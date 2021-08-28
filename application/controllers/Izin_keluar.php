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

	public function atasan(){
		if(substr($this->session->userdata('jabatan'),0,6) !== 'Kepala' ) {
			redirect('404');
		}		
		header("Access-Control-Allow-Origin: *");
        $data = array();

		$id_es4 = $this->session->userdata('id_es4');
		$data['hasil'] = $this->Izin_keluar_model->getIzinBawahan($id_es4);

        $this->load->view('layouts/header');
        $this->load->view('Izin_keluar/atasan', $data); 
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

	public function editIzin(){
	
		// if(! $this->input->is_ajax_request()) {
		// 	redirect('404');
		// }		
		$data = $_POST;
		
		$this->Izin_keluar_model->update_izin($data);
		
		redirect(base_url('Izin_keluar/'));
	}

	public function konfimasiIzin(){
		if(substr($this->session->userdata('jabatan'),0,6) !== 'Kepala' ) {
			redirect('404');
		}		

		$data = $_POST;
		$data['username_atasan'] = $this->session->userdata('username');
		$data['date_konfirmasi'] = date('Y-m-d H:i:s');
		$data['status'] = 'Dikonfirmasi';
		// echo "<pre>",print_r($data);die();
		$this->Izin_keluar_model->update_izin($data);
		
		redirect(base_url('Izin_keluar/atasan'));
	}
}
