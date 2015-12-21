<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
session_start(); //we need to call PHP's session object to access it through CI

class Inquiry extends MY_Controller {

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
        if (empty($this->cur_user)) {
            redirect('login', 'refresh');
            exit;
        }

        if (!empty($_POST['agent']) && !empty($_POST['inquiry_id']) && !empty($_POST['property_id'])) {
            // code for reschedule inquiry
            $id = $_POST['inquiry_id'];
            $today_date = date('Y-m-d H:i:s');
            $data = array(
                'agent_id' => $this->input->post('agent'),
                'appoint_start_date' => date("Y-m-d H:i:s", strtotime($this->input->post('start_date'))),
                'appoint_end_date' => date("Y-m-d H:i:s", strtotime($this->input->post('end_date'))),
                'ended_date' => date("Y-m-d H:i:s", strtotime($this->input->post('end_date'))),
                'updated_date' => $today_date,
                'status' => '4',
                'agent_status' => '0'
            );

            if ($this->inquiry_model->rescheduleInquiry($id, $data)) {
                $this->session->set_flashdata('success', 'Inquiry has been rescheduled!');
            } else {
                $this->session->set_flashdata('error', 'Inquiry has not been rescheduled! Please try again.');
            }
            redirect('/inquiry/reschedule_inquiries');
        } elseif (!empty($_POST['agent'])) {

            $inquiry_num = $this->unic_inquiry_num();
            $property_id = $this->session->userdata('selected_property_id');
            $property_detail = $this->inquiry_model->get_property_detail($property_id);
            $property_link = array();
            $property_link_path = base_url() . "home/view_property";

            array_push($property_link, $property_link_path . $property_detail[0]->id);
            $property_buy_sale = $this->session->userdata('customer_property_buy_sale');
            $data_inqury = $this->inquiry_model->insert_inquiry($_POST, $property_id, $inquiry_num, $property_buy_sale, $property_detail);

            $cust_id = $this->session->userdata('customer_property_id');
            $customer_detail = $this->inquiry_model->get_customer_detail($cust_id);

            $this->mailChimpSubscribe($cust_id);

            $agent_detail = $this->inquiry_model->get_agent_email($_POST['agent']);
            $agent_property_link_path = base_url() . "home/appointment_conform/" . $data_inqury . "/" . $agent_detail[0]->id;

            $agent_mobile_cntry_code = $this->user->get_contry_code($agent_detail[0]->coutry_code);

            if (!empty($agent_mobile_cntry_code)) {
                $agentmcode = substr($agent_mobile_cntry_code[0]->prefix_code, 1);
                $agentcn_mobile_code = "00" . $agentmcode;
            } else {
                $agentcn_mobile_code = "0000";
            }
            // echo'<pre>';print_r($customer_detail);exit; 
            $clientcountry_code = $this->user->get_contry_code($customer_detail[0]->coutry_code);
            if (!empty($clientcountry_code)) {
                $clientmcode = substr($clientcountry_code[0]->prefix_code, 1);
                $clientmobile_code = "00" . $clientmcode;
            } else {
                $clientmobile_code = "0000";
            }
            $data = array(
                'agent_email' => $agent_detail[0]->email,
                'agent_mobile' => $agentcn_mobile_code . $agent_detail[0]->mobile_no,
                'agent_name' => $agent_detail[0]->fname . ' ' . $agent_detail[0]->lname,
                'customer_email' => $customer_detail[0]->email,
                'customer_name' => $customer_detail[0]->fname . ' ' . $customer_detail[0]->lname,
                'customer_mobile' => $clientmobile_code . $customer_detail[0]->mobile_no,
                'property_ref_no' => $property_detail[0]->reference_no,
                'start_date' => $_POST['start_date'],
                'end_date' => $_POST['end_date'],
                //'property_link_url' => $property_link_url[0],
                'property_link' => $property_link[0],
                'agent_property_link_path' => $agent_property_link_path
            );

            /* code for notificatin to agent and customer */
            $this->load->model('customer_model');
            $customer = $this->customer_model->getCustomer($cust_id);
            $agent = $this->user->getUserByID($_POST['agent']);

            /* Notify customer */
            $subject = "Your appointment assigned to agent";
            $message = $this->load->view("email/property_client_appointment_email", $data, TRUE);

            $sms = "Dear " . $customer->fname . " " . $customer->lname . ", your request for appointment on :" . $_POST['start_date'] . ' to ' . $_POST['end_date'];
            $sms .= " for the property with Reference No: " . $property_detail[0]->reference_no . ",";
            $sms .= " will be confirmed by our agent: " . $agent->fname . " " . $agent->lname . ", Mobile Number: +" . $agent->prefix_code . $agent->mobile_no;
            $sms .= " shortly";

            $this->notifyUser($customer, $subject, $message, $sms, $data_inqury);

            /* Notify agent */
            $subject = "New appointment need to confirm";
            $message = $this->load->view("email/property_agent_appointment_email", $data, TRUE);

            $sms = "Dear " . $agent->fname . " " . $agent->lname . ", new request for appointment on " . $_POST['start_date'] . " to " . $_POST['end_date'];
            $sms .= " for the property with Reference No: " . $property_detail[0]->reference_no . ",";
            $sms .= " Inquiry from: " . $customer->fname . " " . $customer->lname . ", Mobile Number: +" . $customer->prefix_code . $customer->mobile_no . ",";
            $sms .= " Confirmation link: " . $agent_property_link_path;

            $this->notifyUser($agent, $subject, $message, $sms, $data_inqury);

            /* sms send agent end */
            $this->session->set_flashdata('success', 'Appointment added successfull.');
            $this->session->unset_userdata('customer_property_id');
            redirect('inquiry/inquiry_manage');
        }


        $data = array();
        $this->load->model('calendar_model');
        $user = $this->cur_user;
        $data['user'] = $user;

        $config = $this->config->item('pagination');
        $config['per_page'] = 10;

        $page = 1;
        if ($this->uri->segment(3)) {
            $page = $this->uri->segment(3);
        }

        if (isset($_REQUEST['per_page']) && !empty($_REQUEST['per_page'])) {
            $config['per_page'] = $_REQUEST['per_page'];
        }

        $calendar = array();
        if (isset($_REQUEST['calendar']) && !empty($_REQUEST['calendar'])) {
            $calendar = $_REQUEST['calendar'];
        }


        $inquiry_for = (!empty($calendar) && isset($calendar['view']) && !empty($calendar['view'])) ? $calendar['view'] : '';
        $inquiry_client = (!empty($calendar) && isset($calendar['view_client']) && !empty($calendar['view_client'])) ? $calendar['view_client'] : '';


        $selected_user = (!empty($calendar) && isset($calendar['user_id']) && !empty($calendar['user_id'])) ? $calendar['user_id'] : array();
        if (!empty($selected_user)) {
            $selected_user = $this->calendar_model->getUserByID($selected_user);
        }
        
        $inc_search = "";
        if (isset($calendar['inc_search']) && !empty($calendar['inc_search'])) {
            $inc_search = $calendar['inc_search'];
        }
        
        $total_rows = $this->calendar_model->getAllinquiryCount($user, false, $selected_user, '', '', $inquiry_for, $inquiry_client,$inc_search);

               
        $this->load->library('pagination');
        $config['base_url'] = base_url() . 'inquiry/inquiry_manage';
        $config['total_rows'] = $total_rows;

        $this->pagination->initialize($config);

        $offset = ($page * $config['per_page']) - $config['per_page'];

        $order_by = 'inquiry.created_date';
        $order_type = 'desc';

        if (isset($calendar['order_by']) && !empty($calendar['order_by'])) {
            $order_by = $calendar['order_by'];
            $order_type = (isset($calendar['order_type']) && !empty($calendar['order_type']) ) ? $calendar['order_type'] : 'asc';
        }

        $data['inquiries'] = $this->calendar_model->getAllinquiryPage($user, $config['per_page'], $offset, false, $selected_user, '', '', $inquiry_for, $inquiry_client, $order_by, $order_type,$inc_search);

        $data['start'] = 0;
        if ($total_rows > 0) {
            $data['start'] = $offset + 1;
        }

        $data['end'] = $offset + $config['per_page'];
        if ($data['end'] > $total_rows) {
            $data['end'] = $total_rows;
        }
        $data['calendar'] = $calendar;
        $data['total_rows'] = $total_rows;
        $data['pagination'] = $this->pagination->create_links();
        $data['all_users'] = $this->calendar_model->getAllUsers();

        /* if (empty($_GET['view'])) {
          if (!empty($_GET['view_client'])) {
          $inc_view = $_GET['view_client'];
          $client = '1';
          } else {
          $inc_view = "";
          $client = '';
          }
          } else {
          $inc_view = $_GET['view'];
          $client = '';
          }
          $data['user'] = $this->inquiry_model->getAllinquiry($inc_view, $client);

          foreach ($data['user'] as $z => $val) {
          $data['user'][$z]->agent_name = $this->inquiry_model->get_inc_agent($val->agent_id);
          } */
        $data['all_client'] = $this->user->getallclient();

        $this->load->view('inquiry_list_view', $data);
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

    function new_client() {
        if ($this->session->userdata('logged_in_super_user') || $this->session->userdata('logged_in_agent') || $this->session->userdata('logged_in_employee')) {

            //$id = $sessionData['id'];
            if (isset($_POST) && isset($_POST['email_mobile']) && !empty($_POST['email_mobile'])) {
                if (is_numeric($_POST['email_mobile'])) {
                    $_POST['mobile_no'] = $_POST['email_mobile'];
                } else {
                    $_POST['email'] = $_POST['email_mobile'];
                }
            }
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
        if (!empty($customer_datail)) {
            if ($customer_datail[0]->status == 'Inactive') {
                echo "inactive";
                exit;
            } else {
                //$this->session->set_userdata('customer_property_status', $_POST['aquired']);
                $this->session->set_userdata('customer_property_id', $customer_datail[0]->id);
                $this->session->set_userdata('customer_name_property', $customer_datail[0]->fname . " " . $customer_datail[0]->lname);
                echo "true";
                exit;
            }
        } else {
            echo "false";
            exit;
        }
    }

    function check_new_client_form_exit() {

        $customer_datail_email = $this->inquiry_model->check_new_client_form_emailexit($_POST);
        $customer_datail_mobile = $this->inquiry_model->check_new_client_form_mobileexit($_POST);
        //echo'<pre>';print_r($customer_datail_email);
        if (!empty($customer_datail_email) && !empty($customer_datail_mobile)) {//exit('sdf');
            $this->session->set_userdata('customer_property_id', $customer_datail_mobile[0]->id);
            $this->session->set_userdata('customer_name_property', $customer_datail_mobile[0]->fname . " " . $customer_datail_mobile[0]->lname);
            echo "both";
            exit;
        } else if (!empty($customer_datail_email)) {//exit('sdf1');
            $this->session->set_userdata('customer_property_id', $customer_datail_email[0]->id);
            $this->session->set_userdata('customer_name_property', $customer_datail_email[0]->fname . " " . $customer_datail_email[0]->lname);
            echo "email";
            exit;
        } else if (!empty($customer_datail_mobile)) {//exit('sdf2');
            $this->session->set_userdata('customer_property_id', $customer_datail_mobile[0]->id);
            $this->session->set_userdata('customer_name_property', $customer_datail_mobile[0]->fname . " " . $customer_datail_mobile[0]->lname);
            echo "mobile";
            exit;
        } else {//exit('sdfsd');
            echo "submit";
            exit;
        }
    }

    function property() {
        if ($this->session->userdata('logged_in_super_user') || $this->session->userdata('logged_in_agent') || $this->session->userdata('logged_in_employee')) {
            //$this->session->unset_userdata('selected_property_id');

            $data['inquiry_flag'] = "1";
            if ($this->session->userdata('customer_property_id')) {
                if (!empty($_POST['aquired'])) {
                    $this->session->set_userdata('customer_property_buy_sale', $_POST['aquired']);
                }
                $data['city'] = $this->inquiry_model->getAllcity();
                $data['city_area'] = $this->inquiry_model->getAllcity_area();
                $data['bedroom'] = array('1' => 1, '2' => 2, '3' => 3, '4' => 4, '5' => 5, '6' => 6);
                $data['bathroom'] = array('1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5', '6' => '6', '7' => '7');
                $data['bedroom'] = array('1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5', '6' => '6', '7' => '7');
                $data['category'] = array('0' => ' [Select all]', '1' => 'Duplex', '2' => 'Apartment', '3' => 'Penthouse', '4' => 'Garden Apartments', '5' => 'Studio', '6' => 'Townhouse', '7' => 'Villa', '8' => 'Bungalow', '9' => 'Land', '10' => 'Shop', '11' => 'Office', '12' => 'Business', '13' => 'Hotel', '14' => 'Restaurant', '15' => 'Building', '16' => 'Industrial estate', '17' => 'House', '18' => 'Upper-House', '19' => 'Maisonette');

                if (!empty($_POST['property_type'])) {

                    if (!empty($_POST['inq_apment']) && $_POST['inq_apment'] == "inquiry") {
                        $data['inquiry_flag'] = "1";
                    } else {
                        $data['inquiry_flag'] = "0";
                    }
                    $data['post_property_data'] = $_POST;
                    $data['search_detail'] = $this->inquiry_model->getrelated_property($_POST);
                    $data['property_types'] = $this->config->item('property_type');
                    $data['aquired_types'] = $this->config->item('aquired_type');
                    $this->load->view('search_property_view', $data);
                } else {
                    $data['post_property_data'] = array();
                    $data['search_detail'] = array();
                    $this->load->view('search_property_view', $data);
                }
            } else {
                redirect('home', 'refresh');
            }
        } else {
            //If no session, redirect to login page
            redirect('login', 'refresh');
        }
    }

    function property_search_result() {


        $agent_properties = ($_GET['agent_properties'] == 1) ? true : false;

        $_POST['user_id'] = $this->cur_user['id'];

        $user = $this->inquiry_model->getrelated_property($_POST, $agent_properties);

        $property_types = $this->config->item('property_type');
        $aquired_types = $this->config->item('aquired_type');
        for ($i = 0; $i < count($user); $i++) {
            echo "<tr>";
            echo '<td data-th="id." hidden><div>' . $user[$i]->id . '</div></td>';
            echo '<td data-th="Reference No."><div>' . $user[$i]->reference_no . "</br></br>Created on " . date("d-M-Y", strtotime($user[$i]->created_date)) . "</br></br>Updated on  " . date("d-M-Y", strtotime($user[$i]->updated_date)) . '</div></td>';
            echo '<td data-th="Title"><div>';

            if (!empty($user[$i]->bedroom) && $user[$i]->bedroom != 0) {
                echo $user[$i]->bedroom . ' Bedroom ';
            }

            if (!empty($user[$i]->property_type) && $user[$i]->property_type != 0) {
                echo $property_types[$user[$i]->property_type];
            }

            if (!empty($user[$i]->type) && $user[$i]->type != 0) {
                echo ' for ' . $aquired_types[$user[$i]->type];
            }
            echo '</div></td>';
            echo '<td data-th="Agent Name"><div>' . $user[$i]->fname . " " . $user[$i]->lname . '</div></td>';
            echo '<td data-th="Property Area"><div>' . $user[$i]->title . '</div></td>';

            if ($user[$i]->type == '1') {
                //echo '<td data-th="Property Status"><div>' ."Sale". '</div></td>';
                if (!empty($user[$i]->sale_price)) {
                    echo '<td data-th="Price(€)" style="text-align: right"><div> ' . "SP. € " . number_format($user[$i]->sale_price, 0, ".", ",") . '</div></td>';
                } else {
                    echo '<td data-th="Price(€)"><div></div> </td>';
                }
            } elseif ($user[$i]->type == '2') {
                // echo '<td data-th="Property Status"><div>' ."Rent". '</div></td>';
                if (!empty($user[$i]->rent_price)) {
                    echo '<td data-th="Price(€)" style="text-align: right"><div> ' . "RP. € " . number_format($user[$i]->rent_price, 0, ".", ",") . '</div></td>';
                } else {
                    echo '<td data-th="Price(€)"><div></div> </td>';
                }
            } elseif ($user[$i]->type == '3') {
                //echo '<td data-th="Property Status"><div>' ."Both(Sale/Rent)". '</div></td>';

                if (isset($_POST['property_type']) && $_POST['property_type'] == 1) {
                    if (!empty($user[$i]->sale_price)) {
                        echo '<td data-th="Price(€)" style="text-align: min-width:85px" ><div> SP. € ' . number_format($user[$i]->sale_price, 0, ".", ",") . '</div></td>';
                    } else {
                        echo '<td data-th="Price(€)"><div></div> </td>';
                    }
                } else if (isset($_POST['property_type']) && $_POST['property_type'] == 2) {
                    if (!empty($user[$i]->rent_price)) {
                        echo '<td data-th="Price(€)" style="text-align: min-width:85px" ><div> RP. € ' . number_format($user[$i]->rent_price, 0, ".", ",") . '</div></td>';
                    } else {
                        echo '<td data-th="Price(€)"><div></div> </td>';
                    }
                }
            } else {
                //echo '<td data-th="Property Status"><div></div> </td>';
                echo '<td data-th="Price(€)"><div> </div></td>';
            }
            echo '<td data-th="Furnish Type" style="min-width:60px"><div>';

            if ($user[$i]->furnished_type == '1') {
                echo 'Furnished';
            } elseif ($user[$i]->furnished_type == '2') {
                echo 'Semi-Furnished';
            } elseif ($user[$i]->furnished_type == '3') {
                echo 'Un-Furnished';
            }
            echo '</div></td>';
            if (!empty($user[$i]->extra_image)) {
                echo '<td data-th="Image"><div>';
                echo '<img src="' . base_url() . "img_prop/100x100/" . $user[$i]->extra_image . '" width="75" height="75">';
                echo '</div></td>';
            } else {
                echo '<td data-th="Image"><div>';
                echo '<img src="' . base_url() . 'upload/property/100x100/noimage.jpg" width="75" height="75">';
                echo '</div></td>';
            }
            echo '<td data-th="Status">';
            echo '<div>';
            echo '<div class="sep"></div><div class="sep"></div><div class="sep"></div>';
            if ($user[$i]->status == 'Active') {
                echo '<span style="width:10px;height:10px;display:inline-block;background:#5cb85c;"></span> Active';
            } else {
                echo '<span style="width:10px;height:10px;display:inline-block;background:#d9534f;"></span> Inactive';
            }
            echo '</div>';
            echo '</td>';
            echo '<td data-th="Actions">';
            echo '<div>';
            echo '<a data-toggle="modal" data-target="#myModal" onclick="setPropertyId(' . $user[$i]->id . ')" class="btn btn-default btn-xs action-btn" rel="tooltip" title="Send Inquiry"><i class="fa fa-paper-plane"></i></a>';
            echo '<a href="view_property/' . $user[$i]->id . '"  target="_blank" class="btn btn-default btn-xs action-btn" rel="tooltip" title="View"><i class="fa fa-eye"></i></a>';
            echo '<a href="add_property/' . $user[$i]->id . '" class="btn btn-default btn-xs action-btn" rel="tooltip" title="Edit"><i class="fa fa-pencil"></i></a>';

            if ($this->session->userdata('logged_in_super_user')) {
                echo '<a href="delete_property/' . $user[$i]->id . '" onclick="return confirm("Are you sure want to delete this record?");" class="btn btn-danger btn-xs action-btn" rel="tooltip" title="Delete"><i class="fa fa-trash"></i></a>';
            }
            echo '</div>';
            echo '</td>';
            echo '</tr>';
        }
    }

    function sendMultipleInquiry() {
        if ($this->session->userdata('logged_in_super_user') || $this->session->userdata('logged_in_agent') || $this->session->userdata('logged_in_employee')) {
            //$this->session->unset_userdata('selected_property_id');
            if ($this->session->userdata('customer_property_id')) {
                if (isset($_POST['Proceed']) && $_POST['Proceed'] != "") {

                    $allPropertyIdsArr = explode(",", $_POST['allPropertyIds']);
                    $getSelectedPropertyDetails = $this->inquiry_model->getPropertyDetailsById($allPropertyIdsArr);

                    $customerId = $this->session->userdata('customer_property_id');
                    $property_buy_sale = $this->session->userdata('customer_property_buy_sale');

                    $property_link = array();
                    $property_title = array();
                    $property_link_path = base_url() . "index.php/home/view_property/";
                    foreach ($getSelectedPropertyDetails as $inqKey => $inqValue) {

                        // Get Unique Inquiry Reference Number
                        $inquiry_num = $this->unic_inquiry_num();
                        if ($inquiryid = $this->inquiry_model->saveClientInquiry($customerId, $inqValue->id, $inqValue->reference_no, $inquiry_num, $property_buy_sale)) {
                            $this->inquiry_model->saveClientInquiry_history($_POST, $inquiryid);
                            array_push($property_link, $property_link_path . $inqValue->id);

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

                            array_push($property_title, $inqValue->reference_no . ", " . $inqValue->bedroom . " Bedrooms " . $property_category . " for " . $type);
                        }
                    }
                    $this->mailChimpSubscribe($customerId);

                    // Send Email for New client Inquiry

                    if ($_POST['sendInquiryBy'] == "sendEmail") {
                        $cust_id = $this->session->userdata('customer_property_id');
                        /* code for notificatin to agent and customer */
                        $this->load->model('customer_model');
                        $customer = $this->customer_model->getCustomer($cust_id);
                        $data = array(
                            'customer_email' => $customer->email,
                            'customer_name' => $customer->fname . ' ' . $customer->lname,
                            'property_links' => $property_link,
                            'property_title' => $property_title,
                            'property_link' => $property_link
                                //'bedroom'=>$bedroom_detail,
                                //'property_category'=>$property_category,
                                //'property_type'=>$property_type
                        );
                        /* Notify customer */
                        $subject = "Welcome to Monopolion System";
                        $message = $this->load->view("email/multiple_inquiry", $data, TRUE);

                        $sms = " ";
                        $this->notifyUser($customer, $subject, $message, $sms, $inquiryid, 1);


                        $this->session->unset_userdata('customer_property_id');
                        $this->session->set_flashdata('success', 'Success! Inquiry for the Property sent successfully. Email send successfull.!');
                        redirect('inquiry/inquiry_manage');
                    } else if ($_POST['sendInquiryBy'] == "sendSms") {
                        $cust_id = $this->session->userdata('customer_property_id');
                        /* code for notificatin to agent and customer */
                        $this->load->model('customer_model');
                        $customer = $this->customer_model->getCustomer($cust_id);

                        /* Notify customer */
                        $subject = "";
                        $message = "";

                        $sms = "Dear " . $customer->fname . " " . $customer->lname . ", ";
                        $sms .="Following attached link for property as per your requirements ";
                        if (!empty($property_title)) {
                            foreach ($property_title as $key => $value) {
                                $property_title[$key] = "Reference No: " . $value;
                            }
                        }
                        if (!empty($property_link)) {
                            foreach ($property_link as $key => $value) {
                                $sms .=$property_title[$key] . ' : ';
                                $sms .= $value;
                                $sms .=", \n";
                            }
                        }
                        $sms .= " For any further information please call: 8000 7000";
                        $sms .= " Thanks,";
                        $sms .= " Monopolion Team";
                        $this->notifyUser($customer, $subject, $message, $sms, $inquiryid, 2);
                        /* sms send end */
                        $this->session->unset_userdata('customer_property_id');
                        $this->session->set_flashdata('success', 'Success! Inquiry for the Property sent successfully. SMS send successfull.!');
                        redirect('inquiry/inquiry_manage');
                    } elseif ($_POST['sendInquiryBy'] == "sendBoth") {
                        $cust_id = $this->session->userdata('customer_property_id');

                        /* code for notificatin to agent and customer */
                        $this->load->model('customer_model');
                        $customer = $this->customer_model->getCustomer($cust_id);
                        $data = array(
                            'customer_email' => $customer->email,
                            'customer_name' => $customer->fname . ' ' . $customer->lname,
                            'property_links' => $property_link,
                            'property_title' => $property_title,
                            'property_link' => $property_link
                                // 'bedroom'=>$bedroom_detail,
                                // 'property_category'=>$property_category,
                                // 'property_type'=>$propety_type
                        );
                        /* Notify customer */
                        $subject = "New Client Inquiry";
                        $message = $this->load->view("email/multiple_inquiry", $data, TRUE);

                        $sms = "Dear " . $customer->fname . " " . $customer->lname . ", ";
                        $sms .="Following attached link for property as per your requirements ";
                        if (!empty($property_title)) {
                            foreach ($property_title as $key => $value) {
                                $property_title[$key] = "Reference No: " . $value;
                            }
                        }
                        if (!empty($property_link)) {
                            foreach ($property_link as $key => $value) {
                                $sms .=$property_title[$key] . " : ";
                                $sms .= $value;
                                $sms .=", \n";
                            }
                        }
                        $sms .= " For any further information please call: 8000 7000";
                        $sms .= " Thanks,";
                        $sms .= " Monopolion Team";
                        $this->notifyUser($customer, $subject, $message, $sms, $inquiryid);
                        //$this->session->set_flashdata('success', 'Success! Inquiry for the Property sent successfully. Email and SMS send successfull.!');
                        //$this->session->set_flashdata('success', 'Success! Inquiry for the Property sent successfully. SMS send successfull.!');
                        //$this->session->set_flashdata('success', 'Success! Inquiry for the Property sent successfully. Email send successfull.!');
                        //$this->session->set_flashdata('success', 'Success! Inquiry for the Property sent successfully.!');
                        redirect('inquiry/inquiry_manage');
                    } else {
                        $this->session->set_flashdata('success', 'Email and SMS not send beacuse somethig wrong.');
                        redirect('inquiry/inquiry_manage');
                        # code for both send sms and email here...                        
                    }
                }
            } else {
                redirect('home', 'refresh');
            }
        } else {
            //If no session, redirect to login page
            redirect('login', 'refresh');
        }
    }

    function scheduleAppointment($inquiryId) {
        if ($inquiryId != "") {
            $inquiryDetail = $this->inquiry_model->getInquiryDetailById($inquiryId);

            if ($inquiryDetail[0]->property_id == "0") {
                $this->session->set_userdata('customer_property_id', $inquiryDetail[0]->customer_id);
                $this->session->set_userdata('customer_property_buy_sale', $inquiryDetail[0]->aquired);
                $this->session->set_userdata('appointment_selected', "1");
                redirect('/inquiry/property', 'refresh');
            } else {
                //elseif($inquiryDetail[0]->appoint_start_date == "0000-00-00 00:00:00" && $inquiryDetail[0]->appoint_end_date == "0000-00-00 00:00:00")
                $this->session->unset_userdata('selected_property_id');
                $this->session->set_userdata('selected_property_id', $inquiryDetail[0]->property_id);
                $this->session->set_userdata('customer_property_id', $inquiryDetail[0]->customer_id);
                $pro_agent_id = $this->inquiry_model->get_related_property_agent_id($inquiryDetail[0]->property_id);
                $this->session->set_userdata('selected_agent_id', $pro_agent_id[0]->agent_id);
                $this->session->set_userdata('schedule_inquiry_id', $inquiryId);
                redirect('/inquiry/agent_calendar', 'refresh');
            }
        }
    }

    function calendar() {
        if ($this->session->userdata('logged_in_super_user') || $this->session->userdata('logged_in_agent') || $this->session->userdata('logged_in_employee')) {

            // $year=date("Y");
            //$month= date("m");
            //$post= array('month' =>$month ,'year'=>$year);
            //echo'<pre>';print_r($post);exit;
            //$data['data']= $this->inquiry_model->agent_schedule_month_vice($post);
            $this->load->view('calendar_view');
        } else {
            //If no session, redirect to login page
            redirect('login', 'refresh');
        }
    }

    function show_month_year_record() {
        //echo'<pre>';print_r($_POST);exit;
        $data['data'] = $this->inquiry_model->agent_schedule_month_vice($_POST);
        $date_arr = array();
        $htmldiv = "";
        foreach ($data['data'] as $key => $value) {
            if (!in_array(date("d-M-Y", strtotime($value->appoint_start_date)), $date_arr)) {
                array_push($date_arr, date("d-M-Y", strtotime($value->appoint_start_date)));

                $htmldiv .= '<div class="cldcolm-main">';
                $htmldiv .= '<div class="cldcolm-main-left">' . date("D", strtotime($value->appoint_start_date)) . '</div>';
                $htmldiv .= '<div class="cldcolm-main-right">' . date("d-M-Y", strtotime($value->appoint_start_date)) . '</div>';
                $htmldiv .= '<div class="clear"></div>';
                $htmldiv .= '</div>';
            }

            $htmldiv .= '<div class="cldcolm">';
            $htmldiv .= '<div class="cldcolm01"> start: ' . date("h:i A", strtotime($value->appoint_start_date)) . '<br /> end: ' . date("h:i A", strtotime($value->appoint_end_date)) . '</div>';

            $htmldiv .= '<div class="cldcolm02">';
            $htmldiv .= '<h1>Dear ' . $value->fname . ' ' . $value->lname . '</h1>';
            $htmldiv .= 'Your appointment for Property Reference Number : ' . $value->property_ref_no . ' Please be on time.';
            $htmldiv .= '</div>';

            $htmldiv .= '<div class="cldcolm03"><a href="#"><img src="' . base_url() . 'img/list.png" alt="" /></a></div>';
            $htmldiv .= '<div class="clear"></div>';
            $htmldiv .= '</div>';
        }
        echo $htmldiv;
    }

    function agent_calendar() {

        if ($this->session->userdata('appointment_selected')) {
            $this->session->unset_userdata('appointment_selected');
        }

        $data = array();
        if (!empty($_POST['property_name'])) {
            $this->session->set_userdata('selected_property_id', $_POST['property_name']);

            if (!isset($_POST['agent_id'])) {
                $pro_agent_id = $this->inquiry_model->get_related_property_agent_id($_POST['property_name']);
                $this->session->set_userdata('selected_agent_id', $pro_agent_id[0]->agent_id);
            } else {
                $this->session->set_userdata('selected_agent_id', $_POST['agent_id']);
                $data['agent_id'] = $_POST['agent_id'];
                $data['inquiry_id'] = $_POST['inquiry_id'];
                $data['property_id'] = $_POST['property_name'];
            }

            $data['allAgent'] = $this->inquiry_model->getAll_appointmentAgent();
            $this->load->view('agent_calendar', $data);
        } elseif ($this->session->userdata('selected_property_id')) {
            $data['allAgent'] = $this->inquiry_model->getAll_appointmentAgent();
            $this->load->view('agent_calendar', $data);
        } else {
            redirect('inquiry/property', 'refresh');
        }
        // $data['allAgent'] = $this->inquiry_model->getAllAgent();
        // $this->load->view('agent_calendar',$data);
    }

    function get_agent_calandar_detail() {
        $data = $this->inquiry_model->agent_schedule();
        // echo'<pre>';print_r($data);exit;
        foreach ($data as $z => $val) {
            //$rand = dechex(rand(0x000000, 0xFFFFFF));
            if (trim($val->agent_status) == '0') {
                $rand = "00bfff";
            } elseif (trim($val->agent_status) == '1') {
                $rand = "EBAF22";
            } elseif (trim($val->agent_status) == '2') {
                $rand = "FFCCFF";
            } else {
                $rand = "ffffff";
            }

            $data[$z]->color = ('#' . $rand);
            $data[$z]->title = $val->fname . ' ' . $val->lname;
            $data[$z]->status = $val->agent_status;
            $data[$z]->id = $val->id;
            $data[$z]->description = 'Appointment start: ' . date("Y-m-d H:i:s", strtotime($val->appoint_start_date)) . " to Appointment end : " . date("Y-m-d H:i:s", strtotime($val->appoint_end_date));
            $data[$z]->start = $val->appoint_start_date;
            $data[$z]->end = $val->appoint_end_date;
        }
        // echo'<pre>';print_r($data);exit;
        echo json_encode($data);
    }

    function get_agent_calender_details_byId($id) {
        $data = $this->inquiry_model->agent_detail_byid($id);

        foreach ($data as $z => $val) {
            $rand = dechex(rand(0x000000, 0xFFFFFF));

            $data[$z]->color = ('#' . $rand);
            $data[$z]->title = date("H:i", strtotime($val->appoint_start_date)) . " to: " . date("H:i", strtotime($val->appoint_end_date));
            $data[$z]->start = $val->appoint_start_date;
            $data[$z]->end = $val->appoint_end_date;
        }
        echo json_encode($data);
    }

    function get_agent_appoinment_date($id) {
        $data = $this->inquiry_model->agent_detail_byid($id);
        foreach ($data as $z => $val) {
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

    function check_agent_free_selectdate() {
        $data = $this->inquiry_model->check_agent_free_selectdate($_POST);
        if (!empty($data)) {
            echo "false";
            exit;
        } else {
            echo "true";
            exit;
        }
    }

    function get_inquiry_recored() {

        $data = $this->inquiry_model->get_inquiry_recored($_POST['inquiry_id']);

        $data[0]->agent_id = $this->inquiry_model->get_agent_name_inq($data[0]->agent_id);
        // echo'<pre>';print_r($data);exit;
        $inquiryDetailHtml = "";

        if ($this->session->userdata('logged_in_employee')) {
            if ($data[0]->status != 5) {
                $inquiryDetailHtml .= "<fieldset><legend>Customer Details</legend>";
                if ((isset($data[0]->agent_id) && !empty($data[0]->c_fname) ) || (isset($data[0]->c_lname) && !empty($data[0]->c_lname) )) {
                    $inquiryDetailHtml .= '<lable><b>Customer Name</b></lable> :<lable>' . $data[0]->c_fname . ' ' . $data[0]->c_lname . '</lable> ';
                    $inquiryDetailHtml .= '<br><br>';
                }
                if ((isset($data[0]->email) && !empty($data[0]->email))) {
                    $inquiryDetailHtml .= '<lable><b>Customer Email</b></lable> :<lable>' . $data[0]->email . '</lable> ';
                    $inquiryDetailHtml .= '<br><br>';
                }

                if ((isset($data[0]->mobile_no) && !empty($data[0]->mobile_no))) {
                    $inquiryDetailHtml .= '<lable><b>Customer Phone</b></lable> :<lable>' . $data[0]->prefix_code . ' ' . $data[0]->mobile_no . '</lable> ';
                    $inquiryDetailHtml .= '<br><br>';
                }
                $inquiryDetailHtml .= "</fieldset>";
            }
        } else {
            $inquiryDetailHtml .= "<fieldset><legend>Customer Details</legend>";
            if ((isset($data[0]->agent_id) && !empty($data[0]->c_fname) ) || (isset($data[0]->c_lname) && !empty($data[0]->c_lname) )) {
                $inquiryDetailHtml .= '<lable><b>Customer Name</b></lable> :<lable>' . $data[0]->c_fname . ' ' . $data[0]->c_lname . '</lable> ';
                $inquiryDetailHtml .= '<br><br>';
            }
            if ((isset($data[0]->email) && !empty($data[0]->email))) {
                $inquiryDetailHtml .= '<lable><b>Customer Email</b></lable> :<lable>' . $data[0]->email . '</lable> ';
                $inquiryDetailHtml .= '<br><br>';
            }

            if ((isset($data[0]->mobile_no) && !empty($data[0]->mobile_no))) {
                $inquiryDetailHtml .= '<lable><b>Customer Phone</b></lable> :<lable>' . $data[0]->prefix_code . ' ' . $data[0]->mobile_no . '</lable> ';
                $inquiryDetailHtml .= '<br><br>';
            }
            $inquiryDetailHtml .= "</fieldset>";
        }

        $inquiryDetailHtml .= "<fieldset><legend>Inquiry Details</legend>";
        if (isset($data[0]->agent_id) && !empty($data[0]->agent_id)) {
            $inquiryDetailHtml .= '<lable><b>Agent Name</b></lable> :<lable>' . $data[0]->agent_id[0]->fname . ' -' . $data[0]->agent_id[0]->lname . '</lable> ';
            $inquiryDetailHtml .= '<br><br>';
        }

        if (isset($data[0]->incquiry_ref_no) && !empty($data[0]->incquiry_ref_no)) {
            $inquiryDetailHtml .= '<lable><b>Inquiry Reference No</b></lable> :<lable>' . $data[0]->incquiry_ref_no . '</lable> ';
            $inquiryDetailHtml .= '<br><br>';
        }
        if (isset($data[0]->title) && !empty($data[0]->title)) {
            $inquiryDetailHtml .= '<lable><b>Property Area</b></lable> :<lable>' . $data[0]->title . '</lable> ';
            $inquiryDetailHtml .= '<br><br>';
        }
        if (isset($data[0]->property_type) && !empty($data[0]->property_type)) {
            $property_data = $this->get_propertytypeby_id($data[0]->property_type);
            $inquiryDetailHtml .= '<lable><b>Property Type</b></lable> :<lable>' . $property_data . '</lable> ';
            $inquiryDetailHtml .= '<br><br>';
        }


        if (isset($data[0]->aquired) && !empty($data[0]->aquired)) {
            if (trim($data[0]->aquired) == 'rent') {
                $data[0]->aquired = 'Rent';
            } elseif (trim($data[0]->aquired) == 'sale') {
                $data[0]->aquired = 'Sale';
            } elseif (trim($data[0]->aquired) == 'both') {
                $data[0]->aquired = 'Sale/Rent';
            }
            $inquiryDetailHtml .= '<lable><b>Property Status</b></lable> :<lable>' . $data[0]->aquired . '</lable> ';
            $inquiryDetailHtml .= '<br><br>';
        }

        if (isset($data[0]->bathroom) && !empty($data[0]->bathroom)) {
            $inquiryDetailHtml .= '<lable><b>Bathrooms</lable> :<lable>' . $data[0]->bathroom . '</lable> ';
            $inquiryDetailHtml .= '<br><br>';
        }

        if (isset($data[0]->badroom) && !empty($data[0]->badroom)) {
            $inquiryDetailHtml .= '<lable><b>Bedrooms</b></lable> :<lable>' . $data[0]->badroom . '</lable> ';
            $inquiryDetailHtml .= '<br><br>';
        }

        if (isset($data[0]->property_ref_no) && !empty($data[0]->property_ref_no)) {
            $inquiryDetailHtml .= '<lable><b>Property Reference No</b></lable> :<lable>' . $data[0]->reference_no . '</lable> ';
            $inquiryDetailHtml .= '<br><br>';
        }

        if (isset($data[0]->minprice) && !empty($data[0]->minprice)) {
            $inquiryDetailHtml .= '<lable><b>Minimum Price</b></lable> :<lable>' . $data[0]->minprice . '</lable> ';
            $inquiryDetailHtml .= '<br><br>';
        }

        if (isset($data[0]->maxprice) && !empty($data[0]->maxprice)) {
            $inquiryDetailHtml .= '<lable><b>Maximum Price</b></lable> :<lable>' . $data[0]->maxprice . '</lable> ';
            $inquiryDetailHtml .= '<br><br>';
        }
        // if(isset($data[0]->created_date) && !empty($data[0]->created_date)){
        //     $inquiryDetailHtml .= '<lable><b>Date Created</b></lable> :<lable>'.date("d-M-Y", strtotime($data[0]->created_date)).'</lable> ';
        //     $inquiryDetailHtml .=  '<br><br>';
        // }
        $inquiryDetailHtml .= '</fieldset>';

        if (isset($data[0]->comments) && !empty($data[0]->comments)) {
            $inquiryDetailHtml .= "<fieldset><legend>Follow-up Message</legend>";
            $inquiryDetailHtml .= "<p>" . $data[0]->comments . "</p>";
            $inquiryDetailHtml .= '</fieldset>';
        }
        if (isset($data[0]->feedback) && !empty($data[0]->feedback)) {
            $inquiryDetailHtml .= "<fieldset><legend>Feedback Message</legend>";
            $inquiryDetailHtml .= "<p>" . $data[0]->feedback . "</p>";
            $inquiryDetailHtml .= '</fieldset>';
        }

        echo $inquiryDetailHtml;
    }

    function get_sms_email_text() {

        $data = $this->inquiry_model->get_sms_email_text($_POST['id']);

        echo $data[0]->text;
    }

    function get_sms_email_text_report() {

        $data = $this->inquiry_model->get_sms_email_text_report($_POST['id']);
        //echo'<pre>';print_r($data);exit;
        if (!empty($data)) {
            $smss_email = array();
            $smss_email[0] = $data[0]['text'];
            $smss_email[1] = $data[0]['type'];
        } else {
            $smss_email = array();
            $smss_email[0] = "No message found.";
            $smss_email[1] = "";
        }
        // print_r($smss_email);
        echo json_encode($smss_email);
    }

    function ajax_update_status() {

        $id = $_POST['id'];
        if (isset($_POST['property_id']))
            $property_id = $_POST['property_id'];
        $status = $_POST['status'];
        $comments = $_POST['comments'];

        $data = array();
        $data['status'] = $status;
        if ($status == 3) {
            $data['comments'] = $comments;
        } else if ($status == 5) {
            $data['feedback'] = $comments;
        }

        $response = array('status' => false, 'message' => $comments, 'id' => $id, 'inq_status' => $status);
        if ($this->inquiry_model->updateInquiryStatus($id, $data)) {
            
            $inquiry = $this->inquiry_model->get_inquiry_data($id);
            $employee_record = $this->inquiry_model->get_employee_record($id);
            $aget_record = $this->inquiry_model->get_aget_record($inquiry[0]->agent_id);
            $inquiry_and_customer_record = $this->inquiry_model->get_inquiry_data($id);

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
                'type' => $inquiry[0]->agent_status
            );
            if ($status == 3) {
                $subject = "Your Appointment is Following Up";
                $message = $this->load->view("email/appointment_confirm", $data, TRUE);

                $sms = "Dear " . $inquiry_and_customer_record->fname . " " . $inquiry_and_customer_record->lname . ",";
                $sms .=" Your appointment for the property with Reference No: " . $inquiry_and_customer_record->property_ref_no . ",";
                $sms .= " has been changed to Follow Up:" . $inquiry_and_customer_record->appoint_start_date . " to " . $inquiry_and_customer_record->appoint_end_date . ".";
                $sms .= " For any further information please kindly contact";
                $sms .= " our Agent, " . $aget_record->fname . " " . $aget_record->lname . ", Mobile Number: +" . $mobile_code_agent . $aget_record->mobile_no . " or  8000 7000 ";
                $this->notifyUser($inquiry_and_customer_record, $subject, $message, $sms, $id);

                $message = $this->load->view("email/appointment_confirm_employee", $data, TRUE);

                $sms = "Dear " . $employee_name . ",";
                $sms .= " Agent has change the status of Inquiry Reference No: ".$inquiry_and_customer_record->incquiry_ref_no." to Follow Up Mode.";
                $sms .=" For the property with Reference No:" . $inquiry_and_customer_record->property_ref_no;
                $sms .= " Inquiry from, " . $inquiry_and_customer_record->fname . ' ' . $inquiry_and_customer_record->lname;

                $this->notifyUser($employee_record, $subject, $message, $sms, $id);
            } else if ($status == 5) {
                $subject = "Your Appointment is Completed";
                $message = $this->load->view("email/appointment_confirm", $data, TRUE);

                $sms = "Dear " . $inquiry_and_customer_record->fname . " " . $inquiry_and_customer_record->lname . ",";
                $sms .=" Your appointment for the property with Reference No: " . $inquiry_and_customer_record->property_ref_no . ",";
                $sms .= " has been completed:" . $inquiry_and_customer_record->appoint_start_date . " to " . $inquiry_and_customer_record->appoint_end_date . ".";
                $sms .= " For any further information please kindly contact";
                $sms .= " our Agent, " . $aget_record->fname . " " . $aget_record->lname . ", Mobile Number: +" . $mobile_code_agent . $aget_record->mobile_no . " or  8000 7000 ";
                $this->notifyUser($inquiry_and_customer_record, $subject, $message, $sms, $id);

                $message = $this->load->view("email/appointment_confirm_employee", $data, TRUE);

                $sms = "Dear " . $employee_name . ",";
                $sms .= " Agent has change the status of Inquiry Reference No: ".$inquiry_and_customer_record->incquiry_ref_no." to Complete.";
                $sms .=" For the property with Reference No:" . $inquiry_and_customer_record->property_ref_no;
                $sms .= " Inquiry from, " . $inquiry_and_customer_record->fname . ' ' . $inquiry_and_customer_record->lname;

                $this->notifyUser($employee_record, $subject, $message, $sms, $id);
            }
            $response['status'] = true;
        }
        echo json_encode($response);
        exit;
    }

    function appointment_note_add() {
        if ($this->inquiry_model->add_appointment_note($_POST)) {
            $response['status'] = true;
        }
        echo json_encode($response);
        exit;
    }

    function new_inquiries() {
        if (empty($this->cur_user)) {
            redirect('login', 'refresh');
        }

        if ($this->cur_user['type'] == 3) {
            $this->session->set_flashdata('error', 'Not allowed!');
            redirect('home');
            exit;
        }


        if ($this->session->userdata('logged_in_agent')) {
            $user = $this->session->userdata('logged_in_agent');
        } else if ($this->session->userdata('logged_in_super_user')) {
            $user = $this->session->userdata('logged_in_super_user');
        }

        if (isset($_REQUEST['agent_user_id']) && !empty($_REQUEST['agent_user_id'])) {
            if ($_REQUEST['agent_user_id'] != 'all') {
                $user = (array) $this->user->getUserByID($_REQUEST['agent_user_id']);
            } else {
                $user = array();
            }
        }

        $inquiries = $this->inquiry_model->getNewInquiries($user);
        $data = array('inquiries' => $inquiries, 'user' => $this->cur_user);

        if ($this->cur_user['type'] == 1) {
            $data['agents'] = $this->inquiry_model->getAll_appointmentAgent();
        }

        $this->load->view('new_inquiries', $data);
    }

    function ajax_change_inquiry_agent_status() {

        $id = (isset($_POST['id']) && !empty($_POST['id'])) ? $_POST['id'] : 0;
        $agent_status = (isset($_POST['agent_status']) && !empty($_POST['agent_status'])) ? $_POST['agent_status'] : 0;
        $message = (isset($_POST['comments']) && !empty($_POST['comments'])) ? $_POST['comments'] : '';

        $data = array('agent_status' => $agent_status);
        if ($agent_status == 3 && !empty($message)) {
            $data['cancel_message'] = $message;
        }

        $response = array('status' => false, 'msg' => '', 'agent_status' => $agent_status, 'id' => $id);
        if ($this->inquiry_model->changeAgentStatus($id, $data)) {

            $inquiry = $this->inquiry_model->get_inquiry_data($id);

            $employee_record = $this->inquiry_model->get_employee_record($id);
            $aget_record = $this->inquiry_model->get_aget_record($inquiry[0]->agent_id);


            $inquiry_and_customer_record = $this->inquiry_model->get_inquiry_data($id);

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
                'type' => $inquiry[0]->agent_status
            );


            $response['status'] = true;
            if ($agent_status == 1) {

                $subject = $response['msg'] = "Appointment Confirmed";
                $message = $this->load->view("email/appointment_confirm", $data, TRUE);

                $sms = "Dear " . $inquiry_and_customer_record->fname . " " . $inquiry_and_customer_record->lname . ",";
                $sms .=" Your appointment for the property with Reference No: " . $inquiry_and_customer_record->property_ref_no . ", ";
                $sms .= " has been confirmed on:" . $inquiry_and_customer_record->appoint_start_date . " to " . $inquiry_and_customer_record->appoint_end_date . ".";
                $sms .= " For any further information please kindly contact";
                $sms .= " our Agent, " . $aget_record->fname . " " . $aget_record->lname . ", Mobile Number: +" . $mobile_code_agent . $aget_record->mobile_no . " or  8000 7000 ";
                $this->notifyUser($inquiry_and_customer_record, $subject, $message, $sms, $id);

                $message = $this->load->view("email/appointment_confirm_employee", $data, TRUE);

                $sms = "Dear " . $employee_name . ",";
                $sms .= " You  that your  appointment on." . $inquiry_and_customer_record->appoint_start_date . " to " . $inquiry_and_customer_record->appoint_end_date;
                $sms .=" For the property with Reference No:" . $inquiry_and_customer_record->property_ref_no;
                $sms .= " Inquiry from, " . $inquiry_and_customer_record->fname . ' ' . $inquiry_and_customer_record->lname;
                $this->notifyUser($employee_record, $subject, $message, $sms, $id);
            } else if ($agent_status == 2) {
                $subject = $response['msg'] = "Appointment has been sent for rescheduling.";
                $message = $this->load->view("email/appointment_confirm", $data, TRUE);

                $sms = "Dear " . $inquiry_and_customer_record->fname . " " . $inquiry_and_customer_record->lname . ",";
                $sms .=" Your appointment for the property with Reference No: " . $inquiry_and_customer_record->property_ref_no . ", ";
                $sms .= " has been rescheduled on:" . $inquiry_and_customer_record->appoint_start_date . " to " . $inquiry_and_customer_record->appoint_end_date . ".";
                $sms .= " For any further information please kindly contact";
                $sms .= " our Agent, " . $aget_record->fname . " " . $aget_record->lname . ", mobile Number: +" . $mobile_code_agent . $aget_record->mobile_no . " or  8000 7000 ";
                $this->notifyUser($inquiry_and_customer_record, $subject, $message, $sms, $id);

                $message = $this->load->view("email/appointment_confirm_employee", $data, TRUE);
                $sms = "Dear " . $employee_name . ",";
                $sms .= " Your appointment has been Rescheduled";
                $sms .=" For the property with Reference No:" . $inquiry_and_customer_record->property_ref_no;
                $sms .= " Inquiry from, " . $inquiry_and_customer_record->fname . ' ' . $inquiry_and_customer_record->lname;
                $this->notifyUser($employee_record, $subject, $message, $sms, $id);
            } else if ($agent_status == 3) {
                $subject = $response['msg'] = "Appointment request has been cancel.";
                $message = $this->load->view("email/appointment_confirm", $data, TRUE);

                $sms = "Dear " . $inquiry_and_customer_record->fname . " " . $inquiry_and_customer_record->lname . ",";
                $sms .= " Your appointment on: " . $inquiry_and_customer_record->appoint_start_date . " to " . $inquiry_and_customer_record->appoint_end_date . ".";
                $sms .=" for the property with Reference No: " . $inquiry_and_customer_record->property_ref_no . ", has been cancelled";
                $sms .= " For any further information please kindly contact";
                $sms .= " our Agent, " . $aget_record->fname . " " . $aget_record->lname . ", mobile Number: +" . $mobile_code_agent . $aget_record->mobile_no . " or  8000 7000 ";
                $this->notifyUser($inquiry_and_customer_record, $subject, $message, $sms, $id);

                $message = $this->load->view("email/appointment_confirm_employee", $data, TRUE);
                $sms = "Dear " . $employee_name . ",";
                $sms .= " Your appointment has been cancel";
                $sms .=" For the property with Reference No:" . $inquiry_and_customer_record->property_ref_no;
                $sms .= " Inquiry from, " . $inquiry_and_customer_record->fname . ' ' . $inquiry_and_customer_record->lname;
                $this->notifyUser($employee_record, $subject, $message, $sms, $id);
            }
        }
        echo json_encode($response);
        exit;
    }

    function ajax_calaneder_change_status() {

        $id = (isset($_POST['id']) && !empty($_POST['id'])) ? $_POST['id'] : 0;
        $agent_status = (isset($_POST['agent_status']) && !empty($_POST['agent_status'])) ? $_POST['agent_status'] : 0;
        $data = array('agent_status' => $agent_status);
        if ($this->inquiry_model->appointmentchangeAgentStatus($id, $data)) {
            $response['status'] = true;
            if ($agent_status == 1) {



                $response['msg'] = "Appointment has been confirmed";
            } else if ($agent_status == 2) {
                $response['msg'] = "Inquiry has been sent for rescheduling.";
            } else if ($agent_status == 3) {
                $response['msg'] = "Appointment request has been cancel.";
            }
        }
        echo json_encode($response);
        exit;
    }

    function reschedule_inquiries() {

        if (empty($this->cur_user)) {
            redirect('login', 'refresh');
            exit;
        }

        $selected = $user = $this->cur_user;

        if (isset($_REQUEST['employee_user_id']) && !empty($_REQUEST['employee_user_id'])) {
            if ($_REQUEST['employee_user_id'] != 'all') {
                $selected = (array) $this->user->getUserByID($_REQUEST['employee_user_id']);
            } else {
                $selected = array();
            }
        }

        $reschedule_inquiries = $this->inquiry_model->getRescheduleInquiries($selected);

        $data = array('reschedule_inquiries' => $reschedule_inquiries);
        $data['selected'] = $selected;
        $data['user'] = $user;
        if ($this->cur_user['type'] == 1) {
            $data['employees'] = $this->user->getAllemployee(true);
        }
        $this->load->view('reschedule_inquiries', $data);
    }

    function cancel_inquiries() {

        if (empty($this->cur_user)) {
            redirect('login', 'refresh');
            exit;
        }

        $selected = $user = $this->cur_user;

        if (isset($_REQUEST['employee_user_id']) && !empty($_REQUEST['employee_user_id'])) {
            if ($_REQUEST['employee_user_id'] != 'all') {
                $selected = (array) $this->user->getUserByID($_REQUEST['employee_user_id']);
            } else {
                $selected = array();
            }
        }

        $cancel_inquiries = $this->inquiry_model->getCanceledInquiries($selected);
        $data = array('cancel_inquiries' => $cancel_inquiries);
        $data['selected'] = $selected;
        $data['user'] = $user;
        if ($this->cur_user['type'] == 1) {
            $data['employees'] = $this->user->getAllemployee(true);
        }
        $this->load->view('cancel_inquiries', $data);
    }

    function check_client_property_activation() {

        $customer_detail = $this->inquiry_model->check_inquiry_client_record($_POST['custid']);

        if ($_POST['propertyid'] != '0') {
            $property_detail = $this->inquiry_model->check_inquiry_property_record($_POST['propertyid']);
            $flag = '1';
        } else {
            $property_detail = array();
            $flag = '0';
        }
        if (!empty($customer_detail)) {
            if (!empty($property_detail) && $flag = '1') {
                echo 'true';
            } else if (empty($property_detail) && $flag = '1') {
                echo 'property_inactive';
            } else {
                echo 'true';
            }
        } else {
            if (empty($property_detail) && $flag = '1') {
                echo 'customer_property_inactive';
            } else {
                echo 'customer_inactive';
            }
        }
    }

}

?>