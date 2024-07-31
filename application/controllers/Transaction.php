<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transaction extends CI_Controller {

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
		if($this->session->userdata('id') == NULL || $this->session->userdata('access_level') != 1) {
			redirect(base_url() . "index.php/Login");
		}
	}
	public function index()
	{
		redirect(base_url() . "index.php/MyAccount");
	}
    public function details($id) {
        $this->load->model('Transactions','',TRUE);
		$this->load->model('Reports','',TRUE);
        $reportCnt = $this->Reports->getReportCntForTransaction($id);
        $transaction = $this->Transactions->transaction_detail($id);
        $this->TPL['transaction'] = $transaction;
		$this->TPL['reportCnt'] = $reportCnt[0]['cnt'];
        $this->template->show('TransactionDetail',$this->TPL);
    }
}
?>