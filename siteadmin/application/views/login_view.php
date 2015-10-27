<?php

$this->load->view('header');

?>
<div class="container-fluid">
<div class="row-fluid">
<div class="span12">
<div class="utopia-login-message">
<h1></h1></br>
<p></p></br>
</div>
</div>
</div>
<div class="row-fluid">
<div class="span12">
<div class="row-fluid">
<div class="span6" style="margin-top: 15px;">
<div class="utopia-login-info"><img src="<?php echo base_url(); ?>img/logo.png" alt="image">
</div>
</div>

<div class="span6">
<div class="utopia-login"><h1>Welcome to Monopolion</h1>
<?php echo form_open('verifylogin',array('class' => 'utopia')); ?>
    <label>Email:</label>
    <?php
    echo form_open('verifylogin');
    $username = array(
        'name' => 'username',
        'id' => 'username',
        'value' => '',
	    'class' => 'utopia-fluid-input',
        'size' => '30',
        'placeholder' => 'Email',
    );
    echo form_input($username);
    ?>
    <div class="error"><?php //echo form_error('username'); ?></div>
    <label>Password:</label>
    <?php
    $password = array(
        'type' => 'password',
        'name' => 'password',
        'id' => 'password',
	    'class' => 'utopia-fluid-input',
        'value' => '',
        'size' => '30',
        'placeholder' => 'Password',
    );
    echo form_input($password);
    ?>
   <!-- <div class="error"><?php echo form_error('password_email'); ?></div>-->
        <?php
            $formErr =  form_error('password_email');
            if(!empty($formErr))
            {  ?>
                <script>
                $(document).ready(function()
                {
                     alert('username or password invalid');
                 //   $.validator.messages.required = 'gfghfsdg';

                });

                </script>
                <?php
            }
        ?>
        <div>
            <a href="home/forgote_pass">Forgot Password</a>
            <div>
    <ul class="utopia-login-action">
    <li>
	<?php
    echo form_submit('submit', 'Login',"class='btn span4'");
    ?>
    </li>
    </ul>
</div>
</div>
</div>
</div>
</div>
</div>
<?php
$this->load->view('footer');
?>
<script type="text/javascript" src="<?php echo base_url(); ?>js/login.js"></script>