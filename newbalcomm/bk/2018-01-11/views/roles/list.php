<section class="vbox">
	<section class="scrollable padder">
		<section class="panel panel-default">
			<header class="panel-heading">
				<div class="row clearfix"><div class="col-sm-6 col-xs-6 text-left"><b> <?php echo $title; ?> </b></div><div class="col-sm-6 col-xs-6 text-right"><a href="<?php echo site_url('roles/addroles'); ?>"><i class="fa fa-plus-square-o" aria-hidden="true"></i>
<b>Add User Role</b></a></div>
			</header>
			<?php
			if ($this->session->flashdata('success_message') != '')
				echo '<div class="alert2 alert-success text-center" style="width:100%;">' . $this->session->flashdata('success_message') . '</div>';
			?>
			<div class="">
				<table class="table table-striped m-b-none table-bordered dt-responsive nowrap" id="userroles_tables" width="100%">
					<thead>
						<tr>
							<th width="25%">Roles Name</th>
							<th width="25%">Roles Description</th>
							<th width="25%">Status</th>
							<th width="25%">Action</th>
						</tr>
					</thead>					
				</table>
			</div>
		</section>
	</section>
</section>