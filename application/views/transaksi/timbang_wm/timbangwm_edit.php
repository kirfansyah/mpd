<?php echo form_open('transaksi/update_timbangwm/'.$detailid, array('id'=>'formEditWM' ,'class'=>'form-horizontal')); ?>

<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal">&times;</button>
	<h5 class="blue bigger">
		Edit Hasil Timbang White Meat
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
				<label class="control-label" for="inputEditTimbang">Timbangan</label>
				<div class="controls">
					<input name="txtEditTimbang" id="inputEditTimbang" type="number" step="0.01" min="0" class="input text-right"
						   value="<?php echo floatval($r->Timbangan);?>"/>
				</div>
			</div>
			
			<div class="control-group">
				<label class="control-label" for="inputEditPotLain">Potongan Lain</label>
				<div class="controls">
					<input name="txtEditPotLain" id="inputEditPotLain" type="number" step="0.01" min="0" class="input text-right"
						   value="<?php echo floatval($r->PotLain);?>"/>
				</div>
			</div>
			
			<div class="control-group">
				<label class="control-label" for="inputEditPotAir">Potongan Air</label>
				<div class="controls">
					<input name="txtEditPotAir" id="inputEditPotAir" type="number" step="0.01" min="0" class="input text-right"
						   value="<?php echo floatval($r->PotAir);?>"/>
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