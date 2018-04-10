<?php $currentpage=$this->uri->segment(1); ?>

<?php 
	//if(($currentpage!='login')&&($currentpage==''))
	{
		?>
		
	<footer class="page_footer">
 
            <div class="large-12 text-center footer-text">
                        © <?php echo date('Y'); ?> Balcomm Limited. All rights reserved. 1A Stoke Gardens, Slough, Berks, SL1 3QB.<br>Design and Developed By Parklane Consultants Ltd United Kingdom. 
                    </div>
        
 </footer>
 <?php
	}
 ?>
</section>
 </section> 
    </section>	
	</section>
<div class="hidden" style="display:none"><img src="<?php echo base_url('assets/images/loader.gif'); ?>"></div>
	<!-- Bootstrap -->
	
	<!-- <script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script> -->
    <!-- App -->
    <script src="<?php echo base_url(); ?>assets/js/app.v1.js" type="text/javascript"></script>

    <!-- fuelux -->
    <script src="<?php echo base_url(); ?>assets/js/libs/underscore-min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/js/fuelux/fuelux.js" type="text/javascript"></script>
    <!-- <script src="<?php echo base_url(); ?>assets/js/datatables/jquery.dataTables.min.js"></script> -->
	<!--<script type="text/javascript" src="<?php //echo base_url('/assets/js/jquery.js');?>"></script>-->
	<script src="<?php echo base_url(); ?>assets/js/jquery.dataTables.min.js" type="text/javascript"></script>
	<script src="<?php echo base_url(); ?>assets/js/dataTables.bootstrap.min.js" type="text/javascript"></script>
	<script src="<?php echo base_url(); ?>assets/js/dataTables.responsive.min.js" type="text/javascript"></script>
	<script src="<?php echo base_url(); ?>assets/js/responsive.bootstrap.min.js" type="text/javascript"></script>
	
	<!--<script src="<?php echo base_url(); ?>assets/js/dataTables.bootstrap.min.js"></script>	
	<script src="<?php echo base_url(); ?>assets/js/dataTables.responsive.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/responsive.bootstrap.min.js"></script>-->
	
	
    <script src="<?php echo base_url(); ?>assets/js/datatables/demo.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/js/app.plugin.js" type="text/javascript"></script>
	<script src="<?php echo base_url(); ?>assets/js/toastr.min.js" type="text/javascript"></script>
	<script src="<?php echo base_url(); ?>assets/js/bootbox.js" type="text/javascript"></script>
	<script src="<?php echo base_url(); ?>assets/js/jquery.inputmask.bundle.min.js" type="text/javascript"></script>
	<script src="<?php echo base_url(); ?>assets/js/moment.min.js" type="text/javascript"></script>

	<script src="<?php echo base_url(); ?>assets/js/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
	<script src="<?php echo base_url(); ?>assets/js/bs_leftnavi.js" type="text/javascript"></script>	
	<script src="<?php echo base_url(); ?>assets/js/bootstrap-toggle.min.js" type="text/javascript"></script>
	<!--<script src="<?php echo base_url(); ?>assets/js/jquery-sortable.js" type="text/javascript"></script>-->
	
	<script src="<?php echo base_url(); ?>assets/js/jquery-ui.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/jquery.ui.touch-punch.min.js"></script>


	<?php
		if(($this->uri->segment(2)=='adduser')||($this->uri->segment(2)=='edituser')||($this->uri->segment(2)=='addcustomer')||($this->uri->segment(2)=='editcustomer')||($this->uri->segment(2)=='timeSheet'))
		{
	?>
		<script src="<?php echo base_url(); ?>assets/js/signature_pad.min.js" type="text/javascript"></script>
		<script src="<?php echo base_url(); ?>assets/js/sign-app.js" type="text/javascript"></script>
	<?php
		}
	?>

	
	<script src="<?php echo base_url(); ?>assets/js/fileinput.min.js" type="text/javascript"></script>
	<!--<script src="<?php echo base_url(); ?>assets/themes/explorer/theme.js" type="text/javascript"></script>-->

	<script src="<?php echo base_url(); ?>assets/js/custom.js" type="text/javascript"></script>
	<script src="<?php echo base_url(); ?>assets/js/panel-filter.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/js/jquery.multiselect.js"></script>

    
<script type="text/javascript">

/******Jquery Code To change the readonly option when click on enable or disable radio button*********/
$( function() {

	/******When Clicked on Enable*********/
	$("input:radio[value=1]").click( function(){
		$("form[name='adduser']").find('input, textarea, select, button, option').each(function(){
   		$(this).attr({
   			'readonly':false,
   			'disabled':false
   			});
		});
		$("a:contains('Add New'), button:contains('Add Row'), button:contains('Add New')").each(function(){
			$(this).css("pointer-events", "");
		})
		$("div.form-control.file-caption.file-caption-disabled.kv-fileinput-caption").removeClass('file-caption-disabled');

		$("div.btn.btn-primary.btn-file").attr('disabled', false);
	})

	/******When Clicked on Disable*********/
	$("input:radio[value=0]").click( function() {
		$("form[name='adduser']").find('input, textarea, select, button, option').each( function(){
   		$(this).attr({
   			'readonly':true,
   			'disabled':true
   			});
		});
		$("a:contains('Add New'), button:contains('Add Row'), button:contains('Add New')").each(function(){
			$(this).css("pointer-events", "none");
		});
		$("div.form-control.file-caption.kv-fileinput-caption").addClass('file-caption-disabled');
		$("div.btn.btn-primary.btn-file").attr('disabled', true);
	})
})
</script>		
</body>
</html>