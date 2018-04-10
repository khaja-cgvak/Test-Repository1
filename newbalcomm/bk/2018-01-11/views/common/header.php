<!DOCTYPE html>
<html lang="en" class="app">
<?php $currentpage=trim($this->uri->segment(1)); ?>
<head>
    <meta charset="utf-8" />
    <title>Balcomm Ltd</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
	
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/font.css" type="text/css" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/animate.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/js/calendar/bootstrap_calendar.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/app.v1.css" type="text/css" />
	<!--<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" type="text/css" />-->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/custom.css" type="text/css" />
	
    <!--<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/css/skin2.css" type="text/css" />-->	
	
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/dataTables.bootstrap.min.css" type="text/css" /> 
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/responsive.bootstrap.min.css" type="text/css" />
	
    <!--<link rel="stylesheet" href="<?php echo base_url(); ?>assets/js/datatables/datatables.css" type="text/css" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/dataTables.bootstrap.min.css" type="text/css" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/responsive.bootstrap.min.css" type="text/css" /> -->
	
	
	
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/toastr.min.css" type="text/css" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap-datetimepicker.min.css" type="text/css" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bs_leftnavi.css" type="text/css" />
	
	<?php
		if(($this->uri->segment(2)=='addprojects')||($this->uri->segment(2)=='editprojects'))
		{
	?>
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/panel-filter.css" type="text/css" />
	<?php
	}
	?>
	
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap-toggle.min.css" type="text/css" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/fileinput.min.css" type="text/css" />
	<!--<link href="<?php echo base_url(); ?>assets/themes/explorer/theme.css" media="all" rel="stylesheet" type="text/css"/>-->
    <link href="<?php echo base_url(); ?>assets/css/jquery.multiselect.css" media="all" rel="stylesheet" type="text/css"/>


	<script type="text/javascript">
	var base_url="<?php echo base_url(); ?>";
	var initPreviewfile=[];
	var initPreviewfileconfig=[];
	</script>
    <!--[if lt IE 9]> 
        <script src="js/ie/html5shiv.js"></script> 
        <script src="js/ie/respond.min.js"></script> 
        <script src="js/ie/excanvas.js"></script> 
    <![endif]-->
</head>

<body class="">
    <section class="vbox">
	<?php 
	#echo 'currentpage='.$currentpage;
if(($currentpage=='login')||($currentpage==''))
	{
		?>
		<header class="bg-dark dk header navbar navbar-fixed-top-xs">
			<div class="text-center">
				<a class="btn btn-link visible-xs navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar"> <i class="fa fa-bars"></i> </a>
				<a href="<?php echo base_url(); ?>" class="navbar-brand">Balcomm Ltd</a>
				<a class="btn btn-link visible-xs" data-toggle="dropdown" data-target=".nav-user"> <i class="fa fa-cog"></i> </a>
			</div>
		</header>
		<?php
	}
	else
	{
?>
		<header class="bg-dark dk header navbar navbar-fixed-top-xs">
			<div class="navbar-header aside-md">
				<a class="btn btn-link visible-xs navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar"> <i class="fa fa-bars"></i> </a>
				<a href="<?php echo base_url(); ?>" class="navbar-brand">Balcomm Ltd</a>
				<a class="btn btn-link visible-xs" data-toggle="dropdown" data-target=".nav-user"> <i class="fa fa-cog"></i> </a>
			</div>
			<div id="navbar" class="navbar-collapse collapse navbar-left">
                <ul class="nav navbar-nav ">
                	<li><a class="<?php if($currentpage=="home") { echo 'active'; } ?>" href="<?php echo site_url('home'); ?>"><i class="fa fa-tachometer icon"> </i>Dashboard</a></li>
                    <li id="company"><a class="<?php if($currentpage=="company") { echo 'active'; } ?>" href="<?php echo site_url('company'); ?>"><i class="fa fa-building-o icon"></i> Company</a></li>
					<li id="role"><a class="<?php if($currentpage=="roles") { echo 'active'; } ?>" href="<?php echo site_url('roles'); ?>"><i class="fa fa-male icon"> </i> User Roles</a></li>
                    <li id="users"><a class="<?php if($currentpage=="users") { echo 'active'; } ?>" href="<?php echo site_url('users'); ?>"><i class="fa fa-user-circle-o icon"> </i> Users</a></li>
                    <li id="customer"><a class="<?php if($currentpage=="customer") { echo 'active'; } ?>" href="<?php echo site_url('customer'); ?>"><i class="fa fa-users icon"> </i> Customer</a></li>
                    <li id="projects"><a class="<?php if($currentpage=="projects") { echo 'active'; } ?>" href="<?php echo site_url('projects'); ?>"><i class="fa fa-tasks icon"> </i> Projects</a></li>
                    <li id="reports"><a class="<?php if($currentpage=="reports") { echo 'active'; } ?>" href="<?php echo site_url('reports'); ?>"><i class="fa fa-bar-chart icon"> </i>Report</a></li>
                    <li id="export"><a class="<?php if($currentpage=="exports") { echo 'active'; } ?>" href="<?php echo site_url('exports'); ?>"><i class="fa fa-bar-chart icon"> </i>Exports</a></li>                        
                    <!-- <li><a class="<?php if($currentpage=="settings") { echo 'active'; } ?>" href="#"><i class="fa fa-cogs icon"> </i>Settings</a></li> -->
                </ul>
            </div>
			<ul class="nav navbar-nav navbar-right m-n hidden-xs nav-user">
				<li>
					<a href="<?php echo base_url('cusers/edituser/'.$this->Common_model->encodeid($this->session->userdata('userid'))); ?>">Welcome <?php echo $this->session->userdata('firstname').' '.$this->session->userdata('lastname'); ?> </a>
				</li>
				<li>
					<a href="<?php echo site_url('login/logout'); ?>">Logout</a>
				</li>
			</ul>
		</header>
<?php
	}
	#echo '<pre>'; print_r($this->session); echo '</pre>';
?><div class="clearifx"></div>
	<section>
	<section class="hbox stretch">
	<?php 
	/*if(($currentpage=='login')||($currentpage==''))
	{
	}
	else{
		$this->load->view('common/sidenav');
	}*/

	if(!isset($sidemenu))
	{
		$sidemenu='';	
	}
	if(!isset($custom_side_menu))
	{
		$custom_side_menu='';	
	}


	
	if(($currentpage!='')&&($sidemenu!='hide')&&($custom_side_menu==''))
	{
		$view_nav =($currentpage).'/'.($currentpage).'_nav.php';
		//echo $view_nav;
		if(file_exists(APPPATH."views/".$view_nav)){
		   $this->load->view($view_nav);
		}
	}
	elseif (isset($custom_side_menu)&&(!empty($custom_side_menu))) {
		$view_nav =($currentpage).'/'.($custom_side_menu).'.php';
		//echo $view_nav;
		if(file_exists(APPPATH."views/".$view_nav)){
		   $this->load->view($view_nav);
		}
	}
	else
	{

	}
		?>
		
		
                <section id="content">
                <?php
                if($this->uri->segment(1)=='projects')
                {
					if ($this->session->flashdata('project_message') != '')
					{
						echo '<div class="alert2 alert-success text-center" style="width:100%;">' . $this->session->flashdata('project_message') . '</div>';
					}
				}
				?>
				<?php
				
				#echo '<pre>'; print_r($_SERVER); echo '</pre>';
				?>