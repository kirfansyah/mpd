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
			<a href="#">Transaksi</a>
			<span class="divider">
				<i class="icon-angle-right"></i>
			</span>
		</li>
		
		<li class="active">
			Hasil Kelapa Cungkil
		</li>
	</ul><!--.breadcrumb-->
</div>

<div class="page-content">
	<div class="row-fluid">
		<div class="span12">
			<div class="judul">
				Hasil Kelapa Cungkil
			</div>
			
			<div class="page-header">
				<?php echo form_open('transaksi/proses_hasilkc',array('id'=>'formkelapacungkil' ,'class'=>'form-inline')); ?>
				<?php echo form_fieldset();?>
				
				<div class="input-append date">
					<input type="text" name="txtTanggal" class="input-small input-mask-date" 
						   value="<?php echo set_value('txtTanggal', $this->session->userdata('serverdate'));?>">
					<span class="add-on">
						<i class="icon-calendar"></i>
					</span>					
				</div>
				
				<select class="chzn-select" name="txtLine" id="dropdownLine" data-placeholder="Pilih Line" style="width: 100px">
					<option value=""></option>
					<?php
						foreach($cboline as $r):
							echo "<option value='".$r->IDLine."'>".$r->NamaLine."</option>";
						endforeach;
					?>
				</select>

				<select class="chzn-select" name="txtShift" id="dropdownShift" data-placeholder="Pilih Shift" style="width: 100px">
					<option value=""></option>
					<?php
						foreach($cboshift as $r):
							echo "<option value='".$r->IDShift."'>".$r->NamaShift."</option>";
						endforeach;
					?>
				</select>
				
				<select class="chzn-select" name="txtJamKerja" id="dropdownJamKerja" data-placeholder="Pilih Jam Kerja" style="width: 120px">
					<option value=""></option>
					<?php
						foreach($cbojamkerja as $r):
							echo "<option value='".$r->IDJamKerja."'>".$r->JamKerja."</option>";
						endforeach;
					?>
				</select>

				<button id="btnProses" class="btn btn-danger btn-small" type="submit">
					<i class="icon-edit"></i>
					Proses
				</button>
				
				<?php echo form_fieldset_close();?>
				<?php echo validation_errors() ? "<br/>".validation_errors() : '' ;?>
				<?php echo form_close(); ?>
			</div>
			
			<?php echo $message;?>
			
			<table id="tabellistkc" class="table table-hover table-bordered table-condensed">
				<thead>
					<tr>
						<th class="center">No</th>
						<th class="center">Tanggal</th>
						<th class="center">Shift</th>
						<th class="center">Line</th>
						<th class="center">Jam Kerja</th>
						<th class="right">Kelapa Cungkil</th>
						<th class="center w150">Aksi</th>
					</tr>
				</thead>
				<tbody>
					<?php
						$i=0;
						foreach ($record as $r){
							$i++;
							echo "<tr>
								<td class='center'>".$i."</td>
								<td class='center'>".tgl_ind($r->Tanggal)."</td>
								<td class='center'>".$r->NamaLine."</td>
								<td class='center'>".$r->IDShift."</td>
								<td class='center'>".$r->JamKerja."</td>
								<td class='right'>".floatval($r->TotalKC)."</td>
								<td class='center'>
									<a href='edit/kelapacungkil/?id=".$r->HasilHeaderID."' class='btn btn-mini btn-warning'><i class='icon-edit'></i> Edit</a>
									<a href='complete_trx/kelapacungkil/?id=".$r->HasilHeaderID."' class='btn btn-mini btn-success'><i class='icon-check'></i> Complete</a>
								</tr>";
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
	
	$('#tabellistkc').dataTable({
		"aoColumns": [
			  null, null, null, null, null,
			  { "bSortable": false },
			  { "bSortable": false }
			]
	});
</script>