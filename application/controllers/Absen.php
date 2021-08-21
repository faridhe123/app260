<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include_once(APPPATH.'core/MY_Login.php');

class Absen extends CI_Controller {
	
	function __construct(){
		parent::__construct();
	
		//helper
	}

	public function index(){
		header("Access-Control-Allow-Origin: *");
        $data = array();
        $this->load->view('layouts/header', $data);
        $this->load->view('absen/index', $data);
        $this->load->view('layouts/footer', $data);
		
	}
	
	public function logout(){
		$this->session->sess_destroy();
		redirect('');
	}
}
