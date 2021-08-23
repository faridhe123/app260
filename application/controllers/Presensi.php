<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include_once(APPPATH.'core/MY_Login.php');

class Presensi extends MY_Login {
	
	function __construct(){
		parent::__construct();
	
		//helper
	}

	public function index(){
		header("Access-Control-Allow-Origin: *");
        $data = array();
        $this->load->view('layouts/header', $data);
        $this->load->view('Presensi/index', $data); 
        $this->load->view('layouts/footer', $data);
		
	}
	public function submit(){

		if(! $this->input->is_ajax_request()) {
			redirect('404');
		}
		
		$long = $_POST["long"];
		$lat = $_POST["lat"];
		
		if(true)echo $long ." - ".$lat;
		else echo "gagal";

	}
	
	public function logout(){
		$this->session->sess_destroy();
		redirect('');
	}
}
