<?php
class SeoOpt {

	private static $title;
	private static $desc;
	private static $h1;
	private static $mini;
	private static $alt;

	public static function setTitle($data) {
		self::$title = $data;
		return true;
	}

	public static function setDesc($data) {
		self::$desc = $data;
		return true;
	}

	public static function setH1($data) {
		self::$h1 = $data;
		return true;
	}

	public static function setMini($data) {
		self::$mini = $data;
		return true;
	}

	public static function setAlt($data) {
		self::$alt = $data;
		return true;
	}

	public static function getTitle() {
		return self::$title;
	}

	public static function getDesc() {
		return self::$desc;
	}

	public static function getH1() {
		return self::$h1;
	}

	public static function getMini() {
		return self::$mini;
	}

	public static function getAlt() {
		return self::$alt;
	}

}
?>