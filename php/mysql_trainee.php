<?php
class Trainee {
	private static $_db_username 		= "root";
	private static $_db_password 		= "";
	private static $_db_host 			= "localhost";
	private static $_db_name			= "icecool_trainee";
	private static $_db;	 
	
	function __construct() {
		try {
		self::$_db = new PDO("mysql:host=" . self::$_db_host . ";dbname=" . self::$_db_name,  self::$_db_username , self::$_db_password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
		} catch(PDOException $e) {
			echo "Datenbankverbindung gescheitert!";
			die();
		}
	}

}
?>