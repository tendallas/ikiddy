<?php
$cartCountItems = Yii::app()->cart->countItems();
$names = array(
	0 => 'товаров',
	1 => 'товар',
	2 => 'товара',
	3 => 'товара',
	4 => 'товара',
);
?>
<p>В корзине
	<?php if ($cartCountItems != 0): ?>
		<a href="<?php echo Yii::app()->createUrl('/orders/cart/index') ?>">
			<?php echo $cartCountItems ?> <?php echo ($cartCountItems < 5 ? $names[$cartCountItems] : 'товаров') ?>
		</a>
	<?php else: ?>
		<?php echo $cartCountItems ?> <?php echo ($cartCountItems < 5 ? $names[$cartCountItems] : 'товаров') ?>
	<?php endif; ?>
	<span> на сумму <?php echo StoreProduct::formatPrice(Yii::app()->currency->convert(Yii::app()->cart->getTotalPrice())) ?>
		<?php echo Yii::app()->currency->active->symbol ?>
	</span>
</p>