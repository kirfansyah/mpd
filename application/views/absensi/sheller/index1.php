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
				
				<button id="btnProses" class="btn btn-primary btn-small" type="submit"><i class="icon-refresh"></i> Refresh</button>

				<?php echo form_fieldset_close();?>				
				<?php echo validation_errors() ? "<br/>".validation_errors() : '' ;?>
				<?php echo form_close(); ?>
			</div>
			
			<div class="table-header">
				LINE <?php echo $namaline;?>				
			</div>
			<table class="table table-bordered table-condensed table-hover">
				<thead>
					<tr>
						<th>No</th>
						<th>NIK</th>
						<th>Nama</th>
						<th>Nomor Mesin</th>
						<th>Keterangan</th>
					</tr>
				</thead>
				<tbody>					
					<?php 
						if ($showdetail === 0){
							echo '<tr>';							
							for($i=1;$i<=5;$i++){
								echo '<td>&nbsp;</td>';
							}
							echo '</tr>';
						} else {
							$i = 0;
							foreach ($record as $r) {
								$i++;
								echo '<tr>';
								echo '<td>'.$i.'</td>';
								echo '<td>'.$r->Nik.'</td>';
								echo '<td>'.$r->Nama.'</td>';
								echo '<td></td>';
								echo '<td></td>';
								echo '</tr>';
							}
						}
					?>					
				</tbody>
			</table>			
			
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