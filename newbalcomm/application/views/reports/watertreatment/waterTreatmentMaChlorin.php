<?php
	$prcdatas=$this->MProject->getPrjPrcLst($prcessid);
    $prcdata=$prcdatas[0];

    $mainChlorin=$this->MProject->getMainChlorin($prcessid);
    $mainChlorin=$mainChlorin[0];
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
			<td width="40%"><strong>Contract Name:</strong></td>
			<td width="60%"><?php echo $mainChlorin['contractname']; ?></td>
		</tr>
		<tr>
			<td width="40%"><strong>Client:</strong></td>
			<td width="60%"><?php $userincharge = $prodata['userincharge']; 
                        $client_name=$this->Common_model->getCustomerById($userincharge);
                        echo $client_name['custname'];
                        ?></td>
		</tr>
		<tr>
			<td width="40%"><strong>Balcomm Ref:</strong></td>
			<td width="60%"><?php echo $prcdata['referenceno']; ?></td>
		</tr>
		<tr>
			<td width="40%"><strong>Lab Ref:</strong></td>
			<td width="60%"><?php echo $mainChlorin['lebref']; ?></td>
		</tr>
	</tbody>
</table><br>			
<div align="center"><br><p><em>The Folllowing services have been sterllised in accordance with <b>BS6700:-</b></em></p></div><br>
<table border="1" cellpadding="10" cellspacing="0" width="100%">
	<tbody>
		<tr>
			<td width="40%"><strong>Systems:</strong></td>
			<td width="60%" align="center"><?php $projectsystemid=$prcdata['system'];
				$allsystems=$this->MReports->getSystemsbyid($proid,$projectsystemid);
				echo $allsystems[0]['systemname']; ?></td>
		</tr>
		<tr>
			<td width="40%"><strong>Sample Point:</strong></td>
			<td width="60%" align="center"><?php echo $mainChlorin['smppoint']; ?></td>
		</tr>
		<tr>
			<td width="40%"><strong>Pipe Length:</strong></td>
			<td width="60%" align="center"><?php echo $mainChlorin['pilen1'].'  Metters '.$mainChlorin['pilen2']; ?></td>
		</tr>
		<tr>
			<td width="40%"><strong>Pipe Diameter:</strong></td>
			<td width="60%" align="center"><?php echo $mainChlorin['pidiameter1'].'  mm '.$mainChlorin['pidiameter2']; ?></td>
		</tr>
		<tr>
			<td width="40%"><strong>Flush Rate:</strong></td>
			<td width="60%" align="center"><?php echo $mainChlorin['flushrate1'].'  L/S '.$mainChlorin['flushrate2']; ?></td>
		</tr>
	</tbody>
</table><br>
<div align="center"><br><p><em>Swabbing & flushing tasks were performed prior to disinfection.</em></p></div><br>
<table border="1" cellpadding="10" cellspacing="0" width="100%">
	<tbody>
		<tr>
			<td width="40%"><strong>Disinfection Chemical Used:</strong></td>
			<td width="60%" align="center"><?php echo $mainChlorin['disinfection_used']; ?></td>
		</tr>
		<tr>
			<td width="40%"><strong>Chlorine Level of Source Water:</strong></td>
			<td width="60%" align="center"><?php echo $mainChlorin['levelsourcewater1'].' MG/L '.$mainChlorin['levelsourcewater2']; ?></td>
		</tr>
		<tr>
			<td width="40%"><strong>Chlorine Level After Dosing:</strong></td>
			<td width="60%" align="center"><?php echo $mainChlorin['levelafterdosing1'].' MG/L '.$mainChlorin['levelafterdosing2']; ?></td>
		</tr>
		<tr>
			<td width="40%"><strong>Contact Time:</strong></td>
			<td width="60%" align="center"><?php
												$contactime=array('00','00');
												if(isset($mainChlorin['contactime']))
												{
													$contactime=explode(':', $mainChlorin['contactime']);
												}
												echo $contactime[0].' Hours '.$contactime[1].' Minutes';
											?></td>
		</tr>
		<tr>
			<td width="40%"><strong>Chlorine Level After Contact:</strong></td>
			<td width="60%" align="center"><?php echo $mainChlorin['levelaftercontact1'].' MG/L '.$mainChlorin['levelaftercontact2']; ?></td>
		</tr>
		<tr>
			<td width="40%"><strong>Chlorine Residual After Flushing:</strong></td>
			<td width="60%" align="center"><?php echo $mainChlorin['resiafterflush1'].' MG/L '.$mainChlorin['resiafterflush2']; ?></td>
		</tr>
		<tr>
			<td width="40%"><strong>Flushing Time to Clear:</strong></td>
			<td width="60%" align="center">
				<?php
					$flushtimeclr=array('00','00');
					if(isset($mainChlorin['flushtimeclr']))
					{
						$flushtimeclr=explode(':', $mainChlorin['flushtimeclr']);
					}	
					echo $flushtimeclr[0].' Hours '.$flushtimeclr[1].' Minutes';	
				?>
			</td>
		</tr>
		<tr>
			<td width="40%"><strong>On Site Taste Result (Post Flush):</strong></td>
			<td width="60%" align="center"><?php echo $mainChlorin['onsitetasterst']; ?></td>
		</tr>
		<tr>
			<td width="40%"><strong>On Site Odour Result (Post Flush):</strong></td>
			<td width="60%" align="center"><?php echo $mainChlorin['onsiteodourrst']; ?></td>
		</tr>
		<tr>
			<td width="40%"><strong>Confirmation of Pipework Capped:</strong></td>
			<td width="60%" align="center"><strong>To Be Confirmed By Services Contrator</strong></td>
		</tr>		
	</tbody>
</table><br>
<div align="center"><br><p><em>Independent Laboratory analysis has confirmed that the following parameters are within EEC guidelines.</em></p></div><br>
<table border="1" cellpadding="10" cellspacing="0" width="100%">
	<tbody>
		<tr>
			<td width="33%"><strong>TVC 3 days @ 22°</strong></td>
			<td width="34%" align="center"><strong>OFFICE TO COMPLETE</strong></td>
			<td width="33%" align="center"><?php echo $mainChlorin['tvc3']; ?></td>
		</tr>
		<tr>
			<td width="33%"><strong>TVC 2 days @ 37°</strong></td>
			<td width="34%" align="center"><strong>OFFICE TO COMPLETE</strong></td>
			<td width="33%" align="center"><?php echo $mainChlorin['tvc2']; ?></td>
		</tr>
		<tr>
			<td width="33%"><strong>Coliforms/100ml</strong></td>
			<td width="34%" align="center"><strong>OFFICE TO COMPLETE</strong></td>
			<td width="33%" align="center"><?php echo $mainChlorin['coliforms']; ?></td>
		</tr>
		<tr>
			<td width="33%"><strong>E.coli/100ml</strong></td>
			<td width="34%" align="center"><strong>OFFICE TO COMPLETE</strong></td>
			<td width="33%" align="center"><?php echo $mainChlorin['ecoil']; ?></td>
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