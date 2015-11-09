<?php
$this->load->view('header');
//$Action = array('1' =>'Waiting','2'=>'Inprocess','3' =>'Pending','4' =>'Complete');
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
                        <li><?php echo anchor('home', 'Home', "title='Home'"); ?><span class="divider">/</span></li>
                        <!-- <li><?php echo anchor('inquiry/inquiry_manage', 'Inquiry Management', "title='Inquiry Management'"); ?><span class="divider">/</span></li> -->
                        <li><?php echo anchor('inquiry/new_inquiries', 'New Appointment', "title='New Appointment'"); ?><span class="divider">/</span></li>    
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
                            <span>New Appointment</span>
                        </div>
                        <div class="utopia-widget-content">
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
                                            echo "<td hidden>" . $user[$i]->id . "</td>";
                                            echo "<td>" . $user[$i]->property_ref_no . "</td>";
                                            echo "<td>" . $user[$i]->incquiry_ref_no . "</td>";
                                            if ($user[$i]->aquired == 'sale') {
                                                echo "<td> Sale </td>";
                                            } else if ($user[$i]->aquired == 'rent') {
                                                echo "<td> Rent </td>";
                                            } else if ($user[$i]->aquired == 'both') {
                                                echo "<td> Sale/Rent </td>";
                                            } else {
                                                echo "<td> </td>";
                                            }

                                            if ( (isset($user[$i]->a_fname) && !empty($user[$i]->a_fname) ) && isset($user[$i]->a_lname) && !empty($user[$i]->a_lname) ) {
                                                echo "<td>" . $user[$i]->a_fname . ' ' . $user[$i]->a_lname . "</td>";
                                            } else {
                                                echo "<td>" . '--Not assigned--' . "</td>";
                                            }
                                            echo "<td>" . $user[$i]->u_fname . ' ' . $user[$i]->u_lname . "</td>";
                                            echo "<td>" . date("d-M-Y", strtotime($user[$i]->created_date)) . "</td>";
                                            ?>
                                        <input type="hidden" id="<?php echo trim($user[$i]->id); ?>" value="<?php echo trim($user[$i]->id); ?>" name="<?php echo trim($user[$i]->id); ?>">
                                        <td data-th="Action">
                                            <?php /* <a href="javascript:void(0)" data-id="<?php echo trim($user[$i]->id); ?>" data-status="1" class="btn btn-default btn-small">Action</a> */ ?>
                                            <div class="btn-group">
                                                <a href="javascript:void(0)" data-ref="<?php echo trim($user[$i]->incquiry_ref_no); ?>" data-id="<?php echo trim($user[$i]->id); ?>" data-status="1" class="btn btn-default btn-small action-agent-status">Confirm</a>
                                                <a href="javascript:void(0)" data-ref="<?php echo trim($user[$i]->incquiry_ref_no); ?>" data-id="<?php echo trim($user[$i]->id); ?>" data-status="2" class="btn btn-default btn-small action-agent-status">Reschedule</a>
                                                <a href="javascript:void(0)" data-ref="<?php echo trim($user[$i]->incquiry_ref_no); ?>" data-id="<?php echo trim($user[$i]->id); ?>" data-status="3" class="btn btn-default btn-small action-agent-status">Cancel</a>
                                            </div>
                                        </td>
                                        <?php
                                        echo "<td>";
                                        echo '<a class="btn btn-default btn-small" href="#popup2" title="View Inquiry" onclick="setInquiryId(' . $user[$i]->id . ')"><i class="icon-zoom-in"></i></a>';
                                        if ($this->session->userdata('logged_in_super_user')) {
                                            echo anchor('inquiry/delete_inquiry/' . $user[$i]->id, '<i class="icon-trash"></i>', array('onclick' => "return confirm('Are you sure you want to delete?')",'title'=>'Delete Inquiry','class'=>'btn btn-default btn-small'));
                                        }
                                        echo "</td>";
                                        echo "</tr>";
                                    }
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>   
                    </section>
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
<div id="popup3" class="overlay">
    <div class="popup">
        <h2>Inquiry Reference No. : <b class="popup-ref">#Reference No</b></h2>
        <a class="close" href="#">×</a>
        <div class="content">
            <div class="row-fluid">
                <div class="" id="inquiry_status_change_popup">
                    <input type="hidden" name="inquiry[id]" id="status_change_inquiry_id" value="" />
                    <input type="hidden" name="inquiry[status]" id="status_change_inquiry_status" value="" />
                    <label for="status_change_content" id="lbl_status_change_content" class="" style="font-weight:bold">Content :</label>
                    <textarea id="status_change_comments" name="inquiry[content]" class="span12" rows="10" cols="50" ></textarea>
                    <button class="btn btn-primary summit_inquiry_status_with_comment">Change Status</button>
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
    
    
    function changeAgentStatus(){
        $.ajax({
            url : '<?php echo base_url(); ?>inquiry/ajax_change_inquiry_agent_status',
            data:{ 
                id : $("#status_change_inquiry_id").val(),
                agent_status: $("#status_change_inquiry_status").val(),
                comments: $("#status_change_comments").val()
            },
            dataType:'json',
            type:'post'
        }).done(function(data){
            if(data.status){
                if(data.agent_status==3){
                    $("#status_change_comments").val('');
                }
                $('[data-id='+data.id+']').parents('tr').first().remove();
                alert(data.msg);
            }else{
                alert("Internal Error: could not change Inquiry Status");
            }
        }).fail(function(){
            alert("Internal Error: could not change Inquiry Status");
        });
    }
    
$(document).ready(function () {
                                  
    $(document).on('click','.summit_inquiry_status_with_comment',function(){
        if($("#status_change_comments").val()!=""){
            var href = window.location.href.split("#");
            window.location = href[0]+"#";
            changeAgentStatus();
        }else{
            alert("We need your comments if you want to cancel this Inquiry.");
        }
    });
                                  
    $(".action-agent-status").click(function(){
        $("#status_change_inquiry_id").val($(this).data('id'));
        $("#status_change_inquiry_status").val($(this).data('status'));
        if($(this).data('status')==1 || $(this).data('status')==2){
            changeAgentStatus();
        }else{
            $(".popup-ref").html($(this).data('ref'));
            $("#lbl_status_change_content").html('Comments :');
            var href = window.location.href.split("#");
            window.location = href[0] + "#popup3";
        }
    });

                                            
                                            $('#example')
                                                    //.on( 'order.dt',  function () { eventFired( 'Order' ); } )
                                                    .on('search.dt', function () {
                                                        // eventFired( 'Search' );
                                                        var oTable = $('#example').dataTable();
                                                        var filterCount = oTable.$('tr', {"filter": "applied"}).length;

                                                        if (filterCount == 0)
                                                        {
                                                            $("#update_button").hide();
                                                        } else {
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
                                                url: baseurl + "index.php/inquiry/get_inquiry_recored",
                                                data: 'inquiry_id=' + inquiryId,
                                                success: function (msg) {
                                                    $("#inquiry_datail_popup").html(msg);
                                                }
                                            });

                                        }
                                        function view_inquiry(incview) {
                                            window.location = "<?php echo base_url(); ?>index.php/inquiry/inquiry_manage?view=" + incview;
                                        }
                                        function view_inquiry_client(incview_client) {
                                            window.location = "<?php echo base_url(); ?>index.php/inquiry/inquiry_manage?view_client=" + incview_client;
                                        }
                                        $("#inquireexcel_form").submit(function (event) {

                                            if ($("#inquire_xls_files").val() != "") {
                                                var ext = $('#inquire_xls_files').val().split('.').pop().toLowerCase();

                                                if ($.inArray(ext, ['xls', 'xlsx']) == -1) {
                                                    alert('Please Only Upload Excel Files.');
                                                    return false;
                                                } else {
                                                    $('#hd_sub').hide();
                                                    $('#message_sub').text("System processing your data, please wait for few mins.........................");
                                                    $("#inquireexcel_form").submit();
                                                }
                                            } else {
                                                alert("Please Upload Import Inquiry Details.");
                                                return false;
                                            }
                                        });
// $(".pushme").click(function () {
//     $('#hd_sub').hide();

//     $('#message_sub').text("System processing your data, please wait for few mins.........................");
//     });
</script>



