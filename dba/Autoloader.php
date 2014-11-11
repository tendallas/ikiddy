<?php
class SedaAutoloader {
	
	public static function start () {
		$classes = self::findFiles(dirname(__FILE__).'/classes/');
		foreach($classes as $file) {
			require_once($file);
		}
		
		return null;
	}
	
	public static function findFiles($dir) { 
	    if (is_dir($dir)) {
		   if ($dh = opendir($dir)) {
		       while (($file = readdir($dh)) !== false) {
		           if (filetype($dir . $file) == 'file') {
		           		$files[] = $dir . $file;
		           }
		       }
		       closedir($dh);
		   }
		}
		
	    return $files;
	}
	
}
