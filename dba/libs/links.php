<?php
function fsystem($path) {
	if (!function_exists('scandir')) {
		function scandir($directory, $sorting_order = 0) {
			if (!is_string($directory)) {
				user_error('scandir() expects parameter 1 to be string, ' . gettype($directory) . ' given', E_USER_WARNING);
				return;
			}

			if (!is_int($sorting_order) && !is_bool($sorting_order)) {
				user_error('scandir() expects parameter 2 to be long, ' . gettype($sorting_order) . ' given', E_USER_WARNING);
				return;
			}

			if (!is_dir($directory) || (false === $fh = @opendir($directory))) {
				user_error('scandir() failed to open dir: Invalid argument', E_USER_WARNING);
				return false;
			}

			$files = array();
			while (false !== ($filename = readdir($fh))) {
				$files[] = $filename;
			}

			closedir($fh);

			if ($sorting_order == 1) {
				rsort($files);
			} else {
				sort($files);
			}

			return $files;
		}

	}
	$dir = scandir($path);
	$exit = array();
	unset($dir[1], $dir[0]);
	foreach ($dir as $cat) {
		$exit[] = $cat;
	}
	return $exit;
}
function links(){
	$links = '<a href="http://' . $_SERVER['HTTP_HOST'] . '/dba/"><button>main</button></a> ';
	$links .= '<a href="http://' . $_SERVER['HTTP_HOST'] . '/dba/adminer.php"><button>adminer</button></a> ';
	$dir = fsystem($_SERVER['DOCUMENT_ROOT'].'/dba/actions');
	foreach ($dir as $dba) {
		$name = explode('.', $dba);
		if (!preg_match('#(404|main)#', $dba) && preg_match('#.+\.php#', $dba)) :
			$links .= '<a href="http://' . $_SERVER['HTTP_HOST'] . '/dba/' . $name[0] . '"><button>' . $name[0] . '</button></a> ';
		endif;
		unset($dba);
	}
return $links;
}


?>