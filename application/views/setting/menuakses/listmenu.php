<table class="table table-striped table-hover table-bordered">
	<thead>
		<tr>
			<th class="center" width="70">Pilih</th>
			<th>Menu</th>
			<th>Kategori</th>
		</tr>
	</thead>
	<tbody>
		<?php 
			$i=0;
			$j=0;
		?>
		<?php foreach($menulist as $row):?>
		<tr>
			<td class="center">				
				<?php 
				if ($row->Pilih == 1){
					
					if($row->MenuParentName == NULL){
						echo "<label><input type='checkbox' disabled='' name='chk[".$i++."]' value='$row->MenuID' checked=''><span class='lbl'></span></label>";
					}else{
						echo "<label><input type='checkbox' name='chk[".$i++."]' value='$row->MenuID' checked=''><span class='lbl'></span></label>";
					}
					
				}else{
					
					if($row->MenuParentName == NULL){
						echo "<label><input type='checkbox' disabled='' name='chk[".$i++."]' value='$row->MenuID' onClick='return togglecheck();' ><span class='lbl'></span></label>";
					}else{
						echo "<label><input type='checkbox' name='chk[".$i++."]' value='$row->MenuID' onClick='return togglecheck();' ><span class='lbl'></span></label>";
					}
					
				};
				
				echo "<label><input type='hidden' name='menu[".$j++."]' value='$row->MenuID'><span class='lbl'></span></label>";
				?>
			</td>
			<td><?php echo "<i class='".$row->MenuIcon."'></i>  ".$row->MenuName;?></td>
			<td><?php 
					if ($row->MenuParentName == NULL){
						echo "<span class='label label-info arrowed arrowed-righ'>Menu Utama</span>";
					}else{
						echo "<span class='label label-success arrowed-in'>".$row->MenuParentName."</span>";
					}
				?>
			</td>
		</tr>
		<?php endforeach;?>
	</tbody>
</table>