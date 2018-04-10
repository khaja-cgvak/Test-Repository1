<?php

$grillegriddata=$this->MProject->getDirGrilleBaldata($prcessid);
$prcdatas=$this->MProject->getPrjPrcLst($prcessid); 
$prcdata=$prcdatas[0];

$prcdatas=$this->MProject->getDirGrilleBalMain($prcessid);
$grillmain=$prcdatas[0];
$dirgrillegrid=$grillegriddata->result_array();

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
			<th class="text-center td_border_right" colspan="3">Design Information</th>
			<th class="text-center" colspan="5">Measured</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td align="center" width="12%"><strong>Ref No.</strong></td>
			<td align="center" width="12%"><strong>Grille Size (mm)</strong></td>
			<td align="center" width="12%"><strong>Design Volume l/s</strong></td>
			<td align="center" width="12%"><strong>Final Volume l/s</strong></td>
			<td align="center" width="12%"><strong>Correction Factor</strong></td>
			<td align="center" width="12%"><strong>Actual Volume l/s</strong></td>
			<td align="center" width="12%"><strong>%</strong></td>
			<td align="center" width="12%"><strong>Setting</strong></td>
		</tr>
		<?php
			foreach ($dirgrillegrid as $gd_key => $gd_value) 
			{											
		?>
		<tr>
			<td><?php echo ((isset($gd_value['ref_no'])) ? $gd_value['ref_no'] : ''); ?></td>
			<td><?php echo ((isset($gd_value['grille_size'])) ? $gd_value['grille_size'] : ''); ?></td>
			<td><?php echo ((isset($gd_value['design_volume'])) ? $gd_value['design_volume'] : ''); ?></td>
			<td><?php echo ((isset($gd_value['final_volume'])) ? $gd_value['final_volume'] : ''); ?></td>
			<td><?php echo ((isset($gd_value['correction_factor'])) ? $gd_value['correction_factor'] : ''); ?></td>
			<td><?php echo ((isset($gd_value['actual_volume'])) ? $gd_value['actual_volume'] : ''); ?></td>
			<td><?php echo ((isset($gd_value['record_percent'])) ? $gd_value['record_percent'] : ''); ?></td>
			<td><?php echo ((isset($gd_value['setting'])) ? $gd_value['setting'] : ''); ?></td>
		</tr>
		<?php
		}
		?>
	</tbody>
</table><br>
<table border="1" cellpadding="10" cellspacing="0" width="100%">
	<tbody>
		<tr>
			<td>Hood Correction Factor Is Served By Dividing The Duct</td>
			<td>Duct Total l/s:</td>
			<td><?php echo ((isset($grillmain['grilleductotal'])) ? $grillmain['grilleductotal'] : ''); ?></td>
		</tr>
		<tr>
			<td>Pitot Traverse Volume By The Grille Indicated Volume</td>
			<td>Hood/Grille Total:</td>
			<td><?php echo ((isset($grillmain['grillehoodtotal'])) ? $grillmain['grillehoodtotal'] : ''); ?></td>
		</tr>
		<tr>
			<td>Direct Volume Reading Using Alnor Hood</td>
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