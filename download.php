<?php
require_once('data.php');
require_once('functions.php');

     // put image at server 
	if(isset($_POST['post_url'])){

		$url = $_POST['post_url'];

		if(!empty($_POST['imgext'])&& $_POST['imgext'] != ''){
			 
		       $extension = $_POST['imgext'];
		} else {
               $extension = 'jpg';
		}


		$imgpath = explode("/", $url); // splitting the path
        $imgname = date("YmdHis").".".$extension;
		$image_data = file_get_contents($url);
				
		$folder = DOWNLOADFOLDERNAME.'/';  

        if(file_put_contents($folder."/".$imgname,$image_data)){
			echo "Success";
		} else {
			echo "Error";
		}
	    	
	}	

?>