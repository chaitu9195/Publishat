 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<!-- maps disabled:  <script src="https://maps.google.com/maps/api/js?sensor=true&key=AIzaSyDN4nGrzkooEjF_RbZyZHvvY5tLlAE5nDA" type="text/javascript"></script> -->
<!-- maps disabled:  <script type='text/javascript' src='https://www.publishat.com/digital/en/assets/js/gmaps.js'></script> -->
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
 <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <title>Publishat</title>
 <link rel="shortcut icon" type="image/x-icon" href="../assets/images/favicon.png" />
  <style>
	.header{
      height: 55px;
	  margin-bottom: 8px;
	}
	
	.headerbgcolor{
      background-color: #466e90;
	}
	.logo h1{
	  font-weight: 700;
	  padding: 0px 3px 0px 30px;
	  font-size: 40px;
	  color: #fff;
	  font-family: inherit;
	  margin-top: 6px;
	}
	.nopad{
	  padding: 0px;
	}
	
::-webkit-scrollbar {
  -webkit-appearance: none;
  width: 10px;
  background: #f1f3f5;
  border-left: 1px solid darken(#f1f3f5, 10%);
}

::-webkit-scrollbar-thumb {
  background: darken(#f1f3f5, 20%);
} 
html, body, div, object, iframe, fieldset { 
/* margin: 0; 
padding: 0; 
border: 0; */
} 
.control-label{
	margin-left:0px !important;
}
.glyphicon-download-alt{
	 color: white !important;
	 font-size: x-large !important;
     padding: 16px !important;
}
.glyphicon-print{
	 font-size: x-large;
	 color: white;
     padding: 16px !important;
	 cursor:pointer;
}
</style>
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

 <div class="container-fluid" style="padding: 0px;">
	<div class="row header headerbgcolor">
		<div class="col-md-3 col-xs-6 rightborder">
		   <span class="logo"><h1>Publishat</h1></span>
		</div> 
		<div class="col-md-7"></div>
		<div class="col-md-2 pull-right" style="color:white">
			<span class="glyphicon glyphicon-print modal_data" title="Print" id="<?=$fid;?>"></span>
		    <a href="<?=$path;?>" title="Download" download><span class="glyphicon glyphicon-download-alt"></span></a>
		</div> 
	</div>
<div id="image_content">
<?php if(in_array(strtolower($type), $images ?? [])){ ?>

	<img src="<?=$path;?>" style="object-fit: cover; max-height: 100vh">
<?php } else if(strtolower($type) == 'pdf'){ ?>
    <!-- PDFs render natively in the browser (Google gView can't reach a local URL). -->
    <iframe src="<?=$path;?>" width="100%" height="90%" style="padding: 0px" frameborder="0"></iframe>
<?php } else{ ?>
    <iframe src="//docs.google.com/gview?url=<?=$path;?>&embedded=true" width="101%" height="90%" style="padding: 0px" frameborder="0"></iframe>
<?php } ?>
</div>
</div>
<div class="container" style="padding: 0px;">
	<div id="body_content"></div>
</div>			
<script>
$(document).ready(function(){
	<?php if($isPrint == 'Y'){ ?>
		$(".modal_data").click();
	<?php } ?>
});
$('.modal_data').one('click',function(e){ 
	e.stopPropagation();
    var id = this.id;  
	var path = '<?=$path;?>';
	var filetype = '<?=$type;?>';
	var filename = '<?=$filename . $type;?>';
	var typeId  = '<?=$typeId;?>'; 
	var module = '<?=$module;?>';
    $.ajax({
        url: "<?php echo base_url(); ?>web/previewdata",
        data: {id: id,path: path,filetype: filetype, typeId: typeId, module: module, filename: filename},
        type: "get",
        success: function(data){
			$('#body_content').html(data);
			$('#image_content').hide();
			$('.modal_data').hide();
			//var len = sheetCount(); //alert(len);
			
		}  		
	});
});

</script>