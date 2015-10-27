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
<link href="<?php echo base_url(); ?>css/fullcalendar.css" rel="stylesheet">
        <!-- <link href="<?php echo base_url(); ?>css/fullcalendar.print.css" rel="stylesheet">-->
        <link href="<?php echo base_url(); ?>css/jquery-ui.min.css" rel="stylesheet"> 
        <script type="text/javascript" src="<?php echo base_url(); ?>js/moment.min.js"></script>
        <!--<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery-ui.custom.min.js"></script>-->
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
<li><?php echo anchor('inquiry/calendar', 'Calendar', "title='Calendar'"); ?>
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
<div id="calendar" class="resize">
</div>
</div>
</div>
</section>
</div>
</div>
</div>
</div>
</div>
<?php
$this->load->view('footer');
?>
<script type="text/javascript">
$(document).ready(function() { 
     //$.getScript('http://arshaw.com/js/fullcalendar-1.6.4/fullcalendar/fullcalendar.min.js',function(){
    
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
        events:baseurl+"index.php/inquiry/get_agent_calandar_detail",
      });

});

</script>


