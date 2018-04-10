<section class="vbox">
	<section class="scrollable padder">
		<section class="panel panel-default">
			<header class="panel-heading"><b><?php echo $title; ?></b> </header>
			<div class="panel-body">
			<form method="POST" name="adduser" action="" class="addusernew">
				<div class="row">
					<div class="form-group clearfix">
						<div class="col-sm-4"><strong>Project:</strong> <?php echo $prodata['projectname']; ?></div>
						<div class="col-sm-4"><strong>Ref:</strong> <?php echo $prodata['id']; ?></div>
						<div class="col-sm-4"><strong>Sheet:</strong> 1 of 1</div>
					</div>
					<div class="form-group clearfix">
						<div class="col-sm-4">
							<label>Compnay Owning Valve<span class="mandatory"> *</span></label>
							<input type="text" class="form-control" name="comownval" placeholder="Enter Compnay Owning Valve" value="<?php echo set_value('comownval', (isset($roles['comownval'])) ? $roles['comownval'] : ''); ?>" />
                			<?php echo form_error('comownval', '<div class="form-error">', '</div>'); ?>
                		</div>
						<div class="col-sm-4">
							<label>Water Suppliers Customer (if Different)<span class="mandatory"> *</span></label>
							<input type="text" class="form-control" name="watsupcus" placeholder="Enter Water Suppliers Customer" value="<?php echo set_value('watsupcus', (isset($roles['watsupcus'])) ? $roles['watsupcus'] : ''); ?>" />
                			<?php echo form_error('watsupcus', '<div class="form-error">', '</div>'); ?>
                		</div>
                		<div class="col-sm-4">
							<label>Water Supplier<span class="mandatory"> *</span></label>
							<input type="text" class="form-control" name="watsupplier" placeholder="Enter Water Supplier" value="<?php echo set_value('watsupplier', (isset($roles['watsupplier'])) ? $roles['watsupplier'] : ''); ?>" />
                			<?php echo form_error('watsupplier', '<div class="form-error">', '</div>'); ?>
                		</div>
					</div>

					<div class="form-group clearfix">
						<div class="col-sm-4">
							<label>Location Address of Valve<span class="mandatory"> *</span></label>
							<input type="text" class="form-control" name="locaaddvalve" placeholder="Enter Location Address of Valve" value="<?php echo set_value('locaaddvalve', (isset($roles['locaaddvalve'])) ? $roles['locaaddvalve'] : ''); ?>" />
                			<?php echo form_error('locaaddvalve', '<div class="form-error">', '</div>'); ?>
                			<div class="clearfix"></div>
                			<label>Tel:<span class="mandatory"> *</span></label>
							<input type="text" class="form-control" name="locaaddvalvetel" placeholder="" value="<?php echo set_value('locaaddvalvetel', (isset($roles['locaaddvalvetel'])) ? $roles['locaaddvalvetel'] : ''); ?>" />
                			<?php echo form_error('locaaddvalvetel', '<div class="form-error">', '</div>'); ?>

                		</div>
						<div class="col-sm-4">
							<label>Valve<span class="mandatory"> *</span></label>
							<table class="table table-bordered table-striped">
								<thead>
									<tr>
										<th>Make</th>
										<th>Size</th>
										<th>Serial</th>
										<th>Model</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td><input type="text" class="form-control" name="valvemake" placeholder="Make" value="<?php echo set_value('valvemake', (isset($roles['valvemake'])) ? $roles['valvemake'] : ''); ?>" />
                			<?php echo form_error('valvemake', '<div class="form-error">', '</div>'); ?></td>
                						<td><input type="text" class="form-control" name="valvesize" placeholder="Size" value="<?php echo set_value('valvesize', (isset($roles['valvesize'])) ? $roles['valvesize'] : ''); ?>" />
			                			<?php echo form_error('valvesize', '<div class="form-error">', '</div>'); ?></td>
			                			<td><input type="text" class="form-control" name="valveserial" placeholder="Serial" value="<?php echo set_value('valveserial', (isset($roles['valveserial'])) ? $roles['valveserial'] : ''); ?>" />
			                			<?php echo form_error('valveserial', '<div class="form-error">', '</div>'); ?></td>
			                			<td><input type="text" class="form-control" name="valvemodel" placeholder="Model" value="<?php echo set_value('valvemodel', (isset($roles['valvemodel'])) ? $roles['valvemodel'] : ''); ?>" />
			                			<?php echo form_error('valvemodel', '<div class="form-error">', '</div>'); ?></td>
									</tr>
								</tbody>
							</table>
							
                		</div>
                		<div class="col-sm-4">
							<label>Permission to Turn off Supply (Capital letters)<span class="mandatory"> *</span></label>
							<input type="text" class="form-control" name="permisturnoffsup" placeholder="Enter Permission to Turn off Supply" value="<?php echo set_value('permisturnoffsup', (isset($roles['permisturnoffsup'])) ? $roles['permisturnoffsup'] : ''); ?>" />
                			<?php echo form_error('permisturnoffsup', '<div class="form-error">', '</div>'); ?>
                			<div class="clearfix"></div>
                			<label>Signed<span class="mandatory"> *</span></label>
							<input type="text" class="form-control" name="valvesigned" placeholder="" value="<?php echo set_value('valvesigned', (isset($roles['valvesigned'])) ? $roles['valvesigned'] : ''); ?>" />
                			<?php echo form_error('valvesigned', '<div class="form-error">', '</div>'); ?>
                		</div>
					</div>

					<div class="form-group clearfix">
						<div class="col-sm-4">
							<label>Location of Valve On Site (Building No.)<span class="mandatory"> *</span></label>
							<input type="text" class="form-control" name="locValSite" placeholder="Enter Location of Valve On Site" value="<?php echo set_value('locValSite', (isset($roles['locValSite'])) ? $roles['locValSite'] : ''); ?>" />
                			<?php echo form_error('locValSite', '<div class="form-error">', '</div>'); ?>
                		</div>
						<div class="col-sm-4">
							<label>Accessibility & Clearances<span class="mandatory"> *</span></label>
							<input type="text" class="form-control" name="access_clearan" placeholder="Enter Accessibility & Clearances" value="<?php echo set_value('access_clearan', (isset($roles['access_clearan'])) ? $roles['access_clearan'] : ''); ?>" />
                			<?php echo form_error('access_clearan', '<div class="form-error">', '</div>'); ?>
                		</div>
                		<div class="col-sm-4">
							<label>Time of Turn Off<span class="mandatory"> *</span></label>
							<input type="text" class="form-control timepicker" name="timeofturnoff" placeholder="Enter Time of Turn Off" value="<?php echo set_value('timeofturnoff', (isset($roles['timeofturnoff'])) ? $roles['timeofturnoff'] : ''); ?>" />
                			<?php echo form_error('timeofturnoff', '<div class="form-error">', '</div>'); ?>
                		</div>
					</div>

					<div class="form-group clearfix">
						<div class="col-sm-4">
							<label>Installation Company (If Known)<span class="mandatory"> *</span></label>
							<input type="text" class="form-control" name="installcom" placeholder="Enter Installation Company" value="<?php echo set_value('installcom', (isset($roles['installcom'])) ? $roles['installcom'] : ''); ?>" />
                			<?php echo form_error('installcom', '<div class="form-error">', '</div>'); ?>
                			<div class="clearfix"></div>
                			<label>Tel<span class="mandatory"> *</span></label>
							<input type="text" class="form-control" name="installcomtel" placeholder="" value="<?php echo set_value('installcomtel', (isset($roles['installcomtel'])) ? $roles['installcomtel'] : ''); ?>" />
                			<?php echo form_error('installcomtel', '<div class="form-error">', '</div>'); ?>
                		</div>
						<div class="col-sm-4">
							<label>Unobstructed Drain Air Gap<span class="mandatory"> *</span></label>
							<input type="text" class="form-control" name="unodraingap" placeholder="Enter Unobstructed Drain Air Gap" value="<?php echo set_value('unodraingap', (isset($roles['unodraingap'])) ? $roles['unodraingap'] : ''); ?>" />
                			<?php echo form_error('unodraingap', '<div class="form-error">', '</div>'); ?>
                		</div>
                		<div class="col-sm-4">
							<label>Meter Reading (If appilicable)<span class="mandatory"> *</span></label>
							<input type="text" class="form-control" name="meeterreading" placeholder="Enter Meter Reading" value="<?php echo set_value('meeterreading', (isset($roles['meeterreading'])) ? $roles['meeterreading'] : ''); ?>" />
                			<?php echo form_error('meeterreading', '<div class="form-error">', '</div>'); ?>
                		</div>
					</div>
					<div class="form-group clearfix">
						<div class="col-sm-4">
							<label>Type of Plant/Equip Being Supplied<span class="mandatory"> *</span></label>
							<input type="text" class="form-control" name="typlasupp" placeholder="Enter Type of Plant/Equip Being Supplied" value="<?php echo set_value('typlasupp', (isset($roles['typlasupp'])) ? $roles['typlasupp'] : ''); ?>" />
	            			<?php echo form_error('typlasupp', '<div class="form-error">', '</div>'); ?>
	            		</div>
						<div class="col-sm-4">
							<label>Strainer Present<span class="mandatory"> *</span></label>
							<input type="text" class="form-control" name="strainpresent" placeholder="Enter Strainer Present" value="<?php echo set_value('strainpresent', (isset($roles['strainpresent'])) ? $roles['strainpresent'] : ''); ?>" />
	            			<?php echo form_error('strainpresent', '<div class="form-error">', '</div>'); ?>
	            		</div>
	            		<div class="col-sm-4">
							<label>Valve Installation Date<span class="mandatory"> *</span></label>
							<input type="text" class="form-control datepicker" name="valinsdate" placeholder="Enter Valve Installation Date" value="<?php echo set_value('valinsdate', (isset($roles['valinsdate'])) ? $roles['valinsdate'] : ''); ?>" />
	            			<?php echo form_error('valinsdate', '<div class="form-error">', '</div>'); ?>
	            		</div>
	            	</div>
					<div class="form-group clearfix">
						<div class="col-sm-4">
							<label>Isolating Valve No.2 Tight<span class="mandatory"> *</span></label>
							<input type="text" class="form-control" name="isovaltight" placeholder="Enter Isolating Valve No.2 Tight" value="<?php echo set_value('isovaltight', (isset($roles['isovaltight'])) ? $roles['isovaltight'] : ''); ?>" />
                			<?php echo form_error('isovaltight', '<div class="form-error">', '</div>'); ?>
                		</div>
						<div class="col-sm-4">
							<label>Commissioning Date (1st Test)<span class="mandatory"> *</span></label>
							<input type="text" class="form-control datepicker" name="strainpresent" placeholder="Enter Commissioning Date" value="<?php echo set_value('comm1stdate', (isset($roles['comm1stdate'])) ? $roles['comm1stdate'] : ''); ?>" />
                			<?php echo form_error('comm1stdate', '<div class="form-error">', '</div>'); ?>
                		</div>
					</div>

					<hr>


					<div class="form-group clearfix">
						<div class="col-sm-12">
							<table class="table table-bordered table-striped">
								<thead>
									<tr>
										<th>&nbsp;</th>
										<th>Check Valve 1</th>
										<th>Relief Value</th>
										<th>Check Valve 2</th>
										<th>Check Valve 1</th>
										<th>Check Valve 2</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<th>Initial Test</th>
										<td>
											<div class="checkbox">
											  <label><input type="checkbox" value="" name="check1initaltest[]">Closed</label>
											</div>
											<div class="checkbox">
											  <label><input type="checkbox" value="" name="check1initaltest[]">Tight Leaked</label>
											</div>
										</td>
										<td>Opened at <input type="text" class="form-control" name="check1openedat" placeholder="" value="<?php echo set_value('check1openedat', (isset($roles['check1openedat'])) ? $roles['check1openedat'] : ''); ?>" /> Bar</td>
										<td><div class="checkbox">
											  <label><input type="checkbox" value="" name="check2initaltest[]">Closed</label>
											</div>
											<div class="checkbox">
											  <label><input type="checkbox" value="" name="check2initaltest[]">Tight Leaked</label>
											</div></td>
										<td>Differential Pressure <input type="text" class="form-control" name="check1diifpressure" placeholder="" value="<?php echo set_value('check1diifpressure', (isset($roles['check1diifpressure'])) ? $roles['check1diifpressure'] : ''); ?>" /> Bar</td>
										<td>Differential Pressure <input type="text" class="form-control" name="check2diifpressure" placeholder="" value="<?php echo set_value('check2diifpressure', (isset($roles['check2diifpressure'])) ? $roles['check2diifpressure'] : ''); ?>" /> Bar</td>
									</tr>
									<tr>
										<th>Repairs & Materials Used</th>
										<td colspan="5"><textarea class="form-control" name="repair_materials"></textarea></td>
									</tr>
									<tr>
										<th>Test After Repair</th>
										<td>
											<div class="checkbox">
											  <label><input type="checkbox" value="" name="check1_1initaltest[]">Tight</label>
											</div>
											<div class="checkbox">
											  <label><input type="checkbox" value="" name="check1_1initaltest[]">Leaked</label>
											</div>
										</td>
										<td>Opened at <input type="text" class="form-control" name="check1_1openedat" placeholder="" value="<?php echo set_value('check1_1openedat', (isset($roles['check1_1openedat'])) ? $roles['check1_1openedat'] : ''); ?>" /> Bar</td>
										<td><div class="checkbox">
											  <label><input type="checkbox" value="" name="check2_1initaltest[]">Tight</label>
											</div>
											<div class="checkbox">
											  <label><input type="checkbox" value="" name="check2_1initaltest[]">Leaked</label>
											</div></td>
										<td>Differential Pressure <input type="text" class="form-control" name="check1_1diifpressure" placeholder="" value="<?php echo set_value('check1_1diifpressure', (isset($roles['check1_1diifpressure'])) ? $roles['check1_1diifpressure'] : ''); ?>" /> Bar</td>
										<td>Differential Pressure <input type="text" class="form-control" name="check2_1diifpressure" placeholder="" value="<?php echo set_value('check2_1diifpressure', (isset($roles['check2_1diifpressure'])) ? $roles['check2_1diifpressure'] : ''); ?>" /> Bar</td>
									</tr>
									</tr>
								</tbody>
							</table>
                		</div>
					</div>

					<div class="form-group clearfix">
						<div class="col-sm-12">
							<label>Comments<span class="mandatory"> *</span></label>
							<textarea class="form-control" name="comments" ><?php echo set_value('comments', (isset($roles['comments'])) ? $roles['comments'] : ''); ?></textarea>
                			<?php echo form_error('comments', '<div class="form-error">', '</div>'); ?>
						</div>
					</div>


					

					<div class="form-group clearfix">
						<div class="col-sm-4">
							<label>Testers Name<span class="mandatory"> *</span></label>
							<input type="text" class="form-control" name="testersname" placeholder="Enter Testers Name" value="<?php echo set_value('testersname', (isset($roles['testersname'])) ? $roles['testersname'] : ''); ?>" />
	            			<?php echo form_error('testersname', '<div class="form-error">', '</div>'); ?>
	            		</div>
						<div class="col-sm-4">
							<label>Testers No.<span class="mandatory"> *</span></label>
							<input type="text" class="form-control" name="testersno" placeholder="Enter Testers Number" value="<?php echo set_value('testersno', (isset($roles['testersno'])) ? $roles['testersno'] : ''); ?>" />
	            			<?php echo form_error('testersno', '<div class="form-error">', '</div>'); ?>
	            		</div>
	            		<div class="col-sm-4">
							<label>Signed<span class="mandatory"> *</span></label>
							<input type="text" class="form-control" name="testersigned" placeholder="" value="<?php echo set_value('valinsdate', (isset($roles['testersigned'])) ? $roles['testersigned'] : ''); ?>" />
	            			<?php echo form_error('testersigned', '<div class="form-error">', '</div>'); ?>
	            		</div>
	            	</div>

	            	<div class="form-group clearfix">
						<div class="col-sm-4">
							<label>Turn On Time<span class="mandatory"> *</span></label>
							<input type="text" class="form-control timepicker" name="turnontme" placeholder="Enter Turn On Time" value="<?php echo set_value('turnontme', (isset($roles['turnontme'])) ? $roles['turnontme'] : ''); ?>" />
	            			<?php echo form_error('turnontme', '<div class="form-error">', '</div>'); ?>
	            		</div>
						<div class="col-sm-4">
							<label>Date of Completion<span class="mandatory"> *</span></label>
							<input type="text" class="form-control datepicker" name="dtecompletion" placeholder="" value="<?php echo set_value('dtecompletion', (isset($roles['dtecompletion'])) ? $roles['dtecompletion'] : ''); ?>" />
	            			<?php echo form_error('dtecompletion', '<div class="form-error">', '</div>'); ?>
	            		</div>
	            		<div class="col-sm-4">
							<label>Date of Next Date<span class="mandatory"> *</span></label>
							<input type="text" class="form-control datepicker" name="dtenextdate" placeholder="" value="<?php echo set_value('dtenextdate', (isset($roles['dtenextdate'])) ? $roles['dtenextdate'] : ''); ?>" />
	            			<?php echo form_error('dtenextdate', '<div class="form-error">', '</div>'); ?>
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
