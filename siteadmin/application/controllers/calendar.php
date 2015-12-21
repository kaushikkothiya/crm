<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
session_start(); //we need to call PHP's session object to access it through CI

class Calendar extends MY_Controller {

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

        $user = $this->cur_user;
        if(empty($user)) {
            redirect('login', 'refresh');
        }
        
        $data = array();
        $this->load->model('calendar_model');
        $data['user'] = $user;

        $config = $this->config->item('pagination');
        $config['per_page'] = 10;

        $page = 1;
        if($this->uri->segment(3)){
            $page = $this->uri->segment(3);
        }

        if(isset($_REQUEST['per_page']) && !empty($_REQUEST['per_page'])){
            $config['per_page'] = $_REQUEST['per_page'];
        }

        $calendar = array();
        if(isset($_REQUEST['calendar']) && !empty($_REQUEST['calendar'])){
            $calendar = $_REQUEST['calendar'];
        }

        if(!empty($calendar) && isset($calendar['show_completed']) && !empty($calendar['show_completed'])) {
            $show_completed = true;
        } else {
            $show_completed = false;
        }

        if(!empty($calendar) && isset($calendar['show_occupied_days']) && !empty($calendar['show_occupied_days'])) {
            $show_occupied_days = true;
        } else {
            $show_occupied_days = false;
        }

        $calendar_view = 'day';
        if(!empty($calendar) && isset($calendar['calendar_view']) && !empty($calendar['calendar_view'])){
            $calendar_view = $calendar['calendar_view'];
        }
        $calendar['calendar_view'] = $calendar_view;

        $from_date = $to_date = date('m/d/Y');

        if (!empty($calendar) && isset($calendar['from_date']) && !empty($calendar['from_date'])) {
            $from_date = $calendar['from_date'];
        }
        if (!empty($calendar) && isset($calendar['to_date']) && !empty($calendar['to_date'])) {
            $to_date = $calendar['to_date'];
        }

        $calendar['from_date'] = $from_date;
        $calendar['to_date'] = $to_date;

        $selected_user = (!empty($calendar) && isset($calendar['user_id']) && !empty($calendar['user_id']))?$calendar['user_id']:array();
        if(!empty($selected_user)){
            $selected_user = $this->calendar_model->getUserByID($selected_user);
        }

        if($show_occupied_days === true) {
            $occupied_days = $this->calendar_model->getOccupiedDays($user, $selected_user);

            foreach ($occupied_days as $key => $value)
            {
                if(trim($value->agent_status) =='0'){
                    $status = "Pending";
                    $color="00bfff";
                }elseif (trim($value->agent_status) =='1') {
                   $status = "Confirmed";
                   $color="EBAF22";
                }elseif (trim($value->agent_status) =='2') {
                   $status = "Reschedule";
                   $color="FFCCFF";
                }elseif (trim($value->agent_status) =='3') {
                    $status = "Cancle";
                    $color = "d9534f";
                }

                $occupied_days[$key]->color = '#' . $color;
                $occupied_days[$key]->title  =  "";
                $occupied_days[$key]->status  =  $value->agent_status;
                $occupied_days[$key]->id  =  $value->id;
                $occupied_days[$key]->description  = 'Appointment Start: '.date("d-M-Y H:i", strtotime($value->appoint_start_date))." To Appointment End : ".date("d-M-Y H:i", strtotime($value->appoint_end_date))." Appointment Status: ".$status;
                $occupied_days[$key]->start  = $value->appoint_start_date;
                $occupied_days[$key]->end  =  $value->appoint_end_date;
            }

            $data['json_occupied_days'] = json_encode($occupied_days);
        } else {
            $data['json_occupied_days'] = json_encode(array());
        }

        $total_rows = $this->calendar_model->getAllinquiryCount($user, $show_completed, $selected_user,$from_date,$to_date);

        $this->load->library('pagination');
        $config['base_url'] = base_url().'calendar/index';
        $config['total_rows'] = $total_rows;

        $this->pagination->initialize($config);

        $offset = ($page * $config['per_page']) - $config['per_page'];
        if( ($offset+1)>$total_rows ){
            $page = 1;
            $offset = ($page * $config['per_page']) - $config['per_page'];    
        }

        $data['inquiries'] = $this->calendar_model->getAllinquiryPage($user,$config['per_page'],$offset,$show_completed,$selected_user,$from_date,$to_date);
        $data['expired_inquiries'] = $this->calendar_model->getExpiredInquiry($user, $selected_user, $from_date, $to_date);

        if(!empty($data['expired_inquiries'][0]->property_type)){
            $data['property_type']= $this->get_propertytypeby_id($data['expired_inquiries'][0]->property_type);
        }else{
            $data['property_type']="";
        }
        
        $data['start'] = 0;
                
        if($total_rows > 0) {
            $data['start'] = $offset + 1;
        }
        
        $data['end'] = $offset  + $config['per_page'];
        if($data['end']>$total_rows){
           $data['end'] = $total_rows;
        }
        $data['calendar'] = $calendar;
        $data['total_rows'] = $total_rows;
        $data['pagination'] = $this->pagination->create_links();
        $data['all_users'] = $this->calendar_model->getAllUsers();
        //$data['inquiries'] = $this->calendar_model->getAllinquiry($user);
        $this->load->view("calendar/index", $data);
    }
    function get_propertytypeby_id($id)
    {

        $data['property_type'] = array('1'=>'Duplex','2' =>'Apartment','3' =>'Penthouse','4' =>'Garden Apartments','5'=>'Studio','6' =>'Townhouse','7' =>'Villa','8' =>'Bungalow','9'=>'Land','10' =>'Shop','11' =>'Office','12' =>'Business','13'=>'Hotel','14' =>'Restaurant','15' =>'Building','16' =>'Industrial estate','17' =>'House','18' =>'Upper-House','19' =>'Maisonette');
        return $data['property_type'][$id];

    }
    
    function deleteInquiry() {
        $this->load->model('calendar_model');
        $user = array();
        if($this->session->userdata('logged_in_super_user')){
            $user = $this->session->userdata('logged_in_super_user');
        }else if($this->session->userdata('logged_in_agent')){
            $user = $this->session->userdata('logged_in_agent');
        }else if($this->session->userdata('logged_in_employee')){
            $user = $this->session->userdata('logged_in_employee');
        }else {
            //If no session, redirect to login page
            redirect('login', 'refresh');
        }
        $id = $this->uri->segment(3);
        $show_completed = $_REQUEST['show_completed'];
        $selected_user = $_REQUEST['selected_user'];
        $from_date = $_REQUEST['from_date'];
        $to_date = $_REQUEST['to_date'];
        $this->calendar_model->deleteinquiry($id);
        $total_rows = $this->calendar_model->getAllinquiryCount($user, $show_completed, $selected_user,$from_date,$to_date);
        echo json_encode(array("success" => true,"total_rows" => $total_rows ));
        
    }

}

?>