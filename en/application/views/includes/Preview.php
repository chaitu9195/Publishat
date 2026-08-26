<?php
$images =array("jpg","png","jpeg","bmp","gif");
$filetype = strtolower($filetype);
function count_pages($pdfname) {
  $pdftext = file_get_contents($pdfname);
  $num = preg_match_all("/\/Page\W/", $pdftext, $dummy);
  return $num;
}
if(strtolower($filetype) == "pdf"){
	$num_pages = count_pages($path);
}
else if($filetype == "docx"){
	$content = file_get_contents($path);
	$file = file_put_contents("../../../print.".$filetype, $content);
	$num_pages = PageCount_DOCX("../../../print.".$filetype);
	unlink("../../../print.".$filetype);
}
else if($filetype == "doc"){
	$content = file_get_contents($path);
	$file = file_put_contents("/var/www/html/print.".$filetype, $content);
	$this->load->helper("converttopdf");
	$convertedPath = converttopdf(base_url()."print.".$filetype);
	$num_pages = count_pages($convertedPath);
	unlink($convertedPath);
	unlink($file);
}
else if($filetype == "pptx"){
	$content = file_get_contents($path);
	$file = file_put_contents("../../../print.".$filetype, $content);
	$num_pages = PageCount_PPTX("../../../print.".$filetype);
	unlink("../../../print.".$filetype);
}
else{
	
}

function PageCount_PPTX($file) {
    $pageCount = 0;
	$zip = new ZipArchive();
	if($zip->open($file) === true) {
        if(($index = $zip->locateName('docProps/app.xml')) !== false)  {
            $data = $zip->getFromIndex($index);
            $zip->close();
            $xml = new SimpleXMLElement($data);
            $pageCount = $xml->Slides;
        }
        $zip->close();
    }

    return $pageCount;
}

function PageCount_DOCX($file) {
    $pageCount = 0;
	$zip = new ZipArchive();
	if($zip->open($file) === true) {
        if(($index = $zip->locateName('docProps/app.xml')) !== false)  {
            $data = $zip->getFromIndex($index);
            $zip->close();
            $xml = new SimpleXMLElement($data);
            $pageCount = $xml->Pages;
        }
        $zip->close();
    }

    return $pageCount;
}

?>
<html>
<head>
<link media="all" type="text/css" href="https://www.publishat.com/maps1/assets/dashicons.css" rel="stylesheet">
<link rel='stylesheet' id='style-css'  href='https://www.publishat.com/maps1/style.css' type='text/css' media='all' />

<style>
body{
	font-family: "Open Sans","lucida grande","Segoe UI",arial,verdana,"lucida sans unicode", tahoma,sans-serif !important;
	font-size:15px;
	font-weight:500;
	}
iframe{
	overflow-x:hidden;
	width:100%;
	height:644px;
    }
   .control-label {
	  text-align:left !important;
	  margin-left:6px;
    }
	.container{
		//margin-left:33px !important;
	}
	.popup{
color:blue;
font-family:arial;
font-size:14px;
font-weight: bolder;
font-style: initial;
font-variant: small-caps;
}
#myUL{
	list-style: none;
}
#back{
	padding: 0 0 17px 0px;
}
</style>
<script>
$(document).ready(function(){ 

/* $('iframe').load( function() {
    $('iframe').contents().find("img")
      .append($("<style type='text/css'>  img{width:100%;height:100%;}  </style>"));
}); */
$("#location").keyup(function(e){ 
var loc = $(this).val(); 
 //var resultDropdown = $(this).siblings(".result");
	$.ajax({
			type: "POST",
			data: {location: loc},
			url: "https://www.publishat.com/digital/en/web/locationsearch",
			cache: false, 
			async: false,		
			success: function(data){ 
				$('.mapdata').html(data);
				/*var locationinfo = $("#mapdata").val(); 
				
				var availableTags =  $.parseJSON(locationinfo);
				$( "#location" ).autocomplete({ 
				maxLength: 0,
				source: availableTags,
				appendTo: '.ui-widget',
				selectFirst: true //here
				
				});*/
				
			}
		});
});
});


</script>
</head>
 <body>
 <div class="row" id="back">
    <a class="btn btn-default pull-right" href="https://www.publishat.com/digital/en/web/records?page_id=<?=$typeId;?>&module=<?=$module;?>&type=f">Back</a>
 </div>
 <div id="confirmation">
<div class="row">
	<div class="col-md-8">
	<?php if(in_array($filetype, $images ?? array())){
		  $num_pages = "1";
		?>
		<iframe name="iframetoprint" id="iframetoprint" src="<?=$path;?>"></iframe>
	<?php } else { ?>
		<iframe class="doc" id="iframefiles" src="https://docs.google.com/gview?url=<?=$path;?>&embedded=true"></iframe>
	<?php } ?>	
	</div>
	<div class="col-md-4">  
		<form class="form-horizontal" role="form" id="print_form">
		<input type="hidden" class="form-control" name="path" id="path" value="<?=$path;?>">
		<input type="hidden" class="form-control" name="filename" id="filename" value="<?=$filename;?>">
            <div class="form-group">
                <label class="col-sm-4 control-label">Color</label>
                <div class="col-sm-8">
                    <select class="form-control" name="color" id="colorselection" onchange="CheckIsProject()">
                        <option value="Black and White">Black and White</option>
                        <option value="Color">Color</option>
						<option value="LOR">LOR</option>
                    </select>
                </div>
            </div>
			<div class="form-group">
                <label class="col-sm-4 control-label">Print Type</label>
                <div class="col-sm-8">
                    <select class="form-control" name="color_type" id="printselection" onchange="CheckIsProject(this.value)">
                        <option value="Portriate">Portriat</option>
                        <option value="Landscape">Landscape</option>
						<option value="Project">Project</option>
                    </select>
                </div>
            </div>
			<div class="form-group">
                <label class="col-sm-4 control-label">Paper Size</label>
                <div class="col-sm-8">
                    <select class="form-control" name="size" id="papersize">
                        <option value="A4">A4</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">Copies</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" name="copies" id="copies">
                </div>
            </div>
			<div class="form-group">
                <label class="col-sm-4 control-label">No.Of.Pages</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control"  name="pagescount" id="pagescount" value="<?=$num_pages;?>" <?php if($num_pages){ ?>ReadOnly<?php }?>>
                </div>
            </div>
			<input type="hidden" class="form-control"  name="url" id="url" value="<?=$path;?>">
            <div class="form-group">
                <label class="col-sm-4 control-label">Description</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control"  name="description" id="description" value="">
                </div>
            </div>
			<div class="addMoreDiv"></div>
			<div style="margin-bottom: 50px;display: none" class="form-group" id="addMoreBtn">
				<button class="btn btn-default pull-right" type="button" onClick = "addMore()">Add Color Pages</button>
			</div>
			<div class="text-center">
				<button class="btn btn-primary" type="button" onClick="printpage(1)">Print</button>
			</div>
			
			
			<!--<div class="form-group">
                <div class="col-sm-12 ui-widget">
                    <input type="text" class="form-control" name="location" id="location" placeholder="Search By Location">
                </div>
				
            </div>-->
			<div class="row mapdata">
				<article class="entry">
					<div class="entry-content">
						<!--<div class="google-map-wrap" itemscope itemprop="hasMap" itemtype="http://schema.org/Map">
							<div id="google-map" class="google-map">
							</div>
						</div>-->
						<?php /* === MAP DATA === */ ?>
						<?php
						$locations = array();
                        $i = 1;
						foreach ($data as $row)  
							{ 
							  
								$name =$row["name"];
                                $lattitude =$row["latitude"];
								$longitude =$row["longitude"];
								$id = $i;
								$code = $row["code"];
								$location_address = $row["address"];
                                $locations[] = array('google_map' => array(
                                    'lat' => $lattitude,
                                    'lng' => $longitude,
									),
                                    'location_address' => $location_address,
                                    'location_name' => $name,
									'id' => $id
                                );
                                ?>
                                <input type="hidden" id="<?=$id;?>" value="<?=$code;?>">
                         <?php      
                                $i++;
							}
							//print_r($locations);
						?>
						<?php /* === PRINT THE JAVASCRIPT === */ ?>
						<?php
						/* Set Default Map Area Using First Location */
						/* 
						$map_area_lat = isset( $locations[0]['google_map']['lat'] ) ? $locations[0]['google_map']['lat'] : '';
						$map_area_lng = isset( $locations[0]['google_map']['lng'] ) ? $locations[0]['google_map']['lng'] : '';
						?>
<!-- maps disabled: 						<script type='text/javascript' src='https://publishat.com/restapp/en/assets/js/gmaps.js'></script> -->
							<script>
								jQuery( document ).ready( function($) { 
								var is_touch_device = 'ontouchstart' in document.documentElement; 
								var map = new GMaps({
									el: '#google-map',
									lat: <?php echo $map_area_lat; ?>,
									lng: <?php echo $map_area_lng; ?>,
									width: '200px',
									height: '200px',
									scrollwheel: false,
									draggable: ! is_touch_device
								});
								var bounds = [];
								
						<?php 
						foreach( $locations as $location ){
							    $id = $location['id'];
								$name = $location['location_name'];
								$addr = $location['location_address'];
								$map_lat = $location['google_map']['lat'];
								$map_lng = $location['google_map']['lng'];
						?>
								var latlng = new google.maps.LatLng(<?php echo $map_lat; ?>, <?php echo $map_lng; ?>);
								bounds.push(latlng);
									map.addMarker({
											lat: <?php echo $map_lat; ?>,
											lng: <?php echo $map_lng; ?>,
											title: '<?php echo $name; ?>',
											infoWindow: {
												content: '<a href="#"  onClick = "printpage(<?=$id;?>)"><p class="popup"><?php echo $name; ?><br><?php echo $addr; ?></p></a>'
												},
                                                click: function(){
                                                   (this.infoWindow).open(this.map, this);
                                                }
									});
						<?php } //end foreach locations ?>
								map.fitLatLngBounds(bounds);
								var $window = $(window);
								function mapWidth() { 
									var size = $('.google-map-wrap').width();
									$('.google-map').css({width: size + 'px', height: (size/1.5) + 'px'});
								}
								mapWidth();
								$(window).resize(mapWidth);

								});
							</script>
						<?php */ ?>
					</div>
				</article>
			</div>
        </form> <!-- /form -->
	</div>
</div>
</div>
</body>
</html>
<form id="ItemDiv" name="ItemDiv">
<div class="ItemDiv" style="display: none">
	<div class="col-md-12">
		<div class="form-group">
			<input type="number" class="form-control ProjectPageNos" id="ProjectPageNos" name="ProjectPageNos[]" required>
		</div>
	</div>
</div>
</form>
<script>
var MoreDivs = 1;
function printpage(id){
	$(document).ready(function(event){ 
		var copies = $("#copies").val();
		var pagescount = $("#pagescount").val();
		var colorselection = $("#colorselection").val();
		var papersize = $("#papersize").val();
		var print_type = $("#printselection").val();
		var url = $("#url").val();
		var code = $("#"+id).val();
		var filename = $("#filename").val(); 
		var description  = $("#description").val();
		
		var ProjectPageNos = [];

        $('.addMoreDiv input[name^="ProjectPageNos"]').each(function() {
			ProjectPageNos.push(this.value);
		});
		
		if(copies == ''){
			$("#copies").focus();
			$("#copies").css("border","1px solid red");
		}
		else if(pagescount == ''){
			$("#pagescount").focus();
			$("#pagescount").css("border","1px solid red");
		}
		else{
			$.ajax({
				type: "POST",
				url: "https://www.publishat.com/digital/en/web/printcheckoutpage", 
				data: {"copies":copies, "pagescount":pagescount, "colorselection":colorselection, "papersize":papersize, "url":url, "code":code, "filename":filename, "description":description, "print_type":print_type, "ProjectPageNos": ProjectPageNos},
				cache: false, 
				async: false,  
				success: function(data){   
                   $('#confirmation').html(data);
				}
			});
        }
	});
}
function addMore(){
	$.each( $('#ItemDiv').serializeArray(), function( key, value ) {
		var fieldName = value.name;
		console.log(fieldName);
		var res = fieldName.replace("[", "");
		var res = res.replace("]", "");
		
		$("#"+res).attr('id', res+"_"+MoreDivs);
	});
	var fieldLength = $('.addMoreDiv .ProjectPageNos').length;
	var newLength 	= parseInt(fieldLength)+MoreDivs;
	var ItemDiv		= $(".ItemDiv").html();
	var PageDetails = '<div id="AddedDiv'+MoreDivs+'"><div><small class="text-danger">Enter Page number</small><button type="button" class="btn btn-xs btn-danger pull-right" onclick="removediv('+MoreDivs+')">x</button></div>'+ItemDiv+'</div>';
	$(".addMoreDiv").append(PageDetails);
	$.each( $('#ItemDiv').serializeArray(), function( key, value ) {
		var fieldName = value.name;
		var res = fieldName.replace("[", "");
		var res = res.replace("]", "");
		$("#ItemDiv [name^='"+value.name+"']").attr('id', res);
	});
		
}
function removediv(id){
	$("#AddedDiv"+id).remove();
}
function CheckIsProject(value){
	var colorselection = $("#colorselection").val();
	value = value ? value : $("#printselection").val();
	if(value == "Project" && colorselection == "Black and White"){
		$("#addMoreBtn").show();
	} else {
		$("#addMoreBtn").hide();
		$(".addMoreDiv").html('');
	}
}
</script>
<?php
function remote_file_size($url){
# Get all header information
$data = get_headers($url, true);
# Look up validity
if (isset($data['Content-Length']))
    # Return file size
    return (int) $data['Content-Length'];
}