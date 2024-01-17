<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Absensi extends CI_Controller{
	function __construct() {
        parent::__construct();
		$this->load->model(array('m_trnhasil','m_master', 'm_absensi'));
		if(!$this->session->userdata('userid')){
            redirect('login');
        }

	}
	
	function to_index($pekerjaan, $showdetail = 0){
		$data['message'] = '';
		$data['cboline'] = $this->m_master->mst_line()->result();
		$data['cboshift'] = $this->m_master->mst_shift()->result();
		$data['cbojamkerja']= $this->m_master->mst_jamkerja()->result();
				
		switch ($pekerjaan) {
			case 'sheller':
				$idpekerjaan = 2;
				$idline	= $this->session->userdata('shl_idline');
				$shift	= $this->session->userdata('shl_shift');
				$idjamkerja = $this->session->userdata('shl_idjamkerja');
				break;
			
			case 'parer':
				$idpekerjaan = 3;
				$idline	= $this->session->userdata('par_idline');
				$shift	= $this->session->userdata('par_shift');
				$idjamkerja	= $this->session->userdata('par_idjamkerja');
				break;
			
		default:
			break;
		}
		
		$qline = $this->m_master->mst_line($idline)->result();
		foreach ($qline as $r){
			$namaline = $r->NamaLine;
			$nomesinawal = $r->NomorMesinAwal;
			$nomesinakhir = $r->NomorMesinAkhir;
		}
		
		$data['idpekerjaan']= $idpekerjaan;
		$data['pekerjaan']	= $pekerjaan;
		$data['idline']		= $idline;
//		$data['namaline']	= $this->m_master->get_nama_line($idline);
		$data['namaline']	= $namaline;
		$data['nomesinawal']= $nomesinawal;
		$data['nomesinakhir']=$nomesinakhir;
		$data['idshift']	= $shift;
		$data['idjamkerja']	= $idjamkerja;
		$data['showdetail'] = $showdetail;
		
		if (!$this->session->flashdata('mesinaktif')){
			$mesinaktif = $nomesinawal;
		} else {
			$mesinaktif = $this->session->flashdata('mesinaktif');
		}
		$data['mesinaktif']	= $mesinaktif;
		
		if ($showdetail == 1){
			$record = $this->m_absensi->refresh_data($idpekerjaan, $idline, $shift)->result();
			$data['listtk'] = $record;
		}
		
		$this->template->display('absensi/'.$pekerjaan.'/index', $data);
		
	}
	
	function sheller($aksi = ''){
		switch ($aksi) {
			case 'end_session':
				$this->hapus_session('sheller');
				break;

			default:
				if (!$this->session->userdata('shl_idline') || !$this->session->userdata('shl_shift')){
					$this->to_index('sheller');
				} else {
					$this->to_index('sheller', 1);				
				}

				break;
		}		
	}
	
	function parer($aksi = ''){
		switch ($aksi) {
			case 'end_session':
				$this->hapus_session('parer');
				break;

			default:
				if (!$this->session->userdata('par_idline') || !$this->session->userdata('par_shift')){
					$this->to_index('parer');
				} else {
					$this->to_index('parer', 1);
				}
				
				break;
		}
	}
	
	function hapus_session($pekerjaan){
		switch ($pekerjaan) {
			case 'sheller':
				$this->session->unset_userdata('shl_idline');
				$this->session->unset_userdata('shl_shift');
				$this->session->unset_userdata('shl_idpekerjaan');
				$this->session->unset_userdata('shl_idjamkerja');
				break;
			case 'parer':
				$this->session->unset_userdata('par_idline');
				$this->session->unset_userdata('par_shift');
				$this->session->unset_userdata('par_idpekerjaan');
				$this->session->unset_userdata('par_idjamkerja');
				break;
			default:
				break;
		}
				
		redirect('absensi/'.$pekerjaan);
	}
	
	function proses_absensi(){
		$idpekerjaan = $this->input->post('txtIDPekerjaan');
		
		switch ($idpekerjaan) {
			case 2:
				$pekerjaan = 'sheller';
				$prefix = 'shl';
				break;
			
			case 3:
				$pekerjaan = 'parer';
				$prefix = 'par';
				break;

			default:
				break;
		}
		
		$this->form_validation->set_rules('txtLine', 'Line','required');
		$this->form_validation->set_rules('txtShift', 'Shift','required');
		$this->form_validation->set_rules('txtJamKerja', 'Jam Kerja','required');
		
		$this->form_validation->set_message('required', '<strong>%s</strong> wajib diisi!');
		
		$this->form_validation->set_error_delimiters('<div class="alert alert-error"><a class="close" data-dismiss="alert">×</a><i class="icon-exclamation-sign bigger-130">&nbsp;</i>', '</div>');
		
		if($this->form_validation->run()==false){
			$this->to_index($pekerjaan);
		}else{		
			$sess_data[$prefix.'_idline']		= $this->input->post('txtLine');
			$sess_data[$prefix.'_shift']		= $this->input->post('txtShift');
			$sess_data[$prefix.'_idjamkerja']	= $this->input->post('txtJamKerja');
			$sess_data[$prefix.'_idpekerjaan']	= $idpekerjaan;
			$this->session->set_userdata($sess_data);
			
			redirect('absensi/'.$pekerjaan);
		}
	
	}
}