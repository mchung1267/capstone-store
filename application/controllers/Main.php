<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {

	var $TPL;

	public function __construct()
	{
	  parent::__construct();
		error_reporting(0);
	  $this->TPL['active'] = array('main' => true,
	  								'items' => false,
									  'myaccount' => false,
									  'about' => false,
									  'register' => false,
									  'login' => false);
		
	}
	public function index()
	{
		
		$this->template->show('Main',$this->TPL);
		

	}
}
