<?php

class m_monitor extends CI_Model{
	function get_loguser($headerid){
		$this->db->select('UserID, Username, JenisTrn');
		$param = array('HasilHeaderID' => $headerid);
		$this->db->where($param);
		$query = $this->db->get('vwOL_LogTrnUser');
		return $query;
	}
	function get_headerid($tanggal, $idline, $shift, $idjamkerja){
		$hasilheaderid = 0;
		
		$param = array(
			'Tanggal'	=> tgl_eng($tanggal),
			'IDLine'	=> $idline,
			'IDShift'	=> $shift,
			'IDJamKerja' => $idjamkerja
		);
		$this->db->where($param);
		$query = $this->db->get('tblOL_TrnHasilHeader');
		
		if (!empty($query) &&  $query->num_rows() > 0){
			$row = $query->row();
			$hasilheaderid = $row->HasilHeaderID;
		}
		
		return $hasilheaderid;	
	}
	
	function monitor_sheller_1($tanggal, $idline, $shift){
		$headerid = $this->get_headerid($tanggal, $idline, $shift);
		return $this->db->query('Select * From dbo.fnMonitorHasilSheller('.$headerid.') Order By NomorMesin ');
	}
	
	function monitor_sheller($headerid, $pekerjaan = ""){
		return $this->db->query("Select * From dbo.fnMonitorHasilSheller(".$headerid.") where Pekerjaan like '".$pekerjaan."' Order By NomorMesin ");
	}
	
	function monitor_parer($headerid, $pekerjaan = ""){
		return $this->db->query("Select * From dbo.fnMonitorHasilParer(".$headerid.") where Pekerjaan like '".$pekerjaan."' Order By NomorMesin ");
	}
	
	function monitor_sheller_lain($headerid){
		return $this->db->query("Select *,KerjaDi = 'Sheller' From dbo.fnMonitorHasilSheller(".$headerid.") where Pekerjaan not in ('HARIAN', 'SHELLER BORONGAN') Order By NomorMesin ");
	}
	
	function monitor_parer_lain($headerid){
		return $this->db->query("Select *, KerjaDi = 'Parer' From dbo.fnMonitorHasilParer(".$headerid.") where Pekerjaan not in ('HARIAN', 'PARER BORONGAN') Order By NomorMesin ");
	}
	
	function monitor_isikeranjang($headerid, $idline){
		return $this->db->query('Select * From fnMonitorIsiKeranjang ('.$headerid.','.$idline.')');
	}
	
	function monitor_whitemeat($headerid, $idline){
		return $this->db->query('Select * From fnMonitorWhiteMeat ('.$headerid.','.$idline.')');
	}
	
	function monitor_airkelapa($headerid, $idline){
		return $this->db->query('Select * From fnMonitorAirKelapa ('.$headerid.','.$idline.')');
	}
	
	function monitor_kelapacungkil($headerid, $idline){
		return $this->db->query('Select * From fnMonitorKelapaCungkil ('.$headerid.','.$idline.')');
	}
	
//	Monitor Absensi
	
	function monitor_absensi(){
		$tanggal		= $this->input->post('txtTanggal');
		$idline			= $this->input->post('txtLine');
		$idshift		= $this->input->post('txtShift');		
		$idpekerjaan	= $this->input->post('txtPekerjaan');
		
		$param = array(
			'Tanggal'	 => tgl_eng($tanggal),
			'IDLineAsal' => $idline,
			'IDShift'	 => $idshift,
			'JenisKerja' => $idpekerjaan
		);
		
		return $this->db->get_where('vwOL_MonKehadiran', $param);
	}
}