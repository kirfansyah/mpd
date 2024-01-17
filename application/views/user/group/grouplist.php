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
			Group
		</li>
	</ul><!--.breadcrumb-->
</div>

<div class="page-content">
	<h3 class="header smaller lighter blue">		
		<a data-toggle="remote-modal" href="<?php echo site_url('users/addgroup');?>" data-target="#modaladd" class="btn btn-danger btn-small">
			<i class="icon-plus"></i> Tambah
		</a>
	</h3>
	
	<?php
		echo $message;		
	?>
	
	<div class="judul">
		User's Group Management
	</div>
	
	<table id="tabelgroup" class="table table-striped table-bordered table-hover">
		<thead>
			<tr>
				<th width='50'>#</th>
				<th class="hidden">Group ID</th>
				<th>Group Name</th>
				<th>Remark</th>
				<th></th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			<?php
				$i = 0;
				foreach ($record as $r){
					$i++;
					echo "<tr>
						<td>".$i."</td>
						<td class='hidden'>".$r->GroupID."</td>
						<td>".$r->GroupName."</td>
						<td>".$r->GroupRemark."</td>
						<td width='30'>".anchor('users/editgroup/'.strtolower($r->GroupID), '<i class="icon-edit bigger-120"></i>', array('class'=>'btn btn-mini btn-danger'))."</td>						
						<td width='30'><a href='#' id='btnDelete' grupid='".  strtoupper($r->GroupID)."' grupname='".strtoupper($r->GroupName)."' class='btn btn-mini btn-danger hapus'><i class='icon-trash bigger-120'></i></a></td>
						</tr>";
				}
			?>
		</tbody>
	</table>
</div><!--/.page-content-->

<div class="modal fade" id="modaladd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">	
	<!--Modal Goes Here-->
</div>

<script src="<?php echo base_url();?>assets/js/bootbox.js"></script> 
<script type="text/javascript">
	$(document).ready(function() {
		$('#tabelgroup').dataTable({
			"aoColumns": [
				null, null, null, null,
				{ "bSortable": false },
				{ "bSortable": false }
			]
		});
		
		$('.hapus').click(function(){
			var grupid = $(this).attr("grupid");
			var	grupname = $(this).attr("grupname");				
			
			bootbox.confirm('Hapus grup <strong>'+grupname+'</strong>?',function(result){
				if (result){
					$.ajax({
						url:"<?php echo site_url('users/deletegroup');?>",
						type:"POST",
						data:"grupid="+grupid,
						cache:false,
						success:function(){
							return location.href = "<?php echo site_url('users/group/delete_success');?>";
						},
						error:function(){
							return location.href="<?php echo site_url('users/group/delete_failed');?>";
						}
					});
				}else{
					console.log("User declined dialog");
				}
			});
		});

	});
	
	
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