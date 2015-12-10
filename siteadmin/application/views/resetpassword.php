<?php 
$new_password = '';
$conf_password = ''; 

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no" />
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" href="<?php echo base_url(); ?>images/favicon.ico">
        <title>Monopolion - Real Estate</title>
        <!-- Bootstrap core CSS -->
        <link href="<?php echo base_url(); ?>css/toaster.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>new/css/bootstrap.min.css" rel="stylesheet">
        <!-- Custom styles for this template -->
        <link href="<?php echo base_url(); ?>new/css/style.css" rel="stylesheet" type="text/css" charset="utf-8" />
    </head>
    <body class="login-bg">
        <div class="wrapper">
            <div class="container">
                <div class="row">
                
                    <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3">
                        <div class="text-center"><img class="img-responsive" src="<?php echo base_url(); ?>images/logo.png" width="200" alt=""/></div>
                        <div class="sep"></div>
                        <?php if ($this->session->flashdata('success')) { ?>
                <div class="alert alert-success" role="alert">
                    <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <?php echo $this->session->flashdata('success'); ?>
                </div>
            <?php } ?>
            <?php  if($this->session->flashdata('danger')){ ?>
            <div class="text-center alert alert-danger"><?php echo $this->session->flashdata('danger'); ?></div>
            <div class="sep"></div>
            <?php  } ?>
                       <?php echo form_open_multipart('home/resetpassword', array('class' => 'form-horizontal')); ?>
                       <?php  
                            echo form_hidden('id', $userid);
                        ?>
                        <h3 class="form-signin-heading">Reset Password</h3>
                        <?php
                            $new_pass_arr = array(
                                'type' => 'password',
                                'name' => 'new_password',
                                'id' => 'new_password',
                                'value' => set_value('new_password', $new_password),
                                'class' => 'form-control',
                                'placeholder'=>'New password'
                            );
                            echo form_input($new_pass_arr);
                        ?>
                    </br>
                        <?php
                            $conf_pass_arr = array(
                                'type' => 'password',
                                'name' => 'conf_password',
                                'id' => 'conf_password',
                                'value' => set_value('conf_password', $conf_password),
                                'class' => 'form-control',
                                'placeholder'=>'Confirm New Password'
                            );
                            echo form_input($conf_pass_arr);
                        ?>

                        <div>&nbsp;</div>
                        <?php echo form_submit('submit', 'Submit', 'class="btn btn-lg btn-primary btn-block"'); ?>
                    </form>
                        <div>&nbsp;</div>
                        <div>&nbsp;</div>
                        <?php echo form_close(); ?>
                        <div class="text-center"><small class="text-muted">&copy; 2015 <?php echo $this->config->item('TITLE'); ?>- Real Estate.</small></div>
                        <div>&nbsp;</div>
                    </div>
                </div>
            </div>
            <!-- /container --> 
        </div>
        <script src="<?php echo base_url(); ?>new/js/jquery.min.js"></script> 
        <script src="<?php echo base_url(); ?>new/js/bootstrap.min.js"></script> 
        <script src="<?php echo base_url(); ?>new/js/custom.js"></script>
        <script src="<?php echo base_url(); ?>js/resetpassword.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/toaster.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.validate.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/additional-methods.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.cookie.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/chosen.jquery.js"></script>
        
    </body>
</html>
