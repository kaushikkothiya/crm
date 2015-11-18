<?php
$this->load->view('header');
$this->load->view('leftmenu');
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
    <div class="row">
      <div class="main">
      		<h1 class="page-header">Change Password</h1>
		<div class="row">
          <div class="col-sm-12">
            <div class="panel panel-default">
            		<div class="panel-heading">Change Password</div>
              <div class="panel-body">
               <?php echo form_open('verification/change_password', array('class' => 'form-horizontal')); ?>
 				<input type="hidden" id="change_pass_id" name="change_pass_id" value="<?php if(isset($id) && !empty($id)){ echo $id; } ?>">
			   	<?php  
					echo form_hidden('old_password', $old_password); 
				?>
				  <div class="form-group">
                    <label class="col-md-3 col-sm-4 control-label">Current Password :</label>
                    <div class="col-sm-6">
	                    <?php
							$pass_arr = array(
								'type' => 'password',
								'name' => 'password',
								'id' => 'password',
								'value' => set_value('password', $password),
								'class' => 'form-control',
							);
							echo form_input($pass_arr);
							?>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-3 col-sm-4 control-label">New Password :</label>
                    <div class="col-sm-6">
	                    <?php
							$new_pass_arr = array(
								'type' => 'password',
								'name' => 'new_password',
								'id' => 'new_password',
								'value' => set_value('new_password', $new_password),
								'class' => 'form-control',
							);
							echo form_input($new_pass_arr);
							?>
                    </div>
                  </div>
                  
                  <div class="form-group">
                    <label class="col-md-3 col-sm-4 control-label">Confirm New Password :</label>
                    <div class="col-sm-6">
                    	<?php
							$conf_pass_arr = array(
								'type' => 'password',
								'name' => 'conf_password',
								'id' => 'conf_password',
								'value' => set_value('conf_password', $conf_password),
								'class' => 'form-control',
							);
							echo form_input($conf_pass_arr);
						?>
                      </div>
                  </div>
                  
	              <div class="form-group">
                    <label class="col-md-3 col-sm-4 control-label">&nbsp;</label>
                    <div class="col-sm-6">
                    <input type="submit" class="btn btn-sm btn-primary" value="Change" name="" id="">
                    <?php
						echo anchor('home', 'Cancel', array('title' => 'Cancel', 'class' => 'btn btn-sm btn-default')); 
					?>
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
<?php
$this->load->view('footer');
?>
<script type="text/javascript" src="<?php echo base_url(); ?>js/change_password.js"></script>