<div class="header-top">
    <div class="header-wrapper">
       <?php if ($this->session->userdata('logged_in_super_user') || $this->session->userdata('logged_in_agent') || $this->session->userdata('logged_in_employee')) {?>
           <a href="<?php echo base_url(); ?>" class="utopia-logo"><img src="<?php echo base_url(); ?>img/cmr.png" alt="Monopolion" height="75px;"></a>
			 <?php } else if($this->session->userdata('logged_in_store_user')) {?>
    			 <a href="<?php echo base_url(); ?>index.php/home" class="utopia-logo"><img src="<?php echo base_url(); ?>img/cmr.png" alt="Utopia"></a>
			 <?php }?>
                <div class="header-right">
                        <div class="header-divider">&nbsp;
                        </div>
                        <div class="user-panel header-divider">
						<?php //print_r($this->session->userdata); ?>

						<?php if($this->session->userdata('logged_in_super_user')){ 
                            $sessionData = $this->session->userdata('logged_in_super_user');
                            $fname = $sessionData['fname'];
                            $lname = $sessionData['lname'];
                            $id = $sessionData['id'];
                            ?>
                            <div class="user-info"><img src="<?php echo base_url(); ?>img/icons/user.png" alt=""><a><?php echo $fname.' '.$lname; ?></a></div>
							<div class="user-dropbox" style="width:160px;">
							<ul>
								<li><img src="<?php echo base_url(); ?>img/icons/user.png"><?php echo anchor('home/edit_profile/'.$id, 'Edit Profile', "title='Edit Profile' style='margin-left: 10px'"); ?></li>
                                <li><img src="<?php echo base_url(); ?>img/icons/password.png"><?php echo anchor('home/change_password', 'Change Password', "title='Change Password' style='margin-left: 10px'"); ?></li>
                                <li class="logout"><?php echo anchor('home/logout', 'Logout', "title='Logout'"); ?></li>
                                
                            </ul>
                            </div>
                        </div>
                        <?php }else if($this->session->userdata('logged_in_agent')){ 
                            $sessionData = $this->session->userdata('logged_in_agent');
                            $fname = $sessionData['fname'];
                            $lname = $sessionData['lname'];
                            $id = $sessionData['id'];
                            ?>
                        	<div class="user-info"><img src="<?php echo base_url(); ?>img/icons/user.png" alt=""><a><?php echo $fname.' '.$lname; ?></a></div>
							<div class="user-dropbox" style="width:160px;">
							<ul>
								<li><img src="<?php echo base_url(); ?>img/icons/user.png"><?php echo anchor('home/edit_profile/'.$id, 'Edit Profile', "title='Edit Profile' style='margin-left: 10px'"); ?></li> 
                                <li><img src="<?php echo base_url(); ?>img/icons/password.png"><?php echo anchor('home/change_password', 'Change Password', "title='Change Password' style='margin-left: 10px'"); ?></li>
                                <li class="logout"><?php echo anchor('home/logout_agent', 'Logout', "title='Logout'"); ?></li>
                                
		                   </ul>
                            </div>
                        <?php }else if($this->session->userdata('logged_in_employee')){ 
                            $sessionData = $this->session->userdata('logged_in_employee');
                            $fname = $sessionData['fname'];
                            $lname = $sessionData['lname'];
                            $id = $sessionData['id'];
                            ?>
                        <div class="user-info"><img src="<?php echo base_url(); ?>img/icons/user.png" alt=""><a><?php echo $fname.' '.$lname; ?></a></div>
                            <div class="user-dropbox" style="width:160px;">
                            <ul>
                                <li><img src="<?php echo base_url(); ?>img/icons/user.png"><?php echo anchor('home/edit_profile/'.$id, 'Edit Profile', "title='Edit Profile' style='margin-left: 10px'"); ?></li>
                                <li><img src="<?php echo base_url(); ?>img/icons/password.png"><?php echo anchor('home/change_password', 'Change Password', "title='Change Password' style='margin-left: 10px'"); ?></li>
                                <li class="logout"><?php echo anchor('home/logout_employee', 'Logout', "title='Logout'"); ?></li>
                                
                            </ul>
                            </div>
                            <?php } ?>
                    </div>
                </div>
            </div>