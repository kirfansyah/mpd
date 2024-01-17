<style type="text/css">
	#formMenuEdit .ico{
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
		<li class="active">Edit</li>
	</ul><!--.breadcrumb-->
</div>

<div class="page-content">
	<div class="row-fluid">
		<div class="span12">
			<div class="widget-box">
				<div class="widget-header header-color-blue2">
					<h4><i class="icon-edit"></i> Edit Menu : <?php foreach ($datamenu as $r): echo $r->MenuName; endforeach;?></h4>
				</div>
				
				<div class="widget-body">
					<div class="widget-main no-padding">
						<?php echo form_open('setting/menu/update',array('id'=>'formMenuEdit' ,'class'=>'form-horizontal')); ?>
						<?php echo form_fieldset();?>
						
						<div class="control-group hidden">
							<label class="span2 control-label" for="inputMenuID">ID Menu</label>
							<div class="controls">
								<input name="txtMenuID" id="inputMenuID" placeholder="ID Menu" type="text" value="<?php foreach ($datamenu as $r): echo $r->MenuID; endforeach;?>"/>
							</div>
						</div>
						
						<div class="control-group">
							<label class="span2 control-label" for="inputMenuName">Nama Menu</label>
							<div class="controls">
								<input name="txtMenuName" id="inputMenuName" placeholder="Nama Menu" type="text" value="<?php foreach ($datamenu as $r): echo $r->MenuName; endforeach;?>"/>
							</div>
						</div>

						<div class="control-group">
							<label class="span2 control-label" for="inputMenuIcon">Icon Menu</label>
							<div class="controls">
								<!--<input name="txtMenuIcon" id="inputMenuIcon" placeholder="Icon Menu" type="text"/>-->								
								<select class="chzn-select" name="txtMenuIcon" id="inputMenuIcon" style="font-family: 'FontAwesome', Open Sans;" data-placeholder="Pilih Icon">
									<option value=''></option>
									<?php
										foreach ($falist as $key => $value) {
											foreach($datamenu as $r):
												$pilih = $r->MenuIcon;
											endforeach;
											
											if ($pilih === $key){
												echo "<option selected='selected' class='ico' value='".$key."' > &#x".stripslashes($value).";    ".$key."</option>";
											}else{
												echo "<option class='ico' value='".$key."' > &#x".stripslashes($value).";    ".$key."</option>";
											}
										}
									?>
								</select>
							</div>
						</div>
						
						<div class="control-group">
							<label class="span2 control-label" for="inputMenuLink">Link Menu</label>
							<div class="controls">
								<input name="txtMenuLink" id="inputMenuLink" placeholder="Link Menu" type="text" value="<?php foreach ($datamenu as $r): echo $r->MenuLink; endforeach;?>"/>
							</div>
						</div>
						
						<div class="control-group">
							<label class="span2 control-label" for="dropdownMenuParent">Parent Menu</label>
							<div class="controls">
								<select class="chzn-select" name="txtMenuParent" id="dropdownMenuParent" data-placeholder="Pilih Menu Parent">
									<!--<option value="0">Pilih Menu Parent</option>-->
									<option value="0"></option>
									<?php 
										foreach($menulist as $row): 
											foreach($datamenu as $r):
												$pilih = $r->MenuParent;
											endforeach;
											
											if ($pilih === $row->MenuID){
												echo "<option selected='selected' value=".$row->MenuID.">".$row->MenuName."</option>";
											}else{
												echo "<option value=".$row->MenuID.">".$row->MenuName."</option>";
											}
										endforeach;
									?>										
								</select>
							</div>
						</div>
						
						<?php echo form_fieldset_close();?>
						
						<div class="form-actions center">
							<button class="btn btn-small btn-primary">
								<i class="icon-ok"></i>
								Update
							</button>
							<a href="<?php echo site_url('setting/menu');?>" class="btn btn-small" >
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
</div><!--/.page-content-->

<script type="text/javascript">
	$(".chzn-select").chosen({
		allow_single_deselect: true
	});
</script>