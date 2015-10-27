<?php

Class Blog_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get_properties($no)
    {
        $this->db->select('*');
        $this->db->from('property');
        $this->db->where('reference_no', $no);
        $query=$this->db->get();
        $data = $query->result();
        return $data;
    }
    function get_city($name)
    {
        $this->db->select('id');
        $this->db->from('city');
        $this->db->where('title', $name);
        $query=$this->db->get();
        $data = $query->result();

        if (empty($data)) {
             $ins_city  = array('title' => $name, 'state_id' => '1', 'created_date' => date('Y-m-d H:i:s'), 'status' =>'Active');
            $id = $this->db->insert('city', $ins_city);
            return $this->db->insert_id();
        }else{
            return $data[0]->id;
        }
        //return $data;
    }
    function get_city_area($city_id, $name)
    {
        $this->db->select('id');
        $this->db->from('city_area');
        $this->db->where('title', $name);
        $this->db->where('city_id', $city_id);
        $query=$this->db->get();
        $data = $query->result();

        if (empty($data)) {
             $ins_city  = array('title' => $name, 'city_id' => $city_id, 'created_date' => date('Y-m-d H:i:s'), 'status' =>'Active');
            $id = $this->db->insert('city_area', $ins_city);
            return $this->db->insert_id();
        }else{
            return $data[0]->id;
        }
        //return $data;
    }
    function get_adduser($value, $city_id){
        $namevalue = $this->db->escape_like_str($value['B']);

        $this->db->select('id');
        $this->db->from('user');
        $this->db->where("CONCAT(fname, ' ', lname) LIKE '%".$namevalue."%'", NULL, FALSE);
        $this->db->where('type', '2');
        $query=$this->db->get();
        $data = $query->result();
        
        $name = explode(" ", $value['B']);
        //$save_data =  array('fname' => $name[0],'lname' => $name[1],'email' => $value['AG'],'mobile_no' => $value['AF'],'coutry_code' => '7840','contry_id' => '1','state_id' => '1', 'city_id'=> $city_id, 'status'=> 'Active', 'created_date'=> date('Y-m-d H:i:s'), 'type'=> '2');
        
        $con_det = $this->get_country_code($value['AF']);

        $save_data =  array('fname' => $name[0],'lname' => $name[1],'coutry_code' => $con_det,'contry_id' => '1','state_id' => '1', 'city_id'=> $city_id, 'status'=> 'Active', 'created_date'=> date('Y-m-d H:i:s'), 'type'=> '2');        
        if (empty($data)) {  
            $this->db->insert('user', $save_data);
            $id = $this->db->insert_id();
            //return $this->db->insert_id();
        }else{
           $save_data['updated_date'] = date('Y-m-d H:i:s');
           unset($save_data['created_date']);
            $this->db->update('user', $save_data, array('id' => $data[0]->id));
            $id = $data[0]->id;            
        }
        return $id;
    }

    function propertyinsert_entry($data_prop)
    {
        $this->db->select('id');
        $this->db->from('property');
        $this->db->where('reference_no', $data_prop['reference_no']);
        $query=$this->db->get();
        $data = $query->result();
        
        //echo "<pre>";print_r($data_prop);exit;
        if (empty($data)) {  
            $this->db->insert('property', $data_prop);
            $id = $this->db->insert_id();
            //return $this->db->insert_id();
        }else{
           $data_prop['updated_date'] = date('Y-m-d H:i:s');
           unset($data_prop['created_date']);
            $this->db->update('property', $data_prop, array('id' => $data[0]->id));
            $id = $data[0]->id;            
        }
        return $id;
    }
    function insert_facilities($datavalue,$property_id,$cattype)
    {
        
        $this->db->select('id');
        $this->db->from('facilities');
        $this->db->where('title', $datavalue);
        $this->db->where('category_id', $cattype);
        $query=$this->db->get();
        $facdata = $query->result();
        
        $savefec_data =  array('category_id' => $cattype,'title' => $datavalue,'created_date' => date('Y-m-d H:i:s'));
        if (empty($facdata)) { 
            $this->db->insert('facilities', $savefec_data);
            $fecid = $this->db->insert_id();
        }else{
            $fecid = $facdata[0]->id;
        }

        $prop_fec_data =  array('property_id' => $property_id,'facility_id' => $fecid,'created_date' => date('Y-m-d H:i:s'));
        $this->db->insert('property_facility', $prop_fec_data);
        $propfecid = $this->db->insert_id();
    }

    function delete_fecelity($property_id)
    {
        $this->db->where('property_id', $property_id);
        $this->db->delete('property_facility'); 
    }

    function get_area($cityarea)
    {
        $this->db->select('id');
        $this->db->from('city_area');
        $this->db->where('title', $cityarea);
        $query=$this->db->get();
        $citydata = $query->result(); 

        $savefec_data =  array('title' => $cityarea,'city_id' => '1','created_date' => date('Y-m-d H:i:s'));
        if (empty($citydata)) { 
            $this->db->insert('city_area', $savefec_data);
            $cityareaid = $this->db->insert_id();
        }else{
            $cityareaid = $citydata[0]->id;
        }

        return $cityareaid;
    }

function get_inquirecustomer($value)
    {
        if (!empty($value['E'])) {
            $this->db->select('id');
            $this->db->from('customer');
            $this->db->where('mobile_no', $value['E']);
            $query=$this->db->get();
            $customerdata = $query->result(); 
        }
        else{
            $customerdata = "";
            $mobileno = "";
        }
        
        $savecust_data =  array('fname' => $value['B'],'lname' => $value['C'],'mobile_no'=>$value['E'],'type'=>'0','status'=>'Active','created_date' => $value['A']);

        if(empty($customerdata)){ 
            $this->db->insert('customer', $savecust_data);
            $customerid = $this->db->insert_id();
        }else{
            $customerid = $customerdata[0]->id;
        }
        
        return $customerid;

    }
    function get_inquireuser($value,$date)
    {
        $namevalue = $this->db->escape_like_str($value);

        $this->db->select('id');
        $this->db->from('user');
        $this->db->where("CONCAT(fname, ' ', lname) LIKE '%".$namevalue."%'", NULL, FALSE);
        $this->db->where('type', '2');
        $query=$this->db->get();
        $data = $query->result();
    
        $name = explode(" ",$value);
        $save_data =  array('fname' => $name[0],'lname' => $name[1],'status'=> 'Active', 'created_date'=> $date, 'type'=> '2');
        
        if (empty($data)) {  
            $this->db->insert('user', $save_data);
            $id = $this->db->insert_id();
            //return $this->db->insert_id();
        }else{
           $id = $data[0]->id;            
        }
        return $id;

    }
    function get_inquire_property($data_prop)
    {
       
        $this->db->select('id');
        $this->db->from('property');
        $this->db->where('reference_no', $data_prop['reference_no']);
        $query=$this->db->get();
        $data = $query->result();
        
        if (empty($data)) { 
            //$this->db->insert('property', $data_prop);
            //$id = $this->db->insert_id();
            //return $this->db->insert_id();
            $id = -1;   
        }else{
           $data_prop['updated_date'] = $data_prop['created_date'];
           unset($data_prop['created_date']);
            $this->db->update('property', $data_prop, array('id' => $data[0]->id));
            $id = $data[0]->id;         
        }
        return $id;
    }

    function get_inquire_inquiredata($data_inquire)
    {
        $this->db->insert('inquiry', $data_inquire);
        $id = $this->db->insert_id();
        return $id;
    }

    function insertdata($data,$table)
    {
        $this->db->insert($table, $data);
        $id = $this->db->insert_id();
        return $id;
    }
    
    function check_unic_prop_refno_num($inquiry_prop_num){
        $this->db->select('id');
        $this->db->from('property');
        $this->db->where('reference_no', $inquiry_prop_num);
        $query=$this->db->get();
        $data = $query->result();
        
        return $data;
    }
    function get_country_code($country_code){
        $country_code = str_replace("0", "", $country_code);

        $this->db->select('id');
        $this->db->from('county_code');
        $this->db->where('prefix_code', '+'.$country_code);
        $query=$this->db->get();
        $data = $query->result();
        
        
        if (!empty($data)) {
           $con_det_id = $data['0']->id;
        }else{
            $con_det_id = "357";
        }

        return $con_det_id;
    }
}
?>