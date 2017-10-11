<?php

// Get cURL resource
$curl = curl_init();
// Set some options - we are passing in a useragent too here
curl_setopt_array($curl, array(
 	CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => 'http://fddb.info/api/v17/search/item_short.xml?lang="de"&q="8715700415468"&apikey="YJPB5WNMC4K5GDAVQGFWV8SP"',
));
// Send the request & save response to $resp
$resp = curl_exec($curl);
// Close request to clear up some resources

if(!curl_exec($curl)){
    die('Error: "' . curl_error($curl) . '" - Code: ' . curl_errno($curl));
}

curl_close($curl);

// showing tree structure of XML representation received by FDDB
//header('Content-Type: text/xml; charset=ISO-8859-1');
//$file = file_get_contents('http://fddb.info/api/v17/search/item_short.xml?lang="de"&q="8715700415468"&apikey="YJPB5WNMC4K5GDAVQGFWV8SP"');
//print_r($file);

// accessing single elements within tree
//$convert = simplexml_load_string($resp);
$convert = new SimpleXMLElement($resp);
print_r($convert);
//echo $convert->items->shortitem->data->kcal;
//$access = json_encode($convert);
//echo $access->items;

?>