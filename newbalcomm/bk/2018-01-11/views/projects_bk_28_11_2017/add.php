<?php
$witnessedusersopt='';
$testedusersopt='';
?>
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
			<form method="POST" name="adduser" action="" class="addusernew">
				<div class="row">
					
					<div class="form-group clearfix">
						<div class="col-sm-4">
							<label>Customer Name<span class="mandatory"> *</span></label>
							<select class="form-control userincharge" name="userincharge">
								<option value="">Select Client name</option>
								<?php
								$userincharge=0;
								if($_REQUEST['userincharge'])
								{
									$userincharge=intval($_REQUEST['userincharge']);
								}
								elseif(isset($projdata['userincharge']))
								{
									$userincharge=intval($projdata['userincharge']);
								}
									if(!empty($customers))
									{
										foreach ($customers as $urs_key => $urs_value) {
											$selected='';
											if($urs_value['id']==intval($userincharge))
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
							<div class="row">
								<div class="col-xs-9">
									<label>Site Name<span class="mandatory"> *</span></label>
									<select class="sitename form-control" name="sitename">
										<option value="">Select Site Name</option>
										<?php
										$sitename=0;
										if($_REQUEST['sitename'])
										{
											$sitename=intval($_REQUEST['sitename']);
										}
										elseif(isset($projdata['siteid']))
										{
											$sitename=intval($projdata['siteid']);
										}

											//if(!empty($projdata['siteid']))
											{
												$sitedata=$this->MProject->getSites(0,intval($userincharge));
												if($sitedata->num_rows()>0)
												{
													$sitedata1=$sitedata->result_array();
													foreach ($sitedata1 as $ds_key => $ds_value) {
														$selected='';
														if($sitename==$ds_value['id'])
														{
															$selected=' selected';
														}
														echo '<option value="'.$ds_value['id'].'" '.$selected.'>'.$ds_value['sitename'].'</option>';
													}
												}
											}
										?>
									</select>
		               				<?php echo form_error('sitename', '<div class="form-error">', '</div>'); ?>
		               			</div>
		               			<div class="col-xs-3"><label>&nbsp;</label><br><button type="button" class="btn btn-success addsitemodel" data-toggle="modal" data-target="#addsitedatafrm"><i class="fa fa-plus-square-o" aria-hidden="true"></i> Add</button></div>
               				</div>
						</div>
						<div class="col-sm-4">
							<div class="row">
								<div class="col-xs-9">
									<label>Contact Name<span class="mandatory"> *</span></label>
									
									<select class="sitecontactname form-control" name="sitecontactname">
										<option value="">Select Contact Name</option>
										<?php
											//if(!empty($projdata['contactid']))
											{
												$sitecontactnameid=0;
												if($_REQUEST['sitecontactname'])
												{
													$sitecontactnameid=intval($_REQUEST['sitecontactname']);
												}
												elseif(isset($projdata['contactid']))
												{
													$sitecontactnameid=intval($projdata['contactid']);
												}

												$sitecontactname=$this->MProject->getContactSites(intval($sitename),intval($userincharge));
												if($sitecontactname->num_rows()>0)
												{
													$sitecontactname1=$sitecontactname->result_array();
													foreach ($sitecontactname1 as $ds_key => $ds_value) {
														$selected='';
														if($sitecontactnameid==$ds_value['id'])
														{
															$selected=' selected';
														}

														echo '<option value="'.$ds_value['id'].'" '.$selected.'>'.$ds_value['contactfirstname'].' '.$ds_value['contactlastname'].'</option>';
													}
												}
											}
										?>

									</select>
		               				<?php echo form_error('sitecontactname', '<div class="form-error">', '</div>'); ?>
		               			</div>
		               			<div class="col-xs-3"><label>&nbsp;</label><br><button type="button" class="btn btn-success addcontactmodel" data-toggle="modal" data-target="#addcontactdatafrm"><i class="fa fa-plus-square-o" aria-hidden="true"></i> Add</button></div>
               				</div>
						</div>
						
					</div>
					<div class="form-group clearfix">
						<div class="col-sm-4">
							<label>Project Number<span class="mandatory"> *</span></label>
							<input type="text" class="form-control" name="projectname" placeholder="Enter Project Number" value="<?php echo set_value('projectname', (isset($projdata['projectname'])) ? $projdata['projectname'] : ''); ?>" />
                <?php echo form_error('projectname', '<div class="form-error">', '</div>'); ?>
						</div>
						<div class="col-sm-4">
							<label>Project Description<span class="mandatory"> *</span></label>
							<textarea class="form-control" name="projectdescription"><?php echo set_value('projectdescription', (isset($projdata['projectdescription'])) ? $projdata['projectdescription'] : ''); ?></textarea>
                <?php echo form_error('projectdescription', '<div class="form-error">', '</div>'); ?>
						</div>
						<div class="col-sm-4">
							<label>Project Start Date</label>
							<input type="text" class="form-control datepicker" name="projectstartdate" value="<?php echo set_value('projectstartdate', (isset($projdata['projectstartdate'])) ? date(DT_FORMAT,strtotime($projdata['projectstartdate'])) : date(DT_FORMAT)); ?>" />
                <?php echo form_error('projectstartdate', '<div class="form-error">', '</div>'); ?>
						</div>
						
						
					</div>
					<div class="form-group clearfix">
					<?php
						/*
					?>
						<div class="col-sm-4">
							<label>Project Proposed End Date</label>
							<input type="text" class="form-control datepicker" name="projectenddate" value="<?php echo set_value('projectenddate', (isset($projdata['projectenddate'])) ? date('d M, Y',strtotime($projdata['projectenddate'])) : ''); ?>" />
                <?php echo form_error('projectenddate', '<div class="form-error">', '</div>'); ?>
						</div>
						*/
						?>
											
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
													$uuuserdata=$userRoledata->result_array();
													if(!empty($uuuserdata))
													{
														$uuuserdatas=$userRoledata->result_array();
														foreach ($uuuserdatas as $ur_key => $ur_value) {
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
<?php
$productID =  $this->uri->segment(3);
  $factoryID =  $this->uri->segment(4);
  echo $productID;
echo $factoryID;  
  ?>
<!-- Modal -->
<div id="addsitedatafrm" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
    	<form action="" method="post" class="frmaddsitemdl">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal">&times;</button>
	        <h4 class="modal-title">Add Site Name</h4>
	      </div>
	      <div class="modal-body">
	        <div class="form-group clearfix">
				<div class="col-sm-6">
					<label>Site Name<span class="mandatory"> *</span></label>
					<input class="form-control alphanumeric-format" type="text" name="sitename"  placeholder="Enter Site Name" value="<?php echo set_value('sitename', (isset($conde_value['sitename'])) ? $conde_value['sitename'] : ''); ?>" />
					<div class="form-error sitename-error"></div>
				</div>
				<div class="col-sm-6">
					<label>Site Address<span class="mandatory"> *</span></label>							
					<textarea class="form-control siteaddress" name="siteaddress"  placeholder="Enter Site Address"><?php echo set_value('siteaddress', (isset($conde_value['siteaddress'])) ? $conde_value['siteaddress'] : ''); ?></textarea>
					<div class="form-error siteaddress-error"></div>
				</div>
			</div>
	      </div>
	      <div class="modal-footer">      	
	      	<button type="submit" class="btn btn-success btn-s-xs submit-btn addnewsitemodal addnew">Submit</button>
	        <button type="button" class="btn btn-danger btn-s-xs submit-btn cancel" data-dismiss="modal">Close</button>
	      </div>
	    </form>
	 </div>    
  </div>
</div>
<!-- Modal -->
<div id="addcontactdatafrm" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
    <form action="" method="post" class="frmaddcontactmdl">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add Contact</h4>
      </div>
      <div class="modal-body">
        <div class="form-group clearfix">
			<div class="col-sm-4">
				<label>First Name<span class="mandatory"> *</span></label>
				<input class="form-control alphanumeric-format" type="text" name="contactfirstname"  placeholder="Enter First Name" value="<?php echo set_value('contactfirstname', (isset($conde_value['contactfirstname'])) ? $conde_value['contactfirstname'] : ''); ?>" />
			</div>
			<div class="col-sm-4">
				<label>Last Name<span class="mandatory"> *</span></label>
				<input class="form-control alphanumeric-format" type="text" name="contactlastname"  placeholder="Enter Last Name" value="<?php echo set_value('contactlastname', (isset($conde_value['contactlastname'])) ? $conde_value['contactlastname'] : ''); ?>" />
			</div>
			<div class="col-sm-4">
				<label>Job Role<span class="mandatory"> *</span></label>
				<input class="form-control" type="text" name="contactdesignation"  placeholder="Enter Designation" value="<?php echo set_value('contactdesignation', (isset($conde_value['contactdesignation'])) ? $conde_value['contactdesignation'] : ''); ?>" />
			</div>
		</div>
		<div class="form-group clearfix">
			<div class="col-sm-4">
				<label>Phone<span class="mandatory"> *</span></label>
				<input class="form-control phone-format" type="text" name="contactphone"  placeholder="Enter Phone" value="<?php echo set_value('contactphone', (isset($conde_value['contactphone'])) ? $conde_value['contactphone'] : ''); ?>" />
			</div>
			<div class="col-sm-4">
				<label>Mobile</label>
				<input class="form-control phone-format" type="text" name="contactmobile"  placeholder="Enter Mobile" value="<?php echo set_value('contactmobile', (isset($conde_value['contactmobile'])) ? $conde_value['contactmobile'] : ''); ?>" />
			</div>
			<div class="col-sm-4">
				<label>Email<span class="mandatory"> *</span></label>
				<input class="form-control email-format" type="text" name="contactemailid"  placeholder="Enter Email" value="<?php echo set_value('contactemailid', (isset($conde_value['contactemailid'])) ? $conde_value['contactemailid'] : ''); ?>" />
			</div>
			
		</div>
      </div>
      <div class="modal-footer">
      	<button type="submit" class="btn btn-success btn-s-xs submit-btn addnewcontactmodal addnew">Submit</button>
	    <button type="button" class="btn btn-danger btn-s-xs submit-btn cancel" data-dismiss="modal">Close</button>
      </div>

      </form>
    </div>

  </div>
</div>


