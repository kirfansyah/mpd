<?php echo form_open('transaksi/update_keranjang/sisa', array('id'=>'formSisa' ,'class'=>'form-horizontal')); ?>

<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal">&times;</button>
	<h5 class="blue bigger"><i class="icon-bitbucket"></i>
		 Edit Sisa Isi Keranjang Mesin <?php echo $nomormesin;?>
	</h5>
</div>

<div class="modal-body">
	<div class="row-fluid">
		<div class="span12">
			<?php 
				echo form_fieldset();
			?>
			
			<input type="hidden" name="txtSisaNoMesin" value="<?php echo $nomormesin;?>">
			
			<?php
				if($sisa1 === '' || $sisa1 === 0){
					echo form_hidden('txtSisa1','0');
				} else {
			?>
			<div class="control-group">
				<label class="control-label" for="inputSisa">Keranjang 1</label>
				<div class="controls">
					<input name="txtSisa1" id="inputSisa" type="number" min="0" class="input text-right numeric"
						   placeholder="0" value="<?php echo $sisa1;?>"/>
				</div>
			</div>
			<?php } ?>
			
			<?php
				if($sisa2 === '' || $sisa2 === 0){
					echo form_hidden('txtSisa2','0');
				} else {
			?>
			<div class="control-group">
				<label class="control-label" for="inputSisa">Keranjang 2</label>
				<div class="controls">
					<input name="txtSisa2" id="inputSisa" type="number" min="0" class="input text-right numeric"
						   placeholder="0" value="<?php echo $sisa2;?>"/>
				</div>
			</div>
			<?php } ?>
		
			<?php 
				echo form_fieldset_close();
			?>
		</div>
	</div>
</div>

<div class="modal-footer center">
	<button class="btn btn-small btn-primary" type="submit">
		<i class="icon-ok"></i>
		Simpan Update
	</button>
	<button class="btn btn-small" data-dismiss="modal">
		<i class="icon-remove"></i>
		Batal
	</button>	
</div>

<?php echo form_close(); ?>

<script type="text/javascript">
	$('.numeric').numeric({
		decimal	: false,
		negative:false
	});	
</script>
