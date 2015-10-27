<?php
$this->load->view('header');



if (isset($user_pass[0])) {
	$new_password = '';
    $conf_password = '';
    $password = '';
    $old_password = $user_pass[0]->password;
    $id = $user_pass[0]->id;
} else {
    $new_password = $this->input->post('new_password');
    $conf_password = $this->input->post('conf_password');
    $password = $this->input->post('password');
	$old_password = $this->input->post('old_password');
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
<li><?php echo anchor('home/change_password', 'Change Password', "title='Change Password'"); ?>

<span class="divider">
</span></li>
</ul>
</div>
</div>

 <?php if ($this->session->flashdata('pass_change_success')) { ?>
	<div class="alert alert-success" role="alert">
		<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<?php echo $this->session->flashdata('pass_change_success'); ?>
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
<span>Change Password</span>
</div>

<div class="row-fluid">

<div class="utopia-widget-content">

<div class="span6 utopia-form-freeSpace">

<?php echo form_open('verification/change_password', array('class' => 'form-horizontal')); ?>
 <input type="hidden" id="change_pass_id" name="change_pass_id" value="<?php if(isset($id) && !empty($id)){ echo $id; } ?>">
	  
<fieldset>
<div class="control-group">
<label class="control-label" for="textarea">Current Password
</label>

<div class="controls">
<?php
	$pass_arr = array(
		'type' => 'password',
		'name' => 'password',
		'id' => 'password',
		'value' => set_value('password', $password),
		'size' => '30',
		'class' => 'span10',
	);
	echo form_input($pass_arr);
	?>
<div class="error"><?php echo form_error('password'); ?></div>
</div>
</div>

<div class="control-group">
<label class="control-label" for="textarea">New Password
</label>

<div class="controls">
<?php
	$new_pass_arr = array(
		'type' => 'password',
		'name' => 'new_password',
		'id' => 'new_password',
		'value' => set_value('new_password', $new_password),
		'size' => '30',
		'class' => 'span10',
	);
	echo form_input($new_pass_arr);
	?>
<div class="error"><?php echo form_error('new_password'); ?></div>
</div>
</div>

<div class="control-group">
<label class="control-label" for="textarea">Confirm New Password
</label>

<div class="controls">
<?php
	$conf_pass_arr = array(
		'type' => 'password',
		'name' => 'conf_password',
		'id' => 'conf_password',
		'value' => set_value('conf_password', $conf_password),
		'size' => '30',
		'class' => 'span10',
	);
	echo form_input($conf_pass_arr);
                        ?>
<div class="error"><?php echo form_error('conf_password'); ?></div>
</div>
</div>


<?php echo form_hidden('old_password', $old_password); ?>





<div class="control-group">

<div class="controls">
	
	 <?php
					echo form_submit('submit', 'Change', 'class="btn span5"');
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
<script type="text/javascript" src="<?php echo base_url(); ?>js/change_password.js"></script>
<?php
$this->load->view('footer');
?>
