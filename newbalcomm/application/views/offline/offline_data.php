<link href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.css" rel="stylesheet" />
<link href="https://cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.css" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.4.2/js/buttons.html5.min.js"></script>
<style type="text/css">
#offline_data_table_wrapper .dt-buttons{
	position: relative;
    float: right;
    margin-left: -372px;
    margin-right: 220px;
    margin-top: 10px;
    text-align: center;
}
	
</style>
<section class="vbox">
	<section class="scrollable padder">
		<section class="panel panel-default">
			<header class="panel-heading"><b><?php echo $title; ?></b></header>
			<div class="">
				<table class="table table-striped m-b-none table-bordered dt-responsive nowrap" id="offline_data_table" width="100%">
					<thead>
						<tr>
							<th width="12%">Project Id</th>
							<th width="15%">Project Name</th>
							<th width="27%">System Details<br>(System Name:System Id)</th>
							<th width="27%">User Details<br>(User Name:User Id)</th>						
						</tr>
					</thead>
					<tbody>
						<?php foreach($total_data as $row){?>
						<tr>
							<td><?= $row['projectid'];?></td>
							<td><?= $row['projectname'];?></td>
							<td><?php foreach(explode(",",$row['systems']) as $arr){ echo $arr.'<br>';} ;?></td>
							<td><?php foreach(explode(",",$row['users']) as $arr){ echo $arr.'<br>';} ;?></td>
						</tr>
						<?php } ?>
					</tbody>					
				</table>
			</div>
		</section>
	</section>
</section>
<script type="text/javascript">	
			$("#offline_data_table").DataTable({
			    dom: 'Blftip',
			    buttons: [{
			      extend: 'pdf',
			      text:'<i class="fa fa-download" aria-hidden="true"></i>  Download PDF',
			      title: 'Offline Data',
			      filename: 'offline_data',
			      orientation: 'landscape',
                  pageSize: 'LEGAL'
			    }]
		});


</script>

