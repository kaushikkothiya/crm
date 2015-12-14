<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class MY_Controller extends CI_Controller {
    
    public $cur_user = array();
    public function __construct() {
        parent::__construct();
        // Your own constructor code
        if ($this->session->userdata('logged_in_super_user')){
            $this->cur_user = $this->session->userdata('logged_in_super_user');
        } else if($this->session->userdata('logged_in_agent')) {
            $this->cur_user = $this->session->userdata('logged_in_agent');
        } else if($this->session->userdata('logged_in_employee')) {
            $this->cur_user = $this->session->userdata('logged_in_employee');
        }
    }
    
    public function generatePassword(){
        $length = rand(6,10);
        $str = '';
        $chr_range = array(
            array(48,57),
            array(65,90),
            array(97,122),
            array(33,47),
            array(58,64),
            array(91,96),
            array(123,126)
        );
        
        for($i=0;$i<=$length;$i++){
            $range = $chr_range[rand(0,6)];
            $new_char = chr(rand($range[0],$range[1]));
            $str.= $new_char;
        }
        return $str;
    }
    
    public function mailChimpSubscribe($cust_id,$type=1) {
        
        require_once APPPATH . 'third_party/Classes/Mailchimp.php';
        $apikey = "cfd5c04a3ac23d934368362c187700c4-us3";
        $unique_id = time() . '_' . rand(1000, 9999) . '_' . rand(1000, 9999);
        $mc = new Mailchimp($apikey);
        $list_id = 'd42363dd0e';

        $grps = $mc->lists->interestGroupings($list_id);
        
        $rent_group = array();
        $sale_group = array();
        foreach($grps as $grp){
            if($grp['id']=='16405'){
                $rent_group = $grp;
            }
            if($grp['id']=='16409'){
                $sale_group = $grp;
            }
        }
        
        $this->load->model('newsletter_model');
        
        $mc_res = $this->newsletter_model->getMinMaxPriceByCustomerID($cust_id,$sale_group,$rent_group,$type);
        
        if(!empty($mc_res['email'])) {
            $merge_vars = array();
            $merge_vars['FNAME'] = $mc_res['fname'];
            $merge_vars['LNAME'] = $mc_res['lname'];
            $merge_vars['groupings'] = array(
                array(
                    'id' => '16389',
                    'groups' => array($mc_res['type'])
                ),
                array(
                    'id' => '16393',
                    'groups' => array($mc_res['aquired'])
                ),
                array(
                    'id' => '16405',
                    'groups' => $mc_res['rent_grps']
                ),
                array(
                    'id' => '16409',
                    'groups' => $mc_res['sale_grps']
                ),
                array(
                    'id'=>'16581',
                    'groups' => array($mc_res['status'])
                ),
            );
            @$mc->lists->subscribe($list_id,array('email'=>$mc_res['email']),$merge_vars,'html',FALSE,true);
        }
        
    }
    
    public function sendEmail($email,$subject,$message){
        $this->load->library('email');
        $this->email->from($this->config->item('email_from'), $this->config->item('title'));
        $this->email->to($email);
        $this->email->subject($subject);        
        $this->email->message($message);
        $sendEmailFlag1 = "";
        if ($this->email->send()) {
            return true;
        }else{
            return false;
        }
    }
    
    public function sendSMS($user, $mobile_code,$sms){
        $this->load->library('CMSMS');
        $sms_res1 = CMSMS::sendMessage($mobile_code . $user->mobile_no, $sms);
        if (empty($sms_res1)) {
            return true;
        }else{
            return false;
        }
    }
   
    public function notifyUser($user,$subject,$message,$sms,$inquiry_id=0,$mail_only=0){
                
        $email_sent = false;
        $sms_sent = false;
        if($mail_only !=2) {
            if (!empty($user->email)) {
                $email_sent = $this->sendEmail($user->email,$subject,$message);
                // save Agent history
                $history_text = $message;
                $history_subject = $subject;
                $history_type = "E-mail";
                $history_reciever_email = $user->email;
                $history_reciever_id = $user->id;
                if(!empty($user->type)) {
                    $history_reciever_usertype = "2";
                }else{
                    $history_reciever_usertype = "1";
                }
                $history_inquiryid = $inquiry_id;
            }
        }
        if($mail_only !=1) {
            if (!empty($user->mobile_no)) {
                $this->load->model('user');
                
                $country_code = $this->user->get_contry_code($user->coutry_code);
                if (!empty($country_code)) {
                    $mcode = substr($country_code[0]->prefix_code, 1);
                    $mobile_code = "00" . $mcode;
                    $sms_sent = $this->sendSMS($user, $mobile_code,$sms);
                    
                    $history_text_sms = $sms;
                    $history_subject_sms = $subject;
                    $history_type_sms = "SMS";
                    $history_reciever = $mobile_code . $user->mobile_no;
                    $history_reciever_id = $user->id;
                    if(!empty($user->type)){
                        $history_reciever_usertype = "2";
                    }else{
                        $history_reciever_usertype = "1";
                    }
                    $history_inquiryid = $inquiry_id;
                }
            }
        }
        
        $history_type_sms = "SMS";
        $history_type = "E-mail";
        if($sms_sent && $email_sent){
            $history_type_sms = "SMS/E-mail";
            $history_type = "SMS/E-mail";
        }
        
        if($sms_sent) {
           $this->inquiry_model->saveSmsEmailHistory($history_text_sms, $history_subject_sms, $history_type_sms, $history_reciever, $history_reciever_id, $history_reciever_usertype, $history_inquiryid); 
        }
        
        if($email_sent) {
            $this->inquiry_model->saveSmsEmailHistory($history_text, $history_subject, $history_type, $history_reciever_email, $history_reciever_id, $history_reciever_usertype, $history_inquiryid);
        }
    }
    
    function get_propertytypeby_id($id) {
        $data['property_type'] = array('1'=>'Duplex','2' =>'Apartment','3' =>'Penthouse','4' =>'Garden Apartments','5'=>'Studio','6' =>'Townhouse','7' =>'Villa','8' =>'Bungalow','9'=>'Land','10' =>'Shop','11' =>'Office','12' =>'Business','13'=>'Hotel','14' =>'Restaurant','15' =>'Building','16' =>'Industrial estate','17' =>'House','18' =>'Upper-House','19' =>'Maisonette');
        return $data['property_type'][$id];
    }
    
    function get_architectural_design($id) {
        $data['get_architectural_design'] = array('1'=>'Contemporary','2' =>'Modern','3' =>'Classic');
        return $data['get_architectural_design'][$id];
    }
    function get_room_size_id($id) {
        $data['get_room_size_id'] = array('1'=>'Small','2' =>'Medium','3' =>'Large');
        return $data['get_room_size_id'][$id];
    }
    
    function property_aquired_type($id) {
        $data['aquired_type'] = array('1'=>'Sale','2' =>'Rent','3' =>'Both(Sale/Rent)');
        return $data['aquired_type'][$id];
    }
}