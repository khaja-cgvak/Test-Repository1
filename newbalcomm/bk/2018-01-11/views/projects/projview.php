<section class="vbox">
	<section class="scrollable padder">
		<section class="panel panel-default">
			<header class="panel-heading">
			<div style="display:inline"><b><?php echo $title; ?></b></div>
			<div class="icon_list" style="display:inline;width:3%; float:right;">
			<a href="<?php echo site_url('projects'); ?>"  data-toggle="tooltip"  title="Project List">

			<i class="fa fa-chevron-circle-left" aria-hidden="true"></i>
			</a>
			</div> 
			</header>
			<div class="panel-body">
				<p><strong><u>Project Details:</u></strong></p>			
				<table class="table table-bordered table-striped">
					<tbody>
						<tr>
							<td width="40%"><strong>Project Name: </strong></td>
							<td width="60%"><?php echo $projdata['projectname']; ?></td>
						</tr>
						<tr>
							<td width="40%"><strong>Project Start Date: </strong></td>
							<td width="60%"><?php echo date('d M, Y',strtotime($projdata['projectstartdate'])); ?></td>
						</tr>
						<tr>
							<td width="40%"><strong>Project Proposed End Date: </strong></td>
							<td width="60%"><?php echo date('d M, Y',strtotime($projdata['projectenddate'])); ?></td>
						</tr>
						<tr>
							<td width="40%"><strong>Client Name: </strong></td>
							<td width="60%"><?php $userincharge = $projdata['userincharge']; 
                        $client_name=$this->Common_model->getCustomerById($userincharge);
                        echo $client_name['custname'];
                        ?></td>
						</tr>
						<tr>
							<td width="40%"><strong>Project Description: </strong></td>
							<td width="60%"><?php echo $projdata['projectdescription']; ?></td>
						</tr>
						<tr>
							<td width="40%"><strong>Active </strong></td>
							<td width="60%"><?php echo (($projdata['isactive'] == 1)?"Yes":"No"); ?></td>
						</tr>
					</tbody>
				</table>
				<p><strong><u>Assign Engineers:</u></strong></p>				
				<table class="table table-bordered table-striped">
					<thead>
						<tr>
							<th>User Name</th>
							<th>User Role</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$asscnt=0;
						$uuuserdata=$userRoledata->result_array();						
						if(!empty($uuuserdata))
						{
							foreach ($uuuserdata as $ur_key => $ur_value) {
								if(isset($assUrsIds))
								{
									if(in_array($ur_value['userid'], $assUrsIds))
									{
										$asscnt++;
						?>
						<tr>
							<td><?php echo $ur_value['firstname'].' '.$ur_value['lastname']; ?></td>
							<td><?php echo $ur_value['rolesname']; ?></td>
						</tr>
						<?php
									}
								}
							}
						}
						if($asscnt==0)
						{
							echo '<tr><td colspan="2">No Records Found.</td></tr>';
						}
						?>
					</tbody>
				</table>
				<p><strong><u>System Details:</u></strong></p>
				<div class="panel-group" id="accordion">
					<!-- Panel start -->
					<?php
						foreach ($system_details as $sys_key => $sys_value) {
					?>									
					<div class="panel panel-default system_details_sec system_details_<?php echo $sys_key; ?> system_details_li">
					    <div class="panel-heading">
					      <h4 class="panel-title">
					        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#syspanel_<?php echo $sys_key; ?>"><?php echo $sys_value['systemname']; ?></a>					        
					        <div class="clearfix"></div>
					      </h4>
					    </div>
					    <div id="syspanel_<?php echo $sys_key; ?>" class="panel-collapse collapse <?php if($sys_key==0) { echo 'in';} ?>">
					      <div class="panel-body">
					      	<table class="table table-bordered table-striped">					      		
					      		<tr>
					      			<td width="20%"><strong>Company Name:</strong></td>
					      			<td width="30%"><?php echo $sys_value['companyname']; ?></td>
					      		
					      			<td width="20%"><strong>Company Address:</strong></td>
					      			<td width="30%"><?php echo $sys_value['companyaddress']; ?></td>
					      		</tr>
					      		<tr>
					      			<td width="20%"><strong>Services Contractor Name:</strong></td>
					      			<td width="30%"><?php echo $sys_value['servicecontractorname']; ?></td>
					      		
					      			<td width="20%"><strong>Services Contractor Address:</strong></td>
					      			<td width="30%"><?php echo $sys_value['servicecontractoraddress']; ?></td>
					      		</tr>
					      		<tr>
					      			<td width="20%"><strong>Witnessed By:</strong></td>
					      			<td width="30%"><?php $userincharge = $sys_value['witnessedby']; 
				                        $client_name=$this->Common_model->getUserById($userincharge);
				                        echo $client_name['firstname'].' '.$client_name['lastname'];
				                        ?></td>
					      		
					      			<td width="20%"><strong>Date:</strong></td>
					      			<td width="30%"><?php echo date(DT_FORMAT,strtotime($sys_value['witnesseddate'])); ?></td>
					      		</tr>
					      		<tr>
					      			<td width="20%"><strong>Test Completed By:</strong></td>
					      			<td width="30%"><?php $userincharge = $sys_value['testedby']; 
				                        $client_name=$this->Common_model->getUserById($userincharge);
				                        echo $client_name['firstname'].' '.$client_name['lastname'];
				                        ?></td>
					      		
					      			<td width="20%"><strong>Date:</strong></td>
					      			<td width="30%"><?php echo date(DT_FORMAT,strtotime($sys_value['testedDate'])); ?></td>
					      		</tr>
					      		
					      	</table>
					      </div>
					    </div>
					</div>
					<?php
						}
					?>
					<!-- Panel End -->
					<br><br>
				</div>
			</div>
			
		</section>
	</section>
</section>
<script type="text/javascript" src="<?php echo base_url('/assets/js/jquery.js');?>"></script>
<script type="text/javascript">
	var click = "<?php echo $this->uri->segment('4');?>";
	if(click == 1){
		//$(".gw-menu-text:first").find('ul').slideToggle();	
		
	}
</script>
