<?php

class Password extends CI_Controller{
	function __construct() {
        parent::__construct();
//		$this->load->model(array('m_users'));	
		
		if(!$this->session->userdata('userid')){
			
            redirect('login');
        }
        ini_set('max_execution_time', 300);
    }
	
	function index(){
		$uid = $this->session->userdata('userid');
		$data['datauser'] = $this->db->get_where('tblOL_UtlUsers',array('UserID'=>$uid))->result();		
		$data['message'] = $this->session->flashdata('message');
		
		$this->template->display('utility/password/ubahpassword',$data);
	}
	
	function update(){
		$uid = $this->input->post('txtUserID');
		$passlama = $this->input->post('txtPassLama');
		$passbaru = $this->input->post('txtPassBaru');
		
		if ($this->cek_pass_lama($uid, $passlama) === 0){
			$pesan = pesan('Password lama anda tidak sesuai','warning');
			$this->session->set_flashdata('message',$pesan);
			redirect('password');
		}
		
		$this->db->trans_start();
		$this->db->where('UserID', strtoupper($uid));
		$this->db->update('tblOL_UtlUsers',array('Password'=>$passbaru));
		$this->db->trans_complete();
		
		$pesan = pesan('Password lama anda berhasil diubah','success');
		$this->session->set_flashdata('message',$pesan);
		redirect('password');
	}
	
	function cek_pass_lama($uid, $passlama){
		$query = $this->db->get_where('tblOL_UtlUsers',array('UserID'=>$uid, 'Password'=>$passlama));
		return $query->num_rows();		
	}
}