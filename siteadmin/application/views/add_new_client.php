<?php 
if($this->uri->segment(3)) {
                $property_id= $this->uri->segment(3);
}else{
	$property_id="";
}
$this->load->view('header');
if (isset($user[0])) {
    $id = $user[0]->id;
    $fname = $user[0]->fname;
	$lname = $user[0]->lname;
	$email = $user[0]->email;
	$password = $user[0]->password;
	$contact = $user[0]->mobile_no;
	$city_id = $user[0]->city_id;
	$contry_id = $user[0]->contry_id;
	$status_name = $user[0]->status;
	$county_code = $user[0]->coutry_code;
	//$aquired = trim($user[0]->aquired);
} else {
    $id = $this->input->post('id');
    $fname = $this->input->post('fname');
    $lname = $this->input->post('lname');
	$email = $this->input->post('email');
	$password = $this->input->post('password');
	$contact = $this->input->post('mobile_no');
	$city_id = $this->input->post('city_id');
	$contry_id = $this->input->post('contry_id');
	$status_name = $this->input->post('status');
	$county_code = $this->input->post('county_code');
    //$aquired = $this->input->post('aquired');
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
<li><?php echo anchor('inquiry/new_client', 'Add New Client', "title='Add New Client'"); ?>
<span class="divider">
</span></li>
<?php if ($this->uri->segment(3)) { ?>
<li><?php //echo anchor('home/add_customer/'.$id, 'Edit Customer', "title='Edit Customer'"); ?> 
<?php } else { ?>
<li><?php //echo anchor('home/add_customer', 'Add Customer', "title='Add Customer'"); ?> 
<?php } ?>
<span class="divider">
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
    Edit Client
<?php } else { ?>
    Add New Client
<?php } ?>
</span>
</div>
<div class="row-fluid">
<div class="utopia-widget-content">
<div class="span6 utopia-form-freeSpace">
	
<?php
if(!empty($property_id)){
echo form_open_multipart('home/sendNewClientInquiry', array('class' => 'form-horizontal')); 	
}else{
 echo form_open_multipart('verification/new_client_customer_details', array('class' => 'form-horizontal')); 
}
 ?>
<fieldset>
	<input type="hidden" id="customer_id" name="customer_id" value="<?php if(isset($id) && !empty($id)){ echo $id; } ?>">

<div class="control-group">
<label class="control-label" for="textarea">Reference From
</label>
<div class="controls">
<?php
		$reference_from =array('1'=>'Phone inquiry','2'=>'Facebook inquiry','3'=>'Website inquiry');
		$device = 'id="reference_from" style="width: 255px"';
		echo form_dropdown('reference_from', $reference_from, '',  $device);
?>
<div class="error"><?php //echo form_error('store_country'); ?></div>

</div>
</div>	
<div class="control-group">
<label class="control-label" for="textarea">First Name
</label>

<div class="controls">
<?php
$fname = array(
	'name' => 'fname',
	'id' => 'fname',
	'value' => set_value('fname', $fname),
	'size' => '30',
	'class' => 'span10',
);

echo form_input($fname);

?>
<div class="error"><?php //echo form_error('fname'); ?></div>
</div>
</div>

<div class="control-group">
<label class="control-label" for="textarea">Last Name
</label>
<div class="controls">
<?php
$lname = array(
	'name' => 'lname',
	'id' => 'lname',
	'value' => set_value('lname', $lname),
	'size' => '30',
	'class' => 'span10',
);
echo form_input($lname);
?>
<div class="error"><?php //echo form_error('lname'); ?></div>
</div>
</div>

<div class="control-group">
<label class="control-label" for="textarea">Email
</label>
<div class="controls">
<?php
$email = array(
	'name' => 'email',
	'id' => 'email',
	'value' => set_value('email', $email),
	'size' => '30',
	'class' => 'span10',
	//'onblur' => "customer_EmailFunction();"
);
echo form_input($email);
?>
<div class="error"><?php //echo form_error('email'); ?></div>
</div>
</div>
<?php
//if ($usrid=="") {
?>
<!--<div class="control-group">
<label class="control-label" for="textarea">Set New Password
</label>
<div class="controls">
<?php
$password = array(
	'name' => 'password',
	'id' => 'password',
	'value' => "",
	'size' => '30',
	'class' => 'span10',
);
echo form_input($password);
if($this->uri->segment(3)) {
?>
Note: If you enter password then your current password will be reset.
<?php }?>
<div class="error"><?php //echo form_error('password'); ?></div>
</div>
</div>-->
<?php //}?>
<div class="control-group">
<label class="control-label" for="textarea">City
</label>
<div class="controls">
<?php
		$citydata =$this->inquiry_model->getallcity();

		$selected = $city_id;
		if($selected == "" || $selected == 0){
				$selected = 0;
		}
		$device = 'id="city_id" style="width: 255px"';
		echo form_dropdown('city_id', $citydata, $selected,  $device);
?>
<div class="error"><?php //echo form_error('store_country'); ?></div>

</div>
</div>
<!--<div class="control-group">
<label class="control-label" for="textarea">City
</label>
<div class="controls">
<?php
		$citydata =$this->inquiry_model->getallcity();

		$selected = $city_id;
		if($selected == "" || $selected == 0){
				$selected = 0;
		}
		$device = 'id="city_id" style="width: 255px"';
		echo form_dropdown('city_id', $citydata, $selected,  $device);
?>
<div class="error"><?php //echo form_error('store_country'); ?></div>

</div>
</div>-->
<div class="control-group">
<label class="control-label" for="textarea">Mobile
</label>
<div class="controls">
<?php
$country =$this->user->getall_countrycode();
		$selected = $county_code;

		if($selected =="0" || $selected==""){
			$selected = 24;
		}
		$device = 'id="county_code" style="width: 94px; float:left; margin-right:5px; "';
		echo form_dropdown('county_code', $country, $selected, $device);
$contact = array(
	//'type'=>'number',
	'name' => 'mobile_no',
	'id' => 'mobile_no',
	'value' => set_value('mobile_no', $contact),
	'size' => '30',
	'class' => 'span6 phonefld2',
	'maxlength' =>"10",
	//'min' =>'10',
	//'max' =>'10',	
	'onkeypress'=>'return numbersonly(event)'
);
echo form_input($contact);
?>
<span style="margin-left:105px;">(example: 97888555)</span>
<div class="error"><?php //echo form_error('mobile_no'); ?></div>
</div>
</div>
<div class="control-group">
<label class="control-label" for="textarea">Property Status :
</label>

<div class="controls">
<?php 
$status = array('id' => 'aquired', 'name' => 'aquired');
// if($this->input->post('aquired')=="rent" || $aquired=="rent") {
//     $checked1 = 'checked="checked"';	
//     $checked2 = '';
// } elseif ($this->input->post('aquired')=="buy" || $aquired=="buy") {
//     $checked1 = '';
//     $checked2 = 'checked="checked"';
// } else {
//     $checked1 = '';
//     $checked2 = 'checked="checked"';
// }
?>
<label class="radio">
<?php echo form_radio($status, 'sale','checked' , 'class="radio_buttons required"'); ?>
Sale</label>
<label class="radio">
<?php echo form_radio($status, 'rent', '', 'class="radio_buttons required"'); ?>
Rent</label>
<label class="radio">
<?php echo form_radio($status, 'both', '', 'class="radio_buttons required"'); ?>
Both</label>

<div class="error"><?php //echo form_error('status'); ?></div>

</div>

</div>
<div class="control-group">
<label class="control-label" for="textarea">Status
</label>

<?php echo form_hidden('status', 'Active'); ?>
<!-- <div class="controls">
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

</div> -->
<?php //echo form_hidden('social', $social); ?>
<?php echo form_hidden('id', $id); ?>
<?php echo form_hidden('property_id', $property_id); ?>

<div class="control-group">

<div class="controls">

<?php
if ($id=="") {
	//echo form_submit('submit', 'Create Customer', "class='btn span5'");
?>
<input type="submit" class="btn span5" value="Add Client" name="customer_form" id="customer_form">
<?php } else { 
	//echo form_submit('submit', 'Update Customer', "class='btn span5'");
?>
<input type="submit" class="btn span5" value="Update Client" name="customer_form" id="customer_form">
<?php
}
?>
<?php echo anchor('inquiry/new_exist_client', 'Cancel', array('title' => 'Cancel', 'class' => 'btn span4')); ?>
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

<script type="text/javascript" src="<?php echo base_url(); ?>js/customer.js"></script>
<script type="text/javascript">
function numbersonly(e){ 	 
    var unicode=e.charCode? e.charCode : e.keyCode;    
    
    if (unicode!=8){ //if the key isn't the backspace key (which we should allow)
    
        if ((unicode<48||unicode>57) && unicode!=46 ) //if not a number
            return false //disable key press
    }
}
</script>