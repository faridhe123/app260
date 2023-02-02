<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include_once(APPPATH.'core/MY_Login.php');


use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
;

class Presensi extends MY_Login {
	
	function __construct(){
		parent::__construct();
	
		//helper
		$this->load->model('Presensi_model');
	}

	public function index(){
		if($this->session->userdata('jenis_akun') !== 'NON ASN'
			&& $this->session->userdata('role') !== 'admin_turt' && $this->session->userdata('role') !== 'admin'
			) redirect(site_url().'home');
		header("Access-Control-Allow-Origin: *");
        $data = array();

		$data['DBCurrentDate'] = $this->Presensi_model->getDBCurrentDate();
		$user = $this->session->userdata('username');
		$data['hasil'] = $this->Presensi_model->getPresensi($user);


        $this->load->view('layouts/header');
        $this->load->view('Presensi/index', $data); 
        $this->load->view('layouts/footer');
	}

	public function uid(){
		if($this->session->userdata('jenis_akun') !== 'NON ASN'
			&& $this->session->userdata('role') !== 'admin_turt' && $this->session->userdata('role') !== 'admin'
			) redirect(site_url().'home');
		header("Access-Control-Allow-Origin: *");
        $data = array();

		$data['hasil'] = $this->Presensi_model->getUID();
		$data['notifikasi'] = $this->Presensi_model->deteksiUID();
		// echo "<pre>",print_r($data['notifikasi']);die();

        $this->load->view('layouts/header');
        $this->load->view('Presensi/uid', $data); 
        $this->load->view('layouts/footer');
	}

	public function admin($bulan=null){
		// header("Access-Control-Allow-Origin: *");
		// if($this->session->userdata('role') !== 'admin_turt' && $this->session->userdata('role') !== 'admin') redirect('404');

        $data = array();
		
		$data['dari'] = $_POST['dari'] ?? date("Y-m-d");
		$data['sampai'] = $_POST['sampai'] ?? date("Y-m-d");

		$data['hasil'] = $this->Presensi_model->getPresensiAdmin($data['dari'], $data['sampai'], $bulan);
		
		// echo "<pre>",print_r($data['hasil']);die();

        $this->load->view('layouts/header');
        $this->load->view('Presensi/admin', $data); 
        $this->load->view('layouts/footer');
	}

	public function sukses(){
		header("Access-Control-Allow-Origin: *");
        $data = array();

		$user = $this->session->userdata('username');

        $this->load->view('layouts/header');
        $this->load->view('Presensi/sukses', $data); 
        $this->load->view('layouts/footer');
	}

	public function submit(){
	
		if(! $this->input->is_ajax_request()) {
			redirect('404');
		}

		$data = array();
		$data['long'] = $_POST["long"];
		$data['lat'] = $_POST["lat"];
		$data['username'] = $_POST["username"];
		$data['uid'] = $_POST["uid"];
		# detil UID
		$data['user_agent'] = $_POST["user_agent"];
		$data['plugins_length'] = $_POST["plugins_length"];
		$data['screen_height'] = $_POST["screen_height"];
		$data['screen_width'] = $_POST["screen_width"];
		$data['pixel_depth'] = $_POST["pixel_depth"];


		$data['nextID'] = ($this->Presensi_model->getMaxID()??0) + 1;

		$presensi = $this->Presensi_model->getPresensi($data['username']);

//		echo json_encode($presensi);die();
		if($presensi['min'] !== null) $jenis =  'PULANG';
		else $jenis = 'MASUK';

		$submit = $this->Presensi_model->submitPresensi($data,$jenis);

		if($submit) echo "Presensi $jenis Sukses";
		else echo "gagal";
	}
	
	public function getExcelRekap($bulan=null)
	{
		if($this->session->userdata('role') !== 'admin_turt' && $this->session->userdata('role') !== 'admin') redirect('404');

		date_default_timezone_set('Asia/Makassar');
		// echo date('Y-m-d H:i:s');
		$fmt = new \IntlDateFormatter('id_ID', NULL, NULL);
		$fmt->setPattern('cccc, d MMMM yyyy');  
		$month = new \IntlDateFormatter('id_ID', NULL, NULL);
		$month->setPattern('MMMM');  
		
		if($this->session->userdata('role') !== 'admin_turt' && $this->session->userdata('role') !== 'admin') redirect('404');
		
		$post = $this->input->post();
		if($bulan == null){
			$dari = $post['dari'];$sampai = $post['sampai'];
		}else{
			$dari = null;$sampai = null;
		}
		$array_hasil = $this->Presensi_model->getPresensiAdmin($dari,$sampai,$bulan);
		$array_hasil_2 = $this->Presensi_model->getRekapBulan($dari,$sampai,$bulan);
		// echo "<pre>",print_r($array_hasil_2);die();
		


		$templateFile = 'assets/files/rekap.xlsx';

		try {
			$objPHPExcel = IOFactory::load($templateFile);
		} catch(Exception $e) {
			die('Error loading file "'.pathinfo($templateFile,PATHINFO_BASENAME).'": '.$e->getMessage());
		}

		// Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
		$style_table_isi = array(
			'alignment' => array(
			  'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER, // Set text jadi di tengah secara vertical (middle)
			  'wrap' => true // wrap
			),
			'borders' => array(
			  'allBorders' => array(
					'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
					'color' => ['argb' => '000000'],
				  )
			 )
		  );
		  
		# UNTUK SHEET 1 : LOG
		$sheet = $objPHPExcel->getSheet(0);
		$highestRow = $sheet->getHighestRow(); // e.g. 10
		$highestColumn = $sheet->getHighestColumn(); // e.g 'F'
		$highestColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn);

		// Keterangan Masa
		if($bulan == null ) $sheet->getCellByColumnAndRow('2', '3')->setValue('Dari '.$fmt->format(new \DateTime($dari)).' sampai '.$fmt->format(new \DateTime($sampai)));
		else $sheet->getCellByColumnAndRow('2', '3')->setValue("Bulan : ".$month->format(new \DateTime('2021-'.$bulan.'-09')));
		


		$row = 7;
		$index = 1;

		# Muali input
		foreach ($array_hasil as $rows)  {
			$sheet->getCellByColumnAndRow('1', $row)->setValue($index++);
			$col = 2;

			if(trim($rows['date_record']) !== '') $rows[''] = \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel(strtotime($rows['date_record'])); 
			// if(trim($cell) !== '') $cell = date("Y/m/d",strtotime($cell)); 
			$sheet->getCellByColumnAndRow($col, $row)->setValue($rows['date_record']);
			$sheet->getStyleByColumnAndRow($col++, $row)
				->getNumberFormat()
				->setFormatCode(
					\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DATETIME
				);

			$sheet->getCellByColumnAndRow($col++, $row)->setValue($rows['nama']);
			$sheet->getCellByColumnAndRow($col++, $row)->setValue($rows['username']);
			$sheet->getCellByColumnAndRow($col++, $row)->setValue($rows['masuk']);
			$sheet->getCellByColumnAndRow($col++, $row)->setValue($rows['pulang']);
			$sheet->getCellByColumnAndRow($col++, $row)->setValue($rows['list_uid']);

			$row++;
		}
		
		# kasih border untuk isiannya
		$sheet->getStyle('A7:G'.$row)->applyFromArray($style_table_isi);

		# UNTUK SHEET 2 : REKAP
		$sheet = $objPHPExcel->getSheet(1);
		$last= DateTime::createFromFormat('!m', '9')->format('t');

		// Keterangan Masa
		if($bulan == null ) $sheet->getCellByColumnAndRow('2', '3')->setValue('Dari '.$fmt->format(new \DateTime($dari)).' sampai '.$fmt->format(new \DateTime($sampai)));
		else $sheet->getCellByColumnAndRow('2', '3')->setValue("Bulan : ".$month->format(new \DateTime('2021-'.$bulan.'-09')));
		$row = 7;
		$index = 1;
		
		$col = 5;
		# tambah nama kolom
		if($bulan !== null){
			for($i=1;$i<=$last;$i++){
				$sheet->getCellByColumnAndRow($col++, 6)->setValue($i);
			}
		}else{
			$tanggal = $dari;
			while(strtotime($tanggal) <= strtotime($sampai)){
				$sheet->getCellByColumnAndRow($col++, 6)->setValue(date("d-m",strtotime($tanggal)));
				$tanggal = date('Y-m-d',strtotime($tanggal. " +1 day"));
			}
		}

		# Mulai input
		foreach ($array_hasil_2 as $rows)  {
			$sheet->getCellByColumnAndRow('1', $row)->setValue($index++);
			$col = 2;
			// if(trim($cell) !== '') $cell = date("Y/m/d",strtotime($cell)); 
			$sheet->getCellByColumnAndRow($col++, $row)->setValue($rows['username']);
			$sheet->getCellByColumnAndRow($col++, $row)->setValue($rows['nama']);
			$sheet->getCellByColumnAndRow($col++, $row)->setValue('MASUK');
			
			# Repeat Masuk BULAN
			if($bulan !== null){
				for($i=1;$i<=$last;$i++){
					$sheet->getCellByColumnAndRow($col++, $row)->setValue($rows['masuk_'.str_pad($i,2,0,STR_PAD_LEFT)]);
				}
			}else{
				$tanggal = $dari;
				while(strtotime($tanggal) <= strtotime($sampai)){
					$sheet->getCellByColumnAndRow($col++, $row)->setValue($rows['masuk_'.str_pad(date("m",strtotime($tanggal)),2,0,STR_PAD_LEFT).str_pad(date("d",strtotime($tanggal)),2,0,STR_PAD_LEFT)]);
					$tanggal = date('Y-m-d',strtotime($tanggal. " +1 day"));
				}
			}
			$row++;
			$col = 4;
			$sheet->getCellByColumnAndRow($col++, $row)->setValue('PULANG');
			
			# Repeat Masuk BULAN
			if($bulan !== null){
				for($i=1;$i<=$last;$i++){
					$sheet->getCellByColumnAndRow($col++, $row)->setValue($rows['pulang_'.str_pad($i,2,0,STR_PAD_LEFT)]);
				}
			}else{
				$tanggal = $dari;
				while(strtotime($tanggal) <= strtotime($sampai)){
					$sheet->getCellByColumnAndRow($col++, $row)->setValue($rows['pulang_'.str_pad(date("m",strtotime($tanggal)),2,0,STR_PAD_LEFT).str_pad(date("d",strtotime($tanggal)),2,0,STR_PAD_LEFT)]);
					$tanggal = date('Y-m-d',strtotime($tanggal. " +1 day"));
				}
			}
			$row++;
		}

		# kasih border untuk isiannya
		$sheet->getStyle('A7:AI'.$row)->applyFromArray($style_table_isi);


		$writer = new Xlsx($objPHPExcel);
		$filename = 'Rekap Presensi';
		
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
	}

	public function getExcelUID($bulan=null)
	{
		if($this->session->userdata('role') !== 'admin_turt' && $this->session->userdata('role') !== 'admin') redirect('404');

		date_default_timezone_set('Asia/Makassar');
		// echo date('Y-m-d H:i:s');
		$fmt = new \IntlDateFormatter('id_ID', NULL, NULL);
		$fmt->setPattern('cccc, d MMMM yyyy');  
		$month = new \IntlDateFormatter('id_ID', NULL, NULL);
		$month->setPattern('MMMM');  
		
		if($this->session->userdata('role') !== 'admin_turt' && $this->session->userdata('role') !== 'admin') redirect('404');
		
		$post = $this->input->post();
		if($bulan == null){
			$dari = $post['dari'];$sampai = $post['sampai'];
		}else{
			$dari = null;$sampai = null;
		}
		$array_hasil = $this->Presensi_model->getPresensiAdmin($dari,$sampai,$bulan);
		$array_hasil_2 = $this->Presensi_model->getRekapBulan($dari,$sampai,$bulan);
		// echo "<pre>",print_r($array_hasil_2);die();
		


		$templateFile = 'assets/files/rekap.xlsx';

		try {
			$objPHPExcel = IOFactory::load($templateFile);
		} catch(Exception $e) {
			die('Error loading file "'.pathinfo($templateFile,PATHINFO_BASENAME).'": '.$e->getMessage());
		}

		// Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
		$style_table_isi = array(
			'alignment' => array(
			  'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER, // Set text jadi di tengah secara vertical (middle)
			  'wrap' => true // wrap
			),
			'borders' => array(
			  'allBorders' => array(
					'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
					'color' => ['argb' => '000000'],
				  )
			 )
		  );
		  
		# UNTUK SHEET 1 : LOG
		$sheet = $objPHPExcel->getSheet(0);
		$highestRow = $sheet->getHighestRow(); // e.g. 10
		$highestColumn = $sheet->getHighestColumn(); // e.g 'F'
		$highestColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn);

		// Keterangan Masa
		if($bulan == null ) $sheet->getCellByColumnAndRow('2', '3')->setValue('Dari '.$fmt->format(new \DateTime($dari)).' sampai '.$fmt->format(new \DateTime($sampai)));
		else $sheet->getCellByColumnAndRow('2', '3')->setValue("Bulan : ".$month->format(new \DateTime('2021-'.$bulan.'-09')));
		


		$row = 7;
		$index = 1;

		# Muali input
		foreach ($array_hasil as $rows)  {
			$sheet->getCellByColumnAndRow('1', $row)->setValue($index++);
			$col = 2;

			if(trim($rows['date_record']) !== '') $rows[''] = \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel(strtotime($rows['date_record'])); 
			// if(trim($cell) !== '') $cell = date("Y/m/d",strtotime($cell)); 
			$sheet->getCellByColumnAndRow($col, $row)->setValue($rows['date_record']);
			$sheet->getStyleByColumnAndRow($col++, $row)
				->getNumberFormat()
				->setFormatCode(
					\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DATETIME
				);

			$sheet->getCellByColumnAndRow($col++, $row)->setValue($rows['nama']);
			$sheet->getCellByColumnAndRow($col++, $row)->setValue($rows['username']);
			$sheet->getCellByColumnAndRow($col++, $row)->setValue($rows['masuk']);
			$sheet->getCellByColumnAndRow($col++, $row)->setValue($rows['pulang']);
			$sheet->getCellByColumnAndRow($col++, $row)->setValue($rows['list_uid']);

			$row++;
		}
		
		# kasih border untuk isiannya
		$sheet->getStyle('A7:G'.$row)->applyFromArray($style_table_isi);

		# UNTUK SHEET 2 : REKAP
		$sheet = $objPHPExcel->getSheet(1);
		$last= DateTime::createFromFormat('!m', '9')->format('t');

		// Keterangan Masa
		if($bulan == null ) $sheet->getCellByColumnAndRow('2', '3')->setValue('Dari '.$fmt->format(new \DateTime($dari)).' sampai '.$fmt->format(new \DateTime($sampai)));
		else $sheet->getCellByColumnAndRow('2', '3')->setValue("Bulan : ".$month->format(new \DateTime('2021-'.$bulan.'-09')));
		$row = 7;
		$index = 1;
		
		$col = 5;
		# tambah nama kolom
		if($bulan !== null){
			for($i=1;$i<=$last;$i++){
				$sheet->getCellByColumnAndRow($col++, 6)->setValue($i);
			}
		}else{
			$tanggal = $dari;
			while(strtotime($tanggal) <= strtotime($sampai)){
				$sheet->getCellByColumnAndRow($col++, 6)->setValue(date("d-m",strtotime($tanggal)));
				$tanggal = date('Y-m-d',strtotime($tanggal. " +1 day"));
			}
		}

		# Mulai input
		foreach ($array_hasil_2 as $rows)  {
			$sheet->getCellByColumnAndRow('1', $row)->setValue($index++);
			$col = 2;
			// if(trim($cell) !== '') $cell = date("Y/m/d",strtotime($cell)); 
			$sheet->getCellByColumnAndRow($col++, $row)->setValue($rows['username']);
			$sheet->getCellByColumnAndRow($col++, $row)->setValue($rows['nama']);
			$sheet->getCellByColumnAndRow($col++, $row)->setValue('MASUK');
			
			# Repeat Masuk BULAN
			if($bulan !== null){
				for($i=1;$i<=$last;$i++){
					$sheet->getCellByColumnAndRow($col++, $row)->setValue($rows['masuk_'.str_pad($i,2,0,STR_PAD_LEFT)]);
				}
			}else{
				$tanggal = $dari;
				while(strtotime($tanggal) <= strtotime($sampai)){
					$sheet->getCellByColumnAndRow($col++, $row)->setValue($rows['masuk_'.str_pad(date("m",strtotime($tanggal)),2,0,STR_PAD_LEFT).str_pad(date("d",strtotime($tanggal)),2,0,STR_PAD_LEFT)]);
					$tanggal = date('Y-m-d',strtotime($tanggal. " +1 day"));
				}
			}
			$row++;
			$col = 4;
			$sheet->getCellByColumnAndRow($col++, $row)->setValue('PULANG');
			
			# Repeat Masuk BULAN
			if($bulan !== null){
				for($i=1;$i<=$last;$i++){
					$sheet->getCellByColumnAndRow($col++, $row)->setValue($rows['pulang_'.str_pad($i,2,0,STR_PAD_LEFT)]);
				}
			}else{
				$tanggal = $dari;
				while(strtotime($tanggal) <= strtotime($sampai)){
					$sheet->getCellByColumnAndRow($col++, $row)->setValue($rows['pulang_'.str_pad(date("m",strtotime($tanggal)),2,0,STR_PAD_LEFT).str_pad(date("d",strtotime($tanggal)),2,0,STR_PAD_LEFT)]);
					$tanggal = date('Y-m-d',strtotime($tanggal. " +1 day"));
				}
			}
			$row++;
		}

		# kasih border untuk isiannya
		$sheet->getStyle('A7:AI'.$row)->applyFromArray($style_table_isi);


		$writer = new Xlsx($objPHPExcel);
		$filename = 'Rekap Presensi';
		
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
	}

}
