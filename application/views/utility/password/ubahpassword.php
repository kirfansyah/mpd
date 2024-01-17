<div class="breadcrumbs" id="breadcrumbs">
	<ul class="breadcrumb">
		<li>
			<i class="icon-home"></i>
			<a href="<?php echo site_url('home');?>">Home</a>
			<span class="divider">
				<i class="icon-angle-right"></i>
			</span>
		</li>
		
		<li>
			<a href="#">Utility</a>
			<span class="divider">
				<i class="icon-angle-right"></i>
			</span>
		</li>
		
		<li class="active">
			Ubah Password
		</li>
	</ul><!--.breadcrumb-->
</div>

<div class="page-content">
	<div class="row-fluid">
		<div class="span12">
			
			<div class="widget-box">
				<div class="widget-header header-color-blue2">
					<h4><i class="icon-key"></i> Ubah Password</h4>
				</div>
				
				<div class="widget-body">
					
					<?php echo $message;?>					
					
					<div class="widget-main no-padding">
						<?php 
							echo form_open('password/update',array('id'=>'formPassword' ,'class'=>'form-horizontal')); 
							echo form_fieldset();
						?>
						
						<div class="control-group hidden">
							<label class="control-label" for="inputPassLama">User ID</label>
							<div class="controls">
								<input name="txtUserID" id="inputUserID" type="text" value="<?php foreach ($datauser as $r): echo $r->UserID; endforeach;?>" />
							</div>
						</div>
						
						<div class="control-group">
							<label class="control-label" for="inputPassLama">Password Lama</label>
							<div class="controls">
								<input name="txtPassLama" id="inputPassLama" placeholder="Password Lama" type="password" />
							</div>
						</div>
						
						<div class="control-group">
							<label class="control-label" for="inputPassBaru">Password Baru</label>
							<div class="controls">
								<input name="txtPassBaru" id="inputPassBaru" placeholder="Password Baru" type="password" />
							</div>
						</div>
						
						<?php 
							echo form_fieldset_close();
						?>

						<div class="form-actions center">
							<button class="btn btn-small btn-primary" type="submit">
								<i class="icon-ok"></i>
								Simpan
							</button>
							<a href="<?php echo site_url('password');?>" class="btn btn-small" >
								<i class="icon-remove"></i>
								Batal
							</a>
						</div>

						<?php 
							echo form_close(); 
						?>
					</div><!--/.widget-main-->
				</div><!--/.widget-body-->
			</div><!--/.widget-box-->
		</div>
	</div><!--/.row-fluid-->
</div><!--/.page-content-->

<script src="<?php echo base_url();?>assets/js/jquery.validate.min.js"></script>
<script type="text/javascript">
	$('#formPassword').validate({
		errorElement: 'span',
		errorClass: 'help-inline',
		focusInvalid: true,
		rules: {
			txtPassLama:{
				required : true
			},
			txtPassBaru:{
				required : true
			}
		},
		
		messages: {
			txtPassLama:{
				required	: " <i class='icon-exclamation-sign'></i> Silakan masukkan password lama anda!"
			},
			txtPassBaru:{
				required	: " <i class='icon-exclamation-sign'></i> Silakan masukkan password baru anda!"
			}
		},
		
		highlight: function (e) {
			$(e).closest('.control-group').removeClass('info').addClass('error');
		},

		success: function (e) {
			$(e).closest('.control-group').removeClass('error').addClass('info');
			$(e).remove();
		}
	});
</script>