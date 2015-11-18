<?php

Class User extends CI_Model {

    function login($username, $password) {
        
        $this->db->select('id, fname, lname, email, password, mobile_no, type');
        $this->db->from('user');
        $this->db->where('email', $username);
        $this->db->where('password', MD5($password));
        //$this->db->where('role_name', 'admin');
        $this->db->where('status', 'Active');
        $this->db->limit(1);

        $query = $this->db->get();

        if ($query->num_rows() == 1) {
            return $query->result();
        } else {
            return false;
        }
    }
    function getallclient()
    {
        $q = $this->db->select("*")
                ->from('customer')
                ->order_by('fname asc, lname asc')
                ->get();
        if ($q->num_rows() > 0) {
            return $q->result();
        }
        return array();
    }
    function get_user_detail($id)
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
    function update_user_profile($id) {
       //$section_prefix = "agent_";
        $today_date = date('Y-m-d H:i:s');
        
       
            $new_user_update_data = array(
            'fname' => $this->input->post('fname'),
            'lname' => $this->input->post('lname'),
            'email' => $this->input->post('email'),
            'mobile_no' => $this->input->post('mobile_no'),
            'contry_id' =>"1",
            'state_id' => "1",
            'city_id' => $this->input->post('city_id'),
            'updated_date' => $today_date,
            
            );
       
        $update = $this->db->where('id', $id)->update('user', $new_user_update_data);
        return $update;
    }
    function user_email_check($post) {
        // if($this->session->userdata('logged_in_super_user')){
        //    $type ='1';
        // }
        // if($this->session->userdata('logged_in_agent')){
        //     $type ='2';
        // }
        // if($this->session->userdata('logged_in_employee')){
        //    $type ='3';
        // }
            $q = $this->db->select("*")
                ->from('user')
                ->where('email',$post['email'])
                ->where('deleted !=','1')
                ->where('id !=',$post['id'])
                ->get();
        if ($q->num_rows() > 0) {
            return $q->result();
        }
        return array();    
    
}
function user_mobile_check($post) {
    // if($this->session->userdata('logged_in_super_user')){
    //        $type ='1';
    //     }
    //     if($this->session->userdata('logged_in_agent')){
    //         $type ='2';
    //     }
    //     if($this->session->userdata('logged_in_employee')){
    //        $type ='3';
    //     }    
            $q = $this->db->select("*")
                ->from('user')
                ->where('mobile_no',$post['mobile_no'])
                ->where('coutry_code',$post['country_code'])
                ->where('deleted !=',"1")
                ->where('id !=',$post['id'])
                ->get();
        if ($q->num_rows() > 0) {
            return $q->result();
        }
        return array();    
    
}
function property_ref_check($post) {
         $q = $this->db->select("*")
                ->from('property')
                ->where('reference_no',$post['reference_no'])
                //->where('type',$type)
                ->where('id !=',$post['id'])
                ->get();
        if ($q->num_rows() > 0) {
            return $q->result();
        }
        return array();    
    
}
    function pass_check($post) {
            $q = $this->db->select("*")
                ->from('user')
                ->where('password',MD5($post['password']))
                ->where('id',$post['id'])
                ->get();
        if ($q->num_rows() > 0) {
            return $q->result();
        }
        return array();
    }
    function forgote_email_check($post) {
        
        $q = $this->db->select("*")
                ->from('user')
                ->where('email',$post['email'])
                ->get();
        if ($q->num_rows() > 0) {
            return $q->result();
        }
        return array();
    }
    public function getallCountry() {        
        $this->db->select('*');
        $this->db->from('country')->order_by('title', 'ASC');
        $query = $this->db->get();
        $data = $query->result();
          
          $countryData[0] = "Select Country";
        for ($i = 0; $i < count($data); $i++) {
            $countryData[$data[$i]->id] = $data[$i]->title;
        }
        return $countryData;
    }
    
    function getall_countrycode() {

        $this->db->select('*');
        $this->db->from('county_code')->order_by('country', 'ASC');
        //$this->db->where('id','24');
        $query = $this->db->get();
        $data = $query->result();
          
        for ($i = 0; $i < count($data); $i++) {
            $country[$data[$i]->id] =$data[$i]->prefix_code.'-'.$data[$i]->country;
        }
        return $country;
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
    function getallcity_area($id) {

        $this->db->select('*');
        $this->db->from('city_area')->order_by('title', 'ASC');
        $this->db->where('city_id',$id);
        $query = $this->db->get();
        $data = $query->result();
   
       return $data;
    }
    
    function agent_insert() {
        //$section_prefix = "agent_";
      // echo'<pre>';print_r($_POST);exit;
        $today_date = date('Y-m-d H:i:s');
        $new_user_insert_data = array(
            'type' => $this->input->post('type'),
            'fname' => $this->input->post('fname'),
            'lname' => $this->input->post('lname'),
            'email' => $this->input->post('email'),
            'password' => md5($this->input->post('password')),
            'mobile_no' => $this->input->post('mobile_no'),
            'coutry_code' => $this->input->post('county_code'),
            'contry_id' => "1",
            'state_id' => "1",
            'city_id' => $this->input->post('city_id'),
            'created_date' => $today_date,
            'updated_date' => $today_date,
            'status' => $this->input->post('status')
        );
        $insert = $this->db->insert('user', $new_user_insert_data);
        return $insert;
    }

    function agent_update($id) {
       // echo'<pre>';print_r($_POST);exit;
       //$section_prefix = "agent_";
        $today_date = date('Y-m-d H:i:s');
        
        if($this->input->post('password') != "")
        {
            $new_user_update_data = array(
            'type' => $this->input->post('type'),
            'fname' => $this->input->post('fname'),
            'lname' => $this->input->post('lname'),
            'email' => $this->input->post('email'),
            'password' => md5($this->input->post('password')),
            'mobile_no' => $this->input->post('mobile_no'),
            'coutry_code' => $this->input->post('county_code'),
            'contry_id' => "1",
            'state_id' => "1",
            'city_id' => $this->input->post('city_id'),
            'updated_date' => $today_date,
            'status' => $this->input->post('status')
            );
        }
        else
        {
            $new_user_update_data = array(
            'type' => $this->input->post('type'),
            'fname' => $this->input->post('fname'),
            'lname' => $this->input->post('lname'),
            'email' => $this->input->post('email'),
            'mobile_no' => $this->input->post('mobile_no'),
            'coutry_code' => $this->input->post('county_code'),
            'contry_id' =>"1",
            'state_id' => "1",
            'city_id' => $this->input->post('city_id'),
            'updated_date' => $today_date,
            'status' => $this->input->post('status')
            );
        }
        $update = $this->db->where('id', $id)->update('user', $new_user_update_data);
        return $update;
    }
function getAllagent() {

        $q = $this->db->select("*")
                ->from('user')
                ->where('type','2')
                ->where('deleted !=','1')
                ->order_by('id', 'desc')
                ->get();
        if ($q->num_rows() > 0) {
            return $q->result();
        }
        return array();
    }
    function getagent($id) {

        $q = $this->db->select("*")
                ->from('user')
                ->where('id', $id)
                ->get();
        if ($q->num_rows() > 0) {
            return $q->result();
        }
        return array();
    }
    function deleteagent($id) {
        $today_date = date('Y-m-d H:i:s');
        $new_user_update_data = array(
            'updated_date' => $today_date,
            'deleted' => "1"
            );
        
        $update = $this->db->where('id', $id)->update('user', $new_user_update_data);
        return $update;
        // $this->db->where('id', $id);
        // $this->db->delete('user');
    }

    function email_check($post) {
        if(empty($post['id'])){
            
            $q = $this->db->select("*")
                ->from('user')
                ->where('email',$post['email'])
                ->where('deleted !=',"1")
                ->get();
        if ($q->num_rows() > 0) {
            return $q->result();
        }
        return array();
    
        }else{
            $q = $this->db->select("*")
                ->from('user')
                ->where('email',$post['email'])
                ->where('id !=',$post['id'])
                ->where('deleted !=',"1")
                ->get();
        if ($q->num_rows() > 0) {
            return $q->result();
        }
        return array();    
    }
}

 function agent_mobile_check($post) {
        if(empty($post['id'])){
            
            $q = $this->db->select("*")
                ->from('user')
                ->where('mobile_no',$post['mobile_no'])
                ->where('coutry_code',$post['country_code'])
                ->where('deleted !=',"1")
                ->get();
        if ($q->num_rows() > 0) {
            return $q->result();
        }
        return array();
    
        }else{
            $q = $this->db->select("*")
                ->from('user')
                ->where('mobile_no',$post['mobile_no'])
                ->where('coutry_code',$post['country_code'])
                ->where('deleted !=',"1")
                ->where('id !=',$post['id'])
                ->get();
        if ($q->num_rows() > 0) {
            return $q->result();
        }
        return array();    
    }
}


    function customer_insert($num) {
        //$section_prefix = "customer_";
        //echo'<pre>';print_r($_POST);exit;
        $today_date = date('Y-m-d H:i:s');
        $new_user_insert_data = array(
            'customer_ref_id' =>$num,
            'fname' => $this->input->post('fname'),
            'lname' => $this->input->post('lname'),
            'email' => $this->input->post('email'),
            'password' =>"", //md5($this->input->post('password')),
            'mobile_no' => $this->input->post('mobile_no'),
            'coutry_code' => $this->input->post('county_code'),
            'contry_id' => "1",
            'state_id' => "1",
            'city_id' => $this->input->post('city_id'),
            'created_date' => $today_date,
            'updated_date' => $today_date,
            'status' => $this->input->post('status'),
            'type' => '0',
            'reference_from' => $this->input->post('reference_from'),
            'aquired' =>$this->input->post('aquired'),
            //'aquired' => $this->input->post('aquired'),
        );
        $insert = $this->db->insert('customer', $new_user_insert_data);
        $insert = $this->db->insert_id();
        return $insert;
        
    }

     function customer_update($id) {
        //$section_prefix = "customer_";
        $today_date = date('Y-m-d H:i:s');
      //  echo'<pre>';print_r($_POST);exit;
        if($this->input->post('password') != "")
        {
            $new_user_update_data = array(

                'fname' => $this->input->post('fname'),
                'lname' => $this->input->post('lname'),
                'email' => $this->input->post('email'),
                'password' =>"", //md5($this->input->post('password')),
                'mobile_no' => $this->input->post('mobile_no'),
                'coutry_code' => $this->input->post('county_code'),
                'contry_id' => "1",
                'state_id' => "1",
                'city_id' => $this->input->post('city_id'),
                'updated_date' => $today_date,
                'status' => $this->input->post('status'),
                'reference_from' => $this->input->post('reference_from'),
                'aquired' => $this->input->post('aquired'),
                );
        }
        else
        {
            $new_user_update_data = array(
                'fname' => $this->input->post('fname'),
                'lname' => $this->input->post('lname'),
                'email' => $this->input->post('email'),
                'mobile_no' => $this->input->post('mobile_no'),
                'coutry_code' => $this->input->post('county_code'),
                'contry_id' => "1",
                'state_id' => "1",
                'city_id' => $this->input->post('city_id'),
                'updated_date' => $today_date,
                'status' => $this->input->post('status'),
                'reference_from' => $this->input->post('reference_from'),
                'aquired' => $this->input->post('aquired'),
                );
        }
        $update = $this->db->where('id', $id)->update('customer', $new_user_update_data);
        return $update;
    }  

    function getAllcustomer() {
        $q = $this->db->select("*")
                ->from('customer')
                ->where('deleted !=','1')
                ->order_by('id', 'asc')
                ->get();
        if ($q->num_rows() > 0) {
            return $q->result();
        }
        return array();
    }

    function check_unic_num($num) {
        
        $q = $this->db->select("*")
                ->from('customer')
                ->where('Customer_ref_id',$num)
                ->get();
        if ($q->num_rows() > 0) {
            return $q->result();
        }
        return array();
    }

    function getcustomer($id) {

        $q = $this->db->select("*")
                ->from('customer')
                ->where('id', $id)
                ->get();
        if ($q->num_rows() > 0) {
            return $q->result();
        }
        return array();
    }

    function deletecustomer($id) {
         $today_date = date('Y-m-d H:i:s');
        $new_customer_update_data = array(
            'updated_date' => $today_date,
            'deleted' => "1"
            );
        
        $update = $this->db->where('id', $id)->update('customer', $new_customer_update_data);
        return $update;
        // $this->db->where('id', $id);
        // $this->db->delete('customer');
    }

    function customer_email_check($post) {
        if(empty($post['id'])){
            
            $q = $this->db->select("*")
                ->from('customer')
                ->where('email',$post['email'])
                ->where('deleted !=',"1")
                ->get();
        if ($q->num_rows() > 0) {
            return $q->result();
        }
        return array();
    
        }else{
            $q = $this->db->select("*")
                ->from('customer')
                ->where('email',$post['email'])
                ->where('id !=',$post['id'])
                ->where('deleted !=',"1")
                ->get();
        if ($q->num_rows() > 0) {
            return $q->result();
        }
        return array();    
    }
}
function customer_mobile_check($post) {
        if(empty($post['id'])){
            
            $q = $this->db->select("*")
                ->from('customer')
                ->where('mobile_no',$post['mobile_no'])
                ->where('coutry_code',$post['country_code'])
                ->where('deleted !=',"1")
                ->get();
        if ($q->num_rows() > 0) {
            return $q->result();
        }
        return array();
    
        }else{
            $q = $this->db->select("*")
                ->from('customer')
                ->where('mobile_no',$post['mobile_no'])
                ->where('coutry_code',$post['country_code'])
                ->where('deleted !=',"1")
                ->where('id !=',$post['id'])
                ->get();
        if ($q->num_rows() > 0) {
            return $q->result();
        }
        return array();    
    }
}
    
    function getAllemployee() {
        $q = $this->db->select("*")
                ->from('user')
                ->where('type','3')
                ->where('deleted !=','1')
                ->order_by('id', 'desc')
                ->get();
        if ($q->num_rows() > 0) {
            return $q->result();
        }
        return array();
    }
   

    function employee_email_check($post) {
        if(empty($post['id'])){
            
            $q = $this->db->select("*")
                ->from('user')
                ->where('email',$post['email'])
                ->where('deleted !=',"1")
                ->get();
        if ($q->num_rows() > 0) {
            return $q->result();
        }
        return array();
    
        }else{
            $q = $this->db->select("*")
                ->from('user')
                ->where('email',$post['email'])
                ->where('id !=',$post['id'])
                ->where('deleted !=',"1")
                ->get();
        if ($q->num_rows() > 0) {
            return $q->result();
        }
        return array();    
    }
}  
	
	function employee_mobile_check($post) {
        if(empty($post['id'])){
            
            $q = $this->db->select("*")
                ->from('user')
                ->where('mobile_no',$post['mobile_no'])
                ->where('coutry_code',$post['country_code'])
                ->where('deleted !=',"1")
                ->get();
        if ($q->num_rows() > 0) {
            return $q->result();
        }
        return array();
    
        }else{
            $q = $this->db->select("*")
                ->from('user')
                ->where('mobile_no',$post['mobile_no'])
                ->where('coutry_code',$post['country_code'])
                ->where('deleted !=',"1")
                ->where('id !=',$post['id'])
                ->get();
        if ($q->num_rows() > 0) {
            return $q->result();
        }
        return array();    
    }
}
function getAllproperty() {
          $q = $this->db->select("property.*,user.fname,user.lname,city_area.title")
                ->from('property')
                ->join('user','user.id =property.agent_id')
                ->join('city_area','city_area.id =property.city_area')
                ->order_by('id', 'desc')
                ->get();
        if ($q->num_rows() > 0) {
            return $q->result();
        }
        return array();      

        
    }
function getregisted_properties() {
        if($this->session->userdata('logged_in_super_user')){
          $q = $this->db->select("property.*,user.fname,user.lname,city_area.title")
                ->from('property')
                ->join('user','user.id =property.agent_id')
                ->join('city_area','city_area.id =property.city_area')
                ->order_by('id', 'desc')
                ->get();
        if ($q->num_rows() > 0) {
            return $q->result();
        }
        return array();      

        }
        if($this->session->userdata('logged_in_agent')){
            $sessionData = $this->session->userdata('logged_in_agent');
            $added_by = $sessionData['type'];
            $added_id = $sessionData['id'];

            $q = $this->db->select("property.*,user.fname,user.lname,city_area.title")
                ->from('property')
                ->join('user','user.id =property.agent_id')
                ->join('city_area','city_area.id =property.city_area')
                ->order_by('id', 'desc')
                ->where('added_by',$added_by)
                ->where('added_id',$added_id)
                ->get();
        if ($q->num_rows() > 0) {
            return $q->result();
        }
        return array();
        }
        if($this->session->userdata('logged_in_employee')) {
           $sessionData = $this->session->userdata('logged_in_employee'); 
           $added_by = $sessionData['type'];
           $added_id = $sessionData['id'];

            $q = $this->db->select("property.*,user.fname,user.lname,city_area.title")
                ->from('property')
                ->join('user','user.id =property.agent_id')
                ->join('city_area','city_area.id =property.city_area')
                ->order_by('id', 'desc')
                ->where('added_by',$added_by)
                ->where('added_id',$added_id)
                ->get();
        if ($q->num_rows() > 0) {
            return $q->result();
        }
        return array();
        }
       
    }

    function get_property($id) {

            $q = $this->db->select("*")
                    ->from('property')
                    ->where('id', $id)
                    ->get();
            if ($q->num_rows() > 0) {
                return $q->result();
            }
            return array();
        }
    function getUserPassword($id) {
        $query = $this->db->select('*')
                ->from('user')
                ->where('id', $id)
                ->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
    }
	
	
	
    function change_password($user_id, $password) {
        $change_password_update_data = array(
            'password' => MD5($password),
        );
        $insert = $this->db->where('id', $user_id)->update('user', $change_password_update_data);
        return $insert;
    }
    function forgote_password($email, $password) {
        $change_password_update_data = array(
            'password' => MD5($password),
        );
        $insert = $this->db->where('email', $email)->update('user', $change_password_update_data);
        return $insert;
    }
    
    
    
    function getAdminEmail() {

        $this->db->select('*');
        $this->db->from('user');
        $this->db->where('status', 'enabled');
        $this->db->limit(1);

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    function user_forgote_password($num,$email) {
        
        $today_date = date('Y-m-d H:i:s');
        $new_user_update_data = array(
            'password' => $num
        );

        $update = $this->db->where('email', $email)->update('user', $new_user_update_data);
        return $update;
    }
    function user_update_password($email,$password) {
        $section_prefix = "usr_";
        $today_date = date('Y-m-d H:i:s');
        $new_user_update_data = array(
            $section_prefix . 'password' => MD5($password)
        );

        $update = $this->db->where('usr_email', $email)->update('tbl_user', $new_user_update_data);
        return $update;
    }
    
    function property_insert($image) {
        
        if($this->session->userdata('logged_in_super_user')){
            $sessionData = $this->session->userdata('logged_in_super_user');
            $added_by = $sessionData['type'];
            $added_id = $sessionData['id'];
        }
        if($this->session->userdata('logged_in_agent')){
            $sessionData = $this->session->userdata('logged_in_agent');
            $added_by = $sessionData['type'];
            $added_id = $sessionData['id'];
        }
        if($this->session->userdata('logged_in_employee')) {
           $sessionData = $this->session->userdata('logged_in_employee'); 
           $added_by = $sessionData['type'];
           $added_id = $sessionData['id'];
        }
        if(isset($_POST['checkbox1']) && !empty($_POST['checkbox1']))
        {
            $checkval="1";
        }else{
            $checkval="0";
        }
        // $name_array[]=array('0'=>$_POST['link_url'],'1'=>$_POST['link_url1'],'2'=>$_POST['link_url2'])
       $url_mul=array('0'=>$_POST['link_url'],'1'=>$_POST['link_url1'],'2'=>$_POST['link_url']);
        $url_link= implode(',', $url_mul);
        //echo $url_link;exit;
        $today_date = date('Y-m-d H:i:s');
        $new_category_insert_data = array(
            'type' => $this->input->post('type'),
            'address' => $this->input->post('address'),
            'country_id' => $this->input->post('country_id'),
            'city_id' => $this->input->post('city_id'),
            'city_area' => $this->input->post('city_area_id'),
            'property_type' => $this->input->post('property_category'),
            'furnished_type' => $this->input->post('furnished_type'),
            'rent_price' => $this->input->post('rent_price'),
            'sale_price' => $this->input->post('sale_price'),
            'bedroom' => $this->input->post('bedrooms'),
            'bathroom' => $this->input->post('bathrooms'),
            'reference_no' => $this->input->post('reference_no'),
            'short_decs' => $this->input->post('short_desc'),
            'long_desc' => $this->input->post('long_decs'),
            'status' => $this->input->post('status'),
            'url_link' => $url_link,
            'image' => $image,
            'created_date' => $today_date,
            'updated_date' => $today_date,
            'agent_id' => $this->input->post('agent_id'),
            'added_by' => $added_by,
            'added_id' => $added_id,
            'rent_val' => $this->input->post('rent_val'),
            'sale_val' => $this->input->post('sale_val'),
            //'squ_meter' => $this->input->post('sqr_meter'),
            'cover_area' => $this->input->post('cover_area'),
            //'plot_area' => $this->input->post('plot_area'),
            'plot_lan_area' => $this->input->post('plot_land_area'),
            'uncover_area' => $this->input->post('uncover_area'),
            //'totale_area' => $this->input->post('totle_area'),
            'fname' => $this->input->post('fname'),
            'lname' => $this->input->post('lname'),
            'email' => $this->input->post('email'),
            'mobile' => $this->input->post('mobile_no'),
            'coutry_code' => $this->input->post('county_code'),
            'compny_name' => $this->input->post('cname'),
            'tearm_condition' => $checkval,
            'kitchen' => $this->input->post('Kitchen_id'),
            'architectural_design' => $this->input->post('architectural_design_id'),
            'room_size' => $this->input->post('room_size_id'),
            'pets' => $this->input->post('pets_id'),
            'make_year' => $this->input->post('make_year'),
            'cover_parking' => $this->input->post('cover_parking'),
            'uncover_parking' => $this->input->post('uncover_parking'),
            'from_supermarket' => $this->input->post('from_supermarket'),
            'from_bus_station' => $this->input->post('from_bus_station'),
            'from_school' => $this->input->post('from_school'),
            'from_high_way' => $this->input->post('from_high_way'),
            'from_playground' => $this->input->post('from_playground'),
            'from_sea' => $this->input->post('from_sea'),
            'from_cafeteria' => $this->input->post('from_cafeteria'),
            'from_restaurent' => $this->input->post('from_restaurant'),
            'map_adress' => $this->input->post('search_address'),
            'lat_long' => $this->input->post('lat_lon'),
        );
        $insert = $this->db->insert('property', $new_category_insert_data);
        $insert = $this->db->insert_id();
        if(!empty($_POST['genral_facility'])){
        foreach ($_POST['genral_facility'] as $key => $value) {
           
           $insert_facility_data = array(
            'property_id' => $insert,
            'facility_id' => $value,
            'created_date' => $today_date,
            'updated_date' => $today_date,
            );
           $add_facility = $this->db->insert('property_facility', $insert_facility_data);
        }
    }
    if(!empty($_POST['instrumental_facility'])){
        foreach ($_POST['instrumental_facility'] as $key => $value) {
           
           $insert_instrument_facility_data = array(
            'property_id' => $insert,
            'facility_id' => $value,
            'created_date' => $today_date,
            'updated_date' => $today_date,
            );
           $add_facility = $this->db->insert('property_facility', $insert_instrument_facility_data);
        }
    }
        return $insert;
    }
    function property_update($image,$id) {
//echo'<pre>';print_r($_POST);exit;

        if($this->session->userdata('logged_in_super_user')){
            $sessionData = $this->session->userdata('logged_in_super_user');
            $added_by = $sessionData['type'];
            $added_id = $sessionData['id'];
        }
        if($this->session->userdata('logged_in_agent')){
            $sessionData = $this->session->userdata('logged_in_agent');
            $added_by = $sessionData['type'];
            $added_id = $sessionData['id'];
        }
        if($this->session->userdata('logged_in_employee')) {
           $sessionData = $this->session->userdata('logged_in_employee'); 
           $added_by = $sessionData['type'];
           $added_id = $sessionData['id'];
        }
        if(isset($_POST['checkbox1']) && !empty($_POST['checkbox1']))
        {
            $checkval="1";
        }else{
            $checkval="0";
        }
        $url_mul=array('0'=>$_POST['link_url'],'1'=>$_POST['link_url1'],'2'=>$_POST['link_url']);
        $url_link= implode(',', $url_mul);
        $today_date = date('Y-m-d H:i:s');
        $new_category_insert_data = array(
            'type' => $this->input->post('type'),
            'address' => $this->input->post('address'),
            'country_id' => $this->input->post('country_id'),
            'city_id' => $this->input->post('city_id'),
            'city_area' => $this->input->post('city_area_id'),
            'property_type' => $this->input->post('property_category'),
            'furnished_type' => $this->input->post('furnished_type'),
            'rent_price' => $this->input->post('rent_price'),
            'sale_price' => $this->input->post('sale_price'),
            'bedroom' => $this->input->post('bedrooms'),
            'bathroom' => $this->input->post('bathrooms'),
            'reference_no' => $this->input->post('reference_no'),
            'short_decs' => $this->input->post('short_desc'),
            'long_desc' => $this->input->post('long_decs'),
            'status' => $this->input->post('status'),
            'url_link' => $url_link,
            'image' => $image,
            'updated_date' => $today_date,
            'agent_id' => $this->input->post('agent_id'),
            'rent_val' => $this->input->post('rent_val'),
            'sale_val' => $this->input->post('sale_val'),
            //'squ_meter' => $this->input->post('sqr_meter'),
            'cover_area' => $this->input->post('cover_area'),
            //'plot_area' => $this->input->post('plot_area'),
            'plot_lan_area' => $this->input->post('plot_land_area'),
            'uncover_area' => $this->input->post('uncover_area'),
            //'totale_area' => $this->input->post('totle_area'),
            'fname' => $this->input->post('fname'),
            'lname' => $this->input->post('lname'),
            'email' => $this->input->post('email'),
            'mobile' => $this->input->post('mobile_no'),
            'coutry_code' => $this->input->post('county_code'),
            'compny_name' => $this->input->post('cname'),
            'tearm_condition' => $checkval,
            'kitchen' => $this->input->post('Kitchen_id'),
            'architectural_design' => $this->input->post('architectural_design_id'),
            'room_size' => $this->input->post('room_size_id'),
            'pets' => $this->input->post('pets_id'),
            'make_year' => $this->input->post('make_year'),
            'cover_parking' => $this->input->post('cover_parking'),
            'uncover_parking' => $this->input->post('uncover_parking'),
            'from_supermarket' => $this->input->post('from_supermarket'),
            'from_bus_station' => $this->input->post('from_bus_station'),
            'from_school' => $this->input->post('from_school'),
            'from_high_way' => $this->input->post('from_high_way'),
            'from_playground' => $this->input->post('from_playground'),
            'from_sea' => $this->input->post('from_sea'),
            'from_cafeteria' => $this->input->post('from_cafeteria'),
            'from_restaurent' => $this->input->post('from_restaurant'),
            'map_adress' => $this->input->post('search_address'),
            'lat_long' => $this->input->post('lat_lon'),

            //'added_by' => $added_by,
            //'added_id' => $added_id
        );
        $update = $this->db->where('id', $id)->update('property', $new_category_insert_data);


        $this->db->where('property_id', $id);
        $this->db->delete('property_facility');

        if(!empty($_POST['genral_facility'])){
        foreach ($_POST['genral_facility'] as $key => $value) {
           
           $insert_genral_facility_data = array(
            'property_id' => $id,
            'facility_id' => $value,
            'created_date' => $today_date,
            'updated_date' => $today_date,
            );
           $add_genral_facility = $this->db->insert('property_facility', $insert_genral_facility_data);
        }
    }
        if(!empty($_POST['instrumental_facility'])){
        foreach ($_POST['instrumental_facility'] as $key => $value) {
           
           $insert_instrumental_facility_data = array(
            'property_id' => $id,
            'facility_id' => $value,
            'created_date' => $today_date,
            'updated_date' => $today_date,
            );
           $add_instrument_facility = $this->db->insert('property_facility', $insert_instrumental_facility_data);
        }
    }
        return $update;
    }

    function deleteproperty($id) {
        $this->db->where('id', $id);
        $this->db->delete('property');
    }

    function getStoreimage($storeid) {
        $q = $this->db->select("image")
                ->from('store')
                ->where('id', $storeid)
                ->get();
                //print_r($q->result);exit;
        if ($q->num_rows() > 0) {
        		$res = $q->result();
        		return $res[0]->image;
            //return $q->result();
        }
        return array();
    }
    function getInquiryTotal() {
        $q = $this->db->select('count(*) AS totInquiry')
                ->from('inquiry')
                ->order_by('id', 'desc')
                ->get();
                                
        if ($q->num_rows() > 0) {
            return $q->result();
        }
        return array();
    }
     function getPropertyTotal() {
        $q = $this->db->select('count(*) AS totProperty')
                ->from('property')
                ->where('status', "Active")
                ->order_by('id', 'desc')
                ->get();
                                
        if ($q->num_rows() > 0) {
            return $q->result();
        }
        return array();
    }
    function getCustomerTotal() {
        $q = $this->db->select('count(*) AS totCustomer')
                ->from('customer')
                ->where('status', "Active")
                ->where('deleted !=','1')
                ->order_by('id', 'desc')
                ->get();
                                
        if ($q->num_rows() > 0) {
            return $q->result();
        }
        return array();
    }
    function getAgentTotal() {
        $q = $this->db->select('count(*) AS totAgent')
                ->from('user')
                ->where('type', "2")
                ->where('status', "Active")
                ->where('deleted !=','1')
                ->order_by('id', 'desc')
                ->get();
                                
        if ($q->num_rows() > 0) {
            return $q->result();
        }
        return array();
    }
    function getEmployeeTotal() {
        $q = $this->db->select('count(*) AS totEmployee')
                ->from('user')
                ->where('type', "3")
                ->where('status', "Active")
                ->where('deleted !=','1')
                ->order_by('id', 'desc')
                ->get();
                                
        if ($q->num_rows() > 0) {
            return $q->result();
        }
        return array();
    }
    function getAllAgent_name()
   {
        $this->db->select('*');
        $this->db->from('user')->order_by('fname', 'ASC');
        $this->db->where('user.type','2');
        if($this->session->userdata('logged_in_agent')){
            $sessionData = $this->session->userdata('logged_in_agent');
            $id = $sessionData['id'];
            $this->db->where('user.id',$id);
        }
        $query = $this->db->get();
        $data = $query->result();

        if($this->session->userdata('logged_in_super_user') || $this->session->userdata('logged_in_employee')){
            $agentData[0] = "Please select agent"; 
        }
        for ($i = 0; $i < count($data); $i++) {
            $agentData[$data[$i]->id] = $data[$i]->fname." ".$data[$i]->lname;
        }
        return $agentData;
   }
   // function get_property_view_detail_($id){
   //   $q = $this->db->select('*')
   //              ->from('property')
   //              ->where('id',$id)
   //              ->get();
                                
   //      if ($q->num_rows() > 0) {
   //          return $q->result();
   //      }
   //      return array();

   // }
   function get_property_view_detail_($id){
     $q = $this->db->select('property.*,city.title as CityTitle,city_area.title as CityareaTitle')
                ->from('property')
                ->join('city','city.id =property.city_id')
                ->join('city_area','city_area.id =property.city_area')
                ->where('property.id',$id)
                ->get();
                                
        if ($q->num_rows() > 0) {
            return $q->result();
        }
        return array();

   }
   function get_property_related_facility($id) {
        $q = $this->db->select('facility_id')
                ->from('property_facility')
                ->where('property_id',$id)
                ->get();
                                
        if ($q->num_rows() > 0) {
            return $q->result_array();
        }
        return array();
    }
     function get_property_view_image($id) {
        $q = $this->db->select('image_name')
                ->from('propety_extra_images')
                ->where('property_id',$id)
                ->get();
                                
        if ($q->num_rows() > 0) {
            return $q->result();
        }
        return array();
    }
    function get_genral_facilities($id) {
        $q = $this->db->select('property_facility.*,facilities.title')
                ->from('property_facility')
                ->join('facilities','facilities.id =property_facility.facility_id')
                ->where('property_facility.property_id',$id)
                ->where('facilities.category_id','1')
                ->get();
                                
        if ($q->num_rows() > 0) {
            return $q->result();
        }
        return array();
    }
    function get_instrumental_facilities($id) {
        $q = $this->db->select('property_facility.*,facilities.title')
                ->from('property_facility')
                ->join('facilities','facilities.id =property_facility.facility_id')
                ->where('property_facility.property_id',$id)
                ->where('facilities.category_id','2')
                ->get();
                                
        if ($q->num_rows() > 0) {
            return $q->result();
        }
        return array();
    }

    function get_contry_code($id) {
        $q = $this->db->select('prefix_code')
                ->from('county_code')
                ->where('id',$id)
                ->get();
                                
        if ($q->num_rows() > 0) {
            return $q->result();
        }
        return array();
    }

    function get_property_title($inquiryid)
    {
            $q = $this->db->select('inquiry.id,property.*')
                ->from('inquiry')
                ->join('property','property.id =inquiry.property_id')
                ->where('inquiry.id',$inquiryid)
                ->get();
                                
        if ($q->num_rows() > 0) {
            return $q->result();
        }
        return array();
    }
    function get_property_image($propid)
    {
        $rs = array();
            $q = $this->db->select('*')
                ->from('images')
                ->order_by("order","ASC")
                ->where('prop_id',$propid)
                ->get();
                                
        if ($q->num_rows() > 0) {
            $rs = $q->result();
        }
        return $rs;
    }
    function delete_propimg($propid){
      $this->db->where('id', $propid);
      $this->db->delete('images'); 
    }
    function select_maxid()
    {
        $rs = array();
            $q = $this->db->select_max('id')
                ->from('images')
                ->get();
                                
        if ($q->num_rows() > 0) {
            $rs = $q->result();
        }

         if (count($rs) > 0) {
            $rs_maxid = $rs[0]->id;
        }else{
            $rs_maxid = 0;
        }
        return $rs_maxid;
    }
    function insert_propimg($propimag){
        $this->db->insert('images', $propimag);
        $rs = $this->db->insert_id();
        return $rs;
    }
    function update_propimg($propimag){
       $this->db->where('id', $propimag['id']);
        $this->db->update('images', $propimag);
    }
    
}

?>