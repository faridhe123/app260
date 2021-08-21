<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include_once(APPPATH.'core/MY_Login.php');

class Akses extends MY_Login {
	
	function __construct(){
		parent::__construct();
		$this->load->library('user_agent');
		$this->load->model("Model_akses","akses");
	}

	public function index()
	{
		$this->load->view('view_akses');
	}
	
	public function admin(){
		
		if($this->session->userdata('role') !== 'admin'){
			redirect('akses');
		}


		header("Access-Control-Allow-Origin: *");
		$data = array();
		
		$data['user'] = $this->akses->listUser();
		$data['title'] = 'Panel Administrator Akses Halaman Terbatas';
		
		//echo "<pre>", print_r($post) , "</pre>";die();

        $this->template->set('title',  $data['title']);
		$this->template->load('default_layout', 'contents' , 'akses/admin', $data);
	}

	public function tutup(){
		header("Access-Control-Allow-Origin: *");
       
		$post = $this->input->post();
		//echo "<pre>", print_r($post) , "</pre>";die();
		$tutup = $this->akses->tutupAkses($post);

		if($tutup){
			redirect("akses/admin?tutupSUCC=1");
		}else{
			redirect("akses/admin?tutupERR=1");
		}
	}

	public function buka(){
		header("Access-Control-Allow-Origin: *");
       
		$post = $this->input->post();
		//echo "<pre>", print_r($post) , "</pre>";die();
		$buka = $this->akses->bukaAkses($post);

		if($buka){
			redirect("akses/admin?bukaSUCC=1");
		}else{
			redirect("akses/admin?bukaERR=1");
		}
	}

	public function ubah_password()
	{
		$this->load->view('ubah_password_akses');
	}

	public function update_password()
	{
		$post = $this->input->post();
		//echo "<pre>" , print_r($post ) , "</pre>";die();

		if($post['password'] !== $post['password_c'] ){
			$this->session->set_flashdata('info','Konfirmasi password tidak sesuai!');
			redirect('akses/ubah_password?redirect_to='.urlencode($post['redirect_to']));
		}elseif(strlen($post['password']) < 6){
			$this->session->set_flashdata('info','Jumlah karakter kurang dari 6!');
			redirect('akses/ubah_password?redirect_to='.urlencode($post['redirect_to']));
		}
		//elseif($post['password'] == $this->session->userdata('username')){
		//	$this->session->set_flashdata('info','Password tidak boleh sama dengan username!');
		//	redirect('akses/ubah_password?redirect_to='.urlencode($post['redirect_to']));
		//}

		$gantiPassword = $this->akses->updatePassword($post);

		if($gantiPassword){
			$this->session->sess_destroy();
			//echo $this->session->flashdata('sukses');die();
			redirect('login/index/1?redirect_to='.urlencode($post['redirect_to']));
		}else{
			$this->session->set_flashdata('info','Terjadi Kesalahan, hubungi administrator untuk informasi lebih lanjut');
			redirect('akses/ubah_password?redirect_to='.urlencode($post['redirect_to']));
		}


	}
}
