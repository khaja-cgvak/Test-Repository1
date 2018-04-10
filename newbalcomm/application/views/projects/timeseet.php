<section class="vbox">
	<section class="scrollable padder">
		<section class="panel panel-default">
			<header class="panel-heading"><b><?php echo $title; ?></b> </header>
			<div class="panel-body">
			<form method="POST" name="adduser" action="" class="addusernew">
				<div class="row">

					<div class="form-group clearfix">
						<div class="col-sm-3"><strong>Project:</strong> <?php echo $prodata['projectname']; ?></div>
						<div class="col-sm-3"><strong>Ref:</strong> <?php echo $prodata['id']; ?></div>
						<div class="col-sm-3"><strong>Client:</strong> Customer Name</div>
						<div class="col-sm-3"><strong>Sheet:</strong> 1 of 1</div>
					</div>

					<div class="form-group clearfix">
						<div class="col-sm-12">
							<table class="table table-bordered table-striped">
								<thead>
									<tr>
										<th class="text-center">Day</th>
										<th class="text-center">Date</th>
										<th class="text-center">Hours</th>
										<th class="text-center">Engineers Name</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<th>Monday</th>
										<td><input type="text" class="form-control datepicker" name="day1" value="<?php echo set_value('day1', (isset($roles['day1'])) ? $roles['day1'] : ''); ?>" /></td>
										<td><input type="text" class="form-control" name="hours1" value="<?php echo set_value('hours1', (isset($roles['hours1'])) ? $roles['hours1'] : ''); ?>" /></td>
										<td><input type="text" class="form-control" name="engineer1" value="<?php echo set_value('engineer1', (isset($roles['engineer1'])) ? $roles['engineer1'] : ''); ?>" /></td>
									</tr>
									<tr>
										<th>Tuesday</th>
										<td><input type="text" class="form-control datepicker" name="day2" value="<?php echo set_value('day2', (isset($roles['day2'])) ? $roles['day2'] : ''); ?>" /></td>
										<td><input type="text" class="form-control" name="hours2" value="<?php echo set_value('hours2', (isset($roles['hours2'])) ? $roles['hours2'] : ''); ?>" /></td>
										<td><input type="text" class="form-control" name="engineer2" value="<?php echo set_value('engineer2', (isset($roles['engineer2'])) ? $roles['engineer2'] : ''); ?>" /></td>
									</tr>
									<tr>
										<th>Wednesday</th>
										<td><input type="text" class="form-control datepicker" name="day3" value="<?php echo set_value('day3', (isset($roles['day3'])) ? $roles['day3'] : ''); ?>" /></td>
										<td><input type="text" class="form-control" name="hours3" value="<?php echo set_value('hours3', (isset($roles['hours3'])) ? $roles['hours3'] : ''); ?>" /></td>
										<td><input type="text" class="form-control" name="engineer3" value="<?php echo set_value('engineer3', (isset($roles['engineer3'])) ? $roles['engineer3'] : ''); ?>" /></td>
									</tr>
									<tr>
										<th>Thursday</th>
										<td><input type="text" class="form-control datepicker" name="day4" value="<?php echo set_value('day4', (isset($roles['day4'])) ? $roles['day4'] : ''); ?>" /></td>
										<td><input type="text" class="form-control" name="hours4" value="<?php echo set_value('hours4', (isset($roles['hours4'])) ? $roles['hours4'] : ''); ?>" /></td>
										<td><input type="text" class="form-control" name="engineer4" value="<?php echo set_value('engineer4', (isset($roles['engineer4'])) ? $roles['engineer4'] : ''); ?>" /></td>
									</tr>
									<tr>
										<th>Friday</th>
										<td><input type="text" class="form-control datepicker" name="day5" value="<?php echo set_value('day5', (isset($roles['day5'])) ? $roles['day5'] : ''); ?>" /></td>
										<td><input type="text" class="form-control" name="hours5" value="<?php echo set_value('hours5', (isset($roles['hours5'])) ? $roles['hours5'] : ''); ?>" /></td>
										<td><input type="text" class="form-control" name="engineer6" value="<?php echo set_value('engineer6', (isset($roles['engineer6'])) ? $roles['engineer6'] : ''); ?>" /></td>
									</tr>
									<tr>
										<th>Saturday</th>
										<td><input type="text" class="form-control datepicker" name="day6" value="<?php echo set_value('day6', (isset($roles['day6'])) ? $roles['day6'] : ''); ?>" /></td>
										<td><input type="text" class="form-control" name="hours6" value="<?php echo set_value('hours6', (isset($roles['hours6'])) ? $roles['hours6'] : ''); ?>" /></td>
										<td><input type="text" class="form-control" name="engineer6" value="<?php echo set_value('engineer6', (isset($roles['engineer6'])) ? $roles['engineer6'] : ''); ?>" /></td>
									</tr>
									<tr>
										<th>Sunday</th>
										<td><input type="text" class="form-control datepicker" name="day7" value="<?php echo set_value('day7', (isset($roles['day7'])) ? $roles['day7'] : ''); ?>" /></td>
										<td><input type="text" class="form-control" name="hours7" value="<?php echo set_value('hours7', (isset($roles['hours7'])) ? $roles['hours7'] : ''); ?>" /></td>
										<td><input type="text" class="form-control" name="engineer7" value="<?php echo set_value('engineer7', (isset($roles['engineer7'])) ? $roles['engineer7'] : ''); ?>" /></td>
									</tr>

								</tbody>
							</table>
						</div>
					</div>
					<div class="form-group clearfix">
						<div class="col-sm-12">
							<label>Comments/Description:</label>
							<textarea class="form-control" name="comments"><?php echo set_value('comments', (isset($roles['comments'])) ? $roles['comments'] : ''); ?></textarea>
						</div>
					</div>
					<div class="form-group clearfix">
						<div class="col-sm-4">
							<label>Clients Signature<span class="mandatory"> *</span></label>
							<input type="text" class="form-control" name="clntsign" placeholder="" value="<?php echo set_value('clntsign', (isset($roles['clntsign'])) ? $roles['clntsign'] : ''); ?>" />
                			<?php echo form_error('clntsign', '<div class="form-error">', '</div>'); ?>
						</div>
						<div class="col-sm-4">
							<label>Position<span class="mandatory"> *</span></label>
							<input type="text" class="form-control" name="clntposition" placeholder="" value="<?php echo set_value('clntposition', (isset($roles['clntposition'])) ? $roles['clntposition'] : ''); ?>" />
                			<?php echo form_error('clntposition', '<div class="form-error">', '</div>'); ?>
						</div>
						<div class="col-sm-4">
							<label>Date<span class="mandatory"> *</span></label>
							<input type="text" class="form-control datepicker" name="clntdate" placeholder="" value="<?php echo set_value('clntdate', (isset($roles['clntdate'])) ? $roles['clntdate'] : ''); ?>" />
                			<?php echo form_error('clntdate', '<div class="form-error">', '</div>'); ?>
						</div>
					</div>
					<div class="form-group clearfix">
						<div class="col-sm-4">
							<label>Engineer:<span class="mandatory"> *</span></label>
							<input type="text" class="form-control" name="enggsign" placeholder="" value="<?php echo set_value('enggsign', (isset($roles['enggsign'])) ? $roles['enggsign'] : ''); ?>" />
                			<?php echo form_error('enggsign', '<div class="form-error">', '</div>'); ?>
						</div>
						<div class="col-sm-4">
							<label>Date<span class="mandatory"> *</span></label>
							<input type="text" class="form-control datepicker" name="enggdate" placeholder="" value="<?php echo set_value('enggdate', (isset($roles['enggdate'])) ? $roles['enggdate'] : ''); ?>" />
                			<?php echo form_error('enggdate', '<div class="form-error">', '</div>'); ?>
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
