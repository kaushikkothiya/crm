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
        <?php if ($this->session->flashdata('success')) { ?>
                <div class="alert alert-success" role="alert">
                    <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <?php echo $this->session->flashdata('success'); ?>
                </div>
            <?php } ?>
         <h1 class="page-header"> Calendar</h1>
        <div class="row">
          <div class="col-sm-12">
            <div class="panel panel-default">
              <div class="panel-heading"> Calendar</div>
              <div class="panel-body" >
               <div class="form-group">
                <div class="col-md-12"> 
                          <span style="width:15px;height:15px;display:inline-block;background:#00bfff;"></span> Pending &nbsp;&nbsp;
                            <!-- Txt-Send --> 
                            <span style="width:15px;height:15px;display:inline-block;background:#EBAF22;"></span> Confirmed &nbsp;&nbsp;
                            <!-- Txt-Send --> 
                            <span style="width:15px;height:15px;display:inline-block;background:#FFCCFF;"></span> Reschedule &nbsp;&nbsp;
                            <!-- Follow-Up --> 
                            <!-- <span style="width:15px;height:15px;display:inline-block;background:#D9EDF7;"></span> Appointment &nbsp;&nbsp; -->
                            <!-- Appointment --> 
                            <!-- <span style="width:15px;height:15px;display:inline-block;background:#99E2A3;"></span> Complete -->
                            <!-- Complete --> 
                        </div>
                        <div class="clearfix sep"></div><div class="clearfix sep"></div>
                    <div class="col-sm-12 resize" id="calendar">
                    
                    </div>
                  </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
<div id="fullCalModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span> <span class="sr-only">close</span></button>
                <h4 id="modalTitle" class="modal-title"></h4>
            </div>
            <div id="modalBody" class="modal-body"></div>
            <div class="modal-footer classshowall">
            <input type="hidden" name="inquiry[id]" id="status_change_inquiry_id" value="" />
            <input type="hidden" name="inquiry[status]" id="status_change_inquiry_status" value="" />
                    
            <a href="javascript:void(0)" data-ref="" data-id="" value="" data-status="1" class="btn btn-default btn-small action-agent-status">Confirm</a>
            <a href="javascript:void(0)" data-ref="" data-id="" value="" data-status="2" class="btn btn-default btn-small action-agent-status">Reschedule</a>
            <a href="javascript:void(0)" data-ref="" data-id="" value="" data-status="3" class="btn btn-default btn-small action-agent-status">Cancel</a>
            <a href="javascript:void(0)" data-toggle="modal" data-target="#myModal" data-ref="" data-id="" value="" data-status="4" class="btn btn-default btn-small">Reminder</a>
             
                <!-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button class="btn btn-default"><a id="eventUrl" target="_blank">Submit</a></button> -->
            </div>
            <div class="modal-footer classshowone">
            <a href="javascript:void(0)" data-toggle="modal" data-target="#myModal" data-ref="" data-id="" data-status="4" class="btn btn-default btn-small">Reminder</a>
             
                <!-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button class="btn btn-default"><a id="eventUrl" target="_blank">Submit</a></button> -->
            </div>
        </div>
    </div>
</div>
 <!-- Modal -->
<div  class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Appointment Reminder</h4>
      </div>
      <form action="" name="appoint_form" id="appoint_form" method="post" enctype="multipart/form-data">
      <div class="modal-body">
                <label style="font-weight:bold">Note:</label>
                    <textarea id="status_change_comments"  required name="inquiry[content]" class="form-control" rows="2" cols="20" ></textarea>
                     </br>
                    <label style="font-weight:bold">Start date:</label>
                    <input type="text" id="start_date" required name="start_date" value="" class="form-control txt_date">
                     </br>
                    <label style="font-weight:bold">Is repetitive:</label>
                    <input type="checkbox" id="is_repetive" name="is_repetive" class="repitive" value="0">
                     </br></br>
                    <div id="frequency_id" hidden>
                    <label style="font-weight:bold">Frequency:</label>
                      <input type="radio" name="frequency" id="frequency" value="month" checked>Month
                      <input type="radio" name="frequency" id="frequency" value="week" >Week
                      <input type="radio" name="frequency" id="frequency" value="day" >Day
                    </br></br>
                      <label style="font-weight:bold">repetitive date:</label>
                      <input type="text" required id="end_date" name="end_date" value="" class="form-control txt_date">
                    </div>
            
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <input type="button" class="btn btn-primary summit_inquiry_status_with_comment" value="Save changes">
        
      </div>
      </form>
    </div>
  </div>
</div>
<?php
$this->load->view('footer');
?>
<script type="text/javascript" src="<?php echo base_url(); ?>js/fullcalendar.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/calender.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
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
            id: $('#status_change_inquiry_id').val()
        },
        dataType:'json'
    }).done(function(data){
        $("#status_change_comments").val('');
        if(data.status){
            alert('Appointment note add successfull');
        }else{
            alert('Internal Error : Unable to add note!');    
        }
    }).error(function(){
        alert('Internal Error : Unable to add note!');
    });
} 
     $("#calendar").fullCalendar({
      
        header: {
          left: 'prev,next',
          center: 'title',
          right: ''
        },
        //defaultView: 'basicWeek',
        //defaultDate: '2015-02-12',
        editable: false,
       // eventLimit: 1, // allow "more" link when too many events
        events:baseurl+"index.php/inquiry/get_agent_calandar_detail",
        eventClick:  function(event, jsEvent, view) {
            $('#modalTitle').html(event.title);
            $('#modalBody').html(event.description);
           
           if(event.status=='0'){
            $('.classshowall').show();
            $('.classshowone').hide();

           }else if(event.status=='1'){
            $('.classshowall').hide();
            $('.classshowone').show();
           }else{
           window.location = 'scheduleAppointment/'+event.id; 
           }
           if(event.status=='0' || event.status=='1'){
           $('#modal-footer').html(event.status);
           $('#status_change_inquiry_id').val(event.id);
            $('#eventUrl').attr('href',event.url);
            $('#fullCalModal').modal();
          }
        }
      });

     $(".action-agent-status").click(function(){
        if($(this).data('status')==1 || $(this).data('status')==3 || $(this).data('status')==2){
            changeAgentStatus($('#status_change_inquiry_id').val(),$(this).data('status'));
        }else{
            $(".popup-ref").html($(this).data('ref'));
            $("#lbl_status_change_content").html('Comments :');
            var href = window.location.href.split("#");
            //window.location = href[0] + "#popup3";
            $('#myModal1').modal('show')
        }
    });


});
function changeAgentStatus(id,status){
        $.ajax({
            url : '<?php echo base_url(); ?>inquiry/ajax_calaneder_change_status',
            data:{ 
                id : id,
                agent_status: status,
            },
            dataType:'json',
            type:'post'
        }).done(function(data){
            if(data.status){
                $('[data-id='+data.id+']').parents('tr').first().remove();
                alert(data.msg);
                location.reload(); 

            }else{
                alert("Internal Error: could not change Appointment Status");
            }
        }).fail(function(){
            alert("Internal Error: could not change Appointment Status");
        });
    }

</script>


