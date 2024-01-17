<?php

class m_menu extends CI_Model{
	
	function list_menu(){
		$this->db->order_by('MenuID');
		return $this->db->get_where('tblOL_UtlMenu',array('NotActive'=>0));
	}
	
	function list_menu_parent(){
		$this->db->order_by('MenuID');
		return $this->db->get_where('tblOL_UtlMenu',array('NotActive'=>0, 'MenuParent'=>0));
	}
	
	function simpan($info){
		$berhasil = 0;
		
		$this->db->trans_start();
		$this->db->insert('tblOL_UtlMenu',$info);
		$this->db->trans_complete();
		
		if ($this->db->trans_status() === TRUE){
			$berhasil = 1;
		}
		
		return $berhasil;
	}
	
	function cek_menuid($menuid){
		$query = $this->db->get_where('tblOL_UtlMenu', array('MenuID' => $menuid));
		if ($query->num_rows() === 0){
			return 0;
		} else {
			return 1;
		}
	}
	
	function get_menu(){
		$grupid = $this->input->post('grupid');
		
		$q = $this->subquery->start_union();
		$q->select('MenuID,MenuName,MenuParent,MenuParentName,MenuIcon,1 as Pilih')->from('vwOL_UtlMenuAkses')->where('GroupID',$grupid);
		
		$q1 = $this->subquery->start_union();
		$q1->select('MenuID,MenuName,MenuParent,MenuParentName,MenuIcon, 0 as Pilih')->from('vwOL_UtlMenu');
			$q11=$this->subquery->start_subquery('where_in');
			$q11->select('MenuID')->from('vwOL_UtlMenuAkses')->where('GroupID',$grupid);		
			$this->subquery->end_subquery('MenuID',false);
			
		$this->subquery->end_union();
		$this->db->order_by('MenuID');
		
		$result = $this->db->get();
		return $result;
	}
	
	function get_menu_single($menuid){
		return $this->db->get_where('tblOL_UtlMenu',array('MenuID'=>strtoupper($menuid)));
	}
	
	function hapus_menuakses($grupid){
		$this->db->delete('tblOL_UtlMenuAkses',array('GroupID'=>$grupid));
	}
	
	function simpan_menuakses($grupid,$menuid){		
		$info = array(
			'GroupID'	=> $grupid,
			'MenuID'	=> $menuid
		);
		
		$berhasil = 0;
		
		$this->db->trans_start();
		$cek = $this->db->get_where('tblOL_UtlMenuAkses',$info);
		
		if ($cek->num_rows() == 0){		
			$this->db->insert('tblOL_UtlMenuAkses',$info);
		}
		$this->db->trans_complete();
		
		if ($this->db->trans_status() === TRUE){
			$berhasil = 1;
		}
		
		return $berhasil;
	}
	
	function update_menu($menuid, $info){
		$berhasil = 0;
		
		$this->db->trans_start();
		$this->db->where('MenuID', strtoupper($menuid));
		$this->db->update('tblOL_UtlMenu',$info);
		$this->db->trans_complete();
		
		if ($this->db->trans_status() === TRUE){
			$berhasil = 1;
		}
		
		return $berhasil;
	}
	
	function deactive_menu($menuid, $info){
		$berhasil = 0;
		
		$this->db->trans_start();
		$this->db->where('MenuID', strtoupper($menuid));
		$this->db->update('tblOL_UtlMenu',$info);
		$this->db->trans_complete();
		
		if ($this->db->trans_status() === TRUE){
			$berhasil = 1;
		}
		
		return $berhasil;
	}
	
	function delete_menu($menuid){
		$berhasil = 0;
		
		$this->db->trans_start();
		$this->db->delete('tblOL_UtlMenu', array('MenuID'=>$menuid));
		$this->db->trans_complete();
		
		if ($this->db->trans_status() === TRUE){
			$berhasil = 1;
		}
		
		return $berhasil;
	}
}