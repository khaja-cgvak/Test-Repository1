<?php
	
	$prcdatas=$this->MProject->getWTtempCettificate($prcessid);
    $prcdata=$prcdatas[0];    
    $prodata=$this->Common_model->getProductById($proid);

    $accordance=array(1=>"B8558",2=>"BS 6700");

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
			<td width="30%"><strong>Balcomm Ref:</strong></td>
			<td width="70%"><?php echo $prcdata['referenceno']; ?></td>
		</tr>
		<tr>
			<td width="30%"><strong>Contract Name:</strong></td>
			<td width="70%"><?php echo $prcdata['contractname']; ?></td>
		</tr>
		<tr>
			<td width="30%"><strong>Client:</strong></td>
			<td width="70%"><?php 
					$userincharge = $prodata['userincharge']; 
	                $client_name=$this->Common_model->getCustomerById($userincharge);
	                echo $client_name['custname'];
                ?>                
            </td>
		</tr>
	</tbody>
</table><br>
<table border="0" cellpadding="10" cellspacing="0" width="100%">
	<tbody>
		<tr>
			<td>The following services have been disinfected in accordance with <strong><?php echo $accordance[$prcdata['accord1']]; ?> or <?php echo $accordance[$prcdata['accord2']]; ?>:-</strong></td>
		</tr>
		<tr><td></td></tr>
		<tr>
			<td><?php echo $prcdata['comments']; ?></td>
		</tr>
		<tr><td></td></tr>
		<tr>
			<td>Laboratory results to follow.</td>
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