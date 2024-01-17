<?php

class m_login extends CI_Model{
	
	function cek_user($uid){
		$query =  $this->db->get_where('vwOL_UtlUsers', array('UserID' => $uid));
		return $query;
	}
	
	function cek_username($uid){
		$query =  $this->db->get_where('vwOL_UtlUsers', array('Username' => $uid));
		return $query;
	}
	
	function cek_pass($uid,$pass){
		$this->db->where('Username',$uid);
		$this->db->where('Password',$pass);
		$query = $this->db->get('tblOL_UtlUsers');
		return $query;
	}
	
	function get_serverdate(){
		$query = $this->db->query('select case 
			when DATEPART(HOUR, GETDATE()) < 5 then dateadd(day,datediff(day,1,GETDATE()),0)
			when DATEPART(HOUR, GETDATE()) >= 5 then dateadd(day,datediff(day,0,GETDATE()),0)
			end as serverdate');
		if ($query->num_rows() > 0){
			$r = $query->row();
			$serverdate = $r->serverdate;
		}
		return tgl_ind($serverdate);
	}
	
	function simpan_log($info){
		$this->db->trans_start();
		$this->db->insert('tblOL_LogUser',$info);
		$signid = $this->db->insert_id();
		$this->db->trans_complete();
		return $signid;
	}
	
	function simpan_log_out($signid){
		$this->db->trans_start();		
		$this->db->query('Update tblOL_LogUser Set DateOut=GetDate() Where LogID='.$signid);
		$this->db->trans_complete();
	}
}