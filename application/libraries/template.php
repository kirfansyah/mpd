<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Template{
    protected $_CI;
    function __construct(){
        $this->_CI=&get_instance();
    }
	
    function display($template,$data=null,$nosidebar=0){		        
		$data['_header']=$this->_CI->load->view('template/header',$data,true);
		$data['_content']=$this->_CI->load->view($template,$data,true);        
		$data['_navbar']=$this->_CI->load->view('template/navbar',$data,true);
		if ($nosidebar===0){
			$data['_sidebar']=$this->_CI->load->view('template/sidebar',$data,true);
		} else {
			$data['_sidebar']=null;
		}
		$data['nosidebar'] = $nosidebar;
//		$data['_footer']=$this->_CI->load->view('template/footer',$data,true);
        $this->_CI->load->view('/template.php',$data);
    }
	
	function display_monitor($jenismonitor, $monitor, $data=null){
		$data['_header']=$this->_CI->load->view('template/header',$data,true);
		$data['_monitor']=$this->_CI->load->view($monitor,$data,true);        
		
		switch ($jenismonitor) {
			case 'hasil':
				$data['_sheller']	=  $this->_CI->load->view('monitor/hasil/monhasil_sheller', $data, true);
				$data['_parer']		=  $this->_CI->load->view('monitor/hasil/monhasil_parer', $data, true);
				break;

			default:
				break;
		}
		
		$data['_navbar']=$this->_CI->load->view('template/navbar',$data,true);
        $data['_sidebar']=$this->_CI->load->view('template/sidebar',$data,true);
//		$data['_footer']=$this->_CI->load->view('template/footer',$data,true);
        $this->_CI->load->view('/monitor_'.$jenismonitor.'.php',$data);
	}
}

/* End of file template.php */
/* Location: ./system/application/libraries/template.php */