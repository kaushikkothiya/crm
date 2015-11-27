<?php
//$this->load->view('header');
?>

<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/style.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/responsive.css" />
<script type="text/javascript" src="<?php echo base_url(); ?>js/slider/jssor.slider.mini.js"></script>

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
	
    <style>
        
        /* jssor slider arrow navigator skin 05 css */
        /*
        .jssora05l                  (normal)
        .jssora05r                  (normal)
        .jssora05l:hover            (normal mouseover)
        .jssora05r:hover            (normal mouseover)
        .jssora05l.jssora05ldn      (mousedown)
        .jssora05r.jssora05rdn      (mousedown)
        */
        .jssora05l, .jssora05r {
            display: block;
            position: absolute;
            /* size of arrow element */
            width: 40px;
            height: 40px;
            cursor: pointer;
            background: url('<?php echo base_url(); ?>img/a17.png') no-repeat;
            overflow: hidden;
        }
        .jssora05l { background-position: -10px -40px; }
        .jssora05r { background-position: -70px -40px; }
        .jssora05l:hover { background-position: -130px -40px; }
        .jssora05r:hover { background-position: -190px -40px; }
        .jssora05l.jssora05ldn { background-position: -250px -40px; }
        .jssora05r.jssora05rdn { background-position: -310px -40px; }

        /* jssor slider thumbnail navigator skin 01 css */
        /*
        .jssort01 .p            (normal)
        .jssort01 .p:hover      (normal mouseover)
        .jssort01 .p.pav        (active)
        .jssort01 .p.pdn        (mousedown)
        */
        .jssort01 .p {
            position: absolute;
            top: 0;
            left: 0;
            width: 72px;
            height: 72px;
        }
        
        .jssort01 .t {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: none;
        }
        
        .jssort01 .w {
            position: absolute;
            top: 0px;
            left: 0px;
            width: 100%;
            height: 100%;
        }
        
        .jssort01 .c {
            position: absolute;
            top: 0px;
            left: 0px;
            width: 68px;
            height: 68px;
            border: #000 2px solid;
            box-sizing: content-box;
            background: url('<?php echo base_url(); ?>img/t01.png') -800px -800px no-repeat;
            _background: none;
        }
        
        .jssort01 .pav .c {
            top: 2px;
            _top: 0px;
            left: 2px;
            _left: 0px;
            width: 68px;
            height: 68px;
            border: #000 0px solid;
            _border: #fff 2px solid;
            background-position: 50% 50%;
        }
        
        .jssort01 .p:hover .c {
            top: 0px;
            left: 0px;
            width: 70px;
            height: 70px;
            border: #fff 1px solid;
            background-position: 50% 50%;
        }
        
        .jssort01 .p.pdn .c {
            background-position: 50% 50%;
            width: 68px;
            height: 68px;
            border: #000 2px solid;
        }
        
        * html .jssort01 .c, * html .jssort01 .pdn .c, * html .jssort01 .pav .c {
            /* ie quirks mode adjust */
            width /**/: 72px;
            height /**/: 72px;
        }
        
    </style>
	<div class="formmain">
		<div class="title"><?php if(!empty($data[0]->bathroom)){echo $data[0]->bathroom.' Bedroom';}else{ echo " "; } ?> <?php  if(!empty($property_type)){echo $property_type.' for'; }else{ echo " ";} ?> <?php if($data[0]->type ==1){ echo "Sale"; }else if($data[0]->type ==2){ echo "Rent"; }elseif($data[0]->type ==3) { echo "Sale/Rent"; }else{ echo "";} ?></div>
		<div>
			 <div id="jssor_1" style="position: relative; margin: 0 auto; top: 0px; left: 0px; width: 800px; height: 456px; overflow: hidden; visibility: hidden; background-color: #24262e;">
        <!-- Loading Screen -->
        <div data-u="loading" style="position: absolute; top: 0px; left: 0px;">
            <div style="filter: alpha(opacity=70); opacity: 0.7; position: absolute; display: block; top: 0px; left: 0px; width: 100%; height: 100%;"></div>
            <div style="position:absolute;display:block;background:url('img/loading.gif') no-repeat center center;top:0px;left:0px;width:100%;height:100%;"></div>
        </div>
        <div data-u="slides" style="cursor: default; position: relative; top: 0px; left: 0px; width: 800px; height: 356px; overflow: hidden;">
            <?php 
            if(!empty($image)){
            foreach ($image as $key => $value) { ?>
				<div data-p="144.50" style="display: none;">
				  <img data-u="image" src='<?php echo base_url() ?>img_prop/<?php echo trim($value->image); ?>'>
				  <img data-u="thumb" src='<?php echo base_url() ?>img_prop/<?php echo trim($value->image); ?>'>
				</div>
				<?php } }else{ ?>
				<div data-p="144.50" style="display: none;">
				  <img data-u="image" src="<?php echo base_url().'upload/property/100x100/noimage.jpg'; ?>" />
				  <img data-u="thumb" src="<?php echo base_url().'upload/property/100x100/noimage.jpg'; ?>" />
				  
				</div>
				<?php } ?>
            
        </div>
        <!-- Thumbnail Navigator -->
        <div data-u="thumbnavigator" class="jssort01" style="position:absolute;left:0px;bottom:0px;width:800px;height:100px;" data-autocenter="1">
            <!-- Thumbnail Item Skin Begin -->
            <div data-u="slides" style="cursor: default;">
                <div data-u="prototype" class="p">
                    <div class="w">
                        <div data-u="thumbnailtemplate" class="t"></div>
                    </div>
                    <div class="c"></div>
                </div>
            </div>
            <!-- Thumbnail Item Skin End -->
        </div>
        <!-- Arrow Navigator -->
        <span data-u="arrowleft" class="jssora05l" style="top:158px;left:8px;width:40px;height:40px;"></span>
        <span data-u="arrowright" class="jssora05r" style="top:158px;right:8px;width:40px;height:40px;"></span>
        <a href="http://www.jssor.com" style="display:none">Jssor Slider</a>
    </div>
</div>
<div class="frmpadd">
			<?php  if(!empty($image)){  ?>
			<!-- <div class="fldimg"><img src="<?php echo base_url() ?>img_prop/100x100/<?php echo trim($image[0]->image); ?>" /></div> -->
			<?php }else{ ?>
			<!-- <div class="fldimg"><img src="<?php echo base_url().'upload/property/100x100/noimage.jpg'; ?>" /></div> -->
			<?php } ?>
			<div class="clear"></div>
			<div class="sep"></div>
			<div class="fldimg-txt">
				<?php if($data[0]->sale_price !='0'){ ?>
					 <div class="fild">
						<div class="lable">Selling Price (&euro;):</div>
						<div class="data"><?php if($data[0]->sale_price !='0' ){echo number_format($data[0]->sale_price, 0, ".", ",");}else{ echo ""; } ?></br><?php if($data[0]->rent_val =='1'){ echo " No V.A.T ";}else{ echo "Plus V.A.T";}?></div>
					</div> 
				<?php } ?>

				<?php if($data[0]->rent_price !='0'){ ?>
					<div class="fild">
						<div class="lable">Rental Price (&euro;):</div>
						<div class="data"><?php if($data[0]->rent_price !='0' ){ echo number_format($data[0]->rent_price, 0, ".", ","); }else{ echo "";} ?></br><?php if($data[0]->rent_val =='1'){ echo "incl. common expenses";}else{ echo "Plus common expenses";}?></div>
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
				<?php if($data[0]->cover_area !='0' && !empty($data[0]->cover_area)){ ?>
					<div class="fild">
						<div class="lable">Cover Area (m<sup>2</sup>):</div>
						<div class="data"><?php echo $data[0]->cover_area; ?></div>
					</div>
				<?php } ?>

				<?php if($data[0]->uncover_area !='0' && !empty($data[0]->uncover_area)){ ?>
					<div class="fild">
						<div class="lable">Uncover Area (m<sup>2</sup>):</div>
						<div class="data"><?php echo $data[0]->uncover_area; ?></div>
					</div>
				<?php } ?>

				<?php if($data[0]->plot_lan_area !='0' && !empty($data[0]->plot_lan_area)){ ?>
					<div class="fild">
						<div class="lable">Plot/land Area (m<sup>2</sup>):</div>
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

			<?php if(!empty($image)){  ?>
				<!-- <div class="description">
					<div class="lable">Extra images:</div>
					<div class="data">
						<?php
						foreach ($image as $key => $value)
						{ ?>
							<div class="thumbnail imageBox image">
							    <img src='<?php echo base_url() ?>img_prop/100x100/<?php echo trim($value->image); ?>'>
				            </div>
							<?php
						}
					?>
					<div class="clear"></div>
					</div>
				</div>  -->
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
 <script>
        jQuery(document).ready(function ($) {
            
            var jssor_1_SlideshowTransitions = [
              {$Duration:1200,x:0.3,$During:{$Left:[0.3,0.7]},$Easing:{$Left:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
              {$Duration:1200,x:-0.3,$SlideOut:true,$Easing:{$Left:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
              {$Duration:1200,x:-0.3,$During:{$Left:[0.3,0.7]},$Easing:{$Left:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
              {$Duration:1200,x:0.3,$SlideOut:true,$Easing:{$Left:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
              {$Duration:1200,y:0.3,$During:{$Top:[0.3,0.7]},$Easing:{$Top:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
              {$Duration:1200,y:-0.3,$SlideOut:true,$Easing:{$Top:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
              {$Duration:1200,y:-0.3,$During:{$Top:[0.3,0.7]},$Easing:{$Top:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
              {$Duration:1200,y:0.3,$SlideOut:true,$Easing:{$Top:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
              {$Duration:1200,x:0.3,$Cols:2,$During:{$Left:[0.3,0.7]},$ChessMode:{$Column:3},$Easing:{$Left:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
              {$Duration:1200,x:0.3,$Cols:2,$SlideOut:true,$ChessMode:{$Column:3},$Easing:{$Left:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
              {$Duration:1200,y:0.3,$Rows:2,$During:{$Top:[0.3,0.7]},$ChessMode:{$Row:12},$Easing:{$Top:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
              {$Duration:1200,y:0.3,$Rows:2,$SlideOut:true,$ChessMode:{$Row:12},$Easing:{$Top:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
              {$Duration:1200,y:0.3,$Cols:2,$During:{$Top:[0.3,0.7]},$ChessMode:{$Column:12},$Easing:{$Top:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
              {$Duration:1200,y:-0.3,$Cols:2,$SlideOut:true,$ChessMode:{$Column:12},$Easing:{$Top:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
              {$Duration:1200,x:0.3,$Rows:2,$During:{$Left:[0.3,0.7]},$ChessMode:{$Row:3},$Easing:{$Left:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
              {$Duration:1200,x:-0.3,$Rows:2,$SlideOut:true,$ChessMode:{$Row:3},$Easing:{$Left:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
              {$Duration:1200,x:0.3,y:0.3,$Cols:2,$Rows:2,$During:{$Left:[0.3,0.7],$Top:[0.3,0.7]},$ChessMode:{$Column:3,$Row:12},$Easing:{$Left:$Jease$.$InCubic,$Top:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
              {$Duration:1200,x:0.3,y:0.3,$Cols:2,$Rows:2,$During:{$Left:[0.3,0.7],$Top:[0.3,0.7]},$SlideOut:true,$ChessMode:{$Column:3,$Row:12},$Easing:{$Left:$Jease$.$InCubic,$Top:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
              {$Duration:1200,$Delay:20,$Clip:3,$Assembly:260,$Easing:{$Clip:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
              {$Duration:1200,$Delay:20,$Clip:3,$SlideOut:true,$Assembly:260,$Easing:{$Clip:$Jease$.$OutCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
              {$Duration:1200,$Delay:20,$Clip:12,$Assembly:260,$Easing:{$Clip:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
              {$Duration:1200,$Delay:20,$Clip:12,$SlideOut:true,$Assembly:260,$Easing:{$Clip:$Jease$.$OutCubic,$Opacity:$Jease$.$Linear},$Opacity:2}
            ];
            
            var jssor_1_options = {
              $AutoPlay: true,
              $SlideshowOptions: {
                $Class: $JssorSlideshowRunner$,
                $Transitions: jssor_1_SlideshowTransitions,
                $TransitionsOrder: 1
              },
              $ArrowNavigatorOptions: {
                $Class: $JssorArrowNavigator$
              },
              $ThumbnailNavigatorOptions: {
                $Class: $JssorThumbnailNavigator$,
                $Cols: 10,
                $SpacingX: 8,
                $SpacingY: 8,
                $Align: 360
              }
            };
            
            var jssor_1_slider = new $JssorSlider$("jssor_1", jssor_1_options);
            
            //responsive code begin
            //you can remove responsive code if you don't want the slider scales while window resizes
            function ScaleSlider() {
                var refSize = jssor_1_slider.$Elmt.parentNode.clientWidth;
                if (refSize) {
                    refSize = Math.min(refSize, 800);
                    jssor_1_slider.$ScaleWidth(refSize);
                }
                else {
                    window.setTimeout(ScaleSlider, 30);
                }
            }
            ScaleSlider();
            $(window).bind("load", ScaleSlider);
            $(window).bind("resize", ScaleSlider);
            $(window).bind("orientationchange", ScaleSlider);
            //responsive code end
        });
    </script>
