<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Barang extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		//$this->load->model('Model_pengguna', 'mp');
		$this->load->model('Model_unv', 'mv');
	}
	public function index()
	{
		$data_kirim = array(
			'barang' => $this->mv->get_data('tb_barang')->result_array(),
		);
		$this->template->load('template', 'admin/barang/data',$data_kirim);
		
	}

	public function tambah()
	{
		if ($this->input->post()) {
			$this->form_validation->set_rules('nama_barang', 'nama_barang', 'required');
			$this->form_validation->set_rules('harga_barang', 'harga_barang', 'required');
			$this->form_validation->set_rules('imei', 'imei', 'required');
			
			$this->form_validation->set_rules('keterangan', 'keterangan', 'required');
			// $this->form_validation->set_rules('hak_akses', 'hak_akses', 'required');
			if ($this->form_validation->run()) {
				$config['upload_path'] = 'assets_2/images';
				$config['allowed_types']='*';
				$config['encrypt_name']=TRUE;
				$this->load->library('upload',$config);
				if($this->upload->do_upload('file')){
					$uploadData = $this->upload->data();
					$uploadFile = $uploadData['file_name'];					
				}

				$data = array(
					'nama_barang' 				=> $this->input->post('nama_barang'),
					'harga_barang' 				=> $this->input->post('harga_barang'),
					'imei' 						=> $this->input->post('imei'),
					'keterangan' 				=> $this->input->post('keterangan'),
					'stok'						=> $this->input->post('stok'),
					'gambar_ut' 				=> $uploadFile
				);
				if ($this->mv->save_data('tb_barang',$data)) {
					$session['berhasil'] = "Data Barang Berhasil Disimpan";
					$this->session->set_userdata($session);
					redirect('admin/Barang');
				} else {
					echo "serr";
				}
			} else {
				echo "ddd";
			}

		}else{
			$this->template->load('template','admin/barang/form');
		}
	}

	public function edit($id_barang){
		$data_kirim['data'] = $this->mv->edit_data('tb_barang','id_barang',$id_barang)->row_array();
		$this->template->load('template','admin/barang/form',$data_kirim);		
	}

	public function update($id_barang){
		if($_FILES['file']['name']){
			$ceks = $this->mv->edit_data('tb_barang','id_barang',$id_barang)->row_array();
			unlink('assets_2/images/'.$ceks['gambar_ut']);
			$config['upload_path'] = 'assets_2/images';
			$config['allowed_types'] = '*';
			$config['encrypt_name'] = TRUE;
			$this->load->library('upload',$config);
			if($this->upload->do_upload('file')){
				$uploadData = $this->upload->data();
				$uploadFile = $uploadData['file_name'];
				$data = array(
					'nama_barang' 				=> $this->input->post('nama_barang'),
					'harga_barang' 				=> $this->input->post('harga_barang'),
					'imei' 						=> $this->input->post('imei'),
					'keterangan' 				=> $this->input->post('keterangan'),
					'stok'						=> $this->input->post('stok'),
					'gambar_ut' 				=> $uploadFile
				);

			}
		}else{
			$data = array(
				'nama_barang' 				=> $this->input->post('nama_barang'),
				'harga_barang' 				=> $this->input->post('harga_barang'),
				'imei' 						=> $this->input->post('imei'),
				'keterangan' 				=> $this->input->post('keterangan'),
				'stok'						=> $this->input->post('stok'),
			);

		}
		$this->mv->save_edit('tb_barang','id_barang',$this->input->post('id_barang'),$data);
		$session['berhasil'] = "Data Barang Berhasil Diedit";
		$this->session->set_userdata($session);
		redirect('admin/Barang');
	}

	public function hapus($kd_barang){
		$cek = $this->mv->edit_data('tb_barang','id_barang',$kd_barang)->row_array();
		unlink('assets_2/images/'.$cek['gambar_ut']);
		$this->mv->delete_data('tb_barang','id_barang',$kd_barang);
		echo json_encode(array('status' => TRUE));
	}
}
