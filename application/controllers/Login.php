<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	var $TPL;

	public function __construct()
	{
	  parent::__construct();
	  error_reporting(0);
	  $this->load->library('form_validation');
	  $this->form_validation->set_rules('email', 'E-Mail Address', 'required|callback_checkEmail');
	  $this->form_validation->set_rules('password', 'Password', 'required|callback_checkPassword');
	  $this->TPL['active'] = array('main' => false,
	  								'items' => false,
									  'myaccount' => false,
									  'about' => false,
									  'register' => false,
									  'login' => false);
		if($this->session->userdata('id') != NULL) {
			redirect(base_url() . "index.php/MyAccount");
		}
	}
	public function index()
	{
		$this->template->show('Login',$this->TPL);
	}
	public function process() {
		$email = $this->input->post('email');
		$password = $this->input->post('password');
		if($this->form_validation->run() == FALSE) {
            
        } else {
			$this->session->set_userdata(array('id'=>1));
			$getUser = $this->db->query("SELECT * FROM users WHERE email='$email'");
			$userinfo = $getUser->result_array();
			$this->session->set_userdata(array('id' => $userinfo[0]['user_id']));
			$this->session->set_userdata(array('access_level' => $userinfo[0]['privilege_id']));
			$this->session->set_userdata(array('first_name' => $userinfo[0]['first_name']));
			$this->session->set_userdata(array('last_name' => $userinfo[0]['last_name']));
			redirect(base_url() . "index.php/MyAccount");
		}
		$this->template->show("Login", $this->TPL);
		
	}
	public function checkEmail($email) {
		$this->load->model("Users",'',TRUE);
		$userInfo = $this->Users->findUserByEmail($email);
		if($userInfo[0]['suspension_expire'] >= date("Y-m-d")) {
			$this->form_validation->set_message('checkEmail', "User associated with this account is currently suspended until " . $userInfo[0]['suspension_expire']);
			return false;
		} else if($userInfo[0]['banned'] == 1) {
			$this->form_validation->set_message('checkEmail', "User associated with this account is currently banned");
			return false;
		} else {
			return true;
		}
	}
	public function checkPassword($password) {
		$this->load->model("Users",'',TRUE);
		$email = $this->input->post('email');
		$userInfo = $this->Users->findUserByEmail($email);
		$correctPass = $userInfo[0]['password'];
		
		
		
		if(password_verify($password, $correctPass)) {
			return true;
		} else {
			$this->form_validation->set_message('checkPassword', "Username or Password is Incorrect");
			return false;
		}
		
	}
}