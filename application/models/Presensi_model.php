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

	function getPresensiAdmin($date1=null,$date2=null) {
		$sql="
			select min(date_record::timestamp),max(date_record::timestamp)
			from presensi.log_presensi 
			where date_record::date = current_date::date
			";
		$query = $this->db->query($sql);
		$data = $query->result_array();
		
		if($data[0]['min'] == $data[0]['max']) $data[0]['max'] == null;

		return $data[0];
		
	}

	function getDBCurrentDate() {
		$sql="select current_timestamp ";
		
		return $this->db->query($sql)->result_array()[0]['current_timestamp'];
		
	}

	function getMaxID() {

		$sql="
			-- max ID
			select max(id::int)
			from presensi.log_presensi a
			";
		$query = $this->db->query($sql);
		$data = $query->result_array();
		
		return $data[0]['max'];

	}

	public function submitPresensi($data,$jenis){
		date_default_timezone_set('Asia/Makassar');
		$input = array();
		$input = array(
			'id' => $data['nextID'],
			'username' => $data['username'],
			'long' => $data['long'],
			'lat' => $data['lat'],
			'uid' => $data['uid'],
			'jenis_presensi' => $jenis,
			'date_record' => date('Y-m-d H:i:s')
		);
		// $id_akun = $this->session->userdata('id_akun');
		// $this->db->where('id_akun', $id_akun);
		
		$insert = $this->db->insert('presensi.log_presensi', $input);
		
		return $insert;
	}

}
