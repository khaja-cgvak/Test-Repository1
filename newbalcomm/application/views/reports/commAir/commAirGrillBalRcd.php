<?php
$grillegriddata=$this->MProject->getGrilleBaldata($prcessid);
$prcdatas=$this->MProject->getPrjPrcLst($prcessid);
$prcdata=$prcdatas[0];  
$prcdatas=$this->MProject->getGrilleBalMain($prcessid);
$grillmain=$prcdatas[0];
$grillegrid=$grillegriddata->result_array();

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
			<th align="center" colspan="5">Measured</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td align="center" width="10%"><strong>Grille No.</strong></td>
			<td align="center" width="10%"><strong>Grille or Hood Size (mm)</strong></td>
			<td align="center" width="10%"><strong>Area m&sup2;</strong></td>
			<td align="center" width="10%"><strong>Design Volume m&sup3;/s</strong></td>
			<td align="center" width="10%"><strong>Design Velocity m/s</strong></td>
			<td align="center" width="10%"><strong>Final Velocity m/s</strong></td>
			<td align="center" width="10%"><strong>Measured Volume m&sup3;/s</strong></td>
			<td align="center" width="10%"><strong>Correction Factor</strong></td>
			<td align="center" width="10%"><strong>Actual Volume m&sup3;/s</strong></td>
			<td align="center" width="10%"><strong>Design %</strong></td>
		</tr>
		<?php
			foreach ($grillegrid as $gd_key => $gd_value) 
			{											
		?>
		<tr>
			<td><?php echo ((isset($gd_value['grilleno'])) ? $gd_value['grilleno'] : ''); ?></td>
			<td><?php echo ((isset($gd_value['grille_hood_size'])) ? $gd_value['grille_hood_size'] : ''); ?></td>
			<td><?php echo ((isset($gd_value['area'])) ? $gd_value['area'] : ''); ?></td>
			<td><?php echo ((isset($gd_value['design_volume'])) ? $gd_value['design_volume'] : ''); ?></td>
			<td><?php echo ((isset($gd_value['design_velocity'])) ? $gd_value['design_velocity'] : ''); ?></td>
			<td><?php echo ((isset($gd_value['final_velocity'])) ? $gd_value['final_velocity'] : ''); ?></td>
			<td><?php echo ((isset($gd_value['measured_volume'])) ? $gd_value['measured_volume'] : ''); ?></td>
			<td><?php echo ((isset($gd_value['correction_factor'])) ? $gd_value['correction_factor'] : ''); ?></td>
			<td><?php echo ((isset($gd_value['actual_volume'])) ? $gd_value['actual_volume'] : ''); ?></td>
			<td><?php echo ((isset($gd_value['design'])) ? $gd_value['design'] : ''); ?></td>
		</tr>
		<?php
		}
		?>
	</tbody>
</table><br>
<table border="1" cellpadding="10" cellspacing="0" width="100%">
	<tbody>
		<tr>
			<td>The measuring hood correction factor is derived by dividing the duct</td>
			<td>Duct Total m³/s:</td>
			<td><?php echo ((isset($grillmain['grilleductotal'])) ? $grillmain['grilleductotal'] : ''); ?></td>
		</tr>
		<tr>
			<td>Pitot traverse volume by the total of the grille indicated volume</td>
			<td>Hood/Grille Total:</td>
			<td><?php echo ((isset($grillmain['grillehoodtotal'])) ? $grillmain['grillehoodtotal'] : ''); ?></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>Correction Factor:</td>
			<td><?php echo ((isset($grillmain['grillecorrfactor'])) ? $grillmain['grillecorrfactor'] : ''); ?></td>
		</tr>

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