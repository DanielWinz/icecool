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
	
	function addTrainingItem($ean, $name, $amount, $unit) {
		//add TrainingItem to DB if it does not exist already
		
		if($this->isExisting($ean)){
			
			$stmt = self::$_db->prepare("INSERT INTO einkaufszettel (name, ean, amount, unit) VALUES (:name, :ean, :amount, :unit)");	
			$stmt->bindParam(":ean", $ean);
			$stmt->bindParam(":name", $name);
			$stmt->bindParam(":amount", $amount);
			$stmt->bindParam(":unit", $unit);
			$stmt->execute();
		}
	
	}
	
	/** NEW ITEM FOR SUGGESTION
	 * 1) check if name and unit already exist
	 * 2) if not: add to DB
	 * 3) if yes: update counter for trainee
	 */
	function addSuggestion($item, $unit) {
		//check if name, unit already exist in DB
		$stmt = self::$_db->prepare("SELECT * FROM einkaufszettel WHERE name=:name AND einheit=:einheit");	
		$stmt->bindParam(":name", $item);
		$stmt->bindParam(":einheit", $unit);
		$stmt->execute();
		
		//if name,unit do not exist => add data to DB
		if($stmt->rowCount() === 0) {
			$counter = 1;
			$stmtAdd = self::$_db->prepare("INSERT INTO einkaufszettel (name, einheit, counter) VALUES(:name, :einheit, :counter)");
			$stmtAdd->bindParam(":name", $item);
			$stmtAdd->bindParam(":einheit", $unit);
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
			
			$stmtUpdate = self::$_db->prepare("UPDATE einkaufszettel SET counter=:counter WHERE name=:name AND einheit=:einheit");
				
			$stmtUpdate->bindParam(":counter", $counter);
			$stmtUpdate->bindParam(":name", $item);
			$stmtUpdate->bindParam(":einheit", $unit);
			
			
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
	
	function isExisting($ean){

		$stmt = self::$_db->prepare("SELECT ean FROM einkaufszettel WHERE ean=:ean");
		$stmt->bindParam(":ean", $ean);
		$stmt->execute();

		$row = $stmt->fetchColumn();
		
		if($row !== false)
			return false;
		
		else 
			return true;
	}

}
?>