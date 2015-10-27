<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Reminders extends CI_Controller {
    function __construct() {

        parent::__construct();

        $this->load->model('Appointment_model', '', TRUE);
        $this->load->helper('html');
        $this->load->model('user', '', TRUE);
        $this->load->model('inquiry_model', '', TRUE);
        $this->load->library('image_lib');
        $this->load->helper('form');

        $config = Array(
            'mailtype' => 'html',
            'wordwrap' => TRUE
        );
        $this->load->library('email', $config);
    }

function index()
{
     // if(!$this->input->is_cli_request())
     // {
     //   echo "This script can only be accessed via the command line" . PHP_EOL;
     //   return;
     // }
      //$timestamp = strtotime("+1 days");
      $appointments = $this->Appointment_model->get_days_appointments();
      if(!empty($appointments))
      {
          foreach($appointments as $appointmentsKey => $appointmentsValue)
          {
                $country_code = $this->user->get_contry_code($appointmentsValue->customer_coutry_code);               
                if(!empty($country_code))
                {    
                    $mcode = substr($country_code[0]->prefix_code, 1);
                    $count_mcode = strlen($mcode);
                    if($count_mcode < 2 ){
                        $mobile_code = '000'.$mcode;
                    }elseif($count_mcode < 3 ){
                        $mobile_code = '00'.$mcode;
                    }
                    elseif($count_mcode < 4 ){
                        $mobile_code = '0'.$mcode;
                    }else{
                        $mobile_code = $mcode;
                    }
                }else{
                    $mobile_code = "+";
                }
                
                $agentcountry_code = $this->user->get_contry_code($appointmentsValue->agent_coutry_code);               
                if(!empty($agentcountry_code))
                {    
                    $agentmcode = substr($agentcountry_code[0]->prefix_code, 1);
                    $agentcount_mcode = strlen($agentmcode);
                    if($agentcount_mcode < 2 ){
                        $agentmobile_code = '000'.$agentmcode;
                    }elseif($agentcount_mcode < 3 ){
                        $agentmobile_code = '00'.$agentmcode;
                    }
                    elseif($agentcount_mcode < 4 ){
                        $agentmobile_code = '0'.$mcode;
                    }else{
                        $agentmobile_code = $agentmcode;
                    }
                    $message ="";
                    $message .="Dear ".$appointmentsValue->agent_fname." ".$appointmentsValue->agent_lname.", ";
                    $message .="We kindly remind you  that your  appointment for the property:".$appointmentsValue->property_ref_no." is in 1 hour. ";
                    $message .="Inquiry from: ".$appointmentsValue->customer_fname." ".$appointmentsValue->customer_lname.", +".$mobile_code.$appointmentsValue->customer_mobile_no;
                    $message .=" Please be on time!";
                    $this->load->library('CMSMS');
                    CMSMS::sendMessage($agentmobile_code.$appointmentsValue->agent_mobile_no, $message);
                    
                    $history_text_sms       = $message;
                    $history_subject_sms    = "1 hour before the appointment";
                    $history_type_sms       = "SMS";
                    $history_reciever_sms   = $agentmobile_code.$appointmentsValue->agent_mobile_no;
                    $history_reciever_id_sms    = $appointmentsValue->agent_id;

                    $this->inquiry_model->saveSmsEmailHistory($history_text_sms, $history_subject_sms, $history_type_sms, $history_reciever_sms, $history_reciever_id_sms);
               
                }
                           
                if(!empty($country_code))
                {
                    $message1 ="";
                    $message1 .= "Dear ".$appointmentsValue->customer_fname." ".$appointmentsValue->customer_lname.", ";
                    $message1 .="We kindly remind you  that your  appointment for the property:".$appointmentsValue->property_ref_no." is in 1 hour. ";
                    $message1 .= "Please be on time! For any further info for the specific property kindly contact our agent ".$appointmentsValue->agent_fname." ".$appointmentsValue->agent_lname.", ";
                    $message1 .= "+".$agentmobile_code.$appointmentsValue->agent_mobile_no."or 8000 7000 ";
                    $this->load->library('CMSMS');
                    CMSMS::sendMessage($mobile_code.$appointmentsValue->customer_mobile_no, $message1);
                    
                    $history_text_sms       = $message1;
                    $history_subject_sms    = "1 hour before the appointment";
                    $history_type_sms       = "SMS";
                    $history_reciever_sms   = $mobile_code.$appointmentsValue->customer_mobile_no;
                    $history_reciever_id_sms    = $appointmentsValue->customer_id;

                    $this->inquiry_model->saveSmsEmailHistory($history_text_sms, $history_subject_sms, $history_type_sms, $history_reciever_sms, $history_reciever_id_sms);
               

                }
          }
    }

    }
}


?>