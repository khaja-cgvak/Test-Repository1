<section class="vbox">
	<section class="scrollable padder">
		<section class="panel panel-default">
			<header class="panel-heading">
				<div class="row clearfix"><div class="col-sm-6 col-xs-6 text-left"><b> <?php echo $title; ?> </b></div><div class="col-sm-6 col-xs-6 text-right"><a href="<?php echo site_url('exports/crereport/'.$proid); ?>"><i class="fa fa-plus-square-o" aria-hidden="true"></i>
<b>Create Report</b></a></div></div>
			</header>
			<?php
			if ($this->session->flashdata('project_message') != '')
				echo '<div class="alert2 alert-success text-center" style="width:100%;">' . $this->session->flashdata('project_message') . '</div>';
			?>
			<div class="">
				<input type="hidden" name="projectid" id="projectid" value="<?php echo $proid; ?>">
				<table class="table table-striped m-b-none table-bordered dt-responsive nowrap" id="reportlist_project" width="100%">
					<thead>
						<tr>
							<th width="30%">Created Date</th>
							<th width="30%">Created By</th>
							<th width="30%">Customer<br>Name</th>							
							<th width="10%">Action</th>
						</tr>
					</thead>					
				</table>
			</div>
		</section>
	</section>
</section>