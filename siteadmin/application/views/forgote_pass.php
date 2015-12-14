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
                        <?php echo form_open('home/forgote_password'); ?>
                        <h3 class="form-signin-heading">Forgot password?</h3>
                        <label for="inputEmail" class="sr-only">Email address</label>
                        <?php $pass_arr = array(
                            'type' => 'email',
                            'name' => 'email',
                            'id' => 'email',
                            'placeholder' => "Email address",
                            'value' => '',
                            'size' => '30',
                            'class' => 'form-control input-lg',
                            'placeholder' => 'Please enter email',
                            'required'=>'required',
                        );
                        echo form_input($pass_arr);
                        ?>
                        <div>&nbsp;</div>
                        <?php echo form_submit('submit', 'Submit', 'class="btn btn-lg btn-primary btn-block"'); ?>
                        <div>&nbsp;</div>
                        <div class="text-center"><a href="<?php echo base_url() ?>index.php/home">Back to Login</a></div>
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
        <script type="text/javascript" src="<?php echo base_url(); ?>js/forgote_password.js"></script>
    </body>
</html>
