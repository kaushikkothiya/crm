<?php

$this->load->view('header');?>
<!-- <link href="<?php echo base_url(); ?>css/popupbox.css" rel="stylesheet"> -->
<?php
$this->load->view('leftmenu');
$Action = array('3' =>'Follow-Up','4' =>'Appointment','5' =>'Complete');
$Action_color = array('1'=>'FFFF00','2' =>'EBAF22','3' =>'FFCCFF','4' =>'D9EDF7','5' =>'99E2A3');
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
          <h1 class="page-header">Inquiry List
             <?php if ($this->session->userdata('logged_in_super_user')) { ?>
          <a><button data-toggle="modal" data-target="#myModal1" class="btn btn-sm btn-info pull-right" type="button">Import Excel File</button></a>
          <?php } ?>
        </h1>
        <div class="row">
        <form action="inquiry_manage" name="mul_rec" id="mul_rec" method="post" enctype="multipart/form-data">
                        <div class="col-md-12"> 
                          <!-- <span style="width:15px;height:15px;display:inline-block;background:#FFFF00;"></span> Register &nbsp;&nbsp; -->
                            <!-- Txt-Send --> 
                            <span style="width:15px;height:15px;display:inline-block;background:#EBAF22;"></span> Text-Send &nbsp;&nbsp;
                            <!-- Txt-Send --> 
                            <span style="width:15px;height:15px;display:inline-block;background:#FFCCFF;"></span> Follow-Up &nbsp;&nbsp;
                            <!-- Follow-Up --> 
                            <span style="width:15px;height:15px;display:inline-block;background:#D9EDF7;"></span> Appointment &nbsp;&nbsp;
                            <!-- Appointment --> 
                            <span style="width:15px;height:15px;display:inline-block;background:#99E2A3;"></span> Complete<!-- Complete --> 
                        </div>
                        <div class="clearfix sep"></div>
                        <div class="clearfix sep"></div>
                     <div class="col-md-3">
                      <span>View Inquiry By :  &nbsp;&nbsp;
                      <select name="view_inc"  id="view_inc" class="form-control" style="width:200px" onchange="view_inquiry(this.value);">
                            <option value="" <?php if(empty($_GET['view'])) { echo "selected"; } ?>>All</option>
                            <option value="rent" <?php if(!empty($_GET['view']) && $_GET['view']== "rent") { echo "selected"; } ?> >Rent inquiry</option>
                            <option value="sale" <?php if(!empty($_GET['view']) && $_GET['view']== "sale") { echo "selected"; } ?>>Sale inquiry</option>
                            <option value="latest" <?php if(!empty($_GET['view']) && $_GET['view']== "latest") { echo "selected"; } ?>>Latest inquiry</option>
                        </select>
                      </span> 
                      </div>
                      
                      <div class="col-md-3">
                      <span>View Inquiry for :  &nbsp;&nbsp;
                      <select name="view_inc_client"  id="view_inc_client" class="form-control" style="width:200px" onchange="view_inquiry_client(this.value);">
                            <?php 
                            ?>
                            <option value="" <?php if(empty($_GET['view_client'])) { echo "selected"; } ?>>All</option>
                            <?php foreach($all_client as $key => $value){ ?>
                            <option value="<?php echo $value->id;?>" <?php if(!empty($_GET['view_client']) && $_GET['view_client']== $value->id) { echo "selected"; } ?> ><?php echo $value->fname.' '.$value->lname;?></option>
                            <?php }?>
                        </select>
                      </span>
                      </div> 
                      <div class="clearfix sep"></div>
                      <div class="clearfix sep"></div>


          <div class="col-sm-12">
                    <div>
                        <table id="inquiry_list">
                                <thead>
                                    <tr>
                                        <th hidden>Id</th>
                                         <th hidden>Property Id</th>
                                        <th>Reference No</th>
                                        <th>Inquiry No</th>
                                        <th>Property Status</th>
                                        <th>Agent Name</th>
                                        <th>Created by</th>
                                        <th>Date Created</th>
                                        <th>Status</th>
                                        <th style="width: 100px;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    for ($i = 0; $i < count($user); $i++) {    
                                        echo "<tr>";
                                        echo "<td data-th='id.' hidden><div>" . $user[$i]->id. "</div></td>";
                                        echo "<td data-th='Property Id' hidden><div>" . $user[$i]->property_id. "</div></td>";
                                        echo "<td data-th='Reference No'><div>" . $user[$i]->property_ref_no. "</div></td>";
                                        echo "<td data-th='Inquiry No'><div>" . $user[$i]->incquiry_ref_no. "</div></td>";
                                        if($user[$i]->aquired =='sale'){
                                            echo "<td data-th='Property Status'><div> Sale </div></td>";
                                        }
                                        else if($user[$i]->aquired =='rent'){
                                            echo "<td data-th='Property Status'><div> Rent</div> </td>";
                                        }else if($user[$i]->aquired =='both'){
                                            echo "<td data-th='Property Status'><div> Sale/Rent</div> </td>";
                                        }else{
                                            echo "<td data-th='Property Status'><div><div> </td>";
                                        }
                                        
                                        if(isset($user[$i]->agent_name[0]) && !empty($user[$i]->agent_name[0])){
                                        echo "<td data-th='Agent Name'><div>" . $user[$i]->agent_name[0]->fname.' '.$user[$i]->agent_name[0]->lname. "</div></td>";
                                        }else{
                                        echo "<td data-th='Agent Name'><div>" .'--Not assigned--'.  "</div></td>";
                                        }
                                        echo "<td data-th='Created by'><div>" . $user[$i]->fname.' '.$user[$i]->lname. "</div></td>";
                                        echo "<td data-th='Created by'><div>" .date("d-M-Y", strtotime($user[$i]->created_date)). "</td>";
                                         ?>
                                        <input type="hidden" id="<?php echo trim($user[$i]->id); ?>" value="<?php echo trim($user[$i]->id); ?>" name="<?php echo trim($user[$i]->id); ?>">
                                        <td data-th="Status"><div>
                                           <?php
                                            if ($user[$i]->status == '2') {
                                                echo '<span style="width:10px;height:10px;display:inline-block;background:#EBAF22;"></span>';
                                            } elseif ($user[$i]->status == '3') {
                                                echo '<span style="width:10px;height:10px;display:inline-block;background:#FFCCFF;"></span>';
                                            } elseif ($user[$i]->status == '4') { 
                                                if($user[$i]->agent_status==0){ $appointmeny_status="Pending";}elseif ($user[$i]->agent_status==1) { $appointmeny_status="Confirmed"; }
                                                elseif ($user[$i]->agent_status==2) { $appointmeny_status="Reschedule"; }elseif ($user[$i]->agent_status==3) { $appointmeny_status="Cancel"; }
                                            ?>
                                                <a rel="tooltip" title="<?php echo $appointmeny_status; ?>"> <?php echo '<span style="width:10px;height:10px;display:inline-block;background:#D9EDF7;"></span>';?></a><?php 
                                            } elseif ($user[$i]->status == '5') {
                                                echo '<span style="width:10px;height:10px;display:inline-block;background:#99E2A3;"></span>';
                                            }
                                            ?>
                                            <?php if($user[$i]->status!=5 && $user[$i]->status!=2) { ?>
                                                <select class="inquiry_status" data-propId="<?php echo trim($user[$i]->property_id); ?>" data-ref="<?php echo trim($user[$i]->incquiry_ref_no); ?>" data-id="<?php echo trim($user[$i]->id); ?>" name="incid_<?php echo trim($user[$i]->id); ?>"  id="incid_<?php echo trim($user[$i]->id); ?>" style="width:80px">
                                                    <?php foreach($Action as $key => $value){ 
                                                           if($key == $user[$i]->status){ ?>
                                                <option selected value="<?php echo $key;?>"><?php echo $value;?></option>
                                                <?php }else{ ?>
                                                    <option  value="<?php echo $key;?>"><?php echo $value;?></option>
                                                    <?php } } ?>
                                                </select>
                                            <?php } else if($user[$i]->status==5){ ?>
                                                Complete
                                            <?php } else if($user[$i]->status==2){ ?>
                                                Text-Send
                                            <?php } ?>
                                        </div>
                                        </td>
                                         <td data-th="Actions">
                                            <div>
                                                <?php if (empty($user[$i]->property_id) || ($user[$i]->appoint_start_date == "0000-00-00 00:00:00" && $user[$i]->appoint_end_date == "0000-00-00 00:00:00")) { ?>
                                                    <!-- <a href="scheduleAppointment/<?php echo $user[$i]->id; ?>"  class="btn btn-default btn-xs action-btn" rel="tooltip" title="Schedule Appointment"><i class="fa fa-calendar-check-o"></i></a>  -->
                                                    <a  onclick="checkclient_property(<?php echo $user[$i]->id; ?>,<?php echo $user[$i]->customer_id; ?>,<?php echo $user[$i]->property_id; ?>)" class="btn btn-default btn-xs action-btn" rel="tooltip" title="Schedule Appointment"><i class="fa fa-calendar-check-o"></i></a>
                                                    <!-- href="scheduleAppointment/<?php echo $user[$i]->id; ?>"<a href="scheduleAppointment/<?php echo $user[$i]->id; ?>" class="btn btn-info btn-xs">Schedule Appointment</a>  -->
                                                <?php if ($this->session->userdata('logged_in_super_user') || $this->session->userdata('logged_in_employee')) {  ?>
                                                    <a data-toggle="modal" data-target="#myModal" class="btn btn-default btn-xs action-btn" onclick="setInquiryId(<?php echo $user[$i]->id; ?>)" rel="tooltip" title="View Inquiry"><i class="fa fa-eye"></i></a> 
                                                    <!-- &nbsp;<a href="#popup2" class="btn btn-info btn-xs" onclick="setInquiryId(<?php echo $user[$i]->id; ?>)">View Inquiry</a>  -->
                                                <?php } }else{ ?>
                                                    <a data-toggle="modal" data-target="#myModal" onclick="setInquiryId(<?php echo $user[$i]->id; ?>) " class="btn btn-default btn-xs action-btn" rel="tooltip" title="View Inquiry"><i class="fa fa-eye"></i></a> 
                                                    <!-- &nbsp;<a href="#popup2" onclick="setInquiryId(<?php echo $user[$i]->id; ?>) " class="btn btn-info btn-xs">View Inquiry</a>  -->
                                                    <a class="btn btn-default btn-xs action-btn" rel="tooltip" title="Scheduled"><i class="fa fa-sort"></i></a> 
                                                    <!-- &nbsp;<a class="btn btn-info btn-xs">Scheduled</a>  -->
                                                <?php } if ($this->session->userdata('logged_in_super_user')) { ?>
                                                <a href="delete_inquiry/<?php echo $user[$i]->id; ?>" onclick="return confirm('Are you sure want to delete this record?');" class="btn btn-danger btn-xs action-btn" rel="tooltip" title="Delete"><i class="fa fa-trash"></i></a>
                                                <!-- &nbsp;<a href="delete_inquiry/<?php echo $user[$i]->id; ?>" onclick="return confirm('Are you sure want to delete this record?');" class="btn btn-danger btn-xs">Delete</a> -->
                                                <?php } ?>
                                            </div>
                                        </td>
                                        <?php
                                            //echo "<td>";
                                            //if (empty($user[$i]->property_id) || ($user[$i]->appoint_start_date == "0000-00-00 00:00:00" && $user[$i]->appoint_end_date == "0000-00-00 00:00:00")) {
                                              //  echo anchor('inquiry/scheduleAppointment/' . $user[$i]->id, '<i class="icon-time"></i>', array('title'=>'Schedule Appointment','class'=>'btn btn-default btn-small'));
                                               // if ($this->session->userdata('logged_in_super_user') || $this->session->userdata('logged_in_employee')) {   
                                                //echo '<a class="btn btn-default btn-small" href="#popup2" title="View Inquiry" onclick="setInquiryId(' . $user[$i]->id . ')"><i class="icon-zoom-in"></i></a>';
                                                //}
                                            //} else {
                                              //  echo '<span class="btn btn-default btn-small" title="Scheduled"><i class="icon-time"></i></span>';
                                                //echo '<a class="btn btn-default btn-small" href="#popup2" onclick="setInquiryId(' . $user[$i]->id . ') "><i class="icon-zoom-in"></i></a> ';
                                            //}
                                            //if ($this->session->userdata('logged_in_super_user')) {
                                              //  echo anchor('inquiry/delete_inquiry/' . $user[$i]->id, '<i class="icon-trash"></i>', array('onclick' => "return confirm('Are you sure you want to delete?')",'title'=>'Delete Inquiry','class'=>'btn btn-default btn-small'));
                                            // } else {
                                            //     echo '<span class="btn btn-default btn-small" ><i class="icon-trash"></i></span>';
                                           // }
                                            //echo "</td>";
                                            echo "</tr>";
                                        }
                                        ?>
                                        <?php /*
                                        // echo "<td>";
                                        if(empty($user[$i]->property_id) || ($user[$i]->appoint_start_date == "0000-00-00 00:00:00" && $user[$i]->appoint_end_date== "0000-00-00 00:00:00"))
                                        {
                                          //  echo "<span style='text-align:left;width: 57%;float: left;'><i class='icon-time'></i>&nbsp;" . anchor('inquiry/scheduleAppointment/'.$user[$i]->id, 'Schedule', "title='Schedule Appointment'"). "</span>";
                                            //echo "<span style='text-align:left;width: 57%;float: left;'><div class='box'><i class='icon-zoom-in'></i><a class='button' href='#popup2' onClick='setInquiryId(".$user[$i]->id.")'>View Inquiry</a></div>";
                                        }else{
                                           // echo "<span style='text-align:left;width: 57%;float: left;'>Scheduled</span>";   
                                           // echo "<span style='text-align:left;width: 57%;float: left;'><div class='box'><i class='icon-zoom-in'></i><a class='button' href='#popup2' onClick='setInquiryId(".$user[$i]->id.")'>View Inquiry</a></div>";
                                        }
                                        if ($this->session->userdata('logged_in_super_user')) {
                                        //echo "<span style='text-align:left;width: 50%;float:  none;'><i class='icon-trash'></i>&nbsp;" . anchor('inquiry/delete_inquiry/'.$user[$i]->id, 'Delete', array('onClick' => "return confirm('Are you sure you want to delete?')")). "</span></td>";
                                        }else{$arrayName = array();
                                        //echo "<span style='text-align:left;width: 50%;float:  none;'><i class='icon-trash'></i>&nbsp;" . 'Delete'. "</span></td>";
                                          //echo "</td>";  
                                        }
                                      //echo "</tr>";

                                    } */ ?>
                                </tbody>
                            </table>
                          </form>
                        </div>
                    </div>
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
        <h4 class="modal-title" id="myModalLabel">View Inquiry Detail</h4>
      </div>
      <div class="modal-body">
        <div id="inquiry_datail_popup">
        </div>
      </div>
      <div class="modal-footer">
        <!-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button> -->
      </div>
    </div>
  </div>
</div>
    <!-- Modal -->
<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Import Database</h4>
      </div>
       <form name="inquireexcel_form" id="inquireexcel_form" method="post" action="<?php echo base_url(); ?>index.php/Excelread/inquire_export" enctype="multipart/form-data">
       <fieldset>
        <div class="modal-body">
        <input type="file" name="inquire_xls_files" id="inquire_xls_files"><br>
        Download Format Excel File:
        <a class="" href="<?php echo base_url(); ?>files/example_file/Inquiries.xlsx">Click Here</a>
        <br><br>
        <div id="message_sub">
        </div>
      </div>
      <div class="modal-footer" id="hd_sub">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <input type="submit" id="inq_submit" class="btn btn-primary" width="" value="Submit" >
      </div>
       </fieldset>
    </form>
    </div>
  </div>
</div>
<!-- <div id="popup1" class="overlay">
    <div class="popup">
        <h2>Import Database</h2>
        <a class="close" href="#">×</a>
        <div class="content">
            <div class="row-fluid">
              <div class="">
                <div class="">
                <form name="inquireexcel_form" id="inquireexcel_form" method="post" action="<?php echo base_url(); ?>index.php/Excelread/inquire_export" enctype="multipart/form-data">
                <fieldset>
                    <hr>
                    <input type="file" name="inquire_xls_files" id="inquire_xls_files"><br>
                    Download Format Excel File:
                    <a class="" href="<?php echo base_url(); ?>files/example_file/Inquiries.xlsx">Click Here</a>
                    <br><br>
                    <div id="hd_sub">
                    <input type="submit" id="inq_submit" class="pushme btn span2" width="" value="Submit" >
                    </div>
                    <div id="message_sub">
                    </div>

                    <div class="control-group">
                        <div class="controls">
                            
                        </div>
                    </div>
                </fieldset>
            </form>
                </div>
              </div>
            </div>
        </div>
    </div>
</div> -->
<!-- <div id="popup2" class="overlay">
    <div class="popup">
        <h2>View Inquiry Detail</h2>
        <a class="close" href="#">×</a>
        <div class="content">
            <div class="row-fluid">
              <div class="" id="inquiry_datail_popup">
                
              </div>
            </div>
        </div>
    </div>
</div> -->
<!-- Modal -->
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
<!-- <div id="popup3" class="overlay">
    <div class="popup">
        <h2>Inquiry Reference No. : <b class="popup-ref">#Reference No</b></h2>
        <a class="close" href="#">×</a>
        <div class="content">
            <div class="row-fluid">
                <div class="" id="inquiry_status_change_popup">
                    <input type="hidden" name="inquiry[id]" id="status_change_inquiry_id" value="" />
                    <input type="hidden" name="property[id]" id="status_change_property_id" value="" />
                    <input type="hidden" name="inquiry[status]" id="status_change_inquiry_status" value="" />
                    <label for="status_change_content" id="lbl_status_change_content" class="" style="font-weight:bold">Content :</label>
                    <textarea id="status_change_comments" name="inquiry[content]" class="span12" rows="10" cols="50" ></textarea>
                    <button class="btn btn-primary summit_inquiry_status_with_comment" id="lbl_status_change_button">Change Status</button>
                </div>
            </div>
        </div>
    </div>
</div> -->


<?php
$this->load->view('footer');
?>
<script type="text/javascript" src="<?php echo base_url(); ?>js/excel_file.js"></script>
<script>
$(document).ready(function(){
    $('#example')
        //.on( 'order.dt',  function () { eventFired( 'Order' ); } )
        .on( 'search.dt', function () {
            // eventFired( 'Search' );
            var oTable = $('#example').dataTable();
            var filterCount = oTable.$('tr', {"filter":"applied"}).length;
            
            if(filterCount == 0)
            {
                $("#update_button").hide();
            }else{
                $("#update_button").show();
            }
        })
        //.on( 'page.dt',   function () { eventFired( 'Page' ); } )
        .DataTable();
    $('[data-toggle="popover"]').popover();   
    
    $(document).on('click','.summit_inquiry_status_with_comment',function(){
        //console.log($(this).parents('.content').prev().html());
        
        // $(this).parents('.popup').find('a.close').trigger('click');
        // var href = window.location.href.split("#");
        // window.location = href[0]+"#";
        $('#myModal2').modal('hide')
        changeInquiryStatus();
    });
    
    $(document).on('change',".inquiry_status",function(){
        $(".popup-ref").html($(this).data('ref'));
        $("#status_change_inquiry_id").val($(this).data('id'));
        $("#status_change_property_id").val($(this).data('propId'));
        $("#status_change_inquiry_status").val($(this).val());
        var href = window.location.href.split("#");
        
        if($(this).val()==2){
            $("#lbl_status_change_content").hide();
            $("#status_change_comments").hide();
            changeInquiryStatus();
        }else if($(this).val()==4){
            $("#lbl_status_change_content").hide();
            $("#status_change_comments").hide();
            changeInquiryStatus();
        }else if($(this).val()==3){
            $("#lbl_status_change_content").show();
            $("#status_change_comments").show();
            $("#lbl_status_change_content").html('Comments :');
            $("#lbl_status_change_button").html('Submit Follow –Up Feedback');
            
            $('#myModal2').modal('show')
            //window.location = href[0] + "#popup3";
        }else if($(this).val()==5){
            $("#lbl_status_change_content").show();
            $("#status_change_comments").show();
            $("#lbl_status_change_content").html('Feedback :');
            $("#lbl_status_change_button").html('Complete');            
            //window.location = href[0] + "#myModal2";
            $('#myModal2').modal('show')
        }
    }); 
});
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
function view_inquiry(incview){
window.location="<?php echo base_url(); ?>index.php/inquiry/inquiry_manage?view="+incview;
}
function view_inquiry_client(incview_client){
window.location="<?php echo base_url(); ?>index.php/inquiry/inquiry_manage?view_client="+incview_client;
}
$("#inquireexcel_form").submit(function( event ) {

    if($("#inquire_xls_files").val() != ""){
        var ext = $('#inquire_xls_files').val().split('.').pop().toLowerCase();
        
        if($.inArray(ext, ['xls','xlsx']) == -1) {
            alert('Please Only Upload Excel Files.');
            return false;
        }else{
             $('#hd_sub').hide();
        $('#message_sub').text("System processing your data, please wait for few mins.........................");
        $("#inquireexcel_form").submit();
        }
    }else{
        alert("Please Upload Import Inquiry Details.");
        return false;
    }
});
function checkclient_property(incid,custid,propertyid){

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
// $(".pushme").click(function () {
//     $('#hd_sub').hide();
    
//     $('#message_sub').text("System processing your data, please wait for few mins.........................");
//     });
</script>
