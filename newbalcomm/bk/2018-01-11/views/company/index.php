
<section class="vbox">
	<section class="scrollable padder">
		<section class="panel panel-default">
		<?php
			if ($this->session->flashdata('success_message') != '')
			{
				echo '<div class="alert2 alert-success text-center" style="width:100%;">' . $this->session->flashdata('success_message') . '</div><br>';
				$this->session->set_flashdata('success_message', '');
			}
			?>
			<header class="panel-heading"><b><?php echo $title; ?></b> </header>
			<div class="panel-body">
			<form method="POST" name="adduser" class="addusernew" id="adduserform" action="" enctype="multipart/form-data">
				<div class="row">
						<div class="">
							<div>
								<div class=" form-group clearfix">
									<div class="col-sm-4">
										<label>Company Name<span class="mandatory"> *</span></label>
										<input class="form-control" type="text" name="companyname" placeholder="Enter Company Name" value="<?php echo set_value('companyname', (isset($companydetails['companyname'])) ? $companydetails['companyname'] : ''); ?>" />
			                <?php echo form_error('companyname', '<div class="form-error">', '</div>'); ?> 
									</div>
									<div class="col-sm-4">
										<label>Phone<span class="mandatory"> *</span></label>
										<input class="form-control phone-format" type="text" name="phone" placeholder="Enter Phone Number" value="<?php echo set_value('phone', (isset($companydetails['phone'])) ? $companydetails['phone'] : ''); ?>" />
			                <?php echo form_error('phone', '<div class="form-error">', '</div>'); ?>
									</div>
									<div class="col-sm-4">
										<label>Mobile</label>
										<input class="form-control phone-format" type="text" name="mobile" placeholder="Enter Mobile Number" value="<?php echo set_value('mobile', (isset($companydetails['mobile'])) ? $companydetails['mobile'] : ''); ?>" />
			                <?php echo form_error('mobile', '<div class="form-error">', '</div>'); ?>
									</div>
								</div>
								<div class="form-group clearfix">
														
									<div class="col-sm-4">
										<label>Email<span class="mandatory"> *</span></label>
										<input class="form-control email-format" type="text" name="email"  placeholder="Enter Email Address" value="<?php echo set_value('email', (isset($companydetails['email'])) ? $companydetails['email'] : ''); ?>" />
			                <?php echo form_error('email', '<div class="form-error">', '</div>'); ?>
									</div>
									<div class="col-sm-4">
										<label>Address<span class="mandatory"> *</span></label>
										<textarea class="form-control" name="address" placeholder="Enter Company Address" ><?php echo set_value('address', (isset($companydetails['address'])) ? $companydetails['address'] : ''); ?></textarea>
			                <?php echo form_error('address', '<div class="form-error">', '</div>'); ?>
									</div>
									<div class="col-sm-4">
										<label>Company Logo<span class="mandatory"> *</span></label>
										<input type="file" name="uploadfile" id="cmplogo">
			                			<?php echo form_error('uploadfile', '<div class="form-error">', '</div>'); ?>
									</div>
								</div>
							</div>
							
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

<?php
	//$getsysFiles=$this->MProject->getsysFilesPrzid(intval($prcessid),CASYSSCHE);
	$initPreviewfile=array();
	$initPreviewfileconfig=array();
	//if($getsysFiles->num_rows()>0)
	if(!empty($companydetails['logo']))
	{
		$fileurl='"'.base_url(UPATH.$companydetails['logo']).'"';
		$initPreviewfileconfig[]='{caption: "'.$companydetails['companyname'].'", size: '.intval(0).', url: "#", key: '.$companydetails['id'].'}';
		$initPreviewfile[]=$fileurl;

	}
?>
<script type="text/javascript">
	var initPreviewfile=[<?php echo implode(',', $initPreviewfile); ?>];
	var initPreviewfileconfig=[<?php echo implode(',', $initPreviewfileconfig); ?>];
</script>