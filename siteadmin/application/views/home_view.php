<?php

$this->load->view('header');
//echo'<pre>';print_r($user);exit;
$totagent =$agent[0]->totAgent;
$totemployee =$employee[0]->totEmployee;
$totcustomer =$customer[0]->totCustomer;
$totinquiry =$inquiry[0]->totInquiry;
$totProperty =$property[0]->totProperty;
							
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
	<?php if ($this->session->flashdata('success')) { ?>
                <div class="alert alert-success" role="alert">
                    <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <?php echo $this->session->flashdata('success'); ?>
                </div>
            <?php }else if($this->session->flashdata('error')){ ?>
                <div class="alert alert-error" role="alert">
                    <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    
                    <?php echo $this->session->flashdata('error'); ?>
                </div>
            <?php } ?>

<div class="row-fluid">
<?php  if ($this->session->userdata('logged_in_super_user')) { ?>
<a href="<?php echo base_url(); ?>home/agent_manage">
<div class="span3">
<div class="utopia-chart-legend">
<div class="utopia-chart-icon"><img src="<?php echo base_url(); ?>img/icons2/user.png">
</div>
<div class="utopia-chart-heading"><?php echo $totagent;?>
</div>
<div class="utopia-chart-desc">Agent
</div>
</div>
</div>
</a>
<a href="<?php echo base_url(); ?>home/customer_manage">
<div class="span3">
<div class="utopia-chart-legend">
<div class="utopia-chart-icon"><img src="<?php echo base_url(); ?>img/icons2/categories.png">
</div>
<div class="utopia-chart-heading"><?php echo $totcustomer;?>
</div>
<div class="utopia-chart-desc">Client
</div>
</div>
</div>
</a>
<a href="<?php echo base_url(); ?>home/employee_manage">
<div class="span3">
<div class="utopia-chart-legend">
<div class="utopia-chart-icon"><img src="<?php echo base_url(); ?>img/icons2/stop.png">
</div>
<div class="utopia-chart-heading"><?php echo $totemployee;?>
</div>
<div class="utopia-chart-desc">Employee
</div>
</div>
</div>
</a>
<?php } ?>
<?php  if ($this->session->userdata('logged_in_super_user') || $this->session->userdata('logged_in_agent') || $this->session->userdata('logged_in_employee')) { ?>
<a href="<?php echo base_url(); ?>inquiry/inquiry_manage">
<div class="span3">
<div class="utopia-chart-legend">
<div class="utopia-chart-icon"><img src="<?php echo base_url(); ?>img/icons2/window.png">
</div>
<div class="utopia-chart-heading"><?php echo $totinquiry;?>
</div>
<div class="utopia-chart-desc">Inquiry
</div>
</div>
</div>
</a>
<a href="<?php echo base_url(); ?>home/property_manage">
<div class="span3">
<div class="utopia-chart-legend">
<div class="utopia-chart-icon"><img src="<?php echo base_url(); ?>img/icons2/world.png">
</div>
<div class="utopia-chart-heading"><?php echo $totProperty;?>
</div>
<div class="utopia-chart-desc">Property
</div>
</div>
</div>
</a>
<?php } ?>
</div>
</div>
</div>
</div>
<?php
$this->load->view('footer');
?>

