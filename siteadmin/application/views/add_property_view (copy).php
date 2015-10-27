<?php


                   
$this->load->view('header');
if (isset($user[0])) {
    
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
<script src="<?php echo base_url(); ?>js/multifileuplod/jquery.min.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/multifileuplod/uploadify.css">
<div class="row-fluid">
<div class="utopia-widget-content">
<div class="span6 utopia-form-freeSpace">
<?php echo form_open_multipart('verification/create_property', array('class' => 'form-horizontal')); ?>
<fieldset>
	<input type="hidden" id="property_id" name="property_id" value="<?php if(isset($id) && !empty($id)){ echo $id; } ?>">

<h3>Owner Detail</h3>
<?php if(!empty($id))
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
	}

	else{
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
	<div class="control-group">
	<label class="control-label" for="textarea">First Name :
	</label>

	<div class="controls">
	<?php
	$fname = array(
		'name' => 'fname',
		'id' => 'fname',
		'value' => set_value('fname', $fname),
		'size' => '30',
		'class' => 'span10',
		$disable => $dis_flag,
	);

	echo form_input($fname);

	?>
	<div class="error"><?php //echo form_error('fname'); ?></div>
	</div>
	</div>

	<div class="control-group">
	<label class="control-label" for="textarea">Last Name :
	</label>
	<div class="controls">
	<?php
	$lname = array(
		'name' => 'lname',
		'id' => 'lname',
		'value' => set_value('lname', $lname),
		'size' => '30',
		'class' => 'span10',
		$disable => $dis_flag,
	);
	echo form_input($lname);
	?>
	<div class="error"><?php //echo form_error('lname'); ?></div>
	</div>
	</div>
	<div class="control-group">
	<label class="control-label" for="textarea">Compny Name :
	</label>
	<div class="controls">
	<?php
	$com_name = array(
		'name' => 'cname',
		'id' => 'cname',
		'value' => set_value('cname', $compny_name),
		'size' => '30',
		'class' => 'span10',
		$disable => $dis_flag,
	);
	echo form_input($lname);
	?>
	<div class="error"><?php //echo form_error('lname'); ?></div>
	</div>
</div>
<?php
}
?>
<div class="control-group">
<label class="control-label" for="textarea">Email :
</label>
<div class="controls">
<?php
$email = array(
	'name' => 'email',
	'id' => 'email',
	'value' => set_value('email', $email),
	'size' => '30',
	'class' => 'span10',
	$disable => $dis_flag,
	//'onblur' => "customer_EmailFunction();"
);
echo form_input($email);
?>
<div class="error"><?php //echo form_error('email'); ?></div>
</div>
</div>
<div class="control-group">
<label class="control-label" for="textarea">Mobile :
</label>
<div class="controls">
<?php
$country =$this->user->getall_countrycode();
		$selected = 24;
		$device = 'id="county_code" style="width: 100px; float:left; margin-right:5px; "';
		echo form_dropdown('county_code', $country, $selected, $device);

$contact = array(
	//'type'=>'number',
	'name' => 'mobile_no',
	'id' => 'mobile_no',
	'value' => set_value('mobile_no', $contact),
	'size' => '30',
	'class' => 'span6',
	'maxlength' =>"8",
	$disable => $dis_flag,
	//'max' =>'10',	
	'onkeypress'=>'return numbersonly(event)'
);
echo form_input($contact);
?>
<span style="margin-left:105px;">(example: 97888555)</span>
<div class="error"><?php //echo form_error('mobile_no'); ?></div>
</div>
</div>
<hr>
<h3>Property Detail</h3>
<div class="control-group">
<label class="control-label" for="textarea">Reference No :
</label>
<div class="controls">
<?php
$reference_no = array(
	'name' => 'reference_no',
	'id' => 'reference_no',
	'value' => set_value('reference_no', $reference_no),
	'size' => '30',
	'class' => 'span10',
);
echo form_input($reference_no);
?>
<div class="error"><?php //echo form_error('email'); ?></div>
</div>
</div>

<div class="control-group">
<label class="control-label" for="textarea">Agent :
</label>
<div class="controls">
<?php
		$citydata =$this->user->getAllAgent_name();
		
		$selected = $agent_id;

		if($selected == "" || $selected == 0){
				$selected = 0;
		}
		$device = 'id="agent_id" style="width: 255px"';
		echo form_dropdown('agent_id', $citydata, $selected, $device);
?>
<div class="error"><?php //echo form_error('store_country'); ?></div>
</div>
</div>
<div class="control-group">
<label class="control-label" for="textarea">Property Status :
</label>
<div class="controls">
<?php
		$citydata = array('0' =>'Select Type','1'=>'Sale','2' =>'Rent','3' =>'Both');
	  	$selected = $type;
		if($selected == "" || $selected == 0){
				$selected = 0;
		}
		$device = 'onchange="hide_agresive_div();" id="type" style="width: 255px"';
		echo form_dropdown('type', $citydata, $selected, $device);
?>
<div class="error"><?php //echo form_error('store_country'); ?></div>

</div>
</div>
<div id="rent_div">
<div class="control-group">
<label class="control-label" for="textarea">Rent Price (€) :
</label>
<div class="controls">
<?php
$rent_price = array(
	'type' => 'text',
	'name' => 'rent_price',
	'id' => 'rent_price',
	'value' => set_value('rent_price', $rent_price),
	'size' => '30',
	'class' => 'span10',
	'onkeypress'=>'return numbersonly(event)',
);
echo form_input($rent_price);
?>
<div class="error"><?php //echo form_error('password'); ?></div>
</div>
</div>
<div class="control-group">
<label class="control-label" for="textarea">
</label>

<div class="controls">
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

<div class="error"><?php //echo form_error('status'); ?></div>

</div>

</div>
</div>
<div id="sale_div">
<div class="control-group">
<label class="control-label" for="textarea">Selling Price (€):
</label>
<div class="controls">
<?php
$sale_price = array(
	'type' => 'text',
	'name' => 'sale_price',
	'id' => 'sale_price',
	'value' => set_value('sale_price', $sale_price),
	'size' => '30',
	'class' => 'span10',
	'onkeypress'=>'return numbersonly(event)',
);
echo form_input($sale_price);
?>
<div class="error"><?php //echo form_error('password'); ?></div>
</div>
</div>
<div class="control-group">
<label class="control-label" for="textarea">
</label>

<div class="controls">
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

<div class="error"><?php //echo form_error('status'); ?></div>

</div>

</div>
</div>
<div class="control-group">
<label class="control-label" for="textarea">Address :
</label>
<div class="controls">
<textarea id="address" name="address" value="<?php echo $address;?>" style="width:243px;"><?php echo $address; ?></textarea>
<div class="error"><?php //echo form_error('description'); ?></div>
</div>
</div>
<div class="control-group">
<label class="control-label" for="textarea">City :
</label>
<div class="controls">
<?php
		$citydata =$this->user->getallcity();
		$selected = $city_id;
		if($selected == "" || $selected == 0){
				$selected = 0;
		}
		$device = 'onchange="get_city_area();" id="city_id" style="width: 255px"';
		echo form_dropdown('city_id', $citydata, $selected, $device);
?>
<div class="error"><?php //echo form_error('store_country'); ?></div>
</div>
</div>
<input type='hidden' name="city_ar_id" id="city_ar_id" value="<?php echo $city_area ?>">
<div class="control-group">
<label class="control-label" for="textarea">City Area :
</label>
<div class="controls">
<?php
		 $city_area_rec = array( '0'=>'Select city area');//$this->user->getallcity_area();
		 $selected = $city_area;
		// if($selected == "" || $selected == 0){
		// 		$selected = 0;
		// }
		$device = 'id="city_area_id" style="width: 255px"';
		echo form_dropdown('city_area_id',$city_area_rec, $selected, $device);
?>
<div class="error"><?php //echo form_error('store_country'); ?></div>

</div>
</div>

<div class="control-group">
<label class="control-label" for="textarea">Property Type :
</label>
<div class="controls">
<?php
		$citydata = array('0' =>'Select Property Category','1'=>'Duplex','2' =>'Apartment','3' =>'Penthouse','4' =>'Garden Apartments','5'=>'Studio','6' =>'Townhouse','7' =>'Villa','8' =>'Bungalow','9'=>'Land','10' =>'Shop','11' =>'Office','12' =>'Business','13'=>'Hotel','14' =>'Restaurant','15' =>'Building','16' =>'Industrial estate','17' =>'House','18' =>'Upper-House','19' =>'Maisonette');
		$selected = $property_type;
		if($selected == "" || $selected == 0){
				$selected = 0;
		}
		$device = 'id="property_category" style="width: 255px"';
		echo form_dropdown('property_category', $citydata, $selected, $device);
?>
<div class="error"><?php //echo form_error('store_country'); ?></div>

</div>
</div>

<div class="control-group">
<label class="control-label" for="textarea">Furnished Type :
</label>
<div class="controls">
<?php
		$citydata = array('0' =>'Select Furmished Type','1'=>'Furnished','2' =>'Semi-Furnished','3' =>'Un-Furnished');
		$selected = $furnished_type;
		if($selected == "" || $selected == 0){
				$selected = 0;
		}
		$device = 'id="furnished_type" style="width: 255px"';
		echo form_dropdown('furnished_type', $citydata, $selected, $device);
?>
<div class="error"><?php //echo form_error('store_country'); ?></div>

</div>
</div>

<div class="control-group">
<label class="control-label" for="textarea">Bedrooms :
</label>
<div class="controls">
<?php
		//$citydata =$this->user->getallcity();
		$citydata = array('0' =>'Select Bedrooms','1'=>'1','2' =>'2','3' =>'3','4' =>'4','5' =>'5','6' =>'6','7' =>'7');
		$selected = $bedroom;
		if($selected == "" || $selected == 0){
				$selected = 0;
		}
		$device = 'id="bedrooms" style="width: 255px"';
		echo form_dropdown('bedrooms', $citydata, $selected, $device);
?>
<div class="error"><?php //echo form_error('store_country'); ?></div>

</div>
</div>
<div class="control-group">
<label class="control-label" for="textarea">Bathrooms :
</label>
<div class="controls">
<?php
		$citydata = array('0' =>'Select Bathrooms','1'=>'1','2' =>'2','3' =>'3','4' =>'4','5' =>'5','6' =>'6','7' =>'7');
		$selected = $bathroom;
		if($selected == "" || $selected == 0){
				$selected = 0;
		}
		$device = 'id="bathrooms" style="width: 255px"';
		echo form_dropdown('bathrooms', $citydata, $selected, $device);
?>
<div class="error"><?php //echo form_error('store_country'); ?></div>

</div>
</div>
<div class="control-group">
<label class="control-label" for="textarea">URL Link1:
</label>
<div class="controls">
<?php
$link = array(
	'name' => 'link_url',
	'id' => 'link_url',
	'value' => set_value('link_url', $link_url),
	'size' => '30',
	'class' => 'span10',
);
echo form_input($link);
?>
<div class="error"><?php //echo form_error('email'); ?></div>
</div>
</div>
<div class="control-group">
<label class="control-label" for="textarea">URL Link2:
</label>
<div class="controls">
<?php
$link1 = array(
	'name' => 'link_url1',
	'id' => 'link_url1',
	'value' => set_value('link_url1', $link_url1),
	'size' => '30',
	'class' => 'span10',
);
echo form_input($link1);
?>
<div class="error"><?php //echo form_error('email'); ?></div>
</div>
</div>
<div class="control-group">
<label class="control-label" for="textarea">URL Link3:
</label>
<div class="controls">
<?php
$link2 = array(
	'name' => 'link_url2',
	'id' => 'link_url2',
	'value' => set_value('link_url2', $link_url2),
	'size' => '30',
	'class' => 'span10',
);
echo form_input($link2);
?>
<div class="error"><?php //echo form_error('email'); ?></div>
</div>
</div>
<div class="control-group">
<label class="control-label" for="textarea">Image :
</label>
<div class="controls">
<input type="file" name="image" id="identity_check_img" class="file"></br></br>
<!--<div id="mulimage"></div></br>
<button type="button" class="btn btn-primary" style="width:120px;"  onclick = "mulimage()">Add Other</button></br></br>-->
<label style="color:red;">The recommended size should be 350px X 350px</label>
<?php 
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
<!--<div class="modal-footer"><a class="btn modal-download" target="_blank"><i class="icon-download"></i>
<span>Download
</span></a>
</div>-->
</div>
<div id="gallery" data-toggle="" data-target=""><a><img src="<?php echo base_url().'upload/property/'.$image; ?>" width="100" height="100"></a>
<!--<div id="gallery" data-toggle="modal-gallery" data-target="#modal-gallery"><a href="<?php echo base_url().'upload/property/'.$image; ?>" rel="gallery"><img src="<?php echo base_url().'upload/property/'.$image; ?>" width="100" height="100"></a>
-->
</div>
<?php
}
?>
<div class="error"><?php if (isset($msg)) //echo $msg; ?></div>
</div>
</div>
<!--<div class="control-group">
<label class="control-label" for="textarea">URL Link :
</label>
<div class="controls">
<textarea id="link_url" name="link_url" value="<?php echo $link_url;?>" width="500px"><?php echo $link_url;?></textarea>
<div class="error"><?php //echo form_error('description'); ?></div>
</div>
</div>-->
<div class="control-group">
<label class="control-label" for="textarea">Covered area (m²):
</label>
<div class="controls">
<?php
$cover_area = array(
	'type' => 'text',
	'name' => 'cover_area',
	'id' => 'cover_area',
	'value' => set_value('cover_area', $cover_area_size),
	'size' => '30',
	'class' => '',
	'style'=>'width:70px',
	'onkeypress'=>'return numbersonly(event)',
); 
echo form_input($cover_area);
?>
&nbsp;Uncovered area: (m²):
<?php
$uncover_area = array(
	'type' => 'text',
	'name' => 'uncover_area',
	'id' => 'uncover_area',
	'value' => set_value('uncover_area', $uncover_area_size),
	'size' => '30',
	'class' => '',
	'style'=>'width:70px',
	'onkeypress'=>'return numbersonly(event)',
); 
echo form_input($uncover_area);
?>
<div class="error"><?php //echo form_error('password'); ?></div>
</div>
</div>
<div class="control-group">
<label class="control-label" for="textarea">Plot/land area (m²):
</label>
<div class="controls">
<?php
$plot_land_area = array(
	'type' => 'text',
	'name' => 'plot_land_area',
	'id' => 'plot_land_area',
	'value' => set_value('plot_land_area', $plot_lan_area_size),
	'size' => '30',
	'class' => '',
	'style'=>'width:70px',
	'onkeypress'=>'return numbersonly(event)',
); 
echo form_input($plot_land_area);
?>
<!-- &nbsp;Plot/land area (m²):
<?php
$plot_land_area = array(
	'type' => 'text',
	'name' => 'plot_land_area',
	'id' => 'plot_land_area',
	'value' => set_value('plot_land_area', $plot_lan_area_size),
	'size' => '30',
	'class' => '',
	'style'=>'width:70px',
	'onkeypress'=>'return numbersonly(event)',
); 
echo form_input($plot_land_area);
?> -->
<div class="error"><?php //echo form_error('password'); ?></div>
</div>
</div>
<!-- <div class="control-group">
<label class="control-label" for="textarea">Uncovered area (m²):
</label>
<div class="controls">
<?php
$uncover_area = array(
	'type' => 'text',
	'name' => 'uncover_area',
	'id' => 'uncover_area',
	'value' => set_value('uncover_area', $uncover_area_size),
	'size' => '30',
	'class' => '',
	'style'=>'width:70px',
	'onkeypress'=>'return numbersonly(event)',
); 
echo form_input($uncover_area);
?>
 &nbsp;Total area (m²):
<?php
$totle_area = array(
	'type' => 'text',
	'name' => 'totle_area',
	'id' => 'totle_area',
	'value' => set_value('totle_area', $totale_area_size),
	'size' => '30',
	'class' => '',
	'style'=>'width:70px',
	'onkeypress'=>'return numbersonly(event)',
); 
echo form_input($totle_area);
?> 
<div class="error"><?php //echo form_error('password'); ?></div>
</div>
</div> -->
<div class="control-group">
<label class="control-label" for="textarea">Property Description :
</label>
<div class="controls">
<textarea id="short_desc" name="short_desc" value="<?php echo $short_decs;?>" width="500px"><?php echo $short_decs;?></textarea>
<div class="error"><?php //echo form_error('description'); ?></div>
</div>
</div>
<!--<div class="control-group">
<label class="control-label" for="textarea">Long Description :
</label>
<div class="controls">
<textarea id="long_decs" name="long_decs"  value="<?php echo $long_desc;?>" width="500px"><?php echo $long_desc;?></textarea>
<div class="error"><?php //echo form_error('description'); ?></div>
</div>
</div>-->
<?php
//if ($usrid=="") {
?>

<!--<div class="control-group">
<label class="control-label" for="textarea">Country
</label>
<div class="controls">
<?php
		$countryData =$this->user->getallCountry();		
		$selected = $contry_id;
		if($selected == "" || $selected == 0){
				$selected = 0;
		}
		$device = 'id="country_id" style="width: 255px"';
		echo form_dropdown('country_id', $countryData, $selected, $device);
?>
<div class="error"><?php //echo form_error('store_country'); ?></div>

</div>
</div>-->
<?php //}?>

<div class="control-group">
<label class="control-label" for="textarea">Status :
</label>

<div class="controls">
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
</div>
<?php if($check_val =='1'){
	$checked='true';
}else{
	$checked='';
} ?>
<div id="check_box_agreement">
<div class="control-group">
<label class="control-label">
</label>
<div class="controls">
<?php
$data = array(
    'name'        => 'checkbox1',
    'id'          => 'checkbox1',
    'value'       => 'accept',
    'checked'     => $checked,
    'style'       => 'margin:10px',
    );

echo form_checkbox($data);

?>Title Deeds / Planning Permission / Building Permission
<div class="error"><?php //echo form_error('password'); ?></div>
</div>
</div>
<div class="control-group">
<label class="control-label">
</label>
<div class="controls">
<?php
$data = array(
    'name'        => 'checkbox2',
    'id'          => 'checkbox2',
    'value'       => 'accept',
    'checked'     => $checked,
    'style'       => 'margin:10px',
    );

echo form_checkbox($data);

?>Signed Commission Agreement
<div class="error"><?php //echo form_error('password'); ?></div>
</div>
</div>
</div>
<?php //echo form_hidden('social', $social); ?>
<?php echo form_hidden('id', $id); ?>

<div class="control-group">

<div class="controls">

<?php
if ($id=="") {
	echo form_submit('submit', 'Add Property', "name='pro_add' class='btn span5'");
} else { 
	echo form_submit('submit', 'Update Property', "name='pro_up' class='btn span5'");
}
?>
<?php echo anchor('home/property_manage', 'Cancel', array('title' => 'Cancel', 'class' => 'btn span4')); ?>
</div>
</div>
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
        $(document).ready(function () {
         hide_agresive_div();
         		$("#link_url").cleditor({width:300});
        		$("#short_desc").cleditor({width:300}); 
        		//$("#long_decs").cleditor({width:300});		
        });
</script>