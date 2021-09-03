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

	function getPresensiAdmin($date1,$date2) {
		
		$sql="
			--getPresensiREKAP
			select date_record::date,b.username,
				b.nama,
				min(date_record)::timestamp::time masuk,
				case when max(date_record)=min(date_record) then null 
					else max(date_record) end::timestamp::time pulang,
				count(distinct uid ) jumlah_uid,
				string_agg(distinct uid,'/') list_uid
			from presensi.log_presensi a
				left join data.akun b on a.username = b.username
			where date_record::date between '".$date1."' and '".$date2."'
			group by 1,2,3
			order by 1,3
			";
		return $this->db->query($sql)->result_array();
		
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
			'user_agent' => $data['user_agent'],
			'plugins_length' => $data['plugins_length'],
			'screen_height' => $data['screen_height'],
			'screen_width' => $data['screen_width'],
			'pixel_depth' => $data['pixel_depth'],
			'jenis_presensi' => $jenis,
			'date_record' => date('Y-m-d H:i:s')
		);

		// echo json_encode($input);die();
		// $id_akun = $this->session->userdata('id_akun');
		// $this->db->where('id_akun', $id_akun);
		
		$insert = $this->db->insert('presensi.log_presensi', $input);
		
		return $insert;
	}

}
