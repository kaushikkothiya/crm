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
                        <li><?php echo anchor('newsletter/email_newsletter_list', 'Email Newsletter', "title='Email Newsletter'"); ?>
                            <span class="divider">
                            </span></li>
                            
                        <li style="float:right;"><a href="<?php echo base_url(); ?>newsletter/emailnewsletter"><input type="button" value="Add New" /></a></li>
                    </ul>
                </div>
            </div>
<?php if ($this->session->flashdata('success')) { ?>
                <div class="alert alert-success" role="alert">
                    <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
    <?php echo $this->session->flashdata('success'); ?>
                </div>
                <?php }else if ($this->session->flashdata('error')) { ?>
                <div class="alert alert-danger" role="alert">
                    <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
    <?php echo $this->session->flashdata('error'); ?>
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
                                        <th>Title</th>
                                        <th>Content</th>
                                        <th>Campaign ID</th>
                                        <th>Type</th>
                                        <th>Schedule</th>
                                        <th>Created</th>
                                    </tr>
                                </thead>
                                <tbody>
<?php
if (!empty($newsletters)) {
    foreach ($newsletters as $key => $value) {
        ?>
                                            <tr>
                                                <td hidden><?php echo $value->id; ?></td>
                                                <td><?php echo $value->title; ?></td>
                                                <td><?php echo $value->content; ?></td>
                                                <td><?php echo $value->campaign_id; ?></td>
                                                <td><?php echo $value->type; ?></td>
                                                <td><?php if($value->type=='date'){ echo date("m/d/Y",strtotime($value->schedule)); }else{ echo $value->schedule; } ?></td>
                                                <td><?php echo date("m/d/Y",strtotime($value->created)); ?></td>
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



