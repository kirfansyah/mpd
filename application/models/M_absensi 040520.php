<?php

class m_absensi extends CI_Model{
		
	function get_urutnama($idpekerjaan, $tanggal, $idline, $shift){
		
		$query = "Select * From vwOL_TrnUrutTK Where IDPekerjaan=".$idpekerjaan." And IDLine=".$idline." And IDShift='".$shift."' And SudahKeluar = 0 "
				."And Tanggalkeluartemp is null and TanggalKeluar is null "
				."And FixNo Not In (Select FixNo From vwOL_TrnUrutan Where IDPekerjaan=".$idpekerjaan." And IDLine=".$idline." And IDShift='".$shift."' "
				."And Convert(smalldatetime,Tanggal,103)=Convert(smalldatetime,Convert(varchar(10),'".tgl_ind($tanggal)."',103),103))" ;
		$query .= " Order By NoUrut ";
		
		return $this->db->query($query);
	}

	function get_urutAnggota($idpekerjaan, $idline, $shift){
		$query = "Select * From vwOL_TrnUrutTK Where IDPekerjaan=".$idpekerjaan." And IDLine=".$idline." And IDShift='".$shift."'"
		//."And SudahKeluar = 0 And Tanggalkeluartemp is null and TanggalKeluar is null "
		;
			$query .= " Order By NoUrut ";
			return $this->db->query($query);
	}
	
	function urutan_tk($idpekerjaan, $idline, $shift){
		$param = array(
			'IDPekerjaan'	=> $idpekerjaan,
			'IDLine'		=> $idline,
			'IDShift'		=> $shift,
			'SudahKeluar'	=> 0
		);
		
		$this->db->where($param);
		return $this->db->get('vwOL_TrnUrutTK');
	}
	
	function get_trans_urutan($idpekerjaan, $prefix){
		$param = array(
			'Tanggal'	 => tgl_eng($this->session->userdata($prefix.'_tanggal')),
			'IDLine'	 => $this->session->userdata($prefix.'_idline'),
			'IDShift'	 => $this->session->userdata($prefix.'_shift'),
			'JenisKerja' => $idpekerjaan
		);
		
		$this->db->where($param);
		$this->db->order_by('NomorMesin');
		return $this->db->get('vwOL_TrnUrutan');
	}
	
	function get_trans_urutan_detail($headerid){
		$sql = 'Select * From dbo.fnTrnUrutanDetail ('.$headerid.') Order By UrutDtlID, NomorMesin';
		return $this->db->query($sql);
	}
	
	function get_urutheader($idpekerjaan, $prefix){				
		$param = array(
			'Tanggal'	 => tgl_eng($this->session->userdata($prefix.'_tanggal')),
			'IDLine'	 => $this->session->userdata($prefix.'_idline'),
			'IDShift'	 => $this->session->userdata($prefix.'_shift'),
			'JenisKerja' => $idpekerjaan
		);
		
		$urutheader = 0;
		$query = $this->db->get_where('tblOL_TrnUrutanHeader', $param);
		if ($query->num_rows() > 0){
			$row = $query->row();
			$urutheader = $row->UrutHdrID;
		} 
		
		return $urutheader;
	}
	
	function get_pengawas_sheller(){
		$prefix = 'shl';
		$param = array(
			'Tanggal'	 => tgl_eng($this->session->userdata($prefix.'_tanggal')),
			'IDLine'	 => $this->session->userdata($prefix.'_idline'),
			'IDShift'	 => $this->session->userdata($prefix.'_shift'),
			'JenisKerja' => 2
		);
		
		$pengawas = '';
		$query = $this->db->get_where('tblOL_TrnUrutanHeader', $param);
		if ($query->num_rows() > 0){
			$row = $query->row();
			$pengawas = $row->Pengawas;
		}
		
		return $pengawas;
	}
	
	function get_pengawas_parer(){
		$prefix = 'par';
		$param = array(
			'Tanggal'	 => tgl_eng($this->session->userdata($prefix.'_tanggal')),
			'IDLine'	 => $this->session->userdata($prefix.'_idline'),
			'IDShift'	 => $this->session->userdata($prefix.'_shift'),
			'JenisKerja' => 3
		);
		
		$pengawas = '';
		$query = $this->db->get_where('tblOL_TrnUrutanHeader', $param);
		if ($query->num_rows() > 0){
			$row = $query->row();
			$pengawas = $row->Pengawas;
		}
		
		return $pengawas;
	}
	
	function get_urutdetail($uruthdrid, $nomormesin, $fixno){				
		$param = array(
			'UrutHdrID'	 => $uruthdrid,
			'NomorMesin' => $nomormesin,
			'FixNo'		 => $fixno
		);
		
		$urutdetail = 0;
		$query = $this->db->get_where('tblOL_TrnUrutanDetail', $param);
		foreach ($query->result() as $row){
			$urutdetail = $row->UrutDtlID;
		}
//		if ($query->num_rows() > 0){
//			$row = $query->row();
//			$urutdetail = $row->UrutDtlID;
//		} 
		
		return $urutdetail;
	}
	
	function get_urutdetail_info($urutdtlid){
		$this->db->where('UrutDtlID', $urutdtlid);
		return $this->db->get('vwOL_TrnUrutan');
	}
	
	function get_urutdetail_exist($tanggal, $idshift, $fixno){
		$param = array(
			'Tanggal'	=> $tanggal,
			'IDShift'	=> $idshift,
			'FixNo'		=> $fixno,
		);
		return $this->db->get_where('vwOL_TrnUrutan', $param);
	}
	
	function insert_header_urut($info){
		$this->db->trans_start();
		$this->db->insert('tblOL_TrnUrutanHeader',$info);
		$uruthdrid = $this->db->insert_id();
		$this->db->trans_complete();

		return $uruthdrid;
	}
	
	function insert_detail_urut($info){
		$this->db->trans_start();
		$this->db->insert('tblOL_TrnUrutanDetail',$info);
		$urutdtlid = $this->db->insert_id();
		$this->db->trans_complete();

		return $urutdtlid;
	}
	
	function insert_detail_urut_history($info){
		$this->db->trans_start();
		$this->db->insert('tblOL_TrnUrutanDetailHistory',$info);
		$urutdtlid = $this->db->insert_id();
		$this->db->trans_complete();

		return $urutdtlid;
	}
	
	function update_detail_urut($detailid, $info){
		$this->db->trans_start();
		$this->db->where('UrutDtlID', $detailid);
		$this->db->update('tblOL_TrnUrutanDetail', $info);
		$this->db->trans_complete();
	}
	
	function update_detail_urut_history($detailid, $info){
		$this->db->trans_start();
		$this->db->where('UrutDtlID', $detailid);
		$this->db->update('tblOL_TrnUrutanDetailHistory', $info);
		$this->db->trans_complete();
	}
	
	function delete_detail($detailid){
		$berhasil = 0;
		
		$this->db->trans_start();
		$this->db->where('UrutDtlID', $detailid);
//		$this->db->where('IDPekerjaan', $idpekerjaan);
		$this->db->delete('tblOL_TrnUrutanDetail');
		$this->db->trans_complete();
		
		if ($this->db->trans_status() === TRUE){
			$berhasil = 1;
		}
		
		return $berhasil;
	}
	
	function delete_detail_history($detailid){
		$berhasil = 0;
		
		$this->db->trans_start();
		$this->db->where('UrutDtlID', $detailid);
//		$this->db->where('IDPekerjaan', $idpekerjaan);
		$this->db->delete('tblOL_TrnUrutanDetailHistory');
		$this->db->trans_complete();
		
		if ($this->db->trans_status() === TRUE){
			$berhasil = 1;
		}
		
		return $berhasil;
	}
	
	
	function get_tipeabsensi(){
		$this->db->where(array('TampilTablet' => 1));
		return $this->db->get('tblMstTipeAbsensi');
	}
	
	function get_listalltk(){
		$param = array(
			'IDDepartemen'	=> 17,
//			'IDPekerjaan'	=> 1,
			'TanggalKeluar'	=> null
		);
		return $this->db->get_where('vwMstTenagaKerja', $param);
	}
	
	function search_tk($idpekerjaan, $idshift, $idline, $idpemborong, $nama, $nik){		
		if(!empty($idpekerjaan) || $idpekerjaan !== ''){
			$this->db->where('IDPekerjaan', $idpekerjaan);
		} else {
			$this->db->where_in('IDPekerjaan', array(1, 2, 3));
		}
		
		if(!empty($idshift) || $idshift !== ''){
			$this->db->where('IDShift', $idshift);
		}
		
		if(!empty($idline) || $idline !== ''){
			$this->db->where('IDLine', $idline);
		}
		
//		if(!empty($idperusahaan) || $idperusahaan !== ''){
//			$this->db->where('IDPerusahaan', $idperusahaan);
//		}
		
		if(!empty($idpemborong) || $idpemborong !== ''){
			$this->db->where('IDPemborong', $idpemborong);
		}
		
		if(!empty($nama) || $nama !== ''){
			$this->db->like('Nama', $nama,'both');
		}
		
		if(!empty($nik) || $nik !== ''){
			$this->db->like('Nik', $nik, 'boths');
		}
		
		$this->db->where('TanggalKeluar', Null);
		
		return $this->db->get('vwOL_MstTenagaKerja');
	}

	function search_tk_sub($idpekerjaan, $idsubpekerjaan, $idshift, $idline, $idpemborong, $nama, $nik){		
		if(!empty($idpekerjaan) || $idpekerjaan !== ''){
			if (($idpekerjaan > 500) && ($idpekerjaan < 1000)){
				$this->db->where('IDSubPekerjaan', $idpekerjaan-500);
				// $this->db->where('IDPekerjaan', 1);
			} else if ($idpekerjaan == 1000){
			
			}
			else
				$this->db->where('IDPekerjaan', $idpekerjaan);
		}

		// if(!empty($idsubpekerjaan) || $idsubpekerjaan !== ''){
		// 	$this->db->where('IDSubPekerjaan', $idsubpekerjaan);
		// }
		
		if(!empty($idshift) || $idshift !== ''){
			$this->db->where('IDShift', $idshift);
		}
		
		if(!empty($idline) || $idline !== ''){
			$this->db->where('IDLine', $idline);
		}
		
//		if(!empty($idperusahaan) || $idperusahaan !== ''){
//			$this->db->where('IDPerusahaan', $idperusahaan);
//		}
		
		if(!empty($idpemborong) || $idpemborong !== ''){
			$this->db->where('IDPemborong', $idpemborong);
		}
		
		if(!empty($nama) || $nama !== ''){
			$this->db->like('Nama', $nama,'both');
		}
		
		if(!empty($nik) || $nik !== ''){
			$this->db->like('Nik', $nik, 'boths');
		}
		
		$this->db->where('TanggalKeluar', Null);
		
		return $this->db->get('vwOL_MstTenagaKerja');
	}
	
	function insert_rekap($info){
		$this->db->trans_start();
		$filter = array(
			'UrutHdrID' => $info['UrutHdrID']
			,'FixNo' => $info['FixNo']);
		$query = $this->db->get_where('tblOL_TrnUrutanDetail', $filter);
		$urutdtlid = 0;
		if ($query->num_rows() == 0){  
			$this->db->insert('tblOL_TrnUrutanDetail',$info);	
			$urutdtlid = $this->db->insert_id();
			$this->db->trans_complete();
		}
		return $urutdtlid;
	}
	
	function insert_rekap_history($info){
		$this->db->trans_start();
		$this->db->insert('tblOL_TrnUrutanDetailHistory',$info);	
		$urutdtlid = $this->db->insert_id();
		$this->db->trans_complete();
		
		return $urutdtlid;
	}
	
	function update_rekap($detailurutid, $info){
		$this->db->trans_start();
		$filter = array('UrutDtlID' => $detailurutid);
		$query = $this->db->get_where('tblOL_TrnUrutanDetail', $filter);
		$row = $query->row();
		if (isset($row)){
			if ($row->Absensi != 'M') {
				$this->db->where('UrutDtlID', $detailurutid);
				$this->db->update('tblOL_TrnUrutanDetail', $info);
				
				$this->db->where('UrutDtlID', $detailurutid);
				$this->db->update('tblOL_TrnUrutanDetailHistory', $info);
			}
		}
		$this->db->trans_complete();
	}
	
	function absencompleted($tanggal, $idline, $idshift, $idpekerjaan){
		$complete = false;
		$param = array(
			'Tanggal'	 => tgl_eng($tanggal),
			'IDLine'	 => $idline,
			'IDShift'	 => $idshift,
			'JenisKerja' => $idpekerjaan,
			'Complete'	 => 1
		);
		$query = $this->db->get_where('tblOL_TrnUrutanHeader', $param);
		
		if ($query->num_rows() > 0){
			$complete = true;			
		}
		
		return $complete;
	}
	
	function complete($uruthdrid){
		$this->db->where('UrutHdrID', $uruthdrid);
		$this->db->update('tblOL_TrnUrutanHeader', array('Complete' => 1));
	}
}
	