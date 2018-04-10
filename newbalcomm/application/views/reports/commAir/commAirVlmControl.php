<?php
$prcdatas=$this->MProject->getPrjPrcLst($prcessid);
$prcdata=$prcdatas[0]; 
$grillegriddata=$this->MProject->getVlmCtrldata($prcessid);
$vlmctrlgrid=$grillegriddata->result_array();
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
<table  border="1" cellpadding="10" cellspacing="0" width="100%">
	<thead>
		<tr>
			<th align="center" colspan="5">Design Information</th>
			<th align="center" colspan="4">Measured</th>
			<th align="center" colspan="4">Measured</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td align="center" width="7%"><strong>Vav Ref No.</strong></td>
			<td align="center" width="9%"><strong>Vav Address Ref.</strong></td>
			<td align="center" width="9%"><strong>Vav Normal Volume</strong></td>
			<td align="center" width="7%"><strong>Max Flow m&sup3;/s</strong></td>
			<td align="center" width="8%"><strong>Min Flow m&sup3;/s</strong></td>
			<td align="center" width="7%"><strong>Min &#8710;P Pa</strong></td>
			<td align="center" width="7%"><strong>Min Volts V</strong></td>
			<td align="center" width="7%"><strong>Min Vol. M&sup3;/s</strong></td>
			<td align="center" width="8%"><strong>Min %</strong></td>
			<td align="center" width="7%"><strong>Max &#8710;P Pa</strong></td>
			<td align="center" width="7%"><strong>Max Volts V</strong></td>
			<td align="center" width="7%"><strong>Max Vol. M&sup3;/s</strong></td>
			<td align="center" width="7%"><strong>Max %</strong></td>
		</tr>
		<?php
		$gd_key=0;
			foreach ($vlmctrlgrid as $gd_key => $gd_value) 
			{											
		?>
		<tr class="vlmctrlgridtr vlmctrlgridtr_<?php echo $gd_key; ?>">
			<td><?php echo (isset($gd_value['vav_refno'])) ? $gd_value['vav_refno'] : ''; ?></td>
			<td><?php echo (isset($gd_value['vav_addr_ref'])) ? $gd_value['vav_addr_ref'] : ''; ?></td>
			<td><?php echo (isset($gd_value['vav_nonimal_value'])) ? $gd_value['vav_nonimal_value'] : ''; ?></td>
			<td><?php echo (isset($gd_value['max_flow_m3_s'])) ? $gd_value['max_flow_m3_s'] : ''; ?></td>
			<td><?php echo (isset($gd_value['min_flow_m3_s'])) ? $gd_value['min_flow_m3_s'] : ''; ?></td>
			<td><?php echo (isset($gd_value['min_p_pa'])) ? $gd_value['min_p_pa'] : ''; ?></td>
			<td><?php echo (isset($gd_value['min_volts'])) ? $gd_value['min_volts'] : ''; ?></td>
			<td><?php echo (isset($gd_value['min_vol_m3s'])) ? $gd_value['min_vol_m3s'] : ''; ?></td>
			<td><?php echo (isset($gd_value['min_percentage'])) ? $gd_value['min_percentage'] : ''; ?></td>
			<td><?php echo (isset($gd_value['max_p_pa'])) ? $gd_value['max_p_pa'] : ''; ?></td>
			<td><?php echo (isset($gd_value['max_volts'])) ? $gd_value['max_volts'] : ''; ?></td>
			<td><?php echo (isset($gd_value['max_vol_m3s'])) ? $gd_value['max_vol_m3s'] : ''; ?></td>
			<td><?php echo (isset($gd_value['max_percentage'])) ? $gd_value['max_percentage'] : ''; ?></td>
		</tr>
		<?php
		}
		?>
	</tbody>
</table><br>
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