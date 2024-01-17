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
		
		<li class="active">
			Complete
		</li>
	</ul><!--.breadcrumb-->
</div>

<div class="page-content">
	<div class="row-fluid">
		<div class="span12">
			<div class="judul">
				Transaksi Complete
			</div>
			
			<div class="page-header">
				<?php echo form_open('#',array('id'=>'form_laphasil' ,'class'=>'form-inline')); ?>
				<?php echo form_fieldset();?>

				<div class="input-append date">
					<input type="text" name="txtTanggal" class="input-small input-mask-date" id="inputTanggal"
						   value="<?php echo set_value('txtTanggal', $tanggal);?>">
					<span class="add-on">
						<i class="icon-calendar"></i>
					</span>					
				</div>

				<?php
					$extra_shift = 'class="chzn-select" id="dropdownShift" data-placeholder="Pilih Shift" style="width: 120px"';
					$option_shift[''] = '';
					foreach($cboshift as $r):
						$option_shift[$r->IDShift] = $r->NamaShift;
					endforeach;
					echo form_dropdown('txtShift', $option_shift, '', $extra_shift);
				?>

				<?php
					$extra_jam = 'class="chzn-select" name="txtJamKerja" id="dropdownJamKerja" data-placeholder="Pilih Jam Kerja" style="width: 140px"';
					$option_jam[''] = '';
					foreach($cbojamkerja as $r):
						$option_jam[$r->IDJamKerja] = $r->JamKerja;
					endforeach;
					echo form_dropdown('txtJamKerja', $option_jam, '', $extra_jam);
				?>

				<button id="btnRefreshHasil" class="btn btn-danger btn-small" type="submit">
					<i class="icon-refresh"></i> Refresh
				</button>

				<?php echo form_fieldset_close();?>
				<?php 
					if (validation_errors()){
						echo "<br/>".validation_errors();
					}
				?>
				<?php echo form_close(); ?>
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