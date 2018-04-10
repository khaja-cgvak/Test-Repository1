<?php

$grillegriddata=$this->MProject->getVlmCtrlBoxdata($prcessid);
$prcdatas=$this->MProject->getPrjPrcLst($prcessid);
$prcdata=$prcdatas[0];            
$vlmctrlboxgrid=$grillegriddata->result_array();
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
			<th class="text-center td_border_right" colspan="5">Design Information</th>
			<th class="text-center" colspan="4">Measured</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td align="center" width="7%"><strong>CAV Ref No.</strong></td>
			<td align="center" width="9%"><strong>CAV Address Ref.</strong></td>
			<td align="center" width="9%"><strong>CAV Design Volume</strong></td>
			<td align="center" width="7%"><strong>Max Flow m&sup3;/s</strong></td>
			<td align="center" width="8%"><strong>Max &#8710;P Pa</strong></td>
			<td align="center" width="7%"><strong>Max &#8710;P Pa</strong></td>
			<td align="center" width="7%"><strong>Max Volts V</strong></td>
			<td align="center" width="7%"><strong>Min Vol. M&sup3;/s</strong></td>
			<td align="center" width="8%"><strong>Max %</strong></td>
		</tr>
		<?php
		$gd_key=0;
			foreach ($vlmctrlboxgrid as $gd_key => $gd_value) 
			{											
		?>
		<tr>
			<td><?php echo ((isset($gd_value['cav_refno'])) ? $gd_value['cav_refno'] : ''); ?></td>
			<td><?php echo ((isset($gd_value['cav_addr_ref'])) ? $gd_value['cav_addr_ref'] : ''); ?></td>
			<td><?php echo ((isset($gd_value['cav_design_volume'])) ? $gd_value['cav_design_volume'] : ''); ?></td>
			<td><?php echo ((isset($gd_value['max_flow_m3_s'])) ? $gd_value['max_flow_m3_s'] : ''); ?></td>
			<td><?php echo ((isset($gd_value['max_p_pa_designed'])) ? $gd_value['max_p_pa_designed'] : ''); ?></td>
			<td><?php echo ((isset($gd_value['max_p_pa_measured'])) ? $gd_value['max_p_pa_measured'] : ''); ?></td>
			<td><?php echo ((isset($gd_value['max_volts'])) ? $gd_value['max_volts'] : ''); ?></td>
			<td><?php echo ((isset($gd_value['max_vol_m3s'])) ? $gd_value['max_vol_m3s'] : ''); ?></td>
			<td><?php echo ((isset($gd_value['max_percentage'])) ? $gd_value['max_percentage'] : ''); ?></td>
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