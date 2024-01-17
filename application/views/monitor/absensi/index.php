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
			Absensi
		</li>
	</ul><!--.breadcrumb-->
</div>

<div class="page-content">
	<div class="row-fluid">
		<div class="span12">
			<div class="judul">
				Monitor Absensi Tenaga Kerja
			</div>
			
			<div class="page-header">
				<?php echo form_open('monitor/absensi',array('id'=>'formMonAbsensi' ,'class'=>'form-inline')); ?>
				<?php echo form_fieldset();?>				
				
				<div class="input-append date">
					<input type="text" name="txtTanggal" class="input-small input-mask-date" 
						   value="<?php echo set_value('txtTanggal', $tanggal);?>">
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
					$extra_shift = 'class="chzn-select" id="dropdownShift" data-placeholder="Shift" style="width: 100px"';
					$option_shift[''] = '';
					foreach($cboshift as $r):
						$option_shift[$r->IDShift] = $r->NamaShift;
					endforeach;
					echo form_dropdown('txtShift', $option_shift, $idshift, $extra_shift);
				?>
				
				<?php
					$extra_kerja = 'class="chzn-select" name="txtPekerjaan" id="dropdownPekerjaan" data-placeholder="Pilih Pekerjaan" style="width: 130px"';
					$option_kerja[''] = '';					
					$option_kerja['2'] = 'SHELLER';
					$option_kerja['3'] = 'PARER';					
					echo form_dropdown('txtPekerjaan', $option_kerja, $idpekerjaan, $extra_kerja);
				?>
				
				<button id="btnProses" class="btn btn-danger btn-small" type="submit"><i class="icon-refresh"></i> Refresh</button>

				<?php echo form_fieldset_close();?>				
				<?php echo validation_errors() ? "<br/>".validation_errors() : '' ;?>
				<?php echo form_close(); ?>
			</div>
			
			<div class="widget-box transparent">
				<div class="widget-header widget-header-flat">
					<h4 class="lighter">
						<i class="icon-calendar-empty"></i>
						Monitor Kehadiran Tenaga Kerja <?php echo 'Tanggal '.$tanggal;?>
					</h4>					
				</div>
				
				<div class="widget-body">
					<div class="widget-main no-padding">
						<div class="table-wrapper">
							<div class="scrollable">
								<table id="tabelabsensi" class="table table-bordered table-condensed">
									<thead>
										<tr>
											<th style="width: 30px" class="center">
												<i class="icon-caret-right blue"></i>
												<span class="blue center">No</span>
											</th>
											<th>
												<i class="icon-caret-right blue"></i>
												<span class="blue">Nama</span>
											</th>
											<th class="center" style="width: 70px">
												<i class="icon-caret-right blue"></i>
												<span class="blue">NIK</span>
											</th>
											<th>
												<i class="icon-caret-right blue"></i>
												<span class="blue">Pekerjaan</span>
											</th>
											<th class="center" style="width: 50px">
												<i class="icon-caret-right blue"></i>
												<span class="blue">Line</span>
											</th>
											<th style="width: 50px" class="center">
												<i class="icon-caret-right blue"></i>
												<span class="blue">Mesin</span>
											</th>
											<th class="left">
												<i class="icon-caret-right blue"></i>
												<span class="blue">Status Absensi</span>
											</th>
											<th>
												<i class="icon-caret-right blue"></i>
												<span class="blue">Keterangan</span>
											</th>
										</tr>
									</thead>
									<tbody>
										<?php
										if (is_null($record)){
											echo '<tr>';
											echo '<td colspan=7><h5>'.$message.'</h5></td>';
											echo '</tr>';
										} else {
											$i=0;
											foreach ($record as $r){
												$i++;
												
												if ($r->Absensi === 'M'){
													$kolommesin = '<td class="center"><span class="badge badge-success">'.$r->NomorMesin.'</span></td>';
													$kolomabsen = '<td class="left"><span class="badge badge-success">'.$r->Absensi.'</span> '.$r->StatusAbsensi.'</td>';
												} else {
													$kolommesin = '<td class="center"><span class="badge badge-important">-</span></td>';
													$kolomabsen = '<td class="left"><span class="badge badge-important">'.$r->Absensi.'</span> '.$r->StatusAbsensi.'</td>';
												}
												
												echo "<tr>
													<td class='center'>".$i."</td>
													<td class='bolder'>".$r->Nama."</td>
													<td class='center'>".$r->Nik."</td>
													<td class='left'>".$r->Pekerjaan."</td>
													<td class='center'>".$r->NamaLine."</td>"
													.$kolommesin
													.$kolomabsen.
													"<td class='center'>".$r->Keterangan."</td>
													</tr>";
											}
											
											if ($i === 0){
												echo '<tr>';
												echo '<td colspan=7><h5>'.$message.'</h5></td>';
												echo '</tr>';
											}
										}
										?>
									</tbody>
								</table>
							</div>
						</div>
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