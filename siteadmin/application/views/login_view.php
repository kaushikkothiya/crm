<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no" />
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" href="<?php echo base_url(); ?>images/favicon.ico">
        <title><?php echo $this->config->item('TITLE'); ?>- Real Estate</title>
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
                        <?php echo form_open('verifylogin'); ?>
                        <h3 class="form-signin-heading">Please sign in</h3>
                        <label for="inputEmail" class="sr-only">Email address</label>
                        <?php
                            $username = array(
                                'name' => 'username',
                                'id' => 'username',
                                'value' => '',
                                'class' => 'form-control input-lg',
                                'placeholder' => 'Email address',
                                'required'=>'required',
                                'autofocus'=>'autofocus',
                            );
                            echo form_input($username);
                        ?>
                        <div>&nbsp;</div>
                        <label for="inputPassword" class="sr-only">Password</label>
                            <?php
                            $password = array(
                                'type' => 'password',
                                'name' => 'password',
                                'id' => 'password',
                                'class' => 'form-control input-lg',
                                'value' => '',
                                'placeholder' => 'Password',
                                'required'=>'required',
                            );
                            echo form_input($password);
                            ?>
                        <?php /* <div class="checkbox">
                          <label>
                          <input type="checkbox" value="remember-me">
                          Remember me </label>
                          </div> */ ?>
                        <div>&nbsp;</div>
                        <?php echo form_button(array(
                            'name'=>'submit', 
                            'value'=>'Sign in',
                            'content'=>'Sign in',
                            'class'=>'btn btn-lg btn-primary btn-block',
                            'type'=>'submit'
                        )); ?>
                        <div>&nbsp;</div>
                        <div class="text-center"><a href="<?php base_url(); ?>home/forgote_pass">Forgot Password?</a></div>
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
        <script type="text/javascript" src="<?php echo base_url(); ?>js/login.js"></script>
    </body>
</html>
