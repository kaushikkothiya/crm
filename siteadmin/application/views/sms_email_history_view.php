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
                <link href="<?php echo base_url(); ?>css/popupbox.css" rel="stylesheet">
            </div>
        </div>
        <div class="span10 body-container">
            <div class="row-fluid">
                <div class="span12">
                    <ul class="breadcrumb">
                        <li><?php echo anchor('home', 'Home', "title='Home'"); ?>
                            <span class="divider">/
                            </span></li>
                        <li><?php echo anchor('home/sms_email_history', 'History', "title='SMS/Email History'"); ?>
                            <span class="divider">
                            </span></li>
								<!-- <li style="float:right;"><a href="add_agent"><input type="button" value="Add New" /></a></li> -->
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
                            <span>SMS / Email History </span>
                        </div>
                        <div class="utopia-widget-content">
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
                                                <td hidden><?php echo $value->id; ?>
                                                <td><?php echo $value->subject; ?>
                                                <td><?php echo $value->type; ?>
                                                <td><?php echo $value->reciever; ?>
                                                <td><?php echo $value->fname." ".$value->lname; ?>
                                                <td><?php echo date("d-M-Y", strtotime($value->created_date)); ?>
                                                <td><div class='box'><i class='icon-zoom-in'></i><a class='button' href='#popup2' onClick='setInquiryId("<?php echo $value->type; ?>",<?php echo $value->id; ?>)'>View</a></div></td>
                                                <!--<td>
                                                 <td>
                                                    <span style='text-align:left;width: 50%;float: left;'><i class='icon-pencil'></i>&nbsp;
                                                        <?php //echo anchor('home/add_agent/'.$user[$i]->id, 'Edit', "title='Edit agent'"); ?>
                                                    </span>
                                                    <span style='text-align:left;width: 50%;float: left;'><i class='icon-trash'></i>&nbsp;
                                                        <?php //echo anchor('home/delete_agent/'.$user[$i]->id, 'Delete', array('onClick' => "return confirm('Are you sure want to delete this record?')")) ?>
                                                    </span>
                                                </td> -->
                                            </tr>
                                            <?php
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>   
                    </section>
                </div>
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



