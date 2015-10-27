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
<li><?php echo anchor('inquiry/new_exist_client', 'New or Existing Client', "title='New or Existing Client'"); ?>
<span class="divider">
</span></li>
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
<div class="span12"><section id="formElement" class="utopia-widget utopia-form-box section">
<div class="utopia-widget-title"><span>New or Existing Client </span>

</div>
<div class="row-fluid">
<div class="utopia-widget-content" style=" margin-bottom:35px; padding:40px 25px;  !important">
<a href="<?php echo base_url(); ?>inquiry/new_client"><img src="<?php echo base_url(); ?>img/icons2/new-client.png"></a>&nbsp;&nbsp;&nbsp;
<a href="<?php echo base_url(); ?>inquiry/exist_client"><img src="<?php echo base_url(); ?>img/icons2/exist-client.png"></a>
<!-- <div class="span3">
<div class="utopia-chart-legend">
<div class="utopia-chart-icon"><a href="<?php echo base_url(); ?>inquiry/new_client"><img src="<?php echo base_url(); ?>img/icons2/new-client.png"></a>
</div> -->

</div>
</div>
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
<script type="text/javascript">
</script>