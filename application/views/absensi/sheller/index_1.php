<style>
	input, textarea, .uneditable-input {
		width: 100px;
	}
	.input-prepend input, .input-append input, .input-prepend input[class*="span"], .input-append input[class*="span"] {
		display: inline-block;
		width: 100px;
	}
</style>

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
		
		<li class="active">
			<?php echo $pekerjaan;?>
		</li>
	</ul><!--.breadcrumb-->
</div>

<div class="page-content">
	<div class="row-fluid">
		<div class="span12">
			
			<div class="judul">
				Absensi Tenaga Kerja <?php echo ucfirst($pekerjaan);?>
			</div>
			
			<div class="page-header">
				<?php echo form_open('absensi/proses_absensi',array('id'=>'formSetMesinSheller' ,'class'=>'form-inline')); ?>
				<?php echo form_fieldset();?>
				
				<input name="txtIDPekerjaan" type="hidden" value="<?php echo $idpekerjaan;?>">
				
				<div class="input-append date">
					<input type="text" name="txtTanggal" class="input-small input-mask-date" 
						   value="<?php echo set_value('txtTanggal', $this->session->userdata('serverdate'));?>">
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
					$extra_jam = 'class="chzn-select" name="txtJamKerja" id="dropdownJamKerja" data-placeholder="Pilih Jam Kerja" style="width: 100px"';
					$option_jam[''] = '';
					foreach($cbojamkerja as $r):
						$option_jam[$r->IDJamKerja] = $r->JamKerja;
					endforeach;
					echo form_dropdown('txtJamKerja', $option_jam, $idjamkerja, $extra_jam);
				?>
				
				<button id="btnProses" class="btn btn-primary btn-small" type="submit"><i class="icon-refresh"></i> Refresh</button>

				<?php echo form_fieldset_close();?>				
				<?php echo validation_errors() ? "<br/>".validation_errors() : '' ;?>
				<?php echo form_close(); ?>
			</div>
			
			<div class="row-fluid">
				<div class="span12">
					<div class="table-header">Pengaturan Nomor Mesin</div>
					<table class="table table-bordered table-condensed table-hover">
						<thead>
							<tr>
								<th class="center middle" style="width:100px">Nomor Mesin</th>
								<th class="center middle" >Nama</th>
								<th class="center middle" style="width:120px">Tombol</th>
							</tr>
						</thead>
						<tbody>
						<?php
						if ($showdetail == 1){
							for ($i = $nomesinawal; $i <= $nomesinakhir; $i++){
								echo '<tr class="bigger-120">';
								echo '<td class="center middle">'.$i.'</td>';
								echo '<td class="middle">';
//									$extra_nama = 'class="chzn-select" id="dropdownNama" data-placeholder="Nama" ';
									$extra_nama = 'id="dropdownNama" data-placeholder="Nama" ';
									$option_nama[''] = '';
									foreach($listtk as $r):
										$option_nama[$r->FixNo] = $r->Nama;
									endforeach;
									echo form_dropdown('txtNama', $option_nama, '', $extra_nama);
								echo '</td>';
								echo '<td>';
									echo '<input class="btn btn-small btn-success" value="Simpan">';
								echo '</td>';
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