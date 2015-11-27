<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

//session_start(); //we need to call PHP's session object to access it through CI

class Verification extends CI_Controller {

    function __construct() {
        parent::__construct();
       $this->load->helper(array('form', 'url'));
       $this->load->model('inquiry_model', '', TRUE);
	   $this->load->model('user', '', TRUE);
       $this->load->library('image_lib');
    }

    function index() {
        if ($this->session->userdata('logged_in_super_user')) {
            //$data['category'] = $this->user->getCategoryTotal();
            //$data['ingredient'] = $this->user->getIngredientTotal();
            //$data['dishes'] = $this->user->getDishTotal();
            //$data['ads'] = $this->user->getAdsTotal();
            //$data['greetings'] = $this->user->getGreetingsTotal();
			$data[] = "";
			
            $this->load->view("home_view", $data);
        } else {
            //If no session, redirect to login page
            redirect('login', 'refresh');
        }
    }
    function search_property() {
                //$this->load->helper(array('form'));
         $this->load->model('inquiry_model', '', TRUE);
         
        /*$this->load->library('form_validation');
        $this->form_validation->set_rules('location', 'location', 'trim|required|xss_clean');
        $this->form_validation->set_rules('city', 'city', 'trim|required|xss_clean');
        $this->form_validation->set_rules('city_area', 'city_area', 'trim|required|xss_clean');
        $this->form_validation->set_rules('criteria', 'criteria', 'trim|required|xss_clean');
        $this->form_validation->set_rules('property_category', 'property_category', 'trim|required|xss_clean');
        $this->form_validation->set_rules('min_price', 'min_price', 'trim|required|xss_clean');
        $this->form_validation->set_rules('max_price', 'max_price', 'trim|required|xss_clean');
        $this->form_validation->set_rules('bedroom', 'bedroom', 'trim|required|xss_clean');
        $this->form_validation->set_rules('bathroom', 'bathroom', 'trim|required|xss_clean');
        $this->form_validation->set_rules('reference_no', 'reference_no', 'trim|required|xss_clean');
        $this->load->helper('form');
        
        if ($this->form_validation->run() == FALSE) {
            
            $this->load->view('search_property_view');
        }*/           if(!empty($_POST)){

                $data['bedroom'] = array('0' =>0,'1'=>1,'2' =>2,'3' =>3,'4' =>4,'5' =>5,'6' =>6);
                $data['bathroom'] = array('0' =>0,'1'=>1,'2' =>2,'3' =>3,'4' =>4,'5' =>5,'6' =>6);
                $data['bedroom'] = array('0' =>0,'1'=>1,'2' =>2,'3' =>3,'4' =>4,'5' =>5,'6' =>6);
                $data['category'] = array('0' =>"abc",'1'=>"fdgabc",'2' =>"xcbv",'3' =>"jkdfj",'4' =>"rwr",'5' =>"fhf",'6' =>"ssdf");
                $data['search_detail'] = $this->inquiry_model->getrelated_property($_POST);
                
                $this->load->view('search_property_view', $data);
                }else{
                $data['bedroom'] = array('0' =>0,'1'=>1,'2' =>2,'3' =>3,'4' =>4,'5' =>5,'6' =>6);
                $data['bathroom'] = array('0' =>0,'1'=>1,'2' =>2,'3' =>3,'4' =>4,'5' =>5,'6' =>6);
                $data['bedroom'] = array('0' =>0,'1'=>1,'2' =>2,'3' =>3,'4' =>4,'5' =>5,'6' =>6);
                $data['category'] = array('0' =>"abc",'1'=>"fdgabc",'2' =>"xcbv",'3' =>"jkdfj",'4' =>"rwr",'5' =>"fhf",'6' =>"ssdf");
                $data['search_detail']=array();  
                $this->load->view('search_property_view', $data);  
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
    function new_client_customer_details() {
           //$this->load->model('inquiry_model', '', TRUE);
            $usrid = $this->input->post('id');
            $aquired = $this->input->post('aquired');
            $this->load->helper('form');
        
            if($usrid=="") {
                
                $unic =$this->unic_num(); 
                $email  = $this->input->post('email');
                $fname  = $this->input->post('fname');  
                $lname  = $this->input->post('lname');    
                
                if ($query = $this->user->customer_insert($unic)) {
                $this->session->set_userdata('customer_property_id', $query);
                $this->session->set_userdata('customer_property_buy_sale', $aquired);
                
                $inquiry_num =$this->unic_inquiry_num();
                $property_buy_sale = $this->session->userdata('customer_property_buy_sale');
                $insert_customer_inquiry = $this->inquiry_model->new_customer_inquiry_insert($query,$inquiry_num,$property_buy_sale);
                 if($insert_customer_inquiry && !empty($email)){
                    include APPPATH . 'third_party/Classes/Mailchimp.php';
                    $apikey = "cfd5c04a3ac23d934368362c187700c4-us3";
                    $unique_id = time() . '_' . rand(1000, 9999) . '_' . rand(1000, 9999);
                    $mc = new Mailchimp($apikey);
                    $list_id = 'd42363dd0e';
                    $merge_vars = array();
                    $merge_vars['FNAME'] = $fname;
                    $merge_vars['LNAME'] = $lname;
                    $merge_vars['groupings'] = array(
                        array(
                            'id' => '16389',
                            'groups' => array('4')
                        ),
                        array(
                            'id' => '16393',
                            'groups' => array($property_buy_sale)
                        ),
                    );
                    @$mc->lists->subscribe($list_id,array('email'=>$email),$merge_vars,'html',FALSE,true);
                }

                $sendSMSFlag = "";
                $sendEmailFlag = "";
                $history_type_sms="";
                $history_type="";
                /* sms send start */
                if(!empty($_POST['mobile_no']))
                {
                    $country_code = $this->user->get_contry_code($_POST['county_code']);               
                    if(!empty($country_code)){    
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

                        $message = "Dear ".$fname." ".$lname.",";
                        $message .= " Welcome and Thank you for choosing our company to find your ideal property.";
                        $message .= " Your Customer ID:".$unic;
                        $message .= " For any further information please call: 8000 7000";
                        
                        $this->load->library('CMSMS');
                        $sms_res=CMSMS::sendMessage($mobile_code.$_POST['mobile_no'], $message);
                        if(empty($sms_res))
                        {
                            $sendSMSFlag = "SMS";
                        }

                        $history_text_sms       = $message;
                        $history_subject_sms    = "Welcome to Monopolion System";
                        $history_type_sms       = "SMS";
                        $history_reciever_sms   = $mobile_code.$_POST['mobile_no'];
                        $history_reciever_id_sms    = $query;
                        $history_reciever_usertype_sms ="1";
                        // $this->inquiry_model->saveSmsEmailHistory($history_text_sms, $history_subject_sms, $history_type_sms, $history_reciever_sms, $history_reciever_id_sms);
                    }
                }
                /* sms send end */

                $id = $unic;
                 $data = array(
                            'id' =>$id,
                            'email'=>$email,
                            'fname' =>$fname,
                            'lname' =>$lname,
                            );
                if(!empty($email))
                {
                    $this->load->library('email');
                    $this->email->from('info@monopolion.com', 'monopolion');
                    $this->email->to($email);
                    $this->email->cc('another@another-example.com');
                    $this->email->bcc('them@their-example.com');
                    $this->email->subject('Welcome to Monopolion System');
                    $email_layout = $this->load->view('email/inquiry_email', $data,TRUE);
                    $this->email->message($email_layout);
                    if($this->email->send())
                    {
                        $sendEmailFlag = "E-mail";   
                    }
                    
                    // Save to sms_email history table
                    $history_text       = $email_layout;
                    $history_subject    = "Welcome to Monopolion System";
                    $history_type       = "E-mail";
                    $history_reciever   = $email;
                    $history_reciever_id    = $query;
                    $history_reciever_usertype ="1";

                    // $this->inquiry_model->saveSmsEmailHistory($history_text, $history_subject, $history_type, $history_reciever, $history_reciever_id);
                    //  $this->session->set_flashdata('success', 'Mail sent successfull Please check Your Email.');
                }
                if($sendSMSFlag == "SMS" && $sendEmailFlag == "E-mail")
                {
                    $history_type_sms   = "SMS/E-mail";
                    $history_type       = "SMS/E-mail";

                    // SMS
                    $this->inquiry_model->saveSmsEmailHistory($history_text_sms, $history_subject_sms, $history_type_sms, $history_reciever_sms, $history_reciever_id_sms,$history_reciever_usertype_sms);
                    
                    // Email
                    $this->inquiry_model->saveSmsEmailHistory($history_text, $history_subject, $history_type, $history_reciever, $history_reciever_id,$history_reciever_usertype);

                    $this->session->set_flashdata('success', 'Mail sent successfull Please check Your Email.');
                redirect('/inquiry/property', 'refresh');
                }
                elseif ($sendSMSFlag == "SMS")
                {
                    
                    // SMS
                    $this->inquiry_model->saveSmsEmailHistory($history_text_sms, $history_subject_sms, $history_type_sms, $history_reciever_sms, $history_reciever_id_sms,$history_reciever_usertype_sms);

                    $this->session->set_flashdata('success', 'SMS sent successfull Please check Your SMS.');
                    redirect('/inquiry/property', 'refresh');
                }
                elseif ($sendEmailFlag == "E-mail")
                {
                    // Email
                    $this->inquiry_model->saveSmsEmailHistory($history_text, $history_subject, $history_type, $history_reciever, $history_reciever_id,$history_reciever_usertype);

                    $this->session->set_flashdata('success', 'Mail sent successfull Please check Your Email.');
                    redirect('/inquiry/property', 'refresh');
      
                }else{
                    $this->session->set_flashdata('success', 'E-mail and SMS not send beacuse somethig wrong');
                    redirect('/inquiry/property', 'refresh');
                }
                
            } else {
                $this->load->view('add_new_client', array('error' => ''));
            }
            } 
        }
    function unic_num() {
        $num = rand(10000000,99999999);

        $unic_number = $this->user->check_unic_num($num);

                if(!empty($unic_number)){
                   $this->unic_num();
                }else{
                   return $num;
                   
                }
        
    }
    function create_agent() {
           //echo'<pre>';print_r($_POST);exit;
        $id = $this->input->post('id');
        
       
            if($id=="") {
                
                if ($query = $this->user->agent_insert()) {
                    $fname = $this->input->post('fname');
                    $lname = $this->input->post('lname');
                    $email = $this->input->post('email');
                    $type = $this->input->post('type');
                    if(!empty($email)){
                    include APPPATH . 'third_party/Classes/Mailchimp.php';
                    $apikey = "cfd5c04a3ac23d934368362c187700c4-us3";
                    $unique_id = time() . '_' . rand(1000, 9999) . '_' . rand(1000, 9999);
                    $mc = new Mailchimp($apikey);
                    $list_id = 'd42363dd0e';
                    $merge_vars = array();
                    $merge_vars['FNAME'] = $fname;
                    $merge_vars['LNAME'] = $lname;
                    $merge_vars['groupings'] = array(
                        array(
                            'id' => '16389',
                            'groups' => array($type)
                        ),
                        array(
                            'id' => '16393',
                            'groups' => array('none')
                        ),
                    );
                    @$mc->lists->subscribe($list_id,array('email'=>$email),$merge_vars,'html',FALSE,true);
                    }
                    $this->session->set_flashdata('success', 'Agent added successfully.');
                    redirect('/home/agent_manage', 'refresh');
                   
                } else {
                    $this->load->view('add_agent_view', array('error' => ''));
                }
            } else { 
            
                if ($query = $this->user->agent_update($id)) {
                    $this->session->set_flashdata('success', 'Agent updated successfully.');
                    $url = "/home/agent_manage/";
                    redirect($url, 'refresh');
                } else {
                    $this->load->view('add_agent_view', array('error' => ''));
                }
            }
        
    }
    function create_customer() {
           
        $id = $this->input->post('id');
        
        
            if($id=="") {
                $unic =$this->unic_num();

                if ($query = $this->user->customer_insert($unic)) {
                $id = $unic;
                $email  = $this->input->post('email');
                $fname  = $this->input->post('fname');  
                $lname  = $this->input->post('lname');    
                $aquired = $this->input->post('aquired');
                if(!empty($email)){
                include APPPATH . 'third_party/Classes/Mailchimp.php';
                $apikey = "cfd5c04a3ac23d934368362c187700c4-us3";
                $unique_id = time() . '_' . rand(1000, 9999) . '_' . rand(1000, 9999);
                $mc = new Mailchimp($apikey);
                $list_id = 'd42363dd0e';
                $merge_vars = array();
                $merge_vars['FNAME'] = $fname;
                $merge_vars['LNAME'] = $lname;
                $merge_vars['groupings'] = array(
                    array(
                        'id' => '16389',
                        'groups' => array('4')
                    ),
                    array(
                        'id' => '16393',
                        'groups' => array($aquired)
                    ),
                );
                @$mc->lists->subscribe($list_id,array('email'=>$email),$merge_vars,'html',FALSE,true);
                }
                $sendSMSFlag = "";
                $sendEmailFlag = "";
                /* sms send start */
                if(!empty($_POST['mobile_no']))
                {
                     $country_code = $this->user->get_contry_code($_POST['county_code']);               
                     if(!empty($country_code)){
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
                        
                        $message = "Dear ".$fname." ".$lname.",";
                        $message .= " Welcome and Thank you for choosing our company to find your ideal property.";
                        $message .= " Your Customer ID:".$unic;
                        $message .= " For any further information please call: 8000 7000\n";
                        
                        $this->load->library('CMSMS');
                        $sms_res=CMSMS::sendMessage($mobile_code.$_POST['mobile_no'], $message);
                        
                        if(empty($sms_res)){
                            $sendSMSFlag = "SMS";
                        }

                        /* sms send end */

                        $history_text_sms       = $message;
                        $history_subject_sms    = "Welcome to Monopolion System";
                        $history_type_sms       = "SMS";
                        $history_reciever_sms   = $mobile_code.$_POST['mobile_no'];
                        $history_reciever_id_sms    = $query;
                        $history_reciever_usertype_sms="1";
                        //$this->inquiry_model->saveSmsEmailHistory($history_text_sms, $history_subject_sms, $history_type_sms, $history_reciever_sms, $history_reciever_id_sms);
                    }
                }   
                
                 $data = array(
                            'id' =>$id,
                            'email'=>$email,
                            'fname' =>$fname,
                            'lname' =>$lname,
                            );    
                    if(!empty($email))
                    {
                        $this->load->library('email');
                        $this->email->from('info@monopolion.com', 'monopolion');
                        $this->email->to($email);
                        $this->email->cc('info@monopolion.com');
                        $this->email->bcc('info@monopolion.com');
                        $this->email->subject('Welcome to Monopolion System');
                        $email_layout = $this->load->view('email/inquiry_email', $data,TRUE);
                        $this->email->message($email_layout);
                        if($this->email->send())
                        {
                            $sendEmailFlag = "E-mail";   
                        }
                        // Save to sms_email history table
                        $history_text       = $email_layout;
                        $history_subject    = "Welcome to Monopolion System";
                        $history_type       = "E-mail";
                        $history_reciever   = $email;
                        $history_reciever_id    = $query;
                        $history_reciever_usertype ="1";

                        //$this->inquiry_model->saveSmsEmailHistory($history_text, $history_subject, $history_type, $history_reciever, $history_reciever_id);
                    }   
                if($sendSMSFlag == "SMS" && $sendEmailFlag == "E-mail")
                {
                    $history_type_sms   = "SMS/E-mail";
                    $history_type       = "SMS/E-mail";

                    // SMS
                    $this->inquiry_model->saveSmsEmailHistory($history_text_sms, $history_subject_sms, $history_type_sms, $history_reciever_sms, $history_reciever_id_sms,$history_reciever_usertype_sms);
                    
                    // Email
                    $this->inquiry_model->saveSmsEmailHistory($history_text, $history_subject, $history_type, $history_reciever, $history_reciever_id,$history_reciever_usertype);
                    $this->session->set_flashdata('success', 'Client added successfull. check your E-mail or SMS');
                    redirect('/home/customer_manage', 'refresh');
                }
                elseif ($sendSMSFlag == "SMS")
                {
                    
                    // SMS
                    $this->inquiry_model->saveSmsEmailHistory($history_text_sms, $history_subject_sms, $history_type_sms, $history_reciever_sms, $history_reciever_id_sms,$history_reciever_usertype_sms);
                    
                    $this->session->set_flashdata('success', 'Client added successfull. check SMS');
                    redirect('/home/customer_manage', 'refresh');
                }
                elseif ($sendEmailFlag == "E-mail")
                {
                    // Email
                    $this->inquiry_model->saveSmsEmailHistory($history_text, $history_subject, $history_type, $history_reciever, $history_reciever_id,$history_reciever_usertype);
                    
                    $this->session->set_flashdata('success', 'Client added successfull. check your E-mail');
                    redirect('/home/customer_manage', 'refresh');      
                }else{
                    $this->session->set_flashdata('success', 'E-mail and SMS not send beacuse somethig wrong');
                    redirect('/home/customer_manage', 'refresh'); 
                }
                        //$this->session->set_flashdata('success', 'Client added successfull.');
                        //redirect('/home/customer_manage', 'refresh');
                } else {
                    $this->load->view('add_customer_view', array('error' => ''));
                }
            } else { 
            
                if ($query = $this->user->customer_update($id)) {
                    $this->session->set_flashdata('success', 'Client updated successfull.');
                    $url = "/home/customer_manage/";
                    redirect($url, 'refresh');
                } else {
                    $this->load->view('add_customer_view', array('error' => ''));
                }
            }
        /*}*/
    }
    function create_employee() {
           
        $id = $this->input->post('id');
        
            if($id=="") {
                
                if ($query = $this->user->agent_insert()) {
                    $fname = $this->input->post('fname');
                    $lname = $this->input->post('lname');
                    $email = $this->input->post('email');
                    $type = $this->input->post('type');
                    if(!empty($email)){
                    include APPPATH . 'third_party/Classes/Mailchimp.php';
                    $apikey = "cfd5c04a3ac23d934368362c187700c4-us3";
                    $unique_id = time() . '_' . rand(1000, 9999) . '_' . rand(1000, 9999);
                    $mc = new Mailchimp($apikey);
                    $list_id = 'd42363dd0e';
                    $merge_vars = array();
                    $merge_vars['FNAME'] = $fname;
                    $merge_vars['LNAME'] = $lname;
                    $merge_vars['groupings'] = array(
                        array(
                            'id' => '16389',
                            'groups' => array($type)
                        ),
                        array(
                            'id' => '16393',
                            'groups' => array('none')
                        ),
                    );
                    @$mc->lists->subscribe($list_id,array('email'=>$email),$merge_vars,'html',FALSE,true);
                    }
                    $this->session->set_flashdata('success', 'Employee added successfull.');
                    redirect('/home/employee_manage', 'refresh');
                } else {
                    $this->load->view('add_employee_view', array('error' => ''));
                }
            } else { 
            
                if ($query = $this->user->agent_update($id)) {
                    $this->session->set_flashdata('success', 'Employee updated successfull.');
                    $url = "/home/employee_manage/";
                    redirect($url, 'refresh');
                } else {
                    $this->load->view('add_employee_view', array('error' => ''));
                }
            }
      /*  }*/
    }
    // function create_property() {
    //     //echo'<pre>';print_r($_FILES);exit;
    //     $this->load->helper('form');
    //     $this->load->library('form_validation');
        

    //         $name_array = array();
    //         $count = count($_FILES['identity_check_img']['size']);
    //         foreach($_FILES as $key=>$value)
    //             for($s=0; $s<=$count-1; $s++) {
    //             $_FILES['userfile']['name']=$value['name'][$s];
    //             $_FILES['userfile']['type']    = $value['type'][$s];
    //             $_FILES['userfile']['tmp_name'] = $value['tmp_name'][$s];
    //             $_FILES['userfile']['error']       = $value['error'][$s];
    //             $_FILES['userfile']['size']    = $value['size'][$s];  
    //             $config['upload_path'] = APPPATH . '../upload/property/';
    //             $config['allowed_types'] = 'gif|jpg|png';
    //             $this->load->library('upload', $config);
    //             $this->upload->initialize($config);
    //             $data=$this->upload->do_upload();
    //             $data = $this->upload->data();
               
    //             $name_array[] = $data['file_name'];
    //             }
    //         $names= implode(',', $name_array);
    //         /* $this->load->database();
    //         $db_data = array('id'=> NULL,
    //         'name'=> $names);
    //         $this->db->insert('testtable',$db_data);
    //         */  print_r($names);EXIT;
    //         }


    //     $image_path = APPPATH . '../upload/property/';
    //     $config['upload_path'] = $image_path;
    //     $config['allowed_types'] = 'gif|jpg|png';
    //     $this->load->library('upload', $config);
    //     $this->upload->initialize($config);
    //     $error['upload_data'] = '';
    //     $id = $this->input->post('property_id');
    //     $old_img = $this->input->post('old_img');
    //     if (!$this->upload->do_upload('image')) {
    //         if($id=="") {
    //             $error = array('msg' => $this->upload->display_errors());
    //             $imageName = '';
    //         } else { 
    //             $error = array('msg' => "Upload success!");
    //             $imageName = $old_img;
    //         }
    //     } else {
    //        $error = array('msg' => "Upload success!");
    //        $error['upload_data'] = $this->upload->data();
    //        $imageName = $error['upload_data']['file_name'];
    //     }
       
    //    if (empty($imageName)) {
    //         $this->load->view('add_property_view', $error);
    //     } else {
    //         if($id=="") {
                
    //             if ($query = $this->user->property_insert($imageName)) {                 
    //                 $this->session->set_flashdata('success', 'Property added successfully.');
    //                       $id = $query;
    //                       $url = "/home/property_manage/";
    //                 redirect($url , 'refresh');
    //             } else {
    //                 $this->load->view('add_property_view', array('error' => ''));
    //             }
    //         } else {
    //             if ($query = $this->user->property_update($imageName,$id)) {
    //                 $this->session->set_flashdata('success', 'Property updated successfully.');
    //                 $url = "/home/property_manage/";
    //                 redirect($url, 'refresh');         
    //             } else {
    //                 $this->load->view('add_store_view', array('error' => ''));
    //             }
    //         }
    //     }
    // }
     function create_property() {
       
       //echo'<pre>';print_r($_POST);exit;
        $this->load->helper('form');
        $this->load->library('form_validation');
        
        //$image_path = APPPATH . '../upload/property/';
        //$config['upload_path'] = $image_path;
        //$config['allowed_types'] = 'gif|jpg|png';
        //$this->load->library('upload', $config);
        //$this->upload->initialize($config);
        //$error['upload_data'] = '';
        $id = $this->input->post('property_id');
        //$old_img = $this->input->post('old_img');
        //if (!$this->upload->do_upload('image')) {
          //  if($id=="") {
            //    $error = array('msg' => $this->upload->display_errors());
             //   $imageName = '';
            //} else { 
              //  $error = array('msg' => "Upload success!");
               // $imageName = $old_img;
            //}
        // } else {

        //    $error = array('msg' => "Upload success!");
        //    $error['upload_data'] = $this->upload->data();
        //    $imageName = $error['upload_data']['file_name'];
        //     $configSize1['image_library']   = 'gd2';
        //     $configSize1['source_image']    = APPPATH . '../upload/property/'.$imageName;
        //     //$configSize1['create_thumb']    = TRUE;
        //     $configSize1['maintain_ratio']  = false;
        //     $configSize1['width']           = 100;
        //     $configSize1['height']          = 100;
        //     $configSize1['new_image']       = APPPATH . '../upload/property/100x100/';

        //     $this->image_lib->initialize($configSize1);
        //     $this->image_lib->resize();
        //     $this->image_lib->clear();

        //     $configSize1['image_library']   = 'gd2';
        //     $configSize1['source_image']    = APPPATH . '../upload/property/'.$imageName;
        //     //$configSize1['create_thumb']    = TRUE;
        //     $configSize1['maintain_ratio']  = false;
        //     $configSize1['width']           = 200;
        //     $configSize1['height']          = 200;
        //     $configSize1['new_image']       = APPPATH . '../upload/property/200x200/';
        //     $this->image_lib->initialize($configSize1);
        //     $this->image_lib->resize();
        //     $this->image_lib->clear();
        // }
       
       // if (empty($imageName)) {
       //      $this->load->view('add_property_view', $error);
       //  } else {
            if($id=="") {
                
                if ($query = $this->user->property_insert()) {    
                          $property_imageid = explode(',', $_POST['property_imageid']);
                $cou = 1;
               foreach ($property_imageid as $prop_imgkey => $prop_imgvalue) {
                  if (!empty($prop_imgvalue)) {
                   
                    $prop_imgdata = array('image' => $prop_imgvalue, 'prop_id' => $query, 'order' => $cou);
                    $this->user->propertyadd_image($prop_imgdata,$this->session->userdata('img_tocken'));
                  }
                  $cou++;
               }                      
                    // if($_POST['pro_add'] =="Add Property"){
                    //     $this->session->set_flashdata('success', 'Property added successfull.');
                    //     $url = "/home/property_manage/";
                    //     redirect($url , 'refresh');
                    // }else{

                        //$url = "/home/propertyExatraImages/".$query;
                         $url = "/home/property_manage/";
                        redirect($url , 'refresh');
                    //}
                } else {
                    $this->load->view('add_property_view', array('error' => ''));
                }
            } else {
                if ($query = $this->user->property_update($id)) {
                    
                    // if($_POST['pro_up'] =="Update Property"){
                    //     $this->session->set_flashdata('success', 'Property updated successfull.');
                    //     $url = "/home/property_manage/";
                    //     redirect($url, 'refresh');
                    // }else{
                        // $url = "/home/propertyExatraImages/".$id;
                        $url = "/home/property_manage/";
                        redirect($url, 'refresh');
                    //}         
                } else {
                    $this->load->view('add_store_view', array('error' => ''));
                }
            }
       // }
    }
    
    function change_password()
    {
    	
    	$this->load->library('form_validation');
      	$new_pass = $this->input->post('new_password');
        $id = $this->input->post('change_pass_id');
		//echo $new_pass;exit; 
		$this->load->helper('form');
		
			if($new_pass!="") {
				if ($query = $this->user->change_password($id, $new_pass)) {
					$this->session->set_flashdata('pass_change_success', 'Your Password was successfull changed.');
					redirect('/home/change_password', 'refresh');
				} else {
					$this->load->view('change_password_view');
				}
			} else {
				$this->load->view('change_password_view');
		}
	}
    function forgote_password()
    {
                $this->load->helper('form');
                $this->load->library('form_validation');
                $new_pass = $this->input->post('new_password');
                $email = $this->input->post('email');
                $password ='monopolion'.rand(100,999);
                $query = $this->user->change_password(MD5($password), $email);
                $this->load->library('email');
                /*$this->email->initialize(array(
                  'protocol' => 'smtp',
                  'smtp_host' => 'smtp.sendgrid.net',
                  'smtp_user' => 'sendgridusername',
                  'smtp_pass' => 'sendgridpassword',
                  'smtp_port' => 587,
                  'crlf' => "\r\n",
                  'newline' => "\r\n"
                ));*/

                $this->email->from('info@monopolion.com', 'monopolion');
                $this->email->to($email);
                $this->email->cc('info@monopolion.com');
                $this->email->bcc('info@monopolion.com');
                $this->email->subject('Your new password');
                //$email = $this->load->view('email/inquiry_email', $data,TRUE);
                $this->email->message($password);
                $this->email->send();
                
                // Save to sms_email history table
                $history_text       = $password;
                $history_subject    = "Your new password";
                $history_type       = "Email";
                $history_reciever   = $email;
                $history_reciever_id    = $query;

                $this->inquiry_model->saveSmsEmailHistory($history_text, $history_subject, $history_type, $history_reciever, $history_reciever_id);
                           
                    $this->session->set_flashdata('success', 'your new password send in your email successfull.');
                    redirect('home/forgote_pass', 'refresh');
        
        
        //     if($new_pass!="") {
        //         if ($query = $this->user->forgote_password($email, $new_pass)) {
        //             $this->session->set_flashdata('pass_change_success', 'Your Password was successfully changed.');
        //             redirect('/login/', 'refresh');
        //         } else {
        //             $this->load->view('forgote_pass');
        //         }
        //     } else {
        //         $this->load->view('forgote_pass');
        // }
    }
    
}

?>