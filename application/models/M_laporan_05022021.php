<?php

class m_laporan extends CI_Model{
	
	function get_whitemeat(){
		$tanggal = tgl_eng($this->input->post('txtTanggal'));
		$idshift = $this->input->post('txtShift');
		$idjamkerja = $this->input->post('txtJamKerja');
		
		$sql = "Select GroupLine, NomorMesin, GrandTotal = SUM(TimbangWM) From vwOL_LapHasilWhiteMeat ".
			" Where Tanggal='".$tanggal."' And IDShift='".$idshift."' And IDJamKerja=".$idjamkerja.
			" Group By GroupLine, NomorMesin ";
		return $this->db->query($sql);
	}
	
	function get_whitemeat_total(){
		$tanggal = tgl_eng($this->input->post('txtTanggal'));
		$idshift = $this->input->post('txtShift');
		$idjamkerja = $this->input->post('txtJamKerja');
		
		$sql = "Select GroupLine, GrandTotal = SUM(TimbangWM) From vwOL_LapHasilWhiteMeat ".
			" Where Tanggal='".$tanggal."' And IDShift='".$idshift."' And IDJamKerja=".$idjamkerja.
			" Group By GroupLine ";
		return $this->db->query($sql);
	}
	
	function get_airkelapa(){
		$tanggal = tgl_eng($this->input->post('txtTanggal'));
		$idshift = $this->input->post('txtShift');
		$idjamkerja = $this->input->post('txtJamKerja');
		
		$sql = "Select GroupLine, NomorMesin, GrandTotal = SUM(TimbangAK) From vwOL_LapHasilAirKelapa ".
			" Where Tanggal='".$tanggal."' And IDShift='".$idshift."' And IDJamKerja=".$idjamkerja.
			" Group By GroupLine, NomorMesin ";
		return $this->db->query($sql);
	}
	
	function get_airkelapa_total(){
		$tanggal = tgl_eng($this->input->post('txtTanggal'));
		$idshift = $this->input->post('txtShift');
		$idjamkerja = $this->input->post('txtJamKerja');
		
		$sql = "Select GroupLine, GrandTotal = SUM(TimbangAK) From vwOL_LapHasilAirKelapa ".
			" Where Tanggal='".$tanggal."' And IDShift='".$idshift."' And IDJamKerja=".$idjamkerja.
			" Group By GroupLine ";
		return $this->db->query($sql);
	}
	
	function get_kelapacungkil(){
		$tanggal = tgl_eng($this->input->post('txtTanggal'));
		$idshift = $this->input->post('txtShift');
		$idjamkerja = $this->input->post('txtJamKerja');
		
		$sql = "Select GroupLine, NomorMesin, GrandTotal = SUM(TimbangKC) From vwOL_LapHasilKelapaCungkil ".
			" Where Tanggal='".$tanggal."' And IDShift='".$idshift."' And IDJamKerja=".$idjamkerja.
			" Group By GroupLine, NomorMesin ";
		return $this->db->query($sql);
	}
	
	function get_kelapacungkil_total(){
		$tanggal = tgl_eng($this->input->post('txtTanggal'));
		$idshift = $this->input->post('txtShift');
		$idjamkerja = $this->input->post('txtJamKerja');
		
		$sql = "Select GroupLine, GrandTotal = SUM(TimbangKC) From vwOL_LapHasilKelapaCungkil ".
			" Where Tanggal='".$tanggal."' And IDShift='".$idshift."' And IDJamKerja=".$idjamkerja.
			" Group By GroupLine ";
		return $this->db->query($sql);
	}
}