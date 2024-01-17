<?php
class Home extends CI_Controller {
	function __construct(){
		 parent::__construct();
		 //$this->load->database();
//		 $this->load->library(array('template'));
		 $this->load->model(array('m_home', 'm_login', 'm_trnhasil'));
		 if(!$this->session->userdata('userid')){
		 	
            redirect('login');
        }
        ini_set('max_execution_time', 300);
	}
	
	public function index(){
		$data['title'] = "RSUP STANDARD";
		$data['userid'] = ucfirst($this->session->userdata('userid'));
		$data['log_history'] = $this->m_home->log_history()->result();
		
		$this->template->display('dashboard/index',$data);
	}
	
	function do_logout(){		
		$signid = $this->session->userdata('signid');
		$this->m_login->simpan_log_out($signid);
		
		$this->unset_only();
		
//		$this->session->unset_userdata('userid');
//		$this->session->unset_userdata('username');
//		$this->session->unset_userdata('groupid');
//		$this->session->unset_userdata('groupname');
//		
//		$this->session->unset_userdata('krj_idline');
//		$this->session->unset_userdata('krj_shift');
//		$this->session->unset_userdata('krj_headerid');
//		
//		$this->session->unset_userdata('wm_idline');
//		$this->session->unset_userdata('wm_shift');
//		$this->session->unset_userdata('wm_headerid');
//		
//		$this->session->unset_userdata('ak_idline');
//		$this->session->unset_userdata('ak_shift');
//		$this->session->unset_userdata('ak_headerid');
		$this->m_trnhasil->insert_selesai('whitemeat');
		$this->m_trnhasil->insert_selesai('airkelapa');
		$this->m_trnhasil->insert_selesai('kelapacungkil');
		redirect('login');
	}
	
	function unset_only() {
		$user_data = $this->session->all_userdata();

		foreach ($user_data as $key => $value) {
			if ($key != 'session_id' && $key != 'ip_address' && $key != 'user_agent' && $key != 'last_activity') {
				$this->session->unset_userdata($key);
			}
		}
	}
}