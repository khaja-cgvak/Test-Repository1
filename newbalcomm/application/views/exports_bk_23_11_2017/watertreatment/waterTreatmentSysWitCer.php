<?php
	$prcdatas=$this->MProject->getWTsyscertificate($prcessid);
    $prcdata=$prcdatas[0];
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
				$projectsystemid=$prcdata['projectsystemid'];
				$allsystems=$this->MReports->getSystemsbyid($proid,$projectsystemid);
				echo $allsystems[0]['systemname']; ?>
			</td>
			<td><?php 
				$sheetnumber=$prcdata['sheetnumber'];
				echo $this->MReports->displaySheetNumText(PRJPRCLST,intval($sheetnumber),$masterprcid);
			?></td>
		</tr>
		<tr>
			<td colspan="2" align="center">
				<b>System Witness Certificate</b><br>
				<h3 style="margin:0">Chemical Cleaning</h3>
				The System detailed within has been witnessed to the Clients representative, <br>the test data is a true record of the system performance achieved
			</td>
		</tr>
	</tbody>
</table><br>
<table border="1" cellpadding="10" cellspacing="0" width="100%">
	<tbody>
		<tr>
			<td width="40%"><strong>Witnessed By:</strong></td>
			<td width="60%"><?php echo $prcdata['u1fname'].' '.$prcdata['u1lname']; ?></td>
		</tr>
		<tr>
			<td width="40%"><strong>Company:</strong></td>
			<td width="60%"><?php echo $prcdata['companyname']; ?></td>
		</tr>
		<tr>
			<td width="40%"><strong>Date:</strong></td>
			<td width="60%"><?php echo date(DT_FORMAT,strtotime($prcdata['witnessdate'])); ?></td>
		</tr>
	</tbody>
</table><br>
<table border="1" cellpadding="10" cellspacing="0" width="100%">
	<tbody>
		<tr>
			<td width="40%"><strong>Test Completed By:</strong></td>
			<td width="60%"><?php echo $prcdata['u2fname'].' '.$prcdata['u2lname']; ?></td>
		</tr>
		<tr>
			<td width="40%"><strong>Services Contractor:</strong></td>
			<td width="60%"><?php echo $prcdata['servicecontractorname']; ?></td>
		</tr>
		<tr>
			<td width="40%"><strong>Date:</strong></td>
			<td width="60%"><?php echo date(DT_FORMAT,strtotime($prcdata['servicecontractdate'])); ?></td>
		</tr>
	</tbody>
</table><br>
<table border="1" cellpadding="10" cellspacing="0" width="100%">
	<tbody>
		<tr>
			<td><strong>Comments:</strong><br><?php echo $prcdata['comments']; ?></td>
		</tr>		
	</tbody>
</table>