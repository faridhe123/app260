<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_register extends CI_model {
	
		function __construct(){
		parent::__construct();
		$this->load->library('user_agent');
	}

	public function getID(){
		$sql = 'SELECT max(id_akun) from wise.akun a';
		return $this->db->query($sql)->result_array()[0]['max'];
	}

	public function cekUser($post){
		$sql = "SELECT username from wise.akun a
			where username = '" . $post['Username'] . "'";
		return $this->db->query($sql)->result_array()[0]['username'];
	}

	public function buatAkun($post){
		$data = array(
			'id_akun' => $post['id'],
			'nama' => $post['Nama'],
			'nik' => $post['NIK'],
			'alamat' => $post['Alamat'],
			'email' => $post['Email'],
			'telepon' => $post['NoTelp'],
			'username' => $post['Username'],
			'password' => md5($post['Password']),
			'date_record' => date('Y-m-d H:i:s')
		);

		return $this->db->insert('wise.akun',$data);

	}

}

