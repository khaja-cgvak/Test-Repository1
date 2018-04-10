<section class="vbox">
	<section class="scrollable padder">
		<section class="panel panel-default">
			<header class="panel-heading"><b><?php echo $title; ?></b> </header>
			<div class="panel-body">
			<form method="POST" name="addcustomer" class="addcustomer" id="addeditcustomer" action="">
				<div class="">
				 <fieldset>
					<legend>Customer Details:</legend>											  				
					<div class="row">
						<div class="form-group clearfix">
							<div class="col-sm-4">
								<label>Customer Name<span class="mandatory"> *</span></label>
								<input class="form-control" type="text" name="custname" placeholder="Enter Customer Name" value="<?php echo set_value('custname', (isset($userdata['custname'])) ? $userdata['custname'] : ''); ?>" />
	                <?php echo form_error('custname', '<div class="form-error">', '</div>'); ?> 
							</div>
							<div class="col-sm-4">
								<label>Address 1<span class="mandatory"> *</span></label>
								<input class="form-control" type="text" name="addressLine1" placeholder="Enter Address" value="<?php echo set_value('addressLine1', (isset($userdata['addressLine1'])) ? $userdata['addressLine1'] : ''); ?>" />
	                <?php echo form_error('addressLine1', '<div class="form-error">', '</div>'); ?>
							</div>
							<div class="col-sm-4">
								<label>Address 2</label>
								<input class="form-control" type="text" name="addressLine2" placeholder="Enter Address" value="<?php echo set_value('addressLine2', (isset($userdata['addressLine2'])) ? $userdata['addressLine2'] : ''); ?>" />
	                <?php echo form_error('addressLine2', '<div class="form-error">', '</div>'); ?>
							</div>
						</div>
						<div class="form-group clearfix">
							<div class="col-sm-4">
								<label>City<span class="mandatory"> *</span></label>
								<input class="form-control" type="text" name="city"  placeholder="Enter City" value="<?php echo set_value('city', (isset($userdata['city'])) ? $userdata['city'] : ''); ?>" />
	                <?php echo form_error('city', '<div class="form-error">', '</div>'); ?>
							</div>
							<div class="col-sm-4">
								<label>County<span class="mandatory"> *</span></label>
								<input class="form-control" type="text" name="state"  placeholder="Enter County" value="<?php echo set_value('state', (isset($userdata['state'])) ? $userdata['state'] : ''); ?>" />
	                <?php echo form_error('state', '<div class="form-error">', '</div>'); ?>
							</div>
							<div class="col-sm-4">
								<label>Country<span class="mandatory"> *</span></label>
								<input class="form-control" type="text" name="country"  placeholder="Enter Country" value="<?php echo set_value('country', (isset($userdata['country'])) ? $userdata['country'] : ''); ?>" />
	                <?php echo form_error('country', '<div class="form-error">', '</div>'); ?>
							</div>
						</div>
						
						<div class="clearfix">
							<div class="">
								<div class="form-group clearfix">
									<div class="col-sm-4">
										<label>Postcode<span class="mandatory"> *</span></label>
										<input class="form-control" type="text" name="zipcode"  placeholder="Enter Postcode" value="<?php echo set_value('zipcode', (isset($userdata['zipcode'])) ? $userdata['zipcode'] : ''); ?>" />
			                <?php echo form_error('zipcode', '<div class="form-error">', '</div>'); ?>
									</div>
									<div class="col-sm-4">
										<label>Phone<span class="mandatory"> *</span></label>
										<input class="form-control phone-format" type="text" name="phone"  placeholder="Enter Phone" value="<?php echo set_value('phone', (isset($userdata['phone'])) ? $userdata['phone'] : ''); ?>" />
			                <?php echo form_error('phone', '<div class="form-error">', '</div>'); ?>
									</div>
									<div class="col-sm-4">
										<label>Fax</label>
										<input class="form-control phone-format" type="text" name="fax"  placeholder="Enter Fax" value="<?php echo set_value('fax', (isset($userdata['fax'])) ? $userdata['fax'] : ''); ?>" />
			                <?php echo form_error('fax', '<div class="form-error">', '</div>'); ?>
									</div>
								</div>
								<div class="form-group clearfix">								
									<div class="col-sm-4">
										<label>Mobile</label>
										<input class="form-control phone-format" type="text" name="mobile"  placeholder="Enter Mobile" value="<?php echo set_value('mobile', (isset($userdata['mobile'])) ? $userdata['mobile'] : ''); ?>" />
			                <?php echo form_error('mobile', '<div class="form-error">', '</div>'); ?>
									</div>							
									<div class="col-sm-4">
										<label>Email Address<span class="mandatory"> *</span></label>
										<input class="form-control email-format" type="text" name="emailid"  placeholder="Enter Email" value="<?php echo set_value('emailid', (isset($userdata['emailid'])) ? $userdata['emailid'] : ''); ?>" />
			                <?php echo form_error('emailid', '<div class="form-error">', '</div>'); ?>
									</div>
									<div class="col-sm-4">
										<label>Website</label>
										<input class="form-control" type="text" name="website"  placeholder="Enter Website" value="<?php echo set_value('website', (isset($userdata['website'])) ? $userdata['website'] : ''); ?>" />
			                			<?php //echo form_error('website', '<div class="form-error">', '</div>'); ?>
									</div>
									
								</div>
								<div class="form-group clearfix">
												<div class="col-sm-6">
													<label>Active<span class="mandatory"> *</span></label>
													<div><label class="checkbox-inline">
													<input type="radio" name="status" value="1" <?php
						            if (isset($userdata['isactive']) && $userdata['isactive'] == 1)
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
						            if (isset($userdata['isactive']) && $userdata['isactive'] == 0)
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
							/*
							<div class="col-sm-4">
									<label>Signature</label>
										<div id="signature-pad" class="m-signature-pad">
										    <div class="m-signature-pad--body">
										      <canvas></canvas>
										    </div>
										    <div class="m-signature-pad--footer">
										      <div class="left">
										        <button type="button" class="button clear btn btn-xs btn-info" data-action="clear">Clear</button>
										      </div>							      
										    </div>									    
										    <input type="hidden" class="form-control csignature" name="csignature" placeholder="" value="<?php echo set_value('csignature', (isset($userdata['csignature'])) ? $userdata['csignature'] : ''); ?>" />
										    <?php //echo form_error('csignature', '<div class="form-error">', '</div>'); ?>

										  </div>
								</div>
								*/
								?>

						</div>
					</div>
					</fieldset>	
				</div>
				<br>
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
