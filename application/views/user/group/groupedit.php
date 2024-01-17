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
			<a href="#">Users</a>

			<span class="divider">
				<i class="icon-angle-right"></i>
			</span>
		</li>
		
		<li>
			<a href="#">Group</a>

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
					<h4><i class="icon-edit"></i> Edit Group : <?php foreach ($datagroup as $r): echo $r->GroupName; endforeach;?></h4>
				</div>
				
				<div class="widget-body">
					<div class="widget-main no-padding">
						<?php echo form_open('users/updategroup',array('id'=>'formGroupEdit' ,'class'=>'form-horizontal')); ?>
						<?php echo form_fieldset();?>
						
						<div class="control-group hidden">
							<label class="control-label" for="inputGroupID">Group ID</label>
							<div class="controls">
								<input name="txtGroupID" id="inputGroupID" placeholder="Group ID" type="text" value="<?php foreach ($datagroup as $r): echo $r->GroupID; endforeach;?>" />
							</div>
						</div>
						
						<div class="control-group">
							<label class="control-label" for="inputGroupName">Group Name</label>
							<div class="controls">
								<input name="txtGroupName" id="inputGroupName" placeholder="Group Name" value="<?php foreach ($datagroup as $r): echo $r->GroupName; endforeach;?>" type="text"/>
							</div>
						</div>
						
						<div class="control-group">
							<label class="control-label" for="inputGroupRemark">Keterangan</label>
							<div class="controls">
								<input name="txtGroupRemark" id="inputGroupRemark" placeholder="Keterangan" value="<?php foreach ($datagroup as $r): echo $r->GroupRemark; endforeach;?>" type="text"/>						
							</div>
						</div>
						
						<?php echo form_fieldset_close();?>
						
						<div class="form-actions center">
							<button class="btn btn-small btn-primary">
								<i class="icon-ok"></i>
								Update
							</button>
							<a href="<?php echo site_url('users/group');?>" class="btn btn-small" >
								<i class="icon-remove"></i>
								Batal
							</a>							
						</div>

						<?php echo form_close(); ?>
					</div><!--/.widget-main-->
				</div><!--/.widget-body-->
			</div><!--/.widget-box-->
		</div><!--/.span12-->		
	</div><!--/.row-fluid-->
</div><!--/.pag-content-->