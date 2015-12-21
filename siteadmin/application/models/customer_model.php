<?php

Class Customer_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function getCustomer($id){
        $q = $this->db->select("customer.*,county_code.prefix_code")
            ->from('customer')
            ->join('county_code', 'county_code.prefix_code =customer.coutry_code','left')
            ->where('customer.id',$id)
            ->get();   
        return $q->row();
    }
}

?>