				<article class="entry">
					<div class="entry-content">
					<input type="hidden" id="mapdata" value="<?=$location;?>">
						<div class="google-map-wrap" itemscope itemprop="hasMap" itemtype="http://schema.org/Map">
							<div id="google-map" class="google-map">
							</div>
						</div>
						<?php /* === MAP DATA === */ ?>
						<?php
						
						$locations = array();
						$i = 1;
						foreach ($data as $row)  
							{  
							  
							  $name = $row['name']; 
								//$name =$row->LocationName;
                                $lattitude =$row['latitude'];
								$longitude =$row['longitude'];
								$id = $i;
								$code = $row["code"];
								$location_address = $row["address"];
                                //$lat = $data[$i]['LocationName']; 
                                $locations[] = array('google_map' => array(
                                    'lat' => $lattitude,
                                    'lng' => $longitude,
									),
                                    'location_address' => $location_address,
                                    'location_name' => $name,
									'id' => $id
                                );
							?>
                                <input type="hidden" id="<?=$i;?>" value="<?=$code;?>">
							<?php      
                                $i++;
							}
						?>
						<?php /* === PRINT THE JAVASCRIPT === */ ?>
						<?php
						/* Set Default Map Area Using First Location */
						$map_area_lat = isset( $locations[0]['google_map']['lat'] ) ? $locations[0]['google_map']['lat'] : '';
						$map_area_lng = isset( $locations[0]['google_map']['lng'] ) ? $locations[0]['google_map']['lng'] : '';
						?>
							<script>
								jQuery( document ).ready( function($) { 
								/* Do not drag on mobile. */
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
								/* Map Bound */
								var bounds = [];
								
						<?php /* For Each Location Create a Marker. */
							foreach( $locations as $locationdata ){
								$name = $locationdata['location_name'];
								$addr = $locationdata['location_address'];
								$map_lat = $locationdata['google_map']['lat'];
								$map_lng = $locationdata['google_map']['lng'];
								$id = $locationdata['id'];
						?>
								/* Set Bound Marker */
								var latlng = new google.maps.LatLng(<?php echo $map_lat; ?>, <?php echo $map_lng; ?>);
								bounds.push(latlng);
								/* Add Marker */
									map.addMarker({
											lat: <?php echo $map_lat; ?>,
											lng: <?php echo $map_lng; ?>,
											title: '<?php echo $name; ?>',
											infoWindow: {
												content: '<a href="#" onClick="printpage(<?=$id;?>)"><p class="popup"><?php echo $name; ?><br><?php echo $addr; ?></p></a>'
												},
                                                click: function(){
                                                   (this.infoWindow).open(this.map, this);
                                                }
									});
						<?php } //end foreach locations ?>
								/* Fit All Marker to map */
								map.fitLatLngBounds(bounds);
								/* Make Map Responsive */
								var $window = $(window);
								function mapWidth() { 
									var size = $('.google-map-wrap').width();
									$('.google-map').css({width: size + 'px', height: (size/1.5) + 'px'});
								}
								mapWidth();
								$(window).resize(mapWidth);

								});
							</script>
									
					</div>
				</article>
<script>
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
				data: {"copies":copies, "pagescount":pagescount, "colorselection":colorselection, "papersize":papersize, "url":url, "code":code, "filename":filename, "description":description, "print_type":print_type},
				cache: false, 
				async: false,  
				success: function(data){   
                   $('#confirmation').html(data);
				}
			});
        }
	});
}

</script>