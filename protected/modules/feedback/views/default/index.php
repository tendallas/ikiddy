<?php

/**
 * @var $this Controller
 */

$this->pageTitle = Yii::t('FeedbackModule.core', 'Обратная связь');
$this->pageDescription = Yii::t('FeedbackModule.core', 'Обратная связь') . ' - интернет магазин детской одежды ikiddy. Купить с доставкой в Киеве или Украине. ☎ Тел.: (063) 561 95 24.';
?>

<h1 class="has_background" style="margin-left: 45px;"><?php echo Yii::t('FeedbackModule.core', 'Контакты') ?></h1>
<div class="total">
<div class="contacts">
	<i>Если у Вас возникли вопросы, обращайтесь к нам по телефонам:</i><br /><br />
	<table id="cont_phones">
		<tr>
			<td align="center"><img src="<?php echo Yii::app()->theme->baseUrl ?>/assets/images/mobile/life.png"></td> 
			<td><b>(063) 561 95 24</b></td>
		</tr>
		<tr>
			<td align="center"><img src="<?php echo Yii::app()->theme->baseUrl ?>/assets/images/mobile/mts.png"></td> 
			<td><b>(066) 15 51 456</b></td>
		</tr>
		<!--<tr>
			<td align="center"><img src="<?php echo Yii::app()->theme->baseUrl ?>/assets/images/mobile/kyivstar.png"></td> 
			<td>(067) 232 14 21</td>
		</tr>-->
	</table>
	<br />
	<p>Почтовый ящик: <a href="mailto:info@i-kiddy.com">info@i-kiddy.com</a></p>
	<p><strong>Время работы:</strong><br />
	Пн &ndash; Пт: &nbsp; &nbsp; &nbsp; &nbsp;<strong>&nbsp; &nbsp;9:00 &mdash; 19:00</strong><br />
	Сб &ndash; Вс: &nbsp; &nbsp; &nbsp; &nbsp;<strong>&nbsp; &nbsp;выходной</strong></p><br />
	<br /><br />
	<p><b>Или задайте ваш вопрос:</b></p>
</div>

<div class="form wide">
<?php $form=$this->beginWidget('CActiveForm'); ?>

		<!-- Display errors  -->
		<?php echo $form->errorSummary($model); ?>

		<div class="row">
			<?php echo CHtml::activeLabel($model,'name', array('required'=>true)); ?>
			<?php echo CHtml::activeTextField($model,'name'); ?>
		</div>

		<div class="row">
			<?php echo CHtml::activeLabel($model,'email', array('required'=>true)); ?>
			<?php echo CHtml::activeTextField($model,'email'); ?>
		</div>

		<div class="row">
			<?php echo CHtml::activeLabel($model,'message', array('required'=>true)); ?>
			<?php echo CHtml::activeTextArea($model,'message', array('rows'=>6)); ?>
		</div>

		<?php if(Yii::app()->settings->get('feedback', 'enable_captcha')): ?>
		<p style="margin-left: 45px; font-weight: bold;font-size: 12px;color: #232323;padding: 5px 0 0 0;display: block;">Напишите указаные буквы:</p>
		<div class="row">
			<label><?php $this->widget('CCaptcha', array('clickableImage'=>true,'showRefreshButton'=>false)) ?></label>
			<?php echo CHtml::activeTextField($model, 'code')?>
		</div>
		<?php endif; ?>

		<div class="row buttons">
			<button type="submit" class="blue_button"><?php echo Yii::t('FeedbackModule.core', 'Отправить') ?></button>
		</div>
	</fieldset>
<?php $this->endWidget(); ?>
</div><br />
<p style="margin-left: 45px;">Будем рады ответить на любые Ваши вопросы!!!</p>
</div>