<?php

$this->load->view('header');

?>

<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/style.css" />



<div class="wrapper">
	<div class="header">
		<div class="logo"><img src="<?php echo base_url(); ?>img/cmr.png" /></div>
		<div class="clear"></div>
	</div>
	<style>
	.imageBox{
				width:100px;height:100px;float:left;
				margin:0px 7px 7px 0px;vertical-align:middle;
				display:inline-block;position:relative;
			}
			.map{max-width:100% !important;}
	</style>
	
	
	<div class="formmain">
		<div class="title"><?php if(!empty($data[0]->bathroom)){echo $data[0]->bathroom;}else{ echo "-"; } ?> Bedroom <?php  if(!empty($property_type)){echo $property_type; }else{ echo "-";} ?> for <?php if($data[0]->type ==1){ echo "Sale"; }else if($data[0]->type ==2){ echo "Rent"; }elseif($data[0]->type ==3) { echo "Sale/Rent"; }else{ echo "";} ?></div>
		<div class="frmpadd">
			<?php if(!empty($data[0]->image)){ ?>
			<div class="fldimg"><img src="<?php echo base_url().'upload/property/100x100/'.$data[0]->image; ?>" /></div>
			<?php }else{ ?>
			<div class="fldimg"><img src="<?php echo base_url().'upload/property/100x100/noimage.jpg'; ?>" /></div>
			<?php } ?>
			
			<div class="fldimg-txt">
				<?php if($data[0]->sale_price !='0'){ ?>
					 <div class="fild">
						<div class="lable">Selling Price (€):</div>
						<div class="data"><?php if($data[0]->sale_price !='0' ){echo $data[0]->sale_price;}else{ echo ""; } ?></br><?php if($data[0]->rent_val =='0'){ echo " No V.A.T ";}else{ echo "Plus V.A.T";}?></div>
					</div> 
				<?php } ?>

				<?php if($data[0]->rent_price !='0'){ ?>
					<div class="fild">
						<div class="lable">Rental Price (€):</div>
						<div class="data"><?php if($data[0]->rent_price !='0' ){ echo $data[0]->rent_price;}else{ echo "";} ?></br><?php if($data[0]->rent_val =='0'){ echo "incl. common expenses";}else{ echo "Plus common expenses";}?></div>
					</div> 
				<?php } ?>
				<?php if(!empty($data[0]->CityTitle)){ ?>	
					<div class="lable">City:</div>
					<div class="data"><?php echo $data[0]->CityTitle; ?></div>
				<?php } ?>
				
				<?php if(!empty($data[0]->CityareaTitle)){ ?>	
					<div class="lable">City area:</div>
					<div class="data"><?php echo $data[0]->CityareaTitle; ?></div>
				<?php } ?>
				
			</div>

			<div class="fldimg-txt1">
				<?php if(!empty($data[0]->reference_no)){ ?>	
					<div class="lable">Reference number:</div>
					<div class="data"><?php echo $data[0]->reference_no ; ?></div>
				<?php } ?>

				<?php if(!empty($data[0]->type)){ ?>	
					<div class="lable">Type:</div>
					<div class="data sep"><?php if($data[0]->type ==1){ echo "Sale"; }else if($data[0]->type ==2){ echo "Rent"; }else { echo "Sale/Rent"; } ?></div>
				<?php } ?>
				
				<?php if(!empty($data[0]->address)){ ?>	
					<div class="lable">Address:</div>
					<div class="data"><?php echo $data[0]->address; ?></div>
				<?php } ?>
			</div>
			<div class="clear"></div>

			<?php if(!empty($data[0]->short_decs)){ ?>
			<div class="clear"></div>
			<div class="description">
				<div class="lable">Property Description:</div>
				<div class="data"><?php echo $data[0]->short_decs; ?></div>
			</div>
			<?php } ?>
			<div class="clear"></div>

			<div class="description">
					<div class="lable"></div>
					<div class="data">
						<input type="text" name="search_address" readonly id="search_address" value="<?php echo (empty($data[0]->map_adress)) ? 'limassol, cyprus' :$data[0]->map_adress ?>" onblur="showAddress(this.value);">
							
					<div class="clear"></div>
					<div class="fild map">
						<div class="data" id="map_canvas" style="width: 100%; height: 400px">
							<!-- <img src="<?php echo base_url(); ?>img/Google-Maps.png" style="width:80%;" /> -->
						</div>

					</div>
					</div>
					</div> 
					<div class="clear"></div>
			<?php if(!empty($image)){ ?>
				<div class="description">
					<div class="lable">Extra images:</div>
					<div class="data">
						<?php
						foreach ($image as $key => $value)
						{ ?>
							<div class="thumbnail imageBox image">
							    <img src='<?php echo base_url() ?>upload/property/100x100/<?php echo $value->image_name ?>'>
				            </div>
							<?php
						}
					?>
					<div class="clear"></div>
					</div>
				</div> 
			<?php } ?>

			<?php //if(!empty($genral_facilities)){ ?>
			<!-- <div class="clear"></div>
			<div class="description">
				<div class="lable">Property Facilities Indoor:</div>
				<div class="data">
					<?php 
					foreach ($genral_facilities as $key => $value)
					{
						echo '<span style="width:100px;height:100px;padding:30px 0px;margin:0px 5px 20px 0px;border:1px solid #ccc"><img src="'.base_url().'upload/property/facility/'.trim($value->title).'.png" style="padding:5px"></span>';
					echo $value->title;?> <br><?php
					}
				?>
				</div>
			</div> -->
			<?php //} ?>
			<?php if(!empty($genral_facilities)){ ?>
			<div class="description">
			<div class="property-icon-main">
				<div class="lable">Property Facilities Indoor:</div></br>
				<div class="txtbdrmain">
				<?php 
					foreach ($genral_facilities as $key => $value)
					{ ?>
						<!-- <div class="property-icon">
						<div class="property-icon-img"><img src='<?php echo base_url() ?>upload/property/facility/call.png' alt="" /></div>
						<div class="property-icon-txt"><?php echo trim($value->title); ?></div>
						<div class="clear"></div>
						</div>	
 -->
						<div class="txtbdr"><?php echo trim($value->title); ?></div>
  					<?php
					if(($key+1)%3 == 0){?>
						<div class="clear"></div>
					<?php }
				 }
				?>
				</div>
						
				<div class="clear"></div>
			</div>
			</div>
			<?php } ?>

			<?php //if(!empty($instrumental_facilities)){ ?>
			<!-- <div class="clear"></div>
			<div class="description">
				<div class="lable">Other Faciliies:</div>
				<div class="data">
					<?php 
					foreach ($instrumental_facilities as $key => $value)
					{
						//echo '<span style="width:100px;height:100px;padding:30px 0px;margin:0px 5px 20px 0px;border:1px solid #ccc"><img src='.base_url().'upload/property/100x100/'.$value->image_name.' style="padding:5px"></span>';
					echo $value->title; ?> <br><?php
					}
				?>
				</div>
			</div> -->
			<?php //} ?>
			<?php if(!empty($instrumental_facilities)){ ?>
			<div class="description">
			<div class="property-icon-main">
				<div class="lable">Other Faciliies:</div></br>
				<div class="txtbdrmain">
				<?php 
					foreach ($instrumental_facilities as $key => $value)
					{ ?>
						<!-- <div class="property-icon">
						<div class="property-icon-img"><img src='<?php echo base_url() ?>upload/property/facility/call.png' alt="" /></div>
						<div class="property-icon-txt"><?php echo trim($value->title); ?></div>
						<div class="clear"></div>
						</div>
						 -->
						 <div class="txtbdr"><?php echo trim($value->title); ?></div>
					<?php
					if(($key+1)%3 == 0){?>
						<div class="clear"></div>
					<?php
					 }
				 }
				?>
				</div>
				<div class="clear"></div>
			</div>
			</div>
			<?php } ?>

			<div class="leftpart">
				
				<?php if(!empty($data[0]->bedroom)){ ?>
					<div class="fild">
						<div class="lable">Bedroom:</div>
						<div class="data"><?php echo $data[0]->bedroom; ?></div>
					</div>
				<?php } ?>

				<?php if(!empty($data[0]->bathroom) && $data[0]->bathroom !="0"){ ?>
					<div class="fild">
						<div class="lable">Bathroom:</div>
						<div class="data"><?php echo $data[0]->bathroom; ?></div>
					</div>
				<?php } ?>
				
				<?php if(!empty($architectural_design)){ ?>
					<div class="fild">
						<div class="lable">Architectural Design:</div>
						<div class="data"><?php echo $architectural_design; ?></div>
					</div> 
				<?php } ?>

				<?php if(!empty($data[0]->from_playground) && $data[0]->from_playground !="0"){ ?>
					<div class="fild">
						<div class="lable">From Playground (KM):</div>
						<div class="data"><?php echo $data[0]->from_playground; ?></div>
					</div> 
				<?php } ?>

				<?php if(!empty($data[0]->from_sea) && $data[0]->from_sea !="0"){ ?>
					<div class="fild">
						<div class="lable">From Sea (KM):</div>
						<div class="data"><?php echo $data[0]->from_sea; ?></div>
					</div> 
				<?php } ?>

				<?php if(!empty($data[0]->from_cafeteria) && $data[0]->from_cafeteria !="0"){ ?>
					<div class="fild">
						<div class="lable">From Cafeteria (KM):</div>
						<div class="data"><?php echo $data[0]->from_cafeteria; ?></div>
					</div>
				<?php } ?>

				<?php if(!empty($data[0]->from_restaurent) && $data[0]->from_restaurent !="0"){ ?> 
					<div class="fild">
						<div class="lable">From Restaurent (KM):</div>
						<div class="data"><?php echo $data[0]->from_restaurent; ?></div>
					</div>
				<?php } ?> 
			</div>
			
			<div class="rightpart">
				<?php if($data[0]->cover_area !='0' && !empty($data[0]->cover_area)){ ?>
					<div class="fild">
						<div class="lable">Cover Area (m²):</div>
						<div class="data"><?php echo $data[0]->cover_area; ?></div>
					</div>
				<?php } ?>

				<?php if($data[0]->uncover_area !='0' && !empty($data[0]->uncover_area)){ ?>
					<div class="fild">
						<div class="lable">Uncover Area (m²):</div>
						<div class="data"><?php echo $data[0]->uncover_area; ?></div>
					</div>
				<?php } ?>

				<?php if($data[0]->plot_lan_area !='0' && !empty($data[0]->plot_lan_area)){ ?>
					<div class="fild">
						<div class="lable">Plot/land Area (m²):</div>
						<div class="data"><?php echo $data[0]->plot_lan_area; ?></div>
					</div>
				<?php } ?>

				<?php if(!empty($data[0]->kitchen) && $data[0]->kitchen !="0"){ ?>
					<div class="fild">
						<div class="lable">Kitchen:</div>
						<div class="data"><?php echo $data[0]->kitchen; ?></div>
					</div>
				<?php } ?>

				<?php if(!empty($room_size)){ ?>
					<div class="fild">
						<div class="lable">Room Size:</div>
						<div class="data"><?php echo $room_size; ?></div>
					</div>
				<?php } ?>
				
				<?php if(!empty($data[0]->from_supermarket) && $data[0]->from_supermarket !="0"){ ?>			
					<div class="fild">
						<div class="lable">From Supermarket (KM):</div>
						<div class="data"><?php echo $data[0]->from_supermarket; ?></div>
					</div>
				<?php } ?>	

				<?php if(!empty($data[0]->from_bus_station) && $data[0]->from_bus_station !="0"){ ?>
					<div class="fild">
						<div class="lable">From Bus Station (KM):</div>
						<div class="data"><?php echo $data[0]->from_bus_station; ?></div>
					</div>
				<?php } ?>	

				<?php if(!empty($data[0]->from_school) && $data[0]->from_school !="0"){ ?>
					<div class="fild">
						<div class="lable">From School (KM):</div>
						<div class="data"><?php echo $data[0]->from_school; ?></div>
					</div>
				<?php } ?>
				
				<?php if(!empty($data[0]->from_high_way) && $data[0]->from_high_way !="0"){ ?>	
					<div class="fild">
						<div class="lable">From Highway (KM):</div>
						<div class="data"><?php echo $data[0]->from_high_way; ?></div>
					</div>
				<?php } ?>
			</div>
		<div class="clear"></div>
	</div>
	<br /><br />
	
</div>

<?php

$this->load->view('footer');

?>

<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=false"></script>
<script>


       $(document).ready(function () {

        	var map;
			var addressField;
			var geocoder;

        
        		 	//var geocoder = new google.maps.Geocoder();
					var address =$('#search_address').val();
					var latitude="";
					var longitude="";
					$.ajax({
					  url:"http://maps.googleapis.com/maps/api/geocode/json?address="+address+"&sensor=false",
					  type: "POST",
					  success:function(res){
					     latitude=res.results[0].geometry.location.lat;
					     longitude=res.results[0].geometry.location.lng;
					     $('#lat_lon').val(latitude+','+longitude);
					     var mapOptions = {
					        center: new google.maps.LatLng(latitude, longitude),
					        zoom: 13,
					        mapTypeId: google.maps.MapTypeId.HYBRID,
					        panControl: true,
					        zoomControl: true,
					        mapTypeControl: true,
					        scaleControl: true,
					        streetViewControl: true,
					        overviewMapControl: true,
					        mapTypeId: google.maps.MapTypeId.ROADMAP
					    };
					    var myLatlng = new google.maps.LatLng(latitude,longitude);
					    // Define map
					    map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);
					   
					    var marker = new google.maps.Marker({
				        position: myLatlng, 
				        map: map,
				        title:address
				    });
					    // Define map
					    //map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);

					    // Define Gecoder
					    geocoder = new google.maps.Geocoder();

					    // Init searchbox
					    initSearchBox();
					  	}				
					 });
        		

		   function initSearchBox() {
			    // Add searchbox
			    var searchControlDiv = document.createElement('div');
			    var searchControl = new SearchControl(searchControlDiv, map);

			    searchControlDiv.index = 1;
			    map.controls[google.maps.ControlPosition.TOP_CENTER].push(searchControlDiv);
			}
      

		function SearchControl(controlDiv, map) {
			   controlDiv.style.padding = '5px';

			    var controlUI = document.createElement('div');
			    controlUI.style.backgroundColor = 'white';
			    controlUI.style.borderStyle = 'solid';
			    controlUI.style.borderWidth = '2px';
			    controlUI.style.cursor = 'pointer';
			    controlUI.style.textAlign = 'center';
			    controlUI.title = 'Sök ex: gatunamn, stad';
			    controlDiv.appendChild(controlUI);

			    // Create the search box
			    var controlSearchBox = document.getElementById("search_address"); //document.createElement('input');
			   
			    // Initiat autocomplete
			    $(function () {
			        $(controlSearchBox).autocomplete({
			            source: function (request, response) {

			                if (geocoder == null) {
			                    geocoder = new google.maps.Geocoder();
			                }

			                geocoder.geocode({
			                    'address': request.term
			                }, function (results, status) {
			                    if (status == google.maps.GeocoderStatus.OK) {
			                        var searchLoc = results[0].geometry.location;
			                        var lat = results[0].geometry.location.lat();
			                        var lng = results[0].geometry.location.lng();
			                        var latlng = new google.maps.LatLng(lat, lng);
			                        var bounds = results[0].geometry.bounds;

			                        geocoder.geocode({
			                            'latLng': latlng
			                        }, function (results1, status1) {
			                            if (status1 == google.maps.GeocoderStatus.OK) {
			                                if (results1[1]) {
			                                    response($.map(results1, function (loc) {
			                                        return {
			                                            label: loc.formatted_address,
			                                            value: loc.formatted_address,
			                                            bounds: loc.geometry.bounds
			                                        }
			                                    }));
			                                }
			                            }
			                        });
			                    }
			                });
			            },
			            select: function (event, ui) {
			                var pos = ui.item.position;
			                var lct = ui.item.locType;
			                var bounds = ui.item.bounds;

			                if (bounds) {
			                    map.fitBounds(bounds);
			                }
			            }
			        });
			    });

			    // Set CSS for the control interior.
			    var controlText = document.createElement('div');
			    controlText.style.fontFamily = 'Arial,sans-serif';
			    controlText.style.fontSize = '12px';
			    controlText.style.paddingLeft = '4px';
			    controlText.style.paddingRight = '4px';
			    controlText.appendChild(controlSearchBox);
			    controlUI.appendChild(controlText);
			}
		});
</script>
