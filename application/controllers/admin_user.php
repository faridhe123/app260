<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include_once(APPPATH.'core/MY_Login.php');

class Pinjam_kendaraan extends MY_Login {
	function __construct(){
		parent::__construct();

		//helper
		$this->load->helper('math_helper');
		$this->load->helper('format_helper');
		$this->load->helper('bulan_helper');

		//model
		$this->load->model("Pinjam_kendaraan_model","pinjam_kendaraan");
	}
	
	public function index(){
		header("Access-Control-Allow-Origin: *");
        $data = array();
		$data['hasil'] = $this->pinjam_kendaraan->statusKendaraan();
        $data['title'] = 'Atur Akses User';
		 //echo "<pre>", print_r($post) , "</pre>";die();
		$data['last_id'] = $this->pinjam_kendaraan->last_IDPinjamKendaraan()[0]['max'];
		 
        $this->template->set('title',  $data['title']);
        $this->template->set('breadcrumbs1', '<a href="'.base_url("calendar/").'">Calendar</a>');
		$this->template->load('default_layout', 'contents' , 'pinjam_kendaraan/index', $data);
		//$this->load->view('pinjam_kendaraan/calendar con', $data);
	}	

}