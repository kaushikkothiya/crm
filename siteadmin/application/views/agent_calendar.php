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
<!-- Full Calendar Js-->
        <!-- <link href="<?php echo base_url(); ?>css/fullcalendar.print.css" rel="stylesheet">-->
        <!--<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery-ui.custom.min.js"></script>-->
        <link href="<?php echo base_url(); ?>css/fullcalendar.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>css/jquery-ui.min.css" rel="stylesheet"> 
        <script type="text/javascript" src="<?php echo base_url(); ?>js/moment.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/fullcalendar.min.js"></script>

<style type="text/css">
  .fc-today-button, .fc-prev-button, .fc-next-button, .fc-month-button, .fc-agendaWeek-button, .fc-agendaDay-button, .fc-popover{
      width:auto !important;
  }
  .resize {
    width: auto !important;
    margin: 0 auto;
  }
</style>
<div class="span10 body-container">
<div class="row-fluid">
<div class="span12">
<ul class="breadcrumb">
<li><?php echo anchor('home', 'Home', "title='Home'"); ?>
<span class="divider">/
</span></li>
<li><?php echo anchor('inquiry/property', 'Property', "title='Property'"); ?>
<span class="divider">
</span></li>
<?php if ($this->uri->segment(3)) { ?>
<li><?php //echo anchor('home/add_agent/'.$usrid, 'Edit Agent', "title='Edit Agent'"); ?> 
<?php } else { ?>
<li><?php //echo anchor('home/add_agent', 'Add Agent', "title='Add Agent'"); ?> 
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
    Agent Availability
<?php } else { ?>
    Agent Availability
<?php } ?>
</span>
</div>
<div class="row-fluid">
<div class="utopia-widget-content">
<div class="span6 utopia-form-freeSpace">
    <?php echo form_open_multipart('inquiry/inquiry_manage', array('class' => 'form-horizontal')); ?>
    <fieldset>

    <div class="control-group">
      <!-- margin-left:135px; -->
        <div  class="controls">
            Agent :
            <select  name="agent"  id="agent" style="width:200px" > <!-- onchange="getAgentCalendar(this.value)" -->
                <option value="">Select Agent</option>
                <?php foreach($allAgent as $key => $value){ ?>
                <option value="<?php echo $key;?>" <?php if($this->session->userdata('selected_agent_id') == $key){ echo "selected";}?> ><?php echo $value;?></option>
                <?php }?>                                           
            </select>
        </div>
                                                
    </div>
    
    <div class="control-group" style="float:left;margin-right:20px;">
        From Date : 
        <input type="text" name="start_date" id="start_date" value="" style="width:161px;" readonly placeholder="1-Jan-2015 0:00" />
        To Date : 
        <input type="text" name="end_date" id="end_date" value="" style="width:161px;" readonly placeholder="1-Jan-2015 0:00" /> 
</div>
<div class="control-group">
    <div class="controls">
        <input id="inquiry_sub" style="width:83px;" class="btn span5" type="submit" value="Next" name="inquiry_sub">
        <?php
            //echo form_submit('submit', 'Next', "class='btn span5'");
        ?>
        <?php //echo anchor('home/agent_manage', 'Cancel', array('title' => 'Cancel', 'class' => 'btn span4')); ?>
    </div>
</div>
</fieldset>
</form>
</div>
</div>
</div>
<div id="calendar" class="resize"></div>
</section>
</div>
</div>
</div>
</div>
</div>
<?php

$this->load->view('footer');

?>

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
          left: 'prev,next today',
          center: 'title',
          right: 'month,agendaWeek,agendaDay'
        },
        //defaultView: 'basicWeek',
        //defaultDate: '2015-02-12',
        editable: false,
        eventLimit: 1, // allow "more" link when too many events
        events:baseurl+"index.php/inquiry/get_agent_calender_details_byId/"+agent_id,
      });
    // function getAgentCalendar(agent_id)
    $('#agent').change(function() {
      
         $('#start_date').val('');
         $('#end_date').val('');
        agent_id = $("#agent").val();
        if( agent_id != null ) {
            eventPath = baseurl+"index.php/inquiry/get_agent_calender_details_byId/"+agent_id;
            $('#calendar').fullCalendar('removeEvents');
            $('#calendar').fullCalendar('addEventSource', eventPath);
        }
        
    });
});

</script>
