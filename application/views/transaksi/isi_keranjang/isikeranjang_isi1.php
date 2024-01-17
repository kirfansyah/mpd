<?php echo form_open('transaksi/update_keranjang/isi', array('id'=>'formIsi' ,'class'=>'form-horizontal')); ?>

<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal">&times;</button>
	<h5 class="blue bigger"><i class="icon-bitbucket"></i>
		Ubah Isi Keranjang Mesin <?php echo $nomormesin;?> Untuk Shift Selanjutnya 
	</h5>
</div>

<div class="modal-body">
	<div class="row-fluid">
		<div class="span12">
			<?php 
				echo form_fieldset();
			?>
			
			<input type="hidden" name="txtIsiNoMesin" value="<?php echo $nomormesin;?>">
			
			<?php
				if($isi1 === '' || $isi1 === 0){
					echo form_hidden('txtIsi1','0');
				} else {
			?>
			<div class="control-group">
				<label class="control-label" for="inputIsi">Keranjang 1</label>
				<div class="controls">
					<input name="txtIsi1" id="inputIsi" type="text" class="input text-right numeric"
						   placeholder="0" value="<?php echo $isi1;?>"/>
				</div>
			</div>
			<?php } ?>
			
			<?php
				if($isi2 === '' || $isi2 === 0){
					echo form_hidden('txtIsi2','0');
				} else {
			?>
			<div class="control-group">
				<label class="control-label" for="inputIsi">Keranjang 2</label>
				<div class="controls">
					<input name="txtIsi2" id="inputIsi" type="text" class="input text-right numeric"
						   placeholder="0" value="<?php echo $isi2;?>"/>
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
		Simpan
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
