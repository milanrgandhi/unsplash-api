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




     // put image at server 
	 function upload_image_at_server($urlval){


		$url = $urlval;
		$imgpath = explode("/", $url); // splitting the path
        $imgname = date("YmdHis");
		$image_data = file_get_contents($url);
		
		
		$folder = 'downloadimgs/';  

       


        if(file_put_contents($folder."/".$imgname,$image_data)){
			echo "Success";
		} else {
			echo "Error";
		}
	    	
	}
	

?>