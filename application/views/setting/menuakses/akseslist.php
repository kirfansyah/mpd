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
		
		<li class="active">
			Akses
		</li>
	</ul><!--.breadcrumb-->
</div>

<div class="page-content">
	<?php 
		echo form_open('setting/akses/simpan',array('id'=>'formFilter' ,'class'=>'form-horizontal')); 
		echo form_fieldset();
	?>
	
	<h3 class="header smaller lighter blue">
		<button class="btn btn-small btn-success" type="submit">
			<i class="icon-save bigger-120"></i> Simpan
		</button>
	</h3>
	
	<?php $message;?>
	
	<div class="judul">
		Menu Akses
	</div>
	
	<div class="page-header position-relative">		
		<div class="control-group">
			<label class="control-label" for="inputUserGroup">User Group</label>
			<div class="controls">
				<select class="chzn-select" name="txtUserGroup" id="dropdownGroupUser" data-placeholder="Pilih User Group">
					<option value="0"></option>
					<?php foreach($grouplist as $row): ?>
						<option value="<?php echo $row->GroupID;?>"><?php echo $row->GroupName;?></option>
					<?php endforeach; ?>
				</select>						
			</div>
		</div>
		
		<div class="control-group">
			<!--<label class="control-label" for="inputUserGroup"></label>-->
			<!--<div class="controls">-->
				<div id="tbllist">	
					
					<table class="table table-striped table-bordered table-hover">
						<thead>
							<tr>
								<th width="70">Pilih</th>
								<th>Menu</th>
								<th>Kategori</th>
							</tr>
						</thead>
					</table>
					
				</div>
			<!--</div>-->
		</div>
		
	</div>
	
	<?php 
		echo form_fieldset_close();		
		echo form_close(); 
	?>
</div><!--/.page-content-->

<script type="text/javascript">	
	$(".chzn-select").chosen({
		allow_single_deselect: true
	});
	
	$("#dropdownGroupUser").change(function(){
		var selectValues = $("#dropdownGroupUser").val();
		if (selectValues === 0)
		{
			var msg = "<table class='table table-striped table-hover table-bordered'>\n\
						<thead><tr>\n\
						<th>Pilih</th><th>Menu</th><th>Kategori</th>\n\
						</tr></thead></table>";
			$('#tbllist').html(msg);					
		}
		else
		{
			var grupid = {grupid:$("#dropdownGroupUser").val()};
			$.ajax({
				type: "POST",
				url : "<?php echo site_url('setting/akses_listmenu')?>",
				data: grupid,
				success: function(msg){
					$('#tbllist').html(msg);
				}
			});
		}
		
		return false;
	});
</script>