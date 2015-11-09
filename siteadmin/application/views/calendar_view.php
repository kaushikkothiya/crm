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
<div id="popup3" class="overlay">
    <div class="popup">
        <h2>Appointment Note:</h2>
        <hr>
        <a class="close" href="#">×</a>
        <div class="content">
            <div class="row-fluid">
                <form name="appoint_form">
                    <label style="font-weight:bold">Note:</label>
                    <textarea id="status_change_comments" name="inquiry[content]" class="span6" rows="2" cols="20" ></textarea>
                    <label style="font-weight:bold">Start date:</label>
                    <input type="text" id="start_date" name="start_date" value="" class="txt_date">
                    <label style="font-weight:bold">Is repetitive:</label>
                    <input type="checkbox" id="is_repetive" name="is_repetive" class="repitive" value="0">
                    <div id="frequency_id" hidden>
                    <label style="font-weight:bold">Frequency:</label>
                      <input type="radio" name="frequency" id="frequency" value="month" checked>Month
                      <input type="radio" name="frequency" id="frequency" value="week" >Week
                      <input type="radio" name="frequency" id="frequency" value="day" >Day
                    
                      <label style="font-weight:bold">repetitive date:</label>
                      <input type="text" id="end_date" name="end_date" value="" class="txt_date">
                    </div>
                    <label>
                      <input type="button" class="summit_inquiry_status_with_comment" style="width:50px;" value="Go">
                     
                    
                    </label>
                  </form>
                    
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
        $( ".txt_date" ).datepicker();
         $("#is_repetive").change(function() {
        if(this.checked) {
           $('#frequency_id').show();
           $('#is_repetive').val(1);
        }else{
          $('#frequency_id').hide();
           $('#end_date').val();
           $('#frequency').val();
           $('#is_repetive').val(0);
        }
    });

     $(document).on('click','.summit_inquiry_status_with_comment',function(){
        //console.log($(this).parents('.content').prev().html());
        $(this).parents('.popup').find('a.close').trigger('click');
        var href = window.location.href.split("#");
        window.location = href[0]+"#";
        changeInquiryStatus();
    });

     function changeInquiryStatus(){
    $.ajax({
        url:'<?php echo base_url(); ?>index.php/inquiry/appointment_note_add',
        type:'post',
        data:{ 
            note: $("#status_change_comments").val(),
            start_date: $("#start_date").val(),
            is_repetive: $("#is_repetive").val(),
            frequency: $("#frequency").val(),
            end_date: $("#end_date").val(),
        },
        dataType:'json'
    }).done(function(data){
        $("#status_change_comments").val('');
        if(data.status){
            $("#incid_"+data.id).prev().css('background','#'+eval('action_color.col_'+data.inq_status));
            if(data.inq_status==5){
                $("#incid_"+data.id).before(document.createTextNode('Completed'));
                $("#incid_"+data.id).remove();
            }
            alert('Inquiry status has been updated');
        }else{
            alert('Internal Error : Unable to save Inquiry status!');    
        }
    }).error(function(){
        alert('Internal Error : Unable to save Inquiry status!');
    });
}

     $("#calendar").fullCalendar({
      
        header: {
          left: 'prev,next today',
          center: 'title',
          right: 'month,agendaWeek,agendaDay'
        },
        //defaultView: 'basicWeek',
        //defaultDate: '2015-02-12',
        editable: false,
       // eventLimit: 1, // allow "more" link when too many events
        events:baseurl+"index.php/inquiry/get_agent_calandar_detail",
        eventClick: function(calEvent, jsEvent, view) {

        window.location ="#popup3";
       

    }
      });

});

</script>


