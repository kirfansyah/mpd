<?php

class m_trnhasil extends CI_Model{
	
	function get_header_hasil($tanggal, $idline, $idjamkerja){
		$hasilheaderid = 0;
		
		$param = array(
//			'Tanggal'	=> tgl_eng($this->session->userdata('serverdate')),
			'Tanggal'	=> tgl_eng($tanggal),
			'IDLine'	=> $idline,
			'IDJamKerja'	=> $idjamkerja
		);
		$query = $this->db->get_where('tblOL_TrnHasilHeader', $param);
		
		if ($query->num_rows() > 0){
			$row = $query->row();
			$hasilheaderid = $row->HasilHeaderID;
		}
		
		return $hasilheaderid;
	}
	
	function get_jurucatat($headerid){
		$query = $this->db->get_where('tblOL_TrnHasilHeader', array('HasilHeaderID'=>$headerid));
		
		$jurucatat = $this->session->userdata('username');
		if ($query->num_rows() > 0){
			$row = $query->row();
			$jurucatat = $row->Inspector;
		}
		
		return $jurucatat;
	}
	
	function insert_header_hasil($info){
		$this->db->trans_start();
		$this->db->insert('tblOL_TrnHasilHeader',$info);
		$hdrid = $this->db->insert_id();
		$this->db->trans_complete();
		return $hdrid;
	}
	
	function complete_hasil($halaman, $id){
		$this->db->trans_start();
		
		switch ($halaman) {
			case 'keranjang':
				$dbfield = 'CompleteIsiKeranjang';
				break;
			
			case 'whitemeat':
				$dbfield = 'CompleteHasilWM';
				break;
			
			case 'airkelapa':
				$dbfield = 'CompleteHasilAK';
				break;
			
			case 'kelapacungkil':
				$dbfield = 'CompleteHasilKC';
				break;

			default:
				break;
		}
		
		$info = array(
			$dbfield => 1
		);
		
		$this->db->where('HasilHeaderID', $id);
		$this->db->update('tblOL_TrnHasilHeader', $info);
		$this->db->trans_complete();
	}
}