<?php
	$prcdatas=$this->MProject->getCWSyspreck($prcessid);
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
</table><br>
<?php
	$getProcesSecCat=$this->Common_model->getProcesSecCatByPrcId(15);
	if($getProcesSecCat->num_rows()>0)
	{
		$getProcesSecCat_data=$getProcesSecCat->result_array();
		foreach ($getProcesSecCat_data as $key => $value) {
			$getProcesSecByCatid=$this->Common_model->getProcesSecByCatid($value['id']);											
			$getProcesSecByCatid_data=$getProcesSecByCatid->result_array();
			
			if($getProcesSecByCatid->num_rows()>0)
			{
				?>
			      	<table border="1" cellpadding="10" cellspacing="0" width="100%">	
			      		<thead>
			      			<tr>
			      				<th width="33%"><?php echo $value['sectioncategory']; ?></th>
			      				<th width="33%" class="text-center">Check</th>
			      				<th width="34%" class="text-center">Comments</th>
			      			</tr>
			      		</thead>
			      		<tbody>
			      		<?php
			      		foreach ($getProcesSecByCatid_data as $key1 => $value1) {
			      		
			      		$commAirPreCommopt=0;
						$commAirPreCommcmd='';
						$procesSectionId=0;	

						$option1='';
						$option2='';
						$option3='';

						if(intval($prcessid)!=0)
						{
							$processMasterdetails=$this->MProject->getcwProcessMasterDetails($prcessid,$value1['id'],1);
							if(!empty($processMasterdetails))
							{
								if($processMasterdetails->num_rows()>0)
								{
									$processMasterdata=$processMasterdetails->result_array();
									
									$commAirPreCommopt=$processMasterdata[0]['checked'];
									$commAirPreCommcmd=$processMasterdata[0]['comments'];
									$procesSectionId=$processMasterdata[0]['id'];

									if($commAirPreCommopt==1)
									{
										$option1='Yes';
									}
									elseif($commAirPreCommopt==2)
									{
										$option1='No';
									}
									elseif($commAirPreCommopt==3)
									{
										$option1='Not Applicable';
									}
									else
									{

									}

								}
							}
						}
			      		?>
			      			<tr>
			      				<td width="33%" class="text-left"><?php echo $value1['sectionname']; ?></td>
			      				<td width="33%" class="text-center"><?php echo $option1; ?></td>
			      				<td width="34%"><?php echo ((isset($commAirPreCommcmd)) ? $commAirPreCommcmd : ''); ?></td>
			      			</tr>
		      			<?php
			      		}
			      		?>			      			
			      		</tbody>
			      	</table><br>
				<?php
			}
		}
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