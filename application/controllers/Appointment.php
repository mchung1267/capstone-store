<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Appointment extends CI_Controller {
    
    public function __construct()
	{
	    parent::__construct();
        error_reporting(0);
	    $this->TPL['active'] = array('main' => false,
	  								'items' => false,
									  'myaccount' => false,
									  'about' => false,
									  'register' => false,
									  'login' => false);
        switch($this->session->userdata('access_level')) {
        case 1:
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
    public function index() {
        redirect(base_url() . "index.php/MyAccount");
    }
    public function new($id) {
        
        $this->load->model('Listings','',TRUE);
        $this->load->model('Users','',TRUE);
        $item = $this->Listings->show_listing_detail($id);
        $sellerInfo = $this->Users->find_user($item[0]['user_id']);
        if($sellerInfo[0]['user_id'] == $this->session->userdata('id')) {
            redirect(base_url() . "index.php/MyAccount");
        } else {
            $this->TPL['listing'] = $item;
            $this->TPL['seller'] = $sellerInfo;
    
            $this->template->show("NewAppointment", $this->TPL);
        }
    }
    public function create($id) {
        $this->load->model('Listings','',TRUE);
        $this->load->model('Appointments','',TRUE);
        $this->load->model('Users','',TRUE);
        $item = $this->Listings->show_listing_detail($id);
        $buyer = $this->session->userdata('id');
        $seller = $item[0]["user_id"];
        $date = $this->input->post("date");
        $time = $this->input->post("time");
        $buyerInfo = $this->Users->find_user($this->session->userdata('id'));
        $sellerInfo = $this->Users->find_user($item[0]['user_id']);
        $sellerName = $sellerInfo[0]['username'];
        $buyerName = $buyerInfo[0]['username'];
        if($date > $item[0]['listing_enddate']) {
            $this->template->show("NewAppointment", $this->TPL);
        } else {
            $listing = $item[0]["listing_id"];
            $this->Appointments->add_appointment($buyer, $seller, $date, $time, $listing);
        }
        $this->load->config('email');
		$this->load->library('email');
		
		$from = $this->config->item('smtp_user');
		$to = $sellerInfo[0]['email'];
		$subject = "An Appointment Request From $buyerName";
        $message = "<h3>Hello, $sellerName,</h3><p>$buyerName has requested you an appointment at : </p><p>$date</p><p>$time</p><p>Please approve or deny the request.</p>";
		

		$this->email->set_newline("\r\n");
		$this->email->from($from, "ElectroTown Support");
		$this->email->to($to);
		$this->email->subject($subject);
		$this->email->message($message);
		if ($this->email->send()) {
			redirect(base_url() . "index.php/Items/Details/".$item[0]['listing_id']);
		} else {
			show_error($this->email->print_debugger());
		}
        
    }
    public function reschedule($id) {
        $this->load->model('Listings','',TRUE);
        $this->load->model('Appointments','',TRUE);
        $this->load->model('Users','',TRUE);
        $appointment = $this->Appointments->appointment_detail($id);
        $item = $this->Listings->show_listing_detail($appointment[0]['listing_id']);
        $sellerInfo = $this->Users->find_user($appointment[0]['buyer_id']);
        $buyerInfo = $this->Users->find_user($appointment[0]['buyer_id']);
        $this->TPL['appointment'] = $appointment[0];
        $this->TPL['listing'] = $item[0];
        $this->TPL['seller'] = $sellerInfo[0];
        $this->TPL['buyer'] = $buyerInfo[0];
        $this->template->show("RescheduleAppointment", $this->TPL);
    }
    public function update($id) {
        $this->load->model('Appointments','',TRUE);
        $this->load->model('Users','',TRUE);
        $this->load->model('Listings','',TRUE);
        $date = $this->input->post("date");
        $time = $this->input->post("time");
        $appointment = $this->Appointments->appointment_detail($id);
        $item = $this->Listings->show_listing_detail($appointment[0]['listing_id']);
        $sellerInfo = $this->Users->find_user($appointment[0]['seller_id']);
        $buyerInfo = $this->Users->find_user($appointment[0]['buyer_id']);
        $sellerName = $sellerInfo[0]['username'];
        $buyerName = $buyerInfo[0]['username'];
        $sellerMail = $sellerInfo[0]['email'];
        if($date > $item[0]['listing_enddate']) {
            $this->template->show("RescheduleAppointment", $this->TPL);
        } else {
            $this->Appointments->adjust_appointment($id, $date, $time);
        }
        $this->load->config('email');
		$this->load->library('email');

        $from = $this->config->item('smtp_user');
		$to = $sellerMail;
		$subject = "Appointment Reschedule Request by $buyerName";
        $message = "<h3>Hello, $sellerName,</h3><p>$buyerName has requested an appointment at : </p><p>$date</p><p>$time</p><p>Please re-check appointment date and time before approving</p>";
		

		$this->email->set_newline("\r\n");
		$this->email->from($from, "ElectroTown Support");
		$this->email->to($to);
		$this->email->subject($subject);
		$this->email->message($message);
		if ($this->email->send()) {
			redirect(base_url() . "index.php/Items/Details/".$item[0]['listing_id']);
		} else {
			show_error($this->email->print_debugger());
		}
        
        redirect(base_url() . "index.php/MyAccount");
    }
    public function details($id) {
        $this->load->model('Listings','',TRUE);
        $this->load->model('Users','',TRUE);
        $this->load->model('Appointments','',TRUE);
        
        $appointment = $this->Appointments->appointment_detail($id);
        $item = $this->Listings->show_listing_detail($appointment[0]['listing_id']);
        $sellerInfo = $this->Users->find_user($appointment[0]['seller_id']);
        $buyerInfo = $this->Users->find_user($appointment[0]['buyer_id']);

        $this->TPL['appointment'] = $appointment[0];
        $this->TPL['listing'] = $item[0];
        $this->TPL['seller'] = $sellerInfo[0];
        $this->TPL['buyer'] = $buyerInfo[0];

        $this->template->show("AppointmentDetails", $this->TPL);
    }
    public function approve($id) {
        $this->load->model('Appointments','',TRUE);
        $this->Appointments->approve_appointment($id);
        $this->load->model('Users','',TRUE);
        $appointment = $this->Appointments->appointment_detail($id);
        $sellerInfo = $this->Users->find_user($appointment[0]['seller_id']);
        $buyerInfo = $this->Users->find_user($appointment[0]['buyer_id']);
        $sellerName = $sellerInfo[0]['username'];
        $buyerName = $buyerInfo[0]['username'];
        $buyerMail = $buyerInfo[0]['email'];
        $date = $appointment[0]['appointment_date'];
        $time = $appointment[0]['appointment_time'];
        $this->load->config('email');
		$this->load->library('email');
		
		$from = $this->config->item('smtp_user');
		$to = $buyerMail;
		$subject = "Appointment Approval From $sellerName";
        $message = "<h3>Hello, $buyerName,</h3><p>$sellerName has approved your appointment request at : </p><p>$date</p><p>$time</p>";
		

		$this->email->set_newline("\r\n");
		$this->email->from($from, "ElectroTown Support");
		$this->email->to($to);
		$this->email->subject($subject);
		$this->email->message($message);
		if ($this->email->send()) {
			redirect(base_url() . "index.php/Appointment/Details/$id");
		} else {
			show_error($this->email->print_debugger());
		}
        
    }
    public function cancel($id) {
        $this->load->model('Appointments','',TRUE);
        $this->load->model('Listings','',TRUE);
        $this->load->model('Users','',TRUE);
        $appointment = $this->Appointments->appointment_detail($id);
        $sellerInfo = $this->Users->find_user($appointment[0]['seller_id']);
        $buyerInfo = $this->Users->find_user($appointment[0]['buyer_id']);
        $sellerName = $sellerInfo[0]['username'];
        $sellerMail = $sellerInfo[0]['email'];
        $buyerName = $buyerInfo[0]['username'];
        $buyerMail = $buyerInfo[0]['email'];
        $date = $appointment[0]['appointment_date'];
        $time = $appointment[0]['appointment_time'];
        $item = $this->Listings->show_listing_detail($appointment[0]['listing_id']);
        $this->Appointments->cancel_appointment($id);

        $this->load->config('email');
		$this->load->library('email');
        $from = $this->config->item('smtp_user');
		$to = $sellerMail;
		$subject = "Appointment Cancelled by $buyerName";
        $message = "<h3>Hello, $sellerName,</h3><p>$buyerName has cancelled an appointment at : </p><p>$date</p><p>$time</p>";
		

		$this->email->set_newline("\r\n");
		$this->email->from($from, "ElectroTown Support");
		$this->email->to($to);
		$this->email->subject($subject);
		$this->email->message($message);
		if ($this->email->send()) {
			redirect(base_url() . "index.php/Items/Details/".$item[0]['listing_id']);
		} else {
			show_error($this->email->print_debugger());
		}
        
    }
    public function sold($id) {
        $this->load->model('Appointments','',TRUE);
        $this->load->model('Listings','',TRUE);
        $this->load->model('Transactions','',TRUE);
        $appointment = $this->Appointments->appointment_detail($id);
        $item = $this->Listings->show_listing_detail($appointment[0]['listing_id']);
        $this->Listings->sold($item[0]['listing_id']);
        $this->Transactions->add_transaction($item[0]['listing_id'], $id);
        redirect(base_url() . "index.php/MyAccount");

    }
}