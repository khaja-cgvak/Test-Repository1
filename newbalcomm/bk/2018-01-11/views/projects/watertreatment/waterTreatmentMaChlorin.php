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
			<?php 
				#echo '<pre>'; print_r($mainChlorin); echo '</pre>';
			?>
			<div class="panel-body">
			<form method="POST" name="adduser" action="" class="addusernew">
				<div class="row">
				<div class="clearfix">
						 <div class="panel-body">
					        	<div class="row form-group clearfix">
					        		<div class="row clearfix">
					        			<div class="col-sm-12">
											<div class="col-sm-3"><label><strong>Contract Name: </strong><span class="mandatory"> *</span></label></div>
											<div class="col-sm-9"><input type="text" <?php if(isset($sidemenu_sub_enable)) { if(($sidemenu_sub_enable)==0) { echo 'readonly="true"'; }  } ?> name="contractname" class="form-control" value="<?php echo set_value('contractname', (isset($mainChlorin['contractname'])) ? $mainChlorin['contractname'] : ''); ?>">
											<?php echo form_error('contractname', '<div class="form-error">', '</div>'); ?></div>
										</div>
									</div>
								</div>
								<div class="row form-group clearfix">
									<div class="col-sm-12">
										<div class="row clearfix">
											<div class="col-sm-3"><label><strong>Client: </strong></label></div>
											<div class="col-sm-9"><?php $userincharge = $prodata['userincharge']; 
                        $client_name=$this->Common_model->getCustomerById($userincharge);
                       // print_r($client_name);
                        echo $client_name['custname'];
                        ?></div>
										</div>
									</div>
								</div>
								<div class="row form-group clearfix">
									<div class="col-sm-12">
										<div class="row clearfix">
											<div class="col-sm-3"><label><strong>Balcomm Ref: </strong><span class="mandatory"> *</span></label></div>
											<div class="col-sm-9">
												<input type="text" <?php if(isset($sidemenu_sub_enable)) { if(($sidemenu_sub_enable)==0) { echo 'readonly="true"'; }  } ?> name="reportref" class="form-control" value="<?php echo set_value('reportref', (isset($prcdata['referenceno'])) ? $prcdata['referenceno'] : ''); ?>">
											<?php echo form_error('reportref', '<div class="form-error">', '</div>'); ?>
											</div>
										</div>
									</div>
								</div>
								<div class="row form-group clearfix">
									<div class="col-sm-12">
										<div class="row clearfix">
											<div class="col-sm-3"><label><strong>Lab Ref: </strong></label></div>
											<div class="col-sm-9">
											<input type="text" <?php if(isset($sidemenu_sub_enable)) { if(($sidemenu_sub_enable)==0) { echo 'readonly="true"'; }  } ?> class="form-control" name="lebref" value="<?php echo set_value('lebref', (isset($mainChlorin['lebref'])) ? $mainChlorin['lebref'] : ''); ?>" />
											</div>
										</div>
									</div>
								</div>
								<div class="form-group clearfix text-center"><br><p><em>The Folllowing services have been sterllised in accordance with <b>BS6700:-</b></em></p></div>
								<div class="row form-group clearfix">
									<div class="col-sm-12">
										<div class="row clearfix">
											<div class="col-sm-3"><label><strong>Systems:</strong><span class="mandatory"> *</span></label></div>
											<div class="col-sm-9"><select name="projsystem" id="projsystem" class="form-control" <?php if(isset($sidemenu_sub_enable)) { if(($sidemenu_sub_enable)==0) { echo 'readonly="true"'; }  } ?>>
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
											<?php echo form_error('projsystem', '<div class="form-error">', '</div>'); ?></div>
										</div>
									</div>
								</div>
								<div class="row form-group clearfix">
									<div class="col-sm-12">
										<div class="row clearfix">
											<div class="col-sm-3"><label><strong>Sample Point:</strong></label></div>
											<div class="col-sm-9"><input type="text" <?php if(isset($sidemenu_sub_enable)) { if(($sidemenu_sub_enable)==0) { echo 'readonly="true"'; }  } ?> class="form-control" name="smppoint" value="<?php echo set_value('smppoint', (isset($mainChlorin['smppoint'])) ? $mainChlorin['smppoint'] : ''); ?>" /></div>
										</div>
									</div>
									
								</div>
								<div class="row form-group clearfix">
									<div class="col-sm-12">
										<div class="row clearfix">
											<div class="col-sm-3"><label><strong>Pipe Length:</strong></label></div>
											<div class="col-sm-3"><input type="text" <?php if(isset($sidemenu_sub_enable)) { if(($sidemenu_sub_enable)==0) { echo 'readonly="true"'; }  } ?> class="form-control num_0decimal" name="pilen1" value="<?php echo set_value('pilen1', (isset($mainChlorin['pilen1'])) ? $mainChlorin['pilen1'] : ''); ?>" /></div><div class="col-sm-1"> Metters</div><div class="col-sm-3"> <input type="text" <?php if(isset($sidemenu_sub_enable)) { if(($sidemenu_sub_enable)==0) { echo 'readonly="true"'; }  } ?> class="form-control num_1decimal" name="pilen2" value="<?php echo set_value('pilen2', (isset($mainChlorin['pilen2'])) ? $mainChlorin['pilen2'] : ''); ?>" /></div>
										</div>
									</div>
								</div>
								<div class="row form-group clearfix">
									<div class="col-sm-12">
										<div class="row clearfix">
											<div class="col-sm-3"><label><strong>Pipe Diameter:</strong></label></div>
											<div class="col-sm-3"><input type="text" <?php if(isset($sidemenu_sub_enable)) { if(($sidemenu_sub_enable)==0) { echo 'readonly="true"'; }  } ?> class="form-control num_0decimal" name="pidiameter1" value="<?php echo set_value('pidiameter1', (isset($mainChlorin['pidiameter1'])) ? $mainChlorin['pidiameter1'] : ''); ?>" /></div><div class="col-sm-1"> mm</div><div class="col-sm-3"> <input type="text" <?php if(isset($sidemenu_sub_enable)) { if(($sidemenu_sub_enable)==0) { echo 'readonly="true"'; }  } ?> class="form-control num_1decimal" name="pidiameter2" value="<?php echo set_value('pidiameter2', (isset($mainChlorin['pidiameter2'])) ? $mainChlorin['pidiameter2'] : ''); ?>" /></div>
										</div>
									</div>
								</div>
								<div class="row form-group clearfix">									
									<div class="col-sm-12">
										<div class="row clearfix">
											<div class="col-sm-3"><label><strong>Flush Rate:</strong></label></div>
											<div class="col-sm-3"><input type="text" <?php if(isset($sidemenu_sub_enable)) { if(($sidemenu_sub_enable)==0) { echo 'readonly="true"'; }  } ?> class="form-control num_0decimal" name="flushrate1" value="<?php echo set_value('flushrate1', (isset($mainChlorin['flushrate1'])) ? $mainChlorin['flushrate1'] : ''); ?>" /></div><div class="col-sm-1"> L/S</div><div class="col-sm-3"> <input type="text" <?php if(isset($sidemenu_sub_enable)) { if(($sidemenu_sub_enable)==0) { echo 'readonly="true"'; }  } ?> class="form-control num_2decimal" name="flushrate2" value="<?php echo set_value('flushrate2', (isset($mainChlorin['flushrate2'])) ? $mainChlorin['flushrate2'] : ''); ?>" /></div>
										</div>
									</div>
								</div>
								<div class="form-group clearfix text-center"><br><p><em>Swabbing & flushing tasks were performed prior to disinfection.</em></p></div>
								<div class="row form-group clearfix">									
									<div class="col-sm-12">
										<div class="row">
											<div class="col-sm-3"><strong>Disinfection Chemical Used:</strong></div>
											<div class="col-sm-7"><input type="text" <?php if(isset($sidemenu_sub_enable)) { if(($sidemenu_sub_enable)==0) { echo 'readonly="true"'; }  } ?> class="form-control" name="disinfection_used" value="<?php echo set_value('disinfection_used', (isset($mainChlorin['disinfection_used'])) ? $mainChlorin['disinfection_used'] : ''); ?>" /></div>
										</div>
									</div>
								</div>
								<div class="row form-group clearfix">
									<div class="col-sm-12">
										<div class="row">
											<div class="col-sm-3"><strong>Chlorine Level of Source Water:</strong></div>
											<div class="col-sm-3"><input type="text" <?php if(isset($sidemenu_sub_enable)) { if(($sidemenu_sub_enable)==0) { echo 'readonly="true"'; }  } ?> class="form-control num_0decimal" name="levelsourcewater1" value="<?php echo set_value('levelsourcewater1', (isset($mainChlorin['levelsourcewater1'])) ? $mainChlorin['levelsourcewater1'] : ''); ?>" /></div>
											<div class="col-sm-1">MG/L</div>
											<div class="col-sm-3"><input type="text" <?php if(isset($sidemenu_sub_enable)) { if(($sidemenu_sub_enable)==0) { echo 'readonly="true"'; }  } ?> class="form-control num_1decimal" name="levelsourcewater2" value="<?php echo set_value('levelsourcewater2', (isset($mainChlorin['levelsourcewater2'])) ? $mainChlorin['levelsourcewater2'] : ''); ?>" /></div>
										</div>
									</div>
								</div>
								<div class="row form-group clearfix">
									<div class="col-sm-12">
										<div class="row">
											<div class="col-sm-3"><strong>Chlorine Level After Dosing:</strong></div>
											<div class="col-sm-3"><input type="text" <?php if(isset($sidemenu_sub_enable)) { if(($sidemenu_sub_enable)==0) { echo 'readonly="true"'; }  } ?> class="form-control num_0decimal" name="levelafterdosing1" value="<?php echo set_value('levelafterdosing1', (isset($mainChlorin['levelafterdosing1'])) ? $mainChlorin['levelafterdosing1'] : ''); ?>" /></div>
											<div class="col-sm-1">MG/L</div>
											<div class="col-sm-3"><input type="text" <?php if(isset($sidemenu_sub_enable)) { if(($sidemenu_sub_enable)==0) { echo 'readonly="true"'; }  } ?> class="form-control num_1decimal" name="levelafterdosing2" value="<?php echo set_value('levelafterdosing2', (isset($mainChlorin['levelafterdosing2'])) ? $mainChlorin['levelafterdosing2'] : ''); ?>" /></div>
										</div>
									</div>
								</div>
								<div class="row form-group clearfix">
									<div class="col-sm-12">
										<div class="row">
											<?php
												$contactime=array('','');
												if(isset($mainChlorin['contactime']))
												{
													$contactime=explode(':', $mainChlorin['contactime']);
												}												
											?>
											<div class="col-sm-3"><strong>Contact Time:</strong></div>
											<div class="col-sm-3"><input type="text" <?php if(isset($sidemenu_sub_enable)) { if(($sidemenu_sub_enable)==0) { echo 'readonly="true"'; }  } ?> class="form-control timepickerHH" name="contactime" value="<?php echo set_value('contactime', $contactime[0]); ?>" /></div>
											<div class="col-sm-1">Hours</div>
											<div class="col-sm-3"><input type="text" <?php if(isset($sidemenu_sub_enable)) { if(($sidemenu_sub_enable)==0) { echo 'readonly="true"'; }  } ?> class="form-control timepickermm" name="contactime1" value="<?php echo set_value('contactime1', $contactime[1] ); ?>" /></div>
											<div class="col-sm-1">Minutes</div>
										</div>
									</div>
								</div>
								<div class="row form-group clearfix">
									<div class="col-sm-12">
										<div class="row">
											<div class="col-sm-3"><strong>Chlorine Level After Contact:</strong></div>
											<div class="col-sm-3"><input type="text" <?php if(isset($sidemenu_sub_enable)) { if(($sidemenu_sub_enable)==0) { echo 'readonly="true"'; }  } ?> class="form-control num_0decimal" name="levelaftercontact1" value="<?php echo set_value('levelaftercontact1', (isset($mainChlorin['levelaftercontact1'])) ? $mainChlorin['levelaftercontact1'] : ''); ?>" /></div>
											<div class="col-sm-1">MG/L</div>
											<div class="col-sm-3"><input type="text" <?php if(isset($sidemenu_sub_enable)) { if(($sidemenu_sub_enable)==0) { echo 'readonly="true"'; }  } ?> class="form-control num_1decimal" name="levelaftercontact2" value="<?php echo set_value('levelaftercontact2', (isset($mainChlorin['levelaftercontact2'])) ? $mainChlorin['levelaftercontact2'] : ''); ?>" /></div>
										</div>
									</div>
								</div>
								<div class="row form-group clearfix">
									<div class="col-sm-12">
										<div class="row">
											<div class="col-sm-3"><strong>Chlorine Residual After Flushing:</strong></div>
											<div class="col-sm-3"><input type="text" <?php if(isset($sidemenu_sub_enable)) { if(($sidemenu_sub_enable)==0) { echo 'readonly="true"'; }  } ?> class="form-control num_0decimal" name="resiafterflush1" value="<?php echo set_value('resiafterflush1', (isset($mainChlorin['resiafterflush1'])) ? $mainChlorin['resiafterflush1'] : ''); ?>" /></div>
											<div class="col-sm-1">MG/L</div>
											<div class="col-sm-3"><input type="text" <?php if(isset($sidemenu_sub_enable)) { if(($sidemenu_sub_enable)==0) { echo 'readonly="true"'; }  } ?> class="form-control num_1decimal" name="resiafterflush2" value="<?php echo set_value('resiafterflush2', (isset($mainChlorin['resiafterflush2'])) ? $mainChlorin['resiafterflush2'] : ''); ?>" /></div>
										</div>
									</div>
								</div>

								<div class="row form-group clearfix">									
									<div class="col-sm-12">
										<?php
											$flushtimeclr=array('','');
											if(isset($mainChlorin['flushtimeclr']))
											{
												$flushtimeclr=explode(':', $mainChlorin['flushtimeclr']);
											}												
										?>
										<div class="row">
											<div class="col-sm-3"><strong>Flushing Time to Clear:</strong></div>
											<div class="col-sm-3"><input type="text" <?php if(isset($sidemenu_sub_enable)) { if(($sidemenu_sub_enable)==0) { echo 'readonly="true"'; }  } ?> class="form-control timepickerHH" name="flushtimeclr" value="<?php echo set_value('flushtimeclr', $flushtimeclr[0]); ?>" /></div>
											<div class="col-sm-1">Hours</div>
											<div class="col-sm-3"><input type="text" <?php if(isset($sidemenu_sub_enable)) { if(($sidemenu_sub_enable)==0) { echo 'readonly="true"'; }  } ?> class="form-control timepickermm" name="flushtimeclr1" value="<?php echo set_value('flushtimeclr1',$flushtimeclr[1]); ?>" /></div>
											<div class="col-sm-1">Minutes</div>
										</div>
									</div>
								</div>
								<div class="row form-group clearfix">
									<div class="col-sm-12">
										<div class="row">
											<div class="col-sm-3"><strong>On Site Taste Result (Post Flush)</strong></div>
											<div class="col-sm-9"><input type="text" <?php if(isset($sidemenu_sub_enable)) { if(($sidemenu_sub_enable)==0) { echo 'readonly="true"'; }  } ?> class="form-control" name="onsitetasterst" value="<?php echo set_value('onsitetasterst', (isset($mainChlorin['onsitetasterst'])) ? $mainChlorin['onsitetasterst'] : ''); ?>" /></div>
										</div>
									</div>
								</div>
								<div class="row form-group clearfix">
									<div class="col-sm-12">
										<div class="row">
											<div class="col-sm-3"><strong>On Site Odour Result (Post Flush)</strong></div>
											<div class="col-sm-9"><input type="text" <?php if(isset($sidemenu_sub_enable)) { if(($sidemenu_sub_enable)==0) { echo 'readonly="true"'; }  } ?> class="form-control" name="onsiteodourrst" value="<?php echo set_value('onsiteodourrst', (isset($mainChlorin['onsiteodourrst'])) ? $mainChlorin['onsiteodourrst'] : ''); ?>" /></div>
										</div>
									</div>
								</div>
								<div class="row form-group clearfix">
									<div class="col-sm-12">
										<div class="row">
											<div class="col-sm-3"><strong>Confirmation of Pipework Capped:</strong></div>
											<div class="col-sm-9">To Be Confirmed By Services Contrator</div>
										</div>
									</div>
								</div>
								
								<div class="form-group clearfix text-center"><br><p><em>Independent Laboratory analysis has confirmed that the following parameters are within EEC guidelines.</em></p></div>

								<div class="row form-group clearfix">
									<div class="col-sm-4"><strong>TVC 3 days @ 22&deg;</strong></div>
									<div class="col-sm-4"><strong>OFFICE TO COMPLETE</strong></div>
									<div class="col-sm-4"><input type="text" <?php if(isset($sidemenu_sub_enable)) { if(($sidemenu_sub_enable)==0) { echo 'readonly="true"'; }  } ?> class="form-control num_0decimal" name="tvc3" value="<?php echo set_value('tvc3', (isset($mainChlorin['tvc3'])) ? $mainChlorin['tvc3'] : ''); ?>" /></div>
								</div>

								<div class="row form-group clearfix">
									<div class="col-sm-4"><strong>TVC 2 days @ 37&deg;</strong></div>
									<div class="col-sm-4"><strong>OFFICE TO COMPLETE</strong></div>
									<div class="col-sm-4"><input type="text" <?php if(isset($sidemenu_sub_enable)) { if(($sidemenu_sub_enable)==0) { echo 'readonly="true"'; }  } ?> class="form-control num_0decimal" name="tvc2" value="<?php echo set_value('tvc2', (isset($mainChlorin['tvc2'])) ? $mainChlorin['tvc2'] : ''); ?>" /></div>
								</div>

								<div class="row form-group clearfix">
									<div class="col-sm-4"><strong>Coliforms/100ml</strong></div>
									<div class="col-sm-4"><strong>OFFICE TO COMPLETE</strong></div>
									<div class="col-sm-4"><input type="text" <?php if(isset($sidemenu_sub_enable)) { if(($sidemenu_sub_enable)==0) { echo 'readonly="true"'; }  } ?> class="form-control num_0decimal" name="coliforms" value="<?php echo set_value('coliforms', (isset($mainChlorin['coliforms'])) ? $mainChlorin['coliforms'] : ''); ?>" /></div>
								</div>

								<div class="row form-group clearfix">
									<div class="col-sm-4"><strong>E.coli/100ml</strong></div>
									<div class="col-sm-4"><strong>OFFICE TO COMPLETE</strong></div>
									<div class="col-sm-4"><input type="text" <?php if(isset($sidemenu_sub_enable)) { if(($sidemenu_sub_enable)==0) { echo 'readonly="true"'; }  } ?> class="form-control num_0decimal" name="ecoil" value="<?php echo set_value('ecoil', (isset($mainChlorin['ecoil'])) ? $mainChlorin['ecoil'] : ''); ?>" /></div>
								</div>

								<div class="row form-group clearfix">
									<div class="col-sm-6">									
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
									<div class="col-sm-6">
										<label><strong>Date:</strong><span class="mandatory"> *</span></label>
										<input type="text" <?php if(isset($sidemenu_sub_enable)) { if(($sidemenu_sub_enable)==0) { echo 'readonly="true"'; }  } ?> class="form-control datepicker" name="commairreptenggdate" placeholder="" value="<?php echo set_value('commairreptenggdate', (isset($prcdata['reportdate'])) ? date(DT_FORMAT,strtotime($prcdata['reportdate'])) : date(DT_FORMAT)); ?>" />
			                			<?php echo form_error('commairreptenggdate', '<div class="form-error">', '</div>'); ?>
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
