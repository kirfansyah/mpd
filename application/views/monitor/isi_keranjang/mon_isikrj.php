<style>
	input, textarea, .uneditable-input {
		width: 100px;
	}
	.input-prepend input, .input-append input, .input-prepend input[class*="span"], .input-append input[class*="span"] {
		display: inline-block;
		width: 100px;
	}
</style>

<div class="breadcrumbs" id="breadcrumbs">
	<ul class="breadcrumb">
		<li>
			<i class="icon-home"></i>
			<a href="<?php echo site_url('home');?>">Home</a>
			<span class="divider"><i class="icon-angle-right"></i></span>
		</li>
		
		<li>
			<a href="#">Monitor</a>
			<span class="divider">
				<i class="icon-angle-right"></i>
			</span>
		</li>
		
		<li class="active">
			 Pengisian Keranjang
		</li>
	</ul><!--.breadcrumb-->
</div>

<div class="page-content">
	<h3 class="header smaller lighter blue">		
		<a href="<?php echo site_url('transaksi/pengisian_keranjang');?>" class="btn btn-primary bolder">
			<i class="icon-file-text"></i> Buka Transaksi Pengisian Keranjang
		</a>		
	</h3>
	
	<div class="row-fluid">
		<div class="span12">
			<div class="page-header">
				<?php echo form_open('monitor/pengisian_keranjang',array('id'=>'formIsiKeranjang' ,'class'=>'form-horizontal')); ?>
				<?php echo form_fieldset();?>
				
				<div class="input-append date">
					<input type="text" name="txtTanggal" class="input-mask-date" 
						   value="<?php echo $tanggaltrn;?>">
					<span class="add-on">
						<i class="icon-calendar"></i>
					</span>					
				</div>				
				
				<?php
					$extra_line = 'class="chzn-select" id="dropdownLine" data-placeholder="Pilih Line" style="width: 100px"';
					$option_line[''] = '';
					foreach($cboline as $r):
						$option_line[$r->IDLine] = $r->NamaLine;
					endforeach;
					echo form_dropdown('txtLine', $option_line, $idline, $extra_line);
				?>
				
				<?php
					$extra_shift = 'class="chzn-select" id="dropdownShift" data-placeholder="Pilih Shift" style="width: 120px"';
					$option_shift[''] = '';
					foreach($cboshift as $r):
						$option_shift[$r->IDShift] = $r->NamaShift;
					endforeach;
					echo form_dropdown('txtShift', $option_shift, $shift, $extra_shift);
				?>
				
				<?php
					$extra_jam = 'class="chzn-select" name="txtJamKerja" id="dropdownJamKerja" data-placeholder="Pilih Jam Kerja" style="width: 140px"';
					$option_jam[''] = '';
					foreach($cbojamkerja as $r):
						$option_jam[$r->IDJamKerja] = $r->JamKerja;
					endforeach;
					echo form_dropdown('txtJamKerja', $option_jam, $idjamkerja, $extra_jam);
				?>

				<button id="btnRefresh" name="btnRefresh" class="btn btn-danger btn-small" type="submit">
					<i class="icon-refresh"></i>
					Refresh
				</button>
				
				<?php echo form_fieldset_close();?>				
				<?php echo validation_errors() ? "<br/>".validation_errors() : '' ;?>
				<?php echo form_close(); ?>
			</div>
			
			<div class="space-6"></div>
			
			<div class="judul">
				Monitor Pengisian Keranjang <span class="badge badge-success"> ID Transaksi : <?php echo $headerid;?> </span>
			</div>
			
			<div class="trx-user-info trx-user-info-striped">				
				<div class="trx-info-row">
					<div class="trx-info-name"> Tanggal </div>
					<div class="trx-info-value"><?php echo $tanggaltrn;?></div>
				</div>
				<div class="trx-info-row">
					<div class="trx-info-name"> Line </div>
					<div class="trx-info-value"><?php echo $namaline;?></div>
				</div>
				<div class="trx-info-row">
					<div class="trx-info-name"> Shift </div>
					<div class="trx-info-value"><?php echo $shift;?></div>
				</div>
				<div class="trx-info-row">
					<div class="trx-info-name"> Jam Kerja </div>
					<div class="trx-info-value"><?php echo $jamkerja;?></div>
				</div>
				<div class="trx-info-row">
					<div class="trx-info-name"> Juru Catat </div>
					<div class="trx-info-value"><?php echo $jurucatat;?></div>
				</div>
			</div>
			
			<div class="space-6"></div>
			
			<table id="tabelmon_krj" class="table table-bordered table-condensed">
				<thead>
					<tr>
						<th colspan="2">Nomor</th>
						<th colspan="14">Posisi Isi Keranjang</th>
					</tr>
					<tr>
						<th rowspan="2" style="width: 30px">Msn</th>
						<th rowspan="2" style="width: 30px">Krj</th>
						<th rowspan="2">Isi Awal</th>
						<th colspan="10">Penambahan</th>
						<th rowspan="2">Sisa</th>
						<th rowspan="2" colspan="2">Total Pakai</th>						
					</tr>
					<tr>
						<th>Jam</th>
						<th>T1</th>
						<th>Jam</th>
						<th>T2</th>
						<th>Jam</th>
						<th>T3</th>
						<th>Jam</th>
						<th>T4</th>
						<th>Jam</th>
						<th>T5</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$grandsisa = 0;
					$grandpakai = 0;
					
					foreach ($record as $rec) {
						echo '<tr>';
						
						if ($rec->NoKrj === 1){
							echo '<td rowspan="2"  class="bigger-170">'.$rec->NomorMesin.'</td>';
						}
						
						$T1Jam = !isset($rec->T1Jam) ? '&nbsp;' : date('H:i',strtotime($rec->T1Jam));
						$T2Jam = !isset($rec->T2Jam) ? '&nbsp;' : date('H:i',strtotime($rec->T2Jam));
						$T3Jam = !isset($rec->T3Jam) ? '&nbsp;' : date('H:i',strtotime($rec->T3Jam));
						$T4Jam = !isset($rec->T4Jam) ? '&nbsp;' : date('H:i',strtotime($rec->T4Jam));
						$T5Jam = !isset($rec->T5Jam) ? '&nbsp;' : date('H:i',strtotime($rec->T5Jam));
						
						echo '<td>'.$rec->NoKrj.'</td>';
						echo '<td class="bolder red">'.$rec->IsiAwal.'</td>';	//ISI AWAL DISINI
						
						echo '<td class="smaller-80">'.$T1Jam.'</td>';
						echo '<td class="bolder blue">'.$rec->T1.'</td>';
						echo '<td class="smaller-80">'.$T2Jam.'</td>';
						echo '<td class="bolder blue">'.$rec->T2.'</td>';
						echo '<td class="smaller-80">'.$T3Jam.'</td>';
						echo '<td class="bolder blue">'.$rec->T3.'</td>';
						echo '<td class="smaller-80">'.$T4Jam.'</td>';
						echo '<td class="bolder blue">'.$rec->T4.'</td>';
						echo '<td class="smaller-80">'.$T5Jam.'</td>';
						echo '<td class="bolder blue">'.$rec->T5.'</td>';
						
						echo '<td class="bolder purple">'.$rec->Sisa.'</td>';	//SISA DISINI
						
						$HitTotal = $rec->IsiAwal + $rec->T1 + $rec->T2 + $rec->T3 + $rec->T4 + $rec->T5 - $rec->Sisa ;
						$TotalPakai = ($HitTotal > 0) ? $HitTotal : '&nbsp;';
						echo '<td class="bolder green">'.$TotalPakai.'</td>';	//TOTAL PAKAI DISINI
						
						if ($rec->NoKrj === 1){
							if ($rec->TotalPakai > 0){
								echo '<td rowspan="2" class="bolder green">'.$rec->TotalPakai.'</td>';
								$grandpakai = $grandpakai + $rec->TotalPakai;
							} else {
								echo '<td rowspan="2" class="bolder green">&nbsp;</td>';
							}
						}
						
						$grandsisa = $grandsisa + $rec->Sisa;
						
						
						echo '</tr>';
					}
					?>
				</tbody>
			</table>
			
			<div class="center">
				<div class="infobox infobox-purple2 infobox-dark">
					<div class="infobox-icon">
						<i class="icon-download-alt"></i>
					</div>

					<div class="infobox-data">
						<div class="infobox-content bigger-150">Sisa</div>	
						<div class="infobox-content bigger-180 center"><?php echo number_format($grandsisa, 0, ',', '.');?></div>
					</div>
				</div>
				
				<div class="infobox infobox-green2 infobox-dark">
					<div class="infobox-icon">
						<i class="icon-h-graph-bar2"></i>						   
					</div>

					<div class="infobox-data">
						<div class="infobox-content bigger-140">Total Pakai</div>
						<div class="infobox-content bigger-180 center"><?php echo number_format($grandpakai, 0, ',', '.');?></div>
					</div>
				</div>
			</div>

		</div>
	</div>
</div>

<script type="text/javascript">
	$(".chzn-select").chosen({		
		allow_single_deselect: true		
	});
	$(".chzn-drop").css({
		minwidth	: '50px',
		width		: 'auto'
	});
	
	$('.input-mask-date').mask('99/99/9999');
	$('.input-append.date').datepicker({
        format: "dd/mm/yyyy",
        autoclose: true,
        todayHighlight: true,
		todayBtn : "linked"
    });
	
</script>

<style>	
	table {
		table-layout: fixed;
	}
	table .bolder{
		font-size: 110%;
			
	}
	#tabelmon_krj td {
		text-align: center;
		vertical-align: middle;
	}
	#tabelmon_krj th {
		text-align: center;
		vertical-align: middle;
	}
</style>