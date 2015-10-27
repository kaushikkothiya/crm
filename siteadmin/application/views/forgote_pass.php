<?php
$this->load->view('header');
?>
<div class="container-fluid">
<div class="row-fluid">
<div class="span12">
</div>
</div>
<div class="row-fluid">
<div class="">
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

</div>
</div>
<div class="span10 body-container">
<div class="row-fluid">
 <?php if ($this->session->flashdata('success')) { ?>
	<div class="alert alert-success" role="alert">
		<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<?php echo $this->session->flashdata('success'); ?>
	</div>
<?php } ?>
 <?php  if (isset($msg) && $msg!=""){ ?>
	<div class="alert alert-error" role="alert">
		<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<?php echo $msg; ?>
	</div>
<?php } ?>

<div class="row-fluid">

<div class="span12"><section id="formElement" class="utopia-widget utopia-form-box section">

<div class="utopia-widget-title">
<span>Forgot Password!</span>
</div>

<div class="row-fluid">

<div class="utopia-widget-content">

<div class="span6 utopia-form-freeSpace">
<?php echo form_open('verification/forgote_password', array('class' => 'form-horizontal')); ?>

<fieldset>
<div class="control-group">
<label class="control-label" for="textarea">Email
</label>

<div class="controls">
<?php
	$pass_arr = array(
		'type' => 'text',
		'name' => 'email',
		'id' => 'email',
		'placeholder' =>"Please enter your email",
		'value' => '',
		'size' => '30',
		'class' => 'span10',
	);
	echo form_input($pass_arr);
	?>
	<div class="error"><?php //echo form_error('conf_password'); ?></div>
</div>
</div>

<!--<div class="control-group">
<label class="control-label" for="textarea">New Password
</label>

<div class="controls">
<?php
	$new_pass_arr = array(
		'type' => 'password',
		'name' => 'new_password',
		'id' => 'new_password',
		'value' => '',
		'size' => '30',
		'class' => 'span10',
	);
	echo form_input($new_pass_arr);
	?>
	<div class="error"><?php //echo form_error('conf_password'); ?></div>
</div>
</div>-->

<!--<div class="control-group">
<label class="control-label" for="textarea">Confirm New Password
</label>

<div class="controls">
<?php
	$conf_pass_arr = array(
		'type' => 'password',
		'name' => 'conf_password',
		'id' => 'conf_password',
		'value' => '',
		'size' => '30',
		'class' => 'span10',
	);
	echo form_input($conf_pass_arr);
                        ?>
<div class="error"><?php //echo form_error('conf_password'); ?></div>
</div>
</div>-->





<div class="control-group">

<div class="controls">
	
	 <?php
					echo form_submit('submit', 'submit', 'class="btn span5"');
					?>
<?php echo anchor('home', 'Cancel', array('title' => 'Cancel', 'class' => 'btn span4')); ?>

</div>
</div>

</fieldset>
</form>

</div>

<div class="span6 utopia-form-freeSpace">


</div>
</div>
</div></section>
</div>
</div>
</div>
</div>
</div>
<script type="text/javascript" src="<?php echo base_url(); ?>js/forgote_password.js"></script>

