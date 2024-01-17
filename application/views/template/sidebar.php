
<a class="menu-toggler" id="menu-toggler" href="#">
	<span class="menu-text"></span>
</a>

<div class="sidebar" id="sidebar">
	<div class="sidebar-shortcuts" id="sidebar-shortcuts">
		<div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large">
			<button class="btn btn-small btn-success">
				<i class="icon-signal"></i>
			</button>

			<button class="btn btn-small btn-info">
				<i class="icon-pencil"></i>
			</button>

			<a href="<?php echo site_url('users/profile');?>" class="btn btn-small btn-warning" title="User's Profile">
				<i class="icon-user"></i>
			</a>
			
			<a href="<?php echo site_url('password');?>" class="btn btn-small btn-danger" title="Ubah Password">
				<i class="icon-key"></i>
			</a>
		</div>

		<div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini">
			<span class="btn btn-success"></span>

			<span class="btn btn-info"></span>

			<span class="btn btn-warning"></span>

			<span class="btn btn-danger"></span>
		</div>
	</div><!--#sidebar-shortcuts-->

	<ul class="nav nav-list">
		<li><a href="<?php echo site_url('home');?>"><i class="icon-home fa-lg"></i><span class="menu-text">HOME</span></a></li>
		<?php
            $groupid = $this->session->userdata('groupid');
			$this->db->order_by('MenuID');
			$main=$this->db->get_where('vwOL_UtlMenuAkses',array('MenuParent'=>0, 'GroupID'=>$groupid));
			foreach ($main->result() as $m)
			{
				// chek ada submenu atau tidak
				$sub=$this->db->get_where('vwOL_UtlMenuAkses',array('MenuParent'=>$m->MenuID, 'GroupID'=>$groupid));
				if($sub->num_rows() >0){
					
					// buat menu
					echo '<li>'.anchor(site_url($m->MenuLink),'<i class="'.$m->MenuIcon.'"></i>
						 <span class="menu-text">'.strtoupper($m->MenuName).'</span>
						 <b class="arrow icon-angle-down"></b>',array('class'=>'dropdown-toggle'));
					echo "<ul class='submenu'>";
					
					//buat sub menu
					foreach ($sub->result() as $s){						
						echo '<li>'.anchor(site_url($s->MenuLink),'<i class="'.$s->MenuIcon.'"></i>'.  strtoupper($s->MenuName)).'</li>';
					}
					echo "</ul>";
					echo '</li>';
				} else {
					// single menu
					echo '<li>'.anchor(site_url($m->MenuLink),'<i class="'.$m->MenuIcon.' fa-lg">
							</i>  <span class="menu-text">'.strtoupper($m->MenuName).'</span>').'</li>';
				}
			}
		?>     
		
	</ul><!--/.nav-list-->

	<div class="sidebar-collapse" id="sidebar-collapse">
		<i class="icon-double-angle-left"></i>
	</div>
</div>


		