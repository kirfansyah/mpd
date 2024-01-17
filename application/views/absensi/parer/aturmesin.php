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
			Atur Urutan Tenaga Kerja
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
			
			<?php echo $message;?>
			
			<?php
			echo '<ul class="item-list">';
			
			for ($i = $nomesinawal; $i <= $nomesinakhir; $i++){
				echo '<li class="item-blue absensi clearfix">';
				echo '<div class="nmrmesin">
						<span class="badge badge-primary"><h4>'.$i.'</h4></span>
					  </div>';
				echo '<div class="tkfield">';
				
				$urutdtlid1 = 0;
				$nama1 ='';
				$nik1 = '';
				$absen1 = '';
				
				$urutdtlid2 = 0;
				$nama2 ='';
				$nik2 = '';
				$absen2 = '';
				
				$urutdtlid3 = 0;
				$nama3 ='';
				$nik3 = '';
				$absen3 = '';
				
				foreach($record_trans as $rt):
					if($rt->NomorMesin === $i && $rt->Posisi === 1){
						$urutdtlid1 = $rt->UrutDtlID;
						$nama1 =  $rt->Nama;
						$nik1 = $rt->Nik;
						$absen1 = $rt->StatusAbsensi;
					}
					if($rt->NomorMesin === $i && $rt->Posisi === 2){
						$urutdtlid2 = $rt->UrutDtlID;
						$nama2 =  $rt->Nama;
						$nik2 = $rt->Nik;
						$absen2 = $rt->StatusAbsensi;
					}
					if($rt->NomorMesin === $i && $rt->Posisi === 3){
						$urutdtlid3 = $rt->UrutDtlID;
						$nama3 =  $rt->Nama;
						$nik3 = $rt->Nik;
						$absen3 = $rt->StatusAbsensi;
					}
				endforeach;
				
				if ($nama1 === ''){
					$extra_nama1 = 'id="dropdownNama1" data-placeholder="Nama" nomormesin="'.$i.'" posisi="1" class="combonama w190" ';
					$option_nama1[''] = '';
					foreach($listurut as $r):
						$option_nama1[$r->FixNo] = $r->Nama;
					endforeach;
					echo '<div class="body grid3">';
					echo '<div class="name">';
					echo form_dropdown('txtNama', $option_nama1, '', $extra_nama1);
					echo '</div>';
					echo '<div class="absen">';
					echo '<div class="tools">
							<div class="action-buttons">
								<a href="'.base_url().'absensi/parer/search/'.$i.'/1" id="btnCariTK" title="Cari Tenaga Kerja"
									class="btn btn-mini btn-primary btn-no-border">
									<i class="icon-search bigger-150"></i>
								</a>
							</div>
						  </div>';
					echo '</div>';
					echo '</div>';
				} else {
					echo '<div class="body grid3">';
					echo '<div class="name">';
					echo '<a href="#">'.$nama1.'</a>';
					echo '</div>';
					echo '<div class="time">
								<span class="pink2">'.$nik1.'</span>
							</div>';
					echo '<div class="absen">
								<span class="label label-success">'.$absen1.'</span>
							</div>';
					echo '<div class="tools">
							<div class="action-buttons">
								<a href="#" id="btnDelete" detailid="'.$urutdtlid1.'" nomormesin="'.$i.'" namatk="'.$nama1.'"
									class="btn btn-mini btn-danger btn-no-border hapus" title="Hapus">
									<i class="icon-trash bigger-150"></i>
								</a>
							</div>
						  </div>';
					echo '</div>';
				}
				
				if ($nama2 === ''){
					$extra_nama2 = 'id="dropdownNama2" data-placeholder="Nama" nomormesin="'.$i.'" posisi="2" class="combonama w190" ';
					$option_nama2[''] = '';
					foreach($listurut as $r):
						$option_nama2[$r->FixNo] = $r->Nama;
					endforeach;
					echo '<div class="body grid3">';
					echo '<div class="name">';
					echo form_dropdown('txtNama', $option_nama2, '', $extra_nama2);
					echo '</div>';
					echo '<div class="absen">';
					echo '<div class="tools">
							<div class="action-buttons">
								<a href="'.base_url().'absensi/parer/search/'.$i.'/2" id="btnCariTK" title="Cari Tenaga Kerja"
									class="btn btn-mini btn-primary btn-no-border">
									<i class="icon-search bigger-150"></i>
								</a>
							</div>
						  </div>';
					echo '</div>';
					echo '</div>';
				} else {
					echo '<div class="body grid3">';
					echo '<div class="name">';
					echo '<a href="#">'.$nama2.'</a>';
					echo '</div>';
					echo '<div class="time">
								<span class="pink2">'.$nik2.'</span>
							</div>';
					echo '<div class="absen">
								<span class="label label-success">'.$absen2.'</span>
							</div>';
					echo '<div class="tools">
							<div class="action-buttons">
								<a href="#" id="btnDelete" detailid="'.$urutdtlid2.'" nomormesin="'.$i.'" namatk="'.$nama2.'"
									class="btn btn-mini btn-danger btn-no-border hapus" title="Hapus">
									<i class="icon-trash bigger-150"></i>
								</a>
							</div>
						  </div>';
					echo '</div>';
				}
				
				if ($nama3 === ''){
					$extra_nama3 = 'id="dropdownNama3" data-placeholder="Nama" nomormesin="'.$i.'" posisi="3" class="combonama w190" ';
					$option_nama3[''] = '';
					foreach($listurut as $r):
						$option_nama3[$r->FixNo] = $r->Nama;
					endforeach;
					echo '<div class="body grid3">';
					echo '<div class="name">';
					echo form_dropdown('txtNama', $option_nama3, '', $extra_nama3);
					echo '</div>';
					echo '<div class="absen">';
					echo '<div class="tools">
							<div class="action-buttons">
								<a href="'.base_url().'absensi/parer/search/'.$i.'/3" id="btnCariTK" title="Cari Tenaga Kerja"
									class="btn btn-mini btn-primary btn-no-border">
									<i class="icon-search bigger-150"></i>
								</a>
							</div>
						  </div>';
					echo '</div>';
					echo '</div>';
				} else {
					echo '<div class="body grid3">';
					echo '<div class="name">';
					echo '<a href="#">'.$nama3.'</a>';
					echo '</div>';
					echo '<div class="time">
								<span class="pink2">'.$nik3.'</span>
							</div>';
					echo '<div class="absen">
								<span class="label label-success">'.$absen3.'</span>
							</div>';
					echo '<div class="tools">
							<div class="action-buttons">
								<a href="#" id="btnDelete" detailid="'.$urutdtlid3.'" nomormesin="'.$i.'" namatk="'.$nama3.'"
									class="btn btn-mini btn-danger btn-no-border hapus" title="Hapus">
									<i class="icon-trash bigger-150"></i>
								</a>
							</div>
						  </div>';
					echo '</div>';
				}
				
				echo '</div>';
				echo '</li>';
				
			}
			echo '</ul>';
			
			?>	

		</div>
		
	</div>
</div>

<!--<div id="loading"></div>-->

<div class="modal fade" id="modaledit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<!--Modal Edit Goes Here-->
</div>

<div class="modal fade" id="modaltable" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<!--Modal Edit Goes Here-->	
</div>

<script src="<?php echo base_url();?>assets/js/bootbox.min.js"></script>
<script>
	$('.combonama').change(function(){
		var fixno = $(this).val();
		var nomormesin = $(this).attr('nomormesin');
		var posisi = $(this).attr('posisi');
		
		$.ajax({			
			url : "<?php echo site_url('absensi/parer/save');?>/"+nomormesin,
			type : "POST",
			data : "fixno="+fixno+"&posisi="+posisi,
			success : function(){
				return location.href = "<?php echo site_url('absensi/parer/set');?>";
			}
//			success : function(response){
//				$("#namadiv").html(response);
//			},
//			dataType : html
		});
		return false;
	});
	
	$('.hapus').click(function(){
		var detailid = $(this).attr("detailid");
		var nomormesin = $(this).attr("nomormesin");
		var nama = $(this).attr("namatk");

		bootbox.confirm('<H4>Hapus nama <strong><span class="red">'+nama+'</span></strong> di mesin <strong><span class="red">'+nomormesin+'</span></strong> ?</H4>',function(result){
			if (result){
				$.ajax({
					url:"<?php echo site_url('absensi/parer/delete');?>/"+nomormesin,
					type:"POST",
					data:"detailid="+detailid,
					cache:false,
					success:function(){
						return location.href = "<?php echo site_url('absensi/parer/set');?>";
					}
				});
			}else{
				console.log("User declined dialog");
			}
		});
	});
	
//	menampilkan modal
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
	
//	$('#btnComplete').click(function(){
//		var uruthdrid = $(this).attr("uruthdrid");
//		
//		$.ajax({
//			url:"<?php // echo site_url('absensi/sheller/complete');?>",
//			type:"POST",
//			data:"uruthdrid="+uruthdrid,
//			cache:false,
//			success:function(){
//				bootbox.alert('Complete data berhasil');
//				return location.href = "<?php // echo site_url('absensi/sheller');?>";
//			}
//		});
//	});
	
</script>
