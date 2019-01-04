<?php
$apiservice = array(
array(' ', ' ',),
array(' ', ' ',)
);
$random = array_rand($apiservice);
$amazonAWSAccessKeyId	= 'AKIAINMJ2FAEHCJ2ZE2Q';//$apiservice[$random][0];// Amazon Access Key Id
$amazonSecretAccessKey	= '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';//$apiservice[$random][1];// Amazon Secret Access Key
$amazonAssociateTag		= 'sarahstore-21';// Amazon Tag
$amazonRegion			= 'com'; // Country
$amazonDepartment		= 'Books'; //Department
/** function **/
function Get_Amazon_XML($amazonAssociateTag, $amazonAWSAccessKeyId, $amazonSecretAccessKey, $amazonRegion, $amazonDepartment, $amazonQuery){
	$time = time() + 10000;
	$method = 'GET';
	$host = 'webservices.amazon.'.$amazonRegion;
	$uri = '/onca/xml';
	$slug["Service"] = "AWSECommerceService";
	$slug["Operation"] = "ItemSearch";
	$slug["SubscriptionId"] = $amazonAWSAccessKeyId;
	$slug["AssociateTag"] = $amazonAssociateTag;
	$slug["SearchIndex"] = $amazonDepartment;
	$slug["Condition"] = 'All';
	$slug["Availability"]= 'Available';
	$slug["Keywords"] = $amazonQuery;
	$slug["ItemPage"] = 1;
	$slug["TruncateReviewsAt"] = '500';
	$slug["ResponseGroup"] = 'Large';
	$slug["Timestamp"] = gmdate("Y-m-d\TH:i:s\Z",$time);
	$slug["Version"] = "2011-08-01";
	ksort($slug);
	$query_slug = array();
	foreach ($slug as $slugs=>$value){
		$slugs = str_replace("%7E", "~", rawurlencode($slugs));
		$value = str_replace("%7E", "~", rawurlencode($value));
		$query_slug[] = $slugs."=".$value;
	}
	$query_slug = implode("&", $query_slug);
	$signinurl = $method."\n".$host."\n".$uri."\n".$query_slug;
	$signature = base64_encode(hash_hmac("sha256", $signinurl, $amazonSecretAccessKey, True)); // Get Amazon Signature API
	$signature = str_replace("%7E", "~", rawurlencode($signature));
	$request = "http://".$host.$uri."?".$query_slug."&Signature=".$signature;
	$ch = curl_init();
	$header[0] = "Accept: text/xml,application/xml,application/xhtml+xml,";
	$header[0] .= "text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5";
	$header[] = "Cache-Control: max-age=0";
	$header[] = "Connection: keep-alive";
	$header[] = "Keep-Alive: 300";
	$header[] = "Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7";
	$header[] = "Accept-Language: en-us,en;q=0.5";
	$header[] = "Pragma: ";
	curl_setopt($ch, CURLOPT_URL, $request);
	curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (compatible; Konqueror/4.0; Microsoft Windows) KHTML/4.0.80 (like Gecko)");
	curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
	curl_setopt($ch, CURLOPT_REFERER, "http://www.google.com/firefox?client=firefox-a&rls=org.mozilla:fr:official");
	curl_setopt($ch, CURLOPT_ENCODING, "gzip,deflate");
	curl_setopt($ch, CURLOPT_AUTOREFERER, true);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_TIMEOUT, 30);
	//curl_setopt($ch, CURLOPT_FOLLOWLOCATION,true);
	$response = curl_exec($ch);
	curl_close($ch);
	return $response;
}
function amazonEncode($text) {
    $encodedText = "";
    $j = strlen($text);
    for($i=0;$i<$j;$i++) {
		$c = substr($text,$i,1);
		if (!preg_match("/[A-Za-z0-9\-_.~]/",$c)) {
			$encodedText .= sprintf("%%%02X",ord($c));
		}else{$encodedText .= $c;}
	}return $encodedText;
}

function amazonSign($url,$secretAccessKey) {
	$url .= "&Timestamp=".gmdate("Y-m-d\TH:i:s\Z");       
	$urlParts = parse_url($url);    
	parse_str($urlParts["query"],$queryVars);    
	ksort($queryVars);      
	$encodedVars = array();    
	foreach($queryVars as $key => $value) {
		$encodedVars[amazonEncode($key)] = amazonEncode($value); 
	}       
	$encodedQueryVars = array();    
	foreach($encodedVars as $key => $value) {
		$encodedQueryVars[] = $key."=".$value;    
	}    
	$encodedQuery = implode("&",$encodedQueryVars);     
	$stringToSign  = "GET";    
	$stringToSign .= "\n".strtolower($urlParts["host"]);    
	$stringToSign .= "\n".$urlParts["path"];    
	$stringToSign .= "\n".$encodedQuery;
	if (function_exists("hash_hmac")) {
		$hmac = hash_hmac("sha256",$stringToSign,$secretAccessKey,TRUE);
	}elseif(function_exists("mhash")) {
		$hmac = mhash(MHASH_SHA256,$stringToSign,$secretAccessKey);    
	}else{
		die("No hash function available!");    
	}    
	$hmacBase64 = base64_encode($hmac);
	$url .= "&Signature=".amazonEncode($hmacBase64);    
	return $url;  
}

?>