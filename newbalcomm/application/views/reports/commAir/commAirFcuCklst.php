<?php
$prcdatas=$this->MProject->getCASyspreck($prcessid);
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
<table  border="1" cellpadding="10" cellspacing="0" width="100%">
	<tbody>
		<?php
			$getProcesSecCat=$this->Common_model->getProcesSecCatByPrcId($masterprcid);
			if($getProcesSecCat->num_rows()>0)
			{
				$getProcesSecCat_data=$getProcesSecCat->result_array();
				foreach ($getProcesSecCat_data as $key => $value) {
					$getProcesSecByCatid=$this->Common_model->getProcesSecByCatid($value['id']);											
					$getProcesSecByCatid_data=$getProcesSecByCatid->result_array();
					$rowtotal=$getProcesSecByCatid->num_rows();
					$rowinc=0;
					if($rowtotal>0)
					{
						foreach ($getProcesSecByCatid_data as $key1 => $value1) {
							$rowinc++;

							$sectionvalue='';
							$procesSectionId=0;

							if(intval($prcessid)!=0)
							{
								$processMasterdetails=$this->MProject->getCAFcuCkDetails($prcessid,$value1['id'],1);
								if(!empty($processMasterdetails))
								{
									if($processMasterdetails->num_rows()>0)
									{
										$processMasterdata=$processMasterdetails->result_array();
										$sectionvalue=$processMasterdata[0]['fcu_description'];
										$procesSectionId=$processMasterdata[0]['id'];
									}
								}
							}

							echo '<tr>
								<td width="50%">'.$value1['sectionname'].'</td>
								<td width="50%">'.$sectionvalue.'</td>
							</tr>';
						}
					}
				}
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