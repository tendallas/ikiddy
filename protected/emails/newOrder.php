<html>
<body>

  Здравствуйте, <?=$order->user_name?>!<br>

  <p>
    Ваш заказ номер <?=$order->id?> принят.<br/>
    <a href="<?=Yii::app()->createAbsoluteUrl('/orders/cart/view', array('secret_key'=>$order->secret_key))?>">Посмотреть на сайте</a>
  </p>

  Вы заказали:
  <p>
    <ul>
    <?php 
      foreach ($order->products as $product){
        echo '<li>'.$product->getRenderFullName().' - '.$product->price." грн.</li>\n";
	  }
    ?>
    </ul>
    
    <br>
    <b>Всего:</b> <?=$order->total_price + $order->delivery_price?> грн.

    <p>
    <b>Контактные данные:</b><br/>
      <?= implode('<br/>', array($order->user_name, $order->user_phone)) ?>
    </p>

  </p>

<p>
С уважением, администрация.<br/>
Интернет магазин iKiddy &copy; <?php echo date('Y');?>
</p>

</body>
</html>