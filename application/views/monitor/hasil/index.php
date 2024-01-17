<div class="breadcrumbs" id="breadcrumbs">
	<ul class="breadcrumb">
		<li>
			<i class="icon-home"></i>
			<a href="<?php echo site_url('home');?>">Home</a>
			<span class="divider"><i class="icon-angle-right"></i></span>
		</li>
		
		<li>
			<a href="#">Monitor</a>
			<span class="divider">
				<i class="icon-angle-right"></i>
			</span>
		</li>
		
		<li class="active">
			Hasil
		</li>
	</ul><!--.breadcrumb-->
</div>

<div class="page-content">
	<div class="row-fluid">
		<div class="span12">
			<div class="judul">
				Monitor Hasil Kerja
			</div>
			
			<div class="page-header">
				<?php echo form_open('monitor/hasil',array('id'=>'formMonHasil' ,'class'=>'form-inline')); ?>
				<?php echo form_fieldset();?>				
				
				<div class="input-append date">
					<input type="text" name="txtTanggal" class="input-small input-mask-date" 
						   value="<?php echo set_value('txtTanggal', $tanggal);?>">
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
					echo form_dropdown('txtLine', $option_line, '', $extra_line);
				?>
				
				<?php
					$extra_shift = 'class="chzn-select" id="dropdownShift" data-placeholder="Shift" style="width: 100px"';
					$option_shift[''] = '';
					foreach($cboshift as $r):
						$option_shift[$r->IDShift] = $r->NamaShift;
					endforeach;
					echo form_dropdown('txtShift', $option_shift, '', $extra_shift);
				?>
				
				<?php
					$extra_jamkerja = 'class="chzn-select" id="dropdownShift" data-placeholder="Jam Kerja" style="width: 100px"';
					$option_jamkerja[''] = '';
					foreach($cbojamkerja as $r):
						$option_jamkerja[$r->IDJamKerja] = $r->JamKerja;
					endforeach;
					echo form_dropdown('txtJamKerja', $option_jamkerja, '', $extra_jamkerja);
				?>
				
				<button id="btnRefresh" name="btnRefresh" class="btn btn-danger btn-small" type="submit"><i class="icon-refresh"></i> Refresh</button>

				<?php echo form_fieldset_close();?>				
				<?php echo validation_errors() ? "<br/>".validation_errors() : '' ;?>
				<?php echo form_close(); ?>
			</div>
			
		</div><!--.span12-->
	</div><!--.row-fluid-->
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