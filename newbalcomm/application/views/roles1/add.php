<section class="vbox">
	<section class="scrollable padder">
		<section class="panel panel-default">
			<header class="panel-heading"><b><?php echo $title; ?></b> </header>
			<?php
				if ($this->session->flashdata('success_message_new') != '')
				echo '<div class="form-group clearfix"><div class="alert2 alert-success text-center" style="width:100%;">' . $this->session->flashdata('success_message_new') . '</div></div>';
			?>
			<div class="panel-body">
			<form method="POST" name="adduser" action="" class="addusernew">
				<div class="row">
					<div class="form-group clearfix">
						<div class="col-sm-4">
							<label>Role Name<span class="mandatory"> *</span></label>
							<input type="text" class="form-control" name="role" placeholder="Enter Role Name" value="<?php echo set_value('role', (isset($roles['rolesname'])) ? $roles['rolesname'] : ''); ?>" />
                <?php echo form_error('role', '<div class="form-error">', '</div>'); ?>
						</div>
						<div class="col-sm-4">
							<label>Description<span class="mandatory"> *</span></label>
							<input type="text" class="form-control" name="description" placeholder="Enter Roles Description" value="<?php echo set_value('description', (isset($roles['rolesdescription'])) ? $roles['rolesdescription'] : ''); ?>" />
                <?php echo form_error('description', '<div class="form-error">', '</div>'); ?>
						</div>
						<div class="col-sm-4">
							<label>Active<span class="mandatory"> *</span></label>
							<div><label class="checkbox-inline">
							<input type="radio" name="status" value="1" <?php
								if (isset($roles['isactive']) && $roles['isactive'] == 1)
								{
									echo 'checked';
								}
								else
								{
									echo 'checked';
								}
								?> /> Yes</label>
								<label class="checkbox-inline">
								<input type="radio" name="status" value="0"  <?php
								if (isset($roles['isactive']) && $roles['isactive'] == 0)
								{
									echo 'checked';
								}
								?>  /> No</label>
									   <?php echo form_error('status', '<div class="form-error">', '</div>'); ?>
												</div>
											</div>
					</div>
				</div>
				<?php
					$roleid=$this->session->userdata('userroleid');
					if($roleid==1)
					{
				?>
				<hr>
				<h5><strong><u>Privilege Options:</u></strong></h5>
				<div class="privilagepanel">
					<?php
						$prvPagesql=$this->Common_model->getPrvPages();
						$prvPagesqlcnt=$prvPagesql->num_rows();
						if($prvPagesqlcnt>0)
						{
							$rowinc=0;
							$prvPagedata=$prvPagesql->result_array();
							foreach ($prvPagedata as $key => $value) 
							{
								if($rowinc==0)
								{
							 		echo '<div class="row">';							 		
								}
								$rowinc++;
							?>
									<div class="col-sm-4">						    	
										<div class="panel panel-info">
											<div class="panel-heading">
												<h3 class="panel-title"><?php echo $value['pagename']; ?></h3>
							                    <span class="pull-right clickable"><i class="fa fa-chevron-up"></i></span>
											</div>
											<div class="panel-body">
												<div class="clearfix">
												<?php
													$prvOptPagesql=$this->Common_model->getPrvOptPagesByPid($value['id']);
													$prvOptPagescnt=$prvOptPagesql->num_rows();
													if($prvOptPagescnt>0)
													{
														$prvOptPagesdata=$prvOptPagesql->result_array();
														foreach ($prvOptPagesdata as $key1 => $value1) {
															$chname='prvOptPage_'.$value1['id'];
															$chname_ck='';
															$chname_val=0;
															if(isset($_POST[$chname]) && !empty($_POST[$chname]))
															{
																$chname_ck=' checked="checked" ';
																$chname_val=1;
															}
															else
															{	
																$roleid=intval($this->Common_model->decodeid($this->uri->segment(3)));
																if($roleid!=0)
																{

																	$rolePermission=$this->Mroles->getRolePermission($roleid,$value1['id']);

																	if($rolePermission->num_rows()>0)
																	{
																		$rolePermission_data=$rolePermission->result_array();
																		if($rolePermission_data[0]['optstatus']==1)
																		{
																			$chname_ck=' checked="checked" ';
																			$chname_val=1;
																		}

																	}
																}

															}
															echo '<div class="col-sm-6"><label class="checkbox"><input type="checkbox" class="prvOptPageid" name="'.$chname.'" value="'.$value1['id'].'" '.$chname_ck.'><input type="hidden" class="prvOptPageids" name="prvOptPageid_'.$value1['id'].'" value="'.$chname_val.'">&nbsp;<i class="fa '.$value1['icons'].'" aria-hidden="true"></i>&nbsp;&nbsp;'.$value1['optname'].'</label>
																<input type="hidden" name="prvPageid[]" value="'.$value1['id'].'" />
															</div>';
														}
													}
												?>
												
												</div>
											</div>
										</div>
									</div>
								<?php
								if(($rowinc==3)||($prvPagesqlcnt==($key+1)))
								{			
									$rowinc=0;			
									echo '</div>';
								}
							}
						}
					?>
				</div>
				<?php
					}
				?>
				
				<footer class="panel-footer text-right bg-light lter"> 
					<input type="hidden" name="existid" value="<?php echo $this->uri->segment(3); ?>" />
					<input type="submit" name="submit" value="Submit" class="btn btn-success btn-s-xs submit-btn addnew">
					<input type="submit" name="cancel" value="Cancel" class="btn btn-danger btn-s-xs submit-btn cancel">
			</footer> 
			</form>
			</div>
			
		</section>
	</section>
</section>
