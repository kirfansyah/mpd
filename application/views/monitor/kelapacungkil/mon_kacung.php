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
			Kelapa Cungkil
		</li>
	</ul><!--.breadcrumb-->
</div>

<div class="page-content">
	<h3 class="header smaller lighter blue">		
		<a href="<?php echo site_url('transaksi/kelapacungkil');?>" class="btn btn-primary bolder">
			<i class="icon-file-text"></i> Buka Transaksi Kelapa Cungkil
		</a>		
	</h3>
	<div class="row-fluid">
		<div class="span12">
			
			<div class="page-header">
				<?php echo form_open('monitor/kelapacungkil',array('id'=>'formTimbangKelapa' ,'class'=>'form-horizontal')); ?>
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
				Monitor Kelapa Cungkil
				<span class="badge badge-success"> ID Transaksi : <?php echo $headerid;?> </span>
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
						
			<table id="tabelmon_ak1" class="table table-bordered table-condensed">
				<thead>
					<tr>
						<th class="center" style="width:30px" rowspan="2">NO</th>
						<th class="center" colspan="<?php echo $nomesinakhir;?>">NOMOR MESIN</th>
					</tr>
					<tr>
						<!--<th class="center" style="width:30px">No</th>-->
						<?php
						for ($i = $nomesinawal; $i <= $nomesinakhir; $i++){
							echo '<th class="center">'.$i.'</th>';
						}
						?>
					</tr>
				</thead>
				<tbody>

					<?php
					$no = 1;
					$totM1 = 0;
					$totM2 = 0;
					$totM3 = 0;
					$totM4 = 0;
					$totM5 = 0;
					$totM6 = 0;
					$totM7 = 0;
					$totM8 = 0;
					$totM9 = 0;
					$totM10 = 0;
					$totM11 = 0;
					$totM12 = 0;
					$totM13 = 0;

					foreach ($record as $rec) {
						$mesinke = 1;
						echo '<tr>';
						echo '<td class="center">'.$no++.'</td>';
						for ($i = $nomesinawal; $i <= $nomesinakhir; $i++){
							if ($mesinke === 1){
								echo '<td class="center">'.$rec->M1.'</td>';
								$totM1 = $totM1 + $rec->M1;
							}
							if ($mesinke === 2){
								echo '<td class="center">'.$rec->M2.'</td>';
								$totM2 = $totM2 + $rec->M2;
							}
							if ($mesinke === 3){
								echo '<td class="center">'.$rec->M3.'</td>';
								$totM3 = $totM3 + $rec->M3;
							}
							if ($mesinke === 4){
								echo '<td class="center">'.$rec->M4.'</td>';
								$totM4 = $totM4 + $rec->M4;
							}
							if ($mesinke === 5){
								echo '<td class="center">'.$rec->M5.'</td>';
								$totM5 = $totM5 + $rec->M5;
							}
							if ($mesinke === 6){
								echo '<td class="center">'.$rec->M6.'</td>';
								$totM6 = $totM6 + $rec->M6;
							}
							if ($mesinke === 7){
								echo '<td class="center">'.$rec->M7.'</td>';
								$totM7 = $totM7 + $rec->M7;
							}
							if ($mesinke === 8){
								echo '<td class="center">'.$rec->M8.'</td>';
								$totM8 = $totM8 + $rec->M8;
							}
							if ($mesinke === 9){
								echo '<td class="center">'.$rec->M9.'</td>';
								$totM9 = $totM9 + $rec->M9;
							}
							if ($mesinke === 10){
								echo '<td class="center">'.$rec->M10.'</td>';
								$totM10 = $totM10 + $rec->M10;
							}
							if ($mesinke === 11){
								echo '<td class="center">'.$rec->M11.'</td>';
								$totM11 = $totM11 + $rec->M11;
							}
							if ($mesinke === 12){
								echo '<td class="center">'.$rec->M12.'</td>';
								$totM12 = $totM12 + $rec->M12;
							}
							if ($mesinke === 13){
								echo '<td class="center">'.$rec->M13.'</td>';
								$totM13 = $totM13 + $rec->M13;
							}
							$mesinke = $mesinke + 1;
						}
						echo '</tr>';
					}

					?>

				</tbody>
				<tfoot class="blue bolder bigger-110">
					<tr>
						<?php
						echo '<td class="center">#</td>';
						$mesinke = 1;
						for ($i = $nomesinawal; $i <= $nomesinakhir; $i++){
							if ($mesinke === 1){
								echo '<td class="center">'.$totM1.'</td>';								
							}
							if ($mesinke === 2){
								echo '<td class="center">'.$totM2.'</td>';								
							}
							if ($mesinke === 3){
								echo '<td class="center">'.$totM3.'</td>';								
							}
							if ($mesinke === 4){
								echo '<td class="center">'.$totM4.'</td>';								
							}
							if ($mesinke === 5){
								echo '<td class="center">'.$totM5.'</td>';								
							}
							if ($mesinke === 6){
								echo '<td class="center">'.$totM6.'</td>';								
							}
							if ($mesinke === 7){
								echo '<td class="center">'.$totM7.'</td>';								
							}
							if ($mesinke === 8){
								echo '<td class="center">'.$totM8.'</td>';								
							}
							if ($mesinke === 9){
								echo '<td class="center">'.$totM9.'</td>';								
							}
							if ($mesinke === 10){
								echo '<td class="center">'.$totM10.'</td>';								
							}
							if ($mesinke === 11){
								echo '<td class="center">'.$totM11.'</td>';								
							}
							if ($mesinke === 12){
								echo '<td class="center">'.$totM12.'</td>';								
							}
							if ($mesinke === 13){
								echo '<td class="center">'.$totM13.'</td>';								
							}
							$mesinke = $mesinke + 1;
						}
						?>
					</tr>
				</tfoot>
			</table>

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