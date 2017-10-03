<?php
include('mysql.php');
$db = new DB();
$item 	= $_POST['item'];
	$amount = $_POST['amount'];
	$unit 	= $_POST['unit'];
	echo $item;
	echo $amount;
	echo $unit;
if(isset($_POST["insertNoteItem"]))
{
	   
	$item 	= $_POST['item'];
	$amount = $_POST['amount'];
	$unit 	= $_POST['unit'];
	echo $item;
	echo $amount;
	echo $unit; 
	$db->insertNoteItem($item, $amount, $unit);
	
}


?>