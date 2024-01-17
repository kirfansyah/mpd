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
		
		<li>
			<a href="#">Hasil</a>
			<span class="divider">
				<i class="icon-angle-right"></i>
			</span>
		</li>
		
		<li class="active">
			<?php echo $namaline;?>
		</li>
	</ul><!--.breadcrumb-->
</div>

<div class="page-content">
	
	<div class="row-fluid">
		<div class="span12">
			<div class="space-6"></div>
			
			<div class="judul">
				Monitor Hasil Kerja
				<span class="badge badge-success"> ID Transaksi : <?php echo $headerid;?> </span>
			</div>
			
			<div class="trx-user-info trx-user-info-striped">				
				<div class="trx-info-row">
					<div class="trx-info-name"> Tanggal </div>
					<div class="trx-info-value"><?php echo $tanggal;?></div>
				</div>
				<div class="trx-info-row">
					<div class="trx-info-name"> Line </div>
					<div class="trx-info-value"><?php echo $namaline;?></div>
				</div>
				<div class="trx-info-row">
					<div class="trx-info-name"> Shift </div>
					<div class="trx-info-value"><?php echo $shift;?></div>
				</div>
				<div class="trx-info-row">
					<div class="trx-info-name"> Jam Kerja </div>
					<div class="trx-info-value"><?php echo $jamkerja;?></div>
				</div>
				<!--<div class="trx-info-row">
					<div class="trx-info-name"> Juru Catat </div>
					<div class="trx-info-value"><?php //echo $jurucatat;?></div>
				</div>-->
				<div class="trx-info-row">
					<div class="trx-info-name"> Juru Catat White Meat</div>
					<div class="trx-info-value"><?php echo $jurucatat['WM'];?></div>
				</div>
				<div class="trx-info-row">
					<div class="trx-info-name">Juru Catat Air Kelapa </div>
					<div class="trx-info-value"><?php echo $jurucatat['AK'];?></div>
				</div>
			</div>
			
			<a href="<?php echo site_url('monitor/hasil');?>" class="btn btn-default btn-medium">Kembali</a>
			<div class="space-10"></div>
			
			<div class="tabbable">
				<ul class="nav nav-tabs" id="tabhasil">

					<li class="active">
						<a data-toggle="tab" href="#hasilsheller">
							Hasil Sheller
						</a>
					</li>

					<li>
						<a data-toggle="tab" href="#hasilparer">
							Hasil Parer
						</a>
					</li>
					
					<li>
						<a data-toggle="tab" href="#hasilshellerharian">
							Hasil Sheller Harian
						</a>
					</li>

					<li>
						<a data-toggle="tab" href="#hasilparerharian">
							Hasil Parer Harian
						</a>
					</li>

				</ul>

				<div class="tab-content">
					<div id="hasilsheller" class="tab-pane in active">
						<?php echo $_sheller;?>
					</div>

					<div id="hasilparer" class="tab-pane">
						<?php echo $_parer;?>
					</div>
					
					<div id="hasilshellerharian" class="tab-pane">
						<?php echo $_sheller_harian;?>
					</div>

					<div id="hasilparerharian" class="tab-pane">
						<?php echo $_parer_harian;?>
					</div>
				</div>
			</div><!--.tabbable-->
			
		</div>
	</div>
</div>