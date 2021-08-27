<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Izin_keluar_model extends CI_model {
	
		function __construct(){
		parent::__construct();
	}

	function getAll($username) {
		
		$query = $this->db->get_where('izin_keluar.log_izin', array('username' => $username));
		$data = $query->result_array();
		return $data;
		
	}

	function getMaxID() {

		$sql="
			-- max ID
			select max(id)
			from izin_keluar.log_izin
			";
		$query = $this->db->query($sql);
		$data = $query->result_array();
		
		return $data[0]['max'];

	}

	public function insert_izin($data){
		date_default_timezone_set('Asia/Makassar');
		$data['date_record'] = date('Y-m-d H:i:s');
		$insert = $this->db->insert('izin_keluar.log_izin', $data);
		
		return $insert;
	}

}
