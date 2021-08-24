<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Presensi_model extends CI_model {
	
		function __construct(){
		parent::__construct();
	}

	function getPresensi($username) {
		$sql="
			select min(date_record::timestamp),max(date_record::timestamp)
			from presensi.log_presensi 
			where username = '$username'
				and date_record::date = current_date::date
			";
		$query = $this->db->query($sql);
		$data = $query->result_array();
		
		if($data[0]['min'] == $data[0]['max']) $data[0]['max'] == null;

		return $data[0];
		
	}

	function getMaxID($data) {

		$sql="
			-- max ID
			select max(id)
			from presensi.log_presensi a
			where username = '817933289'
			";
		$query = $this->db->query($sql);
		$data = $query->result_array();
		
		return $data[0]['max'];

	}

	public function submitPresensi($data,$jenis){
		
		$input = array();
		$input = array(
			'id' => $data['nextID'],
			'username' => $data['username'],
			'long' => $data['long'],
			'lat' => $data['lat'],
			'jenis_presensi' => $jenis,
			'date_record' => date('Y-m-d H:i:s')
		);
		// $id_akun = $this->session->userdata('id_akun');
		// $this->db->where('id_akun', $id_akun);
		
		$insert = $this->db->insert('presensi.log_presensi', $input);
		
		return $insert;
	}

}
