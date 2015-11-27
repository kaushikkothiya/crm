<?php 
if($this->uri->segment(3)) {
     $property_id= $this->uri->segment(3);
}else{
	$property_id="";
}
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
 	<div class="row">
      <div class="main">
      	<?php if ($this->session->flashdata('success')) { ?>
                <div class="alert alert-success" role="alert">
                    <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <?php echo $this->session->flashdata('success'); ?>
                </div>
            <?php } ?>
    
      		<h1 class="page-header">Create Client</h1>
		<div class="row">
          <div class="col-sm-12">
            <div class="panel panel-default">
            		<div class="panel-heading">Create New Client</div>
			<div class="panel-body">
               <?php
				if(!empty($property_id)){
				echo form_open_multipart('home/sendNewClientInquiry', array('class' => 'form-horizontal')); 	
				}else{
				 echo form_open_multipart('verification/new_client_customer_details', array('class' => 'form-horizontal')); 
				}
				 ?>	
				 <input type="hidden" id="customer_id" name="customer_id" value="<?php if(isset($id) && !empty($id)){ echo $id; } ?>">
			   	<?php  
					echo form_hidden('id', $id);
					echo form_hidden('status', 'Active'); 
					echo form_hidden('property_id', $property_id);
				?>
				<div class="form-group">
                    <label class="col-md-3 col-sm-4 control-label">Reference From :</label>
                    <div class="col-sm-6">
                    	<?php
							$reference_from =array('1'=>'Phone inquiry','2'=>'Facebook inquiry','3'=>'Website inquiry');
							$device = 'id="reference_from"class="form-control"';
							echo form_dropdown('reference_from', $reference_from, '',  $device);
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
								$citydata =$this->inquiry_model->getallcity();

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
								'maxlength' =>"10",
								'class' => 'form-control',
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
							$status = array('id' => 'aquired', 'name' => 'aquired');
							?>
							<label class="radio-inline">
							<?php echo form_radio($status, 'sale','checked' , 'class="radio_buttons required"'); ?>
							Sale</label>
							<label class="radio-inline">
							<?php echo form_radio($status, 'rent', '', 'class="radio_buttons required"'); ?>
							Rent</label>
							<label class="radio-inline">
							<?php echo form_radio($status, 'both', '', 'class="radio_buttons required"'); ?>
							Both</label>
                   	</div>
                 </div>
 
	              <div class="form-group">
                    <label class="col-md-3 col-sm-4 control-label">&nbsp;</label>
                    <div class="col-sm-6">
                    <?php
					if ($id=="") {
					?>
					<input type="submit" class="btn btn-sm btn-primary" value="Add Client" name="customer_form" id="customer_form">
					<!-- <input type="submit" class="btn span5" value="Add Client" name="customer_form" id="customer_form"> -->
					<?php } else { 
					?>
					<input type="submit" class="btn span5" value="Update Client" name="customer_form" id="customer_form">
					<?php
					}
					?>
					<?php echo anchor('inquiry/new_exist_client', 'Cancel', array('title' => 'Cancel', 'class' => 'btn btn-sm btn-default')); ?>
                     
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