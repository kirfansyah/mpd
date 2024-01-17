<?php

class m_trnhasil extends CI_Model{
	
	function insert_selesai($transaksi){
		$userid = $this->session->userdata('userid');
		switch ($transaksi) {
			case 'whitemeat':
				$filter = array(
					'UserID' => $userid
					, 'JenisTrn' => 'WM'
					, 'StatusSelesai' => 0
				);
				break;
				case 'airkelapa':
				$filter = array(
					'UserID' => $userid
					, 'JenisTrn' => 'AK'
					, 'StatusSelesai' => 0
				);
				break;
				case 'kelapacungkil':
				$filter = array(
					'UserID' => $userid
					, 'JenisTrn' => 'KC'
					, 'StatusSelesai' => 0
				);
				break;
			
			default:
				break;
		}
		$this->db->trans_start();
		$this->db->where($filter);
		$data = array('StatusSelesai' => 1, 'EndDate' => date('Y-m-d H:i:s'));
		$this->db->update('tblOL_LogTrnUser', $data);
		$this->db->trans_complete();
	}

	function get_header_hasil($tanggal, $idline, $idjamkerja, $shift){
		$hasilheaderid = 0;
		
		$param = array(
//			'Tanggal'	=> tgl_eng($this->session->userdata('serverdate')),
			'Tanggal'	=> tgl_eng($tanggal),
			'IDLine'	=> $idline,
			'IDJamKerja'	=> $idjamkerja,
			'IDShift' => $shift
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

	function get_inspector($headerid, $jnstrn){
		$this->db->order_by('LogTrnID', 'desc');
		$query = $this->db->get_where('vwOL_LogTrnUser', array('HasilHeaderID'=>$headerid, 'JenisTrn' => $jnstrn));
		
		$jurucatat = array ('userid' => $this->session->userdata('userid'), 'username'=>$this->session->userdata('username'), 'stselesai' => 1);
		if ($query->num_rows() > 0){
			$row = $query->row();
			$jurucatat = array ('userid' => $row->UserID, 'username'=>$row->Username, 'stselesai' => $row->StatusSelesai);
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

	function insert_Log_trn($infoLog){
		$this->db->trans_start();
		$this->db->insert('tblOL_LogTrnUser',$infoLog);
		$logid = $this->db->insert_id();
		$this->db->trans_complete();
		return $logid;
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

	function update_header($headerid, $data_update){
		$this->db->trans_start();
		$this->db->where('HasilHeaderID', $headerid);
		$this->db->update('tblOL_TrnHasilHeader', $data_update);
		$this->db->trans_complete();
	}
}