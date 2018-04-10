<?php

$timshtmaster=$this->MProject->getcwTimesheetMaster($prcessid);
$timesheetdata=$this->MProject->getcwTimesheetData($prcessid);

$prcdatas=$this->MProject->getPrjPrcLst($prcessid);
$prcdata=$prcdatas[0];

$timesheetdata=$timesheetdata->result_array();
$timshtmaster=$timshtmaster->result_array();

$tshdays=array(1=>'Monday',2=>'Tuesday',3=>'Wednesday',4=>'Thursday',5=>'Friday',6=>'Saturday',7=>'Sunday');

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
		<tr>
			<td><strong>Client:</strong>&nbsp;
				<?php $userincharge = $prodata['userincharge']; 
                    $client_name=$this->Common_model->getCustomerById($userincharge);
                    echo $client_name['custname'];
                    //$clientsign=$client_name['csignature'];
                ?>
            </td>
			<td></td>
		</tr>
	</tbody>
</table><br>
<table border="1" cellpadding="10" cellspacing="0" width="100%">
	<thead>
		<tr>
			<th class="text-center">Day</th>
			<th class="text-center">Date</th>
			<th class="text-center">Hours</th>
			<th class="text-center">Engineers Name</th>
		</tr>
	</thead>
	<tbody>
		<?php
			foreach ($timesheetdata as $key => $value) {
		?>
		<tr>
			<th><?php echo $tshdays[$value['dayid']]; ?></th>
			<td><?php echo ((!empty($value['daydate']) && ($value['daydate']!='0000-00-00 00:00:00')) ? date(DT_FORMAT,strtotime($value['daydate'])) : ''); ?></td>
			<td><?php echo ((!empty($value['dayhours']) && ($value['dayhours']!='0000-00-00 00:00:00')) ? date(TIME_FORMAT,strtotime($value['dayhours'])) : ''); ?></td>
			<td>
				<?php
					if($value['dayengg']!=0)
					{
						$getUserByid=$this->MReports->getUserByid($value['dayengg']);
						$getUserByiddata=$getUserByid->result_array();
						echo $getUserByiddata[0]['firstname'].' '.$getUserByiddata[0]['lastname'];
					}
				?>
			</td>
		</tr>
		<?php
		}
		?>
	</tbody>
</table><br>
<table border="1" cellpadding="10" cellspacing="0" width="100%">
	<tbody>
		<tr>
			<td><strong>Comments/Description:</strong><br><?php echo $prcdata['comments']; ?></td>
		</tr>		
	</tbody>
</table><br>
<table border="1" cellpadding="10" cellspacing="0" width="100%">
	<thead>
		<tr>
			<th align="center">Clients Signature</th>
			<th align="center">Position</th>
			<th align="center">Date</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td><?php $clientsign=$timshtmaster[0]['clientsign']; if(!empty($clientsign)) { ?><img src="<?php echo $clientsign; ?>" alt="No Signature"><?php } ?></td>
			<td><?php echo $timshtmaster[0]['position']; ?></td>
			<td><?php echo ((isset($timshtmaster[0]['signdate'])) ? date(DT_FORMAT,strtotime($timshtmaster[0]['signdate'])) : ''); ?></td>
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