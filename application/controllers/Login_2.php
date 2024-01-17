<?php // if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	
	function __construct(){
        parent::__construct();
//		$this->load->database();
        $this->load->model(array('m_login'));
        if($this->session->userdata('userid')){
			redirect('home');
        }
        ini_set('max_execution_time', 300);
    }
	
	public function index(){
		$this->load->view('login');
	}
	
	function check_result($uid,$pass){
		$cek_user = $this->m_login->cek_user($uid);		
		if ($cek_user->num_rows() > 0){
		//if (count($cek_user) > 0){
			$row = $cek_user->row();
			if ($row->NotActive === 1){
				$pesan = pesan("User Sudah Tidak Aktif Lagi.", pesan_peringatan());
				$this->session->set_flashdata('message',$pesan);
				return 1;
			}
			
//			$cek_pass = $this->m_login->cek_pass($uid,$pass);
			if ($pass === $row->Password){
				$serverdate = $this->m_login->get_serverdate();
				$this->session->set_userdata('userid',$uid);
				$this->session->set_userdata('username',$row->Username);
				$this->session->set_userdata('groupid',$row->GroupID);
				$this->session->set_userdata('groupname',$row->GroupName);
				$this->session->set_userdata('accessalldata', $row->AccessAllData);
				$this->session->set_userdata('serverdate', $serverdate);
				
				$this->simpan_log();
				return 100;
			}else{
				$pesan = pesan("Password Anda Salah.", pesan_error());
				$this->session->set_flashdata('message',$pesan);
				return 2;
			}
		}else{
			$pesan = pesan("User $uid Tidak Terdaftar.", pesan_error());
			$this->session->set_flashdata('message',$pesan);
			return 0;
		}
	}
	
	function do_login(){
		$uid = $this->input->post('txtUserID');
		$pass = $this->input->post('txtPassWd');
		
		if ($uid === '' && $pass === ''){
			$pesan = pesan("Masukkan user dan password!", pesan_peringatan());
			$this->session->set_flashdata('message',$pesan);
			redirect('login');
		}
		
		$checkres = $this->check_result($uid, $pass);
		switch ($checkres) {
			case 100 :
				redirect('home');
				break;

			default:				
				redirect('login');
				break;
		}
	}
	
	function simpan_log(){
		$this->load->library(array('User_agent','mobile_detect','misc'));
		
		$detect = new Mobile_Detect();
		
		$deviceType = ($detect->isMobile() ? ($detect->isTablet() ? '' : '') : 'PC');
		
		foreach($detect->getRules() as $name => $regex):
			$check = $detect->{'is'.$name}();
			if($check == 'true'){
				$deviceType .= $name.' ';
			}
		endforeach;
			
		if ($this->agent->is_browser()){
			$agent = $this->agent->browser().' '.$this->agent->version();
		}elseif ($this->agent->is_robot()){
			$agent = $this->agent->robot();
		}elseif ($this->agent->is_mobile()){
			$agent = $this->agent->mobile();
		}else{
			$agent = 'Unidentified User Agent';
		}
		
		$hostname	= gethostbyaddr($_SERVER['REMOTE_ADDR']);
		$ipaddr		= $_SERVER['HTTP_CLIENT_IP']?$_SERVER['HTTP_CLIENT_IP']:($_SERVER['HTTP_X_FORWARDE‌​D_FOR']?$_SERVER['HTTP_X_FORWARDED_FOR']:$_SERVER['REMOTE_ADDR']);
		
		$info = array (
			'UserID'	=> strtoupper($this->session->userdata('userid')),
			'DateIn'	=> date('Y-m-d H:i:s'),
			'Hostname'	=> str_replace('.in-addr.arpa', '', $hostname),
			'IPAddress'	=> $ipaddr,
			'Device'	=> $deviceType,
			'Browser'	=> $agent,
			'Platform'	=> $this->misc->platform(),
			'UserAgent'	=> $agent
//			'UserAgent' => $this->agent->agent_string(), //<-- Pake ini gak bisa nyimpen ke DB
		);
		
		$signid = $this->m_login->simpan_log($info);
		
		if ($signid === 0){
			$this->session->set_userdata('signid',0);
		}else{
			$this->session->set_userdata('signid',$signid);
		}
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */