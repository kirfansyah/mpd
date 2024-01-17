
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
			Menu
		</li>
	</ul><!--.breadcrumb-->
</div>

<div class="page-content">
	<div class="row-fluid">
		<h3 class="header smaller lighter blue">
			<?php
				echo anchor('setting/menu/add','<i class="icon-plus"></i> Tambah</i>',array('class'=>'btn btn-danger btn-small'));
			?>
		</h3>
		
		<?php echo $message;?>
		
		<div class="judul">
			Menu Management
		</div>

		<table id="tabelmenu" class="table table-striped table-bordered table-hover">
			<thead>
				<tr>
					<th width="100">ID Menu</th>
					<th>Nama Menu</th>
					<th>Link</th>
					<th width="50" style="text-align: center;">Icon</th>
					<th class="hidden-480">Kategori</th>
					<th></th>
					<th></th>
				</tr>
			</thead>
			<?php
			function chek($id){
				$CI = get_instance();				
				$result=$CI->db->get_where('tblOL_UtlMenu',array('MenuID'=>$id))->row_array();
				return $result['MenuName'];
			}
			foreach ($record as $r){
				$kategori=$r->MenuParent==0?'Menu Utama':chek($r->MenuParent);
				
				if($kategori == 'Menu Utama'){
					$menuparent = "<span class='label label-info arrowed arrowed-righ'>Menu Utama</span>";
				}else{
					$menuparent = "<span class='label label-success arrowed-in'>".$kategori."</span>";
				}
				
				echo "<tr>
					<td>".$r->MenuID."</td>
					<td>".$r->MenuName."</td>
					<td>".$r->MenuLink."</td>
					<td style='text-align:center;'><i class='".$r->MenuIcon."'></td>
					<td>$menuparent</td>
					<td width='30'>".anchor('setting/menu/edit/'.strtolower($r->MenuID), '<i class="icon-edit bigger-120"></i>', array('class'=>'btn btn-mini btn-danger'))."</td>						
					<td width='30'><a href='#' menuid='".  $r->MenuID."' menuname='".strtoupper($r->MenuName)."' class='btn btn-mini btn-danger hapus'><i class='icon-trash bigger-120'></i></a></td>
				</tr>";
			}
			?>
		</table>
	</div>
</div><!--/.page-content-->

<script src="<?php echo base_url();?>assets/js/bootbox.js"></script> 
<script type="text/javascript">
	$(document).ready(function(){
		//http://the-phpjs-ldc.rgou.net/frame.php?docurl=jquery-plugins/DataTables-1.9.4/examples
		$('#tabelmenu').dataTable({
			"bPaginate"	: false,
			"bSort"		: false,
			"bFilter"	: false,			
			"sDom"		: '<"row-fluid" <"top"i> >'		//http://the-phpjs-ldc.rgou.net/frame.php?docurl=jquery-plugins/DataTables-1.9.4/examples			
		});
		
		$('.hapus').click(function(){
			var menuid = $(this).attr("menuid");
			var menuname = $(this).attr("menuname");
			
			bootbox.confirm('Hapus menu <strong>'+menuname+'</strong>?',function(result){
				if (result){
					$.ajax({
						url:"<?php echo site_url('setting/menu/delete');?>",
						type:"POST",
						data:"menuid="+menuid,
						cache:false,
						success:function(){
							return location.href = "<?php echo site_url('setting/menu/delete_success');?>";
						},
						error:function(){
							return location.href="<?php echo site_url('setting/menu/delete_failed');?>";
						}
					});
				}else{
					console.log("User declined dialog");
				}
			});
		});
	});
</script>