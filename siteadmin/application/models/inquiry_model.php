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

    function getAllinquiry($inc_view, $client) {
        if ($this->session->userdata('logged_in_agent')) {
            $sessionData = $this->session->userdata('logged_in_agent');
            $created_id = $sessionData['id'];

            if ($inc_view != "") {
                if ($client == '1') {
                    $this->db->select('inquiry.*,user.fname,user.lname');
                    $this->db->from('inquiry');
                    $this->db->join('user', 'user.id =inquiry.created_by');
                    $this->db->where('inquiry.customer_id', $inc_view);
                    $this->db->where('inquiry.status !=',1);
                    //$this->db->where('inquiry.created_by',$created_id);
                    $this->db->where("(inquiry.created_by = '" . $created_id . "' OR inquiry.agent_id = '" . $created_id . "')");
                    $this->db->order_by('inquiry.created_date', 'DESC');
                    $query = $this->db->get();
                    return $query->result();
                } else {
                    $this->db->select('inquiry.*,user.fname,user.lname');
                    $this->db->from('inquiry');
                    if ($inc_view != "latest") {
                        $this->db->where("(inquiry.aquired = '" . $inc_view . "' OR inquiry.aquired = 'both')");
                        // $this->db->where('inquiry.aquired',$inc_view);
                        // $this->db->or_where('inquiry.aquired','both');
                        //$this->db->order_by('inquiry.created_date','DESC');
                        //$this->db->where('inquiry.created_by',$created_id);
                        //$this->db->where("(inquiry.created_by = '".$created_id."' OR inquiry.agent_id = '".$created_id."')");
                    }
                    $this->db->where("(inquiry.created_by = '" . $created_id . "' OR inquiry.agent_id = '" . $created_id . "')");
                    $this->db->where('inquiry.status !=',1);
                    $this->db->join('user', 'user.id =inquiry.created_by');
                    $this->db->order_by('inquiry.created_date', 'DESC');
                    $query = $this->db->get();
                    return $query->result();
                }
            } else {
                $q = $this->db->select('inquiry.*,user.fname,user.lname')
                        ->from('inquiry')
                        ->join('user', 'user.id =inquiry.created_by')
                        ->where("(inquiry.created_by = '" . $created_id . "' OR inquiry.agent_id = '" . $created_id . "')")
                        ->where('inquiry.status !=',1)
                        ->order_by('inquiry.created_date', 'DESC')
                        ->get();
                if ($q->num_rows() > 0) {
                    return $q->result();
                }
                return array();
            }
        } else {
            if ($inc_view != "") {
                if ($client == '1') {
                    $this->db->select('inquiry.*,user.fname,user.lname');
                    $this->db->from('inquiry');
                    $this->db->join('user', 'user.id =inquiry.created_by');
                    $this->db->where('inquiry.customer_id', $inc_view);
                    $this->db->where('inquiry.status !=',1);
                    $this->db->order_by('inquiry.created_date', 'DESC');
                    $query = $this->db->get();
                    return $query->result();
                } else {
                    $this->db->select('inquiry.*,user.fname,user.lname');
                    $this->db->from('inquiry');
                    if ($inc_view != "latest") {
                        $this->db->where('inquiry.aquired', $inc_view);
                        $this->db->or_where('inquiry.aquired', 'both');
                        $this->db->order_by('inquiry.created_date', 'DESC');
                    } else {
                        $this->db->order_by('inquiry.created_date', 'DESC');
                    }
                    $this->db->where('inquiry.status !=',1);
                    $this->db->join('user', 'user.id =inquiry.created_by');
                    $query = $this->db->get();
                    return $query->result();
                }
            } else {
                $q = $this->db->select('inquiry.*,user.fname,user.lname')
                        ->from('inquiry')
                        ->join('user', 'user.id =inquiry.created_by')
                        ->where('inquiry.status !=',1)
                        ->order_by('inquiry.created_date', 'DESC')
                        ->get();
                if ($q->num_rows() > 0) {
                    return $q->result();
                }
                return array();
            }
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

    function getrelated_property($post,$agent_properties=FALSE) {

        $this->db->select('property.*,user.fname, user.lname, city_area.title,city.id as city_id,(select images.image from images where images.prop_id=property.id order by images.order asc limit 0,1) as extra_image', false);
        $this->db->join('user', 'user.id =property.agent_id', 'left');
        $this->db->join('city_area', 'city_area.id =property.city_area');
        $this->db->join('city', 'city.id =property.city_id');
        $this->db->from('property');
        
        if (isset($post['property_type']) && !empty($post['property_type'])) {
            $this->db->where("(property.type = '". $post['property_type']."' OR property.type = '3')");
        }
        
        // if(!empty($post['property_type'])){
        //     if($post['property_type'] !='3'){
        //         $this->db->where('property.type', $post['property_type']);
        //         $this->db->or_where('property.type','3');
        //     }
        // }
        // if(!empty($post['location']))
        //     $this->db->like('property.address', $post['location']);
        if (!empty($post['country_id']) && $post['country_id'] != '0')
            $this->db->where('property.country_id', $post['country_id']);

        if (!empty($post['city']) && $post['city'] != '0')
            $this->db->where('property.city_id', $post['city']);
        if (!empty($post['furnished_type'])) {
            $this->db->where_in('property.furnished_type', $post['furnished_type']);
        }
        if (!empty($post['selectItemcity_area'])) {
            $this->db->where_in('property.city_area', $post['selectItemcity_area']);
        }
        if (!empty($post['property_category']))
            $this->db->where_in('property.property_type', $post['property_category']);

        if (!empty($post['bedroom']))
            $this->db->where('property.bedroom', $post['bedroom']);

        if (!empty($post['bathroom']))
            $this->db->where('property.bathroom', $post['bathroom']);

        if (!empty($post['reference_no']))
            $this->db->where('property.reference_no', $post['reference_no']);

        if (!empty($post['property_type']) && $post['property_type'] == "1") {
            if (!empty($post['min_price']))
                $this->db->where('property.sale_price >=', $post['min_price']);
            if (!empty($post['max_price']))
                $this->db->where('property.sale_price <=', $post['max_price']);
        }elseif (!empty($post['property_type']) && $post['property_type'] == "2") {
            if (!empty($post['min_price']))
                $this->db->where('property.rent_price >=', $post['min_price']);
            if (!empty($post['max_price']))
                $this->db->where('property.rent_price <=', $post['max_price']);
        }elseif (!empty($post['property_type']) && $post['property_type'] == "3") {
            if (!empty($post['min_price'])) {
                //$this->db->where('( property.sale_price >= '.$post['min_price'].' OR property.rent_price >= '.$post['min_price'].' )');
                $this->db->where('property.sale_price >=', $post['min_price']);
                $this->db->or_where('property.rent_price >=', $post['min_price']);
            }
            if (!empty($post['max_price'])) {
                //$this->db->where('( property.sale_price >= '.$post['max_price'].' OR property.rent_price >= '.$post['max_price'].' )');
                $this->db->where('property.sale_price <=', $post['max_price']);
                $this->db->or_where('property.rent_price <=', $post['max_price']);
            }
        }
                
        if(!empty($agent_properties)){
            $this->db->where('agent_id', $post['user_id']);
        }
        
        $this->db->where('property.status', 'Active');
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
                ->where('reference_no', $num)
                ->get();
        if ($q->num_rows() > 0) {
            return $q->result();
        }
        return array();
    }

    function get_inc_agent($agent_id) {
        $q = $this->db->select("fname,lname")
                ->from('user')
                ->where('id', $agent_id)
                ->get();
        if ($q->num_rows() > 0) {
            return $q->result();
        }
        return array();
    }

    function agent_schedule() {

        //$TotalDays = date("t", mktime(0,0,0,,1,2015));
//echo $TotalDays;exit;
        $this->db->select('inquiry.*,user.fname,user.lname,user.email');
        $this->db->from('inquiry');
        if ($this->session->userdata('logged_in_super_user')) {
            $this->db->join('user', 'user.id =inquiry.agent_id', 'left');
        } elseif ($this->session->userdata('logged_in_agent')) {
            $sessionData = $this->session->userdata('logged_in_agent');
            $id = $sessionData['id'];
            $this->db->join('user', 'user.id = inquiry.agent_id');
            $this->db->where('inquiry.agent_id', $id);
        }
        $this->db->where('inquiry.agent_id !=', '0');
        $this->db->where('inquiry.status', '4');
        $this->db->where("( inquiry.agent_status = '0' OR inquiry.agent_status = '1' OR inquiry.agent_status = '2' )");
        //$this->db->where('inquiry.appoint_start_date !=','');
        //$this->db->where('inquiry.appoint_end_date !=','');
        $this->db->order_by('inquiry.appoint_start_date', 'ASC');

        $query = $this->db->get();
        return $query->result();
    }

    function agent_schedule_month_vice($post) {

        $TotalDays = date("t", mktime(0, 0, 0, $post['month'], 1, $post['year']));
        $start_date = $post['year'] . '-' . $post['month'] . '-01';
        $appointment_start_date = date("Y-m-d H:i:s", strtotime($start_date));
        $end_date = $post['year'] . '-' . $post['month'] . '-' . $TotalDays;
        $appointment_end_date = date("Y-m-d H:i:s", strtotime($end_date));

        $this->db->select('inquiry.*,user.fname,user.lname,user.email,user.mobile_no,user.coutry_code,user.type');
        $this->db->from('inquiry');
        if ($this->session->userdata('logged_in_super_user')) {
            $this->db->join('user', 'user.id =inquiry.agent_id', 'left');
        } elseif ($this->session->userdata('logged_in_agent')) {
            $sessionData = $this->session->userdata('logged_in_agent');
            $id = $sessionData['id'];
            $this->db->join('user', 'user.id = inquiry.agent_id');
            $this->db->where('inquiry.agent_id', $id);
        }
        $this->db->where('inquiry.agent_id !=', '0');
        $this->db->where('inquiry.appoint_start_date >=', $appointment_start_date);
        $this->db->where('inquiry.appoint_start_date <=', $appointment_end_date);
        //$this->db->group_by('MONTH(inquiry.appoint_start_date)');
        $this->db->order_by('inquiry.appoint_start_date', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }

    function getAll_appointmentAgent() {
        $this->db->select('*');
        $this->db->from('user')->order_by('fname', 'ASC');
        $this->db->where('type', 2);
        $this->db->where('deleted', 0);
        $this->db->where('status', 'Active');

        if ($this->session->userdata('logged_in_agent')) {
            $sessionData = $this->session->userdata('logged_in_agent');
            $id = $sessionData['id'];
            $this->db->where('user.id', $id);
        }
        $query = $this->db->get();
        $data = $query->result();

        $agentData = array();
        for ($i = 0; $i < count($data); $i++) {
            $agentData[$data[$i]->id] = $data[$i]->fname . " " . $data[$i]->lname;
        }
        return $agentData;
    }

    function getAllAgent() {
        $this->db->select('*');
        $this->db->from('user');

        if ($this->session->userdata('logged_in_agent')) {
            $sessionData = $this->session->userdata('logged_in_agent');
            $id = $sessionData['id'];
            $this->db->where('user.id', $id);
        }
        $this->db->where('user.type IN (1,2)');
        $this->db->where('user.deleted', 0);
        $this->db->where('user.status', 'Active');
        $this->db->order_by('fname', 'ASC');

        $query = $this->db->get();
        $data = $query->result();


        for ($i = 0; $i < count($data); $i++) {
            $agentData[$data[$i]->id] = $data[$i]->fname . " " . $data[$i]->lname;
        }

        return $agentData;
    }

    function getAllpropertyAgent() {

        $q = $this->db->select("*")
                ->from('user')
                ->where('type', '2')
                ->where('deleted !=', '1')
                ->get();
        if ($q->num_rows() > 0) {
            return $q->result();
        }
        return array();
    }

    function agent_detail_byid($id) {

        $q = $this->db->select('*')
                ->from('inquiry')
                ->where('agent_id', $id)
                ->where('agent_id !=', '0')
                ->where('appoint_start_date !=', '')
                ->where('appoint_end_date !=', '')
                ->get();
        if ($q->num_rows() > 0) {
            return $q->result();
        }
        return array();
    }

    function get_customer_detail($cust_id) {

        $q = $this->db->select('*')
                ->from('customer')
                ->where('id', $cust_id)
                ->get();
        if ($q->num_rows() > 0) {
            return $q->result();
        }
        return array();
    }

    function new_customer_inquiry_insert($cust_id, $inquiry_num, $property_buy_sale) {

        if ($this->session->userdata('logged_in_super_user')) {
            $sessionData = $this->session->userdata('logged_in_super_user');
            $created_id = $sessionData['id'];
        }
        if ($this->session->userdata('logged_in_agent')) {
            $sessionData = $this->session->userdata('logged_in_agent');
            $created_id = $sessionData['id'];
        }

        if ($this->session->userdata('logged_in_employee')) {
            $sessionData = $this->session->userdata('logged_in_employee');
            $id = $sessionData['id'];
            $created_id = $sessionData['id'];
        } else {
            $id = "";
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
            'appoint_start_date' => "", //date("Y-m-d H:i:s", strtotime($this->input->post('start_date'))),
            'appoint_end_date' => "", //date("Y-m-d H:i:s", strtotime($this->input->post('end_date'))),
            'ended_date' => "", //date("Y-m-d H:i:s", strtotime($this->input->post('end_date'))),
            'created_date' => $today_date,
            'updated_date' => $today_date,
            'created_by' => $created_id,
            'status' => "1"
        );
        $insert = $this->db->insert('inquiry', $new_user_insert_data);
        $insert = $this->db->insert_id();
        if ($insert) {
            $inquiry_status = array(
                'inquiry_id' => $this->db->insert_id(),
                'agent_id' => 0,
                'inquiry_status' => 1,
                'inquiry_agent_status' => 0,
                'comments' => '',
            );
            $this->db->insert('inquiry_status_history', $inquiry_status);
        }

        return $insert;
    }

    function insert_inquiry($post, $property_id, $inquiry_num, $property_buy_sale, $property_detail) {
        //$section_prefix = "agent_";
        // echo'<pre>';print_r($_POST);exit;$user['tindt'] = date("m-d-Y", strtotime($post['tin_date']));
        $cust_id = $this->session->userdata('customer_property_id');

        $this->db->select('*');
        $this->db->from('inquiry');
        $this->db->where('property_id', $property_id);
        $this->db->where('customer_id', $cust_id);
        $this->db->where('status !=', "4");
        $this->db->where('status !=', "5");
        $query = $this->db->get();
        $recorde = $query->result();

        if (empty($recorde)) {
            if ($this->session->userdata('logged_in_super_user')) {
                $sessionData = $this->session->userdata('logged_in_super_user');
                $created_id = $sessionData['id'];
            }
            if ($this->session->userdata('logged_in_agent')) {
                $sessionData = $this->session->userdata('logged_in_agent');
                $created_id = $sessionData['id'];
            }

            if ($this->session->userdata('logged_in_employee')) {
                $sessionData = $this->session->userdata('logged_in_employee');
                $id = $sessionData['id'];
                $created_id = $sessionData['id'];
            } else {
                $id = "";
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
                'appoint_end_date' => date("Y-m-d H:i:s", strtotime($this->input->post('end_date'))),
                'ended_date' => date("Y-m-d H:i:s", strtotime($this->input->post('end_date'))),
                'created_date' => $today_date,
                'updated_date' => $today_date,
                'created_by' => $created_id,
                'status' => "4",
            );
            $insert = $this->db->insert('inquiry', $new_user_insert_data);
            $insert = $this->db->insert_id();
            if ($insert) {
                $inquiry = $this->db->select('*')->from('inquiry')->where('id', $insert)->get()->result();
                $inquiry_status = array(
                    'inquiry_id' => $inquiry[0]->id,
                    'agent_id' => $inquiry[0]->agent_id,
                    'inquiry_status' => $inquiry[0]->status,
                    'inquiry_agent_status' => $inquiry[0]->agent_status,
                    'comments' => (isset($_POST['comments'])) ? $_POST['comments'] : '',
                );
                $this->db->insert('inquiry_status_history', $inquiry_status);
            }
            return $insert;
        } else {
            //echo'<pre>';print_r($recorde);exit;
            $today_date = date('Y-m-d H:i:s');
            $new_user_insert_data = array(
                'agent_id' => $this->input->post('agent'),
                'appoint_start_date' => date("Y-m-d H:i:s", strtotime($this->input->post('start_date'))),
                'appoint_end_date' => date("Y-m-d H:i:s", strtotime($this->input->post('end_date'))),
                'ended_date' => date("Y-m-d H:i:s", strtotime($this->input->post('end_date'))),
                'updated_date' => $today_date,
                'status' => "4",
            );
            $insert = $this->db->where('id', $recorde[0]->id)->update('inquiry', $new_user_insert_data);
            if ($insert) {
                $inquiry = $this->db->select('*')->from('inquiry')->where('id', $recorde[0]->id)->get()->result();
                $inquiry_status = array(
                    'inquiry_id' => $inquiry[0]->id,
                    'agent_id' => $inquiry[0]->agent_id,
                    'inquiry_status' => $inquiry[0]->status,
                    'inquiry_agent_status' => $inquiry[0]->agent_status,
                    'comments' => (isset($_POST['comments'])) ? $_POST['comments'] : '',
                );
                $this->db->insert('inquiry_status_history', $inquiry_status);
            }

            return $recorde[0]->id;
        }
    }

    function deletePropertyExtImgById($propertyImgId) {
        $this->db->delete("propety_extra_images", array('id' => $propertyImgId));
        if ($this->db->affected_rows()) {
            return true;
        } else {
            return false;
        }
    }

    function getPropertyExtImgDetailsById($propertyImgId) {
        $this->db->select('*');
        $this->db->from('propety_extra_images');
        $this->db->where('id', $propertyImgId);

        $query = $this->db->get();
        return $query->result();
    }

    function get_sms_email_history() {
        $this->db->select('*');
        $this->db->from('sms_email_history');
        $query = $this->db->get();
        return $query->result();
    }

    function get_sms_email_history_recievername($user_type, $reciever_id) {
        if ($user_type == "1") {
            $this->db->select('*');
            //$this->db->join('customer','customer.id =sms_email_history.reciever_id');
            $this->db->from('customer');
            $this->db->where('id', $reciever_id);
            $query = $this->db->get();
            return $query->result();
        }
        if ($user_type == "2") {
            $this->db->select('*');
            //$this->db->join('user','user.id =sms_email_history.reciever_id');
            $this->db->from('user');
            $this->db->where('id', $reciever_id);
            $query = $this->db->get();
            return $query->result();
        }
        //$this->db->where("sms_email_history.reciever_id",$reciever_id);
    }

    function getPropertyExtraImages($propertyId) {
        $this->db->select('*');
        $this->db->from('propety_extra_images');
        $this->db->where('property_id', $propertyId);

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

    function saveSmsEmailHistory($history_text, $history_subject, $history_type, $history_reciever, $history_reciever_id, $history_reciever_usertype, $inquiryId) {
        $today_date = date('Y-m-d H:i:s');
        $sms_email_data = array(
            'inquiry_id' => $inquiryId,
            'text' => $history_text,
            'subject' => $history_subject,
            'type' => $history_type,
            'reciever' => $history_reciever,
            'reciever_id' => $history_reciever_id,
            'user_type' => $history_reciever_usertype,
            'created_date' => $today_date,
            'updated_date' => $today_date,
        );
        $success_data = $this->db->insert('sms_email_history', $sms_email_data);
        $success_data = $this->db->insert_id();
        return $success_data;
    }

    function saveClientInquiry($customerId, $property_id, $property_ref_no, $inquiry_ref_no, $property_buy_sale) {
        
        

        $this->db->select('*');
        $this->db->from('inquiry');
        $this->db->where('property_id', $property_id);
        $this->db->where('customer_id', $customerId);
        $this->db->where('status !=', "4");
        $this->db->where('status !=', "5");
        $query = $this->db->get();
        $recorde = $query->result();

        if (empty($recorde)) {

            if ($this->session->userdata('logged_in_super_user')) {
                $sessionData = $this->session->userdata('logged_in_super_user');
                $created_id = $sessionData['id'];
            }
            if ($this->session->userdata('logged_in_agent')) {
                $sessionData = $this->session->userdata('logged_in_agent');
                $created_id = $sessionData['id'];
            }

            if ($this->session->userdata('logged_in_employee')) {
                $sessionData = $this->session->userdata('logged_in_employee');
                $id = $sessionData['id'];
                $created_id = $sessionData['id'];
            } else {
                $id = "";
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
                'appoint_start_date' => "", //date("Y-m-d H:i:s", strtotime($this->input->post('start_date'))),
                'appoint_end_date' => "", //date("Y-m-d H:i:s", strtotime($this->input->post('end_date'))),
                'ended_date' => date("Y-m-d H:i:s", strtotime($this->input->post('end_date'))),
                'created_date' => $today_date,
                'updated_date' => $today_date,
                'created_by' => $created_id,
                'status' => '2',
            );
            $insert = $this->db->insert('inquiry', $new_user_insert_data);
            $insert = $this->db->insert_id();
            if ($insert) {
                $inquiry = $this->db->select('*')->from('inquiry')->where('id', $insert)->get()->result();
                $inquiry_status = array(
                    'inquiry_id' => $inquiry[0]->id,
                    'agent_id' => $inquiry[0]->agent_id,
                    'inquiry_status' => $inquiry[0]->status,
                    'inquiry_agent_status' => $inquiry[0]->agent_status,
                    'comments' => (isset($_POST['comments'])) ? $_POST['comments'] : '',
                );
                $this->db->insert('inquiry_status_history', $inquiry_status);
            }

            return $insert;
        } else {

            $today_date = date('Y-m-d H:i:s');
            $new_user_insert_data = array(
                'updated_date' => $today_date,
            );
            $insert = $this->db->where('id', $recorde[0]->id)->update('inquiry', $new_user_insert_data);
            if ($insert) {
                $inquiry = $this->db->select('*')->from('inquiry')->where('id', $recorde[0]->id)->get()->result();
                $inquiry_status = array(
                    'inquiry_id' => $inquiry[0]->id,
                    'agent_id' => $inquiry[0]->agent_id,
                    'inquiry_status' => $inquiry[0]->status,
                    'inquiry_agent_status' => $inquiry[0]->agent_status,
                    'comments' => (isset($_POST['comments'])) ? $_POST['comments'] : '',
                );
            }

            return $recorde[0]->id;
            //$insert = $this->db->insert('inquiry', $new_user_insert_data);
            //$insert = $this->db->insert_id();
            //return $insert;
        }
    }

    function add_appointment_note($post) {

        $this->db->select('*');
        $this->db->from('appointment_note');
        $this->db->where('inquiry_id', $post['id']);
        $query = $this->db->get();
        $recorde = $query->result();
        if ($this->session->userdata('logged_in_super_user')) {
            $sessionData = $this->session->userdata('logged_in_super_user');
            $added_id = $sessionData['id'];
        } elseif ($this->session->userdata('logged_in_agent')) {
            $sessionData = $this->session->userdata('logged_in_agent');
            $added_id = $sessionData['id'];
        } elseif ($this->session->userdata('logged_in_employee')) {
            $sessionData = $this->session->userdata('logged_in_employee');
            $added_id = $sessionData['id'];
        }

        if (empty($recorde)) {
            if ($post['is_repetive'] == "1") {
                $today_date = date('Y-m-d H:i:s');
                $new_user_insert_data = array(
                    'note' => $post['note'],
                    'user_id' => $added_id,
                    'inquiry_id' => $post['id'],
                    'start_date' => date("Y-m-d H:i:s", strtotime($post['start_date'])),
                    'end_date' => date("Y-m-d H:i:s", strtotime($post['end_date'])),
                    'is_repetitive' => $post['is_repetive'],
                    'repetitive_type' => $post['frequency'],
                    'created_date' => $today_date,
                    'update_date' => $today_date,
                );
                $insert = $this->db->insert('appointment_note', $new_user_insert_data);
                return $insert;
            } else {
                $today_date = date('Y-m-d H:i:s');
                $new_user_insert_data = array(
                    'note' => $post['note'],
                    'user_id' => $added_id,
                    'inquiry_id' => $post['id'],
                    'start_date' => date("Y-m-d", strtotime($post['start_date'])),
                    'end_date' => date("Y-m-d", strtotime($post['start_date'])),
                    'is_repetitive' => $post['is_repetive'],
                    'repetitive_type' => $post['frequency'],
                    'created_date' => $today_date,
                    'update_date' => $today_date,
                );
                $insert = $this->db->insert('appointment_note', $new_user_insert_data);
                return $insert;
            }
        } else {
            if ($post['is_repetive'] == "1") {
                $today_date = date('Y-m-d H:i:s');
                $new_user_insert_data = array(
                    'note' => $post['note'],
                    'user_id' => $added_id,
                    'inquiry_id' => $post['id'],
                    'start_date' => date("Y-m-d H:i:s", strtotime($post['start_date'])),
                    'end_date' => date("Y-m-d H:i:s", strtotime($post['end_date'])),
                    'is_repetitive' => $post['is_repetive'],
                    'repetitive_type' => $post['frequency'],
                    'created_date' => $today_date,
                    'update_date' => $today_date,
                );
                $insert = $this->db->where('id', $recorde[0]->id)->update('appointment_note', $new_user_insert_data);
                return $insert;
                //$insert = $this->db->insert('appointment_note', $new_user_insert_data);
                //return $insert;
            } else {
                $today_date = date('Y-m-d H:i:s');
                $new_user_insert_data = array(
                    'note' => $post['note'],
                    'user_id' => $added_id,
                    'inquiry_id' => $post['id'],
                    'start_date' => date("Y-m-d", strtotime($post['start_date'])),
                    'end_date' => date("Y-m-d", strtotime($post['start_date'])),
                    'is_repetitive' => $post['is_repetive'],
                    'repetitive_type' => $post['frequency'],
                    'created_date' => $today_date,
                    'update_date' => $today_date,
                );
                $insert = $this->db->where('id', $recorde[0]->id)->update('appointment_note', $new_user_insert_data);
                return $insert;
            }
        }
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
            'maxprice' => $post['max'],
            'created_date' => $today_date,
            'updated_date' => $today_date,
        );
        $insert = $this->db->insert('inquiry_history', $new_user_insert_data);
        return $insert;
    }

    function getInquiryDetailById($inquiryId) {
        $this->db->select('*');
        $this->db->from('inquiry');
        $this->db->where('id', $inquiryId);

        $query = $this->db->get();
        return $query->result();
    }

    function get_agent_email($aget_id) {
        $q = $this->db->select('*')
                ->from('user')
                ->where('id', $aget_id)
                ->get();
        if ($q->num_rows() > 0) {
            return $q->result();
        }
        return array();
    }

    function insert_inquiry_action($inquiry_action) {
        foreach ($inquiry_action as $z => $val) {
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
                ->where('incquiry_ref_no', $num)
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
                ->where('agent_id', trim($post['id']))
                ->where("(appoint_start_date BETWEEN '$startDate' and '$endDate') OR (appoint_end_date BETWEEN '$startDate' and '$endDate')")
                ->where('status', 4)
                ->where("(agent_status = '1' OR agent_status = '0')")
                // ->or_where("appoint_end_date BETWEEN "'. date('Y-m-d H:i:s', strtotime($post['start_date'])). '" and "'. date('Y-m-d H:i:s', strtotime($post['end_date'])).'"')

                /* ->where('appoint_start_date <=',date("Y-m-d H:i:s", strtotime($post['start_date'])))
                  ->where('appoint_end_date >=',date("Y-m-d H:i:s", strtotime($post['start_date'])))

                  ->or_where('appoint_end_date <=',date("Y-m-d H:i:s", strtotime($post['end_date'])))
                  ->where('appoint_end_date <=',date("Y-m-d H:i:s", strtotime($post['end_date']))) */
                ->get();
        if ($q->num_rows() > 0) {
            return $q->result();
        }
        return array();
    }

    function check_customer_exist($post) {
        $q = $this->db->select("*")
                ->from('customer')
                ->where("(email = '".$post['email_mobile']."' OR mobile_no = '".$post['email_mobile']."')" )
                ->where('deleted',0)
                ->get();
        if ($q->num_rows() > 0) {
            return $q->result();
        }
        return array();
    }

    function check_new_client_form_emailexit($post) {
        if (!empty($post['email'])) {
            $q = $this->db->select("*")
                    ->from('customer')
                    ->where('email', $post['email'])
                    ->where('status','Active')
                    ->where('deleted',0)
                    ->get();
            if ($q->num_rows() > 0) {
                return $q->result();
            }
            return array();
        }
    }

    function check_new_client_form_mobileexit($post) {
        $q = $this->db->select("*")
                ->from('customer')
                ->where('mobile_no', $post['mobile_no'])
                ->where('coutry_code', $post['county_code'])
                ->where('status','Active')
                ->where('deleted',0)
                ->get();
        if ($q->num_rows() > 0) {
            return $q->result();
        }
        return array();
    }

    function get_property_detail($id) {
        $q = $this->db->select("*")
                ->from('property')
                ->where('id', $id)
                ->get();
        if ($q->num_rows() > 0) {
            return $q->result();
        }
        return array();
    }

    function get_exist_customer_Id($id) {
        $q = $this->db->select("*")
                ->from('customer')
                ->where('email', $id)
                ->or_where('mobile_no', $id)
                ->get();
        if ($q->num_rows() > 0) {
            return $q->result();
        }
        return array();
    }

    function get_genral_facility() {

        $this->db->select('*');
        $this->db->from('facilities')->order_by('title', 'ASC');
        $this->db->where('category_id', '1');
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
        $this->db->where('category_id', '2');
        $query = $this->db->get();
        $data = $query->result();

        //$all_genral_facility[0] = "Select City";
        for ($i = 0; $i < count($data); $i++) {
            $all_instrumental_facility[$data[$i]->id] = $data[$i]->title;
        }
        return $all_instrumental_facility;
    }

    function get_inquiry_recored($inquiryid) {

        $q = $this->db->select("customer.id as cust_id, customer.fname as c_fname,customer.lname as c_lname,customer.email, county_code.prefix_code,customer.mobile_no,inquiry.*,inquiry_history.*,city_area.title")
                ->from('inquiry')
                ->join('inquiry_history', 'inquiry_history.inquiry_id = inquiry.id', 'left')
                ->join('city_area', 'city_area.id = inquiry_history.city_area', 'left')
                ->join('customer', 'customer.id = inquiry.customer_id', 'left')
                ->join('county_code', 'customer.coutry_code  = county_code.id', 'left')
                ->where('inquiry.id', $inquiryid)
                ->get();
        if ($q->num_rows() > 0) {
            return $q->result();
        }
        return array();
    }

    function get_agent_name_inq($agentid) {

        $q = $this->db->select("fname,lname")
                ->from('user')
                ->where('id', $agentid)
                ->get();
        if ($q->num_rows() > 0) {
            return $q->result();
        }
        return array();
    }

    function check_agent_appointment($id, $inc_id) {
        $q = $this->db->select("*")
                ->from('inquiry')
                ->where('agent_id', $id)
                ->where('id', $inc_id)
                ->get();
        if ($q->num_rows() > 0) {
            return $q->result();
        }
        return array();
    }

    function update_agent_appointment($agent_id, $inquiry_id, $post) {
        $update = false;
        if (trim($post['submit']) == "Submit") {
            $today_date = date('Y-m-d H:i:s');
            $new_inquiry_update_data = array(
                'agent_status' => '3',
                'updated_date' => $today_date,
                'comments' => $post['comment']
            );
            $update = $this->db->where('id', $inquiry_id)->update('inquiry', $new_inquiry_update_data);
        } elseif (trim($post['submit']) == "Confirm Appointment") {
            $today_date = date('Y-m-d H:i:s');
            $new_inquiry_update_data = array(
                'agent_status' => '1',
                'updated_date' => $today_date,
            );
            $update = $this->db->where('id', $inquiry_id)->update('inquiry', $new_inquiry_update_data);
        } elseif (trim($post['submit']) == "Reschedule Appointment") {
            $today_date = date('Y-m-d H:i:s');
            $new_inquiry_update_data = array(
                'agent_status' => '2',
                'updated_date' => $today_date,
            );
            $update = $this->db->where('id', $inquiry_id)->update('inquiry', $new_inquiry_update_data);
        }
        if ($update) {
            $inquiry = $this->db->select('*')->from('inquiry')->where('id', $inquiry_id)->get()->result();
            $inquiry_status = array(
                'inquiry_id' => $inquiry[0]->id,
                'agent_id' => $inquiry[0]->agent_id,
                'inquiry_status' => $inquiry[0]->status,
                'inquiry_agent_status' => $inquiry[0]->agent_status,
                'comments' => (isset($_POST['comments'])) ? $_POST['comments'] : '',
            );
            $this->db->insert('inquiry_status_history', $inquiry_status);
        }
        return $update;
    }

    function get_inquiry_data($id) {
        $q = $this->db->select("inquiry.property_ref_no,inquiry.agent_id, inquiry.incquiry_ref_no,inquiry.agent_status,inquiry.appoint_start_date,inquiry.appoint_end_date,customer.*")
                ->from('inquiry')
                ->join('customer', 'customer.id =inquiry.customer_id')
                ->where('inquiry.id', $id)
                ->get();
        if ($q->num_rows() > 0) {
            return $q->result();
        }
        return array();
    }

    function get_aget_record($id) {
        $q = $this->db->select("*")
                ->from('user')
                ->where('id', $id)
                ->get();
        if ($q->num_rows() > 0) {
            return $q->result();
        }
        return array();
    }

    function get_employee_record($id) {
        $q = $this->db->select("inquiry.created_by,user.*")
                ->from('inquiry')
                ->join('user', 'user.id =inquiry.created_by')
                ->where('inquiry.id', $id)
                //->where('user.type', "3")
                ->get();
        if ($q->num_rows() > 0) {
            return $q->result();
        }
        return array();
    }

    function get_sms_email_text($id) {
        $q = $this->db->select("text,type")
                ->from('sms_email_history')
                ->where('id', $id)
                ->get();
        if ($q->num_rows() > 0) {
            return $q->result();
        }
        return array();
    }

    function get_sms_email_text_report($id) {
        $q = $this->db->select("sms_email_history.text,sms_email_history.type")
                ->from('sms_email_history')
                ->join('inquiry_history', 'inquiry_history.id = sms_email_history.inquiry_id', 'left')
                ->where('sms_email_history.inquiry_id', $id)
                ->get();
        if ($q->num_rows() > 0) {
            return $q->result_array();
        }
        return array();
    }

    function updateInquiryStatus($id, $data) {
        $update = $this->db->where('id', $id)->update('inquiry', $data);
        if ($update) {
            $inquiry = $this->db->select('*')->from('inquiry')->where('id', $id)->get()->result();
            $inquiry_status = array(
                'inquiry_id' => $inquiry[0]->id,
                'agent_id' => $inquiry[0]->agent_id,
                'inquiry_status' => $inquiry[0]->status,
                'comments' => $_POST['comments'],
            );
            $this->db->insert('inquiry_status_history', $inquiry_status);
            // echo'<pre>';print_r($data['status']);exit;

            /* property inactive code start */
            if ($data['status'] == '5') {
                $this->db->select('property_id');
                $this->db->from('inquiry');
                $this->db->where('id', $id);
                $query = $this->db->get();
                $recorde = $query->result();

                if (!empty($recorde)) {
                    $property_status = array(
                        'status' => 'Inactive',
                    );
                    $this->db->where('id', $recorde[0]->property_id)->update('property', $property_status);
                }
            }
            /* property inactive code end */
        }
        return $update;
    }

    function getNewInquiries($user) {

        $q = $this->db->select('customer.fname as c_fname,customer.lname as c_lname,customer.email, county_code.prefix_code,customer.mobile_no,inquiry.*,user.fname as u_fname,user.lname as u_lname,user.email as u_email,user.mobile_no as u_mobile_no,user.status as u_status,user.type as u_type,agent.fname as a_fname,agent.lname as a_lname')
                ->from('inquiry')
                ->join('inquiry_history', 'inquiry_history.inquiry_id = inquiry.id', 'left')
                ->join('city_area', 'city_area.id = inquiry_history.city_area', 'left')
                ->join('customer', 'customer.id =inquiry.customer_id', 'left')
                ->join('county_code', 'customer.coutry_code  = county_code.id', 'left')
                ->join('user', 'user.id =inquiry.created_by', 'left')
                ->join('user as agent', 'agent.id =inquiry.agent_id', 'left');

        if (!empty($user)) {
            if ($user['type'] != 1) {
                $q = $q->where('inquiry.agent_id', $user['id']);
            }
        }
        $q = $q->where('inquiry.status', 4)
                ->where('inquiry.agent_status', 0)
                ->get();
        if ($q->num_rows() > 0) {
            return $q->result();
        }
        return array();
    }

    function changeAgentStatus($id, $data) {
        $update = $this->db->where('id', $id)->update('inquiry', $data);
        if ($update) {
            $inquiry = $this->db->select('*')->from('inquiry')->where('id', $id)->get()->result();
            $inquiry_status = array(
                'inquiry_id' => $inquiry[0]->id,
                'agent_id' => $inquiry[0]->agent_id,
                'inquiry_status' => $inquiry[0]->status,
                'inquiry_agent_status' => $inquiry[0]->agent_status,
            );
            if (isset($data['cancel_message']) && !empty($data['cancel_message'])) {
                $inquiry_status['comments'] = $data['cancel_message'];
            }
            $this->db->insert('inquiry_status_history', $inquiry_status);
        }
        return $update;
    }

    function appointmentchangeAgentStatus($id, $data) {
        $update = $this->db->where('id', $id)->update('inquiry', $data);
        if ($update) {
            $inquiry = $this->db->select('*')->from('inquiry')->where('id', $id)->get()->result();
            $inquiry_status = array(
                'inquiry_id' => $inquiry[0]->id,
                'agent_id' => $inquiry[0]->agent_id,
                'inquiry_status' => $inquiry[0]->status,
                'inquiry_agent_status' => $inquiry[0]->agent_status,
            );
            $this->db->insert('inquiry_status_history', $inquiry_status);
        }
        return $update;
    }

    function getRescheduleInquiries($user) {
        $q = $this->db->select('customer.fname as c_fname,customer.lname as c_lname,customer.email, county_code.prefix_code,customer.mobile_no,inquiry.*,user.fname as u_fname,user.lname as u_lname,user.email as u_email,user.mobile_no as u_mobile_no,user.status as u_status,user.type as u_type,agent.fname as a_fname,agent.lname as a_lname')
                ->from('inquiry')
                ->join('inquiry_history', 'inquiry_history.inquiry_id = inquiry.id', 'left')
                ->join('city_area', 'city_area.id = inquiry_history.city_area', 'left')
                ->join('customer', 'customer.id =inquiry.customer_id', 'left')
                ->join('county_code', 'customer.coutry_code  = county_code.id', 'left')
                ->join('user', 'user.id =inquiry.created_by', 'left')
                ->join('user as agent', 'agent.id =inquiry.agent_id', 'left');

        if (!empty($user)) {
            if ($user['type'] != 1) {
                $q = $q->where('inquiry.created_by', $user['id']);
            }
        }


        $q = $q->where('inquiry.agent_status', 2)
                ->get();
        if ($q->num_rows() > 0) {
            return $q->result();
        }
        return array();
    }

    function getCanceledInquiries($user) {
        $q = $this->db->select('customer.fname as c_fname,customer.lname as c_lname,customer.email, county_code.prefix_code,customer.mobile_no,inquiry.*,user.fname as u_fname,user.lname as u_lname,user.email as u_email,user.mobile_no as u_mobile_no,user.status as u_status,user.type as u_type,agent.fname as a_fname,agent.lname as a_lname')
                ->from('inquiry')
                ->join('inquiry_history', 'inquiry_history.inquiry_id = inquiry.id', 'left')
                ->join('city_area', 'city_area.id = inquiry_history.city_area', 'left')
                ->join('customer', 'customer.id =inquiry.customer_id', 'left')
                ->join('county_code', 'customer.coutry_code  = county_code.id', 'left')
                ->join('user', 'user.id =inquiry.created_by', 'left')
                ->join('user as agent', 'agent.id =inquiry.agent_id', 'left');

        if (!empty($user)) {
            if ($user['type'] != 1) {
                $q = $q->where('inquiry.created_by', $user['id']);
            }
        }

        $q = $q->where('inquiry.agent_status', 3)
                ->get();
        if ($q->num_rows() > 0) {
            return $q->result();
        }
        return array();
    }

    function rescheduleInquiry($id, $data) {
        $update = $this->db->where('id', $id)->update('inquiry', $data);

        if ($update) {
            $inquiry = $this->db->select('*')->from('inquiry')->where('id', $id)->get()->result();
            $inquiry_status = array(
                'inquiry_id' => $inquiry[0]->id,
                'agent_id' => $inquiry[0]->agent_id,
                'inquiry_status' => $inquiry[0]->status,
                'inquiry_agent_status' => $inquiry[0]->agent_status,
                'comments' => '',
            );
            $this->db->insert('inquiry_status_history', $inquiry_status);
        }
        return $update;
    }

    function get_property_add_client($clientId) {
        $q = $this->db->select("*")
                ->from('customer')
                ->where('id', $clientId)
                ->get();
        if ($q->num_rows() > 0) {
            return $q->result();
        }
        return array();
    }

    function check_inquiry_client_record($clientId) {
        $q = $this->db->select("*")
                ->from('customer')
                ->where('id', $clientId)
                ->where('deleted !=', '1')
                ->where('status', 'Active')
                ->get();
        if ($q->num_rows() > 0) {
            return $q->result();
        }
        return array();
    }

    function check_inquiry_property_record($propertyid) {
        $q = $this->db->select("*")
                ->from('property')
                ->where('id', $propertyid)
                ->where('status', 'Active')
                ->get();
        if ($q->num_rows() > 0) {
            return $q->result();
        }
        return array();
    }
    
//    function getInquiryDetails($id){
//        $q = $this->db->select("inquiry.*,property.type as property_sale_type,property.address as property.address,property.property_type,property.furnished_type,property.country_id,property.city_id,property.city_area,property.rent_price,property.rent_val,property.sale_price,property..sale_val,property.bedroom,property.bathroom,property.reference_no,property.url_link,agent.fname as agent_first_name,agent.lname as agent_lastname,agent.email as agent_email,agent.mobile_no")
//                ->from('inquiry')
//                ->join('property',"property.id=inquiry.property_id","left")
//                ->join('user as agent',"agent.id=inquiry.agent_id","left")
//                ->join('customer',"customer.id=inquiry.customer_id","left")
//                ->join('user as employee',"employee.id=inquiry.created_by","left")
//                ->where('inquiry.id',$id)
//                ->get();
//        if ($q->num_rows() > 0) {
//            return $q->row();
//        }
//        return array();
//    }

}

?>