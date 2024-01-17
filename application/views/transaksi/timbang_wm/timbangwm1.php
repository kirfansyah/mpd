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
			<a href="#">Timbang White Meat</a>
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
		
		<a href="<?php echo site_url('transaksi/proses_timbangwm_selesai');?>" class="btn btn-danger bolder">
			<i class="icon-ok"></i> Selesai
		</a>
		<a href="<?php echo site_url('monitor/timbang_whitemeat');?>" class="btn btn-primary bolder">
			<i class="icon-table"></i> Buka Monitor White Meat
		</a>
		<a href="<?php echo site_url('transaksi/pindahline/whitemeat');?>" class="btn btn-success bolder"
			data-toggle="remote-modal" data-target="#modalpindahline" title="Pindah dari line <?php echo $namaline;?>">
			<i class="icon-level-up"></i> Pindah Line
		</a>
		
	</h3>
	
	<div class="row-fluid">
		<div class="span12">
			
			<div class="judul">
				Hasil Timbang White Meat <?php echo $namaline;?> <span class="badge badge-success"> ID Transaksi : <?php echo $headerid;?> </span>
			</div>
			
			<div class="trx-user-info trx-user-info-striped">
				<div class="trx-info-row">
					<div class="trx-info-name"> Tipe Kelapa </div>
					<div class="trx-info-value"> KB A </div>
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
					<div class="trx-info-name"> Juru Catat </div>
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
									if (number_format($i) === number_format($mesinaktif)) {
										echo '<li class="active">';
									} else {
										echo '<li>';
									}
									
							?>
								<a data-toggle="tab" href="#mesin<?php echo $i;?>">
									<i class="blue icon-maxcdn bigger-110"></i>
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
									
									echo form_open('transaksi/simpan_timbangwm/'.$i, array('id'=>'formtimbangwm'.$i ,'class'=>'form-horizontal', 'name'=>'mesin'.$i));
									echo form_fieldset();
									
									echo form_hidden('txtNomorMesin', $i);
							?>
							<!--<div id="mesin<?php // echo $i;?>" class="tab-pane">-->
															
								<div class="table-header">MESIN <?php echo $i;?></div>
								<table id="tabelMesin<?php echo $i;?>" class="table table-bordered table-condensed table-hover">
									<thead>
										<tr>
											<th rowspan="2" class="center" style="text-align: center; width: 50px">No</th>
											<th rowspan="2" class="center" style="text-align: center; width: auto">Timbangan</th>
											<th colspan="2" class="center">Potongan</th>
											<th rowspan="2" class="center" style="text-align: center; width: 120px">Actions</th>
										</tr>
										<tr>
											<th class="center">Lain</th>
											<th class="center">Air</th>											
										</tr>
									</thead>
									<tbody>
										<?php
											$param_mesin = array(
												'HasilHeaderID'	=> $headerid,
												'NomorMesin'	=> $i
											);
											
											$detail_mesin = $this->db->get_where('vwOL_TrnHasilTimbangWhiteMeat', $param_mesin);
											$detail_jumlah = $detail_mesin->num_rows();
											$j = 0;
											
											$totTimbangan = 0;
											$totPotLain = 0;
											$totPotAir = 0;
											
											if ($detail_jumlah > 0) {
												foreach ($detail_mesin->result() as $dm) {
													$j = $j+1;
													$totTimbangan = $totTimbangan + $dm->Timbangan;
													$totPotLain = $totPotLain + $dm->PotLain;
													$totPotAir = $totPotAir + $dm->PotAir;
													
													echo '<tr class="bigger-120">';
													echo '<td class="center middle">'.$j.'</td>';
													echo '<td class="center middle">'.floatval($dm->Timbangan).'</td>';
													echo '<td class="center middle">'.floatval($dm->PotLain).'</td>';
													echo '<td class="center middle">'.floatval($dm->PotAir).'</td>';
													echo '<td class="center middle">
															<a href="timbang_whitemeat/edit/'.$dm->HasilTimbangWMID.'" class="btn btn-medium btn-warning"
																data-toggle="remote-modal" data-target="#modaledit" title="Edit">
																<i class="icon-pencil bigger-120"></i>
															</a>
															
															<a href="#" id="btnDelete" detailid="'.$dm->HasilTimbangWMID.'" nomormesin="'.$i.'"
																class="btn btn-medium btn-danger hapus" title="Hapus">
																<i class="icon-trash bigger-120"></i>
															</a>
															</td>';
													echo '</tr>';
												}												
											}
											
										?>
										<tr class="bigger-120">
											<td class="center middle">
												<?php echo $j + 1;?>
											</td>
											
											<td class="center middle">
												<input type="text" name="txtTimbang<?php echo $i;?>" placeholder='0' class="input input-small text-right numeric" />
											</td>
											
											<td class="center middle">
												<input type="text" name="txtPotLain<?php echo $i;?>" placeholder='0' class="input input-mini text-right numeric" />
												
											</td>
											
											<td class="center middle">
												<input type="text" name="txtPotAir<?php echo $i;?>" placeholder='0' class="input input-mini text-right numeric" />
											</td>
											
											<td class="center middle">
												<button id="btnSimpan<?php echo $i;?>" name="SimpanMesin<?php echo $i;?>" class="btn btn-block btn-medium btn-primary btnSimpan" type="submit">
													<i class="icon-save"></i> SIMPAN
												</button>
											</td>											
										</tr>

									</tbody>
									<tfoot>
										<tr class="bigger-150 red">
											<td class="center middle">#</td>
											<td class="center middle"><?php echo $totTimbangan;?></td>
											<td class="center middle"><?php echo $totPotLain;?></td>
											<td class="center middle"><?php echo $totPotAir;?></td>
											<td>&nbsp;</td>
										</tr>
									</tfoot>
								</table>
								
								<?php
								$totNetto = $totTimbangan - $totPotLain - $totPotAir;
								$persenNetto = ($totTimbangan > 0) ? ($totNetto / $totTimbangan) * 100 : 0;
								?>
								
								<div class="row-fluid">
									<div class="infobox-container">
										<div class="infobox infobox-orange2">
											<div class="infobox-icon">
												<i class="icon-h-chart-area"></i>
											</div>

											<div class="infobox-data">
												<span class="infobox-data-number"><?php echo $totTimbangan;?></span>
												<div class="infobox-text"> Total Brutto </div>
											</div>
											
											<div class="stat stat-important"><?php echo $totPotLain + $totPotAir;?></div>
										</div>
										
										<div class="infobox infobox-green2">
											<div class="infobox-progress">
												<div class="easy-pie-chart percentage" data-percent="<?php echo number_format($persenNetto, 2);?>" data-size="50">
													<span class="percent"><?php echo number_format($persenNetto, 0);?></span>
													%
												</div>
											</div>

											<div class="infobox-data">
												<span class="infobox-data-number">&nbsp;<?php echo $totNetto;?></span>
												<div class="infobox-text">&nbsp;Total Netto </div>
											</div>
										</div>
									</div>
									
								</div>
								
									<?php
										echo form_fieldset_close();	
										echo form_close();
									?>
								
								
							</div><!--/.tabpane-->
							
							<?php
							};
							?>
							
						</div>
						</ul>
					</div>
				</div>
			</div>
			
			<div class="modal fade" id="modaledit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<!--Modal Edit Goes Here-->
			</div>
		
			<div class="modal fade" id="modalpindahline" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<!--Modal Edit Tambah Goes Here-->
			</div>
		
		</div><!--/.span12-->
	</div><!--/.row-fluid-->
</div><!--/.page-content-->



<style>
	tfoot {
		height: 50px;
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

<script src="<?php echo base_url();?>assets/js/bootbox.js"></script>
<script type="text/javascript">
	// unblock when ajax activity stops 
    $(document).ajaxStop($.unblockUI);
	$('.btnSimpan').click(function(){
		$.blockUI({			
			message	: '<h5><img src="<?php echo base_url();?>assets/images/Preloader_21.gif" /> Proses Simpan...</h5>'						
		});
	});
	
	$(document).ready(function() {
		$('.hapus').click(function(){
			var detailid = $(this).attr("detailid");
			var nomormesin = $(this).attr("nomormesin");
			
			bootbox.confirm('Hapus data mesin '+nomormesin+'?',function(result){
				if (result){
					$.ajax({
						url:"<?php echo site_url('transaksi/hapus_timbangwm');?>",
						type:"POST",
						data:"detailid="+detailid,
						cache:false,
						success:function(){
							return location.href = "<?php echo site_url('transaksi/hapus_timbangwm/berhasil');?>/"+nomormesin;
						},
						error:function(){
							return location.href="<?php echo site_url('transaksi/hapus_timbangwm/gagal');?>/"+nomormesin;
						}
					});
				}else{
					console.log("User declined dialog");
				}
			});
		});
		
		$('.numeric').numeric({
			decimalPlaces : 4,
			negative: false
		});

	});
	
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
	$(function() {
		$('.easy-pie-chart.percentage').each(function(){
			var $box = $(this).closest('.infobox');
			var barColor = $(this).data('color') || (!$box.hasClass('infobox-dark') ? $box.css('color') : 'rgba(255,255,255,0.95)');
			var trackColor = barColor === 'rgba(255,255,255,0.95)' ? 'rgba(255,255,255,0.25)' : '#E2E2E2';
			var size = parseInt($(this).data('size')) || 50;
			$(this).easyPieChart({
				barColor: barColor,
				trackColor: trackColor,
				scaleColor: false,
				lineCap: 'butt',
				lineWidth: parseInt(size/10),
				animate: /msie\s*(8|7|6)/.test(navigator.userAgent.toLowerCase()) ? false : 1000,
				size: size
			});
		});

//		$('.sparkline').each(function(){
//			var $box = $(this).closest('.infobox');
//			var barColor = !$box.hasClass('infobox-dark') ? $box.css('color') : '#FFF';
//			$(this).sparkline('html', {tagValuesAttribute:'data-values', type: 'bar', barColor: barColor , chartRangeMin:$(this).data('min') || 0} );
//		});
					  
	});
</script>