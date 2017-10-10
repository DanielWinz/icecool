<?php

	// =============================================================
    // SEND EAN TO FDDB AND RETURN ITEM INFORMATION
    // =============================================================
    
	$ean = $_GET['ean'];
	
	// Start Curl with EAN as Parameter for request
	$curl = curl_init();
	
	curl_setopt_array($curl, array(
	
	 	CURLOPT_RETURNTRANSFER => 1,
	    CURLOPT_URL => 'http://fddb.info/api/v17/search/item_short.xml?lang="de"&q="' . $ean . '"&apikey="YJPB5WNMC4K5GDAVQGFWV8SP"',
	
	));
	
	// $response = curl_exec($curl);
	
	if(!curl_exec($curl)){
	    die('Error: "' . curl_error($curl) . '" - Code: ' . curl_errno($curl));
	}
	
	curl_close($curl);
	// simulate FDDB Item
	$file = file_get_contents('../testobject.xml');
	
	// Convert XML String to Object and send it back.
	$xml = simplexml_load_string($file);
	echo json_encode($xml);
	
?>