<link href="<?php echo base_url(); ?>css/style_photos.css" rel="stylesheet" type="text/css" />
<!-- <link href="<?php echo base_url(); ?>css/loader/demo.css" rel="stylesheet"> -->
<?php
$this->load->view('header');
$this->load->view('leftmenu');
if (isset($user[0])) {
   // echo'<pre>';print_r($user[0]);
    $id = $user[0]->id;
    $type = $user[0]->type;
	$address = $user[0]->address;
	$country_id = $user[0]->country_id;
	$city_id = $user[0]->city_id;
	$city_area =$user[0]->city_area;
	$property_type = $user[0]->property_type;
	$furnished_type = $user[0]->furnished_type;
	$rent_price = $user[0]->rent_price;
	$sale_price = $user[0]->sale_price;
	$bedroom = $user[0]->bedroom;
    $bathroom = $user[0]->bathroom;
	$reference_no = $user[0]->reference_no;
	//$link_url = explode($user[0]->url_link);
	$link= explode(',', $user[0]->url_link);
	//$link_url=$link['0'];
	if(!empty($link['0'])){
		$link_url=$link['0'];
	}else{
		$link_url="";
	}
	if(!empty($link['1'])){
		$link_url1=$link['1'];
	}else{
		$link_url1='';
	}if(!empty($link['2'])){
		$link_url2=$link['2'];
	}else{
		$link_url2="";
	}
	$image = $user[0]->image;
	$short_decs =$user[0]->short_decs;
	$status_name = $user[0]->status;
	$agent_id = $user[0]->agent_id;
	$rent_type = $user[0]->rent_val;
	$sale_type = $user[0]->sale_val;
	$cover_area_size = $user[0]->cover_area;
	$uncover_area_size = $user[0]->uncover_area;
	$plot_lan_area_size = $user[0]->plot_lan_area;
	$fname = $user[0]->fname;
	$lname = $user[0]->lname;
	$email = $user[0]->email;
	$contact = $user[0]->mobile;
	$compny_name = $user[0]->compny_name;
	$added_id = $user[0]->added_id;
	$check_val = $user[0]->tearm_condition;
	$Kitchen = $user[0]->kitchen;
	$architectural_design = $user[0]->architectural_design;
	$room_size = $user[0]->room_size;
	$pets = $user[0]->pets;
	$make_year = $user[0]->make_year;
	$cover_parking_id = $user[0]->cover_parking;
	$uncover_parking_id = $user[0]->uncover_parking;
	$county_code = $user[0]->coutry_code;

	$from_supermarket = $user[0]->from_supermarket;
	$from_bus_station = $user[0]->from_bus_station;
	$from_school = $user[0]->from_school;
	$from_high_way = $user[0]->from_high_way;
	$from_playground = $user[0]->from_playground;
	$from_sea = $user[0]->from_sea;
	$from_cafeteria = $user[0]->from_cafeteria;
	$from_restaurent = $user[0]->from_restaurent;
	$map_address=$user[0]->map_adress;
} else {
    $id = $this->input->post('id');
    $type = $this->input->post('type');
    $address = $this->input->post('address');
    $country_id = $this->input->post('country_id');
	$city_id = $this->input->post('city_id');
	$city_area = $this->input->post('city_area_id');
	$property_type = $this->input->post('property_category');
	$furnished_type = $this->input->post('furnished_type');
	$rent_price = $this->input->post('rent_price');
	$sale_price = $this->input->post('sale_price');
 	$bedroom = $this->input->post('bedrooms');
    $bathroom = $this->input->post('bathrooms');
    $reference_no = $this->input->post('reference_no');
    $link_url = $this->input->post('link_url');
	$image = $this->input->post('image');
	$short_decs = $this->input->post('short_desc');
	//$long_desc = $this->input->post('long_decs');
	$status_name = $this->input->post('status');
	$agent_id = $this->input->post('agent_id');
	$rent_type = $this->input->post('rent_val');
	$sale_type = $this->input->post('sale_val');
	//$size = $this->input->post('size');
     //$squ_meter_size = $this->input->post('squ_meter');
	$cover_area_size = $this->input->post('cover_area');
	$uncover_area_size = $this->input->post('uncover_area');
	//$plot_area_size = $this->input->post('plot_area');
	$plot_lan_area_size = $this->input->post('plot_lan_area');
	//$totale_area_size = $this->input->post('totale_area');
	$link_url2="";
	$link_url1="";
	$fname = $this->input->post('fname');
	$lname = $this->input->post('lname');
	$email = $this->input->post('email');
	$contact = $this->input->post('mobile');
	$compny_name = $this->input->post('cname');
	$check_val = $this->input->post('checked1');
	$Kitchen = $this->input->post('Kitchen_id');
	$architectural_design = $this->input->post('architectural_design_id');
	$room_size = $this->input->post('room_size_id');
	$pets = $this->input->post('pets_id');
	$facility_id=array();
	$make_year = $this->input->post('make_year');
	$cover_parking_id = $this->input->post('cover_parking');
	$uncover_parking_id = $this->input->post('uncover_parking');
	$county_code = $this->input->post('county_code');
	$from_supermarket = $this->input->post('from_supermarket');
	$from_bus_station = $this->input->post('from_bus_station');
	$from_school = $this->input->post('from_school');
	$from_high_way = $this->input->post('from_high_way');
	$from_playground = $this->input->post('from_playground');
	$from_sea = $this->input->post('from_sea');
	$from_cafeteria = $this->input->post('from_cafeteria');
	$from_restaurent = $this->input->post('from_restaurant');
	$map_address=$this->input->post('search_address');
}
?>

<!--<script type="text/javascript" src="<?php //echo base_url(); ?>js/jquery-ui.js"></script>
<script type="text/javascript" src="<?php //echo base_url(); ?>js/jquery-1.8.3.min.js"></script>-->
<style>
#drop-area{background: #D8F9D3;min-height:200px;padding:10px;}
#drop-area_add{background: #D8F9D3;min-height:200px;padding:10px;}
h3.drop-text{color:#999;text-align:center;font-size:2em;}
</style>
<!--<link href="<?php echo base_url(); ?>css/selectmulcheck/multiple-select.css" rel="stylesheet">
<script type="text/javascript" src="<?php echo base_url(); ?>js/selectmulcheck/jquery.multiple.select.js"></script>
<script src="<?php echo base_url(); ?>js/multifileuplod/jquery.min.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/multifileuplod/uploadify.css">-->
<div class="container-fluid">
	<div class="row">
      <div class="main">
      	<?php if ($this->session->flashdata('success')) { ?>
                <div class="alert alert-success" role="alert">
                    <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <?php echo $this->session->flashdata('success'); ?>
                </div>
            <?php } ?>
      	<?php if ($this->uri->segment(3)) { ?>
      	<h1 class="page-header">Edit Property </h1>
      	<?php } else { ?>
    	<h1 class="page-header">Create Property </h1>
		<?php } ?>
        
        <div class="row">
          <div class="col-sm-12">
            <div class="panel panel-default">
              <div class="panel-heading">Create New Property</div>
              <div class="panel-body">

                <?php echo form_open_multipart('verification/create_property', array('class' => 'form-horizontal')); ?>
                <input type="hidden" id="property_id" name="property_id" value="<?php if(isset($id) && !empty($id)){ echo $id; } ?>">
               	<input type="hidden" id="property_imageid" name="property_imageid" value="">
                <?php echo form_hidden('id', $id); ?>
                <?php 
				if(!empty($id))
				{
					if($this->session->userdata('logged_in_agent')){
							$sessionData = $this->session->userdata('logged_in_agent');
							$agent_loginid =$sessionData['id'];
					}else{
							$agent_loginid="";
					}
					
					if(!$this->session->userdata('logged_in_super_user') && !$this->session->userdata('logged_in_employee'))
					{

						if(!empty($agent_loginid) &&  ($agent_loginid == $agent_id)){
							$flag = "0";
							$disable='disabled';
							$dis_flag="true";
						}else{
							$flag = "2";
							$disable='disabled';
							$dis_flag="true";
						}
					
					}elseif ($this->session->userdata('logged_in_employee')) {
						$flag = "2";
						$disable="";
						$dis_flag="";
					}else{
						$flag = "0";
						$disable="";
						$dis_flag="";
					}
				}else{
					$flag = "0";
					$disable="";
					$dis_flag="";
				}
				if($flag == "0")
				{ ?>
                  <p class="title-text">Owner Detail</p>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="col-md-4 col-sm-4 control-label">First Name <span class="star">*</span> :</label>
                        <div class="col-md-8 col-sm-8 ">
                          <?php
							$fname = array(
								'name' => 'fname',
								'id' => 'fname',
								'value' => set_value('fname', $fname),
								'class' => 'form-control',
								$disable => $dis_flag,
							);
							echo form_input($fname);
							?>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-md-4 col-sm-4 control-label">Last Name <span class="star">*</span> :</label>
                        <div class="col-md-8 col-sm-8">
                        	<?php
								$lname = array(
									'name' => 'lname',
									'id' => 'lname',
									'value' => set_value('lname', $lname),
									'class' => 'form-control',
									$disable => $dis_flag,
								);
								echo form_input($lname);
							?>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-md-4 col-sm-4 control-label">Company Name :</label>
                        <div class="col-md-8 col-sm-8">
                        	<?php
								$com_name = array(
									'name' => 'cname',
									'id' => 'cname',
									'value' => set_value('cname', $compny_name),
									'class' => 'form-control',
									$disable => $dis_flag,
								);
								echo form_input($com_name);
							?>
                          </div>
                      </div>
                      <div class="form-group">
                        <label class="col-md-4 col-sm-4 control-label">Email :</label>
                        <div class="col-md-8 col-sm-8">
                        	<?php
								$email = array(
									'name' => 'email',
									'id' => 'email',
									'value' => set_value('email', $email),
									'class' => 'form-control',
									$disable => $dis_flag,
									//'onblur' => "customer_EmailFunction();"
								);
								echo form_input($email);
							?>	
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-md-4 col-sm-4 control-label">Mobile <span class="star">*</span> :</label>
                        <div class="col-sm-2 col-md-3">
                          <?php
							$country =$this->user->getall_countrycode();
									$selected = $county_code;

									if($selected =="0" || $selected==""){
										$selected = 24;
									}
									$device = 'id="county_code" class="form-control" '.$disable;
									echo form_dropdown('county_code', $country, $selected, $device);
									?>
                        </div>
                        <div class="visible-xs">&nbsp;</div>
                        <div class="col-sm-6 col-md-5">
                         <?php $contact = array(
								'name' => 'mobile_no',
								'id' => 'mobile_no',
								'value' => set_value('mobile_no', $contact),
								'class' => 'form-control',
								'maxlength' =>"10",
								$disable => $dis_flag,
								'onkeypress'=>'return numbersonly(event)'
							);
							echo form_input($contact);
							?>	
                          <small>(example: 97888555)</small>
                        </div>
                      </div>
                     </div>

                 </div><!-- /row -->
                  <hr>
                  <?php } ?>
                  <div class="row">
                  <div class="col-md-6">
                  	  <div class="form-group">
                        <label class="col-md-4 col-sm-4 control-label">Reference No <span class="star">*</span> :</label>
                        <div class="col-md-8 col-sm-8">
                          <?php
								$reference_no = array(
									'name' => 'reference_no',
									'id' => 'reference_no',
									'value' => set_value('reference_no', $reference_no),
									'class' => 'form-control',
								);
								echo form_input($reference_no);
							?>
                          
                        </div>
                      </div>
                      <!-- <div class="form-group">
                        <label class="col-md-4 col-sm-4 control-label">Address :</label>
                        <div class="col-md-8 col-sm-8">
                        	<textarea id="address" class="form-control" rows="3" name="address" value="<?php echo $address;?>"><?php echo $address; ?></textarea>
                        </div>
                      </div> -->
                      <div class="form-group">
                        <label class="col-md-4 col-sm-4 control-label">Agent <span class="star">*</span> :</label>
                        <div class="col-md-8 col-sm-8">
                        	<?php
								$citydata =$this->user->getAllAgent_name();
								$selected = $agent_id;

								if($selected == "" || $selected == 0){
										$selected = 0;
								}
								$device = 'id="agent_id" class="form-control"';
								echo form_dropdown('agent_id', $citydata, $selected, $device);
							?>
                        </div>
                      </div>
                     </div>
                    </div>
                  <hr>
                  <p class="title-text">Property Status</p>

                  <div class="row"><!-- row -->
                        <div class="col-md-6">
                            <div class="form-group">
                              <label class="col-md-4 col-sm-4 control-label">Type <span class="star">*</span> :</label>
                              <div class="col-md-8 col-sm-8">
                              	<?php
									$citydata = array('0' =>'Select Type','1'=>'Sale','2' =>'Rent','3' =>'Both');
								  	$selected = $type;
									if($selected == "" || $selected == 0){
											$selected = 0;
									}
									$device = 'onchange="hide_agresive_div();" id="type" class="form-control"';
									echo form_dropdown('type', $citydata, $selected, $device);
								?>
							  </div>

                            </div>
                        </div>
                        <div class="col-md-6">
                          <div id="rent_div">
                            <div class="form-group">
                              <label class="col-md-4 col-sm-4 control-label">Rent Price (&euro;) <span class="star">*</span> :</label>
                              <div class="col-md-8 col-sm-8">
                                  <?php
									$rent_price = array(
										'type' => 'text',
										'name' => 'rent_price',
										'id' => 'rent_price',
										'value' => set_value('rent_price', $rent_price),
										'class' => 'form-control',
										'onkeypress'=>'return numbersonly(event)',
									);
									echo form_input($rent_price);
									?>
                              </div>
                            </div>

                            <div class="form-group">
                              <label class="col-md-4 col-sm-4 control-label hidden-xs">&nbsp;</label>
                              <div class="col-md-8 col-sm-8">
                                  <?php
									$rent_val = array('id' => 'rent_val', 'name' => 'rent_val');
									if($rent_type=="0") {
									    $checked1 = 'checked="checked"';	
									    $checked2 = '';
									} elseif ($rent_type=="1") {
									    $checked1 = '';
									    $checked2 = 'checked="checked"';
									} else {
									    $checked1 = '';
									    $checked2 = 'checked="checked"';
									}
									?>
									<label class="radio-inline">
									<?php echo form_radio($rent_val, '1', $checked2, ''); ?>
									 incl. common expenses</label>
									<label class="radio-inline">
									<?php echo form_radio($rent_val, '0', $checked1, ''); ?>
									 Plus common expenses</label>
									
                                </div>
                            </div>
                           </div> 

                           <div  id="sale_div">
                            <div class="form-group">
                              <label class="col-md-4 col-sm-4 control-label">Selling Price (&euro;) <span class="star">*</span> :</label>
                              <div class="col-md-8 col-sm-8">
                              	<?php
									$sale_price = array(
										'type' => 'text',
										'name' => 'sale_price',
										'id' => 'sale_price',
										'value' => set_value('sale_price', $sale_price),
										'class' => 'form-control',
										'onkeypress'=>'return numbersonly(event)',
									);
									echo form_input($sale_price);
								?>
                                  
                              </div>
                            </div>

                            <div class="form-group">
                              <label class="col-md-4 col-sm-4 control-label hidden-xs">&nbsp;</label>
                              <div class="col-md-8 col-sm-8">
                                  <?php
									$sale_val = array('id' => 'sale_val', 'name' => 'sale_val');
									if($sale_type=="0") {
									    $checked1 = 'checked="checked"';	
									    $checked2 = '';
									} elseif ($sale_type=="1") {
									    $checked1 = '';
									    $checked2 = 'checked="checked"';
									} else {
									    $checked1 = '';
									    $checked2 = 'checked="checked"';
									}
									?>
									<label class="radio-inline">
									<?php echo form_radio($sale_val, '1', $checked2, ''); ?>
									  No V.A.T </label>
									<label class="radio-inline">
									<?php echo form_radio($sale_val, '0', $checked1, ''); ?>
									 Plus  V.A.T</label>
                                  </div>
                            </div>
                           </div>
                        </div>
                  </div><!-- /row -->

                  <hr>
                  <div id="check_box_agreement" >
                  <?php if($check_val =='1'){
					$checked='true';
				  }else{
					$checked='';
				  } ?>
                  <div class="row">
                    <div class="col-md-6">
                    		<div class="form-group">
                              <label class="col-md-4 col-sm-4 control-label hidden-xs">&nbsp;</label>
                              <div class="col-md-8 col-sm-8">
                                <div class="checkbox">
                                  <label>
                                  	<?php
										$data = array(
										    'name'        => 'checkbox1',
										    'id'          => 'checkbox1',
										    'value'       => 'accept',
										    'checked'     => $checked,
										    );

										echo form_checkbox($data);
									?>Title Deeds / Planning Permission / Building Permission <span class="star">*</span>
                                  </label>
                                </div>
                              </div>
                            </div>

                            <div class="form-group">
                              <label class="col-md-4 col-sm-4 control-label hidden-xs">&nbsp;</label>
                              <div class="col-md-8 col-sm-8">
                                <div class="checkbox">
                                  <label>
                                    <?php
										$data = array(
										    'name'        => 'checkbox2',
										    'id'          => 'checkbox2',
										    'value'       => 'accept',
										    'checked'     => $checked,
										    );
										echo form_checkbox($data);
										?>Signed Commission Agreement <span class="star">*</span>
                                  </label>
                                </div>
                              </div>
                            </div>
                        </div>
                  </div><!-- /row -->
                  <hr>
                </div>

                  <input type='hidden' name="city_ar_id" id="city_ar_id" value="<?php echo $city_area ?>">
                  <p class="title-text">Property Area</p>
                  <div class="row">

                    <div class="col-md-6">
                        <div class="form-group">
                          <label class="col-md-4 col-sm-4 control-label">Country <span class="star">*</span> :</label>
                          <div class="col-md-8 col-sm-8">
                              <?php
								$countrydata =array(0 => 'Select country',1 => 'Cyprus');
								
								$selected = $country_id;
								if($selected == "" || $selected == 0){
										$selected = 0;
								}
								$device = 'id="country_id" class="form-control"';
								echo form_dropdown('country_id', $countrydata, $selected, $device);
							?>
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="col-md-4 col-sm-4 control-label">City <span class="star">*</span> :</label>
                          <div class="col-md-8 col-sm-8">
                              <?php
								$citydata =$this->user->getallcity();
								$selected = $city_id;
								if($selected == "" || $selected == 0){
										$selected = 0;
								}
								$device = 'onchange="get_city_area();" id="city_id" class="form-control"';
								echo form_dropdown('city_id', $citydata, $selected, $device);
							?>
                             
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="col-md-4 col-sm-4 control-label">City area <span class="star">*</span> :</label>
                          <div class="col-md-8 col-sm-8">
                              <?php
								$city_area_rec = array( '0'=>'Select city area');//$this->user->getallcity_area();
						 		$selected = $city_area;
								// if($selected == "" || $selected == 0){
								// 		$selected = 0;
								// }
								$device = 'id="city_area_id" class="form-control"';
								echo form_dropdown('city_area_id',$city_area_rec, $selected, $device);
							?>
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-md-4 col-sm-4 control-label">Address <span class="star">*</span> :</label>
                          <div class="col-md-8 col-sm-8">
                              <textarea id="address" class="form-control" rows="3" name="address" value="<?php echo $address;?>"><?php echo $address; ?></textarea>
                          </div>
                        </div>

                    </div>

                    <div class="col-md-6">
                        <input type="text" name="search_address" id="search_address" value="<?php echo (empty($map_address)) ? 'limassol, cyprus' :$map_address ?>">
						<input type="hidden" id="lat_lon" name="lat_lon">
						
						<div class="data" id="map_canvas" style="width: 100%; height: 400px">
						</div>	
                    </div>

                  </div><!-- /row -->

                  <hr>
                  <p class="title-text">Property Type</p>
                  <div class="row">

                    <div class="col-md-6">
                        <div class="form-group">
                          <label class="col-md-4 col-sm-4 control-label">Property Type <span class="star">*</span> :</label>
                          <div class="col-md-8 col-sm-8">
                              <?php
								$property_category = array('0' =>' Select Property Category','1'=>'Duplex','2' =>'Apartment','3' =>'Penthouse','4' =>'Garden Apartments','5'=>'Studio','6' =>'Townhouse','7' =>'Villa','8' =>'Bungalow','9'=>'Land','10' =>'Shop','11' =>'Office','12' =>'Business','13'=>'Hotel','14' =>'Restaurant','15' =>'Building','16' =>'Industrial estate','17' =>'House','18' =>'Upper-House','19' =>'Maisonette');
								asort($property_category);
								$selected = $property_type;
								if($selected == "" || $selected == 0){
										$selected = 0;
								}
								$device = 'id="property_category" class="form-control"';
								echo form_dropdown('property_category', $property_category, $selected, $device);
							?>
                          </div>
                        </div>
                    </div>

                    <div class="col-md-6">

                        <div class="form-group">
                          <label class="col-md-4 col-sm-4 control-label">Covered area (m&sup2;):</label>
                          <div class="col-md-8 col-sm-8">
                          	<?php
							$cover_area = array(
								'type' => 'text',
								'name' => 'cover_area',
								'id' => 'cover_area',
								'value' => set_value('cover_area', $cover_area_size),
								'class' => 'form-control',
								'onkeypress'=>'return numbersonly(event)',
							); 
							echo form_input($cover_area);
							?>
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="col-md-4 col-sm-4 control-label">Un-covered area (m&sup2;):</label>
                          <div class="col-md-8 col-sm-8">
                           <?php
							$uncover_area = array(
								'type' => 'text',
								'name' => 'uncover_area',
								'id' => 'uncover_area',
								'value' => set_value('uncover_area', $uncover_area_size),
								'class' => 'form-control',
								'onkeypress'=>'return numbersonly(event)',
							); 
							echo form_input($uncover_area);
						?>
                         </div>
                       </div>

                        <div class="form-group">
                          <label class="col-md-4 col-sm-4 control-label">Land/Plot area (m&sup2;):</label>
                          <div class="col-md-8 col-sm-8">
                          	<?php
							$plot_land_area = array(
								'type' => 'text',
								'name' => 'plot_land_area',
								'id' => 'plot_land_area',
								'value' => set_value('plot_land_area', $plot_lan_area_size),
								'class' => 'form-control',
								'onkeypress'=>'return numbersonly(event)',
							); 
							echo form_input($plot_land_area);
						?>
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="col-md-4 col-sm-4 control-label">Bedroom(s) <span class="star">*</span> :</label>
                          <div class="col-md-8 col-sm-8">
                          	<?php
							$bedroom_val = array(
								'type' => 'text',
								'name' => 'bedrooms',
								'id' => 'bedrooms',
								'value' => set_value('bedrooms', $bedroom),
								'class' => 'form-control',
								//'onkeypress'=>'return numbersonly(event)',
							); 
							echo form_input($bedroom_val);
							?>
                              
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="col-md-4 col-sm-4 control-label">Bathroom(s) <span class="star">*</span>:</label>
                          <div class="col-md-8 col-sm-8">
                          	<?php
								$citydata = array('0' =>'Select Bathrooms','1'=>'1','2' =>'2','3' =>'3','4' =>'4','5' =>'5','6' =>'6','7' =>'7');
								$selected = $bathroom;
								if($selected == "" || $selected == 0){
										$selected = 0;
								}
								$device = 'id="bathrooms" class="form-control"';
								echo form_dropdown('bathrooms', $citydata, $selected, $device);
							?>
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="col-md-4 col-sm-4 control-label">Kitchen(s):</label>
                          <div class="col-md-8 col-sm-8">
                              <?php
								$kitchen_list = $this->config->item("kitchen_list");
								$selected = $Kitchen;
								if($selected == "" || $selected == 0){
										$selected = 0;
								}
								$device = 'id="Kitchen_id" class="form-control"';
								echo form_dropdown('Kitchen_id', $kitchen_list, $selected, $device);
							  ?>
                          </div>
                        </div>
                        <div class="sep"></div>
                    </div>

                  </div><!-- /row -->

                  <hr>
                  <p class="title-text">Property Facilities</p>
                  <div class="row">

                    <div class="col-md-6">
                       <div class="form-group">
                          <label class="col-md-4 col-sm-4 control-label">Furnished Type <span class="star">*</span> :</label>
                          <div class="col-md-8 col-sm-8">
                            <?php
								$citydata = array('0' =>'Select Furmished Type','1'=>'Furnished','2' =>'Semi-Furnished','3' =>'Un-Furnished');
								$selected = $furnished_type;
								if($selected == "" || $selected == 0){
										$selected = 0;
								}
								$device = 'id="furnished_type" class="form-control" ';
								echo form_dropdown('furnished_type', $citydata, $selected, $device);
							?>
                          </div>
                        </div>
                    </div>

                  </div><!-- /row -->

                  <div class="row">

                      <label class="col-md-2 col-sm-4 control-label">Select Facilities :</label>
                      <div class="col-md-8 col-sm-8">
                        <div class="row">
                          <div class="col-md-6 col-sm-12">
                              <div class="fild">
                                <div class="scroll-box">
                                   
                                    	<?php
											$all_genral_facility = $this->inquiry_model->get_genral_facility();
											//$facility_id= array_map($facility_id,"facility_id");
											 $facility_id = array_map(function ($value) {
				    							return  $value['facility_id'];
				 							},$facility_id);
											foreach ($all_genral_facility as $key => $value) {
												if(in_array($key, $facility_id)){
												$selected = "checked";		
												}else{
												$selected = "";	
												}
											?>
											 <div class="checkbox" >
											 <label>
											 <input type="checkbox" id="" <?php echo $selected; ?> name="genral_facility[]" value="<?php echo $key; ?>"><?php echo $value; ?><br>
											</label>
											</div>
											<?php }?>
                                      
                                </div>
                              </div>
                          </div>
                          <div class="col-md-6 col-sm-12">
                              <div class="fild ">
                                <div class="scroll-box">
                                      <?php $all_instrumental_facility = $this->inquiry_model->get_instrumental_facility();
										foreach ($all_instrumental_facility as $key1 => $value1) {
										if(in_array($key1, $facility_id)){
											$selected1 = "checked";		
											}else{
											$selected1 = "";	
											}
										?>
										<div class="checkbox">
										<label>
										 <input type="checkbox" id="" <?php echo $selected1; ?> name="instrumental_facility[]" value="<?php echo $key1; ?>"><?php echo $value1; ?><br>
										</label>
										</div>
										<?php }?>
                                      
                                </div>
                              </div>
                          </div>
                        </div>
                      </div>

                  </div><!-- /row -->

                  <div class="row">

                    <div class="col-md-6">
                       <div class="form-group">
                          <label class="col-md-4 col-sm-4 control-label">Building Year of Make :</label>
                          <div class="col-md-8 col-sm-8">
                          	<?php
								$year = array(
									'name' => 'make_year',
									'id' => 'make_year',
									'value' => set_value('lname', $make_year),
									'class' => 'form-control',
									'onkeypress'=>'return numbersonly(event)'
									
								);
								echo form_input($year);
							?>
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="col-md-4 col-sm-4 control-label">Un-Covered Parking(s) :</label>
                          <div class="col-md-8 col-sm-8">
                              <?php
								$uncover_parking = array('0' =>'Please Select','1'=>'1','2' =>'2','3' =>'3','4' =>'4','5' =>'5');
								$selected = $uncover_parking_id;
								if($selected == "" || $selected == 0){
										$selected = 0;
								}
								$device = 'id="uncover_parking" class="form-control" ';
								echo form_dropdown('uncover_parking', $uncover_parking, $selected, $device);
								?>
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="col-md-4 col-sm-4 control-label">Covered Parking(s) :</label>
                          <div class="col-md-8 col-sm-8">
                              <?php
									$cover_parking = array('0' =>'Please Select','1'=>'1','2' =>'2','3' =>'3','4' =>'4','5' =>'5');
									$selected = $cover_parking_id;
									if($selected == "" || $selected == 0){
											$selected = 0;
									}
									$device = 'id="cover_parking" class="form-control" ';
									echo form_dropdown('cover_parking', $cover_parking, $selected, $device);
								?>
                          </div>
                        </div>

                    </div>

                  </div><!-- /row -->

                  <hr>
                  <div class="row">

                    <div class="col-md-12">
                        <div class="form-group">
                          <label class="col-md-2 col-sm-4 control-label">Architectural Design:</label>
                          <div class="col-md-8 col-sm-8">
                          <?php
							$architectural_design_id = array('id' => 'architectural_design_id', 'name' => 'architectural_design_id');
							if($architectural_design=="1") {
							    $checked1 = 'checked="checked"';	
							    $checked2 = '';
							    $checked3 = '';
							} elseif ($architectural_design=="2") {
							    $checked1 = '';
							    $checked2 = 'checked="checked"';
							    $checked3 = '';
							} elseif ($architectural_design=="3") {
							    $checked1 = '';
							    $checked2 = '';
							    $checked3 = 'checked="checked"';
							}else{
								$checked1 = 'checked="checked"';
							    $checked2 = '';
							    $checked3 = '';
							}
							?>
							<label class="radio-inline">
							<?php echo form_radio($architectural_design_id, '1', $checked1, ''); ?>
							 Contemporary </label>
							 <label class="radio-inline">
							<?php echo form_radio($architectural_design_id, '2', $checked2, ''); ?>
							 Modern </label>
							 <label class="radio-inline">
							 <?php echo form_radio($architectural_design_id, '3', $checked3, ''); ?>
							 Classic </label>
                          </div>
                        </div>
                    </div>
                  </div><!-- /row -->

                  <hr>
                  <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                          <label class="col-md-2 col-sm-4 control-label">Size of Rooms :</label>
                          <div class="col-md-8 col-sm-8">
                          	<?php
							$room_size_id = array('id' => 'room_size_id', 'name' => 'room_size_id');
							if($room_size=="1") {
							    $checked1 = 'checked="checked"';	
							    $checked2 = '';
							    $checked3 = '';
							} elseif ($room_size=="2") {
							    $checked1 = '';
							    $checked2 = 'checked="checked"';
							    $checked3 = '';
							} elseif ($room_size=="3") {
							    $checked1 = '';
							    $checked2 = '';
							    $checked3 = 'checked="checked"';
							}else{
								$checked1 = 'checked="checked"';
							    $checked2 = '';
							    $checked3 = '';
							}
							?>
							 <label class="radio-inline">
							<?php echo form_radio($room_size_id, '1', $checked1, ''); ?>
							 Small </label>
							 <label class="radio-inline">
							<?php echo form_radio($room_size_id, '2', $checked2, ''); ?>
							 Medium </label>
							 <label class="radio-inline">
							 <?php echo form_radio($room_size_id, '3', $checked3, ''); ?>
							 Large</label>
                          </div>
                        </div>
                    </div>
                  </div><!-- /row -->

                  <hr>
                  <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                          <label class="col-md-2 col-sm-4 control-label">Pets :</label>
                          <div class="col-md-8 col-sm-8">
                          <?php
							$pets_id = array('id' => 'pets_id', 'name' => 'pets_id');
							if($pets=="0") {
							    $checked1 = 'checked="checked"';	
							    $checked2 = '';
							} elseif ($pets=="1") {
							    $checked1 = '';
							    $checked2 = 'checked="checked"';
							    
							} else{
								$checked1 = 'checked="checked"';
							    $checked2 = '';
							    
							}
							?>
							<label class="radio-inline">
							<?php echo form_radio($pets_id, '0', $checked1, 'class="radio_buttons required"'); ?>
							 Allowed  </label>
							 <label class="radio-inline">
							<?php echo form_radio($pets_id, '1', $checked2, 'class="radio_buttons required"'); ?>
							 Not Allowed </label>
                          </div>
                        </div>
                    </div>
                  </div><!-- /row -->

                  <hr>
                  <div class="row">

                    <div class="col-md-6">
                       <div class="form-group">
                          <label class="col-md-4 col-sm-4 control-label">URL Link(1) <span class="star">*</span> :</label>
                          <div class="col-md-8 col-sm-8">
                          	<?php
								$link = array(
									'name' => 'link_url',
									'id' => 'link_url',
									'value' => set_value('link_url', $link_url),
									'class' => 'form-control',
									'onkeypress'=>'return spance_remove(event)'
								);
								echo form_input($link);
							?>
                            
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="col-md-4 col-sm-4 control-label">URL Link(2) :</label>
                          <div class="col-md-8 col-sm-8">
                              <?php
								$link1 = array(
									'name' => 'link_url1',
									'id' => 'link_url1',
									'value' => set_value('link_url1', $link_url1),
									'class' => 'form-control',
									'onkeypress'=>'return spance_remove(event)'
								);
								echo form_input($link1);
							  ?>
                             
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="col-md-4 col-sm-4 control-label">URL Link(3) :</label>
                          <div class="col-md-8 col-sm-8">
                              <?php
									$link2 = array(
										'name' => 'link_url2',
										'id' => 'link_url2',
										'value' => set_value('link_url2', $link_url2),
										'class' => 'form-control',
										'onkeypress'=>'return spance_remove(event)'
									);
									echo form_input($link2);
								?>
                              
                          </div>
                        </div>

                        

                        <!-- <div class="form-group">
                          <label class="col-md-4 col-sm-4 control-label">Primary Image :</label>
                          <div class="col-md-8 col-sm-8">
                          	<input type="file" name="image" id="image" class="file"></br></br>
                              <p class="help-block"><small class="text-danger">The recommended size should be 350px X 350px</small></p>
                              
                          </div>
                        </div> -->

                        <!--set code remaining start-->
                        <?php 
							/*if(!empty($image)){
							if (isset($user[0])) {
							    echo form_hidden('old_img', $image);
							?>
							<div id="modal-gallery" class="modal modal-gallery hide fade">
							<div class="modal-header"><a class="close" data-dismiss="modal">&times;</a><h3 class="modal-title">Image Gallery</h3>
							</div>
							<div class="modal-body">
							<div class="modal-image">
							</div>
							</div>
							</div>
							 <div class="form-group">
	                          <label class="col-md-4 col-sm-4 control-label"></label>
	                          <div class="col-md-8 col-sm-8">
	                          	<div id="gallery" data-toggle="" data-target=""><a><img src="<?php echo base_url().'upload/property/100x100/'.$image; ?>" width="100" height="100"></a>
								</div>
							  </div>
	                        </div>
							<?php
								}
							}else{
								echo form_hidden('old_img', "noimage.jpg");
							?>
							 <div class="form-group">
	                          <label class="col-md-4 col-sm-4 control-label"></label>
	                          <div class="col-md-8 col-sm-8">
	                          	<div id="gallery" data-toggle="" data-target=""><a><img src="<?php echo base_url().'upload/property/100x100/noimage.jpg'.$image; ?>" width="100" height="100"></a>
							</div>  
	                          </div>
	                        </div>*/
							
							  //} ?>
							<!--set code remaining end-->

                    </div>

                  </div><!-- /row -->
                
                <!--edit by kaushik -->
                  <hr>
                  <?php 
                  if(isset($id) && !empty($id)){ ?>
                  <div id="drop-area">
							<h3 class="drop-text">Drag and Drop Images Here</h3>
							<input type="file" multiple name="uploadButton" id="uploadButton" />
				  </div>
						</br></br>
						<label style="color:red;">The recommended size should be 350px X 350px</label>
					<?php 
						if(isset($prop_img)){
					?>
					<div id="save_reorder_top"  style="margin-top:10px;">
						<!--<a href="javascript:void(0);" class="btn outlined mleft_no reorder_link" id="save_reorder">reorder photos</a>-->
					    <!--<div id="reorder-helper" class="light_box" style="display:none;">
				    	</div>-->
					    <div class="gallery">
					        <ul id="gallery_area" class="reorder_ul reorder-photos-list">
					        <?php 
								//Fetch all images from database
								//$rows = $db->getRows();
								foreach($prop_img as $propimg_key=> $propimg_value): 
										//echo "<pre>";print_r($propimg_value->id);exit;
									?>
					            <li id="image_li_<?php echo $propimg_value->id; ?>" class="ui-sortable-handle"><div style="color:red" onclick="delete_propimage('<?php echo $propimg_value->id; ?>','<?php echo $propimg_value->image; ?>')"><b>X</b></div>
					            		<img src="<?php echo base_url().'img_prop/'.$propimg_value->image; ?>" alt="">
					            	</a>
					           	</li>
					        <?php endforeach; ?>
					        </ul>
					    </div>
					</div>
					<?php 
					}
					?>

                  <?php 
                   }else{ ?>
                   		<div id="drop-area_add">		
                   			<div id="drop-area_add">
								<h3 class="drop-text">Drag and Drop Images Here</h3>		
								
								<input type="file" multiple name="uploadButton" id="uploadButton" />	
								
							</div>
						</div>
						</br></br>		</br></br>
						<label style="color:red;">The recommended size should be 350px X 350px</label>		<label style="color:red;">The recommended size should be 350px X 350px</label>
			
						<div id="save_reorder_top" style="margin-top:50px;">		
						<!--<a href="javascript:void(0);" class="btn outlined mleft_no reorder_link" id="save_reorder">reorder photos</a>-->
						<!--<div id="reorder-helper" class="light_box" style="display:none;">		
						</div>-->		
						<div class="gallery">		
						<ul id="gallery_area" class="reorder_ul reorder-photos-list">		
								
						</ul>		
						</div>		
						</div>
                   <?php }
                  ?>                  
					<!--edit by kaushik-->
                  <hr>

                  <p class="title-text">Property Distance in Km</p>
                  <div class="row">

                    <div class="col-md-6">
                       <div class="form-group">
                          <label class="col-md-4 col-sm-4 control-label">From Supermarket :</label>
                          <div class="col-md-8 col-sm-8">
                              <input name="from_supermarket" id="from_supermarket" value="<?php echo $from_supermarket ?>" type="text" class="form-control" />
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="col-md-4 col-sm-4 control-label">From Bus Station :</label>
                          <div class="col-md-8 col-sm-8">
                              <input name="from_bus_station" id="from_bus_station" value="<?php echo $from_bus_station ?>" type="text" class="form-control" />
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="col-md-4 col-sm-4 control-label">From School :</label>
                          <div class="col-md-8 col-sm-8">
                          	<input name="from_school" id="from_school" value="<?php echo $from_school ?>" type="text" class="form-control" />
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="col-md-4 col-sm-4 control-label">From High-Way :</label>
                          <div class="col-md-8 col-sm-8">
                          	<input name="from_high_way" id="from_high_way" value="<?php echo $from_high_way ?>" type="text" class="form-control" />
                          </div>
                        </div>
                    <!-- </div>

                    <div class="col-md-6"> -->
                        <div class="form-group">
                          <label class="col-md-4 col-sm-4 control-label">From Playground :</label>
                          <div class="col-md-8 col-sm-8">
                          	<input name="from_playground" id="from_playground" value="<?php echo $from_playground ?>" type="text" class="form-control" />
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="col-md-4 col-sm-4 control-label">From Sea :</label>
                          <div class="col-md-8 col-sm-8">
                          	<input name="from_sea" id="from_sea" value="<?php echo $from_sea ?>" type="text" class="form-control" />
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="col-md-4 col-sm-4 control-label">From Cafeteria :</label>
                          <div class="col-md-8 col-sm-8">
                          	<input name="from_cafeteria" id="from_cafeteria" value="<?php echo $from_cafeteria ?>" type="text" class="form-control" />	
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="col-md-4 col-sm-4 control-label">From Restaurant :</label>
                          <div class="col-md-8 col-sm-8">
                              <input name="from_restaurant" id="from_restaurant" value="<?php echo $from_restaurent ?>" type="text" class="form-control" />
                          </div>
                        </div>

                    </div>

                  </div><!-- /row -->

                  <hr>
                  <p class="title-text">Property Description</p>
                  <div class="row">

                      <div class="col-md-12">
                         <div class="form-group">
                            <label class="col-md-2 col-sm-4 hidden-xs control-label">Property Description :</label>
                            <div class="col-md-10 col-sm-8">
                            	<textarea id="short_desc" class="form-control ckeditor" rows="3" name="short_desc" value="<?php echo $short_decs;?>"><?php echo $short_decs;?></textarea>
                            </div>
                          </div>
                      </div>
                   </div><!-- /row -->


                   <hr>
                  <p class="title-text">Property Status</p>
                  <div class="row">

                      <div class="col-md-12">
                         <div class="form-group">
                            <label class="col-md-2 col-sm-4 col-xs-3 hidden-xs control-label">Property Status :</label>
                            <div class="col-md-10 col-sm-8 col-xs-12">
                            	<?php
									$status = array('id' => 'status', 'name' => 'status');
									if($this->input->post('status')=="Inactive" || $status_name=="Inactive") {
									    $checked1 = 'checked="checked"';	
									    $checked2 = '';
									} elseif ($this->input->post('status')=="Active" || $status_name=="Active") {
									    $checked1 = '';
									    $checked2 = 'checked="checked"';
									} else {
									    $checked1 = '';
									    $checked2 = 'checked="checked"';
									}
									?>
									<label class="radio-inline">
									<?php echo form_radio($status, 'Active', $checked2, 'class="radio_buttons required"'); ?>
									Active</label>
									<label class="radio-inline">
									<?php echo form_radio($status, 'Inactive', $checked1, 'class="radio_buttons required"'); ?>
									Inactive</label>
                            	</div>
                          	</div>
                      	</div>
                   	</div><!-- /row -->


                  <hr>

                  <div class="form-group">
                    <label class="col-md-1 col-sm-2 control-label">&nbsp;</label>
                    <div class="col-sm-6">
                    	<?php
							if ($id=="") {
								echo form_submit('pro_add', 'Add Property', "class='btn btn-sm btn-primary'");?>&nbsp;&nbsp;<?php
								//echo form_submit('pro_add', 'Add Property With Extra images', "class='btn'");
							} else { 
								echo form_submit('pro_up', 'Update Property', "class='btn btn-sm btn-primary'");?>&nbsp;&nbsp;<?php
								//echo form_submit('pro_up', 'Update Property With Extra images', "class='btn'");
							}
						?>&nbsp;&nbsp;
						<?php echo anchor('home/property_manage', 'Cancel', array('title' => 'Cancel', 'class' => 'btn btn-sm btn-default')); ?>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=false"></script>
<?php
$this->load->view('footer');
?>

<script src="//cdn.ckeditor.com/4.4.7/full/ckeditor.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/property.js"></script>
<script>

function hide_agresive_div(){
if($("#type").val() =='1'){
$("#check_box_agreement").show();
$("#rent_div").hide();
$('#rent_price').val('');
$("#sale_div").show();
}else if($("#type").val() =='2'){
	$("#check_box_agreement").hide();
	$("#sale_div").hide();
	$('#sale_price').val('');
	$("#rent_div").show();
}else{
	$("#check_box_agreement").show();
	$("#sale_div").show('');
	$("#rent_div").show();
}
}
function numbersonly(e){ 	 
    var unicode=e.charCode? e.charCode : e.keyCode;    
    
    if (unicode!=8){ //if the key isn't the backspace key (which we should allow)
    
        if ((unicode<48||unicode>57) && unicode!=46 ) //if not a number
            return false //disable key press
    }
}
function spance_remove(e){ 	 
    var unicode=e.charCode? e.charCode : e.keyCode;    
        if (unicode == 32) //if not a number
            return false //disable key press
        
}
       $(document).ready(function () {
        	var map;
        	var markers = [];
			var addressField;
			var geocoder;
		 hide_agresive_div();
         		//$("#link_url").cleditor({width:300});
        		//$("#short_desc").cleditor({width:300}); 
        		
        		// $('.multiselect').multipleSelect({
          //                      filter: true,
          //                  });
        		// $('.multiselect').multipleSelect({
          //                      filter: true,
          //                  });
        		//  	//var geocoder = new google.maps.Geocoder();
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
					   addMarker(myLatlng,address);
					   //  var marker = new google.maps.Marker({
				    //     position: myLatlng, 
				    //     map: map,
				    //     title:address
				    // });

					    // Define Gecoder
					    geocoder = new google.maps.Geocoder();

					    // Init searchbox
					    initSearchBox();
					  	}				
					 });
        	// Adds a marker to the map and push to the array.
			function addMarker(location,address) {

			  var marker = new google.maps.Marker({
			    position: location,
			    map: map,
			    title:address
			  });
			  markers.push(marker);
			}

			// Sets the map on all markers in the array.
			function setMapOnAll(map) {
			  for (var i = 0; i < markers.length; i++) {
			    markers[i].setMap(map);
			  }
			}

			// Removes the markers from the map, but keeps them in the array.
			function clearMarkers() {
			  setMapOnAll(null);
			}

			// Shows any markers currently in the array.
			function showMarkers() {
			  setMapOnAll(map);
			}

			// Deletes all markers in the array by removing references to them.
			function deleteMarkers() {
			  clearMarkers();
			  markers = [];
			}	

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
			                         deleteMarkers();
			                         
			                         //marker.setMap(null);
			         //                 var marker = new google.maps.Marker({
								    //     position: latlng, 
								    //     map: map,
								    //     title:address
								    // });
			                        geocoder.geocode({
			                            'latLng': latlng
			                        }, function (results1, status1) {
			                            if (status1 == google.maps.GeocoderStatus.OK) {
			                                if (results1[1]) {
			                                    response($.map(results1, function (loc) {
			                                    	
			                         				addMarker(latlng,loc.formatted_address);
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
			$('#city_area_id,#city_id,#country_id').on('change',function(){

				var city_area=$('#city_area_id option:selected').text();
				var city=$('#city_id option:selected').text();
				var country=$('#country_id option:selected').text();
				if(country=='Select country'){
					var country ="";
				}
				if(city=="Select City"){
					var city="";
				}
				if(city_area=="Select city area"){
					var city_area="";
				}else if(city_area.trim()=='City Center'){
					var city_area="Limassol Kalogries";
				}else if(city_area.trim()=='Agios Ioannis'){
					var city_area="Agios Ioannis Police Station, Giannoulli Chalepa, Limassol, Cyprus";
				}
				var address = city_area+' '+city+' '+country;	
				
				
				$('#search_address').val(address);
        	$.ajax({
					  url:"http://maps.googleapis.com/maps/api/geocode/json?address="+address+"&sensor=false",
					  type: "POST",
					  success:function(res){
					     latitude=res.results[0].geometry.location.lat;
					     longitude=res.results[0].geometry.location.lng;
					     
					     $('#lat_lon').val(latitude+','+longitude);
					     var myLatlng = new google.maps.LatLng(latitude,longitude);
					      deleteMarkers();
					      addMarker(myLatlng,address);
					    //  setMapOnAll(null);
  						 // marker = [];
  						
					    // var marker = new google.maps.Marker({
         //    			position: myLatlng,
         //   				map: map,
           				
        	// 			});
        				 
 						 map.setCenter(new google.maps.LatLng(latitude, longitude));
					  	}

					 });

			  			
			});
		});

</script>

<script type="text/javascript">
$(document).ready(function(){
	//$('.reorder_link').on('click',function(){

		$("ul.reorder-photos-list").sortable({ tolerance: 'pointer' });
		//$('.reorder_link').html('save reordering');
		$('.reorder_link').attr("id","save_reorder");
		$('#reorder-helper').slideDown('slow');
		$('.image_link').attr("href","javascript:void(0);");
		$('.image_link').css("cursor","move");
		$("#save_reorder").click(function( e ){
			if( !$("#save_reorder i").length )
			{
				//$(this).html('').prepend('<img src="images/refresh-animated.gif"/>');
				//$("ul.reorder-photos-list").sortable('destroy');
				//$("#reorder-helper").html( "Reordering Photos - This could take a moment. Please don't navigate away from this page." ).removeClass('light_box').addClass('notice notice_error');
				var h = [];
				//var myarr = $(this).attr('id').split("_");
				//console.log(myarr);
				$("ul.reorder-photos-list li").each(function() { 
					 var myarr = $(this).attr('id').split("_");
					 h.push(myarr[2]);  
				});
				
				if($('#property_id').val() != 'NULL' && $('#property_id').val().length != 0){
					$.ajax({
						type: "POST",
						//url: baseurl+"order_update.php",
						url: baseurl+"home/order_update",
						data: {ids: " " + h + "", "prop_id": $('#property_id').val()},
						success: function(html) 
						{
							//window.location.reload();
							/*$("#reorder-helper").html( "Reorder Completed - Image reorder have been successfully completed. Please reload the page for testing the reorder." ).removeClass('light_box').addClass('notice notice_success');
							$('.reorder_link').html('reorder photos');
							$('.reorder_link').attr("id","");*/
						}
					});	
				}else{
					$.ajax({
						type: "POST",
						//url: baseurl+"order_update.php",
						url: baseurl+"home/propadd_order_update",
						data: {ids: " " + h + ""},
						success: function(html) 
						{

							//window.location.reload();
							/*$("#reorder-helper").html( "Reorder Completed - Image reorder have been successfully completed. Please reload the page for testing the reorder." ).removeClass('light_box').addClass('notice notice_success');
							$('.reorder_link').html('reorder photos');
							$('.reorder_link').attr("id","");*/
						}
					});
				}


				
				return false;
			}	
			e.preventDefault();		
		});
	//});


	$("#drop-area").on('dragenter', function (e){
	e.preventDefault();
	$(this).css('background', '#BBD5B8');
	});

	$("#drop-area").on('dragover', function (e){
	e.preventDefault();
	});

	$("#drop-area").on('drop', function (e){
	$(this).css('background', '#D8F9D3');
	e.preventDefault();
	var image = e.originalEvent.dataTransfer.files;
	createFormData(image);
	});


$("#drop-area_add").on('dragenter', function (e){
	e.preventDefault();
	$(this).css('background', '#BBD5B8');
	});

	$("#drop-area_add").on('dragover', function (e){
	e.preventDefault();
	});

	$("#drop-area_add").on('drop', function (e){
	$(this).css('background', '#D8F9D3');
	e.preventDefault();
	var image = e.originalEvent.dataTransfer.files;
	
	createFormData(image);
	});



	//$("#uploadButton").change(function(e) {
		
		//var formData = new FormData();
		//formData.append('file', $('input[type=file]')[0].files[0]);
		//var postData = new FormData(this);
   		//var fd = new FormData(document.getElementById("uploadButton"));
 		//$('#manage_form').submit();

	/*$.ajax({
		url: baseurl+"update.php",
		type: "POST",
		data: $('#manage_form').serialize(),
		enctype: 'multipart/form-data',
		//cache: false,
		//processData: false,
		success: function(data){
			return false;
			//var obj = jQuery.parseJSON(data);
			
			for (i = 0; i < obj.length; i++) {
	    		$('#gallery_area').append("<li class='ui-sortable-handle' id='image_li_"+obj[i].id+"'><img alt='' src='"+obj[i].img_name+"'></li>");
			}
		}
	});*/

	
	//});

document.querySelector('#uploadButton').addEventListener('change', function(e) {


	if($('#property_id').val() != 'NULL' && $('#property_id').val().length != 0){
		var url = baseurl+'home/insert_image';
	}else{
		var url = baseurl+'home/insertproperty_image';
	}

	var fd = new FormData();
	for (i = 0; i < this.files.length; i++) {
		fd.append('userImage['+i+']', this.files[i]);  
		//fileaddd[i] = this.files[i];
	}

  //var file = this.files[0];
  //var fd = new FormData();
  //fd.append("afile", file);
  fd.append("prop_id", $('#property_id').val());
  // These extra params aren't necessary but show that you can include other data.
  fd.append("action", "single_fileupload");
  var xhr = new XMLHttpRequest();
  xhr.open('POST', url, true);
  
  xhr.upload.onprogress = function(e) {
    if (e.lengthComputable) {
      var percentComplete = (e.loaded / e.total) * 100;
      console.log(percentComplete + '% uploaded');
    }
  };
  xhr.onload = function() {
    if (this.status == 200) {
      var obj = JSON.parse(this.response);
      //console.log('Server got:', resp);
      //var image = document.createElement('img');
      //image.src = resp.dataUrl;
      //document.body.appendChild(image);
     // var obj = jQuery.parseJSON(data);
     var propimg_str = $('#property_imageid').val();
		for (i = 0; i < obj.length; i++) {
			if (obj[i].id == "-1") {
				alert("Please You Only Upload Image File.");
			}else{
				$('#gallery_area').append("<li class='ui-sortable-handle' id='image_li_"+obj[i].id+"'><div onclick=delete_propimage('"+obj[i].id+"','"+obj[i].img_name+"') style='color:red'><b>X</b></div><img alt='' src='"+baseurl+"img_prop/"+obj[i].img_name+"'></li>");
				
				if($('#property_id').val() != 'NULL' && $('#property_id').val().length != 0){
					
				}else{
					propimg_str = obj[i].img_name+","+propimg_str;
				}			
			}
		}
		$('#property_imageid').val(propimg_str);
    };
  };
  xhr.send(fd);
}, false);


});

function createFormData(image) {
	var formImage = new FormData();

	for (i = 0; i < image.length; i++) {
		formImage.append('userImage['+i+']', image[i]);    		
	}

	formImage.append('prop_id', $('#property_id').val());

	//alert($('#property_id').val());return false;

	formImage.append('action', "multiple_fileupload");

	if($('#property_id').val() != 'NULL' && $('#property_id').val().length != 0){
		uploadFormData(formImage);
	}else{
		uploadFormData_insform(formImage);
	}
	//uploadFormData(formImage);
}
function uploadFormData_insform(formData) {
	$.ajax({
		//url: baseurl+"update.php",
		url: baseurl+"home/uploadFormData_insform",
		type: "POST",
		data: formData,
		contentType:false,
		cache: false,
		processData: false,
		success: function(data){
			//var propimg_str = "";
			var propimg_str = $('#property_imageid').val();
			var obj = jQuery.parseJSON(data);
			for (i = 0; i < obj.length; i++) {
				if (obj[i].id == "-1") {
					alert("Please You Only Upload Image File.");
				}else{
	    			$('#gallery_area').append("<li class='ui-sortable-handle' id='image_li_"+obj[i].id+"'><div onclick=delete_propimage('"+obj[i].id+"','"+obj[i].img_name+"') style='color:red'><b>X</b></div><img alt='' src='"+baseurl+"img_prop/"+obj[i].img_name+"'></li>");
					
	    			propimg_str = obj[i].img_name+","+propimg_str;
				}
			}

			$('#property_imageid').val(propimg_str);
			//alert(obj.id);
			//console.log(data);
			//return false;
			//$('#drop-area').append(data);
			//var data_prop = "<li class='ui-sortable-handle' id='image_li_17'><img alt='' src='http://localhost/crm/siteadmin/img_prop/3293.png'></li>";
			//$('#gallery_area').append("<li class='ui-sortable-handle' id='image_li_"+obj.id+"'><img alt='' src='"+obj.img_name+"'></li>");
		}
	});
}
function uploadFormData(formData) {
	$.ajax({
		//url: baseurl+"update.php",
		url: baseurl+"home/update_propimg",
		type: "POST",
		data: formData,
		contentType:false,
		cache: false,
		processData: false,
		success: function(data){
			var obj = jQuery.parseJSON(data);
			for (i = 0; i < obj.length; i++) {
				if (obj[i].id == "-1") {
					alert("Please You Only Upload Image File.");
				}else{
	    			$('#gallery_area').append("<li class='ui-sortable-handle' id='image_li_"+obj[i].id+"'><div onclick=delete_propimage('"+obj[i].id+"','"+obj[i].img_name+"') style='color:red'><b>X</b></div><img alt='' src='"+baseurl+"img_prop/"+obj[i].img_name+"'></li>");
				}
			}
			//alert(obj.id);
			//console.log(data);
			//return false;
			//$('#drop-area').append(data);
			//var data_prop = "<li class='ui-sortable-handle' id='image_li_17'><img alt='' src='http://localhost/crm/siteadmin/img_prop/3293.png'></li>";
			//$('#gallery_area').append("<li class='ui-sortable-handle' id='image_li_"+obj.id+"'><img alt='' src='"+obj.img_name+"'></li>");
		}
	});
}
function delete_propimage(id,imagename){
        var data = {
            action: 'delete_image',
            imagename: imagename,
            imageid:id
        };
        
        if($('#property_id').val() != 'NULL' && $('#property_id').val().length != 0){
			var path = baseurl+"home/delete_propimg";
		}else{
			var path = baseurl+"home/delete_propaddimg";
		}

        $.ajax({
            type: "POST",
            //url: baseurl+"update.php",
            url: path,
            data:data,
            success: function(res) {
            	$("#image_li_"+id).hide();
            	if($('#property_id').val() != 'NULL' && $('#property_id').val().length != 0){
					
				}else{
					var propimg_str = $('#property_imageid').val();

    				arrimg = imagename.split('/');
    				
    				var foo = arrimg[arrimg.length - 1];

    				var propimg_str = $('#property_imageid').val();

    				img_namearr = propimg_str.split(',');
    									
    				var index = img_namearr.indexOf(foo);
    				img_namearr.splice(index, 1);

    				var myVar2 = img_namearr.join(',');

    				$('#property_imageid').val(myVar2);
				}
            }
        });
}
</script>