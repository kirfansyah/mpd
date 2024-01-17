<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Hasil_harian extends CI_Controller{
	function __construct() {
        parent::__construct();
		
		$this->load->model(array('m_trnhasil','m_master', 'm_absensi', 'm_trn_harian'));
		if(!$this->session->userdata('userid')){
			
            redirect('login');
        }
        ini_set('max_execution_time', 300);
	}


	function get_hasil_parer(){
		$header_id 	= $this->input->post('header_id');
		$NIK 		= $this->input->post('NIK');
		$hasil 		= $this->m_trn_harian->get_hasil_parer($header_id, $NIK);
		echo json_encode($hasil);
	}

	function get_hasil_sheller(){
		$header_id 	= $this->input->post('header_id');
		$NIK 		= $this->input->post('NIK');
		$hasil 		= $this->m_trn_harian->get_hasil_sheller($header_id, $NIK);
		echo json_encode($hasil);
	}

	function simpan_hasil(){
		$hasil_header_id	= $this->input->post('headerHasilId');
		$urut_dtl_id		= $this->input->post('urutDtlId');
		$hasil_WM			= $this->input->post('hasilWM');
		$hasil_AK			= $this->input->post('hasilAK');
			
		if ($hasil_WM == ''){
			$hasil_WM = '0';
		} else {
			$hasil_WM = number_format($hasil_WM,4);
		}
		
		if ($hasil_AK == ''){
			$hasil_AK = '0';
		} else {
			$hasil_AK = number_format($hasil_AK,4);
		}

		if ($this->m_trn_harian->get_aksi($hasil_header_id, $urut_dtl_id) === 1){
			$info = array(
				'HasilWM'			=>str_replace(',', '', $hasil_WM),
				'HasilAK'			=>$hasil_AK,
				'UpdateBy'			=> strtoupper($this->session->userdata('userid')),
				'UpdateDate'		=> date('Y-m-d H:i:s')
			);

			if ($this->m_trn_harian->update_hasil_harian($hasil_header_id, $urut_dtl_id, $info) === 1){
				$pesan = pesan('Simpan data hasil pegawai harian berhasil', 'success');
			} else {
				$err = mssql_get_last_message();
				$pesan = pesan('Simpan data hasil pegawai harian gagal.<br>Pesan : '. $err, pesan_error());			
			}

		}else{
			$info = array(
				'HasilHeaderID'		=>$hasil_header_id,
				'UrutDtlID'			=>$urut_dtl_id,
				'HasilWM'			=>str_replace(',', '', $hasil_WM),
				'HasilAK'			=>$hasil_AK,
				'CreatedBy'			=> strtoupper($this->session->userdata('userid')),
				'CreatedDate'		=> date('Y-m-d H:i:s')
			);
			if ($this->m_trn_harian->simpan_hasil_harian($info) === 1){
				$pesan = pesan('Simpan data hasil pegawai harian berhasil', 'success');
			} else {
				$err = mssql_get_last_message();
				$pesan = pesan('Simpan data hasil pegawai harian gagal.<br>Pesan : '. $err, pesan_error());			
			}
		}
	}

	function hapus_hasil(){
		$urut_dtl_id		= $this->input->post('urutDtlId');

		if ($this->m_trn_harian->hapus_hasil_harian($urut_dtl_id) === 1){
				$pesan = pesan('Hapus data hasil pegawai harian berhasil', 'success');
		} else {
				$err = mssql_get_last_message();
				$pesan = pesan('Hapus data hasil pegawai harian gagal.<br>Pesan : '. $err, pesan_error());			
		}

	}

}