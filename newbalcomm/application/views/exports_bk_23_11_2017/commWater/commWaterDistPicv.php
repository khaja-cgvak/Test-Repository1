<?php
	$prcdatas=$this->MProject->getPrjPrcLst($prcessid);
    $prcdata=$prcdatas[0];

    $cwwaterdiststrcd=$this->MProject->getcwWaterDistPicvdata($prcessid);
    $grillegrid=$cwwaterdiststrcd->result_array();
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
<?php 
if($cwwaterdiststrcd->num_rows()>0)
{
	?>
<table  border="1" cellpadding="10" cellspacing="0" width="100%">
	<thead>
		<tr>
			<th align="center" colspan="8">Design Information</th>
			<th align="center" colspan="3">Measured</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td align="center" width="10%"><strong>Ref.No</strong></td>
			<td align="center" width="10%"><strong>Manuf</strong></td>
			<td align="center" width="10%"><strong>Type</strong></td>
			<td align="center" width="10%"><strong>PICV<br>Setting</strong></td>
			<td align="center" width="10%"><strong>Size<br>mm</strong></td>
			<td align="center" width="10%"><strong>Kvs</strong></td>
			<td align="center" width="10%"><strong>Flow<br>i/s</strong></td>
			<td align="center" width="10%"><strong>PD<br>kpa</strong></td>
			<td align="center" width="10%"><strong>PD<br>kpa</strong></td>
			<td align="center" width="10%"><strong>Flow<br>i/s</strong></td>
			<td align="center" width="10%"><strong>%<br>Design</strong></td>
		</tr>
		<?php
			foreach ($grillegrid as $gd_key => $gd_value) 
			{											
		?>
		<tr>
			<td><?php echo ((isset($gd_value['deinforefnum'])) ? $gd_value['deinforefnum'] : ''); ?></td>
			<td><?php echo ((isset($gd_value['deinfomanuf'])) ? $gd_value['deinfomanuf'] : ''); ?></td>
			<td><?php echo ((isset($gd_value['deinfotype'])) ? $gd_value['deinfotype'] : ''); ?></td>
			<td><?php echo ((isset($gd_value['deinfopicvset'])) ? $gd_value['deinfopicvset'] : ''); ?></td>
			<td><?php echo ((isset($gd_value['deinfosizemm'])) ? $gd_value['deinfosizemm'] : ''); ?></td>
			<td><?php echo ((isset($gd_value['deinfokvs'])) ? $gd_value['deinfokvs'] : ''); ?></td>
			<td><?php echo ((isset($gd_value['deinforflowis'])) ? $gd_value['deinforflowis'] : ''); ?></td>
			<td><?php echo ((isset($gd_value['deinfopdkpa'])) ? $gd_value['deinfopdkpa'] : ''); ?></td>
			<td><?php echo ((isset($gd_value['measurpdkpa'])) ? $gd_value['measurpdkpa'] : ''); ?></td>
			<td><?php echo ((isset($gd_value['measurflowis'])) ? $gd_value['measurflowis'] : ''); ?></td>
			<td><?php echo ((isset($gd_value['measurpercen'])) ? $gd_value['measurpercen'] : ''); ?></td>
		</tr>
		<?php
		}
		?>
	</tbody>
</table><br>
<?php
}
?>
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