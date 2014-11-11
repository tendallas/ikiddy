<?php

class SiteController extends Controller
{

	public function actionIndex()
	{
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', array('error'=>$error));
		}
	}
	
	public function actionQuick() 
	{ 
       $model=new CallBack;
           $model->attributes=$_POST['CallBack'];
           if($model->validate()) {
               $headers="From: ".Yii::app()->params['adminEmail']."\r\nReply-To: ".Yii::app()->params['adminEmail'];
               $body = "\n\nОтправитель: ".$model->name."\t Телефон: ".$model->phone;
               mail(Yii::app()->params['adminEmail'],'Письмо с сайта i-kiddy от'.$model->name, $body, $headers);
           }
       $this->redirect('/');
	}
}
