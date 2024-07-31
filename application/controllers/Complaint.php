<?php
class Complaint extends CI_Controller {
    var $TPL;

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
        if($this->session->userdata('id') == NULL) {
            redirect(base_url() . "index.php/Login");
        } else if($this->session->userdata('access_level') == 3) {
            redirect(base_url() . "index.php/Admin");
        }  
    }
    public function compose($id) {
        $this->load->model('Transactions','',TRUE);
        $this->load->model('Reports','',TRUE);
        $reportCnt = $this->Reports->getReportCntForTransaction($id);
        if($reportCnt[0]['cnt'] > 0) {
            redirect(base_url() . "index.php/Transaction/Details/$id");
        }
        $transaction = $this->Transactions->transaction_detail($id);
        $this->TPL['transactionid'] = $id;
        $this->TPL['transaction'] = $transaction;
        $this->template->show("NewComplaint", $this->TPL);
    }
    public function submit($id) {
        $this->load->model('Reports','',TRUE);
        $this->load->model('Transactions','',TRUE);
        $turn_on = $this->input->post('turn_on');
        $port_work = $this->input->post('port_work');
        $camera_work = $this->input->post('camera_work');
        $battery_work = $this->input->post('battery_work');
        $damage_free = $this->input->post('damage_free'); 
        $content = $this->input->post('content');
        $imei = $this->input->post('imei');
        $battery_capacity = $this->input->post('batery_capacity');
        $transaction = $this->Transactions->transaction_detail($id);
        $listing_id = $transaction[0]['listing_id'];
        $appointment_id = $transaction[0]['appointment_id'];
        $this->Reports->add_report($id, $appointment_id, $listing_id, $turn_on, $port_work, $camera_work, $battery_work, $damage_free, $imei, $battery_capacity, $content);
        redirect(base_url() . "index.php/Transaction/Details/$id");
    }
    public function details($id) {
        $this->load->model('Reports','',TRUE);
        $this->load->model('Listings','',TRUE);
        $this->load->model('Appointments','',TRUE);
        
        $report = $this->Reports->select_report($id);
        $appointment = $this->Appointments->appointment_detail($report[0]['appointment_id']);
        if($this->session->userdata('id') != $appointment[0]['buyer_id'] && $this->session->userdata('id') != $appointment[0]['seller_id'] && $this->session->userdata('access_level') != 2) {
            redirect(base_url() . "index.php/MyAccount");
        }
        $listing = $this->Listings->show_listing_detail($report[0]['listing_id']);
        $this->TPL['appointment'] = $appointment[0];
        $this->TPL['complaint'] = $report[0];
        $this->TPL['listing'] = $listing[0];
        $this->template->show("ComplaintDetails", $this->TPL);
    
    }
    public function dismiss($id) {
        //If user is not a moderator redirect to my account page
        if($this->session->userdata('access_level') != 2) {
            redirect(base_url() . "index.php/MyAccount");
        }
        $this->load->model('Reports','',TRUE);
        $report = $this->Reports->select_report($id);
        $sellerMail = $report[0]['sellermail'];
		$sellerName = $report[0]['sellername'];
		$buyerMail = $report[0]['buyermail'];
		$buyerName = $report[0]['buyername'];
        $this->Reports->dismiss($id);
        $this->load->config('email');
		$this->load->library('email');
		
		$from = $this->config->item('smtp_user');
		$to = $sellerMail;
		$subject = "Complaint filed against you has been dismissed";
		$message = "<h3>Hello, $sellerName,</h3><p>A complaint filed against you by $buyerName has been dismissed by a moderator. You do not need to take any action.</p>";

		$this->email->set_newline("\r\n");
		$this->email->from($from, "ElectroTown Support");
		$this->email->to($to);
		$this->email->subject($subject);
		$this->email->message($message);
		if ($this->email->send()) {
			$from = $this->config->item('smtp_user');
			$to = $buyerMail;
			$subject = "Your complaint has been dismissed";
			$message = "<h3>Hello, $buyerName,</h3><p>Your complaint against $sellerName has been dismissed by a moderator. It may have been dismissed due to insufficient information or under discretion of the moderator.</p>";

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
        $appointment = $this->Appointments->appointment_detail($report[0]['appointment_id']);
        
        redirect(base_url() . "index.php/Complaint/Details/$id");
    }

}
?>