<?php

Yii::import('orders.models.*');
Yii::import('store.models.*');

/**
 * Cart controller
 * Display user cart and create new orders
 */
class CartController extends Controller
{

	/**
	 * @var OrderCreateForm
	 */
	public $form;

	/**
	 * @var bool
	 */
	protected $_errors = false;

	/**
	 * Display list of product added to cart
	 */
	public function actionIndex()
	{
		// Recount
		if(Yii::app()->request->isPostRequest && Yii::app()->request->getPost('recount') && !empty($_POST['quantities']))
			$this->processRecount();

		$this->form = new OrderCreateForm;

		// Make order
		if(Yii::app()->request->isPostRequest && Yii::app()->request->getPost('create'))
		{
			if(isset($_POST['OrderCreateForm']))
			{
				$this->form->attributes = $_POST['OrderCreateForm'];

				if($this->form->validate())
				{
					$order = $this->createOrder();
					foreach(array($order->user_email, 'lts7733@gmail.com') as $recipient)
					{
						$bodyLetter = '<html>
									<body>
									  Здравствуйте, '.$order->user_name.'!<br>

									  <p>
									    Ваш заказ номер '.$order->id.' принят.<br/>
									    <a href="'.Yii::app()->createAbsoluteUrl('/orders/cart/view', array('secret_key'=>$order->secret_key)).'">Посмотреть на сайте</a>
									  </p>

									    <p>
									    <b>Контактные данные:</b><br/>
									      '.implode('<br/>', array($order->user_name, $order->user_phone)).'
									    </p>

									  </p>

									<p>
									С уважением, администрация.<br/>
									Интернет магазин iKiddy &copy; '.date('Y').'
									</p>

									</body>
									</html>';
					  $mailer           = Yii::app()->mail;
					  $mailer->From     = "robot@i-kiddy.com";
					  $mailer->FromName = "Интернет-магазин iKiddy";
					  $mailer->Subject  = "Ваш заказ принят";
					  $mailer->Body = $bodyLetter;
					  $mailer->AddReplyTo("lts7733@gmail.com");
					  $mailer->isHtml(true); // заменить на true чтобы отослать в формате html
					  $mailer->AddAddress($recipient);
					  $mailer->Send();
					  $mailer->ClearAddresses();
					}
					Yii::app()->cart->clear();
					$this->addFlashMessage(Yii::t('OrdersModule.core', 'Спасибо. Ваш заказ принят.'));
					Yii::app()->request->redirect($this->createUrl('view', array('secret_key'=>$order->secret_key)));
				}
			}
		}

		$deliveryMethods = StoreDeliveryMethod::model()
			->applyTranslateCriteria()
			->active()
			->orderByName()
			->findAll();

		$this->render('index', array(
			'items'           => Yii::app()->cart->getDataWithModels(),
			'totalPrice'      => Yii::app()->currency->convert(Yii::app()->cart->getTotalPrice()),
			'deliveryMethods' => $deliveryMethods,
		));
	}

	/**
	 * Find order by secret_key and display.
	 * @throws CHttpException
	 */
	public function actionView()
	{
		$secret_key = Yii::app()->request->getParam('secret_key');
		$model = Order::model()->find('secret_key=:secret_key', array(':secret_key'=>$secret_key));

		if(!$model)
			throw new CHttpException(404, Yii::t('OrdersModule.core', 'Ошибка. Заказ не найден.'));

		$this->render('view', array(
			'model'=>$model,
		));
	}

	/**
	 * Validate POST data and add product to cart
	 */
	public function actionAdd()
	{
		$variants = array();

		// Load product model
		$model = StoreProduct::model()
			->active()
			->findByPk(Yii::app()->request->getPost('product_id', 0));

		// Check product
		if(!isset($model))
			$this->_addError(Yii::t('OrdersModule.core', 'Ошибка. Продукт не найден'), true);

		// Update counter
		$model->saveCounters(array('added_to_cart_count'=>1));

		// Process variants
		if(!empty($_POST['eav']))
		{
			foreach($_POST['eav'] as $attribute_id=>$variant_id)
			{
				if(!empty($variant_id))
				{
					// Check if attribute/option exists
					if(!$this->_checkVariantExists($_POST['product_id'], $attribute_id, $variant_id))
						$this->_addError(Yii::t('OrdersModule.core', 'Ошибка. Вариант продукта не найден.'));
					else
						array_push($variants, $variant_id);
				}
			}
		}

		// Process configurable products
		if($model->use_configurations)
		{
			// Get last configurable item
			$configurable_id = Yii::app()->request->getPost('configurable_id', 0);

			if(!$configurable_id || !in_array($configurable_id , $model->configurations))
				$this->_addError(Yii::t('OrdersModule.core', 'Ошибка. Выберите вариант продукта.'), true);
		}else
			$configurable_id  = 0;

		Yii::app()->cart->add(array(
			'product_id'      => $model->id,
			'variants'        => $variants,
			'configurable_id' => $configurable_id,
			'quantity'        => (int) Yii::app()->request->getPost('quantity', 1),
			'price'           => $model->price,
		));

		$this->_finish();
	}

	/**
	 * Remove product from cart and redirect
	 */
	public function actionRemove($index)
	{
		Yii::app()->cart->remove($index);

		if(!Yii::app()->request->isAjaxRequest)
			Yii::app()->request->redirect($this->createUrl('index'));
	}

	/**
	 * Clear cart
	 */
	public function actionClear()
	{
		Yii::app()->cart->clear();

		if(!Yii::app()->request->isAjaxRequest)
			Yii::app()->request->redirect($this->createUrl('index'));
	}

	/**
	 * Render data to display in theme header.
	 */
	public function actionRenderSmallCart()
	{
		$this->renderPartial('_small_cart');
	}

	/**
	 * Create new order
	 * @return Order
	 */
	public function createOrder()
	{
		if(Yii::app()->cart->countItems() == 0)
			return false;

		$order = new Order;

		// Set main data
		$order->user_id      = Yii::app()->user->isGuest ? null : Yii::app()->user->id;
		$order->user_name    = $this->form->name;
		$order->user_email   = $this->form->email;
		$order->user_phone   = $this->form->phone;
		$order->user_address = $this->form->address;
		$order->user_comment = $this->form->comment;
		$order->delivery_id  = $this->form->delivery_id;

		if($order->validate())
			$order->save();
		else
			throw new CHttpException(503, Yii::t('OrdersModule.core', 'Ошибка создания заказа'));

		// Process products
		foreach(Yii::app()->cart->getDataWithModels() as $item)
		{
			$ordered_product = new OrderProduct;
			$ordered_product->order_id        = $order->id;
			$ordered_product->product_id      = $item['model']->id;
			$ordered_product->configurable_id = $item['configurable_id'];
			$ordered_product->name            = $item['model']->name;
			$ordered_product->quantity        = $item['quantity'];
			$ordered_product->sku             = $item['model']->sku;
			$ordered_product->price           = StoreProduct::calculatePrices($item['model'], $item['variant_models'], $item['configurable_id']);

			// Process configurable product
			if(isset($item['configurable_model']) && $item['configurable_model'] instanceof StoreProduct)
			{
				$configurable_data=array();

				$ordered_product->configurable_name = $item['configurable_model']->name;
				// Use configurable product sku
				$ordered_product->sku = $item['configurable_model']->sku;
				// Save configurable data

				$attributeModels = StoreAttribute::model()->findAllByPk($item['model']->configurable_attributes);
				foreach($attributeModels as $attribute)
				{
					$method = 'eav_'.$attribute->name;
					$configurable_data[$attribute->title]=$item['configurable_model']->$method;
				}
				$ordered_product->configurable_data=serialize($configurable_data);
			}

			// Save selected variants as key/value array
			if(!empty($item['variant_models']))
			{
				$variants = array();
				foreach($item['variant_models'] as $variant)
					$variants[$variant->attribute->title] = $variant->option->value;
				$ordered_product->variants = serialize($variants);
			}

			$ordered_product->save();
		}

		// All products added. Update delivery price
		$order->updateDeliveryPrice();

		return $order;
	}

	/**
	 * Check if product variantion exists
	 * @param $product_id
	 * @param $attribute_id
	 * @param $variant_id
	 * @return string
	 */
	protected function _checkVariantExists($product_id, $attribute_id, $variant_id)
	{
		return StoreProductVariant::model()->countByAttributes(array(
			'id'           => $variant_id,
			'product_id'   => $product_id,
			'attribute_id' => $attribute_id
		));
	}

	/**
	 * Recount product quantity and redirect
	 */
	public function processRecount()
	{
		Yii::app()->cart->recount(Yii::app()->request->getPost('quantities'));

		if(!Yii::app()->request->isAjaxRequest)
			Yii::app()->request->redirect($this->createUrl('index'));
	}

	/**
	 * Add message to errors array.
	 * @param string $message
	 * @param bool $fatal finish request
	 */
	protected function _addError($message, $fatal = false)
	{
		if($this->_errors === false)
			$this->_errors = array();

		array_push($this->_errors, $message);

		if($fatal === true)
			$this->_finish();
	}

	/**
	 * Process result and exit!
	 */
	protected function _finish()
	{
		echo CJSON::encode(array(
			'errors'=>$this->_errors,
			'message'=>Yii::t('OrdersModule.core','Продукт успешно добавлен в {cart}', array(
				'{cart}'=>CHtml::link(Yii::t('OrdersModule', 'корзину'), array('/orders/cart/index'))
			)),
		));
		exit();
	}
}
