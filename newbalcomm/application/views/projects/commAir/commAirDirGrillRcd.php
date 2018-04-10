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
				<form method="POST" name="adduser" action="" class="addusernew processForm" enctype="multipart/form-data">
					<div class="row">
					<div class="col-sm-12">
					<div class="">
						<div class="row form-group clearfix">
							<div class="col-sm-4"><strong>Project Name:</strong> <?php echo $prodata['projectname']; ?></div>
							<!-- <div class="col-sm-4">
								<div class="row clearfix">
									<div class="col-sm-3"><label><strong>Ref:</strong><span class="mandatory"> *</span></label></div>
									<div class="col-sm-9">
										<input type="text" name="reportref" class="form-control"  
										value="<?php echo set_value('reportref', (isset($prcdata['referenceno'])) ? $prcdata['referenceno'] : ''); ?>" <?php if(isset($sidemenu_sub_enable)) { if(($sidemenu_sub_enable)==0) { echo 'readonly'; }  } ?>>
										<?php echo form_error('reportref', '<div class="form-error">', '</div>'); ?>
									</div>
								</div>
							</div> -->
							<div class="col-sm-4"><strong>Project Number:</strong> <?php echo $prodata['projectnumber']; ?></div>
							<div class="col-sm-4">
								<div class="row clearfix">
									<div class="col-sm-4"><label><strong>System:</strong><span class="mandatory"> *</span></label></div>
									<div class="col-sm-8">
										<select name="projsystem" id="projsystem" class="form-control" <?php if(isset($sidemenu_sub_enable)) { if(($sidemenu_sub_enable)==0) { echo 'readonly'; }  } ?>>
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
						<div class="row form-group clearfix">
							<div class="col-sm-12">
								<table class="table table-bordered table-striped table-td-5" id="dirgrillegrid">
									<thead>
										<tr>
											<th class="text-center td_border_right" colspan="3">Design Information</th>
											<th class="text-center" colspan="6">Measured</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td class="text-center" width="12%"><strong>Ref No.</strong></td>
											<td class="text-center" width="12%"><strong>Grille Size (mm)</strong></td>
											<td class="text-center td_border_right" width="12%"><strong>Design Volume l/s</strong></td>
											<td class="text-center" width="12%"><strong>Final Volume l/s</strong></td>
											<td class="text-center" width="12%"><strong>Correction Factor</strong></td>
											<td class="text-center" width="12%"><strong>Actual Volume l/s</strong></td>
											<td class="text-center" width="12%"><strong>%</strong></td>
											<td class="text-center" width="12%"><strong>Setting</strong></td>
											<td width="4%">&nbsp;</td>
										</tr>
										<?php
											foreach ($dirgrillegrid as $gd_key => $gd_value) 
											{											
										?>
										<tr class="dirgrillegridtr dirgrillegridtr_<?php echo $gd_key; ?>">
											<td><input type="text" name="ref_no[]" class="form-control ref_no dirgrillefield" value="<?php echo set_value('ref_no['.$gd_key.']', (isset($gd_value['ref_no'])) ? $gd_value['ref_no'] : ''); ?>" <?php if(isset($sidemenu_sub_enable)) { if(($sidemenu_sub_enable)==0) { echo 'readonly'; }  } ?>></td>
											<td><input type="text" name="grille_size[]" class="form-control grille_size dirgrillefield" value="<?php echo set_value('grille_size['.$gd_key.']', (isset($gd_value['grille_size'])) ? $gd_value['grille_size'] : ''); ?>" <?php if(isset($sidemenu_sub_enable)) { if(($sidemenu_sub_enable)==0) { echo 'readonly'; }  } ?>></td>
											<td class="td_border_right"><input type="text" name="design_volume[]" class="form-control design_volume num_0decimal dirgrillefield" value="<?php echo set_value('design_volume['.$gd_key.']', (isset($gd_value['design_volume'])) ? $gd_value['design_volume'] : ''); ?>" <?php if(isset($sidemenu_sub_enable)) { if(($sidemenu_sub_enable)==0) { echo 'readonly'; }  } ?>></td>
											<td><input type="text" name="final_volume[]" class="form-control final_volume num_0decimal dirgrillefield" value="<?php echo set_value('final_volume['.$gd_key.']', (isset($gd_value['final_volume'])) ? $gd_value['final_volume'] : ''); ?>" <?php if(isset($sidemenu_sub_enable)) { if(($sidemenu_sub_enable)==0) { echo 'readonly'; }  } ?>></td>
											<td><input type="text" name="correction_factor[]" class="form-control correction_factor dirgrillefield alwaysreadonly"  value="<?php echo set_value('correction_factor['.$gd_key.']', (isset($gd_value['correction_factor'])) ? $gd_value['correction_factor'] : ''); ?>" readonly ></td>
											<td><input type="text" name="actual_volume[]" class="form-control actual_volume dirgrillefield alwaysreadonly"  value="<?php echo set_value('actual_volume['.$gd_key.']', (isset($gd_value['actual_volume'])) ? $gd_value['actual_volume'] : ''); ?>" readonly ></td>
											<td><input type="text" name="record_percent[]" class="form-control record_percent dirgrillefield alwaysreadonly"  value="<?php echo set_value('record_percent['.$gd_key.']', (isset($gd_value['record_percent'])) ? $gd_value['record_percent'] : ''); ?>" readonly></td>
											<td><input type="text" name="setting[]" class="form-control setting dirgrillefield" value="<?php echo set_value('setting['.$gd_key.']', (isset($gd_value['setting'])) ? $gd_value['setting'] : ''); ?>" <?php if(isset($sidemenu_sub_enable)) { if(($sidemenu_sub_enable)==0) { echo 'readonly'; }  } ?>></td>
											<td><div class="icon_list" style="width:auto;"><a href="javascript:void(0)" data-id="" class="delete_dirgrille_balrow"><i class="fa fa-times" aria-hidden="true"></i></a></div> <input type="hidden" name="dirgilleid[]" class="dirgilleid" value="<?php echo set_value('dirgilleid['.$gd_key.']', (isset($gd_value['id'])) ? $gd_value['id'] : 0); ?>"></td>
										</tr>
										<?php
										}
										?>
									</tbody>
								</table>
								<div class="text-right">
									<button type="button" class="btn btn-sm btn-primary dirgrilleaddnew">Add New</button>
								</div>
							</div>
						</div>
						<div class="row form-group clearfix">
							<div class="col-sm-12">
								<table class="table table-bordered table-striped" id="dirgrillemain">
									<tbody>
										<tr>
											<td>Hood Correction Factor Is Served By Dividing The Duct</td>
											<td><strong>Duct Total l/s:</strong></td>
											<td><input type="text" name="grilleductotal" class="form-control num_1decimal grilleductotal" value="<?php echo set_value('grilleductotal', (isset($grillmain['grilleductotal'])) ? $grillmain['grilleductotal'] : ''); ?>" <?php if(isset($sidemenu_sub_enable)) { if(($sidemenu_sub_enable)==0) { echo 'readonly'; }  } ?>></td>
										</tr>
										<tr>
											<td>Pitot Traverse Volume By The Grille Indicated Volume</td>
											<td><strong>Hood/Grille Total:</strong></td>
											<td><input type="text" name="grillehoodtotal" class="form-control grillehoodtotal alwaysreadonly" value="<?php echo set_value('grillehoodtotal', (isset($grillmain['grillehoodtotal'])) ? $grillmain['grillehoodtotal'] : ''); ?>" readonly ></td>
										</tr>
										<tr>
											<td>Direct Volume Reading Using Alnor Hood</td>
											<td><strong>Correction Factor:</strong></td>
											<td><input type="text" name="grillecorrfactor" class="form-control grillecorrfactor alwaysreadonly" value="<?php echo set_value('grillecorrfactor', (isset($grillmain['grillecorrfactor'])) ? $grillmain['grillecorrfactor'] : ''); ?>"  readonly>
											<input type="hidden" name="grillmainid" value="<?php echo set_value('grillmainid', (isset($grillmain['id'])) ? $grillmain['id'] : 0); ?>" >
											</td>
										</tr>

									</tbody>
								</table>
							</div>
						</div>
						<div class="row form-group clearfix">
							<div class="col-sm-12">
								<label><strong>Comments:</strong></label>
								<textarea class="form-control" name="commaircomments"><?php echo set_value('commaircomments', (isset($prcdata['comments'])) ? $prcdata['comments'] : ''); ?></textarea>
							</div>
						</div>
						<div class="row form-group clearfix">
							<div class="col-sm-4">									
								<label><strong>Engineer:</strong><span class="mandatory"> *</span></label>
								<select class="form-control" name="commairreptenggsign" <?php if(isset($sidemenu_sub_enable)) { if($sidemenu_sub_enable == 0) { echo 'readonly="readonly"'; }  } ?>>
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
										elseif(isset($_SESSION['commAir_syscert_slected_engineer']))
										{
										$commairreptenggsign=$_SESSION['commAir_syscert_slected_engineer'];
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
								<input type="text" class="form-control datepicker" name="commairreptenggdate" placeholder="" value="<?php echo set_value('commairreptenggdate', (isset($prcdata['reportdate'])) ? date(DT_FORMAT,strtotime($prcdata['reportdate'])) : date(DT_FORMAT)); ?>" <?php if(isset($sidemenu_sub_enable)) { if(($sidemenu_sub_enable)==0) { echo 'readonly'; }  } ?>/>
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

						<input type="submit" name="submit" value="Submit" class="btn btn-success btn-sm submit-btn addnew">
						<input type="submit" name="cancel" value="Cancel" class="btn btn-danger btn-sm submit-btn cancel">
						
					</footer>

				</form>
			</div>
			
		</section>
	</section>
</section>
<table class="table hidden">
	<tr class="dirgrilleclonetr">
		<td><input type="text" name="ref_no[]" class="form-control ref_no dirgrillefield" value=""></td>
		<td><input type="text" name="grille_size[]" class="form-control grille_size dirgrillefield" value=""></td>
		<td class="td_border_right"><input type="text" name="design_volume[]" class="form-control design_volume num_0decimal dirgrillefield" value=""></td>
		<td><input type="text" name="final_volume[]" class="form-control final_volume num_0decimal dirgrillefield" value=""></td>
		<td><input type="text" name="correction_factor[]" class="form-control correction_factor dirgrillefield" readonly value=""></td>
		<td><input type="text" name="actual_volume[]" class="form-control actual_volume dirgrillefield" readonly value=""></td>
		<td><input type="text" name="record_percent[]" class="form-control record_percent dirgrillefield" readonly value=""></td>
		<td><input type="text" name="setting[]" class="form-control setting dirgrillefield" value=""></td>
		<td><div class="icon_list" style="width:auto;"><a href="javascript:void(0)" data-id="" class="delete_dirgrille_balrow"><i class="fa fa-times" aria-hidden="true"></i></a></div> <input type="hidden" name="dirgilleid[]" class="dirgilleid" value="0"></td>
	</tr>
</table>