<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Monitor extends CI_Controller{
	function __construct() {
        parent::__construct();
		$this->load->database();
		$this->load->model(array('m_master', 'm_monitor', 'm_trnhasil'));
		if(!$this->session->userdata('userid')){
			
            redirect('login');
        }
        ini_set('max_execution_time', 300);
    }
	
//	function hasil(){
////		$kerja = $this->uri->segment(3);
//		$data['cboline'] = $this->m_master->mst_line()->result();
//		$data['cboshift'] = $this->m_master->mst_shift()->result();
//		$data['cbojamkerja']= $this->m_master->mst_jamkerja()->result();
//		
//		$tanggal	= $this->session->flashdata('mh_tanggal');
//		$idline		= $this->session->flashdata('mh_idline');
//		$shift		= $this->session->flashdata('mh_shift');
//		$idjamkerja	= $this->session->flashdata('mh_idjamkerja');
//		
//		$headerid = $this->m_monitor->get_headerid($tanggal, $idline, $shift);
//		
//		$data['record_sheller'] = $this->m_monitor->monitor_sheller($headerid)->result();
//		$data['record_parer'] = '';
//		
//		$data['tanggal']	= !empty($tanggal) ? $tanggal : $this->session->userdata('serverdate');
//		$data['idline']		= !empty($idline) ? $idline : '';
//		$data['idshift']	= $shift;
//		$data['idjamkerja']	= $idjamkerja;
//		
//		$this->template->display_monitor('hasil', 'monitor/hasil/monhasil', $data);
//	}
	
	function hasil(){
		if (isset($_POST['btnRefresh'])){
			$this->form_validation->set_rules('txtTanggal', 'Tanggal','required|callback_check_date['. $this->input->post('txtTanggal'). ']');
			$this->form_validation->set_rules('txtLine', 'Line','required');
			$this->form_validation->set_rules('txtShift', 'Shift','required');
			$this->form_validation->set_rules('txtJamKerja','Jam Kerja','required');
			$this->form_validation->set_message('required', '<strong>%s</strong> wajib diisi!');

			$this->form_validation->set_error_delimiters('<div class="alert alert-error"><a class="close" data-dismiss="alert">×</a><i class="icon-exclamation-sign bigger-130">&nbsp;</i>', '</div>');
			
			if($this->form_validation->run() == false){
				$this->to_index('hasil');
			} else {
				$this->show_hasil();
			}
		} else {
			$this->to_index('hasil');
		}
	}
	
	function show_hasil(){
		$tanggal	= $this->input->post('txtTanggal');
		$idline		= $this->input->post('txtLine');
		$shift		= $this->input->post('txtShift');
		$idjamkerja = $this->input->post('txtJamKerja');
		
		$qline = $this->m_master->mst_line($idline)->result();
		foreach ($qline as $r){
			$namaline = $r->NamaLine;
		}
		
		$qjamkerja = $this->m_master->mst_jamkerja($idjamkerja)->result();
		foreach ($qjamkerja as $r){
			$jamkerja = $r->JamKerja;
		}
		
		$headerid = $this->m_monitor->get_headerid($tanggal, $idline, $shift, $idjamkerja);
		$inspector = $this->m_trnhasil->get_jurucatat($headerid);
		$loguser = $this->m_monitor->get_loguser($headerid);
		$jurucatat = array (
			'AK' => $inspector,
			'WM' => $inspector
		);
		//if ($loguser->num_rows() > 0) {
			foreach ($loguser->result() as $r) {
				$jurucatat[trim($r->JenisTrn)] = $r->Username;
			}
		//}
		$data['tanggal']	= $tanggal;
		$data['namaline']	= $namaline;
		$data['shift']		= $shift;
		$data['headerid']	= $headerid;
		$data['jurucatat']	= $jurucatat;
		$data['jamkerja'] 	= $jamkerja;
		
		$shel_data['record_sheller'] = $this->m_monitor->monitor_sheller($headerid, 'SHELLER BORONGAN')->result();
		$data['_sheller']	= $this->load->view('monitor/hasil/monhasil_sheller', $shel_data, true);
		
		$par_data['record_parer'] = $this->m_monitor->monitor_parer($headerid, 'PARER BORONGAN')->result();
		$data['_parer']	= $this->load->view('monitor/hasil/monhasil_parer', $par_data, true);
		
		$shel_har_data['record_sheller'] = $this->m_monitor->monitor_sheller($headerid, 'HARIAN')->result();
		$data['_sheller_harian']	= $this->load->view('monitor/hasil/monhasil_sheller_harian', $shel_har_data, true);
		
		$par_har_data['record_parer'] = $this->m_monitor->monitor_parer($headerid, 'HARIAN')->result();
		$data['_parer_harian']	= $this->load->view('monitor/hasil/monhasil_parer_harian', $par_har_data, true);
		
		// $shel_lain = $this->m_monitor->monitor_sheller_lain($headerid)->result();
		// $par_lain = $this->m_monitor->monitor->parer_lain($headerid)->result();
		// $hasil_lain = array_merge($
		
		$this->template->display('monitor/hasil/monhasil', $data);
	}
	
	function refresh_hasil(){
		$this->form_validation->set_rules('txtTanggal', 'Tanggal','required|callback_check_date['. $this->input->post('txtTanggal'). ']');
		$this->form_validation->set_rules('txtLine', 'Line','required');
		$this->form_validation->set_rules('txtShift', 'Shift','required');
		$this->form_validation->set_rules('txtJamKerja', 'Jam Kerja','required');
		
		$this->form_validation->set_message('required', '<strong>%s</strong> wajib diisi!');
		
		$this->form_validation->set_error_delimiters('<div class="alert alert-error"><a class="close" data-dismiss="alert">×</a><i class="icon-exclamation-sign bigger-130">&nbsp;</i>', '</div>');
		
		if($this->form_validation->run() == false){
			$this->hasil();
		} else {
			$sess_data['mh_tanggal']	= $this->input->post('txtTanggal');
			$sess_data['mh_idline']		= $this->input->post('txtLine');
			$sess_data['mh_shift']		= $this->input->post('txtShift');
			$sess_data['mh_idjamkerja']	= $this->input->post('txtJamKerja');

			$this->session->set_flashdata($sess_data);			
			redirect('monitor/hasil');
		}		
		
	}
	
//	FUNGSI MONITOR PER TRANSAKSI
	
	function to_index($halaman){
		$this->load->model(array('m_trn_isikeranjang','m_trn_timbangwm','m_trn_timbangak','m_trn_hasilkc'));
		$data['message'] = '';
		$data['cboline'] = $this->m_master->mst_line()->result();
		$data['cboshift'] = $this->m_master->mst_shift()->result();
		$data['cbojamkerja']= $this->m_master->mst_jamkerja()->result();
				
		switch ($halaman) {
			case 'keranjang':
				$data['record'] = $this->m_trn_isikeranjang->list_isi_keranjang()->result();
				$this->template->display('monitor/isi_keranjang/index',$data);
				break;
			
			case 'whitemeat':
				$data['record'] = $this->m_trn_timbangwm->list_timbangwm()->result();
				$this->template->display('monitor/timbang_wm/index',$data);
				break;
			
			case 'airkelapa':
				$data['record'] =$this->m_trn_timbangak->list_timbangak()->result();
				$this->template->display('monitor/timbang_ak/index',$data);
				break;
			
			case 'kelapacungkil':
				$data['record'] =$this->m_trn_hasilkc->list_hasilkc()->result();
				$this->template->display('monitor/kelapacungkil/index',$data);
				break;
			
			case 'hasil':
				$tanggal		 = $this->input->post('txtTanggal');
				$data['tanggal'] = (isset($_POST['txtTanggal']) ? $tanggal : $this->session->userdata('serverdate'));
				
				$this->template->display('monitor/hasil/index',$data);
				break;
			
			default:
				break;
		}
		
	}
	
	function pengisian_keranjang(){
		if (!$this->session->userdata('krj_idline') || !$this->session->userdata('krj_shift')){
			if (isset($_POST['btnRefresh'])){
				$this->form_validation->set_rules('txtTanggal', 'Tanggal','required|callback_check_date['. $this->input->post('txtTanggal'). ']');
				$this->form_validation->set_rules('txtLine', 'Line','required');
				$this->form_validation->set_rules('txtShift', 'Shift','required');
				$this->form_validation->set_rules('txtJamKerja', 'Jam Kerja','required');

				$this->form_validation->set_message('required', '<strong>%s</strong> wajib diisi!');

				$this->form_validation->set_error_delimiters('<div class="alert alert-error"><a class="close" data-dismiss="alert">×</a><i class="icon-exclamation-sign bigger-130">&nbsp;</i>', '</div>');

				if($this->form_validation->run()==false){
					$this->to_index('keranjang');
				}else{
					$tanggal	= $this->input->post('txtTanggal');
 					$idline		= $this->input->post('txtLine');
					$shift		= $this->input->post('txtShift');
					$idjamkerja	= $this->input->post('txtJamKerja');

					$qjamkerja = $this->m_master->mst_jamkerja($idjamkerja)->result();
					foreach ($qjamkerja as $r) {
						$jamkerja	= $r->JamKerja;
						$jammasuk	= $r->JamMasuk;
					}

					$qline = $this->m_master->mst_line($idline)->result();
					foreach ($qline as $r){
						$namaline = $r->NamaLine;
						$nomesinawal = $r->NomorMesinAwal;
						$nomesinakhir = $r->NomorMesinAkhir;
					}

					$headerid = $this->m_trnhasil->get_header_hasil($tanggal, $idline, $idjamkerja);
					$jurucatat = $this->m_trnhasil->get_jurucatat($headerid);
					
					$data['cboline'] = $this->m_master->mst_line()->result();
					$data['cboshift'] = $this->m_master->mst_shift()->result();
					$data['cbojamkerja']= $this->m_master->mst_jamkerja()->result();
					
					$data['idline'] = $idline;
					$data['idjamkerja'] = $idjamkerja;

					$data['tanggaltrn']	= $tanggal;
					$data['namaline']	= $namaline;
					$data['nomesinawal'] = $nomesinawal;
					$data['nomesinakhir'] = $nomesinakhir;
					$data['shift']		= $shift;
					$data['jamkerja']	= $jamkerja;
					$data['jammasuk']	= $jammasuk;
					$data['headerid']	= $headerid;
					$data['jurucatat']	= $jurucatat;

					$record = $this->m_monitor->monitor_isikeranjang($headerid, $idline);
			
					$data['record']		= $record->result();

					$this->template->display('monitor/isi_keranjang/mon_isikrj', $data);
				}
			} else {
				$this->to_index('keranjang');
			}
		} else {		
			$tanggal	= $this->session->userdata('krj_tanggal');
			$idline		= $this->session->userdata('krj_idline');
			$shift		= $this->session->userdata('krj_shift');
			$idjamkerja	= $this->session->userdata('krj_idjamkerja');

			$qline = $this->m_master->mst_line($idline)->result();
			foreach ($qline as $r){
				$namaline = $r->NamaLine;
				$nomesinawal = $r->NomorMesinAwal;
				$nomesinakhir = $r->NomorMesinAkhir;
			}

			$qjamkerja = $this->m_master->mst_jamkerja($idjamkerja)->result();
			foreach ($qjamkerja as $r) {
				$jamkerja	= $r->JamKerja;
				$jammasuk	= $r->JamMasuk;
			}
			
			$headerid = $this->m_trnhasil->get_header_hasil($tanggal, $idline, $idjamkerja);
			$jurucatat = $this->m_trnhasil->get_jurucatat($headerid);
			
			$data['cboline'] = $this->m_master->mst_line()->result();
			$data['cboshift'] = $this->m_master->mst_shift()->result();
			$data['cbojamkerja']= $this->m_master->mst_jamkerja()->result();

			$data['idline'] = $idline;
			$data['idjamkerja'] = $idjamkerja;

			$data['tanggaltrn']	= $tanggal;
			$data['namaline']	= $idline ? $namaline : '';
			$data['nomesinawal'] = $nomesinawal;
			$data['nomesinakhir'] = $nomesinakhir;
			$data['shift']		= $shift;
			$data['jamkerja']	= $idjamkerja ? $jamkerja : '';
			$data['jammasuk']	= $jammasuk;
			$data['headerid']	= $headerid;
			$data['jurucatat']	= $jurucatat;
			
			$record = $this->m_monitor->monitor_isikeranjang($headerid, $idline);
			
			$data['record']		= $record->result();

			$this->template->display('monitor/isi_keranjang/mon_isikrj', $data);
		}
	}
	
	function timbang_whitemeat(){
		if (!$this->session->userdata('wm_idline') || !$this->session->userdata('wm_shift')){
			if (isset($_POST['btnRefresh'])){
				$this->form_validation->set_rules('txtTanggal', 'Tanggal','required|callback_check_date['. $this->input->post('txtTanggal'). ']');
				$this->form_validation->set_rules('txtLine', 'Line','required');
				$this->form_validation->set_rules('txtShift', 'Shift','required');
				$this->form_validation->set_rules('txtJamKerja', 'Jam Kerja','required');

				$this->form_validation->set_message('required', '<strong>%s</strong> wajib diisi!');

				$this->form_validation->set_error_delimiters('<div class="alert alert-error"><a class="close" data-dismiss="alert">×</a><i class="icon-exclamation-sign bigger-130">&nbsp;</i>', '</div>');

				if($this->form_validation->run()==false){
					$this->to_index('whitemeat');
				}else{
					$tanggal	= $this->input->post('txtTanggal');
					$idline		= $this->input->post('txtLine');
					$shift		= $this->input->post('txtShift');
					$idjamkerja	= $this->input->post('txtJamKerja');
					
					$qjamkerja = $this->m_master->mst_jamkerja($idjamkerja)->result();
					foreach ($qjamkerja as $r) {
						$jamkerja	= $r->JamKerja;
						$jammasuk	= $r->JamMasuk;
					}

					$qline = $this->m_master->mst_line($idline)->result();
					foreach ($qline as $r){
						$namaline = $r->NamaLine;
						$nomesinawal = $r->NomorMesinAwal;
						$nomesinakhir = $r->NomorMesinAkhir;
					}

					$headerid = $this->m_trnhasil->get_header_hasil($tanggal, $idline, $idjamkerja,$shift);
					$jurucatat = $this->m_trnhasil->get_jurucatat($headerid);
					
					$data['cboline'] = $this->m_master->mst_line()->result();
					$data['cboshift'] = $this->m_master->mst_shift()->result();
					$data['cbojamkerja']= $this->m_master->mst_jamkerja()->result();
					
					$data['idline'] = $idline;
					$data['idjamkerja'] = $idjamkerja;

					$data['tanggaltrn']	= $tanggal;
					$data['namaline']	= $namaline;
					$data['nomesinawal'] = $nomesinawal;
					$data['nomesinakhir'] = $nomesinakhir;
					$data['shift']		= $shift;
					$data['jamkerja']	= $jamkerja;
					$data['jammasuk']	= $jammasuk;
					$data['headerid']	= $headerid;
					$data['jurucatat']	= $jurucatat;

					$record = $this->m_monitor->monitor_whitemeat($headerid, $idline);
			
					$data['record']		= $record->result();

					$this->template->display('monitor/timbang_wm/mon_whitemeat', $data);
				}
			} else {
				$this->to_index('whitemeat');
			}
		} else {
			$tanggal = $this->session->userdata('wm_tanggal');
			$shift = $this->session->userdata('wm_shift');
			$idline = $this->session->userdata('wm_idline');
			$idjamkerja = $this->session->userdata('wm_idjamkerja');

			$qjamkerja = $this->m_master->mst_jamkerja($idjamkerja)->result();
			foreach ($qjamkerja as $r) {
				$jamkerja	= $r->JamKerja;
				$jammasuk	= $r->JamMasuk;
			}

			$qline = $this->m_master->mst_line($idline)->result();
			foreach ($qline as $r){
				$namaline = $r->NamaLine;
				$nomesinawal = $r->NomorMesinAwal;
				$nomesinakhir = $r->NomorMesinAkhir;
			}
			
			$headerid = $this->m_trnhasil->get_header_hasil($tanggal, $idline, $idjamkerja, $shift);
			$jurucatat = $this->m_trnhasil->get_jurucatat($headerid);
			
			$data['cboline'] = $this->m_master->mst_line()->result();
			$data['cboshift'] = $this->m_master->mst_shift()->result();
			$data['cbojamkerja']= $this->m_master->mst_jamkerja()->result();
			
			$data['idline'] = $idline;
			$data['idjamkerja'] = $idjamkerja;

			$data['tanggaltrn']	= $tanggal;
			$data['namaline']	= $namaline;
			$data['nomesinawal'] = $nomesinawal;
			$data['nomesinakhir'] = $nomesinakhir;
			$data['shift']		= $shift;
			$data['jamkerja']	= $jamkerja;
			$data['jammasuk']	= $jammasuk;
			$data['headerid']	= $headerid;
			$data['jurucatat']	= $jurucatat;
			
			$record = $this->m_monitor->monitor_whitemeat($headerid, $idline);
			
			$data['record']		= $record->result();
			
			$this->template->display('monitor/timbang_wm/mon_whitemeat', $data);
		}
	}
	
	function timbang_airkelapa(){
		if (!$this->session->userdata('ak_idline') || !$this->session->userdata('ak_shift')){
			if (isset($_POST['btnRefresh'])){
				$this->form_validation->set_rules('txtTanggal', 'Tanggal','required|callback_check_date['. $this->input->post('txtTanggal'). ']');
				$this->form_validation->set_rules('txtLine', 'Line','required');
				$this->form_validation->set_rules('txtShift', 'Shift','required');
				$this->form_validation->set_rules('txtJamKerja', 'Jam Kerja','required');

				$this->form_validation->set_message('required', '<strong>%s</strong> wajib diisi!');

				$this->form_validation->set_error_delimiters('<div class="alert alert-error"><a class="close" data-dismiss="alert">×</a><i class="icon-exclamation-sign bigger-130">&nbsp;</i>', '</div>');

				if($this->form_validation->run()==false){
					$this->to_index('airkelapa');
				}else{
					$tanggal	= $this->input->post('txtTanggal');
					$idline		= $this->input->post('txtLine');
					$shift		= $this->input->post('txtShift');
					$idjamkerja	= $this->input->post('txtJamKerja');

					$qjamkerja = $this->m_master->mst_jamkerja($idjamkerja)->result();
					foreach ($qjamkerja as $r) {
						$jamkerja	= $r->JamKerja;
						$jammasuk	= $r->JamMasuk;
					}

					$qline = $this->m_master->mst_line($idline)->result();
					foreach ($qline as $r){
						$namaline = $r->NamaLine;
						$nomesinawal = $r->NomorMesinAwal;
						$nomesinakhir = $r->NomorMesinAkhir;
					}

					$headerid = $this->m_trnhasil->get_header_hasil($tanggal, $idline, $idjamkerja,$shift);
					$jurucatat = $this->m_trnhasil->get_jurucatat($headerid);
					
					$data['cboline'] = $this->m_master->mst_line()->result();
					$data['cboshift'] = $this->m_master->mst_shift()->result();
					$data['cbojamkerja']= $this->m_master->mst_jamkerja()->result();
					
					$data['idline'] = $idline;
					$data['idjamkerja'] = $idjamkerja;

					$data['tanggaltrn']	= $tanggal;
					$data['namaline']	= $namaline;
					$data['nomesinawal'] = $nomesinawal;
					$data['nomesinakhir'] = $nomesinakhir;
					$data['shift']		= $shift;
					$data['jamkerja']	= $jamkerja;
					$data['jammasuk']	= $jammasuk;
					$data['headerid']	= $headerid;
					$data['jurucatat']	= $jurucatat;

					$record = $this->m_monitor->monitor_airkelapa($headerid, $idline);

					$data['record']		= $record->result();

					$this->template->display('monitor/timbang_ak/mon_airkelapa', $data);

				}
			} else {
				$this->to_index('airkelapa');
			}
		} else {
			$tanggal = $this->session->userdata('ak_tanggal');
			$shift = $this->session->userdata('ak_shift');
			$idline = $this->session->userdata('ak_idline');
			$idjamkerja = $this->session->userdata('ak_idjamkerja');

			$qjamkerja = $this->m_master->mst_jamkerja($idjamkerja)->result();
			foreach ($qjamkerja as $r) {
				$jamkerja	= $r->JamKerja;
				$jammasuk	= $r->JamMasuk;
			}

			$qline = $this->m_master->mst_line($idline)->result();
			foreach ($qline as $r){
				$namaline = $r->NamaLine;
				$nomesinawal = $r->NomorMesinAwal;
				$nomesinakhir = $r->NomorMesinAkhir;
			}
			
			$headerid = $this->m_trnhasil->get_header_hasil($tanggal, $idline, $idjamkerja);
			$jurucatat = $this->m_trnhasil->get_jurucatat($headerid);
			
			$data['cboline'] = $this->m_master->mst_line()->result();
			$data['cboshift'] = $this->m_master->mst_shift()->result();
			$data['cbojamkerja']= $this->m_master->mst_jamkerja()->result();

			$data['idline'] = $idline;
			$data['idjamkerja'] = $idjamkerja;

			$data['tanggaltrn']	= $tanggal;
			$data['namaline']	= $namaline;
			$data['nomesinawal'] = $nomesinawal;
			$data['nomesinakhir'] = $nomesinakhir;
			$data['shift']		= $shift;
			$data['jamkerja']	= $jamkerja;
			$data['jammasuk']	= $jammasuk;
			$data['headerid']	= $headerid;
			$data['jurucatat']	= $jurucatat;
			
			$record = $this->m_monitor->monitor_airkelapa($headerid, $idline);
			
			$data['record']		= $record->result();
			
			$this->template->display('monitor/timbang_ak/mon_airkelapa', $data);
		}
	}
	
	function kelapacungkil(){
		if (!$this->session->userdata('kc_idline') || !$this->session->userdata('kc_shift')){
			if (isset($_POST['btnRefresh'])){
				$this->form_validation->set_rules('txtTanggal', 'Tanggal','required|callback_check_date['. $this->input->post('txtTanggal'). ']');
				$this->form_validation->set_rules('txtLine', 'Line','required');
				$this->form_validation->set_rules('txtShift', 'Shift','required');
				$this->form_validation->set_rules('txtJamKerja', 'Jam Kerja','required');

				$this->form_validation->set_message('required', '<strong>%s</strong> wajib diisi!');

				$this->form_validation->set_error_delimiters('<div class="alert alert-error"><a class="close" data-dismiss="alert">×</a><i class="icon-exclamation-sign bigger-130">&nbsp;</i>', '</div>');

				if($this->form_validation->run()==false){
					$this->to_index('kelapacungkil');
				}else{
					$tanggal	= $this->input->post('txtTanggal');
					$idline		= $this->input->post('txtLine');
					$shift		= $this->input->post('txtShift');
					$idjamkerja	= $this->input->post('txtJamKerja');

					$qjamkerja = $this->m_master->mst_jamkerja($idjamkerja)->result();
					foreach ($qjamkerja as $r) {
						$jamkerja	= $r->JamKerja;
						$jammasuk	= $r->JamMasuk;
					}

					$qline = $this->m_master->mst_line($idline)->result();
					foreach ($qline as $r){
						$namaline = $r->NamaLine;
						$nomesinawal = $r->NomorMesinAwal;
						$nomesinakhir = $r->NomorMesinAkhir;
					}

					$headerid = $this->m_trnhasil->get_header_hasil($tanggal, $idline, $idjamkerja);
					$jurucatat = $this->m_trnhasil->get_jurucatat($headerid);
					
					$data['cboline'] = $this->m_master->mst_line()->result();
					$data['cboshift'] = $this->m_master->mst_shift()->result();
					$data['cbojamkerja']= $this->m_master->mst_jamkerja()->result();
					
					$data['idline'] = $idline;
					$data['idjamkerja'] = $idjamkerja;

					$data['tanggaltrn']	= $tanggal;
					$data['namaline']	= $namaline;
					$data['nomesinawal'] = $nomesinawal;
					$data['nomesinakhir'] = $nomesinakhir;
					$data['shift']		= $shift;
					$data['jamkerja']	= $jamkerja;
					$data['jammasuk']	= $jammasuk;
					$data['headerid']	= $headerid;
					$data['jurucatat']	= $jurucatat;

					$record = $this->m_monitor->monitor_kelapacungkil($headerid, $idline);

					$data['record']		= $record->result();

					$this->template->display('monitor/kelapacungkil/mon_kacung', $data);

				}
			} else {
				$this->to_index('kelapacungkil');
			}
		} else {
			$tanggal = $this->session->userdata('kc_tanggal');
			$shift = $this->session->userdata('kc_shift');
			$idline = $this->session->userdata('kc_idline');
			$idjamkerja = $this->session->userdata('kc_idjamkerja');

			$qjamkerja = $this->m_master->mst_jamkerja($idjamkerja)->result();
			foreach ($qjamkerja as $r) {
				$jamkerja	= $r->JamKerja;
				$jammasuk	= $r->JamMasuk;
			}

			$qline = $this->m_master->mst_line($idline)->result();
			foreach ($qline as $r){
				$namaline = $r->NamaLine;
				$nomesinawal = $r->NomorMesinAwal;
				$nomesinakhir = $r->NomorMesinAkhir;
			}
			
			$headerid = $this->m_trnhasil->get_header_hasil($tanggal, $idline, $idjamkerja);
			$jurucatat = $this->m_trnhasil->get_jurucatat($headerid);
			
			$data['cboline'] = $this->m_master->mst_line()->result();
			$data['cboshift'] = $this->m_master->mst_shift()->result();
			$data['cbojamkerja']= $this->m_master->mst_jamkerja()->result();

			$data['idline'] = $idline;
			$data['idjamkerja'] = $idjamkerja;

			$data['tanggaltrn']	= $tanggal;
			$data['namaline']	= $namaline;
			$data['nomesinawal'] = $nomesinawal;
			$data['nomesinakhir'] = $nomesinakhir;
			$data['shift']		= $shift;
			$data['jamkerja']	= $jamkerja;
			$data['jammasuk']	= $jammasuk;
			$data['headerid']	= $headerid;
			$data['jurucatat']	= $jurucatat;
			
			$record = $this->m_monitor->monitor_kelapacungkil($headerid, $idline);
			
			$data['record']		= $record->result();
			
			$this->template->display('monitor/kelapacungkil/mon_kacung', $data);
		}
	}
	
	function detail($halaman){
		$headerid = $this->input->get('id',true);
		$detheader = $this->m_master->get_hasilheader($headerid)->result();
		$jurucatat = $this->m_trnhasil->get_jurucatat($headerid);
		
		foreach ($detheader as $r) {
			$idline				= $r->IDLine;
			$data['idline']		= $idline;
			$data['idjamkerja']	= $r->IDJamKerja;
			$data['tanggaltrn']	= tgl_ind($r->Tanggal);
			$data['namaline']	= $r->NamaLine;
			$data['nomesinawal'] = $r->NomorMesinAwal;
			$data['nomesinakhir'] = $r->NomorMesinAkhir;
			$data['shift']		= $r->IDShift;
			$data['jamkerja']	= $r->JamKerja;
			$data['jammasuk']	= $r->JamMasuk;
			$data['headerid']	= $headerid;
			$data['jurucatat']	= $jurucatat;
		}
		
		$data['cboline'] = $this->m_master->mst_line()->result();
		$data['cboshift'] = $this->m_master->mst_shift()->result();
		$data['cbojamkerja']= $this->m_master->mst_jamkerja()->result();
					
		switch ($halaman) {
			case 'keranjang':
				$record = $this->m_monitor->monitor_isikeranjang($headerid, $idline);			
				$data['record']		= $record->result();
				$this->template->display('monitor/isi_keranjang/mon_isikrj', $data);
				break;
			
			case 'whitemeat':
				$record = $this->m_monitor->monitor_whitemeat($headerid, $idline);
				$data['record']		= $record->result();
				$this->template->display('monitor/timbang_wm/mon_whitemeat', $data);
				break;
			
			case 'airkelapa':
				$record = $this->m_monitor->monitor_airkelapa($headerid, $idline);
				$data['record']		= $record->result();
				$this->template->display('monitor/timbang_ak/mon_airkelapa', $data);
				break;
			
			case 'kelapacungkil':
				$record = $this->m_monitor->monitor_kelapacungkil($headerid, $idline);
				$data['record']		= $record->result();
				$this->template->display('monitor/kelapacungkil/mon_kacung', $data);
				break;
			
			default:
				break;
		}
	}
	
//	FUNGSI MONITOR ABSENSI
	
	function absensi(){
		$data['cboline'] = $this->m_master->mst_line()->result();
		$data['cboshift'] = $this->m_master->mst_shift()->result();
		$data['cbojamkerja']= $this->m_master->mst_jamkerja()->result();
		$data['message'] = 'Silakan Tentukan Tanggal, Line, Shift dan Jenis Pekerjaan Diatas!';
		
		$tanggal		= $this->input->post('txtTanggal');
		$idline			= $this->input->post('txtLine');
		$idshift		= $this->input->post('txtShift');		
		$idpekerjaan	= $this->input->post('txtPekerjaan');
		
		$data['tanggal']		= (isset($_POST['txtTanggal']) ? $tanggal : $this->session->userdata('serverdate'));
		$data['idline']			= $idline;
		$data['idshift']		= $idshift;		
		$data['idpekerjaan']	= $idpekerjaan;
		
		$record = null;
		
		$this->form_validation->set_rules('txtLine', 'Line','required');
		$this->form_validation->set_rules('txtShift', 'Shift','required');
		$this->form_validation->set_rules('txtPekerjaan', 'Pekerjaan','required');
		
		$this->form_validation->set_message('required', '<strong>%s</strong> wajib diisi!');
		
		$this->form_validation->set_error_delimiters('<div class="alert alert-error"><a class="close" data-dismiss="alert">×</a><i class="icon-exclamation-sign bigger-130">&nbsp;</i>', '</div>');
		
		if($this->form_validation->run()===true){
			if (isset($_POST['txtPekerjaan'])){								
				$record = $this->m_monitor->monitor_absensi()->result();
				$data['message'] = 'Data tidak ditemukan';				
			}
		}
		
		$data['record'] = $record;

		$this->template->display('monitor/absensi/index', $data);		
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