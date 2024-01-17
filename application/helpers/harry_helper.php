<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//PESAN ALERT
function pesan_sukses(){
	return 'success';
}

function pesan_error(){
	return 'error';
}

function pesan_info(){
	return 'info';
}

function pesan_peringatan(){
	return 'warning';
}

function pesan($pesan, $tipe){
	switch ($tipe) {
	case 'success':
		$class	= 'alert alert-success';
		$icon	= 'icon-ok-sign bigger-130';
	break;

	case 'info':
		$class	= 'alert alert-info';
		$icon	= 'icon-info-sign bigger-130';
	break;

	case 'error':
		$class	= 'alert alert-error';
		$icon	= 'icon-exclamation-sign bigger-130';
	break;

	case 'warning':
		$class	= 'alert alert-danger';
		$icon	= 'icon-warning-sign bigger-130';
	break;

	default:
		$class	= 'alert alert-info';
		$icon	= 'icon-info-sign';
	break;
	}
	
	return '<div class="'.$class.'"><a class="close" data-dismiss="alert">×</a><i class="'.$icon.'">&nbsp;</i> '.$pesan.'</div>';
}

function valid_date($date, $format = 'd/m/Y')
{
   $d = DateTime::createFromFormat($format, $date);
   //Check for valid date in given format
   if($d && $d->format($format) == $date) {
		return true;
   } else {
//		$this->form_validation->set_message('valid_date', 
//               'The %s date is not valid it should match this ('.$format.') format');
        return false;
   }
}

//Source : http://tutsnare.com/add-active-class-to-menu-in-codeigniter/
//Add active class to menu in codeigniter

function activate_menu_parent($link) {
	// Getting CI class instance.
	$CI = get_instance();
	// Getting router class to active.
	$class = $CI->router->fetch_class();
	$controller = explode("/", $link);
	return (strtolower($class) == strtolower($controller[0])) ? 'active open' : '';
}

function activate_menu_child($link){
	$CI = get_instance();
	$class = $CI->router->fetch_class();
	$method = $CI->router->fetch_method();
	
	$link_arr = explode("/", $link);

	if(strtolower($class) == strtolower($link_arr[0])){
		return ($method == $link_arr[1]) ? 'active' : '';
	}		
}
