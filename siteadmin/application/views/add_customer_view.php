<?php

$this->load->view('header');
$this->load->view('leftmenu');
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
	$aquired = trim($user[0]->aquired);
	$reference_id = $user[0]->reference_from;
	$county_code = $user[0]->coutry_code;

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
    $aquired = $this->input->post('aquired');
    $reference_id = $this->input->post('reference_from');
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
    		<h1 class="page-header">Edit Client</h1>
		<?php } else { ?>
    		<h1 class="page-header">Create Client</h1>
		<?php } ?>
        
        <div class="row">
          <div class="col-sm-12">
            <div class="panel panel-default">
            	<?php if ($this->uri->segment(3)) { ?>
    				<div class="panel-heading">Edit Client</div>
              	<?php } else { ?>
    				<div class="panel-heading">Create New Client</div>

              	<?php } ?>
        
              <div class="panel-body">
               <?php echo form_open_multipart('verification/create_customer', array('class' => 'form-horizontal')); ?>
			   	<input type="hidden" id="customer_id" name="customer_id" value="<?php if(isset($id) && !empty($id)){ echo $id; } ?>">
			   	<?php  
					echo form_hidden('type','2'); 
					echo form_hidden('id', $id);
				?>
				<div class="form-group">
                    <label class="col-md-3 col-sm-4 control-label">Reference From :</label>
                    <div class="col-sm-6">
                    	<?php
							$reference_from =array('1'=>'Phone inquiry','2'=>'Facebook inquiry','3'=>'Website inquiry');
							$selected = $reference_id;
							if($selected == "" || $selected == 0){
									$selected = 1;
							}
							$device = 'id="reference_from" class="form-control"';
							echo form_dropdown('reference_from', $reference_from, $selected,  $device);
						?>
                    </div>
                </div>

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
								//'onblur' => "customer_EmailFunction();"
							);
							echo form_input($email);
						?>
                    </div>
                  </div>
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
							echo form_dropdown('city_id', $citydata, $selected,  $device);
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
                    <label class="col-md-3 col-sm-4 control-label">Property Status :</label>
                    <div class="col-sm-6">
                    	<?php 
							$aquired_id = array('id' => 'aquired', 'name' => 'aquired');
							if($this->input->post('aquired')=="sale" || $aquired=="sale") {
							    $checked1 = 'checked="checked"';	
							    $checked2 = '';
							    $checked3 = '';
							} elseif ($this->input->post('aquired')=="rent" || $aquired=="rent") {
							    $checked1 = '';
							    $checked2 = 'checked="checked"';
							    $checked3 = '';
							} elseif ($this->input->post('aquired')=="both" || $aquired=="both"){
							    $checked1 = '';
							    $checked2 = '';
							    $checked3 = 'checked="checked"';
							}
							else{
							    $checked1 = 'checked="checked"';
							    $checked2 = '';
							    $checked3 = '';
							}
						?>
						<label class="radio">
							<?php echo form_radio($aquired_id, 'sale',$checked1 , 'class="radio_buttons required"'); ?>
							Sale</label>
							<label class="radio">
							<?php echo form_radio($aquired_id, 'rent', $checked2, 'class="radio_buttons required"'); ?>
							Rent</label>
							<label class="radio">
							<?php echo form_radio($aquired_id, 'both', $checked3, 'class="radio_buttons required"'); ?>
							Both</label>
							
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
                    <?php
						if ($id=="") {
 					?>
 					 <input type="submit" class="btn btn-sm btn-primary" value="Add Client" name="customer_form" id="customer_form">
                    <?php } else { ?>  	
                    <input type="submit" class="btn btn-sm btn-primary" value="Update Client" name="customer_form" id="customer_form">
                    <?php } 
                     echo anchor('home/customer_manage', 'Cancel', array('title' => 'Cancel', 'class' => 'btn btn-sm btn-default')); ?> 
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