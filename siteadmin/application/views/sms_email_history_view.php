<?php

$this->load->view('header');?>
<!-- <link href="<?php echo base_url(); ?>css/popupbox.css" rel="stylesheet"> -->
<?php
$this->load->view('leftmenu');
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
        <h1 class="page-header">SMS / Email History 
          <!-- <button class="btn btn-sm btn-success pull-right" type="button" onClick="window.location.href = 'add_agent';">Create Agent</button> -->
        </h1>
        <div class="row">   
          <div class="col-sm-12">
                    <div>
                        <table id="example" class="display" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th hidden>id</th>
                                        <th>Subject</th>
                                        <th>Type</th>
                                        <th>Receiver Email/Mobile</th>
                                        <th>Receiver Name</th>
                                        <th>Send Date</th>
                                        <th>Text</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if(!empty($sms_email_history))
                                    {
                                        foreach ($sms_email_history as $key => $value)
                                        {
                                            ?>
                                            <tr>
                                                <td data-th='id.' hidden><div><?php echo $value->id; ?></div></td>
                                                <td data-th='Subject'><div><?php echo $value->subject; ?></div></td>
                                                <td data-th='Type'><div><?php echo $value->type; ?></div></td>
                                                <td data-th='Receiver Email/Mobile'><div><?php echo $value->reciever; ?></div></td>
                                                <td data-th='Receiver Name'><div><?php echo $value->name; ?></div></td>
                                                <td data-th='Send Date'><div><?php echo date("d-M-Y", strtotime($value->created_date)); ?></div></td>
                                                <td data-th="Text">
                                                <div>
                                                    <a data-toggle="modal" data-target="#myModal" class="btn btn-default btn-xs action-btn" onClick='setInquiryId("<?php echo $value->type; ?>",<?php echo $value->id; ?>)' rel="tooltip" title="View"><i class="fa fa-eye"></i></a> 
                                                    <!-- <a class="btn btn-info btn-xs" data-toggle="modal" data-target="#myModal" title="View" onClick='setInquiryId("<?php echo $value->type; ?>",<?php echo $value->id; ?>)'>View</a> -->
                                                </div>
                                                </td>
                                                 </tr>
                                            <?php
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"  id="type"></h4>
      </div>
      <div class="modal-body" id="set_text">
       <form name="inquireexcel_form" id="inquireexcel_form" method="post" action="<?php echo base_url(); ?>/index.php/Excelread/inquire_export" enctype="multipart/form-data">
                <fieldset>
                    <!-- <div id="set_text">

                    </div> -->
                </fieldset>
            </form>
      </div>
      <div class="modal-footer">
        <!-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button> -->
      </div>
    </div>
  </div>
</div>
<div id="popup2" class="overlay">
    <div class="popup">
        <h2 id="type"></h2>
        <a class="close" href="#">×</a>
        <div class="content">
            <div class="row-fluid">
              <div class="">
                <div class="">
                <form name="inquireexcel_form" id="inquireexcel_form" method="post" action="<?php echo base_url(); ?>/index.php/Excelread/inquire_export" enctype="multipart/form-data">
                <fieldset>
                    <div id="set_text">

                    </div>
                </fieldset>
            </form>
                </div>
              </div>
            </div>
        </div>
    </div>
</div>
<?php
$this->load->view('footer');
?>
<script>
function setInquiryId(type,id)
{
    $.ajax({
        type: "post",
        url:baseurl+"index.php/inquiry/get_sms_email_text",
        data: 'id='+id,
        success: function(msg){

            $("#set_text").html(msg);
            $("#type").html(type);
        }
    });
          
        
   
}
</script>