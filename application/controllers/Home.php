<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include_once(APPPATH.'core/MY_Login.php');

class Home extends CI_Controller {
	
	function __construct(){
		parent::__construct();
	
		//helper
	}

	public function index(){
		header("Access-Control-Allow-Origin: *");
        $data = array();
        // $this->template->set('title', 'Dashboard');
        $this->load->view('layouts/header', $data);
        $this->load->view('home', $data);
        $this->load->view('layouts/footer', $data);
		
	}
	
	public function logout(){
		$this->session->sess_destroy();
		redirect('');
	}
}
