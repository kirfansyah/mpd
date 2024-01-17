<?php
class Dashboard extends CI_Controller {
	function __construct(){
		 parent::__construct();
//		 $this->load->library(array('template'));
		 ini_set('max_execution_time', 300);
		 $this->load->model(array('m_login'));
		 if(!$this->session->userdata('userid')){
		 	
            redirect('login');
        }
	}
	
	public function index(){
		$data['title'] = "RSUP STANDARD - DASHBOARD";
		$data['userid'] = ucfirst($this->session->userdata('userid'));
		
		$this->template->display('dashboard/index',$data);
	}
	
	function do_logout(){
//		$this->session->unset_userdata('userid');
//		$this->session->unset_userdata('username');
//		$this->session->unset_userdata('groupid');
//		$this->session->unset_userdata('groupname');
		
		$signid = $this->session->userdata('signid');
		$this->m_login->simpan_log_out($signid);
		
		$this->unset_only();
		
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