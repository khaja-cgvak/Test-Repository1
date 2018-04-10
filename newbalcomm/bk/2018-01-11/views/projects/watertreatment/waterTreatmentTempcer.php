<?php
	#echo '<pre>'; print_r($prodata); echo '</pre>';
?>
<section class="vbox">
	<section class="scrollable padder">
		<section class="panel panel-default">
			<header class="panel-heading">
				<div class="row clearfix">
					<div class="col-sm-6"><strong><?php echo $title; ?></strong></div>					
					<div class="col-sm-3"><strong>Process:</strong>&nbsp;&nbsp;&nbsp;<label class="radio-inline"><input type="radio" class="proshtstatus" value="1" name="optradio" <?php if(isset($sheetstatus[0]['status'])) { if(($sheetstatus[0]['status'])==1) { echo 'checked="checked"'; }  }  ?>>Enabled</label><label class="radio-inline"><input type="radio" class="proshtstatus" value="0" name="optradio" <?php if(isset($sheetstatus[0]['status'])) { if(($sheetstatus[0]['status'])==0) { echo 'checked="checked"'; }  } ?>>Disabled</label>
					<!-- <input data-id="0" data-toggle="toggle" data-on="Enabled" data-off="Disabled" data-size="mini" type="checkbox" id="toggle-two" <?php if(isset($sheetstatus[0]['status'])) { if(($sheetstatus[0]['status'])==1) { echo 'checked="checked"'; }  } else{ echo 'checked="checked"'; } ?> > --></div>
					
				</div>
			</header>
			<div class="panel-body">
			<form method="POST" name="adduser" action="" class="addusernew">
				<div class="row">
				<div class="clearfix">
				<div class="panel-body">
					        	<div class="form-group clearfix">
					        	<div class="col-sm-12 text-center"><h2><u>TEMPORARY CERTIFICATE OF<br>DISINFECTION/CHLORINATION</u></h2></div>
					        	</div><br>
					        	<div class="form-group clearfix">
					        		<div class="col-sm-3"><label>Balcomm Ref:<span class="mandatory"> *</span></label></div>
					        		<div class="col-sm-4"><input type="text" <?php if(isset($sidemenu_sub_enable)) { if(($sidemenu_sub_enable)==0) { echo 'readonly="true"'; }  } ?> name="reportref" class="form-control" value="<?php echo set_value('reportref', (isset($prcdata['referenceno'])) ? $prcdata['referenceno'] : ''); ?>">
										<?php echo form_error('reportref', '<div class="form-error">', '</div>'); ?></div>
					        	</div>
					        	<div class="form-group clearfix">
					        		<div class="col-sm-3"><label>Contract Name:<span class="mandatory"> *</span></label></div>
					        		<div class="col-sm-4"><input type="text" <?php if(isset($sidemenu_sub_enable)) { if(($sidemenu_sub_enable)==0) { echo 'readonly="true"'; }  } ?> class="form-control" name="contractname" placeholder="" value="<?php echo set_value('contractname', (isset($prcdata['contractname'])) ? $prcdata['contractname'] : ''); ?>" /><?php echo form_error('reportref', '<div class="form-error">', '</div>'); ?></div>					        		
					        	</div>
					        	<div class="form-group clearfix">
					        		<div class="col-sm-3"><label>Client:</label></div>
					        		<div class="col-sm-4"><?php $userincharge = $prodata['userincharge']; 
                        $client_name=$this->Common_model->getCustomerById($userincharge);
                       // print_r($client_name);
                        echo $client_name['custname'];
                        ?>	</div>
					        	</div>
					        	<div class="form-group clearfix">
					        		<div class="col-sm-12">The following services have been disinfected in accordance with 
					        		<?php 
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
					        			$accord1=0;
					        			if(isset($_POST['accord1']))
					        			{
					        				$accord1=$_POST['accord1'];
					        			}
					        			elseif(isset($prcdata['accord1']))
					        			{
					        				$accord1=$prcdata['accord1'];
					        			}

					        			$accord2=0;
					        			if(isset($_POST['accord2']))
					        			{
					        				$accord2=$_POST['accord2'];
					        			}
					        			elseif(isset($prcdata['accord2']))
					        			{
					        				$accord2=$prcdata['accord2'];
					        			}
					        		?>
					        		<select name="accord1" <?php if(isset($sidemenu_sub_enable)) { if(($sidemenu_sub_enable)==0) { echo 'disabled="true"'; }  } ?>>
					        			<option value="" <?php echo $enabled;?>>Please Select</option>
					        			<option <?php echo $enabled;?> value="1" <?php if($accord1==1) { echo "selected";} ?>>B8558</option>
					        			<option <?php echo $enabled;?> value="2" <?php if($accord1==2) { echo "selected";} ?>>BS 6700</option>
					        		</select>
					        		<strong> or </strong>					        		
					        		<select name="accord2" <?php if(isset($sidemenu_sub_enable)) { if(($sidemenu_sub_enable)==0) { echo 'disabled="true"'; }  } ?> >
					        			<option value="" <?php echo $enabled;?>>Please Select</option>
					        			<option value="1" <?php echo $enabled;?> <?php if($accord2==1) { echo "selected";} ?>>B8558</option>
					        			<option value="2" <?php echo $enabled;?> <?php if($accord2==2) { echo "selected";} ?>>BS 6700</option>
					        		</select>
					        		<strong>:-</strong>
					        		</div>
					        		<?php echo form_error('accord', '<div class="col-sm-12 form-error">', '</div>'); ?>
					        	</div>
					        	<div class="form-group clearfix">
					        		<div class="col-sm-12"><textarea class="form-control" <?php if(isset($sidemenu_sub_enable)) { if(($sidemenu_sub_enable)==0) { echo 'readonly="true"'; }  } ?> name="commaircomments"><?php echo set_value('commaircomments', (isset($prcdata['comments'])) ? $prcdata['comments'] : ''); ?></textarea></div>
					        	</div>
					        	<div class="form-group clearfix">
					        		<div class="col-sm-12">Laboratory results to follow.</div>
					        	</div>
					        	<div class="form-group clearfix">
									<div class="col-sm-4">									
										<label><strong>Engineer:</strong><span class="mandatory"> *</span></label>
										<select class="form-control" name="commairreptenggsign" <?php if(isset($sidemenu_sub_enable)) { if(($sidemenu_sub_enable)==0) { echo 'readonly="true"'; }  } ?>>
											<option value="">Please Select</option >
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
