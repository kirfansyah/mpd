<?php

class m_trn_timbangwm extends CI_Model{
	
	function list_timbangwm(){
		if ($this->session->userdata('accessalldata') === 1) {
			$sql = "Select TglJamMasuk, Tanggal, IDShift, JamKerja, IDLine, NamaLine, HasilHeaderID, "
				. "TotalTimbangan = SUM(Timbangan), TotalPotLain = SUM(PotLain), TotalPotAir = SUM(PotAir) "
				. "From vwOL_TrnHasilTimbangWhiteMeat "
				. "Where CompleteHasilWM is null "
				. "Group By TglJamMasuk, Tanggal, IDShift, JamKerja, IDLine, NamaLine, HasilHeaderID "
				. "Order By TglJamMasuk Desc ";
		} else {
			$sql = "Select TglJamMasuk, Tanggal, IDShift, JamKerja, IDLine, NamaLine, HasilHeaderID, "
				. "TotalTimbangan = SUM(Timbangan), TotalPotLain = SUM(PotLain), TotalPotAir = SUM(PotAir) "
				. "From vwOL_TrnHasilTimbangWhiteMeat "
				. "Where CompleteHasilWM is null "
				. "And Inspector = '".strtoupper($this->session->userdata('username'))."' "
				. "Group By TglJamMasuk, Tanggal, IDShift, JamKerja, IDLine, NamaLine, HasilHeaderID "
				. "Order By TglJamMasuk Desc ";
		}
		return $this->db->query($sql);
		
	}


	
	function get_detail_byid($detailid){
		return $this->db->get_where('tblOL_TrnHasilTimbangWhiteMeat', array('HasilTimbangWMID' => $detailid));
	}
		
	function simpan_detail($info){
		$berhasil = 0;
		
		$this->db->trans_start();
		$this->db->insert('tblOL_TrnHasilTimbangWhiteMeat',$info);
		$this->db->trans_complete();
		
		if ($this->db->trans_status() === TRUE){
			$berhasil = 1;
		}
		
		return $berhasil;
	}
	
	function update_detail($detailid, $info){
		$berhasil = 0;
		
		$this->db->trans_start();
		$this->db->where('HasilTimbangWMID', $detailid);
		$this->db->update('tblOL_TrnHasilTimbangWhiteMeat', $info);
		$this->db->trans_complete();
		
		if ($this->db->trans_status() === TRUE){
			$berhasil = 1;
		}
		
		return $berhasil;
	}
	
	function delete_detail($detailid){
		$berhasil = 0;
		
		$this->db->trans_start();
		$this->db->where('HasilTimbangWMID', $detailid);
		$this->db->delete('tblOL_TrnHasilTimbangWhiteMeat');
		$this->db->trans_complete();
		
		if ($this->db->trans_status() === TRUE){
			$berhasil = 1;
		}
		
		return $berhasil;
	}
	
}