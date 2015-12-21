<?php

Class Calendar_model extends CI_Model {

    function __construct() {
        parent::__construct();

    }

    function getAllinquiry($user) {

        //$property_type = $this->config->item('property_type');
        $this->db->select('inquiry.*,user.fname,user.lname,agent.fname as agent_fname, agent.lname as agent_lname,property.bedroom, property.type as property_for,property.property_type');
        $this->db->from('inquiry');
        $this->db->join('user','user.id =inquiry.created_by', 'left');
        $this->db->join('user as agent','agent.id =inquiry.agent_id', 'left');
        $this->db->join('property','property.id =inquiry.property_id', 'left');
        $this->db->order_by('inquiry.created_date','DESC');
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return array();

    }

    function getOccupiedDays($user, $selected_user=array()) {
        $this->db->select('inquiry.*,user.fname,user.lname');
        $this->db->from('inquiry');
        $this->db->join('user','user.id =inquiry.created_by','left');
        $this->db->where('inquiry.appoint_start_date !=',"");
        $this->db->where('inquiry.appoint_end_date !=',"");
        //$this->db->where('inquiry.agent_status', 1);
        $this->db->where('inquiry.status', 4);


        if($user['type']==1 && !empty($selected_user)){
            if($selected_user->type == 3){
                $this->db->where('inquiry.created_by',$selected_user->id);
            }else{
                $this->db->where( '( inquiry.created_by = '.$selected_user->id.' OR  inquiry.agent_id = '.$selected_user->id.') ');
            }
        } else {
            if($user['type'] == 3){
                $this->db->where('inquiry.created_by',$user['id']);
            } else {
                if(!($user['type']==1 && empty($selected_user)) ){
                    $this->db->where( '( inquiry.created_by = '.$user['id'].' OR  inquiry.agent_id = '.$user['id'].') ');
                }

            }
        }

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return array();
    }

    function getExpiredInquiry($user, $selected_user=array(),$from_date,$to_date) {

        $this->db->select('inquiry.*,user.fname,user.lname,agent.fname as agent_fname, agent.lname as agent_lname,property.bedroom, property.type as property_for,property.property_type,customer.fname as customer_fname,customer.lname as customer_lname');
        $this->db->from('inquiry');
        $this->db->join('user','user.id =inquiry.created_by','left');
        $this->db->join('user as agent','agent.id =inquiry.agent_id','left');
        $this->db->join('property','property.id =inquiry.property_id','left');
        $this->db->join('customer','customer.id =inquiry.customer_id','left');

        if($user['type']==1 && !empty($selected_user)){
            if($selected_user->type == 3){
                $this->db->where('inquiry.created_by',$selected_user->id);
            }else{
                $this->db->where( '( inquiry.created_by = '.$selected_user->id.' OR  inquiry.agent_id = '.$selected_user->id.') ');
            }
        } else {
            if($user['type'] == 3){
                $this->db->where('inquiry.created_by',$user['id']);
            } else {
                $this->db->where( '( inquiry.created_by = '.$user['id'].' OR  inquiry.agent_id = '.$user['id'].') ');
            }
        }

        $this->db->where('inquiry.status', 4);
        $this->db->where('inquiry.agent_status', 1);
        $this->db->where("DATE_FORMAT(inquiry.appoint_end_date,'%m/%d/%Y') <", date('m/d/Y'));
        $this->db->order_by('inquiry.created_date','DESC');

        $this->db->where("DATE_FORMAT(inquiry.created_date,'%m/%d/%Y') >=", $from_date);
        $this->db->where("DATE_FORMAT(inquiry.created_date,'%m/%d/%Y') <=", $to_date);
        //$this->db->limit($limit,$offset);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return array();

    }

    function getAllinquiryCount($user, $show_completed=false, $selected_user=array(),$from_date="",$to_date="",$inquiry_for="",$inquiry_client="",$inc_search="") {

        //$property_type = $this->config->item('property_type');
        $this->db->select('id');
        $this->db->from('inquiry');
        $this->db->join('user','user.id =inquiry.created_by','left');
        $this->db->join('user as agent','agent.id =inquiry.agent_id','left');
        $this->db->join('property','property.id =inquiry.property_id','left');
        if($show_completed == true){
            $this->db->where('inquiry.status', 5);
        }

        if($user['type']==1 && !empty($selected_user)){
            if($selected_user->type == 3){
                $this->db->where('inquiry.created_by',$selected_user->id);
            }else{
                $this->db->where( '( inquiry.created_by = '.$selected_user->id.' OR  inquiry.agent_id = '.$selected_user->id.') ');
            }
        }

        if($user['type'] == 2){
            $this->db->where( '( inquiry.created_by = '.$user['id'].' OR  inquiry.agent_id = '.$user['id'].') ');
        }else if($user['type'] == 3){
            $this->db->where('inquiry.created_by',$user['id']);
        }
        
        if(!empty($inquiry_for)){
            if($inquiry_for=="rent"){
                $this->db->where("(inquiry.aquired = 'rent' OR inquiry.aquired = 'both')");
            }
            if($inquiry_for=="sale"){
                $this->db->where("(inquiry.aquired = 'sale' OR inquiry.aquired = 'both')");
            }
        }
        
        if(!empty($inquiry_client)){
            $this->db->where("inquiry.customer_id",$inquiry_client);
        }
        
        if(!empty($from_date) && !empty($to_date)){
            $this->db->where("DATE_FORMAT(inquiry.created_date,'%m/%d/%Y') >=", $from_date);
            $this->db->where("DATE_FORMAT(inquiry.created_date,'%m/%d/%Y') <=", $to_date);
        }
        
        if(!empty($inc_search)) {
            $this->db->where("(inquiry.incquiry_ref_no like '%".$inc_search."%' "
                    . "OR user.fname like '%".$inc_search."%' "
                    . "OR user.lname like '%".$inc_search."%' "
                    . "OR CONCAT(user.fname, ' ', user.lname) like '%".$inc_search."%' "
                    . "OR agent.fname like '%".$inc_search."%' "
                    . "OR agent.lname like '%".$inc_search."%' "
                    . "OR CONCAT(agent.fname, ' ', agent.lname) like '%".$inc_search."%' "
                    . ")");
        }

        return $this->db->count_all_results();
    }

    function getUserByID($id){
        $q = $this->db->select("*")
                ->from('user')
                ->where('deleted',0)
                ->where('status','Active')
                ->where('id', $id)
                ->get();
        return $q->row();
    }

    function getAllUsers() {

        $q = $this->db->select("*")
                ->from('user')
                ->where('deleted',0)
                ->where('status','Active')
                ->order_by('id', 'asc')
                ->get();
        if ($q->num_rows() > 0) {
            return $q->result();
        }
        return array();
    }

    function getAllinquiryPage($user,$limit=10,$offset=0,$show_completed=false,$selected_user=array(),$from_date="",$to_date="",$inquiry_for="",$inquiry_client="",$order_by="",$order_type="asc",$inc_search="") {

        //$property_type = $this->config->item('property_type');
        $this->db->select('inquiry.*,user.fname,user.lname,agent.fname as agent_fname, agent.lname as agent_lname,property.bedroom, property.type as property_for,property.property_type');
        $this->db->from('inquiry');
        $this->db->join('user','user.id =inquiry.created_by','left');
        $this->db->join('user as agent','agent.id =inquiry.agent_id','left');
        $this->db->join('property','property.id =inquiry.property_id','left');
        if($show_completed == true){
            $this->db->where('inquiry.status',5);
        }

        if($user['type']==1 && !empty($selected_user)){
            if($selected_user->type==3){
                $this->db->where('inquiry.created_by',$selected_user->id);
            }else{
                $this->db->where( '( inquiry.created_by = '.$selected_user->id.' OR  inquiry.agent_id = '.$selected_user->id.') ');
            }
        }
        if($user['type'] == 2){
            $this->db->where( '( inquiry.created_by = '.$user['id'].' OR  inquiry.agent_id = '.$user['id'].') ');
        }else if($user['type'] == 3){
            $this->db->where('inquiry.created_by',$user['id']);
        }
        
        if(!empty($inquiry_for)){
            if($inquiry_for=="rent"){
                $this->db->where("(inquiry.aquired = 'rent' OR inquiry.aquired = 'both')");
            }
            if($inquiry_for=="sale"){
                $this->db->where("(inquiry.aquired = 'sale' OR inquiry.aquired = 'both')");
            }
        }
        
        if(!empty($inquiry_client)){
            $this->db->where("inquiry.customer_id",$inquiry_client);
        }

        if(!empty($from_date) && !empty($to_date)){
            $this->db->where("DATE_FORMAT(inquiry.created_date,'%m/%d/%Y') >=", $from_date);
            $this->db->where("DATE_FORMAT(inquiry.created_date,'%m/%d/%Y') <=", $to_date);
        }
        
        if(!empty($inc_search)) {
            $this->db->where("(inquiry.incquiry_ref_no like '%".$inc_search."%' "
                    . "OR user.fname like '%".$inc_search."%' "
                    . "OR user.lname like '%".$inc_search."%' "
                    . "OR CONCAT(user.fname, ' ', user.lname) like '%".$inc_search."%' "
                    . "OR agent.fname like '%".$inc_search."%' "
                    . "OR agent.lname like '%".$inc_search."%' "
                    . "OR CONCAT(agent.fname, ' ', agent.lname) like '%".$inc_search."%' "
                    . ")");
        }
        
        if(empty($order_by)){
            $this->db->order_by('inquiry.created_date','DESC');
        }else{
            $order_by = explode(" ", $order_by);
            foreach ($order_by as $value){
                $this->db->order_by($value,$order_type);
            }
        }
        $this->db->limit($limit,$offset);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return array();

    }
    
    function deleteinquiry($id) {
        $this->db->where('id', $id);
        $this->db->delete('inquiry');
    }

}

?>