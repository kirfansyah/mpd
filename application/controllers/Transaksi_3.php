<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Transaksi extends CI_Controller{
	function __construct() {
        parent::__construct();
		$this->load->database();
		$this->load->model(array('m_trnhasil','m_master', 'm_trn_isikeranjang', 'm_trn_timbangwm', 'm_trn_timbangak', 'm_trn_hasilkc'));
		if(!$this->session->userdata('userid')){
			
            redirect('login');
        }
        ini_set('max_execution_time', 300);
    }
	
	function to_index($halaman){
		$data['message'] = $this->session->flashdata('message');
		$data['cboline'] = $this->m_master->mst_line()->result();
		$data['cboshift'] = $this->m_master->mst_shift()->result();
		$data['cbojamkerja']= $this->m_master->mst_jamkerja()->result();
				
		switch ($halaman) {
			case 'keranjang':
				$data['record'] = $this->m_trn_isikeranjang->list_isi_keranjang()->result();				
								
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
			
			case 'kelapacungkil':
				$data['record'] =$this->m_trn_hasilkc->list_hasilkc()->result();
				
				$this->template->display('transaksi/kelapacungkil/index',$data);
				break;
			
			default:
				break;
		}		
	}
	
	function do_changeline($halaman){
		switch ($halaman) {
			case 'keranjang':
				$sess_data['krj_idline'] = $this->input->post('txtLine');
				$this->session->set_userdata($sess_data);

				redirect('transaksi/pengisian_keranjang');
				break;
			
			case 'whitemeat':
				$sess_data['wm_idline'] = $this->input->post('txtLine');
				$this->session->set_userdata($sess_data);

				redirect('transaksi/timbang_whitemeat');
				break;
			
			case 'airkelapa':
				$sess_data['ak_idline'] = $this->input->post('txtLine');
				$this->session->set_userdata($sess_data);

				redirect('transaksi/timbang_airkelapa');
				break;
			
			case 'kelapacungkil':
				$sess_data['kc_idline'] = $this->input->post('txtLine');
				$this->session->set_userdata($sess_data);

				redirect('transaksi/kelapacungkil');
				break;

			default:
				break;
		}
	}
	
	function pindahline($halaman){
		$data['cboline'] = $this->m_master->mst_line()->result();
		$data['halaman'] = $halaman;
		
		switch ($halaman) {
			case 'keranjang':
				$data['idline']	= $this->session->userdata('krj_idline');
				break;
			
			case 'whitemeat':
				$data['idline']	= $this->session->userdata('wm_idline');
				break;
			
			case 'airkelapa':
				$data['idline']	= $this->session->userdata('ak_idline');
				break;
			
			case 'kelapacungkil':
				$data['idline']	= $this->session->userdata('kc_idline');
				break;
			
			default:
				break;
		}
		
		$this->load->view('transaksi/pindahline',$data);
	}
	
	function edit($halaman){
		$headerid = $this->input->get('id',true);
		$detheader = $this->m_master->get_hasilheader($headerid)->result();
		
		foreach ($detheader as $r) {
			$tanggal	= tgl_ind($r->Tanggal);
			$idline		= $r->IDLine;
			$shift		= $r->IDShift;
			$idjamkerja	= $r->IDJamKerja;
		}		
		
		switch ($halaman) {
			case 'keranjang':
				$sess_data['krj_tanggal']	= $tanggal;
				$sess_data['krj_idline']	= $idline;
				$sess_data['krj_shift']		= $shift;
				$sess_data['krj_idjamkerja']= $idjamkerja;

				$this->session->set_userdata($sess_data);
				
				redirect('transaksi/pengisian_keranjang');
				break;
			
			case 'whitemeat':
				$sess_data['wm_tanggal']	= $tanggal;
				$sess_data['wm_idline']		= $idline;
				$sess_data['wm_shift']		= $shift;
				$sess_data['wm_idjamkerja']	= $idjamkerja;

				$this->session->set_userdata($sess_data);

				redirect('transaksi/timbang_whitemeat');
				break;
			
			case 'airkelapa':
				$sess_data['ak_tanggal']	= $tanggal;
				$sess_data['ak_idline']		= $idline;
				$sess_data['ak_shift']		= $shift;
				$sess_data['ak_idjamkerja']	= $idjamkerja;

				$this->session->set_userdata($sess_data);

				redirect('transaksi/timbang_airkelapa');
				break;
			
			case 'kelapacungkil':
				$sess_data['kc_tanggal']	= $tanggal;
				$sess_data['kc_idline']		= $idline;
				$sess_data['kc_shift']		= $shift;
				$sess_data['kc_idjamkerja']	= $idjamkerja;

				$this->session->set_userdata($sess_data);

				redirect('transaksi/kelapacungkil');
				break;
			
			default:
				break;
		}
	}
	
	function complete_trx($halaman){
		$headerid = $this->input->get('id',true);
		$this->m_trnhasil->complete_hasil($halaman, $headerid);
		$pesankomplete = pesan('Complete Berhasil', pesan_sukses());
		$this->session->set_flashdata('message', $pesankomplete);		
		
		switch ($halaman) {
			case 'keranjang':
				redirect('transaksi/pengisian_keranjang');
				break;

			case 'whitemeat':
				redirect('transaksi/timbang_whitemeat');
				break;
			
			case 'airkelapa':
				redirect('transaksi/timbang_airkelapa');
				break;
			
			case 'kelapacungkil':
				redirect('transaksi/kelapacungkil');
				
			default:
				break;
		}
		
	}
	
//	TRANSAKSI HASIL - ISI KERANJANG	
	function pengisian_keranjang($aksi = ''){				
		switch ($aksi) {
			case 'edittambah':
				$nomomesin = $this->uri->segment(4);
				$urutantambah = $this->uri->segment(5);
				$krj1 = $this->input->get('krj1');
				$krj2 = $this->input->get('krj2');
				$data['nomormesin']	= $nomomesin;
				$data['urutantambah'] = $urutantambah;
				$data['krj1'] = $krj1;
				$data['krj2'] = $krj2;
				
				$this->load->view('transaksi/isi_keranjang/isikeranjang_tambah', $data);
				break;
			
			case 'editsisa':
				$nomomesin = $this->uri->segment(4);
				$sisa1 = $this->input->get('sisa1');
				$sisa2 = $this->input->get('sisa2');
				$data['nomormesin']	= $nomomesin;
				$data['sisa1'] = $sisa1;
				$data['sisa2'] = $sisa2;
				
				$this->load->view('transaksi/isi_keranjang/isikeranjang_sisa', $data);
				break;
			
			case 'editisi':
				$nomomesin = $this->uri->segment(4);
				$isi1 = $this->input->get('isi1');
				$isi2 = $this->input->get('isi2');
				$data['nomormesin']	= $nomomesin;
				$data['isi1'] = $isi1;
				$data['isi2'] = $isi2;
				
				$this->load->view('transaksi/isi_keranjang/isikeranjang_isi', $data);
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

					$headerid = $this->m_trnhasil->get_header_hasil($tanggal, $idline, $idjamkerja);
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
						$record_isilanjut = $this->m_trn_isikeranjang->get_isilanjut($headerid);

						$data['headerid']		= $headerid;
						$data['mesinaktif']		= $mesinaktif;
						
//						$data['record_awal']	= $record_awal->result(); ==> Dipanggil di view
						$data['record_tambah']	= $record_tambah->result();
						$data['record_sisa']	= $record_sisa->result();
						$data['record_isilanjut'] = $record_isilanjut->result();
						
						$this->template->display('transaksi/isi_keranjang/isikeranjang',$data);
					}
				}

				break;
		}
		
	}
	
	function simpan_keranjang($aksi){
		switch ($aksi) {
			case 'tambah':
				if (isset($_POST['SimpanTambahMesin'])){
					$nomormesin	= $this->input->post('txtTambahNoMesin');				
					$jumlahtambah1 = $this->input->post('txtTambahIsi1');
					$jumlahtambah2 = $this->input->post('txtTambahIsi2');
					$urutantambah = $this->input->post('txtUrutanTambah');

					$this->do_simpan_tambah($nomormesin, $jumlahtambah1, $jumlahtambah2, $urutantambah);
				}
				
				break;
				
			case 'sisa':
				$nomormesin	= $this->uri->segment(4);
				if (isset($_POST['SimpanSisaMesin'.$nomormesin])){
					$sisa1 = $this->input->post('txtSisa1');
					$sisa2 = $this->input->post('txtSisa2');
					$this->do_simpan_sisa($nomormesin, $sisa1, $sisa2);
				}
								
				break;
				
			case 'isi':
				if (isset($_POST['SimpanIsiMesin'])){
					$nomormesin	= $this->input->post('txtIsiNoMesin');
					$isi1 = $this->input->post('txtIsi1');
					$isi2 = $this->input->post('txtIsi2');
					$this->do_simpan_isi($nomormesin, $isi1, $isi2);
				}
				
				break;

			default:
				break;
		}
	}
	
		function do_simpan_tambah($nomormesin, $jumlahtambah1, $jumlahtambah2, $urutantambah){
			$tambah[1] = $jumlahtambah1;
			$tambah[2] = $jumlahtambah2;
			
//			$param = array(
//				'HasilHeaderID'	=> $this->session->userdata('krj_headerid'),
//				'NomorMesin'	=> $nomormesin
//			);			
//			$urutantambah = $this->m_trn_isikeranjang->get_urutan_terakhir($param);
			
			if ($tambah[1] > 0 && $tambah[2] > 0){
				$pesan = pesan('Silakan isi salah satu keranjang!', pesan_error());
				$this->session->set_flashdata('savemsg', $pesan);
				$this->session->set_flashdata('mesinaktif',$nomormesin);

				redirect('transaksi/pengisian_keranjang');
			}
			
			for ($i = 1; $i <= 2; $i++){
				$pesan[$i] = '';
				if ($tambah[$i] !== ''){
					$info = array(
						'HasilHeaderID'	=> $this->session->userdata('krj_headerid'),
						'NomorMesin'	=> $nomormesin,
						'NomorKeranjang'=> $i,
						'UrutanTambah'	=> $urutantambah,
						'JumlahTambah'	=> $tambah[$i],
						'CreatedBy'		=> strtoupper($this->session->userdata('userid')),
						'CreatedDate'	=> date('Y-m-d H:i:s')
					);

					if ($this->m_trn_isikeranjang->simpan_history('tambah', $info) === 1){					
						$pesan[$i] = pesan('Simpan data mesin '.$nomormesin.' berhasil', 'success');
					} else {
						$err = mssql_get_last_message();
						$pesan[$i] = pesan('Simpan data mesin '.$nomormesin.' gagal.<br>Pesan : '. $err, pesan_error());
					}
				}
			}

			$this->session->set_flashdata('savemsg', $pesan[1].$pesan[2]);
			$this->session->set_flashdata('mesinaktif',$nomormesin);

			redirect('transaksi/pengisian_keranjang');
		}
	
		function do_simpan_sisa($nomormesin, $sisa1, $sisa2){
			$pesan1 = '';
			$pesan2 = '';
			if ($sisa1 !== ''){
				$info1 = array(
					'HasilHeaderID'	=> $this->session->userdata('krj_headerid'),
					'NomorMesin'	=> $nomormesin,
					'NomorKeranjang'=> 1,
					'SisaKeranjang'	=> $sisa1,
					'CreatedBy'		=> strtoupper($this->session->userdata('userid')),
					'CreatedDate'	=> date('Y-m-d H:i:s')
				);

				if ($this->m_trn_isikeranjang->simpan_history('sisa', $info1) === 1){					
					$pesan1 = pesan('Simpan data mesin '.$nomormesin.' keranjang 1 berhasil', 'success');
				} else {
					$err1 = mssql_get_last_message();
					$pesan1 = pesan('Simpan data mesin '.$nomormesin.' keranjang 1 gagal.<br>Pesan : '. $err1, pesan_error());
				}
			}
			
			if ($sisa2 !== ''){
				$info2 = array(
					'HasilHeaderID'	=> $this->session->userdata('krj_headerid'),
					'NomorMesin'	=> $nomormesin,
					'NomorKeranjang'=> 2,
					'SisaKeranjang'	=> $sisa2,
					'CreatedBy'		=> strtoupper($this->session->userdata('userid')),
					'CreatedDate'	=> date('Y-m-d H:i:s')
				);

				if ($this->m_trn_isikeranjang->simpan_history('sisa', $info2) === 1){					
					$pesan2 = pesan('Simpan data mesin '.$nomormesin.' keranjang 2 berhasil', 'success');
				} else {
					$err2 = mssql_get_last_message();
					$pesan2 = pesan('Simpan data mesin '.$nomormesin.' keranjang 2 gagal.<br>Pesan : '. $err2, pesan_error());
				}
			}
			
			$this->session->set_flashdata('savemsg', $pesan1.$pesan2);
			$this->session->set_flashdata('mesinaktif',$nomormesin);

			redirect('transaksi/pengisian_keranjang');
		}
		
		function do_simpan_isi($nomormesin, $isi1, $isi2){
			$isi[1] = $isi1;
			$isi[2]	= $isi2;
			
			for ($i = 1; $i <= 2; $i++){
				$pesan[$i] = '';
				if ($isi[$i] !== ''){
					$info = array(
						'HasilHeaderID'	=> $this->session->userdata('krj_headerid'),
						'NomorMesin'	=> $nomormesin,
						'NomorKeranjang'=> $i,
						'SisaKeranjang'	=> $isi[$i],
						'Isi'			=> 1,
						'CreatedBy'		=> strtoupper($this->session->userdata('userid')),
						'CreatedDate'	=> date('Y-m-d H:i:s')
					);

					if ($this->m_trn_isikeranjang->simpan_history('isi', $info) === 1){					
						$pesan[$i] = pesan('Simpan data mesin '.$nomormesin.' berhasil', 'success');
					} else {
						$err = mssql_get_last_message();
						$pesan[$i] = pesan('Simpan data mesin '.$nomormesin.' gagal.<br>Pesan : '. $err, pesan_error());
					}
				}
			}
			
			$this->session->set_flashdata('savemsg', $pesan[1].$pesan[2]);
			$this->session->set_flashdata('mesinaktif',$nomormesin);

			redirect('transaksi/pengisian_keranjang');
			
		}
		
	function update_keranjang($aksi){
		switch ($aksi) {
			case 'tambah':
				$nomormesin	= $this->input->post('txtTambahNoMesin');
				$urutantambah = $this->input->post('txtUrutanTambah');
				$jumlahtambah1 = $this->input->post('txtTambahIsi1');
				$jumlahtambah2 = $this->input->post('txtTambahIsi2');
				$headerid =  $this->session->userdata('krj_headerid');
				
				if ($jumlahtambah1 > 0){
					$idkrj = $this->m_trn_isikeranjang->get_idkrjhistory($headerid, $nomormesin, $urutantambah, 1);
					$this->do_update_tambah($idkrj, $nomormesin, $jumlahtambah1);
					break;
				}
				
				if ($jumlahtambah2 > 0){
					$idkrj = $this->m_trn_isikeranjang->get_idkrjhistory($headerid, $nomormesin, $urutantambah, 2);
					$this->do_update_tambah($idkrj, $nomormesin, $jumlahtambah2);
				}
				
				break;
				
			case 'sisa' :
				$nomormesin	= $this->input->post('txtSisaNoMesin');
				$jumlahsisa1 = $this->input->post('txtSisa1');
				$jumlahsisa2 = $this->input->post('txtSisa2');
				$headerid =  $this->session->userdata('krj_headerid');
				
				if ($jumlahsisa1 > 0 ){
					$idsisa = $this->m_trn_isikeranjang->get_idsisahistory($headerid, $nomormesin, 1);
					$this->do_update_sisa($idsisa, $nomormesin, $jumlahsisa1);
				}
				
				if ($jumlahsisa2 > 0 ){
					$idsisa = $this->m_trn_isikeranjang->get_idsisahistory($headerid, $nomormesin, 2);
					$this->do_update_sisa($idsisa, $nomormesin, $jumlahsisa2);
				}
				
				break;
				
			case 'isi':
				$nomormesin	= $this->input->post('txtIsiNoMesin');
				$jumlahisi1 = $this->input->post('txtIsi1');
				$jumlahisi2 = $this->input->post('txtIsi2');
				$headerid =  $this->session->userdata('krj_headerid');
				
				if ($jumlahisi1 > 0 ){
					$idisi = $this->m_trn_isikeranjang->get_idisihistory($headerid, $nomormesin, 1);
					$this->do_update_isi($idisi, $nomormesin, $jumlahisi1);
				}
				
				if ($jumlahisi2 > 0 ){
					$idisi = $this->m_trn_isikeranjang->get_idisihistory($headerid, $nomormesin, 2);
					$this->do_update_isi($idisi, $nomormesin, $jumlahisi2);
				}
				
				break;

			default:
				break;
		}
	}
		
		function do_update_tambah($idkrj, $nomormesin, $jumlahtambah){
			$info = array(
				'JumlahTambah'	=> $jumlahtambah,
				'UpdatedBy'		=> strtoupper($this->session->userdata('userid')),
				'UpdatedDate'	=> date('Y-m-d H:i:s')
			);
			
			$berhasil = $this->m_trn_isikeranjang->update_history('tambah', $idkrj, $info);
			
			if ($berhasil === 1){
				$pesan = pesan('Update data mesin '.$nomormesin.' berhasil', 'success');
			} else {
				$err = mssql_get_last_message();
				$pesan = pesan('Update data mesin '.$nomormesin.' gagal.<br>Pesan : '. $err, pesan_error());
			}
			
			$this->session->set_flashdata('savemsg', $pesan);
			$this->session->set_flashdata('mesinaktif',$nomormesin);

			redirect('transaksi/pengisian_keranjang');
		}
		
		function do_update_sisa($idsisa, $nomormesin, $jumlahsisa){
			$info = array(
				'SisaKeranjang'	=> $jumlahsisa,
				'UpdatedBy'		=> strtoupper($this->session->userdata('userid')),
				'UpdatedDate'	=> date('Y-m-d H:i:s')
			);
			
			$berhasil = $this->m_trn_isikeranjang->update_history('sisa', $idsisa, $info);
			
			if ($berhasil === 1){
				$pesan = pesan('Update data mesin '.$nomormesin.' berhasil', 'success');
			} else {
				$err = mssql_get_last_message();
				$pesan = pesan('Update data mesin '.$nomormesin.' gagal.<br>Pesan : '. $err, pesan_error());
			}
			
			$this->session->set_flashdata('savemsg', $pesan);
			$this->session->set_flashdata('mesinaktif',$nomormesin);

			redirect('transaksi/pengisian_keranjang');
		}
		
		function do_update_isi($idisi, $nomormesin, $jumlahisi){
			$info = array(
				'SisaKeranjang'	=> $jumlahisi,
				'UpdatedBy'		=> strtoupper($this->session->userdata('userid')),
				'UpdatedDate'	=> date('Y-m-d H:i:s')
			);
			
			$berhasil = $this->m_trn_isikeranjang->update_history('isi', $idisi, $info);
			
			if ($berhasil === 1){
				$pesan = pesan('Update data mesin '.$nomormesin.' berhasil', 'success');
			} else {
				$err = mssql_get_last_message();
				$pesan = pesan('Update data mesin '.$nomormesin.' gagal.<br>Pesan : '. $err, pesan_error());
			}
			
			$this->session->set_flashdata('savemsg', $pesan);
			$this->session->set_flashdata('mesinaktif',$nomormesin);

			redirect('transaksi/pengisian_keranjang');
		}
	
	function hapus_keranjang($aksi, $hasilhapus = null, $nomormesin = 0){
		switch ($aksi) {
			case 'tambah':
				if ($hasilhapus === 'berhasil'){
					$pesan = pesan('Hapus data di mesin '.$nomormesin.' berhasil', pesan_sukses());
					$this->session->set_flashdata('savemsg', $pesan);
					$this->session->set_flashdata('mesinaktif', $nomormesin);
					redirect('transaksi/pengisian_keranjang');
				} else {
					$this->m_trn_isikeranjang->hapus_history('tambah');
				}
				break;
				
			case 'sisa':
				if ($hasilhapus === 'berhasil'){
					$pesan = pesan('Hapus data di mesin '.$nomormesin.' berhasil', pesan_sukses());
					$this->session->set_flashdata('savemsg', $pesan);
					$this->session->set_flashdata('mesinaktif', $nomormesin);
					redirect('transaksi/pengisian_keranjang');
				} else {
					$this->m_trn_isikeranjang->hapus_history('sisa');
				}
				break;
				
			case 'isi':
				if ($hasilhapus === 'berhasil'){
					$pesan = pesan('Hapus data di mesin '.$nomormesin.' berhasil', pesan_sukses());
					$this->session->set_flashdata('savemsg', $pesan);
					$this->session->set_flashdata('mesinaktif', $nomormesin);
					redirect('transaksi/pengisian_keranjang');
				} else {
					$this->m_trn_isikeranjang->hapus_history('isi');
				}
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
					$data['idline']		= $idline;
					$data['cboline']	= $this->m_master->mst_line()->result();

					$headerid = $this->m_trnhasil->get_header_hasil($tanggal, $idline, $idjamkerja);
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
	
	function detail_timbangwm($no_mesin){
		if (isset($_POST['HeaderID'])){
			$header_id 	= $_POST['HeaderID'];
			$param_mesin = array(
				'HasilHeaderID'	=> $header_id,
				'NomorMesin'	=> $no_mesin
			);
			$record 	= $this->m_trn_timbangwm->detail_timbangwm($param_mesin);
			echo json_encode($record);
		}
	}

	function simpan_timbangwm($no_mesin){
		$status_info = 0;
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
			
			$this->form_validation->set_rules('txtTimbang'.$no_mesin,'Kolom Timbangan','required');
			// $this->form_validation->set_message('required', '<strong>%s</strong> wajib diisi!');
			// $this->form_validation->set_error_delimiters('<div class="alert alert-error"><a class="close" data-dismiss="alert">×</a><i class="icon-exclamation-sign bigger-130">&nbsp;</i>', '</div>');
			
			if($this->form_validation->run() === true){
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
					// $pesan = pesan('Simpan data mesin '.$no_mesin.' berhasil', 'success');
					$status_info = 1;
				}
				else {
					$err = mssql_get_last_message();
					// $pesan = pesan('Simpan data mesin '.$no_mesin.' gagal.<br>Pesan : '. $err, pesan_error());			
				}
			} else {
				$pesan = validation_errors();
			}

			// $this->session->set_flashdata('savemsg', $pesan);
			// $this->session->set_flashdata('mesinaktif',$no_mesin);
			
			// redirect('transaksi/timbang_whitemeat');
		} else {
			// $pesan = pesan('Simpan data mesin '.$no_mesin.' gagal', pesan_error());
			// $this->session->set_flashdata('savemsg',$pesan);
			// $this->session->set_flashdata('mesinaktif',$no_mesin);
			
			// redirect('transaksi/timbang_whitemeat');
		}
		echo json_encode($status_info);
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

					$headerid = $this->m_trnhasil->get_header_hasil($tanggal, $idline, $idjamkerja);
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
	
	function detail_timbangak($no_mesin){
		if (isset($_POST['HeaderID'])){
			$header_id 	= $_POST['HeaderID'];
			$param_mesin = array(
				'HasilHeaderID'	=> $header_id,
				'NomorMesin'	=> $no_mesin
			);
			$record 	= $this->m_trn_timbangak->detail_timbangak($param_mesin);
			echo json_encode($record);
		}
	}

	function simpan_timbangak($no_mesin){
		if (isset($_POST['SimpanMesin'.$no_mesin])){
			$hasilak = $this->input->post('txtTimbang'.$no_mesin);
			
			if ($hasilak == ''){
				$hasilak = '0';
			} 
			
			$this->form_validation->set_rules('txtTimbang'.$no_mesin,'Kolom Air Kelapa','required');
			$this->form_validation->set_message('required', '<strong>%s</strong> wajib diisi!');
			$this->form_validation->set_error_delimiters('<div class="alert alert-error"><a class="close" data-dismiss="alert">×</a><i class="icon-exclamation-sign bigger-130">&nbsp;</i>', '</div>');
			
			if($this->form_validation->run()==true){
				$info = array(
					'HasilHeaderID'		=> $this->session->userdata('ak_headerid'),
					'NomorMesin'		=> $no_mesin,
					'HasilAK'			=> $hasilak,
					'CreatedBy'			=> strtoupper($this->session->userdata('userid')),
					'CreatedDate'		=> current_date_eng()
				);

				if($this->m_trn_timbangak->simpan_detail($info) === 1){
					$pesan = pesan('Simpan data mesin '.$no_mesin.' berhasil', 'success');
				}
				else{
					$err = mssql_get_last_message();
					$pesan = pesan('Simpan data mesin '.$no_mesin.' gagal.<br>Pesan : '.$err, pesan_error());			
				}
				
			} else {
				$pesan = validation_errors();				
			}
			
			$this->session->set_flashdata('savemsg', $pesan);
			$this->session->set_flashdata('mesinaktif',$no_mesin);
			
			// redirect('transaksi/timbang_airkelapa');
			
		} else {
			$pesan = pesan('Posting data mesin '.$no_mesin.' gagal', pesan_error());
			$this->session->set_flashdata('savemsg',$pesan);
			$this->session->set_flashdata('mesinaktif',$no_mesin);
			
			// redirect('transaksi/timbang_airkelapa');
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
	
	function hapus_timbangak($hasilhapus = null, $nomormesin = null){
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
	
//	TRANSAKSI HASIL - KELAPA CUNGKIL
	function kelapacungkil($aksi = '', $detailid = 0){
		switch ($aksi) {
			case 'edit':
				$data['record'] = $this->m_trn_hasilkc->get_detail_byid($detailid)->result();
				$data['detailid'] = $detailid;
				$this->load->view('transaksi/kelapacungkil/hasil_kc_edit', $data);
				break;

			default:
				if (!$this->session->userdata('kc_idline') || !$this->session->userdata('kc_shift')){
					$this->to_index('kelapacungkil');
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
					
					$data['tanggaltrn']	= $tanggal;
					$data['namaline']	= $namaline;
					$data['nomesinawal'] = $nomesinawal;
					$data['nomesinakhir'] = $nomesinakhir;
					$data['shift']		= $shift;
					$data['jamkerja']	= $jamkerja;
					$data['jammasuk']	= $jammasuk;

					$headerid = $this->m_trnhasil->get_header_hasil($tanggal, $idline, $idjamkerja);
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

						$this->template->display('transaksi/kelapacungkil/index',$data);
					} else {
						$this->session->set_userdata('kc_headerid', $headerid);
						
						if (!$this->session->flashdata('mesinaktif')){
							$mesinaktif = $nomesinawal;
						} else {
							$mesinaktif = $this->session->flashdata('mesinaktif');
						}

						$data['message'] = $this->session->flashdata('savemsg');
						$data['mesinaktif'] = $mesinaktif;
						$data['headerid']	= $headerid;

						$this->template->display('transaksi/kelapacungkil/hasil_kc',$data);
					}
				}
				
				break;
		}
		
	}
	
	function detail_hasilkc($no_mesin){
		if (isset($_POST['HeaderID'])){
			$header_id 	= $_POST['HeaderID'];
			$param_mesin = array(
				'HasilHeaderID'	=> $header_id,
				'NomorMesin'	=> $no_mesin
			);
			$record 	= $this->m_trn_hasilkc->detail_hasilkc($param_mesin);
			echo json_encode($record);
		}
	}

	function simpan_hasilkc($no_mesin){
		if (isset($_POST['SimpanMesin'.$no_mesin])){
			$hasilkc = $this->input->post('txtHasilKC'.$no_mesin);
			
			if ($hasilkc == ''){
				$hasilkc = '0';
			} 
			
			$this->form_validation->set_rules('txtHasilKC'.$no_mesin,'Kolom Kelapa Cungkil','required');
			$this->form_validation->set_message('required', '<strong>%s</strong> wajib diisi!');
			$this->form_validation->set_error_delimiters('<div class="alert alert-error"><a class="close" data-dismiss="alert">×</a><i class="icon-exclamation-sign bigger-130">&nbsp;</i>', '</div>');
			
			if($this->form_validation->run()==true){
				$info = array(
					'HasilHeaderID'		=> $this->session->userdata('kc_headerid'),
					'NomorMesin'		=> $no_mesin,
					'HasilKC'			=> $hasilkc,
					'CreatedBy'			=> strtoupper($this->session->userdata('userid')),
					'CreatedDate'		=> date('Y-m-d H:i:s')
				);

				if($this->m_trn_hasilkc->simpan_detail($info) === 1){
					$pesan = pesan('Simpan data mesin '.$no_mesin.' berhasil', 'success');
				}
				else{
					$err = mssql_get_last_message();
					$pesan = pesan('Simpan data mesin '.$no_mesin.' gagal.<br>Pesan : '.$err, pesan_error());			
				}
			} else {
				$pesan = validation_errors();
			}

			$this->session->set_flashdata('savemsg', $pesan);
			$this->session->set_flashdata('mesinaktif',$no_mesin);
			
			// redirect('transaksi/kelapacungkil');
		} else {
			$pesan = pesan('Posting data mesin '.$no_mesin.' gagal', pesan_error());
			$this->session->set_flashdata('savemsg',$pesan);
			$this->session->set_flashdata('mesinaktif',$no_mesin);
			
			// redirect('transaksi/kelapacungkil');
		}
	}
	
	function update_hasilkc($detailid){
		$hasilkc	= $this->input->post('txtEditHasilKC');
		$mesinaktif = $this->input->post('txtEditNoMesin');
		
		if ($hasilkc == ''){
			$hasilkc = '0';
		}
		
		$info = array(
			'HasilKC'			=> $hasilkc,
			'UpdatedBy'			=> strtoupper($this->session->userdata('userid')),
			'UpdatedDate'		=> date('Y-m-d H:i:s')
		);
		
		if($this->m_trn_hasilkc->update_detail($detailid, $info) === 1){
			$pesan = pesan('Update data mesin '.$mesinaktif.' berhasil', pesan_sukses());
		}else{
			$err = mssql_get_last_message();
			$pesan = pesan('Update data mesin '.$mesinaktif.' gagal.<br>Pesan : '. $err, pesan_error());			
		}

		$this->session->set_flashdata('savemsg', $pesan);
		$this->session->set_flashdata('mesinaktif', $mesinaktif);

		redirect('transaksi/kelapacungkil');
	}
	
	function hapus_hasilkc($hasilhapus, $nomormesin = null){
		switch ($hasilhapus) {
			case 'berhasil':
				$pesan = pesan('Hapus data di mesin '.$nomormesin.' berhasil', pesan_sukses());
				$this->session->set_flashdata('savemsg', $pesan);
				$this->session->set_flashdata('mesinaktif', $nomormesin);
				redirect('transaksi/kelapacungkil');
				break;
			
			case 'gagal':
				$pesan = pesan('Hapus data di mesin '.$nomormesin.' gagal', pesan_error());
				$this->session->set_flashdata('savemsg', $pesan);
				$this->session->set_flashdata('mesinaktif', $nomormesin);
				redirect('transaksi/kelapacungkil');
				break;

			default:
				$detailid = $this->input->post('detailid');
				$this->m_trn_hasilkc->delete_detail($detailid);
				break;
		}
	}
	
	function proses_hasilkc(){
		$this->form_validation->set_rules('txtTanggal', 'Tanggal','required|callback_check_date['. $this->input->post('txtTanggal'). ']');
		$this->form_validation->set_rules('txtLine', 'Line','required');
		$this->form_validation->set_rules('txtShift', 'Shift','required');
		$this->form_validation->set_rules('txtJamKerja', 'Jam Kerja','required');
		
		$this->form_validation->set_message('required', '<strong>%s</strong> wajib diisi!');
		
		$this->form_validation->set_error_delimiters('<div class="alert alert-error"><a class="close" data-dismiss="alert">×</a><i class="icon-exclamation-sign bigger-130">&nbsp;</i>', '</div>');
		
		if($this->form_validation->run()==false){
			$this->to_index('airkelapa');
		}else{
			$sess_data['kc_tanggal']	= $this->input->post('txtTanggal');
			$sess_data['kc_idline']		= $this->input->post('txtLine');
			$sess_data['kc_shift']		= $this->input->post('txtShift');
			$sess_data['kc_idjamkerja']	= $this->input->post('txtJamKerja');

			$this->session->set_userdata($sess_data);

			redirect('transaksi/kelapacungkil');
		}
	}
	
	function proses_hasilkc_selesai(){
		$this->session->unset_userdata('kc_tanggal');
		$this->session->unset_userdata('kc_idline');
		$this->session->unset_userdata('kc_shift');
		$this->session->unset_userdata('kc_idjamkerja');
		$this->session->unset_userdata('kc_headerid');
		redirect('transaksi/kelapacungkil');
	}
	
	function complete(){
		$data['cboline'] = $this->m_master->mst_line()->result();
		$data['cboshift'] = $this->m_master->mst_shift()->result();
		$data['cbojamkerja']= $this->m_master->mst_jamkerja()->result();
		
		$this->template->display('transaksi/complete/index', $data);
	}


	
}