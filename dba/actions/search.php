<html>
	<head>
		<title>Grep PHP</title>
		<link href="media/modern.css" rel="stylesheet">
	</head>
	<body>
		<?php
		error_reporting(0);
		require_once 'libs/links.php';
		echo links();
		if (isset($_POST['sub'])) {
			$find = $_POST['znach'];
			$folder = $_POST['folder'];
			function get_files($dir = ".") {
				$files = array();
				if ($handle = opendir($dir)) {
					while (false !== ($item = readdir($handle))) {
						if (is_file($dir.'/'.$item)) {
							$files[] = $dir.'/'.$item;
						} elseif (is_dir($dir.'/'.$item) && ($item != ".") && ($item != "..")) {
							$files = array_merge($files, get_files($dir.'/'.$item));
						}
					}
					closedir($handle);
				}
				return $files;
			}

			if (isset($folder) && !empty($folder)) {
				$files = get_files($_SERVER['DOCUMENT_ROOT'] . '/' . $folder);
			} else {
				$files = get_files('../..');
			}
			
			$find = addslashes($find);
			
			foreach ($files as $key => $rec) {
				$cont = file_get_contents($rec);
				if (false !== substr_count($cont, $find)) {
					$resu[] = $rec;
				}
				unset($rec, $cont, $files[$key]);
			}
		}
		?>
		<center>
			<div style="margin-top: 100px; border: 1px solid; width: 500px; padding-top: 9px;">
				<form method="post" action="" class="input-control text">
					<input type="text" id="text" name="folder" size="15">
					<input type="text" id="text" name="znach" size="35">
					<input name="sub" id="go" type="submit" value="Search">
				</form>
				<span class="load"></span>
				<div style="text-align: left; width: 480px; height: 500px; display: block; overflow: scroll;" id="result">
					<pre><?php print_r($resu); ?></pre>
				</div>			
			</div>
		</center>
	</body>
</html>