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
	
	/** adds new Item for suggestions
	 * $stmt-> statement for checking whether name, unit already exist
	 * $stmtAdd-> adds new name to DB if it does not exist
	 * $stmtUpdate-> updates the counter for trainee
	 */
	
	
	function addSuggestion($item, $unit) {
		$ean='';
		$amount='';
		//check if name, unit already exist in DB
		$stmt = self::$_db->prepare("SELECT * FROM einkaufszettel WHERE name=:name AND unit=:unit");	
		$stmt->bindParam(":name", $item);
		$stmt->bindParam(":unit", $unit);
		$stmt->execute();
		
		//if name,unit do not exist => add data to DB
		if($stmt->rowCount() === 0) {
			$counter = 1;
			$stmtAdd = self::$_db->prepare("INSERT INTO einkaufszettel (name, ean, amount, unit,  counter) VALUES(:name, :ean, :amount, :unit, :counter)");
			$stmtAdd->bindParam(":name", $item);
			$stmtAdd->bindParam(":ean", $ean);
			$stmtAdd->bindParam(":amount", $amount);
			$stmtAdd->bindParam(":unit", $unit);
			$stmtAdd->bindParam(":counter", $counter);
			if($stmtAdd->execute()) {
				return true;
			} else {
				return false;
			}
		}
		//if name, unit already exist => update counter to improve suggestions
		if($stmt->rowCount() === 1){
			$counter = $stmt->fetch(PDO::FETCH_OBJ)->counter;
			$counter ++;
			
			$stmtUpdate = self::$_db->prepare("UPDATE einkaufszettel SET counter=:counter WHERE name=:name AND unit=:unit");
				
			$stmtUpdate->bindParam(":counter", $counter);
			$stmtUpdate->bindParam(":name", $item);
			$stmtUpdate->bindParam(":unit", $unit);
			
			
			if($stmtUpdate->execute()) {
				return true;
			} else {
				return false;
			}	
		}
	}

	function getSuggestion() {
		
		$stmt = self::$_db->prepare("SELECT * FROM einkaufszettel ORDER BY counter DESC ");	
		
		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_BOTH);
		
	}

}
?>