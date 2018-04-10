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
						<div class="col-sm-4">&nbsp;</div>
					</div>
					<div class="form-group clearfix">
						<div class="col-sm-4">
							<label>Company Owning Valve<span class="mandatory"> *</span></label>
							<input type="text" class="form-control" name="comownvalve" placeholder="Enter Company Owning Valve" value="<?php echo set_value('comownvalve', (isset($rpzdata['comownvalve'])) ? $rpzdata['comownvalve'] : ''); ?>" />
                			<?php echo form_error('comownvalve', '<div class="form-error">', '</div>'); ?>
                		</div>
						<div class="col-sm-4">
							<label>Water Suppliers Customer (if Different)<span class="mandatory"> *</span></label>
							<input type="text" class="form-control" name="watersuppcustomer" placeholder="Enter Water Suppliers Customer" value="<?php echo set_value('watersuppcustomer', (isset($rpzdata['watersuppcustomer'])) ? $rpzdata['watersuppcustomer'] : ''); ?>" />
                			<?php echo form_error('watersuppcustomer', '<div class="form-error">', '</div>'); ?>
                		</div>
                		<div class="col-sm-4">
							<label>Water Supplier<span class="mandatory"> *</span></label>
							<select class="form-control watersupp" name="watersupp" data-alt="valvesigned" data-id="valvesignedimg">
								<option value="">Please Select</option>
								<?php
								$valvesigned='';
									if($userall->num_rows()>0)
									{
										$userall_data=$userall->result_array();
										foreach ($userall_data as $ud_key => $ud_value) {
											$selected='';
											
											if($ud_value['userid']==$rpzdata['watersupp'])
											{
												$selected=' selected="selected" ';
												$valvesigneddata=$this->Common_model->getUserById($ud_value['userid']);
												$valvesigned=$valvesigneddata['signature'];
											}
											elseif($ud_value['userid']==$_POST['watersupp'])
											{
												$selected=' selected="selected" ';
												$valvesigneddata=$this->Common_model->getUserById($ud_value['userid']);
												$valvesigned=$valvesigneddata['signature'];
											}
											else
											{

											}

											echo '<option value="'.$ud_value['userid'].'" '.$selected.'>'.$ud_value['firstname'].' '.$ud_value['lastname'].'</option>';

										}
									}
								?>
							</select>
							<!--<input type="text" class="form-control" name="watersupp" placeholder="Enter Water Supplier" value="<?php echo set_value('watersupp', (isset($rpzdata['watersupp'])) ? $rpzdata['watersupp'] : ''); ?>" />-->
                			<?php echo form_error('watersupp', '<div class="form-error">', '</div>'); ?>
                		</div>
					</div>

					<div class="form-group clearfix">
						<div class="col-sm-4">
							<label>Location Address of Valve<span class="mandatory"> *</span></label>
							<input type="text" class="form-control" name="valvelocation" placeholder="Enter Location Address of Valve" value="<?php echo set_value('valvelocation', (isset($rpzdata['valvelocation'])) ? $rpzdata['valvelocation'] : ''); ?>" />
                			<?php echo form_error('valvelocation', '<div class="form-error">', '</div>'); ?>
                			<div class="clearfix"></div>
                			<label>Tel:<span class="mandatory"> *</span></label>
							<input type="text" class="form-control" name="valvelocationtel" placeholder="" value="<?php echo set_value('valvelocationtel', (isset($rpzdata['valvelocationtel'])) ? $rpzdata['valvelocationtel'] : ''); ?>" />
                			<?php echo form_error('valvelocationtel', '<div class="form-error">', '</div>'); ?>

                		</div>
						<div class="col-sm-4">
							<label>Valve<span class="mandatory"> *</span></label>
							<table class="table table-bordered table-striped">
								<thead>
									<tr>
										<th>Make</th>
										<th>Size</th>
										<th>Serial</th>
										<th>Model</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td><input type="text" class="form-control" name="valvemake" placeholder="Make" value="<?php echo set_value('valvemake', (isset($rpzdata['valvemake'])) ? $rpzdata['valvemake'] : ''); ?>" /></td>
                						<td><input type="text" class="form-control" name="valvesize" placeholder="Size" value="<?php echo set_value('valvesize', (isset($rpzdata['valvesize'])) ? $rpzdata['valvesize'] : ''); ?>" /></td>
			                			<td><input type="text" class="form-control" name="valveserial" placeholder="Serial" value="<?php echo set_value('valveserial', (isset($rpzdata['valveserial'])) ? $rpzdata['valveserial'] : ''); ?>" /></td>
			                			<td><input type="text" class="form-control" name="valvemodel" placeholder="Model" value="<?php echo set_value('valvemodel', (isset($rpzdata['valvemodel'])) ? $rpzdata['valvemodel'] : ''); ?>" /></td>
									</tr>
								</tbody>
							</table>
							<?php echo form_error('valvemodel', '<div class="form-error">', '</div>'); ?>
                		</div>
                		<div class="col-sm-4">
							<label>Permission to Turn off Supply (Capital letters)<span class="mandatory"> *</span></label>
							<input type="text" class="form-control" name="perturnoffsupply" placeholder="Enter Permission to Turn off Supply" value="<?php echo set_value('perturnoffsupply', (isset($rpzdata['perturnoffsupply'])) ? $rpzdata['perturnoffsupply'] : ''); ?>" />
                			<?php echo form_error('perturnoffsupply', '<div class="form-error">', '</div>'); ?>
                			<div class="clearfix"></div>
                			<label>Signed</label>
							<!--<input type="text" class="form-control" name="valvesigned" placeholder="" value="<?php echo set_value('valvesigned', (isset($rpzdata['valvesigned'])) ? $rpzdata['valvesigned'] : ''); ?>" />
                			<?php echo form_error('valvesigned', '<div class="form-error">', '</div>'); ?>-->
                			
                			<input type="hidden" name="valvesigned" id="valvesigned" value="<?php echo $valvesigned; ?>" />
                			<img src="<?php echo $valvesigned; ?>" alt="No Signature" name="valvesignedimg" class="img-responsive testersign" id="valvesignedimg">
                		</div>
					</div>

					<div class="form-group clearfix">
						<div class="col-sm-4">
							<label>Location of Valve On Site (Building No.)<span class="mandatory"> *</span></label>
							<input type="text" class="form-control" name="locvalveonsite" placeholder="Enter Location of Valve On Site" value="<?php echo set_value('locvalveonsite', (isset($rpzdata['locvalveonsite'])) ? $rpzdata['locvalveonsite'] : ''); ?>" />
                			<?php echo form_error('locvalveonsite', '<div class="form-error">', '</div>'); ?>
                		</div>
						<div class="col-sm-4">
							<label>Accessibility & Clearances<span class="mandatory"> *</span></label>
							<input type="text" class="form-control" name="accessibility" placeholder="Enter Accessibility & Clearances" value="<?php echo set_value('accessibility', (isset($rpzdata['accessibility'])) ? $rpzdata['accessibility'] : ''); ?>" />
                			<?php echo form_error('accessibility', '<div class="form-error">', '</div>'); ?>
                		</div>
                		<div class="col-sm-4">
							<label>Time of Turn Off (24 Hour Clock)<span class="mandatory"> *</span></label>
							<input type="text" class="form-control timepicker" name="timeturnoff" placeholder="Enter Time of Turn Off" value="<?php echo set_value('timeturnoff', (isset($rpzdata['timeturnoff'])) ? $rpzdata['timeturnoff'] : ''); ?>" />
                			<?php echo form_error('timeturnoff', '<div class="form-error">', '</div>'); ?>
                		</div>
					</div>

					<div class="form-group clearfix">
						<div class="col-sm-4">
							<label>Installation Company (If Known)<span class="mandatory"> *</span></label>
							<input type="text" class="form-control" name="installcompany" placeholder="Enter Installation Company" value="<?php echo set_value('installcompany', (isset($rpzdata['installcompany'])) ? $rpzdata['installcompany'] : ''); ?>" />
                			<?php echo form_error('installcompany', '<div class="form-error">', '</div>'); ?>
                			<div class="clearfix"></div>
                			<label>Tel<span class="mandatory"> *</span></label>
							<input type="text" class="form-control" name="installcompanytel" placeholder="" value="<?php echo set_value('installcompanytel', (isset($rpzdata['installcompanytel'])) ? $rpzdata['installcompanytel'] : ''); ?>" />
                			<?php echo form_error('installcompanytel', '<div class="form-error">', '</div>'); ?>
                		</div>
						<div class="col-sm-4">
							<label>Unobstructed Drain Air Gap<span class="mandatory"> *</span></label>
							<input type="text" class="form-control" name="unobstrucdrain" placeholder="Enter Unobstructed Drain Air Gap" value="<?php echo set_value('unobstrucdrain', (isset($rpzdata['unobstrucdrain'])) ? $rpzdata['unobstrucdrain'] : ''); ?>" />
                			<?php echo form_error('unobstrucdrain', '<div class="form-error">', '</div>'); ?>
                		</div>
                		<div class="col-sm-4">
							<label>Meter Reading (If appilicable)<span class="mandatory"> *</span></label>
							<input type="text" class="form-control" name="meterreading" placeholder="Enter Meter Reading" value="<?php echo set_value('meterreading', (isset($rpzdata['meterreading'])) ? $rpzdata['meterreading'] : ''); ?>" />
                			<?php echo form_error('meterreading', '<div class="form-error">', '</div>'); ?>
                		</div>
					</div>
					<div class="form-group clearfix">
						<div class="col-sm-4">
							<label>Type of Plant/Equip Being Supplied<span class="mandatory"> *</span></label>
							<input type="text" class="form-control" name="plantype" placeholder="Enter Type of Plant/Equip Being Supplied" value="<?php echo set_value('plantype', (isset($rpzdata['plantype'])) ? $rpzdata['plantype'] : ''); ?>" />
	            			<?php echo form_error('plantype', '<div class="form-error">', '</div>'); ?>
	            		</div>
						<div class="col-sm-4">
							<label>Strainer Present<span class="mandatory"> *</span></label>
							<input type="text" class="form-control" name="strainerpresent" placeholder="Enter Strainer Present" value="<?php echo set_value('strainerpresent', (isset($rpzdata['strainerpresent'])) ? $rpzdata['strainerpresent'] : ''); ?>" />
	            			<?php echo form_error('strainerpresent', '<div class="form-error">', '</div>'); ?>
	            		</div>
	            		<div class="col-sm-4">
							<label>Valve Installation Date<span class="mandatory"> *</span></label>
							<input type="text" class="form-control datepicker" name="valveinstalldate" placeholder="Enter Valve Installation Date" value="<?php echo set_value('valveinstalldate', (isset($rpzdata['valveinstalldate'])&&($rpzdata['valveinstalldate']!="0000-00-00 00:00:00")) ? date(DT_FORMAT, strtotime($rpzdata['valveinstalldate'])) : ''); ?>" />
	            			<?php echo form_error('valveinstalldate', '<div class="form-error">', '</div>'); ?>
	            		</div>
	            	</div>
					<div class="form-group clearfix">
						<div class="col-sm-4">
							<label>Isolating Valve No.2 Tight<span class="mandatory"> *</span></label>
							<input type="text" class="form-control" name="isolatingvalve2" placeholder="Enter Isolating Valve No.2 Tight" value="<?php echo set_value('isolatingvalve2', (isset($rpzdata['isolatingvalve2'])) ? $rpzdata['isolatingvalve2'] : ''); ?>" />
                			<?php echo form_error('isolatingvalve2', '<div class="form-error">', '</div>'); ?>
                		</div>
						<div class="col-sm-4">
							<label>Commissioning Date (1st Test)<span class="mandatory"> *</span></label>
							<input type="text" class="form-control datepicker" name="commdate" placeholder="Enter Commissioning Date" value="<?php echo set_value('commdate', (isset($rpzdata['commdate'])&&($rpzdata['commdate']!="0000-00-00 00:00:00")) ? date(DT_FORMAT, strtotime($rpzdata['commdate'])) : ''); ?>" />
                			<?php echo form_error('commdate', '<div class="form-error">', '</div>'); ?>
                		</div>
					</div>

					<hr>


					<div class="form-group clearfix">
						<div class="col-sm-12">
							<table class="table table-bordered table-striped">
								<thead>
									<tr>
										<th>&nbsp;</th>
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
										<td>Opened at <input type="text" class="form-control" name="inireliefvalve" placeholder="" value="<?php echo set_value('inireliefvalve', (isset($rpzdata['inireliefvalve'])) ? $rpzdata['inireliefvalve'] : ''); ?>" /> Bar</td>
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
										<td>Differential Pressure <input type="text" class="form-control" name="inidiffpressure1" placeholder="" value="<?php echo set_value('inidiffpressure1', (isset($rpzdata['inidiffpressure1'])) ? $rpzdata['inidiffpressure1'] : ''); ?>" /> Bar</td>
										<td>Differential Pressure <input type="text" class="form-control" name="inidiffpressure2" placeholder="" value="<?php echo set_value('inidiffpressure2', (isset($rpzdata['inidiffpressure2'])) ? $rpzdata['inidiffpressure2'] : ''); ?>" /> Bar</td>
									</tr>
									<tr>
										<th>Repairs & Materials Used</th>
										<td colspan="5"><textarea class="form-control" name="repairmaterial"><?php echo set_value('repairmaterial', (isset($rpzdata['repairmaterial'])) ? $rpzdata['repairmaterial'] : ''); ?></textarea></td>
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
										<td>Opened at <input type="text" class="form-control" name="repreliefvalve" placeholder="" value="<?php echo set_value('repreliefvalve', (isset($rpzdata['repreliefvalve'])) ? $rpzdata['repreliefvalve'] : ''); ?>" /> Bar</td>
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
										<td>Differential Pressure <input type="text" class="form-control" name="repdiffpressure1" placeholder="" value="<?php echo set_value('repdiffpressure1', (isset($rpzdata['repdiffpressure1'])) ? $rpzdata['repdiffpressure1'] : ''); ?>" /> Bar</td>
										<td>Differential Pressure <input type="text" class="form-control" name="repdiffpressure2" placeholder="" value="<?php echo set_value('repdiffpressure2', (isset($rpzdata['repdiffpressure2'])) ? $rpzdata['repdiffpressure2'] : ''); ?>" /> Bar</td>
									</tr>
									</tr>
								</tbody>
							</table>
                		</div>
					</div>

					<div class="form-group clearfix">
						<div class="col-sm-12">
							<label><strong>Comments:</strong></label>
							<textarea class="form-control" name="commaircomments"><?php echo set_value('commaircomments', (isset($prcdata['comments'])) ? $prcdata['comments'] : ''); ?></textarea>
						</div>
					</div>
					
					<div class="form-group clearfix">
						<div class="col-sm-4">
							<label>Testers Name<span class="mandatory"> *</span></label>
							<select class="form-control testername" name="testername" data-alt="testersign" data-id="testersignimg">
								<option value="">Please Select</option>
								<?php
									$testersign='';
									if($userall->num_rows()>0)
									{
										$userall_data=$userall->result_array();
										foreach ($userall_data as $ud_key => $ud_value) {
											$selected='';
											
											if($ud_value['userid']==$rpzdata['testername'])
											{
												$selected=' selected="selected" ';
												$testersigndata=$this->Common_model->getUserById($ud_value['userid']);
												$testersign=$testersigndata['signature'];
											}
											elseif($ud_value['userid']==$_POST['testername'])
											{
												$selected=' selected="selected" ';
												$testersigndata=$this->Common_model->getUserById($ud_value['userid']);
												$testersign=$testersigndata['signature'];
											}
											else
											{

											}

											echo '<option value="'.$ud_value['userid'].'" '.$selected.'>'.$ud_value['firstname'].' '.$ud_value['lastname'].'</option>';

										}
									}
								?>
							</select>
							<!-- <input type="text" class="form-control" name="testername" placeholder="Enter Testers Name" value="<?php echo set_value('testername', (isset($rpzdata['testername'])) ? $rpzdata['testername'] : ''); ?>" /> -->
	            			<?php echo form_error('testername', '<div class="form-error">', '</div>'); ?>
	            		</div>
						<div class="col-sm-4">
							<label>Testers No.<span class="mandatory"> *</span></label>
							<input type="text" class="form-control" name="testerno" placeholder="Enter Testers Number" value="<?php echo set_value('testerno', (isset($rpzdata['testerno'])) ? $rpzdata['testerno'] : ''); ?>" />
	            			<?php echo form_error('testerno', '<div class="form-error">', '</div>'); ?>
	            		</div>
	            		<div class="col-sm-4">
							<label>Signed</label>
							<!-- <input type="text" class="form-control" name="testersign" placeholder="" value="<?php echo set_value('testersign', (isset($rpzdata['testersign'])) ? $rpzdata['testersign'] : ''); ?>" />
	            			<?php echo form_error('testersign', '<div class="form-error">', '</div>'); ?> -->
	            			<input type="hidden" name="testersign" id="testersign" value="<?php echo $testersign; ?>" />
	            			<img src="<?php echo $testersign; ?>" alt="No Signature" name="testersignimg" class="img-responsive testersign" id="testersignimg">
	            		</div>
	            	</div>

	            	<div class="form-group clearfix">
						<div class="col-sm-4">
							<label>Turn On Time<span class="mandatory"> *</span></label>
							<input type="text" class="form-control timepicker" name="turnontime" placeholder="Enter Turn On Time" value="<?php echo set_value('turnontime', (isset($rpzdata['turnontime'])) ? $rpzdata['turnontime'] : ''); ?>" />
	            			<?php echo form_error('turnontime', '<div class="form-error">', '</div>'); ?>
	            		</div>
						<div class="col-sm-4">
							<label>Date of Completion<span class="mandatory"> *</span></label>
							<input type="text" class="form-control datepicker" name="completedate" placeholder="" value="<?php echo set_value('completedate', (isset($rpzdata['completedate'])&&($rpzdata['completedate']!="0000-00-00 00:00:00")) ? date(DT_FORMAT, strtotime($rpzdata['completedate'])) : ''); ?>" />
	            			<?php echo form_error('completedate', '<div class="form-error">', '</div>'); ?>
	            		</div>
	            		<div class="col-sm-4">
							<label>Date of Next Date<span class="mandatory"> *</span></label>
							<input type="text" class="form-control datepicker" name="nextestdate" placeholder="" value="<?php echo set_value('nextestdate', (isset($rpzdata['nextestdate'])&&($rpzdata['nextestdate']!="0000-00-00 00:00:00")) ? date(DT_FORMAT, strtotime($rpzdata['nextestdate'])) : ''); ?>" />
	            			<?php echo form_error('nextestdate', '<div class="form-error">', '</div>'); ?>
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
			</form>
			</div>			
		</section>
	</section>
</section>
