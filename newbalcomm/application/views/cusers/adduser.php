<section class="vbox">
	<section class="scrollable padder">
		<section class="panel panel-default">
		<?php
			if ($this->session->flashdata('success_message') != '')
				echo '<div class="alert2 alert-success text-center" style="width:100%;">' . $this->session->flashdata('success_message') . '</div><br>';
			?>
			<header class="panel-heading"><b><?php echo $title; ?></b> </header>
			<div class="panel-body">
			<form method="POST" name="adduser" class="addusernew" id="adduserform" action="">
				<div class="row">
						<div class="">
							<div class="">
								<div class="form-group clearfix">
									<div class="col-sm-4">
										<label>First Name<span class="mandatory"> *</span></label>
										<input class="form-control" type="text" name="firstname" placeholder="Enter First Name" value="<?php echo set_value('firstname', (isset($userdata['firstname'])) ? $userdata['firstname'] : ''); ?>" />
			                <?php echo form_error('firstname', '<div class="form-error">', '</div>'); ?> 
									</div>
									<div class="col-sm-4">
										<label>Last Name<span class="mandatory"> *</span></label>
										<input class="form-control" type="text" name="lastname" placeholder="Enter Last Name" value="<?php echo set_value('lastname', (isset($userdata['lastname'])) ? $userdata['lastname'] : ''); ?>" />
			                <?php echo form_error('lastname', '<div class="form-error">', '</div>'); ?>
									</div>
									<div class="col-sm-4">
										<label>Email</label>
										<input class="form-control email-format" type="text" name="email"  placeholder="Enter Email" value="<?php echo set_value('email', (isset($userdata['emailid'])) ? $userdata['emailid'] : ''); ?>" />
			                <?php echo form_error('email', '<div class="form-error">', '</div>'); ?>
									</div>
									<div class="col-sm-4 hidden">
										<label>User Name</label>
										<input class="form-control" type="text" readonly name="username" placeholder="Enter User Name" value="<?php echo set_value('username', (isset($userdata['displayname'])) ? $userdata['displayname'] : ''); ?>" />
			                <?php echo form_error('username', '<div class="form-error">', '</div>'); ?>
									</div>
								</div>
								<div class="form-group clearfix">
																	
									<div class="col-sm-4">
										<label>Designation</label>
										<input class="form-control" type="text" name="designation"  placeholder="Enter designation" value="<?php echo set_value('designation', (isset($userdata['designation'])) ? $userdata['designation'] : ''); ?>" />
			                			<?php echo form_error('designation', '<div class="form-error">', '</div>'); ?>
									</div>						
									<div class="col-sm-4">
										<label>Password<span class="mandatory"> *</span></label>
										<input class="form-control" type="password" name="password"   placeholder="Enter Password" value="<?php echo set_value('password'); ?>" />
			                <?php echo form_error('password', '<div class="form-error">', '</div>'); ?> 
									</div>
									<div class="col-sm-4">
										<label>Confirm Password<span class="mandatory"> *</span></label>
										<input class="form-control" type="password" name="cpassword"  placeholder="Enter Confirm Password " value="<?php echo set_value('cpassword'); ?>" />
			                <?php echo form_error('cpassword', '<div class="form-error">', '</div>'); ?>
									</div>
								</div>
							</div>
							<?php
							/*
							<div class="col-sm-4">
								<label>Authorised Signature<span class="mandatory"> *</span></label>
									<div id="signature-pad" class="m-signature-pad">
									    <div class="m-signature-pad--body">
									      <canvas></canvas>
									    </div>
									    <div class="m-signature-pad--footer">
									      <div class="left">
									        <button type="button" class="button clear btn btn-xs btn-info" data-action="clear">Clear</button>
									      </div>							      
									    </div>									    
									    <input type="hidden" class="form-control signature" name="signature" placeholder="" value="<?php echo set_value('signature', (isset($userdata['signature'])) ? $userdata['signature'] : ''); ?>" />
									    <?php echo form_error('signature', '<div class="form-error">', '</div>'); ?>

									  </div>
							</div>
							*/
							?>
						</div>

				</div>
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