<?php
class DB {
	private static $_db_username 		= "root";
	private static $_db_password 		= "";
	private static $_db_host 			= "localhost";
	private static $_db_name			= "icecool_main";
	private static $_db;	 
	
	function __construct() {
		try {
		self::$_db = new PDO("mysql:host=" . self::$_db_host . ";dbname=" . self::$_db_name,  self::$_db_username , self::$_db_password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
		} catch(PDOException $e) {
			echo "Datenbankverbindung gescheitert!";
			die();
		}
	}
	// adds new Item of shopping cart to DB
	function insertNoteItem($item, $amount, $unit) {
		$stmt = self::$_db->prepare("INSERT INTO einkaufszettel (name, menge, einheit) VALUES(:name, :menge, :einheit)");
		$stmt->bindParam(":name", $item);
		$stmt->bindParam(":menge", $amount);
		$stmt->bindParam(":einheit", $unit);
		///$stmt->bindParam(":erledigt", 1);
		
		
		
		if($stmt->execute()) {
			return true;
		} else {
			return false;
		}
	}
	

}
?>