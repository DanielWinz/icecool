<?php
// =============================================================
// Einkaufszettel.php
// =============================================================

//include required DB connection
include('mysql.php');
include('mysql_trainee.php');

//create instances of the DB classes
$db = new DB();
$trainee = new Trainee(); 

//create new note item
if(isset($_POST["insertNoteItem"]))
{
	   
	$item 	= $_POST['item'];
	$amount = $_POST['amount'];
	$unit 	= $_POST['unit'];
	 
	$return = $db->insertNoteItem($item, $amount, $unit);
	
	//add Suggestion to trainee DB
	$trainee->addSuggestion($item, $unit);
	
	//giving ID of created Element back to DOM
	echo $return;
	
}

//get all note items and parse them to $notes[] array
if(isset($_POST["fetchAllNotes"]))
{
	$notes = array();
	$query = $db->getShoppinglist();
	foreach ($query as $fetch ) {
		
	
	$e = array();
    $e['id'] = $fetch['id'];
    $e['name'] = $fetch['name'];
    $e['menge'] = $fetch['amount'];
    $e['einheit'] = $fetch['unit'];
	$e['erledigt'] = $fetch['done'];
	/**
	 * unused property timestamp
	 * $e['timestamp'] = $fetch['timestamp'];
	 */
	
    array_push($notes, $e);
	}
	echo json_encode($notes);
}

if(isset($_POST['deleteItem']))
{
	$deleteId = $_POST['id'];
	$db->deleteNote($deleteId);
}


?>