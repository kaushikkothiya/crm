<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class MY_Controller extends CI_Controller {
    public function __construct() {
        parent::__construct();
        // Your own constructor code
    }
    
    public function mailChimpSubscribe($cust_id) {
        
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
                $rent_group = $grp;
            }
            if($grp['id']=='16409'){
                $sale_group = $grp;
            }
        }
        
        $this->load->model('newsletter_model');
        $mc_res = $this->newsletter_model->getMinMaxPriceByCustomerID($cust_id,$sale_group,$rent_group);
        if(!empty($mc_res['email'])) {
            $merge_vars = array();
            $merge_vars['groupings'] = array(
                array(
                    'id' => '16389',
                    'groups' => array('4')
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
            );
            @$mc->lists->subscribe($list_id,array('email'=>$mc_res['email']),$merge_vars,'html',FALSE,true);
        }
    
    }
}