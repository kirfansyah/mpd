<?php echo form_open('transaksi/update_keranjang/tambah', array('id'=>'formTambah' ,'class'=>'form-horizontal')); ?>

<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal">&times;</button>
	<h5 class="blue bigger"><i class="icon-bitbucket"></i>
		Edit Tambah Isi Keranjang Mesin <?php echo $nomormesin;?>
	</h5>
</div>

<div class="modal-body">
	<div class="row-fluid">
		<div class="span12">
			<?php 
				echo form_fieldset();
			?>
			
			<input type="hidden" name="txtTambahNoMesin" value="<?php echo $nomormesin;?>">
			<input type="hidden" name="txtUrutanTambah" value="<?php echo $urutantambah;?>">
			
			<?php
				if($krj1 === '' || $krj1 === 0){
					echo form_hidden('txtTambahIsi1','0');
				} else {
			?>
			<div class="control-group">
				<label class="control-label" for="inputTambahIsi">Keranjang 1</label>
				<div class="controls">
					<input name="txtTambahIsi1" id="inputTambahIsi" type="text" class="input text-right numeric"
						   placeholder="0" value="<?php echo $krj1;?>"/>
				</div>
			</div>
			<?php } ?>
			
			<?php
				if($krj2 === '' || $krj2 === 0){
					echo form_hidden('txtTambahIsi2','0');
				} else {
			?>
			<div class="control-group">
				<label class="control-label" for="inputTambahIsi">Keranjang 2</label>
				<div class="controls">
					<input name="txtTambahIsi2" id="inputTambahIsi" type="text" class="input text-right numeric"
						   placeholder="0" value="<?php echo $krj2;?>"/>
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

<script src="<?php echo base_url();?>assets/js/jquery.validate.min.js"></script>
<script type="text/javascript">
	$('.numeric').numeric({
		decimal	: false,
		negative: false
	});
</script>
