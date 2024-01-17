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
			 White Meat
		</li>
	</ul><!--.breadcrumb-->
</div>

<div class="page-content">
	<h3 class="header smaller lighter blue">		
		<a href="<?php echo site_url('transaksi/timbang_whitemeat');?>" class="btn btn-primary bolder">
			<i class="icon-file-text"></i> Buka Transaksi White Meat
		</a>		
	</h3>
	
	<div class="row-fluid">
		<div class="span12">
			<div class="page-header">
				<?php echo form_open('monitor/timbang_whitemeat',array('id'=>'formTimbangWhiteMeat' ,'class'=>'form-horizontal')); ?>
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
				Monitor White Meat
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
					<div class="trx-info-value"><?php echo $this->m_trnhasil->get_inspector($headerid, 'WM')['username'];?></div>
				</div>
			</div>
			
			<div class="space-6"></div>
						
			<div class="table-wrapper">
				<div class="scrollable">
			
					<table id="tabelmon_wm" class="table table-bordered table-condensed" >
						<thead>
							<tr>
								<th class="center" style="width:30px" rowspan="3">NO</th>
								<th class="center" colspan="<?php echo ($nomesinakhir * 3);?>">NOMOR MESIN</th>
							</tr>
							<tr>					
								<?php
								for ($i = $nomesinawal; $i <= $nomesinakhir ; $i++){							
									echo '<th colspan="3" class="center">'.$i.'</th>';							
								}
								?>
							</tr>
							<tr>
								<?php
								for ($i = $nomesinawal; $i <= $nomesinakhir ; $i++){
									echo '<th class="center">Timbangan</th>';
									echo '<th class="center">Pot.Lain</th>';
									echo '<th class="center">Pot.Air</th>';							
								}
								?>
							</tr>
						</thead>
						<tbody>
							<?php
							$no = 1;
							$totTM1 = 0;	$totLM1 = 0;	$totAM1 = 0;	$netM1 = 0;
							$totTM2 = 0;	$totLM2 = 0;	$totAM2 = 0;	$netM2 = 0;
							$totTM3 = 0;	$totLM3 = 0;	$totAM3 = 0;	$netM3 = 0;
							$totTM4 = 0;	$totLM4 = 0;	$totAM4 = 0;	$netM4 = 0;
							$totTM5 = 0;	$totLM5 = 0;	$totAM5 = 0;	$netM5 = 0;
							$totTM6 = 0;	$totLM6 = 0;	$totAM6 = 0;	$netM6 = 0;
							$totTM7 = 0;	$totLM7 = 0;	$totAM7 = 0;	$netM7 = 0;
							$totTM8 = 0;	$totLM8 = 0;	$totAM8 = 0;	$netM8 = 0;
							$totTM9 = 0;	$totLM9 = 0;	$totAM9 = 0;	$netM9 = 0;
							$totTM10 = 0;	$totLM10 = 0;	$totAM10 = 0;	$netM10 = 0;
							$totTM11 = 0;	$totLM11 = 0;	$totAM11 = 0;	$netM11 = 0;
							$totTM12 = 0;	$totLM12 = 0;	$totAM12 = 0;	$netM12 = 0;
							$totTM13 = 0;	$totLM13 = 0;	$totAM13 = 0;	$netM13 = 0;

							foreach ($record as $rec) {
								$mesinke = 1;
								echo '<tr>';
								echo '<td class="center">'.$no++.'</td>';
								for ($i = $nomesinawal; $i <= $nomesinakhir; $i++){
									if ($mesinke === 1){
										echo '<td class="center blue bolder">'.floatval($rec->TimM1).'</td>';
										echo '<td class="center red">'.floatval($rec->PotLainM1).'</td>';
										echo '<td class="center pink">'.floatval($rec->PotAirM1).'</td>';
										$totTM1 = $totTM1 + $rec->TimM1;
										$totLM1 = $totLM1 + $rec->PotLainM1;
										$totAM1 = $totAM1 + $rec->PotAirM1;
										$netM1 = $totTM1 - $totLM1 - $totAM1;
									}
									if ($mesinke === 2){
										echo '<td class="center blue bolder">'.floatval($rec->TimM2).'</td>';
										echo '<td class="center red">'.floatval($rec->PotLainM2).'</td>';
										echo '<td class="center pink">'.floatval($rec->PotAirM2).'</td>';
										$totTM2 = $totTM2 + $rec->TimM2;
										$totLM2 = $totLM2 + $rec->PotLainM2;
										$totAM2 = $totAM2 + $rec->PotAirM2;
										$netM2 = $totTM2 - $totLM2 - $totAM2;
									}
									if ($mesinke === 3){
										echo '<td class="center blue bolder">'.floatval($rec->TimM3).'</td>';
										echo '<td class="center red">'.floatval($rec->PotLainM3).'</td>';
										echo '<td class="center pink">'.floatval($rec->PotAirM3).'</td>';
										$totTM3 = $totTM3 + $rec->TimM3;
										$totLM3 = $totLM3 + $rec->PotLainM3;
										$totAM3 = $totAM3 + $rec->PotAirM3;
										$netM3 = $totTM3 - $totLM3 - $totAM3;
									}
									if ($mesinke === 4){
										echo '<td class="center blue bolder">'.floatval($rec->TimM4).'</td>';
										echo '<td class="center red">'.floatval($rec->PotLainM4).'</td>';
										echo '<td class="center pink">'.floatval($rec->PotAirM4).'</td>';
										$totTM4 = $totTM4 + $rec->TimM4;
										$totLM4 = $totLM4 + $rec->PotLainM4;
										$totAM4 = $totAM4 + $rec->PotAirM4;
										$netM4 = $totTM4 - $totLM4 - $totAM4;
									}
									if ($mesinke === 5){
										echo '<td class="center blue bolder">'.floatval($rec->TimM5).'</td>';
										echo '<td class="center red">'.floatval($rec->PotLainM5).'</td>';
										echo '<td class="center pink">'.floatval($rec->PotAirM5).'</td>';
										$totTM5 = $totTM5 + $rec->TimM5;
										$totLM5 = $totLM5 + $rec->PotLainM5;
										$totAM5 = $totAM5 + $rec->PotAirM5;
										$netM5 = $totTM5 - $totLM5 - $totAM5;
									}
									if ($mesinke === 6){
										echo '<td class="center blue bolder">'.floatval($rec->TimM6).'</td>';
										echo '<td class="center red">'.floatval($rec->PotLainM6).'</td>';
										echo '<td class="center pink">'.floatval($rec->PotAirM6).'</td>';
										$totTM6 = $totTM6 + $rec->TimM6;
										$totLM6 = $totLM6 + $rec->PotLainM6;
										$totAM6 = $totAM6 + $rec->PotAirM6;
										$netM6 = $totTM6 - $totLM6 - $totAM6;
									}
									if ($mesinke === 7){
										echo '<td class="center blue bolder">'.floatval($rec->TimM7).'</td>';
										echo '<td class="center red">'.floatval($rec->PotLainM7).'</td>';
										echo '<td class="center pink">'.floatval($rec->PotAirM7).'</td>';
										$totTM7 = $totTM7 + $rec->TimM7;
										$totLM7 = $totLM7 + $rec->PotLainM7;
										$totAM7 = $totAM7 + $rec->PotAirM7;
										$netM7 = $totTM7 - $totLM7 - $totAM7;
									}
									if ($mesinke === 8){
										echo '<td class="center blue bolder">'.floatval($rec->TimM8).'</td>';
										echo '<td class="center red">'.floatval($rec->PotLainM8).'</td>';
										echo '<td class="center pink">'.floatval($rec->PotAirM8).'</td>';
										$totTM8 = $totTM8 + $rec->TimM8;
										$totLM8 = $totLM8 + $rec->PotLainM8;
										$totAM8 = $totAM8 + $rec->PotAirM8;
										$netM8 = $totTM8 - $totLM8 - $totAM8;
									}
									if ($mesinke === 9){
										echo '<td class="center blue bolder">'.floatval($rec->TimM9).'</td>';
										echo '<td class="center red">'.floatval($rec->PotLainM9).'</td>';
										echo '<td class="center pink">'.floatval($rec->PotAirM9).'</td>';
										$totTM9 = $totTM9 + $rec->TimM9;
										$totLM9 = $totLM9 + $rec->PotLainM9;
										$totAM9 = $totAM9 + $rec->PotAirM9;
										$netM9 = $totTM9 - $totLM9 - $totAM9;
									}
									if ($mesinke === 10){
										echo '<td class="center blue bolder">'.floatval($rec->TimM10).'</td>';
										echo '<td class="center red">'.floatval($rec->PotLainM10).'</td>';
										echo '<td class="center pink">'.floatval($rec->PotAirM10).'</td>';
										$totTM10 = $totTM10 + $rec->TimM10;
										$totLM10 = $totLM10 + $rec->PotLainM10;
										$totAM10 = $totAM10 + $rec->PotAirM10;
										$netM10 = $totTM10 - $totLM10 - $totAM10;
									}
									if ($mesinke === 11){
										echo '<td class="center blue bolder">'.floatval($rec->TimM11).'</td>';
										echo '<td class="center red">'.floatval($rec->PotLainM11).'</td>';
										echo '<td class="center pink">'.floatval($rec->PotAirM11).'</td>';
										$totTM11 = $totTM11 + $rec->TimM11;
										$totLM11 = $totLM11 + $rec->PotLainM11;
										$totAM11 = $totAM11 + $rec->PotAirM11;
										$netM11 = $totTM11 - $totLM11 - $totAM11;
									}
									if ($mesinke === 12){
										echo '<td class="center blue bolder">'.floatval($rec->TimM12).'</td>';
										echo '<td class="center red">'.floatval($rec->PotLainM12).'</td>';
										echo '<td class="center pink">'.floatval($rec->PotAirM12).'</td>';
										$totTM12 = $totTM12 + $rec->TimM12;
										$totLM12 = $totLM12 + $rec->PotLainM12;
										$totAM12 = $totAM12 + $rec->PotAirM12;
										$netM12 = $totTM12 - $totLM12 - $totAM12;
									}
									if ($mesinke === 13){
										echo '<td class="center blue bolder">'.floatval($rec->TimM13).'</td>';
										echo '<td class="center red">'.floatval($rec->PotLainM13).'</td>';
										echo '<td class="center pink">'.floatval($rec->PotAirM13).'</td>';
										$totTM13 = $totTM13 + $rec->TimM13;
										$totLM13 = $totLM13 + $rec->PotLainM13;
										$totAM13 = $totAM13 + $rec->PotAirM13;
										$netM13 = $totTM13 - $totLM13 - $totAM13;
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
										echo '<td class="center">'.$totTM1.'</td>';	
										echo '<td class="center red">'.$totLM1.'</td>';
										echo '<td class="center pink">'.$totAM1.'</td>';
									}
									if ($mesinke === 2){
										echo '<td class="center">'.$totTM2.'</td>';	
										echo '<td class="center red">'.$totLM2.'</td>';
										echo '<td class="center pink">'.$totAM2.'</td>';								
									}
									if ($mesinke === 3){
										echo '<td class="center">'.$totTM3.'</td>';	
										echo '<td class="center red">'.$totLM3.'</td>';
										echo '<td class="center pink">'.$totAM3.'</td>';								
									}
									if ($mesinke === 4){
										echo '<td class="center">'.$totTM4.'</td>';	
										echo '<td class="center red">'.$totLM4.'</td>';
										echo '<td class="center pink">'.$totAM4.'</td>';								
									}
									if ($mesinke === 5){
										echo '<td class="center">'.$totTM5.'</td>';	
										echo '<td class="center red">'.$totLM5.'</td>';
										echo '<td class="center pink">'.$totAM5.'</td>';								
									}
									if ($mesinke === 6){
										echo '<td class="center">'.$totTM6.'</td>';	
										echo '<td class="center red">'.$totLM6.'</td>';
										echo '<td class="center pink">'.$totAM6.'</td>';								
									}
									if ($mesinke === 7){
										echo '<td class="center">'.$totTM7.'</td>';	
										echo '<td class="center red">'.$totLM7.'</td>';
										echo '<td class="center pink">'.$totAM7.'</td>';								
									}
									if ($mesinke === 8){
										echo '<td class="center">'.$totTM8.'</td>';	
										echo '<td class="center red">'.$totLM8.'</td>';
										echo '<td class="center pink">'.$totAM8.'</td>';							
									}
									if ($mesinke === 9){
										echo '<td class="center">'.$totTM9.'</td>';	
										echo '<td class="center red">'.$totLM9.'</td>';
										echo '<td class="center pink">'.$totAM9.'</td>';								
									}
									if ($mesinke === 10){
										echo '<td class="center">'.$totTM10.'</td>';	
										echo '<td class="center red">'.$totLM10.'</td>';
										echo '<td class="center pink">'.$totAM10.'</td>';								
									}
									if ($mesinke === 11){
										echo '<td class="center">'.$totTM11.'</td>';	
										echo '<td class="center red">'.$totLM11.'</td>';
										echo '<td class="center pink">'.$totAM11.'</td>';								
									}
									if ($mesinke === 12){
										echo '<td class="center">'.$totTM12.'</td>';	
										echo '<td class="center red">'.$totLM12.'</td>';
										echo '<td class="center pink">'.$totAM12.'</td>';								
									}
									if ($mesinke === 13){
										echo '<td class="center">'.$totTM13.'</td>';	
										echo '<td class="center red">'.$totLM13.'</td>';
										echo '<td class="center pink">'.$totAM13.'</td>';								
									}
									$mesinke = $mesinke + 1;
								}
								?>
							</tr>
							<tr class="green">
								<td class="center">NETTO</td>
								<?php
								$mesinke = 1;
								for ($i = $nomesinawal; $i <= $nomesinakhir; $i++){
									if ($mesinke === 1){
										echo '<td colspan=3 class="center">'.$netM1.'</td>';
									}
									if ($mesinke === 2){
										echo '<td colspan=3 class="center">'.$netM2.'</td>';
									}
									if ($mesinke === 3){
										echo '<td colspan=3 class="center">'.$netM3.'</td>';
									}
									if ($mesinke === 4){
										echo '<td colspan=3 class="center">'.$netM4.'</td>';
									}
									if ($mesinke === 5){
										echo '<td colspan=3 class="center">'.$netM5.'</td>';
									}
									if ($mesinke === 6){
										echo '<td colspan=3 class="center">'.$netM6.'</td>';
									}
									if ($mesinke === 7){
										echo '<td colspan=3 class="center">'.$netM7.'</td>';
									}
									if ($mesinke === 8){
										echo '<td colspan=3 class="center">'.$netM8.'</td>';
									}
									if ($mesinke === 9){
										echo '<td colspan=3 class="center">'.$netM9.'</td>';
									}
									if ($mesinke === 10){
										echo '<td colspan=3 class="center">'.$netM10.'</td>';
									}
									if ($mesinke === 11){
										echo '<td colspan=3 class="center">'.$netM11.'</td>';
									}
									if ($mesinke === 12){
										echo '<td colspan=3 class="center">'.$netM12.'</td>';
									}
									if ($mesinke === 13){
										echo '<td colspan=3 class="center">'.$netM13.'</td>';
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
	</div>
</div>

<!--<script type="text/javascript">
	$('#tabelmon_wm').dataTable();
</script>-->

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


