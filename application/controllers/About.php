<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class About extends CI_Controller {

	var $TPL;

	public function __construct()
	{
	  parent::__construct();
	  error_reporting(0);
	  $this->TPL['active'] = array('main' => false,
	  								'items' => false,
									  'myaccount' => false,
									  'about' => true,
									  'register' => false,
									  'login' => false);

	}
	public function index()
	{
		$this->template->show('About',$this->TPL);
	}
}
