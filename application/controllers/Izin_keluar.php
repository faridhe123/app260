<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include_once(APPPATH.'core/MY_Login.php');

class Izin_keluar extends MY_Login {
	
	function __construct(){
		parent::__construct();
	
		//helper
		$this->load->model('Izin_keluar_model');
	}

	public function index(){
		header("Access-Control-Allow-Origin: *");
        $data = array();

		$user = $this->session->userdata('username');


        $this->load->view('layouts/header');
        $this->load->view('Izin_keluar/index', $data); 
        $this->load->view('layouts/footer');
		
	}
}
