<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Presensi_model extends CI_model {
	
		function __construct(){
		parent::__construct();
		$this->load->library('user_agent');
	}

	public function updatePassword($post){
			
		$data = array(
			'password' => md5($post['password'])
	);

	$id_akun = $this->session->userdata('id_akun');
	$this->db->where('id_akun', $id_akun);
	
	$update = $this->db->update('app_umum.akun_3', $data);

	return $update;
	}

	function listUser() {

		$sql="
			--list user untuk admin
			select * from app_umum.akun_3 a
			order by nama_unit_es3 ,nama_unit_es4 ,id_akun
			";
		$query = $this->db->query($sql);
		$data = $query->result_array();
        return $data;
	}

	function bukaAkses($post) {
		
		
		$this->db->set('akses','1');
		$this->db->where('id_akun', $post['id_akun']);
		
		$buka = $this->db->update('app_umum.akun_3', $data);
	
		return $buka;

	}

	function tutupAkses($post) {
		
		$this->db->set('akses','null',false);
		$this->db->where('id_akun', $post['id_akun']);
		$tutup = $this->db->update('app_umum.akun_3');
	
		return $tutup;

	}

}
