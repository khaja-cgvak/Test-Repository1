<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();  
		$this->load->model('home/Home_model','CHome');
		
		if (!$this->Common_model->isLoggedIn())
		{
			redirect(base_url()); // login checking
		}
	}
	public function index()
	{
		$this->load->view('common/header');
		$this->load->view('home/home');
		$this->load->view('common/footer');
	}
	public function getallProjects()
        {
        
        $table = PROJECTS;
         
        // Table's primary key
        $primaryKey = 'id';
        $cuser=$this->session->userdata('userid');

        $roleid=$this->session->userdata('userroleid');

        $segarrval='projects/editprojects';
        $ckpermission=$this->Common_model->ckRolePermission($roleid,$segarrval);
        define('ckpermprojedit',$ckpermission);
        
        $segarrval='projects/deleteProject';        
        $ckpermission=$this->Common_model->ckRolePermission($roleid,$segarrval);
        define('ckpermprojdel',$ckpermission);

        $segarrval='projects/projview';
        $ckpermission=$this->Common_model->ckRolePermission($roleid,$segarrval);
        define('ckpermproview',$ckpermission);

        //$this->exitpage('projects/projview');


        $columns = array(
            array( 'db' => 'p.projectname', 'dt' => 0, 'field' => 'projectname','formatter'=>function($d,$row){
                return '<a href="'.site_url('projects/projview/'.$row['id']).'">'.$d.'</a>';
            }),          
            array( 'db' => 'p.projectstartdate',  'dt' => 1, 'field' => 'projectstartdate','formatter' => function( $d, $row ) { return date('d M Y',strtotime($d));}),
            array( 'db' => 'p.projectenddate',  'dt' => 2, 'field' => 'projectenddate','formatter' => function( $d, $row ) { return date('d M Y',strtotime($d));}),
            array( 'db' => 'p.projectdescription',  'dt' => 3, 'field' => 'projectdescription'),
            array( 'db' => 'u.custname',  'dt' => 4, 'field' => 'custname'),
            //array( 'db' => 'p.projectstatus',  'dt' => 5, 'field' => 'projectstatus'),
            /*array( 'db' => 'p.isactive',   'dt' => 5, 'field' => 'isactive','formatter' => function( $d, $row ) {
                    return (($d==1)?'Active':'Inactive');
                }),*/
            array( 'db' => 'p.id',   'dt' => 5, 'field' => 'id','formatter' => function( $d, $row ) {
            	
            	/*
            		0-25	=> progress-bar-danger
            		25-50	=> progress-bar-info
            		50-75	=> progress-bar-warning
            		75-100	=> progress-bar-success
            	*/
            		$action='';
            		$newpid=$this->Common_model->encodeid($d);
            		$percentage=$this->CHome->getProjectPrecentage($d);
            		$percentageclass="progress-bar-danger";
            		$progressclass='';
            		if($percentage>25 and $percentage<=50)
            		{
            			$percentageclass="progress-bar-info";            			
            		}
            		elseif($percentage>50 and $percentage<=75)
            		{
            			$percentageclass="progress-bar-warning";            			
            		}
            		elseif($percentage>75)
            		{
            			$percentage=100;
            			$percentageclass="progress-bar-success";            			
            		}
            		else
            		{
            			$percentageclass="progress-bar-danger";
            		}

            		if(intval($percentage)==0)
            		{
            			$progressclass='color:#333;"';
            		}

            		if(ckpermproview==true)
                    {
                        $action.='<a href="'.site_url('projects/projview/'.$newpid).'"  data-toggle="tooltip"  title="Project Process">';
                    }

                    $action.='<div class="progress" style="margin:10px 0px;">
					  <div class="progress-bar '.$percentageclass.' progress-bar-striped" role="progressbar" role="progressbar" aria-valuenow="70"
					  aria-valuemin="0" aria-valuemax="100" style="width:'.intval($percentage).'%;'.$progressclass.'">&nbsp;&nbsp;'.$percentage.'%&nbsp;&nbsp;</div>
					</div> ';
					if(ckpermproview==true)
                    {
                        $action.='</a>';
                    }
                    return $action;
                })  
        );

        // SQL server connection information
        $sql_details = array(
            'user' => $this->db->username,
            'pass' => $this->db->password,
            'db'   => $this->db->database,
            'host' => $this->db->hostname
        );

        require( DROOT.'/assets/class/ssp.customized.class.php' );
        
        $joinQuery = "FROM `".PROJECTS."` AS `p` JOIN `".CUSTOMER."` AS `u` ON (`u`.`id` = `p`.`userincharge`) ";
        $extraWhere = " p.isdeleted='N' ";  

        if(($roleid!=1)&&($cuser!=1))
        {
	        $joinQuery.= " LEFT JOIN `".PROJURS."` pus ON (`p`.`id`=`pus`.`projid` and `pus`.`userid`=".intval($cuser)." ) ";
	        $extraWhere .= " ANd  `pus`.`userid`=".intval($cuser)." ";   
	    }


        $searchval=$_REQUEST['search']['value'];       
        $extraWhere_add=' AND ';
         
        echo json_encode(
            SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere,'',$extraWhere_add )
        );
        
        
    }
}
