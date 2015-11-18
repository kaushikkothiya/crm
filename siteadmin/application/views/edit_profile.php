<?php
$this->load->view('header');
$this->load->view('leftmenu');
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
 	<?php if ($this->session->flashdata('success')) { ?>
                <div class="alert alert-success" role="alert">
                    <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <?php echo $this->session->flashdata('success'); ?>
                </div>
            <?php } ?>
    <div class="row">
      <div class="main">
      	<?php if ($this->uri->segment(3)) { ?>
    		<h1 class="page-header">Edit Profile</h1>
		<?php } else { ?>
    		<h1 class="page-header">Edit Profile</h1>
		<?php } ?>
        
        <div class="row">
          <div class="col-sm-12">
            <div class="panel panel-default">
            	<?php if ($this->uri->segment(3)) { ?>
    				<div class="panel-heading">Edit Profile</div>
              	<?php } else { ?>
    				<div class="panel-heading">Edit Profile</div>

              	<?php } ?>
        
              <div class="panel-body">
               <?php echo form_open_multipart('home/edit_profile', array('class' => 'form-horizontal')); ?>
			   	<input type="hidden" id="user_id" name="user_id" value="<?php if(isset($id) && !empty($id)){ echo $id; } ?>">
			   	<?php  
					 echo form_hidden('id', $id);
					 echo form_hidden('type',$type); 
				?>
				  <div class="form-group">
                    <label class="col-md-3 col-sm-4 control-label">First Name :</label>
                    <div class="col-sm-6">
	                   <?php
							$fname = array(
								'name' => 'fname',
								'id' => 'fname',
								'value' => set_value('fname', $fname),
								'class' => 'form-control',
							);
							echo form_input($fname);
							?>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-3 col-sm-4 control-label">Last Name :</label>
                    <div class="col-sm-6">
	                    <?php
							$lname = array(
								'name' => 'lname',
								'id' => 'lname',
								'value' => set_value('lname', $lname),
								'class' => 'form-control',
							);
							echo form_input($lname);
						?>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-3 col-sm-4 control-label">Email :</label>
                    <div class="col-sm-6">
                      	<?php
							$email = array(
								'name' => 'email',
								'id' => 'email',
								'value' => set_value('email', $email),
								'class' => 'form-control',
								);
							echo form_input($email);
						?>
                    </div>
                  </div>
                  <!--<div class="form-group">
                    <label class="col-md-3 col-sm-4 control-label">Set Password :</label>
                    <div class="col-sm-6">
                      <?php
							$password = array(
								'type' => 'text',
								'name' => 'password',
								'id' => 'password',
								'value' => "",
								'class' => 'form-control',
							);
							echo form_input($password);
							if($this->uri->segment(3)) {
						?>
						Note: If you enter password then your current password will be reset.
						<?php }?>
                    </div>
                  </div>-->
                  <div class="form-group">
                    <label class="col-md-3 col-sm-4 control-label"> City :</label>
                    <div class="col-sm-6">
                    	<?php
							$citydata =$this->user->getallcity();

							$selected = $city_id;
							if($selected == "" || $selected == 0){
									$selected = 0;
							}
							$device = 'id="city_id" class="form-control"';
							echo form_dropdown('city_id', $citydata, $selected, $device);
						?>
                      </div>
                  </div>
                   <div class="form-group">
                        <label class="col-md-3 col-sm-4 control-label">Mobile :</label>
                        <div class="col-sm-2 col-md-2">
                        <?php
							$country =$this->user->getall_countrycode();
							$selected = $county_code;

							if($selected =="0" || $selected==""){
								$selected = 24;
							}
							$device = 'id="county_code" class="form-control"';
							echo form_dropdown('county_code', $country, $selected, $device);
						?>	
                        </div>
                        <div class="visible-xs">&nbsp;</div>
                        <div class="col-sm-4 col-md-4">
                        <?php
	                        $contact = array(

							'name' => 'mobile_no',
							'id' => 'mobile_no',
							'value' => set_value('mobile_no', $contact),
							'class' => 'form-control',
							'maxlength' =>"10",
							'onkeypress'=>'return numbersonly(event)'
							);
							echo form_input($contact);
						?>	
                          <small>(example: 97888555)</small>
                    	</div>
                    </div>
                    
                  <div class="form-group">
                    <label class="col-md-3 col-sm-4 control-label">Status :</label>
                    <div class="col-sm-6">
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
							<?php echo form_radio($status, 'Active', $checked2, 'class="required"'); ?>
							Active</label> 
						<label class="radio">
							<?php echo form_radio($status, 'Inactive', $checked1, 'class="required"'); ?>
							Inactive
						</label>
                      
                    </div>
                  </div>
                  
	              <div class="form-group">
                    <label class="col-md-3 col-sm-4 control-label">&nbsp;</label>
                    <div class="col-sm-6">
                    <input type="submit" class="btn btn-sm btn-primary" value="Update Profile" name="agent_form" id="agent_form">
                    <?php  
                     echo anchor('home', 'Cancel', array('title' => 'Cancel', 'class' => 'btn btn-sm btn-default')); ?> 
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
<script type="text/javascript" src="<?php echo base_url(); ?>js/edit_profile.js"></script>
<script type="text/javascript">
</script>