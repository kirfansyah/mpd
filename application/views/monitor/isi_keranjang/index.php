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
			<a href="#">Monitor</a>
			<span class="divider">
				<i class="icon-angle-right"></i>
			</span>
		</li>
		
		<li class="active">
			Pengisian Keranjang
		</li>
	</ul><!--.breadcrumb-->
</div>

<div class="page-content">
	<div class="row-fluid">
		<div class="span12">
			<div class="judul">
				<i class="icon-table middle"></i>  Monitor Pengisian Keranjang
			</div>
			<div class="page-header">
				<?php echo form_open('monitor/pengisian_keranjang',array('id'=>'formIsiKeranjang' ,'class'=>'form-horizontal')); ?>
				<?php echo form_fieldset();?>
				
				<div class="input-append date">
					<input type="text" name="txtTanggal" class="input-mask-date" 
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

				<button id="btnRefresh" name="btnRefresh" class="btn btn-danger btn-small" type="submit">
					<i class="icon-refresh"></i>
					Refresh
				</button>
				
				<?php echo form_fieldset_close();?>				
				<?php echo validation_errors() ? "<br/>".validation_errors() : '' ;?>
				<?php echo form_close(); ?>
			</div>
			<!--
			<div id="isi">
				<div class="trx-user-info trx-user-info-striped">				
					<div class="trx-info-row">
						<div class="trx-info-name"> Tanggal </div>
						<div class="trx-info-value"><?php //echo $tanggaltrn;?></div>
					</div>
					<div class="trx-info-row">
						<div class="trx-info-name"> Line </div>
						<div class="trx-info-value"><?php //echo $namaline;?></div>
					</div>
					<div class="trx-info-row">
						<div class="trx-info-name"> Shift </div>
						<div class="trx-info-value"><?php //echo $shift;?></div>
					</div>
					<div class="trx-info-row">
						<div class="trx-info-name"> Jam Kerja </div>
						<div class="trx-info-value"><?php //echo $jamkerja;?></div>
					</div>
					<div class="trx-info-row">
						<div class="trx-info-name"> Juru Catat </div>
						<div class="trx-info-value"><?php //echo $this->session->userdata('username');?></div>
					</div>
				</div>
			
   
				
			</div>
			-->
			
			<table id="tabellistisi" class="table table-hover table-bordered table-condensed">
				<thead>
					<tr>
						<th class="center">No</th>
						<th class="center">Tanggal</th>
						<th class="center">Line</th>
						<th class="center">Shift</th>
						<th class="center">Jam Kerja</th>
						<th class="right">Butir</th>
						<th class="right">Sisa</th>						
						<th class="center">Detail</th>
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
								<td class='right'>".$r->Penambahan."</td>
								<td class='right'>".$r->Sisa."</td>								
								<td class='center'><a href='detail/keranjang/?id=".$r->HasilHeaderID."' class='btn btn-mini btn-info'><i class='icon-info'></i></a>
								</tr>";
						}
					?>
				</tbody>
			</table>
			
		</div><!--/.span12-->
	</div><!--/.row-fluid-->
</div><!--/.page-content-->

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
	
	$('#tabellistisi').dataTable({
		"aoColumns": [
			  null, null, null, null, null,
			  { "bSortable": false },
			  { "bSortable": false },			  
			  { "bSortable": false }
			]
	});
</script>