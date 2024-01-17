<?php $CI = &get_instance(); 
$CI->load->model('M_master', 'M_trnhasil');
$line = $CI->m_master->mst_line()->result();
?>
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
		<!-- <a href="<?php //echo site_url('transaksi/pindahline/whitemeat');?>" class="btn btn-success bolder"
			data-toggle="remote-modal" data-target="#modalpindahline" title="Pindah dari line <?php //echo $namaline;?>">
			<i class="icon-level-up"></i> Pindah Line
		</a> -->
	</h3>

	<h3 class="header smaller lighter blue">
		<div class="row-fluid-fluid">
			<?php
				echo form_open('transaksi/do_changeline/whitemeat', array('id'=>'formPindah' ,'class'=>'form-horizontal'));
				foreach ($line as $value) {
				if ($value->NamaLine == $namaline) {$disable = 'disabled'; $btn = 'btn-primary'; $color = 'background-color : #d15500 !important; border-color: #d14400;';}
				else {$disable = ''; $btn = 'btn-black'; $color = 'background-color : #443344 !important; border-color : #553355;';}
			?>
			<button class="btn bolder btn-small <?php echo $btn ?>" type="submit" name="txtLine" value="<?php echo $value->IDLine?>" <?php echo $disable ?> style="width: 90px; margin: 15px; <?php echo $color; ?>">
				<i class="icon-hdd"></i>
				<strong><?php echo $value->NamaLine?></strong>
			</button>
			<?php } echo form_close();?>
		</div>
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
					<div class="trx-info-value"><?php echo $this->m_trnhasil->get_inspector($headerid, 'WM')['username'];?></div>
				</div>
			</div>
			
			<div class="alert alert-info"><i class="icon-h-star"></i> Pastikan informasi diatas sudah benar.</div>
			
			<?php echo $message;?>
			
			<div class="row-fluid">
				<div class="span12">
					<div class="tabbable tabs-left" >
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
							
							<?php
								echo '</li>';
								}
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
									
									// echo form_open('', array('id'=>'formtimbangwm'.$i ,'class'=>'form-horizontal', 'name'=>'mesin'.$i));
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
											<th class="center">Keranjang</th>
											<th class="center">Lain</th>											
										</tr>
									</thead>
									<tbody>
										<?php
											$param_mesin = array(
												'HasilHeaderID'	=> $headerid,
												'NomorMesin'	=> $i
											);
											$this->db->order_by('HasilTimbangWMID','asc');
											$detail_mesin = $this->db->get_where('vwOL_TrnHasilTimbangWhiteMeat', $param_mesin);
											$detail_jumlah = $detail_mesin->num_rows();
											$j = 0;
											
											$totTimbangan = 0;
											$totPotLain = 0;
											$totPotAir = 0;
											?>
											

											<?php
											$tempPotLain = 0;
											if ($detail_jumlah > 0) {
												foreach ($detail_mesin->result() as $dm) {
													$j = $j+1;
													$totTimbangan = $totTimbangan + $dm->Timbangan;
													$totPotLain = $totPotLain + $dm->PotLain;
													$totPotAir = $totPotAir + $dm->PotAir;

													$tempPotLain = $dm->PotLain;
													
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
															
															<button id="btnDelete" detailid="'.$dm->HasilTimbangWMID.'" nomormesin="'.$i.'"
																class="btn btn-medium btn-danger hapus" title="Hapus">
																<i class="icon-trash bigger-120"></i>
															</button>
															</td>';
													echo '</tr>';

												}												
											}
											
										?>
										

									</tbody>
									<tfoot>
									<tr class="bigger-120">
											<td class="center middle">
												<?php echo $j+1;?>
											</td>
											
											<td class="center middle">
												<input type="number" step="0.1" min="0" value="<?php echo set_value('txtTimbang'.$i);?>" name="txtTimbang<?php echo $i;?>" placeholder='0' class="txtTimbang input input-small text-right numeric" id="txtTimbang<?php echo $i;?>"/>	
											</td>
											
											<td class="center middle">
												<input type="number" step="0.1" min="0" name="txtPotLain<?php echo $i;?>" placeholder='0.0' class="input input-mini text-right numeric" id="txtPotLain<?php echo $i;?>" <?php if ($tempPotLain != 0) {echo 'value="'.floatval($tempPotLain).'"';}?>/>
												
											</td>
											
											<td class="center middle">
												<input type="number" step="0.1" min="0" name="txtPotAir<?php echo $i;?>" placeholder='0.0' class="input input-mini text-right numeric" id="txtPotAir<?php echo $i;?>"/>
											</td>
											
											<td class="center middle">
												<button id="btnSimpan<?php echo $i;?>" name="SimpanMesin<?php echo $i;?>" class="btn btn-block btn-medium btn-primary btnSimpan" nomormesin="<?php echo $i;?>" value="<?php echo $i;?>">
													<i class="icon-save"></i> SIMPAN
												</button>
											</td>											
										</tr>
										<tr class="bigger-150 red" id="totalmesin<?php echo $i;?>">
											<td class="center middle">#</td>
											<td class="center middle" id="totalTimbang"><?php echo $totTimbangan;?></td>
											<td class="center middle" id="totalPotLain"><?php echo $totPotLain;?></td>
											<td class="center middle" id="totalPotAir"><?php echo $totPotAir;?></td>
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
												<span class="infobox-data-number" id="totalBruto<?php echo $i;?>"><?php echo $totTimbangan;?></span>
												<div class="infobox-text"> Total Brutto </div>
											</div>
											
											<div class="stat stat-important" id="totalPotongan<?php echo $i;?>"><?php echo $totPotLain + $totPotAir;?></div>
										</div>
										
										<div class="infobox infobox-green2">
											<div class="infobox-progress">
												<div class="easy-pie-chart percentage" data-percent="<?php echo number_format($persenNetto, 2);?>" data-size="50" id="percentage<?php echo $i;?>">
													<span class="percent" id="percent<?php echo $i;?>"><?php echo number_format($persenNetto, 0);?></span>
													%
												</div>
											</div>

											<div class="infobox-data">
												<span class="infobox-data-number" id="totalNetto<?php echo $i;?>">&nbsp;<?php echo $totNetto;?></span>
												<div class="infobox-text">&nbsp;Total Netto </div>
											</div>
										</div>
									</div>
									
								</div>
								
									<?php
										echo form_fieldset_close();	
										// echo form_close();
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

<script>
//var sticky = document.querySelector('#tabmesin');
//var stickyCon = document.querySelector('.tab-content');
//var origOffsetY = sticky.offsetTop;
//
//function onScroll(e) {
////  window.scrollY >= origOffsetY ? sticky.classList.add('nav-fixed') :
////                                  sticky.classList.remove('nav-fixed');
//	if (window.scrollY >= origOffsetY){
//		sticky.classList.add('nav-fixed');
//		stickyCon.classList.add('tab-content-fixed');
//	} else {
//		sticky.classList.remove('nav-fixed');
//		stickyCon.classList.remove('tab-content-fixed');
//	}
//}
//
//document.addEventListener('scroll', onScroll);
</script>


<script src="<?php echo base_url();?>assets/js/bootbox.js"></script>
<script type="text/javascript">
	// unblock when ajax activity stops 
//    $(document).ajaxStop($.unblockUI);
//	$('.btnSimpan').click(function(){
//		$.blockUI({			
//			message	: '<h5><img src="<?php echo base_url();?>assets/images/Preloader_21.gif" /> Proses Simpan...</h5>'						
//		});
//	});


		$('.btnSimpan').click(function(){
			var nomorMesin = $(this).attr("nomormesin");
			var tabelMesin 		= '#tabelMesin'+nomorMesin;
			var dataString = 
							"SimpanMesin"+nomorMesin+"="+''+
							"&txtTimbang"+nomorMesin+"="+$('#txtTimbang'+nomorMesin).val()+
							"&txtPotLain"+nomorMesin+"="+$('#txtPotLain'+nomorMesin).val()+
							"&txtPotAir"+nomorMesin+"="+$('#txtPotAir'+nomorMesin).val()
			;
			var TimbangWM = $('txtTimbang'+nomorMesin).val();
			$.ajax({
				url 		: "<?php echo site_url('transaksi/simpan_timbangwm/')?>/"+nomorMesin,
				type 		: "POST",
				data 		: dataString,
				cache		: false,
				beforeSend  : function(){
					$(tabelMesin+' tbody').append('<tr><td colspan="5" class="center middle"><img src="<?php echo base_url('assets/images/ajax-loader.gif')?>" /> </td></tr>');
					$('.btnSimpan').attr('disabled', 'disabled');
				},
				success 	: function(status_info){
					
					status_info = parseInt(status_info);
					 if (status_info == 1) {
						add_data_table(nomorMesin);
					 }else{
						$(tabelMesin+' tbody tr:last').remove();	 	
					 }
				},
				error		:function(XMLHttpRequest, textStatus, errorThrown){
					alert("error : " + XMLHttpRequest + " " + textStatus + " " + errorThrown );
					$(tabelMesin+' tbody tr:last').remove();
					return location.href = "<? echo site_url('transaksi/timbang_whitemeat');?>";
				},
				complete 	: function(){
					$('.btnSimpan').removeAttr('disabled');
				}
			});
		});

	// $('.txtTimbang').keypress(function(){
	// 	var timbang = $('.txtTimbang').val();
	// 	timbang = 
	// 	$('.txtTimbang').val(timbang);
	// });

	function add_data_table(nomorMesin){
		var tabelMesin 		= '#tabelMesin'+nomorMesin;
		var rowcount		= $(tabelMesin+' >tbody >tr').length;
		var totalTimbang 	= parseFloat($('#totalmesin'+nomorMesin+' >#totalTimbang').text());
		var totalPotLain 	= parseFloat($('#totalmesin'+nomorMesin+' >#totalPotLain').text());
		var totalPotAir 	= parseFloat($('#totalmesin'+nomorMesin+' >#totalPotAir').text());
		var totalnetto 		= 0.0;
		var persenNetto 	= 0.0;
		$.ajax({
			url 		: "<?php echo site_url('transaksi/detail_timbangwm')?>/"+nomorMesin,
			type		: "post",
			data 		: "HeaderID="+<?php echo $headerid;?>,
			dataType 	: "json",
			success 	: function(info){
				$(tabelMesin+' tbody tr:last').remove();
				$(tabelMesin+' tbody').append('<tr class="bigger-120">'+
					'<td class="center middle">'+ rowcount +'</td>'+
					'<td class="center middle">'+parseFloat(info[0].Timbangan)+'</td>'+
					'<td class="center middle">'+parseFloat(info[0].PotLain)+'</td>'+
					'<td class="center middle">'+parseFloat(info[0].PotAir)+'</td>'+
					'<td class="center middle">'+
					'<a href="timbang_whitemeat/edit/'+info[0].HasilTimbangWMID+'" class="btn btn-medium btn-warning" '+
						'data-toggle="remote-modal" data-target="#modaledit" title="Edit">'+
						'<i class="icon-pencil bigger-120"></i>'+
					'</a> '+
															
					'<button id="btnDelete" detailid="'+info[0].HasilTimbangWMID+'" nomormesin="'+nomorMesin+'" '+
						'class="btn btn-medium btn-danger hapus" title="Hapus"> '+
						'<i class="icon-trash bigger-120"></i>'+
					'</button>'+
					'</td>'+
				'</tr>');
				
				totalTimbang 	= totalTimbang + parseFloat(info[0].Timbangan);
				totalPotLain 	= totalPotLain + parseFloat(info[0].PotLain);
				totalPotAir  	= totalPotAir  + parseFloat(info[0].PotAir);
				totalNetto  	= totalTimbang - (totalPotLain + totalPotAir);
				totalPotongan 	= totalPotAir + totalPotLain;
				persenNetto 	= (totalNetto / totalTimbang) * 100;
				$('#totalmesin'+nomorMesin+' >#totalTimbang').text(totalTimbang.toFixed(2));
				$('#totalmesin'+nomorMesin+' >#totalPotLain').text(totalPotLain.toFixed(2));
				$('#totalmesin'+nomorMesin+' >#totalPotAir').text(totalPotAir.toFixed(2));
				$('#totalBruto'+nomorMesin).text(totalTimbang.toFixed(1));
				$('#totalPotongan'+nomorMesin).text(totalPotongan.toFixed(1));
				$('#totalNetto'+nomorMesin).text(parseFloat(totalNetto).toFixed(1));
				$('#percentage'+nomorMesin).attr('data-percent',parseFloat(persenNetto).toFixed(2));
				$('#percent'+nomorMesin).text(parseFloat(persenNetto).toFixed(0));
				$('#txtTimbang'+nomorMesin).val(null);
				$('#txtPotLain'+nomorMesin).val(parseFloat(info[0].PotLain));
				$('#txtPotAir'+nomorMesin).val(null);
				$(tabelMesin+' >tfoot >tr:first').find('td:first-child').text(rowcount + 1);
			},
			error 		: function(XMLHttpRequest, textStatus, errorThrown){
				// alert('koneksi gagal');
				alert("error : " + XMLHttpRequest + " " + textStatus + " " + errorThrown );
				return location.href = "<? echo site_url('transaksi/timbang_whitemeat');?>";
			}
		});
		
	}


	$(document).on('click', '.hapus', function(){
		// $('.hapus').click(function(){
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
		// });
		
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