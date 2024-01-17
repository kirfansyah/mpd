
<div class="navbar navbar-fixed-top">
	<div class="navbar-inner">
		<div class="container-fluid">
			<a href="#" class="brand">
				<small>
					<i class="icon-h-palm-tree"></i> MP Department
				</small>
			</a><!--/.brand-->
			
			<ul class="nav ace-nav pull-right">
				
				<li class="light-blue">
					<a data-toggle="dropdown" href="#" class="dropdown-toggle">
						<img class="nav-user-photo" src="<?php echo base_url();?>assets/avatars/avatar2.png" alt="" />
						<span class="user-info">
							<small>Welcome,</small>
							<?php echo ucfirst($this->session->userdata('username'));?>
						</span>

						<i class="icon-caret-down"></i>
					</a>

					<ul class="user-menu pull-right dropdown-menu dropdown-yellow dropdown-caret dropdown-closer">
						<li>
							<a href="<?php echo site_url('users/profile');?>">
								<i class="icon-user"></i>
								Profile
							</a>
						</li>
						
						<li>
							<a href="<?php echo site_url('password');?>">
								<i class="icon-key"></i>
								Ubah Password
							</a>
						</li>

						<li class="divider"></li>

						<li>
							<a href="<?php echo site_url('home/do_logout');?>">
								<i class="icon-off"></i>
								Logout
							</a>
						</li>
					</ul>
				</li>				

			</ul>
		</div>
	</div>
</div>