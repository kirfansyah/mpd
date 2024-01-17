<?php

class m_trn_timbangak extends CI_Model{
	
	function list_timbangak(){
		// if ($this->session->userdata('accessalldata') === 1) {
			$sql = "Select top 500 Tanggal, IDShift, JamKerja, IDLine, NamaLine, HasilHeaderID, "
				. "TotalAK = SUM(HasilAK) "
				. "From vwOL_TrnHasilTimbangAirKelapa "
				. "Where CompleteHasilAK is null "
				. "Group By Tanggal, IDShift, JamKerja, IDLine, NamaLine, HasilHeaderID "
				. "Order By Tanggal DESC ";
		/* } else {
			$sql = "Select top 500 Tanggal, IDShift, JamKerja, IDLine, NamaLine, HasilHeaderID, "
				. "TotalAK = SUM(HasilAK) "
				. "From vwOL_TrnHasilTimbangAirKelapa "
				. "Where CompleteHasilAK is null "
				. "And Inspector='".strtoupper($this->session->userdata('username'))."' "
				. "Group By Tanggal, IDShift, JamKerja, IDLine, NamaLine, HasilHeaderID "
				. "Order By Tanggal DESC ";
		} */
		return $this->db->query($sql);
	}
	
	function detail_timbangak($param_mesin){
		$this->db->select('*');
		$this->db->where($param_mesin);
		$this->db->order_by('HasilTimbangAKID','desc');
		$this->db->limit(1);
		$query = $this->db->get("vwOL_TrnHasilTimbangAirKelapa");
		return $query->result();
	}

	function get_detail_byid($detailid){
		return $this->db->get_where('tblOL_TrnHasilTimbangAirKelapa', array('HasilTimbangAKID' => $detailid));
	}
	
	function simpan_detail($info){
		$berhasil = 0;
		
		$this->db->trans_start();
		$this->db->insert('tblOL_TrnHasilTimbangAirKelapa',$info);
		$this->db->trans_complete();
		
		if ($this->db->trans_status() === TRUE){
			$berhasil = 1;
		}
		
		return $berhasil;
	}
	
	function update_detail($detailid, $info){
		$berhasil = 0;
		
		$this->db->trans_start();
		$this->db->where('HasilTimbangAKID', $detailid);
		$this->db->update('tblOL_TrnHasilTimbangAirKelapa', $info);
		$this->db->trans_complete();
		
		if ($this->db->trans_status() === TRUE){
			$berhasil = 1;
		}
		
		return $berhasil;
	}
	
	function delete_detail($detailid){
		$berhasil = 0;
		
		$this->db->trans_start();
		$this->db->where('HasilTimbangAKID', $detailid);
		$this->db->delete('tblOL_TrnHasilTimbangAirKelapa');
		$this->db->trans_complete();
		
		if ($this->db->trans_status() === TRUE){
			$berhasil = 1;
		}
		
		return $berhasil;
	}
}