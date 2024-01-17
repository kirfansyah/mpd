<div class="breadcrumbs" id="breadcrumbs">
	<ul class="breadcrumb">
		<li>
			<i class="icon-home"></i>
			<a href="#">Home</a>

			<span class="divider">
				<i class="icon-angle-right"></i>
			</span>
		</li>
				
		<li class="active">
			<?php $userid = $this->session->userdata('userid'); echo ucfirst($userid);?>'s Profile
		</li>
	</ul><!--.breadcrumb-->
</div>
<!--<div class="main-content">-->
<div class="page-content">
	<div class="row-fluid">
		<div class="span12">
			<div class="clearfix">
				<div class="judul">User's Profile</div>
			</div>
			<div class="hr dotted"></div>
			<div>
				<div class="user-profile row-fluid">
					<div class="span3 center">
						<div>
							<span class="profile-picture">
								<img id="avatar" class="editable" alt="Alex's Avatar" src="<?php echo base_url();?>assets/avatars/profile-pic.jpg" />
							</span>

							<div class="space-4"></div>

							<div class="width-80 label label-info label-large arrowed-in arrowed-in-right">
								<div class="inline position-relative">
									<a href="#" class="user-title-label dropdown-toggle" data-toggle="dropdown">
										<i class="icon-circle light-green middle"></i>&nbsp;
										<span class="white middle bigger-120"><?php $username = $this->session->userdata('username'); echo ucfirst($username);?></span>
									</a>
								</div>
							</div><!--/.width-80-->
						</div>

						<div class="space-6"></div>

						<div class="profile-contact-info">
							<div class="profile-contact-links align-left">
								<a class="btn btn-link" href="#">
									<i class="icon-globe bigger-125 blue"></i> www.raimu.com
								</a>
							</div>

							<div class="space-6"></div>

							<div class="profile-social-links center">
								<a href="#" class="tooltip-info" title="" data-original-title="Visit my Facebook">
									<i class="middle icon-facebook-sign icon-2x blue"></i>
								</a>
								<a href="#" class="tooltip-info" title="" data-original-title="Visit my Twitter">
									<i class="middle icon-twitter-sign icon-2x light-blue"></i>
								</a>
							</div>
						</div><!--/.profile-contact-info-->

					</div>

					<div class="span9">						
						<div class="profile-user-info profile-user-info-striped">
							<div class="profile-info-row">
								<div class="profile-info-name"> Username </div>
								<div class="profile-info-value">
									<span class="editable" id="username"><?php echo $this->session->userdata('username');?></span>
								</div>
							</div><!--/.profile-info-row-->
						</div>
						
					</div>
				</div><!--/.user-profile-->
			</div>
		</div>
	</div>
</div>
<!--</div>-->

<script src="<?php echo base_url();?>assets/js/x-editable/bootstrap-editable.min.js"></script>
<script src="<?php echo base_url();?>assets/js/x-editable/ace-editable.min.js"></script>
<script type="text/javascript">
	$(function() {
		var url="<?php echo site_url("users/updaterofile");?>";
		$.fn.editable.defaults.mode = 'inline';		
		$.fn.editableform.loading = "<div class='editableform-loading'><i class='light-blue icon-2x icon-spinner icon-spin'></i></div>";
		$.fn.editableform.buttons = '<button type="submit" class="btn btn-info editable-submit"><i class="icon-ok icon-white"></i></button>'+
									'<button type="button" class="btn editable-cancel"><i class="icon-remove"></i></button>';    

		//editables 
		$('#username').editable({
			type	: 'text',
			name	: 'username',
			url		: url+'/username/'+$(this).val()
		});
	});
</script>