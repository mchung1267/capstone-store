<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MyAccount extends CI_Controller {

	var $TPL;

	public function __construct()
	{
	  parent::__construct();
	  error_reporting(0);
		//Library for form validation
		$this->load->library('form_validation');

		$this->form_validation->set_rules('password', 'Password', 'required|callback_isPasswordValid');

		$this->form_validation->set_rules('firstname', 'First Name', 'required');

		$this->form_validation->set_rules('lastname', 'Last Name', 'required');

		$this->form_validation->set_rules('line_one', 'Address Line 1', 'required');

		$this->form_validation->set_rules('city', 'City', 'required');

	  $this->TPL['active'] = array('main' => false,
	  								'items' => false,
									  'myaccount' => true,
									  'about' => false,
									  'register' => false,
									  'login' => false);
		if($this->session->userdata('id') == NULL) {
			redirect(base_url() . "index.php/Login");
		}
	}
	public function index()
	{
		$this->load->model('Users','',TRUE);
		$this->load->model('Listings','',TRUE);
		$this->load->model('Messages','',TRUE);
		$this->load->model('Appointments','',TRUE);
		$this->load->model('Transactions','',TRUE);
		$this->load->model('Reports','',TRUE);
		$transactions = $this->Transactions->myTransactions($this->session->userdata('id'));
		$myAppointments = $this->Appointments->list_myappointment($this->session->userdata('id'));
		$unread = $this->Messages->unread_message_count($this->session->userdata('id'));
		$myListings = $this->Listings->mylisting($this->session->userdata('id'));
		$userinfo = $this->Users->find_user($this->session->userdata('id'));
		$purchaseCnt = $this->Appointments->purchaseApptCnt();
		$saleCnt = $this->Appointments->salesApptCnt();
		$complaints_received = $this->Reports->listMyReportsReceived($this->session->userdata('id'));
		$complaints_sent = $this->Reports->listMyReportsSent($this->session->userdata('id'));
		$this->TPL['user'] = $userinfo;
		$this->TPL['listings'] = $myListings;
		$this->TPL['unread'] = $unread[0]['cnt'];
		$this->TPL['appointments'] = $myAppointments;
		$this->TPL['transactions'] = $transactions;
		$this->TPL['saleAppt'] = $saleCnt[0]['cnt'];
		$this->TPL['purcAppt'] = $purchaseCnt[0]['cnt'];
		$this->TPL['complaints_received'] = $complaints_received;
		$this->TPL['complaints_sent'] = $complaints_sent;
		switch($this->session->userdata('access_level')) {
			case 1:
				$this->template->show('MyAccount',$this->TPL);
				break;
			case 2:
				redirect(base_url() . "index.php/Mod");
				break;
			case 3:
				redirect(base_url() . "index.php/Admin");
				break;
			default:
				redirect(base_url() . "index.php/Login");
				break;
		}
		
	}
	public function editProfile($id) {
		if($id != $this->session->userdata('id')) {
			redirect(base_url() . "index.php/MyAccount");
		}
		$this->load->model("Users",'',TRUE);
		$currUser = $this->Users->find_user($this->session->userdata('id'));
		$this->TPL['current'] = $currUser[0];
		$this->template->show("Profile",$this->TPL);
	}
	public function update($id) {
		$this->load->model("Users",'',TRUE);
        $username = $this->input->post("username");
        $first_name = $this->input->post("firstname");
        $last_name = $this->input->post("lastname");
        $address_line_one = $this->input->post("line_one");
        $address_line_two = $this->input->post("line_two");
        $city = $this->input->post("city");
        $province = $this->input->post("province");
        $password = $this->input->post('password');
		$currUser = $this->Users->find_user($this->session->userdata('id'));
		$this->TPL['current'] = $currUser[0];
		$hashed = password_hash($password, PASSWORD_BCRYPT);
		if($this->form_validation->run() == FALSE) {

		} else {
			$this->Users->update_profile($id, $first_name, $last_name, $hashed, $address_line_one, $address_line_two, $city, $province);
			redirect(base_url() . "index.php/MyAccount");
		}
		$this->template->show('Profile', $this->TPL);
	}
    public function isPasswordValid($password) {
        if(strlen($password) < 8){
            $this->form_validation->set_message('isPasswordValid', 'Password must be at least 8 characters.');
            return false;
        } 
        if (!preg_match("#[A-Z]+#", $password)) {
            $this->form_validation->set_message('isPasswordValid', "Password must include at least one uppercase and lowercase letter each!");
            return false;
        } 
        if (!preg_match("#[a-z]+#", $password)) {
            $this->form_validation->set_message('isPasswordValid', "Password must include at least one uppercase and lowercase letter each!");
            return false;
        } 
        if (!preg_match("#[0-9]+#", $password)) {
            $this->form_validation->set_message('isPasswordValid', "Password must include at least one number!");
            return false;
        }
        return true;
    }
}