<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
session_start(); //we need to call PHP's session object to access it through CI

class Home extends CI_Controller {

    function __construct() {
        parent::__construct();
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

    function index() {
        if ($this->session->userdata('logged_in_super_user') || $this->session->userdata('logged_in_agent') || $this->session->userdata('logged_in_employee')) {
            
				$data['agent'] = $this->user->getAgentTotal();            
            
            $data['employee'] =$this->user->getEmployeeTotal();
            
				$data['customer'] =$this->user->getCustomerTotal();
		
				$data['inquiry'] =$this->user->getInquiryTotal(); 

                $data['property'] =$this->user->getPropertyTotal(); 
				//echo'<pre>';print_r($data);exit;
				$this->load->view("home_view", $data);
				
        } else {
            //If no session, redirect to login page
            redirect('login', 'refresh');
        }
    }
    //Agent manag start //
    
    function agent_manage() {
        if ($this->session->userdata('logged_in_super_user')) {
        
            $data['user'] = $this->user->getAllagent();
         // echo'<pre>';print_r($data);exit;
            $this->load->view('agent_list_view', $data);
        } else {
            //If no session, redirect to login page
            redirect('login', 'refresh');
        }
    }
    function add_agent() {
        if ($this->session->userdata('logged_in_super_user')) {
            $this->load->helper(array('form'));
            
            if($this->uri->segment(3)) {
                $id = $this->uri->segment(3);
                $data['user'] = $this->user->getagent($id);
                //$data['orderdetail'] = $this->user->getAllUserOrderDetail($usrid);
                $this->load->view('add_agent_view', $data);
            } else {
                $this->load->view('add_agent_view');
            }
            
        } else {
            //If no session, redirect to login page
            redirect('login', 'refresh');
        }
    }
    function delete_agent() {
        if ($this->session->userdata('logged_in_super_user')) {
            
            $id = $this->uri->segment(3);

            //$user = $this->user->getUser($usrid);
                        
            $this->user->deleteagent($id);

            $this->session->set_flashdata('success', 'Success! You have deleted Agent successfully.!');
            redirect('home/agent_manage', 'refresh');
        } else {
            //If no session, redirect to login page
            redirect('login', 'refresh');
        }
    }
    function agentemail_check() {
        
        $user = $this->user->email_check($_POST);
        
        if(!empty($user)) {
                echo "false";exit;
            }else{
                echo "true";exit;
            }
        
    }
    function agent_mobile_check() {
        echo'<pre>';print_r($_POST);exit;
        
        $user = $this->user->agent_mobile_check($_POST);
        
        if(!empty($user)) {
                echo "false";exit;
            }else{
                echo "true";exit;
            }
        
    }
//Agent manag end //


//customer manag start //
    function customer_manage() {
        if ($this->session->userdata('logged_in_super_user')) {

            $data['user'] = $this->user->getAllcustomer();
            
            $this->load->view('customer_list_view', $data);
        } else {
            //If no session, redirect to login page
            redirect('login', 'refresh');
        }
    }
    
    function add_customer() {
        if ($this->session->userdata('logged_in_super_user')) {

            $this->load->helper(array('form'));
            
            if($this->uri->segment(3)) {
                $id = $this->uri->segment(3);
                $data['user'] = $this->user->getcustomer($id);
                //$data['orderdetail'] = $this->user->getAllUserOrderDetail($usrid);
                $this->load->view('add_customer_view', $data);
            } else {
                $this->load->view('add_customer_view');
            }
            
        } else {
            //If no session, redirect to login page
            redirect('login', 'refresh');
        }
    }
    function delete_customer() {
        if ($this->session->userdata('logged_in_super_user')) {
            
            $id = $this->uri->segment(3);

            //$user = $this->user->getcustomer($id);
                        
            $this->user->deletecustomer($id);

            $this->session->set_flashdata('success', 'Success! You have deleted Client successfully.!');
            redirect('home/customer_manage', 'refresh');
        } else {
            //If no session, redirect to login page
            redirect('login', 'refresh');
        }
    }

     function customer_email_check() {

        $user = $this->user->customer_email_check($_POST);
        
        if(!empty($user)) {
                echo "false";exit;
            }else{
                echo "true";exit;
            }
    }
    function customer_mobile_check() {

        $user = $this->user->customer_mobile_check($_POST);
        
        if(!empty($user)) {
                echo "false";exit;
            }else{
                echo "true";exit;
            }
    }

//customer manag end //


//employee manag start //
     function employee_manage() {
        if ($this->session->userdata('logged_in_super_user')) {
        
            $data['user'] = $this->user->getAllemployee();
            //echo'<pre>';print_r($data);exit;
            $this->load->view('employee_list_view', $data);
        } else {
            //If no session, redirect to login page
            redirect('login', 'refresh');
        }
    }	
    
    function add_employee() {
            if ($this->session->userdata('logged_in_super_user')) {
            $this->load->helper(array('form'));
            
            if($this->uri->segment(3)) {
                $id = $this->uri->segment(3);
                $data['user'] = $this->user->getagent($id);
                //$data['orderdetail'] = $this->user->getAllUserOrderDetail($usrid);
                $this->load->view('add_employee_view', $data);
            } else {
                $this->load->view('add_employee_view');
            }
            
        } else {
            //If no session, redirect to login page
            redirect('login', 'refresh');
        }
    }

    function delete_employee() {
        if ($this->session->userdata('logged_in_super_user')) {    
            $id = $this->uri->segment(3);

           // $user = $this->user->getemployee($usrid);
                        
            $this->user->deleteagent($id);

            $this->session->set_flashdata('success', 'Success! You have deleted Employee successfully.!');
            redirect('home/employee_manage', 'refresh');
        } else {
            //If no session, redirect to login page
            redirect('login', 'refresh');
        }
    }

    function employee_email_check() {

        $user = $this->user->employee_email_check($_POST);
        
        if(!empty($user)) {
                echo "false";exit;
            }else{
                echo "true";exit;
            }
    }
    function employee_mobile_check() {

        $user = $this->user->employee_mobile_check($_POST);
        
        if(!empty($user)) {
                echo "false";exit;
            }else{
                echo "true";exit;
            }
    }
//employee manage end //

//property manage start //
	function property_manage() {
        if ($this->session->userdata('logged_in_super_user') || $this->session->userdata('logged_in_agent') || $this->session->userdata('logged_in_employee')) {
            $data['user'] = $this->user->getAllproperty();
            
            $this->load->view('property_list_view', $data);
        } else {
            //If no session, redirect to login page
            redirect('login', 'refresh');
        }
    }
    //property manage start //
    function registed_properties() {
        if ($this->session->userdata('logged_in_super_user') || $this->session->userdata('logged_in_agent') || $this->session->userdata('logged_in_employee')) {
            $data['user'] = $this->user->getregisted_properties();
            
            $this->load->view('property_list_view', $data);
        } else {
            //If no session, redirect to login page
            redirect('login', 'refresh');
        }
    }
    function add_property() {
        if ($this->session->userdata('logged_in_super_user') || $this->session->userdata('logged_in_agent') || $this->session->userdata('logged_in_employee')) {
                    $this->load->helper(array('form'));
            
            if($this->uri->segment(3)) {
                $id = $this->uri->segment(3);
                $data['user'] = $this->user->get_property($id);
                $data['facility_id'] = $this->user->get_property_related_facility($id);
                 //echo'<pre>';print_r($data['facility_id'][0]->facility_id);exit;
                //$data['orderdetail'] = $this->user->getAllUserOrderDetail($usrid);
                $this->load->view('add_property_view', $data);
            } else {

                $this->load->view('add_property_view');
            }
            
        } else {
            //If no session, redirect to login page
            redirect('login', 'refresh');
        }
    }
     function email_newsletter_list()
    {
        $this->load->view('email_newsletter_list_view');
    }
    function sms_newsletter_list()
    {
        $this->load->view('sms_newsletter_list_view');
    }
     function sms_newsletter()
    {

        $this->load->library('CMSMS');
        CMSMS::sendMessage('00919898027612', 'Test message');

        $this->load->view('sms_newsletter_view');
    }

    function email_newsletter()
    {
        $this->load->view('email_newsletter_view');
    }

    function sms_email_history()
    {
        $data['sms_email_history'] = $this->inquiry_model->get_sms_email_history();
        
        foreach ($data['sms_email_history'] as $key => $value) {
        
            $data['sms_email_history'] = $this->inquiry_model->get_sms_email_history_recievername($value->user_type);
        }
        //echo'<pre>';print_r($data);exit;
        $this->load->view('sms_email_history_view',$data);
    }

    function propertyExatraImages($propertyId)
    {
        $data['allPropertyImages'] = $this->inquiry_model->getPropertyExtraImages($propertyId);
        $data['getPropertyDetails'] = $this->inquiry_model->get_property_detail($propertyId);
        $this->load->view('property_exatra_images',$data);
    }

    function deletePropertyExtImg()
    {
        $propertyImgId = $_POST['propertyImgId'];
        //echo $propertyImgName = $_POST['propertyImgName'];
        $propertyImgDetails = $this->inquiry_model->getPropertyExtImgDetailsById($propertyImgId);
        
        //print_r($propertyImgDetails);exit;
        if($this->inquiry_model->deletePropertyExtImgById($propertyImgId))
        {
            @unlink(APPPATH."../upload/property/".$propertyImgDetails[0]->image_name);
            @unlink(APPPATH."../upload/property/100x100/".$propertyImgDetails[0]->image_name);
            @unlink(APPPATH."../upload/property/200x200/".$propertyImgDetails[0]->image_name);
            echo true;
        }
        else{
            echo false;
        }
    }

    function addpropertyExatraImagesByAjax($propertyId)
    {
        if(isset($_FILES["myfile"]))
        {
            $ret = array();
            // This is for custom errors;
            /* $custom_error= array();
            $custom_error['jquery-upload-file-error']="File already exists";
            echo json_encode($custom_error);
            die();
            */
            // $fileCount = count($_FILES["myfile"]["name"]);
            // for($i=0; $i < $fileCount; $i++)
            // {
            //     $fileName = $_FILES["myfile"]["name"][$i];
            //     move_uploaded_file($_FILES["myfile"]["tmp_name"][$i],$output_dir.$fileName);
            //     $ret[]= $fileName;
            // }

            // Upload Original Image
            $config['upload_path'] =  realpath(APPPATH . '../upload/property');
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            $data=$this->upload->do_upload("myfile");
            $data = $this->upload->data();
            
            // Save data to Database.
            if($this->inquiry_model->savePropertyExtraImage($propertyId, $data['file_name']))
            {
                $propertyImgId = $this->db->insert_id();
                
                $configSize1['image_library']   = 'gd2';
                $configSize1['source_image']    = APPPATH . '../upload/property/'.$data['file_name'];
                //$configSize1['create_thumb']    = TRUE;
                $configSize1['maintain_ratio']  = TRUE;
                $configSize1['width']           = 100;
                $configSize1['height']          = 100;
                $configSize1['new_image']       = APPPATH . '../upload/property/100x100/';

                $this->image_lib->initialize($configSize1);
                $this->image_lib->resize();
                $this->image_lib->clear();

                $configSize1['image_library']   = 'gd2';
                $configSize1['source_image']    = APPPATH . '../upload/property/'.$data['file_name'];
                //$configSize1['create_thumb']    = TRUE;
                $configSize1['maintain_ratio']  = TRUE;
                $configSize1['width']           = 200;
                $configSize1['height']          = 200;
                $configSize1['new_image']       = APPPATH . '../upload/property/200x200/';
                $this->image_lib->initialize($configSize1);
                $this->image_lib->resize();
                $this->image_lib->clear();

                $ret["filename"] = $data['file_name'];
                $ret["fileId"] = $propertyImgId;
                echo json_encode($ret);
            }
        }
    }

    function delete_property() {
        if ($this->session->userdata('logged_in_super_user') || $this->session->userdata('logged_in_agent') || $this->session->userdata('logged_in_employee')) {
                    $id = $this->uri->segment(3);

           // $user = $this->user->getemployee($usrid);
                        
            $this->user->deleteproperty($id);

            $this->session->set_flashdata('success', 'Success! You have deleted Property successfully.!');
            redirect('home/property_manage', 'refresh');
        } else {
            //If no session, redirect to login page
            redirect('login', 'refresh');
        }
    }
    
    function change_password() {
        if ($this->session->userdata('logged_in_super_user') || $this->session->userdata('logged_in_agent') || $this->session->userdata('logged_in_employee')) {
        
            $this->load->helper(array('form'));
            if($this->session->userdata('logged_in_super_user')){
                $sessionData = $this->session->userdata('logged_in_super_user');
            }
            else if($this->session->userdata('logged_in_agent')){
                $sessionData = $this->session->userdata('logged_in_agent');
            }else if($this->session->userdata('logged_in_employee')){
                $sessionData = $this->session->userdata('logged_in_employee');
            }
			$id = $sessionData['id'];
			$data['user_pass'] = $this->user->getUserPassword($id);
           
         $this->load->view('change_password_view',$data);
            
        } else {
            //If no session, redirect to login page
            redirect('login', 'refresh');
        }
    }
    function unic_num() {
        $num = rand(10000000,99999999);

        $unic_number = $this->user->check_unic_num($num);
        if(!empty($unic_number))
        {
           $this->unic_num();
        }
        else
        {
           return $num;
        }
    }
    function unic_inquiry_num() {
        $inquiry_num = 'inquiry'.rand(10000000,99999999);
        $unic_number = $this->inquiry_model->check_unic_inquiry_num($inquiry_num);
        if(!empty($unic_number))
        {
           $this->unic_inquiry_num();
        }
        else
        {
           return $inquiry_num;
        }
    }

    function sendNewClientInquiry_exist_client()
    {
        error_reporting(0);
        $get_exist_customer_Id = $this->inquiry_model->get_exist_customer_Id($_POST['email_mobile']);
        
        $PropertyId = $_POST['property_id'];
        $getSelectedPropertyDetails = $this->inquiry_model->getPropertyDetailsById($PropertyId);
        
        $customerId  =$get_exist_customer_Id[0]->id;
        $property_buy_sale = $_POST['aquired'];
        $property_link = array();
        $property_title =array();
        $property_link_path = base_url()."index.php/home/view_property/"; 
        array_push($property_link, $property_link_path.$getSelectedPropertyDetails[0]->id);
       
        if(!empty($getSelectedPropertyDetails[0]->bedroom)){
            $bedroom_detail=$getSelectedPropertyDetails[0]->bedroom;
        }else{
            $bedroom_detail="-";
        }
        
        if(!empty($getSelectedPropertyDetails[0]->reference_no)){ 
        $reference_no= $getSelectedPropertyDetails[0]->reference_no;
        }else{
            $reference_no="-";
        }
        if(!empty($getSelectedPropertyDetails[0]->property_type)){ 
        $property_category= $this->get_propertytypeby_id($getSelectedPropertyDetails[0]->property_type);
        }else{
            $property_category="-";
        }

        if(!empty($getSelectedPropertyDetails[0]->type)){ 
            $propety_type=$getSelectedPropertyDetails[0]->type;
        }else{
            $propety_type="-";
        }        
        if($propety_type =='1')
        {
            $type = "Sale";
        }
        else if($propety_type ==2)
        {
            $type = "Rent";
        }
        else if($propety_type =='3')
        {
             $type = "Sale/Rent";
        }
        else{
            $type = "- ";
        }
        array_push($property_title, $reference_no." ".$bedroom_detail." Bedrooms ".$property_category." ".$type);
        $inquiry_num = $this->unic_inquiry_num();

        $this->inquiry_model->saveClientInquiry($customerId, $PropertyId, $getSelectedPropertyDetails[0]->reference_no, $inquiry_num, $property_buy_sale);            
            
            $data = array(
                            'customer_email'=>$get_exist_customer_Id[0]->email,
                            'customer_name'=>$get_exist_customer_Id[0]->fname.''.$get_exist_customer_Id[0]->lname,
                            'property_links'=>$property_link,
                            //'bedroom'=>$bedroom_detail,
                            //'property_category'=>$property_category,
                            //'property_type'=>$propety_type
                            'property_title'=>$property_title
                        );
            $sendSMSFlag = "";
            $sendEmailFlag = "";
            if(!empty($get_exist_customer_Id[0]->email))
            {
                $this->load->library('email');
                $this->email->from('info@monopolion.com', 'monopolion');
                $this->email->to($get_exist_customer_Id[0]->email);
                $this->email->cc('info@monopolion.com');
                $this->email->bcc('info@monopolion.com');
                $this->email->subject('Exist Client Inquiry');
                $email_layout = $this->load->view('email/multiple_inquiry', $data,TRUE);
                $this->email->message($email_layout);
                if($this->email->send())
                {
                     $sendEmailFlag = "E-mail";   
                }
                
                $history_text       = $email_layout;
                $history_subject    = "Exist Client Inquiry";
                $history_type       = "E-mail";
                $history_reciever   = $get_exist_customer_Id[0]->email;
                $history_reciever_id    = $customerId;
                $history_reciever_usertype="1";
                //$this->inquiry_model->saveSmsEmailHistory($history_text, $history_subject, $history_type, $history_reciever, $history_reciever_id);
            }

            
            /* sms send start */
            if(!empty($get_exist_customer_Id[0]->mobile_no))
            {
                $country_code = $this->user->get_contry_code($get_exist_customer_Id[0]->coutry_code);               
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
                   
                    $message = "Dear ".$get_exist_customer_Id[0]->fname." ".$get_exist_customer_Id[0]->lname.", ";
                    $message .="Following attached link for property as per your requirements: \n";
                    $message .= $reference_no;
                    $message .= " ".$bedroom_detail." Bedrooms ";
                    $message .= $property_category .", ";
                     
                    if($propety_type =='1')
                    {
                        $message .= "Sale \n";
                    }
                    else if($propety_type ==2)
                    {
                        $message .= "Rent \n";
                    }
                    else if($propety_type =='3')
                    {
                         $message .= "Sale/Rent \n";
                    }
                    else{
                        $message .= "- \n";
                    }
                    $message .= $property_link[0];
                    $message .= " For any further info call: 8000 7000";
                    $message .= " Thanks,";
                    $message .= " Monopolion Team";
                    $this->load->library('CMSMS');
                    $sms_res=CMSMS::sendMessage($mobile_code.$get_exist_customer_Id[0]->mobile_no, $message);
                    if(empty($sms_res)){
                            $sendSMSFlag = "SMS";
                    }
                    $history_text_sms       = $message;
                    $history_subject_sms    = "Your Property Inquiry";
                    $history_type_sms       = "SMS";
                    $history_reciever_sms   = $mobile_code.$get_exist_customer_Id[0]->mobile_no;
                    $history_reciever_id_sms    = $customerId;
                    $history_reciever_usertype="1";
                    //$this->inquiry_model->saveSmsEmailHistory($history_text_sms, $history_subject_sms, $history_type_sms, $history_reciever_sms, $history_reciever_id_sms);
                }
            }
            if($sendSMSFlag == "SMS" && $sendEmailFlag == "E-mail")
                {
                    $history_type_sms   = "SMS/E-mail";
                    $history_type       = "SMS/E-mail";

                    // SMS
                    $this->inquiry_model->saveSmsEmailHistory($history_text_sms, $history_subject_sms, $history_type_sms, $history_reciever_sms, $history_reciever_id_sms,$history_reciever_usertype);
                    
                    // Email
                    $this->inquiry_model->saveSmsEmailHistory($history_text, $history_subject, $history_type, $history_reciever, $history_reciever_id,$history_reciever_usertype);
                    $this->session->set_flashdata('success', 'Success! Inquiry for the Property sent successfully. check your E-mail or SMS!');
                    redirect('home/property_manage');
                }
                elseif ($sendSMSFlag == "SMS")
                {
                    
                    // SMS
                    $this->inquiry_model->saveSmsEmailHistory($history_text_sms, $history_subject_sms, $history_type_sms, $history_reciever_sms, $history_reciever_id_sms,$history_reciever_usertype);
                    
                    $this->session->set_flashdata('success', 'Success! Inquiry for the Property sent successfully. Check SMS!');
                    redirect('home/property_manage');
                }
                elseif ($sendEmailFlag == "E-mail")
                {
                    // Email
                    $this->inquiry_model->saveSmsEmailHistory($history_text, $history_subject, $history_type, $history_reciever, $history_reciever_id,$history_reciever_usertype);
                    
                    $this->session->set_flashdata('success', 'Success! Inquiry for the Property sent successfully. Check your E-mail!');
                    redirect('home/property_manage');      
                }
          /* sms send end */

            $this->session->set_flashdata('success', 'Success! Inquiry for the Property sent successfully.!');
            redirect('home/property_manage');
        

    }

    function sendNewClientInquiry()
    {
        if ($this->session->userdata('logged_in_super_user') || $this->session->userdata('logged_in_agent') || $this->session->userdata('logged_in_employee'))
        {
            error_reporting(0);
            $customer_uniqueNo =$this->unic_num(); 
            if ($customer_Id = $this->user->customer_insert($customer_uniqueNo)) {
            
                    if(isset($_POST) && $_POST !="")
                    {   
                        $PropertyId = $_POST['property_id'];
                        $getSelectedPropertyDetails = $this->inquiry_model->getPropertyDetailsById($PropertyId);
                        
                        $customerId  = $customer_Id;
                        $property_buy_sale = $_POST['aquired'];
                        $property_link = array();
                        $property_link_path = base_url()."index.php/home/view_property/";
                        foreach ($getSelectedPropertyDetails as $inqKey => $inqValue) {

                            // Get Unique Inquiry Reference Number
                            $inquiry_num = $this->unic_inquiry_num();
                            if($this->inquiry_model->saveClientInquiry($customerId, $inqValue->id, $inqValue->reference_no, $inquiry_num, $property_buy_sale))
                            {
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
                        
                        if(!empty($getSelectedPropertyDetails[0]->bedroom)){
                            $bedroom_detail=$getSelectedPropertyDetails[0]->bedroom;
                        }else{
                            $bedroom_detail="-";
                        }
                        
                        if(!empty($getSelectedPropertyDetails[0]->property_type)){ 
                        $property_category= $this->get_propertytypeby_id($getSelectedPropertyDetails[0]->property_type);
                        }else{
                            $property_category="-";
                        }
                        if(!empty($getSelectedPropertyDetails[0]->type)){ 
                            $property_type=$getSelectedPropertyDetails[0]->type;
                        }else{
                            $property_type="-";
                        }
                        
                        $sendSMSFlag = "";
                        $sendEmailFlag = "";
                        /* sms send start */
                        if(!empty($_POST['mobile_no']))
                        { 
                            $country_code = $this->user->get_contry_code($_POST['county_code']);               
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
                                $message = "Dear ".$_POST['fname']." ".$_POST['lname'].", ";
                                $message .="Following attached link for property as per your requirements: \n";
                                $message .= $reference_no;
                                $message .= " ".$bedroom_detail." Bedrooms ";
                                $message .= $property_category.", ";
                                if($property_type ==1)
                                {
                                    $message .= "Sale \n";
                                }
                                elseif($property_type ==2)
                                {
                                    $message .= "Rent \n";
                                }
                                elseif($property_type ==3)
                                {
                                     $message .= "Sale/Rent \n";
                                }
                                else{
                                    $message .= "- \n";
                                }
                                $message .= $property_link[0];
                                $message .= " For any further info call: 8000 7000";
                                $message .= " Thanks,";
                                $message .= " Monopolion Team";
                                $this->load->library('CMSMS');
                                $sms_res=CMSMS::sendMessage($mobile_code.$_POST['mobile_no'], $message);
                                if(empty($sms_res)){
                                    $sendSMSFlag = "SMS";
                                }
                                $history_text_sms       = $message;
                                $history_subject_sms    = "New Client Inquiry";
                                $history_type_sms       = "SMS";
                                $history_reciever_sms   = $mobile_code.$_POST['mobile_no'];
                                $history_reciever_id_sms    = $customerId;
                                $history_reciever_usertype="1";
                               // $this->inquiry_model->saveSmsEmailHistory($history_text_sms, $history_subject_sms, $history_type_sms, $history_reciever_sms, $history_reciever_id_sms);
                            }
                        }
                        /* sms send end */

                        if(!empty($_POST['email']))
                        {

                            $data = array(
                                'id' =>$customer_uniqueNo,
                                'email'=>$_POST['email'],
                                'fname' =>$_POST['fname'],
                                'lname' =>$_POST['lname'],

                             );
                            $data = array(
                                        'customer_email'=>$_POST['email'],
                                        'customer_name'=>$_POST['fname'].''.$_POST['lname'],
                                        'property_links'=>$property_link,
                                        'property_title'=>$property_title
                                        //'bedroom'=>$bedroom_detail,
                                        //'property_category'=>$property_category,
                                        //'property_type'=>$propety_type
                                    );
                       

                                $this->load->library('email');
                                    
                                $this->email->from('info@monopolion.com', 'monopolin');
                                $this->email->to($_POST['email']);
                                $this->email->cc('info@monopolion.com');
                                $this->email->bcc('info@monopolion.com');
                                $this->email->subject('Your Property Inquiry');
                                $email_layout = $this->load->view('email/multiple_inquiry', $data,TRUE);
                                $this->email->message($email_layout);
                                if($this->email->send()){
                                    $sendEmailFlag = "E-mail";  
                                }

                                // save Customer history
                                $history_text       = $email_layout;
                                $history_subject    = "New Client Inquiry";
                                $history_type       = "E-mail";
                                $history_reciever   = $_POST['email'];
                                $history_reciever_id    = $customerId;
                                $history_reciever_usertype="1";
                                //$this->inquiry_model->saveSmsEmailHistory($history_text, $history_subject, $history_type, $history_reciever, $history_reciever_id);
                                //$this->session->set_flashdata('success', 'Success! Inquiry for the Property sent successfully.!');
                                //redirect('home/property_manage');
                            
                        }
                        if($sendSMSFlag == "SMS" && $sendEmailFlag == "E-mail")
                        {
                            $history_type_sms   = "SMS/E-mail";
                            $history_type       = "SMS/E-mail";

                            // SMS
                            $this->inquiry_model->saveSmsEmailHistory($history_text_sms, $history_subject_sms, $history_type_sms, $history_reciever_sms, $history_reciever_id_sms,$history_reciever_usertype);
                            
                            // Email
                            $this->inquiry_model->saveSmsEmailHistory($history_text, $history_subject, $history_type, $history_reciever, $history_reciever_id,$history_reciever_usertype);
                            $this->session->set_flashdata('success', 'Success! Inquiry for the Property sent successfully. Check your email or SMS!');
                            redirect('home/property_manage');
                            
                        }
                        elseif ($sendSMSFlag == "SMS")
                        {
                            
                            // SMS
                            $this->inquiry_model->saveSmsEmailHistory($history_text_sms, $history_subject_sms, $history_type_sms, $history_reciever_sms, $history_reciever_id_sms,$history_reciever_usertype);
                            
                            $this->session->set_flashdata('success', 'Success! Inquiry for the Property sent successfully. Check SMS!');
                            redirect('home/property_manage');
                        }
                        elseif ($sendEmailFlag == "E-mail")
                        {
                            // Email
                            $this->inquiry_model->saveSmsEmailHistory($history_text, $history_subject, $history_type, $history_reciever, $history_reciever_id,$history_reciever_usertype);
                            $this->session->set_flashdata('success', 'Success! Inquiry for the Property sent successfully. Check your E-mail!');
                            redirect('home/property_manage');      
                        }
                        else{

                            $this->session->set_flashdata('success', 'Success! Inquiry for the Property sent successfully.!');
                            redirect('home/property_manage');
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
   function change_pass_check() {
   
         $user = $this->user->pass_check($_POST);
        //echo'<pre>';print_r($user);exit;
        if(!empty($user)) {
                echo "true";exit;
            }else{
                echo "false";exit;
            }
    }
    function edit_profile() {

        if(!empty($_POST['type'])){

        $deta['user']=$this->user->update_user_profile($_POST['id']);
        if($deta['user'] =='1'){
           
            $sess_array = array(

                    'id' => $_POST['user_id'],
                    'fname' => $_POST['fname'],
                    'lname' => $_POST['lname'],
                    'email' => $_POST['email'],
                    'mobile_no' => $_POST['mobile_no'],
                    'type' => $_POST['type'],
                );
                if($sess_array['type'] =='1'){
                    $this->session->unset_userdata('logged_in_super_user');
                    $this->session->set_userdata('logged_in_super_user', $sess_array);
                }else if($sess_array['type'] =='2') {
                    $this->session->unset_userdata('logged_in_agent');
                    $this->session->set_userdata('logged_in_agent', $sess_array);
                }else{
                    $this->session->unset_userdata('logged_in_employee');
                    $this->session->set_userdata('logged_in_employee', $sess_array);
                }
            }
            redirect('home', 'refresh');
        }
        elseif($this->uri->segment(3)) {
                $id = $this->uri->segment(3);
        $deta['user']=$this->user->get_user_detail($id);

        $this->load->view('edit_profile',$deta);
        }
    }
    function user_email_check() {

        $user = $this->user->user_email_check($_POST);
        
        if(!empty($user)) {
                echo "false";exit;
            }else{
                echo "true";exit;
            }
    }
    function user_mobile_check() {

        $user = $this->user->user_mobile_check($_POST);
        
        if(!empty($user)) {
                echo "false";exit;
            }else{
                echo "true";exit;
            }
    }
     function get_city_area() {
        $this->output->set_content_type('application/json');
        $citydata = $this->user->getallcity_area($_POST['city_id']);
        echo json_encode($citydata);
        exit;
    }
    // function get_city_area(){
    //     $citydata =$this->user->getallcity_area($_POST['city_id']);
    //     $this->output->set_output(json_encode($citydata));
    //     //echo $citydata;exit;
    // }
    function sms_send_mass(){
        $this->load->view('sms_send_mass');
        //echo $citydata;exit;
    }
    function email_send_mass(){
       $this->load->view('email_send_mass');
        //echo $citydata;exit;
    }
    function sms_email_send_history(){
        $this->load->view('sms_email_send_history');
        //echo $citydata;exit;
    }

    function view_property($id){
 
        $property_data['data'] =$this->user->get_property_view_detail_($id);
        $property_data['image'] =$this->user->get_property_view_image($property_data['data'][0]->id);
        $property_data['genral_facilities'] =$this->user->get_genral_facilities($property_data['data'][0]->id);
        $property_data['instrumental_facilities'] =$this->user->get_instrumental_facilities($property_data['data'][0]->id);
        
        if(!empty($property_data['data'][0]->property_type)){ 
        $property_data['property_type']= $this->get_propertytypeby_id($property_data['data'][0]->property_type);
        }else{
            $property_data['property_type']="";
        }
        if(!empty($property_data['data'][0]->architectural_design)){
        $property_data['architectural_design']= $this->get_architectural_design($property_data['data'][0]->architectural_design);  
        }else{
            $property_data['architectural_design']="";
        }
        if(!empty($property_data['data'][0]->room_size)) {  
        $property_data['room_size']= $this->get_room_size_id($property_data['data'][0]->room_size);
        }else{
            $property_data['room_size']="";
        }
       // echo '<pre>';print_r($property_data);exit;
        $this->load->view('view_property_detail',$property_data);
    }
    function get_propertytypeby_id($id)
    {
        
        $data['property_type'] = array('1'=>'Duplex','2' =>'Apartment','3' =>'Penthouse','4' =>'Garden Apartments','5'=>'Studio','6' =>'Townhouse','7' =>'Villa','8' =>'Bungalow','9'=>'Land','10' =>'Shop','11' =>'Office','12' =>'Business','13'=>'Hotel','14' =>'Restaurant','15' =>'Building','16' =>'Industrial estate','17' =>'House','18' =>'Upper-House','19' =>'Maisonette');
        return $data['property_type'][$id];

    }
    function get_architectural_design($id)
    {
        
        $data['get_architectural_design'] = array('1'=>'Contemporary','2' =>'Modern','3' =>'Classic');
        return $data['get_architectural_design'][$id];

    }
    function get_room_size_id($id)
    {
        
        $data['get_room_size_id'] = array('1'=>'Small','2' =>'Medium','3' =>'Large');
        return $data['get_room_size_id'][$id];

    }
     function property_ref_check() {

        $ref_unin = $this->user->property_ref_check($_POST);
        
        if(!empty($ref_unin)) {
                echo "false";exit;
            }else{
                echo "true";exit;
            }
    }
    function error() {
        $this->load->view('error_view');
    }

    function forgote_pass() {
         $this->load->helper(array('form'));

            $this->load->view('forgote_pass');
    }
    function forgote_email_check() {

         $user = $this->user->forgote_email_check($_POST);
        if(!empty($user)) {
                echo "true";exit;
            }else{
                echo "false";exit;
            }
    }
    function logout() {
        $this->session->unset_userdata('logged_in_super_user');
        session_destroy();
        redirect('home', 'refresh');
    }
    function logout_agent() {
        $this->session->unset_userdata('logged_in_agent');
        session_destroy();
        redirect('home', 'refresh');
    }
	function logout_employee() {
		$this->session->unset_userdata('logged_in_employee');

        session_destroy();
        redirect('home', 'refresh');
    }
    function appointment_conform(){
      
            $inquiry_id = $this->uri->segment(3);
            $agent_id = $this->uri->segment(4);
           
            $aget_record = $this->inquiry_model->get_aget_record($agent_id);
            $aget_data = $this->inquiry_model->check_agent_appointment($agent_id,$inquiry_id);
            if(!empty($aget_data))
            {
            if($aget_data[0]->id == $inquiry_id)
            {
                $inquiry_data = $this->inquiry_model->update_agent_appointment($agent_id,$inquiry_id);
                if($inquiry_data ==1)
                {
                $inquiry_detail = $this->inquiry_model->get_inquiry_data($inquiry_id);
                
                $agentcountry_code = $this->user->get_contry_code($inquiry_detail[0]->coutry_code);               
                $sendSMSFlag = "";
                $sendEmailFlag = "";
                
                if(!empty($agentcountry_code))
                {    
                    $agentmcode = substr($agentcountry_code[0]->prefix_code, 1);
                    $agentmobile_code="00".$agentmcode;
                //     $agentcount_mcode = strlen($agentmcode);
                //     if($agentcount_mcode < 2 ){
                //         $agentmobile_code = '000'.$agentmcode;
                //     }elseif($agentcount_mcode < 3 ){
                //         $agentmobile_code = '00'.$agentmcode;
                //     }
                //     elseif($agentcount_mcode < 4 ){
                //         $agentmobile_code = '0'.$agentmcode;
                //     }else{
                //         $agentmobile_code = $agentmcode;
                //     }
                }else{
                    $agentmobile_code = "0000";
                }

                $country_code = $this->user->get_contry_code($inquiry_detail[0]->coutry_code);               
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
                    $message = "Dear ".$inquiry_detail[0]->fname." ".$inquiry_detail[0]->lname.",";
                    $message .= " your request for appointment on.".$inquiry_detail[0]->appoint_start_date.' to '.$inquiry_detail[0]->appoint_end_date;
                    $message .=" for the property with Reference No:".$inquiry_detail[0]->property_ref_no." has been CONFIRMED!";
                    $message .= " For any further info for the specific property kindly contact";
                    $message .= " our Agent, ".$aget_record[0]->fname.' '.$aget_record[0]->lname.', +'.$agentmobile_code.$aget_record[0]->mobile_no.' or  8000 7000 ';
                    
                    $this->load->library('CMSMS');
                    $sms_res=CMSMS::sendMessage($mobile_code.$inquiry_detail[0]->mobile_no, $message);
                     if(empty($sms_res)){
                            $sendSMSFlag = "SMS";
                        }

                    $history_text_sms       = $message;
                    $history_subject_sms    = "Agent Confirm Your Appointment";
                    $history_type_sms       = "SMS";
                    $history_reciever_sms   = $mobile_code.$inquiry_detail[0]->mobile_no;
                    $history_reciever_id_sms    = $inquiry_detail[0]->id;
                    $history_reciever_usertype="1";

                    //$this->inquiry_model->saveSmsEmailHistory($history_text_sms, $history_subject_sms, $history_type_sms, $history_reciever_sms, $history_reciever_id_sms);
                }
                if(!empty($inquiry_detail[0]->email))
                {

                    $data = array(
                                  'customer_name'=>$inquiry_detail[0]->fname.' '.$inquiry_detail[0]->lname,
                                  'appointment_start'=>$inquiry_detail[0]->appoint_start_date,
                                  'appointment_end'=>$inquiry_detail[0]->appoint_end_date,
                                  'property_ref_no'=>$inquiry_detail[0]->property_ref_no,
                                  'agent_name'=>$aget_record[0]->fname.' '.$aget_record[0]->lname,
                                  'agent_mobile'=>$agentmobile_code.$aget_record[0]->mobile_no
                                 );
                       
                        if(!empty($customer_detail[0]->email))
                        {
                            $this->load->library('email');
                            $this->email->from('info@monopolion.com', 'monopolion');
                            $this->email->to($inquiry_detail[0]->email);
                            $this->email->cc('info@monopolion.com');
                            $this->email->bcc('info@monopolion.com');
                            $this->email->subject('Agent Confirm Your Appointment');
                            $email_layout = $this->load->view('email/appointment_confirm', $data,TRUE);
                            $this->email->message($email_layout);
                            if($this->email->send())
                            {
                                $sendEmailFlag = "E-mail";   
                            }

                            // save Customer history
                            $history_text       = $email_layout;
                            $history_subject    = "Agent Confirm Your Appointment";
                            $history_type       = "E-mail";
                            $history_reciever   = $inquiry_detail[0]->email;
                            $history_reciever_id    = $inquiry_detail[0]->id;
                            $history_reciever_usertype="1";
                            //$this->inquiry_model->saveSmsEmailHistory($history_text, $history_subject, $history_type, $history_reciever, $history_reciever_id);
                        }
                }
                if($sendSMSFlag == "SMS" && $sendEmailFlag == "E-mail")
                {
                    $history_type_sms   = "SMS/E-mail";
                    $history_type       = "SMS/E-mail";

                    // SMS
                    $this->inquiry_model->saveSmsEmailHistory($history_text_sms, $history_subject_sms, $history_type_sms, $history_reciever_sms, $history_reciever_id_sms,$history_reciever_usertype);
                    
                    // Email
                    $this->inquiry_model->saveSmsEmailHistory($history_text, $history_subject, $history_type, $history_reciever, $history_reciever_id,$history_reciever_usertype);
                    
                }
                elseif ($sendSMSFlag == "SMS")
                {
                    // SMS
                    $this->inquiry_model->saveSmsEmailHistory($history_text_sms, $history_subject_sms, $history_type_sms, $history_reciever_sms, $history_reciever_id_sms,$history_reciever_usertype);
                    
                }
                elseif ($sendEmailFlag == "E-mail")
                {
                    // Email
                    $this->inquiry_model->saveSmsEmailHistory($history_text, $history_subject, $history_type, $history_reciever, $history_reciever_id,$history_reciever_usertype);
                }

                    echo "Your Appointment Confirm....."; 
                }else{
                    echo "Your are Not Authorize to Confirm Appointment.....";
                }
            }else{
                echo "Your are Not Authorize to Confirm Appointment.....";
                } 
            }    
    }
}

?>