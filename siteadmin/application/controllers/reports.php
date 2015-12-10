<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Reports extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('html');
        $this->load->model('user', '', TRUE);
        $this->load->model('inquiry_model', '', TRUE);
        $this->load->helper('form');

        $config = Array(
            'mailtype' => 'html',
            'wordwrap' => TRUE
        );
        $this->load->library('email', $config);
    }

    public function index() {
        if ($this->session->userdata('logged_in_super_user') || $this->session->userdata('logged_in_agent') || $this->session->userdata('logged_in_employee')) {

            $user = array();
            if ($this->session->userdata('logged_in_super_user')) {
                $user = $this->session->userdata('logged_in_super_user');
            } else if ($this->session->userdata('logged_in_agent')) {
                $user = $this->session->userdata('logged_in_agent');
            } else if ($this->session->userdata('logged_in_employee')) {
                $user = $this->session->userdata('logged_in_employee');
            }
            $data = array('user' => $user);
            $this->load->model('report_model');

            if ($user['type'] == 1) {
                $employees = $this->report_model->getAllEmployees();
                $agents = $this->report_model->getAllAgents();
                $data['employees'] = $employees;
                $data['agents'] = $agents;
            }
            $user_id = $user['id'];
            if (isset($_REQUEST['user_type']) && $_REQUEST['user_type'] == 2 && isset($_REQUEST['agent_user_id']) && !empty($_REQUEST['agent_user_id'])) {
                $user_id = $_REQUEST['agent_user_id'];
            }
            if (isset($_REQUEST['user_type']) && $_REQUEST['user_type'] == 3 && isset($_REQUEST['employee_user_id']) && !empty($_REQUEST['employee_user_id'])) {
                $user_id = $_REQUEST['employee_user_id'];
            }

            if (isset($_REQUEST['user_type']) && ($_REQUEST['user_type'] == 3 || $_REQUEST['user_type'] == 2) && (( isset($_REQUEST['employee_user_id']) && $_REQUEST['employee_user_id'] == 'all' ) || ( isset($_REQUEST['agent_user_id']) && $_REQUEST['agent_user_id'] == 'all' ) )) {
                $user_id = 'all';
            }

            //$from_date = date("m/d/Y", strtotime("-1 months"));
            //$to_date = date('m/d/Y');
            $from_date = $to_date = date('m/d/Y');

            if (isset($_REQUEST['from_date'])) {
                $from_date = $_REQUEST['from_date'];
            }
            if (isset($_REQUEST['to_date'])) {
                $to_date = $_REQUEST['to_date'];
            }

            $_REQUEST['from_date'] = $from_date;
            $_REQUEST['to_date'] = $to_date;

            $data['reporting'] = $this->report_model->getUserReporting($user_id, $from_date, $to_date);

            $this->load->view('reports/index', $data);
        } else {
            //If no session, redirect to login page
            redirect('login', 'refresh');
        }
    }

    public function property() {
        if ($this->session->userdata('logged_in_super_user') || $this->session->userdata('logged_in_agent') || $this->session->userdata('logged_in_employee')) {

            $user = array();
            if ($this->session->userdata('logged_in_super_user')) {
                $user = $this->session->userdata('logged_in_super_user');
            } else if ($this->session->userdata('logged_in_agent')) {
                $user = $this->session->userdata('logged_in_agent');
            } else if ($this->session->userdata('logged_in_employee')) {
                $user = $this->session->userdata('logged_in_employee');
            }
            $data = array('user' => $user);
            $this->load->model('report_model');

            if ($user['type'] == 1) {
                $employees = $this->report_model->getAllEmployees();
                $data['employees'] = $employees;
            }
            
            if ($user['type'] == 1 || $user['type'] == 2) {
                $agents = $this->report_model->getAllAgents();
                $data['agents'] = $agents;
            }
            
            $user_id = $user['id'];
            if (isset($_REQUEST['user_type']) && $_REQUEST['user_type'] == 2 && isset($_REQUEST['agent_user_id']) && !empty($_REQUEST['agent_user_id'])) {
                $user_id = $_REQUEST['agent_user_id'];
            }
            
            if (isset($_REQUEST['user_type']) && $_REQUEST['user_type'] == 3 && isset($_REQUEST['employee_user_id']) && !empty($_REQUEST['employee_user_id'])) {
                $user_id = $_REQUEST['employee_user_id'];
            }

            if (isset($_REQUEST['user_type']) && ($_REQUEST['user_type'] == 3 || $_REQUEST['user_type'] == 2) && (( isset($_REQUEST['employee_user_id']) && $_REQUEST['employee_user_id'] == 'all' ) || ( isset($_REQUEST['agent_user_id']) && $_REQUEST['agent_user_id'] == 'all' ) )) {
                $user_id = 'all';
            }

            //$from_date = date("m/d/Y", strtotime("-1 months"));
            //$to_date = date('m/d/Y');
            $from_date = $to_date = date('m/d/Y');

            if (isset($_REQUEST['from_date'])) {
                $from_date = $_REQUEST['from_date'];
            }
            if (isset($_REQUEST['to_date'])) {
                $to_date = $_REQUEST['to_date'];
            }

            $_REQUEST['from_date'] = $from_date;
            $_REQUEST['to_date'] = $to_date;

            $data['reporting'] = $this->report_model->getPropertyReporting($user_id, $from_date, $to_date);
            $this->load->view('reports/property', $data);
        } else {
            //If no session, redirect to login page
            redirect('login', 'refresh');
        }
    }
    
    public function client() {
        if ($this->session->userdata('logged_in_super_user') || $this->session->userdata('logged_in_agent') || $this->session->userdata('logged_in_employee')) {

            $user = array();
            if ($this->session->userdata('logged_in_super_user')) {
                $user = $this->session->userdata('logged_in_super_user');
            } else if ($this->session->userdata('logged_in_agent')) {
                $user = $this->session->userdata('logged_in_agent');
            } else if ($this->session->userdata('logged_in_employee')) {
                $user = $this->session->userdata('logged_in_employee');
            }
            $data = array('user' => $user);
            $this->load->model('report_model');

            if ($user['type'] == 1) {
                $employees = $this->report_model->getAllEmployees();
                $data['employees'] = $employees;
            }
            
            if ($user['type'] == 1 || $user['type'] == 2) {
                $agents = $this->report_model->getAllAgents();
                $data['agents'] = $agents;
            }
            
            $user_id = $user['id'];
            if (isset($_REQUEST['user_type']) && $_REQUEST['user_type'] == 2 && isset($_REQUEST['agent_user_id']) && !empty($_REQUEST['agent_user_id'])) {
                $user_id = $_REQUEST['agent_user_id'];
            }
            
            if (isset($_REQUEST['user_type']) && $_REQUEST['user_type'] == 3 && isset($_REQUEST['employee_user_id']) && !empty($_REQUEST['employee_user_id'])) {
                $user_id = $_REQUEST['employee_user_id'];
            }

            if (isset($_REQUEST['user_type']) && (( isset($_REQUEST['employee_user_id']) && $_REQUEST['employee_user_id'] == 'all' ) || ( isset($_REQUEST['agent_user_id']) && $_REQUEST['agent_user_id'] == 'all' ) )) {
                $user_id = 'all';
            }
            
            //$from_date = date("m/d/Y", strtotime("-1 months"));
            //$to_date = date('m/d/Y');
            $from_date = $to_date = date('m/d/Y');

            if (isset($_REQUEST['from_date'])) {
                $from_date = $_REQUEST['from_date'];
            }
            if (isset($_REQUEST['to_date'])) {
                $to_date = $_REQUEST['to_date'];
            }

            $_REQUEST['from_date'] = $from_date;
            $_REQUEST['to_date'] = $to_date;

            $data['reporting'] = $this->report_model->getClientReporting($user_id, $from_date, $to_date);
            $this->load->view('reports/client', $data);
        } else {
            //If no session, redirect to login page
            redirect('login', 'refresh');
        }
    }    

    function nullToString(&$item) {
        if (!is_array($item) && !is_object($item)) {
            $item = strval($item);
        } else {
            if (is_object($item)) {
                $item = (array) $item;
            }
            array_walk($item, array($this, 'nullToString'));
        }
    }

}