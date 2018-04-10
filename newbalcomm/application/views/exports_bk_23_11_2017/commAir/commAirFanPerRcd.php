<?php
	$prcdatas=$this->MProject->getPrjPrcLst($prcessid);
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
</table>
<?php
	$procesSecCatid=5;
	$getProcesSecByCatid=$this->Common_model->getProcesSecByCatid($procesSecCatid);
	$getProcesSecByCatid_data=$getProcesSecByCatid->result_array();
	
	if($getProcesSecByCatid->num_rows()>0)
	{
		?>
		
		<h5><strong>FAN:</strong></h5>
      	<table border="1" cellpadding="10" cellspacing="0" width="100%">
      		<thead>
      			<tr>
      				<th width="33%">Item</th>
      				<th width="33%" align="center">Static Check</th>
      				<th width="34%" align="center">Comments</th>
      			</tr>
      		</thead>
      		<tbody>
      		<?php
      		foreach ($getProcesSecByCatid_data as $key1 => $value1) {
      		
      		$commAirPreCommopt='';
			$commAirPreCommcmd='';
			$procesSectionId=0;	

			$option1='';
			$option2='';
			$option3='';

			if(intval($prcessid)!=0)
			{
				$processMasterdetails=$this->MProject->getFanPrefDetails($prcessid,$value1['id'],1);
				if(!empty($processMasterdetails))
				{
					if($processMasterdetails->num_rows()>0)
					{
						$processMasterdata=$processMasterdetails->result_array();
						
						$commAirPreCommopt=$processMasterdata[0]['staticcheck'];
						$commAirPreCommcmd=$processMasterdata[0]['comments'];
						$procesSectionId=$processMasterdata[0]['id'];

					}
				}
			}
      		?>
      			<tr>
      				<td width="33%" class="text-left">
      					<table border="1" cellpadding="10" cellspacing="0" width="100%"><tr><td class="no_border"><?php echo $value1['sectionname']; ?></td><td class="no_border" align="right"><?php echo $value1['sectionuom']; ?></td></tr></table></td>
      				<td width="33%" class="text-center"><?php echo ((isset($commAirPreCommopt)) ? $commAirPreCommopt : ''); ?></td>
      				<td width="34%"><?php echo ((isset($commAirPreCommcmd)) ? $commAirPreCommcmd : ''); ?></td>
      			</tr>
  			<?php
      		}
      		?>			      			
      		</tbody>
      	</table>
		<?php
	}

	$procesSecCatid=6;
	$getProcesSecByCatid=$this->Common_model->getProcesSecByCatid($procesSecCatid);
	$getProcesSecByCatid_data=$getProcesSecByCatid->result_array();
	
	if($getProcesSecByCatid->num_rows()>0)
	{
		?>
		<h5><strong>MOTOR:</strong></h5>
      	<table border="1" cellpadding="10" cellspacing="0" width="100%">
      		<thead>
      			<tr>
      				<th width="33%">Item</th>
      				<th width="33%" class="text-center">Static Check</th>
      				<th width="34%" class="text-center">Comments</th>
      			</tr>
      		</thead>
      		<tbody>
      		<?php
      		foreach ($getProcesSecByCatid_data as $key1 => $value1) {
      		
      		$commAirPreCommopt='';
			$commAirPreCommcmd='';
			$procesSectionId=0;	

			$option1='';
			$option2='';
			$option3='';

			if(intval($prcessid)!=0)
			{
				$processMasterdetails=$this->MProject->getFanPrefDetails($prcessid,$value1['id'],1);
				if(!empty($processMasterdetails))
				{
					if($processMasterdetails->num_rows()>0)
					{
						$processMasterdata=$processMasterdetails->result_array();
						
						$commAirPreCommopt=$processMasterdata[0]['staticcheck'];
						$commAirPreCommcmd=$processMasterdata[0]['comments'];
						$procesSectionId=$processMasterdata[0]['id'];

					}
				}
			}
      		?>
      			<tr>
      				<td width="33%" class="text-left"><table border="1" cellpadding="10" cellspacing="0" width="100%"><tr><td class="no_border"><?php echo $value1['sectionname']; ?></td><td class="no_border" align="right"><?php echo $value1['sectionuom']; ?></td></tr></table></td>
      				<td width="33%" class="text-center"><?php echo ((isset($commAirPreCommopt)) ? $commAirPreCommopt : ''); ?></td>
      				<td width="34%"><?php echo ((isset($commAirPreCommcmd)) ? $commAirPreCommcmd : ''); ?></td>
      			</tr>
  			<?php
      		}
      		?>			      			
      		</tbody>
      	</table>
		<?php
	}

	$procesSecCatid=7;
	$getProcesSecByCatid=$this->Common_model->getProcesSecByCatid($procesSecCatid);
	$getProcesSecByCatid_data=$getProcesSecByCatid->result_array();
	
	if($getProcesSecByCatid->num_rows()>0)
	{
		?>
		<h5><strong>PERFORMANCE:</strong></h5>
      	<table border="1" cellpadding="10" cellspacing="0" width="100%">
      		<thead>
      			<tr>
      				<th width="33%">Item</th>
      				<th width="23%" class="text-center">Design Data</th>
      				<th width="22%" class="text-center">Test Data No.1</th>
      				<th width="22%" class="text-center">Test Data No.2</th>
      			</tr>
      		</thead>
      		<tbody>
      		<?php
      		foreach ($getProcesSecByCatid_data as $key1 => $value1) {
      		
      		$commAirPreCommopt='';
      		$commAirPreCommtestdata='';
      		$commAirPreCommtestdata1='';
			$commAirPreCommcmd='';
			$procesSectionId=0;	

			$option1='';
			$option2='';
			$option3='';

			if(intval($prcessid)!=0)
			{
				$processMasterdetails=$this->MProject->getFanPrefDetails($prcessid,$value1['id'],1);
				if(!empty($processMasterdetails))
				{
					if($processMasterdetails->num_rows()>0)
					{
						$processMasterdata=$processMasterdetails->result_array();
						
						$commAirPreCommopt=$processMasterdata[0]['staticcheck'];
						$commAirPreCommtestdata=$processMasterdata[0]['testdata'];
						$commAirPreCommtestdata1=$processMasterdata[0]['testdata1'];

						$testdata_ans=$processMasterdata[0]['testdata_ans'];
						$testdata1_ans=$processMasterdata[0]['testdata1_ans'];

						$commAirPreCommcmd=$processMasterdata[0]['comments'];
						$procesSectionId=$processMasterdata[0]['id'];

						if($commAirPreCommopt==1)
						{
							$option1='checked="checked"';
						}
						elseif($commAirPreCommopt==2)
						{
							$option2='checked="checked"';
						}
						elseif($commAirPreCommopt==3)
						{
							$option3='checked="checked"';
						}
						else
						{

						}

					}
				}
			}
      		?>
      			<tr>
      				<td width="33%" class="text-left"><table border="1" cellpadding="10" cellspacing="0" width="100%"><tr><td class="no_border"><?php echo $value1['sectionname']; ?></td><td class="no_border" align="right"><?php echo $value1['sectionuom']; ?></td></tr></table></td>
      				<td width="23%" class="text-center"><?php echo ((isset($commAirPreCommopt)) ? $commAirPreCommopt : ''); ?></td>
      				<td width="22%">
      					<table border="1" cellpadding="10" cellspacing="0" width="100%"><tr><td class="no_border"><?php echo ((isset($commAirPreCommtestdata)) ? $commAirPreCommtestdata : ''); ?></td>
      					<?php echo ((($testdata_ans!="")) ? '<td class="no_border" align="center">'.$testdata_ans.'</td>' : ''); ?>     
      					</tr></table> 						
      					</td>
      				<td width="22%">
      					<table border="1" cellpadding="10" cellspacing="0" width="100%"><tr><td class="no_border"><?php echo ((isset($commAirPreCommtestdata1)) ? $commAirPreCommtestdata1 : ''); ?></td>
      					<?php echo ((($testdata1_ans!="")) ? '<td class="no_border" align="center">'.$testdata1_ans.'</td>' : ''); ?>
      					</tr></table>
      						
      					</td>
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