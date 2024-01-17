<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title>PT. Pulau Sambu-MPD</title>

		<meta name="description" content="User Login Page" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<link rel='shortcut icon' type='image icon' href="<?php echo base_url(); ?>assets/images/logo_PSG.gif"/>
		
		<noscript>
			<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/noscript.css">
			<style>div { display:none; }</style>
		</noscript>

		<!--basic styles-->

		<link href="<?php echo base_url();?>assets/css/bootstrap.min.css" rel="stylesheet" />
		<link href="<?php echo base_url();?>assets/css/bootstrap-responsive.min.css" rel="stylesheet" />
		<link href="<?php echo base_url();?>assets/css/font-awesome.min.css" rel="stylesheet" />
		<link href="<?php echo base_url();?>assets/css/font-harry.css" rel="stylesheet" />

		<!--[if IE 7]>
		  <link rel="stylesheet" href="<?php echo base_url();?>assets/css/font-awesome-ie7.min.css" />
		<![endif]-->

		<!--page specific plugin styles-->

		<!--fonts-->
		<link href="<?php echo base_url();?>assets/font/opensans/opensans.css" rel="stylesheet">
		<!--<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400,300" />-->

		<!--ace styles-->

		<link rel="stylesheet" href="<?php echo base_url();?>assets/css/ace.min.css" />
		<link rel="stylesheet" href="<?php echo base_url();?>assets/css/ace-responsive.min.css" />
		<link rel="stylesheet" href="<?php echo base_url();?>assets/css/ace-skins.min.css" />
		<link rel="stylesheet" href="<?php echo base_url();?>assets/css/custom.css" />

		<!--[if lte IE 8]>
		  <link rel="stylesheet" href="<?php echo base_url();?>assets/css/ace-ie.min.css" />
		<![endif]-->

		<!--inline styles related to this page-->
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head>

	<body class="login-layout">
		<div class="main-container container-fluid">
			<div class="main-content">
				<div class="row-fluid">
					<div class="span12">
						<div class="login-container">
							<div class="row-fluid">
								<div class="center">
									<h1>
										<!--<i class="icon-tablet green"></i>-->
										<i class="icon-h-palm-tree green"></i>
										<span class="red">MP</span>
										<span class="white">Department</span>
									</h1>
									<h4 class="blue">&copy; PT. Pulau Sambu</h4>
								</div>
							</div>

							<div class="space-6"></div>

							<div class="row-fluid">
								<div class="position-relative">
									<div id="login-box" class="login-box visible widget-box no-border">
										<div class="widget-body">
											<div class="widget-main">
												<h4 class="header blue lighter bigger">
													<i class="icon-h-content-34 green"></i>
													Silakan Login
												</h4>

												<div class="space-6"></div>
												
												<form action="<?php echo site_url('login/do_login');?>" method="post">
													<fieldset>
														<label>
															<span class="block input-icon input-icon-left">																
																<i class="icon-user"></i>
																<input name="txtUserID" type="text" class="span12" placeholder="Username" />																
															</span>
														</label>

														<label>
															<span class="block input-icon input-icon-left">
																<i class="icon-lock"></i>
																<input name="txtPassWd" type="password" class="span12" placeholder="Password" />																
															</span>
														</label>

														<div class="space"></div>

														<div class="clearfix">
															<button class="width-100 btn btn-small btn-primary" type="submit" id="btnLogin">
																<i class="icon-key"></i>
																Login
															</button>
														</div>

														<div class="space-4"></div>
													</fieldset>
												</form>

												<div class="social-or-login center">
													<h3 class="bigger"><i class="icon-lock"></i></h3>													
												</div>
												
												<?php
													if ($this->session->flashdata('message')) :
														echo $this->session->flashdata( 'message' );
													endif;
												?>
												
												<div>
													<p class="text-info text-center smaller-80">
														Page rendered in <strong>{elapsed_time}</strong> seconds
													</p>
												</div>

<!--												<div class="social-login center">
													<a class="btn btn-primary">
														<i class="icon-facebook"></i>
													</a>

													<a class="btn btn-info">
														<i class="icon-twitter"></i>
													</a>

													<a class="btn btn-danger">
														<i class="icon-google-plus"></i>
													</a>
												</div>-->
											</div><!--/widget-main-->

											<div class="toolbar clearfix">
												<div>
													<a href="#" onclick="show_box('about-box'); return false;" class="forgot-password-link">
														<i class="icon-arrow-left"></i>
														About
													</a>
												</div>

												<div>
													<a href="#" onclick="show_box('programmer-box'); return false;" class="user-signup-link">
														Programmer
														<i class="icon-arrow-right"></i>
													</a>
												</div>
											</div>
										</div><!--/widget-body-->
									</div><!--/login-box-->

									<div id="about-box" class="about-box widget-box no-border">
										<div class="widget-body">
											<div class="widget-main">
												<h4 class="header red lighter bigger">
													<i class="icon-info-sign"></i>
													Tentang Program MPD
												</h4>

												<div class="space-6"></div>
												<p>Program tablet MPD adalah program untuk mencatat data hasil kerja karyawan secara realtime.</p>
												<p>Program ini terintegrasi dengan Payroll sehingga data hasil transaksi dapat langsung diproses untuk mendapatkan upah tenaga kerja.</p>

											</div><!--/widget-main-->

											<div class="toolbar center">
												<a href="#" onclick="show_box('login-box'); return false;" class="back-to-login-link">
													Back to login
													<i class="icon-arrow-right"></i>
												</a>
											</div>
										</div><!--/widget-body-->
									</div><!--/forgot-box-->

									<div id="programmer-box" class="programmer-box widget-box no-border">
										<div class="widget-body">
											<div class="widget-main">
												<!--<div class="space-6"></div>-->
												
												<div id="user-profile-1" class="user-profile row-fluid">
													<div class="center">
														
														<div class="width-80 label label-success label-large arrowed-in arrowed-in-right">
															<div class="inline position-relative">
																<span class="white middle bigger-120">Harry Windharto</span>
															</div>
														</div>
														
														<div class="space-6"></div>
														
														<span class="profile-picture">
															<img id="avatar"  alt="Programmer's Avatar" src="<?php echo base_url();?>assets/avatars/profile-pic.jpg" />
														</span>
														
														<div class="space-4"></div>
														
														<div class="profile-contact-info">
															<div class="profile-contact-links align-left">
																
																<a class="btn btn-link" href="#" target="_blank">
																	<i class="icon-globe bigger-125 blue"></i>
																	www.harrywindharto.co.id
																</a>
																
																<a class="btn btn-link" href="http://www.faceboook.com/hriywiend" target="_blank">
																	<i class="icon-facebook-sign bigger-125 blue"></i>
																	Find me on Facebook
																</a>
																
																<a class="btn btn-link" href="#" target="_blank">
																	<i class="icon-twitter-sign bigger-125 blue"></i>
																	Follow me on Twitter
																</a>
															</div>
														</div>
													</div>
												</div>

											</div>

											<div class="toolbar center">
												<a href="#" onclick="show_box('login-box'); return false;" class="back-to-login-link">
													<i class="icon-arrow-left"></i>
													Back to login
												</a>
											</div>
										</div><!--/widget-body-->
									</div><!--/signup-box-->
								</div><!--/position-relative-->
							</div>
						</div>
					</div><!--/.span-->
				</div><!--/.row-fluid-->
			</div>
		</div><!--/.main-container-->

		<!--basic scripts-->

		<!--[if !IE]>-->

		<!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>-->
		<script src="<?php echo base_url();?>assets/js/jquery-2.0.3.min.js"></script>

		<!--<![endif]-->

		<!--[if IE]>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<![endif]-->

		<!--[if !IE]>-->

		<script type="text/javascript">
			window.jQuery || document.write("<script src='<?php echo base_url();?>assets/js/jquery-2.0.3.min.js'>"+"<"+"/script>");
		</script>

		<!--<![endif]-->

		<!--[if IE]>
<script type="text/javascript">
 window.jQuery || document.write("<script src='assets/js/jquery-1.10.2.min.js'>"+"<"+"/script>");
</script>
<![endif]-->

		<script type="text/javascript">
			if("ontouchend" in document) document.write("<script src='assets/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
		</script>
		<script src="<?php echo base_url();?>assets/js/bootstrap.min.js"></script>

		<!--page specific plugin scripts-->
		
		<script src="<?php echo base_url();?>assets/js/jquery.blockUI.js"></script>
		<script type="text/javascript">
			$(document).ajaxStop($.unblockUI);
				$('#btnLogin').click(function(){
					$.blockUI({			
						message	: '<h5><img src="<?php echo base_url();?>assets/images/Preloader_21.gif" /> Authentication</h5>'						
					});
				});
		</script>

		<!--ace scripts-->

		<script src="<?php echo base_url();?>assets/js/ace-elements.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/ace.min.js"></script>

		<!--inline scripts related to this page-->

		<script type="text/javascript">
			function show_box(id) {
			 $('.widget-box.visible').removeClass('visible');
			 $('#'+id).addClass('visible');
			}
		</script>
	</body>
</html>
