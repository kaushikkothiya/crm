<?php
$this->load->view('header');
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
  
      	<h1 class="page-header">New or Existing Client</h1>
      	<div class="row">
          <div class="col-sm-12">
            <div class="panel panel-default">
            		<div class="panel-heading">New or Existing Client</div>
              <div class="panel-body">
             	<div class="form-group">
                    <label class="col-md-3 col-sm-4 control-label"></label>
                    <div class="col-sm-12">
	                    <div class="text-center">
                        
						<a href="<?php echo base_url(); ?>inquiry/new_client"><img src="<?php echo base_url(); ?>img/icons2/new-client.png"></a><span class="sep"></span>
						<a href="<?php echo base_url(); ?>inquiry/exist_client"><img src="<?php echo base_url(); ?>img/icons2/exist-client.png"></a>
						
            <!-- <div class="span3">
						<div class="utopia-chart-legend">
						<div class="utopia-chart-icon"><a href="<?php echo base_url(); ?>inquiry/new_client"><img src="<?php echo base_url(); ?>img/icons2/new-client.png"></a>
						</div> -->

</div>
                    </div>
                  </div>  
              </div>
            </div>
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
</script>
