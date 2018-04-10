<section class="vbox">
	<div class="scrollable padder">
	<form action="" method="post" name="forgetpassword" class="forgetpassword" id="forgetpassword"> <br><br><br><br><br>
	<div class="col-md-4 col-md-offset-4">
	<?php 
                    if (isset($email_error) && $email_error !='')
                    {
                        echo '<div width="100%" class="alert alert-danger">' . $email_error . '</div><br/>';
                    }
            
            ?>
          <?php    if($this->session->flashdata('success_message'))
                    {
                            $msg = $this->session->flashdata('success_message');
                            echo '<div width="100%" style="height:50px;" class="alert alert-success">' . $msg . '</div><br/>';
                            //$this->session->unset_userdata('success_message'); 
                    }
                    ?>
             <?php echo form_error('useremail', '<div class="alert alert-danger">', '</div><br/>'); ?>
	
		<div class="form-group">
			<label class="sr-only" for="balcomm_name">Email ID</label>
			<div class="input-group">
			  <div class="input-group-addon"><i class="fa fa-key"></i></div>
			  <input class="form-control" type="text" name="useremail" value="<?php echo set_value('useremail'); ?>" placeholder="Enter Email ID">
			  <!--<div class="input-group-addon">.00</div>-->
			</div>
		</div>
		<div class="form-group text-center">
			<input type="submit" name="submit"  class="btn btn-success btn-lg addnew" value="Submit"> 
			<input type="submit" class="btn btn-danger btn-lg cancel" name="cancel" value="Cancel">
		</div>
	</div>
		</form>
	</section>
</div>