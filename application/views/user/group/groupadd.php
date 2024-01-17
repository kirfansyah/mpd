<?php echo form_open('users/savegroup',array('id'=>'formGroupAdd' ,'class'=>'form-horizontal')); ?>
<?php echo form_fieldset();?>

<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal">&times;</button>
	<h4 class="blue bigger">Tambah Grup User Baru</h4>		
</div>

<div class="modal-body">			
	<div class="row-fluid">
		<div class="span12">

			<!--			
			<div class="control-group">
				<label class="control-label" for="inputUserID">Group ID</label>
				<div class="controls">
					<input name="txtGroupID" id="inputUserID" placeholder="Group ID" type="text"/>
				</div>
			</div>-->

			<div class="control-group">
				<label class="control-label" for="inputGroupName">Nama Grup</label>
				<div class="controls">
					<input name="txtGroupName" id="inputGroupName" placeholder="Nama Grup User" type="text"/>
				</div>
			</div>
			
			<div class="control-group">
				<label class="control-label" for="inputGroupRemark">Keterangan</label>
				<div class="controls">
					<input name="txtGroupRemark" id="inputGroupRemark" placeholder="Keterangan" type="text"/>						
				</div>
			</div>

			

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

<?php echo form_fieldset_close();?>
<?php echo form_close(); ?>

<script type="text/javascript">
	$(".chzn-select").chosen();
</script>