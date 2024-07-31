<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mod extends CI_Controller {

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
		if($this->session->userdata('id') == NULL || $this->session->userdata('access_level') != 2) {
			redirect(base_url() . "index.php/Login");
		}
	}
	public function index()
	{
		$this->load->model("Users",'',TRUE);
		$this->load->model("Listings",'',TRUE);
		$this->load->model("Reports",'',TRUE);
		$this->load->model("Messages",'',TRUE);
		$unread = $this->Messages->unread_message_count($this->session->userdata('id'));
		$listings = $this->Listings->show_pending_listing();
		$data = $this->Users->list_user();
		$reports = $this->Reports->list_report();
		$this->TPL["complaints"] = $reports;
		$this->TPL["users"] = $data;
		$this->TPL["listings"] = $listings;
		$this->TPL["unread"] = $unread[0]['cnt'];
		switch($this->session->userdata('access_level')) {
			case 1:
				redirect(base_url() . "index.php/MyAccount");
				break;
			case 2:
				$this->template->show('Moderator',$this->TPL);
				break;
			case 3:
				redirect(base_url() . "index.php/Admin");
				break;
			default:
				redirect(base_url() . "index.php/Login");
				break;
		}
		
	}
	public function suspendUser($id) {
		$this->load->model("Users",'',TRUE);
		$this->load->model('Reports','',TRUE);
		$this->load->model('Listings','',TRUE);
		$report = $this->Reports->select_report($id);
		$listing = $this->Listings->show_listing_detail($report[0]['listing_id']);
		$this->Users->suspend_switch($listing[0]['user_id']);
		$seller = $this->Users->find_user($listing[0]['user_id']);
		$sellerMail = $report[0]['sellermail'];
		$sellerName = $report[0]['sellername'];
		$buyerMail = $report[0]['buyermail'];
		$buyerName = $report[0]['buyername'];
		$susExpiry = $seller[0]['suspension_expire'];
		$itemname = $listing[0]['product_name'];
		$this->Reports->resolve($id);
		$this->load->config('email');
		$this->load->library('email');
		
		$from = $this->config->item('smtp_user');
		$to = $sellerMail;
		$subject = "Your Account Has Been Suspended!";
		$message = "<h3>Hello, $username,</h3><p>Your accout has been suspended until $susExpiry. It is due to complaint by a buyer for $itemname which you have listed.</p><p>You may not use our service until suspension expires.</p>";

		$this->email->set_newline("\r\n");
		$this->email->from($from, "ElectroTown Support");
		$this->email->to($to);
		$this->email->subject($subject);
		$this->email->message($message);
		if ($this->email->send()) {
			$from = $this->config->item('smtp_user');
			$to = $buyerMail;
			$subject = "Your Account Has Been Suspended!";
			$message = "<h3>Hello, $buyerName,</h3><p>Your case has been resolved by a moderator. A seller has been suspended by a moderator..</p>";

			$this->email->set_newline("\r\n");
			$this->email->from($from, "ElectroTown Support");
			$this->email->to($to);
			$this->email->subject($subject);
			$this->email->message($message);
			if($this->email->send()) {
				redirect(base_url() . "index.php/Mod");
			} else {
				redirect(base_url() . "index.php/Mod");
			}
		} else {
			redirect(base_url() . "index.php/Mod");
		}
	}
	public function approveListing($id) {
		$this->load->model("Users",'',TRUE);
		$this->load->model("Listings",'',TRUE);
		$this->Listings->approve_listing($id);
		$item = $this->Listings->show_listing_detail($id);
		$userid = $item[0]['user_id'];
		$itemname = $item[0]['product_name'];
		$user = $this->Users->find_user($userid);
		$sellerMail = $user[0]['email'];
		$username = $user[0]['username'];

		$this->load->config('email');
		$this->load->library('email');
		
		$from = $this->config->item('smtp_user');
		$to = $sellerMail;
		$subject = "Your listing of $itemname has been approved!";
		$message = "<h3>Hello, $username,</h3><p>Thank you for using ElectroTown to list your $itemname.</p><p>Your item is now approved by moderator and will be visible to buyers and public users.</p>";

		$this->email->set_newline("\r\n");
		$this->email->from($from, "ElectroTown Support");
		$this->email->to($to);
		$this->email->subject($subject);
		$this->email->message($message);
		if ($this->email->send()) {
			redirect(site_url("Mod"));
		} else {
			show_error($this->email->print_debugger());
		}
		
	}
	public function rejectListing($id) {
		$this->load->model("Users",'',TRUE);
		$this->load->model("Listings",'',TRUE);
		$this->Listings->reject_listing($id);
		$item = $this->Listings->show_listing_detail($id);
		$userid = $item[0]['user_id'];
		$itemname = $item[0]['product_name'];
		$user = $this->Users->find_user($userid);
		$sellerMail = $user[0]['email'];
		$username = $user[0]['username'];

		$this->load->config('email');
		$this->load->library('email');
		
		$from = $this->config->item('smtp_user');
		$to = $sellerMail;
		$subject = "Your listing of $itemname has been Rejected by the Moderator.";
		$message = "<h3>Hello, $username,</h3><p>Thank you for using ElectroTown to list your $itemname.</p><p>Unfortunately, your item listing has been rejected by the moderator. Please delete the listing and relist an item with more details and upload pictures as instructed.</p>";

		$this->email->set_newline("\r\n");
		$this->email->from($from, "ElectroTown Support");
		$this->email->to($to);
		$this->email->subject($subject);
		$this->email->message($message);
		if ($this->email->send()) {
			redirect(site_url("Mod"));
		} else {
			show_error($this->email->print_debugger());
		}
		
	}
}