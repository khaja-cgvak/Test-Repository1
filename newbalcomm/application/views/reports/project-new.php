<?php
$witnessedusersopt='';
$testedusersopt='';
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>
<script>
$(document).ready(function(){

   /*$(".slidingDiv").hide();
   $(".show_hide").show();

   $('.show_hide').click(function(){
       $(".plus").text("-");
       $(".slidingDiv").show();
       
   },function(){
       $(".plus").text("+");
       $(".slidingDiv").show();
   });*/
    
});
</script>
<section class="vbox">
	<section class="scrollable padder">
		<section class="panel panel-default">
			<header class="panel-heading"><b><?php echo $title; ?></b></header>
			<?php
			if ($this->session->flashdata('success_message') != '')
				echo '<div class="alert2 alert-success text-center" style="width:100%;">' . $this->session->flashdata('success_message') . '</div>';
			?>
			<div class="">
				<table class="table table-striped m-b-none table-bordered dt-responsive nowrap" id="projectlist_reports" width="100%">
					<thead>
						<tr>
							<th width="19%">Project Name</th>
							<th width="15%">Start Date</th>
							<!-- <th width="15%">End Date</th> -->
							<th width="27%">Project<br>Description</th>
							<th width="19%">Customer<br>Name</th>							
							<th width="5%">Action</th>
							<th width="5%">System Details </th>
							 			
						</tr>
						
					</thead>
					<tbody>
							<?php
							$cuser=$this->session->userdata('userid');
        					$roleid=$this->session->userdata('userroleid');
	        					$this->db->select('p.*,u.custname,sn.sitename, cn.contactfirstname, cn.contactlastname');
	        					$this->db->join(CUSTOMER.' u','(u.id = p.userincharge)','left');
	        					if(($roleid!=1)&&($cuser!=1))
						        {
						        	$this->db->join(PROJURS.' pus','(p.id = pus.projid and pus.userid='.intval($cuser).')','left');
						        	$this->db->where('pus.userid',intval($cuser));
							    }
							    $this->db->join(CUSSITES.' sn','(sn.id = p.siteid)','left');
							    $this->db->join(CUSDETAILS.' cn','(cn.id = p.contactid)','left');
	        					$this->db->where('p.isdeleted','N');	        					
								$allprj=$this->db->get(PROJECTS.' p');

								$segarrval='projects/projview';
								$ckpermission=$this->Common_model->ckRolePermission($roleid,$segarrval);
								//$ckpermproview=$ckpermission;
								 define('rptview',$ckpermission);

								if($allprj->num_rows()>0)
								{
									$allprjdata=$allprj->result_array();
									foreach ($allprjdata as $key => $value) {

										/*$percentage=$this->CHome->getProjectPrecentage($value['id']);
										$percentageclass="progress-bar-danger";
										$progressclass='';
										if($percentage>25 and $percentage<=50)
										{
											$percentageclass="progress-bar-info";            			
										}
										elseif($percentage>50 and $percentage<=75)
										{
											$percentageclass="progress-bar-warning";            			
										}
										elseif($percentage>75)
										{
											$percentage=100;
											$percentageclass="progress-bar-success";            			
										}
										else
										{
											$percentageclass="progress-bar-danger";
										}

										if(intval($percentage)==0)
										{
											$progressclass='color:#333;"';
										}*/

										//$newpid=$this->Common_model->encodeid($value['id']);
										$action='<div class="icon_list">';
					
                    $newpid=$this->Common_model->encodeid($value['id']);
                    if(rptview==true)
                    {
                        $action.='<a href="'.site_url('reports/projview/'.$newpid).'"  data-toggle="tooltip"  title="Report List"><i class="fa fa-cog" aria-hidden="true"></i></a>';
                    }
                    $action.='</div>';
										/*$action='';

					            		if($ckpermproview==true)
					                    {
					                        $action.='<a href="'.site_url('projects/projview/'.$newpid).'"  data-toggle="tooltip"  title="Project Process">';
					                    }*/

					                    /*$action.='<div class="progress" style="margin:10px 0px;">
										  <div class="progress-bar '.$percentageclass.' progress-bar-striped" role="progressbar" role="progressbar" aria-valuenow="70"
										  aria-valuemin="0" aria-valuemax="100" style="width:'.intval($percentage).'%;'.$progressclass.'">&nbsp;&nbsp;'.$percentage.'%&nbsp;&nbsp;</div>
										</div> ';*/
										/*if($ckpermproview==true)
					                    {
					                        $action.='</a>';
					                    }*/
					                      echo '<form method="POST" name="adduser" action="" class="addusernew">';
											echo '<tr>
												<td>'.$value['projectname'].'</td>
												<td>'.date('d M Y',strtotime($value['projectstartdate'])).'</td>
												<td>'.date('d M Y',strtotime($value['projectenddate'])).'</td>
												<td>'.$value['projectdescription'].'</td>
												<td>'.$value['custname'].'</td>
												<td>'.$action.'</td>
												<td class="show_hide plus" id="plus1">Click</td>
												<td><input type="hidden" name="projectid" value='.$value['id'].'></td>
												<div>dsds</div>;
											</tr>';
											
											
										
									}
								}
							?>
						</tbody>
					
                   		
				</table>
			</div>
			
			<div class="slidingDiv">
			
				<div class="row">
					
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
									        <?php
									        	//echo 'id='.$sys_value['id'];									        
									        	$sysidres=$this->MProject->getSystemPrjck($sys_value['id']);
									        	//echo 'system='.$sysidres->num_rows();
									        	if($sysidres->num_rows()==0 || empty($sys_value['id']))
									        	{
									        ?>
									        <button class="pull-right btn btn-danger btn-xs systemdetailsremove" type="button"><i class="fa fa-times" aria-hidden="true"></i>
</button>
<?php } ?>
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
													<label>Company Name:</label>
													<input class="form-control" name="companyname[]" placeholder="Enter Company Name" value="<?php echo set_value('companyname['.$sys_key.']', (isset($sys_value['companyname'])) ? $sys_value['companyname'] : ''); ?>" type="text">
													
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
															
											</div>
											<div class="form-group clearfix">
												<div class="col-sm-4">
													<label>Witnessed By:</label>
													<input class="form-control" name="witnessedny[]" placeholder="Witnessed By" value="<?php echo set_value('witnessedny['.$sys_key.']', (isset($sys_value['witnessedny'])) ? $sys_value['witnessedny'] : ''); ?>" type="text">
						                		</div>
											
												<div class="col-sm-4">
													<label>Date:</label>
													<input class="form-control datepicker" name="witnesseddate[]" value="<?php echo set_value('testcmpdate['.$sys_key.']', (isset($sys_value['witnesseddate'])) ? date(DT_FORMAT,strtotime($sys_value['witnesseddate'])) : ''); ?>" type="text">
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
																	if($sys_key==0)
																	{
																	$testedusersopt.='<option value="'.$ud_value['userid'].'">'.$ud_value['firstname'].' '.$ud_value['lastname'].'</option>';
																	}

																	if($ud_value['userid']==$sys_value['testedby'])
																	{
																		$selected=' selected="selected" ';
																	}
																	/*elseif($ud_value['userid']==$_POST['testcmpby'][$sys_key])
																	{
																		$selected=' selected="selected" ';
																	}*/
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
													<label>Date:</label>
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
			</div>
			
		</section>
	</section>
</section>

<div class="system_details_A hidden">
	<div class="panel-heading">
      <h4 class="panel-title">
        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#syspanel_">
        </a>
        <button class="pull-right btn btn-danger btn-xs systemdetailsremove" type="button"><i class="fa fa-times" aria-hidden="true"></i></button>
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
					<label>Company Name:</label>
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
				<!---<div class="col-sm-8">
					<label>Services Contractor Address:<span class="mandatory"> *</span></label>
					<textarea class="form-control" name="contractoraddress[]"></textarea>
        		</div>--->				
			</div>
			<div class="form-group clearfix">
				<div class="col-sm-4">
					<label>Witnessed By:</label>
					<!---<select class="form-control" name="witnessedny[]">
						<option value="">Please Select</option>
						<?php //echo $witnessedusersopt; ?>
					</select>--->
					<input class="form-control" name="witnessedny[]" placeholder="Witnessed By" value="" type="text">
        		</div>
				<div class="col-sm-4">
					<label>Date:</label>
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
					<label>Date:</label>
					<input class="form-control datepicker" name="testcmpdate[]" value="<?php echo date(DT_FORMAT); ?>" type="text">
        		</div>
        		
			</div>
			<input type="hidden" class="systemid" name="systemid[]" value="0" />
		</div>
	</div>
</div>
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
		</section>
	</section>
</section>





