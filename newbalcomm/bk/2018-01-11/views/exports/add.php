<?php
$witnessedusersopt='';
$testedusersopt='';
?>
<section class="vbox">
	<section class="scrollable padder">
		<section class="panel panel-default">
			<header class="panel-heading"><b><?php echo $title; ?></b> </header>
			<div class="panel-body">
			<form method="POST" name="adduser" action="" class="addusernew">
				<div class="row">
					<div class="form-group clearfix">
						<div class="col-sm-4">
							<label>Project Name<span class="mandatory"> *</span></label>
							<input type="text" class="form-control" name="projectname" placeholder="Enter Project Name" value="<?php echo set_value('projectname', (isset($projdata['projectname'])) ? $projdata['projectname'] : ''); ?>" />
                <?php echo form_error('projectname', '<div class="form-error">', '</div>'); ?>
						</div>
						<div class="col-sm-4">
							<label>Project Start Date<span class="mandatory"> *</span></label>
							<input type="text" class="form-control datepicker" name="projectstartdate" value="<?php echo set_value('projectstartdate', (isset($projdata['projectstartdate'])) ? date('d M, Y',strtotime($projdata['projectstartdate'])) : ''); ?>" />
                <?php echo form_error('projectstartdate', '<div class="form-error">', '</div>'); ?>
						</div>
						<div class="col-sm-4">
							<label>Project Proposed End Date<span class="mandatory"> *</span></label>
							<input type="text" class="form-control datepicker" name="projectenddate" value="<?php echo set_value('projectenddate', (isset($projdata['projectenddate'])) ? date('d M, Y',strtotime($projdata['projectenddate'])) : ''); ?>" />
                <?php echo form_error('projectenddate', '<div class="form-error">', '</div>'); ?>
						</div>
						
					</div>
					<div class="form-group clearfix">
						<div class="col-sm-4">
							<label>Client Name<span class="mandatory"> *</span></label>
							<select class="form-control" name="userincharge">
								<option value="">Select Client name</option>
								<?php
									if(!empty($customers))
									{
										foreach ($customers as $urs_key => $urs_value) {
											$selected='';
											if($urs_value['id']==intval($projdata['userincharge']))
											{
												$selected=' selected="selected" ';
											}
											echo '<option value="'.$urs_value['id'].'" '.$selected.'>'.$urs_value['custname'].'</option>';
										}
									}
								?>
							</select>
                <?php echo form_error('userincharge', '<div class="form-error">', '</div>'); ?>
						</div>
						<div class="col-sm-4">
							<label>Project Description<span class="mandatory"> *</span></label>
							<textarea class="form-control" name="projectdescription"><?php echo set_value('projectdescription', (isset($projdata['projectdescription'])) ? $projdata['projectdescription'] : ''); ?></textarea>
                <?php echo form_error('projectdescription', '<div class="form-error">', '</div>'); ?>
						</div>					
						<div class="col-sm-4">
							<label>Active<span class="mandatory"> *</span></label>
							<div><label class="checkbox-inline">
							<input type="radio" name="status" value="1" <?php
								if (isset($projdata['isactive']) && $projdata['isactive'] == 1)
								{
									echo 'checked';
								}
								else
								{
									echo 'checked';
								}
								?> /> Yes</label>
								<label class="checkbox-inline">
								<input type="radio" name="status" value="0"  <?php
								if (isset($projdata['isactive']) && $projdata['isactive'] == 0)
								{
									echo 'checked';
								}
								?>  /> No</label>
									   <?php echo form_error('status', '<div class="form-error">', '</div>'); ?>
												</div>
											</div>
					</div>
					<div class="form-group clearfix">					
						<div class="col-sm-12">						
							
								<?php #echo '<pre>'; print_r($userRoledata->result_array()); echo '</pre>'; ?>
							<div class="creatediv1">    			
								<div class="row">
									<div class="col-md-12">
										<div class="panel panel-primary filterable">
											<div class="panel-heading">
												<h3 class="panel-title">Assign Engineers <span class="mandatory"> *</span></h3>
												<div class="pull-right">
													<button type="button" class="btn btn-default btn-xs btn-filter"><span class="glyphicon glyphicon-filter"></span> Filter</button>
												</div>
											</div>
											<table class="span12">
												<table>
													<tr class="filters">
														<th style="width: 4%">
															<div class="checkbox radio-margin">
																<label>
																	<input type="checkbox" value="">
																	<span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
																</label>
															</div>
														</th>
														<th style="width: 48%">
															<input type="text" class="form-control" placeholder="User Name" disabled>
														</th>
														<th style="width: 48%">
															<input type="text" class="form-control" placeholder="User Role" disabled>
														</th>
													</tr>
												</table>
												<div class="bg tablescroll">

													<table class="table table-bordered table-striped">
													<?php
													if(!empty($userRoledata->result_array()))
													{
														foreach ($userRoledata->result_array() as $ur_key => $ur_value) {

															$checked='';

															if(isset($assUrsIds))
															{
																if(in_array($ur_value['userid'], $assUrsIds))
																{
																	$checked=' checked="checked" ';
																}
															}

														?>
														<tr>
															<td style="width: 4%">
																<div class="checkbox radio-margin">
																	<label>
																		<input type="checkbox" value="<?php echo $ur_value['userid']; ?>" name="assign_users[]" <?php echo $checked; ?>>
																		<span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
																	</label>
																</div>
															</td>
															<td style="width: 48%"><?php echo $ur_value['firstname'].' '.$ur_value['lastname']; ?></td>
															<td style="width: 48%"><?php echo $ur_value['rolesname']; ?></td>
														</tr>
													<?php
														}
													}
													?>
														
													</table>
												</div>
											</table>
											<?php
												echo form_error('assign_users[]', '<div class="form-error">', '</div>');
											?>
										</div>
									</div>
								</div>
				    
							</div>
						</div>
					</div>
					<div class="system_details">					
						<div class="form-group clearfix">
							<div class="col-sm-12">
								<label><strong>System Details:</strong></label>
							</div>
						</div>						
						<div class="form-group clearfix">
							<div class="col-sm-12">
								<div class="panel-group" id="accordion">
									<!-- Panel start -->
									<?php
										foreach ($system_details as $sys_key => $sys_value) {
									?>									
									<div class="panel panel-default system_details_sec system_details_<?php echo $sys_key; ?> system_details_li">
									    <div class="panel-heading">
									      <h4 class="panel-title">
									        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#syspanel_<?php echo $sys_key; ?>">System #<?php echo ($sys_key+1); ?>
									        </a>
									        <button class="pull-right btn btn-danger btn-xs systemdetailsremove"><i class="fa fa-times" aria-hidden="true"></i>
</button>
									        <div class="clearfix"></div>
									      </h4>
									    </div>
									    <div id="syspanel_<?php echo $sys_key; ?>" class="panel-collapse collapse <?php if($sys_key==0) { echo 'in';} ?>">
									      <div class="panel-body">
									        <div class="form-group clearfix">
												<div class="col-sm-4">
													<label>System Name:<span class="mandatory"> *</span></label>
													<input class="form-control" name="systemname[]" placeholder="Enter System Name" value="<?php echo set_value('systemname['.$sys_key.']', (isset($sys_value['systemname'])) ? $sys_value['systemname'] : ''); ?>" type="text">
													<?php
														echo form_error('systemname['.$sys_key.']', '<div class="form-error">', '</div>');
													?>
						                		</div>
						                		<div class="col-sm-4">
													<label>Company Name:<span class="mandatory"> *</span></label>
													<input class="form-control" name="companyname[]" placeholder="Enter Company Name" value="<?php echo set_value('companyname['.$sys_key.']', (isset($sys_value['companyname'])) ? $sys_value['companyname'] : ''); ?>" type="text">
													<?php
														echo form_error('companyname['.$sys_key.']', '<div class="form-error">', '</div>');
													?>
						                		</div>
						                		<div class="col-sm-4">
													<label>Company Address:<span class="mandatory"> *</span></label>
													<textarea class="form-control" name="companyaddress[]"><?php echo set_value('companyaddress['.$sys_key.']', (isset($sys_value['companyaddress'])) ? $sys_value['companyaddress'] : ''); ?></textarea>
													<?php
														echo form_error('companyaddress['.$sys_key.']', '<div class="form-error">', '</div>');
													?>
						                		</div>
						                	</div>
											<div class="form-group clearfix">
												<div class="col-sm-4">
													<label>Services Contractor Name:<span class="mandatory"> *</span></label>
													<input class="form-control" name="contractorname[]" placeholder="Enter Services Contractor Name" value="<?php echo set_value('contractorname['.$sys_key.']', (isset($sys_value['servicecontractorname'])) ? $sys_value['servicecontractorname'] : ''); ?>" type="text">
													<?php
														echo form_error('contractorname['.$sys_key.']', '<div class="form-error">', '</div>');
													?>
						                		</div>
												<div class="col-sm-8">
													<label>Services Contractor Address:<span class="mandatory"> *</span></label>
													<textarea class="form-control" name="contractoraddress[]"><?php echo set_value('contractoraddress['.$sys_key.']', (isset($sys_value['servicecontractoraddress'])) ? $sys_value['servicecontractoraddress'] : ''); ?></textarea>
													<?php
														echo form_error('contractoraddress['.$sys_key.']', '<div class="form-error">', '</div>');
													?>
						                		</div>				
											</div>
											<div class="form-group clearfix">
												<div class="col-sm-4">
													<label>Witnessed By:<span class="mandatory"> *</span></label>
													<select class="form-control" name="witnessedny[]">
														<option value="">Please Select</option>
														<?php
															if($userall->num_rows()>0)
															{
																$userall_data=$userall->result_array();
																foreach ($userall_data as $ud_key => $ud_value) {
																	$selected='';
																	$witnessedusersopt.='<option value="'.$ud_value['userid'].'">'.$ud_value['firstname'].' '.$ud_value['lastname'].'</option>';

																	if($ud_value['userid']==$sys_value['witnessedby'])
																	{
																		$selected=' selected="selected" ';
																	}
																	elseif($ud_value['userid']==$_POST['witnessedny'][$sys_key])
																	{
																		$selected=' selected="selected" ';
																	}
																	else
																	{

																	}

																	echo '<option value="'.$ud_value['userid'].'" '.$selected.'>'.$ud_value['firstname'].' '.$ud_value['lastname'].'</option>';

																}
															}
														?>
													</select>
													<?php
														echo form_error('witnessedny['.$sys_key.']', '<div class="form-error">', '</div>');
													?>
						                		</div>
												<div class="col-sm-4">
													<label>Date:<span class="mandatory"> *</span></label>
													<input class="form-control datepicker" name="witnesseddate[]" value="<?php echo set_value('testcmpdate['.$sys_key.']', (isset($sys_value['testedDate'])) ? date(DT_FORMAT,strtotime($sys_value['testedDate'])) : ''); ?>" type="text">
													<?php
														echo form_error('witnesseddate['.$sys_key.']', '<div class="form-error">', '</div>');
													?>
						                		</div>					                		
											</div>
											<div class="form-group clearfix">
												<div class="col-sm-4">
													<label>Test Completed By:<span class="mandatory"> *</span></label>
													<select class="form-control" name="testcmpby[]">
														<option value="">Please Select</option>
														<?php
															if($userall->num_rows()>0)
															{
																$userall_data=$userall->result_array();
																foreach ($userall_data as $ud_key => $ud_value) {
																	$selected='';
																	$testedusersopt.='<option value="'.$ud_value['userid'].'">'.$ud_value['firstname'].' '.$ud_value['lastname'].'</option>';

																	if($ud_value['userid']==$sys_value['testedby'])
																	{
																		$selected=' selected="selected" ';
																	}
																	elseif($ud_value['userid']==$_POST['testcmpby'][$sys_key])
																	{
																		$selected=' selected="selected" ';
																	}
																	else
																	{

																	}


																	echo '<option value="'.$ud_value['userid'].'" '.$selected.'>'.$ud_value['firstname'].' '.$ud_value['lastname'].'</option>';

																}
															}
														?>
													</select>
													<?php
														echo form_error('testcmpby['.$sys_key.']', '<div class="form-error">', '</div>');
													?>
						                		</div>
												<div class="col-sm-4">
													<label>Date:<span class="mandatory"> *</span></label>
													<input class="form-control datepicker" name="testcmpdate[]" value="<?php echo set_value('testcmpdate['.$sys_key.']', (isset($sys_value['testedDate'])) ? date(DT_FORMAT,strtotime($sys_value['testedDate'])) : ''); ?>" type="text">
													<?php
														echo form_error('testcmpdate['.$sys_key.']', '<div class="form-error">', '</div>');
													?>
						                		</div>				                		
											</div>
											<input type="hidden" class="systemid" name="systemid[]" value="<?php echo (isset($sys_value['id']) ? $sys_value['id'] : 0); ?>" />
									      </div>
									    </div>
									</div>
									<?php
										}
									?>
									<!-- Panel End -->
								</div>
								<div class="text-right">
									<button type="button" class="btn btn-primary btn-add-panel systemdetailsadd">
									    <i class="glyphicon glyphicon-plus"></i> Add New System
									</button>
								</div>
							</div>
						</div>
					</div>
					<br>
				</div>
				<footer class="panel-footer text-right bg-light lter"> 
					<input type="hidden" name="existid" value="<?php echo $this->uri->segment(3); ?>" />
					<input type="submit" name="submit" value="Submit" class="btn btn-success btn-s-xs submit-btn addnew">
					<input type="submit" name="cancel" value="Cancel" class="btn btn-danger btn-s-xs submit-btn cancel">
			</footer>
			 
			</form>
			</div>
			
		</section>
	</section>
</section>

<div class="system_details_A hidden">
	<div class="panel-heading">
      <h4 class="panel-title">
        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#syspanel_">
        </a>
        <button class="pull-right btn btn-danger btn-xs systemdetailsremove"><i class="fa fa-times" aria-hidden="true"></i></button>
			        <div class="clearfix"></div>
      </h4>
    </div>
    <div id="syspanel_" class="panel-collapse collapse">
	    <div class="panel-body">
			<div class="form-group clearfix">
				<div class="col-sm-4">
					<label>System Name:<span class="mandatory"> *</span></label>
					<input class="form-control" name="systemname[]" placeholder="Enter System Name" value="" type="text">
        		</div>
        		<div class="col-sm-4">
					<label>Company Name:<span class="mandatory"> *</span></label>
					<input class="form-control" name="companyname[]" placeholder="Enter Company" value="" type="text">
        		</div>
        		<div class="col-sm-4">
					<label>Company Address:<span class="mandatory"> *</span></label>
					<textarea class="form-control" name="companyaddress[]"></textarea>
        		</div>
        	</div>
			<div class="form-group clearfix">
				<div class="col-sm-4">
					<label>Services Contractor Name:<span class="mandatory"> *</span></label>
					<input class="form-control" name="contractorname[]" placeholder="Enter Contractor Name" value="" type="text">
        		</div>
				<div class="col-sm-8">
					<label>Services Contractor Address:<span class="mandatory"> *</span></label>
					<textarea class="form-control" name="contractoraddress[]"></textarea>
        		</div>				
			</div>
			<div class="form-group clearfix">
				<div class="col-sm-4">
					<label>Witnessed By:<span class="mandatory"> *</span></label>
					<select class="form-control" name="witnessedny[]">
						<option value="">Please Select</option>
						<?php echo $witnessedusersopt; ?>
					</select>
        		</div>
				<div class="col-sm-4">
					<label>Date:<span class="mandatory"> *</span></label>
					<input class="form-control datepicker" name="witnesseddate[]" value="<?php echo date(DT_FORMAT); ?>" type="text">
        		</div>	
        		
			</div>
			<div class="form-group clearfix">
				<div class="col-sm-4">
					<label>Test Completed By:<span class="mandatory"> *</span></label>
					<select class="form-control" name="testcmpby[]">
						<option value="">Please Select</option>
						<?php echo $testedusersopt; ?>
					</select>
        		</div>
				<div class="col-sm-4">
					<label>Date:<span class="mandatory"> *</span></label>
					<input class="form-control datepicker" name="testcmpdate[]" value="<?php echo date(DT_FORMAT); ?>" type="text">
        		</div>
        		
			</div>
			<input type="hidden" class="systemid" name="systemid[]" value="0" />
		</div>
	</div>
</div>
