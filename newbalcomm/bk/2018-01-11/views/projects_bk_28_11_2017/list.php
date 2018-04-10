<section class="vbox">
	<section class="scrollable padder">
		<section class="panel panel-default">
			<header class="panel-heading">
				<div class="row clearfix"><div class="col-sm-6 col-xs-6 text-left"><b> <?php echo $title; ?> </b></div><div class="col-sm-6 col-xs-6 text-right"><a href="<?php echo site_url('projects/addprojects'); ?>"><i class="fa fa-plus-square-o" aria-hidden="true"></i>
<b>Add Project</b></a></div></div>
			</header>
			<?php
			if ($this->session->flashdata('success_message') != '')
				echo '<div class="alert2 alert-success text-center" style="width:100%;">' . $this->session->flashdata('success_message') . '</div>';
			?>
			<div class="">
				<table class="table table-striped m-b-none table-bordered dt-responsive nowrap" id="projectlist_tables" width="100%">
					<thead>
						<tr>
							<th width="16%">Project Number</th>
							<!---<th width="16%">Site Name</th>--->
							<th width="16%">Contact Name</th>
							<th width="16%">Customer<br>Name</th>							
							<th width="16%">Project<br>Description</th>
							<th width="10%">Status</th>
							<th width="16%">Project Start Date</th>
							<th width="10%">Action</th>
						</tr>
					</thead>					
				</table>
			</div>
		</section>
	</section>
</section>