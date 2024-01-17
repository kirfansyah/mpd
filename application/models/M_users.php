<?php

class m_users extends CI_Model{
	
	function get_user($userid){
		return $this->db->get_where('tblOL_UtlUsers',array('UserID'=>strtoupper($userid)));
	}
	
	function simpan_user($info){
		$berhasil = 0;
		
		$this->db->trans_start();
		$this->db->insert('tblOL_UtlUsers',$info);
		$this->db->trans_complete();
		
		if ($this->db->trans_status() === TRUE){
			$berhasil = 1;
		}
		
		return $berhasil;
	}
	
	function update_user($userid, $info){
		$berhasil = 0;
		
		$this->db->trans_start();
		$this->db->where('UserID', strtoupper($userid));
		$this->db->update('tblOL_UtlUsers',$info);
		$this->db->trans_complete();
		
		if ($this->db->trans_status() === TRUE){
			$berhasil = 1;
		}
		
		return $berhasil;
	}
	
//	GROUP USER
	function simpan_group($info){
		$berhasil = 0;
		
		$this->db->trans_start();
		$this->db->insert('tblOL_UtlGroupUsers',$info);
		$this->db->trans_complete();
		
		if ($this->db->trans_status() === TRUE){
			$berhasil = 1;
		}
		
		return $berhasil;
	}
	
	function get_group($groupid){
		return $this->db->get_where('tblOL_UtlGroupUsers',array('GroupID'=>$groupid));
	}
	
	function update_group($groupid, $info){
		$berhasil = 0;
		
		$this->db->trans_start();
		$this->db->where('GroupID', strtoupper($groupid));
		$this->db->update('tblOL_UtlGroupUsers',$info);
		$this->db->trans_complete();
		
		if ($this->db->trans_status() === TRUE){
			$berhasil = 1;
		}
		
		return $berhasil;
	}
}