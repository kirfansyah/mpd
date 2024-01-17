<?php
class M_daftar extends CI_Model{

	function search_tk_sub($idpekerjaan, $idshift, $idline, $idpemborong, $nama, $nik){		
		if(!empty($idpekerjaan) || $idpekerjaan !== ''){
			if ($idpekerjaan == 1000) {
				$this->db->where('IDPekerjaan !=', 0);
			} else if ($idpekerjaan > 500){
				$this->db->where('IDSubPekerjaan', $idpekerjaan-500);
			}else
				$this->db->where('IDPekerjaan', $idpekerjaan);
		}
		
		if(!empty($idshift) || $idshift !== ''){
			$this->db->where('IDShift', $idshift);
		}
		
		if(!empty($idline) || $idline !== ''){
			$this->db->where('IDLine', $idline);
		}
		
		if(!empty($idpemborong) || $idpemborong !== ''){
			$this->db->where('IDPemborong', $idpemborong);
		}
		
		if(!empty($nama) || $nama !== ''){
			$this->db->like('Nama', $nama,'both');
		}
		
		if(!empty($nik) || $nik !== ''){
			$this->db->like('Nik', $nik, 'boths');
		}
		
		$this->db->where('TanggalKeluar', Null);
		
		return $this->db->get('vwOL_MstTenagaKerja');
	}

	function get_trans_id($fixno){
		$param = array ('FixNo' => $fixno);

		$trans_id = 0;
		$query = $this->db->get_where('tblUtlSetNoUrut', $param);
		if ($query->num_rows() > 0){
			$row = $query->row();
			$trans_id = $row->TransID;
		}
		return $trans_id;
	}

	function delete_nourut($trans_id){
		$success = 0 ;
		$this->db->trans_start();
		$this->db->where('TransID', $trans_id);
		$this->db->delete('tblUtlSetNoUrut');
		$this->db->trans_complete();

		if ($this->db->trans_status() === TRUE){
			$berhasil = 1;
		}

		return $berhasil;
	}

	function insert_nourut($info){
		$this->db->trans_start();
		$this->db->insert('tblUtlSetNoUrut',$info);
		$nourutid = $this->db->insert_id();
		$this->db->trans_complete();

		return $nourutid;
	}
}