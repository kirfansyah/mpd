<table id="tabelparer" class="table table-bordered table-condensed">
	<thead>
		<tr>
			<th class="center"> NO </th>
			<th class="center"> NO. MESIN </th>
			<th class="center"> NIK PSN </th>
			<th class="center"> NAMA </th>
			<th class="center"> PEKERJAAN </th>
			<th class="center"> WHITE MEAT </th>
			<th class="center"> AIR KELAPA </th>
			<th class="center"> KETERANGAN </th>
		</tr>
	</thead>
	<tbody>
		<?php
			$i=0;
			$totalWM = 0;
			$totalAK = 0;
			foreach ($record_parer as $r){
				$i++;
				$totalWM += floatval($r->TimbangWM);
				$totalAK += floatval($r->TimbangAK);
				if ($r->HasilManual == '1') $style = 'style="background-color:#FCEA10;"';
				else $style = '';
				echo "<tr $style>
					<td class='center'>".$i."</td>
					<td class='center'>".$r->NomorMesin."</td>
					<td class='center'>".$r->NIK."</td>
					<td class='left'>".$r->Nama."</td>
					<td class='right'>".$r->Pekerjaan."</td>
					<td class='right'>".floatval($r->TimbangWM)."</td>
					<td class='right'>".floatval($r->TimbangAK)."</td>
					<td>&nbsp;</td>
					</tr>";
			}
			echo '<tr>
				<td colspan="5" class="center"><strong>Total</strong></td>
				<td class="right"><strong>'.$totalWM.'</strong></td>
				<td class="right"><strong>'.$totalAK.'</strong></td>
				<td></td>
			</tr>';
		?>
	</tbody>
</table>

<script type="text/javascript">
//	$('#tabelparer').dataTable();
</script>