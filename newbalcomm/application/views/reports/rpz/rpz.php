<?php
$prcdatas=array();
$prcdatas1=$this->MProject->getPRZsection(RPZMASTER,$prcessid);
$prcdatas=$prcdatas1;

$prcdatas2=$this->MProject->getPRZsection(RPZVALVES,$prcessid);
if(!empty($prcdatas2))
{
    unset($prcdatas2['id']);
    unset($prcdatas2['projectprocesslistmasterid']);
    unset($prcdatas2['rpzid']);

    $prcdatas=array_merge($prcdatas, $prcdatas2);                
}

$prcdatas3=$this->MProject->getPRZsection(RPZCKVALV,$prcessid);
if(!empty($prcdatas3))
{
    unset($prcdatas3['id']);
    unset($prcdatas3['projectprocesslistmasterid']);
    unset($prcdatas3['rpzid']);

    $prcdatas=array_merge($prcdatas, $prcdatas3);                
}

/*$prcdatas4=$this->MProject->getPRZsection(RPZDATA,$prcessid);
if(!empty($prcdatas4))
{
    unset($prcdatas4['id']);
    unset($prcdatas4['projectprocesslistmasterid']);
    unset($prcdatas4['rpzid']);

    $prcdatas=array_merge($prcdatas, $prcdatas4);                
}*/

$rpzdata=$prcdatas;

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
			<td><?php 
				$sheetnumber=$prcdata['sheetnumber'];
				echo $this->MReports->displaySheetNumText(PRJPRCLST,intval($sheetnumber),$masterprcid);
			?></td>
		</tr>
	</tbody>
</table><br>
<table border="1" class="tblnormal" cellpadding="10" cellspacing="10" width="100%">
	<tbody>
		<tr>
			<td width="33%"><strong>Company Owning Valve</strong><br><?php echo $rpzdata['comownvalve']; ?></td>
			<td width="34%"><strong>Water Suppliers Customer</strong><br><small>(if Different)</small><br><?php echo $rpzdata['watersuppcustomer']; ?></td>
			<td width="33%"><strong>Water Supplier</strong><br>
			<?php
				$valvesigneddata=$this->Common_model->getUserById(intval($rpzdata['watersupp']));
				$valvesigned=$valvesigneddata['signature'];
				echo $valvesigneddata['firstname'].' '.$valvesigneddata['lastname']
			?>
		</tr>
		<tr>
			<td valign="top"><strong>Location Address of Valve</strong><br><?php echo $rpzdata['valvelocation']; ?>
			<br><br><strong>&nbsp;&nbsp;&nbsp;Tel:</strong><?php echo $rpzdata['valvelocationtel']; ?>
			</td>
			<td valign="top"><strong>Valve</strong><br>
				<table border="1" cellpadding="10" cellspacing="0" width="100%">
					<tr>
						<td>Make</td>												
						<td><?php echo $rpzdata['valvemake']; ?></td>						
					</tr>
					<tr>
						<td>Size</td>
						<td><?php echo $rpzdata['valvesize']; ?></td>
					</tr>
					<tr>
						<td>Serial</td>
						<td><?php echo $rpzdata['valveserial']; ?></td>						
					</tr>
					<tr>
						<td>Model</td>
						<td><?php echo $rpzdata['valvemodel']; ?></td>
					</tr>
				</table>
			</td>
			<td valign="top" style="padding:0px;">
				<table border="1" class="tblnormal" cellpadding="10" cellspacing="10" width="100%">
					<tbody>
						<tr>
							<td>
								<strong>Permission to Turn off Supply</strong><br><small>(Capital letters)</small><br>
								<?php echo ($rpzdata['perturnoffsupply']); ?>
							</td>
						</tr>
						<tr><td>&nbsp;</td></tr>
						<tr>
							<td>
								<strong>Signed</strong><br>
								<?php //echo ($rpzdata['valvesigned']); ?>
								<img src="<?php echo $valvesigned; ?>" alt="No Signature">
							</td>
						</tr>
					</tbody>
				</table>
			</td>
		</tr>
		<tr>
			<td><strong>Location of Valve On Site</strong><br><small>(Building No.)</small><br><?php echo $rpzdata['locvalveonsite']; ?></td>
			<td><strong>Accessibility & Clearances</strong><br><?php echo $rpzdata['accessibility']; ?></td>
			<td><strong>Time of Turn Off</strong><br><small>(24 Hour Clock)</small><br><?php echo $rpzdata['timeturnoff']; ?></td>
		</tr>
		<tr>
			<td valign="top"><strong>Installation Company</strong><br><small>(If Known)</small><br><?php echo $rpzdata['installcompany']; ?>
			<br><br><strong>&nbsp;&nbsp;&nbsp;Tel:</strong><?php echo $rpzdata['installcompanytel']; ?>
			</td>
			<td valign="top" style="padding:0px;">
				<table border="1" class="tblnormal" cellpadding="10" cellspacing="10" width="100%">
					<tbody>
						<tr>
							<td>
								<strong>Unobstructed Drain Air Gap</strong><br>
								<?php echo ($rpzdata['unobstrucdrain']); ?>
							</td>
						</tr>
						<tr><td>&nbsp;</td></tr>
						<tr>
							<td>
								<strong>Strainer Present</strong><br>
								<?php echo ($rpzdata['strainerpresent']); ?>
							</td>
						</tr>
					</tbody>
				</table>
			</td>
			<td valign="top" style="padding:0px;">
				<table border="1" class="tblnormal" cellpadding="10" cellspacing="10" width="100%">
					<tbody>
						<tr>
							<td>
								<strong>Meter Reading</strong><br><small>(If appilicable)</small><br>
								<?php echo ($rpzdata['meterreading']); ?>
							</td>
						</tr>
						<tr><td>&nbsp;</td></tr>
						<tr>
							<td>
								<strong>Valve Installation Date</strong><br>
								<?php 
									if((!empty($rpzdata['valveinstalldate']))&&($rpzdata['valveinstalldate']!='0000-00-00 00:00:00'))
									{
										echo (date(DT_FORMAT, strtotime($rpzdata['valveinstalldate']))); 
									}
								?>
							</td>
						</tr>
					</tbody>
				</table>
			</td>
		</tr>
		<tr>
			<td><strong>Type of Plant/Equip Being Supplied</strong><br><?php echo $rpzdata['plantype']; ?></td>
			<td><strong>Isolating Valve No.2 Tight</strong><br><?php echo $rpzdata['isolatingvalve2']; ?></td>
			<td><strong>Commissioning Date (1st Test)</strong><br>
			<?php 
				if((!empty($rpzdata['commdate']))&&($rpzdata['commdate']!='0000-00-00 00:00:00'))
			{
				echo date(DT_FORMAT, strtotime($rpzdata['commdate']));
			}
			?></td>
		</tr>
	</tbody>
</table><br>
<hr>
<br>
<table border="1" cellpadding="10" cellspacing="0" width="100%">
	<thead>
		<tr>
			<th class="no_border">&nbsp;</th>
			<th>Check Valve 1</th>
			<th>Relief Value</th>
			<th>Check Valve 2</th>
			<th>Check Valve 1</th>
			<th>Check Valve 2</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<th>Initial Test</th>
			<td>
				<div class="checkbox">
					<?php
						$inickvalve1='';
						if(($_POST['inickvalve1'])||($rpzdata['inickvalve1']==1))
						{
							$inickvalve1=' checked="checked"';
						}
					?>

				  <label><input type="checkbox" value="1" name="inickvalve1" <?php echo $inickvalve1; ?>>Closed</label>
				</div>
				<div class="checkbox">
					<?php
						$inileaked1='';
						if(($_POST['inileaked1'])||($rpzdata['inileaked1']==1))
						{
							$inileaked1=' checked="checked"';
						}
					?>
				  <label><input type="checkbox" value="1" name="inileaked1" <?php echo $inileaked1; ?>>Tight Leaked</label>
				</div>
			</td>
			<td>Opened at <?php echo $rpzdata['inireliefvalve']; ?> Bar</td>
			<td><div class="checkbox">
				<?php
						$inickvalve2='';
						if(($_POST['inickvalve2'])||($rpzdata['inickvalve2']==1))
						{
							$inickvalve2=' checked="checked"';
						}
					?>
				  <label><input type="checkbox" value="1" name="inickvalve2" <?php echo $inickvalve2; ?>>Closed</label>
				</div>
				<div class="checkbox">
					<?php
						$inileaked2='';
						if(($_POST['inileaked2'])||($rpzdata['inileaked2']==1))
						{
							$inileaked2=' checked="checked"';
						}
					?>
				  <label><input type="checkbox" value="1" name="inileaked2" <?php echo $inileaked2; ?>>Tight Leaked</label>
				</div></td>
			<td>Differential Pressure <?php echo $rpzdata['inidiffpressure1']; ?> Bar</td>
			<td>Differential Pressure <?php echo $rpzdata['inidiffpressure2']; ?> Bar</td>
		</tr>
		<tr>
			<th>Repairs & Materials Used</th>
			<td colspan="5"><?php echo $rpzdata['repairmaterial']; ?></td>
		</tr>
		<tr>
			<th>Test After Repair</th>
			<td>
				<div class="checkbox">
					<?php
						$repckvalve1='';
						if(($_POST['repckvalve1'])||($rpzdata['repckvalve1']==1))
						{
							$repckvalve1=' checked="checked"';
						}
					?>
				  <label><input type="checkbox" value="1" name="repckvalve1" <?php echo $repckvalve1; ?>>Tight</label>
				</div>
				<div class="checkbox">
					<?php
						$repleaked1='';
						if(($_POST['repleaked1'])||($rpzdata['repleaked1']==1))
						{
							$repleaked1=' checked="checked"';
						}
					?>
				  <label><input type="checkbox" value="1" name="repleaked1" <?php echo $repleaked1; ?>>Leaked</label>
				</div>
			</td>
			<td>Opened at <?php echo $rpzdata['repreliefvalve']; ?> Bar</td>
			<td><div class="checkbox">
				<?php
						$repckvalve2='';
						if(($_POST['repckvalve2'])||($rpzdata['repckvalve2']==1))
						{
							$repckvalve2=' checked="checked"';
						}
					?>
				  <label><input type="checkbox" value="1" name="repckvalve2" <?php echo $repckvalve2; ?>>Tight</label>
				</div>
				<div class="checkbox">
					<?php
						$repleaked2='';
						if(($_POST['repleaked2'])||($rpzdata['repleaked2']==1))
						{
							$repleaked2=' checked="checked"';
						}
					?>
				  <label><input type="checkbox" value="1" name="repleaked2" <?php echo $repleaked2; ?>>Leaked</label>
				</div></td>
			<td>Differential Pressure <?php echo $rpzdata['repdiffpressure1']; ?> Bar</td>
			<td>Differential Pressure <?php echo $rpzdata['repdiffpressure2']; ?> Bar</td>
		</tr>
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
			<td><strong>Testers Name</strong></td>
			<td>
				<?php
				$testernamedata=$this->Common_model->getUserById(intval($rpzdata['testername']));
				$testername=$testernamedata['signature'];
				echo $testernamedata['firstname'].' '.$testernamedata['lastname']
			?>
				
			</td>
			<td><strong>Turn On Time</strong></td>
			<td><?php echo $rpzdata['turnontime']; ?></td>
		</tr>
		<tr>
			<td><strong>Testers No.</strong></td>
			<td><?php echo $rpzdata['testerno']; ?></td>
			<td><strong>Date of Completion</strong></td>
			<td><?php 
			if((!empty($rpzdata['completedate']))&&($rpzdata['completedate']!='0000-00-00 00:00:00'))
			{
				echo date(DT_FORMAT, strtotime($rpzdata['completedate'])); 
			}
			?></td>
		</tr>
		<tr>
			<td><strong>Signed</strong></td>
			<td>
				<?php //echo $rpzdata['testersign']; ?>
				<img src="<?php echo $testername; ?>" alt="No Signature">				
			</td>
			<td><strong>Date of Next Date</strong></td>
			<td><?php 
			if((!empty($rpzdata['nextestdate']))&&($rpzdata['nextestdate']!='0000-00-00 00:00:00'))
			{
				echo date(DT_FORMAT, strtotime($rpzdata['nextestdate']));
			}
			?></td>
		</tr>

	</tbody>
</table>