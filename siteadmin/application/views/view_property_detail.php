<!DOCTYPE HTML>
<html>

<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no" />
<meta name="description" content="">
<meta name="author" content="">
<link rel="icon" href="images/favicon.ico">
<title>Monopolion- Real Estate</title>
<!-- Bootstrap core CSS -->
<link href="<?php echo base_url(); ?>new/css/bootstrap.min.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>new/css/font-awesome.min.css" rel="stylesheet">

<!-- Custom styles for this template -->
<link href="<?php echo base_url(); ?>new/css/style.css" rel="stylesheet" type="text/css" charset="utf-8" />
<!-- Custom property detail page -->
<link href="<?php echo base_url(); ?>new/css/property-detail-page.css" rel="stylesheet" type="text/css" charset="utf-8" />
</head>

<body class="property-detail-page">
	<?php if(!empty($data)){ ?>
<div class="property-detail-container">
     <header class="header-top">
          <a href="javascript:;" class="logo"><img src="<?php echo base_url(); ?>images/logo.png" alt="" /></a>
     </header>
     
     <section class="showcase"> <!-- showcase -->
     <h1 class="property-name-titel"><?php if(!empty($data[0]->bedroom)){echo $data[0]->bedroom.' Bedroom';}else{ echo " "; } ?> <?php  if(!empty($property_type)){echo $property_type.' for'; }else{ echo " ";} ?> <?php if($data[0]->type ==1){ echo "Sale"; }else if($data[0]->type ==2){ echo "Rent"; }elseif($data[0]->type ==3) { echo "Sale/Rent"; }else{ echo "";} ?></h1>
       <div id="jssor_1" style="position: relative; margin: 0 auto; top: 0px; left: 0px; width: 800px; height: 456px; overflow: hidden; visibility: hidden; background-color: #24262e;">
          <!-- Loading Screen -->
          <div data-u="loading" style="position: absolute; top: 0px; left: 0px;">
              <div style="filter: alpha(opacity=70); opacity: 0.7; position: absolute; display: block; top: 0px; left: 0px; width: 100%; height: 100%;"></div>
              <div style="position:absolute;display:block;background:url('images/loading.gif') no-repeat center center;top:0px;left:0px;width:100%;height:100%;"></div>
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
	          <img data-u="image" src="<?php echo base_url().'upload/property/noimage.png'; ?>" />
	          <img data-u="thumb" src="<?php echo base_url().'upload/property/noimage.png'; ?>" />
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

      </div>

      <!-- #endregion Jssor Slider End -->
      </section><!-- /showcase -->
      <section class="poperty-detail-content">
     <div class="container-fluid">
         <h4>Property Price detail</h4>
         <div class="pro-block"><!-- pro-block -->
            <div class="row">
                <?php if(!empty($data[0]->reference_no)){ ?>
                <div class="col-md-6 col-sm-6">
                  <dl class="dl-horizontal">
                    <dt>Reference number:</dt>
                    <dd><?php echo $data[0]->reference_no ; ?></dd>
                  </dl>
                </div>
                <?php } ?>
                <?php if(!empty($data[0]->type)){ ?>
                <div class="col-md-6 col-sm-6">
                  <dl class="dl-horizontal">
                    <dt>Type:</dt>
                    <dd><?php if($data[0]->type ==1){ echo "Sale"; }else if($data[0]->type ==2){ echo "Rent"; }else { echo "Sale/Rent"; } ?></dd>
                  </dl>
                </div>
                <?php } ?>
            </div>
            <?php if($data[0]->sale_price !=0 || $data[0]->rent_price !=0){ ?>
            <div class="row">
                <?php if($data[0]->sale_price !=0){ ?>
                <div class="col-md-6 col-sm-6">
                  <dl class="dl-horizontal">
                  	<dt>Selling Price (€):</dt>
                    <dd><?php if($data[0]->sale_price !=0 ){echo number_format($data[0]->sale_price, 0, ".", ",");}else{ echo ""; } ?><br> <small class="text-muted"><?php if($data[0]->sale_val ==1){ echo " No V.A.T ";}else{ echo "Plus V.A.T";}?></small></dd>
                  </dl>
                </div>
                <?php } ?>
                <?php if($data[0]->rent_price !=0){ ?>
                <div class="col-md-6 col-sm-6">
                  <dl class="dl-horizontal">
                  	<dt>Rental Price (€):</dt>
                    <dd><?php if($data[0]->rent_price !=0 ){ echo number_format($data[0]->rent_price, 0, ".", ","); }else{ echo "";} ?> <br> <small class="text-muted"><?php if($data[0]->rent_val ==1){ echo "incl. common expenses";}else{ echo "Plus common expenses";}?></small></dd>
				  </dl>
                </div>
                <?php } ?>
            </div>
            <?php } ?>
         </div><!-- /pro-block -->

         <?php if(!empty($data[0]->address) || !empty($data[0]->CityTitle) || !empty($data[0]->CityareaTitle)){ ?>
         <h4>Property Area</h4>
         <div class="pro-block"><!-- pro-block -->
            <?php if(!empty($data[0]->address)){ ?>
            <div class="row">
                <div class="col-md-12 col-sm-12">
                  <dl class="dl-horizontal">
                    <dt>Address:</dt>
                    <dd><?php echo $data[0]->address; ?></dd>
                  </dl>
                </div>
            </div>
            <?php } ?>
            <div class="row">
                <?php if(!empty($data[0]->CityTitle)){ ?> 
                <div class="col-md-6 col-sm-6">
                  <dl class="dl-horizontal">
                    <dt>City:</dt>
                    <dd><?php echo $data[0]->CityTitle; ?></dd>
                  </dl>
                </div>
                <?php } ?>
                <?php if(!empty($data[0]->CityareaTitle)){ ?>
                <div class="col-md-6 col-sm-6">
                  <dl class="dl-horizontal">
                    <dt>City area:</dt>
                    <dd><?php echo $data[0]->CityareaTitle; ?></dd>
                  </dl>
                </div>
                <?php } ?>
            </div>

         </div><!-- /pro-block -->
         <?php } ?>

         <?php if(!empty($data[0]->bedroom) || (!empty($data[0]->bathroom) && $data[0]->bathroom !=0) || (!empty($data[0]->kitchen) && $data[0]->kitchen !=0) || !empty($room_size)){ ?>
         <h4>Key features</h4>
         <div class="pro-block"><!-- pro-block -->
            <div class="row">
                <?php if(!empty($data[0]->bedroom)){ ?>
                <div class="col-md-6 col-sm-6">
                  <dl class="dl-horizontal">
                    <dt>Bedroom:</dt>
                    <dd><?php echo $data[0]->bedroom; ?></dd>
                  </dl>
                </div>
                <?php } ?>
                <?php if(!empty($data[0]->bathroom) && $data[0]->bathroom !=0){ ?>
                <div class="col-md-6 col-sm-6">
                  <dl class="dl-horizontal">
                    <dt>Bathroom:</dt>
                    <dd><?php echo $data[0]->bathroom; ?></dd>
                  </dl>
                </div>
                <?php } ?>
            </div>
            <?php if((!empty($data[0]->kitchen) && $data[0]->kitchen !=0) || !empty($room_size)){ ?>
            <div class="row">
                <?php if(!empty($data[0]->kitchen) && $data[0]->kitchen !=0){ ?>
                <div class="col-md-6 col-sm-6">
                  <dl class="dl-horizontal">
                    <dt>Kitchen:</dt>
                    <dd><?php echo $data[0]->kitchen; ?></dd>
                  </dl>
                </div>
                <?php } ?>
                <?php if(!empty($room_size)){ ?>
                <div class="col-md-6 col-sm-6">
                  <dl class="dl-horizontal">
                    <dt>Room Size:</dt>
                    <dd><?php echo $room_size; ?></dd>
                  </dl>
                </div>
                <?php } ?>
            </div>
            <?php } ?>
            <?php if(!empty($architectural_design)){ ?>
            <div class="row">
                <div class="col-md-12 col-sm-12">
                  <dl class="dl-horizontal">
                    <dt>Architectural Design:</dt>
                    <dd><?php echo $architectural_design; ?></dd>
                  </dl>
                </div>
            </div>
            <?php } ?>

         </div><!-- /pro-block -->
         <?php } ?>

         <?php if(($data[0]->cover_area !=0 && !empty($data[0]->cover_area)) || ($data[0]->uncover_area !=0 && !empty($data[0]->uncover_area)) || ($data[0]->uncover_area !=0 && !empty($data[0]->uncover_area))){ ?>
         <h4>Property space detail</h4>
         <div class="pro-block"><!-- pro-block -->
            <?php if(($data[0]->cover_area !=0 && !empty($data[0]->cover_area)) || ($data[0]->uncover_area !=0 && !empty($data[0]->uncover_area))){ ?>
            <div class="row">
                <?php if($data[0]->cover_area !=0 && !empty($data[0]->cover_area)){ ?>
                <div class="col-md-6 col-sm-6">
                  <dl class="dl-horizontal">
                    <dt>Cover Area (m<sup>2</sup>):</dt>
                    <dd><?php echo $data[0]->cover_area; ?></dd>
                  </dl>
                </div>
                <?php } ?>
                <?php if($data[0]->uncover_area !=0 && !empty($data[0]->uncover_area)){ ?>
                <div class="col-md-6 col-sm-6">
                  <dl class="dl-horizontal">
                    <dt>Uncover Area (m<sup>2</sup>):</dt>
                    <dd><?php echo $data[0]->uncover_area; ?></dd>
                  </dl>
                </div>
                <?php } ?>
            </div>
            <?php } ?>
            <?php if($data[0]->plot_lan_area !=0 && !empty($data[0]->plot_lan_area)){ ?>
            <div class="row">
                <div class="col-md-6 col-sm-6">
                  <dl class="dl-horizontal">
                    <dt>Plot/land Area  (m<sup>2</sup>):</dt>
                    <dd><?php echo $data[0]->plot_lan_area; ?></dd>
                  </dl>
                </div>
            </div>
            <?php } ?>
         </div><!-- /pro-block -->
         <?php } ?>
         <?php if((!empty($data[0]->from_playground) && $data[0]->from_playground !=0) || (!empty($data[0]->from_supermarket) && $data[0]->from_supermarket !=0) || (!empty($data[0]->from_sea) && $data[0]->from_sea !=0) || (!empty($data[0]->from_bus_station) && $data[0]->from_bus_station !=0) ||(!empty($data[0]->from_cafeteria) && $data[0]->from_cafeteria !=0) || (!empty($data[0]->from_school) && $data[0]->from_school !=0) || (!empty($data[0]->from_restaurent) && $data[0]->from_restaurent !=0)|| (!empty($data[0]->from_high_way) && $data[0]->from_high_way !=0)){ ?>
         <h4>Property Distance</h4>
         <div class="pro-block property-distance-block"><!-- pro-block -->
            <?php if((!empty($data[0]->from_playground) && $data[0]->from_playground !=0) || (!empty($data[0]->from_supermarket) && $data[0]->from_supermarket !=0)){ ?>
            <div class="row">
                <?php if(!empty($data[0]->from_playground) && $data[0]->from_playground !=0){ ?>
                <div class="col-md-6 col-sm-6">
                  <dl class="dl-horizontal">
                    <dt><i class="icon" data-toggle="tooltip" data-placement="top" title="Playground" ><img src="<?php echo base_url(); ?>img/property-distance/playground.png" alt="" /></i> :</dt>
                    <dd><?php echo $data[0]->from_playground; ?> (KM)</dd>
                  </dl>
                </div>
                <?php } ?>
                <?php if(!empty($data[0]->from_supermarket) && $data[0]->from_supermarket !=0){ ?> 
                <div class="col-md-6 col-sm-6">
                  <dl class="dl-horizontal">
                    <dt><i class="icon" data-toggle="tooltip" data-placement="top" title="Supermarket" ><img src="<?php echo base_url(); ?>img/property-distance/supermarket.png" alt="" /></i> :</dt>
                    <dd><?php echo $data[0]->from_supermarket; ?> (KM)</dd>
                  </dl>
                </div>
                <?php } ?>
            </div>
            <?php } ?>
            <?php if((!empty($data[0]->from_sea) && $data[0]->from_sea !=0) || (!empty($data[0]->from_bus_station) && $data[0]->from_bus_station !=0)){ ?>
            <div class="row">
                <?php if(!empty($data[0]->from_sea) && $data[0]->from_sea !=0){ ?>
                <div class="col-md-6 col-sm-6">
                  <dl class="dl-horizontal">
                    <dt><i class="icon" data-toggle="tooltip" data-placement="top" title="Sea"  ><img src="<?php echo base_url(); ?>img/property-distance/sea.png" alt="" /></i> :</dt>
                    <dd><?php echo $data[0]->from_sea; ?> (KM)</dd>
                  </dl>
                </div>
                <?php } ?>
                <?php if(!empty($data[0]->from_bus_station) && $data[0]->from_bus_station !=0){ ?>
                <div class="col-md-6 col-sm-6">
                  <dl class="dl-horizontal">
                    <dt><i class="icon" data-toggle="tooltip" data-placement="top" title="Bus Station " ><img src="<?php echo base_url(); ?>img/property-distance/bus-station.png" alt="" /></i> :</dt>
                    <dd><?php echo $data[0]->from_bus_station; ?> (KM)</dd>
                  </dl>
                </div>
                <?php } ?>
            </div>
            <?php } ?>
            <?php if((!empty($data[0]->from_cafeteria) && $data[0]->from_cafeteria !=0) || (!empty($data[0]->from_school) && $data[0]->from_school !=0)){ ?>
            <div class="row">
                <?php if(!empty($data[0]->from_cafeteria) && $data[0]->from_cafeteria !=0){ ?>
                <div class="col-md-6 col-sm-6">
                  <dl class="dl-horizontal">
                    <dt><i class="icon" data-toggle="tooltip" data-placement="top" title="Cafeteria" ><img src="<?php echo base_url(); ?>img/property-distance/Cafeteria.png" alt="" /></i> :</dt>
                    <dd><?php echo $data[0]->from_cafeteria; ?> (KM)</dd>
                  </dl>
                </div>
                <?php } ?>
                <?php if(!empty($data[0]->from_school) && $data[0]->from_school !=0){ ?>
                <div class="col-md-6 col-sm-6">
                  <dl class="dl-horizontal">
                    <dt><i class="icon" data-toggle="tooltip" data-placement="top" title="School" ><img src="<?php echo base_url(); ?>img/property-distance/school.png" alt="" /></i> :</dt>
                    <dd><?php echo $data[0]->from_school; ?> (KM)</dd>
                  </dl>
                </div>
                 <?php } ?>
            </div>
            <?php } ?>
            <?php if((!empty($data[0]->from_restaurent) && $data[0]->from_restaurent !=0)|| (!empty($data[0]->from_high_way) && $data[0]->from_high_way !=0)){ ?> 
            <div class="row">
            	<?php if(!empty($data[0]->from_restaurent) && $data[0]->from_restaurent !=0){ ?> 
                <div class="col-md-6 col-sm-6">
                  <dl class="dl-horizontal">
                    <dt><i class="icon" data-toggle="tooltip" data-placement="top" title="Restaurent" ><img src="<?php echo base_url(); ?>img/property-distance/resturant.png" alt="" /></i> :</dt>
                    <dd><?php echo $data[0]->from_restaurent; ?> (KM)</dd>
                  </dl>
                </div>
                <?php } ?>
                <?php if(!empty($data[0]->from_high_way) && $data[0]->from_high_way !=0){ ?> 
                <div class="col-md-6 col-sm-6">
                  <dl class="dl-horizontal">
                    <dt><i class="icon" data-toggle="tooltip" data-placement="top" title="Highway " ><img src="<?php echo base_url(); ?>img/property-distance/highway.png" alt="" /></i> :</dt>
                    <dd><?php echo $data[0]->from_high_way; ?> (KM)</dd>
                  </dl>
                </div>
                <?php } ?>
            </div>
            <?php } ?>
         </div><!-- /pro-block -->
         <?php } ?>
         <br>
         <?php if(!empty($data[0]->short_decs)){ ?>
         <h4>Property Description</h4>
         <p><?php echo $data[0]->short_decs; ?></p>
         <br>
         <?php } ?>
         
         <?php if(!empty($genral_facilities)){ ?>
         <h4>Property Facilities Indoor</h4>
         <div class="pro-faciltiy-list-outer">
            <ul class="pro-faciltiy-list">
              <?php foreach ($genral_facilities as $key => $value){ ?>
              <li data-toggle="tooltip" data-placement="top" title="<?php echo trim($value->title); ?>">
                <div>
                  <i class="icon"><img src="<?php echo base_url(); ?>img/indoor/<?php echo trim($value->image); ?>" alt="" /></i>
                  <span><?php echo trim($value->title); ?></span>
                </div>
              </li>
              <?php } ?>
            </ul>
         </div>
         <?php } ?>

         <?php if(!empty($instrumental_facilities)){ ?>
         <h4>Other Faciliies</h4>
         <div class="pro-faciltiy-list-outer">
           <ul class="pro-faciltiy-list">
              <?php foreach ($instrumental_facilities as $key => $value) { ?>
              <li  data-toggle="tooltip" data-placement="top" title="<?php echo trim($value->title); ?>">
                <div>
                  <i class="icon"><img src="<?php echo base_url(); ?>img/electo/<?php echo trim($value->image); ?>" alt="" /></i>
                  <span><?php echo trim($value->title); ?></span>
                </div>
              </li>
              <?php } ?>
            </ul>
         </div>
         <?php } ?>
      
      <?php if(!empty($data[0]->url_link)){
        $url= explode(',', $data[0]->url_link);
      ?>
         <h4>Other Links</h4>
         <div class="pro-block otherlinks-block"><!-- pro-block -->
            <?php if(!empty($url[0])){ ?>
            <div class="row">
                <div class="col-md-12 col-sm-12">
                  <div class="url-links-row">
                    <i class="link-icon"><img src="<?php echo base_url(); ?>images/links-icon.png" alt="" /></i>
                    <a href="javascript:;"><?php echo $url[0]; ?> </a>
                  </div>
                </div>
            </div>
            <?php } ?>

            <?php if(!empty($url[1])){ ?>
            <div class="row">
                <div class="col-md-12 col-sm-12">
                  <div class="url-links-row">
                    <i class="link-icon"><img src="<?php echo base_url(); ?>images/links-icon.png" alt="" /></i>
                    <a href="javascript:;"><?php echo $url[1]; ?> </a>
                  </div>
                </div>
            </div>
            <?php } ?>

            <?php if(!empty($url[2])){ ?>
            <div class="row">
                <div class="col-md-12 col-sm-12">
                  <div class="url-links-row">
                    <i class="link-icon"><img src="<?php echo base_url(); ?>images/links-icon.png" alt="" /></i>
                    <a href="javascript:;"><?php echo $url[2]; ?> </a>
                  </div>
                </div>
            </div>
            <?php } ?>

         </div><!-- /pro-block -->
         <?php } ?>
         <h4>Map </h4>
            <input type="text" name="search_address" readonly id="search_address" value="<?php echo (empty($data[0]->map_adress)) ? 'limassol, cyprus' :$data[0]->map_adress ?>" onblur="showAddress(this.value);">
          	<div class="clear"></div>
         		<div class="map-block">
            	<div class="data" id="map_canvas" style="width: 100%; height: 400px">
              <!-- <img src="<?php echo base_url(); ?>img/Google-Maps.png" style="width:80%;" /> -->
            </div>

          </div>
          
         <!-- <div class="map-block">
              <img src="images/map-img.jpg" alt="" />
         </div> -->

     </div>
     </section>
</div>
 <?php }else{ ?>
 <center>
 <h3>Ooops! The requested page does not found.! </h3>
</center>
 <?php } ?>
<footer class="footer">&copy; <?php echo date('Y'); ?> Monopolion - Real Estate.</footer>

<script type="text/javascript" src="<?php echo base_url(); ?>new/js/jquery.min.js"></script> 
<script type="text/javascript" src="<?php echo base_url(); ?>new/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>new/js/custom.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>new/js/jssor.slider.mini.js"></script>
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
              //initSearchBox();
              }       
           });
            

      //  function initSearchBox() {
      //     // Add searchbox
      //     var searchControlDiv = document.createElement('div');
      //     var searchControl = new SearchControl(searchControlDiv, map);

      //     searchControlDiv.index = 1;
      //     map.controls[google.maps.ControlPosition.TOP_CENTER].push(searchControlDiv);
      // }
      

    // function SearchControl(controlDiv, map) {
    //      controlDiv.style.padding = '5px';

    //       var controlUI = document.createElement('div');
    //       controlUI.style.backgroundColor = 'white';
    //       controlUI.style.borderStyle = 'solid';
    //       controlUI.style.borderWidth = '2px';
    //       controlUI.style.cursor = 'pointer';
    //       controlUI.style.textAlign = 'center';
    //       controlUI.title = 'Sök ex: gatunamn, stad';
    //       controlDiv.appendChild(controlUI);

    //       // Create the search box
    //       var controlSearchBox = document.getElementById("search_address"); //document.createElement('input');
         
    //       // Initiat autocomplete
    //       $(function () {
    //           $(controlSearchBox).autocomplete({
    //               source: function (request, response) {

    //                   if (geocoder == null) {
    //                       geocoder = new google.maps.Geocoder();
    //                   }

    //                   geocoder.geocode({
    //                       'address': request.term
    //                   }, function (results, status) {
    //                       if (status == google.maps.GeocoderStatus.OK) {
    //                           var searchLoc = results[0].geometry.location;
    //                           var lat = results[0].geometry.location.lat();
    //                           var lng = results[0].geometry.location.lng();
    //                           var latlng = new google.maps.LatLng(lat, lng);
    //                           var bounds = results[0].geometry.bounds;

    //                           geocoder.geocode({
    //                               'latLng': latlng
    //                           }, function (results1, status1) {
    //                               if (status1 == google.maps.GeocoderStatus.OK) {
    //                                   if (results1[1]) {
    //                                       response($.map(results1, function (loc) {
    //                                           return {
    //                                               label: loc.formatted_address,
    //                                               value: loc.formatted_address,
    //                                               bounds: loc.geometry.bounds
    //                                           }
    //                                       }));
    //                                   }
    //                               }
    //                           });
    //                       }
    //                   });
    //               },
    //               select: function (event, ui) {
    //                   var pos = ui.item.position;
    //                   var lct = ui.item.locType;
    //                   var bounds = ui.item.bounds;

    //                   if (bounds) {
    //                       map.fitBounds(bounds);
    //                   }
    //               }
    //           });
    //       });

    //       // Set CSS for the control interior.
    //       var controlText = document.createElement('div');
    //       controlText.style.fontFamily = 'Arial,sans-serif';
    //       controlText.style.fontSize = '12px !important';
    //       controlText.style.paddingLeft = '4px !important';
    //       controlText.style.paddingRight = '4px !important';
    //       controlText.appendChild(controlSearchBox);
    //       controlUI.appendChild(controlText);
    //   }
    });
</script>
<script>
   $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })

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
            //you can remove responsive code if you don't want the slider scales while window resizing
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
