<?php

/**
 * @var UserProfile $profile
 * @var User $user
 * @var Controller $this
 */

$this->pageTitle = Yii::t('UsersModule.core','Регистрация');
?>

<h1 class="has_background"><?php echo Yii::t('UsersModule.core','Регистрация'); ?></h1>

<div class="login_box rc5">
	<div class="form wide">
		<?php $form=$this->beginWidget('CActiveForm', array(
			'id'=>'user-register-form',
			'enableAjaxValidation'=>false,
		)); ?>

		<?php echo $form->errorSummary(array($user, $profile)); ?>

		<div class="row">
			<?php echo $form->labelEx($user,'username'); ?>
			<?php echo $form->textField($user,'username'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($user,'password'); ?>
			<?php echo $form->passwordField($user,'password'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($user,'email'); ?>
			<?php echo $form->textField($user,'email'); ?>
		</div>

		<div class="row buttons">
			<?php echo CHtml::submitButton(Yii::t('UsersModule.core', 'Отправить')); ?>
		</div>

		<div class="row buttons">
			<?php echo CHtml::link(Yii::t('UsersModule.core', 'Авторизация'), array('login/login')) ?><br>
			<?php echo CHtml::link(Yii::t('UsersModule.core', 'Напомнить пароль'), array('/users/remind')) ?>
		</div>

		<?php $this->endWidget(); ?>
	</div><!-- form -->
</div>
