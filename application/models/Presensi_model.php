<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Presensi_model extends CI_model {
	
		function __construct(){
		parent::__construct();
	}

	function getUID() {
		
		$query = $this->db->get('data.v_list_uid');
		$data = $query->result_array();

		// echo "<pre>",print_r($data);die();
		return $data;
		
	}

	function deteksiUID() {
		$sql="
		-- 4. Deteksi User Menggunakan UID Lain
			select
				case when a.username = b.username then 'Cocok' else c.nama||' absen '|| a.jenis_presensi ||' menggunakan UID  '||b.user_pemilik end indikasi,
			a.*
			from presensi.log_presensi a
				left join data.v_list_uid b on a.uid  = b.uid
				left join data.v_join_asn_nonasn c on a.username = c.username 
			where a.username != b.username
			order by date_record desc";

		return $this->db->query($sql)->result_array();
	}

	function getPresensi($username) {
		$sql="
			 select 
				MIN(CAST(date_record as DATETIME)) AS min,
				MAX(CAST(date_record as DATETIME)) AS max,
				CURDATE(),date_record,CAST(date_record as DATE)
			from log_presensi 
			where username = '$username'
				and CAST(date_record as DATE) = CURDATE()
			";
		$query = $this->db->query($sql);
		$data = $query->result_array();

//		echo print_r($data);
		
		if($data[0]['min'] == $data[0]['max']) $data[0]['max'] == null;

		return $data[0];
		
	}

	function getPresensiAdmin($date1,$date2,$bulan=null) {
		
		$sql="
			select * 
			from presensi.v_rekap_presensi ";
		if($bulan !== null) $sql .= " where extract('month' from date_record::date) = '".$bulan."'";
		else $sql .= " where date_record::date between ".$date1." and ".$date2."";

		return $this->db->query($sql)->result_array();
		
	}

	function getRekapBulan($date1,$date2,$bulan=null) {

		
		
		$sql="
		-- rekap per SEBULAN
			select b.username, b.nama , ";

		if($bulan !== null){
		$last = DateTime::createFromFormat('!m', $bulan)->format('t');
		for($tgl = 1;$tgl <= $last;$tgl++ ){
			$sql .= "
					string_agg(case when a.date_record = '2021-".str_pad($bulan,2,0,STR_PAD_LEFT)."-".str_pad($tgl,2,0,STR_PAD_LEFT)."' then masuk::text else null end,'') masuk_".str_pad($tgl,2,0,STR_PAD_LEFT).",
					string_agg(case when a.date_record = '2021-".str_pad($bulan,2,0,STR_PAD_LEFT)."-".str_pad($tgl,2,0,STR_PAD_LEFT)."' then pulang::text else null end,'') pulang_".str_pad($tgl,2,0,STR_PAD_LEFT).",
				";
			}
		}else{
			$tanggal = $date1;
			while(strtotime($tanggal) <= strtotime($date2)){
				$sql .= "
						string_agg(case when a.date_record = '".date("Y-m-d",strtotime($tanggal))."' then masuk::text else null end,'') masuk_".str_pad(date("m",strtotime($tanggal)),2,0,STR_PAD_LEFT).str_pad(date("d",strtotime($tanggal)),2,0,STR_PAD_LEFT).",
						string_agg(case when a.date_record = '".date("Y-m-d",strtotime($tanggal))."' then pulang::text else null end,'') pulang_".str_pad(date("m",strtotime($tanggal)),2,0,STR_PAD_LEFT).str_pad(date("d",strtotime($tanggal)),2,0,STR_PAD_LEFT).",
					";

				$tanggal = date('Y-m-d',strtotime($tanggal. " +1 day"));
			}
		}

		$sql .= "'end' selesai
				from presensi.v_rekap_presensi a
					full join data.akun b on a.username = b.username";
					
		if($bulan !== null) $sql .= " where extract('month' from date_record::date) = '".$bulan."'";
		else $sql .= " where date_record::date between '".$date1."' and '".$date2."'";

		$sql .=" or a.username is null
				group by b.username , b.nama
				order by 3";
		$result = $this->db->query($sql)->result_array();
		// echo "<pre>", print_r($result);die();
		// echo "<pre>", print_r($sql);die();

		return $result;
	}

	function getDBCurrentDate() {
		$sql="select current_timestamp ";
		
		return $this->db->query($sql)->result_array()[0]['current_timestamp'];
		
	}

	function getMaxID() {

		$sql="
			-- max ID
			select max(CAST(id AS DECIMAL)) AS max
			from log_presensi a
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
		
		$insert = $this->db->insert('log_presensi', $input);
		
		return $insert;
	}

}
