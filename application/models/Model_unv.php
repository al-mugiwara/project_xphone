	<?php 
	defined('BASEPATH') OR exit('No direct script access allowed');
	class Model_unv extends CI_Model
	{
		function get_data($tabel){
			$this->db->select('*');
			$this->db->from($tabel);
			$query = $this->db->get();
			return $query;
		}	

		function save_data($tabel,$data){
			return $this->db->insert($tabel,$data);
		}

		function delete_data($tabel,$where,$id){
			$this->db->where($where,$id);
			$this->db->delete($tabel);
		}

		function edit_data($tabel,$where,$id){
			$this->db->from($tabel);
			$this->db->where($where,$id);
			$query = $this->db->get();
			return $query;
		}

		function save_edit($tabel,$where,$id,$data){
			$this->db->where($where,$id);
			$this->db->update($tabel,$data);
		}

		function delete_lebih($tabel,$where1,$where2,$id1,$id2){
			$this->db->where(array($where1 => $id1,$where2 => $id2))->delete($tabel);
		}

		function edit_lebih($tabel,$where1,$where2,$id1,$id2){
			$this->db->from($tabel);
			$this->db->where(array($where1 => $id1,$where2 => $id2));
			$query = $this->db->get();
			return $query;
		}

	}

	?>