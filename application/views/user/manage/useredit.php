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
			<a href="#">Users</a>

			<span class="divider">
				<i class="icon-angle-right"></i>
			</span>
		</li>
		
		<li>
			<a href="<?php echo site_url('users/manage');?>">Manage</a>

			<span class="divider">
				<i class="icon-angle-right"></i>
			</span>
		</li>
		
		<li class="active">
			Edit
		</li>
	</ul><!--.breadcrumb-->
</div>

<div class="page-content">
	<div class="row-fluid">
		<div class="span12">	
			<div class="widget-box">
				<div class="widget-header header-color-blue2">
					<h4><i class="icon-edit"></i> Edit User : <?php foreach ($datauser as $r): echo $r->UserID; endforeach;?></h4>
				</div>
				
				<div class="widget-body">
					<div class="widget-main no-padding">
						<?php echo form_open('users/updateuser',array('id'=>'formUserEdit' ,'class'=>'form-horizontal')); ?>
						<?php echo form_fieldset();?>

						<div class="control-group hidden">
							<label class="control-label" for="inputUserID">User ID</label>
							<div class="controls">
								<input name="txtUserID" id="inputUserID" placeholder="User ID" type="text" value="<?php foreach ($datauser as $r): echo $r->UserID; endforeach;?>" />
							</div>
						</div>

						<div class="control-group">
							<label class="control-label" for="inputUserName">User Name</label>
							<div class="controls">
								<input name="txtUserName" id="inputUserName" placeholder="User Name" value="<?php foreach ($datauser as $r): echo $r->Username; endforeach;?>" type="text"/>
							</div>
						</div>

						<div class="control-group">
							<label class="control-label" for="inputUserGroup">User Group</label>
							<div class="controls">
								<select class="chzn-select" name="txtUserGroup" id="dropdownGroupUser" data-placeholder="Pilih User Group">
									<option value="0"></option>
									<?php 
									foreach($grouplist as $row): 
										foreach($datauser as $r):
											$pilih = $r->GroupID;
										endforeach;

										if ($pilih === $row->GroupID){
											echo "<option selected='selected' value='".$row->GroupID."'>".$row->GroupName."</option>";
										}else{
											echo "<option value='".$row->GroupID."'>".$row->GroupName."</option>";
										}
									endforeach; ?>									
								</select>						
							</div>
						</div>

						<?php echo form_fieldset_close();?>
						
						<div class="form-actions center">
							<button class="btn btn-small btn-primary">
								<i class="icon-ok"></i>
								Update
							</button>
							<a href="<?php echo site_url('users/manage');?>" class="btn btn-small" >
								<i class="icon-remove"></i>
								Batal
							</a>							
						</div>

						<?php echo form_close(); ?>
					</div>
				</div><!--.widget-body-->
			</div><!--.widget-box-->
		</div><!--/.span12-->
	</div><!--/.row-fluid-->

</div>

<script type="text/javascript">	
	$(".chzn-select").chosen({
		allow_single_deselect: true
	});
</script>