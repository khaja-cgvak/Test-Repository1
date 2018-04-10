<?php
	$prcdatas=$this->MProject->getPrjPrcLst($prcessid);
    $prcdata=$prcdatas[0];

    $cwwaterdiststrcd=$this->MProject->getcwWaterHSWdata($prcessid);
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
			<th align="center">Valve Ref</th>
			<th align="center">Blending Valve Temperature Range 41 to 43℃</th>
			<th align="center">Fail Safe Operation</th>
			<th align="center">Comments</th>
		</tr>
	</thead>
	<tbody>
		<?php
			foreach ($grillegrid as $gd_key => $gd_value) 
			{											
		?>
		<tr>
			<td><?php echo ((isset($gd_value['valveref'])) ? $gd_value['valveref'] : ''); ?></td>
			<td><?php echo ((isset($gd_value['valvetemp'])) ? $gd_value['valvetemp'] : ''); ?></td>
			<td><?php 
			if (isset($gd_value['failsafeopt']))
			{
				if($gd_value['failsafeopt']==1)
				{
					echo 'Set Correctly/Operational';
				}
				else
				{
					echo 'Requires Attention';
				}
			}
				?></td>
			<td><?php echo ((isset($gd_value['hwscmts'])) ? $gd_value['hwscmts'] : ''); ?></td>
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