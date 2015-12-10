<?php

Class Newsletter_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function saveNewsletter($data) {
        if ($this->db->insert('email_newsletter', $data)) {
            return true;
        } else {
            return false;
        }
    }

    function saveSMSNewsletter($data) {
        if ($this->db->insert('sms_newsletter', $data)) {
            return true;
        } else {
            return false;
        }
    }

    function getMinMaxPriceByCustomerID($id, $sale_group = array(), $rent_group = array(), $type = 1) {

        if ($type == 1) {
            $this->db->select('property.sale_price,property.rent_price,customer.email,customer.fname,customer.lname, customer.aquired')
                    ->from('inquiry')
                    ->join('property', 'inquiry.property_ref_no = property.reference_no', 'left')
                    ->join('customer', 'inquiry.customer_id = customer.id', 'left')
                    ->where('inquiry.property_ref_no is not null')
                    ->where("inquiry.property_ref_no != ''")
                    ->where("inquiry.customer_id", $id);
            $res1 = $this->db->get();
            
            $sale_grps = array();
            $rent_grps = array();
            $res = array();
            if ($res1->num_rows() > 0) {
                $rows = $res1->result();
                foreach ($rows as $key => $row) {
                    foreach ($rent_group['groups'] as $grp) {
                        $range = explode("-", $grp['name']);
                        if ($range[1] == 'gt') {
                            if ($row->rent_price >= $range[0]) {
                                $rent_grps[] = $grp['name'];
                            }
                            continue;
                        }

                        if (!in_array($grp['name'], $rent_grps)) {
                            if ($row->rent_price >= $range[0] && $row->rent_price <= $range[1]) {
                                $rent_grps[] = $grp['name'];
                            }
                        }
                    }
                    foreach ($sale_group['groups'] as $grp) {
                        $range = explode("-", $grp['name']);
                        if ($range[1] == 'gt') {
                            if ($row->sale_price >= $range[0]) {
                                $sale_grps[] = $grp['name'];
                            }
                            continue;
                        }

                        if (!in_array($grp['name'], $sale_grps)) {
                            if ($row->sale_price >= $range[0] && $row->sale_price <= $range[1]) {
                                $sale_grps[] = $grp['name'];
                            }
                        }
                    }
                }
                $res['fname'] = $rows[0]->fname;
                $res['lname'] = $rows[0]->lname;
                $res['email'] = $rows[0]->email;
                $res['aquired'] = $rows[0]->aquired;
                $res['rent_grps'] = $rent_grps;
                $res['sale_grps'] = $sale_grps;
                $res['type'] = 4;
                $res['status'] = ($rows[0]->status == 'Active') ? 1 : 0;
                
            }else{
                $rows = $this->user->getcustomer($id);
                $res['fname'] = $rows[0]->fname;
                $res['lname'] = $rows[0]->lname;
                $res['email'] = $rows[0]->email;
                $res['aquired'] = $rows[0]->aquired;
                $res['rent_grps'] = $rent_grps;
                $res['sale_grps'] = $sale_grps;
                $res['type'] = 4;
                $res['status'] = ($rows[0]->status == 'Active') ? 1 : 0;
            }
            return $res;
        } else {
            $this->load->model('user');
            
            $user = $this->user->getUserByID($id,true);

            if (!empty($user)) {
                $res = array();
                $res['fname'] = $user->fname;
                $res['lname'] = $user->lname;
                $res['email'] = $user->email;
                $res['aquired'] = '';
                $res['rent_grps'] = array();
                $res['sale_grps'] = array();
                $res['type'] = $user->type;
                $res['status'] = ($user->status == 'Active') ? 1 : 0;
                return $res;
            }
        }
        return array();
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
                ->join('county_code', 'customer.coutry_code  = county_code.id', 'left')
                ->where('customer.status', 'Active')
                ->where('customer.deleted', '0');

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
                ->join('county_code', 'user.coutry_code  = county_code.id', 'left')
                ->where('user.status', 'Active')
                ->where('user.deleted', '0');

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