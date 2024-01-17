<style type="text/css">
	#formMenu .ico{
		font-family: 'FontAwesome', Open Sans;
	}
</style>

<div class="breadcrumbs" id="breadcrumbs">
	<ul class="breadcrumb">
		<li>
			<i class="icon-home"></i>
			<a href="#">Home</a>

			<span class="divider">
				<i class="icon-angle-right"></i>
			</span>
		</li>
		<li>
			<a href="#">Setting</a>

			<span class="divider">
				<i class="icon-angle-right"></i>
			</span>
		</li>
		<li>
			<a href="<?php echo site_url('setting/menu'); ?>">Menu</a>

			<span class="divider">
				<i class="icon-angle-right"></i>
			</span>
		</li>
		<li class="active">Add</li>
	</ul><!--.breadcrumb-->
</div>

<div class="page-content">
	<div class="row-fluid">
		<div class="span12">
			
			<?php echo $message;?>
			
			<div class="widget-box">
				<div class="widget-header header-color-blue2">
					<h4><i class="icon-plus"></i> Tambah Menu</h4>
				</div>
				
				<div class="widget-body">
					<div class="widget-main no-padding">
						<?php 
							echo form_open('setting/menu/save',array('id'=>'formMenu' ,'class'=>'form-horizontal')); 
							echo form_fieldset();
						?>

						<div class="control-group">
							<label class="span2 control-label" for="inputMenuID">ID Menu</label>
							<div class="controls">
								<input name="txtMenuID" id="inputMenuID" placeholder="ID Menu" type="text" onkeypress="return isNumber(event)"/>
							</div>
						</div>
						
						<div class="control-group">
							<label class="span2 control-label" for="inputMenuName">Nama Menu</label>
							<div class="controls">
								<input name="txtMenuName" id="inputMenuName" placeholder="Nama Menu" type="text"/>
							</div>
						</div>

						<div class="control-group">
							<label class="span2 control-label" for="inputMenuIcon">Icon Menu</label>
							<div class="controls">
								<!--<input name="txtMenuIcon" id="inputMenuIcon" placeholder="Icon Menu" type="text"/>-->								
								<select class="chzn-select" name="txtMenuIcon" id="inputMenuIcon" style="font-family: 'FontAwesome', Open Sans;" data-placeholder='Pilih Icon Menu'>
									<option value=''></option>
									<?php
										foreach ($falist as $key => $value) {
//											echo "<option class='".$key." ico' value='".$key."' > <span class='".$key."'></span> ".$key."</option>";
											echo "<option class='ico' value='".$key."' > &#x".stripslashes($value).";    ".$key."</option>";
										}
									?>
								</select>
							</div>
						</div>
						
						<div class="control-group">
							<label class="span2 control-label" for="inputMenuLink">Link Menu</label>
							<div class="controls">
								<input name="txtMenuLink" id="inputMenuLink" placeholder="Link Menu" type="text"/>
							</div>
						</div>
						
						<div class="control-group">
							<label class="span2 control-label" for="dropdownMenuParent">Parent Menu</label>
							<div class="controls">
								<select class="chzn-select" name="txtMenuParent" id="dropdownMenuParent" data-placeholder="Pilih Menu Utama">
									<option value="0"></option>
									<?php foreach($menulist as $row): ?>
										<option value="<?php echo $row->MenuID;?>"><?php echo $row->MenuName;?></option>
									<?php endforeach; ?>
								</select>
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
							<a href="<?php echo site_url('setting/menu');?>" class="btn btn-small" >
								<i class="icon-remove"></i>
								Batal
							</a>
						</div>

						<?php 
							echo form_close(); 
						?>
					</div><!-- End widget-main no-padding-->
				</div><!-- End widget-body -->
			</div><!-- End widget-box -->
		</div>
	</div><!-- End row-fluid -->
</div><!-- End page-content -->

<script src="<?php echo base_url();?>assets/js/jquery.validate.min.js"></script>
<script type="text/javascript">
	$(".chzn-select").chosen({
		allow_single_deselect: true
	});
	
	$('#formMenu').validate({
		errorElement: 'span',
		errorClass: 'help-inline',
		focusInvalid: false,
		rules: {
			txtMenuID:{
				required	: true,
				maxlength	: 3,
				minlength	: 3
			},
			txtMenuName:{
				required : true
			},
			txtMenuIcon:{
				required : true
			}
		},
		
		messages: {
			txtMenuID:{
				required	: "Masukkan ID Menu!",
				maxlength	: "Masukkan 3 digit angka",
				minlength	: "Masukkan 3 digit angka"
			},
			txtMenuName:{
				required	: "Masukkan Nama Menu"
			},
			txtMenuIcon:{
				required	: "Masukkan Icon Menu"
			}
		},
		
		highlight: function (e) {
			$(e).closest('.control-group').removeClass('info').addClass('error');
		},

		success: function (e) {
			$(e).closest('.control-group').removeClass('error').addClass('info');
			$(e).remove();
		},
		
		errorPlacement: function (error, element) {
			if(element.is(':checkbox') || element.is(':radio')) {
				var controls = element.closest('.controls');
				if(controls.find(':checkbox,:radio').length > 1) controls.append(error);
				else error.insertAfter(element.nextAll('.lbl:eq(0)').eq(0));
			}
			else if(element.is('.select2')) {
				error.insertAfter(element.siblings('[class*="select2-container"]:eq(0)'));
			}
			else if(element.is('.chzn-select')) {
				error.insertAfter(element.siblings('[class*="chzn-container"]:eq(0)'));
			}
			else error.insertAfter(element);
		}
	});
</script>
