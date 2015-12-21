<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once FCPATH . "application/third_party/Classes/PHPExcel.php";

//require_once FCPATH  .'application/third_party/Classes/PHPExcel/IOFactory.php';

class Excelread extends MY_Controller {

    public function __construct() {
        parent::__construct();
        error_reporting(E_ALL);
        $this->load->model('user', '', TRUE);
        $this->load->model('inquiry_model', '', TRUE);
        $this->load->helper('url');
        $this->load->model('Blog_model');
    }

    public function index() {

        ini_set("display_errors", 1);
        error_reporting(E_ALL);
        set_time_limit(0);
        if (isset($_FILES) && !empty($_FILES)) {
            require_once FCPATH . "application/third_party/Classes/PHPExcel/IOFactory.php";
            $str = base_url();
            $arr = explode("/", $str);
            $key = max(array_keys($arr));

            $file_path = APPPATH . '../files';

            $name = rand(1111, 9999) . '_' . $_FILES["xls_files"]["name"];
            $type = $_FILES["xls_files"]["type"];
            $size = $_FILES["xls_files"]["size"];
            $temp = $_FILES["xls_files"]["tmp_name"];
            $error = $_FILES["xls_files"]["error"];

            if ($error > 0)
                die("Error uploading file! code $error.");
            else {
                move_uploaded_file($temp, $file_path . '/' . $name);
            }

            $objPHPExcel = PHPExcel_IOFactory::load($file_path . '/' . $name);
            $cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();
            foreach ($cell_collection as $cell) {
                $column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
                $row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
                $data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();

                if ($row == 1) {
                    $header[$row][$column] = $data_value;
                } else {
                    $arr_data[$row - 1][$column] = $data_value;
                }
            }

            $data['header'] = $header;
            $data['values'] = $arr_data;

            $error = array();
            $i = 0;
            foreach ($header as $fieldkey => $fieldvalue) {
                if (
                        $fieldvalue['A'] == 'Reference No' && $fieldvalue['B'] == 'Agent' && $fieldvalue['C'] == 'Rent Price â‚¬' && $fieldvalue['D'] == 'Common expenses ( 1 - incl. common expenses, 0- Plus common expenses )' && $fieldvalue['E'] == 'Selling Price â‚¬' && $fieldvalue['F'] == 'VAT ( 1 - No V.A.T, 0 â€“ Plus V.A.T )' && $fieldvalue['G'] == 'Address' && $fieldvalue['H'] == 'City' && $fieldvalue['I'] == 'City Area' && $fieldvalue['J'] == 'Property Type' && $fieldvalue['K'] == 'Property Status (Sale / Rent / Both)' && $fieldvalue['L'] == 'Furnished Type' && $fieldvalue['M'] == 'Size of rooms' && $fieldvalue['N'] == 'Bedrooms' && $fieldvalue['O'] == 'Bathrooms' && $fieldvalue['P'] == 'Kitchen' && $fieldvalue['Q'] == 'URL Link1' && $fieldvalue['R'] == 'URL Link2' && $fieldvalue['S'] == 'URL Link3' && $fieldvalue['T'] == 'Covered area (mÂ²)' && $fieldvalue['U'] == 'Uncovered area: (mÂ²)' && $fieldvalue['V'] == 'Plot/land area (mÂ²)' && $fieldvalue['W'] == 'Description' && $fieldvalue['X'] == 'Pets' && $fieldvalue['Y'] == 'Architectural Design' && $fieldvalue['Z'] == 'Make Year' && $fieldvalue['AA'] == 'General Facility' && $fieldvalue['AB'] == 'Electronics Faciliteis' && $fieldvalue['AC'] == 'Owner Name' && $fieldvalue['AD'] == 'Owner Surname' && $fieldvalue['AE'] == 'Company Name' && $fieldvalue['AF'] == 'Mobile' && $fieldvalue['AG'] == 'E-Mail'
                ) {
                    $tablefor_result = "true";
                } else {
                    $tablefor_result = "false";
                }

                foreach ($data['values'] as $key => $value) {
                    
                    if ((empty($value['A']))) {
                        continue;
                    }
                    
                    $city_id = $this->Blog_model->get_city($value['H']);
                    $city_area_id = $this->Blog_model->get_city_area($city_id, $value['I']);
                   
                    $name_agent = explode(" ",$value['B']);
                    
                    $agent_details = array(
                        'fname'=> (!empty($name_agent) && isset($name_agent[0]))?$name_agent[0]:'',
                        'lname'=> (!empty($name_agent) && isset($name_agent[1]))?$name_agent[1]:'',
                        'email' => trim($value['AI']),
                        'mobile_no' => $value['AJ'],
                    );
                    $agent_id = false;
                    $agent_id = $this->Blog_model->getAgent($agent_details);
                    
                    if(!$agent_id && !empty($agent_details['email'])){
                        
                        $agent_details['password'] = $this->generatePassword();
                        $agent_id = $this->Blog_model->saveAgent($agent_details);
                        
                        $subject = "Your Account has been created to ".$this->config->item('title');
                        $user = $this->user->getUserByID($agent_id);
                        
                        $message = $this->load->view("email/agent_create_email", $agent_details, TRUE);
                        
                        $sms = strip_tags($message);
                        $this->notifyUser($user, $subject, $message, $sms);
                    }

                    $prop_type = array('1' => 'Duplex', '2' => 'Apartment', '3' => 'Penthouse', '4' => 'Garden Apartments', '5' => 'Studio', '6' => 'Townhouse', '7' => 'Villa', '8' => 'Bungalow', '9' => 'Land', '10' => 'Shop', '11' => 'Office', '12' => 'Business', '13' => 'Hotel', '14' => 'Restaurant', '15' => 'Building', '16' => 'Industrial estate', '17' => 'House', '18' => 'Upper-House', '19' => 'Maisonette');
                    $propkey = array_search("" . $value['J'] . "", $prop_type);

                    $propsell_type = array('1' => 'Sale', '2' => 'Rent', '3' => 'Both');
                    $proprty_typekey = array_search("" . $value['K'] . "", $propsell_type);

                    $furnished_type = array('1' => 'Furnished', '2' => 'semi-Furnished', '3' => 'Un-Furnished');
                    $furnished_typekey = array_search("" . $value['L'] . "", $furnished_type);

                    $pets_type = array('0' => 'Allowed', '1' => 'Not Allowed');
                    $pets_typekey = array_search("" . $value['X'] . "", $pets_type);

                    $artich_design = array('1' => 'Contemporary', '2' => 'Modern', '3' => 'Classic');
                    $artich_designkey = array_search("" . $value['Y'] . "", $artich_design);

                    $size_rm = array('1' => 'Small', '2' => 'Medium', '3' => 'Large');
                    $size_rmkey = array_search("" . $value['M'] . "", $size_rm);

                    $link_str = "";
                    if (!empty($value['Q'])) {
                        $link_str .= $value['Q'] . ',';
                    }
                    if (!empty($value['R'])) {
                        $link_str .= $value['R'] . ',';
                    }
                    if (!empty($value['S'])) {
                        $link_str .= $value['S'] . ',';
                    }

                    $link_str = rtrim($link_str, ",");


                    $country_id1 = $this->Blog_model->get_country_code($value['AF']);

                    $value['AA'] = explode(",", $value['AA']);
                    $value['AB'] = explode(",", $value['AB']);

                    $data_prop = array(
                        'reference_no' => $value['A'],
                        'agent_id' => $agent_id,
                        'rent_price' => $value['C'],
                        'rent_val' => $value['D'],
                        'sale_price' => $value['E'],
                        'sale_val' => $value['F'],
                        'address' => $value['G'],
                        'city_id' => $city_id,
                        'city_area' => $city_area_id,
                        'property_type' => $propkey,
                        'type' => $proprty_typekey,
                        'furnished_type' => $furnished_typekey,
                        'room_size' => $size_rmkey,
                        'bedroom' => $value['N'],
                        'bathroom' => $value['O'],
                        'kitchen' => $value['P'],
                        'kitchen' => $value['P'],
                        'url_link' => $link_str,
                        'cover_area' => $value['T'],
                        'uncover_area' => $value['U'],
                        'plot_lan_area' => $value['V'],
                        'short_decs' => $value['W'],
                        'pets' => $pets_typekey,
                        'architectural_design' => $artich_designkey,
                        'make_year' => $value['Z'],
                        'fname' => $value['AC'],
                        'lname' => $value['AD'],
                        'compny_name' => $value['AE'],
                        'coutry_code' => $country_id1,
                        'mobile' => $value['AG'],
                        'email' => $value['AH'],
                        'created_date' => date('Y-m-d H:i:s'),
                        'updated_date' => date('Y-m-d H:i:s')
                    );

                    $property_id = $this->Blog_model->propertyinsert_entry($data_prop);

                    //$delete_id = $this->Blog_model->delete_fecelity($property_id);

                    /* if (!empty($value['AA'])) {
                      foreach ($value['AA'] as $generaldatakey => $generaldatavalue)
                      {
                      $generalfec_id = $this->Blog_model->insert_facilities($generaldatavalue,$property_id,'1');
                      }
                      }
                      if (!empty($value['AB'])) {
                      foreach ($value['AB'] as $elecdatakey => $elecdatavalue)
                      {
                      $elecfec_id = $this->Blog_model->insert_facilities($elecdatavalue,$property_id,'2');
                      }
                      } */
                }
                unlink($file_path . '/' . $name);
                redirect('home/property_manage');
            }
        } else {
            redirect('home/property_manage');
            //$this->load->view('excel_reader');
        }
    }

    public function inquire_export() {

        error_reporting(0);
        set_time_limit(0);
        $this->load->helper('url');
        $this->load->model('Blog_model');

        if (isset($_FILES) && !empty($_FILES)) {

            require_once FCPATH . "application/third_party/Classes/PHPExcel/IOFactory.php";
            $str = base_url();

            $arr = explode("/", $str);
            $key = max(array_keys($arr));

            $file_path = APPPATH . '../files';

            $name = rand(1111, 9999) . '_' . $_FILES["inquire_xls_files"]["name"];
            $type = $_FILES["inquire_xls_files"]["type"];
            $size = $_FILES["inquire_xls_files"]["size"];
            $temp = $_FILES["inquire_xls_files"]["tmp_name"];
            $error = $_FILES["inquire_xls_files"]["error"];

            if ($error > 0)
                die("Error uploading file! code $error.");
            else {
                move_uploaded_file($temp, $file_path . '/' . $name);
            }

            $objPHPExcel = PHPExcel_IOFactory::load($file_path . '/' . $name);
            $cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();
            foreach ($cell_collection as $cell) {
                $column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
                $row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
                $data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();

                if ($row == 1) {
                    $header[$row][$column] = $data_value;
                } else {
                    $arr_data[$row - 1][$column] = $data_value;
                }
            }
            $data['header'] = $header;
            $data['values'] = $arr_data;

            $error = array();
            $i = 0;
            foreach ($header as $fieldkey => $fieldvalue) { 
                if (
                        $fieldvalue['A'] == 'Date (dd/mm/yyyy)' && $fieldvalue['B'] == 'First Name' && $fieldvalue['C'] == 'Last Name' && $fieldvalue['D'] == 'Mobile' && $fieldvalue['E'] == 'Pass Over (Yes / No)' && $fieldvalue['F'] == 'Name Of Agent' && $fieldvalue['G'] == 'Area' && $fieldvalue['H'] == 'Bathrooms' && $fieldvalue['I'] == 'Bedrooms' && $fieldvalue['J'] == 'Furnished Type' && $fieldvalue['K'] == 'Property Status' && $fieldvalue['L'] == 'Property Type' && $fieldvalue['M'] == 'Reference Number' && $fieldvalue['N'] == 'Budget Min € ' && $fieldvalue['O'] == 'Budget Max €') {
                    $tablefor_result = "true";
                } else {
                    $tablefor_result = "false";
                }
            }

            foreach ($data['values'] as $key => $value) { 
                if ((empty($value['E'])) && (empty($value['F']))) {
                    continue;
                }

                $value['E'] = trim($value['E']);
                $country_id1 = $this->Blog_model->get_country_code($value['D']);

                if (!empty($country_id1)) {
                    $country_id1 = $country_id1[0]->id;
                } else {
                    $country_id1 = "24";
                }

                $value['country_id1'] = $country_id1;

                $value['A'] = trim($value['A']);

                //excel date convert to php date
                $PHPTimeStamp = PHPExcel_Shared_Date::ExcelToPHP($value['A']);
                $value['A'] = date('Y-m-d', $PHPTimeStamp);

                if (!empty($value['I'])) {
                    $area_id1 = $this->Blog_model->get_area($value['I']);
                    $value['area_id1'] = $area_id1;
                } else {
                    $area_id1 = "";
                    $value['area_id1'] = "";
                }

                if (!empty($value['J'])) {
                    $area_id2 = $this->Blog_model->get_area($value['J']);
                    $value['area_id2'] = $area_id2;
                } else {
                    $area_id2 = "";
                    $value['area_id2'] = "";
                }

                if (!empty($value['K'])) {
                    $area_id3 = $this->Blog_model->get_area($value['K']);
                    $value['area_id3'] = $area_id3;
                } else {
                    $area_id3 = "";
                    $value['area_id3'] = "";
                }
                if (!empty($value['L'])) {
                    $area_id4 = $this->Blog_model->get_area($value['L']);
                    $value['area_id4'] = $area_id4;
                } else {
                    $area_id4 = "";
                    $value['area_id4'] = "";
                }

                $customer_id = $this->Blog_model->get_inquirecustomer($value);
                $value['customer_id'] = $customer_id;

                $agent_id = "";
                if ($value['G'] == "Yes") {
                    $name = explode(" ",$value['H']);
                    $agent_details = array(
                        'fname'=> (!empty($name) && isset($name[0]))?$name[0]:'',
                        'lname'=> (!empty($name) && isset($name[1]))?$name[1]:'',
                        'email' => trim($value['U']),
                        'mobile_no' => $value['V'],
                        'created_date' => $value['A']
                    );
                    
                    $agent_id = false;
                    $agent_id = $this->Blog_model->getAgent($agent_details);
                    
                    if(!$agent_id && !empty($agent_details['email'])){
                        $agent_details['password'] = $this->generatePassword();
                        $agent_id = $this->Blog_model->saveAgent($agent_details);
                        
                        $subject = "Your Account has been created to ".$this->config->item('title');
                        $user = $this->user->getUserByID($agent_id);
                        
                        $message = $this->load->view("email/agent_create_email", $agent_details, TRUE);
                        $sms = strip_tags($message);
                        $this->notifyUser($user, $subject, $message, $sms);
                    }
                    //$agent_id = $this->Blog_model->get_inquireuser($agent_details);
                    
                }
                
                $value['agent_id'] = $agent_id;

                if (empty($value['Q'])) {
                    $propkey = "";
                } else {
                    $property_types = $this->config->item('property_type');
                    $propkey = array_search("" . $value['Q'] . "", $property_types);
                }

                $property_status = $value['P'];
                if (empty($value['P'])) {
                    $proprty_typekey = "";
                } else {
                    $propsell_type = array('1' => 'Sale', '2' => 'Rent', '3' => 'Both');
                    $proprty_typekey = array_search("" . $value['P'] . "", $propsell_type);
                }

                if (empty($value['O'])) {
                    $furnished_typekey = "";
                } else {
                    $furnished_type = array('1' => 'Furnished', '2' => 'semi-Furnished', '3' => 'Un-Furnished');
                    $furnished_typekey = array_search("" . $value['O'] . "", $furnished_type);
                }

                $value['R'] = trim($value['R']);
                $ref = array();
                if (!empty($value['R'])) {
                    if (stripos($value['R'], "/") == true) {
                        $ref = explode('/', $value['R']);
                    } elseif (stripos($value['R'], "-") == true) {
                        $ref = explode('-', $value['R']);
                    } elseif (stripos($value['R'], ",") == true) {
                        $ref = explode(',', $value['R']);
                    } elseif (stripos($value['R'], " ") == true) {
                        $ref = explode(' ', $value['R']);
                    } else {
                        $ref[0] = $value['R'];
                    }
                } else {
                    //$ref[0] = $this->unic_inquiry_prop_refconf_num();
                    $ref = array();
                }
                
                if (count($ref) < 1) {
                    $data_prop=array();
                    $propid = $this->Blog_model->get_inquire_property($data_prop);
                    if ($propid == -1) {
                        $propid = "";
                    }
                                        
                    $created_id = $this->cur_user['id'];
                    
                    $inquiry_num = $this->unic_inquiry_num();
 
                    $data_inquire = array(
                        'customer_id' => $customer_id,
                        'property_ref_no' => '',
                        'incquiry_ref_no' => $inquiry_num,
                        'property_id' => $propid,
                        'agent_id' => $agent_id,
                        'created_date' => $value['A'],
                        'updated_date' => $value['A'],
                        'created_by' => $created_id,
                        'aquired' => strtolower($property_status)
                    );
                   
                   // print_r($propid);
                    //print_r($agent_details);
                   // exit;
                    
                    if(!empty($propid) && !empty($agent_details['email'])){
                        $data_inquire['status'] = 4; 
                        $data_inquire['agent_status'] = 2;
                    }else if(!empty($propid) && empty($agent_details['email'])){
                        $data_inquire['status'] = 2;
                        $data_inquire['agent_status'] = 0;
                    }else if(empty($propid)){
                        $data_inquire['status'] = 1;
                        $data_inquire['agent_status'] = 0;
                    }else{
                        $data_inquire['status'] = 1;
                        $data_inquire['agent_status'] = 0;
                    }
                    
                    $inquireid = $this->Blog_model->get_inquire_inquiredata($data_inquire);

                    $data_inquiry_details = array(
                        'inquiry_id' => $inquireid,
                        'city_area' => $area_id1 . "," . $area_id2 . "," . $area_id3 . "," . $area_id4,
                        'bathroom' => $value['M'],
                        'badroom' => $value['N'],
                        'reference_no' =>'',
                        //'furnished_type'=> $furnished_typekey,
                        'property_status' => $proprty_typekey,
                        'property_type' => $propkey,
                        'minprice' => $value['S'],
                        'maxprice' => $value['T'],
                        'created_date' => $value['A'],
                        'updated_date' => $value['A']
                    );

                    $inquire_detid = $this->Blog_model->insertdata($data_inquiry_details, 'inquiry_history');
                    
                   
                    if(!empty($inquireid)){
                        $inquiry = $this->inquiry_model->get_inquiry_data($inquireid);
                        $employee_record = $this->inquiry_model->get_employee_record($inquireid);
                        $inquiry_and_customer_record = $this->inquiry_model->get_inquiry_data($inquireid);
                      
                        if($inquiry[0]->status=4 && $inquiry[0]->agent_status==2){
                            $aget_record = $this->inquiry_model->get_aget_record($agent_id);
                            if (!empty($aget_record)) {
                                $aget_record = $aget_record[0];
                                $agentcountry_code = $this->user->get_contry_code($aget_record->coutry_code);
                                $mcode_agent = substr($agentcountry_code[0]->prefix_code, 1);
                                $mobile_code_agent = "00" . $mcode_agent;
                            } else {
                                $mobile_code_agent = "0000";
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
                                'employee_name' => $employee_record[0]->fname.' '.$employee_record[0]->lname,
                                'customer_name' => $inquiry_and_customer_record->fname . ' ' . $inquiry_and_customer_record->lname,
                                'appointment_start' => $inquiry_and_customer_record->appoint_start_date,
                                'appointment_end' => $inquiry_and_customer_record->appoint_end_date,
                                'property_ref_no' => $inquiry_and_customer_record->property_ref_no,
                                'agent_name' => $aget_record->fname . ' ' . $aget_record->lname,
                                'agent_mobile' => $mobile_code_agent . $aget_record->mobile_no,
                                'customer_mobile' => $mobile_code_customer . $inquiry_and_customer_record->mobile_no,
                                'type' => $inquiry[0]->agent_status
                            );
                            
                            $subject = $response['msg'] = "Appointment has been sent for rescheduling.";
                            $message = $this->load->view("email/appointment_confirm", $data, TRUE);

                            $sms = "Dear " . $inquiry_and_customer_record->fname . " " . $inquiry_and_customer_record->lname . ",";
                            $sms .=" Your appointment for the property with Reference No: " . $inquiry_and_customer_record->property_ref_no . ", ";
                            $sms .= " has been rescheduled on:" . $inquiry_and_customer_record->appoint_start_date . " to " . $inquiry_and_customer_record->appoint_end_date . ".";
                            $sms .= " For any further information please kindly contact";
                            $sms .= " our Agent, " . $aget_record->fname . " " . $aget_record->lname . ", mobile Number: +" . $mobile_code_agent . $aget_record->mobile_no . " or  8000 7000 ";
                            $this->notifyUser($inquiry_and_customer_record, $subject, $message, $sms, $inquireid);

                            $message = $this->load->view("email/appointment_confirm_employee", $data, TRUE);
                            $sms = "Dear " . $employee_name . ",";
                            $sms .= " Your appointment has been Rescheduled";
                            $sms .=" For the property with Reference No:" . $inquiry_and_customer_record->property_ref_no;
                            $sms .= " Inquiry from, " . $inquiry_and_customer_record->fname . ' ' . $inquiry_and_customer_record->lname;
                            $this->notifyUser($employee_record, $subject, $message, $sms, $inquireid);
                            
                        }else if($inquiry[0]->status = 2) {
                            
                        }else if($inquiry[0]->status = 1){
                            
                        }
                    }
                    
                } else {
                    foreach ($ref as $refkey => $refvalue) {

                        $refvalue = trim($refvalue);
                        $data_prop = array(
                            'reference_no' => $refvalue,
                            'agent_id' => $agent_id,
                            'city_id' => '1',
                            'city_area' => $area_id1,
                            'property_type' => $propkey,
                            'type' => $proprty_typekey,
                            'furnished_type' => $furnished_typekey,
                            'bedroom' => $value['N'],
                            'bathroom' => $value['M'],
                            'fname' => $value['B'],
                            'lname' => $value['C'],
                            'coutry_code' => '7840',
                            'mobile' => $value['E'],
                            'created_date' => $value['A']
                        );

                        $propid = $this->Blog_model->get_inquire_property($data_prop);
                        if ($propid == -1) {
                            $propid = "";
                        }

                        $created_id = $this->cur_user['id'];

                        $inquiry_num = $this->unic_inquiry_num();

                        $data_inquire = array(
                            'customer_id' => $customer_id,
                            'property_ref_no' => $refvalue,
                            'incquiry_ref_no' => $inquiry_num,
                            'property_id' => $propid,
                            'agent_id' => $agent_id,
                            'created_date' => $value['A'],
                            'created_by' => $created_id,
                            'aquired' => strtolower($property_status)
                        );
                        

                        if(!empty($propid) && !empty($agent_details['email'])){
                        $data_inquire['status'] = 4; 
                        $data_inquire['agent_status'] = 2;
                        }else if(!empty($propid) && empty($agent_details['email'])){
                            $data_inquire['status'] = 2;
                            $data_inquire['agent_status'] = 0;
                        }else if(empty($propid)){
                            $data_inquire['status'] = 1;
                            $data_inquire['agent_status'] = 0;
                        }else{
                            $data_inquire['status'] = 1;
                            $data_inquire['agent_status'] = 0;
                        }

                        $inquireid = $this->Blog_model->get_inquire_inquiredata($data_inquire);

                        $data_inquiry_details = array(
                            'inquiry_id' => $inquireid,
                            'city_area' => $area_id1 . "," . $area_id2 . "," . $area_id3 . "," . $area_id4,
                            'bathroom' => $value['M'],
                            'badroom' => $value['N'],
                            'reference_no' => $refvalue,
                            //'furnished_type'=> $furnished_typekey,
                            'property_status' => $proprty_typekey,
                            'property_type' => $propkey,
                            'minprice' => $value['S'],
                            'maxprice' => $value['T'],
                            'created_date' => $value['A'],
                            'updated_date' => $value['A']
                        );

                        $inquire_detid = $this->Blog_model->insertdata($data_inquiry_details, 'inquiry_history');

                        if(!empty($inquireid)){
                        $inquiry = $this->inquiry_model->get_inquiry_data($inquireid);
                        $employee_record = $this->inquiry_model->get_employee_record($inquireid);
                        $inquiry_and_customer_record = $this->inquiry_model->get_inquiry_data($inquireid);
                       
                        if($inquiry[0]->status=4 && $inquiry[0]->agent_status==2){
                            $aget_record = $this->inquiry_model->get_aget_record($agent_id);
                            if (!empty($aget_record)) {
                                $aget_record = $aget_record[0];
                                $agentcountry_code = $this->user->get_contry_code($aget_record->coutry_code);
                                $mcode_agent = substr($agentcountry_code[0]->prefix_code, 1);
                                $mobile_code_agent = "00" . $mcode_agent;
                            } else {
                                $mobile_code_agent = "0000";
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
                                'employee_name' => $employee_record[0]->fname.' '.$employee_record[0]->lname,
                                'customer_name' => $inquiry_and_customer_record->fname . ' ' . $inquiry_and_customer_record->lname,
                                'appointment_start' => $inquiry_and_customer_record->appoint_start_date,
                                'appointment_end' => $inquiry_and_customer_record->appoint_end_date,
                                'property_ref_no' => $inquiry_and_customer_record->property_ref_no,
                                'agent_name' => $aget_record->fname . ' ' . $aget_record->lname,
                                'agent_mobile' => $mobile_code_agent . $aget_record->mobile_no,
                                'customer_mobile' => $mobile_code_customer . $inquiry_and_customer_record->mobile_no,
                                'type' => $inquiry[0]->agent_status
                            );
                            
                            $subject = $response['msg'] = "Appointment has been sent for rescheduling.";
                            $message = $this->load->view("email/appointment_confirm", $data, TRUE);

                            $sms = "Dear " . $inquiry_and_customer_record->fname . " " . $inquiry_and_customer_record->lname . ",";
                            $sms .=" Your appointment for the property with Reference No: " . $inquiry_and_customer_record->property_ref_no . ", ";
                            $sms .= " has been rescheduled on:" . $inquiry_and_customer_record->appoint_start_date . " to " . $inquiry_and_customer_record->appoint_end_date . ".";
                            $sms .= " For any further information please kindly contact";
                            $sms .= " our Agent, " . $aget_record->fname . " " . $aget_record->lname . ", mobile Number: +" . $mobile_code_agent . $aget_record->mobile_no . " or  8000 7000 ";
                            $this->notifyUser($inquiry_and_customer_record, $subject, $message, $sms, $inquireid);

                            $message = $this->load->view("email/appointment_confirm_employee", $data, TRUE);
                            $sms = "Dear " . $employee_name . ",";
                            $sms .= " Your appointment has been Rescheduled";
                            $sms .=" For the property with Reference No:" . $inquiry_and_customer_record->property_ref_no;
                            $sms .= " Inquiry from, " . $inquiry_and_customer_record->fname . ' ' . $inquiry_and_customer_record->lname;
                            $this->notifyUser($employee_record, $subject, $message, $sms, $inquireid);
                            
                        }else if($inquiry[0]->status = 2) {
                            
                        }else if($inquiry[0]->status = 1){
                            
                        }
                    }
                    }
                }
            }
            unlink($file_path . '/' . $name);

            redirect('inquiry/inquiry_manage');
            //}
        } else {

            redirect('inquiry/inquiry_manage');
            //$this->load->view('inqire_excelreader');
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

    function unic_inquiry_prop_refconf_num() {
        $inquiry_prop_num = rand(10000000, 99999999);

        $unic_prop_number = $this->Blog_model->check_unic_prop_refno_num($inquiry_prop_num);

        if (!empty($unic_prop_number)) {
            $this->unic_inquiry_prop_refconf_num();
        } else {
            return $inquiry_prop_num;
        }
    }

    function export_data() {

        $property_result = $this->Blog_model->property_export_data();

        require_once FCPATH . "application/third_party/Classes/PHPExcel/IOFactory.php";
        /* SetAuto size index column */
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $column_array = array('A', 'B', 'C', 'E', 'H', 'I', 'J', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'X', 'Y', 'Z', 'AC', 'AD', 'AE', 'AF', 'AG', 'AH','AI','AJ','Ak');
        foreach ($column_array as $k => $v) {
            $objPHPExcel->getActiveSheet()->getColumnDimension($v)->setAutoSize(true);
        }

        /* Set index[0] or row 1 column name and color */
        $rowCount = 1;
        $column_index_array = array('A' => 'Reference No', 'B' => 'Agent', 'C' => 'Rent Price €', 'D' => 'Common expenses ( 1 - incl. common expenses, 0- Plus common expenses )', 'E' => 'Selling Price €', 'F' => 'VAT ( 1 - No V.A.T, 0 - Plus V.A.T )', 'G' => 'Address', 'H' => 'City', 'I' => 'City Area', 'J' => 'Property Type', 'K' => 'Property Status (Sale / Rent / Both)', 'L' => 'Furnished Type', 'M' => 'Size of rooms', 'N' => 'Bedrooms', 'O' => 'Bathrooms', 'P' => 'Kitchen', 'Q' => 'URL Link1', 'R' => 'URL Link2', 'S' => 'URL Link3', 'T' => 'Covered area (m²)', 'U' => 'Uncovered area (m²)', 'V' => 'Plot/land area (m²)', 'W' => 'Description', 'X' => 'Pets', 'Y' => 'Architectural Design', 'Z' => 'Make Year', 'AA' => 'General Facility', 'AB' => 'Electronics Faciliteis', 'AC' => 'Owner Name', 'AD' => 'Owner Surname', 'AE' => 'Company Name', 'AF' => 'Country STD code', 'AG' => 'Mobile', 'AH' => 'E-Mail', 'AI' => 'Agent Email', 'AJ' => 'Agent Phone', 'AK' => 'Image');
        foreach ($column_index_array as $A => $B) {
            $objPHPExcel->getActiveSheet()->SetCellValue($A . $rowCount, $B);
            $objPHPExcel->getActiveSheet()->getStyle('A1:AK1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('#8D4904');
        }

        /* Set row 2  to n column value */
        $Count = 2;
        foreach ($property_result as $key => $value) {
            /* Set column value left align and font size*/
            $objPHPExcel->getActiveSheet()->getStyle('A' . $Count . ':AK' . $Count)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->getActiveSheet()->getStyle('A' . $Count . ':AK' . $Count)->getFont()->setSize(9);
           
            /* Get general facility record perticuler property */
            $genral_facilities = $this->user->get_genral_facilities($value->id);
            $Faciliteis_title = array();
            foreach ($genral_facilities as $key1 => $value1) {
                $Faciliteis_title[$key1] = $value1->title;
            }

            /* Get electronic facility record perticuler property */
            $instrumental_facilities = $this->user->get_instrumental_facilities($value->id);
            $instrumental_title = array();
            foreach ($instrumental_facilities as $key2 => $value2) {
                $instrumental_title[$key2] = $value2->title;
            }

            /* call function to get property type name */
            if ($value->property_type != 0 && !empty($value->property_type)) {
                $property_type = $this->get_propertytypeby_id($value->property_type);
            } else {
                $property_type = "";
            }

            /* call function to get type or aquired name */
            if ($value->type != 0 && !empty($value->type)) {
                $type = $this->property_aquired_type($value->type);
            } else {
                $type = "";
            }

            /* check condition property type rent or both */
            if (!empty($value->type) && ($value->type == 2 || $value->type == 3)) {
                $rent_price = $value->rent_price;
                $rent_val = $value->rent_val;
            } else {
                $rent_price = "";
                $rent_val = "";
            }

            /* check condition property type sale or both */
            if (!empty($value->type) && ($value->type == 1 || $value->type == 3)) {
                $sale_price = $value->sale_price;
                $sale_val = $value->sale_val;
            }else{
            	$sale_price = "";
                $sale_val = "";
            }

            /* url comma sepreted string to convert array */
            $url = explode(',', $value->url_link);
            $url = array_filter($url);
            $url=array_unique($url);
            $other_link = array();
            if (!empty($url)) {
                foreach ($url as $c1 => $d1) {
                    if (!empty($d1) && $d1 != "") {
                        array_push($other_link, $d1);
                    }
                }
            } else {
                array_push($other_link, "");
                array_push($other_link, "");
                array_push($other_link, "");
            }
            if (count($other_link) == 2) {
                array_push($other_link, '');
            } elseif (count($other_link) == 1) {
                array_push($other_link, '');
                array_push($other_link, '');
            }elseif (count($other_link) == 0) {
                array_push($other_link, '');
                array_push($other_link, '');
                array_push($other_link, '');
            }

            /* get furnished type name as defind id */
            if ($value->furnished_type == 1) {
                $furnished_type = "Furnished";
            } else if ($value->furnished_type == 2) {
                $furnished_type = "Semi-Furnished";
            } else if ($value->furnished_type == 3) {
                $furnished_type = "Un-Furnished";
            } else {
                $furnished_type = "";
            }
            /* get room size name as defind id */
            if ($value->room_size == 1) {
                $room_size = "Small";
            } else if ($value->room_size == 2) {
                $room_size = "Medium";
            } else if ($value->room_size == 3) {
                $room_size = "Large";
            } else {
                $room_size = "";
            }
            /* get architectural design name as defind id */
            if ($value->architectural_design == 1) {
                $architectural_design = "Contemporary";
            } else if ($value->architectural_design == 2) {
                $architectural_design = "Modern";
            } else if ($value->architectural_design == 3) {
                $architectural_design = "Classic";
            } else {
                $architectural_design = "";
            }
            /* get pets name as defind id */
            if ($value->pets == 0) {
                $pets = "Allowed";
            } else if ($value->pets == 1) {
                $pets = "Not Allowed";
            } else {
                $pets = "";
            }
            $objPHPExcel->getActiveSheet()->SetCellValue('A' . $Count, $value->reference_no);
            $objPHPExcel->getActiveSheet()->SetCellValue('B' . $Count, $value->user_fname . ' ' . $value->user_lname);
            $objPHPExcel->getActiveSheet()->SetCellValue('C' . $Count, $rent_price);
            $objPHPExcel->getActiveSheet()->SetCellValue('D' . $Count, $rent_val);
            $objPHPExcel->getActiveSheet()->SetCellValue('E' . $Count, $sale_price);
            $objPHPExcel->getActiveSheet()->SetCellValue('F' . $Count, $sale_val);
            $objPHPExcel->getActiveSheet()->SetCellValue('G' . $Count, $value->address);
            $objPHPExcel->getActiveSheet()->SetCellValue('H' . $Count, $value->city_title);
            $objPHPExcel->getActiveSheet()->SetCellValue('I' . $Count, $value->title);
            $objPHPExcel->getActiveSheet()->SetCellValue('J' . $Count, $property_type);
            $objPHPExcel->getActiveSheet()->SetCellValue('K' . $Count, $type);
            $objPHPExcel->getActiveSheet()->SetCellValue('L' . $Count, $furnished_type);
            $objPHPExcel->getActiveSheet()->SetCellValue('M' . $Count, $room_size);
            $objPHPExcel->getActiveSheet()->SetCellValue('N' . $Count, $value->bedroom);
            $objPHPExcel->getActiveSheet()->SetCellValue('O' . $Count, $value->bathroom);
            $objPHPExcel->getActiveSheet()->SetCellValue('P' . $Count, $value->kitchen);
            $objPHPExcel->getActiveSheet()->SetCellValue('Q' . $Count, $other_link[0]);
            $objPHPExcel->getActiveSheet()->SetCellValue('R' . $Count, $other_link[1]);
            $objPHPExcel->getActiveSheet()->SetCellValue('S' . $Count, $other_link[2]);
            $objPHPExcel->getActiveSheet()->SetCellValue('T' . $Count, $value->cover_area != 0 ? $value->cover_area : '');
            $objPHPExcel->getActiveSheet()->SetCellValue('U' . $Count, $value->uncover_area != 0 ? $value->uncover_area : '');
            $objPHPExcel->getActiveSheet()->SetCellValue('V' . $Count, $value->plot_lan_area != 0 ? $value->plot_lan_area : '');
            $objPHPExcel->getActiveSheet()->SetCellValue('W' . $Count, strip_tags($value->short_decs));
            $objPHPExcel->getActiveSheet()->SetCellValue('X' . $Count, $pets);
            $objPHPExcel->getActiveSheet()->SetCellValue('Y' . $Count, $architectural_design);
            $objPHPExcel->getActiveSheet()->SetCellValue('Z' . $Count, $value->make_year != 0 ? $value->make_year : '');
            $objPHPExcel->getActiveSheet()->SetCellValue('AA' . $Count, implode(",", $Faciliteis_title));
            $objPHPExcel->getActiveSheet()->SetCellValue('AB' . $Count, implode(",", $instrumental_title));
            $objPHPExcel->getActiveSheet()->SetCellValue('AC' . $Count, $value->fname);
            $objPHPExcel->getActiveSheet()->SetCellValue('AD' . $Count, $value->lname);
            $objPHPExcel->getActiveSheet()->SetCellValue('AE' . $Count, $value->compny_name);
            $objPHPExcel->getActiveSheet()->SetCellValue('AF' . $Count, $value->coutry_code);
            $objPHPExcel->getActiveSheet()->SetCellValue('AG' . $Count, $value->mobile);
            $objPHPExcel->getActiveSheet()->SetCellValue('AH' . $Count, $value->email);
            $objPHPExcel->getActiveSheet()->SetCellValue('AI' . $Count, $value->user_email);
            $objPHPExcel->getActiveSheet()->SetCellValue('AJ' . $Count, $value->user_mobile_no);
            $objPHPExcel->getActiveSheet()->SetCellValue('AK' . $Count, '=HYPERLINK("'.base_url().'Excelread/property_image/'.$value->id.'","'.base_url().'Excelread/property_image/'.$value->id.'")' );
            $Count++;
        }

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Property Management List.xls"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
    }
    
     function property_image(){
        $id = $this->uri->segment(3);
        
        /*Get all images in perticular property id*/
        $property_image = $this->Blog_model->get_property_image($id); 
        
        /*load zip library*/
        $this->load->library('zip');
       
        foreach ($property_image as $key => $value) {
            /*get image in storage folder*/
            $path =  base_url().'img_prop/'.$value->image;
            
            /*create zip and store image in images.zip*/
            $this->zip->add_data('images/' . $value->image, file_get_contents($path));
        }
        
        /*Download images zip fole */
        $this->zip->download('images.zip'); 
    }

}

?>
