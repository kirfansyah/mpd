<?php echo form_open('transaksi/update_hasilkc/'.$detailid, array('id'=>'formEditKC' ,'class'=>'form-horizontal')); ?>

<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal">&times;</button>
	<h5 class="blue bigger">
		Edit Hasil Kelapa Cungkil
		<span class="badge badge-success"> ID : <?php echo $detailid;?> </span>
	</h5>
</div>

<div class="modal-body">
	<div class="row-fluid">
		<div class="span12">
			<?php 
				echo form_fieldset();
				
				foreach($record as $r){
			?>
			
			<input type="hidden" name="txtEditNoMesin" value="<?php echo $r->NomorMesin;?>">
			
			<div class="control-group">
				<label class="control-label" for="inputEditHasilKC">Kelapa Cungkil</label>
				<div class="controls">
					<input name="txtEditHasilKC" id="inputEditHasilKC" type="number" min="0" class="input text-right numeric"
						   value="<?php echo $r->HasilKC;?>"/>
				</div>
			</div>
			
			<?php 
				};
				echo form_fieldset_close();
			?>
		</div>
	</div>
</div>

<div class="modal-footer center">
	<button class="btn btn-small btn-primary" type="submit">
		<i class="icon-ok"></i>
		Update
	</button>
	<button class="btn btn-small" data-dismiss="modal">
		<i class="icon-remove"></i>
		Batal
	</button>	
</div>

<?php echo form_close(); ?>

<script type="text/javascript">
	$('.numeric').numeric({
		decimalPlaces: 4,
		negative: false
	})
</script>
