<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* 
*/
class Daftar extends CI_Controller
{
	
	function __construct(){
		parent::__construct();
		ini_set('max_execution_time', 300);
		$this->load->model(array('m_master', 'm_daftar'));
		if(!$this->session->userdata('userid')){
			redirect('login');
    }
    
	}

	function sheller($action = '', $noUrut = '', $tipe_submit = '', $idurut = ''){
		$prefix = 'shl';
		if (!$this->session->userdata($prefix.'_daftar')){
			$sess_data[$prefix.'_daftar'] = '1';
			$this->session->set_userdata($sess_data);
		}
		switch ($action) {
			case 'search':
				$data['pekerjaan']		= 'sheller';
				$data['cbopekerjaan'] 	= $this->m_master->mst_pekerjaan_mpd()->result();
				$data['cbosubpekerjaan'] = $this->m_master->mst_sub_pekerjaan_mpd()->result();
				$data['cboshift']		= $this->m_master->mst_shift()->result();
				$data['cboline']		= $this->m_master->mst_line()->result();
				$data['cbopemborong'] 	= $this->m_master->mst_pemborong()->result();
				$data['nourut']		= $noUrut;

				$idpekerjaan			= $this->input->post('txtPekerjaan');
				$idshift				= $this->input->post('txtShift');
				$idline					= $this->input->post('txtLine');
				$idpemborong			= $this->input->post('txtPemborong');
				$nama					= $this->input->post('txtNama');				
				$nik					= $this->input->post('txtNIK');

				if ($this->input->server('REQUEST_METHOD') == 'POST'){
					if (empty($idpekerjaan)){
						$idpekerjaan = 2;
					}
					$data['search_result'] = $this->m_daftar->search_tk_sub($idpekerjaan, $idshift, $idline, $idpemborong, $nama, $nik)->result();
					$data['selectpekerjaan'] 	= $idpekerjaan;
					$data['idshift'] 			= $idshift;
					$data['idline']				= $idline;
					$data['idpemborong'] 		= $idpemborong;
					$data['searchnama'] 		= $nama;
					$data['searchnik'] 			= $nik;
					$data['tipe_submit']    = $tipe_submit;
					$data['idurut']					= $idurut;
				} else {
					$data['selectpekerjaan'] 	= 2;
 					$data['idshift'] 			= $idshift;
					$data['idline']				= $idline;
					$data['idpemborong'] 		= $idpemborong;
					$data['searchnama'] 		= $nama;
					$data['searchnik'] 			= $nik;
					$data['tipe_submit']    = $tipe_submit;
					$data['idurut']					= $idurut;
				}

				$data['page_asal'] = 'sheller';
				$this->template->display('daftar/sheller/search', $data, 1);

				break;
			case 'ganti_isi':
				$pilih = explode('#', $this->input->post('radioPilih'));
				$fixno = $pilih[0];
				if ((!empty($fixno)) || ($fixno == '')){
					$gettransid = $this->m_daftar->get_trans_id($fixno);
					//print_r($gettransid.'-'.$idurut);
					if ($gettransid != 0){
							$this->m_daftar->delete_nourut($gettransid);
					}
					$this->m_daftar->delete_nourut($idurut);
					$info_nourut = array(
						'FixNo' => $fixno
						, 'IDLine' => $this->session->userdata($prefix.'_idline')
						, 'IDShift' => $this->session->userdata($prefix.'_shift')
						, 'IDDept' => 17
						, 'IDPekerjaan' => 2
						
						, 'NoUrut' => $noUrut
						, 'SudahKeluar' => 0
						, 'CreatedBy' =>  strtoupper($this->session->userdata('username'))
						, 'CreatedDate' => date('Y-m-d H:i:s')
						, 'LastUpdatedDate' => date('Y-m-d H:i:s')
						, 'Computer' => 'TAB-MPD'
						, 'ComputerDate' => date('Y-m-d H:i:s')
					);
					print_r($info_nourut);
					$lastid = $this->m_daftar->insert_nourut($info_nourut);	
				}
				redirect('absensi/sheller/set');
				break;

			case 'ganti_kosong':
				$pilih = explode('#', $this->input->post('radioPilih'));
				$fixno = $pilih[0];
				if ((!empty($fixno)) || ($fixno == '')){
					$gettransid = $this->m_daftar->get_trans_id($fixno);
					print_r($gettransid.'-'.$idurut);
					if ($gettransid != 0){
							$this->m_daftar->delete_nourut($gettransid);
					}
					$info_nourut = array(
						'FixNo' => $fixno
						, 'IDLine' => $this->session->userdata($prefix.'_idline')
						, 'IDShift' => $this->session->userdata($prefix.'_shift')
						, 'IDDept' => 17
						, 'IDPekerjaan' => 2
						
						, 'NoUrut' => $noUrut
						, 'SudahKeluar' => 0
						, 'CreatedBy' =>  strtoupper($this->session->userdata('username'))
						, 'CreatedDate' => date('Y-m-d H:i:s')
						, 'LastUpdatedDate' => date('Y-m-d H:i:s')
						, 'Computer' => 'TAB-MPD'
						, 'ComputerDate' => date('Y-m-d H:i:s')
					);
					print_r($info_nourut);
					$lastid = $this->m_daftar->insert_nourut($info_nourut);
				}
				redirect('absensi/sheller/set');
				break;

				case 'delete_nourut':
						$urutid_del = $this->input->post('transid');
						$this->m_daftar->delete_nourut($urutid_del);
				break;

				case 'end':
					$this->session->unset_userdata($prefix.'_daftar');
					redirect('absensi/sheller/set');
					break;
			default:
				break;
		}
		
	}

	function parer($action = '', $noUrut = '', $tipe_submit = '', $idurut = ''){
		$prefix = 'par';
		if (!$this->session->userdata($prefix.'_daftar')){
			$sess_data[$prefix.'_daftar'] = '1';
			$this->session->set_userdata($sess_data);
		}
		switch ($action) {
			case 'search':
				$data['pekerjaan']		= 'parer';
				$data['cbopekerjaan'] 	= $this->m_master->mst_pekerjaan_mpd()->result();
				$data['cbosubpekerjaan'] = $this->m_master->mst_sub_pekerjaan_mpd()->result();
				$data['cboshift']		= $this->m_master->mst_shift()->result();
				$data['cboline']		= $this->m_master->mst_line()->result();
				$data['cbopemborong'] 	= $this->m_master->mst_pemborong()->result();
				$data['nourut']		= $noUrut;

				$idpekerjaan			= $this->input->post('txtPekerjaan');
				$idshift				= $this->input->post('txtShift');
				$idline					= $this->input->post('txtLine');
				$idpemborong			= $this->input->post('txtPemborong');
				$nama					= $this->input->post('txtNama');				
				$nik					= $this->input->post('txtNIK');

				if ($this->input->server('REQUEST_METHOD') == 'POST'){
					if (empty($idpekerjaan)){
						$idpekerjaan = 3;
					}
					$data['search_result'] = $this->m_daftar->search_tk_sub($idpekerjaan, $idshift, $idline, $idpemborong, $nama, $nik)->result();
					$data['selectpekerjaan'] 	= $idpekerjaan;
					$data['idshift'] 			= $idshift;
					$data['idline']				= $idline;
					$data['idpemborong'] 		= $idpemborong;
					$data['searchnama'] 		= $nama;
					$data['searchnik'] 			= $nik;
					$data['tipe_submit']    = $tipe_submit;
					$data['idurut']					= $idurut;
				} else {
					$data['selectpekerjaan'] 	= 3;
 					$data['idshift'] 			= $idshift;
					$data['idline']				= $idline;
					$data['idpemborong'] 		= $idpemborong;
					$data['searchnama'] 		= $nama;
					$data['searchnik'] 			= $nik;
					$data['tipe_submit']    = $tipe_submit;
					$data['idurut']					= $idurut;
				}

				$data['page_asal'] = 'parer';
				$this->template->display('daftar/parer/search', $data, 1);

				break;
			case 'ganti_isi':
				$pilih = explode('#', $this->input->post('radioPilih'));
				$fixno = $pilih[0];
				if ((!empty($fixno)) || ($fixno == '')){
					$gettransid = $this->m_daftar->get_trans_id($fixno);
					//print_r($gettransid.'-'.$idurut);
					if ($gettransid != 0){
							$this->m_daftar->delete_nourut($gettransid);
					}
					$this->m_daftar->delete_nourut($idurut);
					$info_nourut = array(
						'FixNo' => $fixno
						, 'IDLine' => $this->session->userdata($prefix.'_idline')
						, 'IDShift' => $this->session->userdata($prefix.'_shift')
						, 'IDDept' => 17
						, 'IDPekerjaan' => 3
						
						, 'NoUrut' => $noUrut
						, 'SudahKeluar' => 0
						, 'CreatedBy' =>  strtoupper($this->session->userdata('username'))
						, 'CreatedDate' => date('Y-m-d H:i:s')
						, 'LastUpdatedDate' => date('Y-m-d H:i:s')
						, 'Computer' => 'TAB-MPD'
						, 'ComputerDate' => date('Y-m-d H:i:s')
					);
					print_r($info_nourut);
					$lastid = $this->m_daftar->insert_nourut($info_nourut);	
				}
				redirect('absensi/parer/set');
				break;

			case 'ganti_kosong':
				$pilih = explode('#', $this->input->post('radioPilih'));
				$fixno = $pilih[0];
				if ((!empty($fixno)) || ($fixno == '')){
					$gettransid = $this->m_daftar->get_trans_id($fixno);
					print_r($gettransid.'-'.$idurut);
					if ($gettransid != 0){
							$this->m_daftar->delete_nourut($gettransid);
					}
					$info_nourut = array(
						'FixNo' => $fixno
						, 'IDLine' => $this->session->userdata($prefix.'_idline')
						, 'IDShift' => $this->session->userdata($prefix.'_shift')
						, 'IDDept' => 17
						, 'IDPekerjaan' => 3
						
						, 'NoUrut' => $noUrut
						, 'SudahKeluar' => 0
						, 'CreatedBy' =>  strtoupper($this->session->userdata('username'))
						, 'CreatedDate' => date('Y-m-d H:i:s')
						, 'LastUpdatedDate' => date('Y-m-d H:i:s')
						, 'Computer' => 'TAB-MPD'
						, 'ComputerDate' => date('Y-m-d H:i:s')
					);
					print_r($info_nourut);
					$lastid = $this->m_daftar->insert_nourut($info_nourut);
				}
				redirect('absensi/parer/set');
				break;

				case 'delete_nourut':
						$urutid_del = $this->input->post('transid');
						$this->m_daftar->delete_nourut($urutid_del);
				break;

				case 'end':
					$this->session->unset_userdata($prefix.'_daftar');
					redirect('absensi/parer/set');
					break;
			default:
				break;
		}
		
	}
}
