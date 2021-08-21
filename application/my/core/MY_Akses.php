<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
include_once(APPPATH.'core/MY_Login.php');

class MY_Akses extends MY_Login {

 function __construct()
    {
		parent::__construct();
		if (!isset($_SERVER['HTTP_REFERER']) or $_SERVER['REQUEST_URI'] !== 'http://10.15.15.201/rumah_data/login'){
			$redirect_to = $_SERVER['REQUEST_URI'];
		}else{
			$redirect_to = $_SERVER['HTTP_REFERER'];
		}

        if ( null == $this->session->userdata('akses')){ 
			redirect('akses?redirect_to='.urlencode($redirect_to));
        }elseif( null == $this->session->userdata('ganti_pass')){
			redirect('akses/ubah_password?redirect_to='.urlencode($redirect_to));
		}
    }
}


?>