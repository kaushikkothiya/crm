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
<li><?php //echo anchor('home', 'Home', "title='Home'"); ?>
<span class="divider" style="color:black">New listing or Reference Number
</span></li>
<li><?php //echo anchor('home/agent_manage', 'Manage Agent', "title='Manage Agent'"); ?>
<span class="divider">
</span></li>
<?php if ($this->uri->segment(3)) { ?>
<li><?php //echo anchor('home/add_agent/'.$usrid, 'Edit Agent', "title='Edit Agent'"); ?> 
<?php } else { ?>
<li><?php //echo anchor('home/add_agent', 'Add Agent', "title='Add Agent'"); ?> 
<?php } ?>
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
<div class="utopia-widget-title">
<span>
<?php if ($this->uri->segment(3)) { ?>
    New listing or Reference Number
<?php } else { ?>
    New listing or Reference Number
<?php } ?>
</span>
</div>
<div class="row-fluid">
<div class="utopia-widget-content">
<div class="span6 utopia-form-freeSpace">
<?php echo form_open_multipart('inquiry/new_listing_reference', array('class' => 'form-horizontal')); ?>
<fieldset>


<div class="control-group">
<div class="controls">
<input type="radio" name="sex" checked value="new_listing" onclick="hide();"> New listing<br>
<input type="radio" name="sex" value="reference_number" onclick="show();"> Reference Number
<div><?php
    //echo $search_detail; exit;
    if(!empty($search_detail))
    {
        echo $search_detail;       
    }
     ?>
    
</div>
<div id="xyz" hidden>
<input type="text" name="referenece_id"  id="referenece_id" placeholder="Please Enter Reference Number"> 
</div>
</div>

</div>
<div class="control-group">

<div class="controls">

<?php
	echo form_submit('submit', 'Next', "class='btn span5'");
?>
<?php //echo anchor('home/agent_manage', 'Cancel', array('title' => 'Cancel', 'class' => 'btn span4')); ?>
</div>
</div>
</fieldset>
</form>
</div>

<div class="span6 utopia-form-freeSpace">
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

<script type="text/javascript" src="<?php echo base_url(); ?>js/agent.js"></script>
<script type="text/javascript">
function hide(){
        document.getElementById('xyz').hidden = true;
    }
    function show(){
        document.getElementById('xyz').hidden = false;
    }
 //document.getElementById('referenece_id').style.display = 'none';
  

function numbersonly(e){
    var unicode=e.charCode? e.charCode : e.keyCode
    if (unicode!=8){ //if the key isn't the backspace key (which we should allow)
        if (unicode<48||unicode>57) //if not a number
            return false //disable key press
    }
}

</script>