<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include_once(APPPATH.'core/MY_Login.php');

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

	public function admin(){
		if($this->session->userdata('role') !== 'admin_turt' && $this->session->userdata('role') !== 'admin') redirect('404');

		header("Access-Control-Allow-Origin: *");
        $data = array();

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
    
		$data['nextID'] = ($this->Presensi_model->getMaxID()??0) + 1;
    
		$presensi = $this->Presensi_model->getPresensi($data['username']);
		
		if($presensi['min'] !== null) $jenis =  'PULANG';
		else $jenis = 'MASUK';

		$submit = $this->Presensi_model->submitPresensi($data,$jenis);
		
		if($submit) echo "Presensi $jenis Sukses";
		else echo "gagal";
	}
	
	public function getExcelRekap()
	{
		$post = $this->input->post();
		$arraySPD = $this->tinjauan_spd->getSPD($post['id'])[0];
		$templateFile = 'assets/files/rekap.xlsx';

		try {
			$objPHPExcel = IOFactory::load($templateFile);
		} catch(Exception $e) {
			die('Error loading file "'.pathinfo($templateFile,PATHINFO_BASENAME).'": '.$e->getMessage());
		}

		$sheet = $objPHPExcel->getSheet(0);
		$highestRow = $sheet->getHighestRow(); // e.g. 10
		$highestColumn = $sheet->getHighestColumn(); // e.g 'F'
		$highestColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn);

		$col = 1;
		foreach ($arraySPD as $head=>$cell)  {
			if(strpos($head, 'tgl') !== false or $head == 'berangkat' or $head == 'kembali'){
				if(trim($cell) !== '') $cell = \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel(strtotime($cell)); 
				// if(trim($cell) !== '') $cell = date("Y/m/d",strtotime($cell)); 
				$value = $sheet->getCellByColumnAndRow($col, 3)->setValue($cell);
				$sheet->getStyleByColumnAndRow($col++, 3)
					->getNumberFormat()
					->setFormatCode(
						\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DATETIME
					);
			}else $value = $sheet->getCellByColumnAndRow($col++, 3)->setValue($cell);

		}

		$data['rowData'] = $sheet->rangeToArray('A' . 3 . ':' . 'FF' . $highestRow, NULL,TRUE,FALSE);
		$writer = new Xlsx($objPHPExcel);
		$filename = 'edit SPD';
		
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
	}

}
