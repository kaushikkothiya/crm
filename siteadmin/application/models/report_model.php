<?php

Class Report_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    //getClientReporting
    function getClientReporting($id, $from_date, $to_date){
        
        $data = array();
        if ($id !== 'all') {
            $user = $this->get_user_detail($id);
        } else {
            $user = array();
            $_REQUEST['user_type'] = (!isset($_REQUEST['user_type']))?1:$_REQUEST['user_type'];
            $user[0] = (Object) array('type' => $_REQUEST['user_type']);
        }
        
        // added properties
        $added_clients = array();
        $q = $this->db->select('customer.*,user.fname as u_fname,user.lname as u_lname')
                ->from('customer')
                ->join('user','user.id =customer.added_id','left');
        if ($id !== 'all') {
            $q = $q->where('customer.added_id',$id);
        }
        $q = $q->where("DATE_FORMAT(customer.updated_date,'%m/%d/%Y') >=", $from_date);
        $q = $q->where("DATE_FORMAT(customer.updated_date,'%m/%d/%Y') <=", $to_date);
        $q = $q->group_by("customer.id");
        $q = $q->order_by("customer.updated_date", "desc");
        $q = $q->get();
        if ($q->num_rows() > 0) {
            $added_clients = $q->result();
        }
        $data['added_clients'] = $added_clients;
        
        // assigned properties
        $assigned_clients = array();
        $q = $this->db->select('customer.*,user.fname as u_fname,user.lname as u_lname')
                ->from('customer')
                ->join('inquiry','inquiry.customer_id =customer.id','left')
                ->join('inquiry_status_history','inquiry.id = inquiry_status_history.inquiry_id and inquiry_status_history.inquiry_status = 4 and inquiry_status_history.inquiry_agent_status = 0','left')
                ->join('user','user.id =inquiry_status_history.agent_id','left');
        
        if ($id !== 'all') {
            $q = $q->where('user.id',$id);
        }
        $q = $q->where('inquiry_status_history.agent_id != 0');
        $q = $q->where("DATE_FORMAT(inquiry_status_history.created,'%m/%d/%Y') >=", $from_date);
        $q = $q->where("DATE_FORMAT(inquiry_status_history.created,'%m/%d/%Y') <=", $to_date);
        $q = $q->order_by("inquiry_status_history.created", "desc");
        $q = $q->get();
        if ($q->num_rows() > 0) {
            $assigned_clients = $q->result();
        }
        $data['assigned_clients'] = $assigned_clients;
        
        $data['agent_clients'] = 0;
        if($user[0]->type == 1 || $user[0]->type == 2){
            $q = $this->db->select('count(customer.id) as cnt')
                ->from('customer')
                ->join('inquiry','inquiry.customer_id =customer.id','left')
                ->join('inquiry_status_history','inquiry.id = inquiry_status_history.inquiry_id and inquiry_status_history.inquiry_status = 4 and inquiry_status_history.inquiry_agent_status = 1','left')
                ->join('user','user.id =inquiry_status_history.agent_id','left');
            if ($id !== 'all') {
                $q = $q->where('inquiry_status_history.agent_id',$id);
            }            
            $q = $q->where("DATE_FORMAT(inquiry_status_history.created,'%m/%d/%Y') >=", $from_date);
            $q = $q->where("DATE_FORMAT(inquiry_status_history.created,'%m/%d/%Y') <=", $to_date);
            $q = $q->get();
            if ($q->num_rows() > 0) {
                $data['agent_clients'] = $q->result();
                $data['agent_clients'] = $data['agent_clients'][0]->cnt;
            }
        }
        
        $active_properties = array();
        $q = $this->db->select('property.*,user.fname,user.lname,city_area.title,propety_extra_images.image_name')
                ->from('property')
                ->join('user','user.id =property.agent_id','left')
                ->join('city_area','city_area.id =property.city_area','left')
                ->join('propety_extra_images','property.id =propety_extra_images.property_id','left');
        $q = $q->where("DATE_FORMAT(property.updated_date,'%m/%d/%Y') >=", $from_date);
        $q = $q->where("DATE_FORMAT(property.updated_date,'%m/%d/%Y') <=", $to_date);
        $q = $q->where("property.status","Active");
        $q = $q->group_by("property.id");
        $q = $q->order_by("property.updated_date", "desc");
        $q = $q->get();
        if ($q->num_rows() > 0) {
            $active_properties = $q->result();
        }
        $data['active_properties'] = $active_properties;
        
        $inactive_properties = array();
        $q = $this->db->select('property.*,user.fname,user.lname,city_area.title,propety_extra_images.image_name')
                ->from('property')
                ->join('user','user.id =property.agent_id','left')
                ->join('city_area','city_area.id =property.city_area','left')
                ->join('propety_extra_images','property.id =propety_extra_images.property_id','left');
        $q = $q->where("DATE_FORMAT(property.updated_date,'%m/%d/%Y') >=", $from_date);
        $q = $q->where("DATE_FORMAT(property.updated_date,'%m/%d/%Y') <=", $to_date);
        $q = $q->where("property.status","Inactive");
        $q = $q->group_by("property.id");
        $q = $q->order_by("property.updated_date", "desc");
        $q = $q->get();
        if ($q->num_rows() > 0) {
            $inactive_properties = $q->result();
        }
        $data['inactive_properties'] = $inactive_properties;
        return $data;
    }
    
    function getPropertyReporting($id, $from_date, $to_date){
        
        $data = array();
        if ($id !== 'all') {
            $user = $this->get_user_detail($id);
        } else {
            $user = array();
            $_REQUEST['user_type'] = (!isset($_REQUEST['user_type']))?1:$_REQUEST['user_type'];
            $user[0] = (Object) array('type' => $_REQUEST['user_type']);
        }
        
        // added properties
        $added_properties = array();
        $q = $this->db->select('property.*,user.fname,user.lname,city_area.title,propety_extra_images.image_name')
                ->from('property')
                ->join('user','user.id =property.agent_id','left')
                ->join('city_area','city_area.id =property.city_area','left')
                ->join('propety_extra_images','property.id =propety_extra_images.property_id','left');
        if ($id !== 'all') {
            $q = $q->where('property.added_id',$id);
        }
        $q = $q->where("DATE_FORMAT(property.updated_date,'%m/%d/%Y') >=", $from_date);
        $q = $q->where("DATE_FORMAT(property.updated_date,'%m/%d/%Y') <=", $to_date);
        $q = $q->group_by("property.id");
        $q = $q->order_by("property.updated_date", "desc");
        $q = $q->get();
        if ($q->num_rows() > 0) {
            $added_properties = $q->result();
        }
        $data['added_properties'] = $added_properties;
        
        // assigned properties
        $assigned_properties = array();
        $q = $this->db->select('property.*,user.fname,user.lname,city_area.title,propety_extra_images.image_name')
                ->from('inquiry')
                ->join('property','inquiry.property_id = property.id','left')
                ->join('inquiry_status_history','inquiry.id = inquiry_status_history.inquiry_id and inquiry_status_history.inquiry_status = 4 and inquiry_status_history.inquiry_agent_status = 0','left')
                ->join('user','user.id =property.agent_id','left')
                ->join('city_area','city_area.id =property.city_area','left')
                ->join('propety_extra_images','property.id =propety_extra_images.property_id','left');
        if ($id !== 'all') {
            //$q = $q->where('inquiry.agent_id',$id);
            $q = $q->where('inquiry_status_history.agent_id',$id);
        }
        $q = $q->where('inquiry.agent_id != 0');
        $q = $q->where("DATE_FORMAT(inquiry_status_history.created,'%m/%d/%Y') >=", $from_date);
        $q = $q->where("DATE_FORMAT(inquiry_status_history.created,'%m/%d/%Y') <=", $to_date);
        $q = $q->group_by("property.id");
        $q = $q->order_by("inquiry_status_history.created", "desc");
        $q = $q->get();
        if ($q->num_rows() > 0) {
            $assigned_properties = $q->result();
        }
        $data['assigned_properties'] = $assigned_properties;
        
        $data['agent_properties'] = 0;
        if($user[0]->type == 1 || $user[0]->type == 2){
            $q = $this->db->select('count(property.id) as cnt')
                ->from('property');
            if ($id !== 'all') {
                $q = $q->where('property.added_id',$id);
            }            
            $q = $q->where("DATE_FORMAT(property.updated_date,'%m/%d/%Y') >=", $from_date);
            $q = $q->where("DATE_FORMAT(property.updated_date,'%m/%d/%Y') <=", $to_date);
            $q = $q->get();
            if ($q->num_rows() > 0) {
                $data['agent_properties'] = $q->result();
                $data['agent_properties'] = $data['agent_properties'][0]->cnt;
            }
        }
        
        $active_properties = array();
        $q = $this->db->select('property.*,user.fname,user.lname,city_area.title,propety_extra_images.image_name')
                ->from('property')
                ->join('user','user.id =property.agent_id','left')
                ->join('city_area','city_area.id =property.city_area','left')
                ->join('propety_extra_images','property.id =propety_extra_images.property_id','left');
        $q = $q->where("DATE_FORMAT(property.updated_date,'%m/%d/%Y') >=", $from_date);
        $q = $q->where("DATE_FORMAT(property.updated_date,'%m/%d/%Y') <=", $to_date);
        $q = $q->where("property.status","Active");
        $q = $q->group_by("property.id");
        $q = $q->order_by("property.updated_date", "desc");
        $q = $q->get();
        if ($q->num_rows() > 0) {
            $active_properties = $q->result();
        }
        $data['active_properties'] = $active_properties;
        
        $inactive_properties = array();
        $q = $this->db->select('property.*,user.fname,user.lname,city_area.title,propety_extra_images.image_name')
                ->from('property')
                ->join('user','user.id =property.agent_id','left')
                ->join('city_area','city_area.id =property.city_area','left')
                ->join('propety_extra_images','property.id =propety_extra_images.property_id','left');
        $q = $q->where("DATE_FORMAT(property.updated_date,'%m/%d/%Y') >=", $from_date);
        $q = $q->where("DATE_FORMAT(property.updated_date,'%m/%d/%Y') <=", $to_date);
        $q = $q->where("property.status","Inactive");
        $q = $q->group_by("property.id");
        $q = $q->order_by("property.updated_date", "desc");
        $q = $q->get();
        if ($q->num_rows() > 0) {
            $inactive_properties = $q->result();
        }
        $data['inactive_properties'] = $inactive_properties;
        
        return $data;
    }
    
    function get_user_detail($id) {
        $q = $this->db->select("*")
                ->from('user')
                ->where('id', $id)
                ->get();
        if ($q->num_rows() > 0) {
            return $q->result();
        }
        return array();
    }

    function getUserReporting($id, $from_date, $to_date) {

        if ($id !== 'all') {
            $user = $this->get_user_detail($id);
        } else {
            $user = array();
            $user[0] = (Object) array('type' => $_REQUEST['user_type']);
        }

        $inquiries = array();
        $q = $this->db->select("customer.fname as c_fname,customer.lname as c_lname,customer.email, county_code.prefix_code,customer.mobile_no,inquiry.*,user.fname as u_fname,user.lname as u_lname,user.email as u_email,user.mobile_no as u_mobile_no,user.status as u_status,user.type as u_type,agent.fname as a_fname,agent.lname as a_lname, IFNULL(DATEDIFF(
(SELECT DATE_FORMAT(created,'%Y-%m-%d') FROM `inquiry_status_history` where inquiry_status='4' and inquiry_agent_status='1' and inquiry_id=inquiry.id order by `created` DESC limit 0,1),

(SELECT DATE_FORMAT(created,'%Y-%m-%d') FROM `inquiry_status_history` where inquiry_status='4' and inquiry_agent_status='0' and inquiry_id=inquiry.id order by `created` DESC limit 0,1)
),'') as diff_ass_conf", FALSE)
                ->from('inquiry')
                ->join('inquiry_history', 'inquiry_history.inquiry_id = inquiry.id', 'left')
                ->join('city_area', 'city_area.id = inquiry_history.city_area', 'left')
                ->join('customer', 'customer.id =inquiry.customer_id', 'left')
                ->join('county_code', 'customer.coutry_code  = county_code.id', 'left')
                ->join('user', 'user.id =inquiry.created_by', 'left')
                ->join('user as agent', 'agent.id =inquiry.agent_id', 'left');
        if ($id !== 'all')
            $q = $q->where('inquiry.created_by', $id);
        $q = $q->where("DATE_FORMAT(inquiry.updated_date,'%m/%d/%Y') >=", $from_date);
        $q = $q->where("DATE_FORMAT(inquiry.updated_date,'%m/%d/%Y') <=", $to_date);
        $q = $q->group_by('inquiry.id');
        $q = $q->order_by("updated_date", "desc");
        $q = $q->get();
        if ($q->num_rows() > 0) {
            $inquiries = $q->result();
        }

        $appointments_assigned = 0;
        $q = $this->db->select("count(inquiry_status_history.id) as cnt")
                ->from('(select * from inquiry_status_history order by inquiry_status_history.created desc) as inquiry_status_history', false)
                ->join('inquiry', 'inquiry.id = inquiry_status_history.inquiry_id', 'left');
        if ($id !== 'all')
            $q = $q->where("inquiry.created_by", $id);
        $q = $q->where("inquiry_status_history.inquiry_status", 4)
                //->where("inquiry_status_history.inquiry_agent_status",0)
                ->where("DATE_FORMAT(inquiry_status_history.created,'%m/%d/%Y') >=", $from_date)
                ->where("DATE_FORMAT(inquiry_status_history.created,'%m/%d/%Y') <=", $to_date)
                ->where('inquiry_status_history.agent_id != 0')
                ->group_by("inquiry.id")
                ->get();
        if ($q->num_rows() > 0) {
            $appointments_assigned = $q->result();
            $appointments_assigned = $appointments_assigned[0]->cnt;
        }

        $appointments = array();
        if ($user[0]->type != 3) {
            $q = $this->db->select(" inquiry_status_history.inquiry_agent_status,customer.fname as c_fname,customer.lname as c_lname,customer.email, county_code.prefix_code,customer.mobile_no,inquiry.*,user.fname as u_fname,user.lname as u_lname,user.email as u_email,user.mobile_no as u_mobile_no,user.status as u_status,user.type as u_type,agent.fname as a_fname,agent.lname as a_lname, TIMESTAMPDIFF(
SECOND,
(SELECT created FROM `inquiry_status_history` where `inquiry_status_history`.agent_id = '" . $id . "' and inquiry_status='4' and inquiry_agent_status='0' and inquiry_id=inquiry.id order by `created` DESC limit 0,1),
(SELECT created FROM `inquiry_status_history` where `inquiry_status_history`.agent_id = '" . $id . "' and inquiry_status='4' and inquiry_agent_status='1' and inquiry_id=inquiry.id order by `created` DESC limit 0,1)
) as diff_ass_conf", FALSE)
                    ->from('(select * from inquiry_status_history order by inquiry_status_history.created desc) as inquiry_status_history', false)
                    ->join('inquiry', 'inquiry.id=inquiry_status_history.inquiry_id', 'left')
                    ->join('inquiry_history', 'inquiry_history.inquiry_id = inquiry.id', 'left')
                    ->join('city_area', 'city_area.id = inquiry_history.city_area', 'left')
                    ->join('customer', 'customer.id =inquiry.customer_id', 'left')
                    ->join('county_code', 'customer.coutry_code  = county_code.id', 'left')
                    ->join('user', 'user.id =inquiry.created_by', 'left')
                    ->join('user as agent', 'agent.id =inquiry.agent_id', 'left');
            if ($id !== 'all')
                $q = $q->where('inquiry_status_history.agent_id', $id);
            $q = $q->where("DATE_FORMAT(inquiry_status_history.created,'%m/%d/%Y') >=", $from_date)
                    ->where("DATE_FORMAT(inquiry_status_history.created,'%m/%d/%Y') <=", $to_date)
                    ->where('inquiry_status_history.agent_id != 0')
                    ->group_by('inquiry.id')
                    ->order_by("inquiry_status_history.created", "desc")
                    ->get();
            if ($q->num_rows() > 0) {
                $appointments = $q->result();
            }
        }

        $inquiry_completed = 0;
        $q = $this->db->select("count(inquiry.id) as cnt")
                ->from('inquiry');
        if ($id !== 'all')
            $q = $q->where("inquiry.created_by", $id);
        $q = $q->where("inquiry.status", 5)
                ->where("DATE_FORMAT(inquiry.updated_date,'%m/%d/%Y') >=", $from_date)
                ->where("DATE_FORMAT(inquiry.updated_date,'%m/%d/%Y') <=", $to_date)
                ->get();
        if ($q->num_rows() > 0) {
            $inquiry_completed = $q->result();
            $inquiry_completed = $inquiry_completed[0]->cnt;
        }

        $appointments_completed = 0;
        if ($user[0]->type != 3) {
            $q = $this->db->select("count(inquiry.id) as cnt")
                    ->from('inquiry_status_history')
                    ->join('inquiry', 'inquiry.id=inquiry_status_history.inquiry_id', 'left');
            if ($id !== 'all')
                $q = $q->where("inquiry_status_history.agent_id", $id);
            $q = $q->where("inquiry_status_history.inquiry_status", 5)
                    ->where("DATE_FORMAT(inquiry_status_history.created,'%m/%d/%Y') >=", $from_date)
                    ->where("DATE_FORMAT(inquiry_status_history.created,'%m/%d/%Y') <=", $to_date)
                    ->where('inquiry_status_history.agent_id != 0')
                    ->get();
            if ($q->num_rows() > 0) {
                $appointments_completed = $q->result();
                $appointments_completed = $appointments_completed[0]->cnt;
            }
        }

        $appointments_canceled = 0;
        if ($user[0]->type != 3) {
            $q = $this->db->select("count(inquiry_status_history.id) as cnt")
                    ->from('inquiry_status_history')
                    ->join('inquiry', 'inquiry.id=inquiry_status_history.inquiry_id', 'left');
            if ($id !== 'all')
                $q = $q->where("inquiry_status_history.agent_id", $id);
            $q = $q->where("inquiry_status_history.inquiry_agent_status", 3)
                    ->where("DATE_FORMAT(inquiry_status_history.created,'%m/%d/%Y') >=", $from_date)
                    ->where("DATE_FORMAT(inquiry_status_history.created,'%m/%d/%Y') <=", $to_date)
                    ->where('inquiry_status_history.agent_id != 0')
                    ->get();
            if ($q->num_rows() > 0) {
                $appointments_canceled = $q->result();
                $appointments_canceled = $appointments_canceled[0]->cnt;
            }
        }

        $appointments_reschedule = 0;
        if ($user[0]->type != 3) {
            $q = $this->db->select("count(inquiry_status_history.id) as cnt")
                    ->from('inquiry_status_history')
                    ->join('inquiry', 'inquiry.id=inquiry_status_history.inquiry_id', 'left');
            if ($id !== 'all')
                $q = $q->where("inquiry_status_history.agent_id", $id);
            $q = $q->where("inquiry_status_history.inquiry_agent_status", 2)
                    ->where("DATE_FORMAT(inquiry_status_history.created,'%m/%d/%Y') >=", $from_date)
                    ->where("DATE_FORMAT(inquiry_status_history.created,'%m/%d/%Y') <=", $to_date)
                    ->where('inquiry_status_history.agent_id != 0')
                    ->get();
            if ($q->num_rows() > 0) {
                $appointments_reschedule = $q->result();
                $appointments_reschedule = $appointments_reschedule[0]->cnt;
            }
        }

        $appointments_confirmed = 0;
        if ($user[0]->type != 3) {
            $q = $this->db->select("count(inquiry_status_history.id) as cnt")
                    ->from('inquiry_status_history')
                    ->join('inquiry', 'inquiry.id=inquiry_status_history.inquiry_id', 'left');
            if ($id !== 'all')
                $q = $q->where("inquiry_status_history.agent_id", $id);
            $q = $q->where("inquiry_status_history.inquiry_agent_status", 1)
                    ->where("DATE_FORMAT(inquiry_status_history.created,'%m/%d/%Y') >=", $from_date)
                    ->where("DATE_FORMAT(inquiry_status_history.created,'%m/%d/%Y') <=", $to_date)
                    ->where('inquiry_status_history.agent_id != 0')
                    ->get();
            if ($q->num_rows() > 0) {
                $appointments_confirmed = $q->result();
                $appointments_confirmed = $appointments_confirmed[0]->cnt;
            }
        }

        $summery = array();
        $summery['inquiry_completed'] = $inquiry_completed;
        $summery['appointments_completed'] = $appointments_completed;
        $summery['appointments_canceled'] = $appointments_canceled;
        $summery['appointments_reschedule'] = $appointments_reschedule;
        $summery['appointments_confirmed'] = $appointments_confirmed;
        $summery['appointments_assigned'] = $appointments_assigned;

        return array('user' => $user, 'inquiries' => $inquiries, 'appointments' => $appointments, 'summery' => $summery);
    }

    function getAllAgents() {
        $q = $this->db->select('user.id,user.fname,user.lname,user.email,user.mobile_no,user.status,user.type')
                ->from('user')
                ->join('county_code', 'user.coutry_code  = county_code.id', 'left')
                ->where('user.type', 2)
                ->get();
        if ($q->num_rows() > 0) {
            return $q->result();
        }
        return array();
    }

    function getAllEmployees() {
        $q = $this->db->select('user.id,user.fname,user.lname,user.email,user.mobile_no,user.status,user.type')
                ->from('user')
                ->join('county_code', 'user.coutry_code  = county_code.id', 'left')
                ->where('user.type', 3)
                ->get();
        if ($q->num_rows() > 0) {
            return $q->result();
        }
        return array();
//        $q = $this->db->select('customer.fname as c_fname,customer.lname as c_lname,customer.email, county_code.prefix_code,customer.mobile_no,inquiry.*,user.fname as u_fname,user.lname as u_lname,user.email as u_email,user.mobile_no as u_mobile_no,user.status as u_status,user.type as u_type,agent.fname as a_fname,agent.lname as a_lname')
//                ->from('inquiry')
//                ->join('inquiry_history', 'inquiry_history.inquiry_id = inquiry.id','left')
//                ->join('city_area', 'city_area.id = inquiry_history.city_area','left')
//                ->join('customer','customer.id =inquiry.customer_id','left')
//                ->join('county_code', 'customer.coutry_code  = county_code.id','left')
//                ->join('user','user.id =inquiry.created_by','left')
//                ->join('user as agent','agent.id =inquiry.agent_id','left')
//                ->where('inquiry.agent_id',$id)
//                ->where('inquiry.agent_status',0)
//                ->get();
//        if ($q->num_rows() > 0) {
//            return $q->result();
//        }
//        return array();
    }

    function getSMSNewsletterByID($id) {
        $this->db->select('receivers')
                ->from('sms_newsletter')
                ->where("id", $id);
        $res = $this->db->get();
        if ($res->num_rows() > 0) {
            return $res->result();
        }
        return array();
    }

    function getAllSMSNewsLetters() {
        $this->db->select('*')
                ->from('sms_newsletter')
                ->order_by("created", "desc");
        $res = $this->db->get();
        if ($res->num_rows() > 0) {
            return $res->result();
        }
        return array();
    }

    function getAllNewsLetters() {
        $this->db->select('*')
                ->from('email_newsletter')
                ->order_by("created", "desc");
        $res = $this->db->get();
        if ($res->num_rows() > 0) {
            return $res->result();
        }
        return array();
    }

    function getCustomerReceiverList($data, $type = 'email') {

        //$this->db->select("`customer`.`id`,  `property`.`sale_price`,`property`.`rent_price`,`customer`.`fname`,`customer`.`lname`,`customer`.`email`,`county_code`.`prefix_code`,`customer`.`mobile_no`, IF(TRUE,4,NULL) as 'type' ",false)
        $this->db->select("`customer`.`id`,  `customer`.`fname`,`customer`.`lname`,`customer`.`email`,`county_code`.`prefix_code`,`customer`.`mobile_no`, IF(TRUE,4,NULL) as 'type' ", false)
                ->from('customer')
                ->join('county_code', 'customer.coutry_code  = county_code.id', 'left');

        if (!empty($data['sale_range']) || !empty($data['rent_range'])) {
            $this->db->join('inquiry', 'customer.id  = inquiry.customer_id', 'left');
            $this->db->join('property', 'inquiry.property_ref_no = property.reference_no', 'left');

            $where = array();

            if (isset($data['client_specification']) && $data['client_specification'] == 'rent') {
                if (!empty($data['rent_range'])) {
                    $rent_range = explode('-', $data['rent_range']);
                    if ($rent_range[1] != 'gt') {
                        $where[] = "( property.rent_price >= '" . $rent_range[0] . "' && property.rent_price <= '" . $rent_range[1] . "' )";
                    } else {
                        $where[] = "property.rent_price >= '" . $rent_range[0] . "'";
                    }
                }
            }

            if (isset($data['client_specification']) && $data['client_specification'] == 'sale') {
                if (!empty($data['sale_range'])) {
                    $sale_range = explode('-', $data['sale_range']);
                    if ($sale_range[1] != 'gt') {
                        $where[] = "( property.sale_price >= '" . $sale_range[0] . "' && property.sale_price <= '" . $sale_range[1] . "' )";
                    } else {
                        $where[] = "property.sale_price >= '" . $sale_range[0] . "'";
                    }
                }
            }

            if (isset($data['client_specification']) && $data['client_specification'] == 'both') {
                $or_codition = array();
                if (!empty($data['rent_range'])) {
                    $rent_range = explode('-', $data['rent_range']);
                    if ($rent_range[1] != 'gt') {
                        $or_codition[] = "( property.rent_price >= '" . $rent_range[0] . "' && property.rent_price <= '" . $rent_range[1] . "' )";
                    } else {
                        $or_codition[] = "property.rent_price >= '" . $rent_range[0] . "'";
                    }
                }

                if (!empty($data['sale_range'])) {
                    $sale_range = explode('-', $data['sale_range']);
                    if ($sale_range[1] != 'gt') {
                        $or_codition[] = "( property.sale_price >= '" . $sale_range[0] . "' && property.sale_price <= '" . $sale_range[1] . "' )";
                    } else {
                        $or_codition[] = "property.sale_price >= '" . $sale_range[0] . "'";
                    }
                }
                $where[] = "(" . implode(' OR ', $or_codition) . ")";
            }

            if (!empty($where)) {
                $where = '( ' . implode(" AND ", $where) . ' )';
                $this->db->where($where);
            }
        }

        if (isset($data['client_specification']) && !empty($data['client_specification'])) {
            $where = array();
            if ($data['client_specification'] == 'rent') {
                $where[] = "customer.aquired = 'rent'";
            }

            if ($data['client_specification'] == 'sale') {
                $where[] = "customer.aquired = 'sale'";
            }

            if (!empty($where)) {
                $where = '( ' . implode(" OR ", $where) . ' )';
                $this->db->where($where);
            }
        }

        $this->db->where('customer.deleted !=', 1);
        if ($type == 'sms') {
            $this->db->where("( county_code.prefix_code != '' AND county_code.prefix_code is not null )");
            $this->db->where("( customer.mobile_no != '' AND customer.mobile_no is not null )");
            $this->db->group_by(array("county_code.prefix_code", "customer.mobile_no"));
        } else {
            $this->db->where("( customer.email != '' AND customer.email is not null )");
            $this->db->group_by("customer.email");
        }

        $res = $this->db->get();
        if ($res->num_rows() > 0) {

            return $res->result();
        }
        return array();
    }

    function getStaffReceiverList($data, $type = 'email') {

        $this->db->select('user.id,user.fname,user.lname,user.email,county_code.prefix_code,user.mobile_no,user.type')
                ->from('user')
                ->join('county_code', 'user.coutry_code  = county_code.id', 'left');

        if (!empty($data['user_type'])) {
            $where = array();
            if (in_array('administrator', $data['user_type'])) {
                $where[] = "user.type = '1'";
            }
            if (in_array('agents', $data['user_type'])) {
                $where[] = "user.type = '2'";
            }
            if (in_array('employees', $data['user_type'])) {
                $where[] = "user.type = '3'";
            }
            if (!empty($where)) {
                $where = '( ' . implode(" OR ", $where) . ' )';
                $this->db->where($where);
            }
        }

        $this->db->where('user.deleted !=', 1);

        if ($type == 'sms') {
            $this->db->where("( county_code.prefix_code != '' AND county_code.prefix_code is not null )");
            $this->db->where("( user.mobile_no != '' AND user.mobile_no is not null )");
            $this->db->group_by(array("county_code.prefix_code", "user.mobile_no"));
        } else {
            $this->db->where("( user.email != '' AND user.email is not null )");
            $this->db->group_by("user.email");
        }

        $res = $this->db->get();
        if ($res->num_rows() > 0) {
            return $res->result();
        }
        return array();
    }

}

?>