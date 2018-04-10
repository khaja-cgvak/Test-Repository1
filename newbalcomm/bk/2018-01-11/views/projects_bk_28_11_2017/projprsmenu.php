<?php
if(!isset($sidemenu_sub_active))
{
	$sidemenu_sub_active='';
}

$proidnew=($this->uri->segment(3)); 
?>
<aside class="bg-dark lter aside-lg hidden-print" id="nav">
	<section class="vbox">
		<section class="w-f scrollable">
			<div class="slim-scroll" data-height="auto" data-disable-fade-out="true" data-distance="0" data-size="5px" data-color="#333333">
				<!-- nav -->
				<nav class="nav-primary">
					<ul class="gw-nav gw-nav-list">
						<?php
							$processcat=$this->Common_model->getProcessCat();
							if($processcat->num_rows()!=0)
							{
								$processcat_data=$processcat->result_array();
								foreach ($processcat_data as $key => $value) {
									$link1='javascript:void(0)';
									if($value['slug'])
									{
										$link1=site_url('projects/'.$value['slug'].'/'.$proidnew);
									}
									$processlist=$this->Common_model->getProcessLstByPrcat($value['id']);
									$processlist_data=$processlist->result_array();
									//print_r($processlist_data);
									if(($processlist->num_rows()==0)&&empty($value['slug']))
									{
										$link1='javascript:void(0)';
									}
									$parent_active='';
									if(($this->uri->segment(2)==$value['slug'])&&$value['slug']!="") { 
										$parent_active='active';
									}
									if($processlist->num_rows()==1)									
									{
										$link1=site_url('projects/'.$processlist_data[0]['slug'].'/'.$proidnew);

										if(($this->uri->segment(2)==$processlist_data[0]['slug'])&&$processlist_data[0]['slug']!="") { 
											$parent_active='active';
										}

									}
									?>
									<li class="init-arrow-down processcarnavli <?php echo $parent_active; ?>" data-id="<?php echo $value['id']; ?>" id="processcarnavli_<?php echo $value['id']; ?>"> <a href="<?php echo $link1; ?>"><i class="fa fa-angle-right"></i><span class="gw-menu-text"><?php echo $value['processcategory']; ?></span><span class="pull-right processcarnav processcar_<?php echo $key; ?>">&nbsp;</span><span class="clearfix"></span></a>
											<?php
												if($processlist->num_rows()>1)
												{
											?>
											<ul class="gw-submenu processcarnavul" data-id="<?php echo $value['id']; ?>" id="processcarnavul_<?php echo $value['id']; ?>">
												<?php
													foreach ($processlist_data as $key1 => $value1) {	
														$link2='javascript:void(0)';
														if($value1['slug'])
														{   $enabled = urlencode(base64_encode($value1['isenabled']));
															$link2=site_url('projects/'.$value1['slug'].'/'.$proidnew.'/'.$enabled);
														}
														if(($value1['isenabled'])==1) 
														{ 
													      $backgroundColor='style="background-color:#D4ED91;"';
														}  
   													    else
														{ 
													     $backgroundColor='style="background-color:#FFEFD5;"';
														}
												?>
								          		<li <?php echo $backgroundColor; ?> data-id="<?php echo $value1['id']; ?>" data-name="Item <?php echo $value1['id']; ?>" id="item-<?php echo $value1['id']; ?>"> <a href="<?php echo $link2; ?>" class="<?php if($this->uri->segment(2)==$value1['slug']) { echo 'active_a';} ?>"><?php echo $value1['processtitle']; ?></a> </li>
								          		<?php
								          			}
								          		?>
								          	</ul>
								          	<?php
								          	}
								          	?>
									</li>
									<?php
								}
							}
						?>
					</ul>
				</nav>
				<!-- / nav 9240107 -->
			</div>
		</section>
		<footer class="footer lt hidden-xs b-t b-dark">
			<a href="#nav" data-toggle="class:nav-xs" class="pull-right btn btn-sm btn-dark btn-icon"> <i class="fa fa-angle-left text"></i> <i class="fa fa-angle-right text-active"></i> </a>
		</footer>
	</section>
</aside>