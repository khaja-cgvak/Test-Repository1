<section class="vbox">
	<section class="scrollable padder">
		<section class="panel panel-default">
			<header class="panel-heading">
				<div class="row clearfix">
					<div class="col-sm-6"><strong><?php echo $title; ?></strong></div>					
					<div class="col-sm-3">Process:&nbsp;&nbsp;&nbsp;<label class="radio-inline"><input type="radio" class="proshtstatus" value="1" name="optradio" <?php if(isset($sheetstatus[0]['status'])) { if(($sheetstatus[0]['status'])==1) { echo 'checked="checked"'; }  }  ?>>Enabled</label><label class="radio-inline"><input type="radio" class="proshtstatus" value="0" name="optradio" <?php if(isset($sheetstatus[0]['status'])) { if(($sheetstatus[0]['status'])==0) { echo 'checked="checked"'; }  } ?>>Disabled</label>
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
			<form method="POST" name="adduser" action="" class="addusernew commAirSysScheform" enctype="multipart/form-data">
				<div class="row">
				<div class="col-sm-12">
				<div class="">
				<?php #echo '<pre>'; print_r($prcdata); echo '</pre>'; ?>
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
												<select name="projsystem" class="form-control" <?php if(isset($sidemenu_sub_enable)) { if(($sidemenu_sub_enable)==0) { echo 'readonly="true"'; }  } ?>>
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
																	//if($sd_value['id']==$prcdata['projectsystemid'])
																	if($sd_value['id']==$projectsystemid)
																	{
																		$selected=' selected="selected" ';
																	}
																}													
																echo '<option '.$enabled.' value="'.$sd_value['id'].'" '.$selected.'>'.$sd_value['systemname'].'</option>';
															}
														}
													?>
												</select>
												<!--<input type="text" name="projsystem" class="form-control" value="<?php echo set_value('projsystem', (isset($prcdata['system'])) ? $prcdata['system'] : ''); ?>"> -->
												<?php echo form_error('projsystem', '<div class="form-error">', '</div>'); ?>
											</div>
										</div>									
									</div>
								</div>

								<div class="form-group clearfix">
									<label>Upload File:<span class="mandatory"> *</span></label>
									<!--<input type="file" name="uploadfile" id="imgInp" class="file">-->
									<input type="file" name="uploadfile[]" <?php if(isset($sidemenu_sub_enable)) { if(($sidemenu_sub_enable)==0) { echo 'readonly="true"'; }  } ?> id="imgInp" multiple>
								    <?php echo form_error('uploadfile', '<div class="form-error">', '</div>'); ?>
								</div>
								
								<div class="row form-group clearfix">
									<div class="col-sm-4">									
										<label>Engineer:<span class="mandatory"> *</span></label>
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
										<label>Date: <span class="mandatory"> *</span></label>
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
<?php
	//$getsysFiles=$this->MProject->getsysFilesPrzid(intval($prcessid),CASYSSCHE);
	$initPreviewfile=array();
	$initPreviewfileconfig=array();
	//if($getsysFiles->num_rows()>0)
	if(!empty($getsysFilesdata))
	{
		//$getsysFilesdata=$getsysFiles->result_array();		
		foreach ($getsysFilesdata as $key => $value) {
			//application/pdf
			$fileurl='"'.base_url(UPATH.$value['filestorename']).'"';
			if($value['filetype']=='application/pdf')
			{
				$initPreviewfileconfig[]='{caption: "'.$value['filename'].'", type:"pdf",  size: '.intval($value['filesize']).', url: "'.base_url('projects/removeFilebyUser').'", key: '.$value['id'].'}';
			}
			else
			{
				$initPreviewfileconfig[]='{caption: "'.$value['filename'].'", size: '.intval($value['filesize']).', url: "'.base_url('projects/removeFilebyUser').'", key: '.$value['id'].'}';
			}

			$initPreviewfile[]=$fileurl;
			//$initPreviewfileconfig[]='{caption: "'.$value['filename'].'", size: '.intval($value['filesize']).', url: "'.base_url('projects/removeFilebyUser').'", key: '.$value['id'].'}';
		}

	}
?>
<script type="text/javascript">
	var initPreviewfile=[<?php echo implode(',', $initPreviewfile); ?>];
	var initPreviewfileconfig=[<?php echo implode(',', $initPreviewfileconfig); ?>];
</script>