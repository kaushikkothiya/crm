<?php


                   
$this->load->view('header');
if (isset($user[0])) {
   // echo'<pre>';print_r($user[0]);
    $id = $user[0]->id;
    $type = $user[0]->type;
	$address = $user[0]->address;
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

} else {
    $id = $this->input->post('id');
    $type = $this->input->post('type');
    $address = $this->input->post('address');
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
	
}
?>
<div class="container-fluid">
<div class="row-fluid">
<div class="span12">
<?php $this->load->view('admin_top_nav'); ?>
</div>
</div>
<div class="row-fluid">
<div class="span2 sidebar-container">
<div class="sidebar">
<div class="navbar sidebar-toggle">
<div class="container"><a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
<span class="icon-bar">
</span>
<span class="icon-bar">
</span>
<span class="icon-bar">
</span></a>
</div>
</div>
<?php
$this->load->view('leftmenu');
?>
</div>
</div>
<div class="span10 body-container">
<div class="row-fluid">
<div class="span12">
<ul class="breadcrumb">
<li><?php echo anchor('home', 'Home', "title='Home'"); ?>
<span class="divider">/
</span></li>
<li><?php echo anchor('home/property_manage', 'Manage Property', "title='Manage Property'"); ?>
<span class="divider">/
</span></li>
<?php if ($this->uri->segment(3)) { ?>
<li><?php echo anchor('home/add_property/'.$id, 'Edit Property', "title='Edit Property'"); ?> 
<?php } else { ?>
<li><?php echo anchor('home/add_property', 'Add Property', "title='Add Property'"); ?> 
<?php } ?>
<span class="divider">/
</span></li>
</ul>
</div>
</div>
            <?php if ($this->session->flashdata('success')) { ?>
                <div class="alert alert-success" role="alert">
                    <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <?php echo $this->session->flashdata('success'); ?>
                </div>
            <?php } ?>
<div class="row-fluid">
<div class="span12"><section id="formElement" class="utopia-widget utopia-form-box section">
<div class="utopia-widget-title">
<span>
<?php if ($this->uri->segment(3)) { ?>
    Edit Property
<?php } else { ?>
    Add Property
<?php } ?>
</span>
</div>
<link href="<?php echo base_url(); ?>css/selectmulcheck/multiple-select.css" rel="stylesheet">
<script type="text/javascript" src="<?php echo base_url(); ?>js/selectmulcheck/jquery.multiple.select.js"></script>
<script src="<?php echo base_url(); ?>js/multifileuplod/jquery.min.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/multifileuplod/uploadify.css">
<div class="row-fluid">
<div class="utopia-widget-content">
<div class="span6 utopia-form-freeSpace" style="width:100%!important;">
<?php echo form_open_multipart('verification/create_property', array('class' => 'form-horizontal')); ?>
<fieldset>
	<input type="hidden" id="property_id" name="property_id" value="<?php if(isset($id) && !empty($id)){ echo $id; } ?>">
	<div class="propertymain">
		<h1>Owner Detail</h1>
		<?php 
		if(!empty($id))
		{
			if($this->session->userdata('logged_in_agent')){
					$sessionData = $this->session->userdata('logged_in_agent');
					$agent_loginid =$sessionData['id'];
			}else{
					$agent_loginid="";
			}
			
			if(!$this->session->userdata('logged_in_super_user'))
			{

				if(!empty($agent_loginid) &&  ($agent_loginid == $added_id)){
					$flag = "0";
					$disable='disabled';
					$dis_flag="true";
				}else{
					$flag = "1";
					$disable='disabled';
					$dis_flag="true";
				}
			
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
		{
		?>
		<div class="propertypadd">
			<div class="twofildmain">
				<div class="fildleft">First Name :</div>
				<div class="fildright">
					<?php
					$fname = array(
						'name' => 'fname',
						'id' => 'fname',
						'value' => set_value('fname', $fname),
						'class' => 'inpselect2',
						$disable => $dis_flag,
					);

					echo form_input($fname);

					?>
				</div>
				<div class="clear"></div>
			</div>

			<div class="twofildmain">
				<div class="fildleft">Last Name :</div>
				<div class="fildright">
					<?php
						$lname = array(
							'name' => 'lname',
							'id' => 'lname',
							'value' => set_value('lname', $lname),
							'class' => 'inpselect2',
							$disable => $dis_flag,
						);
						echo form_input($lname);
					?>
				</div>
				<div class="clear"></div>
			</div>

			<div class="twofildmain">
				<div class="fildleft">Company Name :</div>
				<div class="fildright">
					<?php
						$com_name = array(
							'name' => 'cname',
							'id' => 'cname',
							'value' => set_value('cname', $compny_name),
							'class' => 'inpselect2',
							$disable => $dis_flag,
						);
						echo form_input($com_name);
					?>	
				</div>
				<div class="clear"></div>
			</div>
		<?php } ?>
			<div class="twofildmain">
				<div class="fildleft">Email :</div>
				<div class="fildright">
					<?php
						$email = array(
							'name' => 'email',
							'id' => 'email',
							'value' => set_value('email', $email),
							'class' => 'inpselect2',
							$disable => $dis_flag,
							//'onblur' => "customer_EmailFunction();"
						);
						echo form_input($email);
					?>	
				</div>
				<div class="clear"></div>
			</div>

			<div class="twofildmain">
				<div class="fildleft">Mobile :</div>
				<div class="fildright">
					<?php
							$country =$this->user->getall_countrycode();
									$selected = $county_code;

									if($selected =="0" || $selected==""){
										$selected = 24;
									}
									$device = 'id="county_code" style="width: 94px; float:left; margin-right:5px;" '.$disable;
									echo form_dropdown('county_code', $country, $selected, $device);

							$contact = array(
								//'type'=>'number',
								'name' => 'mobile_no',
								'id' => 'mobile_no',
								'value' => set_value('mobile_no', $contact),
								'size' => '30',
								'class' => 'span6 phonefld1',
								'maxlength' =>"10",
								$disable => $dis_flag,
								//'max' =>'10',	
								'onkeypress'=>'return numbersonly(event)'
							);
							echo form_input($contact);
				?>	
				<span style="margin-left:105px;">(example: 97888555)</span>
				</div>
				<div class="clear"></div>
			</div>
			
		</div>
		
	</div>

<div class="line2"></div>
<div class="propertymain">
		<h1></h1>
		<div class="twofildmain">
				<div class="fildleft">Reference No :</div>
				<div class="fildright">
					<?php
						$reference_no = array(
							'name' => 'reference_no',
							'id' => 'reference_no',
							'value' => set_value('reference_no', $reference_no),
							'class' => 'inpselect2',
						);
						echo form_input($reference_no);
					?>
				</div>
				<div class="clear"></div>
		</div>

			<div class="twofildmain">
				<div class="fildleft">Address :</div>
				<div class="fildright">
					<textarea id="address" class="inpselect2" name="address" value="<?php echo $address;?>"><?php echo $address; ?></textarea>
				</div>
				<div class="clear"></div>
			</div>
			
			<div class="twofildmain">
				<div class="fildleft">Agent :</div>
				<div class="fildright">
						<?php
								$citydata =$this->user->getAllAgent_name();
								
								$selected = $agent_id;

								if($selected == "" || $selected == 0){
										$selected = 0;
								}
								$device = 'id="agent_id" class="inpselect2"';
								echo form_dropdown('agent_id', $citydata, $selected, $device);
						?>
				</div>
				<div class="clear"></div>
			</div>
		</div>


<br /><br />
<div class="line2"></div>
	<div class="propertymain">
		<h1>Property Status</h1>
		
		<div class="propertypadd">
			<div class="propertyleft">
				<div class="fild">
					<div class="lable">Type:</div>
					<div class="data">
						<?php
							$citydata = array('0' =>'Select Type','1'=>'Sale','2' =>'Rent','3' =>'Both');
						  	$selected = $type;
							if($selected == "" || $selected == 0){
									$selected = 0;
							}
							$device = 'onchange="hide_agresive_div();" id="type" class="inpselect1" style="width: 255px"';
							echo form_dropdown('type', $citydata, $selected, $device);
						?>
						
					</div>
				</div>
			</div>
			
			<div class="propertyright">
				<div class="fild" id="rent_div">
					<div class="lable">Rent Price (€) :</div>
					<div class="data">
						<?php
							$rent_price = array(
								'type' => 'text',
								'name' => 'rent_price',
								'id' => 'rent_price',
								'value' => set_value('rent_price', $rent_price),
								'class' => 'inpselect1',
								'onkeypress'=>'return numbersonly(event)',
							);
							echo form_input($rent_price);
						?>
					</div>
					
					<div class="radiomain">
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
							<?php echo form_radio($rent_val, '1', $checked2, 'class="radio_buttons required"'); ?>
							 incl. common expenses &nbsp;&nbsp;
							<?php echo form_radio($rent_val, '0', $checked1, 'class="radio_buttons required"'); ?>
							 Plus common expenses

					</div>
				</div>
					
					<div class="fild" id="sale_div">
					<div class="lable">Selling Price (€):</div>
					<div class="data">
						<?php
							$sale_price = array(
								'type' => 'text',
								'name' => 'sale_price',
								'id' => 'sale_price',
								'value' => set_value('sale_price', $sale_price),
								'class' => 'inpselect1',
								'onkeypress'=>'return numbersonly(event)',
							);
							echo form_input($sale_price);
						?>
					</div>
					
					<div class="radiomain">
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
							<?php echo form_radio($sale_val, '1', $checked2, 'class="radio_buttons required"'); ?>
							  No V.A.T &nbsp;&nbsp;
							<?php echo form_radio($sale_val, '0', $checked1, 'class="radio_buttons required"'); ?>
							 Plus  V.A.T
					</div>
				</div>
			</div>
			<div class="clear"></div>
			<div id="check_box_agreement" >
			<div class="line1"></div>
			<?php if($check_val =='1'){
				$checked='true';
			}else{
				$checked='';
				} ?>
			<div class="checkboxmain">
				<?php
					$data = array(
					    'name'        => 'checkbox1',
					    'id'          => 'checkbox1',
					    'value'       => 'accept',
					    'checked'     => $checked,
					    'style'       => 'margin:10px',
					    );

					echo form_checkbox($data);

					?>&nbsp; Title Deeds / Planning Permission / Building Permission
				
			</div>
			<div class="checkboxmain">
				<?php
					$data = array(
					    'name'        => 'checkbox2',
					    'id'          => 'checkbox2',
					    'value'       => 'accept',
					    'checked'     => $checked,
					    'style'       => 'margin:10px',
					    );

					echo form_checkbox($data);

					?>&nbsp; Signed Commission Agreement
			</div>
			</div>
		  </div>
		
	  </div>

  <br /><br />
	<div class="line2"></div>
	<div class="propertymain">
		<input type='hidden' name="city_ar_id" id="city_ar_id" value="<?php echo $city_area ?>">
			<h1>Property Area</h1>
			
			<div class="propertypadd">
				<div class="propertyleft">
					<div class="fild">
						<div class="data">
							<?php
								$citydata =$this->user->getallcity();
								$selected = $city_id;
								if($selected == "" || $selected == 0){
										$selected = 0;
								}
								$device = 'onchange="get_city_area();" id="city_id" class="inpselect1" style="width: 255px"';
								echo form_dropdown('city_id', $citydata, $selected, $device);
							?>
							</br></br></br>	
							<?php
								$city_area_rec = array( '0'=>'Select city area');//$this->user->getallcity_area();
						 		$selected = $city_area;
								// if($selected == "" || $selected == 0){
								// 		$selected = 0;
								// }
								$device = 'id="city_area_id" class="inpselect1" style="width: 255px"';
								echo form_dropdown('city_area_id',$city_area_rec, $selected, $device);
							?>
						</div>
					</div>
				</div>
				
				<div class="propertyright">
					<div class="fild">
						<div class="data">
							<input type="text" name="search_address" id="search_address" value="1600 Amphitheatre Pky, Mountain View, CA" onblur="showAddress(this.value);">
							<!-- <textarea name="" cols="2" rows="1" class="textarea1"></textarea> -->
						</div>
					</div>
					
					<div class="fild">
						<div class="data" id="map_canvas" style="width: 500px; height: 400px">
							<!-- <img src="<?php echo base_url(); ?>img/Google-Maps.png" style="width:80%;" /> -->
						</div>
					</div>
					<div class="sep"></div>
					
				</div>
				<div class="clear"></div>
		</div>
	</div>
	
	<div class="line2"></div>
	
	<div class="propertymain">
		<h1>Property Type</h1>
		
		<div class="propertypadd">
			<div class="propertyleft">
				<div class="fild">
					<div class="data">
							<?php
								$property_category = array('0' =>'Select Property Category','1'=>'Duplex','2' =>'Apartment','3' =>'Penthouse','4' =>'Garden Apartments','5'=>'Studio','6' =>'Townhouse','7' =>'Villa','8' =>'Bungalow','9'=>'Land','10' =>'Shop','11' =>'Office','12' =>'Business','13'=>'Hotel','14' =>'Restaurant','15' =>'Building','16' =>'Industrial estate','17' =>'House','18' =>'Upper-House','19' =>'Maisonette');
								asort($property_category);
								$selected = $property_type;
								if($selected == "" || $selected == 0){
										$selected = 0;
								}
								$device = 'id="property_category" class="inpselect1" style="width: 255px"';
								echo form_dropdown('property_category', $property_category, $selected, $device);
							?>
					</div>
				</div>
			</div>
			
			<div class="propertyright">
				<div class="fild">
					<div class="lable">Covered area (m²):</div>
					<div class="data">
						<?php
							$cover_area = array(
								'type' => 'text',
								'name' => 'cover_area',
								'id' => 'cover_area',
								'value' => set_value('cover_area', $cover_area_size),
								'class' => 'inpselect1',
								'onkeypress'=>'return numbersonly(event)',
							); 
							echo form_input($cover_area);
						?>
					</div>
				</div>
				
				<div class="fild">
					<div class="lable">Un-covered area(m²):</div>
					<div class="data">
						<?php
							$uncover_area = array(
								'type' => 'text',
								'name' => 'uncover_area',
								'id' => 'uncover_area',
								'value' => set_value('uncover_area', $uncover_area_size),
								'class' => 'inpselect1',
								'onkeypress'=>'return numbersonly(event)',
							); 
							echo form_input($uncover_area);
						?>
					</div>
				</div>
				
				<div class="fild">
					<div class="lable">Land/Plot area(m²):</div>
					<div class="data">
						<?php
							$plot_land_area = array(
								'type' => 'text',
								'name' => 'plot_land_area',
								'id' => 'plot_land_area',
								'value' => set_value('plot_land_area', $plot_lan_area_size),
								'class' => 'inpselect1',
								'onkeypress'=>'return numbersonly(event)',
							); 
							echo form_input($plot_land_area);
						?>
					</div>
				</div>
				
				<div class="fild">
					<div class="lable">Bedroom(s) :</div>
					<div class="data">
						<?php
							$bedroom_val = array(
								'type' => 'text',
								'name' => 'bedrooms',
								'id' => 'bedrooms',
								'value' => set_value('bedrooms', $bedroom),
								'class' => 'inpselect1',
								//'onkeypress'=>'return numbersonly(event)',
							); 
							echo form_input($bedroom_val);
						?>
					</div>
				</div>
				<!-- <div class="fild">
					<div class="lable">Bedroom(s):</div>
					<div class="data">
						<?php
							$citydata = array('0' =>'Select Bedrooms','1'=>'1','2' =>'2','3' =>'3','4' =>'4','5' =>'5','6' =>'6','7' =>'7');
							$selected = $bedroom;
							if($selected == "" || $selected == 0){
									$selected = 0;
							}
							$device = 'id="bedrooms" class="inpselect1"';
							echo form_dropdown('bedrooms', $citydata, $selected, $device);
						?>
					</div>
				</div> -->
				
				<div class="fild">
					<div class="lable">Bathroom(s):</div>
					<div class="data">
						<?php
							$citydata = array('0' =>'Select Bathrooms','1'=>'1','2' =>'2','3' =>'3','4' =>'4','5' =>'5','6' =>'6','7' =>'7');
							$selected = $bathroom;
							if($selected == "" || $selected == 0){
									$selected = 0;
							}
							$device = 'id="bathrooms" class="inpselect1"';
							echo form_dropdown('bathrooms', $citydata, $selected, $device);
						?>
					</div>
				</div>
				
				<div class="fild">
					<div class="lable">Kitchen(s):</div>
					<div class="data">
						<?php
							$kitchen_list = $this->config->item("kitchen_list");
							$selected = $Kitchen;
							if($selected == "" || $selected == 0){
									$selected = 0;
							}
							$device = 'id="Kitchen_id" class="inpselect1"';
							echo form_dropdown('Kitchen_id', $kitchen_list, $selected, $device);
						?>
					</div>
				</div>
				<div class="sep"></div>
			</div>
			<div class="clear"></div>
		</div>
		
	</div>

<div class="line2"></div>
	
	<div class="propertymain">
		<h1>Property Facilities</h1>
		
		<div class="propertypadd">
			<div class="twofildmain">
				<div class="fildleft">Furnished Type :</div>
				<div class="fildright">
						<?php
							$citydata = array('0' =>'Select Furmished Type','1'=>'Furnished','2' =>'Semi-Furnished','3' =>'Un-Furnished');
							$selected = $furnished_type;
							if($selected == "" || $selected == 0){
									$selected = 0;
							}
							$device = 'id="furnished_type" class="inpselect2" ';
							echo form_dropdown('furnished_type', $citydata, $selected, $device);
						?>
				</div>
				<div class="clear"></div>
			</div>
		
			 <div class="propertyleft">
				<div class="fild">
					<div class="data" id="ScrollCB" style="height:200px;width:400px;overflow-y:scroll;border:1px solid #ccc; padding:5px;">
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
							 <input type="checkbox" id="" <?php echo $selected; ?> name="genral_facility[]" value="<?php echo $key; ?>"><?php echo $value; ?><br>
							<?php }?>
					</div>
				</div>
				<span style="margin-left:105px;"><!-- Use Ctrl + Click for multi select. --></span>
				<div class="sep"></div>
			</div> 
			
			<div class="propertyright">
				<div class="fild">
					<div class="data" id="ScrollCB" style="height:200px;width:400px;overflow-y:scroll;border:1px solid #ccc; padding:5px;">
							
							<?php $all_instrumental_facility = $this->inquiry_model->get_instrumental_facility();
							foreach ($all_instrumental_facility as $key1 => $value1) {
							if(in_array($key1, $facility_id)){
								$selected1 = "checked";		
								}else{
								$selected1 = "";	
								}
							?>
							 <input type="checkbox" id="" <?php echo $selected1; ?> name="instrumental_facility[]" value="<?php echo $key1; ?>"><?php echo $value1; ?><br>
							<?php }?>
							
					</div>
					<span style="margin-left:105px;"><!-- Use Ctrl + Click for multi select. --></span>
				</div>
				<div class="sep"></div>
			</div>

			<div class="clear line1"></div>
			<div class="sep"></div>
			<div class="sep"></div>
						
			<div class="twofildmain">
				<div class="fildleft">Building Year of Make:</div>
				<div class="fildright">
					<?php
						$year = array(
							'name' => 'make_year',
							'id' => 'make_year',
							'value' => set_value('lname', $make_year),
							'class' => 'inpselect1',
							'onkeypress'=>'return numbersonly(event)'
							
						);
						echo form_input($year);
					?>
				</div>
				<div class="clear"></div>
			</div>
			
			<div class="twofildmain">
				<div class="fildleft">Un-Covered Parking(s):</div>
				<div class="fildright">
					<?php
							$uncover_parking = array('0' =>'Please Select','1'=>'1','2' =>'2','3' =>'3','4' =>'4','5' =>'5');
							$selected = $uncover_parking_id;
							if($selected == "" || $selected == 0){
									$selected = 0;
							}
							$device = 'id="uncover_parking" class="inpselect1" ';
							echo form_dropdown('uncover_parking', $uncover_parking, $selected, $device);
						?>
				</div>
				<div class="clear"></div>
			</div>
			
			<div class="twofildmain">
				<div class="fildleft">Covered Parking(s):</div>
				<div class="fildright">
					<?php
							$cover_parking = array('0' =>'Please Select','1'=>'1','2' =>'2','3' =>'3','4' =>'4','5' =>'5');
							$selected = $cover_parking_id;
							if($selected == "" || $selected == 0){
									$selected = 0;
							}
							$device = 'id="cover_parking" class="inpselect1" ';
							echo form_dropdown('cover_parking', $cover_parking, $selected, $device);
						?>
				</div>
				<div class="clear"></div>
			</div>
		</div>
	</div>
	
	<div class="line2"></div>
	
	<div class="propertymain">
		<h1>Architectural Design</h1>
		<div class="propertypadd">
			<div class="radiosection">
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
							<?php echo form_radio($architectural_design_id, '1', $checked1, 'class="radio_buttons required"'); ?>
							 Contemporary &nbsp;&nbsp;
							<?php echo form_radio($architectural_design_id, '2', $checked2, 'class="radio_buttons required"'); ?>
							 Modern &nbsp;&nbsp;
							 <?php echo form_radio($architectural_design_id, '3', $checked3, 'class="radio_buttons required"'); ?>
							 Classic
				<div class="clear"></div>
			</div>
		</div>
		
		<div class="line1"></div>
		
		<h1>Size of Rooms</h1>
		<div class="propertypadd">
			<div class="radiosection">
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
							<?php echo form_radio($room_size_id, '1', $checked1, 'class="radio_buttons required"'); ?>
							 Small &nbsp;&nbsp;
							<?php echo form_radio($room_size_id, '2', $checked2, 'class="radio_buttons required"'); ?>
							 Medium &nbsp;&nbsp;
							 <?php echo form_radio($room_size_id, '3', $checked3, 'class="radio_buttons required"'); ?>
							 Large
				<div class="clear"></div>
			</div>
		</div>
		
		<div class="line1"></div>
		
		<h1>Pets</h1>
		<div class="propertypadd">
			<div class="radiosection">
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
							<?php echo form_radio($pets_id, '0', $checked1, 'class="radio_buttons required"'); ?>
							 Allowed &nbsp;&nbsp;
							<?php echo form_radio($pets_id, '1', $checked2, 'class="radio_buttons required"'); ?>
							 Not Allowed 
				<div class="clear"></div>
			</div>
		</div>
		
	</div>
	
	<div class="line2"></div>
	
	<div class="propertymain">
		<h1></h1>
		
		<div class="propertypadd">
			<div class="twofildmain">
				<div class="fildleft">URL Link(1)</div>
				<div class="fildright">
					<?php
						$link = array(
							'name' => 'link_url',
							'id' => 'link_url',
							'value' => set_value('link_url', $link_url),
							'size' => '30',
							'class' => 'span10',
							'onkeypress'=>'return spance_remove(event)'
						);
						echo form_input($link);
					?>
				</div>
				<div class="clear"></div>
			</div>
			
			<div class="twofildmain">
				<div class="fildleft">URL Link(2):</div>
				<div class="fildright">
					<?php
						$link1 = array(
							'name' => 'link_url1',
							'id' => 'link_url1',
							'value' => set_value('link_url1', $link_url1),
							'size' => '30',
							'class' => 'span10',
							'onkeypress'=>'return spance_remove(event)'
						);
						echo form_input($link1);
					?>
				</div>
				<div class="clear"></div>
			</div>
			
			<div class="twofildmain">
				<div class="fildleft">URL Link(3)</div>
				<div class="fildright">
					<?php
						$link2 = array(
							'name' => 'link_url2',
							'id' => 'link_url2',
							'value' => set_value('link_url2', $link_url2),
							'size' => '30',
							'class' => 'span10',
							'onkeypress'=>'return spance_remove(event)'
						);
						echo form_input($link2);
					?>
				</div>
				<div class="clear"></div>
			</div>
			
			<br /><br />

<div class="control-group">
<label class="control-label" for="textarea">Image :
</label>
<div class="controls">
<input type="file" name="image" id="image" class="file"></br></br>
<label style="color:red;">The recommended size should be 350px X 350px</label>

<?php 
if(!empty($image)){
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
<div id="gallery" data-toggle="" data-target=""><a><img src="<?php echo base_url().'upload/property/100x100/'.$image; ?>" width="100" height="100"></a>
</div>
<?php
	}
}else{
	echo form_hidden('old_img', "noimage.jpg");
?>
<div id="gallery" data-toggle="" data-target=""><a><img src="<?php echo base_url().'upload/property/100x100/noimage.jpg'.$image; ?>" width="100" height="100"></a>
</div>
<?php } ?>
<div class="error"><?php if (isset($msg)) //echo $msg; ?></div>
</div>
</div>
		
	</div>
	
	<div class="line2"></div>
	
	<div class="propertymain">
		<h1>Property Distance in Km</h1>
		
		<div class="propertypadd">
			<div class="twofildmain">
				<div class="fildleft">From Supermarket:</div>
				<div class="fildright">
					<input name="from_supermarket" id="from_supermarket" value="<?php echo $from_supermarket ?>" type="text" class="inpselect2" />
				</div>
				<div class="clear"></div>
			</div>
			
			<div class="twofildmain">
				<div class="fildleft">From Bus Station:</div>
				<div class="fildright">
					<input name="from_bus_station" id="from_bus_station" value="<?php echo $from_bus_station ?>" type="text" class="inpselect2" />
				</div>
				<div class="clear"></div>
			</div>
			
			<div class="twofildmain">
				<div class="fildleft">From School:</div>
				<div class="fildright">
					<input name="from_school" id="from_school" value="<?php echo $from_school ?>" type="text" class="inpselect2" />
				</div>
				<div class="clear"></div>
			</div>
			
			<div class="twofildmain">
				<div class="fildleft">From High-Way:</div>
				<div class="fildright">
					<input name="from_high_way" id="from_high_way" value="<?php echo $from_high_way ?>" type="text" class="inpselect2" />
				</div>
				<div class="clear"></div>
			</div>
			
			<div class="twofildmain">
				<div class="fildleft">From Playground:</div>
				<div class="fildright">
					<input name="from_playground" id="from_playground" value="<?php echo $from_playground ?>" type="text" class="inpselect2" />
				</div>
				<div class="clear"></div>
			</div>
			<div class="twofildmain">
				<div class="fildleft">From Sea:</div>
				<div class="fildright">
					<input name="from_sea" id="from_sea" value="<?php echo $from_sea ?>" type="text" class="inpselect2" />
				</div>
				<div class="clear"></div>
			</div>
			<div class="twofildmain">
				<div class="fildleft">From Cafeteria:</div>
				<div class="fildright">
					<input name="from_cafeteria" id="from_cafeteria" value="<?php echo $from_cafeteria ?>" type="text" class="inpselect2" />
				</div>
				<div class="clear"></div>
			</div>
			
			<div class="twofildmain">
				<div class="fildleft">From Restaurant:</div>
				<div class="fildright">
					<input name="from_restaurant" id="from_restaurant" value="<?php echo $from_restaurent ?>" type="text" class="inpselect2" />
				</div>
				<div class="clear"></div>
			</div>
		</div>
		
	</div>
	

	<div class="line2"></div>
	
	<div class="description">
		<div class="lable">Property Description:</div>
		<style type="text/css">
			.cleditorMain{
				width: 100% !important;
			}
		</style>
		<div class="data">
			<textarea id="short_desc" name="short_desc" value="<?php echo $short_decs;?>"><?php echo $short_decs;?></textarea>

		</div>
	</div>
	
<h1>Status</h1>
		<div class="propertypadd">
			<div class="radiosection">
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
				<label class="radio">
				<?php echo form_radio($status, 'Active', $checked2, 'class="radio_buttons required"'); ?>
				Active</label>
				<label class="radio">
				<?php echo form_radio($status, 'Inactive', $checked1, 'class="radio_buttons required"'); ?>
				Inactive</label>

				<div class="error"><?php //echo form_error('status'); ?></div>

</div>


<?php //echo form_hidden('social', $social); ?>
<?php echo form_hidden('id', $id); ?>

<center>
		<?php
		if ($id=="") {
			echo form_submit('pro_add', 'Add Property', "class='btn'");?>&nbsp;&nbsp;<?php
			//echo form_submit('pro_add', 'Add Property With Extra images', "class='btn'");
		} else { 
			echo form_submit('pro_up', 'Update Property', "class='btn'");?>&nbsp;&nbsp;<?php
			//echo form_submit('pro_up', 'Update Property With Extra images', "class='btn'");
		}
		?>&nbsp;&nbsp;
		<?php echo anchor('home/property_manage', 'Cancel', array('title' => 'Cancel', 'class' => 'btn')); ?>
</center>
</fieldset>
</form>
</div>

<div class="span6 utopia-form-freeSpace">
</div>
</div>
</div>
</section>
</div>
</div>
</div>
</div>
</div>

<?php

$this->load->view('footer');

?>
 <script src="http://maps.google.com/maps?file=api&amp;v=2&a
 y=ABQIAAAAjU0EJWnWPMv7oQ-jjS7dYxSPW5CJgpdgO_s4yyMovOaVh_KvvhSfpvagV18eOyDWu7VytS6Bi1CWxw"
      type="text/javascript"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/property.js"></script>
<script>

function hide_agresive_div(){
if($("#type").val() =='1'){
$("#check_box_agreement").show();
$("#rent_div").hide();
$("#sale_div").show();
}else if($("#type").val() =='2'){
	$("#check_box_agreement").hide();
	$("#sale_div").hide();
	$("#rent_div").show();
}else{
	$("#check_box_agreement").show();
	$("#sale_div").show();
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
         hide_agresive_div();
         		$("#link_url").cleditor({width:300});
        		$("#short_desc").cleditor({width:300}); 
        		
        		$('.multiselect').multipleSelect({
                                filter: true,
                            });
        		$('.multiselect').multipleSelect({
                                filter: true,
                            });
        		//$("#long_decs").cleditor({width:300});
        		initialize();
        		GUnload();
        		var map = null;
    			var geocoder = null;

		    });
        function initialize() {
		      if (GBrowserIsCompatible()) {
		        map = new GMap2(document.getElementById("map_canvas"));
		        map.setCenter(new GLatLng(37.4419, -122.1419), 1);
		        map.setUIToDefault();
		        geocoder = new GClientGeocoder();
		      }
		    }
        function showAddress(search_address) {
		      if (geocoder) {
		        geocoder.getLatLng(
		          search_address,
		          function(point) {
		            if (!point) {
		              alert(search_address + " not found");
		            } else {
		              map.setCenter(point, 15);
		                map.setZoom(5);
		              var marker = new GMarker(point, {draggable: true});
		              map.addOverlay(marker);
		              GEvent.addListener(marker, "dragend", function() {
		                marker.openInfoWindowHtml(marker.getLatLng().toUrlValue(6));
		              });
		              GEvent.addListener(marker, "click", function() {
		                marker.openInfoWindowHtml(marker.getLatLng().toUrlValue(6));
		              });
			      GEvent.trigger(marker, "click");
		            }
		          }
		        );
		      }
		    }
</script>
