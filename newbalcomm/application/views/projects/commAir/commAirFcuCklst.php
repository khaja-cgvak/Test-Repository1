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

						<?php
							$getProcesSecCat=$this->Common_model->getProcesSecCatByPrcId($masterprcid);
							if($getProcesSecCat->num_rows()>0)
							{
								$getProcesSecCat_data=$getProcesSecCat->result_array();
								foreach ($getProcesSecCat_data as $key => $value) {
									$getProcesSecByCatid=$this->Common_model->getProcesSecByCatid($value['id']);											
									$getProcesSecByCatid_data=$getProcesSecByCatid->result_array();
									$rowtotal=$getProcesSecByCatid->num_rows();
									$rowinc=0;
									if($rowtotal>0)
									{
										foreach ($getProcesSecByCatid_data as $key1 => $value1) {
											if($rowinc==0)
											{
												echo '<div class="row form-group clearfix">';
											}
											$rowinc++;

											$sectionvalue='';
											$procesSectionId=0;

											if(intval($prcessid)!=0)
											{
												$processMasterdetails=$this->MProject->getCAFcuCkDetails($prcessid,$value1['id'],1);
												if(!empty($processMasterdetails))
												{
													if($processMasterdetails->num_rows()>0)
													{
														$processMasterdata=$processMasterdetails->result_array();
														$sectionvalue=$processMasterdata[0]['fcu_description'];
														$procesSectionId=$processMasterdata[0]['id'];
													}
												}
											}
                                            if(isset($sidemenu_sub_enable)) 
											{ if(($sidemenu_sub_enable)==0) 
											   { 
										        $selected ='readonly="true"';
											   }
                                              else
											  {
												$selected='';  
											  }										   
										    }
											echo '<div class="col-sm-4">
												<label><strong>'.$value1['sectionname'].':</strong></label>
													<input type="text" '.$selected.' class="form-control"  name="sectionname_'.$value1['id'].'" placeholder="" value="'.$sectionvalue.'" />
													<input type="hidden" name="procesSection[]" value="'.$value1['id'].'" />
												    <input type="hidden" name="procesSectionId'.$value1['id'].'" value="'.$procesSectionId.'" />
											</div>';

											if(($rowtotal==($key1+1))||($rowinc==3))
											{
												echo '</div>';
												$rowinc=0;
											}

										}
									}
								}
							}
						?>
						
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
								<input type="text" class="form-control datepicker" name="commairreptenggdate" <?php if(isset($sidemenu_sub_enable)) { if(($sidemenu_sub_enable)==0) { echo 'readonly="true"'; }  } ?> placeholder="" value="<?php echo set_value('commairreptenggdate', (isset($prcdata['reportdate'])) ? date(DT_FORMAT,strtotime($prcdata['reportdate'])) : date(DT_FORMAT)); ?>" />
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