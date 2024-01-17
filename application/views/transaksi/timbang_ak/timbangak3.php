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
			<a href="#">Timbang Air Kelapa</a>
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
		<a href="<?php echo site_url('transaksi/proses_timbangak_selesai');?>" class="btn btn-danger bolder">
			<i class="icon-ok"></i> Selesai
		</a>
		<a href="<?php echo site_url('monitor/timbang_airkelapa');?>" class="btn btn-primary bolder">
			<i class="icon-table"></i> Buka Monitor Air Kelapa
		</a>
		<a href="<?php echo site_url('transaksi/pindahline/airkelapa');?>" class="btn btn-success bolder"
			data-toggle="remote-modal" data-target="#modalpindahline" title="Pindah dari line <?php echo $namaline;?>">
			<i class="icon-level-up"></i> Pindah Line
		</a>
	</h3>
	
	<div class="row-fluid">
		<div class="span12">
			<div class="judul">
				Hasil Timbang Air Kelapa <?php echo $namaline;?> <span class="badge badge-success"> ID Transaksi : <?php echo $headerid;?> </span>
			</div>
			
			<div class="trx-user-info trx-user-info-striped">
				<div class="trx-info-row">
					<div class="trx-info-name"> Jenis Produk </div>
					<div class="trx-info-value"> AK </div>
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
									if (number_format($i) === number_format($mesinaktif)){
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
									
									// echo form_open('transaksi/simpan_timbangak/'.$i, array('id'=>'formtimbangak'.$i ,'class'=>'form-horizontal', 'name'=>'mesin'.$i));
									echo form_fieldset();
									
									echo form_hidden('txtNomorMesin', $i);
							?>
							
							<div class="table-header">MESIN <?php echo $i;?></div>
								<table id="tabelMesin<?php echo $i;?>" class="table table-bordered table-condensed">
									<thead>
										<tr>
											<th class="center middle" style="width: 50px">No</th>
											<th class="center middle">Air Kelapa</th>
											<th class="center middle" style="width: 120px">Actions</th>
										</tr>
									</thead>
									<tbody>
										<?php
											$param_mesin = array(
												'HasilHeaderID'	=> $headerid,
												'NomorMesin'	=> $i
											);
											
											$detail_mesin = $this->db->get_where('vwOL_TrnHasilTimbangAirKelapa', $param_mesin);
											$detail_jumlah = $detail_mesin->num_rows();
											$j = 0;
											
											$totHasilAK = 0;
											
											if ($detail_jumlah > 0) {
												foreach ($detail_mesin->result() as $dm) {
													$j = $j+1;
													
													$totHasilAK = $totHasilAK + $dm->HasilAK;
													
													echo '<tr class="bigger-120">';
													echo '<td class="center middle">'.$j.'</td>';
													echo '<td class="center middle">'.$dm->HasilAK.'</td>';
													echo '<td class="center middle">
															<a href="timbang_airkelapa/edit/'.$dm->HasilTimbangAKID.'" class="btn btn-medium btn-warning"
																data-toggle="remote-modal" data-target="#modaledit" title="Edit">
															<i class="icon-pencil bigger-120"></i>
															</a>
															
															<button id="btnDelete" detailid="'.$dm->HasilTimbangAKID.'" nomormesin="'.$i.'" 
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
												<?php echo $j + 1;?>
											</td>
											
											<td class="center middle">
												<input type="number" min="0" name="txtTimbang<?php echo $i;?>" placeholder='0' class="input input-small text-right numeric" id="txtTimbang<?php echo $i;?>" /> 											
											</td>
											
											<td class="center middle">
												<button id="btnSimpan<?php echo $i;?>" name="SimpanMesin<?php echo $i;?>" class="btn btn-block btn-primary btn-medium btnSimpan" nomormesin="<?php echo $i;?>">
													<i class="icon-save"></i> SIMPAN
												</button>
											</td>
										</tr>
										<tr class="bigger-140 red" id="totalmesin<?php echo $i;?>">
											<td class="center middle">#</td>
											<td class="center middle" id="totalTimbang"><?php echo $totHasilAK;?></td>
											<td class="center middle">&nbsp;</td>
										</tr>
									</tfoot>
								</table>
								
							<?php
								echo form_fieldset_close();	
								// echo form_close();
								echo '</div>';
							};
							?>
						</div><!--/.tab-content-->
					</div><!--/.tabable-->
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
 //    $(document).ajaxStop($.unblockUI);
	// $('.btnSimpan').click(function(){
	// 	$.blockUI({			
	// 		message	: '<h5><img src="<?php echo base_url();?>assets/images/Preloader_21.gif" /> Proses Simpan...</h5>'						
	// 	});
	// });
	
	
		$('.btnSimpan').click(function(){
			var nomorMesin = $(this).attr("nomormesin");
			var dataString = 
							"SimpanMesin"+nomorMesin+"="+""+
							"&txtTimbang"+nomorMesin+"="+$('#txtTimbang'+nomorMesin).val()

			;
			$.ajax({
				url 	: "<?php echo site_url('transaksi/simpan_timbangak/')?>/"+nomorMesin,
				type 	: "post",
				data 	: dataString,
				cache 	: false,
				beforeSend  : function(){
					$('.btnSimpan').html('<img src="<?php echo base_url('assets/images/ajax-loader.gif')?>" />');
					$('.btnSimpan').attr('disabled', 'disabled');
				},
				success : function(){
					add_data_table(nomorMesin);
				},
				error 	: function(){
					alert("data tidak berhasil disimpan");
				},
				complete 	: function(){
					$('.btnSimpan').html('SIMPAN');
					$('.btnSimpan').removeAttr('disabled');
				}
			});
		});
	

	function add_data_table(nomorMesin){
		var tabelMesin 		= '#tabelMesin'+nomorMesin;
		var rowcount 		= $(tabelMesin+' >tbody >tr').length + 1;
		var totalTimbang 	= parseFloat($('#totalmesin'+nomorMesin+' >#totalTimbang').text());
		$.ajax({
			url 		: "<?php echo base_url('transaksi/detail_timbangak')?>/"+nomorMesin,
			type 		: "post",
			data 		: "HeaderID="+<?php echo $headerid;?>,
			dataType 	: "json",
			success 	: function(info){
				$(tabelMesin+' tbody').append('<tr class="bigger-120">'+
					'<td class="center middle">'+ rowcount +'</td>'+
					'<td class="center middle">'+parseFloat(info[0].HasilAK)+'</td>'+
					'<td class="center middle">'+
						'<a href="timbang_airkelapa/edit/'+info[0].HasilTimbangAKID+'" class="btn btn-medium btn-warning" '+
						'data-toggle="remote-modal" data-target="#modaledit" title="Edit">'+
							'<i class="icon-pencil bigger-120"></i>'+
						'</a> '+									
						'<button id="btnDelete" detailid="'+info[0].HasilTimbangAKID+'" nomormesin="'+nomorMesin+'" '+ 
							'class="btn btn-medium btn-danger hapus" title="Hapus">'+
							'<i class="icon-trash bigger-120"></i>'+
							'</button>'+
					'</td>'+
				'</tr>'
				);
				totalTimbang 	= totalTimbang + parseFloat(info[0].HasilAK);
				$('#totalmesin'+nomorMesin+' >#totalTimbang').text(totalTimbang.toFixed(2));
				$('#txtTimbang'+nomorMesin).val(null);
				$(tabelMesin+' >tfoot >tr:first').find('td:first-child').text(rowcount + 1);

			},
			error 		: function(){
				alert('koneksi gagal');
				//return location.href = "<? echo site_url('transaksi/timbang_airkelapa');?>";
			}
		});
	}

	$(document).on('click', '.hapus', function() {
		// $('.hapus').click(function(){
			var detailid = $(this).attr("detailid");
			var nomormesin = $(this).attr("nomormesin");
			
			bootbox.confirm('Hapus data mesin '+nomormesin+'?',function(result){
				if (result){
					$.ajax({
						url:"<?php echo site_url('transaksi/hapus_timbangak');?>",
						type:"POST",
						data:"detailid="+detailid,
						cache:false,
						success:function(){
							return location.href = "<?php echo site_url('transaksi/hapus_timbangak/berhasil');?>/"+nomormesin;
						},
						error:function(){
							return location.href="<?php echo site_url('transaksi/hapus_timbangak/gagal');?>/"+nomormesin;
						}
					});
				}else{
					console.log("User declined dialog");
				}
			});
		// });
		
		$('.numeric').numeric({
			decimal	: false,
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

<script src="<?php echo base_url();?>assets/js/jquery.validate.min.js"></script>
<script type="text/javascript">
	$('#formtimbangak').validate({
		errorElement: 'span',
		errorClass: 'help-inline',
		focusInvalid: true,
		rules: {
			txtTimbang:{
				required : true
			}
		},
		
		messages: {
			txtTimbang:{
				required	: " <i class='icon-exclamation-sign'></i> Nilai Timbangan Wajib Diisi!!"
			}
		},
		
		highlight: function (e) {
			$(e).closest('.control-group').removeClass('info').addClass('error');
		},

		success: function (e) {
			$(e).closest('.control-group').removeClass('error').addClass('info');
			$(e).remove();
		}
	});
</script>