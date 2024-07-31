<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	var $TPL;

	public function __construct()
	{
	  parent::__construct();
	  error_reporting(0);
	  $this->TPL['active'] = array('main' => false,
	  								'items' => false,
									  'myaccount' => true,
									  'about' => false,
									  'register' => false,
									  'login' => false);
		if($this->session->userdata('id') == NULL || $this->session->userdata('access_level') != 3) {
			redirect(base_url() . "index.php/MyAccount");
		}
		
	}
	public function index()
	{
		$this->load->model('Users','',TRUE);
		$this->load->model('transactions','',TRUE);
		$userlist = $this->Users->list_user();
		$this->TPL['userlist'] = $userlist;

		$transactions = $this->transactions->list_administrative();
		$this->TPL['transactions'] = $transactions;
		switch($this->session->userdata('access_level')) {
			case 1:
				redirect(base_url() . "index.php/MyAccount");
				break;
			case 2:
				redirect(base_url() . "index.php/Mod");
				break;
			case 3:
				$this->template->show('Administrator',$this->TPL);
				break;
			default:
				redirect(base_url() . "index.php/Login");
				break;
		}
		
		
	}
	public function updatePriv($id) {
		$this->load->model('Users','',TRUE);
		$new = $this->input->post('newlevel');
		$user = $this->Users->find_user($id);
		$userMail = $user[0]['email'];
		$username = $user[0]['username'];
		if($new != NULL) {
			$this->Users->updatePrivilege($id, $new);
			$this->load->config('email');
			$this->load->library('email');
			
			$from = $this->config->item('smtp_user');
			$to = $userMail;
			switch($new) {
				case 1:
					$subject = "Your account privilege has been changed.";
					$message = "<h3>Hello, $username,</h3><p>Your account privilege level has changed to Buyer / Seller, which means your account level is now same as normal users.</p>";
					break;
				case 2:
					$subject = "Your account privilege has been changed.";
					$message = "<h3>Hello, $username,</h3><p>Your account privilege level has changed to Moderator, which means you are now responsible for approving / denying listing and process complaints.</p>";
					break;
				case 3:
					$subject = "Your account privilege has been changed.";
					$message = "<h3>Hello, $username,</h3><p>Your account privilege level has changed to Administrator, which means you are now responsible for administrative roles of this website.</p>";
					break;
				default:
					break;
			}
			
			

			$this->email->set_newline("\r\n");
			$this->email->from($from, "ElectroTown Support");
			$this->email->to($userMail);
			$this->email->subject($subject);
			$this->email->message($message);
			if ($this->email->send()) {
				redirect(base_url() . "index.php/Admin/User/$id");
			} else {
				show_error($this->email->print_debugger());
			}
		} else {

		}
		redirect(base_url() . "index.php/Admin/User/$id");
		
	}
	public function user($id) {
		$this->load->model('Users','',TRUE);
		$this->load->model('Transactions','',TRUE);
		$this->load->model('Reports','',TRUE);
		$user = $this->Users->find_user($id);
		$reportCnt = $this->Reports->getReportCnt($id);
		$transactionCnt = $this->Transactions->myTransactionCnt($id);
		$this->TPL['userinfo'] = $user;
		$this->TPL['transactions'] = $transactionCnt;
		$this->TPL['reports'] = $reportCnt;

		$this->template->show('UserDetails',$this->TPL);
	}
	public function banSwitch($id) {
		$this->load->model('Users','',TRUE);
		$this->Users->ban_switch($id);
		$user = $this->Users->find_user($id);
		$userMail = $user[0]['email'];
		$username = $user[0]['username'];
		$banState = $user[0]['banned'];

		$this->load->config('email');
		$this->load->library('email');
		
		$from = $this->config->item('smtp_user');
		$to = $userMail;
		if($banState == 1) {
			$subject = "Your account is banned from ElectroTown.";
			$message = "<h3>Hello, $username,</h3><p>We are sorry to inform you that your account will no longer be able to use ElectroTown anymore.</p><p>Your account has been banned for violation of ElectroTown rules and / or multiple complaints and suspensions.</p>";
		} else if ($banState == 0) {
			$subject = "Your account has been reinstated.";
		$message = "<h3>Hello, $username,</h3><p>We apologize that we have banned your account by error.</p><p>Your account is now reinstated and you may use ElectroTown service again.</p>";
		}
		

		$this->email->set_newline("\r\n");
		$this->email->from($from, "ElectroTown Support");
		$this->email->to($to);
		$this->email->subject($subject);
		$this->email->message($message);
		if ($this->email->send()) {
			redirect(base_url() . "index.php/Admin/User/$id");
		} else {
			show_error($this->email->print_debugger());
		}
		redirect(base_url() . "index.php/Admin/User/$id");
	}
	public function transaction($id) {
		$this->load->model('Transactions','',TRUE);
		$transaction = $this->Transactions->transaction_detail($id);
		$this->TPL['transaction'] = $transaction;
		$this->template->show('TransactionDetail',$this->TPL);
	}
	public function deleteTransaction($id) {
		$this->load->model('Transactions','',TRUE);
		$this->Transactions->deleteTransaction($id);
		redirect(base_url() . "index.php/Admin");
	}
	
}