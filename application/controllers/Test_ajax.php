<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include_once(APPPATH.'core/MY_Login.php');

class Test_ajax extends CI_Controller {
	
	function __construct(){
		parent::__construct();
	
		//helper
	}

	public function index(){
		header("Access-Control-Allow-Origin: *");
        $data = array();
        $this->template->set('title', 'Dashboard');
        $this->load->view('test_ajax', $data);
		
		
	}
	
	public function test(){
		$long = $_POST["long"];
		$lat = $_POST["lat"];
		
		if(true)echo $long ." - ".$lat;
		else echo "gagal";

	}

	public function action(){
		// include_once('config.php');
		$userData = count($_POST["name"]);
		
		if ($userData >= 1 && (trim($_POST['name'][0] != '') && trim($_POST['email'][0] != '')) ) {
			
			for ($i=0; $i < $userData; $i++) {
				if (trim($_POST['name'][$i] != '') && trim($_POST['email'][$i] != '')) {
					
					$data = array(
							'name' => $_POST["name"][$i],
							'email' => $_POST["email"][$i]
					);
					// print_r($data);die();
					$insert = $this->db->insert('app_umum.users',$data);
					echo $insert;
				}
			}
		}else{
			echo "Please Enter user name";
		}
	}
}
