<section class="vbox">
	<section class="scrollable padder">
		<section class="panel panel-default">
			<header class="panel-heading"><b><?php echo $title; ?></b> </header>
			<div class="panel-body">
				<div class="table-responsive">
					<input type="hidden" id="userid" value="<?php echo $userid; ?>">
					<table class="table table-striped m-b-none table-bordered dt-responsive nowrap" width="100%" id="customersitelist_tables">
						<thead>
							<tr>
								<th width="45%">Site Name</th>
								<th width="45%">Site Address</th>
								<th width="10%">Action</th>
							</tr>
						</thead>					
					</table>
				</div>
			<form method="POST" name="addcustomersite" class="addcustomersite" id="addcustomersite" action="">
				<div class="">
				 <fieldset>
						<legend>Add/Edit Site</legend>						
					  				
					<div class="form-group clearfix">
						<div class="col-sm-4">
							<label>Site Name<span class="mandatory"> *</span></label>
							<input class="form-control" type="text" name="sitename"  placeholder="Enter Site Name" value="<?php echo set_value('sitename', (isset($conde_value['sitename'])) ? $conde_value['sitename'] : ''); ?>" />
							<div class="form-error sitename-error"></div>
						</div>
						<div class="col-sm-4">
							<label>Site Address<span class="mandatory"> *</span></label>							
							<textarea class="form-control siteaddress" name="siteaddress"  placeholder="Enter Site Address"><?php echo set_value('siteaddress', (isset($conde_value['siteaddress'])) ? $conde_value['siteaddress'] : ''); ?></textarea>
							<div class="form-error siteaddress-error"></div>
						</div>
					</div>
					<div class="form-group clearfix">
						<div class="col-sm-12">
							<label>Contacts<span class="mandatory"> *</span></label>
						</div>
						<div class="col-sm-12">
							<?php
								if($contactall->num_rows()>0)
								{
									$contactalldata=$contactall->result_array();
									//echo '<pre>'; print_r($contactalldata); echo '</pre>';
									foreach ($contactalldata as $key => $value) {
										?>
										<label class="checkbox-inline"><input type="checkbox" class="sitecontacts" name="sitecontacts[]" value="<?php echo $value['id']; ?>"><?php echo $value['contactfirstname'].' '.$value['contactlastname']; ?></label>
										<?php
									}
								}
							?>
							<div class="form-error sitecontacts-error"></div>
						</div>
					</div>
					</fieldset>	
				</div>
				<br>
				<footer class="panel-footer text-right bg-light lter"> 
					<input type="hidden" name="custid" id="custid" value="<?php echo $this->uri->segment(3); ?>" />
					<input type="hidden" name="custsiteid" id="custsiteid" value="0" />
					<input type="submit" name="submit" value="Submit" class="btn btn-success btn-sm submit-btn ">
					<input type="reset" name="cancel" value="Cancel" class="btn btn-danger btn-sm submit-btn btnreset ">
				</footer>
			</form>
			</div>
			
		</section>
	</section>
</section>