<?php

Class Appointment_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

  function get_days_appointments() {
          
        $day_start = date('Y-m-d 00:00:00');
        $day_end = date('Y-m-d 23:59:59');

          $q = $this->db->select("inquiry.*,user.id as agent_id,user.fname as agent_fname,user.email as agent_email,user.lname as agent_lname,user.mobile_no as agent_mobile_no,user.coutry_code as agent_coutry_code,customer.fname as customer_fname,customer.lname as customer_lname,customer.mobile_no as customer_mobile_no,customer.coutry_code as customer_coutry_code,customer.id as customer_id,customer.email as customer_email")
                ->from('inquiry')
                ->join('user','user.id =inquiry.agent_id')
                ->join('customer','customer.id =inquiry.customer_id')
                ->where('inquiry.appoint_start_date >', $day_start)
                ->where('inquiry.appoint_end_date <', $day_end)
                ->get();
        if ($q->num_rows() > 0) {
            return $q->result();
        }
        return array();      

        
    }

}
?>