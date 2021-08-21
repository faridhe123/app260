 <?php
	//File products_model.php
	class Pengaduan_model extends CI_Model  {
	
	function __construct() { 
		parent::__construct(); 
	} 
	

	function get_all() {
		//input
        $username = strtolower($this->session->userdata('username'));
		$sql="SELECT * from wise.pengaduan
            where akun_record = '$username'";

        return $this->db->query($sql)->result_array();

	}

	function input_pengaduan($post) {
		//input
		$data = array(
				'id_pengaduan' => $post['id_pengaduan'],
				'alamat_kejadian' => $post['alamat_kejadian'],
				'unit_kejadian' => $post['unit_kejadian'],
				'perkiraan_waktu' => $post['perkiraan_waktu'],
				'terlapor' => $post['terlapor'],
				'file_lampiran' => $post['lampiran'],
				'date_record' => date('Y-m-d H:m:s'),
				'akun_record' => $this->session->userdata('username')	
            );
		
		$insert = $this->db->insert('wise.pengaduan', $data);
	
		return $insert;

	}

	public function upload_lampiran($files,$path)    {

        $config = array(
            'upload_path'   => $path,
            'allowed_types' => 'jpg|png|pdf|jpeg|bmp|gif|doc|docx|xls|xlsx|ppt|pptx',
            'overwrite'     => 1,
        );

        $this->load->library('upload', $config);

        $images = array();

        foreach ($files['name'] as $key => $image) {
            $_FILES['images[]']['name']= $files['name'][$key];
            $_FILES['images[]']['type']= $files['type'][$key];
            $_FILES['images[]']['tmp_name']= $files['tmp_name'][$key];
            $_FILES['images[]']['error']= $files['error'][$key];
            $_FILES['images[]']['size']= $files['size'][$key];

            $split = explode(".",$image);
            $ext = end($split);

            $fileName = uniqid() .'_'. md5($image) . "." . $ext;
			$ip = $this->input->ip_address();
			$dateNow = date("Y-m-d H:i:s");

            $obj = new stdClass();
            $obj->file = $fileName;
            $obj->judul = $image;
            $obj->ip = $ip;
            $obj->tanggal = $dateNow;
            $obj->path = $path;
            $images[] = $obj;

            $config['file_name'] = $fileName;

            $this->upload->initialize($config);

            if ($this->upload->do_upload('images[]')) {
                $this->upload->data();
            } else {
                return false;
                exit();
            }
        }

        return $images;
    }

	public function getLastID()
	{
		$sql = "select max(id_pengaduan)from wise.pengaduan a";

		$query = $this->db->query($sql);
		$last_id = $query->result_array()[0]['max'];
		return $last_id;
	}

}