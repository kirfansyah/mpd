<div class="breadcrumbs" id="breadcrumbs">
	<ul class="breadcrumb">
		<li>
			<i class="icon-home"></i>
			<a href="<?php echo site_url('home');?>">Home</a>
			<span class="divider"><i class="icon-angle-right"></i></span>
		</li>
		
		<li>
			<a href="#">Transaksi</a>
			<span class="divider">
				<i class="icon-angle-right"></i>
			</span>
		</li>
		
		<li>
			<a href="#">Pengisian Keranjang</a>
			<span class="divider">
				<i class="icon-angle-right"></i>
			</span>
		</li>
		
		<li class="active">
			<?php echo $namaline;?>
		</li>
	</ul><!--.breadcrumb-->
</div>

<div class="page-content">
	<h3 class="header smaller lighter blue">		
		<a href="<?php echo site_url('transaksi/proses_isi_selesai');?>" class="btn btn-danger bolder">
			<i class="icon-ok"></i> Selesai
		</a>
		<a href="<?php echo site_url('monitor/pengisian_keranjang');?>" class="btn btn-primary bolder">
			<i class="icon-table"></i> Buka Monitor Pengisian Keranjang
		</a>
		<a href="<?php echo site_url('transaksi/pindahline/keranjang');?>" class="btn btn-success bolder"
			data-toggle="remote-modal" data-target="#modalpindahline" title="Pindah dari line <?php echo $namaline;?>">
			<i class="icon-level-up"></i> Pindah Line
		</a>
	</h3>
	
	<div class="row-fluid">
		<div class="span12">
			<div class="judul">
				Pengisian Keranjang <?php echo $namaline;?> <span class="badge badge-success"> ID Transaksi : <?php echo $headerid;?> </span>
			</div>
			
			<div class="trx-user-info trx-user-info-striped">
				<div class="trx-info-row">
					<div class="trx-info-name"> Tipe Kelapa </div>
					<div class="trx-info-value"> KB A</div>
				</div>
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
					<div class="trx-info-name"> Pelaksana Isi </div>
					<div class="trx-info-value"><?php echo $this->session->userdata('username');?></div>
				</div>
			</div>
			
			<div class="alert alert-info"><i class="icon-h-star"></i> Pastikan informasi diatas sudah benar.</div>
			
			<?php echo $message;?>
			
			<!-- BEGIN CONTENT "MESIN" -->
			
			<div class="row-fluid">
				<div class="span12">
					
					<div class="tabbable tabs-left">
						<ul class="nav nav-tabs" id="tabmesin">
							<?php								
							for ($i = $nomesinawal; $i <= $nomesinakhir; $i++){
								if (number_format($i) === number_format($mesinaktif)){
									echo '<li class="active">';
								} else {
									echo '<li>';
								}
							?>
							
							<a data-toggle="tab" href="#mesin<?php echo $i;?>">	
								<i class="blue icon-maxcdn bigger-120"></i>
								<span class="bigger-120">  <?php echo $i;?></span>									
							</a>
							
							<?php
								echo '</li>';
							}
							?>
						</ul>
						
						<!-- BEGIN "TAB CONTENT" -->
						<div class="tab-content">
							<?php				
								for ($i = $nomesinawal; $i <= $nomesinakhir; $i++){
									
									if (number_format($i) === number_format($mesinaktif)){
										echo '<div id="mesin'.$i.'" class="tab-pane in active">';
									} else {
										echo '<div id="mesin'.$i.'" class="tab-pane">';
									}
									
//									echo '<h4 class="alert alert-danger"><strong>MESIN '.$i.'</strong></h4>'
									echo '<div class="judul"><strong>MESIN '.$i.'</strong></div>';
							?>
							
							<div class="space-6"></div>
							
							<div class="row-fluid"> <!-- ISI AWAL -->
								<div class="span12">
									<div class="widget-container-span">
										<div class="widget-box">
											<div class="widget-header">
												<h5 class="bigger-120 red"><strong>ISI AWAL</strong></h5>

												<?php
													$isiawal1 = 0;
													$isiawal2 = 0;
													$sisa1 = 0;
													$sisa2 = 0;
													$totkrj1 = 0;
													$totkrj2 = 0;

													$headerid_sebelum = $this->m_trn_isikeranjang->get_header_sebelum($headerid, $idline);
													if ($headerid_sebelum > 0){
														$record_awal = $this->m_trn_isikeranjang->get_isiawal($headerid_sebelum)->result();

														foreach ($record_awal as $ri){
															if (number_format($ri->NomorMesin) === number_format($i)){
																$isiawal1 = (!is_null($ri->IsiAwal1)) ? $ri->IsiAwal1: 0;
																$isiawal2 = (!is_null($ri->IsiAwal2)) ? $ri->IsiAwal2: 0;
															}
														}
													} else {
														$isiawal1 = 0;
														$isiawal2 = 0;
													}
												?>

												<div class="widget-toolbar">
													<a href="#" data-action="collapse">
														<i class="icon-chevron-up"></i>
													</a>
													<!--<span class="badge badge-important">TOTAL</span>-->
												</div>
											</div>

											<div class="widget-body">
												<div class="widget-main padding-6">
													<!--<div class="alert alert-info"> Hello World! </div>-->
													<div class="row-fluid">
														<div class="span6">
															<div class="trx-user-info trx-user-info-striped">
																<div class="trx-info-row bigger-140">
																	<div class="trx-info-name"> Keranjang 1 </div>
																	<div class="trx-info-value"> <?php echo $isiawal1;?></div>
																</div>														
															</div>
														</div>

														<div class="span6">
															<div class="trx-user-info trx-user-info-striped">
																<div class="trx-info-row bigger-140">
																	<div class="trx-info-name"> Keranjang 2 </div>
																	<div class="trx-info-value"> <?php echo $isiawal2;?></div>
																</div>														
															</div>
														</div>
													</div>

												</div>
											</div>
										</div>
									</div> 
								</div>
							</div>
									
							<div class="space-10"></div>
							
							<!--<form action="transaksi/simpan_keranjang/tambah" id="formTambahKrj<?php echo $i;?>" name="tambah_mesin<?php echo $i;?>" class="form-horizontal" method="post">-->
							<?php
							echo form_open('transaksi/simpan_keranjang/tambah', array('id'=>'formTambahKrj'.$i ,'class'=>'form-horizontal', 'name'=>'tambah_mesin'.$i));
							echo form_fieldset();
							echo form_hidden('txtTambahNoMesin', $i);
							?>
							
							<div class="row-fluid"> <!-- TAMBAH -->
								<div class="span12">
									<div class="widget-container-span">
										<div class="widget-box">
											<div class="widget-header">
												<h5 class="bigger-120 blue"> <strong>TAMBAH</strong> </h5>
												
												<div class="widget-toolbar">
													<a href="#" data-action="collapse">
														<i class="icon-chevron-up"></i>
													</a>													
												</div>
											</div>
											
											<div class="widget-body">
												<div class="widget-main no-padding">
													<table class="table table-striped table-condensed table-hover">
														<thead>
															<tr class="bigger-120">
																<th class="center middle" style="width: 50px">#</th>
																<th class="center middle">Keranjang 1</th>
																<th class="center middle">Keranjang 2</th>
																<th style="width: 120px">&nbsp;</th>
															</tr>
														</thead>
														<tbody>
															<?php
															$urutanakhir = $this->m_trn_isikeranjang->get_urutan_terakhir($headerid, $i);

															for ($t = 1; $t<=5; $t++){
																$Krj1 = '';
																$Krj2 = '';
																
																echo '<tr class="blue bigger-120"><td class="center middle">';
																echo form_hidden('txtUrutanTambah', $t);
																echo '<strong> T'.$t.' </strong></td>';
																foreach ($record_tambah as $rt) {													
																	if (number_format($rt->NomorMesin) === number_format($i)){
																		if ($rt->UrutanTambah === $t){															
																			$Krj1 = (!is_null($rt->Krj1)) ? $rt->Krj1: '';
																			$Krj2 = (!is_null($rt->Krj2)) ? $rt->Krj2: '';
//																			$idkrj1 = (!is_null($rt->IDKrjHistory)) ? $rt->IDKrjHistory: '';
																			$urut = $rt->UrutanTambah;
																		}
																	}
																}

																$totkrj1 = $totkrj1 + $Krj1;
																$totkrj2 = $totkrj2 + $Krj2;
																
																if($Krj1 === '' && $Krj2 === ''){
																	echo '<td class="center middle">
																			<input name="txtTambahIsi1" id="inputTambahIsi1" type="text" class="input input-small text-right numeric" placeholder="0"/>
																		  </td>';
																	
																	echo '<td class="center middle">
																			<input name="txtTambahIsi2" id="inputTambahIsi2" type="text" class="input input-small text-right numeric" placeholder="0"/>
																		  </td>';
																	
																	echo '<td class="center">
																			<button id="btnSimpanTambah'.$i.'" name="SimpanTambahMesin" class="btn btn-block btn-primary btn-medium btnSimpan" type="submit">
																				<i class="icon-save"></i> SIMPAN
																			</button>																		
																		  </td>';
																	break;
																} else {
																	if ($Krj1 > 0){
																		$idkrj = $this->m_trn_isikeranjang->get_idkrjhistory($headerid, $i, $t, 1);
																	}
																	
																	if ($Krj2 > 0){
																		$idkrj = $this->m_trn_isikeranjang->get_idkrjhistory($headerid, $i, $t, 2);
																	}
																	
																	echo '<td class="center middle"><strong>'.$Krj1.'</strong></td>';
																	echo '<td class="center middle"><strong>'.$Krj2.'</strong></td>';
																	echo '<td class="center">';
																	
																	if ($t < $urutanakhir){
																		echo '  <a href="'.base_url().'transaksi/pengisian_keranjang/edittambah/'.$i.'/'.$t.'/?krj1='.$Krj1.'&krj2='.$Krj2.'" class="btn btn-medium btn-warning"
																				data-toggle="remote-modal" data-target="#modaledittambah" title="Edit">
																				<i class="icon-pencil bigger-120"></i>
																				</a>';
																		echo '  <label class="btn btn-medium btn-default disabled"><i class="icon-trash bigger-130" ></label>';
																	} else {
																		echo '  <a href="'.base_url().'transaksi/pengisian_keranjang/edittambah/'.$i.'/'.$t.'/?krj1='.$Krj1.'&krj2='.$Krj2.'" class="btn btn-medium btn-warning"
																				data-toggle="remote-modal" data-target="#modaledittambah" title="Edit">
																				<i class="icon-pencil bigger-120"></i>
																				</a>';
																		echo '	<a href="#" id="btnDelete" idkrj="'.$idkrj.'" nomormesin="'.$i.'"
																					class="btn btn-medium btn-danger hapustambah" title="Hapus">
																					<i class="icon-trash bigger-130"></i>
																				</a>';
																	};
																	echo '</td>';
																	
																}
																
																echo '</tr>';
															}

															?>
														</tbody>
														<tfoot>
															<tr class="green bigger-140">
																<td class="center middle"><strong>TOTAL</strong></td>
																<td class="center middle"><strong><?php echo $totkrj1;?></strong></td>
																<td class="center middle"><strong><?php echo $totkrj2;?></strong></td>
																<td>&nbsp;</td>
															</tr>
														</tfoot>
													</table>
												</div>
											</div>
												
										</div>
									</div>
								</div>
							</div> <!-- TAMBAH -->

							
							<?php
							echo form_fieldset_close();
							echo form_close();
							?>
							
							<?php
							echo form_open('transaksi/simpan_keranjang/sisa/'.$i, array('id'=>'formSisaKrj'.$i ,'class'=>'form-horizontal', 'name'=>'sisa_mesin'.$i));
							echo form_fieldset();
							?>
							
							<div class="row-fluid"> <!-- SISA -->
								<div class="span12">
									<div class="widget-container-span">
										<div class="widget-box">
											<div class="widget-header">
												<h5 class="bigger-120 purple"> <strong>SISA</strong> </h5>

												<?php
													foreach ($record_sisa as $rs){
														if (number_format($rs->NomorMesin) === number_format($i)){
															$sisa1 = (!is_null($rs->Sisa1)) ? $rs->Sisa1: '';
															$sisa2 = (!is_null($rs->Sisa2)) ? $rs->Sisa2: '';
														}
													}
												?>

												<div class="widget-toolbar">
													<a href="#" data-action="collapse">
														<i class="icon-chevron-up"></i>
													</a>
												</div>
											</div>

											<div class="widget-body">
												<div class="widget-main no-padding">
													<table class="table table-striped table-condensed table-hover">
														<thead>
															<tr class="bigger-120">
																<th style="width: 50px">&nbsp;</th>
																<th class="center middle">Keranjang 1</th>
																<th class="center middle">Keranjang 2</th>
																<th class="center middle" style="width: 120px">&nbsp;</th>
															</tr>
														</thead>
														<tbody>
															<?php
															echo '<tr class="bigger-120">';
															echo '<td>&nbsp;</td>';
															if ($sisa1 === 0 && $sisa2 === 0){
																$show_isilanjut = 0;
																echo '<td class="center middle">
																		<input type="text" name="txtSisa1" placeholder="0" class="input input-small text-right numeric" />
																	  </td>';
																echo '<td class="center middle"><input type="text" name="txtSisa2" placeholder="0" class="input input-small text-right numeric" /></td>';
																echo '<td class="center middle">
																		<button id="btnSimpanSisa'.$i.'" name="SimpanSisaMesin'.$i.'" class="btn btn-block btn-purple btn-medium btnSimpan" type="submit">
																			<i class="icon-save"></i> SIMPAN
																		</button>
																	  </td>';
																
															} else {
																$show_isilanjut = 1;
																if ($sisa1 > 0){
																	$idsisa = $this->m_trn_isikeranjang->get_idsisahistory($headerid, $i, 1);
																}

																if ($sisa2 > 0){
																	$idsisa = $this->m_trn_isikeranjang->get_idsisahistory($headerid, $i, 2);
																}
																
																echo '<td class="center middle">'.$sisa1.'</td>';
																echo '<td class="center middle">'.$sisa2.'</td>';
																echo '<td class="center middle">
																		<a href="pengisian_keranjang/editsisa/'.$i.'/?sisa1='.$sisa1.'&sisa2='.$sisa2.'" class="btn btn-medium btn-warning"
																			data-toggle="remote-modal" data-target="#modaleditsisa" title="Edit Sisa">
																			<i class="icon-pencil bigger-120"></i>
																		</a>
																		<a href="#" id="btnDelete" idsisa="'.$idsisa.'" nomormesin="'.$i.'"
																			class="btn btn-medium btn-danger hapussisa" title="Hapus Sisa">
																			<i class="icon-trash bigger-120"></i>
																		</a>
																	  </td>';
															}
															echo '</tr>';
															?>
														</tbody>
													</table>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div> <!-- SISA -->
							
							<?php
							echo form_fieldset_close();
							echo form_close();
							?>
							
							<?php 
							$totpakai1 = $isiawal1 + $totkrj1 - $sisa1;
							$totpakai2 = $isiawal2 + $totkrj2 - $sisa2;
							?>
							
							<div class="row-fluid"> <!-- TOTAL PAKAI -->
								<div class="span12">
									<div class="widget-container-span ">
										<div class="widget-box">
											<div class="widget-header">
												<h5 class="bigger-120 green"> <strong>TOTAL PAKAI</strong> </h5>
												<div class="widget-toolbar">
													<a href="#" data-action="collapse">
														<i class="icon-chevron-up"></i>
													</a>
												</div>												
											</div>
											
											<div class="widget-body">
												<div class="widget-main padding-6">
													<!--<div class="alert alert-info"> Hello World! </div>-->
													<div class="row-fluid">
														<div class="span6">
															<div class="trx-user-info trx-user-info-striped">
																<div class="trx-info-row bigger-140">
																	<div class="trx-info-name"> Keranjang 1 </div>
																	<div class="trx-info-value"> <?php echo $totpakai1;?></div>
																</div>														
															</div>
														</div>

														<div class="span6">
															<div class="trx-user-info trx-user-info-striped">
																<div class="trx-info-row bigger-140">
																	<div class="trx-info-name"> Keranjang 2 </div>
																	<div class="trx-info-value"> <?php echo $totpakai2;?></div>
																</div>														
															</div>
														</div>
													</div>
													
													<div class="center">
														<div class="infobox infobox-green" style="width: 250px">
															
															<div class="infobox-icon">
																<i class="icon-h-graph-bar2"></i>
															</div>

															<div class="infobox-data">
																<div class="infobox-content bigger-120 green">TOTAL KERANJANG 1 & 2</div>
																<div class="infobox-content bigger-180"><?php echo $totpakai1 + $totpakai2;?></div>
															</div>
														</div>
													</div>

												</div>
											</div>
										</div>
									</div>
								</div>
							</div> <!-- TOTAL PAKAI -->
							
							<?php
//							if ($show_isilanjut === 1){
							?>
							
							<?php
							echo form_open('transaksi/simpan_keranjang/isi', array('id'=>'formIsiKrj'.$i ,'class'=>'form-horizontal', 'name'=>'isi_mesin'.$i));
							echo form_fieldset();
							echo form_hidden('txtIsiNoMesin', $i);
							?>
							
							
							<div class="space-10"></div>
							
							<div class="row-fluid"> <!-- ISI AWAL SHIFT LANJUT -->
								<div class="span12">
									<div class="widget-container-span ">
										<div class="widget-box">
											<div class="widget-header header-color-red2">
												<h5 class="bigger-120"> <strong>ISI KERANJANG UNTUK SHIFT SELANJUTNYA</strong> </h5>
												<div class="widget-toolbar">
													<a href="#" data-action="collapse">
														<i class="icon-chevron-up"></i>
													</a>
												</div>												
											</div>
											
											<div class="widget-body">
												<div class="widget-main no-padding">
													<table class="table table-striped table-condensed table-hover">
														<thead>
															<tr class="bigger-120">
																<th style="width: 50px">&nbsp;</th>
																<th class="center middle">Keranjang 1</th>
																<th class="center middle">Keranjang 2</th>
																<th class="center middle" style="width: 120px">&nbsp;</th>
															</tr>
														</thead>
														
														<tbody>
															
															<?php
															$isi1 = 0;
															$isi2 = 0;
															
															foreach ($record_isilanjut as $ril){
																if (number_format($ril->NomorMesin) === number_format($i)){
																	$isi1 = (!is_null($ril->Sisa1)) ? $ril->Sisa1: '';
																	$isi2 = (!is_null($ril->Sisa2)) ? $ril->Sisa2: '';
																}
															}
															
															echo '<tr class="bigger-120">';
															echo '<td>&nbsp;</td>';
															if ($isi1 === 0 && $isi2 === 0){
																if ($sisa1 > 0){
																	echo '<td class="center middle">'.form_hidden('txtIsi1', '').'</td>';																	
																} else {
																	echo '<td class="center middle">
																			<input type="text" name="txtIsi1" placeholder="0" class="input input-small text-right numeric" />
																		  </td>';
																}
																
																if ($sisa2 > 0){
																	echo '<td class="center middle">'.form_hidden('txtIsi2', '').'</td>';																	
																} else {
																	echo '<td class="center middle">
																			<input type="text" name="txtIsi2" placeholder="0" class="input input-small text-right numeric" />
																		  </td>';
																}
																
																echo '<td class="center middle">
																		<button id="btnSimpanIsi'.$i.'" name="SimpanIsiMesin" class="btn btn-block btn-inverse btn-medium btnSimpan" type="submit">
																			<i class="icon-save"></i> SIMPAN
																		</button>
																	  </td>';
																
															} else {
																if ($isi1 > 0){
																	$idisi = $this->m_trn_isikeranjang->get_idisihistory($headerid, $i, 1);
																}

																if ($isi2 > 0){
																	$idisi = $this->m_trn_isikeranjang->get_idisihistory($headerid, $i, 2);
																}
																echo '<td class="center middle">'.$isi1.'</td>';
																echo '<td class="center middle">'.$isi2.'</td>';
																echo '<td class="center middle">
																		<a href="pengisian_keranjang/editisi/'.$i.'/?isi1='.$isi1.'&isi2='.$isi2.'" class="btn btn-medium btn-warning"
																			data-toggle="remote-modal" data-target="#modaleditisi" title="Edit Isi">
																			<i class="icon-pencil bigger-120"></i>
																		</a>
																		<a href="#" id="btnDelete" idisi="'.$idisi.'" nomormesin="'.$i.'"
																			class="btn btn-medium btn-danger hapusisi" title="Hapus Isi">
																			<i class="icon-trash bigger-120"></i>
																		</a>
																	  </td>';
															}
															echo '</tr>';
															?>
														</tbody>
													</table>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div> <!-- ISI AWAL SHIFT LANJUT -->
							
							<?php
							echo form_fieldset_close();
							echo form_close();
//							}
							?>
							
							<?php
									echo '</div>';
								}
							?>
							
						</div>
						<!-- END "TAB CONTENT" -->
						
					</div>
					
				</div>
			</div>
			
			<!-- END CONTENT "MESIN" -->
			
		</div>
	</div>
</div>

<div class="modal fade" id="modalpindahline" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<!--Modal Edit Tambah Goes Here-->
</div>

<div class="modal fade" id="modaledittambah" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<!--Modal Edit Tambah Goes Here-->
</div>

<div class="modal fade" id="modaleditsisa" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<!--Modal Edit Sisa Goes Here-->
</div>

<div class="modal fade" id="modaleditisi" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<!--Modal Edit Sisa Goes Here-->
</div>

<script src="<?php echo base_url();?>assets/js/bootbox.js"></script>
<script type="text/javascript">
	$(function() {
		$(document).on("click", "[data-toggle='remote-modal']", function (e) {
			e.preventDefault();

			var $this = $(this)
			  , href = $this.attr('href')
			  , $target = $($this.attr('data-target') || (href && href.replace(/.*(?=#[^\s]+$)/, ''))) //strip for ie7
			  , option = $target.data('modal') ? 'toggle' : $.extend({ }, $target.data(), $this.data());

			$target
				.modal(option)
				.load(href)
				.one('hide', function() {
					$this.focus();
				});
			console.log(href);
		});
	});
	
</script>

<script type="text/javascript">
	$('.numeric').numeric({
		decimal	: false,
		negative: false
	});
	// unblock when ajax activity stops 
    $(document).ajaxStop($.unblockUI);
	$('.btnSimpan').click(function(){
		$.blockUI({			
			message	: '<h5><img src="<?php echo base_url();?>assets/images/Preloader_21.gif" /> Proses Simpan...</h5>'						
		});
	});
	
	$('.hapustambah').click(function(){
		var idkrj = $(this).attr("idkrj");
		var nomormesin = $(this).attr("nomormesin");

		bootbox.confirm('Hapus data mesin '+nomormesin+'?',function(result){
			if (result){
				$.ajax({
					url:"<?php echo site_url('transaksi/hapus_keranjang/tambah');?>/"+nomormesin,
					type:"POST",
					data:"idkrj="+idkrj,
					cache:false,
					success:function(){
						return location.href = "<?php echo site_url('transaksi/hapus_keranjang/tambah/berhasil');?>/"+nomormesin;
					},
					error:function(){
						return location.href="<?php echo site_url('transaksi/hapus_keranjang/tambah/gagal');?>/"+nomormesin;
					}
				});
			}else{
				console.log("User declined dialog");
			}
		});
	});
	
	$('.hapussisa').click(function(){
		var idsisa = $(this).attr("idsisa");
		var nomormesin = $(this).attr("nomormesin");

		bootbox.confirm('Hapus data mesin '+nomormesin+'?',function(result){
			if (result){
				$.ajax({
					url:"<?php echo site_url('transaksi/hapus_keranjang/sisa');?>/"+nomormesin,
					type:"POST",
					data:"idsisa="+idsisa,
					cache:false,
					success:function(){
						return location.href = "<?php echo site_url('transaksi/hapus_keranjang/sisa/berhasil');?>/"+nomormesin;
					},
					error:function(){
						return location.href="<?php echo site_url('transaksi/hapus_keranjang/sisa/gagal');?>/"+nomormesin;
					}
				});
			}else{
				console.log("User declined dialog");
			}
		});
	});
	
	$('.hapusisi').click(function(){
		var idisi = $(this).attr("idisi");
		var nomormesin = $(this).attr("nomormesin");

		bootbox.confirm('Hapus data mesin '+nomormesin+'?',function(result){
			if (result){
				$.ajax({
					url:"<?php echo site_url('transaksi/hapus_keranjang/isi');?>/"+nomormesin,
					type:"POST",
					data:"idisi="+idisi,
					cache:false,
					success:function(){
						return location.href = "<?php echo site_url('transaksi/hapus_keranjang/isi/berhasil');?>/"+nomormesin;
					},
					error:function(){
						return location.href="<?php echo site_url('transaksi/hapus_keranjang/isi/gagal');?>/"+nomormesin;
					}
				});
			}else{
				console.log("User declined dialog");
			}
		});
	});
</script>