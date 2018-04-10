<section class="vbox">
	<section class="scrollable padder">
		<section class="panel panel-default">
			<header class="panel-heading"><b><?php echo $title; ?></b> </header>
			<div class="panel-body">
				<div class="table-responsive">
					<input type="hidden" id="userid" value="<?php echo $userid; ?>">
					<table class="table table-striped m-b-none table-bordered dt-responsive nowrap" width="100%" id="customercontactlist_tables">
						<thead>
							<tr>
								<th width="15%">First Name</th>
								<th width="15%">Last Name</th>
								<th width="15%">Designation</th>
								<th width="15%">Phone</th>							
								<th width="15%">Mobile</th>
								<th width="15%">Email</th>
								<th width="10%">Action</th>
							</tr>
						</thead>					
					</table>
				</div>
			<form method="POST" name="addcustomercont" class="addcustomercont" id="addcustomercont" action="">
				<div class="">
				 <fieldset>
						<legend>Add/Edit Contact</legend>						
					  				
					<div class="form-group clearfix">
						<div class="col-sm-4">
							<label>First Name<span class="mandatory"> *</span></label>
							<input class="form-control" type="text" name="contactfirstname"  placeholder="Enter First Name" value="<?php echo set_value('contactfirstname', (isset($conde_value['contactfirstname'])) ? $conde_value['contactfirstname'] : ''); ?>" />
						</div>
						<div class="col-sm-4">
							<label>Last Name<span class="mandatory"> *</span></label>
							<input class="form-control" type="text" name="contactlastname"  placeholder="Enter Last Name" value="<?php echo set_value('contactlastname', (isset($conde_value['contactlastname'])) ? $conde_value['contactlastname'] : ''); ?>" />
						</div>
						<div class="col-sm-4">
							<label>Job Role<span class="mandatory"> *</span></label>
							<input class="form-control" type="text" name="contactdesignation"  placeholder="Enter Designation" value="<?php echo set_value('contactdesignation', (isset($conde_value['contactdesignation'])) ? $conde_value['contactdesignation'] : ''); ?>" />
						</div>
					</div>
					<div class="form-group clearfix">
						<div class="col-sm-4">
							<label>Phone<span class="mandatory"> *</span></label>
							<input class="form-control phone-format" type="text" name="contactphone"  placeholder="Enter Phone" value="<?php echo set_value('contactphone', (isset($conde_value['contactphone'])) ? $conde_value['contactphone'] : ''); ?>" />
						</div>
						<div class="col-sm-4">
							<label>Mobile</label>
							<input class="form-control phone-format" type="text" name="contactmobile"  placeholder="Enter Mobile" value="<?php echo set_value('contactmobile', (isset($conde_value['contactmobile'])) ? $conde_value['contactmobile'] : ''); ?>" />
						</div>
						<div class="col-sm-4">
							<label>Email<span class="mandatory"> *</span></label>
							<input class="form-control email-format" type="text" name="contactemailid"  placeholder="Enter Email" value="<?php echo set_value('contactemailid', (isset($conde_value['contactemailid'])) ? $conde_value['contactemailid'] : ''); ?>" />
						</div>
						
					</div>
					</fieldset>	
				</div>
				<br>
				<footer class="panel-footer text-right bg-light lter"> 
					<input type="hidden" name="custid" id="custid" value="<?php echo $this->uri->segment(3); ?>" />
					<input type="hidden" name="custcontid" id="custcontid" value="0" />
					<input type="submit" name="submit" value="Submit" class="btn btn-success btn-sm submit-btn ">
					<input type="reset" name="cancel" value="Cancel" class="btn btn-danger btn-sm submit-btn btnreset ">
				</footer>
			</form>
			</div>
			
		</section>
	</section>
</section>