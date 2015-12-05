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
 

<div class="row-fluid">

<div class="span12"><section id="formElement" class="utopia-widget utopia-form-box section">

<div class="utopia-widget-title">
<span><p><h3>
<?php
                            $property_title =$this->user->get_property_title($inquiry);
                           
                           
                            if(!empty($property_title[0]->reference_no))
                            {
                                echo ' Property Reference Number: '.$property_title[0]->reference_no;
                            }
                            if(!empty($property_title[0]->bedroom))
                            {
                                echo ' '.$property_title[0]->bedroom.' Bathrooms';
                            }
                            if(!empty($property_title[0]->property_type))
                            {
                                echo ' '.get_propertytypeby_id($property_title[0]->property_type);
                            }
                            if(!empty($property_title[0]->type))
                            {
                                if($property_title[0]->type==1){
                                    echo ' Sale';
                                }elseif ($property_title[0]->type==2) {
                                    echo ' Rent';
                                }elseif ($property_title[0]->type==3) {
                                    echo ' Sale / Rent';
                                }
                            }
?>
</h3></p>   </span>
</div>
<link href="<?php echo base_url(); ?>css/popupbox.css" rel="stylesheet">
<div class="row-fluid">

<div class="utopia-widget-content">
<?php if ($this->session->flashdata('success')) { ?>
                <div class="alert alert-success" role="alert">
                    <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <?php echo $this->session->flashdata('success'); ?>
                </div>
            <?php }else if($this->session->flashdata('error')){ ?>
                <div class="alert alert-error" role="alert">
                    <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    
                    <?php echo $this->session->flashdata('error'); ?>
                </div>
            <?php } ?>
<div class="span6 utopia-form-freeSpace">
<?php echo form_open('home/final_appointment_conform', array('class' => 'form-horizontal')); ?>

<fieldset>
<input type="hidden" id="inquiry" name="inquiry" value="<?php echo $inquiry; ?>">
	<input type="hidden" id="inquiry" name="agent" value="<?php echo $agent; ?>">
<p><h3>Click on the link below to confirm, reschedule or cancel appointment</h3></p>

	 <?php
 echo "<span style='float:left; margin-right:5px;'>".form_submit('submit', 'Confirm Appointment', 'class="btn"')."</span>"; 
 echo "<span style='float:left; margin-right:5px;'>".form_submit('submit', 'Reschedule Appointment', 'class="btn"')."</span>";
 //echo anchor('home/appointment_conform/'.$inquiry.'/'.$agent, 'Cancel Appointment', 'data-toggle=modal data-target=#myModal');
 ?>
<button data-toggle="modal" data-target="#myModal" class="btn btn-sm fluid-btn"  type="button">cancel</button>
 <?php
 function get_propertytypeby_id($id)
    {
        
        $data['property_type'] = array('1'=>'Duplex','2' =>'Apartment','3' =>'Penthouse','4' =>'Garden Apartments','5'=>'Studio','6' =>'Townhouse','7' =>'Villa','8' =>'Bungalow','9'=>'Land','10' =>'Shop','11' =>'Office','12' =>'Business','13'=>'Hotel','14' =>'Restaurant','15' =>'Building','16' =>'Industrial estate','17' =>'House','18' =>'Upper-House','19' =>'Maisonette');
        return $data['property_type'][$id];

    }
 ?>

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
<div id="popup" class="overlay">
    <div class="popup">
        <h2>Agent Comment</h2>
        <a class="close" href="#">×</a>
        <div class="content">
            <div class="row-fluid">
              <div class="">
                <div class="">
                    <form name="excel_form" id="excel_form" method="post" action="<?php echo base_url(); ?>index.php/home/final_appointment_conform" enctype="multipart/form-data">
                
                <fieldset>
                    <hr>
                    <textarea col="20" row="3"name="comment" required id="comment"></textarea>
                    <input type="hidden" id="inquiry" name="inquiry" value="<?php echo $inquiry; ?>">
					<input type="hidden" id="inquiry" name="agent" value="<?php echo $agent; ?>">
                    <div id="hd_sub">
                    <input type="submit" class="pushme btn span2" name="submit" value="Submit" >
                    </div>
                    
                </fieldset>
            </form>
                </div>
              </div>
            </div>
        </div>
    </div>
</div>

<div  class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Agent Comment</h4>
      </div>
      <form name="excel_form" id="excel_form" method="post" action="<?php echo base_url(); ?>index.php/home/final_appointment_conform" enctype="multipart/form-data">
        <div class="modal-body">
        <textarea cols="50" rows="5" name="comment" required id="comment"></textarea>
        <input type="hidden" id="inquiry" name="inquiry" value="<?php echo $inquiry; ?>">
        <input type="hidden" id="inquiry" name="agent" value="<?php echo $agent; ?>">
        <!-- <div id="hd_sub">
        <input type="submit" class="pushme btn span2" name="submit" value="Submit" >
        </div> -->
      </div>
      <div class="modal-footer" id="hd_sub">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <input type="submit" class="btn btn-primary" name="submit" value="Submit" >

      </div>
      </form>
    </div>
  </div>
</div>
<script type="text/javascript">

</script>
<?php
$this->load->view('footer');
?>

