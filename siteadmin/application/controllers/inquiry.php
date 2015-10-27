<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
session_start(); //we need to call PHP's session object to access it through CI

class Inquiry extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('html');
         $this->load->model('user', '', TRUE);
        $this->load->model('inquiry_model', '', TRUE);
        $this->load->helper('form');

        $config = Array(
            'mailtype' => 'html',
            'wordwrap' => TRUE
        );
        $this->load->library('email', $config);
    }
    function new_exist_client() {
        if ($this->session->userdata('logged_in_super_user') || $this->session->userdata('logged_in_agent') || $this->session->userdata('logged_in_employee')) {
           
         // echo'<pre>';print_r($data);exit;
            $this->load->view('new_exist_client_view');
        } else {
            //If no session, redirect to login page
            redirect('login', 'refresh');
        }
    }
    function inquiry_manage() {
        if ($this->session->userdata('logged_in_super_user') || $this->session->userdata('logged_in_agent') || $this->session->userdata('logged_in_employee')) {
        
        if(!empty($_POST['example_length'])){
            unset($_POST['example_length']);
            $mul_rec=array_chunk($_POST,2);
            $data = $this->inquiry_model->insert_inquiry_action($mul_rec);
            redirect('inquiry/inquiry_manage');
        }elseif(!empty($_POST['agent'])){
            
            $inquiry_num =$this->unic_inquiry_num();
            $property_id = $this->session->userdata('selected_property_id');
            $property_detail = $this->inquiry_model->get_property_detail($property_id);
            $property_link = array();
            $property_link_path = base_url()."home/view_property";
            array_push($property_link, $property_link_path.$property_detail[0]->id);
            
            $property_buy_sale = $this->session->userdata('customer_property_buy_sale');
            $data = $this->inquiry_model->insert_inquiry($_POST,$property_id,$inquiry_num,$property_buy_sale,$property_detail);
            
            
            $cust_id = $this->session->userdata('customer_property_id');
            $customer_detail = $this->inquiry_model->get_customer_detail($cust_id);
             
            $agent_detail = $this->inquiry_model->get_agent_email($_POST['agent']);
            $agent_property_link_path = base_url()."home/appointment_conform/".$data."/".$agent_detail[0]->id;
            
            $agent_mobile_cntry_code = $this->user->get_contry_code($agent_detail[0]->coutry_code);               
            $sendSMSFlag = "";
            $sendEmailFlag = "";
            $sendSMSFlag1 = "";
            $sendEmailFlag1 = "";
            if(!empty($agent_mobile_cntry_code))
            {
                $agentmcode = substr($agent_mobile_cntry_code[0]->prefix_code, 1);
                $agentcn_mobile_code="00".$agentmcode;
            //     $agentcount_mcode = strlen($agentmcode);
            //     if($agentcount_mcode < 2 ){
            //         $agentcn_mobile_code = '000'.$agentmcode;
            //     }elseif($agentcount_mcode < 3 ){
            //         $agentcn_mobile_code = '00'.$agentmcode;
            //     }
            //     elseif($agentcount_mcode < 4 ){
            //         $agentcn_mobile_code = '0'.$agentmcode;
            //     }else{
            //         $agentcn_mobile_code = $agentmcode;
            //     }
             }else{
                 $agentcn_mobile_code = "0000";
             }
                
            $clientcountry_code = $this->user->get_contry_code($customer_detail[0]->coutry_code);               
            if(!empty($clientcountry_code))
            {
                $clientmcode = substr($clientcountry_code[0]->prefix_code, 1);
                $clientmobile_code="00".$clientmcode;
             //   $clientcount_mcode = strlen($clientmcode);
            //     if($clientcount_mcode < 2 ){
            //         $clientmobile_code = '000'.$clientmcode;
            //     }elseif($clientcount_mcode < 3 ){
            //         $clientmobile_code = '00'.$clientmcode;
            //     }
            //     elseif($clientcount_mcode < 4 ){
            //         $clientmobile_code = '0'.$clientmcode;
            //     }else{
            //         $clientmobile_code = $clientmcode;
            //     }
             }else{
                 $clientmobile_code="0000";
             }
            $data = array(
                            'agent_email'=>$agent_detail[0]->email,
                            'agent_mobile'=>$agentcn_mobile_code.$agent_detail[0]->mobile_no,
                            'agent_name' =>$agent_detail[0]->fname.' '.$agent_detail[0]->lname,
                            'customer_email'=>$customer_detail[0]->email,
                            'customer_name'=>$customer_detail[0]->fname.' '.$customer_detail[0]->lname,
                            'customer_mobile'=>$clientmobile_code.$customer_detail[0]->mobile_no,
                            'property_ref_no'=>$property_detail[0]->reference_no,
                            'start_date'=>$_POST['start_date'],
                            'end_date'=>$_POST['end_date'],
                            'property_link'=>$property_link[0],
                            'agent_property_link_path'=>$agent_property_link_path
                            );
            if(!empty($agent_detail[0]->email))
            {
                $this->load->library('email');
                $this->email->from('info@monopolion.com', 'monopolion');
                $this->email->to($agent_detail[0]->email);
                $this->email->cc('info@monopolion.com');
                $this->email->bcc('info@monopolion.com');
                $this->email->subject('Agent Appointment');
                $email_layout = $this->load->view('email/property_agent_appointment_email', $data,TRUE);
                $this->email->message($email_layout);
                if($this->email->send())
                {
                     $sendEmailFlag1 = "E-mail";   
                }
                // save Agent history
                $history_text_agent   = $email_layout;
                $history_subject_agent   = "Agent Appointment";
                $history_type_agent      = "E-mail";
                $history_reciever_agent_email  = $agent_detail[0]->email;
                $history_reciever_id_agent   = $agent_detail[0]->id;
                //$this->inquiry_model->saveSmsEmailHistory($history_text, $history_subject, $history_type, $history_reciever, $history_reciever_id);
            }
            if(!empty($customer_detail[0]->email))
            {
                $this->load->library('email');
                $this->email->from('info@monopolion.com', 'monopolion');
                $this->email->to($customer_detail[0]->email);
                $this->email->cc('info@monopolion.com');
                $this->email->bcc('info@monopolion.com');
                $this->email->subject('Client Appointment');
                $email_layout = $this->load->view('email/property_client_appointment_email', $data,TRUE);
                $this->email->message($email_layout);
                if($this->email->send())
                {
                     $sendEmailFlag = "E-mail";   
                }
                // save Customer history
                $history_text       = $email_layout;
                $history_subject    = "Client Appointment";
                $history_type       = "E-mail";
                $history_reciever   = $customer_detail[0]->email;
                $history_reciever_id    = $customer_detail[0]->id;
                //$this->inquiry_model->saveSmsEmailHistory($history_text, $history_subject, $history_type, $history_reciever, $history_reciever_id);

                }
           
            /* sms send customer start */
            if(!empty($customer_detail[0]->mobile_no))
            {
                $country_code = $this->user->get_contry_code($customer_detail[0]->coutry_code);               
                if(!empty($country_code))
                {
                    $mcode = substr($country_code[0]->prefix_code, 1);
                    $mobile_code="00".$mcode;
                    // $count_mcode = strlen($mcode);
                    // if($count_mcode < 2 ){
                    //     $mobile_code = '000'.$mcode;
                    // }elseif($count_mcode < 3 ){
                    //     $mobile_code = '00'.$mcode;
                    // }
                    // elseif($count_mcode < 4 ){
                    //     $mobile_code = '0'.$mcode;
                    // }else{
                    //     $mobile_code = $mcode;
                    // }
                    $message = "Dear ".$customer_detail[0]->fname." ".$customer_detail[0]->lname.", your request for appointment on :".$_POST['start_date'].' - '.$_POST['end_date'];
                    $message .= " for the property: ".$property_detail[0]->reference_no;
                    $message .= " will be confirmed by our agent: ".$agent_detail[0]->fname." ".$agent_detail[0]->lname.", +".$agent_detail[0]->coutry_code.$agent_detail[0]->mobile_no;
                    $message .= " shortly";
                    
                    $this->load->library('CMSMS');
                    $sms_res=CMSMS::sendMessage($mobile_code.$customer_detail[0]->mobile_no, $message);
                    if(empty($sms_res)){
                            $sendSMSFlag = "SMS";
                    }
                     // save Customer history
                    $history_text_sms       = $message;
                    $history_subject_sms    = "Your Appointment Assign to Agent";
                    $history_type_sms       = "SMS";
                    $history_reciever_sms   = $mobile_code.$customer_detail[0]->mobile_no;
                    $history_reciever_id_sms    = $customer_detail[0]->id;
                    //$this->inquiry_model->saveSmsEmailHistory($history_text_sms, $history_subject_sms, $history_type_sms, $history_reciever_sms, $history_reciever_id_sms);
            
                }
            }
            /* sms send customer end */

             /* sms send agent start */
            if(!empty($agent_detail[0]->mobile_no))
            {
                $country_code_agent = $this->user->get_contry_code($agent_detail[0]->coutry_code);               
                if(!empty($country_code_agent))
                {           
                    $mcode_agent = substr($country_code_agent[0]->prefix_code, 1);
                    $mobile_code_agent="00".$mcode_agent;
                    // $count_mcode_agent = strlen($mcode);
                    // if($count_mcode_agent < 2 ){
                    //     $mobile_code_agent = '000'.$mcode_agent;
                    // }elseif($count_mcode < 3 ){
                    //     $mobile_code_agent = '00'.$mcode_agent;
                    // }
                    // elseif($count_mcode_agent < 4 ){
                    //     $mobile_code_agent = '0'.$mcode_agent;
                    // }else{
                    //     $mobile_code_agent = $mcode_agent;
                    // }
                    
                    $message_agent = "Dear ".$agent_detail[0]->fname." ".$agent_detail[0]->lname." you have an inquiry for an appointment on ".$_POST['start_date']." to ".$_POST['end_date'];
                    $message_agent .= " for the property: ".$property_detail[0]->reference_no;
                    $message_agent .= " Inquiry from: ".$customer_detail[0]->fname." ".$customer_detail[0]->lname.", +".$customer_detail[0]->coutry_code.$customer_detail[0]->mobile_no;
                    $message_agent .= " Please confirm on our system asap by clicking the following ";
                    $message_agent .= "link: ".$property_link[0];
                                 
                    $this->load->library('CMSMS');
                    $sms_res1=CMSMS::sendMessage($mobile_code_agent.$agent_detail[0]->mobile_no, $message_agent);
                    if(empty($sms_res1)){
                            $sendSMSFlag1 = "SMS";
                    }
                    $history_text_sms_agent       = $message_agent;
                    $history_subject_sms_agent    = "Your Appointment Need to Confirm";
                    $history_type_sms_agent       = "SMS";
                    $history_reciever_agent   = $mobile_code_agent.$agent_detail[0]->mobile_no;
                    $history_reciever_id_agent    = $agent_detail[0]->id;
                    //$this->inquiry_model->saveSmsEmailHistory($history_text_sms, $history_subject_sms, $history_type_sms, $history_reciever_agent, $history_reciever_id_agent);
            
                }
            }
            if($sendSMSFlag == "SMS" && $sendEmailFlag == "E-mail")
                {
                    $history_type_sms   = "SMS/E-mail";
                    $history_type       = "SMS/E-mail";

                    // SMS
                    $this->inquiry_model->saveSmsEmailHistory($history_text_sms, $history_subject_sms, $history_type_sms, $history_reciever_sms, $history_reciever_id_sms);
                    
                    // Email
                    $this->inquiry_model->saveSmsEmailHistory($history_text, $history_subject, $history_type, $history_reciever, $history_reciever_id);
                    
                }
                elseif ($sendSMSFlag == "SMS")
                {
                    
                    // SMS
                    $this->inquiry_model->saveSmsEmailHistory($history_text_sms, $history_subject_sms, $history_type_sms, $history_reciever_sms, $history_reciever_id_sms);
                    
                    
                }
                elseif ($sendEmailFlag == "E-mail")
                {
                    // Email
                    $this->inquiry_model->saveSmsEmailHistory($history_text, $history_subject, $history_type, $history_reciever, $history_reciever_id);
                    
                }
            if($sendSMSFlag1 == "SMS" && $sendEmailFlag1 == "E-mail")
                {
                    $history_type_sms_agent   = "SMS/E-mail";
                    $history_type_agent       = "SMS/E-mail";

                    // SMS
                    $this->inquiry_model->saveSmsEmailHistory($history_text_sms_agent, $history_subject_sms_agent, $history_type_sms_agent, $history_reciever_agent, $history_reciever_id_agent);
                    
                    // Email
                    $this->inquiry_model->saveSmsEmailHistory($history_text_agent, $history_subject_agent, $history_type_agent, $history_reciever_agent_email, $history_reciever_id_agent);
                    
                }
                elseif ($sendSMSFlag1 == "SMS")
                {
                    
                    // SMS
                    $this->inquiry_model->saveSmsEmailHistory($history_text_sms_agent, $history_subject_sms_agent, $history_type_sms_agent, $history_reciever_agent, $history_reciever_id_agent);
                    
                    
                }
                elseif ($sendEmailFlag1 == "E-mail")
                {
                    // Email
                    $this->inquiry_model->saveSmsEmailHistory($history_text_agent, $history_subject_agent, $history_type_agent, $history_reciever_agent_email, $history_reciever_id_agent);
                    
                }

            /* sms send agent end */
            $this->session->set_flashdata('success', 'Appointment added successfull.');
            $this->session->unset_userdata('customer_property_id');   
            redirect('inquiry/inquiry_manage');
        }
        //echo $_GET['view'];EXIT;
            if(empty($_GET['view'])){
                if(!empty($_GET['view_client'])){
                    $inc_view=$_GET['view_client'];
                    $client ='1';   
                }else{
                    $inc_view="";
                    $client ='';
                }

            }else{
                $inc_view=$_GET['view'];
                $client ='';
            }
            $data['user'] = $this->inquiry_model->getAllinquiry($inc_view,$client);
             
             foreach ($data['user'] as $z=>$val)
              { 
                 $data['user'][$z]->agent_name  = $this->inquiry_model->get_inc_agent($val->agent_id);
                 
               }
               // echo'<pre>';print_r($data['user'][0]->agent_name[0]->fname);exit;
               $data['all_client']=$this->user->getallclient();

            $this->load->view('inquiry_list_view', $data);
        } else {
            redirect('login', 'refresh');
        }
    }
    function unic_inquiry_num() {
        $inquiry_num = rand(10000000,99999999);

        $unic_number = $this->inquiry_model->check_unic_inquiry_num($inquiry_num);

                if(!empty($unic_number)){
                   $this->unic_inquiry_num();
                }else{
                   return $inquiry_num;
                   
                }
        
    }
    function new_client() {
        if ($this->session->userdata('logged_in_super_user') || $this->session->userdata('logged_in_agent') || $this->session->userdata('logged_in_employee')) {
        
        //$id = $sessionData['id'];
            $this->load->helper(array('form'));
            
                $this->load->view('add_new_client');
                        
        } else {
            //If no session, redirect to login page
            redirect('login', 'refresh');
        }
    }
    function exist_client() {
        if ($this->session->userdata('logged_in_super_user') || $this->session->userdata('logged_in_agent') || $this->session->userdata('logged_in_employee')) {
        
        
            $this->load->helper(array('form'));
            
                $this->load->view('add_exit_client');
                        
        } else {
            //If no session, redirect to login page
            redirect('login', 'refresh');
        }
    }
    function check_customer_exist() {

        $customer_datail = $this->inquiry_model->check_customer_exist($_POST);
        //echo "<pre>";print_r($customer_datail[0]->id);exit;

        if(!empty($customer_datail)){
        $this->session->set_userdata('customer_property_id', $customer_datail[0]->id);
        echo "true";exit;    
    }else{
        echo "false";exit;
    }
        
    }
    
    function property() {
       if ($this->session->userdata('logged_in_super_user') || $this->session->userdata('logged_in_agent') || $this->session->userdata('logged_in_employee')) {
            //$this->session->unset_userdata('selected_property_id');
       
            $data['inquiry_flag'] = "1";
        if($this->session->userdata('customer_property_id')){
                if(!empty($_POST['aquired'])){
                    $this->session->set_userdata('customer_property_buy_sale', $_POST['aquired']);
                } 
                $data['city'] = $this->inquiry_model->getAllcity();
                $data['city_area'] = $this->inquiry_model->getAllcity_area();
                $data['bedroom'] = array('1'=>1,'2' =>2,'3' =>3,'4' =>4,'5' =>5,'6' =>6);
                $data['bathroom'] = array('1'=>'1','2' =>'2','3' =>'3','4' =>'4','5' =>'5','6' =>'6','7' =>'7');
                $data['bedroom'] = array('1'=>'1','2' =>'2','3' =>'3','4' =>'4','5' =>'5','6' =>'6','7' =>'7');
                $data['category'] = array('1'=>'Duplex','2' =>'Apartment','3' =>'Penthouse','4' =>'Garden Apartments','5'=>'Studio','6' =>'Townhouse','7' =>'Villa','8' =>'Bungalow','9'=>'Land','10' =>'Shop','11' =>'Office','12' =>'Business','13'=>'Hotel','14' =>'Restaurant','15' =>'Building','16' =>'Industrial estate','17' =>'House','18' =>'Upper-House','19' =>'Maisonette');
                      
                if(!empty($_POST['property_type'])){

                    if(!empty($_POST['inq_apment']) && $_POST['inq_apment'] == "inquiry")
                    {
                        $data['inquiry_flag'] = "1";
                    }else{
                        $data['inquiry_flag'] = "0";
                    }
                    $data['post_property_data']=$_POST;
                    $data['search_detail'] = $this->inquiry_model->getrelated_property($_POST);
                    $this->load->view('search_property_view', $data);
                }else{
                    $data['post_property_data']=array();
                   $data['search_detail'] =array();
                    $this->load->view('search_property_view', $data);
                }
            }else{
                    redirect('home', 'refresh');
                }
                        
        } else {
            //If no session, redirect to login page
            redirect('login', 'refresh');
        }
    }

    function sendMultipleInquiry() {
        if ($this->session->userdata('logged_in_super_user') || $this->session->userdata('logged_in_agent') || $this->session->userdata('logged_in_employee'))
        {
            //$this->session->unset_userdata('selected_property_id');
        if($this->session->userdata('customer_property_id'))
        {
                if(isset($_POST['Proceed']) && $_POST['Proceed']!="")
                {
                   

                    $allPropertyIdsArr = explode(",", $_POST['allPropertyIds']);
                    $getSelectedPropertyDetails = $this->inquiry_model->getPropertyDetailsById($allPropertyIdsArr);
                    
                    $customerId  = $this->session->userdata('customer_property_id');
                    $property_buy_sale = $this->session->userdata('customer_property_buy_sale');
                    $property_link = array();
                    $property_title =array();
                    $property_link_path = base_url()."index.php/home/view_property/";
                    foreach ($getSelectedPropertyDetails as $inqKey => $inqValue) {

                        // Get Unique Inquiry Reference Number
                        $inquiry_num = $this->unic_inquiry_num();
                        if($inquiryid=$this->inquiry_model->saveClientInquiry($customerId, $inqValue->id, $inqValue->reference_no, $inquiry_num, $property_buy_sale))
                        {
                            $this->inquiry_model->saveClientInquiry_history($_POST,$inquiryid);
                            array_push($property_link, $property_link_path.$inqValue->id);
                           
                            if(!empty($inqValue->property_type)){ 
                                $property_category= $this->get_propertytypeby_id($inqValue->property_type);
                            }else{
                            $property_category="-";
                            }
                            if($inqValue->type ==1)
                                {
                                    $type = "Sale";
                                }
                                elseif($inqValue->type ==2)
                                {
                                    $type = "Rent";
                                }
                                elseif($inqValue->type ==3)
                                {
                                     $type = "Sale/Rent";
                                }
                                else{
                                    $type = "-";
                                }

                            array_push($property_title, $inqValue->reference_no." ".$inqValue->bedroom." Bedrooms ".$property_category." ".$type);
                        }
                        
                    }

                    // if(!empty($getSelectedPropertyDetails[0]->bedroom))
                    // {    
                    //     $bedroom_detail=$getSelectedPropertyDetails[0]->bedroom;
                    // }else{
                    //     $bedroom_detail="-";
                    // }
                    
                    // if(!empty($getSelectedPropertyDetails[0]->property_type)){ 
                    //     $property_category= $this->get_propertytypeby_id($getSelectedPropertyDetails[0]->property_type);
                    // }else{
                    //     $property_category="-";
                    // }
                    
                    // if(!empty($getSelectedPropertyDetails[0]->type)){ 
                    //     $property_type=$getSelectedPropertyDetails[0]->type;
                    // }else{
                    //     $property_type="-";
                    // }

                    // Send Email for New client Inquiry
                    
                    if($_POST['sendInquiryBy'] == "sendEmail")
                    {
                        $cust_id = $this->session->userdata('customer_property_id');
                        $customer_detail = $this->inquiry_model->get_customer_detail($cust_id);
                         
                        $data = array(
                                        'customer_email'=>$customer_detail[0]->email,
                                        'customer_name'=>$customer_detail[0]->fname.' '.$customer_detail[0]->lname,
                                        'property_links'=>$property_link,
                                         'property_title'=>$property_title
                                        //'bedroom'=>$bedroom_detail,
                                        //'property_category'=>$property_category,
                                        //'property_type'=>$property_type

                                    );
                       
                        if(!empty($customer_detail[0]->email))
                        {
                            $this->load->library('email');
                            $this->email->from('info@monopolion.com', 'monopolion');
                            $this->email->to($customer_detail[0]->email);
                            $this->email->cc('info@monopolion.com');
                            $this->email->bcc('info@monopolion.com');
                            $this->email->subject('New Client Inquiry');
                            $email_layout = $this->load->view('email/multiple_inquiry', $data,TRUE);
                            $this->email->message($email_layout);
                            $this->email->send();

                            // save Customer history
                            $history_text       = $email_layout;
                            $history_subject    = "Your Property Inquiry";
                            $history_type       = "E-mail";
                            $history_reciever   = $customer_detail[0]->email;
                            $history_reciever_id    = $customer_detail[0]->id;
                            $this->inquiry_model->saveSmsEmailHistory($history_text, $history_subject, $history_type, $history_reciever, $history_reciever_id);
                        }
                        $this->session->unset_userdata('customer_property_id');   
                        redirect('inquiry/inquiry_manage');
                    }
                    elseif ($_POST['sendInquiryBy'] == "sendSms")
                    {   
                        $cust_id = $this->session->userdata('customer_property_id');
                        $customer_detail = $this->inquiry_model->get_customer_detail($cust_id);
                        
                        if(!empty($customer_detail[0]->mobile_no))
                        {
                            /* sms send start */
                            $country_code = $this->user->get_contry_code($customer_detail[0]->coutry_code);               
                            if(!empty($country_code))
                            {
                                $mcode = substr($country_code[0]->prefix_code, 1);
                                $mobile_code="00".$mcode;
                                // $count_mcode = strlen($mcode);
                                // if($count_mcode < 2 ){
                                //     $mobile_code = '000'.$mcode;
                                // }elseif($count_mcode < 3 ){
                                //     $mobile_code = '00'.$mcode;
                                // }
                                // elseif($count_mcode < 4 ){
                                //     $mobile_code = '0'.$mcode;
                                // }else{
                                //     $mobile_code = $mcode;
                                // }
                                $message = "Dear ".$customer_detail[0]->fname." ".$customer_detail[0]->lname.", ";
                                $message .="Following attached link for property as per your requirements ";
                                if (!empty($property_title)) {
                                 foreach ($property_title as $key => $value) 
                                 {
                                        $property_title[$key] = $value;
                                        
                                 }   
                                }
                                if(!empty($property_link))
                                {
                                    foreach ($property_link as $key => $value) 
                                    {   
                                        $message .=$property_title[$key];
                                        $message .= $value;
                                        $message .=", \n"; 
                                    }
                                }
                                $message .= " For any further info call: 8000 7000";
                                $message .= " Thanks,";
                                $message .= " Monopolion Team";
                                $this->load->library('CMSMS');
                                CMSMS::sendMessage($mobile_code.$customer_detail[0]->mobile_no, $message);
                                
                                // Save new sms to history table
                                $history_text       = $message;
                                $history_subject    = "New Client Inquiry";
                                $history_type       = "SMS";
                                $history_reciever   = $mobile_code.$customer_detail[0]->mobile_no;
                                $history_reciever_id    = $customer_detail[0]->id;
                                $this->inquiry_model->saveSmsEmailHistory($history_text, $history_subject, $history_type, $history_reciever, $history_reciever_id);
                        
                            }
                        }    
                        /* sms send end */
                          $this->session->unset_userdata('customer_property_id'); 
                          redirect('inquiry/inquiry_manage');
                    
                    } elseif ($_POST['sendInquiryBy'] == "sendBoth"){
                        $cust_id = $this->session->userdata('customer_property_id');
                        $customer_detail = $this->inquiry_model->get_customer_detail($cust_id);
                         
                        $data = array(
                                        'customer_email'=>$customer_detail[0]->email,
                                        'customer_name'=>$customer_detail[0]->fname.''.$customer_detail[0]->lname,
                                        'property_links'=>$property_link,
                                        'property_title'=>$property_title
                                        // 'bedroom'=>$bedroom_detail,
                                        // 'property_category'=>$property_category,
                                        // 'property_type'=>$propety_type
                                    );
                        $sendSMSFlag = "";
                        $sendEmailFlag = "";
                        if(!empty($customer_detail[0]->email))
                        {
                            $this->load->library('email');
                            $this->email->from('info@monopolion.com', 'monopolion');
                            $this->email->to($customer_detail[0]->email);
                            $this->email->cc('info@monopolion.com');
                            $this->email->bcc('info@monopolion.com');
                            $this->email->subject('New Client Inquiry');
                            $email_layout = $this->load->view('email/multiple_inquiry', $data,TRUE);
                            $this->email->message($email_layout);
                            if($this->email->send())
                            {
                                $sendEmailFlag = "E-mail";   
                            }
                            // save Customer history
                            $history_text       = $email_layout;
                            $history_subject    = "New Client Inquiry";
                            $history_type       = "Email";
                            $history_reciever   = $customer_detail[0]->email;
                            $history_reciever_id    = $customer_detail[0]->id;
                            //$this->inquiry_model->saveSmsEmailHistory($history_text, $history_subject, $history_type, $history_reciever, $history_reciever_id);
                        }
                        
                        if(!empty($customer_detail[0]->mobile_no))
                        {
                        /* sms send start */
                            $country_code = $this->user->get_contry_code($customer_detail[0]->coutry_code);               
                            if(!empty($country_code))
                            {
                                $mcode = substr($country_code[0]->prefix_code, 1);
                                $mobile_code="00".$mcode;
                                // $count_mcode = strlen($mcode);
                                // if($count_mcode < 2 ){
                                //     $mobile_code = '000'.$mcode;
                                // }elseif($count_mcode < 3 ){
                                //     $mobile_code = '00'.$mcode;
                                // }
                                // elseif($count_mcode < 4 ){
                                //     $mobile_code = '0'.$mcode;
                                // }else{
                                //     $mobile_code = $mcode;
                                // }
                                $message = "Dear ".$customer_detail[0]->fname." ".$customer_detail[0]->lname.", ";
                                $message .="Following attached link for property as per your requirements ";
                                if (!empty($property_title)) {
                                 foreach ($property_title as $key => $value) 
                                 {
                                        $property_title[$key] = $value;
                                        
                                 }   
                                }
                                if(!empty($property_link))
                                {
                                    foreach ($property_link as $key => $value) 
                                    {
                                        $message .=$property_title[$key];
                                        $message .= $value;
                                        $message .=", \n"; 
                                    }
                                }
                                $message .= " For any further info call: 8000 7000";
                                $message .= " Thanks,";
                                $message .= " Monopolion Team";
                                $this->load->library('CMSMS');
                               $sms_res= CMSMS::sendMessage($mobile_code.$customer_detail[0]->mobile_no, $message);
                                if(empty($sms_res)){
                                    $sendSMSFlag = "SMS";
                                }
                                $history_text_sms       = $message;
                                $history_subject_sms    = "New Client Inquiry";
                                $history_type_sms       = "SMS";
                                $history_reciever_sms   = $mobile_code.$customer_detail[0]->mobile_no;
                                $history_reciever_id_sms    = $customer_detail[0]->id;
                               // $this->inquiry_model->saveSmsEmailHistory($history_text_sms, $history_subject_sms, $history_type_sms, $history_reciever_sms, $history_reciever_id_sms);
                            }
                        }
                        if($sendSMSFlag == "SMS" && $sendEmailFlag == "E-mail")
                        {
                            $history_type_sms   = "SMS/E-mail";
                            $history_type       = "SMS/E-mail";

                            // SMS
                            $this->inquiry_model->saveSmsEmailHistory($history_text_sms, $history_subject_sms, $history_type_sms, $history_reciever_sms, $history_reciever_id_sms);
                            
                            // Email
                            $this->inquiry_model->saveSmsEmailHistory($history_text, $history_subject, $history_type, $history_reciever, $history_reciever_id);
                            $this->session->set_flashdata('success', 'Success! Inquiry for the Property sent successfully. check your E-mail or SMS!');
                            redirect('inquiry/inquiry_manage');
                        }
                        elseif ($sendSMSFlag == "SMS")
                        {
                            
                            // SMS
                            $this->inquiry_model->saveSmsEmailHistory($history_text_sms, $history_subject_sms, $history_type_sms, $history_reciever_sms, $history_reciever_id_sms);
                            
                            $this->session->set_flashdata('success', 'Success! Inquiry for the Property sent successfully. Check SMS!');
                            redirect('inquiry/inquiry_manage');
                        }
                        elseif ($sendEmailFlag == "E-mail")
                        {
                            // Email
                            $this->inquiry_model->saveSmsEmailHistory($history_text, $history_subject, $history_type, $history_reciever, $history_reciever_id);
                            
                            $this->session->set_flashdata('success', 'Success! Inquiry for the Property sent successfully. Check your E-mail!');
                            redirect('inquiry/inquiry_manage');      
                        }
                        
                    }else{
                        $this->session->set_flashdata('success', 'Success! Inquiry for the Property sent successfully.!');
                        redirect('inquiry/inquiry_manage');
                        # code for both send sms and email here...                        

                    }
                    
                }
               
        }else{
                redirect('home', 'refresh');
            }
                        
        } else {
            //If no session, redirect to login page
            redirect('login', 'refresh');
        }
    }
    
    function scheduleAppointment($inquiryId)
    {
        if($inquiryId !="")
        {
            $inquiryDetail = $this->inquiry_model->getInquiryDetailById($inquiryId);
            
            if($inquiryDetail[0]->property_id == "0")
            {
                $this->session->set_userdata('customer_property_id', $inquiryDetail[0]->customer_id);
                $this->session->set_userdata('customer_property_buy_sale', $inquiryDetail[0]->aquired);
                $this->session->set_userdata('appointment_selected', "1");
                redirect('/inquiry/property', 'refresh');
            }
            elseif($inquiryDetail[0]->appoint_start_date == "0000-00-00 00:00:00" && $inquiryDetail[0]->appoint_end_date == "0000-00-00 00:00:00")
            {
                $this->session->unset_userdata('selected_property_id');
                $this->session->set_userdata('selected_property_id', $inquiryDetail[0]->property_id);

                $pro_agent_id = $this->inquiry_model->get_related_property_agent_id($inquiryDetail[0]->property_id);
                $this->session->set_userdata('selected_agent_id', $pro_agent_id[0]->agent_id);
                redirect('/inquiry/agent_calendar', 'refresh');
            }
        }
    }

    function calendar() {

        $this->load->view('calendar_view');

    }
    function agent_calendar() {
        
        if($this->session->userdata('appointment_selected'))
        {
           $this->session->unset_userdata('appointment_selected'); 
        }
        
        if(!empty($_POST['property_name']))
        {
            $this->session->set_userdata('selected_property_id', $_POST['property_name']);
            $pro_agent_id = $this->inquiry_model->get_related_property_agent_id($_POST['property_name']);
                $this->session->set_userdata('selected_agent_id', $pro_agent_id[0]->agent_id);
            $data['allAgent'] = $this->inquiry_model->getAll_appointmentAgent();

            $this->load->view('agent_calendar',$data);
        }
        elseif($this->session->userdata('selected_property_id'))
        {
            $data['allAgent'] = $this->inquiry_model->getAll_appointmentAgent();
            $this->load->view('agent_calendar',$data);
        }
        else
        {
            redirect('inquiry/property', 'refresh'); 
        }
       // $data['allAgent'] = $this->inquiry_model->getAllAgent();
       // $this->load->view('agent_calendar',$data);
    }
    function get_agent_calandar_detail()
    {
        $data= $this->inquiry_model->agent_schedule();
         
         foreach ($data as $z=>$val)
              { 
                $rand = dechex(rand(0x000000, 0xFFFFFF));

                 $data[$z]->color = ('#' . $rand);
                 $data[$z]->title  =  $val->fname.' '.$val->lname.' '.date("H:i", strtotime($val->appoint_start_date))." to: ".date("H:i", strtotime($val->appoint_end_date));
                 $data[$z]->start  = $val->appoint_start_date;
                 $data[$z]->end  =  $val->appoint_end_date;
                 
               }
              // echo'<pre>';print_r($data);exit;
                echo json_encode($data);   
               
    }
    function get_agent_calender_details_byId($id)
    {
        $data= $this->inquiry_model->agent_detail_byid($id);
        
         foreach ($data as $z=>$val)
              {
                $rand = dechex(rand(0x000000, 0xFFFFFF));

                 $data[$z]->color = ('#' . $rand);
                 $data[$z]->title  = date("H:i", strtotime($val->appoint_start_date))." to: ".date("H:i", strtotime($val->appoint_end_date));
                 $data[$z]->start  = $val->appoint_start_date;
                 $data[$z]->end  =  $val->appoint_end_date;
                 
               }
                echo json_encode($data);   
               
    }
    function get_agent_appoinment_date($id){
        $data= $this->inquiry_model->agent_detail_byid($id);
        foreach ($data as $z=>$val)
              { 
                 //$data[$z]->title  =  "Agent Not Free";
                 $data[$z] = date("d-m-Y", strtotime($val->appoint_start_date));

               // $data[$z]->end  =  $val->appoint_end_date;
                 
               }
                echo json_encode($data);   
             
    }

    function delete_inquiry() {
        if ($this->session->userdata('logged_in_super_user') || $this->session->userdata('logged_in_agent') || $this->session->userdata('logged_in_employee')) {
            
            $id = $this->uri->segment(3);

           // $user = $this->user->getemployee($usrid);
                        
            $this->inquiry_model->deleteinquiry($id);

            $this->session->set_flashdata('success', 'Success! You have deleted inquiry successfully.!');
            redirect('inquiry/inquiry_manage', 'refresh');
        } else {
            //If no session, redirect to login page
            redirect('login', 'refresh');
        }
    }

    function check_agent_free_selectdate()
    {
        $data= $this->inquiry_model->check_agent_free_selectdate($_POST);
        if(!empty($data)) {
                echo "false";exit;
            }else{
                echo "true";exit;
        }
    }
    function get_propertytypeby_id($id)
    {
        
        $data = array('1'=>'Duplex','2' =>'Apartment','3' =>'Penthouse','4' =>'Garden Apartments','5'=>'Studio','6' =>'Townhouse','7' =>'Villa','8' =>'Bungalow','9'=>'Land','10' =>'Shop','11' =>'Office','12' =>'Business','13'=>'Hotel','14' =>'Restaurant','15' =>'Building','16' =>'Industrial estate','17' =>'House','18' =>'Upper-House','19' =>'Maisonette');
        return $data[$id];

    }
    function get_inquiry_recored()
    {
        
        $data= $this->inquiry_model->get_inquiry_recored($_POST['inquiry_id']);
        $data[0]->agent_id= $this->inquiry_model->get_agent_name_inq($data[0]->agent_id);
       // echo'<pre>';print_r($data);exit;
        $inquiryDetailHtml = "<fieldset><hr>";
        if(isset($data[0]->agent_id) && !empty($data[0]->agent_id)){
            $inquiryDetailHtml .= '<lable><b>Agent Name</b></lable> :<lable>'.$data[0]->agent_id[0]->fname.' -'.$data[0]->agent_id[0]->lname . '</lable> ';
            $inquiryDetailHtml .=  '<br><br>'; 
        }
        
        
        if(isset($data[0]->incquiry_ref_no) && !empty($data[0]->incquiry_ref_no)){
            $inquiryDetailHtml .= '<lable><b>Inquiry Reference No</b></lable> :<lable>'.$data[0]->incquiry_ref_no.'</lable> ';
            $inquiryDetailHtml .=  '<br><br>';           
        }
        if(isset($data[0]->title) && !empty($data[0]->title)){
            $inquiryDetailHtml .= '<lable><b>Property Area</b></lable> :<lable>'.$data[0]->title.'</lable> ';
            $inquiryDetailHtml .=  '<br><br>';           
        }
        if(isset($data[0]->property_type) && !empty($data[0]->property_type)){
            $property_data= $this->get_propertytypeby_id($data[0]->property_type);
             $inquiryDetailHtml .= '<lable><b>Property Type</b></lable> :<lable>'.$property_data.'</lable> ';
                $inquiryDetailHtml .=  '<br><br>';
        }
         

        if(isset($data[0]->aquired) && !empty($data[0]->aquired)){
            $inquiryDetailHtml .= '<lable><b>Property Status</b></lable> :<lable>'.$data[0]->aquired.'</lable> ';
            $inquiryDetailHtml .=  '<br><br>';
        }
                   
        if(isset($data[0]->bathroom) && !empty($data[0]->bathroom)){
            $inquiryDetailHtml .= '<lable><b>Bathrooms</lable> :<lable>'.$data[0]->bathroom.'</lable> ';
            $inquiryDetailHtml .=  '<br><br>';
        }
         
        if(isset($data[0]->badroom) && !empty($data[0]->badroom)){
            $inquiryDetailHtml .= '<lable><b>Bedrooms</b></lable> :<lable>'.$data[0]->badroom.'</lable> ';
            $inquiryDetailHtml .=  '<br><br>';
        }
         
        if(isset($data[0]->reference_no) && !empty($data[0]->reference_no)){
            $inquiryDetailHtml .= '<lable><b>Property Reference No</b></lable> :<lable>'.$data[0]->reference_no.'</lable> ';
            $inquiryDetailHtml .=  '<br><br>';
        }
         
        if(isset($data[0]->minprice) && !empty($data[0]->minprice)){
            $inquiryDetailHtml .= '<lable><b>Minimum Price</b></lable> :<lable>'.$data[0]->minprice.'</lable> ';
            $inquiryDetailHtml .=  '<br><br>';
        }
                   
        if(isset($data[0]->maxprice) && !empty($data[0]->maxprice)){
            $inquiryDetailHtml .= '<lable><b>Maximum Price</b></lable> :<lable>'.$data[0]->maxprice.'</lable> ';
            $inquiryDetailHtml .=  '<br><br>';
        }
         
        
        $inquiryDetailHtml .=  '</fieldset>';          
                    
        echo $inquiryDetailHtml;
    }
    function get_sms_email_text()
    {
       
        $data= $this->inquiry_model->get_sms_email_text($_POST['id']);
        echo $data[0]->text;
       
    }
}

?>