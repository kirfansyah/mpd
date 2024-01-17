
<?php
	$jumgrupline = 0;
	$showline = '';
	foreach ($groupline as $r){
		$jumgrupline++;
		$showline .= '<th class="center">'.$r->GroupLine.'</th>';
	}
?>
						
<table id="tablaphasil_wm" class="table table-bordered table-condensed">

	<thead>
		<tr>
			<th class="center" rowspan="2">Mesin</th>
			<th class="center" colspan="<?php echo $jumgrupline;?>">Line</th>
		</tr>
		<tr>
			<?php echo $showline;?>
		</tr>
	</thead>

	<tbody>
		<?php
		for($i=1; $i <= $totalmesinmax; $i++){
			echo '<tr>';
			echo '<td class="center">'.$i.'</td>';
			
			foreach ($groupline as $gl){
				$grandtotal = '';
				foreach ($record_ak as $r){
					if ($gl->GroupLine === $r->GroupLine && $i === $r->NomorMesin){
						$grandtotal = floatval($r->GrandTotal);
					}
				}
				echo '<td class="right">'.$grandtotal.'</td>';
			}

			echo '</tr>';
		}
		?>
	</tbody>
	
	<tfoot>
		<?php
		
		echo '<tr>';
		echo '<td class="center">TOTAL</td>';

		foreach ($groupline as $gl){
			$grandtotal = '';
			foreach ($ak_total as $r){
				if ($gl->GroupLine === $r->GroupLine){
					$grandtotal = floatval($r->GrandTotal);
				}
			}
			echo '<td class="right">'.$grandtotal.'</td>';
		}

		echo '</tr>';
		
		?>
	</tfoot>

</table>

<style>
	table {
      width: 100%;
	  /*table-layout: fixed;*/
    }
    .table-wrapper {
      overflow: hidden;
      border: 1px solid #ccc;
    }
/*    
	.pinned {
      width: 30%;
      border-right: 1px solid #ccc;
      float: left;
    }
*/
    .scrollable {
      float: right;
      width: 100%;
      overflow: scroll;
      overflow-y: hidden;
    }
    th {
      text-transform: uppercase;
      line-height: 12px;
      text-align: center;
      overflow: hidden;
      white-space: nowrap;
    }
    td {
      text-align: center;
      vertical-align: middle;
      overflow: hidden;
      /*height: 30px;*/
      white-space: nowrap;
    }
/*	
    .pinned td {
      position: relative;
      font-weight: bold;
      line-height: 18px;
      text-align: left;
      overflow: hidden;
    }
    .pinned td.wrap {
      white-space: normal;
    }
*/
    td .outer {
      position: relative;
      height: 30px;
    }
    td .inner {
      overflow: hidden;
      white-space: nowrap;
      position: absolute;
      width: 100%;
    }
/*
    .pinned td .inner.wrap {
      white-space: normal;
    }
*/
	tfoot {
		background-color: #F3F3F3;
		background-image: linear-gradient(to bottom, #ECECEC,#F8F8F8 );
		background-repeat: repeat-x;
		background-attachment: scroll;
		background-position: 0% 0%;
		background-clip: border-box;
		background-origin: padding-box;
		background-size: auto auto;
	}
	
</style>