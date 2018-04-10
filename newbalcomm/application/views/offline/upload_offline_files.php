
<style type="text/css">
	.alert-dismissable .close, .alert-dismissible .close {
    position: relative;
    top: -2px;
     right: 0px !important;
     color: #2e3e4e !important;
}
</style>
<section class="vbox">
	<section class="scrollable padder">
		<section class="panel panel-default">
		<?php
			if ($this->session->flashdata('success_message') != '')
			{
				echo '<div class="alert2 alert-success text-center alert-dismissible" style="width:100%;"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>' . $this->session->flashdata('success_message') . '</div><br>';
				$this->session->set_flashdata('success_message', '');
			}
			if ($this->session->flashdata('failed_message') != '')
			{
				echo '<div class="alert2 alert-danger text-center alert-dismissible" style="width:100%;"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>' . $this->session->flashdata('failed_message') . '</div><br>';
				$this->session->set_flashdata('failed_message', '');
			}
			?>
			<header class="panel-heading"><b><?php echo $title; ?></b> </header>
			<div class="panel-body">
			<form method="POST" name="adduser" class="addusernew" id="adduserform" action="" enctype="multipart/form-data">
				<div class="row">
					<br><br>
					<div class=" form-group clearfix">

						<div class="col-sm-6 col-sm-offset-4">
							<label for="offline_file" style="float: left;margin:0px 10px;">Upload Json Data Files</label>
							<!-- <input type="file" name="offline_file[]" id="offline_file" onchange="onFileSelected(event)" multiple="" required="" onchange="return checkImages();"> -->
							<input type="file" name="offline_file[]" id="offline_file"  multiple="" required="" onchange="return checkImages();">
						</div>
					
				</div>
			</div>
			<br>

				<!-- <div class="row">
						<div class="">
							<div>
								<div class=" form-group clearfix">
									<div class="col-sm-4">
										<label>Project Id<span class="mandatory"> *</span></label>
										<input class="form-control number" type="text" name="project_id" id="project_id" placeholder="Project Id" />
			                <?php echo form_error('companyname', '<div class="form-error">', '</div>'); ?> 
									</div>
									<div class="col-sm-4">
										<label>Process Name<span class="mandatory"> *</span></label>
										<input class="form-control " type="text" name="process_name" placeholder="Process Name" id="process_name" />
			                <?php echo form_error('phone', '<div class="form-error">', '</div>'); ?>
									</div>
									<div class="col-sm-4">
										<label>System Id<span class="mandatory"> *</span></label>
										<input class="form-control number" type="text" name="system_id" id="system_id" placeholder="System Id" value="" />
			                <?php echo form_error('mobile', '<div class="form-error">', '</div>'); ?>
									</div>
								</div>
								<div class="form-group clearfix">
														
									<div class="col-sm-4">
										<label>Engineer Id<span class="mandatory"> *</span></label>
										<input class="form-control number" type="text" name="engineer_id"  id="engineer_id" placeholder="Engineer Id" />
			                <?php echo form_error('email', '<div class="form-error">', '</div>'); ?>
									</div>
									<div class="col-sm-4">
										<label>Date<span class="mandatory"> *</span></label>
										<input type="text" name="date_added" id="date_added" class="datepicker form-control" >
										
			                <?php echo form_error('address', '<div class="form-error">', '</div>'); ?>
									</div>
									
								</div>
							</div>
							
						</div>

				</div> -->
				<footer class="panel-footer text-right bg-light lter"> 
					<input type="hidden" name="existid" value="<?php echo $this->uri->segment(3); ?>" />
					<input type="submit" name="submit" value="Submit" class="btn btn-success btn-s-xs submit-btn addnew center">
					<input type="reset" name="cancel" value="Cancel" class="btn btn-danger btn-s-xs submit-btn cancel center">
				</footer>
			</form>
			</div>
			
		</section>
	</section>
</section>

  <!-- Modal content-->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal">&times;</button>
      <h4 class="modal-title" style="color: red;">Please select files of type text/plain only</h4>
    </div>
    
    <div class="modal-footer">
      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    </div>
  </div>
</div>
</div>

<script type="text/javascript">

	function checkImages(){
        var allowed_file_types = ['text/plain'];
            var files = document.getElementById("offline_file").files;
            for (var i = 0; i < files.length; i++)
            {
                 if(allowed_file_types.indexOf(files[i].type) != -1)
                 {

                 }else{
                    document.getElementById("offline_file").value = '';
                    $('#myModal').modal('show');
                    //alert('Please select only files of type text/plain');
                    return false;
                 }  
            }
        }
//   function onFileSelected(event) {
//   var selectedFile = event.target.files[0];
//   var reader = new FileReader();


//   reader.onload = function(event) {
//     var res = JSON.parse(event.target.result);
//     for(i=0;i<res.length;i++){
//     	if(res[i].name =='project_name'){
//     		$("#project_id").val(res[i].value[0]);
//     	}

//     	if(res[i].name =='process_name_offline'){
//     		$("#process_name").val(res[i].value[0]);
//     	}

//     	if(res[i].name =='projsystem'){
//     		$("#system_id").val(res[i].value[0]);
//     	}

//     	if(res[i].name =='commairreptenggsign'){
//     		$("#engineer_id").val(res[i].value[0]);
//     	}

//     	if(res[i].name =='commairreptenggdate'){
//     		$("#date_added").val(res[i].value[0]);
//     	}


//     }
//     var urllll = "<?php ?>"

//     var action_url = "<?php echo base_url()."projects/";?>";
//     action_url+= $("#process_name").val()+'/';
   
//     //$("#adduserform").attr('action', action_url);
//     /*console.log(res);
//     console.log(res[0].value[0]);
//     console.log(res[1].value[0]);
//     console.log(res[3].value[0]);
//     console.log(res[92].value[0]);*/
//   };

//   reader.readAsText(selectedFile);
// }
</script>
