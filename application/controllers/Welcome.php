<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('Model_login','ml');
	}
	public function index()
	{
		if(isset($_POST['submit'])){
			$username = $this->input->post('username',true);
			$password = $this->input->post('password',true);
			$this->form_validation->set_rules('username','username','required');
			//$this->form_validation->set_rules('username','username','required');
			$this->form_validation->set_rules('password','password','required');
			if(!$this->form_validation->run()){
				$session['gagal'] = "Username atau Password Salah";
				$this->session->set_userdata($session);
				redirect('Welcome');
				//echo "sa";

			}else{
				$result = $this->ml->get_login($username,$password);
				if($result){
					$sdata['username'] = $result->username;
					$sdata['nama_lengkap'] = $result->nama_lengkap;
					$sdata['alamat'] = $result->alamat;
					$sdata['no_hp'] = $result->no_hp;
					$sdata['id_pengguna'] = $result->id_pengguna;
					$sdata['hak_akses'] = $result->hak_akses;
					$this->session->set_userdata($sdata);
					if($sdata['hak_akses'] == 'admin'){
						redirect('admin/Dashboard');

					}
				}else{
					echo "sdd";
				}
			}
			
		}
		$this->load->view('welcome_message');
	}
}
