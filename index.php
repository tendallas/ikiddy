<?php

error_reporting(E_ALL);

//define('YII_DEBUG', true);
$yii=dirname(__FILE__).'/framework/yii.php';
$config=dirname(__FILE__).'/protected/config/main.php';

require $yii;
require 'protected/components/SWebApplication.php';

// Create application
Yii::createApplication('SWebApplication', $config)->run();
