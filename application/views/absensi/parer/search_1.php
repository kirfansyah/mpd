<div class="breadcrumbs" id="breadcrumbs">
	<ul class="breadcrumb">
		<li>
			<i class="icon-home"></i>
			<a href="<?php echo site_url('home');?>">Home</a>
			<span class="divider"><i class="icon-angle-right"></i></span>
		</li>
		
		<li>
			<a href="#">Absensi</a>
			<span class="divider">
				<i class="icon-angle-right"></i>
			</span>
		</li>
		
		<li>
			<a href="<?php echo site_url('absensi/'.$pekerjaan);?>"><?php echo ucfirst($pekerjaan);?></a>
			<span class="divider">
				<i class="icon-angle-right"></i>
			</span>
		</li>
		
		<li>
			<a href="<?php echo site_url('absensi/'.$page_asal.'/set');?>">Atur Urutan Tenaga Kerja</a>
			<span class="divider">
				<i class="icon-angle-right"></i>
			</span>
		</li>
		
		<li class="active">
			Pencarian Tenaga Kerja
		</li>
	</ul><!--.breadcrumb-->
</div>

<div class="page-content">
	<div class="row-fluid">
		<div class="span8 offset2">
			<div class="widget-box">
				<div class="widget-header">					
					<h5 class="smaller"><i class="icon-search"></i> Pencarian Tenaga Kerja</h5>					
				</div>
				
				<div class="widget-body">
					<div class="widget-main no-padding">
						
						<?php 
						echo form_open('absensi/parer/search/'.$nomormesin.'/'.$posisi,array('id'=>'formCariTK' ,'class'=>'form-horizontal')); 
						echo form_fieldset();
						?>

						<div class="control-group">
							<label class="control-label" for="dropdownPekerjaan">Pekerjaan</label>
							<div class="controls">
							<?php
								$extra_pekerjaan = 'class="chzn-select" id="dropdownPekerjaan" data-placeholder="Pilih Pekerjaan" ';
//								$option_pekerjaan[''] = '';
								foreach($cbopekerjaan as $r):
									$option_pekerjaan[$r->IDPekerjaan] = $r->Pekerjaan;
								endforeach;
								echo form_dropdown('txtPekerjaan', $option_pekerjaan, $selectpekerjaan, $extra_pekerjaan);
							?>	
								<span class="help-inline red">Pekerjaan Wajib Diisi!</span>
							</div>
						</div>

						<div class="control-group">
							<label class="control-label" for="dropdownShift">Shift</label>
							<div class="controls">
							<?php
								$extra_shift = 'class="chzn-select" id="dropdownShift" data-placeholder="Pilih Shift" ';
								$option_shift[''] = '';
								foreach($cboshift as $r):
									$option_shift[$r->IDShift] = $r->IDShift;
								endforeach;
								echo form_dropdown('txtShift', $option_shift, $idshift, $extra_shift);
							?>
							</div>
						</div>
						
						<div class="control-group">
							<label class="control-label" for="dropdownLine">Line</label>
							<div class="controls">
							<?php
								$extra_line = 'class="chzn-select" id="dropdownLine" data-placeholder="Pilih Line"';
								$option_line[''] = '';
								foreach($cboline as $r):
									$option_line[$r->IDLine] = $r->NamaLine;
								endforeach;
								echo form_dropdown('txtLine', $option_line, $idline, $extra_line);
							?>
							</div>
						</div>
<!--						
						<div class="control-group">
							<label class="control-label" for="dropdownPerusahaan">Perusahaan</label>
							<div class="controls">
							<?php
//								$extra_perusahaan = 'class="chzn-select" id="dropdownPerusahaan" data-placeholder="Pilih Perusahaan"';
//								$option_perusahaan[''] = '';
//								foreach($cboperusahaan as $r):
//									$option_perusahaan[$r->IDPerusahaan] = $r->Perusahaan;
//								endforeach;
//								echo form_dropdown('txtPerusahaan', $option_perusahaan, $idperusahaan, $extra_perusahaan);
							?>
							</div>
						</div>
						-->
						<div class="control-group">
							<label class="control-label" for="dropdownPemborong">Pemborong</label>
							<div class="controls">
							<?php
								$extra_pemborong = 'class="chzn-select" id="dropdownPemborong" data-placeholder="Pilih Pemborong"';
								$option_pemborong[''] = '';
								foreach($cbopemborong as $r):
									$option_pemborong[$r->IDPemborong] = $r->Pemborong;
								endforeach;
								echo form_dropdown('txtPemborong', $option_pemborong, $idpemborong, $extra_pemborong);
							?>
							</div>
						</div>
						
						<div class="control-group">
							<label class="control-label" for="inputNama">Nama</label>
							<div class="controls">
								<input type="text" name="txtNama" id="inputNama" value="<?php echo $searchnama;?>">
							</div>
						</div>
						
						<div class="control-group">
							<label class="control-label" for="inputNIK">NIK</label>
							<div class="controls">
								<input type="text" name="txtNIK" id="inputNIK" value="<?php echo $searchnik;?>">
							</div>
						</div>
												
						<?php echo form_fieldset_close();?>
						<?php // echo validation_errors() ? "<br/>".validation_errors() : '' ;?>
												
						<div class="form-actions center">
							<button id="btnCari" class="btn btn-danger btn-medium" type="submit">
								<i class="icon-search"></i> Cari
							</button>
						</div>
						
						<?php echo form_close(); ?>
						
						<div class="space-10"></div>
						
						
						<div id="hasilcari">
							<?php
							echo form_open('absensi/parer/simpanpilih/'.$nomormesin.'/'.$posisi,array('id'=>'formPilih' ,'class'=>'form-horizontal')); 
							echo form_fieldset();
							?>
							<div class="table-header">Hasil Pencarian</div>
							
							<table id="tabel_search_result" class="table table-bordered table-hover">
								<thead>
									<tr>
										<th class="center">No</th>
										<td></td>
										<th class="center">Nama</th>
										<th class="center">NIK</th>
										<th class="center">Shift</th>
										<th class="center">Line</th>
										<th class="center">Pekerjaan</th>
										<th class="center">Pemborong</th>
									</tr>
								</thead>
								<tbody>
									<?php 									
									if (isset($search_result)){
										$no = 1;
										foreach($search_result as $row):
										?>
										
										<tr>
											<td class="center"><?php echo $no++;?></td>
											<td class="center">
												<label>
													<input name="radioPilih" type="radio" value="<?php echo $row->FixNo;?>"/>
													<span class="lbl"></span>													
												</label>
											</td>
											<td><?php echo $row->Nama;?></td>
											<td class="center"><?php echo $row->Nik;?></td>
											<td class="center"><?php echo $row->IDShift;?></td>
											<td>
												<?php echo $row->NamaLine;?>
												<input name="txtPilihIDLine" type="hidden" value="<?php echo $row->IDLine;?>" />
											</td>
											<td>
												<?php echo $row->Pekerjaan;?>
												<input name="txtPilihIDPekerjaan" type="hidden" value="<?php echo $row->IDPekerjaan;?>" />
											</td>
											<td>
												<?php echo $row->Pemborong;?>
											</td>
										</tr>
									<?php 
									endforeach; 
									};
									?>
								</tbody>
							</table>
							
							<div class="space-4"></div>
							
							<?php echo form_fieldset_close();?>	
								
							<div class="row-fluid inline">
								<div class="span6">
									<button name="btnSimpanPilih" class="btn btn-success no-border btn-block" type="submit">
										<i class="icon-ok"></i>
										PILIH & SIMPAN
									</button>
								</div>
								<div class="span6">
									<a href="<?php echo site_url('absensi/'.$page_asal.'/set');?>" class="btn btn-default no-border btn-block">
										<i class="icon-repeat"></i>
										KEMBALI
									</a>
								</div>
							</div>
							
							<?php echo form_close(); ?>
						</div>
						
					</div>
										
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	$('.chzn-select').chosen({		
		allow_single_deselect: true		
	});
	
	$('#tabel_search_result').dataTable({
		"oLanguage": {
			"sSearch" : "Filter"
		}
	});
</script>