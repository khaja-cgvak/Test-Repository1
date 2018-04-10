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
										<label>Project Name<span class="mandatory"> *</span><span id="proj_name_offline_selected" class="pull-right"></span></label>
										<!-- <input class="form-control" type="text" name="project_name" id="project_name" placeholder="Project Name" onchange="changeJsonData(this)"/>		                 -->
										<select name="project_name" id="project_name" class="form-control" onchange="projChange(this);changeJsonData(this)">
											<option value="">Select Project Name</option>
											<?php foreach($projects as $project){?>
												<option value="<?= $project['projectname'];?>" ><?=$project['projectname']?></option>
											<?php } ?>
										</select>
									</div>
									<div class="col-sm-4">
										<label>System Name<span class="mandatory"> *</span><span id="system_name_offline_selected" class="pull-right"></span></label>
										<!-- <input class="form-control" type="text" name="projsystem" id="projsystem" placeholder="System Name" value="" onchange="javascript:changeJsonData(this)"/>	                 -->
										<select name="projsystem" id="projsystem" class="form-control" onchange="changeJsonData(this)">
										<option value="">Slect System</option>
										</select>
									</div>
									<div class="col-sm-4" style="display:none">
										<label>Water Supplier<span class="mandatory"> *</span><span id="watersupp_offline_selected" class="pull-right"></span></label>
										<select class="form-control watersupp" name="watersupp" id="watersupp" data-alt="valvesigned" data-id="valvesignedimg">
											<option value="">Please Select</option>
											<?php
											$valvesigned='';
											if($userall->num_rows()>0)
											{
												$userall_data=$userall->result_array();
												foreach ($userall_data as $ud_key => $ud_value) {
												echo '<option  value="'.$ud_value['userid'].'">'.$ud_value['firstname'].' '.$ud_value['lastname'].'</option>';
												}
											}
											?>
										</select>
									</div>
									<div class="col-sm-4" style="display:none">
									<label>Testers Name<span class="mandatory"> *</span><span id="testername_offline_selected" class="pull-right"></span></label>
									<select class="form-control testername" name="testername" id="testername" data-alt="testersign" data-id="testersignimg">
										<option value="">Please Select</option>
										<?php
										if($userall->num_rows()>0)
										{
											$userall_data=$userall->result_array();
											foreach ($userall_data as $ud_key => $ud_value) {
											echo '<option  value="'.$ud_value['userid'].'">'.$ud_value['firstname'].' '.$ud_value['lastname'].'</option>';
											}
										}
										?>
									</select>
									</div>	
									<div class="col-sm-4">
										<label>Process Name<span class="mandatory"> *</span></label>
										<input class="form-control " type="text" name="process_name" placeholder="Process Name" id="process_name" readonly/>
			               
									</div>
									<div class="col-sm-12" id="uploaddiv" style="display:none">
										<br>
                                             <label><strong>Upload File:</strong><span class="mandatory"> *</span></label>
                                             <input type="file" name="uploadfile[]" id="imgInp" multiple required>
                                    </div>
									
								</div>
								<div class="form-group clearfix">
										<div class="col-sm-4">
										<label>Ref<span class="mandatory"> *</span></label>
										<input class="form-control" type="text" name="reportref"  id="reportref" placeholder="Reference" onchange="changeJsonData(this)"/>              
									</div>
									
												
									<div class="col-sm-4">
										<label>Engineer Name<span class="mandatory"> *</span><span id="engineer_name_offline_selected" class="pull-right"></span></label>
										<!-- <input class="form-control" type="text" name="commairreptenggsign"  id="commairreptenggsign" placeholder="Engineer Name" onchange="changeJsonData(this)"/> -->
			                			<select class="form-control" name="commairreptenggsign" id="commairreptenggsign" onchange="changeJsonData(this)" <?php if(isset($sidemenu_sub_enable)) { if(($sidemenu_sub_enable)==0) { echo 'readonly="true"'; }  } ?>>
                      <option value="">Please Select</option>
                      <?php
                        $commairreptenggsign=0;
                        if(isset($_POST['commairreptenggsign']))
                        {
                          $commairreptenggsign=$this->input->post('commairreptenggsign');
                        }
                        elseif(isset($prcdata['engineerid']))
                        {
                          $commairreptenggsign=$prcdata['engineerid'];
                        }
                        else
                        {

                        }
                                                if(isset($sidemenu_sub_enable)) 
                        { 
                          if(($sidemenu_sub_enable)==0) 
                          { 
                          $enabled = 'disabled'; 
                          }  
                          else
                          {
                          $enabled = ''; 
                          }
                        }                         
                        if(!empty($engdata))
                        {
                          foreach ($engdata as $eng_key => $eng_value) {
                            $selected='';
                            if(($eng_value['userid']==$commairreptenggsign))
                            {
                              $selected=' selected="selected" ';
                            }
                            echo '<option '.$enabled.' value="'.$eng_value['userid'].'" '.$selected.'>'.$eng_value['firstname'].' '.$eng_value['lastname'].'</option>';
                          }
                        }
                      ?>
                    </select>
                            <?php echo form_error('commairreptenggsign', '<div class="form-error">', '</div>'); ?>
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
							console.log(dataObj);
							$("#commairreptenggsign").parent().show();
								$("#commairreptenggdate").parent().show();
							if(dataObj.process_slug=='commAir'|| dataObj.process_slug=='commWater' || dataObj.process_slug=='waterTreatmentSysWitCer'){	
								$("#commairreptenggsign").parent().hide();
								$("#commairreptenggdate").parent().hide();
							}
							if(dataObj.process_slug == 'waterTreatmentTempcer'){
								$("#projsystem").parent().hide();
							}
							if(dataObj.process_slug == 'rpz'){
								$("#projsystem").parent().hide();
								$("#commairreptenggdate").parent().hide();
								$("#commairreptenggsign").parent().hide();
								$("#watersupp").parent().show();
								$("#testername").parent().show();

								 $("#watersupp_offline_selected").text('  ----->  '+dataObj.watersupp);
							   	 $("#testername_offline_selected").text('  ----->  '+dataObj.testername);
							}
							if(dataObj.process_name_offline == 'System Schematic'){
								$("#uploaddiv").css('display', 'block');
							}
							else{
								$("#uploaddiv").css('display', 'none');
								$("#imgInp").removeAttr('required');
							}
							   $("#proj_name_offline_selected").text('  ----->  '+dataObj.project_name);
							   $("#system_name_offline_selected").text('  ----->  '+dataObj.projsystem);
							   if(dataObj.commairreptenggsign != '' && dataObj.commairreptenggsign != undefined){
									$("#engineer_name_offline_selected").text('  ----->  '+dataObj.commairreptenggsign);
							   }
				   			$("#process_name").val(dataObj.process_name_offline);
				   			//$("#projsystem").val(dataObj.projsystem);
				   			//$("#commairreptenggsign").val(dataObj.commairreptenggsign);
				   			$("#commairreptenggdate").val(dataObj.commairreptenggdate);
				   			$("#reportref").val(dataObj.reportref);
							$("#verify-data-btn").attr('data-json-file-id', e.target.getAttribute('json_file_id'));
							$("#verify-data-btn").removeClass('disabled');
													
					 }, 'text');
			}
		);

		$("#verify-data-btn").click(function(e){
			var dataObj =JSON.parse($("#function_accessible_json").val());//Set for using json data in other functions

			var ajaxPostObj = {'project_name':dataObj.project_name, 'system_name':dataObj.projsystem,
				'engineer_name':dataObj.commairreptenggsign, 'process_slug':dataObj.process_slug,'reportref':dataObj.reportref};

				if(dataObj.process_slug == 'rpz'){
					ajaxPostObj.testername = dataObj.testername;
					ajaxPostObj.watersupp = dataObj.watersupp;
				}

			$.ajax({
				url:"<?php echo base_url().'OfflineData/checkValidNames';?>",
				method:"post",
				data:ajaxPostObj,
				success:function(res){ 
					console.log(res);
					res = JSON.parse(res);
					if(res.status == 'success'){
						/*********** Replacing Names wih ids *******/
						dataObj.project_name = res.data.project_id;
						dataObj.projsystem = res.data.system_id;
						dataObj.commairreptenggsign = res.data.engineer_id;
						dataObj.json_file_id = e.target.getAttribute('data-json-file-id');
						if(dataObj.process_slug == 'rpz'){
							dataObj.testername = res.data.tester_id;
							dataObj.watersupp = res.data.watersupp_id;
							dataObj.testersign = '';
						}
						/*********** End of Replacing Names wih ids *******/
						var hidden_json_data = JSON.stringify(dataObj);
						$("#post_url").val(res.data.post_url);
						$("#adduserform").attr('action', res.data.post_url);
						$("#hidden_json_data").val(hidden_json_data);/** setting Json Data to be sent to the controller function */
						$("input[name='submit']").removeClass('disabled');
					}
					else if(res.status == 'failed1'){
						alert("Reference Already Exists");
					}
					else{
						alert('Invalid Details Entered in Offline Form for either of Project Name or System Name or Engineer Name');
					}
				}
			})
		})
		
	}
	/***Changing Json values on changing the input values in the form */
	function changeJsonData(e) {
		var dataObj =JSON.parse($("#function_accessible_json").val());
		console.log(dataObj);
		 var propertyid = e.id;
		 dataObj[propertyid] = e.value;
		 dataObj = JSON.stringify(dataObj);
		 $("#function_accessible_json").val(dataObj);
		 console.log(JSON.parse($("#function_accessible_json").val()));
		 //$("#verify-data-btn").click();
	}

	function projChange(e){
		var project_id = e.value;
		if(project_id !='' && project_id!= 'null'){
			$.ajax({
				method:"POST",
				url:"<?php echo base_url().'OfflineData/getSystemsnEngineersByProjName/';?>"+project_id,
				success:function(res){
					var res = JSON.parse(res);
					var systems = res.systems_list;
					var engineers = res.engineers_list;
					//console.log(systems);
					//console.log(engineers);
					$('#projsystem').find('option').not(':first').remove();
					$.each(systems,function(index,data){
						$('#projsystem').append('<option value="'+data.systemname+'">'+data.systemname+'</option>');
					});
					$("#commairreptenggsign").find('option').not(':first').remove();
					$.each(engineers,function(index,data){
						$('#commairreptenggsign').append('<option value="'+data.name+'">'+data.name+'</option>');
					});
				}
			})
		}
	}	
</script>
