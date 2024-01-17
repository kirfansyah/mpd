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
			Laporan Hasil
		</li>
	</ul><!--.breadcrumb-->
</div>


<div class="page-content">
	<div class="row-fluid">
		<div class="span12">
			<div class="judul">
				<i class="icon-table middle"></i>  Monitor Laporan Hasil
			</div>
			
			<div class="page-header">
				<?php echo form_open('#',array('id'=>'form_laphasil' ,'class'=>'form-inline')); ?>
				<?php echo form_fieldset();?>

				<div class="input-append date">
					<input type="text" name="txtTanggal" class="input-small input-mask-date" id="inputTanggal"
						   value="<?php echo set_value('txtTanggal', $tanggal);?>">
					<span class="add-on">
						<i class="icon-calendar"></i>
					</span>					
				</div>

				<?php
					$extra_shift = 'class="chzn-select" id="dropdownShift" data-placeholder="Pilih Shift" style="width: 120px"';
					$option_shift[''] = '';
					foreach($cboshift as $r):
						$option_shift[$r->IDShift] = $r->NamaShift;
					endforeach;
					echo form_dropdown('txtShift', $option_shift, $idshift, $extra_shift);
				?>

				<?php
					$extra_jam = 'class="chzn-select" name="txtJamKerja" id="dropdownJamKerja" data-placeholder="Pilih Jam Kerja" style="width: 140px"';
					$option_jam[''] = '';
					foreach($cbojamkerja as $r):
						$option_jam[$r->IDJamKerja] = $r->JamKerja;
					endforeach;
					echo form_dropdown('txtJamKerja', $option_jam, $idjamkerja, $extra_jam);
				?>

				<button id="btnRefreshHasil" class="btn btn-danger btn-small" type="submit">
					<i class="icon-refresh"></i> Refresh
				</button>

				<?php echo form_fieldset_close();?>
				<?php 
					if (validation_errors()){
						echo "<br/>".validation_errors();
					}
				?>
				<?php echo form_close(); ?>
			</div>
			
			<div id="accordhasil" class="accordion">
				<div class="accordion-group">
					<div class="accordion-heading">
						<a href="#collapseWhiteMeat" data-parent="#accordhasil" data-toggle="collapse" class="accordion-toggle collapsed">
							WHITE MEAT
						</a>
					</div>

					<div class="accordion-body collapse" id="collapseWhiteMeat">
						<div class="accordion-inner">
							<div class="table-wrapper">
								<div class="scrollable">
									<div id="lap_wm">	
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
											
											<tfoot>
												<?php

												echo '<tr>';
												echo '<td class="center">TOTAL</td>';

												foreach ($groupline as $gl){
													echo '<td class="right"></td>';
												}

												echo '</tr>';

												?>
											</tfoot>

											<tbody>
												<?php
												for($i=1; $i<=$totalmesinmax; $i++){
													echo '<tr>';
													echo '<td class="center">'.$i.'</td>';
													
													foreach ($groupline as $gl){
														echo '<td>&nbsp;</td>';
													}
													
													echo '</tr>';
												}
												?>
											</tbody>

										</table>
									</div>

								</div><!--/.scrollable-->
							</div>
						</div>
					</div>
				</div>
				
				<div class="accordion-group">
					<div class="accordion-heading">
						<a href="#collapseAirKelapa" data-parent="#accordhasil" data-toggle="collapse" class="accordion-toggle collapsed">
							AIR KELAPA
						</a>
					</div>

					<div class="accordion-body collapse" id="collapseAirKelapa">
						<div class="accordion-inner">
							<div class="table-wrapper">
								<div class="scrollable">
									<div id="lap_ak">	
										<?php
										$jumgrupline = 0;
										$showline = '';
										foreach ($groupline as $r){
											$jumgrupline++;
											$showline .= '<th class="center">'.$r->GroupLine.'</th>';
										}
										?>

										<table id="tablaphasil_ak" class="table table-bordered table-condensed">

											<thead>
												<tr>
													<th class="center" rowspan="2">Mesin</th>
													<th class="center" colspan="<?php echo $jumgrupline;?>">Line</th>
												</tr>
												<tr>
													<?php echo $showline;?>
												</tr>
											</thead>
											
											<tfoot>
												<?php

												echo '<tr>';
												echo '<td class="center">TOTAL</td>';

												foreach ($groupline as $gl){
													echo '<td class="right"></td>';
												}

												echo '</tr>';

												?>
											</tfoot>
											
											<tbody>
												<?php
												for($i=1; $i<=$totalmesinmax;$i++){
													echo '<tr>';
													echo '<td class="center">'.$i.'</td>';
													
													foreach ($groupline as $gl){
														echo '<td>&nbsp;</td>';
													}
													
													echo '</tr>';
												}
												?>
											</tbody>

										</table>
									</div>

								</div><!--/.scrollable-->
							</div>
						</div>
					</div>
				</div>
				
				<div class="accordion-group">
					<div class="accordion-heading">
						<a href="#collapseCungkil" data-parent="#accordhasil" data-toggle="collapse" class="accordion-toggle collapsed">
							KELAPA CUNGKIL
						</a>
					</div>

					<div class="accordion-body collapse" id="collapseCungkil">
						<div class="accordion-inner">
							<div class="table-wrapper">
								<div class="scrollable">
									<div id="lap_kc">	
										<?php
										$jumgrupline = 0;
										$showline = '';
										foreach ($groupline as $r){
											$jumgrupline++;
											$showline .= '<th class="center">'.$r->GroupLine.'</th>';
										}
										?>

										<table id="tablaphasil_kc" class="table tabel-hasil table-bordered table-condensed">

											<thead>
												<tr>
													<th class="center" rowspan="2">Mesin</th>
													<th class="center" colspan="<?php echo $jumgrupline;?>">Line</th>
												</tr>
												<tr>
													<?php echo $showline;?>
												</tr>
											</thead>
											
											<tfoot>
												<?php

												echo '<tr>';
												echo '<td class="center">TOTAL</td>';

												foreach ($groupline as $gl){
													echo '<td class="right"></td>';
												}

												echo '</tr>';

												?>
											</tfoot>
											
											<tbody>
												<?php
												for($i=1; $i<=$totalmesinmax;$i++){
													echo '<tr>';
													echo '<td class="center">'.$i.'</td>';
													
													foreach ($groupline as $gl){
														echo '<td>&nbsp;</td>';
													}
													
													echo '</tr>';
												}
												?>
											</tbody>

										</table>
									</div>

								</div><!--/.scrollable-->
							</div>
						</div>
					</div>
				</div>
			</div>
			
			
		</div><!--/.span12-->
	</div><!--/.row-fluid-->
</div><!--/.page-content-->

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
	
	$("#btnRefreshHasil").click(function(){
		var tgl = $("#inputTanggal").val();
		var shift = $("#dropdownShift").val();
		var jamkerja = $("#dropdownJamKerja").val();
		
		if ((tgl !== "") && (shift !== "") && (jamkerja !== ""))		
		{
			var params = {txtTanggal:tgl, txtShift:shift, txtJamKerja:jamkerja};
			$.ajax({
				type: "POST",
				url : "<?php echo site_url('laporan/hasil_refresh/whitemeat')?>",
				data: params,
				success: function(msg){
					$('#lap_wm').html(msg);
				}
			});
			$.ajax({
				type: "POST",
				url : "<?php echo site_url('laporan/hasil_refresh/airkelapa')?>",
				data: params,
				success: function(msg){
					$('#lap_ak').html(msg);
				}
			});
			$.ajax({
				type: "POST",
				url : "<?php echo site_url('laporan/hasil_refresh/kelapacungkil')?>",
				data: params,
				success: function(msg){
					$('#lap_kc').html(msg);
				}
			});
		}
		
		return false;
	});
</script>

<script type="text/javascript">
	$(document).ajaxStop($.unblockUI);
		$('#btnRefreshHasil').click(function(){
			$.blockUI({			
				message	: '<h5><img src="<?php echo base_url();?>assets/images/Preloader_21.gif" /> Please Wait...</h5>'						
			});
		});
</script>

<style>
	.scrollable {
      float: right;
      width: 100%;
      overflow: scroll;
      overflow-y: hidden;
    }
	
    .table-wrapper {
      overflow: hidden;
      border: 1px solid #428bca;
	  padding: 0;
    }
	
	.tabel-hasil table {
      width: 100%;
	  border: 1px solid #428bca;
	  /*table-layout: fixed;*/
    }
	
/*    
	.pinned {
      width: 30%;
      border-right: 1px solid #ccc;
      float: left;
    }
*/
    thead {
		background: #428bca;
		color: #fff;
		border: none;
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