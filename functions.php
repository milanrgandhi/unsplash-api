<?php
function get($url, $params=array()){
	
	
	$ext = 'curl';
	
	if(!extension_loaded($ext)) {
		
		return 'The library requires the ' . $ext . ' extension.';
		
	}
	else {
		
		
		$url = $url.'?'.http_build_query($params, '', '&');
		
		$ch = curl_init();
		
		curl_setopt($ch, CURLOPT_URL, $url);
		
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
		
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		
		$response = curl_exec($ch);
		
		curl_close($ch);
		
		return $response;
		
	}
	
	
}

?>