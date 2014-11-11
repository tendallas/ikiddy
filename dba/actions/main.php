<html>
    <head>
        <title>Seo zone</title>
        <link href="media/modern.css" rel="stylesheet">
    </head>
    <body>
<div style="margin: 5px;">
<form action="" method="post" enctype="multipart/form-data" class="input-control text">
<input type="text" name="filename" placeholder="введите название бэкапа">
<input type="submit" name="backup" value="Cделать!">
</form></div>
<?php
function createFile($fileName){
    $path = $_SERVER['DOCUMENT_ROOT'].'/dba/'.$fileName.date("d.m.y").'.tar.gz';
    if(isset($_POST['backup'])){
    	ob_start();
        system('tar -czvf '.$path.' '.$_SERVER['DOCUMENT_ROOT'].'/');
		$res=ob_get_contents();
		ob_end_clean();
        echo (!empty($res) ? 'файл создан' : 'ошибка');
    }
}
if(isset($_POST['backup'])){
	createFile($_POST['filename']);
}
?>
<center style="margin-top: 20%;">
<?php require 'libs/links.php'; 
echo links();
?>
        </body>
        </html>