<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include_once(APPPATH.'core/MY_Login.php');

class Pengaduan extends MY_Login {
	function __construct(){
		parent::__construct();

		//helper
		$this->load->helper('math_helper');
		$this->load->helper('format_helper');
		$this->load->helper('bulan_helper');

		//model
		$this->load->model("Pengaduan_model","pengaduan");
	}
	
	
	public function index(){
		header("Access-Control-Allow-Origin: *");
		
		$data['title'] = 'Saluran Whistle Blower Kanwil DJP Sulselbartra';
		$data['hasil'] = $this->pengaduan->get_all();
		// echo "<pre>", print_r($data['hasil']) , "</pre>";die();
		
        $this->template->set('title',  $data['title']);

		$this->load->view( 'LayoutsLTE/header', $data);
		$this->load->view('pengaduan/index', $data);
		$this->load->view( 'LayoutsLTE/footer', $data);
		//$this->load->view('pinjam_ruang/calendar con', $data);
	}

	public function baru(){
		header("Access-Control-Allow-Origin: *");
		
		//echo "<pre>", print_r($data['hasil']) , "</pre>";die();
		

		$this->load->view( 'LayoutsLTE/header');
		$this->load->view('pengaduan/new');
		$this->load->view( 'LayoutsLTE/footer');
		//$this->load->view('pinjam_ruang/calendar con', $data);
	}
	
	public function input(){
		
		$post = $this->input->post();
        $last_id = $this->pengaduan->getLastID();

		
		for($x = 0; $x< count($post['nama']) ;$x++){
			$post['terlapor'][$x]['nama'] = $post['nama'][$x]!==''?$post['nama'][$x]:'Anonym';
			$post['terlapor'][$x]['nip'] = $post['nip'][$x]!==''?$post['nip'][$x]:'Anonym';
			$post['terlapor'][$x]['unit'] = $post['unit'][$x]!==''?$post['unit'][$x]:'Anonym';
			$post['terlapor'][$x]['jabatan'] = $post['jabatan'][$x]!==''?$post['jabatan'][$x]:'Anonym';
		};

		$post['terlapor'] = json_encode($post['terlapor']);

		
		$id = ($last_id[0]['max']?? 0)+1;
		$post['id_pengaduan'] = $id;
		
		//PROSES FILE
		if (!is_dir('assets/uploads/pengaduan/'.$id)) {
			mkdir('assets/uploads/pengaduan/'.$id, 0777, TRUE);
		}
		
		if (!is_dir('assets/uploads/pengaduan/'.$id)) {
			mkdir('assets/uploads/pengaduan/'.$id, 0777, TRUE);
		}
		$path = 'assets/uploads/pengaduan/'.$id.'/';
		if($_FILES['lampiran']["name"][0] != "") {
			$gambar = $this->pengaduan->upload_lampiran($_FILES["lampiran"],$path);
			if($gambar == false) {
				echo "error";
			}
			
			$post['lampiran'] = json_encode($gambar);
		}
		// echo "<pre>", print_r($post) , "</pre>";die();
		$input = $this->pengaduan->input_pengaduan($post);
		
		if($input){
			redirect("pengaduan?stsSUCC=1");
		}else{
			redirect("pengaduan?stsERR=1");
		}
		
	}

}