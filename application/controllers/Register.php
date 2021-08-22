<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends CI_Controller {
	
	function __construct(){
		parent::__construct();
		$this->load->library('user_agent');

		$this->load->model("Model_register","register");
	}

	public function index(){
		header("Access-Control-Allow-Origin: *");
        $data = array();
        $this->template->set('title', 'Dashboard');
        $this->load->view('layoutsLTE/header', $data);
        $this->load->view('register', $data);
        $this->load->view('layoutsLTE/footer', $data);
		
	}

	public function submit(){
		$post = $this->input->post();
		// echo "<pre>",print_r($post);die();
		$post['id'] = ($this->register->getID()??0)+1 ;

		$cekUser = $this->register->cekUser($post);
		if($cekUser){
			redirect("register?stsERR=1");
		}

		$input = $this->register->buatAkun($post);

		if($input){
			redirect("home?stsSUCC=1");
		}else{
			redirect("home?stsERR=1");
		}
	}


}
