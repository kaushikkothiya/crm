<?php
if($this->uri->segment(3)) {
                $property_id= $this->uri->segment(3);
}else{
	$property_id="";
}
$this->load->view('header');

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
<li><?php echo anchor('inquiry/exist_client', 'Search Existing Client', "title='Search Existing Client'"); ?>
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
    Search Existing Client
<?php } else { ?>
    Search Existing Client
<?php } ?>
</span>
</div>
<div class="row-fluid">
<div class="utopia-widget-content">
<div class="span6 utopia-form-freeSpace">
<?php
if(!empty($property_id)){
echo form_open_multipart('home/sendNewClientInquiry_exist_client', array('class' => 'form-horizontal')); 	
}else{ 
echo form_open_multipart('inquiry/property', array('class' => 'form-horizontal'));
}
 ?>
<fieldset>
	
<div class="control-group">
<label class="control-label" for="textarea">Email or Mobile Phone
</label>
<div class="controls">
<?php
$email = array(
	'name' => 'email_mobile',
	'id' => 'email_mobile',
	//'value' => set_value('email', $email),
	'placeholder'=>"Enter Email or Mobile Phone",
	'size' => '30',
	'class' => 'span10',
	//'onblur' => "customer_EmailFunction();"
);
echo form_input($email);
?>
<div class="error"><?php //echo form_error('email'); ?></div>
</div>
</div>
<div class="control-group">
<label class="control-label" for="textarea">Property Status :
</label>

<div class="controls">
<?php 
$status = array('id' => 'aquired', 'name' => 'aquired');
?>
<label class="radio">
<?php echo form_radio($status, 'sale', 'checked', 'class="radio_buttons required"'); ?>
Sale</label>
<label class="radio">
<?php echo form_radio($status, 'rent','', 'class="radio_buttons required"'); ?>
Rent</label>
<label class="radio">
<?php echo form_radio($status, 'both','', 'class="radio_buttons required"'); ?>
Both</label>

<div class="error"><?php //echo form_error('status'); ?></div>

</div>

</div>
<?php echo form_hidden('property_id', $property_id); ?>

<div class="control-group">

<div class="controls">


<input type="submit" class="btn span5" value="Search" name="customer_form1" id="customer_form1">
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

<script type="text/javascript" src="<?php echo base_url(); ?>js/exist_customer.js"></script>
<script type="text/javascript">
</script>