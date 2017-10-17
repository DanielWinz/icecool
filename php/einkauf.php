<?php
	
// =============================================================
// a) SEND EAN TO FDDB AND RETURN ITEM INFORMATION
// =============================================================
    
if(isset($_GET["ean"])){
    	
	$ean = $_GET['ean'];
	
	// Start Curl with EAN as Parameter for request
	$curl = curl_init();
	
	curl_setopt_array($curl, array(
	
	 	CURLOPT_RETURNTRANSFER => 1,
	    CURLOPT_URL => 'http://fddb.info/api/v17/search/item_short.xml?lang="de"&q="' . $ean . '"&apikey="YJPB5WNMC4K5GDAVQGFWV8SP"',
	
	));
	
	$response = curl_exec($curl);
	
	if(!curl_exec($curl)){
	    die('Error: "' . curl_error($curl) . '" - Code: ' . curl_errno($curl));
	}
	
	curl_close($curl);

	// Convert XML String to Object
	$xml = simplexml_load_string($response,'SimpleXMLElement', LIBXML_NOCDATA);

// =============================================================
// b) PUSH ITEM TO MYSQL_TRAINEE AND FOOL **** :D
// =============================================================	
	if($xml->items->stats->numitemsfound != 0){
			
		include('mysql_trainee.php');
	
		// extract data for mysql_trainee from XML Object
		$name = $xml->items->shortitem->data->description->name;
		$amount = $xml->items->shortitem->data->amount;
		$unit = $xml->items->shortitem->data->amount_measuring_system;
	
		//push items to addTrainingItem
		$trainee = new Trainee();
		$trainee->addTrainingItem($ean, $name, $amount, $unit);
	}

	// send XML Object back
	echo json_encode($xml);
	
	}
    	
?> 