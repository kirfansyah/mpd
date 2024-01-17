<?php
class Utl_akses extends CI_Controller{
    
    function __construct() {
        parent::__construct();
		$this->load->model(array('m_menu'));	
		
		if(!$this->session->userdata('userid')){
			
            redirect('login');
        }
        ini_set('max_execution_time', 300);
    }
	
	function index(){
		$data['grouplist'] = $this->db->get('tblOL_UtlGroupUsers')->result();
		
		$this->template->display('utility/menuakses/akseslist',$data);
	}
	
	function get_listmenu(){
		if('IS_AJAX') {
        	$data['menulist'] = $this->m_menu->get_menu()->result();
			$this->load->view('utility/menuakses/listmenu',$data);
        }
	}
	
	function simpan(){
		$groupid = $this->input->post('txtUserGroup');
		$chkid = $this->input->post('chk');
		$jummenu = count($this->input->post('menu'));
		
		if (!empty($chkid)){			
			$this->m_menu->hapus_menuakses($groupid);
			for($i=0; $i < $jummenu; $i++)
			{
				if (isset($chkid[$i]))
				{
					$menuid = $chkid[$i];
					$menuhead = substr($menuid, 0,1).'00';
					$this->m_menu->simpan_menuakses($groupid,$menuhead);
					$this->m_menu->simpan_menuakses($groupid,$menuid);
				}
			}
		}
		
		$this->session->set_flashdata("message","<div class='alert alert-success'><a class='close' data-dismiss='alert'>×</a><i class='icon-info'>&nbsp;</i>Simpan Menu Akses Berhasil</div>");
		redirect('utl_akses');
	}
}