<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users extends CI_Controller{
	function __construct() {
        parent::__construct();
		$this->load->model(array('m_users'));	
		
		if(!$this->session->userdata('userid')){
			
            redirect('login');
        }
        ini_set('max_execution_time', 300);
    }
	
	function index(){
		redirect('users/manage');
//		$data['record']=  $this->db->get('vwOL_UtlUsers')->result();
//		$data['title'] = "User's Management";
//		$data['message'] = $this->session->flashdata('savemsg');
//		
//		$this->template->display('user/manage/userlist',$data);
	}
	
	function manage(){
		$data['record']=  $this->db->get('vwOL_UtlUsers')->result();		
		$data['title'] = "User's Management";
		
		if ($this->uri->segment(3) == 'delete_success'){
			$data['message'] = '<div class="alert alert-success"><a class="close" data-dismiss="alert">×</a><i class="icon-info-sign">&nbsp;</i> Hapus Data Berhasil</div>';
		} elseif ($this->uri->segment(3) == 'delete_failed'){
			$data['message'] = '<div class="alert alert-danger"><a class="close" data-dismiss="alert">×</a><i class="icon-warning-sign">&nbsp;</i> Hapus Data Gagal</div>';
		} elseif ($this->uri->segment(3) == 'reset_success'){
			$data['message'] = '<div class="alert alert-danger"><a class="close" data-dismiss="alert">×</a><i class="icon-warning-sign">&nbsp;</i> Reset Ulang Password Berhasil</div>';
		} elseif ($this->uri->segment(3) == 'reset_failed'){
			$data['message'] = '<div class="alert alert-danger"><a class="close" data-dismiss="alert">×</a><i class="icon-warning-sign">&nbsp;</i> Reset Ulang Password Gagal</div>';
		} else {
			$data['message'] = $this->session->flashdata('savemsg');
		}
		
		$this->template->display('user/manage/userlist',$data);
	}
	
	function adduser(){
		$data['grouplist'] = $this->db->get('tblOL_UtlGroupUsers')->result();
		
		$this->load->view('user/manage/useradd',$data);
	}
	
	function saveuser(){
		$info = array(
			'UserID'		=> strtoupper($this->input->post('txtUserID')),
			'Username'		=> strtoupper($this->input->post('txtUserName')),
			'Password'		=> strtoupper($this->input->post('txtUserID')),
			'GroupID'		=> $this->input->post('txtUserGroup'),
			'CreatedBy'		=> strtoupper($this->session->userdata('userid')),
			'CreatedDate'	=> date('Y-m-d H:i:s')
		);
		
		if($this->m_users->simpan_user($info) === 1){
			$pesan = pesan('Simpan user berhasil', 'success');
		}else{
			$err = mssql_get_last_message();
			$pesan = pesan('Simpan data gagal.<br>Pesan : '. $err,'error');			
		}
		
		$this->session->set_flashdata('savemsg',$pesan);
		redirect('users/manage');
	}
	
	function edituser($userid){		
		$data['grouplist'] = $this->db->get('tblOL_UtlGroupUsers')->result();
		$data['datauser'] = $this->m_users->get_user($userid)->result();
		
		$this->template->display('user/manage/useredit',$data);
	}
	
	function updateuser(){
		$info = array(
			'UserID'		=> strtoupper($this->input->post('txtUserID')),
			'Username'		=> strtoupper($this->input->post('txtUserName')),
			'GroupID'		=> $this->input->post('txtUserGroup'),
			'UpdatedBy'		=> strtoupper($this->session->userdata('userid')),
			'UpdatedDate'	=> date('Y-m-d H:i:s')
		);
		$userid = strtoupper($this->input->post('txtUserID'));
		
		if($this->m_users->update_user($userid, $info) === 1){
			$pesan = pesan('Update data user berhasil.', 'success');
		}else{
			$err = mssql_get_last_message();
			$pesan = pesan('Update data user gagal.<br>Pesan : '.$err, 'error');
		}
				
		$this->session->set_flashdata('savemsg',$pesan);
		redirect('users/manage');
	}
	
	function deleteuser(){
		$uid = $this->input->post('uid');
		$this->db->delete('tblOL_UtlUsers',array('UserID'=>$uid));		
	}
	
	function resetuser(){
		$uid = $this->input->post('uid');
		$data = array('Password' => $uid);
		$this->db->update('tblOL_UtlUsers', $data , array('UserID' => $uid));
	}
	
	//User Group
	function group(){
		$data['record']=  $this->db->get('tblOL_UtlGroupUsers')->result();
		$data['title'] = "User's Group Management";
		
		if ($this->uri->segment(3) == 'delete_success'){
			$pesan = pesan('Hapus data berhasil.', 'success');
		} elseif ($this->uri->segment(3) == 'delete_failed'){
			$pesan = pesan('Hapus data gagal.', 'error');
		} else {
			$pesan = $this->session->flashdata('savemsg');
		}
		
		$data['message'] = $pesan;
		$this->template->display('user/group/grouplist',$data);
	}
	
	function addgroup(){
		$this->load->view('user/group/groupadd');
	}
	
	function savegroup(){
		$info = array(
			'GroupName'		=> strtoupper($this->input->post('txtGroupName')),
			'GroupRemark'	=> strtoupper($this->input->post('txtGroupRemark')),			
			'CreatedBy'		=> strtoupper($this->session->userdata('userid')),
			'CreatedDate'	=> date('Y-m-d H:i:s')
		);
		
		if($this->m_users->simpan_group($info) === 1){
			$pesan = pesan('Simpan grup user berhasil.', 'success');
		}else{
			$err = mssql_get_last_message();
			$pesan = pesan('Simpan grup user gagal.<br>Pesan : '.$err, 'success');
		}
		
		$this->session->set_flashdata('savemsg',$pesan);
		redirect('users/group');
	}
	
	function editgroup($groupid){		
		$data['datagroup'] = $this->m_users->get_group($groupid)->result();
		
		$this->template->display('user/group/groupedit',$data);
	}
	
	function updategroup(){
		$info = array(
			'GroupName'		=> strtoupper($this->input->post('txtGroupName')),
			'GroupRemark'	=> strtoupper($this->input->post('txtGroupRemark')),
			'UpdatedBy'		=> strtoupper($this->session->userdata('userid')),
			'UpdatedDate'	=> date('Y-m-d H:i:s')
		);
		$groupid = strtoupper($this->input->post('txtGroupID'));
		$groupname = strtoupper($this->input->post('txtGroupName'));
		
		if($this->m_users->update_group($groupid, $info) === 1){
			$pesan = pesan('Update grup '.$groupname.' berhasil.', 'success');
		}else{
			$err = mssql_get_last_message();
			$pesan = pesan('Update grup '.$groupname.' gagal.<br>Pesan : '.$err, 'error');
		}
			
		$this->session->set_flashdata('savemsg',$pesan);
		redirect('users/group');
	}
	
	function deletegroup(){
		$grupid = $this->input->post('grupid');
		$this->db->delete('tblOL_UtlGroupUsers',array('GroupID'=>$grupid));
	}
	
	
//	USER'S PROFILE
	function profile(){
		$this->template->display('user/profile/index');
	}
	
	function updateprofile($field, $value){
		$uid = $this->session->userdata('userid');
//		$isi = $this->post->input('datapost');
			
		switch ($field) {
			case 'username':
				$info = array('Username'=>$value);
				break;

			default:
				break;
		}
		
		$this->db->trans_start();
		$this->db->where('UserID', strtoupper($uid));
		$this->db->update('tblOL_UtlUsers',$info);
		$this->db->trans_complete();
	}
}