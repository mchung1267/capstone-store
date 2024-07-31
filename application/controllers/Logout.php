<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logout extends CI_Controller {

	var $TPL;

	public function __construct()
	{
	  parent::__construct();  
	  error_reporting(0);
      $this->session->unset_userdata('id');  
	  $this->session->unset_userdata('access_level');  
	  $this->session->unset_userdata('first_name');  
	  $this->session->unset_userdata('last_name');  
	}
	public function index()
	{
		redirect(base_url() . "index.php/Main");
	}
}