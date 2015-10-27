<?php

Class Inquiry_model extends CI_Model {

    function __construct() {
        parent::__construct();
     
    }

     function getallcity() {

        $this->db->select('*');
        $this->db->from('city')->order_by('title', 'ASC');
        $query = $this->db->get();
        $data = $query->result();
          
         $citydata[0] = "Select City";
        for ($i = 0; $i < count($data); $i++) {
            $citydata[$data[$i]->id] = $data[$i]->title;
        }
        return $citydata;
    }
    function get_related_property_agent_id($id) {

        $q = $this->db->select("agent_id")
                ->from('property')
                ->where('id', $id)
                ->get();
        if ($q->num_rows() > 0) {
            return $q->result();
        }
        return array();
    }
     function getAllcity_area() {

        $this->db->select('*');
        $this->db->from('city_area')->order_by('title', 'ASC');
        $query = $this->db->get();
        $data = $query->result();
         
        $citydata[0] = "Select City Area";
        for ($i = 0; $i < count($data); $i++) {
            $citydata[$data[$i]->id] = $data[$i]->title;
        }
        return $citydata;
    }
    
    function getAllinquiry($inc_view,$client) {
        if($inc_view !=""){
            if($client =='1'){
               $this->db->select('inquiry.*,user.fname,user.lname');
               $this->db->from('inquiry');
               $this->db->join('user','user.id =inquiry.created_by'); 
               $this->db->where('customer_id',$inc_view);
               $query = $this->db->get();
               return $query->result();
            }else{
               $this->db->select('inquiry.*,user.fname,user.lname');
               $this->db->from('inquiry');
               if($inc_view !="latest"){
                    $this->db->where('aquired',$inc_view);
                    $this->db->or_where('aquired','both');
                }else{
                    $this->db->order_by('created_date','DESC');
                }
               $this->db->join('user','user.id =inquiry.created_by'); 
               $query = $this->db->get();
               return $query->result();
           }
        }else{
            $q = $this->db->select('inquiry.*,user.fname,user.lname')
                    ->from('inquiry')
                    ->join('user','user.id =inquiry.created_by')
                    ->get();
            if ($q->num_rows() > 0) {
                return $q->result();
            }
            return array();
                
        }

        // $this->db->select('inquiry.*,user.fname,user.lname,user.email,user.mobile_no')->distinct();
        // $this->db->from('inquiry');
        // $this->db->join('user','user.id =inquiry.agent_id');
        // if($this->session->userdata('logged_in_agent')) {
        //   $sessionData = $this->session->userdata('logged_in_agent');
        //   $id = $sessionData['id'];
        //   $this->db->where('inquiry.agent_id',$id);
        // }elseif($this->session->userdata('logged_in_employee')) {
        //     $sessionData = $this->session->userdata('logged_in_employee');
        //     $id = $sessionData['id'];
        //     $this->db->where('inquiry.employee_id',$id);
        // }
        // $query = $this->db->get();
        // return $query->result();
    }
     function getrelated_property($post) {
       
        //echo'<pre>';print_r($_POST);exit;
        $this->db->select('property.*,city_area.title,city.id as city_id');
        $this->db->join('city_area','city_area.id =property.city_area');
        $this->db->join('city','city.id =property.city_id');
        $this->db->from('property');
        
        if(!empty($post['property_type'])){
            if($post['property_type'] !='3'){
                $this->db->where('property.type', $post['property_type']);
                $this->db->or_where('property.type','3');
            }
        }
        // if(!empty($post['location']))
        //     $this->db->like('property.address', $post['location']);

        if(!empty($post['city']) && $post['city'] !='0')
            $this->db->where('property.city_id', $post['city']);
        
        if(!empty($post['selectItemcity_area']))
        {
           $this->db->where_in('property.city_area',$post['selectItemcity_area']);
        }
        if(!empty($post['property_category']))
            $this->db->where('property.property_type', $post['property_category']);

        if(!empty($post['bedroom']))
            $this->db->where('property.bedroom', $post['bedroom']);

        if(!empty($post['bathroom']))
            $this->db->where('property.bathroom', $post['bathroom']);
        

        if(!empty($post['reference_no']))
            $this->db->where('property.reference_no', $post['reference_no']);

        if(!empty($post['property_type'])=="1"){
            if(!empty($post['min_price']))
                $this->db->where('property.sale_price >=', $post['min_price']);
            if(!empty($post['max_price']))
                $this->db->where('property.sale_price <=', $post['max_price']);

        }elseif (!empty($post['property_type'])=="2") {
            if(!empty($post['min_price']))
                $this->db->where('property.rent_price >=', $post['min_price']);
            if(!empty($post['max_price']))
                $this->db->where('property.rent_price <=', $post['max_price']);
        
        }elseif (!empty($post['property_type'])=="3"){
            if(!empty($post['min_price']))
            {
                $this->db->where('property.sale_price >=', $post['min_price']);
                $this->db->or_where('property.rent_price >=', $post['min_price']);
            }
            if(!empty($post['max_price']))
            {
                $this->db->where('property.sale_price <=', $post['max_price']);
                $this->db->or_where('property.rent_price <=', $post['max_price']);
            }
                
        }
        $query = $this->db->get();
        return $query->result();
    }

     function getPropertyDetailsById($propertyIdsStr) {
       //echo'<pre>';print_r($_POST);exit;
        $this->db->select('*');
        $this->db->from('property');
        $this->db->where_in('id', $propertyIdsStr);
        $query = $this->db->get();
        return $query->result();
    }

    function get_releted_ref_property($num) {
        $q = $this->db->select("*")
                ->from('property')
                ->where('reference_no',$num)
                ->get();
        if ($q->num_rows() > 0) {
            return $q->result();
        }
        return array();
    }
    function get_inc_agent($agent_id) {
        $q = $this->db->select("fname,lname")
                ->from('user')
                ->where('id',$agent_id)
                ->get();
        if ($q->num_rows() > 0) {
            return $q->result();
        }
        return array();
    }
    function agent_schedule() {
        
       /* $q = $this->db->select('id, appoint_start_date, appoint_end_date')
                ->from('inquiry')
                ->get();
        if ($q->num_rows() > 0) {
            return $q->result();
        }
        return array();*/

        $this->db->select('inquiry.*,user.*');
        $this->db->from('inquiry');
        if($this->session->userdata('logged_in_super_user')){
            $this->db->join('user','user.id =inquiry.agent_id','left');
        }elseif($this->session->userdata('logged_in_agent')){
            $sessionData = $this->session->userdata('logged_in_agent');
            $id = $sessionData['id'];
            $this->db->join('user','user.id = inquiry.agent_id');
            $this->db->where('inquiry.agent_id',$id);
        }
        $this->db->where('inquiry.agent_id !=','0');
        $this->db->where('inquiry.appoint_start_date !=','');
        $this->db->where('inquiry.appoint_end_date !=','');
        $query = $this->db->get();
        return $query->result();
    }
    function getAll_appointmentAgent()
   {
        $this->db->select('*');
        $this->db->from('user')->order_by('fname', 'ASC');
        // if($this->session->userdata('logged_in_agent')){
        //     $sessionData = $this->session->userdata('logged_in_agent');
        //     $id = $sessionData['id'];
        //     $this->db->where('user.id',$id);
        // }
        $query = $this->db->get();
        $data = $query->result();
          
        for ($i = 0; $i < count($data); $i++) {
            $agentData[$data[$i]->id] = $data[$i]->fname." ".$data[$i]->lname;
        }
        return $agentData;
   }
    function getAllAgent()
   {
        $this->db->select('*');
        $this->db->from('user')->order_by('fname', 'ASC');
        if($this->session->userdata('logged_in_agent')){
            $sessionData = $this->session->userdata('logged_in_agent');
            $id = $sessionData['id'];
            $this->db->where('user.id',$id);
        }
        $query = $this->db->get();
        $data = $query->result();
          
        for ($i = 0; $i < count($data); $i++) {
            $agentData[$data[$i]->id] = $data[$i]->fname." ".$data[$i]->lname;
        }
        return $agentData;
   }
   function agent_detail_byid($id) {
        
        $q = $this->db->select('*')
                ->from('inquiry')
                ->where('agent_id',$id)
                ->where('agent_id !=','0')
                ->where('appoint_start_date !=','')
                ->where('appoint_end_date !=','')
                ->get();
        if ($q->num_rows() > 0) {
            return $q->result();
        }
        return array();

    }
    
    function get_customer_detail($cust_id) {
        
        $q = $this->db->select('*')
                ->from('customer')
                ->where('id',$cust_id)
                ->get();
        if ($q->num_rows() > 0) {
            return $q->result();
        }
        return array();

    }
    function new_customer_inquiry_insert($cust_id,$inquiry_num,$property_buy_sale)
    {

    if($this->session->userdata('logged_in_super_user')){
            $sessionData = $this->session->userdata('logged_in_super_user');
            $created_id = $sessionData['id'];
    }
    if($this->session->userdata('logged_in_agent')){
            $sessionData = $this->session->userdata('logged_in_agent');
            $created_id = $sessionData['id'];
    }

    if($this->session->userdata('logged_in_employee')){
            $sessionData = $this->session->userdata('logged_in_employee');
            $id = $sessionData['id'];
            $created_id = $sessionData['id'];
    }else{
            $id="";
    }
     $today_date = date('Y-m-d H:i:s');
        $new_user_insert_data = array(
            'property_id' => "0",
            'property_ref_no' => "",
            'aquired' => $property_buy_sale,
            'customer_id' => $cust_id,
            'agent_id' => "",
            'employee_id' => "",
            'incquiry_ref_no' => $inquiry_num,
            'short_decs' => "fhsdfghfggsdfhgshdf",
            'appoint_start_date' =>"", //date("Y-m-d H:i:s", strtotime($this->input->post('start_date'))),
            'appoint_end_date' =>"",//date("Y-m-d H:i:s", strtotime($this->input->post('end_date'))),
            'ended_date' => "",//date("Y-m-d H:i:s", strtotime($this->input->post('end_date'))),
            'created_date' => $today_date,
            'updated_date' => $today_date,
            'created_by' => $created_id,
            
        );
        $insert = $this->db->insert('inquiry', $new_user_insert_data);
        return $insert;
   }

   function insert_inquiry($post,$property_id,$inquiry_num,$property_buy_sale,$property_detail) {
        //$section_prefix = "agent_";
      // echo'<pre>';print_r($_POST);exit;$user['tindt'] = date("m-d-Y", strtotime($post['tin_date']));
        $cust_id = $this->session->userdata('customer_property_id');
        
        if($this->session->userdata('logged_in_super_user')){
            $sessionData = $this->session->userdata('logged_in_super_user');
            $created_id = $sessionData['id'];
        }
        if($this->session->userdata('logged_in_agent')){
            $sessionData = $this->session->userdata('logged_in_agent');
            $created_id = $sessionData['id'];
        }

        if($this->session->userdata('logged_in_employee')){
            $sessionData = $this->session->userdata('logged_in_employee');
            $id = $sessionData['id'];
            $created_id = $sessionData['id'];
        }else{
            $id="";
        }
        $today_date = date('Y-m-d H:i:s');
        $new_user_insert_data = array(
            'property_id' => $property_id,
            'property_ref_no' => $property_detail[0]->reference_no,
            'aquired' => $property_buy_sale,
            'customer_id' => $cust_id,
            'agent_id' => $this->input->post('agent'),
            'employee_id' => $id,
            'incquiry_ref_no' => $inquiry_num,
            'short_decs' => "fhsdfghfggsdfhgshdf",
            'appoint_start_date' => date("Y-m-d H:i:s", strtotime($this->input->post('start_date'))),
            'appoint_end_date' =>date("Y-m-d H:i:s", strtotime($this->input->post('end_date'))),
            'ended_date' => date("Y-m-d H:i:s", strtotime($this->input->post('end_date'))),
            'created_date' => $today_date,
            'updated_date' => $today_date,
            'created_by' => $created_id,
            
        );
        $insert = $this->db->insert('inquiry', $new_user_insert_data);
        $insert = $this->db->insert_id();
        return $insert;
    }

     function deletePropertyExtImgById($propertyImgId)
    {
        $this->db->delete("propety_extra_images",array('id'=>$propertyImgId));
        if ($this->db->affected_rows()) {
            return true;
        }else {
            return false;
        }
    }

    function getPropertyExtImgDetailsById($propertyImgId)
    {
        $this->db->select('*');
        $this->db->from('propety_extra_images');
        $this->db->where('id',$propertyImgId);

        $query = $this->db->get();
        return $query->result();
    }

    function get_sms_email_history()
    {
        $this->db->select('sms_email_history.*,customer.fname,customer.lname,customer.type as customerType');
        $this->db->join('customer','customer.id =sms_email_history.reciever_id');
        $this->db->from('sms_email_history');
        
        $query = $this->db->get();
        return $query->result();
    }

    function getPropertyExtraImages($propertyId)
    {
        $this->db->select('*');
        $this->db->from('propety_extra_images');
        $this->db->where('property_id',$propertyId);

        $query = $this->db->get();
        return $query->result();
    }
    
    function savePropertyExtraImage($propertyId, $file_name) {
        //$section_prefix = "agent_";
        // echo'<pre>';print_r($_POST);exit;$user['tindt'] = date("m-d-Y", strtotime($post['tin_date']));
       $today_date = date('Y-m-d H:i:s');
        $property_images = array(
            'property_id' => $propertyId,
            'image_name' => $file_name,
            'created_date' => $today_date,
            'updated_at' => $today_date,
        );
        $insert = $this->db->insert('propety_extra_images', $property_images);
        return $insert;
    }

    function saveSmsEmailHistory($history_text, $history_subject, $history_type, $history_reciever, $history_reciever_id)
    {   
        $today_date = date('Y-m-d H:i:s');
        $sms_email_data = array(
            'text' => $history_text,
            'subject' => $history_subject,
            'type' => $history_type,
            'reciever' => $history_reciever,
            'reciever_id' => $history_reciever_id,
            'created_date'=>$today_date,
            'updated_date'=>$today_date,
        );
        $success_data = $this->db->insert('sms_email_history', $sms_email_data);
        $success_data = $this->db->insert_id();
        return $success_data;
    }
    
    function saveClientInquiry($customerId, $property_id, $property_ref_no, $inquiry_ref_no, $property_buy_sale) {
        //$section_prefix = "agent_";
// echo'<pre>';print_r($_POST);exit;$user['tindt'] = date("m-d-Y", strtotime($post['tin_date']));
       if($this->session->userdata('logged_in_super_user')){
            $sessionData = $this->session->userdata('logged_in_super_user');
            $created_id = $sessionData['id'];
        }
        if($this->session->userdata('logged_in_agent')){
            $sessionData = $this->session->userdata('logged_in_agent');
            $created_id = $sessionData['id'];
        }

        if($this->session->userdata('logged_in_employee')){
            $sessionData = $this->session->userdata('logged_in_employee');
            $id = $sessionData['id'];
            $created_id = $sessionData['id'];
        }else{
            $id="";
        }
        $today_date = date('Y-m-d H:i:s');
        $new_user_insert_data = array(
            'property_id' => $property_id,
            'property_ref_no' => $property_ref_no,
            'aquired' => $property_buy_sale,
            'customer_id' => $customerId,
            'agent_id' => "",
            'employee_id' => $id,
            'incquiry_ref_no' => $inquiry_ref_no,
            'short_decs' => "fhsdfghfggsdfhgshdf",
            'appoint_start_date' =>"", //date("Y-m-d H:i:s", strtotime($this->input->post('start_date'))),
            'appoint_end_date' =>"",//date("Y-m-d H:i:s", strtotime($this->input->post('end_date'))),
            'ended_date' => date("Y-m-d H:i:s", strtotime($this->input->post('end_date'))),
            'created_date' => $today_date,
            'updated_date' => $today_date,
            'created_by' => $created_id,
            'status'=>'2',
            
        );
        $insert = $this->db->insert('inquiry', $new_user_insert_data);
        $insert = $this->db->insert_id();
        return $insert;
    }

    function saveClientInquiry_history($post, $inquiry_id) {
       
        $today_date = date('Y-m-d H:i:s');
        $new_user_insert_data = array(
            'inquiry_id' => $inquiry_id,
            'city_area' => $post['city_area_id'],
            'bathroom' => $post['bathroom_no'],
            'badroom' => $post['bedroom_no'],
            'reference_no' => $post['reference_number'],
            'property_status' => $post['property_status'],
            'property_type' => $post['property_category_id'],
            'minprice' => $post['min'],
            'maxprice' =>$post['max'], 
            'created_date' => $today_date,
            'updated_date' => $today_date,
            
        );
        $insert = $this->db->insert('inquiry_history', $new_user_insert_data);
        return $insert;
    }
    function getInquiryDetailById($inquiryId)
    {
        $this->db->select('*');
        $this->db->from('inquiry');
        $this->db->where('id',$inquiryId);

        $query = $this->db->get();
        return $query->result();
    }
   function get_agent_email($aget_id) {
    $q = $this->db->select('*')
                ->from('user')
                ->where('id',$aget_id)
                ->get();
        if ($q->num_rows() > 0) {
            return $q->result();
        }
        return array();
   }
   function insert_inquiry_action($inquiry_action)
   {
    foreach ($inquiry_action as $z=>$val)
     {
                 $today_date = date('Y-m-d H:i:s');
                $new_inquiry_update_data = array(
                'status' => $val[1],
                'updated_date' => $today_date,
            
        );
        $update = $this->db->where('id', $val[0])->update('inquiry', $new_inquiry_update_data);
      }
      return $update;
   }
   function check_unic_inquiry_num($num) {
        
        $q = $this->db->select("*")
                ->from('inquiry')
                ->where('incquiry_ref_no',$num)
                ->get();
        if ($q->num_rows() > 0) {
            return $q->result();
        }
        return array();
    }
     function deleteinquiry($id) {
        $this->db->where('id', $id);
        $this->db->delete('inquiry');
    }
    function check_agent_free_selectdate($post) {
       //echo date("Y-m-d H:i:s", strtotime($post['start_date']));exit;
        $startDate = date('Y-m-d H:i:s', strtotime($post['start_date']));
        $endDate = date('Y-m-d H:i:s', strtotime($post['end_date']));
        $q = $this->db->select("*")
                ->from('inquiry')
                ->where('agent_id',trim($post['id']))
                ->where("(appoint_start_date BETWEEN '$startDate' and '$endDate') OR (appoint_end_date BETWEEN '$startDate' and '$endDate')" )
                // ->or_where('appoint_end_date BETWEEN "'. date('Y-m-d H:i:s', strtotime($post['start_date'])). '" and "'. date('Y-m-d H:i:s', strtotime($post['end_date'])).'"')

                 /*->where('appoint_start_date <=',date("Y-m-d H:i:s", strtotime($post['start_date'])))
                 ->where('appoint_end_date >=',date("Y-m-d H:i:s", strtotime($post['start_date'])))
                 
                 ->or_where('appoint_end_date <=',date("Y-m-d H:i:s", strtotime($post['end_date'])))
                 ->where('appoint_end_date <=',date("Y-m-d H:i:s", strtotime($post['end_date'])))*/

                ->get();
        if ($q->num_rows() > 0) {
            return $q->result();
        }
        return array();
    }
    function check_customer_exist($post)
    {
        $q = $this->db->select("*")
                ->from('customer')
                ->where('email',$post['email_mobile'])
                ->or_where('mobile_no',$post['email_mobile'])
                ->get();
        if ($q->num_rows() > 0) {
            return $q->result();
        }
        return array();
    } 
    function get_property_detail($id) {
        $q = $this->db->select("*")
                ->from('property')
                ->where('id',$id)
                ->get();
        if ($q->num_rows() > 0) {
            return $q->result();
        }
        return array();
    }

   function get_exist_customer_Id($id) {
        $q = $this->db->select("*")
                ->from('customer')
                ->where('email',$id)
                ->or_where('mobile_no',$id)
                ->get();
        if ($q->num_rows() > 0) {
            return $q->result();
        }
        return array();
    }
     function get_genral_facility() {

        $this->db->select('*');
        $this->db->from('facilities')->order_by('title', 'ASC');
        $this->db->where('category_id','1');
        $query = $this->db->get();
        $data = $query->result();
          
          //$all_genral_facility[0] = "Select City";
        for ($i = 0; $i < count($data); $i++) {
            $all_genral_facility[$data[$i]->id] = $data[$i]->title;
        }
        return $all_genral_facility;
    }
    function get_instrumental_facility() {

        $this->db->select('*');
        $this->db->from('facilities')->order_by('title', 'ASC');
        $this->db->where('category_id','2');
        $query = $this->db->get();
        $data = $query->result();
          
          //$all_genral_facility[0] = "Select City";
        for ($i = 0; $i < count($data); $i++) {
            $all_instrumental_facility[$data[$i]->id] = $data[$i]->title;
        }
        return $all_instrumental_facility;
    }
    function get_inquiry_recored($inquiryid) {

       $q = $this->db->select("inquiry.*,inquiry_history.*,city_area.title")
                ->from('inquiry')
                ->join('inquiry_history', 'inquiry_history.inquiry_id = inquiry.id','left')
                ->join('city_area', 'city_area.id = inquiry_history.city_area','left')
                ->where('inquiry.id',$inquiryid)
                ->get();
        if ($q->num_rows() > 0) {
            return $q->result();
        }
        return array();
    }
    function get_agent_name_inq($agentid) {

       $q = $this->db->select("fname,lname")
                ->from('user')
                ->where('id',$agentid)
                ->get();
        if ($q->num_rows() > 0) {
            return $q->result();
        }
        return array();
    }
    function check_agent_appointment($id,$inc_id)
    {
         $q = $this->db->select("*")
                ->from('inquiry')
                ->where('agent_id',$id)
                ->where('id',$inc_id)
                ->get();
        if ($q->num_rows() > 0) {
            return $q->result();
        }
        return array();
    }
    function update_agent_appointment($agent_id,$inquiry_id)
    {
                $today_date = date('Y-m-d H:i:s');
                $new_inquiry_update_data = array(
                'status' => '4',
                'updated_date' => $today_date,
            
        );
        $update = $this->db->where('id', $inquiry_id)->update('inquiry', $new_inquiry_update_data);
        return $update;
   }

   function get_inquiry_data($id)
    {
         $q = $this->db->select("inquiry.property_ref_no,inquiry.appoint_start_date,inquiry.appoint_end_date,customer.*")
                ->from('inquiry')
                ->join('customer','customer.id =inquiry.customer_id') 
                ->where('inquiry.id',$id)
                ->get();
        if ($q->num_rows() > 0) {
            return $q->result();
        }
        return array();
    }
    function get_aget_record($id)
    {
        $q = $this->db->select("*")
                ->from('user')
                ->where('id',$id)
                ->get();
        if ($q->num_rows() > 0) {
            return $q->result();
        }
        return array();
    }
    function get_sms_email_text($id)
    {
        $q = $this->db->select("text,type")
                ->from('sms_email_history')
                ->where('id',$id)
                ->get();
        if ($q->num_rows() > 0) {
            return $q->result();
        }
        return array();
    }
}

?>