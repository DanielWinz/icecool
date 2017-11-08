<?php
    include('../mysql_trainee.php');
	$trainee = new Trainee();
	$searchStr = $_GET['queryStr'];
	$query = $trainee->getSuggestion();
	
	//create json array and 
	$suggestions = array();
	
	foreach ($query as $fetch ) {
		$e = array();
	    $e['name'] = $fetch['name'];
	    $e['unit'] = $fetch['unit'];
	    array_push($suggestions, $e);
	}
	echo json_encode($suggestions);
	
?>