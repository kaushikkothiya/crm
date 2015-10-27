<?php



if (!defined('BASEPATH'))

    exit('No direct script access allowed');



class Login extends CI_Controller {



    function __construct() {

        parent::__construct();

        $this->load->model('user', '', TRUE);

    }



    function index() {

        if ($this->session->userdata('logged_in_super_user') || $this->session->userdata('logged_in_agent') || $this->session->userdata('logged_in_employee'))
     {
          redirect('home', 'refresh');
      }
        if ($this->session->userdata('logged_in_super_user')) {

           

            //$data['category'] = $this->user->getCategoryTotal();

            //$data['ingredient'] = $this->user->getIngredientTotal();

            //$data['dishes'] = $this->user->getDishTotal();

            //$data['ads'] = $this->user->getAdsTotal();

           // $data['greetings'] = $this->user->getGreetingsTotal();

				$data['user'] =array(); //$this->user->getUserTotal();            
            
            $data['category'] =array(); //$this->user->getCategoryTotal();
            
				$data['store'] =array(); //$this->user->getStoreTotal();
		
				$data['coupon'] =array(); //$this->user->getCouponTotal();

            $this->load->view("home_view", $data);

        } else {

            $this->load->helper(array('form'));

            $this->load->view('login_view');

        }

    }

    


}



?>