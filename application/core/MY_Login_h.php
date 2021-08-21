<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

//require APPPATH . "third_party/MX/Controller.php";
class MY_Login_h extends MY_Controller {

 function __construct()
    {
        parent::__construct();
        if ( ! $this->session->userdata('logged_in'))
        { 
            redirect('user/login');
        }
    }
}


?>