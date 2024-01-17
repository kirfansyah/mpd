<?php

class m_master extends CI_Model{
	
	function mst_pekerjaan(){
		return $this->db->get('tblMstPekerjaan');
	}
	
	function mst_perusahaan(){
		$this->db->order_by('Perusahaan');
		return $this->db->get('tblMstPerusahaan');
	}
	
	function mst_pemborong(){
		$this->db->order_by('Pemborong');
		return $this->db->get('tblMstPemborong');
	}
	
	function mst_line_group(){
		$this->db->select('GroupLine');
		$this->db->group_by('GroupLine');
		return $this->db->get('tblMstLine');
	}
	
	function mst_line($idline = 0){
		if ($idline>0){
			$this->db->where('IDLine', $idline);
		}
		return $this->db->get('tblMstLine');
	}
	
	function mst_shift(){
		return $this->db->get('tblMstShift');
	}
	
	function mst_jamkerja($idjamkerja = 0){
		if ($idjamkerja > 0){
			$sql = "Select * From tblMstJamKerja Where IDJamKerja = '$idjamkerja' and NotActive = 0";
			// $this->db->where("IDJamKerja = '$idjamkerja' and NotActive = 0");
		}else{
			$sql = "Select * From tblMstJamKerja Where NotActive = 0";
		}
		// return $this->db->get('tblMstJamKerja');
		return $this->db->query($sql);
	}
	
	function mst_pekerjaan_mpd(){
		$sql = 'Select * From tblMstPekerjaan Where IDPekerjaan In (1, 2, 3)';
		return $this->db->query($sql);
	}
	
	function get_pekerjaan($idpekerjaan){
		$query = $this->db->get_where('tblMstPekerjaan',array('IDPekerjaan' => $idpekerjaan));
		if ($query->num_rows() > 0){
			$row = $query->row();
			$pekerjaan=$row->Pekerjaan;
		}else{
			$pekerjaan='';
		}
		return $pekerjaan;
	}
	
	function get_nama_line($idline){
		$query = $this->db->get_where('tblMstLine',array('IDLine' => $idline));
		if ($query->num_rows() > 0){
			$row = $query->row();
			$nama_line=$row->NamaLine;
		}else{
			$nama_line='';
		}
		return $nama_line;
	}
	
	function get_hasilheader($headerid){
		$query = $this->db->get_where('vwOL_TrnHasilHeader', array('HasilHeaderID' => $headerid));
		return $query;
	}
	
	function total_mesin_max(){
		$query = $this->db->query('Select Total=Max(NomorMesinAkhir) From tblMstLine');
		if ($query->num_rows() > 0){
			$row = $query->row();
			$totalmesinmax=$row->Total;
		}else{
			$totalmesinmax= 0;
		}
		return $totalmesinmax;
	}
	
	function get_nomormesin($idline){
		$this->db->where('IDLine', $idline);
		return $this->db->get('tblMstLine');		
	}
	
}
