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


    public function notifyUser($user,$subject,$message,$sms,$inquiry_id=0){
                
        $email_sent = false;
        $sms_sent = false;
        if (!empty($user->email)) {
            $email_sent = $this->sendEmail($user->email,$subject,$message);
            // save Agent history
            $history_text = $message;
            $history_subject = $subject;
            $history_type = "E-mail";
            $history_reciever_email = $user->email;
            $history_reciever_id = $user->id;
            if(!empty($user->type)){
                $history_reciever_usertype = "2";
            }else{
                $history_reciever_usertype = "1";
            }
            $history_inquiryid = $inquiry_id;
        }
        
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
        
        $history_type_sms = "SMS";
        $history_type = "E-mail";
        if($sms_sent && $email_sent){
            $history_type_sms = "SMS/E-mail";
            $history_type = "SMS/E-mail";
        }
        
        if($sms_sent){
           $this->inquiry_model->saveSmsEmailHistory($history_text_sms, $history_subject_sms, $history_type_sms, $history_reciever, $history_reciever_id, $history_reciever_usertype, $history_inquiryid); 
        }
        
        if($email_sent){
            $this->inquiry_model->saveSmsEmailHistory($history_text, $history_subject, $history_type, $history_reciever_email, $history_reciever_id, $history_reciever_usertype, $history_inquiryid);
        }
        
    }    
}