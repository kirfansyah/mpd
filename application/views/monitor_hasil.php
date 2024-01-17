<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title><?php echo $this->config->item("title"); ?></title>

		<meta name="description" content="Static &amp; Dynamic Tables" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<link rel='shortcut icon' type='image icon' href="<?php echo base_url(); ?>assets/images/logo_PSG.gif"/>

		<?php echo $_header;?>

		<!--inline styles related to this page-->
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	</head>

	<body>
		<?php echo $_navbar;?>

		<div class="main-container container-fluid">
			<?php echo $_sidebar;?>

			<div class="main-content">
				<div class="breadcrumbs" id="breadcrumbs">
					<ul class="breadcrumb">
						<li>
							<i class="icon-home"></i>
							<a href="<?php echo site_url('home');?>">Home</a>
							<span class="divider"><i class="icon-angle-right"></i></span>
						</li>

						<li>
							<a href="#">Monitor</a>
							<span class="divider">
								<i class="icon-angle-right"></i>
							</span>
						</li>

						<li class="active">
							Hasil
						</li>
					</ul><!--.breadcrumb-->
				</div>

				<div class="page-content">
					<div class="row-fluid">
						<div class="span12">
							<div class="judul">
								Monitor Hasil
							</div>
							
							<?php echo $_monitor; ?>
							
							<div class="row-fluid">
								<div class="span12">
									<div class="tabbable">
										<ul class="nav nav-tabs" id="tabhasil">

											<li class="active">
												<a data-toggle="tab" href="#hasilsheller">
													Hasil Sheller
												</a>
											</li>

											<li>
												<a data-toggle="tab" href="#hasilparer">
													Hasil Parer
												</a>
											</li>

										</ul>

										<div class="tab-content">
											<div id="hasilsheller" class="tab-pane in active">
												<?php echo $_sheller;?>
											</div>

											<div id="hasilparer" class="tab-pane">
												<?php echo $_parer;?>
											</div>
										</div>

									</div>
								</div>
							</div>
						</div>
					</div><!--/.row-fluid-->
				</div><!--/.page-content-->
			</div><!--/.main-content-->
		</div><!--/.main-container-->

		<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-small btn-inverse">
			<i class="icon-double-angle-up icon-only bigger-110"></i>
		</a>		
	</body>
	
</html>