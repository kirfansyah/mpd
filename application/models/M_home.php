<?php

class m_home extends CI_Model{
	
	function log_history(){
		$userid = $this->session->userdata('userid');
		$groupid = $this->session->userdata('groupid');
		$sql = "select top 20 * from tblOL_LogUser where UserID = " . $this->db->escape($userid) . " " .
		        "order by datein desc";
		$query = $this->db->query($sql);
		return $query;
	}
}