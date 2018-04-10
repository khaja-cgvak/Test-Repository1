<?php
if(!isset($sidemenu_sub_active))
{
	$sidemenu_sub_active='';
}
?>
<aside class="bg-dark lter aside-md hidden-print" id="nav">
	<section class="vbox">
		<section class="w-f scrollable">
			<div class="slim-scroll" data-height="auto" data-disable-fade-out="true" data-distance="0" data-size="5px" data-color="#333333">
				<!-- nav -->
				<nav class="nav-primary">
					<ul class="nav">
						<li class="<?php if($sidemenu_sub_active=='settings'){ echo 'active'; }; ?>"">
							<a href="<?php echo site_url('settings'); ?>"> <i class="fa fa-angle-right"></i><span>Dynamic Form Options</span> </a>
						</li>
					</ul>
				</nav>
				<!-- / nav -->
			</div>
		</section>
		<footer class="footer lt hidden-xs b-t b-dark">
			<a href="#nav" data-toggle="class:nav-xs" class="pull-right btn btn-sm btn-dark btn-icon"> <i class="fa fa-angle-left text"></i> <i class="fa fa-angle-right text-active"></i> </a>
		</footer>
	</section>
</aside>