<?php

class m_trn_isikeranjang extends CI_Model{
	
	function list_isi_keranjang(){
		if ($this->session->userdata('accessalldata') === 1) {
			$this->db->where(array('CompleteIsiKeranjang' => NULL));
		} else {
			$this->db->where(array('CompleteIsiKeranjang' => NULL, 'Inspector' => strtoupper($this->session->userdata('username'))));
		}
		$this->db->order_by('TglJamMasuk', 'DESC');
		return $this->db->get('vwOL_TrnHasilIsiKeranjang');
	}
	
	function list_view_detail(){
		$param = array(
			'Tanggal'	=> tgl_eng($this->session->userdata('serverdate')),
			'IDLine'	=> $this->session->userdata('krj_idline'),
			'IDShift'	=> $this->session->userdata('krj_shift')
		);
		
		$this->db->order_by('NomorMesin','NomorKeranjang');
		return $this->db->get_where('vwOL_TrnHasilKeranjang', $param);
	}
	
	function get_header_sebelum($headerid, $idline){
		$this->db->select('TglJamMasuk')->from('vwOL_TrnHasilHeader');
		$this->db->where('HasilHeaderID', $headerid);		
		$sql1 = $this->db->get();
		if($sql1->num_rows() > 0){
			$r1 = $sql1->row();
			$tgljammasuk_sekarang = datetime_eng($r1->TglJamMasuk);
		}
		
		$headerid_sebelum = 0;
		$this->db->select('Top 1 HasilHeaderID')->from('vwOL_TrnHasilHeader');
		$this->db->where('IDLine', $idline);
		$this->db->where("TglJamMasuk < '".$tgljammasuk_sekarang."'");
		$this->db->order_by('TglJamMasuk', 'DESC');
		$sql2 = $this->db->get();
		if($sql2->num_rows() > 0){
			$r2 = $sql2->row();
			$headerid_sebelum = $r2->HasilHeaderID;
		}
		return $headerid_sebelum;
	}
	
	function get_isiawal($headerid){				
		$sql = 'Select HasilHeaderID, NomorMesin, IsiAwal1 = [1], IsiAwal2 = [2] From '
			. '(Select HasilHeaderID, NomorMesin, NomorKeranjang, SisaKeranjang From tblOL_TrnHasilSisaKeranjangHistory) as s '
			. 'PIVOT (SUM(SisaKeranjang) FOR NomorKeranjang IN ([1], [2])) as pvt '
			. 'Where HasilHeaderID = '.$headerid;
		return $this->db->query($sql);
	}
		
	function get_isitambah($headerid){
		$sql = 'Select HasilHeaderID, NomorMesin, UrutanTambah, Krj1 = [1], Krj2 = [2] From '
			. '(Select HasilHeaderID, NomorMesin, UrutanTambah, NomorKeranjang, JumlahTambah From tblOL_TrnHasilIsiKeranjangHistory) as s '
			. 'PIVOT (SUM(JumlahTambah) FOR NomorKeranjang IN ([1], [2])) as pvt '
			. 'Where HasilHeaderID = '.$headerid;
		return $this->db->query($sql);		
	}
	
	function get_sisa($headerid){
		$sql = 'Select HasilHeaderID, NomorMesin, Isi, Sisa1 = [1], Sisa2 = [2] From '
			. '(Select HasilHeaderID, NomorMesin, Isi, NomorKeranjang, SisaKeranjang From tblOL_TrnHasilSisaKeranjangHistory) as s '
			. 'PIVOT (SUM(SisaKeranjang) FOR NomorKeranjang IN ([1], [2])) as pvt '
			. 'Where HasilHeaderID = '.$headerid.' And Isi = 0 ';
		return $this->db->query($sql);
	}
	
	function get_isilanjut($headerid){
		$sql = 'Select HasilHeaderID, NomorMesin, Isi, Sisa1 = [1], Sisa2 = [2] From '
			. '(Select HasilHeaderID, NomorMesin, Isi, NomorKeranjang, SisaKeranjang From tblOL_TrnHasilSisaKeranjangHistory) as s '
			. 'PIVOT (SUM(SisaKeranjang) FOR NomorKeranjang IN ([1], [2])) as pvt '
			. 'Where HasilHeaderID = '.$headerid.' And Isi = 1 ';
		return $this->db->query($sql);
	}
		
	function get_urutan_terakhir($headerid, $nomormesin){
		$param = array(
			'HasilHeaderID'	=> $headerid,
			'NomorMesin'	=> $nomormesin
		);
		
		$this->db->select('Top 1 UrutanTambah as UrutanTerakhir');
		$this->db->from('tblOL_TrnHasilIsiKeranjangHistory');
		$this->db->where($param);
		$this->db->order_by('UrutanTambah', 'desc');
		
		$sql = $this->db->get();
		if ($sql->num_rows() > 0){
			$row = $sql->row();
			$urutanterakhir = $row->UrutanTerakhir;
		} else {
			$urutanterakhir = 0;
		}
		return number_format($urutanterakhir);
	}
	
	function simpan_history($aksi, $info){
		$berhasil = 0;
		
		switch ($aksi) {
			case 'tambah':
				$namatabel = 'tblOL_TrnHasilIsiKeranjangHistory';
				break;
			case 'sisa':
				$namatabel = 'tblOL_TrnHasilSisaKeranjangHistory';
				break;
			case 'isi':
				$namatabel = 'tblOL_TrnHasilSisaKeranjangHistory';
				break;

			default:
				break;
		}
		
		$this->db->trans_start();
		$this->db->insert($namatabel, $info);
		$this->db->trans_complete();
		
		if ($this->db->trans_status() === TRUE){
			$berhasil = 1;
		}
		
		return $berhasil;
	}
	
	function update_history($aksi, $detailid, $info){
		$berhasil = 0;
		
		switch ($aksi) {
			case 'tambah':
				$namatabel	= 'tblOL_TrnHasilIsiKeranjangHistory';
				$fieldID	= 'IDKrjHistory';
				break;
			case 'sisa':
				$namatabel	= 'tblOL_TrnHasilSisaKeranjangHistory';
				$fieldID	= 'IDSisaKrj';
				break;
			case 'isi':
				$namatabel	= 'tblOL_TrnHasilSisaKeranjangHistory';
				$fieldID	= 'IDSisaKrj';
				break;

			default:
				break;
		}
		
		$this->db->trans_start();
		$this->db->where($fieldID, $detailid);
		$this->db->update($namatabel, $info);
		$this->db->trans_complete();
		
		if ($this->db->trans_status() === TRUE){
			$berhasil = 1;
		}
		
		return $berhasil;
	}
	
	function get_idkrjhistory($headerid, $nomormesin, $urutantambah, $keranjang){
		$param = array(
			'HasilHeaderID'	=> $headerid,
			'NomorMesin'	=> $nomormesin,
			'UrutanTambah'	=> $urutantambah,
			'NomorKeranjang'=> $keranjang
		);
		$sql = $this->db->get_where('tblOL_TrnHasilIsiKeranjangHistory', $param);
		if ($sql->num_rows() > 0){
			$row = $sql->row();
			$idkrjhistory = $row->IDKrjHistory;
		}
		return $idkrjhistory;
	}
	
	function get_idsisahistory($headerid, $nomormesin, $keranjang){
		$param = array(
			'HasilHeaderID'	=> $headerid,
			'NomorMesin'	=> $nomormesin,
			'NomorKeranjang'=> $keranjang,
			'Isi'			=> 0
		);
		$sql = $this->db->get_where('tblOL_TrnHasilSisaKeranjangHistory', $param);
		if ($sql->num_rows() > 0){
			$row = $sql->row();
			$idsisahistory = $row->IDSisaKrj;
		}
		return $idsisahistory;
	}
	
	function get_idisihistory($headerid, $nomormesin, $keranjang){
		$param = array(
			'HasilHeaderID'	=> $headerid,
			'NomorMesin'	=> $nomormesin,
			'NomorKeranjang'=> $keranjang,
			'Isi'			=> 1
		);
		$sql = $this->db->get_where('tblOL_TrnHasilSisaKeranjangHistory', $param);
		if ($sql->num_rows() > 0){
			$row = $sql->row();
			$idisihistory = $row->IDSisaKrj;
		}
		return $idisihistory;
	}
		
	function hapus_history($aksi){		
		switch ($aksi) {
			case 'tambah':
				$id = $this->input->post('idkrj');
				$namatabel = 'tblOL_TrnHasilIsiKeranjangHistory';
				$fieldID = 'IDKrjHistory';				
				break;
			case 'sisa':
				$id = $this->input->post('idsisa');
				$namatabel = 'tblOL_TrnHasilSisaKeranjangHistory';
				$fieldID = 'IDSisaKrj';
				break;
			case 'isi':
				$id = $this->input->post('idisi');
				$namatabel = 'tblOL_TrnHasilSisaKeranjangHistory';
				$fieldID = 'IDSisaKrj';
				break;

			default:
				break;
		}
		
		$this->db->trans_start();
		$this->db->where($fieldID, $id);
		$this->db->delete($namatabel);
		$this->db->trans_complete();
	}
	
	function cek_detail_exists($headerid, $nomormesin){
		$detailid = 0;
		$sql = $this->db->get_where('tblOL_TrnHasilIsiKeranjang', array('HasilHeaderID'=>$headerid, 'NomorMesin'=>$nomormesin));
		if ($sql->num_rows() > 0){
			$row = $sql->row();
			$detailid = $row->HasilKeranjangID;
		}
		return $detailid;
	}
	
}