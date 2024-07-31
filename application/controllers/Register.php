<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends CI_Controller {

	var $TPL;

	public function __construct()
	{
	  parent::__construct();
      error_reporting(0);
        //Library for form validation
        $this->load->library('form_validation');

        $this->form_validation->set_rules('username', 'Username', 'required|callback_isNameUnique');

        $this->form_validation->set_rules('password', 'Password', 'required|callback_isPasswordValid');

        $this->form_validation->set_rules('firstname', 'First Name', 'required');

        $this->form_validation->set_rules('lastname', 'Last Name', 'required');

        $this->form_validation->set_rules('email', 'E-Mail Address', 'required|callback_isEmailUnique');

        $this->form_validation->set_rules('line_one', 'Address Line 1', 'required');

        $this->form_validation->set_rules('city', 'City', 'required');

	  $this->TPL['active'] = array('main' => false,
	  								'items' => false,
									  'myaccount' => true,
									  'about' => false,
									  'register' => false,
									  'login' => false);
        
	}
    public function isNameUnique($name) {
        $this->load->model("Users",'',TRUE);
		$data = $this->Users->checkUserName($name);
		if($data == 1) {
            return true;
        } else {
            $this->form_validation->set_message('isNameUnique', 'Username already exists.');
            return false;
        }
    }
    public function isEmailUnique($email) {
        $this->load->model("Users",'',TRUE);
		$data = $this->Users->checkEmail($email);
		if($data == 1) {
            return true;
        } else {
            $this->form_validation->set_message('isEmailUnique', 'E-Mail address already exists.');
            return false;
        }
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
    public function SignUp() {
        $this->load->model("Users",'',TRUE);
        $username = $this->input->post("username");
        $first_name = $this->input->post("firstname");
        $last_name = $this->input->post("lastname");
        $email = $this->input->post("email");
        $address_line_one = $this->input->post("line_one");
        $address_line_two = $this->input->post("line_two");
        $city = $this->input->post("city");
        $province = $this->input->post("province");
        $password = $this->input->post('password');
		$hashed = password_hash($password, PASSWORD_BCRYPT);
        if($this->form_validation->run() == FALSE) {
            
        } 
        //If input is valid, add user data into table
        else {
            $data = $this->Users->add_user($username, $first_name, $last_name, $email, $hashed, $address_line_one, $address_line_two, $city, $province);
            $this->load->config('email');
            $this->load->library('email');
            
            $from = $this->config->item('smtp_user');
            $to = $email;
            $subject = "Welcome to ElectroTown!";
            $message = "<h3>Hello, $username,</h3><p>Thank you for signing up for an account at ElectroTown. Now you can list items, 
            book an appointment with a seller and communicate with sellers. Your account is now active and you may start using our service.</p><a href='https://capstone.setsuna.live/index.php/Login'>Click here to login</a>";

            $this->email->set_newline("\r\n");
            $this->email->from($from, "ElectroTown Support");
            $this->email->to($to);
            $this->email->subject($subject);
            $this->email->message($message);
            if ($this->email->send()) {
                redirect(base_url() . "index.php/Login");
            } else {
                show_error($this->email->print_debugger());
            }
          
        }
        $this->template->show('Register', $this->TPL);
    }
	public function index()
	{


		switch($this->session->userdata('access_level')) {
			case 1:
				redirect(base_url() . "index.php/MyAccount");
				break;
			case 2:
				redirect(base_url() . "index.php/Mod");
				break;
			case 3:
				redirect(base_url() . "index.php/Admin");
				break;
			default:
                $this->template->show('Register',$this->TPL);
				break;
		}
		
	}
}