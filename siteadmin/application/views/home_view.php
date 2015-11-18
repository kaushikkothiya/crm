<?php
//echo'<pre>';print_r($user);exit;
$totagent = $agent[0]->totAgent;
$totemployee = $employee[0]->totEmployee;
$totcustomer = $customer[0]->totCustomer;
$totinquiry = $inquiry[0]->totInquiry;
$totProperty = $property[0]->totProperty;
?>
<?php $this->load->view('header'); ?>
<?php $this->load->view('leftmenu'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="main">
            <h1 class="page-header">Dashboard</h1>
            <div class="row">
                <div class="col-sm-12">
                    <?php if ($this->session->flashdata('success')) { ?>
                        <div class="row">
                            <div class="alert alert-success" role="alert">
                                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                <?php echo $this->session->flashdata('success'); ?>
                            </div>
                        </div>
                    <?php } else if ($this->session->flashdata('error')) { ?>
                        <div class="row">
                            <div class="alert alert-error" role="alert">
                                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>

                                <?php echo $this->session->flashdata('error'); ?>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="row">
                        <?php if ($this->session->userdata('logged_in_super_user')) { ?>
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <a href="<?php echo base_url(); ?>home/agent_manage">
                                    <div class="dashboard-box fb-bg text-center clearfix">
                                        <div class="pull-left"> <i class="fa fa-user"></i> </div>
                                        <div class="pull-right">
                                            <h3><?php echo $totagent;?></h3>
                                            <small>Agent</small> </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <a href="<?php echo base_url(); ?>home/customer_manage">
                                    <div class="dashboard-box twitter-bg text-center clearfix">
                                        <div class="pull-left"> <i class="fa fa-file-text-o"></i> </div>
                                        <div class="pull-right">
                                            <h3><?php echo $totcustomer;?></h3>
                                            <small>Client</small> </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <a href="<?php echo base_url(); ?>home/employee_manage">
                                    <div class="dashboard-box youtube-bg text-center clearfix">
                                        <div class="pull-left"> <i class="fa fa-briefcase"></i> </div>
                                        <div class="pull-right">
                                            <h3><?php echo $totemployee;?></h3>
                                            <small>Employee</small> </div>
                                    </div>
                                </a>
                            </div>
                        <?php } ?>
                        <?php if ($this->session->userdata('logged_in_super_user') || $this->session->userdata('logged_in_agent') || $this->session->userdata('logged_in_employee')) { ?>
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <a href="<?php echo base_url(); ?>inquiry/inquiry_manage">
                                    <div class="dashboard-box instagram-bg text-center clearfix">
                                        <div class="pull-left"> <i class="fa fa-question-circle"></i> </div>
                                        <div class="pull-right">
                                            <h3><?php echo $totinquiry;?></h3>
                                            <small>Inquiry</small> </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <a href="<?php echo base_url(); ?>home/property_manage">
                                    <div class="dashboard-box rss-bg text-center clearfix">
                                        <div class="pull-left"> <i class="fa fa-building"></i> </div>
                                        <div class="pull-right">
                                            <h3><?php echo $totProperty;?></h3>
                                            <small>Property</small> </div>
                                    </div>
                                </a>
                            </div>

                        <?php } ?>
<!--                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <div class="dashboard-box total-bg text-center clearfix">
                                <div class="pull-left"> <b>Total</b> </div>
                                <div class="pull-right">
                                    <h3>1365</h3>
                                    <small>Contents</small> </div>
                            </div>
                        </div>-->
                    </div>
                    <div class="sep"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('footer'); ?>

