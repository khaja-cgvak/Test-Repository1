<section class="vbox">
	<section class="scrollable padder">
		<section class="panel panel-default">
			<header class="panel-heading"><b><?php echo $title; ?></b> </header>
			<div class="panel-body">
			<form method="POST" name="adduser" action="" class="addusernew">
				<div class="row">
					<div class="form-group clearfix">
						<div class="col-sm-4">
							<strong>Project Name: </strong> <?php echo $projdata['projectname']; ?>
						</div>
						<div class="col-sm-4">
							<strong>Project Start Date: </strong> <?php echo date('d M, Y',strtotime($projdata['projectstartdate'])); ?>
						</div>
						<div class="col-sm-4">
							<strong>Project Proposed End Date: </strong> <?php echo date('d M, Y',strtotime($projdata['projectenddate'])); ?>
						</div>
						
					</div>
					<div class="form-group clearfix">
						<div class="col-sm-4">
							<strong>Client Name: </strong> <?php echo $projdata['userincharge']; ?>
						</div>
						<div class="col-sm-4">
							<strong>Project Description: </strong> <?php echo $projdata['projectdescription']; ?>
						</div>					
						<div class="col-sm-4">
							<strong>Active: </strong> <?php echo (($projdata['isactive'] == 1)?"Yes":"No"); ?>
						</div>
					</div>

				</div>
				<!--<footer class="panel-footer text-right bg-light lter"> 
					<input type="hidden" name="existid" value="<?php echo $this->uri->segment(3); ?>" />
					<input type="submit" name="submit" value="Submit" class="btn btn-success btn-s-xs submit-btn addnew">
					<input type="submit" name="cancel" value="Cancel" class="btn btn-danger btn-s-xs submit-btn cancel">
				</footer>-->
			</form>
			</div>
			
		</section>
	</section>
</section>