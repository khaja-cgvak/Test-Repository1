<style>
#verify-data-btn.disabled { cursor: not-allowed !important; }
</style>
<section class="vbox">
	<section class="scrollable padder">
		<section class="panel panel-default">
		<?php
			if ($this->session->flashdata('success_message') != '')
			{
				echo '<div class="alert2 alert-success text-center" style="width:100%;">' . $this->session->flashdata('success_message') . '</div><br>';
				$this->session->set_flashdata('success_message', '');
			}
			?>
			<header class="panel-heading"><b><?php echo $title; ?></b> </header>
			<div class="panel-body">
			<form method="POST" name="adduser" class="addusernew" id="adduserform" action="" enctype="multipart/form-data">
						<div class="">
							<div>
								<div class=" form-group clearfix">
								<center><h4>Offline Form Details</h4></center>
									<div class="col-sm-4">
										<label>Project Name<span class="mandatory"> *</span></label>
										<input class="form-control" type="text" name="project_name" id="project_name" placeholder="Project Name" onchange="changeJsonData(this)"/>		                
									</div>
									<div class="col-sm-4">
										<label>System Name<span class="mandatory"> *</span></label>
										<input class="form-control" type="text" name="projsystem" id="projsystem" placeholder="System Name" value="" onchange="javascript:changeJsonData(this)"/>	                
									</div>
									<div class="col-sm-4">
										<label>Process Name<span class="mandatory"> *</span></label>
										<input class="form-control " type="text" name="process_name" placeholder="Process Name" id="process_name" />
			               
									</div>
									
								</div>
								<div class="form-group clearfix">
										<div class="col-sm-4">
										<label>Ref<span class="mandatory"> *</span></label>
										<input class="form-control number" type="text" name="reportref"  id="reportref" placeholder="Reference" onchange="changeJsonData(this)"/>              
									</div>				
									<div class="col-sm-4">
										<label>Engineer Name<span class="mandatory"> *</span></label>
										<input class="form-control" type="text" name="commairreptenggsign"  id="commairreptenggsign" placeholder="Engineer Name" onchange="changeJsonData(this)"/>
			                
									</div>
									<div class="col-sm-4">
										<label>Date<span class="mandatory"> *</span></label>
										<input type="text" name="commairreptenggdate" id="commairreptenggdate" class="datepicker form-control" >
										<input type="hidden" name="hidden_json_data" id="hidden_json_data">
										<input type="hidden" name="function_accessible_json" id="function_accessible_json">
									</div>
									
									
								</div>
								<div class="form-group clearfix">
									<div class="col-sm-4">
										<label>URL</label>
										<input type="text" name="post_url" id="post_url" class="form-control" readonly="true">	
									</div>
									<div class="col-sm-4 pull-right">
									<input type="hidden" name="existid" value="<?php echo $this->uri->segment(3); ?>" />
									<button type="button"  class="btn btn-info btn-s-xs submit-btn disabled" id="verify-data-btn" data-json-file-id="">Verify Data</button>
					<input type="submit"  name="submit" value="Submit" class="btn btn-success btn-s-xs submit-btn addnew disabled">
					<input type="reset" name="cancel" value="Cancel" class="btn btn-danger btn-s-xs submit-btn cancel">
					
									</div>
							</div>

							
						</div>

				</div>
				<hr>
				<div class="row offline-row">

					<center id="offline-center"><h4>Offline Files List</h4></center>
					<table class="table table-striped m-b-none table-bordered dt-responsive nowrap" id="offline_data_table" width="100%">
					
				<thead>
						<tr>
							<th>File Name</th>
							<!-- <th>Form Name</th>
							<th>Form Id</th> -->
							<th>Uploaded By</th>
							<th>Uploaded Date</th>
							<th>Import Status</th>
							<th>Select To Import</th>
							<th>Action</th>						
						</tr>
					</thead>
					<tbody>
						<?php foreach($json_log as $row){?>
						<tr>
							<td><?= $row['file_name'];?></td>
							<!-- <td><?= $row['form_name'];?></td>
							<td><?= $row['form_id'];?></td> -->
							<td><?= $row['name'];?></td>
							<td><?= $row['uploaded_date'];?></td>
							<td><?php echo ($row['is_imported']==1 ? 'Yes' : 'No');?></td>
							<td><input type="radio" name="selected_radio" value="<?= $row['file_name'];?>" json_file_id="<?=$row['id'];?>"></td>
							<td><a href="javascript:void(0)" data-id="<?= $row['id']?>" class="delete_json_file" data-toggle="tooltip" title="" data-original-title="Delete File"><i class="fa fa-times" aria-hidden="true"></i></a></td>
						</tr>
						<?php } ?>
					</tbody>					
				</table>
			</div>
						</div>

			</form>
			</div>
			<footer class="panel-footer text-right bg-light lter"> 
					
				</footer>
			
		</section>
	</section>
</section>
<script type="text/javascript">
	window.onload = function(){
			$("#offline_data_table").DataTable();
			/**Reading json data from the uploaded file when click on the radio button */
			$("input:radio[name='selected_radio']").click( function(e) {
				$.get('<?php echo base_url()."uploads/json_files/";?>'+e.target.value, function(data) {
					$("#function_accessible_json").val(data);
							var dataObj = JSON.parse(data);
				   			$("#project_name").val(dataObj.project_name);
				   			$("#process_name").val(dataObj.process_name_offline);
				   			$("#projsystem").val(dataObj.projsystem);
				   			$("#commairreptenggsign").val(dataObj.commairreptenggsign);
				   			$("#commairreptenggdate").val(dataObj.commairreptenggdate);
				   			$("#reportref").val(dataObj.reportref);
							$("#verify-data-btn").attr('data-json-file-id', e.target.getAttribute('json_file_id'));
							$("#verify-data-btn").removeClass('disabled');
													
					 }, 'text');
			}
		);

		$("#verify-data-btn").click(function(e){
			var dataObj =JSON.parse($("#function_accessible_json").val());//Set for using json data in other functions
			$.ajax({
				url:"<?php echo base_url().'OfflineData/checkValidNames';?>",
				method:"post",
				data:{'project_name':dataObj.project_name, 'system_name':dataObj.projsystem,'engineer_name':dataObj.commairreptenggsign, 'process_slug':dataObj.process_slug},
				success:function(res){ 
					console.log(res);
					res = JSON.parse(res);
					if(res.status == 'success'){
						/*********** Replacing Names wih ids *******/
						dataObj.project_name = res.data.project_id;
						dataObj.projsystem = res.data.system_id;
						dataObj.commairreptenggsign = res.data.engineer_id;
						dataObj.json_file_id = e.target.getAttribute('data-json-file-id');
						/*********** End of Replacing Names wih ids *******/
						var hidden_json_data = JSON.stringify(dataObj);
						$("#post_url").val(res.data.post_url);
						$("#adduserform").attr('action', res.data.post_url);
						$("#hidden_json_data").val(hidden_json_data);/** setting Json Data to be sent to the controller function */
						$("input[name='submit']").removeClass('disabled');
					}
					else{
						alert('Invalid Details Entered in Offline Form for either of Project Name or System Name or Engineer Name');
					}
				}
			})
		})
		
	}
	/***Changing Json values on changing the input values in the form */
	function changeJsonData(e){
		var dataObj =JSON.parse($("#function_accessible_json").val());
		 var propertyid = e.id;
		 dataObj[propertyid] = e.value;
		 dataObj = JSON.stringify(dataObj);
		 $("#function_accessible_json").val(dataObj);
		 $("#verify-data-btn").click();
	}	
</script>
