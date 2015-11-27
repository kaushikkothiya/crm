<?php
$this->load->view('header');
$this->load->view('leftmenu');
?>
<link href="<?php echo base_url(); ?>css/fullcalendar.css" rel="stylesheet">
<style type="text/css">
  .fc-today-button, .fc-prev-button, .fc-next-button, .fc-month-button, .fc-agendaWeek-button, .fc-agendaDay-button, .fc-popover{
      width:auto !important;
  }
  .resize {
    width: auto !important;
    margin: 0 auto;
  }
  .fc-time{
   display : none;
}
</style>
<div class="container-fluid">
  <div class="row">
      <div class="main">
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
    
    <h1 class="page-header">Agent Availability</h1>
    <div class="row">
          <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">Agent Availability</div>
              <div class="panel-body">
        <?php echo form_open_multipart('inquiry/inquiry_manage', array('class' => 'form-horizontal')); ?>
          <div class="form-group">
              <label class="col-md-1 col-sm-1 control-label">Agent :</label>
                <div class="col-sm-4">
                  <select  name="agent" class="form-control"  id="agent" onchange="selected_agent_calender();"> <!-- onchange="getAgentCalendar(this.value)" -->
                    <option value="">Select Agent</option>
                    <?php foreach($allAgent as $key => $value){ 
                      if($this->session->userdata('selected_agent_id')){
                       $agent_login_id = $this->session->userdata('logged_in_agent');
                        $agent_id=$agent_login_id['id'];
                      ?>
                      <option value="<?php echo $key;?>" <?php if($agent_id == $key){ echo "selected";}?> ><?php echo $value;?></option>
                      <?php }else{?>
                      <option value="<?php echo $key;?>" <?php if($this->session->userdata('selected_agent_id') == $key){ echo "selected";}?> ><?php echo $value;?></option>
                      <?php } }?>                                           
                  </select>
              </div>
          </div>
          <div class="form-group">
            
            <div class="col-sm-2 col-md-2">
              From Date :
              <input type="text" name="start_date"  class="form-control" id="start_date" value=""  readonly placeholder="1-Jan-2015 0:00" />
            </div>
  
            <div class="visible-xs">&nbsp;</div>
            

            <div class="col-sm-2 col-md-2">
            To Date :
              <input type="text" name="end_date"  class="form-control" id="end_date" value=""  readonly placeholder="1-Jan-2015 0:00" /> 
            </div>

          

            <div class="col-sm-2 col-md-2 left">
                <br />
                <div class="clearfix"></div>
                <div class="col-sm-6">
                  <input id="inquiry_sub" class="btn btn-sm btn-primary" type="submit" value="Next" name="inquiry_sub">
                </div>
            </div>

          </div>
           

           <!-- <div class="form-group">
              <label class="col-md-3 col-sm-4 control-label">&nbsp;</label>
              <div class="col-sm-6">
                <input id="inquiry_sub" class="btn btn-sm btn-primary" type="submit" value="Next" name="inquiry_sub">
              </div>
          </div> -->


          <?php if(isset($inquiry_id)){ ?>
          <input type="hidden" value="<?php echo $inquiry_id; ?>" name="inquiry_id" id="reschedule_inquiry_id" />
          <?php } ?>
          <?php if(isset($property_id)){ ?>
          <input type="hidden" value="<?php echo $property_id; ?>" name="property_id" id="reschedule_property_id" />
          <?php } ?>
         </form>
        </div>
        <hr>
        <div id="calendar" class="resize"></div>
       </div>
     </div>
    </div>
    </div>
  </div>
 </div>
<?php

$this->load->view('footer');

?>
<script type="text/javascript" src="<?php echo base_url(); ?>js/fullcalendar.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/agent_datail.js"></script>
<script type="text/javascript">

$(function() {

    var startDateTextBox = $('#start_date');
    var endDateTextBox = $('#end_date');
    var dateToday = new Date();
    $.timepicker.datetimeRange(
    startDateTextBox,
    endDateTextBox,
    {
      minInterval: (1000*60*60), // 1hr
      dateFormat: 'd-M-yy', 
      timeFormat: 'H:mm',
      minDate: dateToday,
      start: {}, // start picker options
      end: {} // end picker options         
    }
  );

});

$(document).ready(function() { 
     //$.getScript('http://arshaw.com/js/fullcalendar-1.6.4/fullcalendar/fullcalendar.min.js',function(){
     agent_id = '';
     $("#calendar").fullCalendar({
      
        header: {
          left: 'prev,next',
          center: 'title',
          right: ''
        },
        //defaultView: 'basicWeek',
        //defaultDate: '2015-02-12',
        editable: false,
        eventLimit: 1, // allow "more" link when too many events
        events:baseurl+"index.php/inquiry/get_agent_calender_details_byId/"+agent_id,
      });
    // function getAgentCalendar(agent_id)
    // $('#agent').change(function() {
      
    //      $('#start_date').val('');
    //      $('#end_date').val('');
    //     agent_id = $("#agent").val();
    //     if( agent_id != null ) {
    //         eventPath = baseurl+"index.php/inquiry/get_agent_calender_details_byId/"+agent_id;
    //         $('#calendar').fullCalendar('removeEvents');
    //         $('#calendar').fullCalendar('addEventSource', eventPath);
    //     }
        
    // });
selected_agent_calender();
});
function selected_agent_calender(){
   $('#start_date').val('');
         $('#end_date').val('');
        agent_id = $("#agent").val();
        if( agent_id != null ) {
            eventPath = baseurl+"index.php/inquiry/get_agent_calender_details_byId/"+agent_id;
            $('#calendar').fullCalendar('removeEvents');
            $('#calendar').fullCalendar('addEventSource', eventPath);
        }
        
}

</script>
