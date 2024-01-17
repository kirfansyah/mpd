
<div class="modal-header no-padding">
	<div class="table-header">
		<button type="button" class="close" data-dismiss="modal">&times;</button>
		<i class="icon-search"></i> Pencarian Tenaga Kerja
	</div>
</div>

<div class="modal-body no-padding">
	<div class="row-fluid">
		<table id="tabelTK" class="table table-striped table-bordered table-hover no-margin-bottom no-border-top">
			<thead>
				<tr>
					<th class="center" style="width: 30px">No</th>
					<th>Nama</th>
					<th class="center">NIK</th>
					<th>Pekerjaan</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<?php
				$i = 1;
				foreach($record_tk as $r){
					echo '<tr>';
					echo '<td class="center">'.$i++.'</td>';
					echo '<td>'.$r->Nama.'</td>';
					echo '<td>'.$r->Nik.'</td>';
					echo '<td>'.$r->Pekerjaan.'</td>';
					echo '<td>&nbsp;</td>';
					echo '</tr>';
				}
				?>
			</tbody>
		</table>
	</div>
</div>


<div class="modal-footer">
	<button class="btn btn-small btn-danger pull-left" data-dismiss="modal">
		<i class="icon-remove"></i>
		Close
	</button>
</div>

<script type="text/javascript">
	
	$('#tabelTK').dataTable({
		"bLengthChange": false
	});	
</script>