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
					<div class="clearfix">
						<div class="panel-body">
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

								<div class="form-group clearfix">
									<table class="table table-bordered table-striped" id="cwdesignmeasuredhws">
										<thead>
											<tr>
												<th class="text-center">Valve Ref</th>
												<th class="text-center">Blending Valve Temperature Range 41 to 43&#8451;</th>
												<th class="text-center">Fail Safe Operation</th>
												<th class="text-center">Comments</th>
												<th>&nbsp;</th>
											</tr>
										</thead>
										<tbody>
										<?php
										foreach ($cwwaterdiststrcd as $gd_key => $gd_value) 
										{											
										?>
											<tr class="cwwaterhwscd_tr_<?php echo $gd_key; ?>">
												<td><input type="text" <?php if(isset($sidemenu_sub_enable)) { if(($sidemenu_sub_enable)==0) { echo 'readonly="true"'; }  } ?> class="form-control valveref" name="valveref[]" value="<?php echo set_value('valveref['.$gd_key.']', (isset($gd_value['valveref'])) ? $gd_value['valveref'] : ''); ?>" /></td>
												<td><input type="text" <?php if(isset($sidemenu_sub_enable)) { if(($sidemenu_sub_enable)==0) { echo 'readonly="true"'; }  } ?> class="form-control num_1decimal valvetemp" name="valvetemp[]" value="<?php echo set_value('valvetemp['.$gd_key.']', (isset($gd_value['valvetemp'])) ? $gd_value['valvetemp'] : ''); ?>" /></td>
												<td>
												<?php 
													$checkboxck='';
													if($gd_value['failsafeopt']==1)
													{
														$checkboxck=' Checked="checked" ';
													}
												?>

												<input type="checkbox" <?php if(isset($sidemenu_sub_enable)) { if(($sidemenu_sub_enable)==0) { echo 'disabled="disabled"'; }  } ?> class="form-control failsafeopt" value="1" <?php echo $checkboxck; ?> />

												<input type="hidden" class="form-control failsafeopt1" name="failsafeopt[]" value="<?php echo intval($gd_value['failsafeopt']); ?>" />

												</td>
												<td><input type="text" <?php if(isset($sidemenu_sub_enable)) { if(($sidemenu_sub_enable)==0) { echo 'readonly="true"'; }  } ?> class="form-control hwscmts" name="hwscmts[]" value="<?php echo set_value('hwscmts['.$gd_key.']', (isset($gd_value['hwscmts'])) ? $gd_value['hwscmts'] : ''); ?>" /></td>
												<td><div class="icon_list" style="width:auto;"><a href="#" data-toggle="tooltip" title="Remove Row" class="cwdesignmeasuredhwstrremove"><i class="fa fa-times" aria-hidden="true"></i></a></div><input type="hidden" name="cwdesignmeasured[]" class="cwdesignmeasured" value="<?php echo set_value('cwdesignmeasured['.$gd_key.']', (isset($gd_value['id'])) ? $gd_value['id'] : 0); ?>"></td>
											</tr>
										<?php
										}
										?>
										</tbody>
									</table>
									<div class="text-right"><button type="button" <?php if(isset($sidemenu_sub_enable)) { if(($sidemenu_sub_enable)==0) { echo 'style="pointer-events: none"'; }  } ?> class="btn btn-sm btn-primary cwdesignmeasuredhws_add">Add Row</button></div>
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

					<input type="submit" name="submit" value="Submit" class="btn btn-success btn-s-xs submit-btn addnew" <?php if(isset($sidemenu_sub_enable)) { if(($sidemenu_sub_enable)==0) { echo 'disabled="disabled"'; }  } ?>>
					<input type="submit" name="cancel" value="Cancel" class="btn btn-danger btn-s-xs submit-btn cancel" <?php if(isset($sidemenu_sub_enable)) { if(($sidemenu_sub_enable)==0) { echo 'disabled="disabled"'; }  } ?>>
					
				</footer>

			</form>
			</div>
			
		</section>
	</section>
</section>
<table class="hidden">
	<tr class="cwwaterhwscd_tr_clone">
		<td><input type="text" class="form-control valveref" name="valveref[]" value="" /></td>
		<td><input type="text" class="form-control num_1decimal valvetemp" name="valvetemp[]" value="" /></td>
		<td><input type="checkbox" class="form-control failsafeopt" value="1" /><input type="hidden" class="form-control failsafeopt1" name="failsafeopt[]" value="0" /></td>
		<td><input type="text" class="form-control hwscmts" name="hwscmts[]" value="" /></td>
		<td><div class="icon_list" style="width:auto;"><a href="#" data-toggle="tooltip" title="Remove Row" class="cwdesignmeasuredhwstrremove"><i class="fa fa-times" aria-hidden="true"></i></a></div><input type="hidden" name="cwdesignmeasured[]" class="cwdesignmeasured" value="0"></td>
	</tr>
</table>