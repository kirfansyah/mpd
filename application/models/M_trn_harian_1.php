<?php
class m_trn_harian extends CI_model{

	function get_HasilHeader($idpekerjaan, $prefix){
		$hasilHeaderID = "";				
		$param = array(
			'Tanggal'	 => tgl_eng($this->session->userdata($prefix.'_tanggal')),
			'IDLine'	 => $this->session->userdata($prefix.'_idline'),
			'IDShift'	 => $this->session->userdata($prefix.'_shift'),
		);
		
		$urutheader = 0;
		$query = $this->db->get_where('tblOL_TrnHasilHeader', $param);
		if ($query->num_rows() > 0){
			$row 			= $query->row();
			$hasilHeaderID 	= $row->HasilHeaderID;
		} 
		
		return $hasilHeaderID;
	}

	function simpan_hasil_harian($info){
		$berhasil = 0;
		
		$this->db->trans_start();
		$this->db->insert('tblOL_TrnHasilTimbangHarian',$info);
		$this->db->trans_complete();
		
		if ($this->db->trans_status() === TRUE){
			$berhasil = 1;
		}
		
		return $berhasil;
	}

	function update_hasil_harian($hasil_header_id, $urut_dtl_id, $info){
		$berhasil = 0;
		
		$this->db->trans_start();
		$this->db->where('HasilHeaderID', $hasil_header_id);
		$this->db->where('UrutDtlID', $urut_dtl_id);
		$this->db->update('tblOL_TrnHasilTimbangHarian', $info);
		$this->db->trans_complete();
		
		if ($this->db->trans_status() === TRUE){
			$berhasil = 1;
		}
		
		return $berhasil;
	}

	function get_hasil_parer($headerid, $NIK){
		$array = array('NIK' => $NIK);
		$this->db->select('TimbangWM', 'TimbangAK', 'HasilKC');
		$this->db->where($array);
		$this->db->from('fnMonitorHasilParer('.$headerid.')');
		$query = $this->db->get();
		$result = $query->result();
		return $result;
	}

	function get_Aksi($hasilHeaderId, $urutHeaderId){				
		$param = array(
			'HasilHeaderID'	=> $hasilHeaderId,
			'UrutDtlID'		=> $urutHeaderId
		);
		
		$edit =  0;
		$query = $this->db->get_where('tblOL_TrnHasilTimbangHarian', $param);
		if ($query->num_rows() > 0){
			$edit 		= 1;
		} 
		
		return $edit;
	}

	function hapus_hasil_harian($urut_dtl_id){
		$berhasil = 0;
		
		$this->db->trans_start();
		$this->db->where('UrutDtlID', $urut_dtl_id);
		$this->db->delete('tblOL_TrnHasilTimbangHarian');
		$this->db->trans_complete();
		
		if ($this->db->trans_status() === TRUE){
			$berhasil = 1;
		}
		
		return $berhasil;
	}
}
?>