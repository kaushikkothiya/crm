<?php

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
        <link href="<?php echo base_url(); ?>css/popupbox.css" rel="stylesheet">
        <div class="span10 body-container">
            <div class="row-fluid">
                <div class="span12">
                    <ul class="breadcrumb">
                        <li><?php echo anchor('home', 'Home', "title='Home'"); ?>
                            <span class="divider">/
                            </span></li>
                        <li><?php echo anchor('home/property_manage', 'Property Management', "title='Property Management'"); ?>
                            <span class="divider">
                            </span></li>
								<li style="float:right;"><a href="add_property"><input type="button" value="Add New" /></a></li>
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
                <div class="span12"><section class="utopia-widget">
                        <div class="utopia-widget-title">
                            <span>Property Management </span>
                        </div>
                        <div class="utopia-widget-content">
                            <table id="example" class="display" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                       <th hidden>Id</th>
                                       <th>Reference No</th>
                                       <th>Agent Name</th>
                                       <th>Property Area</th>
                                       <th>Property Status</th>
                                       <th>Price(€)</th>
                                       <th>furnish type</th>
                                       <th>Image</th>
                                       <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    for ($i = 0; $i < count($user); $i++) {
                                        echo "<tr>";
                                        echo "<td hidden>" . $user[$i]->id. "</td>";
                                        echo "<td>" . $user[$i]->reference_no.'</br></br>Created on '.date("d-M-Y", strtotime($user[$i]->created_date)). "</td>";
                                        echo "<td>" . $user[$i]->fname.' '.$user[$i]->lname. "</td>";
                                        echo "<td>" . $user[$i]->title. "</td>";
                                        if($user[$i]->type =='1'){
                                            echo "<td>" .'Sale'. "</td>";
                                            echo "<td>" .'€'.$user[$i]->sale_price. "</td>";
                                            
                                        }elseif ($user[$i]->type =='2') {
                                           echo "<td>" .'Rent'. "</td>";
                                           echo "<td>" .'€'.$user[$i]->rent_price. "</td>";
                                        }elseif ($user[$i]->type =='3') {
                                           echo "<td>" .'Both(Sale/Rent)'. "</td>";
                                           echo "<td> SP. €". $user[$i]->sale_price." / RP. €".$user[$i]->rent_price. "</td>";
                                          
                                        }
                                        if($user[$i]->furnished_type =='1'){
                                            echo "<td> Furnished </td>";
                                            
                                        }elseif ($user[$i]->furnished_type =='2') {
                                           echo "<td> Semi-Furnished</td>";
                                        }elseif ($user[$i]->furnished_type =='3') {
                                           echo "<td>Un-Furnished </td>";
                                          
                                        }
                                        //echo "<td>" . substr($user[$i]->short_decs, 0, 20).".....</td>";
     									echo "<td>";
                                        echo '<img src="'.base_url().'upload/property/'.$user[$i]->image.'" width="75" height="75">';
                                        echo "</td>";
                                        echo "<td>";
                                            //echo "<span style='text-align:left;width: 50%;float: left;'><div class='box'><a class='button' href='#popup1' onClick='setPropertyId(".$user[$i]->id.")'>Send Inquiry</a></div><br>";
                                        echo "<span style='text-align:left;width: 50%;float: ;'><i class='icon-pencil'></i>".anchor('home/propertyExatraImages/'.$user[$i]->id, 'Extra Images')."<div class='box'><i class='icon-fast-forward'></i><a class='button' href='#popup1' onClick='setPropertyId(".$user[$i]->id.")'>Send Inquiry</a></div><br><i class='icon-pencil'></i>&nbsp;" . anchor('home/add_property/'.$user[$i]->id, 'Edit', "title='Edit agent'"). "</span>";
                                        $arrayName = array('target' => '_blank','title'=>'View Property Details' );?>&nbsp;&nbsp;&nbsp;<?php
                                        echo "<i class='icon-zoom-in'></i>&nbsp;" . anchor('home/view_property/'.$user[$i]->id, 'View',$arrayName )."  ";
                                        
                                        if ($this->session->userdata('logged_in_super_user')) {
                                        echo "<span style='text-align:left;width: 50%;float: ;'><i class='icon-trash'></i>&nbsp;" . anchor('home/delete_property/'.$user[$i]->id, 'Delete', array('onClick' => "return confirm('Are you sure want to delete this record?')")). "</span></td>";
                                        }
                                        echo "</tr>";

                                    }

                                    ?>
                                </tbody>
                            </table>
                        </div>   
                    </section>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="popup1" class="overlay">
    <div class="popup">
        <h2>Add New Client</h2>
        <a class="close" href="#">×</a>
        <div class="content">
            <div class="row-fluid">
              <div class="utopia-widget-content">
                <div class="span5 utopia-form-freeSpace">
                <?php echo form_open_multipart('home/sendNewClientInquiry', array('class' => 'form-horizontal')); ?>
                <fieldset>
                    <input type="hidden" id="property_id" name="property_id" value="">
                    <div class="control-group">
                        <label class="control-label" for="textarea">First Name
                        </label>

                        <div class="controls">
                            <?php
                            $fname = array(
                                'name' => 'fname',
                                'id' => 'fname',
                                'value' => "", //set_value('fname', $fname),
                                'size' => '30',
                                //'class' => 'span10',
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
                                //'value' => set_value('lname', $lname),
                                'size' => '30',
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
                                //'value' => set_value('email', $email),
                                'size' => '30',
                                //'onblur' => "customer_EmailFunction();"
                            );
                            echo form_input($email);
                            ?>
                            <div class="error"><?php //echo form_error('email'); ?></div>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="textarea">City
                        </label>
                        <div class="controls">
                            <?php
                                    $citydata =$this->inquiry_model->getallcity();

                                    $device = 'id="city_id" style="width: 255px"';
                                    echo form_dropdown('city_id', $citydata, $device);
                            ?>
                            <div class="error"><?php //echo form_error('store_country'); ?></div>

                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="textarea">Mobile
                        </label>
                        <div class="controls">
                            <?php
                            $country =$this->user->getall_countrycode();
                            $selected = 24;
                            $device = 'id="county_code" style="width: 100px; float:left; margin-right:5px; "';
                            echo form_dropdown('county_code', $country, $selected, $device);
                            $contact = array(
                                'name' => 'mobile_no',
                                'id' => 'mobile_no',
                                //'value' => set_value('mobile_no', $contact),
                                'style' => 'width:105px;',
                                'size' => '30',
                                'maxlength' =>"8",
                                'onkeypress'=>'return numbersonly(event)'
                            );
                            echo form_input($contact);
                            ?>
                            <br><span style="margin-left:105px;">(example: 97888555)</span>
                            <div class="error"><?php //echo form_error('mobile_no'); ?></div>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="textarea">Status :
                        </label>

                        <div class="controls">
                            <?php
                            $status = array('id' => 'status', 'name' => 'status');
                                $checked1 = '';
                                $checked2 = 'checked="checked"';
                            ?>
                            
                            <?php echo form_radio($status, 'Active', $checked2, 'class="radio_buttons required"'); ?>
                            Active
                            <?php echo form_radio($status, 'Inactive', $checked1, 'class="radio_buttons required"'); ?>
                            Inactive

                            <div class="error"><?php //echo form_error('status'); ?></div>

                        </div>

                    </div>
                    <div class="control-group">
                        <label class="control-label" for="textarea">Property Status :
                        </label>

                        <div class="controls">
                            <?php 
                                $status = array('id' => 'aquired', 'name' => 'aquired');
                            ?>
                           
                            <?php echo form_radio($status, 'sale','checked' , 'class="radio_buttons required"'); ?>
                            Sale
                            <?php echo form_radio($status, 'rent', '', 'class="radio_buttons required"'); ?>
                            Rent
                            <?php echo form_radio($status, 'both', '', 'class="radio_buttons required"'); ?>
                            Both                            <div class="error"><?php //echo form_error('status'); ?></div>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="textarea">Send By :
                        </label>

                        <div class="controls">
                            <select name="sendInquiryBy">
                                <option value="sendEmail">Email</option>
                                <option value="sendSms">SMS</option>
                                <option value="sendBoth">Both</option>
                            </select>
                        </div>
                    </div>

                    <div class="control-group">
                        <div class="controls">
                            <input type="submit" class="btn" value="Add Inquiry" name="inquiry_form" id="inquiry_form">
                        </div>
                    </div>
                </fieldset>
            </form>
                </div>
              </div>
            </div>
        </div>
    </div>
</div>
<?php
$this->load->view('footer');
?>
<script type="text/javascript">
function setPropertyId(propertyId)
{
    $("#property_id").val(propertyId);
}
function numbersonly(e){     
    var unicode=e.charCode? e.charCode : e.keyCode;    
    
    if (unicode!=8){ //if the key isn't the backspace key (which we should allow)
    
        if ((unicode<48||unicode>57) && unicode!=46 ) //if not a number
            return false //disable key press
    }
}
</script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/customer.js"></script>


