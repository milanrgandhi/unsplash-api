<?php

require_once('data.php');

require_once('functions.php');



if(isset($_GET['txtSearch']))
{
	
	$searchtxt=trim($_GET['txtSearch']);
	
}
else {
	
	$searchtxt = "food";
	
}


$start=0;

$limit=PAGE_COUNT;


if(isset($_GET['page']))
{
	
	
	$page=$_GET['page'];
	
	
	$start=($page-1)*$limit;
	
	
}
else {
	
	
	$page= 1;
	
}



?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
<title>Unsplash API Photo Gallery Demo</title>
   
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">
     <link href="custome-style.css" rel="stylesheet">
	<link rel="stylesheet prefetch" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css">
    <link href="jquery.bsPhotoGallery.css" rel="stylesheet">
    <script src="//code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="jquery.bsPhotoGallery.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap3-dialog/1.34.9/css/bootstrap-dialog.min.css" rel="stylesheet" type="text/css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap3-dialog/1.34.9/js/bootstrap-dialog.min.js"></script>

    <script>
$(document).ready(function(){

   /* $(document).ready(function(){
        $('ul.first').bsPhotoGallery({
          "classes" : "col-lg-2 col-md-4 col-sm-3 col-xs-4 col-xxs-12",
          "hasModal" : true,
          // "fullHeight" : false
        });
      }); */


   $('li img').on('click',function(){
        var src = $(this).attr('data-img');
        var img = '<img src="' + src + '" class="img-responsive"/>';
        $('#myModal').modal();
        $('#myModal').on('shown.bs.modal', function(){
            $('#myModal .modal-body').html(img);
        });
        $('#myModal').on('hidden.bs.modal', function(){
            $('#myModal .modal-body').html('');
        });
   });

})


function putImage_onServer(newURL, imgextension){
		
	     
        var base_url = '<?php $protocol.SERVER_HOSTNAME."/".LOCALDIR."/" ?>download.php';

		 $.ajax({
				'url' : base_url,
				'type' : 'POST', //the way you want to send data to your URL
				'data' : 'post_url='+newURL+'&imgext='+imgextension+'',
                 beforeSend: function(){
                       $(".overlay").show();
                       $(".overlay").html('<p style="position:absolute; top:50%; left:20%; font-size:42px;">Please wait adding image to your library.....&nbsp;<i class="fa fa-circle-o-notch fa-spin"></i></p>');
                   },
				'success' : function(data){ 

				    if(data == 'Error'){
					    
                        $(".overlay").hide();
						 BootstrapDialog.show({
							cssClass: 'modal-danger',
                            type: BootstrapDialog.TYPE_DANGER,
							title: 'Error!',
							message: errorObj.message,
							buttons: [{
								label: 'Close',
								cssClass: 'btn-outline',
								action: function(dialogRef){
									dialogRef.close();
								}
							}]
						});   
                         

					} else {
						
                         
                          $(".overlay").hide();
						  BootstrapDialog.show({
                                cssClass: 'modal-success',
                                type: BootstrapDialog.TYPE_SUCCESS,
                                title: 'Download Complete!',
                                message: 'Image has been downloaded successfully. add_image.php?filename=NAME_OF_FILE',
                                buttons: [{
                                    label: 'Close',
                                    cssClass: 'btn-outline',
                                    action: function(dialogRef){
                                        dialogRef.close();
                                    }
                                }]
                            });



					}
					
				}
		  });
			
	 }
    </script>
   
      </head>

 <body>

 <div class="overlay" style="">
    <div id="loading-img"></div>
</div>
 <div class='container'>
  <div class="row" style="text-align:center; border-bottom:1px dashed #ccc;  padding:0 0 20px 0; margin-bottom:40px;">
            <h3 style="font-family:'Bree Serif', arial; font-weight:bold; font-size:30px;">
                <a class="logo" href="#"><i class="fa fa-camera"></i>&nbsp;&nbsp;Unsplash <strong>Photos</strong></a>
            </h3>
            
   </div>

<form action="api-unsplash.php" method="GET" name="frmsearch"> 
   <div class="row" style="text-align:center; border-bottom:1px dashed #ccc;  padding:0 0 20px 0; margin-bottom:40px;">
    <div class="col-xs-6 col-md-4">
      <div class="input-group">
   <input type="text" class="form-control" placeholder="Search Photos" id="txtSearch" name="txtSearch" value="<?php echo $searchtxt;
?>"/>
   <div class="input-group-btn">
        <button class="btn btn-primary" type="submit">
        <span class="glyphicon glyphicon-search"></span>
        </button>
   </div>
   </div>
    </div>
  </div>
  </form>

<?php


$a =  get('https://api.unsplash.com/search/photos/', array('client_id'=>API_KEY, '_accept'=>'application/json', 'query'=>$searchtxt,'page'=>$page, 'per_page'=>$limit));


$b = json_decode($a);

/*echo "<pre>";
print_r($b);

echo "</pre>";*/


if($b->total > 0 ){
	
	
	$mainalbumarray = array();
	
	
	?>

<div class='row' style='margin-bottom:30px; padding:0 0 0 20px'>
<h3 style='font-family:Bree Serif, arial; font-weight:bold; font-size:22px;'><?php echo ucfirst($searchtxt)?> &nbsp;&nbsp;&nbsp;&nbsp;<i class='fa fa-camera'></i><strong>&nbsp;<?php echo $b->total ?> Photos</strong></h3>
</div>

<ul class='row first'>

<?php

foreach($b->results as $key=>$Albumimg) {
	
	
	$smallimg = $b->results[$key]->urls->small;

    $thumbimg = $b->results[$key]->urls->thumb;

    $regularimg = $b->results[$key]->urls->regular;
	
	
	$username = $b->results[$key]->user->name;
	
	
	$linkimg = $b->results[$key]->links->html;
	
	
	$download = $b->results[$key]->links->download;

    $query_str = parse_url($smallimg, PHP_URL_QUERY);
    $strtext = parse_str($query_str, $query_params);
    /*echo "<pre>";
    print_r($query_params);
     echo "</pre>";*/

     $imgextension = $query_params['fm'];
	
	
	
	?>    
	
	
	
<li class='col-md-4 col-lg-4 col-xs-12 col-sm-6'>
	
<div class='imgWrapper'>
	
	<!--<a class='link' target='_blank' href=<?php echo $linkimg; ?>>-->
    <img src=<?php echo $smallimg; ?> class="img-responsive" data-img="<?php echo $regularimg; ?>">
    
    <!--</a>-->
	
	</div>
	
	<div class='text'>
   <!-- <a class="pull-right" href=<?php echo $download; ?>?force=true> <i class="fa fa-download" aria-hidden="true"></i></a>-->
   


     <a class="pull-right" href="javascript:;" onclick="putImage_onServer('<?php echo $smallimg ?>' , '<?php echo $imgextension ?>');"> <i class="fa fa-download" aria-hidden="true"></a></i>
    </div>
	
	
	
	</li>
	
	
<?php
}
?>
 

</ul>

<div class="modal fade custom-height-modal " id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
             <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button></div>
      <div class="modal-body ">
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->



<ul class='pagination'>
    
<?php 

if($page>1)
{

?>    
	
	
	<li><a href="<?php $protocol.SERVER_HOSTNAME."/".LOCALDIR."/" ?>api-unsplash.php?page="<?php echo ($page-1); ?>"&txtSearch="<?php echo $searchtxt; ?>"">PREVIOUS</a></li>
	

<?php 	
}


for ($i=1;$i<=$b->total_pages;$i++)
{
	
	
	if($i==$page) {
		
		
		
		$activeclass = "class='active'";
		
		
	}
	
	else {
		
		
		$activeclass = "";
		
		
		
	}
	
	
?> 	
	
	<li <?php echo $activeclass; ?>>
    <a href="<?php $protocol.SERVER_HOSTNAME.'/'.LOCALDIR.'/' ?>api-unsplash.php?page=<?php echo $i; ?>&txtSearch=<?php echo $searchtxt; ?>"> <?php echo $i; ?>
    </a>
    </li>
	
<?php 	
	
}


if($page!=$b->total_pages){

?>
	
	
<li><a href="<?php $protocol.SERVER_HOSTNAME.'/'.LOCALDIR.'/' ?>api-unsplash.php?page=<?php echo ($page+1)?>&txtSearch=<?php echo $searchtxt; ?>">NEXT</a></li>

	
<?php 	
}


?>


</ul>

<?php 

}
else {


?> 

    <div style='text-align:center; font-family:Bree Serif, arial; font-weight:bold; font-size:23px; color:#337ab7;'> No photo found. </div>

<?php
}



?>

</div><!-- /container -->
</body>


</html>

