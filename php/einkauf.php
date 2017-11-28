<?php
	
// =============================================================
// a) SEND EAN TO FDDB AND RETURN ITEM INFORMATION
// =============================================================
    
if(isset($_GET["ean"])){
    	
	$ean = $_GET['ean'];
	
	// Start Curl with EAN as Parameter for request
	$curl = curl_init();
	
	/*curl_setopt_array($curl, array(
	 	CURLOPT_RETURNTRANSFER => 1,
	    CURLOPT_URL => 'http://fddb.info/api/v17/search/item_short.xml?lang="de"&q="' . $ean . '"&apikey="YJPB5WNMC4K5GDAVQGFWV8SP"',	
	)); */
	
	curl_setopt_array($curl, array(
		CURLOPT_HTTPHEADER => array(
			"Accept: application/json",
			"Authorization: Token token=8fff8a07340ee563d32af9e4b597e9cb"
			),
		CURLOPT_ENCODING => "",
		CURLOPT_RETURNTRANSFER => 1,
	    CURLOPT_URL => 'https://www.openfood.ch/api/v3/products?barcodes=' . $ean,
	));

	$response = curl_exec($curl);

	if(!curl_exec($curl)){
	    die('Error: "' . curl_error($curl) . '" - Code: ' . curl_errno($curl));
	}
	
	curl_close($curl);
	
	// Convert XML String to Object
	//$xml = simplexml_load_string(utf8_encode($response),'SimpleXMLElement',LIBXML_NOCDATA);

// =============================================================
// b) PUSH ITEM TO MYSQL_TRAINEE AND FOOL **** :D
// =============================================================	
	//if($xml->stats->numitemsfound != 0){
	//	error_log($ean);
	//	include('mysql_trainee.php');
		// extract data for mysql_trainee from XML Object
	//	$name = (string) $xml->items->shortitem->data->description->name;
	//	error_log("in PHP" . $name,0);
	//	$amount = $xml->items->shortitem->data->amount;
	//	$unit = $xml->items->shortitem->data->amount_measuring_system;
	//	error_log($name, 0);
		
		//push items to addTrainingItem
	//	$trainee = new Trainee();
	//	$trainee->addTrainingItem($ean, $name, $amount, $unit);
	
// =============================================================
// c) PUSH ITEM FROM OPENFOOD TO MYSQL_TRAINEE
// =============================================================	
	$resp = json_decode($response);
	
		if(count($resp->data) > 0){
			
		include('mysql_trainee.php');
		// extract data for mysql_trainee from XML Object
		$name = $resp->data[0]->name_translations->de;
		$amount = $resp->data[0]->portion_quantity;
		$unit = $resp->data[0]->portion_unit;
		
		//push items to addTrainingItem
		$trainee = new Trainee();
		$trainee->addTrainingItem($ean, $name, $amount, $unit);
	}

	// send XML Object back
	echo $response;
	
	}
    	
?> 