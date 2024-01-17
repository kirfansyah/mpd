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
		$data['message'] = $this->session->flashdata('message');
		
		$data['cboline'] = $this->m_master->mst_line()->result();
		$data['cboshift'] = $this->m_master->mst_shift()->result();
		$data['cbojamkerja']= $this->m_master->mst_jamkerja()->result();
		
		switch ($pekerjaan) {
			case 'sheller':
				$idpekerjaan = 2;
				$tanggal= $this->session->userdata('shl_tanggal');
				$idline	= $this->session->userdata('shl_idline');
				$shift	= $this->session->userdata('shl_shift');
				$idjamkerja = $this->session->userdata('shl_idjamkerja');
				break;
			
			case 'parer':
				$idpekerjaan = 3;
				$tanggal= $this->session->userdata('par_tanggal');
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
		$data['namaline']	= $namaline;
		$data['nomesinawal']= $nomesinawal;
		$data['nomesinakhir']=$nomesinakhir;
		$data['idshift']	= $shift;
		$data['idjamkerja']	= $idjamkerja;
		$data['showdetail'] = $showdetail;
		
		if ($showdetail == 1){
			$record = $this->m_absensi->get_urutnama($idpekerjaan, $tanggal, $idline, $shift)->result();
			$data['listtk'] = $record;
		}
		
		$this->template->display('absensi/'.$pekerjaan.'/index', $data);
		
	}
	
	function simpan_detail_urut_sheller($uruthdrid, $nomormesin, $fixno, $info){
		$urutdtlid = $this->m_absensi->get_urutheader($uruthdrid, $nomormesin, $fixno);				
		if ($urutdtlid === 0){
			$urutdltid_result = $this->m_absensi->insert_detail_urut($info);
			
			if ($urutdltid_result > 0){
				redirect('absensi/sheller/set');
			}
		}
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
			$tanggal	= $this->input->post('txtTanggal');
			$idline		= $this->input->post('txtLine');
			$idshift	= $this->input->post('txtShift');
			
			$complete = $this->m_absensi->absencompleted($tanggal, $idline, $idshift, $idpekerjaan);
				
			if ($complete === true){
				$this->session->set_flashdata('message',pesan('Data tidak dapat diubah karena sudah di Complete!', pesan_info()));				
				redirect('absensi/completed/'.$pekerjaan);
			} else {
				$sess_data[$prefix.'_tanggal']		= $this->input->post('txtTanggal');
				$sess_data[$prefix.'_idline']		= $this->input->post('txtLine');
				$sess_data[$prefix.'_shift']		= $this->input->post('txtShift');
				$sess_data[$prefix.'_idjamkerja']	= $this->input->post('txtJamKerja');
				$sess_data[$prefix.'_idpekerjaan']	= $idpekerjaan;
				$this->session->set_userdata($sess_data);

				redirect('absensi/'.$pekerjaan.'/set');
			}
		}	
	}
	
	function completed(){
		$pekerjaan = $this->uri->segment(3);
		$this->to_index($pekerjaan);
	}
	
	function rekap($pekerjaan){
		$hdrid = $this->input->post('txtHeaderID');
		$dtlid = $this->input->post('txtDtlID');
		$fixno = $this->input->post('txtFixNo');
		$absen = $this->input->post('txtAbsen');
		$ket	= $this->input->post('txtKeterangan');
		$jumdtl = count($this->input->post('txtDtlID'));
		
		switch ($pekerjaan) {
			case 'sheller':
				$idpekerjaan = 2;
				break;
			case 'parer':
				$idpekerjaan = 3;
				break;

			default:
				$idpekerjaan = 0;
				break;
		}
		
		for($i=1; $i <= $jumdtl; $i++){
			$detailurutid = $dtlid[$i];
			if ($detailurutid === '0' && trim($absen[$i]) !== ''){
				$info = array(
					'UrutHdrID'	=> $hdrid,
					'FixNo'		=> $fixno[$i],
					'IDPekerjaan' => $idpekerjaan,
					'Absensi'	=> $absen[$i],
					'Keterangan'=> $ket[$i],
					'CreatedBy'	=> strtoupper($this->session->userdata('userid')),
					'CreatedDate'=> date('Y-m-d H:i:s')
				);
				$this->m_absensi->insert_rekap($info);
			} else {
				$info = array(
					'Absensi'	=> $absen[$i],
					'Keterangan'=> $ket[$i],
					'UpdatedBy'	=> strtoupper($this->session->userdata('userid')),
					'UpdatedDate' => date('Y-m-d H:i:s')
				);
				$this->m_absensi->update_rekap($detailurutid, $info);
			}			
		}
		
		switch ($idpekerjaan) {
			case 2:
				redirect('absensi/sheller/set');
				break;
			
			case 3:
				redirect('absensi/parer/set');
				break;

			default:
				redirect(base_url);
				break;
		}
		
	}

//Transaksi Sheller
	function sheller($aksi = '', $nomormesin = 0){
		if(!$this->session->userdata('userid')){
            redirect('login');
        }
		
		$prefix = 'shl';
		
		switch ($aksi) {
			case 'set':
				$data['pekerjaan'] = 'Sheller';
				$tanggal= tgl_eng($this->session->userdata('shl_tanggal'));
				$idline	= $this->session->userdata('shl_idline');
				$shift	= $this->session->userdata('shl_shift');
				
				$qline = $this->m_master->mst_line($idline)->result();
				foreach ($qline as $r){
					$namaline = $r->NamaLine;
					$nomesinawal = $r->NomorMesinAwal;
					$nomesinakhir = $r->NomorMesinAkhir;
				}
				
				$data['tanggal']	 = $tanggal;
				$data['namaline']	 = $namaline;
				$data['shift']		 = $shift;
				$data['nomesinawal'] = $nomesinawal;
				$data['nomesinakhir']= $nomesinakhir;
				
				$headerid = $this->m_absensi->get_urutheader(2, $prefix);				
				$data['headerid'] = $headerid;
								
				$pengawas = $this->m_absensi->get_pengawas_sheller();
				$data['pengawas'] = $pengawas === '' ? $this->session->userdata('username') : $pengawas;
				
				$record = $this->m_absensi->get_urutnama(2, $tanggal, $idline, $shift)->result();
				$data['listurut'] = $record;
				
				$record_trans = $this->m_absensi->get_trans_urutan(2, 'shl')->result();
				$data['record_trans'] = $record_trans;
				
				$urutandetail = $this->m_absensi->get_trans_urutan_detail($headerid)->result();
				$data['urutandetail'] = $urutandetail;
				
				$data['msg_simpan'] = $this->session->flashdata('msg_simpan');
				
				$tipeabsensi = $this->m_absensi->get_tipeabsensi()->result();
				$data['tipeabsensi'] = $tipeabsensi;

				$this->template->display('absensi/sheller/aturmesin', $data);
				break;
				
			case 'save' :
				$uruthdrid = $this->m_absensi->get_urutheader(2, 'shl');
				if ($uruthdrid === 0){
					$info = array(
						'Tanggal'	 => tgl_eng($this->session->userdata($prefix.'_tanggal')),
						'IDLine'	 => $this->session->userdata($prefix.'_idline'),
						'IDShift'	 => $this->session->userdata($prefix.'_shift'),
						'JenisKerja' => 2,
						'Pengawas'	 => ucfirst($this->session->userdata('username')),
						'CreatedBy'	 => strtoupper($this->session->userdata('userid')),
						'CreatedDate'=> date('Y-m-d H:i:s')
					);
					$uruthdrid = $this->m_absensi->insert_header_urut($info);
				}
				
				$fixno = $this->input->post('fixno');
				
				$info_detail = array(
					'UrutHdrID'	 => $uruthdrid,
					'NomorMesin' => $nomormesin,
					'FixNo'		 => $fixno,
					'IDPekerjaan'=> 2,
					'Absensi'	 => 'M',
					'CreatedBy'	 => strtoupper($this->session->userdata('userid')),
					'CreatedDate'=> date('Y-m-d H:i:s')
				);
				
//				$this->simpan_detail_urut_sheller($uruthdrid, $nomormesin, $fixno, $info);
				
//				$urutdtlid = $this->m_absensi->get_urutheader($uruthdrid, $nomormesin, $fixno);
				$urutdtlid = $this->m_absensi->get_urutdetail($uruthdrid, $nomormesin, $fixno);
				if ($urutdtlid === 0){
					$this->m_absensi->insert_detail_urut($info_detail);
				}
				
				break;
				
			case 'edit':
				$detailid = $this->uri->segment(5);
				$data['detailid'] = $detailid;
				$data['nomormesin'] = $nomormesin;
				
				$qdetail = $this->m_absensi->get_urutdetail_info($detailid)->result();
				foreach($qdetail as $r){
					$headerid = $r->UrutHdrID;
					$nama	= $r->Nama;
					$fixno	= $r->FixNo;
				}
				
				$data['headerid'] = $headerid;
				$data['nama']	= $nama;
				$data['fixno']	= $fixno;
				
				$tanggal= tgl_eng($this->session->userdata('shl_tanggal'));
				$idline	= $this->session->userdata('shl_idline');
				$shift	= $this->session->userdata('shl_shift');
				
				$listurut = $this->m_absensi->urutan_tk(2, $idline, $shift)->result();
				$data['listurut'] = $listurut;
				
				$this->load->view('absensi/sheller/urutedit', $data);
				break;
				
			case 'update':
				$fixno = $this->input->post('txtEditNama');
				$headerid = $this->input->post('txtEditHeaderID');
				$detailid = $this->input->post('txtEditDetailID');
				$nomesin = $this->input->post('txtEditNoMesin');
				
				$query = $this->db->get_where('tblOL_TrnUrutanDetail', array('UrutHdrID'=>$headerid, 'FixNo'=>$fixno));
				if ($query->num_rows() > 0){
					$row = $query->row();
					$deletedetailidd = $row->UrutDtlID;
					$this->m_absensi->delete_detail(2, $deletedetailidd);
				}
				
				$info_detail = array(
					'NomorMesin'	=> $nomesin,
					'FixNo'			=> $fixno,
					'IDPekerjaan'	=> 2,
					'Absensi'		=> 'M',
					'UpdatedBy'		=> strtoupper($this->session->userdata('userid')),
					'UpdatedDate'	=> date('Y-m-d H:i:s')
				);
				
				$this->m_absensi->update_detail_urut($detailid, $info_detail);
				
				redirect('absensi/sheller/set');
				
				break;
				
			case 'delete':
				$detailid = $this->input->post('detailid');
				$this->m_absensi->delete_detail($detailid);				
				break;
			
			case 'complete':
				$uruthdrid = $this->input->post('uruthdrid');
				$this->m_absensi->complete($uruthdrid);
				break;
			
			case 'search':
				$data['record_tk']	= $this->m_absensi->get_listalltk()->result();
				$data['pekerjaan']	= 'sheller';
				$data['cbopekerjaan'] = $this->m_master->mst_pekerjaan_mpd()->result();
				$data['cboshift']	= $this->m_master->mst_shift()->result();
				$data['cboline']	= $this->m_master->mst_line()->result();
				$data['cboperusahaan'] = $this->m_master->mst_perusahaan()->result();
				$data['nomormesin']	= $nomormesin;
				
				$idpekerjaan = $this->input->post('txtPekerjaan');
				$idshift = $this->input->post('txtShift');
				$idline = $this->input->post('txtLine');
				$idperusahaan = $this->input->post('txtPerusahaan');
				$nama = $this->input->post('txtNama');				
				$nik = $this->input->post('txtNIK');
								
				if ($this->input->server('REQUEST_METHOD') === 'POST'){	
					if (empty($idpekerjaan)){
						$idpekerjaan = 2;
					}
					$data['search_result'] = $this->m_absensi->search_tk($idpekerjaan, $idshift, $idline, $idperusahaan, $nama, $nik)->result();
					$data['selectpekerjaan'] = $idpekerjaan;
					$data['idshift'] = $idshift;
					$data['idline']	= $idline;
					$data['idperusahaan'] = $idperusahaan;
					$data['searchnama'] = $nama;
					$data['searchnik'] = $nik;
				} else {
					$data['search_result'] = null;
					$data['selectpekerjaan'] = 2;
					$data['idshift'] = $this->session->userdata('shl_shift');
					$data['idline']	= $idline; //$this->session->userdata('shl_idline');
					$data['idperusahaan'] = $idperusahaan;
					$data['searchnama'] = $nama;
					$data['searchnik'] = $nik;					
				}
				
				$data['page_asal'] = 'sheller';
				
				$this->template->display('absensi/sheller/search', $data, 1);
				break;
				
			case 'simpanpilih':
//				if (!empty($_POST['btnSimpanPilih'])){
					$uruthdrid = $this->m_absensi->get_urutheader(2, $prefix);
					if ($uruthdrid === 0){
						$info = array(
							'Tanggal'	 => tgl_eng($this->session->userdata($prefix.'_tanggal')),
							'IDLine'	 => $this->session->userdata($prefix.'_idline'),
							'IDShift'	 => $this->session->userdata($prefix.'_shift'),
							'JenisKerja' => 2,
							'Pengawas'	 => ucfirst($this->session->userdata('username')),
							'CreatedBy'	 => strtoupper($this->session->userdata('userid')),
							'CreatedDate'=> date('Y-m-d H:i:s')
						);
						$uruthdrid = $this->m_absensi->insert_header_urut($info);
					}
					
//					if (isset($_POST['simpanpilih'])){
						$fixno = $this->input->post('radioPilih');
						$pilih_idpekerjaan = $this->input->post('txtPilihIDPekerjaan');
					
						$info_detail = array(
							'UrutHdrID'	 => $uruthdrid,
							'NomorMesin' => $nomormesin,
							'FixNo'		 => $fixno,
							'IDPekerjaan'=> $pilih_idpekerjaan,
							'Absensi'	 => 'M',
							'CreatedBy'	 => strtoupper($this->session->userdata('userid')),
							'CreatedDate'=> date('Y-m-d H:i:s')
						);

						$urutdtlid = $this->m_absensi->get_urutdetail($uruthdrid, $nomormesin, $fixno);				
						if ($urutdtlid === 0){
							$this->m_absensi->insert_detail_urut($info_detail);
							$msg_simpan = '';
						} else {
							$msg_simpan = pesan('Data Sudah Ada', pesan_error());
						}
						
						$this->session->set_flashdata('msg_simpan', $msg_simpan);

						redirect('absensi/sheller/set/'.$nomormesin);
//					} else {
//						$this->session->set_flashdata('pesansimpanpilih', pesan('Pilih Salah Satu Tenaga Kerja', pesan_error()));
//						$this->sheller('search', $nomormesin);
//					}
										
//				}
				break;
						
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
	
//Transaksi Parer	
	function parer($aksi = '', $nomormesin = 0){		
		if(!$this->session->userdata('userid')){
            redirect('login');
        }
		
		$prefix = 'par';
				
		switch ($aksi) {
			case 'set':
				$data['pekerjaan'] = 'Parer';
				$tanggal= tgl_eng($this->session->userdata($prefix.'_tanggal'));
				$idline	= $this->session->userdata($prefix.'_idline');
				$shift	= $this->session->userdata($prefix.'_shift');
				
				$qline = $this->m_master->mst_line($idline)->result();
				foreach ($qline as $r){
					$namaline = $r->NamaLine;
					$nomesinawal = $r->NomorMesinAwal;
					$nomesinakhir = $r->NomorMesinAkhir;
				}
				
				$data['tanggal']	 = $tanggal;
				$data['namaline']	 = $namaline;
				$data['shift']		 = $shift;
				$data['nomesinawal'] = $nomesinawal;
				$data['nomesinakhir']= $nomesinakhir;
				
				$headerid = $this->m_absensi->get_urutheader(3, $prefix);				
				$data['headerid'] = $headerid;
								
				$pengawas = $this->m_absensi->get_pengawas_parer();
				$data['pengawas'] = $pengawas === '' ? $this->session->userdata('username') : $pengawas;
				
				$record = $this->m_absensi->get_urutnama(3, $tanggal, $idline, $shift)->result();
				$data['listurut'] = $record;
				
				$record_trans = $this->m_absensi->get_trans_urutan(3, 'par')->result();
				$data['record_trans'] = $record_trans;
				
				$urutandetail = $this->m_absensi->get_trans_urutan_detail($headerid)->result();
				$data['urutandetail'] = $urutandetail;
				
				$data['msg_simpan'] = $this->session->flashdata('msg_simpan');
				
				$tipeabsensi = $this->m_absensi->get_tipeabsensi()->result();
				$data['tipeabsensi'] = $tipeabsensi;

				$this->template->display('absensi/parer/aturmesin', $data);
				break;

			case 'save' :
				$uruthdrid = $this->m_absensi->get_urutheader(3, 'par');
				if ($uruthdrid === 0){
					$info = array(
						'Tanggal'	 => tgl_eng($this->session->userdata($prefix.'_tanggal')),
						'IDLine'	 => $this->session->userdata($prefix.'_idline'),
						'IDShift'	 => $this->session->userdata($prefix.'_shift'),
						'JenisKerja' => 3,
						'Pengawas'	 => ucfirst($this->session->userdata('username')),
						'CreatedBy'	 => strtoupper($this->session->userdata('userid')),
						'CreatedDate'=> date('Y-m-d H:i:s')
					);
					$uruthdrid = $this->m_absensi->insert_header_urut($info);
				}
				
				$fixno = $this->input->post('fixno');
				$posisi = $this->input->post('posisi');
				
				$info_detail = array(
					'UrutHdrID'	  => $uruthdrid,
					'NomorMesin'  => $nomormesin,
					'FixNo'		  => $fixno,
					'IDPekerjaan' => 3,
					'Absensi'	  => 'M',
					'Posisi'	  => $posisi,
					'CreatedBy'	  => strtoupper($this->session->userdata('userid')),
					'CreatedDate' => date('Y-m-d H:i:s')
				);

				$urutdtlid = $this->m_absensi->get_urutdetail($uruthdrid, $nomormesin, $fixno);
				if ($urutdtlid === 0){
					$this->m_absensi->insert_detail_urut($info_detail);
				}
				
				break;
				
			case 'delete':
				$detailid = $this->input->post('detailid');
				$this->m_absensi->delete_detail($detailid);				
				break;
			
			case 'search':
				$posisi = $this->uri->segment(5);
				$data['record_tk']	= $this->m_absensi->get_listalltk()->result();
				$data['pekerjaan']	= 'parer';
				$data['cbopekerjaan'] = $this->m_master->mst_pekerjaan_mpd()->result();
				$data['cboshift']	= $this->m_master->mst_shift()->result();
				$data['cboline']	= $this->m_master->mst_line()->result();
				$data['cboperusahaan'] = $this->m_master->mst_perusahaan()->result();				
				$data['nomormesin']	= $nomormesin;
				$data['posisi'] = $posisi;
				
				$idpekerjaan = $this->input->post('txtPekerjaan');
				$idshift = $this->input->post('txtShift');
				$idline = $this->input->post('txtLine');
				$idperusahaan = $this->input->post('txtPerusahaan');
				$nama = $this->input->post('txtNama');
				$nik = $this->input->post('txtNIK');
								
				if ($this->input->server('REQUEST_METHOD') === 'POST'){	
					if (empty($idpekerjaan)){
						$idpekerjaan = 3;
					}
					$data['search_result'] = $this->m_absensi->search_tk($idpekerjaan, $idshift, $idline, $idperusahaan, $nama, $nik)->result();
					$data['selectpekerjaan'] = $idpekerjaan;
					$data['idshift'] = $idshift;
					$data['idline']	= $idline;
					$data['idperusahaan'] = $idperusahaan;
					$data['searchnama'] = $nama;
					$data['searchnik'] = $nik;
				} else {
					$data['search_result'] = null;
					$data['selectpekerjaan'] = 3;
					$data['idshift'] = $this->session->userdata('shl_shift');
					$data['idline']	= $idline;
					$data['idperusahaan'] = $idperusahaan;
					$data['searchnama'] = $nama;
					$data['searchnik'] = $nik;					
				}
				
				$data['page_asal'] = 'parer';
				
				$this->template->display('absensi/parer/search', $data, 1);
				break;
				
			case 'simpanpilih':
				$posisi = $this->uri->segment(5);
				$uruthdrid = $this->m_absensi->get_urutheader(2, $prefix);
				if ($uruthdrid === 0){
					$info = array(
						'Tanggal'	 => tgl_eng($this->session->userdata($prefix.'_tanggal')),
						'IDLine'	 => $this->session->userdata($prefix.'_idline'),
						'IDShift'	 => $this->session->userdata($prefix.'_shift'),
						'JenisKerja' => 3,
						'Pengawas'	 => ucfirst($this->session->userdata('username')),
						'CreatedBy'	 => strtoupper($this->session->userdata('userid')),
						'CreatedDate'=> date('Y-m-d H:i:s')
					);
					$uruthdrid = $this->m_absensi->insert_header_urut($info);
				}
					
				$fixno = $this->input->post('radioPilih');
				$pilih_idpekerjaan = $this->input->post('txtPilihIDPekerjaan');

				$info_detail = array(
					'UrutHdrID'	 => $uruthdrid,
					'NomorMesin' => $nomormesin,
					'FixNo'		 => $fixno,
					'IDPekerjaan'=> $pilih_idpekerjaan,
					'Absensi'	 => 'M',
					'Posisi'	 => $posisi,
					'CreatedBy'	 => strtoupper($this->session->userdata('userid')),
					'CreatedDate'=> date('Y-m-d H:i:s')
				);

				$urutdtlid = $this->m_absensi->get_urutdetail($uruthdrid, $nomormesin, $fixno);				
				if ($urutdtlid === 0){
					$this->m_absensi->insert_detail_urut($info_detail);
					$msg_simpan = '';
				} else {
					$msg_simpan = pesan('Data Sudah Ada', pesan_error());
				}

				$this->session->set_flashdata('msg_simpan', $msg_simpan);

				redirect('absensi/parer/set/'.$nomormesin);

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
}