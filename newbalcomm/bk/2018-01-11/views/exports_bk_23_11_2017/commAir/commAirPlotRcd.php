<?php
$plotrcdMsddata=$this->MProject->getPlotRcdMsddata($prcessid);
$prcdesign=$this->MProject->getPlotRcdDsndata($prcessid);
$prcdatas=$this->MProject->getPrjPrcLst($prcessid);
$prcdata=$prcdatas[0];            
$plotrcd=$plotrcdMsddata->result_array();

$prcdatas=$prcdesign->result_array();
$prcdesign=$prcdatas[0];
?>

<table border="0" cellpadding="10" cellspacing="0" width="100%">
	<thead>
		<tr>
			<th align="right" colspan="2" style="border:0px;"><strong><?php echo $title; ?></strong></th>
		</tr>
	</thead>
</table><br>
<table border="1" cellpadding="10" cellspacing="0" width="100%">	
	<tbody>
		<tr>
			<td><strong>Project:</strong> <?php echo $prodata['projectname']; ?></td>
			<td><strong>Ref:</strong> <?php echo $prcdata['referenceno']; ?></td>
		</tr>
		<tr>
			<td><strong>System:</strong> <?php 
				$projectsystemid=$prcdata['system'];
				$allsystems=$this->MReports->getSystemsbyid($proid,$projectsystemid);
				echo $allsystems[0]['systemname']; ?>
			</td>
			<td><?php 
				$sheetnumber=$prcdata['sheetnumber'];
				echo $this->MReports->displaySheetNumText(PRJPRCLST,intval($sheetnumber),$masterprcid);
			?></td>
		</tr>
	</tbody>
</table><br>
<table border="1" cellpadding="10" cellspacing="0" width="100%">
	<thead>
		<tr>
			<th align="center" colspan="2" width="30%">Design Information</th>
			<th align="center" colspan="2" width="70%">Measured</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td colspan="2" width="30%" valign="top">
				<table border="1" width="100%" cellpadding="5">
					<tr>
						<td align="center" width="50%">Traverse<br>Ref.</td>
						<td width="50%"><?php echo ((isset($prcdesign['traverseref'])) ? $prcdesign['traverseref'] : ''); ?></td>
					</tr>
					<tr>
						<td align="center" width="50%">Traverse<br>Location</td>
						<td width="50%"><?php echo ((isset($prcdesign['traverselocation'])) ? $prcdesign['traverselocation'] : ''); ?></td>
					</tr>
					<tr>
						<td align="center" width="50%">Duct Size<br>mm</td>
						<td width="50%">
							<table border="1" width="100%" cellpadding="0">
								<tr>
									<td class="no_border"><?php echo ((isset($prcdesign['duct_size_mm'])) ? $prcdesign['duct_size_mm'] : ''); ?></td>
									<td class="no_border">&nbsp;|&nbsp;</td>
									<td class="no_border"><?php echo ((isset($prcdesign['duct_size_mm1'])) ? $prcdesign['duct_size_mm1'] : ''); ?></td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td align="center" width="50%">Duct<br>Area m&sup2;</td>
						<td width="50%"><?php echo ((isset($prcdesign['duct_area_m2'])) ? $prcdesign['duct_area_m2'] : ''); ?></td>
					</tr>
					<tr>
						<td align="center" width="50%">Flow<br>Rate m&sup3;/s</td>
						<td width="50%"><?php echo ((isset($prcdesign['flow_rate_m3_s'])) ? $prcdesign['flow_rate_m3_s'] : ''); ?></td>
					</tr>
				</table>
			</td>											
			<td width="45%" valign="top">
				<table border="1" cellpadding="10" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th align="center">1</th>
							<th align="center">2</th>
							<th align="center">3</th>
							<th align="center">4</th>
							<th align="center">5</th>
							<th align="center">6</th>
							<th align="center">7</th>
							<th align="center">8</th>
						</tr>														
					</thead>
					<tbody>
					<?php
					#echo '<pre>'; print_r($plotrcd); echo '</pre>';
					foreach ($plotrcd as $gd_key => $gd_value) 
					{
					?>
						<tr>
							<td><?php echo (isset($gd_value['volume1']) ? $gd_value['volume1'] : ''); ?></td>
							<td><?php echo (isset($gd_value['volume2']) ? $gd_value['volume2'] : ''); ?></td>
							<td><?php echo (isset($gd_value['volume3']) ? $gd_value['volume3'] : ''); ?></td>
							<td><?php echo (isset($gd_value['volume4']) ? $gd_value['volume4'] : ''); ?></td>
							<td><?php echo (isset($gd_value['volume5']) ? $gd_value['volume5'] : ''); ?></td>
							<td><?php echo (isset($gd_value['volume6']) ? $gd_value['volume6'] : ''); ?></td>
							<td><?php echo (isset($gd_value['volume7']) ? $gd_value['volume7'] : ''); ?></td>
							<td><?php echo (isset($gd_value['volume8']) ? $gd_value['volume8'] : ''); ?></td>
						</tr>	
					<?php
					}
					?>													
					</tbody>
				</table>
			</td>
			<td width="25%" valign="top">
				<table border="1" cellpadding="10" cellspacing="0" width="100%">
					<tbody>
						<tr>	
							<td align="center">Total Velocity m/s</td>
							<td align="center">Average Velocity m/s</td>
							<td align="center">Actual Volume m&sup3;/s</td>
						</tr>
						<tr>

							<td><?php echo ((isset($prcdesign['total_velocity'])) ? $prcdesign['total_velocity'] : ''); ?></td>
							<td><?php echo ((isset($prcdesign['average_velocity'])) ? $prcdesign['average_velocity'] : ''); ?></td>
							<td><?php echo ((isset($prcdesign['actual_volume'])) ? $prcdesign['actual_volume'] : ''); ?></td>
						</tr>
						<tr>
							
							<td colspan="2" align="center">Design %</td>
							<td><?php echo ((isset($prcdesign['design'])) ? $prcdesign['design'] : ''); ?></td>
						</tr>
						<tr>
							<td colspan="2" align="center">No Test Points</td>
							<td><?php echo ((isset($prcdesign['no_test_points'])) ? $prcdesign['no_test_points'] : ''); ?></td>
						</tr>
						<tr>
							<td colspan="2" align="center">Static Pressure (Pa)</td>
							<td><?php echo ((isset($prcdesign['static_presssure'])) ? $prcdesign['static_presssure'] : ''); ?></td>
						</tr>
					</tbody>
				</table>
			</td>
		</tr>
		
	</tbody>
</table>
<br>
<table border="1" cellpadding="10" cellspacing="0" width="100%">
	<tbody>
		<tr>
			<td><strong>Comments:</strong><br><?php echo $prcdata['comments']; ?></td>
		</tr>		
	</tbody>
</table><br>
<table border="1" cellpadding="10" cellspacing="0" width="100%">
	<tbody>
		<tr>
			<td width="40%"><strong>Engineer:</strong>&nbsp;
			<?php
				$getUserByid=$this->MReports->getUserByid($prcdata['engineerid']);
				$getUserByiddata=$getUserByid->result_array();
				echo $getUserByiddata[0]['firstname'].' '.$getUserByiddata[0]['lastname'];
			?>
			</td>
			<td width="60%"><strong>Date:</strong>&nbsp;<?php echo date(DT_FORMAT,strtotime($prcdata['reportdate'])); ?></td>
		</tr>
	</tbody>
</table>