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
		
		<li class="active">
			Kehadiran
		</li>
	</ul><!--.breadcrumb-->
</div>

<div class="page-content">
	<div class="row-fluid">
		<div class="span12">
			<div class="judul"><i class="icon-bookmark"></i> Pengaturan Urutan <span class="badge badge-success"> ID Transaksi : <?php echo $headerid;?> </span></div>
			
			<div class="trx-user-info trx-user-info-striped">
				
				<div class="trx-info-row">
					<div class="trx-info-name"> Tanggal </div>
					<div class="trx-info-value"><?php echo $tanggal;?></div>
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
					<div class="trx-info-name"> Pengawas </div>
					<div class="trx-info-value"><?php echo $pengawas;?></div>
				</div>
			</div>
			
			<div class="hr hr-30"></div>
			
			<?php 
				echo form_open('absensi/rekap/sheller', array('id'=>'formAbsenSheller', 'class'=>'form-horizontal'));
				echo form_fieldset();
				echo form_hidden('txtHeaderID', $headerid);
			?>
			
			<div class="widget-box transparent">
				<div class="widget-header widget-header-flat">
					<h4 class="lighter">
						<i class="icon-calendar-empty"></i>
						Daftar Kehadiran Tenaga Kerja						
					</h4>
					<?php 
					if ($headerid === 0){
						$disablebtn = 'disabled';						
					} else {
						$disablebtn = '';
					}
					?>
					
					<button class="btn btn-primary <?php echo $disablebtn;?>" type="submit">
						<span class="icon-save"> </span>
						SIMPAN
					</button>
					<a href="#" id="btnComplete" uruthdrid="<?php echo $headerid;?>"
						class="btn btn-danger" <?php echo $disablebtn;?>>
						COMPLETE
					</a>
				</div>
				
				<div class="widget-body">
					<div class="widget-main no-padding">
						<div class="table-wrapper">
							<div class="scrollable">
								<table class="table table-bordered table-condensed">
									<thead>
										<tr>
											<th style="width: 30px" class="center">
												<i class="icon-caret-right blue"></i>
												<span class="blue">No</span>
											</th>
											<th>
												<i class="icon-caret-right blue"></i>
												<span class="blue">Nama</span>
											</th>
											<th>
												<i class="icon-caret-right blue"></i>
												<span class="blue">NIK</span>
											</th>
											<th>
												<i class="icon-caret-right blue"></i>
												<span class="blue">Pekerjaan</span>
											</th>
											<th style="width: 50px" class="center">
												<i class="icon-caret-right blue"></i>
												<span class="blue">Mesin</span>
											</th>
											<th style="width: 225px">
												<i class="icon-caret-right blue"></i>
												<span class="blue">Status</span>
											</th>
											<th>
												<i class="icon-caret-right blue"></i>
												<span class="blue">Keterangan</span>
											</th>
										</tr>
									</thead>
									<tbody>
										<?php
										$i = 1;
										foreach($urutandetail as $r):
											$absensi = $r->Absensi;
										
											echo '<tr>';
											echo '<td class="center">'
													.$i
													.form_hidden('txtDtlID['.$i.']', $r->UrutDtlID)
													.form_hidden('txtFixNo['.$i.']', $r->FixNo)
												 .'</td>';
											echo '<td>'.$r->Nama.'</td>';
											echo '<td>'.$r->Nik.'</td>';
											echo '<td>'.$r->Pekerjaan.'</td>';

											if ($absensi === 'M'){
												echo '<td class="center"><span class="badge badge-success">'.$r->NomorMesin.'</span></td>';
											} else {
												echo '<td class="center"><span class="badge badge-important">-</span></td>';
											}

											echo '<td>';
												if (trim($absensi) === ''){
													$extra_absen = 'id="dropdownAbsen" class="w170" ';
													$option_absen[' '] = '';
													foreach($tipeabsensi as $ra):
														if ($ra->AbbrTipeAbsensi !== 'M' && $ra->AbbrTipeAbsensi !== 'T'){
															$option_absen[$ra->AbbrTipeAbsensi] = $ra->AbbrTipeAbsensi.' ('.$ra->TipeAbsensi.')';
														}
													endforeach;
													echo form_dropdown('txtAbsen['.$i.']', $option_absen, '', $extra_absen);
												} else {
													$extra_absen_M = 'id="dropdownAbsen" class="w170" ';
													// Jika ada status absensi M (Masuk), Hanya ditampilkan status M & T
													if ($absensi === 'M' || $absensi === 'T'){	
														foreach($tipeabsensi as $ra):
															if ($ra->AbbrTipeAbsensi === 'M' || $ra->AbbrTipeAbsensi === 'T'){
																$option_absen_M1[$ra->AbbrTipeAbsensi] = $ra->AbbrTipeAbsensi.' ('.$ra->TipeAbsensi.')';
															}
														endforeach;
														echo form_dropdown('txtAbsen['.$i.']', $option_absen_M1, $absensi, $extra_absen_M);
													} else {
														foreach($tipeabsensi as $ra):
															if ($ra->AbbrTipeAbsensi !== 'M' && $ra->AbbrTipeAbsensi !== 'T'){
																$option_absen_M2[$ra->AbbrTipeAbsensi] = $ra->AbbrTipeAbsensi.' ('.$ra->TipeAbsensi.')';
															}
														endforeach;
														echo form_dropdown('txtAbsen['.$i.']', $option_absen_M2, $absensi, $extra_absen_M);
													}
												}
											echo '</td>';

											echo '<td>';
												$keterangan = $r->Keterangan;
												echo '<input type="text" name="txtKeterangan['.$i.']" class="input input-medium" value="'.$r->Keterangan.'" />';												
											echo '</td>';
											echo '</tr>';
											$i++;
										endforeach;
										?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
				
				
			</div>
			
			<?php
				echo form_fieldset_close();
				echo form_close();
			?>
			
		</div>
	</div>
</div>