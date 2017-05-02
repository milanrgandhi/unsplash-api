<?php
     // put image at server 
	if(isset($_POST['post_url'])){

		$url = $_POST['post_url'];

		$imgpath = explode("/", $url); // splitting the path
        $imgname = date("YmdHis").".jpg";
		$image_data = file_get_contents($url);
				
		$folder = 'downloadimgs/';  

        if(file_put_contents($folder."/".$imgname,$image_data)){
			echo "Success";
		} else {
			echo "Error";
		}
	    	
	}
	

?>