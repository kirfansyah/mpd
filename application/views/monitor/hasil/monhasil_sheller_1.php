<table id="tabelsheller" class="table table-bordered table-condensed">
	<thead>
		<tr>
			<th class="center"> NO </th>
			<th class="center"> NO. MESIN </th>
			<th class="center"> NIK PSN </th>
			<th class="center"> NAMA </th>
			<th class="center"> BUTIR </th>
			<th class="center"> WHITE MEAT </th>
			<th class="center"> AIR KELAPA </th>
			<th class="center"> KELAPA CUNGKIL </th>
			<th class="center"> KETERANGAN </th>
		</tr>
	</thead>
	<tbody>
		<?php
			$i=0;
			foreach ($record_sheller as $r){
				$i++;
				echo "<tr>
					<td class='center'>".$i."</td>
					<td class='center'>".$r->NomorMesin."</td>
					<td class='center'>".$r->NIK."</td>
					<td class='left'>".$r->Nama."</td>
					<td class='right'>".$r->TotalPakai."</td>
					<td class='right'>".floatval($r->TimbangWM)."</td>
					<td class='right'>".floatval($r->TimbangAK)."</td>
					<td class='right'>".floatval($r->HasilKC)."</td>
					<td>&nbsp;</td>
					</tr>";
			}
		?>
	</tbody>
</table>

<script type="text/javascript">
//	$('#tabelsheller').dataTable();
</script>