<?php
// Get cURL resource
$curl = curl_init();
// Set some options - we are passing in a useragent too here
curl_setopt_array($curl, array(
 	CURLOPT_RETURNTRANSFER => 1,
 	CURLOPT_HEADER => 1,
    CURLOPT_URL => 'http://fddb.info/api/v17/search/item_short.xml?lang="de"&q="4001325002713"&apikey="YJPB5WNMC4K5GDAVQGFWV8SP"',
));
// Send the request & save response to $resp
$resp = curl_exec($curl);

$header_size = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
$header = substr($resp, 0, $header_size);
$body = substr($resp, $header_size);

if(!curl_exec($curl)){
    die('Error: "' . curl_error($curl) . '" - Code: ' . curl_error($curl));
}

curl_close($curl);


// showing tree structure of XML representation received by FDDB
//$file = file_get_contents('http://fddb.info/api/v17/search/item_short.xml?lang="de"&q="8715700415468"&apikey="YJPB5WNMC4K5GDAVQGFWV8SP"');
//print_r($file);

// accessing single elements within tree
//header('Content-Type: text/xml; charset=ISO-8859-1');
//$convert = new SimpleXMLElement($body);
$convert = simplexml_load_string($body,'SimpleXMLElement', LIBXML_NOCDATA);
print_r($convert);
//echo $convert->stats->numitemsfound;
//$access = json_encode($convert);
//echo $access->items;

?>