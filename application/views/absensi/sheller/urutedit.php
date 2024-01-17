<?php echo form_open('absensi/sheller/update/'.$nomormesin, array('id'=>'formEditUrut' ,'class'=>'form-horizontal')); ?>

<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal">&times;</button>
	<h5 class="blue bigger">
		Edit Urutan Mesin Tenaga Kerja
		<span class="badge badge-success"> ID : <?php echo $detailid;?> </span>
	</h5>
</div>

<div class="modal-body">
	<div class="row-fluid">
		<div class="span12">
			<?php 
				echo form_fieldset();				
			?>
			
			<input type="hidden" name="txtEditDetailID" value="<?php echo $detailid;?>">
			<input type="hidden" name="txtEditHeaderID" value="<?php echo $headerid;?>">
			<input type="hidden" name="txtEditNoMesin" value="<?php echo $nomormesin;?>">
			
			<div class="control-group">
				<label class="control-label" for="dropdownNama">Nama</label>
				<div class="controls">
					<?php
					$extra_nama = 'id="dropdownNama" data-placeholder="Nama" ';
					$option_nama[''] = '';
					$selected = $fixno;
					
					foreach($listurut as $r):
						$option_nama[$r->FixNo] = $r->Nama;						
					endforeach;
					
					echo form_dropdown('txtEditNama', $option_nama, $selected, $extra_nama);
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
		Update
	</button>
	<button class="btn btn-small" data-dismiss="modal">
		<i class="icon-remove"></i>
		Batal
	</button>	
</div>

<?php echo form_close(); ?>