<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Transaksi extends CI_Controller{
	function __construct() {
        parent::__construct();
		$this->load->model(array('m_trnhasil','m_master', 'm_trn_isikeranjang', 'm_trn_timbangwm', 'm_trn_timbangak'));
		if(!$this->session->userdata('userid')){
            redirect('login');
        }

    }
	
//	TRANSAKSI HASIL - ISI KERANJANG
	function to_index($halaman){
		$data['message'] = '';
		$data['cboline'] = $this->m_master->mst_line()->result();
		$data['cboshift'] = $this->m_master->mst_shift()->result();
		$data['cbojamkerja']= $this->m_master->mst_jamkerja()->result();
				
		switch ($halaman) {
			case 'keranjang':
				$this->template->display('transaksi/isi_keranjang/index',$data);
				break;
			
			case 'whitemeat':
				$data['record'] = $this->m_trn_timbangwm->list_timbangwm()->result();
				
				$this->template->display('transaksi/timbang_wm/index',$data);
				break;
			
			case 'airkelapa':
				$data['record'] =$this->m_trn_timbangak->list_timbangak()->result();
				
				$this->template->display('transaksi/timbang_ak/index',$data);
				break;
			
			default:
				break;
		}
		
	}
	
	function pengisian_keranjang($aksi = ''){				
		switch ($aksi) {
			case 'tambah':
				$nomomesin = $this->uri->segment(4);				
				$data['nomormesin']	= $nomomesin;
				
				$this->load->view('transaksi/isi_keranjang/isikeranjang_tambah', $data);
				break;
			
			case 'sisa':
				$nomomesin = $this->uri->segment(4);				
				$data['nomormesin']	= $nomomesin;
				
				$this->load->view('transaksi/isi_keranjang/isikeranjang_sisa', $data);
				break;

			default:
				if (!$this->session->userdata('krj_idline') || !$this->session->userdata('krj_shift')){
					$this->to_index('keranjang');
				} else {
					$tanggal = $this->session->userdata('krj_tanggal');
					$idline = $this->session->userdata('krj_idline');
					$shift = $this->session->userdata('krj_shift');
					$idjamkerja = $this->session->userdata('krj_idjamkerja');

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

					$data['tanggaltrn']	= $tanggal;
					$data['namaline'] = $namaline;
					$data['nomesinawal'] = $nomesinawal;
					$data['nomesinakhir'] = $nomesinakhir;
					$data['shift'] = $shift;
					$data['jamkerja'] = $jamkerja;
					$data['jammasuk'] = $jammasuk;

					$headerid = $this->m_trnhasil->get_header_hasil($tanggal, $idline, $shift);
					if ($headerid === 0){
						$info = array(
							'Tanggal'		=> tgl_eng($tanggal),
							'IDLine'		=> $idline,
							'IDShift'		=> $shift,
							'IDJamKerja'	=> $idjamkerja,
							'Inspector'		=> ucfirst($this->session->userdata('username')),
							'CreatedBy'		=> strtoupper($this->session->userdata('userid')),
							'CreatedDate'	=> date('Y-m-d H:i:s')
						);

						$headerid = $this->m_trnhasil->insert_header_hasil($info);
					}

					if ($headerid === 0){
						$pesan = pesan('Transaksi Header Gagal',  pesan_info());
						$data['message']	= $pesan;
						$data['cboline']	= $this->m_master->mst_line()->result();
						$data['cboshift']	= $this->m_master->mst_shift()->result();

						$this->template->display('transaksi/isi_keranjang/index',$data);
					} else {
						$this->session->set_userdata('krj_headerid', $headerid);
//						$this->simpan_data_detail_awal($headerid, $nomesinawal, $nomesinakhir);
						
						if (!$this->session->flashdata('mesinaktif')){
							$mesinaktif = $nomesinawal;
						} else {
							$mesinaktif = $this->session->flashdata('mesinaktif');
						}

						$data['message'] = $this->session->flashdata('savemsg');
						$data['idline']	= $idline;
						
//						$record_awal = $this->m_trn_isikeranjang->get_isiawal($headerid);
						$record_tambah = $this->m_trn_isikeranjang->get_isitambah($headerid);
						$record_sisa = $this->m_trn_isikeranjang->get_sisa($headerid);

						$data['headerid']		= $headerid;
						$data['mesinaktif']		= $mesinaktif;
						
//						$data['record_awal']	= $record_awal->result(); ==> Dipanggil di view
						$data['record_tambah']	= $record_tambah->result();
						$data['record_sisa']	= $record_sisa->result();

						$this->template->display('transaksi/isi_keranjang/isikeranjang',$data);
					}
				}

				break;
		}
		
	}
	
//	function simpan_data_detail_awal($headerid, $mesinawal, $mesinakhir){
//		for ($i = $mesinawal; $i <= $mesinakhir; $i++){
//			$detailid = $this->m_trn_isikeranjang->cek_detail_exists($headerid, $i);
//			if ($detailid === 0){
//				$info = array(
//					'HasilHeaderID'	=> $headerid,
//					'NomorMesin'	=> $i,
//					'CreatedBy'		=> strtoupper($this->session->userdata('userid')),
//					'CreatedDate'	=> date('Y-m-d H:i:s')
//				);				
//				$this->m_trn_isikeranjang->simpan_detail($info);
//			}
//		}
//	}
	
	function simpan_keranjang($aksi){
		switch ($aksi) {
			case 'tambah':
				$nomormesin	= $this->input->post('txtTambahNoMesin');
				$nomorkeranjang = $this->input->post('radioTambahKeranjang');				
				$jumlahtambah = $this->input->post('txtTambahIsi');

				$param = array(
					'HasilHeaderID'	=> $this->session->userdata('krj_headerid'),
					'NomorMesin'	=> $nomormesin
				);
				$urutantambah = $this->m_trn_isikeranjang->get_urutan_terakhir($param);

				$info = array(
					'HasilHeaderID'	=> $this->session->userdata('krj_headerid'),
					'NomorMesin'	=> $nomormesin,
					'NomorKeranjang'=> $nomorkeranjang,
					'UrutanTambah'	=> $urutantambah + 1,
					'JumlahTambah'	=> $jumlahtambah,
					'CreatedBy'		=> strtoupper($this->session->userdata('userid')),
					'CreatedDate'	=> date('Y-m-d H:i:s')
				);

				if ($this->m_trn_isikeranjang->simpan_history($aksi, $info) === 1){					
					$pesan = pesan('Simpan data mesin '.$nomormesin.' berhasil', 'success');
				} else {
					$err = mssql_get_last_message();
					$pesan = pesan('Simpan data mesin '.$nomormesin.' gagal.<br>Pesan : '. $err, pesan_error());
				}

				$this->session->set_flashdata('savemsg', $pesan);
				$this->session->set_flashdata('mesinaktif',$nomormesin);

				redirect('transaksi/pengisian_keranjang');
				
				break;
				
			case 'sisa':
				$nomormesin	= $this->input->post('txtSisaNoMesin');
				$nomorkeranjang = $this->input->post('radioSisaKeranjang');				
				$sisa = $this->input->post('txtSisa');

				$param = array(
					'HasilHeaderID'	=> $this->session->userdata('krj_headerid'),
					'NomorMesin'	=> $nomormesin
				);
				
				$info = array(
					'HasilHeaderID'	=> $this->session->userdata('krj_headerid'),
					'NomorMesin'	=> $nomormesin,
					'NomorKeranjang'=> $nomorkeranjang,
					'SisaKeranjang'	=> $sisa,
					'CreatedBy'		=> strtoupper($this->session->userdata('userid')),
					'CreatedDate'	=> date('Y-m-d H:i:s')
				);

				if ($this->m_trn_isikeranjang->simpan_history($aksi, $info) === 1){					
					$pesan = pesan('Simpan data mesin '.$nomormesin.' berhasil', 'success');
				} else {
					$err = mssql_get_last_message();
					$pesan = pesan('Simpan data mesin '.$nomormesin.' gagal.<br>Pesan : '. $err, pesan_error());
				}

				$this->session->set_flashdata('savemsg', $pesan);
				$this->session->set_flashdata('mesinaktif',$nomormesin);

				redirect('transaksi/pengisian_keranjang');
				
				break;

			default:
				break;
		}
	}
	
	function proses_isi_keranjang(){
		$this->form_validation->set_rules('txtTanggal', 'Tanggal','required|callback_check_date['. $this->input->post('txtTanggal'). ']');
		$this->form_validation->set_rules('txtLine', 'Line','required');
		$this->form_validation->set_rules('txtShift', 'Shift','required');
		$this->form_validation->set_rules('txtJamKerja', 'Jam Kerja','required');
		
		$this->form_validation->set_message('required', '<strong>%s</strong> wajib diisi!');
		
		$this->form_validation->set_error_delimiters('<div class="alert alert-error"><a class="close" data-dismiss="alert">×</a><i class="icon-exclamation-sign bigger-130">&nbsp;</i>', '</div>');
		
		if($this->form_validation->run()==false){
			$this->to_index('keranjang');
		}else{		
			$sess_data['krj_tanggal']	= $this->input->post('txtTanggal');
			$sess_data['krj_idline']	= $this->input->post('txtLine');
			$sess_data['krj_shift']		= $this->input->post('txtShift');
			$sess_data['krj_idjamkerja']= $this->input->post('txtJamKerja');

			$this->session->set_userdata($sess_data);

			redirect('transaksi/pengisian_keranjang');
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
	
	function proses_isi_selesai(){
		$this->session->unset_userdata('krj_tanggal');
		$this->session->unset_userdata('krj_idline');
		$this->session->unset_userdata('krj_shift');
		$this->session->unset_userdata('krj_idjamkerja');
		$this->session->unset_userdata('krj_headerid');
		redirect('transaksi/pengisian_keranjang');
	}
	
	
//	TRANSAKSI HASIL - WHITE MEAT
	function timbang_whitemeat($aksi = '', $detailid = 0){
		switch ($aksi) {
			case 'edit':
				$data['record'] = $this->m_trn_timbangwm->get_detail_byid($detailid)->result();
				$data['detailid'] = $detailid;
				$this->load->view('transaksi/timbang_wm/timbangwm_edit', $data);
				
				break;

			default:
				if (!$this->session->userdata('wm_idline') || !$this->session->userdata('wm_shift')){
					$this->to_index('whitemeat');
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

					$data['tanggaltrn']	= $tanggal;
					$data['namaline']	= $namaline;
					$data['nomesinawal'] = $nomesinawal;
					$data['nomesinakhir'] = $nomesinakhir;
					$data['shift']		= $shift;
					$data['jamkerja']	= $jamkerja;
					$data['jammasuk']	= $jammasuk;

					$headerid = $this->m_trnhasil->get_header_hasil($tanggal, $idline, $shift);
					if ($headerid === 0){	//Jika belum ada headernya, maka akan di-Insert
						$info = array(
							'Tanggal'		=> tgl_eng($tanggal),
							'IDLine'		=> $idline,
							'IDShift'		=> $shift,
							'IDJamKerja'	=> $idjamkerja,
							'Inspector'		=> ucfirst($this->session->userdata('username')),
							'CreatedBy'		=> strtoupper($this->session->userdata('userid')),
							'CreatedDate'	=> date('Y-m-d H:i:s')
						);

						$headerid = $this->m_trnhasil->insert_header_hasil($info);
					}

					if ($headerid === 0){	//Jika transaksi simpan header gagal, diarahkan ke index
						$pesan = pesan('Transaksi Header Gagal',  pesan_info());
						$data['message']	= $pesan;
						$data['cboline']	= $this->m_master->mst_line()->result();
						$data['cboshift']	= $this->m_master->mst_shift()->result();
						$data['cbojamkerja']= $this->m_master->mst_jamkerja()->result();

						$this->template->display('transaksi/timbang_wm/index',$data);
					} else {	//Jika transaksi simpan header berhasil, akan dilanjutkan kesini						
						//Setelah Simpan Timbang akan menuju kesini
						$this->session->set_userdata('wm_headerid', $headerid);
						
						if (!$this->session->flashdata('mesinaktif')){
							$mesinaktif = $nomesinawal;
						} else {
							$mesinaktif = $this->session->flashdata('mesinaktif');
						}

						$data['message'] = $this->session->flashdata('savemsg');
						$data['mesinaktif'] = $mesinaktif;
						$data['headerid']	= $headerid;

						$this->template->display('transaksi/timbang_wm/timbangwm',$data);
					}
				}
				break;
		}
				
	}
	
	function simpan_timbangwm($no_mesin){
		if (isset($_POST['SimpanMesin'.$no_mesin])){
			$timbangan	= $this->input->post('txtTimbang'.$no_mesin);
			$potlain	= $this->input->post('txtPotLain'.$no_mesin);
			$potair		= $this->input->post('txtPotAir'.$no_mesin);
			
			if ($timbangan == ''){
				$timbangan = '0';
			} else {
				$timbangan = number_format($timbangan,4);
			}
			
			if ($potlain == ''){
				$potlain = '0';
			} else {
				$potlain = number_format($potlain,4);
			}
			
			if ($potair == ''){
				$potair = '0';
			} else {
				$potair = number_format($potair,4);
			}
			
			$info = array(
				'HasilHeaderID'		=> $this->session->userdata('wm_headerid'),
				'NomorMesin'		=> $no_mesin,
				'Timbangan'			=> $timbangan,
				'PotLain'			=> $potlain,
				'PotAir'			=> $potair,
				'CreatedBy'			=> strtoupper($this->session->userdata('userid')),
				'CreatedDate'		=> date('Y-m-d H:i:s')
			);
			
			if($this->m_trn_timbangwm->simpan_detail($info) === 1){
				$pesan = pesan('Simpan data mesin '.$no_mesin.' berhasil', 'success');
			}
			else {
				$err = mssql_get_last_message();
				$pesan = pesan('Simpan data mesin '.$no_mesin.' gagal.<br>Pesan : '. $err, pesan_error());			
			}

			$this->session->set_flashdata('savemsg', $pesan);
			$this->session->set_flashdata('mesinaktif',$no_mesin);
			
			redirect('transaksi/timbang_whitemeat');
		} else {
			$pesan = pesan('Simpan data mesin '.$no_mesin.' gagal', pesan_error());
			$this->session->set_flashdata('savemsg',$pesan);
			$this->session->set_flashdata('mesinaktif',$no_mesin);
			
			redirect('transaksi/timbang_whitemeat');
		}
	}
	
	function update_timbangwm($detailid){
		$timbangan	= $this->input->post('txtEditTimbang');
		$potlain	= $this->input->post('txtEditPotLain');
		$potair		= $this->input->post('txtEditPotAir');
		$mesinaktif = $this->input->post('txtEditNoMesin');
		
		if ($timbangan == ''){
			$timbangan = '0';
		} else {
			$timbangan = number_format($timbangan,4);
		}

		if ($potlain == ''){
			$potlain = '0';
		} else {
			$potlain = number_format($potlain,4);
		}

		if ($potair == ''){
			$potair = '0';
		} else {
			$potair = number_format($potair,4);
		}

		$info = array(
			'Timbangan'			=> $timbangan,
			'PotLain'			=> $potlain,
			'PotAir'			=> $potair,
			'UpdatedBy'			=> strtoupper($this->session->userdata('userid')),
			'UpdatedDate'		=> date('Y-m-d H:i:s')
		);
		
		if($this->m_trn_timbangwm->update_detail($detailid, $info) === 1){
			$pesan = pesan('Update data mesin '.$mesinaktif.' berhasil', pesan_sukses());
		}else{
			$err = mssql_get_last_message();
			$pesan = pesan('Update data mesin '.$mesinaktif.' gagal.<br>Pesan : '. $err, pesan_error());			
		}

		$this->session->set_flashdata('savemsg', $pesan);
		$this->session->set_flashdata('mesinaktif', $mesinaktif);

		redirect('transaksi/timbang_whitemeat');
	}
	
	function hapus_timbangwm($hasilhapus, $nomormesin = null){
		switch ($hasilhapus) {
			case 'berhasil':
				$pesan = pesan('Hapus data di mesin '.$nomormesin.' berhasil', pesan_sukses());
				$this->session->set_flashdata('savemsg', $pesan);
				$this->session->set_flashdata('mesinaktif', $nomormesin);
				redirect('transaksi/timbang_whitemeat');
				break;
			
			case 'gagal':
				$pesan = pesan('Hapus data di mesin '.$nomormesin.' gagal', pesan_error());
				$this->session->set_flashdata('savemsg', $pesan);
				$this->session->set_flashdata('mesinaktif', $nomormesin);
				redirect('transaksi/timbang_whitemeat');
				break;

			default:
				$detailid = $this->input->post('detailid');
				$this->m_trn_timbangwm->delete_detail($detailid);
				break;
		}
	}
	
	function proses_timbangwm(){
		$this->form_validation->set_rules('txtTanggal', 'Tanggal','required|callback_check_date['. $this->input->post('txtTanggal'). ']');
		$this->form_validation->set_rules('txtLine', 'Line','required');
		$this->form_validation->set_rules('txtShift', 'Shift','required');
		$this->form_validation->set_rules('txtJamKerja', 'Jam Kerja','required');
		
		$this->form_validation->set_message('required', '<strong>%s</strong> wajib diisi!');
		
		$this->form_validation->set_error_delimiters('<div class="alert alert-error"><a class="close" data-dismiss="alert">×</a><i class="icon-exclamation-sign bigger-130">&nbsp;</i>', '</div>');
		
		if($this->form_validation->run()==false){
			$this->to_index('whitemeat');
		}else{
			$sess_data['wm_tanggal']	= $this->input->post('txtTanggal');
			$sess_data['wm_idline']		= $this->input->post('txtLine');
			$sess_data['wm_shift']		= $this->input->post('txtShift');
			$sess_data['wm_idjamkerja']	= $this->input->post('txtJamKerja');

			$this->session->set_userdata($sess_data);

			redirect('transaksi/timbang_whitemeat');
		}
	}
	
	function proses_timbangwm_selesai(){
		$this->session->unset_userdata('wm_tanggal');
		$this->session->unset_userdata('wm_idline');
		$this->session->unset_userdata('wm_shift');
		$this->session->unset_userdata('wm_idjamkerja');
		$this->session->unset_userdata('wm_headerid');
		redirect('transaksi/timbang_whitemeat');
	}
	
	
//	TRANSAKSI HASIL - AIR KELAPA
	function timbang_airkelapa($aksi = '', $detailid = 0){
		switch ($aksi) {
			case 'edit':
				$data['record'] = $this->m_trn_timbangak->get_detail_byid($detailid)->result();
				$data['detailid'] = $detailid;
				$this->load->view('transaksi/timbang_ak/timbangak_edit', $data);

				break;

			default:
				if (!$this->session->userdata('ak_idline') || !$this->session->userdata('ak_shift')){
					$this->to_index('airkelapa');
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
					
					$data['tanggaltrn']	= $tanggal;
					$data['namaline']	= $namaline;
					$data['nomesinawal'] = $nomesinawal;
					$data['nomesinakhir'] = $nomesinakhir;
					$data['shift']		= $shift;
					$data['jamkerja']	= $jamkerja;
					$data['jammasuk']	= $jammasuk;

					$headerid = $this->m_trnhasil->get_header_hasil($tanggal, $idline, $shift);
					if ($headerid === 0){
						$info = array(
							'Tanggal'		=> tgl_eng($tanggal),
							'IDLine'		=> $idline,
							'IDShift'		=> $shift,
							'IDJamKerja'	=> $idjamkerja,
							'Inspector'		=> ucfirst($this->session->userdata('username')),
							'CreatedBy'		=> strtoupper($this->session->userdata('userid')),
							'CreatedDate'	=> date('Y-m-d H:i:s')
						);

						$headerid = $this->m_trnhasil->insert_header_hasil($info);
					}

					if ($headerid === 0){
						$pesan = pesan('Transaksi Header Gagal',  pesan_info());
						$data['message']	= $pesan;
						$data['cboline']	= $this->m_master->mst_line()->result();
						$data['cboshift']	= $this->m_master->mst_shift()->result();

						$this->template->display('transaksi/timbang_ak/index',$data);
					} else {
						$this->session->set_userdata('ak_headerid', $headerid);
						
						if (!$this->session->flashdata('mesinaktif')){
							$mesinaktif = $nomesinawal;
						} else {
							$mesinaktif = $this->session->flashdata('mesinaktif');
						}

						$data['message'] = $this->session->flashdata('savemsg');
						$data['mesinaktif'] = $mesinaktif;
						$data['headerid']	= $headerid;

						$this->template->display('transaksi/timbang_ak/timbangak',$data);
					}
				}
				
				break;
		}
		
	}
	
	function simpan_timbangak($no_mesin){
		if (isset($_POST['SimpanMesin'.$no_mesin])){
			$hasilak = $this->input->post('txtTimbang'.$no_mesin);
			
			if ($hasilak == ''){
				$hasilak = '0';
			} 
			
			$info = array(
				'HasilHeaderID'		=> $this->session->userdata('ak_headerid'),
				'NomorMesin'		=> $no_mesin,
				'HasilAK'			=> $hasilak,
				'CreatedBy'			=> strtoupper($this->session->userdata('userid')),
				'CreatedDate'		=> date('Y-m-d H:i:s')
			);
			
			if($this->m_trn_timbangak->simpan_detail($info) === 1){
				$pesan = pesan('Simpan data mesin '.$no_mesin.' berhasil', 'success');
			}
			else{
				$err = mssql_get_last_message();
//				$err = "GAGAL";
				$pesan = pesan('Simpan data mesin '.$no_mesin.' gagal.<br>Pesan : '.$err, pesan_error());			
			}

			$this->session->set_flashdata('savemsg', $pesan);
			$this->session->set_flashdata('mesinaktif',$no_mesin);
			
			redirect('transaksi/timbang_airkelapa');
		} else {
			$pesan = pesan('Posting data mesin '.$no_mesin.' gagal', pesan_error());
			$this->session->set_flashdata('savemsg',$pesan);
			$this->session->set_flashdata('mesinaktif',$no_mesin);
			
			redirect('transaksi/timbang_airkelapa');
		}
	}
	
	function update_timbangak($detailid){
		$hasilak	= $this->input->post('txtEditHasilAK');
		$mesinaktif = $this->input->post('txtEditNoMesin');
		
		if ($hasilak == ''){
			$hasilak = '0';
		}
		
		$info = array(
			'HasilAK'			=> $hasilak,
			'UpdatedBy'			=> strtoupper($this->session->userdata('userid')),
			'UpdatedDate'		=> date('Y-m-d H:i:s')
		);
		
		if($this->m_trn_timbangak->update_detail($detailid, $info) === 1){
			$pesan = pesan('Update data mesin '.$mesinaktif.' berhasil', pesan_sukses());
		}else{
			$err = mssql_get_last_message();
			$pesan = pesan('Update data mesin '.$mesinaktif.' gagal.<br>Pesan : '. $err, pesan_error());			
		}

		$this->session->set_flashdata('savemsg', $pesan);
		$this->session->set_flashdata('mesinaktif', $mesinaktif);

		redirect('transaksi/timbang_airkelapa');
	}
	
	function hapus_timbangak($hasilhapus, $nomormesin = null){
		switch ($hasilhapus) {
			case 'berhasil':
				$pesan = pesan('Hapus data di mesin '.$nomormesin.' berhasil', pesan_sukses());
				$this->session->set_flashdata('savemsg', $pesan);
				$this->session->set_flashdata('mesinaktif', $nomormesin);
				redirect('transaksi/timbang_airkelapa');
				break;
			
			case 'gagal':
				$pesan = pesan('Hapus data di mesin '.$nomormesin.' gagal', pesan_error());
				$this->session->set_flashdata('savemsg', $pesan);
				$this->session->set_flashdata('mesinaktif', $nomormesin);
				redirect('transaksi/timbang_airkelapa');
				break;

			default:
				$detailid = $this->input->post('detailid');
				$this->m_trn_timbangak->delete_detail($detailid);
				break;
		}
	}
	
	function proses_timbangak(){
		$this->form_validation->set_rules('txtTanggal', 'Tanggal','required|callback_check_date['. $this->input->post('txtTanggal'). ']');
		$this->form_validation->set_rules('txtLine', 'Line','required');
		$this->form_validation->set_rules('txtShift', 'Shift','required');
		$this->form_validation->set_rules('txtJamKerja', 'Jam Kerja','required');
		
		$this->form_validation->set_message('required', '<strong>%s</strong> wajib diisi!');
		
		$this->form_validation->set_error_delimiters('<div class="alert alert-error"><a class="close" data-dismiss="alert">×</a><i class="icon-exclamation-sign bigger-130">&nbsp;</i>', '</div>');
		
		if($this->form_validation->run()==false){
			$this->to_index('airkelapa');
		}else{
			$sess_data['ak_tanggal']	= $this->input->post('txtTanggal');
			$sess_data['ak_idline']		= $this->input->post('txtLine');
			$sess_data['ak_shift']		= $this->input->post('txtShift');
			$sess_data['ak_idjamkerja']	= $this->input->post('txtJamKerja');

			$this->session->set_userdata($sess_data);

			redirect('transaksi/timbang_airkelapa');
		}
	}
	
	function proses_timbangak_selesai(){
		$this->session->unset_userdata('ak_tanggal');
		$this->session->unset_userdata('ak_idline');
		$this->session->unset_userdata('ak_shift');
		$this->session->unset_userdata('ak_idjamkerja');
		$this->session->unset_userdata('ak_headerid');
		redirect('transaksi/timbang_airkelapa');
	}
	
	
}