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

	<body class="navbar-fixed">
		
		<?php echo $_navbar;?>

		<div class="main-container container-fluid">
			<?php
			if ($nosidebar === 0){
				echo $_sidebar;

				echo '<div class="main-content">';
				echo $_content;
				echo '</div>';
			} else {
				echo $_content;
			}
			?>
			
		</div><!--/.main-container-->
		
		<div id="footer">
			<!-- <div class="label label-primary">
				<i class="icon-time"></i> Page load in {elapsed_time} second
			</div> -->
		</div>

		<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-small btn-inverse">
			<i class="icon-double-angle-up icon-only bigger-110"></i>
		</a>
		
	</body>
	
	<script language="JavaScript">
//		Penggunaan ==> <input onkeydown="return isNumber(event)"/>
		function isNumber(evt) {
			evt = (evt) ? evt : window.event;
			var charCode = (evt.which) ? evt.which : evt.keyCode;
			if (charCode > 31 && (charCode < 48 || charCode > 57)) {
				return false;
			}
			return true;
		}
		
		function isDecimal(evt) {
			evt = (evt) ? evt : window.event;
			var charCode = (evt.which) ? evt.which : evt.keyCode;
			if (charCode > 31 && (charCode < 48 || (charCode > 57 && charCode !== 190 && charCode !== 110 ))) {
				return false;
			}
			return true;
		}
	</script>
	
	<!--Script utk fixed tab mesin-->
	<script>
		var sticky = document.querySelector('#tabmesin');
		var stickyCon = document.querySelector('.tab-content');
		var origOffsetY = sticky.offsetTop;

		function onScroll(e) {
		//  window.scrollY >= origOffsetY ? sticky.classList.add('nav-fixed') :
		//                                  sticky.classList.remove('nav-fixed');
			if (window.scrollY >= origOffsetY){
				sticky.classList.add('nav-fixed');
				stickyCon.classList.add('tab-content-fixed');
			} else {
				sticky.classList.remove('nav-fixed');
				stickyCon.classList.remove('tab-content-fixed');
			}
		}

		document.addEventListener('scroll', onScroll);
	</script>
</html>