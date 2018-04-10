<section class="vbox">
	<section class="scrollable padder">
		<section class="panel panel-default">

            <header class="panel-heading">
				<div class="row clearfix">
					<div class="col-sm-6"><strong><?php echo $title; ?></strong></div>					
					<div class="col-sm-3"><strong>Process:</strong>&nbsp;&nbsp;&nbsp;<label class="radio-inline"><input type="radio" class="proshtstatus" value="1" name="optradio" <?php if(isset($sheetstatus)) { if(($sheetstatus)==1) { echo 'checked="checked"'; }  }  ?>>Enabled</label><label class="radio-inline"><input type="radio" class="proshtstatus" value="0" name="optradio" <?php if(isset($sheetstatus)) { if(($sheetstatus)==0) { echo 'checked="checked"'; }  } ?>>Disabled</label>
					<!-- <input data-id="0" data-toggle="toggle" data-on="Enabled" data-off="Disabled" data-size="mini" type="checkbox" id="toggle-two" <?php if(isset($sheetstatus[0]['status'])) { if(($sheetstatus[0]['status'])==1) { echo 'checked="checked"'; }  } else{ echo 'checked="checked"'; } ?> > --></div>
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
			<form method="POST" id="addnewtimesheet" name="adduser" action="" class="addusernew">
				<div class="row">

					<div class="form-group clearfix">
						
						<div class="col-sm-3"><strong>Project:</strong>
                         <?php echo $prodata['projectname']; ?>	
						</div>


					<div class="col-sm-3">
						<div class="row clearfix">
							<div class="col-sm-3"><label><strong>Ref:</strong><span class="mandatory"> *</span></label></div>
							<div class="col-sm-9">
								<input type="text" name="reportref" class="form-control" value="<?php echo set_value('reportref', (isset($prcdata['referenceno'])) ? $prcdata['referenceno'] : ''); ?>">
								<?php echo form_error('reportref', '<div class="form-error">', '</div>'); ?>
							</div>
						</div>
					 </div>

        		<div class="col-sm-3">
						<div class="row clearfix">
							<div class="col-sm-5"><label><strong>System:</strong><span class="mandatory"> *</span></label></div>
							<div class="col-sm-7">
								<select name="projsystem" id="projsystem" class="form-control">
						<option value="">Please Select</option>									
						<?php 
							$allsystems=$this->MProject->getSystems($proid);
							$projectsystemid=0;
							if(isset($_POST['projsystem']))
							{
								$projectsystemid=$this->input->post('projsystem');
							}
							elseif(isset($prcdata['system']))
							{
								$projectsystemid=$prcdata['system'];
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
								<?php
									#echo '<pre>'; print_r($allsystems->result_array()); echo '</pre>';
								?>
								<!--<input type="text" name="projsystem" class="form-control" value="<?php echo set_value('projsystem', (isset($prcdata['system'])) ? $prcdata['system'] : ''); ?>"> -->
								<?php echo form_error('projsystem', '<div class="form-error">', '</div>'); ?>
							</div>
						</div>									
					</div>

					<div class="col-sm-3"><strong>Client:</strong>
                        <?php $userincharge = $prodata['userincharge']; 
                        $client_name=$this->Common_model->getCustomerById($userincharge);
                       // print_r($client_name);
                        echo $client_name['custname'];
                        $clientsign=$client_name['csignature'];
                        ?>	

					 </div>

							

					</div>

					<div class="form-group clearfix">
						<div class="col-sm-12">
							<table class="table table-bordered table-striped">
								<thead>
									<tr>
										<th class="text-center">Day</th>
										<th class="text-center">Date</th>
										<th class="text-center">Hours</th>
										<th class="text-center">Engineers Name</th>
									</tr>
								</thead>
								<tbody>
									<?php
										foreach ($timesheetdata as $key => $value) {
									?>
									<tr>
										<th><?php echo $tshdays[$value['dayid']]; ?><input type="hidden" name="dayid[]" value="<?php echo $value['dayid']; ?>"></th>
										<td><input type="text" class="form-control datepicker" name="daydate<?php echo $value['dayid']; ?>" value="<?php echo set_value('daydate'.$value['dayid'], (!empty($value['daydate']) && ($value['daydate']!='0000-00-00 00:00:00')) ? date(DT_FORMAT,strtotime($value['daydate'])) : ''); ?>" /></td>
										<td><input type="text" class="form-control timepicker" name="dayhours<?php echo $value['dayid']; ?>" value="<?php echo set_value('dayhours'.$value['dayid'], (!empty($value['dayhours']) && ($value['dayhours']!='0000-00-00 00:00:00')) ? date(TIME_FORMAT,strtotime($value['dayhours'])) : ''); ?>" /></td>
										<td>
											<select class="form-control" name="dayengg<?php echo $value['dayid']; ?>">
											<option value="">Please Select</option>
											<?php
												$commairreptenggsign=0;
												if(isset($_POST['dayengg'.$value['dayid']]))
												{
													$commairreptenggsign=$this->input->post('dayengg'.$value['dayid']);
												}
												elseif(isset($value['dayengg']))
												{
													$commairreptenggsign=$value['dayengg'];
												}
												else
												{

												}																	
												if(!empty($engdata))
												{
													foreach ($engdata as $eng_key => $eng_value) {
														$selected='';
														if(($eng_value['userid']==$commairreptenggsign))
														{
															$selected=' selected="selected" ';
														}
														echo '<option value="'.$eng_value['userid'].'" '.$selected.'>'.$eng_value['firstname'].' '.$eng_value['lastname'].'</option>';
													}
												}
											?>
											</select>
											<input type="hidden" name="tmeshtdataids<?php echo $value['dayid']; ?>" value="<?php echo set_value('tmeshtdataids'.$value['dayid'], (isset($value['id'])) ? $value['id'] : 0); ?>">
										</td>
									</tr>
									<?php
									}
									?>
								</tbody>
							</table>
						</div>
					</div>
					<div class="form-group clearfix">
						<div class="col-sm-12">
							<label>Comments/Description:</label>
							<textarea class="form-control" name="commaircomments"><?php echo set_value('commaircomments', (isset($prcdata['comments'])) ? $prcdata['comments'] : ''); ?></textarea>
						</div>
					</div>
					<div class="form-group clearfix">					

					<div class="col-sm-4">					
						<label>Clients Signature<span class="mandatory"> *</span></label>
							<div id="signature-pad" class="m-signature-pad">
							    <div class="m-signature-pad--body">
							      <canvas></canvas>
							    </div>
							    <div class="m-signature-pad--footer">
							      <div class="left">
							        <button type="button" class="button clear btn btn-xs btn-info" data-action="clear">Clear</button>
							      </div>							      
							    </div>									    
							    <input type="hidden" class="form-control signature" name="clientsign" placeholder="" value="<?php echo set_value('clientsign', (isset($timshtmaster[0]['clientsign'])) ? $timshtmaster[0]['clientsign'] : ''); ?>" />
							    <?php echo form_error('clientsign', '<div class="form-error">', '</div>'); ?>

							  </div>
					</div>
					<?php
					/*
						<div class="col-sm-4">
							<label>Clients Signature</label>							
							<input type="hidden" name="clientsign" id="clientsign" value="<?php echo $clientsign; ?>" />
	            			<img src="<?php echo $clientsign; ?>" alt="No Signature" name="clientsignimg" class="img-responsive clientsign" id="clientsignimg">

							<!--<input type="text" class="form-control" name="clientsign" placeholder="" value="<?php echo set_value('clientsign', (isset($timshtmaster[0]['clientsign'])) ? $timshtmaster[0]['clientsign'] : ''); ?>" />
                			<?php echo form_error('clientsign', '<div class="form-error">', '</div>'); ?>-->
						</div>
						*/
						?>
						<div class="col-sm-4">
							<label>Position<span class="mandatory"> *</span></label>
							<input type="text" class="form-control" name="position" placeholder="" value="<?php echo set_value('position', (isset($timshtmaster[0]['position'])) ? $timshtmaster[0]['position'] : ''); ?>" />
                			<?php echo form_error('position', '<div class="form-error">', '</div>'); ?>
						</div>
						<div class="col-sm-4">
							<label>Date<span class="mandatory"> *</span></label>
							<input type="text" class="form-control datepicker" name="signdate" placeholder="" value="<?php echo set_value('signdate', (!empty($timshtmaster[0]['signdate'])) ? date(DT_FORMAT,strtotime($timshtmaster[0]['signdate'])) : date(DT_FORMAT)); ?>" />
                			<?php echo form_error('signdate', '<div class="form-error">', '</div>'); ?>
                			<input type="hidden" name="timesheetid" value="<?php echo set_value('timesheetid', (isset($timshtmaster[0]['id'])) ? $timshtmaster[0]['id'] : ''); ?>" />
						</div>
					</div>
					<div class="form-group clearfix">
						<div class="col-sm-4">									
							<label><strong>Engineer:</strong><span class="mandatory"> *</span></label>
							<select class="form-control" name="commairreptenggsign">
								<option value="">Please Select</option>
								<?php
									$commairreptenggsign=0;
									if(isset($_POST['commairreptenggsign']))
									{
										$commairreptenggsign=$this->input->post('commairreptenggsign');
									}
									elseif(isset($prcdata['engineerid']))
									{
										$commairreptenggsign=$prcdata['engineerid'];
									}
									else
									{

									}																	
									if(!empty($engdata))
									{
										foreach ($engdata as $eng_key => $eng_value) {
											$selected='';
											if(($eng_value['userid']==$commairreptenggsign))
											{
												$selected=' selected="selected" ';
											}
											echo '<option value="'.$eng_value['userid'].'" '.$selected.'>'.$eng_value['firstname'].' '.$eng_value['lastname'].'</option>';
										}
									}
								?>
							</select>
                			<?php echo form_error('commairreptenggsign', '<div class="form-error">', '</div>'); ?>
						</div>
						<div class="col-sm-4">
							<label><strong>Date:</strong><span class="mandatory"> *</span></label>
							<input type="text" class="form-control datepicker" name="commairreptenggdate" placeholder="" value="<?php echo set_value('commairreptenggdate', (isset($prcdata['reportdate'])) ? date(DT_FORMAT,strtotime($prcdata['reportdate'])) : date(DT_FORMAT)); ?>" />
                			<?php echo form_error('commairreptenggdate', '<div class="form-error">', '</div>'); ?>
						</div>
					</div>
				</div>
		<footer class="panel-footer text-right bg-light lter"> 
					<input type="hidden" name="shtenadis" class="shtenadis" value="<?php echo set_value('shtenadis', (isset($sheetstatus[0]['status'])) ? $sheetstatus[0]['status'] : '1'); ?>" />
					<input type="hidden" name="existid" value="<?php echo $this->uri->segment(4); ?>" />

					<input type="hidden" name="projectid" id="projectid" value="<?php echo $proid; ?>">
					<input type="hidden" name="sheetid" id="sheetid" value="<?php echo $prcessid; ?>">


					<input type="submit" name="submit" value="Submit" class="btn btn-success btn-s-xs submit-btn addnew">
					<input type="submit" name="cancel" value="Cancel" class="btn btn-danger btn-s-xs submit-btn cancel">
					
		</footer>

				<br><br><br>
			</form>
			</div>			
		</section>
	</section>
</section>
