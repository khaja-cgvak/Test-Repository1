<section class="vbox">
	<section class="scrollable padder">
		<section class="panel panel-default">
			<header class="panel-heading">
				<div class="row clearfix">
					<div class="col-sm-6"><strong><?php echo $title; ?></strong></div>					
					<div class="col-sm-3"><strong>Process:</strong>&nbsp;&nbsp;&nbsp;<label class="radio-inline"><input type="radio" class="proshtstatus" value="1" name="optradio" <?php if(isset($sheetstatus)) { if(($sheetstatus)==1) { echo 'checked="checked"'; }  }  ?>>Enabled</label><label class="radio-inline"><input type="radio" class="proshtstatus" value="0" name="optradio" <?php if(isset($sheetstatus)) { if(($sheetstatus)==0) { echo 'checked="checked"'; }  } ?>>Disabled</label>


<!-- <input type="checkbox" id="toggle-two" <?php if(isset($sheetstatus[0]['status'])) { if(($sheetstatus[0]['status'])==1) { echo 'checked="checked"'; }  } else{ echo 'checked="checked"'; } ?> > -->
</div>
					<div class="col-sm-3 text-right">
					<a href="<?php echo site_url('projects/'.$this->uri->segment(2).'/'.$this->uri->segment(3)); ?>" class="pull-left"><button type="button" class="btn btn-primary btn-xs">Add New</button></a>
					<?php 
						$sheetnumber=1;
						if(isset($prcdata['sheetnumber']))
						{
							$sheetnumber=$prcdata['sheetnumber'];
						}
						echo $this->Common_model->displaySheetNum(PRJPRCLST,intval($sheetnumber),$masterprcid);
					?></div>
				</div>
			</header>
			<div class="panel-body">
			<form method="POST" name="adduser" action="" class="addusernew">
				<div class="row">
					<div class="form-group clearfix">
						<div class="col-sm-4"><strong>Project:</strong> <?php echo $prodata['projectname']; ?></div>
						<div class="col-sm-4">
							<div class="row clearfix">
								<div class="col-sm-3"><label><strong>Ref:</strong><span class="mandatory"> *</span></label></div>
								<div class="col-sm-9">
									<input type="text" name="reportref" class="form-control" value="<?php echo set_value('reportref', (isset($prcdata['referenceno'])) ? $prcdata['referenceno'] : ''); ?>">
									<?php echo form_error('reportref', '<div class="form-error">', '</div>'); ?>
								</div>
							</div>
						</div>
						<div class="col-sm-4">
							<div class="row clearfix">
								<div class="col-sm-4"><label><strong>System:</strong><span class="mandatory"> *</span></label></div>
								<div class="col-sm-8">
									<select name="projsystem" id="projsystem" class="form-control">
										<option value="">Please Select</option>									
										<?php 
											$allsystems=$this->MProject->getSystems($proid);
											$projectsystemid=0;
											if(isset($_POST['projsystem']))
											{
												$projectsystemid=$this->input->post('projsystem');
											}
											elseif(isset($prcdata['projectsystemid']))
											{
												$projectsystemid=$prcdata['projectsystemid'];
											}
											else
											{

											}
											if($allsystems->num_rows()>0)
											{
												$allsystems_data=$allsystems->result_array();
												foreach ($allsystems_data as $sd_key => $sd_value) {
													$selected='';
													//if(isset($prcdata['projectsystemid']))
													{
														if($sd_value['id']==$projectsystemid)
														{
															$selected=' selected="selected" ';
														}
													}													
													echo '<option value="'.$sd_value['id'].'" '.$selected.'>'.$sd_value['systemname'].'</option>';
												}
											}

											#echo '<pre>'; print_r($allsystems->result_array()); echo '</pre>';
										?>
									</select>
									<!--<input type="text" name="projsystem" class="form-control" value="<?php echo set_value('projsystem', (isset($prcdata['system'])) ? $prcdata['system'] : ''); ?>"> -->
									<?php echo form_error('projsystem', '<div class="form-error">', '</div>'); ?>
								</div>
							</div>									
						</div>
					</div>

					<div class="form-group clearfix">
						<div class="col-sm-12 text-center">
							<div class="panel panel-default">
							      <div class="panel-body">
							      	<b>System Witness Certificate</b><br>
									<h3 style="margin:0">Chemical Cleaning</h3>
									The System detailed within has been witnessed to the Clients representative, <br>the test data is a true record of the system performance achieved
							      </div>
							</div>										
						</div>
					</div>



					<div class="form-group clearfix">
						<div class="col-sm-4">
							<label><strong>Witnessed By:</strong><span class="mandatory"> *</span></label>
							<input type="text" class="form-control" name="commairwitness" placeholder="Enter Witness" value="<?php echo set_value('commairwitness', (isset($prcdata['u1fname'])) ? $prcdata['u1fname'].' '.$prcdata['u1lname'] : ''); ?>" readonly="readonly" />
                			<?php echo form_error('commairwitness', '<div class="form-error">', '</div>'); ?>
                		</div>
						<div class="col-sm-4">
							<label><strong>Company:</strong><span class="mandatory"> *</span></label>
							<input type="text" class="form-control" name="commaircmpy" placeholder="Enter Company" value="<?php echo set_value('commaircmpy', (isset($prcdata['companyname'])) ? $prcdata['companyname'] : ''); ?>" readonly="readonly" />
                			<?php echo form_error('commaircmpy', '<div class="form-error">', '</div>'); ?>
                		</div>
                		<div class="col-sm-4">
							<label><strong>Date:</strong><span class="mandatory"> *</span></label>
							<input type="text" class="form-control datepicker" name="commairwitdate" value="<?php echo set_value('commairwitdate', (isset($prcdata['witnessdate'])) ? date('d m, Y',strtotime($prcdata['witnessdate'])) : date('d m, Y')); ?>" />
                			<?php echo form_error('commairwitdate', '<div class="form-error">', '</div>'); ?>
                		</div>
					</div>
					<div class="form-group clearfix">
						<div class="col-sm-4">
							<label><strong>Test Completed By:</strong><span class="mandatory"> *</span></label>
							<input type="text" class="form-control" name="commairtestcomp" placeholder="Enter Test Completed By" value="<?php echo set_value('commairtestcomp', (isset($prcdata['u2fname'])) ? $prcdata['u2fname'].' '.$prcdata['u2lname'] : ''); ?>" readonly="readonly" />
                			<?php echo form_error('commairtestcomp', '<div class="form-error">', '</div>'); ?>
                		</div>
						<div class="col-sm-4">
							<label><strong>Services Contractor:</strong><span class="mandatory"> *</span></label>
							<input type="text" class="form-control" name="commairsercontract" placeholder="Enter Service Contractor" value="<?php echo set_value('commairsercontract', (isset($prcdata['servicecontractorname'])) ? $prcdata['servicecontractorname'] : ''); ?>" readonly="readonly" />
                			<?php echo form_error('commairsercontract', '<div class="form-error">', '</div>'); ?>
                		</div>
                		<div class="col-sm-4">
							<label><strong>Date:</strong><span class="mandatory"> *</span></label>
							<input type="text" class="form-control datepicker" name="commairtestcompdate" value="<?php echo set_value('commairtestcompdate', (isset($prcdata['servicecontractdate'])) ? date('d m, Y',strtotime($prcdata['servicecontractdate'])) : date('d m, Y')); ?>" />
                			<?php echo form_error('commairtestcompdate', '<div class="form-error">', '</div>'); ?>
                		</div>
					</div>

					<div class="form-group clearfix">
						<div class="col-sm-12">
							<label><strong>Comments:</strong><span class="mandatory"> *</span></label>
							<textarea class="form-control" name="commaircomments" ><?php echo set_value('commaircomments', (isset($prcdata['comments'])) ? $prcdata['comments'] : ''); ?></textarea>
                			<?php echo form_error('commaircomments', '<div class="form-error">', '</div>'); ?>
						</div>
					</div>
				</div>
				<footer class="panel-footer text-right bg-light lter"> 
					<input type="hidden" name="shtenadis" class="shtenadis" value="<?php echo set_value('shtenadis', (isset($sheetstatus[0]['status'])) ? $sheetstatus[0]['status'] : '1'); ?>" />
					<input type="hidden" name="existid" value="<?php echo $this->uri->segment(4); ?>" />

					<input type="hidden" name="projectid" id="projectid" value="<?php echo $proid; ?>">
					<input type="hidden" name="sheetid" id="sheetid" value="<?php echo $prcessid; ?>">

					<input type="submit" name="submit" value="Submit" class="btn btn-success btn-sm submit-btn addnew">
					<input type="submit" name="cancel" value="Cancel" class="btn btn-danger btn-sm submit-btn cancel">
			</footer> 
			</form>
			</div>			
		</section>
	</section>
</section>