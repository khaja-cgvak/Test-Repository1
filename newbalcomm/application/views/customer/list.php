<section class="vbox">
	<section class="scrollable padder">
		<section class="panel panel-default">
			<header class="panel-heading">
				<div class="row clearfix"><div class="col-sm-6 col-xs-6 text-left"><b> Customer List </b></div><div class="col-sm-6 col-xs-6 text-right"><a href="<?php echo site_url('customer/addcustomer'); ?>"><i class="fa fa-plus-square-o" aria-hidden="true"></i>
<b>Add Customer</b></a></div>
			</header>
			<?php
			if ($this->session->flashdata('success_message') != '')
				echo '<div class="alert2 alert-success text-center" style="width:100%;">' . $this->session->flashdata('success_message') . '</div>';
			?>
			<div class="table-responsive">
				<table class="table table-striped m-b-none table-bordered dt-responsive nowrap" width="100%" id="customerlist_tables">
					<thead>
						<tr>
							<th width="19%">Customer Name</th>
							<th width="19%">Address</th>
							<th width="19%">Email</th>
							<th width="19%">Website</th>							
							<th width="10%">Status</th>
							<th width="14%">Action</th>
						</tr>
					</thead>
                    					
				</table>
			</div>
		</section>
	</section>
</section>