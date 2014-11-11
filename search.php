<?php
class Autocomplete {
	
	protected $host = 'localhost';
	protected $login = 'ten';
	protected $pass = '214rocky';
	protected $db = 'ikiddy';
	
	public function dbConnect () {
		$conn = mysql_connect($this->host, $this->login, $this->pass);
		mysql_select_db($this->db, $conn);
		mysql_query("SET NAMES utf8");
		
		return $conn;
	}
	
	public function dbClose () {
		return mysql_close($this->dbConnect());
	}
	
	public function getNameArray ($search) {
		$names = array();
		$query = "SELECT * FROM `StoreProductTranslate` WHERE `name` LIKE '%" . strip_tags($search) . "%' AND language_id = 1 LIMIT 8";
		$data = mysql_query($query);
		while($obj = mysql_fetch_object($data)) {
			$names[] = $obj->name;
		}
		
		return $names;
	} 
	
}

$ins = $_GET['query'];

$complete = new Autocomplete();
$complete->dbConnect();
$data = $complete->getNameArray($ins);
$complete->dbClose();
echo json_encode($data);

