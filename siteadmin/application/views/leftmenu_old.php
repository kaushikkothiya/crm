<?php
if ($this->session->userdata('logged_in_super_user')) {
    $sessionData = $this->session->userdata('logged_in_super_user');
    $sessionData['user_type'] = 'super';
} else if ($this->session->userdata('logged_in_agent')) {
    $sessionData = $this->session->userdata('logged_in_agent');
    $sessionData['user_type'] = 'agent';
} else if ($this->session->userdata('logged_in_employee')) {
    $sessionData = $this->session->userdata('logged_in_employee');
    $sessionData['user_type'] = 'employee';
}
$fname = $sessionData['fname'];
$lname = $sessionData['lname'];
$id = $sessionData['id'];
?>
<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-ex1-collapse" aria-expanded="false" aria-controls="navbar"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
            <a class="navbar-brand" href="<?php echo base_url(); ?>index.php/home" title="Social Media Aggregator"><img src="<?php echo base_url(); ?>images/logo-inner.png" width="203" alt="Social Media Aggregator"/></a> </div>
        <ul class="nav navbar-nav navbar-right hidden-xs">
            <li><a href="<?php echo base_url(); ?>home/edit_profile/<?php echo $id; ?>"><i class="fa fa-user"></i> Profile</a></li>
            <li><a href="<?php echo base_url(); ?>home/change_password"><i class="fa fa-lock"></i> Change Password</a></li>
            <li><a href="<?php echo base_url(); ?>index.php/home/logout"><i class="fa fa-power-off"></i> Logout</a></li>
        </ul>

        <div class="navbar-collapse navbar-ex1-collapse collapse">
<?php if ($sessionData['user_type'] == "super") { ?>
                <ul class="nav navbar-nav side-nav">
                    <li class="active"><a href="<?php echo base_url(); ?>index.php/home"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                    <li><a href="#"  data-toggle="collapse" data-target="#submenu1" aria-expanded="false"><i class="fa fa-cog"></i> Management <span class="pull-right text-muted"><i class="fa fa-fw fa-angle-down text"></i></span></a>
                        <ul class="nav collapse" id="submenu1" role="menu">
                            <li><a href="<?php echo base_url(); ?>home/agent_manage">Agent Management</a></li>
                            <li><a href="<?php echo base_url(); ?>home/property_manage">Property Management</a></li>
                            <li><a href="<?php echo base_url(); ?>home/customer_manage">Client Management</a></li>
                            <li><a href="<?php echo base_url(); ?>home/employee_manage">Employee Management</a></li>
                            <li><a href="<?php echo base_url(); ?>inquiry/inquiry_manage">Inquiry Management</a></li>
                        </ul>
                    </li>
                    <li><a href="#" data-toggle="collapse" data-target="#submenu2" aria-expanded="false"><i class="fa fa-calendar-check-o"></i> Appointment <span class="pull-right text-muted"><i class="fa fa-fw fa-angle-down text"></i></span></a>
                        <ul class="nav collapse" id="submenu2" role="menu">
                            <li><a href='<?php echo base_url(); ?>inquiry/new_inquiries'>New Appointment</a></li>
                            <li><a href='<?php echo base_url(); ?>inquiry/reschedule_inquiries'>Appointment (Reschedule)</a></li>
                            <li><a href='<?php echo base_url(); ?>inquiry/cancel_inquiries'>Appointment (Cancel)</a></li> 
                        </ul>
                    </li>
                    <li><a href="#" data-toggle="collapse" data-target="#submenu3" aria-expanded="false"><i class="fa fa-envelope"></i> Email / SMS <span class="pull-right text-muted"><i class="fa fa-fw fa-angle-down text"></i></span></a>
                        <ul class="nav collapse" id="submenu3" role="menu">
                            <li><a href='<?php echo base_url(); ?>newsletter/sms_newsletter_list'>SMS Newsletter</a></li>
                            <li><a href='<?php echo base_url(); ?>newsletter/email_newsletter_list'>Email Newsletter</a></li>
                            <li><a href='<?php echo base_url(); ?>home/sms_email_history'>Individual SMS / Email History</a></li>
                        </ul>
                    </li>
                    <li><a href="<?php echo base_url(); ?>inquiry/new_exist_client"><i class="fa fa-question-circle"></i> Inquiry Center</a></li>
                    <li><a href='<?php echo base_url(); ?>inquiry/calendar'><i class="fa fa-calendar"></i> Calendar</a></li>
                    <li><a href='<?php echo base_url(); ?>reports/index'><i class="glyphicon glyphicon-list-alt"></i> Reports</a></li>
                    <li class="visible-xs"> <a href="<?php echo base_url(); ?>home/edit_profile/<?php echo $id; ?>"><i class="fa fa-user"></i> Profile</a> </li>
                    <li class="visible-xs"> <a href="<?php echo base_url(); ?>home/change_password"><i class="fa fa-lock"></i> Change Password</a> </li>
                    <li class="visible-xs"> <a href="<?php echo base_url(); ?>index.php/home/logout"><i class="fa fa-power-off"></i> Logout</a> </li>
                    <?php /* <li><a href="user-list.html"><i class="fa fa-user"></i> User Management</a></li> */ ?>
                    <?php /* <li class="visible-xs"> <a href="admin-profile.html"><i class="fa fa-user"></i> View Profile</a> </li> */ ?>
                <?php /* <li class="visible-xs"> <a href="index.html"><i class="fa fa-power-off"></i> Logout</a> </li> */ ?>
                </ul>
<?php } else if ($sessionData['user_type'] == "agent") { ?>
                <ul class="nav navbar-nav side-nav">
                    <li class="active"><a href="dashboard.html"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                    <li><a href="#"  data-toggle="collapse" data-target="#submenu1" aria-expanded="false"><i class="fa fa-cog"></i> Management <span class="pull-right text-muted"><i class="fa fa-fw fa-angle-down text"></i></span></a>
                        <ul class="nav collapse" id="submenu1" role="menu">
                            <li><a href="<?php echo base_url(); ?>home/property_manage">Property Management</a></li>
                            <li><a href="<?php echo base_url(); ?>inquiry/inquiry_manage">Inquiry Management</a></li>
                            <li><a href='<?php echo base_url(); ?>home/registed_properties'>Registed Properties</a></li>
                        </ul>
                    </li>
                    <li><a href="#" data-toggle="collapse" data-target="#submenu2" aria-expanded="false"><i class="fa fa-calendar-check-o"></i> Appointment <span class="pull-right text-muted"><i class="fa fa-fw fa-angle-down text"></i></span></a>
                        <ul class="nav collapse" id="submenu2" role="menu">
                            <li><a href='<?php echo base_url(); ?>inquiry/new_inquiries'>New Appointment</a></li>
                            <li><a href='<?php echo base_url(); ?>inquiry/reschedule_inquiries'>Appointment (Reschedule)></a></li>
                            <li><a href='<?php echo base_url(); ?>inquiry/cancel_inquiries'>Appointment (Cancel)</a></li> 
                        </ul>
                    </li>
                    <li><a href="<?php echo base_url(); ?>inquiry/new_exist_client"><i class="fa fa-question-circle"></i> Inquiry Center</a></li>
                    <li><a href='<?php echo base_url(); ?>inquiry/calendar'><i class="fa fa-calendar"></i> Calendar</a></li>
                    <li><a href='<?php echo base_url(); ?>reports/index'><i class="glyphicon glyphicon-list-alt"></i> Reports</a></li>
                    <li class="visible-xs"> <a href="<?php echo base_url(); ?>home/edit_profile/<?php echo $id; ?>"><i class="fa fa-user"></i> Profile</a> </li>
                    <li class="visible-xs"> <a href="<?php echo base_url(); ?>home/change_password"><i class="fa fa-lock"></i> Change Password</a> </li>
                    <li class="visible-xs"> <a href="<?php echo base_url(); ?>index.php/home/logout"><i class="fa fa-power-off"></i> Logout</a> </li>
                    
                    <?php /* <li><a href="user-list.html"><i class="fa fa-user"></i> User Management</a></li> */ ?>
                    <?php /* <li class="visible-xs"> <a href="admin-profile.html"><i class="fa fa-user"></i> View Profile</a> </li> */ ?>
                <?php /* <li class="visible-xs"> <a href="index.html"><i class="fa fa-power-off"></i> Logout</a> </li> */ ?>
                </ul>  
            <?php } else if ($sessionData['user_type'] == "employee") { ?>
<ul class="nav navbar-nav side-nav">
                    <li class="active"><a href="dashboard.html"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                    <li><a href="#"  data-toggle="collapse" data-target="#submenu1" aria-expanded="false"><i class="fa fa-cog"></i> Management <span class="pull-right text-muted"><i class="fa fa-fw fa-angle-down text"></i></span></a>
                        <ul class="nav collapse" id="submenu1" role="menu">
                            <li><a href="<?php echo base_url(); ?>home/property_manage">Property Management</a></li>
                            <li><a href="<?php echo base_url(); ?>inquiry/inquiry_manage">Inquiry Management</a></li>
                        </ul>
                    </li>
                    <li><a href="#" data-toggle="collapse" data-target="#submenu2" aria-expanded="false"><i class="fa fa-calendar-check-o"></i> Appointment <span class="pull-right text-muted"><i class="fa fa-fw fa-angle-down text"></i></span></a>
                        <ul class="nav collapse" id="submenu2" role="menu">
                            <li><a href='<?php echo base_url(); ?>inquiry/reschedule_inquiries'>Appointment (Reschedule)></a></li>
                            <li><a href='<?php echo base_url(); ?>inquiry/cancel_inquiries'>Appointment (Cancel)</a></li> 
                        </ul>
                    </li>
                    <li><a href="<?php echo base_url(); ?>inquiry/new_exist_client"><i class="fa fa-question-circle"></i> Inquiry Center</a></li>
                    <li><a href='<?php echo base_url(); ?>inquiry/calendar'><i class="fa fa-calendar"></i> Calendar</a></li>
                    <li><a href='<?php echo base_url(); ?>reports/index'><i class="glyphicon glyphicon-list-alt"></i> Reports</a></li>
                    <li class="visible-xs"> <a href="<?php echo base_url(); ?>home/edit_profile/<?php echo $id; ?>"><i class="fa fa-user"></i> Profile</a> </li>
                    <li class="visible-xs"> <a href="<?php echo base_url(); ?>home/change_password"><i class="fa fa-lock"></i> Change Password</a> </li>
                    <li class="visible-xs"> <a href="<?php echo base_url(); ?>index.php/home/logout"><i class="fa fa-power-off"></i> Logout</a> </li>
                    
                    <?php /* <li><a href="user-list.html"><i class="fa fa-user"></i> User Management</a></li> */ ?>
                    <?php /* <li class="visible-xs"> <a href="admin-profile.html"><i class="fa fa-user"></i> View Profile</a> </li> */ ?>
                <?php /* <li class="visible-xs"> <a href="index.html"><i class="fa fa-power-off"></i> Logout</a> </li> */ ?>
                </ul>  
<?php } ?>
        </div>
    </div>
</nav>