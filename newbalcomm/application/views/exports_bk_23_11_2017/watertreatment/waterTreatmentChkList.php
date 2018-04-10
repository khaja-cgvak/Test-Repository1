<?php
	$prcdatas=$this->MProject->getPrjPrcLst($prcessid);
    $prcdata=$prcdatas[0];

    $checkListdatas=$this->MProject->getWTcheckList($prcessid);
    $checkList=$checkListdatas->result_array();
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
<!-- Loop Start -->
<?php
$getProcesSecCat=$this->Common_model->getProcesSecCatByPrcId($masterprcid);
$getProcesSecCatcnt=$getProcesSecCat->num_rows();
if($getProcesSecCatcnt>0)
{
	$getProcesSecCat_data=$getProcesSecCat->result_array();
	foreach ($getProcesSecCat_data as $key => $value) 
	{
		$getProcesSec=$this->Common_model->getProcesSecByCatid($value['id']);
		if($getProcesSec->num_rows()>0)
		{
	if(($key%2)==0)
	{
?>

<table border="0" cellpadding="0" cellspacing="0" width="100%">	
<tbody>
		<!-- <tr>
			<td> <?php echo $value['sectioncategory']; ?> </td>
			<td> <?php echo $value['sectioncategory']; ?> </td>
		</tr> -->
		<tr>
<?php
}
?>
	<td width="50%" class="td-pad-0">
		<table class="table" border="1" cellpadding="10" cellspacing="0" width="99%" align="<?php echo ((($key%2)==0)?'left':'right'); ?>">
			<thead>
				<tr>
      				<th colspan="2" align="center"> <?php echo $value['sectioncategory']; ?> </th>
      			</tr>
			</thead>
      		<tbody>      			
	      		<?php
	      			$getProcesSec_data=$getProcesSec->result_array();
	      			$getProcesSecCatcnt1=$getProcesSec->num_rows();
	      			foreach ($getProcesSec_data as $key1 => $value1) {
	      				$curvalsql=$this->MProject->getWTchkLstData($prcessid,$value1['id']);
	      				$curval='';
	      				$curvalid=0;
	      				if($curvalsql->num_rows()>0)
	      				{
	      					$curvaldata=$curvalsql->result_array();
	      					$curval=$curvaldata[0]['secdata'];
	      					$curvalid=$curvaldata[0]['id'];
	      				}
	      				if($curval=='yes')
	      				{
	      					$curval='YES';
	      				}
	      				elseif($curval=='no')
	      				{
	      					$curval='NO';
	      				}
	      				elseif($curval=='na')
	      				{
	      					$curval='N/A';
	      				}
	      				else
	      				{

	      				}
	      				?>
	      		<tr>
      				<td class="<?php echo (($getProcesSecCatcnt1!=($key1+1))?'no_border_bottom':''); ?>"><?php echo $value1['sectionname']; ?></td>
      				<td class="<?php echo (($getProcesSecCatcnt1!=($key1+1))?'no_border_bottom':''); ?>"><?php echo $curval; ?></td>
      			</tr>
	      				<?php
	      			}
	      		?>
      		</tbody>
      	</table>
	</td>
		
	<?php
	if((($key%2)==1)||$getProcesSecCatcnt==($key+1))
	{
		?>
		</tr>
	</tbody>
	</table><br>
	<?php
	}
		}
	}
}
?>
<!-- Loop End -->
<table border="1" cellpadding="10" cellspacing="0" width="100%">
	<tbody>
		<tr>
			<td><strong>Chemicals Used:</strong></td>
			<td colspan="3"><?php echo $checkList[0]['chemical']; ?></td>
		</tr>
		<tr>
			<td><strong>Inhibitor Dosage:</strong></td>
			<td><?php echo $checkList[0]['inhibitor']; ?></td>
			<td><strong>Biocide Dosage:</strong></td>
			<td><?php echo $checkList[0]['biocide']; ?></td>
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