<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<!-- maps disabled: <script src="https://maps.google.com/maps/api/js?sensor=true&key=AIzaSyDN4nGrzkooEjF_RbZyZHvvY5tLlAE5nDA" type="text/javascript"></script> -->
<!-- maps disabled: <script type='text/javascript' src='https://www.publishat.com/digital/en/assets/js/gmaps.js'></script> -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Publishat</title>
<link rel="shortcut icon" type="image/x-icon" href="../assets/images/favicon.png" />

<script>
/* root.find('iframe').ready(function(){
 root.find('iframe')
     .contents()
     .find('img')
     .css({'width':'100%', 'height':'100%'});
}); */

$(document).ready(function() {
 /*$('#iframetoprint').on("load", function() {
   $("#iframetoprint").contents().find("body").attr("style","text-align:center;padding-top:5%")
   $("#iframetoprint").contents().find("img").attr("style","width:50%;height:70%")

   $("#iframe-id").contents().find("img").addClass("fancy-zoom")

   $("#iframe-id").contents().find("img").onclick(function(){ zoomit($(this)); });
 });*/
});
</script>
<?php
$images = ['jpg','png','jpeg','bmp','gif'];
$path = base_url() . "web/viewfile?fid=$fid";
?>

<div id="image_content">
<?php

if(in_array(strtolower($type), $images ?? [])){
?>

   <img src="<?=$path;?>" style="object-fit: cover; max-height: 100vh">
<?php } else if(strtolower($type) == 'pdf'){ ?>
   <!-- PDFs render natively (Google gView can't reach a local URL). -->
   <iframe src="<?=$path;?>" width="100%" height="90%" style="padding: 0px" frameborder="0"></iframe>
<?php } else{ ?>
   <iframe src="//docs.google.com/gview?url=<?=$path;?>&embedded=true" width="101%" height="90%" style="padding: 0px" frameborder="0"></iframe>
<?php } ?>
</div>
