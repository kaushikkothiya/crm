<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Reminders extends MY_Controller {
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
      //$timestamp = strtotime("+1 days"); $sendSMSFlag = "";
                        $sendSMSFlag = "";
                        $sendEmailFlag = "";
                        $sendSMSFlag1 = "";
                        $sendEmailFlag1 = "";
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
                    $message .="REMINDER: Dear ".$appointmentsValue->agent_fname." ".$appointmentsValue->agent_lname.", ";
                    $message1 .="You have an appointment in 1 hour at the property with Reference No:".$appointmentsValue->property_ref_no.", ";
                    $message .="Inquiry from: ".$appointmentsValue->customer_fname." ".$appointmentsValue->customer_lname.", Mobile Number +".$mobile_code.$appointmentsValue->customer_mobile_no;
                    $message .=" Please be on time!";
                    $this->load->library('CMSMS');
                    $sms_res=CMSMS::sendMessage($agentmobile_code.$appointmentsValue->agent_mobile_no, $message);
                    if(empty($sms_res)){
                        $sendSMSFlag = "SMS";
                    }
                    $history_text_agent_sms       = $message;
                    $history_subject_agent_sms    = "1 hour before the appointment";
                    $history_type_agent_sms       = "SMS";
                    $history_reciever_agent_sms   = $agentmobile_code.$appointmentsValue->agent_mobile_no;
                    $history_reciever_id_agent_sms    = $appointmentsValue->agent_id;
                    $history_reciever_agent_usertype ="2";
                    //$this->inquiry_model->saveSmsEmailHistory($history_text_sms, $history_subject_sms, $history_type_sms, $history_reciever_sms, $history_reciever_id_sms,$history_reciever_agent_usertype);
               
                }else{
                   $agentmobile_code="+"; 
                }
                           
                if(!empty($country_code))
                {
                    $message1 ="";
                    $message1 .= "REMINDER: Dear ".$appointmentsValue->customer_fname." ".$appointmentsValue->customer_lname.", ";
                    $message1 .="You have an appointment in 1 hour at the property with Reference No:".$appointmentsValue->property_ref_no.", ";
                    $message1 .= "with our Agent: ".$appointmentsValue->agent_fname." ".$appointmentsValue->agent_lname.", ";
                    $message1 .= "Mobile Number +".$agentmobile_code.$appointmentsValue->agent_mobile_no."or 8000 7000 ";
                    $this->load->library('CMSMS');
                    $sms_res1=CMSMS::sendMessage($mobile_code.$appointmentsValue->customer_mobile_no, $message1);
                    if(empty($sms_res1)){
                        $sendSMSFlag1 = "SMS";
                    }
                    $history_text_sms       = $message1;
                    $history_subject_sms    = "1 hour before the appointment";
                    $history_type_sms       = "SMS";
                    $history_reciever_sms   = $mobile_code.$appointmentsValue->customer_mobile_no;
                    $history_reciever_id_sms    = $appointmentsValue->customer_id;
                    $history_reciever_usertype_sms ="1";
                    //$this->inquiry_model->saveSmsEmailHistory($history_text_sms, $history_subject_sms, $history_type_sms, $history_reciever_sms, $history_reciever_id_sms,$history_reciever_usertype);
               

                }
                
                if(!empty($appointmentsValue->agent_email))
                {   
                    if(empty($agentcountry_code)){
                        $agentmobile_code ="+";
                    }

                    $data['agent'] = array(
                          'customer_name'=>$appointmentsValue->customer_fname.' '.$appointmentsValue->customer_lname,
                          'property_ref_no'=>$appointmentsValue->property_ref_no,
                          'agent_name'=>$appointmentsValue->agent_fname." ".$appointmentsValue->agent_lname,
                          'agent_mobile'=>$agentmobile_code.$appointmentsValue->agent_mobile_no,
                          'customer_mobile'=>$mobile_code.$appointmentsValue->customer_mobile_no
                                         );
                    $this->load->library('email');
                    $this->email->from('info@monopolion.com', 'monopolion');
                    $this->email->to($appointmentsValue->agent_email);
                    $this->email->cc('another@another-example.com');
                    $this->email->bcc('them@their-example.com');
                    $this->email->subject('Appointment Reminder');
                    $email_layout_agent = $this->load->view('email/appointment_reminder', $data,TRUE);
                    $this->email->message($email_layout_agent);
                    if($this->email->send())
                    {
                        $sendEmailFlag = "E-mail";   
                    }
                    
                    // Save to sms_email history table
                    $history_text_agent       = $email_layout_agent;
                    $history_subject_agent    = "Appointment Reminder";
                    $history_type_agent       = "E-mail";
                    $history_reciever_agent   = $appointmentsValue->agent_email;
                    $history_reciever_id_agent    = $appointmentsValue->agent_id;
                    $history_reciever_usertype_agent ="2";
                }
                if(!empty($appointmentsValue->customer_email))
                {   if(empty($agentcountry_code)){
                        $agentmobile_code ="+";
                    }
                    $data['customer'] = array(
                          'customer_name'=>$appointmentsValue->customer_fname.' '.$appointmentsValue->customer_lname,
                          'property_ref_no'=>$appointmentsValue->property_ref_no,
                          'agent_name'=>$appointmentsValue->agent_fname." ".$appointmentsValue->agent_lname,
                          'agent_mobile'=>$agentmobile_code.$appointmentsValue->agent_mobile_no,
                          'customer_mobile'=>$mobile_code.$appointmentsValue->customer_mobile_no
                            );
                    $this->load->library('email');
                    $this->email->from('info@monopolion.com', 'monopolion');
                    $this->email->to($appointmentsValue->customer_email);
                    $this->email->cc('another@another-example.com');
                    $this->email->bcc('them@their-example.com');
                    $this->email->subject('Appointment Reminder');
                    $email_layout = $this->load->view('email/appointment_reminder', $data,TRUE);
                    $this->email->message($email_layout);
                    if($this->email->send())
                    {
                        $sendEmailFlag1 = "E-mail";   
                    }
                    
                    // Save to sms_email history table
                    $history_text       = $email_layout;
                    $history_subject    = "Appointment Reminder";
                    $history_type       = "E-mail";
                    $history_reciever   = $appointmentsValue->customer_email;
                    $history_reciever_id    = $appointmentsValue->customer_id;
                    $history_reciever_usertype ="1";
                }
                
                if($sendSMSFlag == "SMS" && $sendEmailFlag == "E-mail")
                {
                    $history_type_agent_sms   = "SMS/E-mail";
                    $history_type = "SMS/E-mail";

                    // SMS
                    $this->inquiry_model->saveSmsEmailHistory($history_text_agent_sms, $history_subject_agent_sms, $history_type_agent_sms, $history_reciever_agent_sms, $history_reciever_id_agent_sms,$history_reciever_agent_usertype);
                    
                    // Email
                    $this->inquiry_model->saveSmsEmailHistory($history_text_agent, $history_subject_agent, $history_type_agent, $history_reciever_agent, $history_reciever_id_agent,$history_reciever_usertype_agent);
                    
                }
                elseif ($sendSMSFlag == "SMS")
                {
                    // SMS
                    $this->inquiry_model->saveSmsEmailHistory($history_text_agent_sms, $history_subject_agent_sms, $history_type_agent_sms, $history_reciever_agent_sms, $history_reciever_id_agent_sms,$history_reciever_agent_usertype);
                    
                }
                elseif ($sendEmailFlag == "E-mail")
                {
                    // Email
                    $this->inquiry_model->saveSmsEmailHistory($history_text_agent, $history_subject_agent, $history_type_agent, $history_reciever_agent, $history_reciever_id_agent,$history_reciever_usertype_agent);
                    
                }

                if($sendSMSFlag1 == "SMS" && $sendEmailFlag1 == "E-mail")
                {
                    $history_reciever_usertype_sms   = "SMS/E-mail";
                    $history_reciever_usertype = "SMS/E-mail";

                    // SMS
                   $this->inquiry_model->saveSmsEmailHistory($history_text_sms, $history_subject_sms, $history_type_sms, $history_reciever_sms, $history_reciever_id_sms,$history_reciever_usertype_sms);
                    
                    // Email
                    $this->inquiry_model->saveSmsEmailHistory($history_text, $history_subject, $history_type, $history_reciever, $history_reciever_id,$history_reciever_usertype);
                    
                }
                elseif ($sendSMSFlag1 == "SMS")
                {
                    // SMS
                    $this->inquiry_model->saveSmsEmailHistory($history_text_sms, $history_subject_sms, $history_type_sms, $history_reciever_sms, $history_reciever_id_sms,$history_reciever_usertype_sms);
                    
                }
                elseif ($sendEmailFlag1 == "E-mail")
                {
                    // Email
                    $this->inquiry_model->saveSmsEmailHistory($history_text, $history_subject, $history_type, $history_reciever, $history_reciever_id,$history_reciever_usertype);
                }
          }
      }
}
}


?>