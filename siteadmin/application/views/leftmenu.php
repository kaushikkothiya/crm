  <script src="<?php echo base_url(); ?>js/menu/script.js"></script>
<div id='cssmenu'>
<ul>
  <?php  if ($this->session->userdata('logged_in_super_user')) { ?>
   <li class='has-sub'><a href='#'><span>Management</span></a>
    <ul>
         <li><a href='<?php echo base_url(); ?>home/agent_manage'><span>Agent Management</span></a></li>
         <li><a href='<?php echo base_url(); ?>home/property_manage'><span>Property Management</span></a></li>
         <li><a href='<?php echo base_url(); ?>home/customer_manage'><span>Client Management</span></a></li>
         <li><a href='<?php echo base_url(); ?>home/employee_manage'><span>Employee Management</span></a></li>
         <li><a href='<?php echo base_url(); ?>inquiry/inquiry_manage'><span>Inquiry Management</span></a></li>
         <li class='has-sub'><a href='#'><span>Appointment</span></a>
          <ul>
           <li><a href='<?php echo base_url(); ?>inquiry/new_inquiries'><span>New Appointment</span></a></li>
           <li><a href='<?php echo base_url(); ?>inquiry/reschedule_inquiries'><span>Appointment (Reschedule)</span></a></li>
           <li><a href='<?php echo base_url(); ?>inquiry/cancel_inquiries'><span>Appointment (Cancel)</span></a></li> 
          </ul>
        </li>

      </ul>
   </li>

   <li><a href='<?php echo base_url(); ?>inquiry/new_exist_client'><span>Inquiry Center</span></a></li>

   <li class='has-sub'><a href='#'><span>Email / SMS</span></a>
    <ul>
          <li><a href='<?php echo base_url(); ?>newsletter/sms_newsletter_list'><span>SMS Newsletter</span></a></li>
        <li><a href='<?php echo base_url(); ?>newsletter/email_newsletter_list'><span>Email Newsletter</span></a></li>
         <li><a href='<?php echo base_url(); ?>home/sms_email_history'><span>Individual SMS / Email History</span></a></li>
      </ul>

   </li>
   <li><a href='<?php echo base_url(); ?>inquiry/calendar'><span>Calendar</span></a></li>
   
   <?php }else if($this->session->userdata('logged_in_agent')){?>
   <li class='has-sub'><a href='#'><span>Management</span></a>
      <ul>
        <li><a href='<?php echo base_url(); ?>inquiry/inquiry_manage'><span>Inquiry Management</span></a></li>
        <li><a href='<?php echo base_url(); ?>home/property_manage'><span>Property Management</span></a></li>
        <li><a href='<?php echo base_url(); ?>home/registed_properties'><span>Registed Properties</span></a></li>
        <li class='has-sub'><a href='#'><span>Appointment</span></a>
         <ul>
          <li><a href='<?php echo base_url(); ?>inquiry/new_inquiries'><span>New Appointment</span></a></li>
          <li><a href='<?php echo base_url(); ?>inquiry/reschedule_inquiries'><span>Appointment (Reschedule)</span></a></li>
          <li><a href='<?php echo base_url(); ?>inquiry/cancel_inquiries'><span>Appointment (Cancel)</span></a></li>
        </ul>
       </li>
      </ul>
  </li>

  <li><a href='<?php echo base_url(); ?>inquiry/new_exist_client'><span>Inquiry Center</span></a></li>
    
  <!-- <li class='has-sub'><a href='#'><span>Email / SMS</span></a>
    <ul>
         <li><a href='<?php echo base_url(); ?>home/sms_newsletter_list'><span>SMS Newsletter</span></a></li>
         <li><a href='<?php echo base_url(); ?>home/email_newsletter_list'><span>Email Newsletter</span></a></li>
         <li><a href='<?php echo base_url(); ?>home/sms_email_history'><span>Individual SMS / Email History</span></a></li>
      </ul>

   </li -->>

  <!-- <li class='has-sub'><a href='<?php echo base_url(); ?>home/property_manage'><span>Property Management</span></a>
    <ul>
         <li><a href='<?php echo base_url(); ?>home/registed_properties'><span>Registed Properties</span></a></li>
    </ul>

  </li> -->

  <li><a href='<?php echo base_url(); ?>inquiry/calendar'><span>Calendar</span></a></li>

<?php }elseif($this->session->userdata('logged_in_employee')){ ?>

  <li class='has-sub'><a href='#'><span>Management</span></a>
      <ul>
        <li><a href='<?php echo base_url(); ?>home/property_manage'><span>Property Management</span></a></li>
        <li><a href='<?php echo base_url(); ?>inquiry/inquiry_manage'><span>Inquiry Management</span></a></li>
        <li class='has-sub'><a href='#'><span>Appointment</span></a>
        <ul>
          <li><a href='<?php echo base_url(); ?>inquiry/reschedule_inquiries'><span>Appointment (Reschedule)</span></a></li>
          <li><a href='<?php echo base_url(); ?>inquiry/cancel_inquiries'><span>Appointment (Cancel)</span></a></li>
        </ul>
      </li>
      </ul>
  </li>
  <li><a href='<?php echo base_url(); ?>inquiry/new_exist_client'><span>Inquiry Center</span></a></li>

  <!-- <li class='has-sub'><a href='#'><span>Email / SMS</span></a>
    <ul>
         <li><a href='<?php echo base_url(); ?>home/sms_newsletter_list'><span>SMS Newsletter</span></a></li>
         <li><a href='<?php echo base_url(); ?>home/email_newsletter_list'><span>Email Newsletter</span></a></li>
         <li><a href='<?php echo base_url(); ?>home/sms_email_history'><span>Individual SMS / Email History</span></a></li>
      </ul>

   </li> -->
   <?php } ?>
</ul>
</div>


