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
					<div class="col-sm-12">
					<div class="">
						<div class="row form-group clearfix">
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
										<!--<input type="text" name="projsystem" class="form-control" value="<?php echo set_value('projsystem', (isset($prcdata['system'])) ? $prcdata['system'] : ''); ?>"> -->
										<?php echo form_error('projsystem', '<div class="form-error">', '</div>'); ?>
									</div>
								</div>									
							</div>
						</div>
						<div class="row form-group clearfix">
							<div class="col-sm-12">
								<table class="table table-bordered table-striped table-td-5" id="grillegrid">
									<thead>
										<tr>
											<th class="text-center td_border_right" colspan="5">Design Information</th>
											<th class="text-center" colspan="6">Measured</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td class="text-center" width="10%"><strong>Grille No.</strong></td>
											<td class="text-center" width="10%"><strong>Grille or Hood Size (mm)</strong></td>
											<td class="text-center" width="10%"><strong>Area m&sup2;</strong></td>
											<td class="text-center" width="10%"><strong>Design Volume m&sup3;/s</strong></td>
											<td class="text-center td_border_right" width="10%"><strong>Design Velocity m/s</strong></td>
											<td class="text-center" width="10%"><strong>Final Velocity m/s</strong></td>
											<td class="text-center" width="10%"><strong>Measured Volume m&sup3;/s</strong></td>
											<td class="text-center" width="10%"><strong>Correction Factor</strong></td>
											<td class="text-center" width="10%"><strong>Actual Volume m&sup3;/s</strong></td>
											<td class="text-center" width="10%"><strong>Design %</strong></td>
											<td>&nbsp;</td>
										</tr>
										<?php
											foreach ($grillegrid as $gd_key => $gd_value) 
											{											
										?>
										<tr class="grillegridtr grillegridtr_<?php echo $gd_key; ?>">
											<td><input type="text" name="grilleno[]" class="form-control grilleno grillefield" value="<?php echo set_value('grilleno['.$gd_key.']', (isset($gd_value['grilleno'])) ? $gd_value['grilleno'] : ''); ?>"></td>
											<td><input type="text" name="grille_hood_size[]" class="form-control grille_hood_size grillefield" value="<?php echo set_value('grille_hood_size['.$gd_key.']', (isset($gd_value['grille_hood_size'])) ? $gd_value['grille_hood_size'] : ''); ?>"></td>
											<td><input type="text" name="area[]" class="form-control area grillefield" value="<?php echo set_value('area['.$gd_key.']', (isset($gd_value['area'])) ? $gd_value['area'] : ''); ?>"></td>
											<td><input type="text" name="design_volume[]" class="form-control design_volume num_3decimal grillefield" value="<?php echo set_value('design_volume['.$gd_key.']', (isset($gd_value['design_volume'])) ? $gd_value['design_volume'] : ''); ?>"></td>
											<td class="td_border_right"><input type="text" name="design_velocity[]" class="form-control design_velocity grillefield" value="<?php echo set_value('design_velocity['.$gd_key.']', (isset($gd_value['design_velocity'])) ? $gd_value['design_velocity'] : ''); ?>" readonly></td>
											<td><input type="text" name="final_velocity[]" class="form-control final_velocity  num_2decimal grillefield" value="<?php echo set_value('final_velocity['.$gd_key.']', (isset($gd_value['final_velocity'])) ? $gd_value['final_velocity'] : ''); ?>"></td>
											<td><input type="text" name="measured_volume[]" class="form-control measured_volume grillefield" value="<?php echo set_value('measured_volume['.$gd_key.']', (isset($gd_value['measured_volume'])) ? $gd_value['measured_volume'] : ''); ?>" readonly></td>
											<td><input type="text" name="correction_factor[]" class="form-control correction_factor grillefield" value="<?php echo set_value('correction_factor['.$gd_key.']', (isset($gd_value['correction_factor'])) ? $gd_value['correction_factor'] : ''); ?>" readonly></td>
											<td><input type="text" name="actual_volume[]" class="form-control actual_volume grillefield" value="<?php echo set_value('actual_volume['.$gd_key.']', (isset($gd_value['actual_volume'])) ? $gd_value['actual_volume'] : ''); ?>" readonly></td>
											<td><input type="text" name="design[]" class="form-control design grillefield" value="<?php echo set_value('design['.$gd_key.']', (isset($gd_value['design'])) ? $gd_value['design'] : ''); ?>" readonly></td>
											<td><div class="icon_list" style="width:auto;"><a href="javascript:void(0)" data-id="" class="delete_grille_balrow"><i class="fa fa-times" aria-hidden="true"></i></a></div> <input type="hidden" name="gilleid[]" class="gilleid" value="<?php echo set_value('gilleid['.$gd_key.']', (isset($gd_value['id'])) ? $gd_value['id'] : 0); ?>"></td>
										</tr>
										<?php
										}
										?>
									</tbody>
								</table>
								<div class="text-right">
									<button type="button" class="btn btn-sm btn-primary grilleaddnew">Add New</button>
								</div>
							</div>
						</div>
						<div class="row form-group clearfix">
							<div class="col-sm-12">
								<table class="table table-bordered table-striped" id="grillegridmain">
									<tbody>
										<tr>
											<td>The measuring hood correction factor is derived by dividing the duct</td>
											<td><strong>Duct Total m³/s:</strong></td>
											<td><input type="text" name="grilleductotal" class="form-control num_3decimal grilleductotal" value="<?php echo set_value('grilleductotal', (isset($grillmain['grilleductotal'])) ? $grillmain['grilleductotal'] : ''); ?>"></td>
										</tr>
										<tr>
											<td>Pitot traverse volume by the total of the grille indicated volume</td>
											<td><strong>Hood/Grille Total:</strong></td>
											<td><input type="text" name="grillehoodtotal" class="form-control grillehoodtotal" value="<?php echo set_value('grillehoodtotal', (isset($grillmain['grillehoodtotal'])) ? $grillmain['grillehoodtotal'] : ''); ?>" readonly></td>
										</tr>
										<tr>
											<td>&nbsp;</td>
											<td><strong>Correction Factor:</strong></td>
											<td><input type="text" name="grillecorrfactor" class="form-control grillecorrfactor" value="<?php echo set_value('grillecorrfactor', (isset($grillmain['grillecorrfactor'])) ? $grillmain['grillecorrfactor'] : ''); ?>" readonly>
											<input type="hidden" name="grillmainid" value="<?php echo set_value('grillmainid', (isset($grillmain['id'])) ? $grillmain['id'] : 0); ?>">
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
	<tr class="grilleclonetr">
		<td><input type="text" name="grilleno[]" class="form-control grilleno grillefield" value=""></td>
		<td><input type="text" name="grille_hood_size[]" class="form-control grille_hood_size grillefield" value=""></td>
		<td><input type="text" name="area[]" class="form-control area grillefield" value=""></td>
		<td><input type="text" name="design_volume[]" class="form-control design_volume num_3decimal grillefield" value=""></td>
		<td class="td_border_right"><input type="text" name="design_velocity[]" class="form-control design_velocity grillefield" value="" readonly></td>
		<td><input type="text" name="final_velocity[]" class="form-control final_velocity  num_2decimal grillefield" value=""></td>
		<td><input type="text" name="measured_volume[]" class="form-control measured_volume grillefield" value="" readonly></td>
		<td><input type="text" name="correction_factor[]" class="form-control correction_factor grillefield" value="" readonly></td>
		<td><input type="text" name="actual_volume[]" class="form-control actual_volume grillefield" value="" readonly></td>
		<td><input type="text" name="design[]" class="form-control design grillefield" value="" readonly></td>
		<td><div class="icon_list" style="width:auto;"><a href="javascript:void(0)" data-id="" class="delete_grille_balrow"><i class="fa fa-times" aria-hidden="true"></i></a></div> <input type="hidden" class="gilleid" name="gilleid[]" value="0"></td>
	</tr>
</table>