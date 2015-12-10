<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class NewsLetter extends MY_Controller {

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
    
    public function index(){
        $this->smsNewsletter();
    }
    
    public function email_newsletter_list(){
        if (!$this->session->userdata('logged_in_super_user')) {
            $this->session->set_flashdata('error', 'Not allowed!');
            redirect('login', 'refresh');
            exit;
        }
        $this->load->model('newsletter_model');
        $newsletterds = $this->newsletter_model->getAllNewsLetters();
        $this->load->view('newsletter/email_newsletter_list_view',array('newsletters'=>$newsletterds));
    }
    
    public function sms_newsletter_list(){
        if (!$this->session->userdata('logged_in_super_user')) {
            $this->session->set_flashdata('error', 'Not allowed!');
            redirect('login', 'refresh');
            exit;
        }
        $this->load->model('newsletter_model');
        $newsletterds = $this->newsletter_model->getAllSMSNewsLetters();
        $this->load->view('newsletter/sms_newsletter_list',array('newsletters'=>$newsletterds));
    }
    
    public function emailNewsletter() {
        if (!$this->session->userdata('logged_in_super_user')) {
            $this->session->set_flashdata('error', 'Not allowed!');
            redirect('login', 'refresh');
            exit;
        }
        
        if(!empty($_POST)){
            
            include APPPATH . 'third_party/Classes/Mailchimp.php';
            $apikey = "cfd5c04a3ac23d934368362c187700c4-us3";
            $unique_id = time() . '_' . rand(1000, 9999) . '_' . rand(1000, 9999);
            $mc = new Mailchimp($apikey);
            $list_id = 'd42363dd0e';
            
            $receivers = $this->input->post('receivers');
            $content = $this->input->post('content');
            $user_type = $this->input->post('user_type');
            $client_specification = $this->input->post('client_specification');
            $price_min = $this->input->post('price_min');
            $price_max = $this->input->post('price_max');
            $campaign_name = $this->input->post('campaign_name');
            $schedule = $this->input->post('schedule');
            $schedule_date = $this->input->post('schedule_date');
            
            $rent_range = $this->input->post('rent_range');
            $sale_range = $this->input->post('sale_range');
            
            if(!empty($schedule_date)){
                $schedule_date = explode("/", $schedule_date);
                $schedule_date = $schedule_date[2]."-".$schedule_date[0]."-".$schedule_date[1];
            }
            
            $content = str_replace('{first_name}', '*|FNAME|*', $content);
            $content = str_replace('{last_name}', '*|LNAME|*', $content);
                        
            $segment = array(
                "match" => "all",
                "conditions" => array()
            );
            
            if(!empty($user_type)){
                $utypes = array();
                if(in_array('administrator', $user_type)){
                    $utypes[]=1;
                }
                if(in_array('agents', $user_type)){
                    $utypes[]=2;
                }
                if(in_array('employees', $user_type)){
                    $utypes[]=3;
                }
                if(in_array('customers', $user_type)){
                    $utypes[]=4;
                }
                $utypes = implode(",", $utypes);
                $group_id = '16389';
                $segment['conditions'][] = array(
                    "field" => 'interests-' . $group_id,
                    "op" => "one",
                    "value" => $utypes
                );
            }
            
            if(in_array('customers', $user_type) && $client_specification!="both"){
                $group_id = '16393';
                $segment['conditions'][] = array(
                    "field" => 'interests-' . $group_id,
                    "op" => "one",
                    "value" => $client_specification.',none'
                );
            }
            
            if(in_array('customers', $user_type) && !empty($rent_range)){
                $group_id = '16405';
                $segment['conditions'][] = array(
                    "field" => 'interests-' . $group_id,
                    "op" => "one",
                    "value" => $rent_range
                );
            }
            
            if(in_array('customers', $user_type) && !empty($sale_range)){
                $group_id = '16409';
                $segment['conditions'][] = array(
                    "field" => 'interests-' . $group_id,
                    "op" => "one",
                    "value" => $sale_range
                );
            }
            
            $group_id = '16581';
            $segment['conditions'][] = array(
                "field" => 'interests-' . $group_id,
                "op" => "none",
                "value" => array('0')
            );
           
            
//            $segment_id = $mc->lists->segmentAdd( $list_id,
//                array(
//                    'type'=>'saved',
//                    'name'=>time().rand(1000,9999),
//                    'segment_opts'=>$segment
//                )
//            );
//            
//            print_r($segment_id);
//            exit;
            //$result = $mc->lists->segmentTest($list_id,$segment);
            //print_r($result);
            //exit;
            
            if($schedule=='repetitive'){
                $campaign_type = 'auto';
            }else{
                $campaign_type = 'regular';   
            }
            
            $type_opt = array();
            if($campaign_type=='auto'){
                $duration = $this->input->post('duration');
                $type_opt['offset-dir'] = 'before';
                $type_opt['offset-units '] = $duration;
            }
            
            $result = $mc->campaigns->create($campaign_type, 
                array(
                    'list_id' => $list_id,
                    'subject' => $campaign_name,
                    'from_email' => 'test@webplanex.com',
                    'from_name' => 'Monopolion',
                    'to_name' => 'Recipients'
                ), 
                array(
                    'html' => $content
                ),
                $segment,
                $type_opt
            );
            
            if(isset($result['id'])){
                
                $campaign = array();
                $campaign['campaign_id'] = $result['id'];
                $campaign['title'] = $result['subject'];
                $campaign['content'] = $content;
                $campaign['type'] = $schedule;
                if($schedule=='date'){
                    $campaign['schedule'] = $schedule_date;
                }else if($schedule=='repetitive'){
                    $campaign['schedule'] = $duration;
                }
                
                $save_flag=false;
                if($schedule=='now'){
                    try{
                        $sent = $mc->campaigns->send($campaign['campaign_id']);
                        if($sent['complete']){
                            $save_flag=true;
                        }else{
                            $this->session->set_flashdata('error', 'Newsletter saved but failed to send!');
                            redirect('newsletter/emailnewsletter');
                        }
                    }  catch (Exception $e){
                        $this->session->set_flashdata('error', 'Newsletter saved but failed to send!');
                        redirect('newsletter/emailnewsletter');
                    }
                } else if($schedule=='date'){
                    $schedule_date = date("Y-m-d H:i:s",strtotime($schedule_date));
                    $sent = $mc->campaigns->schedule($campaign['campaign_id'],$schedule_date);
                    if($sent['complete']){
                        $save_flag=true;
                    }else{
                        $this->session->set_flashdata('error', 'Newsletter failed to schedule on given date!');
                        redirect('newsletter/emailnewsletter');
                    }
                }else{
                    $save_flag=true;
                }
                $campaign['success'] = $save_flag;
                $this->load->model('newsletter_model');
                if($this->newsletter_model->saveNewsletter($campaign)){
                    
                    $this->session->set_flashdata('success', 'Newsletter have been saved to send!');
                    redirect('newsletter/email_newsletter_list');
                }else{
                    $this->session->set_flashdata('error', 'Newsletter Failed. please try again!');
                    redirect('newsletter/emailnewsletter');
                }   
            }else{
                $this->session->set_flashdata('error', 'Newsletter Failed. please try again!');
                redirect('newsletter/emailnewsletter');
            }
        }
        
        include APPPATH . 'third_party/Classes/Mailchimp.php';
        $apikey = "cfd5c04a3ac23d934368362c187700c4-us3";
        $unique_id = time() . '_' . rand(1000, 9999) . '_' . rand(1000, 9999);
        $mc = new Mailchimp($apikey);
        $list_id = 'd42363dd0e';

        $grps = $mc->lists->interestGroupings($list_id);
        $rent_group = array();
        $sale_group = array();
        foreach($grps as $grp){
            if($grp['id']=='16405'){
                $rent_group = $grp['groups'];
            }
            if($grp['id']=='16409'){
                $sale_group = $grp['groups'];
            }
        }
        
        $data = array('rent_group'=>$rent_group,'sale_group'=>$sale_group);
        $this->load->view('newsletter/email', $data);
    }
    
    public function ajax_get_receivers(){
        $id = $_REQUEST['id'];
        $this->load->model('newsletter_model');
        
        //header('Content-type: application/json');
        $res = $this->newsletter_model->getSMSNewsletterByID($id);
        if(!empty($res)){
            echo $res[0]->receivers;
        }else{
            echo "[]";
        }
        exit;
    }
    
    public function smsNewsletter() {
        if (!$this->session->userdata('logged_in_super_user')) {
            $this->session->set_flashdata('error', 'Not allowed!');
            redirect('login', 'refresh');
            exit;
        }
        
        if(!empty($_POST)){
            set_time_limit(0);
            $receivers = $this->input->post('receivers');
            $message = $this->input->post('content');
            $title = $this->input->post('title');
            
            $sms_newsletter = array();
            $sms_newsletter['title'] = $title;
            $sms_newsletter['content'] = $message;
            $sms_newsletter['receivers'] = array();
            
            foreach($receivers as $receiver){
                $sms_newsletter['receivers'][] = explode("|", $receiver);
            }
            $sms_newsletter['receivers'] = json_encode($sms_newsletter['receivers']);
            
            $this->load->library('CMSMS');
            $sms_res = CMSMS::sendBulkMessage($receivers, $message);
            
            $this->load->model('newsletter_model');
            
            if($this->newsletter_model->saveSMSNewsletter($sms_newsletter)){
                $this->session->set_flashdata('success', 'SMS has been saved to send!');
                redirect('newsletter/sms_newsletter_list');
            }
        }
        
        $data = array();
        $this->load->view('newsletter/sms', $data);
    }
    
    function nullToString(&$item) {
        if (!is_array($item) && !is_object($item)) {
            $item = strval($item);
        } else {
            if (is_object($item)) {
                $item = (array) $item;
            }
            array_walk($item, array($this, 'nullToString'));
        }
    }
    
    public function ajax_get_receviers(){
        $this->load->model('newsletter_model');
        $data = $_REQUEST;
        
        $staff_list = array();
        if(!empty($data['user_type'])){
            if(count($data['user_type'])==1 && in_array('customers', $data['user_type'])){}else{
                $staff_list = $this->newsletter_model->getStaffReceiverList($data,'sms');
            }
        }
        
        $customer_list = array();
        if(!empty($data['user_type']) && in_array('customers', $data['user_type'])){
            $customer_list = $this->newsletter_model->getCustomerReceiverList($data,'sms');
        }
        $receviers = array_merge($staff_list, $customer_list);
        
        array_walk($receviers,array($this, 'nullToString'));
        
        header('Content-type: application/json');
        echo json_encode($receviers);
        exit;
    }
    
    public function sendbulksms(){
        
    }
}

?>