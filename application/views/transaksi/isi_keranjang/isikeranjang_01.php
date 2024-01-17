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
		<a href="<?php echo site_url('transaksi/proses_isi_selesai');?>" class="btn btn-danger btn-small">
			<i class="icon-ok"></i> Selesai
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
							</li>

							<?php
								};
							?>
						</ul>
						
						<div class="tab-content">
							<?php				
								for ($i = $nomesinawal; $i <= $nomesinakhir; $i++){
									
									if (number_format($i) === number_format($mesinaktif)){
										echo '<div id="mesin'.$i.'" class="tab-pane in active">';
									} else {
										echo '<div id="mesin'.$i.'" class="tab-pane">';
									}
									
									echo '<div class="table-header">MESIN '.$i.'</div>';
							?>
							
							<div class="row-fluid">
								<div class="span12">
									<table id="tabelMesin<?php echo $i;?>" class="table table-bordered table-condensed table-hover">
										<thead>
											<tr>
												<th>&nbsp;</th>
												<th class="center">Keranjang 1</th>
												<th class="center">Keranjang 2</th>
												<th style="width: 120px">&nbsp;</th>
											</tr>
										</thead>
										<tbody>
											<?php
											$isiawal1 = '';
											$isiawal2 = '';
											$totkrj1 = 0;
											$totkrj2 = 0;
											
											$headerid_sebelum = $this->m_trn_isikeranjang->get_header_sebelum($headerid, $idline);
											if ($headerid_sebelum > 0){
												$record_awal = $this->m_trn_isikeranjang->get_isiawal($headerid_sebelum)->result();
												
												foreach ($record_awal as $ri){
													if (number_format($ri->NomorMesin) === number_format($i)){
														$isiawal1 = (!is_null($ri->IsiAwal1)) ? $ri->IsiAwal1: '';
														$isiawal2 = (!is_null($ri->IsiAwal2)) ? $ri->IsiAwal2: '';
													}
												}
											} else {
												$isiawal1 = 0;
												$isiawal2 = 0;
											}
											?>
											<tr class="red  bigger-120">
												<td class="middle"><strong> ISI AWAL </strong></td>
												<td class="right middle"><?php echo $isiawal1;?></td>
												<td class="right middle"><?php echo $isiawal2;?></td>
												<td></td>
											</tr>
											
											<?php
											
											for ($t = 1; $t<=5; $t++){
												$Krj1 = '';
												$Krj2 = '';
												
												echo '<tr class="blue bigger-120"><td class="middle"><strong> T'.$t.' </strong></td>';
												foreach ($record_tambah as $rt) {													
													if (number_format($rt->NomorMesin) === number_format($i)){
														if ($rt->UrutanTambah === $t){															
															$Krj1 = (!is_null($rt->Krj1)) ? $rt->Krj1: '';
															$Krj2 = (!is_null($rt->Krj2)) ? $rt->Krj2: '';
															$urut = $rt->UrutanTambah;
														}
													}
												}
												
												$totkrj1 = $totkrj1 + $Krj1;
												$totkrj2 = $totkrj2 + $Krj2;
												
												echo '<td class="right middle">'.$Krj1.'</td>';
												echo '<td class="right middle">'.$Krj2.'</td>';
												
												if($Krj1 === '' && $Krj2 === ''){
													echo '<td class="center">
														<a href="pengisian_keranjang/tambah/'.$i.'" class="btn btn-medium btn-block btn-primary"
															data-toggle="remote-modal" data-target="#modaltambah" title="Tambah">
															<i class="icon-plus bigger-150"></i>															
														</a></td>';
													break;
												} else {
													echo '<td class="center">
															<a href="pengisian_keranjang/edit/'.$urut.'" class="btn btn-medium btn-warning"
																data-toggle="remote-modal" data-target="#modaledit" title="Edit">
																<i class="icon-pencil bigger-120"></i>
															</a>
															<a href="#" id="btnDelete" urutanke="'.$urut.'" nomormesin="'.$i.'"
																class="btn btn-medium btn-danger hapus" title="Hapus">
																<i class="icon-trash bigger-130"></i>
															</a>
														</td>';
												}
												
												echo '</tr>';
											}
											
											$sisa1 = '';
											$sisa2 = '';
											foreach ($record_sisa as $rs){
												if (number_format($rs->NomorMesin) === number_format($i)){
													$sisa1 = (!is_null($rs->Sisa1)) ? $rs->Sisa1: '';
													$sisa2 = (!is_null($rs->Sisa2)) ? $rs->Sisa2: '';
												}
											}
											
											?>

											<tr class="purple  bigger-120">
												<td class="middle"><strong> SISA </strong></td>
												<td class="right middle"><?php echo $sisa1;?></td>
												<td class="right middle"><?php echo $sisa2;?></td>
												<td class="center">
												<?php
													if($sisa1 === '' && $sisa2 === ''){
														echo '<a href="pengisian_keranjang/sisa/'.$i.'" class="btn btn-block btn-medium btn-purple"
															    data-toggle="remote-modal" data-target="#modalsisa" title="Input Sisa">
																<i class="icon-share bigger-120"></i>																
															  </a>';
													} else {
														echo '<a href="pengisian_keranjang/editsisa" class="btn btn-medium btn-warning"
																data-toggle="remote-modal" data-target="#modaledit" title="Edit Sisa">
																<i class="icon-pencil bigger-120"></i>																
															</a>
															<a href="#" id="btnDelete" nomormesin="'.$i.'"
																class="btn btn-medium btn-danger hapussisa" title="Hapus Sisa">
																<i class="icon-trash bigger-120"></i>
															</a>';
													}
												?>
												</td>
											</tr>
										</tbody>
										<tfoot>
											<?php 
											$totpakai1 = $isiawal1 + $totkrj1 - $sisa1;
											$totpakai2 = $isiawal2 + $totkrj2 - $sisa2;
											?>
											<tr class="green  bigger-120">
												<td class="middle"><strong> TOTAL PAKAI </strong></td>
												<td class="right middle"><?php echo $totpakai1;?></td>
												<td class="right middle"><?php echo $totpakai2;?></td>
												<td>&nbsp;</td>
											</tr>
										</tfoot>
									</table>

								</div>
							</div>
							
							<div class="well">
								<a href="#" class="btn btn-small btn-success">
									<i class="icon-refresh"></i> ISI KERANJANG UNTUK SHIFT SELANJUTNYA
								</a>
							</div>
							
							<?php
									echo '</div>';
								}
							?>
						</div><!--/.tab-content-->
						
					</div><!--/.tabbable-->
				</div><!--/.span12-->
			</div><!--/.row-fluid-->
			
		</div><!--/.span12-->
	</div><!--/.row-fluid-->
</div>

<div class="modal fade" id="modaltambah" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<!--Modal Tambah Goes Here-->
</div>

<div class="modal fade" id="modalsisa" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<!--Modal Sisa Goes Here-->
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