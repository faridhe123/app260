<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
	
	function __construct(){
		parent::__construct();
		$this->load->library('user_agent');
		$this->load->model('Login_model');
	}

	public function index($sts=null)
	{
		if(isset($sts)){
			$this->session->set_flashdata('sukses','Silahkan login kembali menggunakan password baru');
		}
		$this->load->view('view_login');
		
	}
	public function getlogin()
	{
		$u = $this->input->post('Username');
		$p = $this->input->post('Password');
		
		$post = $this->input->post();
		if(isset($post['redirect_to'])){
			$redirect_to = $this->input->post('redirect_to');
		}else{
			$redirect_to = null;
		}
		
		$login = $this->Login_model->getlogin($u,$p,$redirect_to);

		if($login) redirect($redirect_to);
		else redirect(site_url(''));
		
	}
}
