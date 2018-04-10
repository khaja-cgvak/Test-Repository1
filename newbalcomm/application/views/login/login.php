<section class="vbox">
	<div class="scrollable padder">
	<form class="login-form" id="login-form" action="" method="post">
	<div class="row">
	<?php
                        if($this->session->userdata('error_message'))
                        {
                            echo '<div width="100%" class="alert alert-danger text-center">' . $this->session->userdata('error_message') . '</div>';
                            $this->session->unset_userdata('error_message');
                        }
                        $msg = '';
                        if (isset($login_error))
                        {
                            echo '<div width="100%" class="alert alert-danger text-center">' . $login_error . '</div>';
                        }
                        if ($this->session->userdata('success'))
                        {
                            $msg = $this->session->userdata('success');
                        }
                        if ($msg != '')
                        {
                            ?>
                            <div class="alert alert-success" style="width:90%;text-align:center;margin-right:14px;">
                            <?php echo $msg; $this->session->unset_userdata('success'); ?>
                            </div>
<?php } ?>
	
		<div class="form-group">
			<label class="sr-only" for="balcomm_name">User Name</label>
			<div class="input-group">
			  <div class="input-group-addon"><i class="fa fa-user"></i></div>
			  <input class="form-control" name="username" id="balcomm_name" placeholder="Enter User Name" type="text" value="<?php echo set_value('username', (isset($_COOKIE['remember_username'])) ? $_COOKIE['remember_username'] : ''); ?>"> 
			  <!--<div class="input-group-addon">.00</div>-->
			</div>
		</div>
		
		<div class="form-group">
			<label class="sr-only" for="balcomm_pass">Password</label>
			<div class="input-group">
			  <div class="input-group-addon"><i class="fa fa-lock"></i></div>
			  <input class="form-control" name="password" id="balcomm_pass" placeholder="Enter Password" type="password" value="<?php echo set_value('password', (isset($_COOKIE['remember_userpsw'])) ? $_COOKIE['remember_userpsw'] : ''); ?>">  
			  <!--<div class="input-group-addon">.00</div>-->
			</div>
		</div>		
		<div class="form-group">		
			<label>
			  <input type="checkbox" name="remember" value="1" id="balcomm_remember"  <?php if(isset($_COOKIE['remember_useremail']))  {  echo 'checked="checked"';  } else { echo '';} ?>> Remember Me
			</label>
		</div>
		<div class="form-group">
			<input type="submit" name="submit" class="btn btn-success btn-lg" value="Submit"/> 
		</div>

	</div>
	
	<p class="text-center"><a href="<?php echo site_url('login/forget_password'); ?>">Forgot Password</a><span class="fontawesome-arrow-right">&nbsp;<i class="fa fa-arrow-right"></i></span></p>
		</form>
	</section>
</div>