<?php
$controller = $this->router->fetch_class();
$action = $this->router->fetch_method();
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
            <a class="navbar-brand" href="<?php echo base_url(); ?>index.php/home" title="Social Media Aggregator"><img src="<?php echo base_url(); ?>images/logo-inner.png" width="203" alt="Social Media Aggregator"/></a>
        </div>
        <ul class="nav navbar-nav navbar-right hidden-xs">
            <?php
            if ($this->session->userdata('logged_in_super_user')) {
                $name = $this->session->userdata('logged_in_super_user');
                $username_profile = $name['fname'] . ' ' . $name['lname'];
            } elseif ($this->session->userdata('logged_in_agent')) {
                $name = $this->session->userdata('logged_in_agent');
                $username_profile = $name['fname'] . ' ' . $name['lname'];
            } elseif ($this->session->userdata('logged_in_employee')) {
                $name = $this->session->userdata('logged_in_employee');
                $username_profile = $name['fname'] . ' ' . $name['lname'];
            }
            ?>
            <li><a href="<?php echo base_url(); ?>home/edit_profile/<?php echo $id; ?>"><i class="fa fa-user"></i> <?php echo strtoupper($username_profile); ?></a></li>
            <li><a href="<?php echo base_url(); ?>home/change_password"><i class="fa fa-lock"></i> Change Password</a></li>
            <li><a href="<?php echo base_url(); ?>index.php/home/logout<?php echo ($sessionData['user_type'] != 'super') ? '_' . $sessionData['user_type'] : ''; ?>"><i class="fa fa-power-off"></i> Logout</a></li>
        </ul>

        <div ui-nav class="navbar-collapse navbar-ex1-collapse collapse">
            <?php if ($sessionData['user_type'] == "super") { ?>
                <ul class="nav navbar-nav side-nav">
                    <li class="<?php echo ($controller == "home" && $action == "index") ? " active " : ""; ?>"><a href="<?php echo base_url(); ?>index.php/home"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                    <li class="<?php echo (in_array($controller, array('inquiry')) && in_array($action, array('new_exist_client'))) ? " active " : ""; ?>"><a href="<?php echo base_url(); ?>inquiry/new_exist_client"><i class="fa fa-question-circle"></i> Inquiry Center</a></li>
                    <li class="<?php echo (in_array($controller, array('home', 'inquiry')) && in_array($action, array('agent_manage', 'property_manage', 'customer_manage', 'employee_manage', 'inquiry_manage'))) ? " active " : ""; ?> mnu-<?php echo $controller ?>-<?php echo $action; ?>"><a href="#"   data-target="#submenu1" aria-expanded="<?php echo (in_array($controller, array('home', 'inquiry')) && in_array($action, array('agent_manage', 'property_manage', 'customer_manage', 'employee_manage', 'inquiry_manage'))) ? " true " : "false"; ?>"><i class="fa fa-cog"></i> Management <span class="pull-right text-muted"><i class="fa fa-fw fa-angle-down text"></i></span></a>
                        <ul class="nav collapse <?php echo (in_array($controller, array('home', 'inquiry')) && in_array($action, array('agent_manage', 'property_manage', 'customer_manage', 'employee_manage', 'inquiry_manage'))) ? " in " : ""; ?>" id="submenu1" role="menu">
                            <li class="<?php echo ($controller == 'home' && $action == 'agent_manage') ? " active " : ""; ?>"><a href="<?php echo base_url(); ?>home/agent_manage">Agent Management</a></li>
                            <li class="<?php echo ($controller == 'home' && $action == 'property_manage') ? " active " : ""; ?>"><a href="<?php echo base_url(); ?>home/property_manage">Property Management</a></li>
                            <li class="<?php echo ($controller == 'home' && $action == 'customer_manage') ? " active " : ""; ?>"><a href="<?php echo base_url(); ?>home/customer_manage">Client Management</a></li>
                            <li class="<?php echo ($controller == 'home' && $action == 'employee_manage') ? " active " : ""; ?>"><a href="<?php echo base_url(); ?>home/employee_manage">Employee Management</a></li>
                            <li class="<?php echo ($controller == 'inquiry' && $action == 'inquiry_manage') ? " active " : ""; ?>"><a href="<?php echo base_url(); ?>inquiry/inquiry_manage">Inquiry Management</a></li>
                        </ul>
                    </li>
                    <li class="mnu-<?php echo $controller ?>-<?php echo $action; ?> <?php echo (in_array($controller, array('inquiry')) && in_array($action, array('new_inquiries', 'reschedule_inquiries', 'cancel_inquiries'))) ? " active " : ""; ?>"><a href="#"  data-target="#submenu2" aria-expanded="false"><i class="fa fa-calendar-check-o"></i> Appointment <span class="pull-right text-muted"><i class="fa fa-fw fa-angle-down text"></i></span></a>
                        <ul class="nav collapse <?php echo (in_array($controller, array('inquiry')) && in_array($action, array('new_inquiries', 'reschedule_inquiries', 'cancel_inquiries'))) ? " in " : ""; ?>" id="submenu2" role="menu">
                            <li class="<?php echo ($controller == 'inquiry' && $action == 'new_inquiries') ? " active " : ""; ?>"><a href='<?php echo base_url(); ?>inquiry/new_inquiries'>New Appointment</a></li>
                            <li class="<?php echo ($controller == 'inquiry' && $action == 'reschedule_inquiries') ? " active " : ""; ?>"><a href='<?php echo base_url(); ?>inquiry/reschedule_inquiries'>Appointment (Reschedule)</a></li>
                            <li class="<?php echo ($controller == 'inquiry' && $action == 'cancel_inquiries') ? " active " : ""; ?>"><a href='<?php echo base_url(); ?>inquiry/cancel_inquiries'>Appointment (Cancel)</a></li> 
                        </ul>
                    </li>
                    <li class="mnu-<?php echo $controller ?>-<?php echo $action; ?> <?php echo (in_array($controller, array('newsletter', 'home')) && in_array($action, array('sms_newsletter_list', 'email_newsletter_list', 'sms_email_history'))) ? " active " : ""; ?>"><a href="#"  data-target="#submenu3" aria-expanded="false"><i class="fa fa-envelope"></i> Newsletter <span class="pull-right text-muted"><i class="fa fa-fw fa-angle-down text"></i></span></a>
                        <ul class="nav collapse <?php echo (in_array($controller, array('newsletter', 'home')) && in_array($action, array('sms_newsletter_list', 'email_newsletter_list', 'sms_email_history'))) ? " in " : ""; ?>" id="submenu3" role="menu">
                            <li class="<?php echo ($controller == 'newsletter' && $action == 'sms_newsletter_list') ? " active " : ""; ?>"><a href='<?php echo base_url(); ?>newsletter/sms_newsletter_list'>SMS Newsletter</a></li>
                            <li class="<?php echo ($controller == 'newsletter' && $action == 'email_newsletter_list') ? " active " : ""; ?>"><a href='<?php echo base_url(); ?>newsletter/email_newsletter_list'>Email Newsletter</a></li>
                            <li class="<?php echo ($controller == 'home' && $action == 'sms_email_history') ? " active " : ""; ?>"><a href='<?php echo base_url(); ?>home/sms_email_history'>Individual SMS / Email History</a></li>
                        </ul>
                    </li>
                    <li class="<?php echo (in_array($controller, array('inquiry')) && in_array($action, array('calendar'))) ? " active " : ""; ?>"><a href='<?php echo base_url(); ?>inquiry/calendar'><i class="fa fa-calendar"></i> Calendar</a></li>
                    <li class="<?php echo (in_array($controller, array('reports')) && in_array($action, array('index','property','client'))) ? " active " : ""; ?>"><a href="#"><i class="glyphicon glyphicon-list-alt"></i> Reports <span class="pull-right text-muted"><i class="fa fa-fw fa-angle-down text"></i></span></a>
                        <ul class="nav collapse <?php echo (in_array($controller, array('reports')) && in_array($action, array('index', 'property', 'client'))) ? " in " : ""; ?>" id="submenu4" role="menu">
                            <li class="<?php echo ($controller == 'reports' && $action == 'index') ? " active " : ""; ?>"><a href='<?php echo base_url(); ?>reports/index'>Reports</a></li>
                            <li class="<?php echo ($controller == 'reports' && $action == 'property') ? " active " : ""; ?>"><a href='<?php echo base_url(); ?>reports/property'>Property Report</a></li>
                            <li class="<?php echo ($controller == 'reports' && $action == 'client') ? " active " : ""; ?>"><a href='<?php echo base_url(); ?>reports/client'>Client Report</a></li>
                        </ul>
                    </li>
                    <li class="visible-xs <?php echo (in_array($controller, array('home')) && in_array($action, array('edit_profile'))) ? " active " : ""; ?>"> <a href="<?php echo base_url(); ?>home/edit_profile/<?php echo $id; ?>"><i class="fa fa-user"></i> Profile</a> </li>
                    <li class="visible-xs <?php echo (in_array($controller, array('home')) && in_array($action, array('change_password'))) ? " active " : ""; ?>"> <a href="<?php echo base_url(); ?>home/change_password"><i class="fa fa-lock"></i> Change Password</a> </li>
                    <li class="visible-xs <?php echo (in_array($controller, array('reports')) && in_array($action, array('logout'))) ? " active " : ""; ?>"> <a href="<?php echo base_url(); ?>index.php/home/logout"><i class="fa fa-power-off"></i> Logout</a> </li>
                    <?php /* <li><a href="user-list.html"><i class="fa fa-user"></i> User Management</a></li> */ ?>
                    <?php /* <li class="visible-xs"> <a href="admin-profile.html"><i class="fa fa-user"></i> View Profile</a> </li> */ ?>
                    <?php /* <li class="visible-xs"> <a href="index.html"><i class="fa fa-power-off"></i> Logout</a> </li> */ ?>
                </ul>
            <?php } else if ($sessionData['user_type'] == "agent") { ?>
                <ul class="nav navbar-nav side-nav">
                    <li class="<?php echo ($controller == "home" && $action == "index") ? " active " : ""; ?>"><a href="<?php echo base_url(); ?>index.php/home"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                    <li><a href="<?php echo base_url(); ?>inquiry/new_exist_client"><i class="fa fa-question-circle"></i> Inquiry Center</a></li>
                    <li class="<?php echo (in_array($controller, array('home', 'inquiry')) && in_array($action, array('property_manage', 'inquiry_manage', 'registed_properties'))) ? " active " : ""; ?> mnu-<?php echo $controller ?>-<?php echo $action; ?>"><a href="#"   data-target="#submenu1" aria-expanded="false"><i class="fa fa-cog"></i> Management <span class="pull-right text-muted"><i class="fa fa-fw fa-angle-down text"></i></span></a>
                        <ul class="nav collapse <?php echo (in_array($controller, array('home', 'inquiry')) && in_array($action, array('property_manage', 'inquiry_manage', 'registed_properties'))) ? " in " : ""; ?>" id="submenu1" role="menu">
                            <li class="<?php echo ($controller == 'home' && $action == 'property_manage') ? " active " : ""; ?>"><a href="<?php echo base_url(); ?>home/property_manage">Property Management</a></li>
                            <li class="<?php echo ($controller == 'inquiry' && $action == 'inquiry_manage') ? " active " : ""; ?>"><a href="<?php echo base_url(); ?>inquiry/inquiry_manage">Inquiry Management</a></li>
                            <li class="<?php echo ($controller == 'home' && $action == 'registed_properties') ? " active " : ""; ?>"><a href='<?php echo base_url(); ?>home/registed_properties'>Registed Properties</a></li>
                        </ul>
                    </li>
                    <li class="mnu-<?php echo $controller ?>-<?php echo $action; ?> <?php echo (in_array($controller, array('inquiry')) && in_array($action, array('new_inquiries', 'reschedule_inquiries', 'cancel_inquiries'))) ? " active " : ""; ?>"><a href="#"  data-target="#submenu2" aria-expanded="false"><i class="fa fa-calendar-check-o"></i> Appointment <span class="pull-right text-muted"><i class="fa fa-fw fa-angle-down text"></i></span></a>
                    <!-- <li><a href="#"  data-target="#submenu2" aria-expanded="false"><i class="fa fa-calendar-check-o"></i> Appointment <span class="pull-right text-muted"><i class="fa fa-fw fa-angle-down text"></i></span></a> -->
                        <ul class="nav collapse <?php echo (in_array($controller, array('inquiry')) && in_array($action, array('new_inquiries', 'reschedule_inquiries', 'cancel_inquiries'))) ? " in " : ""; ?>" id="submenu2" role="menu">
                            <li class="<?php echo ($controller == 'inquiry' && $action == 'new_inquiries') ? " active " : ""; ?>"><a href='<?php echo base_url(); ?>inquiry/new_inquiries'>New Appointment</a></li>
                            <li class="<?php echo ($controller == 'inquiry' && $action == 'reschedule_inquiries') ? " active " : ""; ?>"><a href='<?php echo base_url(); ?>inquiry/reschedule_inquiries'>Appointment (Reschedule)</a></li>
                            <li class="<?php echo ($controller == 'inquiry' && $action == 'cancel_inquiries') ? " active " : ""; ?>"><a href='<?php echo base_url(); ?>inquiry/cancel_inquiries'>Appointment (Cancel)</a></li> 
                        </ul>
                    </li>
                    <li class="<?php echo (in_array($controller, array('inquiry')) && in_array($action, array('calendar'))) ? " active " : ""; ?>"><a href='<?php echo base_url(); ?>inquiry/calendar'><i class="fa fa-calendar"></i> Calendar</a></li>
                    <li class="<?php echo (in_array($controller, array('reports')) && in_array($action, array('index','property','client'))) ? " active " : ""; ?>"><a href="#"><i class="glyphicon glyphicon-list-alt"></i> Reports <span class="pull-right text-muted"><i class="fa fa-fw fa-angle-down text"></i></span></a>
                        <ul class="nav collapse <?php echo (in_array($controller, array('reports')) && in_array($action, array('index', 'property', 'client'))) ? " in " : ""; ?>" id="submenu4" role="menu">
                            <li class="<?php echo ($controller == 'reports' && $action == 'index') ? " active " : ""; ?>"><a href='<?php echo base_url(); ?>reports/index'>Reports</a></li>
                            <li class="<?php echo ($controller == 'reports' && $action == 'property') ? " active " : ""; ?>"><a href='<?php echo base_url(); ?>reports/property'>Property Report</a></li>
                            <li class="<?php echo ($controller == 'reports' && $action == 'client') ? " active " : ""; ?>"><a href='<?php echo base_url(); ?>reports/client'>Client Report</a></li>
                        </ul>
                    </li>

                    <li class="visible-xs <?php echo (in_array($controller, array('home')) && in_array($action, array('edit_profile'))) ? " active " : ""; ?>"> <a href="<?php echo base_url(); ?>home/edit_profile/<?php echo $id; ?>"><i class="fa fa-user"></i> Profile</a> </li>
                    <li class="visible-xs <?php echo (in_array($controller, array('home')) && in_array($action, array('change_password'))) ? " active " : ""; ?>"> <a href="<?php echo base_url(); ?>home/change_password"><i class="fa fa-lock"></i> Change Password</a> </li>
                    <li class="visible-xs <?php echo (in_array($controller, array('reports')) && in_array($action, array('logout'))) ? " active " : ""; ?>"> <a href="<?php echo base_url(); ?>index.php/home/logout"><i class="fa fa-power-off"></i> Logout</a> </li>

                    <?php /* <li><a href="user-list.html"><i class="fa fa-user"></i> User Management</a></li> */ ?>
                    <?php /* <li class="visible-xs"> <a href="admin-profile.html"><i class="fa fa-user"></i> View Profile</a> </li> */ ?>
                    <?php /* <li class="visible-xs"> <a href="index.html"><i class="fa fa-power-off"></i> Logout</a> </li> */ ?>
                </ul>  
            <?php } else if ($sessionData['user_type'] == "employee") { ?>
                <ul class="nav navbar-nav side-nav">
                    <li class="<?php echo ($controller == "home" && $action == "index") ? " active " : ""; ?>"><a href="<?php echo base_url(); ?>index.php/home"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                    <li><a href="<?php echo base_url(); ?>inquiry/new_exist_client"><i class="fa fa-question-circle"></i> Inquiry Center</a></li>
                    <li class="<?php echo (in_array($controller, array('home', 'inquiry')) && in_array($action, array('property_manage', 'inquiry_manage'))) ? " active " : ""; ?> mnu-<?php echo $controller ?>-<?php echo $action; ?>"><a href="#"   data-target="#submenu1" aria-expanded="false"><i class="fa fa-cog"></i> Management <span class="pull-right text-muted"><i class="fa fa-fw fa-angle-down text"></i></span></a>
                        <ul class="nav collapse <?php echo (in_array($controller, array('home', 'inquiry')) && in_array($action, array('property_manage', 'inquiry_manage'))) ? " in " : ""; ?>" id="submenu1" role="menu">
                            <li class="<?php echo ($controller == 'home' && $action == 'property_manage') ? " active " : ""; ?>"><a href="<?php echo base_url(); ?>home/property_manage">Property Management</a></li>
                            <li class="<?php echo ($controller == 'inquiry' && $action == 'inquiry_manage') ? " active " : ""; ?>"><a href="<?php echo base_url(); ?>inquiry/inquiry_manage">Inquiry Management</a></li>
                        </ul>
                    </li>
                    <li class="mnu-<?php echo $controller ?>-<?php echo $action; ?> <?php echo (in_array($controller, array('inquiry')) && in_array($action, array('reschedule_inquiries', 'cancel_inquiries'))) ? " active " : ""; ?>"><a href="#"  data-target="#submenu2" aria-expanded="false"><i class="fa fa-calendar-check-o"></i> Appointment <span class="pull-right text-muted"><i class="fa fa-fw fa-angle-down text"></i></span></a>
                        <ul class="nav collapse <?php echo (in_array($controller, array('inquiry')) && in_array($action, array('reschedule_inquiries', 'cancel_inquiries'))) ? " in " : ""; ?>" id="submenu2" role="menu">
                            <li class="<?php echo ($controller == 'inquiry' && $action == 'reschedule_inquiries') ? " active " : ""; ?>"><a href='<?php echo base_url(); ?>inquiry/reschedule_inquiries'>Appointment (Reschedule)</a></li>
                            <li class="<?php echo ($controller == 'inquiry' && $action == 'cancel_inquiries') ? " active " : ""; ?>"><a href='<?php echo base_url(); ?>inquiry/cancel_inquiries'>Appointment (Cancel)</a></li> 
                        </ul>
                    </li>
                    <li class="<?php echo (in_array($controller, array('inquiry')) && in_array($action, array('calendar'))) ? " active " : ""; ?>"><a href='<?php echo base_url(); ?>inquiry/calendar'><i class="fa fa-calendar"></i> Calendar</a></li>
                    <li class="<?php echo (in_array($controller, array('reports')) && in_array($action, array('index','property','client'))) ? " active " : ""; ?>"><a href="#"><i class="glyphicon glyphicon-list-alt"></i> Reports <span class="pull-right text-muted"><i class="fa fa-fw fa-angle-down text"></i></span></a>
                        <ul class="nav collapse <?php echo (in_array($controller, array('reports')) && in_array($action, array('index', 'property', 'client'))) ? " in " : ""; ?>" id="submenu4" role="menu">
                            <li class="<?php echo ($controller == 'reports' && $action == 'index') ? " active " : ""; ?>"><a href='<?php echo base_url(); ?>reports/index'>Reports</a></li>
                            <li class="<?php echo ($controller == 'reports' && $action == 'property') ? " active " : ""; ?>"><a href='<?php echo base_url(); ?>reports/property'>Property Report</a></li>
                            <li class="<?php echo ($controller == 'reports' && $action == 'client') ? " active " : ""; ?>"><a href='<?php echo base_url(); ?>reports/client'>Client Report</a></li>
                        </ul>
                    </li>

                    <li class="visible-xs <?php echo (in_array($controller, array('home')) && in_array($action, array('edit_profile'))) ? " active " : ""; ?>"> <a href="<?php echo base_url(); ?>home/edit_profile/<?php echo $id; ?>"><i class="fa fa-user"></i> Profile</a> </li>
                    <li class="visible-xs <?php echo (in_array($controller, array('home')) && in_array($action, array('change_password'))) ? " active " : ""; ?>"> <a href="<?php echo base_url(); ?>home/change_password"><i class="fa fa-lock"></i> Change Password</a> </li>
                    <li class="visible-xs <?php echo (in_array($controller, array('reports')) && in_array($action, array('logout'))) ? " active " : ""; ?>"> <a href="<?php echo base_url(); ?>index.php/home/logout"><i class="fa fa-power-off"></i> Logout</a> </li>

                    <?php /* <li><a href="user-list.html"><i class="fa fa-user"></i> User Management</a></li> */ ?>
                    <?php /* <li class="visible-xs"> <a href="admin-profile.html"><i class="fa fa-user"></i> View Profile</a> </li> */ ?>
                    <?php /* <li class="visible-xs"> <a href="index.html"><i class="fa fa-power-off"></i> Logout</a> </li> */ ?>
                </ul>  
            <?php } ?>
        </div>
    </div>
</nav>