<?php
	// Get cURL resource
	$curl = curl_init();
	// Set some options - we are passing in a useragent too here
	curl_setopt_array($curl, array(
		CURLOPT_HTTPHEADER => array(
			"Accept: application/json",
			"Authorization: Token token=8fff8a07340ee563d32af9e4b597e9cb"
			),
		CURLOPT_ENCODING => "",
		CURLOPT_RETURNTRANSFER => 1,
	    CURLOPT_URL => 'https://www.openfood.ch/api/v3/products?barcodes=20846473',
	));
	// Send the request & save response to $resp
	$resp = curl_exec($curl);
	
	if(!curl_exec($curl)){
	    die('Error: "' . curl_error($curl) . '" - Code: ' . curl_error($curl));
	}
	curl_close($curl);
	
	print_r ($resp);
?>