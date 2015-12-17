<?php $this->load->view('header'); ?>
<?php $this->load->view('leftmenu'); ?>
<?php
    $action = array('2' =>'Text-Send','3' =>'Follow-Up','4' =>'Appointment','5' =>'Complete');
    $action_color = array('1'=>'FFFF00','2' =>'EBAF22','3' =>'FFCCFF','4' =>'D9EDF7','5' =>'99E2A3');
?>
<div class="container-fluid">
    <div class="row">
        <div class="main">
            <h1 class="page-header">Calendar</h1>
            <div class="pageHeadInfo">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="row listHeader-left">
                            <div class="col-sm-3 date-display">
                                <?php if($calendar['calendar_view'] == 'day') { ?>
                                <a class="btn btn-default btn-xs action-btn report-prev" href="javascript:;"><i class="fa fa-chevron-left"></i></a>
                                <a href="javascript:;" class="date-today"><?php echo isset($calendar['from_date']) ? $calendar['from_date'] : date('m/d/Y'); ?></a>
                                <a class="btn btn-default btn-xs action-btn report-next <?php echo (date('m/d/Y') == $calendar['from_date']) ? 'disabled' : ''; ?>" href="javascript:;"><i class="fa fa-chevron-right"></i></a>
                                <?php } else if ($calendar['calendar_view'] == 'week') { ?>
                                <!-- Week code -->
                                <?php } else { ?>
                                <a class="btn btn-default btn-xs action-btn report-prev-month" href="javascript:;"><i class="fa fa-chevron-left"></i></a>
                                <a href="javascript:;" class="date-today"><?php echo isset($calendar['from_date']) ? date('F, Y',  strtotime($calendar['from_date'])) : date('F, Y'); ?></a>
                                <a class="btn btn-default btn-xs action-btn report-next-month <?php echo (date('Y-m') == date('Y-m',  strtotime($calendar['from_date']))) ? 'disabled' : ''; ?>" href="javascript:;"><i class="fa fa-chevron-right"></i></a>
                                <?php } ?>
                            </div>
                            <div class="col-sm-3 show-completed">
                                <label>
                                    <input id="show_completed" type="checkbox" <?php echo (isset($calendar['show_completed']) && !empty($calendar['show_completed'])) ? "checked" : ""; ?> /> Show completed
                                </label>
                            </div>
                            <?php if($user['type'] == 1){ ?>
                            <div class="col-sm-5">
                                <div class="user-select">
                                    <select id="show_by_user" class="form-control">
                                        <option value="">All</option>
                                        <?php foreach($all_users as $all_user){ ?>
                                        <option value="<?php echo $all_user->id ?>" <?php echo (isset($calendar['user_id']) && !empty($calendar['user_id']) && $calendar['user_id'] == $all_user->id) ? "selected" : ""; ?> ><?php echo $all_user->fname.' '.$all_user->lname; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <ul class="nav nav-tabs">
                            <li class="<?php echo (isset($calendar['calendar_view']) && $calendar['calendar_view']=='day')?'active':''; ?>"><a href="javascript:void(0)" class="change-view" data-value="day" data-toggle="tab">DAY</a></li>
                            <li class="<?php echo (isset($calendar['calendar_view']) && $calendar['calendar_view']=='week')?'active':''; ?>"><a href="javascript:void(0)" class="change-view" data-value="week" data-toggle="tab">WEEK</a></li>
                            <li class="<?php echo (isset($calendar['calendar_view']) && $calendar['calendar_view']=='month')?'active':''; ?>"><a href="javascript:void(0)" class="change-view" data-value="month" data-toggle="tab">MONTH</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-8">
                    <div class="panel panel-default">
                        <div class="panel-heading">Title</div>
                        <div class="panel-body padding-O">
                            <div>
                                <table class="table table-striped responsive-table">
                                    <thead>
                                        <tr>
                                            <th>Inquiry No.</th>
                                            <th>Property<br>Status</th>
                                            <th>Agent Name</th>
                                            <th>Created By</th>
                                            <th>Created On</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($inquiries as $inquiry) :?>
                                        <tr>
                                            <td data-th="Inquiry No"><div><a data-toggle="modal" data-target="#myModal" onclick="setInquiryId(<?php echo $inquiry->id; ?>)" href="javascript:;"><?php echo $inquiry->incquiry_ref_no; ?></a></div></td>
                                            <?php
                                            if($inquiry->aquired =='sale') {
                                                $property_status = "Sale";
                                            } else if ($inquiry->aquired =='rent') {
                                                $property_status = "Rent";
                                            } else if ($inquiry->aquired =='both') {
                                                $property_status = "Sale/Rent";
                                            } else {
                                                $property_status = "";
                                            }
                                            ?>
                                            <td data-th="Property Status"><div><?php echo $property_status; ?></div></td>
                                            <td data-th="Agent Name"><div><?php echo (isset($inquiry->agent_fname) ? $inquiry->agent_fname.' '.$inquiry->agent_lname : "--Not assigned--"); ?></div></td>
                                            <td data-th="Created by"><div><?php echo $inquiry->fname.' '.$inquiry->lname; ?></div></td>
                                            <td data-th="Date Created"><div><?php echo date("d-M-Y", strtotime($inquiry->created_date)); ?></div></td>
                                            <td data-th="Status">
                                                <div>
                                                    <?php if($inquiry->status==3 || $inquiry->status==5){ ?>
                                                        <span class="inquiry_status_span feed_cmnt_span" rel="tooltip" title="Click to view message" style="cursor:pointer;background:#<?php echo $action_color[$inquiry->status] ?>"></span>
                                                    <?php } else { ?>
                                                        <?php if($inquiry->agent_status == 3) { ?>
                                                        <span class="inquiry_status_span feed_cmnt_span" rel="tooltip" title="Click to view message" style="cursor:pointer;background:#<?php echo $action_color[$inquiry->status] ?>"></span>
                                                        <input type="hidden" class="inquiry_status" data-msg="<?php echo $inquiry->cancel_message; ?>" >
                                                        <?php } else { ?>
                                                        <span class="inquiry_status_span" rel="tooltip" style="background:#<?php echo $action_color[$inquiry->status] ?>"></span>
                                                        <?php } ?>
                                                    <?php } ?>
                                                        <?php if($inquiry->status==1) { ?>
                                                                Register
                                                        <?php } else if($inquiry->status==2){ ?>
                                                                Text-Send
                                                        <?php } else if($inquiry->status==3){ ?>
                                                                <select class="inquiry_status" data-propId="<?php echo trim($inquiry->property_id); ?>" data-msg="<?php echo $inquiry->comments ?>" data-ref="<?php echo trim($inquiry->incquiry_ref_no); ?>" data-id="<?php echo trim($inquiry->id); ?>" name="incid_<?php echo trim($inquiry->id); ?>"  id="incid_<?php echo trim($inquiry->id); ?>" style="width:105px">
                                                                    <?php foreach($action as $key => $value){
                                                                        if($key != 2 && $key !=4) {
                                                                        if($key == $inquiry->status){ ?>
                                                                        <option selected value="<?php echo $key;?>"><?php echo $value;?></option>
                                                                        <?php }else{ ?>
                                                                        <option  value="<?php echo $key;?>"><?php echo $value;?></option>
                                                                        <?php }
                                                                          }
                                                                        } ?>
                                                                </select>
                                                        <?php } else if($inquiry->status==4){ ?>
                                                                <?php
                                                                if($inquiry->agent_status == 0) {
                                                                    $agent_status = "Pending";
                                                                }else if($inquiry->agent_status == 1) { ?>
                                                                    <select class="inquiry_status" data-propId="<?php echo trim($inquiry->property_id); ?>" data-msg="<?php echo $inquiry->comments ?>" data-ref="<?php echo trim($inquiry->incquiry_ref_no); ?>" data-id="<?php echo trim($inquiry->id); ?>" name="incid_<?php echo trim($inquiry->id); ?>"  id="incid_<?php echo trim($inquiry->id); ?>" style="width:105px">
                                                                    <?php foreach($action as $key => $value){
                                                                        if($key != 2) {
                                                                        if($key == $inquiry->status){ ?>
                                                                        <option selected value="<?php echo $key;?>"><?php echo $value;?></option>
                                                                        <?php }else{ ?>
                                                                        <option  value="<?php echo $key;?>"><?php echo $value;?></option>
                                                                        <?php }
                                                                          }
                                                                        } ?>
                                                                    </select>
                                                                <?php } else if($inquiry->agent_status == 2) {
                                                                    $agent_status = "Reschedule";
                                                                } else if($inquiry->agent_status == 3) {
                                                                    $agent_status = "Cancel";
                                                                }
                                                                if($inquiry->agent_status != 1) {
                                                                ?>
                                                                <?php if(($inquiry->agent_status != 0 && $inquiry->agent_status != 1) && ($user['type']==1 || $user['id']==$inquiry->created_by)) { ?>
                                                                <span rel="tooltip" class="agent_status_span" title="<?php echo $agent_status; ?>"><a href="javascript:;" onclick="return reschedule(<?php echo trim($inquiry->property_id); ?>,<?php echo trim($inquiry->agent_id); ?>,<?php echo trim($inquiry->id); ?>)">Appointment</a></span>
                                                                <?php } else { ?>
                                                                    <span rel="tooltip" class="agent_status_span" title="<?php echo $agent_status; ?>">Appointment</span>
                                                                <?php } ?>
                                                                <?php if($inquiry->agent_status == 0 && $user['type'] != 3) { ?>
                                                                    <select class="action-agent-status" data-agentstatus="<?php echo $inquiry->agent_status ?>" data-userid="<?php echo $user['id'] ?>" data-usertype="<?php echo $user['type'] ?>" data-createdby="<?php echo $inquiry->created_by ?>" data-agentid="<?php echo $inquiry->agent_id ?>" data-propId="<?php echo trim($inquiry->property_id); ?>" data-ref="<?php echo trim($inquiry->incquiry_ref_no); ?>" id="incid_<?php echo trim($inquiry->id); ?>" data-id="<?php echo trim($inquiry->id); ?>">
                                                                        <option value="">Change Status</option>
                                                                        <option value="1">Confirm</option>
                                                                        <option value="2">Reschedule</option>
                                                                        <option value="3">Cancel</option>
                                                                    </select>
                                                                <?php } ?>
                                                                <?php } ?>
                                                        <?php } else if($inquiry->status==5){ ?>
                                                                Complete
                                                                <input type="hidden" class="inquiry_status" data-msg="<?php echo $inquiry->feedback; ?>" >
                                                        <?php } ?>
                                                </div>
                                            </td>
                                            <td data-th="Actions">
                                                <div>
                                                    <?php if($inquiry->status==2) { ?>
                                                    <a onclick="checkclient_property(<?php echo $inquiry->id ?>,<?php echo $inquiry->customer_id ?>,<?php echo $inquiry->property_id ?>)" class="btn btn-default btn-xs action-btn" rel="tooltip" title="Schedule Appointment"><i class="fa fa-calendar-check-o"></i></a>
                                                    <?php } ?>
                                                    <a href="<?php echo base_url(); ?>calendar/deleteInquiry/<?php echo $inquiry->id?>" class="btn btn-danger btn-xs action-btn" rel="tooltip" title="Delete"><i class="fa fa-trash"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-sm-6 text-left text-center-sm">Showing <span id="pagi_start"><?php echo $start; ?></span> to <span id="pagi_end"><?php echo $end; ?></span> of <span id="total_rows"><?php echo $total_rows; ?></span> entries	</div>
                            <?php echo $pagination; ?>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">Title</div>
                        <div class="panel-body padding-O">
                            <div class="appointment-table-fix">
                                <table class="table table-striped responsive-table">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Property Title</th>
                                            <th>Customer Name</th>
                                            <th>End Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i=0; foreach($expired_inquiries as $expired_inquirie) { $i++; ?>
                                        <tr>
                                            <td data-th="No."><div><?php echo $i; ?></div></td>
                                            <td data-th="Property Title"><?php if(!empty($expired_inquirie->bedroom) && $expired_inquirie->bedroom != "none"){echo $expired_inquirie->bedroom.' Bedroom';}else{ echo " "; } ?> <?php  if(!empty($property_type)){echo $property_type.' for'; }else{ echo " ";} ?> <?php if($expired_inquirie->property_for ==1){ echo "Sale"; }else if($expired_inquirie->property_for ==2){ echo "Rent"; }elseif($expired_inquirie->property_for ==3) { echo "Sale/Rent"; }else{ echo "";} ?></td>
                                            <td data-th="Customer Name"><div><?php echo $expired_inquirie->customer_fname.' '.$expired_inquirie->customer_lname; ?></div></td>
                                            <td data-th="End Date"><div><?php echo date("d-M-Y", strtotime($expired_inquirie->appoint_end_date));?></div></td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <span class="calendar-status-pending"></span>Pending
                        <span class="calendar-status-confirm"></span>Confirm
                        <span class="calendar-status-reschedule"></span>Reschedule<br>
                        <span class="calendar-status-cancel"></span>Cancel
                    </div>
                    <div class="clearfix sep"></div>
                    <div class="calendar-block">
                        <div id="calendar"></div>
                    </div>
                    <div class="col-sm-8">
                        <label>
                            <input type="checkbox" id="show_occupied_days" <?php echo (isset($calendar['show_occupied_days']) && !empty($calendar['show_occupied_days'])) ? "checked" : ""; ?> /> Show occupied days
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Inquiry Reference No. :<b class="popup-ref">#Reference No</b></h4>
            </div>
            <div class="modal-body">
                <div class="" id="inquiry_status_change_popup">
                    <input type="hidden" name="inquiry[id]" id="status_change_inquiry_id" value="" />
                    <input type="hidden" name="property[id]" id="status_change_property_id" value="" />
                    <input type="hidden" name="inquiry[status]" id="status_change_inquiry_status" value="" />
                    <label for="status_change_content" id="lbl_status_change_content" class="" style="font-weight:bold">Content :</label>
                    <textarea id="status_change_comments" name="inquiry[content]" class="span12" rows="10" cols="50" ></textarea>
                    <div class="modal-footer" id="hd_sub">
                        <button class="btn btn-primary summit_inquiry_status_with_comment" id="lbl_status_change_button">Change Status</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="followup_msg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel2">Message : </h4><b class="popup-ref-msg">#Comment</b>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Inquiry Reference No. :<b class="popup-ref2">#Reference No</b></h4>
      </div>
            <div class="modal-body">
                <div class="" id="inquiry_status_change_popup">
                    <input type="hidden" name="inquiry[id]" id="status_change_inquiry_id2" value="" />
                    <input type="hidden" name="inquiry[status]" id="status_change_inquiry_status2" value="" />
                    <label for="status_change_content" id="lbl_status_change_content2" class="" style="font-weight:bold">Content :</label>
                    <textarea id="status_change_comments2" name="inquiry[content]" class="span12" rows="10" cols="50" ></textarea>
                    <div class="modal-footer" id="hd_sub">
                       <button class="btn btn-primary summit_inquiry_status_with_comment2">Change Status</button>
                       <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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
        <h4 class="modal-title" id="myModalLabel">View Inquiry Detail</h4>
      </div>
      <div class="modal-body">
        <div id="inquiry_datail_popup">
        </div>
      </div>
      <div class="modal-footer">
      </div>
    </div>
  </div>
</div>

<form id="calendar-filter-form" name="calendar-filter-form" method="post">
    <input type="hidden" id="calendar_user_id" name="calendar[user_id]" value="<?php echo (isset($calendar) && isset($calendar['user_id']) && !empty($calendar['user_id']))?$calendar['user_id']:''; ?>" />
    <input type="hidden" id="calendar_from_date" name="calendar[from_date]" value="<?php echo (isset($calendar) && isset($calendar['from_date']) && !empty($calendar['from_date']))?$calendar['from_date']:''; ?>" />
    <input type="hidden" id="calendar_to_date" name="calendar[to_date]" value="<?php echo (isset($calendar) && isset($calendar['to_date']) && !empty($calendar['to_date']))?$calendar['to_date']:''; ?>" />
    <input type="hidden" id="calendar_show_completed" name="calendar[show_completed]" value="<?php echo (isset($calendar) && isset($calendar['show_completed']) && !empty($calendar['show_completed']))?$calendar['show_completed']:''; ?>" />
    <input type="hidden" id="calendar_calendar_view" name="calendar[calendar_view]" value="<?php echo (isset($calendar) && isset($calendar['calendar_view']) && !empty($calendar['calendar_view']))?$calendar['calendar_view']:''; ?>" />
    <input type="hidden" id="calendar_show_occupied_days" name="calendar[show_occupied_days]" value="<?php echo (isset($calendar) && isset($calendar['show_occupied_days']) && !empty($calendar['show_occupied_days']))?$calendar['show_occupied_days']:""; ?>" />
</form>
<form id="rechedule_form" action="<?php echo base_url(); ?>index.php/inquiry/agent_calendar" method="post">
    <input type="hidden" name="agent_id" id="rechedule_agent_id" value="" />
    <input type="hidden" name="property_name" id="rechedule_property_id" value="" />
    <input type="hidden" name="inquiry_id" id="rechedule_inquiry_id" value="" />
</form>
<?php $this->load->view('footer'); ?>
<script type="text/javascript" src="<?php echo base_url(); ?>js/fullcalendar.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/calender.js"></script>
<script type="text/javascript">

Date.prototype.addDays = function(days) {
    var dat = new Date(this.valueOf());
    dat.setDate(dat.getDate() + days);
    return dat;
}
function addMonths(dateObj, num) {

    var currentMonth = dateObj.getMonth();
    dateObj.setMonth(dateObj.getMonth() + num)

    if (dateObj.getMonth() != ((currentMonth + num) % 12)){
        dateObj.setDate(0);
    }
    return dateObj;
}

function setPrevWeek(){
    if($("#calendar_from_date").val()!=$("#calendar_to_date").val()){
        var dt = new Date();
    }else{
        var dt = new Date(phpdate.split("/")[2],(phpdate.split("/")[0]-1),phpdate.split("/")[1]);
    }
    var first = dt.getDate() - dt.getDay(); // First day is the day of the month - the day of the week
    var last = first + 6; // last day is the first day + 6
    
    var firstday = new Date(dt.setDate(first)).toUTCString();
    var lastday = new Date(dt.setDate(last)).toUTCString();
    
    
    
}

$(document).ready(function(){

    $("#show_occupied_days").click(function(){
        if($(this).is(':checked')) {
            $("#calendar_show_occupied_days").val($(this).val());
        } else {
            $("#calendar_show_occupied_days").val("");
        }
        $("#calendar-filter-form").submit();
    });

    $(".change-view").click(function(){
        $("#calendar_calendar_view").val($(this).data('value'));
        $("#calendar-filter-form").submit();
    })

    $('#show_completed').click(function () {
        if($(this).is(':checked')){
            $('#calendar_show_completed').val($(this).val());
        }else{
            $('#calendar_show_completed').val('');
        }
        $("#calendar-filter-form").submit();
    });

    $('#show_by_user').change(function(){
        $("#calendar_user_id").val($(this).val());
        $("#calendar-filter-form").submit();
    });

    var phpdate = '<?php echo $calendar['from_date']; ?>';
        $('.report-prev').click(function(){
            if($("#calendar_from_date").val()!=$("#calendar_to_date").val()){
               var dt = new Date();
            }else{
               var dt = new Date(phpdate.split("/")[2],(phpdate.split("/")[0]-1),phpdate.split("/")[1]);
            }

            dt = dt.addDays(-1);
            m = (dt.getMonth()+1).toString();
            m = (m.length<2)?('0'+m):m;
            d = dt.getDate().toString();
            d = (d.length<2)?('0'+d):d;
            y = dt.getFullYear();
            dt = m+'/'+d+'/'+y;
            $("#calendar_from_date").val(dt);
            $("#calendar_to_date").val(dt);
            $("#calendar-filter-form").submit();
        });

        $('.report-next').click(function(){
            if($("#calendar_from_date").val()!=$("#calendar_to_date").val()){
                dt = new Date();
            }else{
                dt = new Date(phpdate.split("/")[2],(phpdate.split("/")[0]-1),phpdate.split("/")[1]);
            }

            dt = dt.addDays(1);
            m = (dt.getMonth()+1).toString();
            m = (m.length<2)?('0'+m):m;
            d = dt.getDate().toString();
            d = (d.length<2)?('0'+d):d;
            y = dt.getFullYear();
            dt = m+'/'+d+'/'+y;
            $("#calendar_from_date").val(dt);
            $("#calendar_to_date").val(dt);
            $("#calendar-filter-form").submit();
        });

        $('.report-prev-month').click(function () {
            <?php if(isset($calendar['calendar_view']) && $calendar['calendar_view']=='day'){ ?>
                dt = new Date();
            <?php } else if (isset($calendar['calendar_view']) && $calendar['calendar_view']=='month') { ?>
                dt = new Date(phpdate.split("/")[2], (phpdate.split("/")[0]-1), phpdate.split("/")[1]);
            <?php } ?>

            dt = addMonths(dt,-1);
            m = (dt.getMonth()+1).toString();
            m = (m.length < 2) ? ('0' + m) : m;
            d = dt.getDate().toString();
            d = (d.length < 2) ? ('0' + d) : d;
            y = dt.getFullYear();
            dt = m + '/' + '01' + '/' + y;
            $("#calendar_from_date").val(dt);
            console.log(dt);

            dt = new Date(y, parseInt(m) + 1, 0);
            //console.log(m);
            m = dt.getMonth().toString();
            m = (m.length < 2) ? ('0' + m) : m;
            d = dt.getDate().toString();
            d = (d.length < 2) ? ('0' + d) : d;
            y = dt.getFullYear();
            dt = m + '/' + d + '/' + y;
            $("#calendar_to_date").val(dt);
            //console.log(dt);
            $("#calendar-filter-form").submit();
        });

        $('.report-next-month').click(function () {
            <?php if(isset($calendar['calendar_view']) && $calendar['calendar_view']=='day'){ ?>
                dt = new Date();
            <?php } else if(isset($calendar['calendar_view']) && $calendar['calendar_view']=='month') { ?>
                dt = new Date(phpdate.split("/")[2], (phpdate.split("/")[0]-1), phpdate.split("/")[1]);
            <?php } ?>

            dt = addMonths(dt,1);
            m = (dt.getMonth()+1).toString();
            m = (m.length < 2) ? ('0' + m) : m;
            d = dt.getDate().toString();
            d = (d.length < 2) ? ('0' + d) : d;
            y = dt.getFullYear();
            dt = m + '/' + '01' + '/' + y;
            $("#calendar_from_date").val(dt);
            //console.log(dt);
            dt = new Date(y, parseInt(m), 0);
            m = (dt.getMonth()+1).toString();
            m = (m.length < 2) ? ('0' + m) : m;
            d = dt.getDate().toString();
            d = (d.length < 2) ? ('0' + d) : d;
            y = dt.getFullYear();
            dt = m + '/' + d + '/' + y;
            $("#calendar_to_date").val(dt);
            //console.log(dt);
            $("#calendar-filter-form").submit();
        });

        $("#calendar").fullCalendar({
            events:<?php echo $json_occupied_days; ?>,
            eventAfterRender: function (event, element) {
                $(element).tooltip({title:event.description, container: "body"});
            },
        });

        $(".btn-danger").click(function(e){

            var conf = confirm('Are you sure want to delete this record?');

            if( conf === true ) {
                $this  = $(this);
                e.preventDefault();
                var url = $(this).attr("href");
                var show_completed = $("#calendar_show_completed").val();
                var selected_user = $("#calendar_user_id").val();
                var from_date = $("#calendar_from_date").val();
                var to_date = $("#calendar_to_date").val();

                url = url+"?show_completed="+show_completed+"&selected_user="+selected_user+"&from_date="+from_date+"&to_date="+to_date;
                $.get(url, function(r){
                    var data = JSON.parse(r);

                    if(data.success){
                        $this.closest('tr').remove();
                        $("#total_rows").html(data.total_rows);
                        $("#pagi_end").html($("#pagi_end").html()-1);

                        if(data.total_rows == "0") {
                            $("#pagi_start").html("0");
                        }
                    }
                })
            }
            return false;
        });

    $(document).on('click',".feed_cmnt_span",function(){
        $(".popup-ref-msg").html($(this).siblings('.inquiry_status').attr('data-msg'));
        $('#followup_msg').modal('show');
    });

    $(document).on('change',".inquiry_status",function(){
        $(".popup-ref").html($(this).data('ref'));
        $("#status_change_inquiry_id").val($(this).data('id'));
        $("#status_change_property_id").val($(this).data('propid'));
        $("#status_change_inquiry_status").val($(this).val());
        var href = window.location.href.split("#");

        if($(this).val()==2){
            $("#lbl_status_change_content").hide();
            $("#status_change_comments").hide();
            changeInquiryStatus();
        }else if($(this).val()==4){ // Appointment
            $("#lbl_status_change_content").hide();
            $("#status_change_comments").hide();
            changeInquiryStatus();
        }else if($(this).val()==3){ // Follow-Up
            $("#lbl_status_change_content").show();
            $("#status_change_comments").show();
            $("#lbl_status_change_content").html('Comments :');
            $("#lbl_status_change_button").html('Submit Follow –Up Feedback');

            $('#myModal2').modal('show')
        }else if($(this).val()==5){ // Complete
            $("#lbl_status_change_content").show();
            $("#status_change_comments").show();
            $("#lbl_status_change_content").html('Feedback :');
            $("#lbl_status_change_button").html('Complete');
            $('#myModal2').modal('show')
        }
    });

    $(document).on('click','.summit_inquiry_status_with_comment',function(){
        $('#myModal2').modal('hide')
        changeInquiryStatus();
    });

    $(document).on('change',".action-agent-status",function(){
        if($(this).val() != "") {
            $("#status_change_inquiry_id2").val($(this).data('id'));
            $("#status_change_inquiry_status2").val($(this).val());
            if($(this).val()==1 || $(this).val()==2){
                changeAgentStatus();
                var agentStatus = "";
                if($(this).val()==1) {
                    //agentStatus = "Confirmed";
                    $(this).siblings('.agent_status_span').remove();
                    var incid = $(this).data('id');
                    var ref = $(this).data('ref');
                    var propid = $(this).data('propid');
                    $(this).before('<select id="incid_'+incid+'" class="inquiry_status" style="width:105px" name="incid_'+incid+'" data-id="'+incid+'" data-ref="'+ref+'" data-propid="'+propid+'" ><option value="3">Follow-Up</option><option value="4" selected>Appointment</option><option value="5">Complete</option></select>');
                    $(this).siblings('.agent_status_span').attr("data-original-title",agentStatus);
                    $(this).remove();
                }
            }else{
                $(".popup-ref2").html($(this).data('ref'));
                $("#lbl_status_change_content2").html('Comments :');
                var href = window.location.href.split("#");
                $('#myModal1').modal('show');
            }
        }
    });

    $(document).on('click','.summit_inquiry_status_with_comment2',function(){
        if($("#status_change_comments2").val()!=""){
            $('#myModal1').modal('hide')
            changeAgentStatus();
        }else{
            alert("We need your comments if you want to cancel this Inquiry.");
        }
    });

});

function changeAgentStatus(){
    cancel_msg = $("#status_change_comments2").val();
    $.ajax({
        url : '<?php echo base_url(); ?>inquiry/ajax_change_inquiry_agent_status',
        data:{
            id : $("#status_change_inquiry_id2").val(),
            agent_status: $("#status_change_inquiry_status2").val(),
            comments: $("#status_change_comments2").val()
        },
        dataType:'json',
        type:'post'
    }).done(function(data){
        if(data.status){
            
            var data_id = $("#status_change_inquiry_id2").val(); // inquiry_id
            
            var created_by = $("#incid_"+data_id).data('createdby');
            var user_type = $("#incid_"+data_id).data('usertype');
            var user_id = $("#incid_"+data_id).data('userid');
            var agentstatus = $("#incid_"+data_id).data('agentstatus');
            var proprty_id = $("#incid_"+data_id).data('propid');
            var agent_id = $("#incid_"+data_id).data('agentid');
            
            if(data.agent_status != 1) {
                console.log("agentstatus:"+agentstatus+" user_type:"+user_type+" user_id:"+user_id+" created_by:"+created_by)
                if(user_type == 1 || user_id == created_by) {
                    $("#incid_"+data_id).siblings('.agent_status_span').html('<a onclick="return reschedule('+proprty_id+','+agent_id+','+data_id+')" href="javascript:;">Appointment</a>');
                }
            }
            if(data.agent_status==2) {
                $("#incid_"+data_id).siblings('.agent_status_span').attr("data-original-title","Reschedule");
                $("#incid_"+data_id).remove();    
            }
            if(data.agent_status==3){
                $("#status_change_comments2").val('');
                $("#incid_"+data_id).siblings('.inquiry_status_span').css('cursor','pointer');
                $("#incid_"+data_id).siblings('.inquiry_status_span').addClass('feed_cmnt_span');
                $("#incid_"+data_id).siblings('.inquiry_status_span').attr('data-original-title','Click to view message');
                $("#incid_"+data_id).after('<input type="hidden" class="inquiry_status" data-msg="'+cancel_msg+'" >');

                $("#incid_"+data_id).siblings('.agent_status_span').attr("data-original-title","Cancel");
                $("#incid_"+data_id).remove();
            }
            alert(data.msg);
        }else{
            alert("Internal Error: could not change Inquiry Status");
        }
    }).fail(function(){
        alert("Internal Error: could not change Inquiry Status");
    });
}

function checkclient_property(incid,custid,propertyid){
    baseurl = "<?php echo base_url() ?>";
    $.ajax({
        type: "post",
        url:baseurl+"index.php/inquiry/check_client_property_activation",
        data: {custid:custid,propertyid:propertyid},
        success: function(msg){

            if(msg =='true'){
                window.location="<?php echo base_url(); ?>inquiry/scheduleAppointment/"+incid;
            }else if(msg =='property_inactive'){
                alert('This Inquiry Property is inactive');
            }else if(msg =='customer_inactive'){
                alert('This Inquiry Property is inactive');
            }else if(msg =='customer_property_inactive'){
                alert('This Inquiry Property and client is inactive');
            }else{
                window.location="<?php echo base_url(); ?>inquiry/scheduleAppointment/"+incid;
            }
        }
    });
}
var action_color = {'col_2' :'EBAF22','col_3' :'FFCCFF','col_4' :'D9EDF7','col_5' :'99E2A3'};
function changeInquiryStatus(){
    $.ajax({
        url:'<?php echo base_url(); ?>index.php/inquiry/ajax_update_status',
        type:'post',
        data:{
            id: $("#status_change_inquiry_id").val(),
            status: $("#status_change_inquiry_status").val(),
            comments: $("#status_change_comments").val(),
        },
        dataType:'json'
    }).done(function(data){
        $("#status_change_comments").val('');
        if(data.status){
            $("#incid_"+data.id).prev().css('background','#'+eval('action_color.col_'+data.inq_status));

            if(data.inq_status == 3){
                $("#incid_"+data.id).attr('data-msg',data.message);
                $("#incid_"+data.id).prev().css('cursor','pointer');
                $("#incid_"+data.id).prev().addClass('feed_cmnt_span');
            }
            if(data.inq_status == 5){
                $("#incid_"+data.id).prev().css('cursor','pointer');
                $("#incid_"+data.id).prev().addClass('feed_cmnt_span');

                $("#incid_"+data.id).before('<input type="hidden" class="inquiry_status" data-msg="'+data.message+'" >')
                $("#incid_"+data.id).before(document.createTextNode('Complete'));
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

function setInquiryId(inquiryId)
{

   $.ajax({
        type: "post",
        url:baseurl+"index.php/inquiry/get_inquiry_recored",
        data: 'inquiry_id='+inquiryId,
        success: function(msg){
            $("#inquiry_datail_popup").html(msg);
        }
    });

}

function reschedule(propery_id,agent_id,inquiry_id){
    if( (propery_id!=0 || propery_id!='') && (agent_id!=0 || agent_id!='') || (inquiry_id!=0 || inquiry_id!='') ){
        $('#rechedule_agent_id').val(agent_id);
        $('#rechedule_property_id').val(propery_id);
        $('#rechedule_inquiry_id').val(inquiry_id);
        $("#rechedule_form").submit();
    }
}

</script>