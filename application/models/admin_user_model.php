<?php
	//File products_model.php
	class Pinjam_kendaraan_model extends CI_Model  {
	
	function __construct() { 
		parent::__construct(); 
	} 
	
	function summary() {
		$sql="---new
			select 
				a.id_pinjam ,
				a.tgl_pinjam::timestamp,
				a.ket_pinjam,
				a.id_kendaraan ,b.nama kendaraan,a.pj,
				a.id_akun ,c1.username,d1.nama nm_user,a.tgl_pengajuan::timestamp,a.ip_peminjam ,
				a.status,A.ket_admin ,a.tgl_status ,coalesce (d2.nama,c2.username) nm_admin
			from app_umum.pinjam_kendaraan a
				left join app_umum.kendaraan b on a.id_kendaraan = b.id_kendaraan 
				left join app_umum.akun c1 on a.id_akun::INT = c1.id_akun
				left join dimensi.pegawai d1 on c1.nip9 = d1.nip9
				left join app_umum.akun c2 on a.id_admin::INT  = c2.id_akun
				left join dimensi.pegawai d2 on c2.nip9 = d2.nip9
			where a.status != 'DITOLAK' or a.status is null
			--where a.status = 'DITOLAK'
			";
		$query = $this->db->query($sql);
		$data = $query->result_array();
        return $data;
	}

	function summaryPinjam($id_kendaraan=null) {
		$sql="--get pinjam kendaraan
				select a.* ,
					to_date(a.tgl_mulai_pinjam,'yyyy-mm-dd') tgl_mulai_pinjam,
					to_date(a.tgl_selesai_pinjam,'yyyy-mm-dd') tgl_selesai_pinjam,
					b.merk_type,b.nopol,
					c1.username,c1.nama nama_user,
					c2.nama nama_admin
				from app_umum.pinjam_kendaraan_nd_2 a
					left join dimensi.dim_kendaraan b on a.id_kendaraan = b.id_kendaraan 
					left join app_umum.akun_3 c1 on c1.id_akun = a.id_akun::int
					left join app_umum.akun_3 c2 on c2.id_akun = a.id_admin::int ";
		
		if(isset($id_kendaraan)){
			$sql .=	" where a.id_kendaraan = '$id_kendaraan'";
		}

		$sql .=	" order by to_date(a.tgl_selesai_pinjam,'yyyy-mm-dd') desc, a.id_pinjam desc";
		$query = $this->db->query($sql);
		$data = $query->result_array();
        return $data;
	}

	function summaryPinjamUser() {
		$sql="--get pinjam kendaraan
				select a.* ,
					to_date(a.tgl_mulai_pinjam,'yyyy-mm-dd') tgl_mulai_pinjam,
					to_date(a.tgl_selesai_pinjam,'yyyy-mm-dd') tgl_selesai_pinjam,
					b.merk_type,b.nopol,
					c1.username,c1.nama nama_user,
					c2.nama nama_admin
				from app_umum.pinjam_kendaraan_nd_2 a
					left join dimensi.dim_kendaraan b on a.id_kendaraan = b.id_kendaraan 
					left join app_umum.akun_3 c1 on c1.id_akun = a.id_akun::int
					left join app_umum.akun_3 c2 on c2.id_akun = a.id_admin::int ";

			$sql .=	" where a.id_akun = '".$this->session->userdata('id_akun')."'";

		$sql .=	" order by to_date(a.tgl_selesai_pinjam,'yyyy-mm-dd') desc";
		$query = $this->db->query($sql);
		$data = $query->result_array();
        return $data;
	}

	function listkendaraanPinjam($id_kendaraan=null) {
		$sql="--list kendaraan
			select distinct a.id_kendaraan,b.merk_type,b.nopol 
			from app_umum.pinjam_kendaraan_nd_2 a
				left join dimensi.dim_kendaraan b on a.id_kendaraan = b.id_kendaraan";
		$query = $this->db->query($sql);
		$data = $query->result_array();
        return $data;
	}

	function statusKendaraan() {
		$sql="--get status kendaraan2
			select a.id_kendaraan ::int,
				a.merk_type ,a.nopol,a.lama nopol_lama,a.no_stnk ,a.no_bpkp ,a.no_rangka ,a.no_mesin ,a.thn,a.roda ,a.pemegang ,
				a.si ,a.ket ,a.fg_operasional ,
				b.id_pinjam,b.tgl_mulai_pinjam, b.tgl_selesai_pinjam,b.nomor_nd,b.atas_nama,c1.nm_es3_short nm_es3_peminjam,b.tujuan,
				coalesce(c2.nama ,a.pemegang) pemegang, c1.nama pj_peminjam_terakhir
			from dimensi.dim_kendaraan a
				left join (
					--max nd pinjam2
					select * 
					from (
						select id_pinjam,
							to_date(a.tgl_mulai_pinjam,'yyyy-mm-dd') tgl_mulai_pinjam,
							to_date(a.tgl_selesai_pinjam,'yyyy-mm-dd') tgl_selesai_pinjam,
							nomor_nd,
							tujuan ,
							id_kendaraan,
							atas_nama,id_akun,id_admin,status,
							rank() over (partition by unnest(string_to_array(id_kendaraan,',')) order by to_date(a.tgl_mulai_pinjam,'yyyy-mm-dd') desc) rank
						from app_umum.pinjam_kendaraan_nd_2 a
						where status != 'DITOLAK') a
					where rank = 1
					order by id_kendaraan) b on a.id_kendaraan = b.id_kendaraan
				left join app_umum.akun_3 c1 on c1.id_akun = b.id_akun::int
				left join app_umum.akun_3 c2 on c2.id_akun = a.id_pemegang::int
			--where a.pemegang != 'TURT/KOSONG'
			order by fg_operasional,1
			";
		$query = $this->db->query($sql);
		$data = $query->result_array();
        return $data;
	}

	function last_IDPinjamKendaraan() {
		$sql="--get last id pinjam
			select max(id_pinjam)+1 max from app_umum.pinjam_kendaraan_nd_2 a
			";
		$query = $this->db->query($sql);
		$data = $query->result_array();
        return $data;
	}

	function pinjam_kendaraan($post) {
		
		$data = array(
				'id_pinjam' => $post['id_pinjam'],
				'id_akun' => $post['id_akun'],
				'id_kendaraan' => $post['id_kendaraan'],
				'ip_peminjam' => $post['ip_peminjam'],
				'tgl_mulai_pinjam' => $post['tgl_mulai_pinjam'],
				'tgl_selesai_pinjam' => $post['tgl_selesai_pinjam'],
				'tujuan' => $post['tujuan'],
				'atas_nama' => $post['atas_nama'],
				'nomor_nd' => $post['nomor_nd'],
				'pj' => $post['pj'],
				'tanggal_rekam' => date('Y-m-d H:m:s')
		);
		
		$insert = $this->db->insert('app_umum.pinjam_kendaraan_nd_2', $data);
	
		return $insert;

	}

	function approve_pinjam_kendaraanan($post) {
		
		$data = array(
				'status' => $post['status_admin'],
				'tgl_status' => $post['tgl_status'],
				'id_admin' => $post['id_admin'],
				'ket_admin' => $post['ket_admin']
		);

		$this->db->where('id_pinjam', $post['id_pinjam']);
		
		$insert = $this->db->update('app_umum.pinjam_kendaraan_nd_2', $data);
	
		return $insert;

	}

	function update_pinjam_kendaraanan($post) {
		
		$data = array(
				'nomor_nd' => $post['nomor_nd'],
				'tgl_mulai_pinjam' => $post['tgl_mulai_pinjam'],
				'tgl_selesai_pinjam' => $post['tgl_selesai_pinjam'],
				'tujuan' => $post['tujuan'],
				'atas_nama' => $post['atas_nama'],
				'pj' => $post['pj'],
		);

		$this->db->where('id_pinjam', $post['id_pinjam']);
		
		$insert = $this->db->update('app_umum.pinjam_kendaraan_nd_2', $data);
	
		return $insert;

	}

	function reset_pinjam_kendaraan($post) {
		
		$this->db->set('status','null',false);
		$this->db->set('tgl_status','null',false);
		$this->db->set('id_admin','null',false);
		$this->db->set('ket_admin','null',false);
		$this->db->where('id_pinjam', $post['id_pinjam']);
		
		$insert = $this->db->update('app_umum.pinjam_kendaraan_nd_2', $data);
	
		return $insert;

	}

}