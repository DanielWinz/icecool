<?php
include('mysql.php');
$db = new DB();

//create new note item
if(isset($_POST["insertNoteItem"]))
{
	   
	$item 	= $_POST['item'];
	$amount = $_POST['amount'];
	$unit 	= $_POST['unit'];
	 
	$return = $db->insertNoteItem($item, $amount, $unit);
	echo $return;
	
}

//get all note items and parse them to $notes array
if(isset($_POST["fetchAllNotes"]))
{
	$notes = array();
	$query = $db->getShoppinglist();
	foreach ($query as $fetch ) {
		
	
	$e = array();
    $e['id'] = $fetch['id'];
    $e['name'] = $fetch['name'];
    $e['menge'] = $fetch['menge'];
    $e['einheit'] = $fetch['einheit'];
	$e['erledigt'] = $fetch['erledigt'];
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