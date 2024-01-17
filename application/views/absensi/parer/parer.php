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
			Parer
		</li>
	</ul><!--.breadcrumb-->
</div>

<div class="page-content">
	<h3 class="header smaller lighter blue">		
		<a href="<?php echo site_url('absensi/parer/end_session');?>" class="btn btn-danger btn-small">
			<i class="icon-ok"></i> Selesai
		</a>		
	</h3>
	<div class="row-fluid">
		<div class="span12">
			
			<div class="judul">
				Absensi Tenaga Kerja Parer
			</div>
			
			<div class="page-header">
				<?php echo form_open('absensi/proses_absensi',array('id'=>'formSetMesin' ,'class'=>'form-inline')); ?>
				<?php echo form_fieldset();?>
				
				<div class="input-append date">
					<input type="text" name="txtTanggal" class="input-mask-date" 
						   value="<?php echo set_value('txtTanggal', $this->session->userdata('serverdate'));?>">
					<span class="add-on">
						<i class="icon-calendar"></i>
					</span>					
				</div>				
				
				<select class="chzn-select" name="txtLine" id="dropdownLine" data-placeholder="Line" style="width: 100px">
					<option value=""></option>
					<?php
						foreach($cboline as $r):
							echo "<option value='".$r->IDLine."'>".$r->NamaLine."</option>";
						endforeach;
					?>					
				</select>
				
				<select class="chzn-select" name="txtShift" id="dropdownShift" data-placeholder="Shift" style="width: 100px">
					<option value=""></option>
					<?php
						foreach($cboshift as $r):
							echo "<option value='".$r->IDShift."'>".$r->NamaShift."</option>";
						endforeach;
					?>
				</select>
				
				<select class="chzn-select" name="txtJamKerja" id="dropdownJamKerja" data-placeholder="Jam Kerja" style="width: 120px">
					<option value=""></option>
					<?php
						foreach($cbojamkerja as $r):
							echo "<option value='".$r->IDJamKerja."'>".$r->JamKerja."</option>";
						endforeach; 
					?>
				</select>
				
				<button id="btnProses" class="btn btn-danger btn-small" type="submit">Proses</button>

				<?php echo form_fieldset_close();?>				
				<?php echo validation_errors() ? "<br/>".validation_errors() : '' ;?>
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