<?php

class m_trn_hasilkc extends CI_Model{
	
	function list_hasilkc(){
		if ($this->session->userdata('accessalldata') === 1) {
			$sql = "Select top 500 Tanggal, IDShift, JamKerja, IDLine, NamaLine, HasilHeaderID, "
				. "TotalKC = SUM(HasilKC) "
				. "From vwOL_TrnHasilKelapaCungkil "
				. "Where CompleteHasilKC is null "
				. "Group By Tanggal, IDShift, JamKerja, IDLine, NamaLine, HasilHeaderID "
				. "Order By Tanggal DESC ";
		} else {
			$sql = "Select top 500 Tanggal, IDShift, JamKerja, IDLine, NamaLine, HasilHeaderID, "
				. "TotalKC = SUM(HasilKC) "
				. "From vwOL_TrnHasilKelapaCungkil "
				. "Where CompleteHasilKC is null "
				. "And Inspector = '".strtoupper($this->session->userdata('username'))."' "
				. "Group By Tanggal, IDShift, JamKerja, IDLine, NamaLine, HasilHeaderID "
				. "Order By Tanggal DESC ";
		}
		return $this->db->query($sql);
	}
	
	function detail_hasilkc($param_mesin){
		$this->db->where($param_mesin);
		$this->db->order_by('HasilKCID','desc');
		$query = $this->db->get("vwOL_TrnHasilKelapaCungkil");
		return $query->result();
	}

	function get_detail_byid($detailid){
		return $this->db->get_where('tblOL_TrnHasilKelapaCungkil', array('HasilKCID' => $detailid));
	}
	
	function simpan_detail($info){
		$berhasil = 0;
		
		$this->db->trans_start();
		$this->db->insert('tblOL_TrnHasilKelapaCungkil',$info);
		$this->db->trans_complete();
		
		if ($this->db->trans_status() === TRUE){
			$berhasil = 1;
		}
		
		return $berhasil;
	}
	
	function update_detail($detailid, $info){
		$berhasil = 0;
		
		$this->db->trans_start();
		$this->db->where('HasilKCID', $detailid);
		$this->db->update('tblOL_TrnHasilKelapaCungkil', $info);
		$this->db->trans_complete();
		
		if ($this->db->trans_status() === TRUE){
			$berhasil = 1;
		}
		
		return $berhasil;
	}
	
	function delete_detail($detailid){
		$berhasil = 0;
		
		$this->db->trans_start();
		$this->db->where('HasilKCID', $detailid);
		$this->db->delete('tblOL_TrnHasilKelapaCungkil');
		$this->db->trans_complete();
		
		if ($this->db->trans_status() === TRUE){
			$berhasil = 1;
		}
		
		return $berhasil;
	}
}