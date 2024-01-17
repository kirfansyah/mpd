<div class="breadcrumbs" id="breadcrumbs">
	<ul class="breadcrumb">
		<li class="active">
			<i class="icon-home"></i>
			<a href="<?php echo site_url('home');?>">Home</a>

			<span class="divider">
				<i class="icon-angle-right"></i>
			</span>
		</li>
		
	</ul><!--.breadcrumb-->
</div>

<div class="page-content">
	<div class="row-fluid">
		<div class="span12">
			<h4>SELAMAT DATANG <strong><?php echo $this->session->userdata('username');?></strong></h4>
			<hr/>
			
			<div class="row-fluid">
				<div class="table-header">
					Login History <?php echo $this->session->userdata('serverdate');?>
				</div>

				<table id="tabelloginhistory" class="table table-hover table-bordered table-condensed">
					<thead>
						<tr>
							<th class="center middle">No</th>
							<th class="center middle">User ID</th>
							<th class="center middle">Login</th>
							<th class="center middle">Logout</th>
							<th class="center middle">Hostname</th>
							<th class="center middle">Device</th>
							<th class="center middle">Browser</th>
							<th class="center middle">Platform</th>
						</tr>
					</thead>
					<tbody>
						<?php
							$i=0;
							foreach ($log_history as $r){
								$i++;
								echo "<tr>
									<td class='center'>".$i."</td>
									<td class='left'>".$r->UserID."</td>
									<td class='center'>".datetime_eng($r->DateIn)."</td>
									<td class='center'>".datetime_eng($r->DateOut)."</td>
									<td class='center'>".$r->Hostname."</td>
									<td class='center'>".$r->Device."</td>
									<td class='center'>".$r->Browser."</td>
									<td class='center'>".$r->Platform."</td>
									</tr>";
							}
						?>
					</tbody>
				</table>
			</div>
		</div>
		
	</div>
	
</div><!--/.page-content-->

<script type="text/javascript">
	$('#tabelloginhistory').dataTable();
</script>
