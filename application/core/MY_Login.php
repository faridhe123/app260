<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Login extends CI_Controller {

 function __construct()
    {
        parent::__construct();
        if ( ! $this->session->userdata('username'))
        { 
			//if(isset($_SERVER['HTTP_REFERER']) and $_SERVER['HTTP_REFERER'] !=='http://10.15.15.201/rumah_data/index.php/login/getlogin'){
			//	$this->session->set_userdata(array('referer'=>$_SERVER['HTTP_REFERER']));
			//}
			//elseif(current_url() !== 'http://10.15.15.201/rumah_data/index.php/login/getlogin'){
			//	$this->session->set_userdata(array('referer'=>current_url()));
			//}
			//else{
			//	$this->session->set_userdata(array('referer'=>'home'));
			//}
			$user_ip = $this->input->ip_address();
			
			$this->load->library('user_agent');
			
			if (!isset($_SERVER['HTTP_REFERER']) or $_SERVER['REQUEST_URI'] !== 'http://10.15.15.201/rumah_data/login')
			{
				$redirect_to = $_SERVER['REQUEST_URI'];
			}else{
				$redirect_to = $_SERVER['HTTP_REFERER'];
			}
			
			//echo $redirect_to ;die();
			//echo $_SERVER['REMOTE_ADDR'];die();
			 if(!in_array($_SERVER['REMOTE_ADDR'], array('10.15.254.75','192.168.43.177')) or true){
			 	//redirect('login');
			 	redirect('login?redirect_to='.urlencode($redirect_to));
			 	if (!isset($_SERVER['HTTP_REFERER']) or $_SERVER['REQUEST_URI'] !== 'http://10.15.15.201/rumah_data/login')
			 	{
			 		redirect('login?redirect_to='.urlencode($redirect_to));
			 	}else{
			 		redirect('login');
			 	}
			 }
        }
    }
}


?>