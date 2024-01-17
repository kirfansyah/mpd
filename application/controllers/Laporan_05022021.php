<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Laporan extends CI_Controller{
	function __construct() {
        parent::__construct();
		//$this->load->database();
		$this->load->model(array('m_master', 'm_laporan', 'm_monitor', 'm_trnhasil'));
		if(!$this->session->userdata('userid')){
			
            redirect('login');
        }
        ini_set('max_execution_time', 300);
    }
	
	function hasil(){
		$data['cboshift'] = $this->m_master->mst_shift()->result();
		$data['cbojamkerja']= $this->m_master->mst_jamkerja()->result();
		$data['groupline'] = $this->m_master->mst_line_group()->result();
		$data['totalmesinmax'] = $this->m_master->total_mesin_max();
		
		$tanggal	= $this->session->flashdata('lh_tanggal');
		$shift		= $this->session->flashdata('lh_shift');
		$idjamkerja	= $this->session->flashdata('lh_idjamkerja');

		$data['tanggal']	= !empty($tanggal) ? $tanggal : $this->session->userdata('serverdate');
		$data['idshift']	= $shift;
		$data['idjamkerja']	= $idjamkerja;			
		
		$this->template->display('laporan/hasil/index', $data);
	}
	
	function hasil_refresh($jenis = ''){
		$this->form_validation->set_rules('txtTanggal', 'Tanggal','required|callback_check_date['. $this->input->post('txtTanggal'). ']');
		$this->form_validation->set_rules('txtShift', 'Shift','required');
		$this->form_validation->set_rules('txtJamKerja', 'Jam Kerja','required');
		
		$this->form_validation->set_message('required', '<strong>%s</strong> wajib diisi!');
		
		$this->form_validation->set_error_delimiters('<div class="alert alert-error"><a class="close" data-dismiss="alert">×</a><i class="icon-exclamation-sign bigger-130">&nbsp;</i>', '</div>');
		
		if($this->form_validation->run() == false){
			$sess_data['lh_tanggal']	= $this->input->post('txtTanggal');
			$sess_data['lh_shift']		= $this->input->post('txtShift');
			$sess_data['lh_idjamkerja']	= $this->input->post('txtJamKerja');

			$this->session->set_flashdata($sess_data);
			$this->hasil();
		} else {
			$sess_data['lh_tanggal']	= $this->input->post('txtTanggal');
			$sess_data['lh_shift']		= $this->input->post('txtShift');
			$sess_data['lh_idjamkerja']	= $this->input->post('txtJamKerja');

			$this->session->set_flashdata($sess_data);
			
			$data['groupline'] = $this->m_master->mst_line_group()->result();
			$data['totalmesinmax'] = $this->m_master->total_mesin_max();
			
			switch ($jenis) {
				case 'whitemeat':
					$data['record_wm'] = $this->m_laporan->get_whitemeat()->result();
					$data['wm_total'] = $this->m_laporan->get_whitemeat_total()->result();
					$this->load->view('laporan/hasil/whitemeat', $data);
					break;
				
				case 'airkelapa':
					$data['record_ak'] = $this->m_laporan->get_airkelapa()->result();
					$data['ak_total'] = $this->m_laporan->get_airkelapa_total()->result();
					$this->load->view('laporan/hasil/airkelapa', $data);
					break;
				
				case 'kelapacungkil':
					$data['record_kc'] = $this->m_laporan->get_kelapacungkil()->result();
					$data['kc_total'] = $this->m_laporan->get_kelapacungkil_total()->result();
					$this->load->view('laporan/hasil/kelapacungkil', $data);
					break;
			
				default:
					redirect('hasil');
					break;
			}
			
		}
	}
	
	function check_date($tanggal){
		if (valid_date($tanggal) == false){
			$this->form_validation->set_message('check_date', 'Format %s salah! Format yang benar : <strong>hari/bulan/tahun</strong>');
			return FALSE;
		} else {
			return TRUE;
		}
	}
}