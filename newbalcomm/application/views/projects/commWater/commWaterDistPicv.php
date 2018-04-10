<section class="vbox">
	<section class="scrollable padder">
		<section class="panel panel-default">
			<header class="panel-heading">
				<div class="row clearfix">
					<div class="col-sm-6"><strong><?php echo $title; ?></strong></div>					
					<div class="col-sm-3"><strong>Process:</strong>&nbsp;&nbsp;&nbsp;<label class="radio-inline"><input type="radio" class="proshtstatus" value="1" name="optradio" <?php if(isset($sheetstatus[0]['status'])) { if(($sheetstatus[0]['status'])==1) { echo 'checked="checked"'; }  }  ?>>Enabled</label><label class="radio-inline"><input type="radio" class="proshtstatus" value="0" name="optradio" <?php if(isset($sheetstatus[0]['status'])) { if(($sheetstatus[0]['status'])==0) { echo 'checked="checked"'; }  } ?>>Disabled</label>
					<!-- <input data-id="0" data-toggle="toggle" data-on="Enabled" data-off="Disabled" data-size="mini" type="checkbox" id="toggle-two" <?php if(isset($sheetstatus[0]['status'])) { if(($sheetstatus[0]['status'])==1) { echo 'checked="checked"'; }  } else{ echo 'checked="checked"'; } ?> > --></div>
					<div class="col-sm-3 text-right">
					<a href="<?php echo site_url('projects/'.$this->uri->segment(2).'/'.$this->uri->segment(3)); ?>" class="pull-left" <?php if(isset($sidemenu_sub_enable)) { if(($sidemenu_sub_enable)==0) { echo 'style="pointer-events: none"'; }  } ?>><button type="button" class="btn btn-primary btn-xs">Add New</button></a>
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
			<form method="POST" name="adduser" action="" class="addusernew processForm">
				<div class="row">
					<div class="clearfix">
						<div class="panel-body">
				        	<div class="row form-group clearfix">
								<div class="col-sm-4"><strong>Project Name:</strong> <?php echo $prodata['projectname']; ?></div>
								<!-- <div class="col-sm-4">
									<div class="row clearfix">
										<div class="col-sm-3"><label><strong>Ref:</strong><span class="mandatory"> *</span></label></div>
										<div class="col-sm-9">
											<input type="text" name="reportref" class="form-control" <?php if(isset($sidemenu_sub_enable)) { if(($sidemenu_sub_enable)==0) { echo 'readonly="true"'; }  } ?> value="<?php echo set_value('reportref', (isset($prcdata['referenceno'])) ? $prcdata['referenceno'] : ''); ?>">
											<?php echo form_error('reportref', '<div class="form-error">', '</div>'); ?>
										</div>
									</div>
								</div> -->
								<div class="col-sm-4"><strong>Project Number:</strong> <?php echo $prodata['projectnumber']; ?></div>
								<div class="col-sm-4">
									<div class="row clearfix">
										<div class="col-sm-4"><label><strong>System:</strong><span class="mandatory"> *</span></label></div>
										<div class="col-sm-8">
											<select name="projsystem" id="projsystem" class="form-control" <?php if(isset($sidemenu_sub_enable)) { if(($sidemenu_sub_enable)==0) { echo 'readonly="true"'; }  } ?>>
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
										else if($this->session->userdata('system_value'))
										{
											$projectsystemid=$this->session->userdata('system_value');
										}
										else
										{

										}
										if(isset($sidemenu_sub_enable)) 
										{ 
										  if(($sidemenu_sub_enable)==0) 
										  { 
											$enabled = 'disabled'; 
										  }  
										  else
										  {
											$enabled = ''; 
										  }
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
												echo '<option '.$enabled.' value="'.$sd_value['id'].'" '.$selected.'>'.$sd_value['systemname'].'</option>';
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
								<table class="table table-bordered table-striped table-td-2" id="cwwaterdiststpicv">
									<thead>
										<tr>
											<th class="text-center td_border_right" colspan="8">Design Information</th>
											<th class="text-center" colspan="4">Measured</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<th class="text-center"><strong>Ref.<br>No</strong></th>
											<th class="text-center"><strong>Manuf</strong></th>
											<th class="text-center"><strong>Type</strong></th>
											<th class="text-center"><strong>PICV<br>Setting</strong></th>
											<th class="text-center"><strong>Size<br>mm</strong></th>
											<th class="text-center"><strong>Kvs</strong></th>
											<th class="text-center"><strong>Flow<br>i/s</strong></th>
											<th class="text-center td_border_right"><strong>PD<br>kpa</strong></th>
											<th class="text-center"><strong>PD<br>kpa</strong></th>
											<th class="text-center"><strong>Flow<br>i/s</strong></th>
											<th class="text-center"><strong>%<br>Design</strong></th>
											<th class="text-center">&nbsp;</th>
										</tr>
										<?php
										foreach ($cwwaterdiststrcd as $gd_key => $gd_value) 
										{											
									?>
										<tr class="cwwaterdistpicvrcdtr cwwaterdistpicvrcd_tr_<?php echo $gd_key; ?>">
											<td><input type="text" <?php if(isset($sidemenu_sub_enable)) { if(($sidemenu_sub_enable)==0) { echo 'readonly="true"'; }  } ?> class="form-control deinforefnum" name="deinforefnum[]" value="<?php echo set_value('deinforefnum['.$gd_key.']', (isset($gd_value['deinforefnum'])) ? $gd_value['deinforefnum'] : ''); ?>" /></td>
											<td><input type="text" <?php if(isset($sidemenu_sub_enable)) { if(($sidemenu_sub_enable)==0) { echo 'readonly="true"'; }  } ?> class="form-control deinfomanuf" name="deinfomanuf[]" value="<?php echo set_value('deinfomanuf['.$gd_key.']', (isset($gd_value['deinfomanuf'])) ? $gd_value['deinfomanuf'] : ''); ?>" /></td>
											<td><input type="text" <?php if(isset($sidemenu_sub_enable)) { if(($sidemenu_sub_enable)==0) { echo 'readonly="true"'; }  } ?> class="form-control deinfotype" name="deinfotype[]" value="<?php echo set_value('deinfotype['.$gd_key.']', (isset($gd_value['deinfotype'])) ? $gd_value['deinfotype'] : ''); ?>" /></td>
											<td><input type="text" <?php if(isset($sidemenu_sub_enable)) { if(($sidemenu_sub_enable)==0) { echo 'readonly="true"'; }  } ?> class="form-control deinfopicvset" name="deinfopicvset[]" value="<?php echo set_value('deinfopicvset['.$gd_key.']', (isset($gd_value['deinfopicvset'])) ? $gd_value['deinfopicvset'] : ''); ?>" /></td>
											<td><input type="text" <?php if(isset($sidemenu_sub_enable)) { if(($sidemenu_sub_enable)==0) { echo 'readonly="true"'; }  } ?> class="form-control deinfosizemm" name="deinfosizemm[]" value="<?php echo set_value('deinfosizemm['.$gd_key.']', (isset($gd_value['deinfosizemm'])) ? $gd_value['deinfosizemm'] : ''); ?>" /></td>
											<td><input type="text" <?php if(isset($sidemenu_sub_enable)) { if(($sidemenu_sub_enable)==0) { echo 'readonly="true"'; }  } ?> class="form-control num_1decimal deinfokvs" name="deinfokvs[]" value="<?php echo set_value('deinfokvs['.$gd_key.']', (isset($gd_value['deinfokvs'])) ? $gd_value['deinfokvs'] : ''); ?>" /></td>
											<td><input type="text" <?php if(isset($sidemenu_sub_enable)) { if(($sidemenu_sub_enable)==0) { echo 'readonly="true"'; }  } ?> class="form-control num_3decimal deinforflowis" name="deinforflowis[]" value="<?php echo set_value('deinforflowis['.$gd_key.']', (isset($gd_value['deinforflowis'])) ? $gd_value['deinforflowis'] : ''); ?>" /></td>
											<td class="td_border_right"><input type="text" class="form-control deinfopdkpa alwaysreadonly" name="deinfopdkpa[]"  readonly value="<?php echo set_value('deinfopdkpa['.$gd_key.']', (isset($gd_value['deinfopdkpa'])) ? $gd_value['deinfopdkpa'] : ''); ?>" /></td>
											<td><input type="text" <?php if(isset($sidemenu_sub_enable)) { if(($sidemenu_sub_enable)==0) { echo 'readonly="true"'; }  } ?> class="form-control num_2decimal measurpdkpa" name="measurpdkpa[]" value="<?php echo set_value('measurpdkpa['.$gd_key.']', (isset($gd_value['measurpdkpa'])) ? $gd_value['measurpdkpa'] : ''); ?>" /></td>
											<td><input type="text" readonly class="form-control measurflowis alwaysreadonly"  name="measurflowis[]" value="<?php echo set_value('measurflowis['.$gd_key.']', (isset($gd_value['measurflowis'])) ? $gd_value['measurflowis'] : ''); ?>" /></td>
											<td><input type="text" readonly class="form-control measurpercen alwaysreadonly"  name="measurpercen[]" value="<?php echo set_value('measurpercen['.$gd_key.']', (isset($gd_value['measurpercen'])) ? $gd_value['measurpercen'] : ''); ?>" /></td>
											<td><div class="icon_list" style="width:auto;"><a href="#" data-toggle="tooltip" title="Remove Row" class="cwdesignmeasuredpicvtrremove"><i class="fa fa-times" aria-hidden="true"></i></a></div><input type="hidden" name="cwdesignmeasured[]" class="cwdesignmeasured" value="<?php echo set_value('cwdesignmeasured['.$gd_key.']', (isset($gd_value['id'])) ? $gd_value['id'] : 0); ?>"></td>
										</tr>
										<?php
										}
										?>
									</tbody>
								</table>
								<div class="text-right"><button type="button" <?php if(isset($sidemenu_sub_enable)) { if(($sidemenu_sub_enable)==0) { echo 'style="pointer-events: none"'; }  } ?> class="btn btn-sm btn-primary design_measured_PICV_add">Add Row</button></div>
							</div>

							<div class="row form-group clearfix">
								<div class="col-sm-12">
									<label><strong>Comments:</strong></label>
									<textarea class="form-control" name="commaircomments" <?php if(isset($sidemenu_sub_enable)) { if(($sidemenu_sub_enable)==0) { echo 'readonly="true"'; }  } ?>><?php echo set_value('commaircomments', (isset($prcdata['comments'])) ? $prcdata['comments'] : ''); ?></textarea>
								</div>
							</div>

							<div class="row form-group clearfix">
								<div class="col-sm-4">									
									<label><strong>Engineer:</strong><span class="mandatory"> *</span></label>
									<select class="form-control" name="commairreptenggsign" <?php if(isset($sidemenu_sub_enable)) { if(($sidemenu_sub_enable)==0) { echo 'readonly="true"'; }  } ?>>
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
											elseif(isset($_SESSION['commWater_syscert_slected_engineer']))
											{
											$commairreptenggsign=$_SESSION['commWater_syscert_slected_engineer'];
											}
											else
											{

											}
                                            if(isset($sidemenu_sub_enable)) 
											{ 
											  if(($sidemenu_sub_enable)==0) 
											  { 
												$enabled = 'disabled'; 
											  }  
											  else
											  {
												$enabled = ''; 
												  }
											} 												
											if(!empty($engdata))
											{
												foreach ($engdata as $eng_key => $eng_value) {
													$selected='';
													if(($eng_value['userid']==$commairreptenggsign))
													{
														$selected=' selected="selected" ';
													}
													echo '<option '.$enabled.' value="'.$eng_value['userid'].'" '.$selected.'>'.$eng_value['firstname'].' '.$eng_value['lastname'].'</option>';
												}
											}
										?>
									</select>
		                			<?php echo form_error('commairreptenggsign', '<div class="form-error">', '</div>'); ?>
								</div>
								<div class="col-sm-4">
									<label><strong>Date:</strong><span class="mandatory"> *</span></label>
									<input type="text" class="form-control datepicker" name="commairreptenggdate" placeholder="" <?php if(isset($sidemenu_sub_enable)) { if(($sidemenu_sub_enable)==0) { echo 'readonly="true"'; }  } ?> value="<?php echo set_value('commairreptenggdate', (isset($prcdata['reportdate'])) ? date(DT_FORMAT,strtotime($prcdata['reportdate'])) : date(DT_FORMAT)); ?>" />
		                			<?php echo form_error('commairreptenggdate', '<div class="form-error">', '</div>'); ?>
								</div>
							</div>


				        </div>					
					</div>
				</div>
				<footer class="panel-footer text-right bg-light lter"> 
					<input type="hidden" name="shtenadis" class="shtenadis" value="<?php echo set_value('shtenadis', (isset($sheetstatus[0]['status'])) ? $sheetstatus[0]['status'] : '1'); ?>" />
					<input type="hidden" name="existid" value="<?php echo $this->uri->segment(4); ?>" />

					<input type="hidden" name="projectid" id="projectid" value="<?php echo $proid; ?>">
					<input type="hidden" name="sheetid" id="sheetid" value="<?php echo $prcessid; ?>">
					<input type="submit" name="submit" value="Submit" class="btn btn-success btn-s-xs submit-btn addnew" <?php if(isset($sidemenu_sub_enable)) { if(($sidemenu_sub_enable)==0) { echo 'disabled="disabled"'; }  } ?>>
					<input type="submit" name="cancel" value="Cancel" class="btn btn-danger btn-s-xs submit-btn cancel" <?php if(isset($sidemenu_sub_enable)) { if(($sidemenu_sub_enable)==0) { echo 'disabled="disabled"'; }  } ?>>
					
				</footer>

			</form>
			</div>
			
		</section>
	</section>
</section>
<table class="hidden">
	<tr class="cwwaterdistpicvclonetr">
		<td><input type="text" class="form-control deinforefnum" name="deinforefnum[]" value="" /></td>
		<td><input type="text" class="form-control deinfomanuf" name="deinfomanuf[]" value="" /></td>
		<td><input type="text" class="form-control deinfotype" name="deinfotype[]" value="" /></td>
		<td><input type="text" class="form-control deinfopicvset" name="deinfopicvset[]" value="" /></td>
		<td><input type="text" class="form-control deinfosizemm" name="deinfosizemm[]" value="" /></td>
		<td><input type="text" class="form-control num_1decimal deinfokvs" name="deinfokvs[]" value="" /></td>
		<td><input type="text" class="form-control num_3decimal deinforflowis" name="deinforflowis[]" value="" /></td>
		<td class="td_border_right"><input type="text" class="form-control deinfopdkpa" readonly="" name="deinfopdkpa[]" value="" /></td>
		<td><input type="text" class="form-control num_2decimal measurpdkpa" name="measurpdkpa[]" value="" /></td>
		<td><input type="text" class="form-control measurflowis" readonly="" name="measurflowis[]" value="" /></td>
		<td><input type="text" class="form-control measurpercen" readonly="" name="measurpercen[]" value="" /></td>
		<td><div class="icon_list" style="width:auto;"><a href="#" data-toggle="tooltip" title="Remove Row" class="cwdesignmeasuredpicvtrremove"><i class="fa fa-times" aria-hidden="true"></i></a></div><input type="hidden" name="cwdesignmeasured[]" class="cwdesignmeasured" value="0"></td>
	</tr>
</table>