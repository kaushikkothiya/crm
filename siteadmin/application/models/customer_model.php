<?php

Class Customer_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function getCustomer($id){
        $q = $this->db->select()
            ->from('customer')
            ->where('id',$id)
            ->get();   
        return $q->row();
    }
}

?>