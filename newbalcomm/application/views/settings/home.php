<section class="vbox">
    <section class="scrollable padder">
        <section class="panel panel-default">
            <header class="panel-heading">
            	<div class="row clearfix">
            		<div class="col-sm-6 col-xs-6 text-left"><strong><?php echo $title; ?> </strong></div>
            		<div class="col-sm-6 col-xs-6 text-right">
            			<a href="<?php echo site_url('settings/adddyform'); ?>"><i class="fa fa-plus-square-o" aria-hidden="true"></i>&nbsp;<strong>Add Form</strong></a>
            		</div>
            	</div>
			</header>
            <div class="panel-body">
            <?php
            	$sql="";
            ?>
                <table class="table table-bordered table-striped" id="dyformdatalist">
                	<thead>
                		<tr>
                			<th>Process Name</th>                			
                			<th>Section</th>                			
                			<th>Option Name</th>
                			<th>Sorting</th>
                			<th>Action</th>
                		</tr>
                	</thead>
                	<tbody>
                		<tr>
                			<td>Process Name</td>
                			<td>Section</td>                			
                			<td>Option Name</td>
                			<td>Sorting</td>
                			<td>Action</td>
                		</tr>
                		<tr>
                			<td>Process Name</td>
                			<td>Section</td>                			
                			<td>Option Name</td>
                			<td>Sorting</td>
                			<td>Action</td>
                		</tr>
                	</tbody>
                </table>
            </div>
        </section>
    </section>
</section>