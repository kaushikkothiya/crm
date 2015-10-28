<?php

$this->load->view('header');
//$Action = array('1' =>'Waiting','2'=>'Inprocess','3' =>'Pending','4' =>'Complete');
$Action = array('1' =>'Follow-Up','2' =>'Text-Send','3' =>'Complete');
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
                        <li><?php echo anchor('inquiry/inquiry_manage', 'Inquiry Management', "title='Inquiry Management'"); ?>
                            <span class="divider">/
                            </span></li>
                            <?if ($this->session->userdata('logged_in_super_user')) { ?>
								<li style="float:right;"><a href='#popup1'><input type="button" value="Import Inquiry Datails" /></a></li>
                            <?php } ?>
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
                            <span>Inquiry Management </span>
                        </div>
                        <div class="utopia-widget-content">
                            <form action="inquiry_manage" name="mul_rec" id="mul_rec" method="post" enctype="multipart/form-data">
                            <div class="col-sm-2 pull-left">
                <span style="width:15px;height:15px;display:inline-block;background:#EBAF22;"></span> Follow-Up<!-- Waiting -->
                <!-- <span style="width:15px;height:15px;display:inline-block;background:#FFCCFF;"></span> Inprocess -->
                <span style="width:15px;height:15px;display:inline-block;background:#D9EDF7;"></span> Txt-Send<!-- Pending -->
                <span style="width:15px;height:15px;display:inline-block;background:#99E2A3;"></span> Complete<!-- Complete -->
                
                
            </div>&nbsp;&nbsp;&nbsp;&nbsp;
                <span>View Inquiry By :  &nbsp;&nbsp;
                <select name="view_inc"  id="view_inc" style="width:200px" onchange="view_inquiry(this.value);">
                    <option value="" <?php if(empty($_GET['view'])) { echo "selected"; } ?>>All</option>
                    <option value="rent" <?php if(!empty($_GET['view']) && $_GET['view']== "rent") { echo "selected"; } ?> >Rent inquiry</option>
                    <option value="sale" <?php if(!empty($_GET['view']) && $_GET['view']== "sale") { echo "selected"; } ?>>Sale inquiry</option>
                    <option value="latest" <?php if(!empty($_GET['view']) && $_GET['view']== "latest") { echo "selected"; } ?>>Latest inquiry</option>
                </select>
                </span>
                <span>View Inquiry for :  &nbsp;&nbsp;
                <select name="view_inc_client"  id="view_inc_client" style="width:200px" onchange="view_inquiry_client(this.value);">
                    <?php 
                    ?>
                    <option value="" <?php if(empty($_GET['view_client'])) { echo "selected"; } ?>>All</option>
                    <?php foreach($all_client as $key => $value){ ?>
                    <option value="<?php echo $value->id;?>" <?php if(!empty($_GET['view_client']) && $_GET['view_client']== $value->id) { echo "selected"; } ?> ><?php echo $value->fname.' '.$value->lname;?></option>
                    <?php }?>
                </select>
                </span>
                            <div class="table-responsive">
                            <table id="example" class="display" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th hidden>Id</th>
                                        <th>Reference No</th>
                                        <th>Inquiry No</th>
                                        <th>Property Status</th>
                                        <th>Agent Name</th>
                     					<th>Created by</th>
                                        <th>Date Created</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    for ($i = 0; $i < count($user); $i++) {

                                        echo "<tr>";
                                        echo "<td hidden>" . $user[$i]->id. "</td>";
                                        echo "<td>" . $user[$i]->property_ref_no. "</td>";
                                        echo "<td>" . $user[$i]->incquiry_ref_no. "</td>";
                                        if($user[$i]->aquired =='sale'){
                                            echo "<td> Sale </td>";
                                        }
                                        else if($user[$i]->aquired =='rent'){
                                            echo "<td> Rent </td>";
                                        }else if($user[$i]->aquired =='both'){
                                            echo "<td> Sale/Rent </td>";
                                        }else{
                                            echo "<td> </td>";
                                        }
                                        
                                        if(isset($user[$i]->agent_name[0]) && !empty($user[$i]->agent_name[0])){
                                        echo "<td>" . $user[$i]->agent_name[0]->fname.' '.$user[$i]->agent_name[0]->lname. "</td>";
                                        }else{
                                        echo "<td>" .'--Not assigned--'.  "</td>";
                                        }
                                        echo "<td>" . $user[$i]->fname.' '.$user[$i]->lname. "</td>";
                                        echo "<td>" .date("d-M-Y", strtotime($user[$i]->created_date)). "</td>";
                                         ?>
                                        <input type="hidden" id="<?php echo trim($user[$i]->id); ?>" value="<?php echo trim($user[$i]->id); ?>" name="<?php echo trim($user[$i]->id); ?>">
                                        <td data-th="Action">
                                           <?php if($user[$i]->status == '1'){
                                            echo '<span style="width:10px;height:10px;display:inline-block;background:#EBAF22;"></span>';
                                         }elseif($user[$i]->status == '2'){ 
                                        echo '<span style="width:10px;height:10px;display:inline-block;background:#FFCCFF;"></span>';
                                         } elseif($user[$i]->status == '3'){ 
                                        echo '<span style="width:10px;height:10px;display:inline-block;background:#D9EDF7;"></span>';
                                         }else{ 
                                        echo '<span style="width:10px;height:10px;display:inline-block;background:#99E2A3;"></span>';
                                         } ?>
                                            <select name="incid_<?php echo trim($user[$i]->id); ?>"  id="incid_<?php echo trim($user[$i]->id); ?>" style="width:80px">
                                                <?php foreach($Action as $key => $value){ 
                                                       if($key == $user[$i]->status){
                                            ?>
                                            <option selected value="<?php echo $key;?>"><?php echo $value;?></option>
                                            <?php }else{ ?>
                                                <option  value="<?php echo $key;?>"><?php echo $value;?></option>
                                                <?php } } ?>
                                            </select>                                                                           
                                        </td>
                                        <?
                                        echo "<td>";
                                        if(empty($user[$i]->property_id) || ($user[$i]->appoint_start_date == "0000-00-00 00:00:00" && $user[$i]->appoint_end_date== "0000-00-00 00:00:00"))
                                        {
                                            echo "<span style='text-align:left;width: 57%;float: left;'><i class='icon-time'></i>&nbsp;" . anchor('inquiry/scheduleAppointment/'.$user[$i]->id, 'Schedule', "title='Schedule Appointment'"). "</span>";
                                            echo "<span style='text-align:left;width: 57%;float: left;'><div class='box'><i class='icon-zoom-in'></i><a class='button' href='#popup2' onClick='setInquiryId(".$user[$i]->id.")'>View Inquiry</a></div>";
                                        }else{
                                            echo "<span style='text-align:left;width: 57%;float: left;'>Scheduled</span>";   
                                            echo "<span style='text-align:left;width: 57%;float: left;'><div class='box'><i class='icon-zoom-in'></i><a class='button' href='#popup2' onClick='setInquiryId(".$user[$i]->id.")'>View Inquiry</a></div>";
                                        }
                                        if ($this->session->userdata('logged_in_super_user')) {
                                        echo "<span style='text-align:left;width: 50%;float:  none;'><i class='icon-trash'></i>&nbsp;" . anchor('inquiry/delete_inquiry/'.$user[$i]->id, 'Delete', array('onClick' => "return confirm('Are you sure you want to delete?')")). "</span></td>";
                                        }else{$arrayName = array();
                                        //echo "<span style='text-align:left;width: 50%;float:  none;'><i class='icon-trash'></i>&nbsp;" . 'Delete'. "</span></td>";
                                          echo "</td>";  
                                        }
                                      echo "</tr>";

                                    }

                                    ?>
                                </tbody>
                            </table>
                        </div>
                            <div>
                                <?php  if(count($user) !=0){ ?>
                               
                            <button type="Submit"  id="update_button" style="width:144px; float:right; margin:5px 107px 5px">Update Status</button>
                           
                                <?php } ?>
                             </div>
                      </form>
                        </div>   
                    </section>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="popup1" class="overlay">
    <div class="popup">
        <h2>Import Inquiry Details</h2>
        <a class="close" href="#">×</a>
        <div class="content">
            <div class="row-fluid">
              <div class="">
                <div class="">
                <form name="inquireexcel_form" id="inquireexcel_form" method="post" action="<?php echo base_url(); ?>/index.php/Excelread/inquire_export" enctype="multipart/form-data">
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
                            <!--<input type="submit" class="btn" value="Add Inquiry" name="inquiry_form" id="inquiry_form">-->
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
<div id="popup2" class="overlay">
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
</div>
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
});
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
// $(".pushme").click(function () {
//     $('#hd_sub').hide();
    
//     $('#message_sub').text("System processing your data, please wait for few mins.........................");
//     });
</script>



