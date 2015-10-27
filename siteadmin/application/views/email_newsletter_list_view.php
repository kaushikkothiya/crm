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
        <div class="span10 body-container">
            <div class="row-fluid">
                <div class="span12">
                    <ul class="breadcrumb">
                        <li><?php echo anchor('home', 'Home', "title='Home'"); ?>
                            <span class="divider">/
                            </span></li>
                        <li><?php echo anchor('home/email_newsletter_list', 'Email Newsletter', "title='Email Newsletter'"); ?>
                            <span class="divider">
                            </span></li>
						<li style="float:right;"><a href="email_newsletter"><input type="button" value="Add New" /></a></li>
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
                            <span>Email Newsletter </span>
                        </div>
                        <div class="utopia-widget-content">
                            <table id="example" class="display" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th hidden>id</th>
                                        <th>Subject</th>
                                        <th>Type</th>
                                        <th>Message</th>
                                        <th>User List</th>
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
                                                <!-- <td>
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
<?php
$this->load->view('footer');
?>



