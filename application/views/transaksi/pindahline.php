<?php
echo form_open('transaksi/do_changeline/'.$halaman, array('id'=>'formPindah' ,'class'=>'form-horizontal')); 
?>

<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal">&times;</button>
	<h5 class="blue bigger"><i class="icon-level-up"></i>
		Pindah Line
	</h5>
</div>

<div class="modal-body">
	<div class="row-fluid">
		<div class="span12">
			<?php 
				echo form_fieldset();
			?>
			
			<div class="control-group">
				<label class="control-label" for="dropdownLine">Pindah Ke Line</label>
				<div class="controls">
					<?php
					$extra_line = ' id="dropdownLine" data-placeholder="Pilih Line" style="width: 100px"';
					$option_line[''] = '';
					foreach($cboline as $r):
						$option_line[$r->IDLine] = $r->NamaLine;
					endforeach;
					echo form_dropdown('txtLine', $option_line, $idline, $extra_line);
					?>
				</div>
			</div>
			
			<?php 
				echo form_fieldset_close();
			?>
		</div>
	</div>
</div>

<div class="modal-footer center">
	<button class="btn btn-small btn-primary" type="submit">
		<i class="icon-ok"></i>
		Pindahkan
	</button>
	<button class="btn btn-small" data-dismiss="modal">
		<i class="icon-remove"></i>
		Batal
	</button>	
</div>

<?php echo form_close();