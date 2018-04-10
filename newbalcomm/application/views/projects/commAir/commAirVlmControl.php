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
					<div class="col-sm-12">
					<div class="">
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
						<div class="row form-group clearfix">
							<div class="col-sm-12">
								<table class="table table-bordered table-striped table-td-5" id="vlmctrlgrid">
									<thead>
										<tr>
											<th class="text-center td_border_right" colspan="5">Design Information</th>
											<th class="text-center td_border_right" colspan="4">Measured</th>
											<th class="text-center" colspan="5">Measured</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td class="text-center" width="7%"><strong>Vav Ref No.</strong></td>
											<td class="text-center" width="9%"><strong>Vav Address Ref.</strong></td>
											<td class="text-center" width="9%"><strong>Vav Normal Volume</strong></td>
											<td class="text-center" width="7%"><strong>Max Flow m&sup3;/s</strong></td>
											<td class="text-center td_border_right" width="8%"><strong>Min Flow m&sup3;/s</strong></td>
											<td class="text-center" width="7%"><strong>Min &#8710;P Pa</strong></td>
											<td class="text-center" width="7%"><strong>Min Volts V</strong></td>
											<td class="text-center" width="7%"><strong>Min Vol. M&sup3;/s</strong></td>
											<td class="text-center td_border_right" width="8%"><strong>Min %</strong></td>
											<td class="text-center" width="7%"><strong>Max &#8710;P Pa</strong></td>
											<td class="text-center" width="7%"><strong>Max Volts V</strong></td>
											<td class="text-center" width="7%"><strong>Max Vol. M&sup3;/s</strong></td>
											<td class="text-center" width="7%"><strong>Max %</strong></td>
											<td width="3%">&nbsp;</td>
										</tr>
										<?php
										$gd_key=0;
											foreach ($vlmctrlgrid as $gd_key => $gd_value) 
											{											
										?>
										<tr class="vlmctrlgridtr vlmctrlgridtr_<?php echo $gd_key; ?>">
											<td><input type="text" name="vav_refno[]" class="form-control vav_refno vav_field" <?php if(isset($sidemenu_sub_enable)) { if(($sidemenu_sub_enable)==0) { echo 'readonly="true"'; }  } ?> value="<?php echo set_value('vav_refno['.$gd_key.']', (isset($gd_value['vav_refno'])) ? $gd_value['vav_refno'] : ''); ?>"></td>
											<td><input type="text" name="vav_addr_ref[]" class="form-control vav_addr_ref vav_field" <?php if(isset($sidemenu_sub_enable)) { if(($sidemenu_sub_enable)==0) { echo 'readonly="true"'; }  } ?> value="<?php echo set_value('vav_addr_ref['.$gd_key.']', (isset($gd_value['vav_addr_ref'])) ? $gd_value['vav_addr_ref'] : ''); ?>"></td>
											<td><input type="text" name="vav_nonimal_value[]" class="form-control vav_nonimal_value vav_field" <?php if(isset($sidemenu_sub_enable)) { if(($sidemenu_sub_enable)==0) { echo 'readonly="true"'; }  } ?> value="<?php echo set_value('vav_nonimal_value['.$gd_key.']', (isset($gd_value['vav_nonimal_value'])) ? $gd_value['vav_nonimal_value'] : ''); ?>"></td>
											<td><input type="text" name="max_flow_m3_s[]" class="form-control max_flow_m3_s num_3decimal vav_field" <?php if(isset($sidemenu_sub_enable)) { if(($sidemenu_sub_enable)==0) { echo 'readonly="true"'; }  } ?> value="<?php echo set_value('max_flow_m3_s['.$gd_key.']', (isset($gd_value['max_flow_m3_s'])) ? $gd_value['max_flow_m3_s'] : ''); ?>"></td>
											<td class="td_border_right"><input type="text" name="min_flow_m3_s[]" class="form-control min_flow_m3_s  num_3decimal vav_field" <?php if(isset($sidemenu_sub_enable)) { if(($sidemenu_sub_enable)==0) { echo 'readonly="true"'; }  } ?> value="<?php echo set_value('min_flow_m3_s['.$gd_key.']', (isset($gd_value['min_flow_m3_s'])) ? $gd_value['min_flow_m3_s'] : ''); ?>"></td>
											<td><input type="text" name="min_p_pa[]" class="form-control min_p_pa  num_1decimal vav_field" <?php if(isset($sidemenu_sub_enable)) { if(($sidemenu_sub_enable)==0) { echo 'readonly="true"'; }  } ?> value="<?php echo set_value('min_p_pa['.$gd_key.']', (isset($gd_value['min_p_pa'])) ? $gd_value['min_p_pa'] : ''); ?>"></td>
											<td><input type="text" name="min_volts[]" class="form-control min_volts  num_1decimal vav_field" <?php if(isset($sidemenu_sub_enable)) { if(($sidemenu_sub_enable)==0) { echo 'readonly="true"'; }  } ?> value="<?php echo set_value('min_volts['.$gd_key.']', (isset($gd_value['min_volts'])) ? $gd_value['min_volts'] : ''); ?>"></td>
											<td><input type="text" name="min_vol_m3s[]" class="form-control min_vol_m3s num_3decimal vav_field" <?php if(isset($sidemenu_sub_enable)) { if(($sidemenu_sub_enable)==0) { echo 'readonly="true"'; }  } ?> value="<?php echo set_value('min_vol_m3s['.$gd_key.']', (isset($gd_value['min_vol_m3s'])) ? $gd_value['min_vol_m3s'] : ''); ?>"></td>
											<td class="td_border_right"><input type="text" name="min_percentage[]" class="form-control min_percentage vav_field alwaysreadonly" readonly value="<?php echo set_value('min_percentage['.$gd_key.']', (isset($gd_value['min_percentage'])) ? $gd_value['min_percentage'] : ''); ?>" ></td>
											<td><input type="text" name="max_p_pa[]" class="form-control max_p_pa  num_1decimal vav_field" <?php if(isset($sidemenu_sub_enable)) { if(($sidemenu_sub_enable)==0) { echo 'readonly="true"'; }  } ?> value="<?php echo set_value('max_p_pa['.$gd_key.']', (isset($gd_value['max_p_pa'])) ? $gd_value['max_p_pa'] : ''); ?>"></td>
											<td><input type="text" name="max_volts[]" class="form-control max_volts  num_1decimal vav_field" <?php if(isset($sidemenu_sub_enable)) { if(($sidemenu_sub_enable)==0) { echo 'readonly="true"'; }  } ?> value="<?php echo set_value('max_volts['.$gd_key.']', (isset($gd_value['max_volts'])) ? $gd_value['max_volts'] : ''); ?>"></td>
											<td><input type="text" name="max_vol_m3s[]" class="form-control max_vol_m3s num_1decimal vav_field" <?php if(isset($sidemenu_sub_enable)) { if(($sidemenu_sub_enable)==0) { echo 'readonly="true"'; }  } ?> value="<?php echo set_value('max_vol_m3s['.$gd_key.']', (isset($gd_value['max_vol_m3s'])) ? $gd_value['max_vol_m3s'] : ''); ?>"></td>
											<td><input type="text" name="max_percentage[]" class="form-control max_percentage vav_field alwaysreadonly" readonly value="<?php echo set_value('max_percentage['.$gd_key.']', (isset($gd_value['max_percentage'])) ? $gd_value['max_percentage'] : ''); ?>" ></td>
											<td><div class="icon_list" style="width:auto;"><a href="javascript:void(0)" data-id="" class="delete_vlmctrl_balrow"><i class="fa fa-times" aria-hidden="true"></i></a></div> <input type="hidden" name="vlmctrlid[]" class="vlmctrlid" value="<?php echo set_value('vlmctrlid['.$gd_key.']', (isset($gd_value['id'])) ? $gd_value['id'] : 0); ?>"></td>
										</tr>
										<?php
										}
										?>
									</tbody>
								</table>
								<div class="text-right">
									<button type="button" class="btn btn-sm btn-primary vlmctrladdnew" <?php if(isset($sidemenu_sub_enable)) { if(($sidemenu_sub_enable)==0) { echo 'style="pointer-events: none"'; }  } ?>>Add New</button>
								</div>
							</div>
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
										elseif(isset($_SESSION['commAir_syscert_slected_engineer']))
										{
										$commairreptenggsign=$_SESSION['commAir_syscert_slected_engineer'];
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

						<input type="submit" name="submit" value="Submit" class="btn btn-success btn-sm submit-btn addnew" <?php if(isset($sidemenu_sub_enable)) { if(($sidemenu_sub_enable)==0) { echo 'disabled="disabled"'; }  } ?>>
						<input type="submit" name="cancel" value="Cancel" class="btn btn-danger btn-sm submit-btn cancel" <?php if(isset($sidemenu_sub_enable)) { if(($sidemenu_sub_enable)==0) { echo 'disabled="disabled"'; }  } ?>>
						
					</footer>

				</form>
			</div>
			
		</section>
	</section>
</section>
<table class="table hidden">
	<tr class="vlmctrlclonetr">
		<td><input type="text" name="vav_refno[]" class="form-control vav_refno vav_field" value=""></td>
		<td><input type="text" name="vav_addr_ref[]" class="form-control vav_addr_ref vav_field" value=""></td>
		<td><input type="text" name="vav_nonimal_value[]" class="form-control vav_nonimal_value vav_field" value=""></td>
		<td><input type="text" name="max_flow_m3_s[]" class="form-control max_flow_m3_s num_3decimal vav_field" value=""></td>
		<td class="td_border_right"><input type="text" name="min_flow_m3_s[]" class="form-control min_flow_m3_s  num_3decimal vav_field" value=""></td>
		<td><input type="text" name="min_p_pa[]" class="form-control min_p_pa  num_1decimal vav_field" value=""></td>
		<td><input type="text" name="min_volts[]" class="form-control min_volts  num_1decimal vav_field" value=""></td>
		<td><input type="text" name="min_vol_m3s[]" class="form-control min_vol_m3s num_3decimal vav_field" value=""></td>
		<td class="td_border_right"><input type="text" name="min_percentage[]" class="form-control min_percentage vav_field" value="" readonly></td>
		<td><input type="text" name="max_p_pa[]" class="form-control max_p_pa  num_1decimal vav_field" value=""></td>
		<td><input type="text" name="max_volts[]" class="form-control max_volts  num_1decimal vav_field" value=""></td>
		<td><input type="text" name="max_vol_m3s[]" class="form-control max_vol_m3s num_1decimal vav_field" value=""></td>
		<td><input type="text" name="max_percentage[]" class="form-control max_percentage vav_field" value="" readonly></td>
		<td><div class="icon_list" style="width:auto;"><a href="javascript:void(0)" data-id="" class="delete_vlmctrl_balrow"><i class="fa fa-times" aria-hidden="true"></i></a></div> <input type="hidden" name="vlmctrlid[]" class="vlmctrlid" value=""></td>
	</tr>
</table>