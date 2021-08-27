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
		$data['hasil'] = $this->Izin_keluar_model->getAll($user);

        $this->load->view('layouts/header');
        $this->load->view('Izin_keluar/index', $data); 
        $this->load->view('layouts/footer');
		
	}

	public function submitIzin(){
	
		// if(! $this->input->is_ajax_request()) {
		// 	redirect('404');
		// }		
		$data = $_POST;
		
		$data['id'] = ($this->Izin_keluar_model->getMaxID()??0) + 1;
		$data['username'] = $this->session->userdata('username');
		$data['tanggal'] = date('Y-m-d',strtotime($data['tanggal']));
		
		// echo "<pre>",print_r($data);die();
		// echo json_encode($data);

		$this->Izin_keluar_model->insert_izin($data);
		
		// if($insert) echo "Presensi $jenis Sukses";
		// else echo "gagal";
		redirect(base_url('Izin_keluar/'));
	}
}
