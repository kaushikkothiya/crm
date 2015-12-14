<?php
if ($this->uri->segment(3)) {
    $property_id = $this->uri->segment(3);
} else {
    $property_id = "";
}
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
            <h1 class="page-header">Search Existing Client</h1>
            <div class="row">
                <div class="col-sm-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">Search Existing Client</div>
                        <div class="panel-body">
                            <?php
                            if (!empty($property_id)) {
                                echo form_open_multipart('home/sendNewClientInquiry_exist_client', array('class' => 'form-horizontal'));
                            } else {
                                echo form_open_multipart('inquiry/property', array('class' => 'form-horizontal'));
                            }
                            ?>
                            <input type="hidden" id="customer_id" name="customer_id" value="<?php if (isset($id) && !empty($id)) {
                                echo $id;
                            } ?>">
                            <?php
                            echo form_hidden('property_id', $property_id);
                            ?>
                            <div class="form-group">
                                <label class="col-md-3 col-sm-4 control-label">Email or Mobile Phone <span class="star">*</span> :</label>
                                <div class="col-sm-6">
                                    <?php
                                    $email = array(
                                        'name' => 'email_mobile',
                                        'id' => 'email_mobile',
                                        'placeholder' => "Enter Email or Mobile Phone",
                                        'class' => 'form-control',
                                    );
                                    echo form_input($email);
                                    ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 col-sm-4 control-label">Property Status :</label>
                                <div class="col-sm-6">
                                    <?php
                                    $status = array('id' => 'aquired', 'name' => 'aquired');
                                    ?>
                                    <label class="radio-inline">
                                        <?php echo form_radio($status, 'sale', 'checked', 'class="radio_buttons required"'); ?>
                                        Sale</label>
                                    <label class="radio-inline">
                                        <?php echo form_radio($status, 'rent', '', 'class="radio_buttons required"'); ?>
                                        Rent</label>
                                    <label class="radio-inline">
                                        <?php echo form_radio($status, 'both', '', 'class="radio_buttons required"'); ?>
                                        Both</label>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 col-sm-4 control-label">&nbsp;</label>
                                <div class="col-sm-6">

                                    <input type="submit" class="btn btn-sm btn-primary" value="Search" name="customer_form1" id="customer_form1">
                                    <?php echo anchor('inquiry/new_exist_client', 'Cancel', array('title' => 'Cancel', 'class' => 'btn btn-sm btn-default')); ?>
                                    <a class="create-new-client hidden" href="javascript:void(0)" >Create New Client</a>
                                </div>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<form id="frm-existing-client" method="post">
    <input type="hidden" id="re_aquired" name="aquired" value=""  />
    <input type="hidden" id="re_email_mobile" name="email_mobile" value=""  />
</form>
<?php
$this->load->view('footer');
?>
<script type="text/javascript" src="<?php echo base_url(); ?>js/exist_customer.js"></script>
<script type="text/javascript">
</script>