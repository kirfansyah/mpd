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
		
		<li class="active">
			Manage
		</li>
	</ul><!--.breadcrumb-->
</div>

<div class="page-content">
	<h3 class="header smaller lighter blue">		
		<a data-toggle="remote-modal" href="<?php echo site_url('users/adduser');?>" data-target="#modalcon" class="btn btn-danger btn-small">
			<i class="icon-plus"></i> Tambah
		</a>
	</h3>
		
	<?php echo $message;?>
	
	<div class="judul">
		User's Management
	</div>
	
	<table id="tabeluser" class="table table-striped table-bordered table-hover">
		<thead>
			<tr>
				<th width='50'>#</th>
				<th>User ID</th>
				<th>User Name</th>
				<th>Group Name</th>
				<th></th>
				<th></th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			<?php
				$i = 0;
				foreach ($record as $r){
					$i++;
					form_hidden('txtUserID', $r->UserID);
					echo "<tr>
						<td>".$i."</td>
						<td>".$r->UserID."</td>
						<td>".$r->Username."</td>
						<td>".$r->GroupName."</td>
						<td width='80'>".anchor('users/edituser/'.strtolower($r->UserID), '<i class="icon-edit bigger-120"></i> EDIT', array('class'=>'btn btn-mini btn-danger'))."</td>						
						<td width='80'><a href='#' id='btnDelete' uid='".  strtoupper($r->UserID)."' class='btn btn-mini btn-danger hapus'><i class='icon-trash bigger-120'></i> HAPUS</a></td>
						<td width='80'><a href='#' id='btnReset' uid='".  strtoupper($r->UserID)."' class='btn btn-mini btn-danger reset'><i class='icon-refresh bigger-120'></i> RESET</a></td>
						</tr>";
				}
			?>
		</tbody>
	</table>
</div><!--/.page-content-->

<div class="modal fade" id="modalcon" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">	
	<!--Modal Goes Here-->
</div>

<script src="<?php echo base_url();?>assets/js/bootbox.js"></script> 
<script type="text/javascript">
	//$(document).ready(function() {
		$('#tabeluser').dataTable({
			"aoColumns": [
			  null, null, null, null,
			  { "bSortable": false },
			  { "bSortable": false },
			  { "bSortable": false }
			]
		});
		
		$(document).on('click','.hapus',function (){
		//$('.hapus').click(function(){
			var uid = $(this).attr("uid");
			
			bootbox.confirm('Hapus data '+uid+'?',function(result){
				if (result){
					$.ajax({
						url:"<?php echo site_url('users/deleteuser');?>",
						type:"POST",
						data:"uid="+uid,
						cache:false,
						success:function(){
							return location.href = "<?php echo site_url('users/manage/delete_success');?>";
						},
						error:function(){
							return location.href="<?php echo site_url('users/manage/delete_failed');?>";
						}
					});
				}else{
					console.log("User declined dialog");
				}
			});
		});
		
		$(document).on('click','.reset',function() {
		//$('.reset').click(function(){
			var uid = $(this).attr("uid");
			
			bootbox.confirm('Apakah anda yakin mereset password '+uid+'?',function(result){
				if (result){
					$.ajax({
						url:"<?php echo site_url('users/resetuser');?>",
						type:"POST",
						data:"uid="+uid,
						cache:false,
						success:function(){
							return location.href = "<?php echo site_url('users/manage/reset_success');?>";
						},
						error:function(){
							return location.href="<?php echo site_url('users/manage/reset_failed');?>";
						}
					});
				}else{
					console.log("User declined dialog");
				}
			});
		});

	//});

//	$(function() {
//		var oTableMenu = $('#tabeluser').dataTable({
//			"aoColumns": [
//			  null, null, null, null,
//			  { "bSortable": false },
//			  { "bSortable": false }
//			]
//		});
//	});
	
	$(function() {
		$(document).on("click", "[data-toggle='remote-modal']", function (e) {
			e.preventDefault();

			var $this = $(this)
			  , href = $this.attr('href')
			  , $target = $($this.attr('data-target') || (href && href.replace(/.*(?=#[^\s]+$)/, ''))) //strip for ie7
			  , option = $target.data('modal') ? 'toggle' : $.extend({ }, $target.data(), $this.data());

			$target
				.modal(option)
				.load(href)
				.one('hide', function() {
					$this.focus();
				});
			console.log(href);
		});
	});
	
</script>