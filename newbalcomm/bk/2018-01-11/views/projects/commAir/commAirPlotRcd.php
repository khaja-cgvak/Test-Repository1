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
				<form method="POST" name="adduser" action="" class="addusernew">
					<div class="row">
					<div class="col-sm-12">
					<div class="">
						<div class="row form-group clearfix">
							<div class="col-sm-4"><strong>Project:</strong> <?php echo $prodata['projectname']; ?></div>
							<div class="col-sm-4">
								<div class="row clearfix">
									<div class="col-sm-3"><label><strong>Ref:</strong><span class="mandatory"> *</span></label></div>
									<div class="col-sm-9">
										<input type="text" name="reportref" class="form-control" <?php if(isset($sidemenu_sub_enable)) { if(($sidemenu_sub_enable)==0) { echo 'readonly="true"'; }  } ?> value="<?php echo set_value('reportref', (isset($prcdata['referenceno'])) ? $prcdata['referenceno'] : ''); ?>">
										<?php echo form_error('reportref', '<div class="form-error">', '</div>'); ?>
									</div>
								</div>
							</div>
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

						<div class="row form-group clearfix">
							<div class="col-sm-12">
								<table class="table table-bordered table-td-5 margin-botton-0" id="plotrcdtable">
									<thead>
										<tr>
											<th class="text-center" colspan="2" width="30%">Design Information</th>
											<th class="text-center" colspan="2" width="70%">Measured</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td colspan="2" width="30%">
												<table class="table table-bordered table-td-2 margin-botton-0" id="plotrcdtable1">
													<tr>
														<td class="text-center" width="40%"><strong>Traverse<br>Ref.</strong></td>
														<td width="60%"><input type="text" name="traverseref" class="form-control traverseref" <?php if(isset($sidemenu_sub_enable)) { if(($sidemenu_sub_enable)==0) { echo 'readonly="true"'; }  } ?> value="<?php echo set_value('traverseref', (isset($prcdesign['traverseref'])) ? $prcdesign['traverseref'] : ''); ?>"></td>
													</tr>
													<tr>
														<td class="text-center" width="40%"><strong>Traverse<br>Location</strong></td>
														<td width="60%"><input type="text" name="traverselocation" class="form-control traverselocation" <?php if(isset($sidemenu_sub_enable)) { if(($sidemenu_sub_enable)==0) { echo 'readonly="true"'; }  } ?> value="<?php echo set_value('traverselocation', (isset($prcdesign['traverselocation'])) ? $prcdesign['traverselocation'] : ''); ?>"></td>
													</tr>
													<tr>
														<td class="text-center" width="40%"><strong>Duct Size<br>mm</strong></td>
														<td width="60%">
															<div class="row clearfix">
																<div class="col-sm-6">
																	<input type="text" name="duct_size_mm" class="form-control num_3decimal duct_size_mm" <?php if(isset($sidemenu_sub_enable)) { if(($sidemenu_sub_enable)==0) { echo 'readonly="true"'; }  } ?> value="<?php echo set_value('duct_size_mm', (isset($prcdesign['duct_size_mm'])) ? $prcdesign['duct_size_mm'] : ''); ?>">
																</div>
																<div class="col-sm-6">
																	<input type="text" name="duct_size_mm1" class="form-control num_3decimal duct_size_mm1" <?php if(isset($sidemenu_sub_enable)) { if(($sidemenu_sub_enable)==0) { echo 'readonly="true"'; }  } ?> value="<?php echo set_value('duct_size_mm1', (isset($prcdesign['duct_size_mm1'])) ? $prcdesign['duct_size_mm1'] : ''); ?>">
																</div>
															</div>
														</td>
													</tr>
													<tr>
														<td class="text-center" width="40%"><strong>Duct<br>Area m&sup2;</strong></td>
														<td width="60%"><input type="text" name="duct_area_m2" class="form-control duct_area_m2" <?php if(isset($sidemenu_sub_enable)) { if(($sidemenu_sub_enable)==0) { echo 'readonly="true"'; }  } ?> value="<?php echo set_value('duct_area_m2', (isset($prcdesign['duct_area_m2'])) ? $prcdesign['duct_area_m2'] : ''); ?>" ></td>
													</tr>
													<tr>
														<td class="text-center" width="40%"><strong>Flow<br>Rate m&sup3;/s</strong></td>
														<td width="60%"><input type="text" name="flow_rate_m3_s" class="form-control num_3decimal flow_rate_m3_s" <?php if(isset($sidemenu_sub_enable)) { if(($sidemenu_sub_enable)==0) { echo 'readonly="true"'; }  } ?> value="<?php echo set_value('flow_rate_m3_s', (isset($prcdesign['flow_rate_m3_s'])) ? $prcdesign['flow_rate_m3_s'] : ''); ?>"></td>
													</tr>
												</table>
											</td>											
											<td width="45%">
												<table class="table table-bordered table-td-2 margin-botton-0" id="plotrcdtable1">
													<thead>
														<tr>
															<th class="text-center">1</th>
															<th class="text-center">2</th>
															<th class="text-center">3</th>
															<th class="text-center">4</th>
															<th class="text-center">5</th>
															<th class="text-center">6</th>
															<th class="text-center">7</th>
															<th class="text-center">8</th>
															<th>&nbsp;</th>
														</tr>														
													</thead>
													<tbody>
													<?php
													#echo '<pre>'; print_r($plotrcd); echo '</pre>';
													foreach ($plotrcd as $gd_key => $gd_value) 
													{
													?>
														<tr class="plotrcdgridtr plotrcdgridtr_<?php echo $gd_key; ?>">
															<td><input type="text" name="value1[]" <?php if(isset($sidemenu_sub_enable)) { if(($sidemenu_sub_enable)==0) { echo 'readonly="true"'; }  } ?> value="<?php echo set_value('value1['.$gd_key.']', (isset($gd_value['volume1'])) ? $gd_value['volume1'] : ''); ?>" class="form-control num_1decimal volume1 volume"></td>
															<td><input type="text" name="value2[]" <?php if(isset($sidemenu_sub_enable)) { if(($sidemenu_sub_enable)==0) { echo 'readonly="true"'; }  } ?> value="<?php echo set_value('value2['.$gd_key.']', (isset($gd_value['volume2'])) ? $gd_value['volume2'] : ''); ?>" class="form-control num_1decimal volume2 volume"></td>
															<td><input type="text" name="value3[]" <?php if(isset($sidemenu_sub_enable)) { if(($sidemenu_sub_enable)==0) { echo 'readonly="true"'; }  } ?> value="<?php echo set_value('value3['.$gd_key.']', (isset($gd_value['volume3'])) ? $gd_value['volume3'] : ''); ?>" class="form-control num_1decimal volume3 volume"></td>
															<td><input type="text" name="value4[]" <?php if(isset($sidemenu_sub_enable)) { if(($sidemenu_sub_enable)==0) { echo 'readonly="true"'; }  } ?> value="<?php echo set_value('value4['.$gd_key.']', (isset($gd_value['volume4'])) ? $gd_value['volume4'] : ''); ?>" class="form-control num_1decimal volume4 volume"></td>
															<td><input type="text" name="value5[]" <?php if(isset($sidemenu_sub_enable)) { if(($sidemenu_sub_enable)==0) { echo 'readonly="true"'; }  } ?> value="<?php echo set_value('value5['.$gd_key.']', (isset($gd_value['volume5'])) ? $gd_value['volume5'] : ''); ?>" class="form-control num_1decimal volume5 volume"></td>
															<td><input type="text" name="value6[]" <?php if(isset($sidemenu_sub_enable)) { if(($sidemenu_sub_enable)==0) { echo 'readonly="true"'; }  } ?> value="<?php echo set_value('value6['.$gd_key.']', (isset($gd_value['volume6'])) ? $gd_value['volume6'] : ''); ?>" class="form-control num_1decimal volume6 volume"></td>
															<td><input type="text" name="value7[]" <?php if(isset($sidemenu_sub_enable)) { if(($sidemenu_sub_enable)==0) { echo 'readonly="true"'; }  } ?> value="<?php echo set_value('value7['.$gd_key.']', (isset($gd_value['volume7'])) ? $gd_value['volume7'] : ''); ?>" class="form-control num_1decimal volume7 volume"></td>
															<td><input type="text" name="value8[]" <?php if(isset($sidemenu_sub_enable)) { if(($sidemenu_sub_enable)==0) { echo 'readonly="true"'; }  } ?> value="<?php echo set_value('value8['.$gd_key.']', (isset($gd_value['volume8'])) ? $gd_value['volume8'] : ''); ?>" class="form-control num_1decimal volume8 volume"></td>
															<td>
																<div class="icon_list" style="width:auto;"><a href="javascript:void(0)" data-id="" class="delete_plotrcdrow"><i class="fa fa-times" aria-hidden="true"></i></a></div>
																<input type="hidden" class="plotrcdid" name="plotrcdid[]" value="<?php echo set_value('plotrcdid['.$gd_key.']', (isset($gd_value['id'])) ? $gd_value['id'] : '0'); ?>">
															</td>
														</tr>	
													<?php
													}
													?>													
													</tbody>
												</table><br>
												<div class="text-right"><button <?php if(isset($sidemenu_sub_enable)) { if(($sidemenu_sub_enable)==0) { echo 'style="pointer-events: none"'; }  } ?> type="button" class="btn btn-xs btn-primary plotrcdaddnew">Add New</button></div>
											</td>
											<td width="25%">
												<table class="table table-bordered table-td-2 margin-botton-0" id="plotrcdtable1">
													<tbody>
														<tr>	
															<td class="text-center"><strong>Total Velocity m/s</strong></td>
															<td class="text-center"><strong>Average Velocity m/s</strong></td>
															<td class="text-center"><strong>Actual Volume m&sup3;/s</strong></td>
														</tr>
														<tr>

															<td><input type="text" name="total_velocity" class="form-control total_velocity" <?php if(isset($sidemenu_sub_enable)) { if(($sidemenu_sub_enable)==0) { echo 'readonly="true"'; }  } ?> value="<?php echo set_value('total_velocity', (isset($prcdesign['total_velocity'])) ? $prcdesign['total_velocity'] : ''); ?>" ></td>
															<td><input type="text" name="average_velocity" class="form-control average_velocity" <?php if(isset($sidemenu_sub_enable)) { if(($sidemenu_sub_enable)==0) { echo 'readonly="true"'; }  } ?> value="<?php echo set_value('average_velocity', (isset($prcdesign['average_velocity'])) ? $prcdesign['average_velocity'] : ''); ?>" ></td>
															<td><input type="text" name="actual_volume" class="form-control actual_volume" <?php if(isset($sidemenu_sub_enable)) { if(($sidemenu_sub_enable)==0) { echo 'readonly="true"'; }  } ?> value="<?php echo set_value('actual_volume', (isset($prcdesign['actual_volume'])) ? $prcdesign['actual_volume'] : ''); ?>" ></td>
														</tr>
														<tr>
															
															<td colspan="2" class="text-center"><strong>Design %</strong></td>
															<td><input type="text" name="design" class="form-control plotrcddesign" <?php if(isset($sidemenu_sub_enable)) { if(($sidemenu_sub_enable)==0) { echo 'readonly="true"'; }  } ?> value="<?php echo set_value('design', (isset($prcdesign['design'])) ? $prcdesign['design'] : ''); ?>" ></td>
														</tr>
														<tr>
															<td colspan="2" class="text-center"><strong>No Test Points</strong></td>
															<td><input type="text" name="no_test_points" class="form-control no_test_points" <?php if(isset($sidemenu_sub_enable)) { if(($sidemenu_sub_enable)==0) { echo 'readonly="true"'; }  } ?> value="<?php echo set_value('no_test_points', (isset($prcdesign['no_test_points'])) ? $prcdesign['no_test_points'] : ''); ?>" ></td>
														</tr>
														<tr>
															<td colspan="2" class="text-center"><strong>Static Pressure (Pa)</strong></td>
															<td>
															<input type="text" name="static_presssure" class="form-control num_1decimal" <?php if(isset($sidemenu_sub_enable)) { if(($sidemenu_sub_enable)==0) { echo 'readonly="true"'; }  } ?> value="<?php echo set_value('static_presssure', (isset($prcdesign['static_presssure'])) ? $prcdesign['static_presssure'] : ''); ?>">
															<input type="hidden" name="designid" value="<?php echo set_value('designid', (isset($prcdesign['id'])) ? $prcdesign['id'] : ''); ?>">
															</td>
														</tr>
													</tbody>
												</table>
											</td>
										</tr>
										
									</tbody>
								</table>
							</div>
						</div>
						
						<div class="row form-group clearfix">
							<div class="col-sm-12">
								<label><strong>Comments:</strong></label>
								<textarea class="form-control" <?php if(isset($sidemenu_sub_enable)) { if(($sidemenu_sub_enable)==0) { echo 'readonly="true"'; }  } ?> name="commaircomments"><?php echo set_value('commaircomments', (isset($prcdata['comments'])) ? $prcdata['comments'] : ''); ?></textarea>
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
								<input type="text" <?php if(isset($sidemenu_sub_enable)) { if(($sidemenu_sub_enable)==0) { echo 'readonly="true"'; }  } ?> class="form-control datepicker" name="commairreptenggdate" placeholder="" value="<?php echo set_value('commairreptenggdate', (isset($prcdata['reportdate'])) ? date(DT_FORMAT,strtotime($prcdata['reportdate'])) : date(DT_FORMAT)); ?>" />
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

						<input type="submit" name="submit" value="Submit" class="btn btn-success btn-sm submit-btn addnew" <?php if(isset($sidemenu_sub_enable)) { if(($sidemenu_sub_enable)==0) { echo 'disabled="disabled"'; }  } ?>>
						<input type="submit" name="cancel" value="Cancel" class="btn btn-danger btn-sm submit-btn cancel" <?php if(isset($sidemenu_sub_enable)) { if(($sidemenu_sub_enable)==0) { echo 'disabled="disabled"'; }  } ?>>
						
					</footer>

				</form>
			</div>
			
		</section>
	</section>
</section>
<table class="hidden">
	<tr class="plotrcdclone">
		<td><input type="text" name="value1[]" value="" class="form-control num_1decimal volume1 volume"></td>
		<td><input type="text" name="value2[]" value="" class="form-control num_1decimal volume2 volume"></td>
		<td><input type="text" name="value3[]" value="" class="form-control num_1decimal volume3 volume"></td>
		<td><input type="text" name="value4[]" value="" class="form-control num_1decimal volume4 volume"></td>
		<td><input type="text" name="value5[]" value="" class="form-control num_1decimal volume5 volume"></td>
		<td><input type="text" name="value6[]" value="" class="form-control num_1decimal volume6 volume"></td>
		<td><input type="text" name="value7[]" value="" class="form-control num_1decimal volume7 volume"></td>
		<td><input type="text" name="value8[]" value="" class="form-control num_1decimal volume8 volume"></td>
		<td>
			<div class="icon_list" style="width:auto;"><a href="javascript:void(0)" data-id="" class="delete_plotrcdrow"><i class="fa fa-times" aria-hidden="true"></i></a></div>
			<input type="hidden" name="plotrcdid[]" class="plotrcdid" value="0">
		</td>
	</tr>
</table>