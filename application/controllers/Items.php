<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Items extends CI_Controller {

	var $TPL;

	public function __construct()
	{
	  parent::__construct();
	  error_reporting(0);
	  $this->load->helper('directory');
	  $this->load->model('Listings','',TRUE);
	  $this->TPL['active'] = array('main' => true,
	  								'items' => false,
									  'myaccount' => false,
									  'about' => false,
									  'register' => false,
									  'login' => false);
		
	}
	public function index()
	{	
		$config = array();
		$itemlist = $this->Listings->show_approved_listing($this->session->userdata('id'));
		$this->TPL['items'] = $itemlist;
		if (!is_dir('/var/www/capstone/application/uploads/3')) {
			mkdir('/var/www/capstone/application/uploads/3', 0777, TRUE);
		
		}
		$this->template->show('Items',$this->TPL);
		

	}
	public function details($id) {
		$this->load->model('Listings','',TRUE);
		$this->load->model('Users','',TRUE);
		$this->load->model('Appointments','',TRUE);
		
		$item = $this->Listings->show_listing_detail($id);
		if($this->session->userdata('id') != NULL) {
			$apptInfo = $this->Appointments->getItemAppt($id);
			$isMyAppt = $this->Appointments->getApptCnt($id);
			$this->TPL['apptCnt'] = $isMyAppt[0]['cnt'];
			$this->TPL['myAppt'] = $apptInfo;
		}
		
		$userinfo = $this->Users->find_user($item[0]["user_id"]);
		
		$this->TPL['user'] = $userinfo;
		$this->TPL['detail'] = $item;
		
		$this->template->show('Details',$this->TPL);
	}
	public function new() {
		switch($this->session->userdata('access_level')) {
			case 1:
				$this->TPL['status'] = '';
				$this->template->show('NewListing',$this->TPL);
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
	public function delete($id) {
		if($this->session->userdata('id') == NULL) {
			redirect(base_url() . "index.php/Login");
		} else if($this->session->userdata('access_level') != 1) {
			redirect(base_url() . "index.php/MyAccount");
		}
		$this->load->model('Listings','',TRUE);
		$this->load->model('Users','',TRUE);
		$this->load->config('email');
		$this->load->library('email');
		
		$item = $this->Listings->show_listing_detail($id);
		$userinfo = $this->Users->find_user($item[0]["user_id"]);
		$username = $userinfo[0]['username'];
		$userMail = $userinfo[0]['email'];

		

		if($userinfo[0]['user_id'] == $this->session->userdata('id')) {
			$this->load->helper("file");
			$this->Listings->delete($id);
			delete_files("/var/www/capstone/application/uploads/$id", true);
			rmdir("/var/www/capstone/application/uploads/$id");
			$from = $this->config->item('smtp_user');
			$to = $userMail;
			$subject = "You have cancelled the listing for ".$item[0]['product_name'];
			$message = "<h3>Hello, $username,</h3><p>You have deleted a listing for " . $item[0]['product_name'] . ". You may also relist the item again by filling in form again.";
			$this->email->set_newline("\r\n");
			$this->email->from($from, "ElectroTown Support");
			$this->email->to($to);
			$this->email->subject($subject);
			$this->email->message($message);
			
			if ($this->email->send()) {
				redirect(site_url("MyAccount"));
			} else {
				show_error($this->email->print_debugger());
			}
			
		} else {
			redirect(site_url("MyAccount"));
		}
	}
	public function revise($id) {
		$this->load->model('Listings','',TRUE);
		$listingInfo = $this->Listings->show_listing_detail($id)[0];
		if($this->session->userdata('id') == NULL) {
			redirect(base_url() . "index.php/Login");
		} else if($this->session->userdata('access_level') != 1) {
			redirect(base_url() . "index.php/MyAccount");
		} else if($this->session->userdata('id') != $listingInfo['user_id']) {
			redirect(base_url() . "index.php/MyAccount");
		}
		$this->TPL['listing'] = $listingInfo;
		$this->template->show("ReviseListing", $this->TPL);
		
	}
	public function update($id) {
		$this->load->model('Listings','',TRUE);
		$listingInfo = $this->Listings->show_listing_detail($id)[0];
		if($this->session->userdata('id') == NULL) {
			redirect(base_url() . "index.php/Login");
		} else if($this->session->userdata('access_level') != 1) {
			redirect(base_url() . "index.php/MyAccount");
		} else if($this->session->userdata('id') != $listingInfo['user_id']) {
			redirect(base_url() . "index.php/MyAccount");
		}
		$brand = $this->input->post("brand");
		$name = $this->input->post("product_name");
		$processor = $this->input->post("processor");
		$storage = $this->input->post("storage");
		$ramsize = $this->input->post("ramsize");
		$imei = $this->input->post("imei");
		$price = $this->input->post("price");
		$description = $this->input->post("description");
		$category = $this->input->post("category");
		$this->Listings->revise_listing($id, $name, $category, $price, $description, $imei, $brand, $storage, $processor, $ramsize);
		redirect(base_url() . "index.php/MyAccount");
	} 
	public function add() {
		if($this->session->userdata('id') == NULL) {
			redirect(base_url() . "index.php/Login");
		} else if($this->session->userdata('access_level') != 1) {
			redirect(base_url() . "index.php/MyAccount");
		}
		$brand = $this->input->post("brand");
		$name = $this->input->post("product_name");
		$processor = $this->input->post("processor");
		$storage = $this->input->post("storage");
		$ramsize = $this->input->post("ramsize");
		$imei = $this->input->post("imei");
		$price = $this->input->post("price");
		$description = $this->input->post("description");
		$category = $this->input->post("category");
		$seller = $this->session->userdata('id');
		$today = strtotime("Today");
		$ending = strtotime("+1 month", $today);
		$enddate = date("Y-m-d", $ending);



		$this->load->model('Listings','',TRUE);
		
		if($category == "Phone" && ( $imei == NULL || !is_numeric($imei) || strlen($imei) != 15)) {
			$this->TPL['status'] = 'IMEI is Required or not valid';
			$this->template->show("NewListing", $this->TPL);
		} else {
			$this->Listings->add_listing($name, $category, $seller, $price, $description, $imei, $brand, $storage, $processor, $ramsize, $enddate);
			$max = $this->Listings->get_latest()[0]['maximum'];
			if (!is_dir("/var/www/capstone/application/uploads/$max")) {
				mkdir("/var/www/capstone/application/uploads/$max", 0777, TRUE);
				$config['upload_path']          = "/var/www/capstone/application/uploads/$max";
                $config['allowed_types']        = 'gif|jpg|png|jpeg';
                $config['file_name']            = "device";
				$picList = array("frontPic", "backPic", "topPic", "bottomPic", "rightPic", "leftPic", "turnedOn");
				$this->load->library('upload', $config);
				foreach($picList as $pic) {
					if ( ! $this->upload->do_upload($pic))
					{
							$error = array('error' => $this->upload->display_errors());

					}
					else
					{
							$data = array('upload_data' => $this->upload->data());

					}
				}
				redirect(base_url() . "index.php/MyAccount");
				
				

			}
		}		
	}
}
