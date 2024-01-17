<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function tgl_eng($tgl) {
	$tanggal  = substr($tgl,0,2);
	$bulan	= substr($tgl,3,2);
	$tahun	= substr($tgl,6,4);
	return $tahun.'-'.$bulan.'-'.$tanggal;
}

function tgl_ind($tgl) {
	return date("d/m/Y",  strtotime($tgl));
}

function current_date_eng(){
	date_default_timezone_set('Asia/Jakarta');
	return date("Y-m-d H:i:s");
}

function datetime_ind($datetime){	
	if (is_null($datetime)){
		$result = '';
	}else{
		$result = date("d/m/Y H:i:s", strtotime($datetime));
	}
	return $result;
}

function datetime_eng($datetime){	
	if (is_null($datetime)){
		$result = '';
	}else{
		$result = date("Y-m-d H:i:s", strtotime($datetime));
	}
	return $result;
}

