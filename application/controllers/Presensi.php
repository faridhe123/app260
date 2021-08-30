<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include_once(APPPATH.'core/MY_Login.php');

class Presensi extends MY_Login {
	
	function __construct(){
		parent::__construct();
	
		//helper
		$this->load->model('Presensi_model');
	}

	public function index(){
		header("Access-Control-Allow-Origin: *");
        $data = array();

		$data['DBCurrentDate'] = $this->Presensi_model->getDBCurrentDate();
		$user = $this->session->userdata('username');
		$data['hasil'] = $this->Presensi_model->getPresensi($user);


        $this->load->view('layouts/header');
        $this->load->view('Presensi/index', $data); 
        $this->load->view('layouts/footer');
		
	}

	public function admin(){
		if($this->session->userdata('role') !== 'admin_turt' && $this->session->userdata('role') !== 'admin') redirect('404');

		header("Access-Control-Allow-Origin: *");
        $data = array();

		$data['hasil'] = $this->Presensi_model->getPresensiAdmin();


        $this->load->view('layouts/header');
        $this->load->view('Presensi/admin', $data); 
        $this->load->view('layouts/footer');
		
	}

	public function sukses(){
		header("Access-Control-Allow-Origin: *");
        $data = array();

		$user = $this->session->userdata('username');

        $this->load->view('layouts/header');
        $this->load->view('Presensi/sukses', $data); 
        $this->load->view('layouts/footer');
	}

	public function submit(){
	
		if(! $this->input->is_ajax_request()) {
			redirect('404');
		}

		$data = array();
		$data['long'] = $_POST["long"];
		$data['lat'] = $_POST["lat"];
		$data['username'] = $_POST["username"];
    
		$data['nextID'] = ($this->Presensi_model->getMaxID()??0) + 1;
    
		$presensi = $this->Presensi_model->getPresensi($data['username']);
		
		if($presensi['min'] !== null) $jenis =  'PULANG';
		else $jenis = 'MASUK';

		$submit = $this->Presensi_model->submitPresensi($data,$jenis);
		
		if($submit) echo "Presensi $jenis Sukses";
		else echo "gagal";
	}
	
}
