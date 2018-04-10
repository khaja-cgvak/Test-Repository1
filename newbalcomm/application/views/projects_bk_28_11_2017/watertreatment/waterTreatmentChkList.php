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
				<div class="row clearfix">
				<div class="">
					<div  class="">
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
								<div class="form-group clearfix">
									<div class="clearfix">
										<!-- Loop Start -->
										<?php
										$getProcesSecCat=$this->Common_model->getProcesSecCatByPrcId($masterprcid);
										if($getProcesSecCat->num_rows()>0)
										{
											$getProcesSecCat_data=$getProcesSecCat->result_array();
											foreach ($getProcesSecCat_data as $key => $value) 
											{
												$getProcesSec=$this->Common_model->getProcesSecByCatid($value['id']);
												if($getProcesSec->num_rows()>0)
												{
										?>
										<div class="col-sm-6">
											<div class="panel panel-default">
										      <div class="panel-heading">
										        <h4 class="panel-title text-center"><?php echo $value['sectioncategory']; ?></h4>
										      </div>
										      <div class="panel-body">
										      	<table class="table">
										      		<tbody>
											      		<?php
											      			$getProcesSec_data=$getProcesSec->result_array();
											      			foreach ($getProcesSec_data as $key1 => $value1) {
											      				$curvalsql=$this->MProject->getWTchkLstData($prcessid,$value1['id']);
											      				$curval='';
											      				$curvalid=0;
											      				if($curvalsql->num_rows()>0)
											      				{
											      					$curvaldata=$curvalsql->result_array();
											      					$curval=$curvaldata[0]['secdata'];
											      					$curvalid=$curvaldata[0]['id'];
											      				}
											      				if(isset($_POST['mawatqph_'.$value1['id']])&&($_POST['syscompretest_'.$value1['id']]))
											      				{
											      					$curval=$_POST['mawatqph_'.$value1['id']];
											      				}
											      				elseif(isset($_POST['mawatqph_'.$value1['id']])&&($_POST['syscompretest_'.$value1['id']]))
											      				{
											      					$curval=$_POST['mawatqph_'.$value1['id']];
											      				}
											      				else
											      				{

											      				}
											      				?>
											      		<tr>
										      				<td><?php echo $value1['sectionname']; ?></td>
										      				<td>
										      					<?php
										      						if($value1['datatype']=='text' || $value1['datatype']=='number')
										      						{
										      							?>
										      						<input type="text" class="form-control" name="mawatqph_<?php echo $value1['id']; ?>" value="<?php echo $curval; ?>" />
										      							<?php
										      						}
										      						else
										      						{
										      					?>
										      					<label class="radio-inline"><input type="radio" value="yes" name="mawatqph_<?php echo $value1['id']; ?>" <?php echo (($curval=='yes')?'checked="checked"':''); ?> >Yes</label>
																<label class="radio-inline"><input type="radio" value="no" name="mawatqph_<?php echo $value1['id']; ?>" <?php echo (($curval=='no')?'checked="checked"':''); ?> >No</label>
																<label class="radio-inline"><input type="radio" value="na" name="mawatqph_<?php echo $value1['id']; ?>" <?php echo (($curval=='na')?'checked="checked"':''); ?> >N/A</label>
																<?php
																	}
																?>
																<input type="hidden" name="curvalid_<?php echo $value1['id']; ?>" value="<?php echo $curvalid; ?>">
																<input type="hidden" name="prosectid[]" value="<?php echo $value1['id']; ?>">
										      				</td>
										      			</tr>
											      				<?php
											      			}
											      		?>
										      		</tbody>
										      	</table>
										      </div>
										    </div>
										</div>
										<?php
												}
											}
										}
										?>
										<!-- Loop End -->
										
									</div>
								</div>
								<div class="form-group clearfix">
									<div class="col-sm-4">
										<label>Chemicals Used:</label>
										<input type="text" class="form-control" name="chemical" placeholder="" value="<?php echo set_value('chemical', (isset($checkList['chemical'])) ? $checkList['chemical'] : ''); ?>" />
									</div>
									<div class="col-sm-4">
										<label>Inhibitor Dosage:</label>
										<input type="text" class="form-control" name="inhibitor" placeholder="" value="<?php echo set_value('inhibitor', (isset($checkList['inhibitor'])) ? $checkList['inhibitor'] : ''); ?>" />
									</div>
									<div class="col-sm-4">
										<label>Biocide Dosage:</label>
										<input type="text" class="form-control" name="biocide" placeholder="" value="<?php echo set_value('biocide', (isset($checkList['biocide'])) ? $checkList['biocide'] : ''); ?>" />
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
					<input type="hidden" name="chklstid" value="<?php echo $chklstid; ?>" />
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
