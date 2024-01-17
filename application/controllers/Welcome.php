<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

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
        $this->load->model(array('m_login'));
        if($this->session->userdata('userid')){
        	
            redirect('home');
        }
        ini_set('max_execution_time', 300);
    }
	
	public function index()
	{
		$this->load->view('login');
	}
	
	function check_result($uid,$pass){
		$cek_user = $this->m_login->cek_user($uid);		
		if ($cek_user->num_rows() > 0){
			$row = $cek_user->row();
			if ($row->NotActive === 1){
				$this->session->set_flashdata('message',"User Sudah Tidak Aktif Lagi.");
				return 1;
			}
			
			$cek_pass = $this->m_login->cek_pass($uid,$pass);
			if ($cek_pass === true){
				$this->session->set_userdata('userid',$uid);
				$this->session->set_userdata('username',$row->Username);
				return 100;
			}else{
				$this->session->set_flashdata('message',"Password Anda Salah.");
				return 2;
			}
		}else{
			$this->session->set_flashdata('message',"User $uid Tidak Terdaftar.");
			return 0;
		}
	}
	
	function login(){
		$uid = $this->input->post('txtUserID');
		$pass = $this->input->post('txtPassWd');
		
		$checkres = $this->check_result($uid, $pass);
		switch ($checkres) {
//			case 0:
//				redirect('welcome');
//				break;
//			case 1:
//				redirect('welcome');
//				break;
//			case 2:
//				redirect('welcome');
//				break;
			case 100 :
				redirect('dashboard');
				break;

			default:				
				redirect('welcome');
				break;
		}
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */