<?php

    
$this->load->view('header');
if (isset($user[0])) {
    $id = $user[0]->id;
    $fname = $user[0]->fname;
	$lname = $user[0]->lname;
	$email = $user[0]->email;
	$password =$user[0]->password;
	$contact = $user[0]->mobile_no;
	$city_id = $user[0]->city_id;
	$contry_id = $user[0]->contry_id;
	$status_name = $user[0]->status;
	$type = $user[0]->type;
	$county_code = $user[0]->coutry_code;
	
} else {
    $id = $this->input->post('id');
    $fname = $this->input->post('fname');
    $lname = $this->input->post('lname');
	$email = $this->input->post('email');
	//$password = $this->input->post('password');
	$contact = $this->input->post('mobile_no');
	$city_id = $this->input->post('city_id');
	$county_code = $this->input->post('county_code');
	//$contry_id = $this->input->post('contry_id');
	//$status_name = $this->input->post('status');
    
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
<li><?php echo anchor('home/edit_profile', 'Edit Profile', "title='Edit Profile'"); ?>
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
    Edit Profile
<?php }  ?>
</span>
</div>
<div class="row-fluid">
<div class="utopia-widget-content">
<div class="span6 utopia-form-freeSpace">
<?php echo form_open_multipart('home/edit_profile', array('class' => 'form-horizontal')); ?>
<fieldset>
<div class="control-group">
<label class="control-label" for="textarea">First Name :
</label>

<div class="controls">
	<input type="hidden" id="user_id" name="user_id" value="<?php if(isset($id) && !empty($id)){ echo $id; } ?>">
	<?php  
	//if ($this->session->userdata('logged_in_super_user'))
	//{
	//	echo form_hidden('type','1');  
	//}else if($this->session->userdata('logged_in_super_user'))
	//{ 
		echo form_hidden('type',$type); 
	 //}else if($this->session->userdata('logged_in_super_user'))
	 //{
	 	//echo form_hidden('type','3'); 
	 //}
	  ?>
	
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
);
echo form_input($lname);
?>
<div class="error"><?php //echo form_error('lname'); ?></div>
</div>
</div>

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
	//'onblur' => "EmailFunction();"
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
<label class="control-label" for="textarea">Set Password :
</label>
<div class="controls">
<?php
$password = array(
	'type' => 'text',
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
		$device = 'id="city_id" style="width: 255px"';
		echo form_dropdown('city_id', $citydata, $selected, $device);
?>
<div class="error"><?php //echo form_error('store_country'); ?></div>

</div>
</div>
<?php //}?>
<div class="control-group">
<label class="control-label" for="textarea">Mobile :
</label>
<div class="controls">
<?php
$country =$this->user->getall_countrycode();
		$selected = $county_code;

		if($selected =="0" || $selected==""){
			$selected = 24;
		}
		$device = 'id="county_code" style="width: 100px; float:left; margin-right:5px; "';
		echo form_dropdown('county_code', $country, $selected, $device);

$contact = array(

	'name' => 'mobile_no',
	'id' => 'mobile_no',
	'value' => set_value('mobile_no', $contact),
	'size' => '30',
	'class' => 'span6',
	'maxlength' =>"10",
	//'onkeypress'=>'return numbersonly(event)'
);
echo form_input($contact);
?>
(eg  0123456987)
<div class="error"><?php //echo form_error('mobile_no'); ?></div>
</div>


</div>
<!--<div class="control-group">
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

</div>-->
<?php //echo form_hidden('social', $social); ?>
<?php echo form_hidden('id', $id); ?>

<div class="control-group">

<div class="controls">


	<!--echo form_submit('submit', 'Update Agent', $form_id);-->
	 <input type="submit" class="btn span5" value="Update" name="agent_form" id="agent_form">
	 
<?php echo anchor('home', 'Cancel', array('title' => 'Cancel', 'class' => 'btn span4')); ?>
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

<script type="text/javascript" src="<?php echo base_url(); ?>js/edit_profile.js"></script>
<script type="text/javascript">


</script>