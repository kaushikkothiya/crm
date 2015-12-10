<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
session_start(); //we need to call PHP's session object to access it through CI

class Home extends MY_Controller {

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

            $data['employee'] = $this->user->getEmployeeTotal();

            $data['customer'] = $this->user->getCustomerTotal();

            $data['inquiry'] = $this->user->getInquiryTotal();

            $data['property'] = $this->user->getPropertyTotal();
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

            if ($this->uri->segment(3)) {
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

        if (!empty($user)) {
            echo "false";
            exit;
        } else {
            echo "true";
            exit;
        }
    }

    function agent_mobile_check() {


        $user = $this->user->agent_mobile_check($_POST);

        if (!empty($user)) {
            echo "false";
            exit;
        } else {
            echo "true";
            exit;
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

            if ($this->uri->segment(3)) {
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

        if (!empty($user)) {
            echo "false";
            exit;
        } else {
            echo "true";
            exit;
        }
    }

    function customer_mobile_check() {

        $user = $this->user->customer_mobile_check($_POST);

        if (!empty($user)) {
            echo "false";
            exit;
        } else {
            echo "true";
            exit;
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

            if ($this->uri->segment(3)) {
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

        if (!empty($user)) {
            echo "false";
            exit;
        } else {
            echo "true";
            exit;
        }
    }

    function employee_mobile_check() {

        $user = $this->user->employee_mobile_check($_POST);

        if (!empty($user)) {
            echo "false";
            exit;
        } else {
            echo "true";
            exit;
        }
    }

//employee manage end //
//property manage start //
    function property_manage() {
        if ($this->session->userdata('logged_in_super_user') || $this->session->userdata('logged_in_agent') || $this->session->userdata('logged_in_employee')) {

            if (!empty($_GET['view_agent'])) {
                $prop_view = $_GET['view_agent'];
            } else {
                $prop_view = '';
            }
            $data['user'] = $this->user->getAllproperty($prop_view);

            foreach ($data['user'] as $key => $value) {
                $data['user'][$key]->extra_image = $this->user->getAllproperty_image($value->id);
            }
            $data['city'] = $this->inquiry_model->getAllcity();
            $data['agent'] = $this->inquiry_model->getAllpropertyAgent();
            $data['city_area'] = $this->inquiry_model->getAllcity_area();
            $data['bedroom'] = array('1' => 1, '2' => 2, '3' => 3, '4' => 4, '5' => 5, '6' => 6);
            $data['bathroom'] = array('1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5', '6' => '6', '7' => '7');
            $data['bedroom'] = array('1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5', '6' => '6', '7' => '7');
            $data['category'] = array('0' => ' [Select all]', '1' => 'Duplex', '2' => 'Apartment', '3' => 'Penthouse', '4' => 'Garden Apartments', '5' => 'Studio', '6' => 'Townhouse', '7' => 'Villa', '8' => 'Bungalow', '9' => 'Land', '10' => 'Shop', '11' => 'Office', '12' => 'Business', '13' => 'Hotel', '14' => 'Restaurant', '15' => 'Building', '16' => 'Industrial estate', '17' => 'House', '18' => 'Upper-House', '19' => 'Maisonette');

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

            if ($this->uri->segment(3)) {
                $id = $this->uri->segment(3);
                $data['user'] = $this->user->get_property($id);
                $data['facility_id'] = $this->user->get_property_related_facility($id);

                $data['prop_img'] = $this->user->get_property_image($id);

                //echo'<pre>';print_r($data);exit;
                //$data['orderdetail'] = $this->user->getAllUserOrderDetail($usrid);
                $this->load->view('add_property_view', $data);
            } else {
                // $this->load->library('googlemaps');
                // //$marker = array();
                // //$marker['position'] = '37.429, -122.1419';
                // //$this->googlemaps->add_marker($marker);
                // $config['center'] = '37.4419, -122.1419';
                // $config['zoom'] = 'auto';
                // $config['places'] = TRUE;
                // $config['placesAutocompleteInputID'] = 'myPlaceTextBox';
                // $config['placesAutocompleteBoundsMap'] = TRUE; // set results biased towards the maps viewport
                // $config['placesAutocompleteOnChange'] = 
                // $this->googlemaps->initialize($config);
                // $data['map'] = $this->googlemaps->create_map();

                $this->load->view('add_property_view');
            }
        } else {
            //If no session, redirect to login page
            redirect('login', 'refresh');
        }
    }

    function email_newsletter_list() {
        $this->load->view('email_newsletter_list_view');
    }

    function sms_newsletter_list() {
        $this->load->view('sms_newsletter_list_view');
    }

    function sms_newsletter() {

        $this->load->library('CMSMS');
        CMSMS::sendMessage('00919898027612', 'Test message');

        $this->load->view('sms_newsletter_view');
    }

    function email_newsletter() {
        $this->load->view('email_newsletter_view');
    }

    function sms_email_history() {
        if (!$this->session->userdata('logged_in_super_user')) {
            $this->session->set_flashdata('error', 'Not allowed!');
            redirect('login', 'refresh');
            exit;
        }
        error_reporting(0);
        $data['sms_email_history'] = $this->inquiry_model->get_sms_email_history();
        //echo'<pre>';print_r($data['sms_email_history']);exit;

        foreach ($data['sms_email_history'] as $key => $value) {

            $data['sms_email_history'][$key]->name = $this->inquiry_model->get_sms_email_history_recievername($value->user_type, $value->reciever_id);
            $data['sms_email_history'][$key]->name = $data['sms_email_history'][$key]->name[0]->fname . ' ' . $data['sms_email_history'][$key]->name[0]->lname;
            //$data['sms_email_history'][$key]
        }
        //echo "<pre>";print_r($data);exit;
        // $data['sms_email_history'] =$data['sms_email_history'][0];
        $this->load->view('sms_email_history_view', $data);
    }

    function propertyExatraImages($propertyId) {
        $data['allPropertyImages'] = $this->inquiry_model->getPropertyExtraImages($propertyId);
        $data['getPropertyDetails'] = $this->inquiry_model->get_property_detail($propertyId);
        $this->load->view('property_exatra_images', $data);
    }

    function deletePropertyExtImg() {
        $propertyImgId = $_POST['propertyImgId'];
        //echo $propertyImgName = $_POST['propertyImgName'];
        $propertyImgDetails = $this->inquiry_model->getPropertyExtImgDetailsById($propertyImgId);

        //print_r($propertyImgDetails);exit;
        if ($this->inquiry_model->deletePropertyExtImgById($propertyImgId)) {
            @unlink(APPPATH . "../upload/property/" . $propertyImgDetails[0]->image_name);
            @unlink(APPPATH . "../upload/property/100x100/" . $propertyImgDetails[0]->image_name);
            @unlink(APPPATH . "../upload/property/200x200/" . $propertyImgDetails[0]->image_name);
            echo true;
        } else {
            echo false;
        }
    }

    function addpropertyExatraImagesByAjax($propertyId) {
        if (isset($_FILES["myfile"])) {
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
            $config['upload_path'] = realpath(APPPATH . '../upload/property');
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            $data = $this->upload->do_upload("myfile");
            $data = $this->upload->data();

            // Save data to Database.
            if ($this->inquiry_model->savePropertyExtraImage($propertyId, $data['file_name'])) {
                $propertyImgId = $this->db->insert_id();

                $configSize1['image_library'] = 'gd2';
                $configSize1['source_image'] = APPPATH . '../upload/property/' . $data['file_name'];
                //$configSize1['create_thumb']    = TRUE;
                $configSize1['maintain_ratio'] = true;
                $configSize1['width'] = 100;
                $configSize1['height'] = 100;
                $configSize1['new_image'] = APPPATH . '../upload/property/100x100/';

                $this->image_lib->initialize($configSize1);
                $this->image_lib->resize();
                $this->image_lib->clear();

                $configSize1['image_library'] = 'gd2';
                $configSize1['source_image'] = APPPATH . '../upload/property/' . $data['file_name'];
                //$configSize1['create_thumb']    = TRUE;
                $configSize1['maintain_ratio'] = true;
                $configSize1['width'] = 200;
                $configSize1['height'] = 200;
                $configSize1['new_image'] = APPPATH . '../upload/property/200x200/';
                $this->image_lib->initialize($configSize1);
                $this->image_lib->resize();
                $this->image_lib->clear();

                $configSize1['maintain_ratio'] = true;
                $configSize1['width'] = 800;
                $configSize1['height'] = 400;
                $configSize1['new_image'] = APPPATH . '../upload/property/800x400/';
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
            if ($this->session->userdata('logged_in_super_user')) {
                $sessionData = $this->session->userdata('logged_in_super_user');
            } else if ($this->session->userdata('logged_in_agent')) {
                $sessionData = $this->session->userdata('logged_in_agent');
            } else if ($this->session->userdata('logged_in_employee')) {
                $sessionData = $this->session->userdata('logged_in_employee');
            }
            $id = $sessionData['id'];
            $data['user_pass'] = $this->user->getUserPassword($id);

            $this->load->view('change_password_view', $data);
        } else {
            //If no session, redirect to login page
            redirect('login', 'refresh');
        }
    }

    function unic_num() {
        $num = rand(10000000, 99999999);

        $unic_number = $this->user->check_unic_num($num);
        if (!empty($unic_number)) {
            $this->unic_num();
        } else {
            return $num;
        }
    }

    function unic_inquiry_num() {
        $inquiry_num = rand(10000000, 99999999);
        $unic_number = $this->inquiry_model->check_unic_inquiry_num($inquiry_num);
        if (!empty($unic_number)) {
            $this->unic_inquiry_num();
        } else {
            return $inquiry_num;
        }
    }

    function sendNewClientInquiry_exist_client() {
        error_reporting(0);
        $get_exist_customer_Id = $this->inquiry_model->get_exist_customer_Id($_POST['email_mobile']);

        $PropertyId = $_POST['property_id'];
        $getSelectedPropertyDetails = $this->inquiry_model->getPropertyDetailsById($PropertyId);

        $customerId = $get_exist_customer_Id[0]->id;
        $property_buy_sale = $_POST['aquired'];
        $property_link = array();
        $property_title = array();
        $property_link_url = array();
        $property_link_path = base_url() . "index.php/home/view_property/";
        $url = explode(',', $getSelectedPropertyDetails[0]->url_link);
        if (!empty($url[0])) {
            $url_link = $url[0];
        } elseif (!empty($url[1])) {
            $url_link = $url[1];
        } elseif (!empty($url[2])) {
            $url_link = $url[2];
        } else {
            $url_link = "";
        }
        array_push($property_link, $property_link_path . $getSelectedPropertyDetails[0]->id);
        array_push($property_link_url, $url_link);
        if (!empty($getSelectedPropertyDetails[0]->bedroom)) {
            $bedroom_detail = $getSelectedPropertyDetails[0]->bedroom;
        } else {
            $bedroom_detail = "-";
        }

        if (!empty($getSelectedPropertyDetails[0]->reference_no)) {
            $reference_no = $getSelectedPropertyDetails[0]->reference_no;
        } else {
            $reference_no = "-";
        }
        if (!empty($getSelectedPropertyDetails[0]->property_type)) {
            $property_category = $this->get_propertytypeby_id($getSelectedPropertyDetails[0]->property_type);
        } else {
            $property_category = "-";
        }

        if (!empty($getSelectedPropertyDetails[0]->type)) {
            $propety_type = $getSelectedPropertyDetails[0]->type;
        } else {
            $propety_type = "-";
        }
        if ($propety_type == '1') {
            $type = "Sale";
        } else if ($propety_type == 2) {
            $type = "Rent";
        } else if ($propety_type == '3') {
            $type = "Sale/Rent";
        } else {
            $type = "- ";
        }
        array_push($property_title, $reference_no . ", " . $bedroom_detail . " Bedrooms " . $property_category . " for " . $type);
        $inquiry_num = $this->unic_inquiry_num();

        $insert_customer_inquiry = $this->inquiry_model->saveClientInquiry($customerId, $PropertyId, $getSelectedPropertyDetails[0]->reference_no, $inquiry_num, $property_buy_sale);
        $this->mailChimpSubscribe($customerId);
        $data = array(
            'customer_email' => $get_exist_customer_Id[0]->email,
            'customer_name' => $get_exist_customer_Id[0]->fname . ' ' . $get_exist_customer_Id[0]->lname,
            'property_links' => $property_link,
            'property_link_url' => $property_link_url,
            //'bedroom'=>$bedroom_detail,
            //'property_category'=>$property_category,
            //'property_type'=>$propety_type
            'property_title' => $property_title
        );

        /* code for notificatin to agent and customer */
        $this->load->model('customer_model');
        $customer = $this->customer_model->getCustomer($customerId);

        /* Notify customer */
        $subject = "Your Property Inquiry";
        $message = $this->load->view("email/multiple_inquiry", $data, TRUE);

        $sms = "Dear " . $get_exist_customer_Id[0]->fname . " " . $get_exist_customer_Id[0]->lname . ", ";
        $sms .="Following attached link for property as per your requirements: \n";
        $sms .= "Reference No: " . $reference_no;
        $sms .= ", " . $bedroom_detail . " Bedrooms ";
        $sms .= $property_category . " for ";
        if ($propety_type == '1') {
            $sms .= "Sale \n";
        } else if ($propety_type == '2') {
            $sms .= "Rent \n";
        } else if ($propety_type == '3') {
            $sms .= "Sale/Rent \n";
        } else {
            $sms .= "- \n";
        }
        if (!empty($property_link_url[0]) && trim($property_link_url[0]) != "") {
            $sms .= $property_link_url[0];
        } else {
            $sms .= $property_link[0];
        }
        $sms .= " For any further information please call: 8000 7000";
        $sms .= " Thanks,";
        $sms .= " Monopolion Team";

        $this->notifyUser($customer, $subject, $message, $sms, $insert_customer_inquiry);

        //$this->session->set_flashdata('success', 'Success! Inquiry for the Property sent successfully. E-mail and SMS send successfull.!');
        //$this->session->set_flashdata('success', 'Success! Inquiry for the Property sent successfully. SMS send successfull.!');
        //$this->session->set_flashdata('success', 'Success! Inquiry for the Property sent successfully. E-mail send successfull!');
        redirect('home/property_manage');
    }

    function sendNewClientInquiry() {
        if ($this->session->userdata('logged_in_super_user') || $this->session->userdata('logged_in_agent') || $this->session->userdata('logged_in_employee')) {
            error_reporting(0);
            $customer_uniqueNo = $this->unic_num();
            if ($customer_Id = $this->user->customer_insert($customer_uniqueNo)) {

                $this->mailChimpSubscribe($customer_Id);
                if (isset($_POST) && $_POST != "") {
                    $PropertyId = $_POST['property_id'];
                    $getSelectedPropertyDetails = $this->inquiry_model->getPropertyDetailsById($PropertyId);

                    $customerId = $customer_Id;
                    $property_buy_sale = $_POST['aquired'];
                    $property_link = array();
                    $property_title = array();
                    $property_link_url = array();
                    $property_link_path = base_url() . "index.php/home/view_property/";
                    foreach ($getSelectedPropertyDetails as $inqKey => $inqValue) {
                        $url = explode(',', $inqValue->url_link);
                        if (!empty($url[0])) {
                            $url_link = $url[0];
                        } elseif (!empty($url[1])) {
                            $url_link = $url[1];
                        } elseif (!empty($url[2])) {
                            $url_link = $url[2];
                        } else {
                            $url_link = "";
                        }
                        // Get Unique Inquiry Reference Number
                        $inquiry_num = $this->unic_inquiry_num();

                        if ($insert_customer_inquiry = $this->inquiry_model->saveClientInquiry($customerId, $inqValue->id, $inqValue->reference_no, $inquiry_num, $property_buy_sale)) {
                            array_push($property_link, $property_link_path . $inqValue->id);
                            array_push($property_link_url, $url_link);
                            if (!empty($inqValue->property_type)) {
                                $property_category = $this->get_propertytypeby_id($inqValue->property_type);
                            } else {
                                $property_category = "-";
                            }
                            if ($inqValue->type == 1) {
                                $type = "Sale";
                            } elseif ($inqValue->type == 2) {
                                $type = "Rent";
                            } elseif ($inqValue->type == 3) {
                                $type = "Sale/Rent";
                            } else {
                                $type = "-";
                            }

                            array_push($property_title, $inqValue->reference_no . ", " . $inqValue->bedroom . " Bedrooms " . $property_category . " " . $type);
                        }
                    }
                    if (!empty($getSelectedPropertyDetails[0]->bedroom)) {
                        $bedroom_detail = $getSelectedPropertyDetails[0]->bedroom;
                    } else {
                        $bedroom_detail = "-";
                    }

                    if (!empty($getSelectedPropertyDetails[0]->property_type)) {
                        $property_category = $this->get_propertytypeby_id($getSelectedPropertyDetails[0]->property_type);
                    } else {
                        $property_category = "-";
                    }
                    if (!empty($getSelectedPropertyDetails[0]->type)) {
                        $property_type = $getSelectedPropertyDetails[0]->type;
                    } else {
                        $property_type = "-";
                    }

                    $sendSMSFlag = "";
                    $sendEmailFlag = "";

                    $data = array(
                        'customer_email' => $_POST['email'],
                        'customer_name' => $_POST['fname'] . '' . $_POST['lname'],
                        'property_links' => $property_link,
                        'property_title' => $property_title,
                        'property_link_url' => $property_link_url
                            //'bedroom'=>$bedroom_detail,
                            //'property_category'=>$property_category,
                            //'property_type'=>$propety_type
                    );
                    /* code for notificatin to agent and customer */
                    $this->load->model('customer_model');
                    $customer = $this->customer_model->getCustomer($customerId);

                    /* Notify customer */
                    $subject = "Your Property Inquiry";
                    $message = $this->load->view("email/multiple_inquiry", $data, TRUE);

                    $sms = "Dear " . $_POST['fname'] . " " . $_POST['lname'] . ", ";
                    $sms .="Following attached link for property as per your requirements: \n";
                    $sms .= " Reference No: " . $inqValue->reference_no;
                    $sms .= ", " . $bedroom_detail . " Bedrooms ";
                    $sms .= $property_category . " for ";
                    if ($property_type == 1) {
                        $sms .= "Sale \n";
                    } elseif ($property_type == 2) {
                        $sms .= "Rent \n";
                    } elseif ($property_type == 3) {
                        $sms .= "Sale/Rent \n";
                    } else {
                        $sms .= "- \n";
                    }
                    if (!empty($property_link_url[0]) && trim($property_link_url[0]) != "") {
                        $sms .= $property_link_url[0];
                    } else {
                        $sms .= $property_link[0];
                    }
                    $sms .= " For any further information please call: 8000 7000";
                    $sms .= " Thanks,";
                    $sms .= " Monopolion Team";

                    $this->notifyUser($customer, $subject, $message, $sms, $insert_customer_inquiry);

                    //$this->session->set_flashdata('success', 'Success! Inquiry for the Property sent successfully. Email and SMS send successfull.!');
                    // $this->session->set_flashdata('success', 'Success! Inquiry for the Property sent successfully. SMS send successfull.!');
                    //$this->session->set_flashdata('success', 'Success! Inquiry for the Property sent successfully. E-mail send successfull.!');
                    //$this->session->set_flashdata('success', 'E-mail and SMS not send beacuse somethig wrong');
                    redirect('home/property_manage');
                }
            } else {
                redirect('home', 'refresh');
            }
        } else {
            redirect('login', 'refresh');
        }
    }

    function change_pass_check() {

        $user = $this->user->pass_check($_POST);
        //echo'<pre>';print_r($user);exit;
        if (!empty($user)) {
            echo "true";
            exit;
        } else {
            echo "false";
            exit;
        }
    }

    function edit_profile() {

        if (!empty($_POST['type'])) {
            if ($this->session->userdata('logged_in_agent')) {
                $image_path = APPPATH . '../upload/agent/';
                $config['upload_path'] = $image_path;
                $config['allowed_types'] = 'gif|jpg|png';
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                $error['upload_data'] = '';
                $old_img = $this->input->post('old_img');
                if (!$this->upload->do_upload('image')) {
                    $error = array('msg' => "Upload success!");
                    $imageName = $old_img;
                } else {

                    $error = array('msg' => "Upload success!");
                    $error['upload_data'] = $this->upload->data();
                    $imageName = $error['upload_data']['file_name'];
                    $configSize1['image_library'] = 'gd2';
                    $configSize1['source_image'] = APPPATH . '../upload/agent/' . $imageName;
                    //$configSize1['create_thumb']    = TRUE;
                    $configSize1['maintain_ratio'] = false;
                    $configSize1['width'] = 100;
                    $configSize1['height'] = 100;
                    $configSize1['new_image'] = APPPATH . '../upload/agent/100x100/';

                    $this->image_lib->initialize($configSize1);
                    $this->image_lib->resize();
                    $this->image_lib->clear();

                    $configSize1['image_library'] = 'gd2';
                    $configSize1['source_image'] = APPPATH . '../upload/agent/' . $imageName;
                    //$configSize1['create_thumb']    = TRUE;
                    $configSize1['maintain_ratio'] = false;
                    $configSize1['width'] = 200;
                    $configSize1['height'] = 200;
                    $configSize1['new_image'] = APPPATH . '../upload/agent/200x200/';
                    $this->image_lib->initialize($configSize1);
                    $this->image_lib->resize();
                    $this->image_lib->clear();
                }
                $deta['user'] = $this->user->update_user_profile_agent($_POST['id'], $imageName);
            } else {
                $deta['user'] = $this->user->update_user_profile($_POST['id']);
            }

            if ($deta['user'] == '1') {

                $sess_array = array(
                    'id' => $_POST['user_id'],
                    'fname' => $_POST['fname'],
                    'lname' => $_POST['lname'],
                    'email' => $_POST['email'],
                    'mobile_no' => $_POST['mobile_no'],
                    'type' => $_POST['type'],
                );
                if ($sess_array['type'] == '1') {
                    $this->session->unset_userdata('logged_in_super_user');
                    $this->session->set_userdata('logged_in_super_user', $sess_array);
                } else if ($sess_array['type'] == '2') {
                    $this->session->unset_userdata('logged_in_agent');
                    $this->session->set_userdata('logged_in_agent', $sess_array);
                } else {
                    $this->session->unset_userdata('logged_in_employee');
                    $this->session->set_userdata('logged_in_employee', $sess_array);
                }
            }
            $this->session->set_flashdata('success', 'Your profile update successfull.');
            redirect('home', 'refresh');
        } elseif ($this->uri->segment(3)) {
            $id = $this->uri->segment(3);
            $deta['user'] = $this->user->get_user_detail($id);

            $this->load->view('edit_profile', $deta);
        }
    }

    function user_email_check() {

        $user = $this->user->user_email_check($_POST);

        if (!empty($user)) {
            echo "false";
            exit;
        } else {
            echo "true";
            exit;
        }
    }

    function user_mobile_check() {

        $user = $this->user->user_mobile_check($_POST);

        if (!empty($user)) {
            echo "false";
            exit;
        } else {
            echo "true";
            exit;
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
    function sms_send_mass() {
        $this->load->view('sms_send_mass');
        //echo $citydata;exit;
    }

    function email_send_mass() {
        $this->load->view('email_send_mass');
        //echo $citydata;exit;
    }

    function sms_email_send_history() {
        $this->load->view('sms_email_send_history');
        //echo $citydata;exit;
    }

    function view_property($id) {

        $property_data['data'] = $this->user->get_property_view_detail_($id);
        if (!empty($property_data['data'])) {
            $property_data['image'] = $this->user->get_property_view_image($property_data['data'][0]->id);
            $property_data['genral_facilities'] = $this->user->get_genral_facilities($property_data['data'][0]->id);
            $property_data['instrumental_facilities'] = $this->user->get_instrumental_facilities($property_data['data'][0]->id);

            if (!empty($property_data['data'][0]->property_type)) {
                $property_data['property_type'] = $this->get_propertytypeby_id($property_data['data'][0]->property_type);
            } else {
                $property_data['property_type'] = "";
            }
            if (!empty($property_data['data'][0]->architectural_design)) {
                $property_data['architectural_design'] = $this->get_architectural_design($property_data['data'][0]->architectural_design);
            } else {
                $property_data['architectural_design'] = "";
            }
            if (!empty($property_data['data'][0]->room_size)) {
                $property_data['room_size'] = $this->get_room_size_id($property_data['data'][0]->room_size);
            } else {
                $property_data['room_size'] = "";
            }
        }
        // echo '<pre>';print_r($property_data);exit;
        $this->load->view('view_property_detail', $property_data);
    }

    function property_ref_check() {

        $ref_unin = $this->user->property_ref_check($_POST);

        if (!empty($ref_unin)) {
            echo "false";
            exit;
        } else {
            echo "true";
            exit;
        }
    }

    function error() {
        $this->load->view('error_view');
    }

    function forgote_password() {
        $this->load->helper(array('form'));

        if (!empty($_POST)) {
            $email = $_POST['email'];
            $result = $this->user->get_email_forgotepass($_POST['email']);
            //  echo'<pre>';print_r($result[0]->id);exit;
            if (!empty($result)) {
                $token = md5(uniqid(rand(), true));
                $userid = $result[0]->id;
                $res = $this->user->insert_token($userid, $token);

                /* Notify customer */
                $subject = "Password Reset Link";
                $link = base_url() . "index.php/home/resetpassword/" . $token;
                $message = $link;

                $sms = "";
                $insert_customer_inquiry = 0;
                $this->notifyUser($result[0], $subject, $message, $sms, $insert_customer_inquiry, 1);

                $this->session->set_flashdata('success', "Reset password link is send to your Email address.");
                redirect('home/forgote_password', 'refresh');
            } else {
                $this->session->set_flashdata('danger', "Email address not registered with us.");
                redirect('home/forgote_password', 'refresh');
            }
        } else {
            $this->load->view('forgote_pass');
        }
    }

    function resetpassword() {
        if (!empty($_POST)) {
            if (!empty($_POST['id'])) {
                $query = $this->user->user_password_change($_POST['id'], $_POST['new_password']);
                if ($query == 1) {
                    $this->session->set_flashdata('danger', "Howdy, Password successfully reset. Login from here.");
                    redirect('login', 'refresh');
                } else {
                    $this->session->set_flashdata('danger', "Whoops, Something went to wrong. Try again!!.");
                    redirect('login', 'refresh');
                }
            } else {
                $this->session->set_flashdata('danger', "your reset password link has been expired.");
                redirect('login', 'refresh');
            }
        }
        if ($this->uri->segment(3)) {
            $token = $this->uri->segment(3);
            $record = $this->user->get_user_token_rec($token);
            if (!empty($record)) {
                $data['userid'] = $record[0]->id;
                $this->load->view('resetpassword', $data);
            } else {
                $this->session->set_flashdata('danger', "Invalid token.");
                $this->load->view('forgote_pass');
            }
        } else {
            $data['userid'] = '';
            $this->load->view('resetpassword', $data);
        }
    }

    function forgote_email_check() {

        $user = $this->user->forgote_email_check($_POST);
        if (!empty($user)) {
            echo "true";
            exit;
        } else {
            echo "false";
            exit;
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

    function appointment_conform() {

        if ($this->uri->segment(3) && $this->uri->segment(4)) {
            $inquiry_id = $this->uri->segment(3);
            $agent_id = $this->uri->segment(4);
            $data['inquiry'] = $inquiry_id;
            $data['agent'] = $agent_id;
        } else {
            $data['inquiry'] = '';
            $data['agent'] = '';
        }
        $this->load->view('appointment_conform', $data);
    }

    function delete_propimg() {
        //echo $_POST['imagename'];exit;
        $propertyImgId = $_POST['imageid'];
        $imagename = $_POST['imagename'];

        @unlink(APPPATH . "../img_prop/" . $imagename);
        @unlink(APPPATH . "../img_prop/100x100/" . $imagename);
        @unlink(APPPATH . "../img_prop/200x200/" . $imagename);


        $delete_img = $this->user->delete_propimg($_POST['imageid']);

        exit;
    }

    function delete_propaddimg() {
        $propertyImgId = $_POST['imageid'];
        $imagename = $_POST['imagename'];

        @unlink(APPPATH . "../img_prop/" . $imagename);
        @unlink(APPPATH . "../img_prop/100x100/" . $imagename);
        @unlink(APPPATH . "../img_prop/200x200/" . $imagename);

        $delete_img = $this->user->delete_propaddimg($_POST['imageid']);
        exit;
    }

    function update_propimg() {


        //$allowedExts = array("gif", "jpeg", "jpg", "png");
        if (!empty($_FILES) && $_POST['action'] == "multiple_fileupload") {

            $max_order = $this->user->select_maxid();

            if ($max_order < 1) {
                $max_order = 1;
            } else {
                $max_order = $max_order + 1;
            }


            $config['upload_path'] = realpath(APPPATH . '../img_prop');
            $config['allowed_types'] = 'gif|jpg|png|jpeg';

            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            // echo "<pre>";print_r($_FILES['userImage']);exit;
            foreach ($_FILES['userImage']['name'] as $filekey => $filevalue) {
                $_FILES['afile']['name'] = $filevalue;
                $_FILES['afile']['type'] = $_FILES['userImage']['type'][$filekey];
                $_FILES['afile']['tmp_name'] = $_FILES['userImage']['tmp_name'][$filekey];
                $_FILES['afile']['error'] = $_FILES['userImage']['error'][$filekey];
                $_FILES['afile']['size'] = $_FILES['userImage']['size'][$filekey];

                $data = $this->upload->do_upload("afile");
                $data = $this->upload->data();


                $propimag = array('image' => $data['file_name'], 'order' => $max_order, 'prop_id' => $_POST['prop_id']);
                $insertid = $this->user->insert_propimg($propimag);


                $configSize1['image_library'] = 'gd2';
                $configSize1['source_image'] = APPPATH . '../img_prop/' . $data['file_name'];
                //$configSize1['create_thumb']    = TRUE;
                $configSize1['maintain_ratio'] = true;
                $configSize1['width'] = 100;
                $configSize1['height'] = 100;
                $configSize1['new_image'] = APPPATH . '../img_prop/100x100/';

                $this->image_lib->initialize($configSize1);
                $this->image_lib->resize();
                $this->image_lib->clear();

                $configSize1['image_library'] = 'gd2';
                $configSize1['source_image'] = APPPATH . '../img_prop/' . $data['file_name'];
                //$configSize1['create_thumb']    = TRUE;
                $configSize1['maintain_ratio'] = true;
                $configSize1['width'] = 200;
                $configSize1['height'] = 200;
                $configSize1['new_image'] = APPPATH . '../img_prop/200x200/';
                $this->image_lib->initialize($configSize1);
                $this->image_lib->resize();
                $this->image_lib->clear();

                $configSize1['image_library'] = 'gd2';
                $configSize1['source_image'] = APPPATH . '../img_prop/' . $data['file_name'];
                //$configSize1['create_thumb']    = TRUE;
                $configSize1['maintain_ratio'] = true;
                $configSize1['width'] = 800;
                $configSize1['height'] = 400;
                $configSize1['new_image'] = APPPATH . '../img_prop/800x400/';
                $this->image_lib->initialize($configSize1);
                $this->image_lib->resize();
                $this->image_lib->clear();

                $img_detail[$filekey]['id'] = $insertid;
                $img_detail[$filekey]['img_name'] = $data['file_name'];
            }



            /* $targetDir = "img_prop/";
              foreach ($_FILES['userImage']['name'] as $filekey => $filevalue) {

              $fileName = $filevalue;
              $fnm = explode('.', $filevalue);
              $fileName =rand('1111','9999').'.'.max($fnm);
              if(in_array(max($fnm), $allowedExts)){
              $fileName =rand('1111','9999').'.'.max($fnm);
              $max_order = $this->user->select_maxid();

              if ($max_order < 1) {
              $max_order = 1;
              }else{
              $max_order = $max_order+1;
              }

              $targetFile = $targetDir.$fileName;

              if(move_uploaded_file($_FILES['userImage']['tmp_name'][$filekey],$targetFile)){

              $propimag  = array('image' =>$fileName ,'order'=> $max_order, 'prop_id'=>$_POST['prop_id']);
              $insertid = $this->user->insert_propimg($propimag);


              $img_detail[$filekey]['id'] = $insertid;
              $img_detail[$filekey]['img_name'] = base_url()."img_prop/".$fileName;
              }
              }
              else
              {
              $img_detail[$filekey]['id'] = '-1';
              $img_detail[$filekey]['img_name'] = "error_file";
              }
              } */

            echo json_encode($img_detail);
        }
    }

    function insert_image() {
        //$allowedExts = array("gif", "jpeg", "jpg", "png");
        //$fileName = $_FILES['afile']['name'];
        // $targetDir = "img_prop/";
        //$fnm = explode('.', $fileName);
        /* $temp = explode(".", $_FILES["file"]['name']);
          $extension = end($temp);
         */

        //if(in_array(max($fnm), $allowedExts)){
        //$fileName =rand('1111','9999').'.'.max($fnm);
        $max_order = $this->user->select_maxid();
        // $query = mysqli_query($con,"SELECT * FROM `images` ORDER BY `order` ASC") or die(mysql_error());
        //while($row = mysqli_fetch_assoc($query))
        //{
        //   $rows[$row['order']] = $row;
        //}
        //$max_order = max(array_keys($rows));
        if ($max_order < 1) {
            $max_order = 1;
        } else {
            $max_order = $max_order + 1;
        }

        //$targetFile = $targetDir.$fileName;


        $config['upload_path'] = realpath(APPPATH . '../img_prop');
        $config['allowed_types'] = 'gif|jpg|png|jpeg';


        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        foreach ($_FILES['userImage']['name'] as $filekey => $filevalue) {
            $_FILES['afile']['name'] = $filevalue;
            $_FILES['afile']['type'] = $_FILES['userImage']['type'][$filekey];
            $_FILES['afile']['tmp_name'] = $_FILES['userImage']['tmp_name'][$filekey];
            $_FILES['afile']['error'] = $_FILES['userImage']['error'][$filekey];
            $_FILES['afile']['size'] = $_FILES['userImage']['size'][$filekey];
            $data = $this->upload->do_upload("afile");


            $data = $this->upload->data();

            $propimag = array('image' => $data['file_name'], 'order' => $max_order, 'prop_id' => $_POST['prop_id']);
            $insertid = $this->user->insert_propimg($propimag);

            // Save data to Database.
            //if($this->inquiry_model->savePropertyExtraImage($propertyId, $data['file_name']))
            //{
            //$propertyImgId = $this->db->insert_id();

            $configSize1['image_library'] = 'gd2';
            $configSize1['source_image'] = APPPATH . '../img_prop/' . $data['file_name'];
            //$configSize1['create_thumb']    = TRUE;
            $configSize1['maintain_ratio'] = true;
            $configSize1['width'] = 100;
            $configSize1['height'] = 100;
            $configSize1['new_image'] = APPPATH . '../img_prop/100x100/';

            $this->image_lib->initialize($configSize1);
            $this->image_lib->resize();
            $this->image_lib->clear();

            $configSize1['image_library'] = 'gd2';
            $configSize1['source_image'] = APPPATH . '../img_prop/' . $data['file_name'];
            //$configSize1['create_thumb']    = TRUE;
            $configSize1['maintain_ratio'] = true;
            $configSize1['width'] = 200;
            $configSize1['height'] = 200;
            $configSize1['new_image'] = APPPATH . '../img_prop/200x200/';
            $this->image_lib->initialize($configSize1);
            $this->image_lib->resize();
            $this->image_lib->clear();

            $configSize1['image_library'] = 'gd2';
            $configSize1['source_image'] = APPPATH . '../img_prop/' . $data['file_name'];
            //$configSize1['create_thumb']    = TRUE;
            $configSize1['maintain_ratio'] = true;
            $configSize1['width'] = 800;
            $configSize1['height'] = 400;
            $configSize1['new_image'] = APPPATH . '../img_prop/800x400/';
            $this->image_lib->initialize($configSize1);
            $this->image_lib->resize();
            $this->image_lib->clear();

            // }
            $img_detail[$filekey]['id'] = $insertid;
            $img_detail[$filekey]['img_name'] = $data['file_name'];
            //$img_detail[0]['id'] = $insertid;
            //$img_detail[0]['img_name'] = $data['file_name'];
        }
        /* if(move_uploaded_file($_FILES['afile']['tmp_name'],$targetFile)){

          $propimag  = array('image' =>$fileName ,'order'=> $max_order, 'prop_id'=>$_POST['prop_id']);

          $insertid = $this->user->insert_propimg($propimag);
          $img_detail[0]['id'] = $insertid;
          $img_detail[0]['img_name'] = $fileName;
          } */
        /* }
          else
          {
          $img_detail[0]['id'] = '-1';
          $img_detail[0]['img_name'] = "error_file";
          } */
        echo json_encode($img_detail);
    }

    function insertproperty_image() {
        /* if (isset($this->session->userdata('img_tocken')) && !empty($this->session->userdata('img_tocken'))) {
          $tocken = $this->session->userdata('img_tocken');
          }else{
          $tocken = md5(rand(1111,9999));
          $this->session->set_userdata('img_tocken', $tocken);
          } */
        if ($this->session->userdata('img_tocken')) {
            $tocken = $this->session->userdata('img_tocken');
        } else {
            $tocken = md5(rand(1111, 9999));
            $this->session->set_userdata('img_tocken', $tocken);
        }


        $max_order = $this->user->select_maxid_insprop();
        // $query = mysqli_query($con,"SELECT * FROM `images` ORDER BY `order` ASC") or die(mysql_error());
        //while($row = mysqli_fetch_assoc($query))
        //{
        //   $rows[$row['order']] = $row;
        //}
        //$max_order = max(array_keys($rows));
        if ($max_order < 1) {
            $max_order = 1;
        } else {
            $max_order = $max_order + 1;
        }


        $config['upload_path'] = realpath(APPPATH . '../img_prop');
        $config['allowed_types'] = 'gif|jpg|png|jpeg';

        $this->load->library('upload', $config);
        $this->upload->initialize($config);


        foreach ($_FILES['userImage']['name'] as $filekey => $filevalue) {
            $_FILES['afile']['name'] = $filevalue;
            $_FILES['afile']['type'] = $_FILES['userImage']['type'][$filekey];
            $_FILES['afile']['tmp_name'] = $_FILES['userImage']['tmp_name'][$filekey];
            $_FILES['afile']['error'] = $_FILES['userImage']['error'][$filekey];
            $_FILES['afile']['size'] = $_FILES['userImage']['size'][$filekey];
            $data = $this->upload->do_upload("afile");

            $data = $this->upload->data();
            $propimag = array('image' => $data['file_name'], 'order' => $max_order, 'tocken' => $tocken, 'created' => date('Y-m-d H:i:s'));
            $insertid = $this->user->insert_propadd_img($propimag);

            // Save data to Database.
            //if($this->inquiry_model->savePropertyExtraImage($propertyId, $data['file_name']))
            //{
            //$propertyImgId = $this->db->insert_id();

            $configSize1['image_library'] = 'gd2';
            $configSize1['source_image'] = APPPATH . '../img_prop/' . $data['file_name'];
            //$configSize1['create_thumb']    = TRUE;
            $configSize1['maintain_ratio'] = true;
            $configSize1['width'] = 100;
            $configSize1['height'] = 100;
            $configSize1['new_image'] = APPPATH . '../img_prop/100x100/';

            $this->image_lib->initialize($configSize1);
            $this->image_lib->resize();
            $this->image_lib->clear();

            $configSize1['image_library'] = 'gd2';
            $configSize1['source_image'] = APPPATH . '../img_prop/' . $data['file_name'];
            //$configSize1['create_thumb']    = TRUE;
            $configSize1['maintain_ratio'] = true;
            $configSize1['width'] = 200;
            $configSize1['height'] = 200;
            $configSize1['new_image'] = APPPATH . '../img_prop/200x200/';
            $this->image_lib->initialize($configSize1);
            $this->image_lib->resize();
            $this->image_lib->clear();

            $configSize1['maintain_ratio'] = true;
            $configSize1['width'] = 800;
            $configSize1['height'] = 400;
            $configSize1['new_image'] = APPPATH . '../img_prop/800x400/';
            $this->image_lib->initialize($configSize1);
            $this->image_lib->resize();
            $this->image_lib->clear();

            // }

            $img_detail[$filekey]['id'] = $insertid;
            $img_detail[$filekey]['img_name'] = $data['file_name'];

            //$img_detail[0]['id'] = $insertid;
            //$img_detail[0]['img_name'] = $data['file_name'];
        }

        //$allowedExts = array("gif", "jpeg", "jpg", "png");
        //$fileName = $_FILES['afile']['name'];
        //$targetDir = "img_prop/";
        //$fnm = explode('.', $fileName);
        /* $temp = explode(".", $_FILES["file"]['name']);
          $extension = end($temp);
         */

        /* if(in_array(max($fnm), $allowedExts)){

          $fileName =rand('1111','9999').'.'.max($fnm);
          $max_order = $this->user->select_maxid_insprop();

          if ($max_order < 1) {
          $max_order = 1;
          }else{
          $max_order = $max_order+1;
          }

          $targetFile = $targetDir.$fileName;

          if(move_uploaded_file($_FILES['afile']['tmp_name'],$targetFile)){

          $propimag  = array('image' =>$fileName ,'order'=> $max_order, 'created' => date('Y-m-d H:i:s'));
          $insertid = $this->user->insert_propadd_img($propimag);

          $img_detail[0]['id'] = $insertid;
          $img_detail[0]['img_name'] = $fileName;

          }
          }
          else
          {
          $img_detail[0]['id'] = '-1';
          $img_detail[0]['img_name'] = "error_file";
          } */
        echo json_encode($img_detail);
    }

    function order_update() {
        $idArray = explode(",", $_POST['ids']);

        $count = 1;
        foreach ($idArray as $propkey => $propvalue) {

            $propimag = array('order' => $count, 'id' => $propvalue);
            $insertid = $this->user->update_propimg($propimag);

            $count ++;
        }
        return true;
    }

    function uploadFormData_insform() {
        if ($this->session->userdata('img_tocken')) {
            $tocken = $this->session->userdata('img_tocken');
        } else {
            $tocken = md5(rand(1111, 9999));
            $this->session->set_userdata('img_tocken', $tocken);
        }

        /* if((isset($this->session->userdata('img_tocken'))) && (!empty($this->session->userdata('img_tocken'))) {
          $tocken = $this->session->userdata('img_tocken');
          }else{
          $tocken = md5(rand(1111,9999));
          $this->session->set_userdata('img_tocken', $tocken);
          } */

        //$_SESSION['img_tocken'] = $tocken;
        $allowedExts = array("gif", "jpeg", "jpg", "png");
        if (!empty($_FILES) && $_POST['action'] == "multiple_fileupload") {

            //$targetDir = "img_prop/";

            $max_order = $this->user->select_maxid_insprop();

            if ($max_order < 1) {
                $max_order = 1;
            } else {
                $max_order = $max_order + 1;
            }


            $config['upload_path'] = realpath(APPPATH . '../img_prop');
            $config['allowed_types'] = 'gif|jpg|png|jpeg';

            $this->load->library('upload', $config);
            $this->upload->initialize($config);


            foreach ($_FILES['userImage']['name'] as $filekey => $filevalue) {
                $_FILES['afile']['name'] = $filevalue;
                $_FILES['afile']['type'] = $_FILES['userImage']['type'][$filekey];
                $_FILES['afile']['tmp_name'] = $_FILES['userImage']['tmp_name'][$filekey];
                $_FILES['afile']['error'] = $_FILES['userImage']['error'][$filekey];
                $_FILES['afile']['size'] = $_FILES['userImage']['size'][$filekey];

                $data = $this->upload->do_upload("afile");
                $data = $this->upload->data();

                $propimag = array('image' => $data['file_name'], 'order' => $max_order, 'tocken' => $tocken, 'created' => date('Y-m-d H:i:s'));
                $insertid = $this->user->insert_propadd_img($propimag);

                $configSize1['image_library'] = 'gd2';
                $configSize1['source_image'] = APPPATH . '../img_prop/' . $data['file_name'];
                //$configSize1['create_thumb']    = TRUE;
                $configSize1['maintain_ratio'] = true;
                $configSize1['width'] = 100;
                $configSize1['height'] = 100;
                $configSize1['new_image'] = APPPATH . '../img_prop/100x100/';

                $this->image_lib->initialize($configSize1);
                $this->image_lib->resize();
                $this->image_lib->clear();

                $configSize1['image_library'] = 'gd2';
                $configSize1['source_image'] = APPPATH . '../img_prop/' . $data['file_name'];
                //$configSize1['create_thumb']    = TRUE;
                $configSize1['maintain_ratio'] = true;
                $configSize1['width'] = 200;
                $configSize1['height'] = 200;
                $configSize1['new_image'] = APPPATH . '../img_prop/200x200/';
                $this->image_lib->initialize($configSize1);
                $this->image_lib->resize();
                $this->image_lib->clear();

                $configSize1['maintain_ratio'] = true;
                $configSize1['width'] = 800;
                $configSize1['height'] = 400;
                $configSize1['new_image'] = APPPATH . '../img_prop/800x400/';
                $this->image_lib->initialize($configSize1);
                $this->image_lib->resize();
                $this->image_lib->clear();

                $img_detail[$filekey]['id'] = $insertid;
                //$img_detail[$filekey]['img_name'] = base_url()."img_prop/".$fileName;
                $img_detail[$filekey]['img_name'] = $data['file_name'];
            }

            /* foreach ($_FILES['userImage']['name'] as $filekey => $filevalue) {


              $fileName = $filevalue;
              $fnm = explode('.', $filevalue);

              if(in_array(max($fnm), $allowedExts)){
              $fileName =rand('1111','9999').'.'.max($fnm);
              $max_order = $this->user->select_maxid_insprop();

              if ($max_order < 1) {
              $max_order = 1;
              }else{
              $max_order = $max_order+1;
              }

              $targetFile = $targetDir.$fileName;

              if(move_uploaded_file($_FILES['userImage']['tmp_name'][$filekey],$targetFile)){
              $propimag  = array('image' =>$fileName ,'order'=> $max_order, 'created' => date('Y-m-d H:i:s'));
              $insertid = $this->user->insert_propadd_img($propimag);

              $img_detail[$filekey]['id'] = $insertid;
              //$img_detail[$filekey]['img_name'] = base_url()."img_prop/".$fileName;
              $img_detail[$filekey]['img_name'] = $fileName;
              }


              }
              else
              {
              $img_detail[$filekey]['id'] = '-1';
              $img_detail[$filekey]['img_name'] = "error_file";
              }
              } */

            echo json_encode($img_detail);
        }
    }

    function propadd_order_update() {
        $idArray = explode(",", $_POST['ids']);

        $count = 1;
        foreach ($idArray as $propkey => $propvalue) {

            $propimag = array('order' => $count, 'id' => $propvalue);
            $insertid = $this->user->update_propaddimg($propimag);

            $count ++;
        }
    }

    function final_appointment_conform() {
        if (!empty($_POST)) {
            $inquiry_id = $_POST['inquiry'];
            $agent_id = $_POST['agent'];

            $result = $this->inquiry_model->check_agent_appointment($agent_id, $inquiry_id);
            if (!empty($result)) {
                $inquiry_data = $this->inquiry_model->update_agent_appointment($agent_id, $inquiry_id, $_POST);
                $aget_record = $this->inquiry_model->get_aget_record($agent_id);
                $employee_record = $this->inquiry_model->get_employee_record($inquiry_id);
                $inquiry_and_customer_record = $this->inquiry_model->get_inquiry_data($inquiry_id);

                if (!empty($aget_record)) {
                    $aget_record = $aget_record[0];
                    $agentcountry_code = $this->user->get_contry_code($aget_record->coutry_code);
                    $mcode_agent = substr($agentcountry_code[0]->prefix_code, 1);
                    $mobile_code_agent = "00" . $mcode_agent;
                } else {
                    $mobile_code_agent = "0000";
                }
                if (!empty($employee_record)) {
                    $employee_record = $employee_record[0];
                    $employeecountry_code = $this->user->get_contry_code($employee_record->coutry_code);
                    $mcode_employee = substr($employeecountry_code[0]->prefix_code, 1);
                    $mobile_code_employee = "00" . $mcode_employee;
                    $employee_name = $employee_record->fname . " " . $employee_record->lname;
                } else {
                    $mobile_code_employee = "0000";
                    $employee_name = " ";
                }
                if (!empty($inquiry_and_customer_record)) {
                    $inquiry_and_customer_record = $inquiry_and_customer_record[0];
                    $customercountry_code = $this->user->get_contry_code($inquiry_and_customer_record->coutry_code);
                    $mcode_customer = substr($customercountry_code[0]->prefix_code, 1);
                    $mobile_code_customer = "00" . $mcode_customer;
                } else {
                    $mobile_code_customer = "0000";
                }

                $data = array(
                    'employee_name' => $employee_name,
                    'customer_name' => $inquiry_and_customer_record->fname . ' ' . $inquiry_and_customer_record->lname,
                    'appointment_start' => $inquiry_and_customer_record->appoint_start_date,
                    'appointment_end' => $inquiry_and_customer_record->appoint_end_date,
                    'property_ref_no' => $inquiry_and_customer_record->property_ref_no,
                    'agent_name' => $aget_record->fname . ' ' . $aget_record->lname,
                    'agent_mobile' => $mobile_code_agent . $aget_record->mobile_no,
                    'customer_mobile' => $mobile_code_customer . $inquiry_and_customer_record->mobile_no,
                    'type' => trim($_POST['submit'])
                );

                if (trim($_POST['submit']) == "Confirm Appointment") {
                    $this->session->set_flashdata('success', 'Your Appointment has been Confirm.');
                    $history_subject = "Agent Confirm Appointment";
                } elseif (trim($_POST['submit']) == "Submit") {
                    $this->session->set_flashdata('success', 'Your Appointment has been cancel.');
                    $history_subject = "Agent cancle Appointment";
                } elseif (trim($_POST['submit']) == "Reschedule Appointment") {
                    $this->session->set_flashdata('success', 'Your Appointment has been Reschedule.');
                    $history_subject = "Agent reschedule Appointment";
                }

                /* Notify Agent */
                $subject = $history_subject;
                $message = $this->load->view("email/appointment_confirm_agent", $data, TRUE);

                if (trim($_POST['submit']) == "Confirm Appointment") {
                    $sms = "Dear " . $aget_record->fname . " " . $aget_record->lname . ",";
                    $sms .=" Your appointment for the property with Reference No:" . $inquiry_and_customer_record->property_ref_no . ",";
                    $sms .= " has been confirmed on:" . $inquiry_and_customer_record->appoint_start_date . " to " . $inquiry_and_customer_record->appoint_end_date . ".";
                    $sms .= " Inquiry from, " . $inquiry_and_customer_record->fname . " " . $inquiry_and_customer_record->lname . ", mobile Number: +" . $mobile_code_customer . $inquiry_and_customer_record->mobile_no;
                } elseif (trim($_POST['submit']) == "Submit") {
                    $sms = "Dear " . $aget_record->fname . " " . $aget_record->lname . ",";
                    $sms .= " Your appointment on " . $inquiry_and_customer_record->appoint_start_date . " to " . $inquiry_and_customer_record->appoint_end_date . ".";
                    $sms .=" For the property with Reference No: " . $inquiry_and_customer_record->property_ref_no . ",";
                    $sms .= " has been cancelled";
                    $sms .= " Inquiry from, " . $inquiry_and_customer_record->fname . " " . $inquiry_and_customer_record->lname . ", mobile Number: +" . $mobile_code_customer . $inquiry_and_customer_record->mobile_no;
                } elseif (trim($_POST['submit']) == "Reschedule Appointment") {
                    $sms = "Dear " . $aget_record->fname . " " . $aget_record->lname . ",";
                    $sms .=" Your appointment for the property with Reference No:" . $inquiry_and_customer_record->property_ref_no . ",";
                    $sms .= " has been rescheduled on:" . $inquiry_and_customer_record->appoint_start_date . " to " . $inquiry_and_customer_record->appoint_end_date . ".";
                    $sms .= " Inquiry from, " . $inquiry_and_customer_record->fname . " " . $inquiry_and_customer_record->lname . ", mobile Number: +" . $mobile_code_customer . $inquiry_and_customer_record->mobile_no;
                }
                $this->notifyUser($aget_record, $subject, $message, $sms, $inquiry_id);

                /* Notify Cuestomer */
                $subject = $history_subject;
                $message = $this->load->view("email/appointment_confirm", $data, TRUE);

                if (trim($_POST['submit']) == "Confirm Appointment") {
                    $sms = "Dear " . $inquiry_and_customer_record->fname . " " . $inquiry_and_customer_record->lname . ",";
                    $sms .=" Your appointment for the property with Reference No: " . $inquiry_and_customer_record->property_ref_no . ", ";
                    $sms .= " has been confirmed on:" . $inquiry_and_customer_record->appoint_start_date . " to " . $inquiry_and_customer_record->appoint_end_date . ".";
                    $sms .= " For any further information please kindly contact";
                    $sms .= " our Agent, " . $aget_record->fname . " " . $aget_record->lname . ", Mobile Number: +" . $mobile_code_agent . $aget_record->mobile_no . " or  8000 7000 ";
                } elseif (trim($_POST['submit']) == "Submit") {
                    $sms = "Dear " . $inquiry_and_customer_record->fname . " " . $inquiry_and_customer_record->lname . ",";
                    $sms .= " Your appointment on: " . $inquiry_and_customer_record->appoint_start_date . " to " . $inquiry_and_customer_record->appoint_end_date . ".";
                    $sms .=" for the property with Reference No: " . $inquiry_and_customer_record->property_ref_no . ", has been cancelled";
                    $sms .= " For any further information please kindly contact";
                    $sms .= " our Agent, " . $aget_record->fname . " " . $aget_record->lname . ", mobile Number: +" . $mobile_code_agent . $aget_record->mobile_no . " or  8000 7000 ";
                } elseif (trim($_POST['submit']) == "Reschedule Appointment") {
                    $sms = "Dear " . $inquiry_and_customer_record->fname . " " . $inquiry_and_customer_record->lname . ",";
                    $sms .=" Your appointment for the property with Reference No: " . $inquiry_and_customer_record->property_ref_no . ", ";
                    $sms .= " has been rescheduled on:" . $inquiry_and_customer_record->appoint_start_date . " to " . $inquiry_and_customer_record->appoint_end_date . ".";
                    $sms .= " For any further information please kindly contact";
                    $sms .= " our Agent, " . $aget_record->fname . " " . $aget_record->lname . ", mobile Number: +" . $mobile_code_agent . $aget_record->mobile_no . " or  8000 7000 ";
                }
                $this->notifyUser($inquiry_and_customer_record, $subject, $message, $sms, $inquiry_id);

                /* Notify Employee */
                $subject = $history_subject;
                $message = $this->load->view("email/appointment_confirm_employee", $data, TRUE);

                if (trim($_POST['submit']) == "Confirm Appointment") {
                    $sms = "Dear " . $employee_name . ",";
                    $sms .= " You  that your  appointment on." . $inquiry_and_customer_record->appoint_start_date . " to " . $inquiry_and_customer_record->appoint_end_date;
                    $sms .=" For the property with Reference No:" . $inquiry_and_customer_record->property_ref_no;
                    $sms .= " Inquiry from, " . $inquiry_and_customer_record->fname . ' ' . $inquiry_and_customer_record->lname;
                } elseif (trim($_POST['submit']) == "Submit") {
                    $sms = "Dear " . $employee_name . ",";
                    $sms .= " Your appointment has been cancel";
                    $sms .=" For the property with Reference No:" . $inquiry_and_customer_record->property_ref_no;
                    $sms .= " Inquiry from, " . $inquiry_and_customer_record->fname . ' ' . $inquiry_and_customer_record->lname;
                } elseif (trim($_POST['submit']) == "Reschedule Appointment") {
                    $sms = "Dear " . $employee_name . ",";
                    $sms .= " Your appointment has been Reschedule";
                    $sms .=" For the property with Reference No:" . $inquiry_and_customer_record->property_ref_no;
                    $sms .= " Inquiry from, " . $inquiry_and_customer_record->fname . ' ' . $inquiry_and_customer_record->lname;
                }
                $this->notifyUser($employee_record, $subject, $message, $sms, $inquiry_id);

                $url = "/home/appointment_conform/" . $inquiry_id . "/" . $agent_id;
                redirect($url, 'refresh');
            } else {
                // echo "Your are not Authorize.....";
                $url = "/home/appointment_conform/" . $inquiry_id . "/" . $agent_id;
                $this->session->set_flashdata('error', 'Your are not Authorize.');
                redirect($url, 'refresh');
            }
        } else {
            //echo "Your are not Authorize.....";

            $url = "/home/appointment_conform/";
            $this->session->set_flashdata('error', 'Your are not Authorize.');
            redirect($url, 'refresh');
        }
    }

}

?>