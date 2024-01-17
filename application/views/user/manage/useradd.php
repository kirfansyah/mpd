<?php echo form_open('users/saveuser',array('id'=>'formUserAdd' ,'class'=>'form-horizontal')); ?>

<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal">&times;</button>
	<h4 class="blue bigger">Tambah User Baru</h4>		
</div>

<div class="modal-body">			
	<div class="row-fluid">
		<div class="span12">

			<?php echo form_fieldset();?>
			
			<div class="control-group">
				<label class="control-label" for="inputUserID">User ID</label>
				<div class="controls">
					<input name="txtUserID" id="inputUserID" placeholder="User ID" type="text"/>
				</div>
			</div>

			<div class="control-group">
				<label class="control-label" for="inputUserName">User Name</label>
				<div class="controls">
					<input name="txtUserName" id="inputUserName" placeholder="User Name" type="text"/>
				</div>
			</div>
			
			<div class="control-group">
				<label class="control-label" for="inputUserGroup">User Group</label>
				<div class="controls">
					<select class="form-control" name="txtUserGroup" id="dropdownGroupUser" data-placeholder="Pilih User Group">
						<option value="0">Pilih User Group</option>
						<?php foreach($grouplist as $row): ?>
							<option value="<?php echo $row->GroupID;?>"><?php echo $row->GroupName;?></option>
						<?php endforeach; ?>
					</select>						
				</div>
			</div>
			
			<?php echo form_fieldset_close();?>

		</div><!--/.span12-->
	</div><!--/.row-fluid-->
</div><!--/.modal-body-->

<div class="modal-footer">
	<button class="btn btn-small btn-primary">
		<i class="icon-ok"></i>
		Simpan
	</button>
	<button class="btn btn-small" data-dismiss="modal">
		<i class="icon-remove"></i>
		Batal
	</button>	
</div>

<?php echo form_close(); ?>


<script src="<?php echo base_url();?>assets/js/jquery.validate.min.js"></script>
<script type="text/javascript">
//	$(".chzn-select").chosen();
	
	$('#formUserAdd').validate({
		errorElement: 'span',
		errorClass: 'help-inline',
		focusInvalid: false,
		rules: {
			txtUserID:{
				required : true
			},
			txtUserName:{
				required : true
			},
			txtUserGroup:{
				required : true
			}
		},
		
		messages: {
			txtUserID:{
				required	: "Masukkan UserID!"
			},
			txtUserName:{
				required	: "Masukkan Username"
			},
			txtUserGroup:{
				required	: "Masukkan Grup User"
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
