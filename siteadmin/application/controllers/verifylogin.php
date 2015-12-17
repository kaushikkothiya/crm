<?php



if (!defined('BASEPATH'))

    exit('No direct script access allowed');



class VerifyLogin extends MY_Controller {



    function __construct() {

        parent::__construct();

        $this->load->model('user', '', TRUE);

    }



    function index() {
        //This method will have the credentials validation

        $this->load->library('form_validation');

        //$this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean');

        //$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean|callback_check_database');
        $this->form_validation->set_rules('password_email', 'password_email', 'trim|xss_clean|callback_check_database');

        if ($this->form_validation->run() == FALSE) {
            //Field validation failed. User redirected to login page
            
            $this->load->view('login_view');
        } else {
            //Go to private area
            redirect('home', 'refresh');

        }

    }
	
	
    function check_database($password) {

        //Field validation succeeded. Validate against database
        $password = $this->input->post('password');
        $username = $this->input->post('username');

        //query the database
        $result = $this->user->login($username, $password);
              
        //echo'<pre>';print_r($result);exit;
        if ($result) {

            $row = $result[0];
            if($row->status=="Inactive") {
                $this->session->set_flashdata('danger',"Your account has been deactivated.");
                return false;
            }else {
                $sess_array = array();
                $sess_array = array(
                    'id' => $row->id,
                    'fname' => $row->fname,
                    'lname' => $row->lname,
                    'email' => $row->email,
                    'mobile_no' => $row->mobile_no,
                    'type' => $row->type,
                );

                if($sess_array['type'] =='1'){
                    $this->session->unset_userdata('logged_in_super_user');
                    $this->session->set_userdata('logged_in_super_user', $sess_array);
                }else if($sess_array['type'] =='2')	{
                    $this->session->unset_userdata('logged_in_agent');
                    $this->session->set_userdata('logged_in_agent', $sess_array);
                }else{
                    $this->session->unset_userdata('logged_in_employee');
                    $this->session->set_userdata('logged_in_employee', $sess_array);
                }			
                //$this->session->unset_userdata('logged_in_store_user');
                //$this->session->set_userdata('logged_in_super_user', $sess_array);
                return TRUE;
            }

        } else {
            $this->session->set_flashdata('danger', 'Invalid username or password.');
            //redirect($url, 'refresh');
            
           
            //$this->form_validation->set_message('check_database', 'Invalid username or password');
            return false;
         }

    }



}



?>