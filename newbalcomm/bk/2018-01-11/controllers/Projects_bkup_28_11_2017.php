<?php
error_reporting(0);
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Projects extends CI_Controller {

    protected $tshdays=array(1=>'Monday',2=>'Tuesday',3=>'Wednesday',4=>'Thursday',5=>'Friday',6=>'Saturday',7=>'Sunday');

    public function __construct()
    {
        parent::__construct();
        $this->load->model('projects/Projects_model','MProject');

        if (!$this->Common_model->isLoggedIn())
            redirect(base_url('')); // login checking

        
    }

    //Load Home page
    public function index()
    {
        //check_user_permission(array(1)); // check user permission
        
        $data = array();
        //$data['template'] = 'roles/list';
        $data['title'] = 'Project List';
        $this->session->set_userdata('left_submenu', 'projects');
        //$data['rolesdata'] = $this->MProject->getrolesdata();
        
        
		$this->load->view('common/header');
        $this->load->view('projects/list',$data);
		$this->load->view('common/footer');
    }
    public function exitpage($segarrval='')
    {
        $roleid=$this->session->userdata('userroleid');
        $segarr=array($this->uri->segment(1),$this->uri->segment(2));
        if(empty($segarrval))
        {
            $segarrval=implode('/', $segarr);
        }

        $ckpermission=$this->Common_model->ckRolePermission($roleid,$segarrval);
        if($ckpermission==false)
        {
            $data=array();
            $this->load->view('common/header'); 
            $this->load->view('common/permission',$data);
            $this->load->view('common/footer');       
            $this->output->_display();
            exit();
        }
    }
    public function addprojects()
    {
        $this->exitpage();
        $data = array();
        $data['userRoledata']=$this->Common_model->getUserRolesByRoles();
        $data['userroles']=$this->Common_model->getUserRolesById();
        $data['customers']=$this->Common_model->getAllCustomers();
       

        if ($this->input->post('cancel'))
        {
            $path = base_url('projects/'.$this->uri->segment(2).'/');
            redirect($path);
        }
        if ($this->input->post('submit'))
        {            
            $this->form_validation->set_rules('projectname', 'Project Number', 'trim|required');
            //$this->form_validation->set_rules('projectstartdate', 'Project Start Date', 'trim|required');
            //$this->form_validation->set_rules('projectenddate', 'Project Proposed End Date', 'trim|required|callback_compareDate');
            $this->form_validation->set_rules('sitename', 'Site name', 'trim|required');
            $this->form_validation->set_rules('sitecontactname', 'Contact name', 'trim|required');

            $this->form_validation->set_rules('userincharge', 'Customer Name', 'trim|required');
            $this->form_validation->set_rules('assign_users[]', 'Assign Users', 'trim|required');
            $this->form_validation->set_rules('projectdescription', 'Project Description', 'trim|required');
            $this->form_validation->set_rules('status', 'Is acive', 'trim|required');
            //$this->form_validation->set_rules('systemname[]', 'System Name', 'trim|required');

            /*$systemname_ck = $this->input->post('systemname');
            if(!empty($systemname_ck))
            {
                foreach($systemname_ck as $id => $data_ck)
                {
                    $this->form_validation->set_rules('systemname[' . $id . ']', 'System Name', 'required|trim');
                    $this->form_validation->set_rules('companyname[' . $id . ']', 'Company Name', 'required|trim');
                    $this->form_validation->set_rules('companyaddress[' . $id . ']', 'Company Address', 'required|trim');
                    $this->form_validation->set_rules('contractorname[' . $id . ']', 'Services Contractor Name', 'required|trim');
                    $this->form_validation->set_rules('contractoraddress[' . $id . ']', 'Services Contractor Address', 'required|trim');
                    $this->form_validation->set_rules('witnessedny[' . $id . ']', 'Witnessed By', 'required|trim');
                    $this->form_validation->set_rules('witnesseddate[' . $id . ']', 'Date', 'required|trim');
                    $this->form_validation->set_rules('testcmpby[' . $id . ']', 'Test Completed By', 'required|trim');
                    $this->form_validation->set_rules('testcmpdate[' . $id . ']', 'Date', 'required|trim');
                }
            }*/
            
            if ($this->form_validation->run() == TRUE)
            {
                $created_date = date('Y-m-d H:i:s');

                $ins_array = array(
                    'projectname' => $this->input->post('projectname'),
                    'projectstartdate' => date('Y-m-d',strtotime($this->input->post('projectstartdate'))),
                    //'projectenddate' => date('Y-m-d',strtotime($this->input->post('projectenddate'))),
                    'userincharge' => $this->input->post('userincharge'),
                    'siteid' => $this->input->post('sitename'),
                    'contactid' => $this->input->post('sitecontactname'),
                    'projectdescription' => $this->input->post('projectdescription'),
                    'isactive' => $this->input->post('status'),
                    'createdon' => $created_date,
                    'createdby' => $this->session->userdata('userid')
                );
                $this->db->insert(PROJECTS, $ins_array);

                $projid=$this->db->insert_id();
                $ckemtyval=$this->input->post('assign_users');

                if(!empty($ckemtyval))
                {                    
                    foreach ($this->input->post('assign_users') as $asur_key => $asur_value) {
                        $data['assUrsIds'][]=$asur_value;
                        $ins_assusers = array(
                            'projid' => $projid,
                            'userid' => $asur_value
                        );
                        $this->db->insert(PROJURS, $ins_assusers);
                    }
                }
                $ckemtyval=$this->input->post('systemname');

                /*if(!empty($ckemtyval))
                {
                    foreach ($this->input->post('systemname') as $sys_key => $sys_value) {

                        $ins_sys_array= array(
                            'projectid'=>$projid,
                            'systemname'=>$_POST['systemname'][$sys_key],
                            'companyname'=>$_POST['companyname'][$sys_key],
                            'companyaddress'=>$_POST['companyaddress'][$sys_key],
                            'servicecontractorname'=>$_POST['contractorname'][$sys_key],
                            'servicecontractoraddress'=>$_POST['contractoraddress'][$sys_key],
                            'testedby'=>$_POST['testcmpby'][$sys_key],
                            'witnessedby'=>$_POST['witnessedny'][$sys_key],
                            'witnesseddate'=>date('Y-m-d H:i:s',strtotime($_POST['witnesseddate'][$sys_key])),
                            'testedDate'=>date('Y-m-d H:i:s',strtotime($_POST['testcmpdate'][$sys_key])),
                        );
                        $this->db->insert(PRJSYS, $ins_sys_array);

                    }
                }*/


                $this->session->set_flashdata('success_message', 'New Project has been created successfully...');
                $path = base_url('projects') ;
                redirect($path);
            }
        }

        $data['title'] = 'Add New Project'; 

        $data['system_details']=array(
            array(
                    'id'=>0,
                    'projectid'=>0,
                    'systemname'=>'',
                    'companyname'=>'',
                    'companyaddress'=>'',
                    'servicecontractorname'=>'',
                    'servicecontractoraddress'=>'',
                    'testedby'=>0,
                    'witnessedby'=>0,
                    'witnesseddate'=>date(DT_FORMAT),
                    'testedDate'=>date(DT_FORMAT)                        
                )
        );

        if ($this->input->post('submit'))
        {
            $data['system_details']=array();
            $ckemtyval=$this->input->post('systemname');

            if(!empty($ckemtyval))
            {
                foreach ($ckemtyval as $sys_key => $sys_value) {
                    $data['system_details'][]= array(
                        'id'=>0,
                        'projectid'=>0,
                        'systemname'=>$_POST['systemname'][$sys_key],
                        'companyname'=>$_POST['companyname'][$sys_key],
                        'companyaddress'=>$_POST['companyaddress'][$sys_key],
                        'servicecontractorname'=>$_POST['contractorname'][$sys_key],
                        'servicecontractoraddress'=>$_POST['contractoraddress'][$sys_key],
                        'testedby'=>$_POST['testcmpby'][$sys_key],
                        'witnessedby'=>$_POST['witnessedny'][$sys_key],
                        'witnesseddate'=>date('Y-m-d H:i:s',strtotime($_POST['witnesseddate'][$sys_key])),
                        'testedDate'=>date('Y-m-d H:i:s',strtotime($_POST['testcmpdate'][$sys_key])),
                    );
                }
            }
            $ckemtyval=$this->input->post('assign_users');

                if(!empty($ckemtyval))
                {                    
                    foreach ($this->input->post('assign_users') as $asur_key => $asur_value) {
                        $data['assUrsIds'][]=$asur_value;
                    }
                }

        }

        $data['userall']=$this->MProject->getUsers(0);
        $this->load->view('common/header',$data);     
        $this->load->view('projects/add',$data);
        $this->load->view('common/footer');
    }
    public function editprojects()
    {
        $this->exitpage();
        $data=array();
        $proid_new = $this->uri->segment(3);
        $proid = $this->Common_model->decodeid($this->uri->segment(3));
        $projid=$proid;

        if ($this->input->post('cancel'))
        {
            $path = base_url('projects/'.$this->uri->segment(2).'/'.$proidnew);
            redirect($path);
        }
        if ($this->input->post('submit'))
        {
            $this->form_validation->set_rules('projectname', 'Project Number', 'trim|required');
            $this->form_validation->set_rules('sitename', 'Site name', 'trim|required');
            $this->form_validation->set_rules('sitecontactname', 'Contact name', 'trim|required');
            //$this->form_validation->set_rules('projectstartdate', 'Project Start Date', 'trim|required');
            //$this->form_validation->set_rules('projectenddate', 'Project Proposed End Date', 'trim|required|callback_compareDate');
            $this->form_validation->set_rules('userincharge', 'Customer Name', 'trim|required');
            $this->form_validation->set_rules('assign_users[]', 'Assign Users', 'trim|required');
            $this->form_validation->set_rules('projectdescription', 'Project Description', 'trim|required');
            $this->form_validation->set_rules('status', 'Is acive', 'trim|required');

            $systemname_ck = $this->input->post('systemname');
            if(!empty($systemname_ck))
            {
                foreach($systemname_ck as $id => $data_ck)
                {
                    $this->form_validation->set_rules('systemname[' . $id . ']', 'System Name', 'required|trim');
                    $this->form_validation->set_rules('companyname[' . $id . ']', 'Company Name', 'required|trim');
                    $this->form_validation->set_rules('companyaddress[' . $id . ']', 'Company Address', 'required|trim');
                    $this->form_validation->set_rules('contractorname[' . $id . ']', 'Services Contractor Name', 'required|trim');
                    $this->form_validation->set_rules('contractoraddress[' . $id . ']', 'Services Contractor Address', 'required|trim');
                    $this->form_validation->set_rules('witnessedny[' . $id . ']', 'Witnessed By', 'required|trim');
                    $this->form_validation->set_rules('witnesseddate[' . $id . ']', 'Date', 'required|trim');
                    $this->form_validation->set_rules('testcmpby[' . $id . ']', 'Test Completed By', 'required|trim');
                    $this->form_validation->set_rules('testcmpdate[' . $id . ']', 'Date', 'required|trim');
                }
            }

            
            if ($this->form_validation->run() == TRUE)
            {
                $created_date = date('Y-m-d H:i:s');

                $upd_array = array(
                    'projectname' => $this->input->post('projectname'),
                    'projectstartdate' => date('Y-m-d',strtotime($this->input->post('projectstartdate'))),
                    //'projectenddate' => date('Y-m-d',strtotime($this->input->post('projectenddate'))),
                    'siteid' => $this->input->post('sitename'),
                    'contactid' => $this->input->post('sitecontactname'),
                    'userincharge' => $this->input->post('userincharge'),
                    'projectdescription' => $this->input->post('projectdescription'),
                    'isactive' => $this->input->post('status'),
                    'lastmodifiedon' => $created_date,
                    'lastmodifiedby' => $this->session->userdata('userid')
                );

                #echo '<pre>'; print_r($upd_array); echo '</pre>';
                #exit;
                
                $this->db->where('id', $projid);
                $this->db->update(PROJECTS, $upd_array);                

                $this->db->where('projid', $projid);
                $this->db->delete(PROJURS);
                $ckemtyval=$this->input->post('assign_users');
                if(!empty($ckemtyval))
                {
                    foreach ($this->input->post('assign_users') as $asur_key => $asur_value) {
                        $ins_assusers = array(
                            'projid' => $projid,
                            'userid' => $asur_value
                        );
                        $this->db->insert(PROJURS, $ins_assusers);
                    }
                }
                $ckemtyval=$this->input->post('systemname');
                if(!empty($ckemtyval))
                {
                    foreach ($this->input->post('systemname') as $sys_key => $sys_value) {

                        $ins_sys_array=array(
                            'projectid'=>$projid,
                            'systemname'=>$_POST['systemname'][$sys_key],
                            'companyname'=>$_POST['companyname'][$sys_key],
                            'companyaddress'=>$_POST['companyaddress'][$sys_key],
                            'servicecontractorname'=>$_POST['contractorname'][$sys_key],
                            'servicecontractoraddress'=>$_POST['contractoraddress'][$sys_key],
                            'testedby'=>$_POST['testcmpby'][$sys_key],
                            'witnessedby'=>$_POST['witnessedny'][$sys_key],
                            'witnesseddate'=>date('Y-m-d H:i:s',strtotime($_POST['witnesseddate'][$sys_key])),
                            'testedDate'=>date('Y-m-d H:i:s',strtotime($_POST['testcmpdate'][$sys_key])),
                        );
                        if($_POST['systemid'][$sys_key]!=0)
                        {
                            $this->db->where('id', $_POST['systemid'][$sys_key]);
                            $this->db->update(PRJSYS, $ins_sys_array);
                        }
                        else
                        {
                            $this->db->insert(PRJSYS, $ins_sys_array);
                        }
                    }
                }
                $ckemtyval=$this->input->post('systemdelid');
                if(!empty($ckemtyval))
                {
                    foreach ($this->input->post('systemdelid') as $sysdel_key => $sysdel_value) {
                        $sysid=$_POST['systemdelid'][$sysdel_key];
                        $sysidres=$this->MProject->getSystemPrjck($sysid);
                        $sysidrescnt=$sysidres->num_rows();
                        if($sysidrescnt==0)
                        {
                            $inssysdel_array=array(
                                'isdelete'=>'A'
                            );
                            $this->db->where('id',$sysid);
                            $this->db->update(PRJSYS, $inssysdel_array);
                        }
                    }
                }


                $this->session->set_flashdata('success_message', 'The Project has been updated successfully...');
                $path = base_url('projects') ;
                redirect($path);
            }
        }

        $data['proid'] = $proid;
        
        $data['userRoledata']=$this->Common_model->getUserRolesByRoles();
        $data['userroles']=$this->Common_model->getUserRolesById();
        $data['customers']=$this->Common_model->getAllCustomers();
        $data['assUrsIds']=$this->Common_model->getAssUrsIds($proid);
        $system_details=$this->MProject->getSystemDetailsAll($proid);
        if($system_details->num_rows()>0)
        {            
            $data['system_details']=$system_details->result_array();
        }
        else
        {
            $data['system_details']=array(
                array(
                        'id'=>0,
                        'projectid'=>0,
                        'systemname'=>'',
                        'companyname'=>'',
                        'companyaddress'=>'',
                        'servicecontractorname'=>'',
                        'servicecontractoraddress'=>'',
                        'testedby'=>0,
                        'witnessedby'=>0,
                        'witnesseddate'=>date(DT_FORMAT),
                        'testedDate'=>date(DT_FORMAT)                        
                    )
            );
        }

        if ($this->input->post('submit'))
        {
            $data['system_details']=array();
            $ckemtyval=$this->input->post('systemname');

            if(!empty($ckemtyval))
            {
                foreach ($ckemtyval as $sys_key => $sys_value) {
                    $data['system_details'][]= array(
                        'id'=>$_POST['systemid'][$sys_key],
                        'projectid'=>$projid,
                        'systemname'=>$_POST['systemname'][$sys_key],
                        'companyname'=>$_POST['companyname'][$sys_key],
                        'companyaddress'=>$_POST['companyaddress'][$sys_key],
                        'servicecontractorname'=>$_POST['contractorname'][$sys_key],
                        'servicecontractoraddress'=>$_POST['contractoraddress'][$sys_key],
                        'testedby'=>$_POST['testcmpby'][$sys_key],
                        'witnessedby'=>$_POST['witnessedny'][$sys_key],
                        'witnesseddate'=>date('Y-m-d H:i:s',strtotime($_POST['witnesseddate'][$sys_key])),
                        'testedDate'=>date('Y-m-d H:i:s',strtotime($_POST['testcmpdate'][$sys_key])),
                    );
                }
            }

        }



        $data['userall']=$this->MProject->getUsers(0);
        $data['projdata']=$this->Common_model->getProductById($proid);
        $data['title'] = 'Edit Project';
        //$data['sidemenu'] = 'hide';
        $this->load->view('common/header',$data);
        $this->load->view('projects/add',$data);
        $this->load->view('common/footer');
    }
    public function compareDate() {
      $startDate = strtotime($_POST['projectstartdate']);
      $endDate = strtotime($_POST['projectenddate']);

      if ($endDate >= $startDate)
        return True;
      else {
        $this->form_validation->set_message('compareDate', '%s should be greater than Start Date.');
        return False;
      }
    }

    public function deleteProject()
    {
        $this->exitpage();
        //isdeleted
        $projid = $this->uri->segment(3);
        $created_date = date('Y-m-d H:i:s');

        $upd_array = array(
            'isdeleted' => 'Y',
            'lastmodifiedon' => $created_date,
            'lastmodifiedby' => $this->session->userdata('userid')
        );
        
        $this->db->where('id', $projid);
        $this->db->update(PROJECTS, $upd_array);

        $this->session->set_flashdata('success_message', 'The Project has been deleted successfully...');
        $path = base_url('projects') ;
        redirect($path);

    }

    public function getallProjects()
        {
        
        $table = PROJECTS;
         
        // Table's primary key
        $primaryKey = 'id';

        $roleid=$this->session->userdata('userroleid');
        $cuser=$this->session->userdata('userid');

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
            //array( 'db' => 'p.projectstartdate',  'dt' => 1, 'field' => 'projectstartdate','formatter' => function( $d, $row ) { return date('d M Y',strtotime($d));}),
            //array( 'db' => 'sn.sitename',  'dt' => 1, 'field' => 'sitename'),
            array( 'db' => 'cn.contactfirstname',  'dt' => 1, 'field' => 'contactfirstname'),
            array( 'db' => 'cn.contactlastname',  'dt' => 1, 'field' => 'contactlastname','formatter'=> function($d,$row){ return $row['contactfirstname'].' '.$row['contactlastname'];}),
            //array( 'db' => 'p.projectenddate',  'dt' => 2, 'field' => 'projectenddate','formatter' => function( $d, $row ) { return date('d M Y',strtotime($d));}),
            array( 'db' => 'u.custname',  'dt' => 2, 'field' => 'custname'),
            array( 'db' => 'p.projectdescription',  'dt' => 3, 'field' => 'projectdescription'),
            
            //array( 'db' => 'p.projectstatus',  'dt' => 5, 'field' => 'projectstatus'),
            array( 'db' => 'p.isactive',   'dt' => 4, 'field' => 'isactive','formatter' => function( $d, $row ) {
                    return (($d==1)?'Active':'Inactive');
                }),
			array( 'db' => 'p.projectstartdate',  'dt' => 5, 'field' => 'projectstartdate','formatter' => function( $d, $row ) { return date('d M Y',strtotime($d));}),
            array( 'db' => 'p.id',   'dt' => 6, 'field' => 'id','formatter' => function( $d, $row ) {
                    $action='<div class="icon_list">';

                    $newpid=$this->Common_model->encodeid($d);

                    if(ckpermprojedit==true)
                    {
                        $action.='<a href="'.site_url('projects/editprojects/'.$newpid).'"  data-toggle="tooltip"  title="Edit Project"><i class="fa fa-pencil" aria-hidden="true"></i></a>&nbsp;';
                    }
                    if(ckpermprojdel==true)
                    {
                        $action.='<a href="javascript:void(0)" data-id="'.$d.'" class="delete_project_acc" data-toggle="tooltip"  title="Delete Project"><i class="fa fa-times" aria-hidden="true"></i></a>&nbsp;';
                    }
                    if(ckpermproview==true)
                    {
                        $action.='<a href="'.site_url('projects/projview/'.$newpid).'"  data-toggle="tooltip"  title="Project Process"><i class="fa fa-eye" aria-hidden="true"></i></a>';
                    }
                    $action.='</div>';

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
        
        $joinQuery = "FROM `".PROJECTS."` AS `p` JOIN `".CUSTOMER."` AS `u` ON (`u`.`id` = `p`.`userincharge`)";
        $joinQuery .= " LEFT JOIN `".CUSSITES."` `sn` ON (`sn`.`id` = `p`.`siteid`)";
        $joinQuery .= " LEFT JOIN `".CUSDETAILS."` `cn` ON (`cn`.`id` = `p`.`contactid`)";
        $extraWhere = " p.isdeleted='N' "; 

        if(($roleid!=1)&&($cuser!=1))
        {
            $joinQuery.= " LEFT JOIN `".PROJURS."` pus ON (`p`.`id`=`pus`.`projid` and `pus`.`userid`=".intval($cuser)." ) ";
            $extraWhere .= " ANd  `pus`.`userid`=".intval($cuser)." ";   
        }

        $searchval=$_REQUEST['search']['value'];       
        $extraWhere_add=' AND ';
        if(!empty($searchval))
        {
            $extraWhere .= " OR cn.contactfirstname like '%".$searchval."%' ";
            $extraWhere .= " OR cn.contactlastname like '%".$searchval."%' ";
            /*$extraWhere = " addressLine2 like '%".$searchval."%' ";
            $extraWhere .= " OR city like '%".$searchval."%' ";
            $extraWhere .= " OR state like '%".$searchval."%' ";
            $extraWhere .= " OR country like '%".$searchval."%' ";
            $extraWhere .= " OR zipcode like '%".$searchval."%' ";
            $extraWhere .= " OR phone like '%".$searchval."%' ";
            $extraWhere .= " OR fax like '%".$searchval."%' ";
            $extraWhere .= " OR mobile like '%".$searchval."%' ";
            $extraWhere .= " OR contactlastname like '%".$searchval."%' ";
            $extraWhere .= " OR contactdesignation like '%".$searchval."%' ";
            $extraWhere .= " OR contactphone like '%".$searchval."%' ";
            $extraWhere .= " OR contactmobile like '%".$searchval."%' ";
            $extraWhere .= " OR contactemailid like '%".$searchval."%' ";*/           
        }

        #echo '<pre>'; print_r($_GET); echo '</pre>';
         
        echo json_encode(
            SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere,'',$extraWhere_add )
        );
        
        
    }
    public function projview()
    {
        $this->exitpage('projects/projview');
        
        $proidnew = $this->uri->segment(3);
        $proid = intval($this->Common_model->decodeid($proidnew));        
        $data['proid'] = $proid;

        $data['projdata']=$this->Common_model->getProductById($proid);
        
        $data['userRoledata']=$this->Common_model->getUserRolesByRoles();
        $data['userroles']=$this->Common_model->getUserRolesById();
        $data['customers']=$this->Common_model->getAllCustomers();
        $data['assUrsIds']=$this->Common_model->getAssUrsIds($proid);
        $system_details=$this->MProject->getSystemDetailsAll($proid);
        if($system_details->num_rows()>0)
        {            
            $data['system_details']=$system_details->result_array();
        }
        $data['userall']=$this->MProject->getUsers(0);
        $data['title'] = 'View Project';
        $data['custom_side_menu'] = 'projprsmenu';
        $data['sidemenu_sub_active'] = '';
        $data['sidemenu_sub_active1'] = '';
        //$data['sidemenu'] = 'hide';
        $this->load->view('common/header',$data);
        $this->load->view('projects/projview',$data);
        $this->load->view('common/footer');
    }
    public function rpz()
    {
        $this->exitpage('projects/projview');
        
        $proidnew = $this->uri->segment(3);
        $proid = intval($this->Common_model->decodeid($proidnew));        
        $data['proid'] = $proid;
        $prcessidnew = $this->uri->segment(4);
        $prcessid = intval($this->Common_model->decodeid($prcessidnew));        

        if ($this->input->post('cancel'))
        {
            $path = base_url('projects/'.$this->uri->segment(2).'/'.$proidnew);
            redirect($path);
        }
        $masterprcid=26;
               
        $data['title'] = 'RPZ Valve Test Report';
        $data['masterprcid'] = $masterprcid;
        if ($this->input->post('submit'))
        {
            $this->form_validation->set_rules('reportref', 'Ref', 'trim|required');

            /* ============= section 1 ======================== */

            $this->form_validation->set_rules('comownvalve', 'Company Owning Valve', 'trim|required');
            $this->form_validation->set_rules('watersuppcustomer', 'Water Suppliers Customer', 'trim|required');
            $this->form_validation->set_rules('watersupp', 'Water Supplier', 'trim|required');
            $this->form_validation->set_rules('valvelocation', 'Location Address of Valve', 'trim|required');
            $this->form_validation->set_rules('valvelocationtel', 'Location Address of Valve tel', 'trim|required');
            $this->form_validation->set_rules('perturnoffsupply', 'Permission to Turn off Supply', 'trim|required');
            //$this->form_validation->set_rules('valvesigned', 'Signed', 'trim|required');
            if(empty($_POST['valvemake']) || empty($_POST['valvesize']) || empty($_POST['valveserial']) || empty($_POST['valvemodel']))
            {
                $this->form_validation->set_rules('valvemodel', 'Valve', 'trim|required');
            }

            /* ================ Section 2 ============================= */

            $this->form_validation->set_rules('locvalveonsite', 'Location of Valve On Site', 'trim|required');
            $this->form_validation->set_rules('accessibility', 'Accessibility & Clearances', 'trim|required');
            $this->form_validation->set_rules('timeturnoff', 'Time of Turn Off', 'trim|required');
            $this->form_validation->set_rules('installcompany', 'Installation Company', 'trim|required');
            $this->form_validation->set_rules('installcompanytel', 'Installation Company tel', 'trim|required');
            $this->form_validation->set_rules('unobstrucdrain', 'Unobstructed Drain Air Gap', 'trim|required');
            $this->form_validation->set_rules('meterreading', 'Meter Reading', 'trim|required');

            $this->form_validation->set_rules('plantype', 'Meter Reading', 'trim|required');
            $this->form_validation->set_rules('valveinstalldate', 'Valve Installation Date', 'trim|required');
            $this->form_validation->set_rules('strainerpresent', 'Strainer Present', 'trim|required');
            $this->form_validation->set_rules('isolatingvalve2', 'Isolating Valve No.2 Tight', 'trim|required');
            $this->form_validation->set_rules('commdate', 'Commissioning Date', 'trim|required');

            /* ======================== Section 3 =========================== */

            $this->form_validation->set_rules('testername', 'Testers Name', 'trim|required');
            $this->form_validation->set_rules('testerno', 'Testers No.', 'trim|required');
            //$this->form_validation->set_rules('testersign', 'Signed', 'trim|required');
            $this->form_validation->set_rules('turnontime', 'Turn On Time', 'trim|required');
            $this->form_validation->set_rules('completedate', 'Date of Completion', 'trim|required');
            $this->form_validation->set_rules('nextestdate', 'Date of Next Date', 'trim|required');



            
            if ($this->form_validation->run() == TRUE)
            {

                $created_date = date('Y-m-d H:i:s');

                if($prcessid==0)
                {



                    $ins_array1 = array(
                        'projectid' =>  $proid,
                        'processid' =>  $masterprcid,
                        'sheetnumber' => 0,                        
                        'system' => 0,                    
                        'referenceno' => $this->input->post('reportref'),
                        'comments'  =>  $this->input->post('commaircomments'),                        
                        'engineerid' => 0,
                        'reportdate' => '0000-00-00 00:00:00',
                        'createdon' => $created_date,
                        'createdby' => $this->session->userdata('userid')
                    );

                    $prcessid=$this->Common_model->insertPrjPrcMaster($ins_array1);                    
                    $prcessidnew = ($this->Common_model->encodeid($prcessid));
                    

                    $rpz_master=array(
                        'projectprocesslistmasterid'=>$prcessid,
                        'comownvalve'       =>  $this->input->post('comownvalve'),
                        'watersuppcustomer' =>  $this->input->post('watersuppcustomer'),
                        'watersupp'         =>  $this->input->post('watersupp'),
                        'valvelocation'     =>  $this->input->post('valvelocation'),
                        'valvelocationtel'  =>  $this->input->post('valvelocationtel'),
                        'perturnoffsupply'  =>  $this->input->post('perturnoffsupply'),
                        'valvesigned'       =>  $this->input->post('valvesigned'),
                        'locvalveonsite'    =>  $this->input->post('locvalveonsite'),
                        'accessibility'     =>  $this->input->post('accessibility'),
                        'timeturnoff'       =>  $this->input->post('timeturnoff'),
                        'installcompany'    =>  $this->input->post('installcompany'),
                        'installcompanytel' =>  $this->input->post('installcompanytel'),
                        'unobstrucdrain'    =>  $this->input->post('unobstrucdrain'),
                        'meterreading'      =>  $this->input->post('meterreading'),
                        'strainerpresent'   =>  $this->input->post('strainerpresent'),                        
                        'valveinstalldate'  =>  date(SQL_FORMAT, strtotime($this->input->post('valveinstalldate'))),
                        'plantype'          =>  $this->input->post('plantype'),
                        'isolatingvalve2'   =>  $this->input->post('isolatingvalve2'),
                        'commdate'          =>  date(SQL_FORMAT, strtotime($this->input->post('commdate'))),
                        'testername'        =>  $this->input->post('testername'),
                        'testerno'          =>  $this->input->post('testerno'),
                        'testersign'        =>  $this->input->post('testersign'),
                        'turnontime'        =>  $this->input->post('turnontime'),
                        'completedate'      =>  date(SQL_FORMAT, strtotime($this->input->post('completedate'))),
                        'nextestdate'       =>  date(SQL_FORMAT, strtotime($this->input->post('nextestdate'))),
                        'createdon'         =>  $created_date,
                        'createdby'         =>  $this->session->userdata('userid')
                    );                    
                    $rpzid=$this->MProject->insertRPZsection(RPZMASTER,$rpz_master);

                    $rpz_valves=array(
                        'projectprocesslistmasterid'=>$prcessid,
                        'rpzid'             =>  $rpzid,
                        'valvemake'         =>  $this->input->post('valvemake'),
                        'valvesize'         =>  $this->input->post('valvesize'),
                        'valveserial'       =>  $this->input->post('valveserial'),
                        'valvemodel'        =>  $this->input->post('valvemodel')
                    );

                    $this->MProject->insertRPZsection(RPZVALVES,$rpz_valves);

                    $rpz_checkvalve=array(
                        'projectprocesslistmasterid'=>$prcessid,
                        'rpzid'             =>  $rpzid,
                        'inickvalve1'       =>  intval($this->input->post('inickvalve1')),
                        'inileaked1'        =>  intval($this->input->post('inileaked1')),
                        'inireliefvalve'    =>  $this->input->post('inireliefvalve'),
                        'inickvalve2'       =>  intval($this->input->post('inickvalve2')),
                        'inileaked2'        =>  intval($this->input->post('inileaked2')),
                        'inidiffpressure1'  =>  $this->input->post('inidiffpressure1'),
                        'inidiffpressure2'  =>  $this->input->post('inidiffpressure2'),
                        'repairmaterial'    =>  $this->input->post('repairmaterial'),
                        'repckvalve1'       =>  intval($this->input->post('repckvalve1')),
                        'repleaked1'        =>  intval($this->input->post('repleaked1')),
                        'repreliefvalve'    =>  $this->input->post('repreliefvalve'),
                        'repckvalve2'       =>  intval($this->input->post('repckvalve2')),
                        'repleaked2'        =>  intval($this->input->post('repleaked2')),
                        'repdiffpressure1'  =>  $this->input->post('repdiffpressure1'),
                        'repdiffpressure2'  =>  $this->input->post('repdiffpressure2')
                    );

                    $this->MProject->insertRPZsection(RPZCKVALV,$rpz_checkvalve);



                    //$this->Common_model->updateSequenceval(CAPRECK,'sheetnumber','projectid='.$proid,'id','ASC');
                    $this->Common_model->updateSequenceval(PRJPRCLST,'sheetnumber','projectid='.$proid.' and processid='.$masterprcid,'id','ASC');

                    $this->session->set_flashdata('project_message', 'New Air System Pre-Commissioning Checks has been created successfully...');
                }
                else
                {

                    $update_array1 = array(
                        'referenceno' => $this->input->post('reportref'),
                        'comments' => $this->input->post('commaircomments'),
                        'modifiedon' => $created_date,
                        'modifiedby' => $this->session->userdata('userid')
                    );

                    $this->Common_model->updatePrjPrcMaster($update_array1,$prcessid);

                    $rpz_master=array(
                        'projectprocesslistmasterid'=>$prcessid,
                        'comownvalve'       =>  $this->input->post('comownvalve'),
                        'watersuppcustomer' =>  $this->input->post('watersuppcustomer'),
                        'watersupp'         =>  $this->input->post('watersupp'),
                        'valvelocation'     =>  $this->input->post('valvelocation'),
                        'valvelocationtel'  =>  $this->input->post('valvelocationtel'),
                        'perturnoffsupply'  =>  $this->input->post('perturnoffsupply'),
                        'valvesigned'       =>  $this->input->post('valvesigned'),
                        'locvalveonsite'    =>  $this->input->post('locvalveonsite'),
                        'accessibility'     =>  $this->input->post('accessibility'),
                        'timeturnoff'       =>  $this->input->post('timeturnoff'),
                        'installcompany'    =>  $this->input->post('installcompany'),
                        'installcompanytel' =>  $this->input->post('installcompanytel'),
                        'unobstrucdrain'    =>  $this->input->post('unobstrucdrain'),
                        'meterreading'      =>  $this->input->post('meterreading'),
                        'strainerpresent'   =>  $this->input->post('strainerpresent'),                        
                        'valveinstalldate'  =>  date(SQL_FORMAT, strtotime($this->input->post('valveinstalldate'))),
                        'plantype'          =>  $this->input->post('plantype'),
                        'isolatingvalve2'   =>  $this->input->post('isolatingvalve2'),
                        'commdate'          =>  date(SQL_FORMAT, strtotime($this->input->post('commdate'))),
                        'testername'        =>  $this->input->post('testername'),
                        'testerno'          =>  $this->input->post('testerno'),
                        'testersign'        =>  $this->input->post('testersign'),
                        'turnontime'        =>  $this->input->post('turnontime'),
                        'completedate'      =>  date(SQL_FORMAT, strtotime($this->input->post('completedate'))),
                        'nextestdate'       =>  date(SQL_FORMAT, strtotime($this->input->post('nextestdate'))),
                        'modifiedon'         =>  $created_date,
                        'modifiedby'         =>  $this->session->userdata('userid')
                    );                    
                    $this->MProject->updateRPZsection(RPZMASTER,$rpz_master,'projectprocesslistmasterid',$prcessid);
                    
                    $rpz_valves=array(
                        'projectprocesslistmasterid'=>$prcessid,
                        'rpzid'             =>  $rpzid,
                        'valvemake'         =>  $this->input->post('valvemake'),
                        'valvesize'         =>  $this->input->post('valvesize'),
                        'valveserial'       =>  $this->input->post('valveserial'),
                        'valvemodel'        =>  $this->input->post('valvemodel')
                    );

                    $this->MProject->updateRPZsection(RPZVALVES,$rpz_valves,'projectprocesslistmasterid',$prcessid);

                    $rpz_checkvalve=array(
                        'projectprocesslistmasterid'=>$prcessid,
                        'inickvalve1'       =>  intval($this->input->post('inickvalve1')),
                        'inileaked1'        =>  intval($this->input->post('inileaked1')),
                        'inireliefvalve'    =>  $this->input->post('inireliefvalve'),
                        'inickvalve2'       =>  intval($this->input->post('inickvalve2')),
                        'inileaked2'        =>  intval($this->input->post('inileaked2')),
                        'inidiffpressure1'  =>  $this->input->post('inidiffpressure1'),
                        'inidiffpressure2'  =>  $this->input->post('inidiffpressure2'),
                        'repairmaterial'    =>  $this->input->post('repairmaterial'),
                        'repckvalve1'       =>  intval($this->input->post('repckvalve1')),
                        'repleaked1'        =>  intval($this->input->post('repleaked1')),
                        'repreliefvalve'    =>  $this->input->post('repreliefvalve'),
                        'repckvalve2'       =>  intval($this->input->post('repckvalve2')),
                        'repleaked2'        =>  intval($this->input->post('repleaked2')),
                        'repdiffpressure1'  =>  $this->input->post('repdiffpressure1'),
                        'repdiffpressure2'  =>  $this->input->post('repdiffpressure2')
                    );

                    $this->MProject->updateRPZsection(RPZCKVALV,$rpz_checkvalve,'projectprocesslistmasterid',$prcessid);



                    $this->session->set_flashdata('project_message', 'Air System Pre-Commissioning Checks has been updated successfully...');

                }

                $sheetstatus=$this->input->post('shtenadis');
                $this->MProject->insertPrjSheetStatus($proid,$masterprcid,$sheetstatus,false);

                $path = base_url('projects/rpz/'.$proidnew.'/'.$prcessidnew);
                redirect($path);
            }

        }
        //$data['sidemenu'] = 'hide';
        $data['engdata']=$this->MProject->getEngByPrjID($proid);
        if($prcessid!=0)        
        {
            $prcdatas=array();
            $prcdatas1=$this->MProject->getPRZsection(RPZMASTER,$prcessid);
            $prcdatas=$prcdatas1;

            $prcdatas2=$this->MProject->getPRZsection(RPZVALVES,$prcessid);
            if(!empty($prcdatas2))
            {
                unset($prcdatas2['id']);
                unset($prcdatas2['projectprocesslistmasterid']);
                unset($prcdatas2['rpzid']);

                $prcdatas=array_merge($prcdatas, $prcdatas2);                
            }

            $prcdatas3=$this->MProject->getPRZsection(RPZCKVALV,$prcessid);
            if(!empty($prcdatas3))
            {
                unset($prcdatas3['id']);
                unset($prcdatas3['projectprocesslistmasterid']);
                unset($prcdatas3['rpzid']);

                $prcdatas=array_merge($prcdatas, $prcdatas3);                
            }

            $data['rpzdata']=$prcdatas;

            $prcdatas=$this->MProject->getPrjPrcLst($prcessid);
            $data['prcdata']=$prcdatas[0];
        }
        
        $data['prcessid']=$prcessid;
        $data['sheetstatus']=$this->MProject->getPrjSheetStatus($proid,26);
        $data['custom_side_menu'] = 'projprsmenu';
        $data['prodata']=$this->Common_model->getProductById($proid); 
        $data['sidemenu_sub_active'] = 'commAir';
        $data['sidemenu_sub_active1'] = $this->uri->segment(2); 
        $data['userall']=$this->MProject->getUsers(0);
        $this->load->view('common/header',$data);
        $this->load->view('projects/rpz/rpz',$data);
        $this->load->view('common/footer');
    }

    public function timeSheet()
    {
        $this->exitpage('projects/projview');
        
        $proidnew = $this->uri->segment(3);
        $proid = intval($this->Common_model->decodeid($proidnew));        
        $data['proid'] = $proid;
        $prcessidnew = $this->uri->segment(4);
        $prcessid = intval($this->Common_model->decodeid($prcessidnew)); 

        if ($this->input->post('cancel'))
        {
            $path = base_url('projects/'.$this->uri->segment(2).'/'.$proidnew);
            redirect($path);
        }
        
        $data['title'] = 'Time Sheet';
        $masterprcid = 27;

        /*== Start Insert/Update ==*/
        if ($this->input->post('submit'))
        {

            $this->form_validation->set_rules('reportref', 'Ref', 'trim|required');
            $this->form_validation->set_rules('projsystem', 'System', 'trim|required');            
            $this->form_validation->set_rules('commairreptenggsign', 'Engineer', 'trim|required');
            //$this->form_validation->set_rules('clientsign', 'Clients Signature', 'trim|required');
            $this->form_validation->set_rules('position', 'Position', 'trim|required');            
            $this->form_validation->set_rules('signdate', 'Date', 'trim|required');
            
            if ($this->form_validation->run() == TRUE)
            {
                $created_date = date('Y-m-d H:i:s');

                if($prcessid==0)
                {

                    $ins_array1 = array(
                        'projectid' =>  $proid,
                        'processid' =>  $masterprcid,
                        'sheetnumber' => 0,                        
                        'system' => $this->input->post('projsystem'),                    
                        'referenceno' => $this->input->post('reportref'),
                        'comments'  =>  $this->input->post('commaircomments'),                        
                        'engineerid' => $this->input->post('commairreptenggsign'),
                        'reportdate' => date('Y-m-d H:i:s',strtotime($this->input->post('commairreptenggdate'))),
                        'createdon' => $created_date,
                        'createdby' => $this->session->userdata('userid')
                    );

                    $prcessid=$this->Common_model->insertPrjPrcMaster($ins_array1);
                    $prcessidnew = ($this->Common_model->encodeid($prcessid));

                    $timshtmaster_inc=array(
                        'projectprocesslistmasterid' => $prcessid,
                        'clientsign'=>$_POST['clientsign'],
                        'position'=>$_POST['position'],
                        'signdate'=>date(SQL_FORMAT,strtotime($_POST['signdate'])),
                        'createdon' => $created_date,
                        'createdby' => $this->session->userdata('userid')
                    );
                    $this->db->insert(CWTIMEMASTER,$timshtmaster_inc);
                    $timesheetid=$this->db->insert_id();

                    $insarray_batch=array();
                    $procesSectionCat_pdata=$this->input->post('dayid');
                    if(!empty($procesSectionCat_pdata))
                    {
                        foreach ($procesSectionCat_pdata as $psc_key => $psc_value) 
                        {
                            $daydate='0000-00-00 00:00:00';
                            $dayhours='0000-00-00 00:00:00';
                            if(!empty($_POST['daydate'.$psc_value]))
                            {
                                $daydate=date(SQL_FORMAT,strtotime($_POST['daydate'.$psc_value]));
                            }
                            if(!empty($_POST['dayhours'.$psc_value]))
                            {
                                $dayhours=date(SQL_FORMAT,strtotime($_POST['dayhours'.$psc_value]));
                            }


                            $insarray_batch[] = array(
                              'projectprocesslistmasterid' => $prcessid,
                              'timesheetid'=>$timesheetid,
                              'dayid' => $psc_value,
                              'daydate'=>$daydate,
                              'dayhours'=>$dayhours,
                              'dayengg'=>$_POST['dayengg'.$psc_value]
                            );
                        }
                    }
                    #if(!empty($insarray_batch))
                    {
                        $this->db->insert_batch(CWTIMEDATA, $insarray_batch);
                    }

                    //$this->Common_model->updateSequenceval(CAPRECK,'sheetnumber','projectid='.$proid,'id','ASC');
                    $this->Common_model->updateSequenceval(PRJPRCLST,'sheetnumber','projectid='.$proid.' and processid='.$masterprcid,'id','ASC');

                    $this->session->set_flashdata('project_message', 'New '.$data['title'].' has been created successfully...');
                }
                else
                {
                   
                    $update_array1 = array(
                        'system' => $this->input->post('projsystem'),                    
                        'referenceno' => $this->input->post('reportref'),
                        'comments' => $this->input->post('commaircomments'),
                        'engineerid' => $this->input->post('commairreptenggsign'),
                        'reportdate' => date('Y-m-d H:i:s',strtotime($this->input->post('commairreptenggdate'))),
                        'modifiedon' => $created_date,
                        'modifiedby' => $this->session->userdata('userid')
                    );

                    $this->Common_model->updatePrjPrcMaster($update_array1,$prcessid);

                    $timesheetid=intval($_POST['timesheetid']);

                    $timshtmaster_inc=array(
                        'clientsign'=>$_POST['clientsign'],
                        'position'=>$_POST['position'],
                        'signdate'=>date(SQL_FORMAT,strtotime($_POST['signdate']))
                    );
                    if($timesheetid==0)
                    {
                        $timshtmaster_inc['createdon']= $created_date;
                        $timshtmaster_inc['createdby'] = $this->session->userdata('userid');
                        $this->db->insert(CWTIMEMASTER,$timshtmaster_inc);
                        $timesheetid=$this->db->insert_id();
                    }
                    else
                    {
                        $timshtmaster_inc['modifiedon']= $created_date;
                        $timshtmaster_inc['modifiedby'] = $this->session->userdata('userid');
                        $this->db->where('id',$timesheetid);
                        $this->db->update(CWTIMEMASTER,$timshtmaster_inc);
                    }


                    
                    $upsarray_batch=array();

                    $procesSectionCat_pdata=$this->input->post('dayid');

                    if(!empty($procesSectionCat_pdata))
                    {
                        foreach ($procesSectionCat_pdata as $psc_key => $psc_value) 
                        {
                            $daydate='0000-00-00 00:00:00';
                            $dayhours='0000-00-00 00:00:00';
                            if(!empty($_POST['daydate'.$psc_value]))
                            {
                                $daydate=date(SQL_FORMAT,strtotime($_POST['daydate'.$psc_value]));
                            }
                            if(!empty($_POST['dayhours'.$psc_value]))
                            {
                                $dayhours=date(SQL_FORMAT,strtotime($_POST['dayhours'.$psc_value]));
                            }

                            if($_POST['tmeshtdataids'.$psc_value]==0)
                            {
                                $insarray_batch[] = array(
                                  'projectprocesslistmasterid' => $prcessid ,
                                  'timesheetid'=>$timesheetid,
                                  'dayid' => $psc_value,
                                  'daydate'=>$daydate,
                                  'dayhours'=>$dayhours,
                                  'dayengg'=>$_POST['dayengg'.$psc_value]
                                );
                            }
                            else
                            {
                                $upsarray_batch[] = array(
                                    'id'=>$_POST['tmeshtdataids'.$psc_value],
                                    'projectprocesslistmasterid' => $prcessid ,
                                    'timesheetid'=>$timesheetid,
                                    'dayid' => $psc_value,
                                    'daydate'=>$daydate,
                                    'dayhours'=>$dayhours,
                                    'dayengg'=>$_POST['dayengg'.$psc_value]
                                );
                            }

                        }
                    }

                    if(!empty($upsarray_batch))
                    {
                        $this->db->update_batch(CWTIMEDATA, $upsarray_batch,'id');
                    }
                    if(!empty($insarray_batch))
                    {
                        $this->db->insert_batch(CWTIMEDATA, $insarray_batch);
                    }

                    $this->session->set_flashdata('project_message', $data['title'].' has been updated successfully...');

                }

                $sheetstatus=$this->input->post('shtenadis');
                $this->MProject->insertPrjSheetStatus($proid,$masterprcid,$sheetstatus,false);

                $path = base_url('projects/'.$this->uri->segment(2).'/'.$proidnew.'/'.$prcessidnew);
                redirect($path);
            }
        }

        //$data['sidemenu'] = 'hide';
        $data['engdata']=$this->MProject->getEngByPrjID($proid);        
        $timshtmaster=$this->MProject->getcwTimesheetMaster($prcessid);
        $timesheetdata=$this->MProject->getcwTimesheetData($prcessid);

        if($prcessid!=0)        
        {
            $prcdatas=$this->MProject->getPrjPrcLst($prcessid);
            $data['prcdata']=$prcdatas[0];  
        }

        if($timesheetdata->num_rows()>0)
        {
            $data['timesheetdata']=$timesheetdata->result_array();
        }
        else
        {
            $data['timesheetdata']=array(
                array('id'=>0,'projectprocesslistmasterid'=>$prcessid,'timesheetid'=>'','dayid' => 1,'daydate'=>'',',dayhours'=>'','dayengg'=>''),
                array('id'=>0,'projectprocesslistmasterid'=>$prcessid,'timesheetid'=>'','dayid' => 2,'daydate'=>'','dayhours'=>'','dayengg'=>''),
                array('id'=>0,'projectprocesslistmasterid'=>$prcessid,'timesheetid'=>'','dayid' => 3,'daydate'=>'','dayhours'=>'','dayengg'=>''),
                array('id'=>0,'projectprocesslistmasterid'=>$prcessid,'timesheetid'=>'','dayid' => 4,'daydate'=>'','dayhours'=>'','dayengg'=>''),
                array('id'=>0,'projectprocesslistmasterid'=>$prcessid,'timesheetid'=>'','dayid' => 5,'daydate'=>'','dayhours'=>'','dayengg'=>''),
                array('id'=>0,'projectprocesslistmasterid'=>$prcessid,'timesheetid'=>'','dayid' => 6,'daydate'=>'','dayhours'=>'','dayengg'=>''),
                array('id'=>0,'projectprocesslistmasterid'=>$prcessid,'timesheetid'=>'','dayid' => 7,'daydate'=>'','dayhours'=>'','dayengg'=>'')
            );

        }

        if($timshtmaster->num_rows()>0)
        {
            $data['timshtmaster']=$timshtmaster->result_array();
        }
        else
        {            
            $data['timshtmaster']=array(array('id'=>0,'clientsign'=>'','position'=>'','signdate'=>''));
        }

        if($this->input->post('dayid'))
        {
            $data['timesheetdata']=array();
            $value1=$this->input->post('dayid');            
            foreach ($value1 as $key => $value) {
                $data['timesheetdata'][]=array(
                    'id'=>$_POST['tmeshtdataids'.$value],
                    'projectprocesslistmasterid'=>$prcessid,
                    'timesheetid'=>'',
                    'dayid' => $value,
                    'daydate'=>$_POST['daydate'.$value],
                    'dayhours'=>$_POST['dayhours'.$value],
                    'dayengg'=>$_POST['dayengg'.$value]
                );
            }

            $data['timshtmaster']=array(
                array(
                    'id'=>$_POST['timesheetid'],
                    'clientsign'=>$_POST['clientsign'],
                    'position'=>$_POST['position'],
                    'signdate'=>$_POST['signdate']
                )
            );

        }

        /*== End Insert/Update ==*/

        //$data['sidemenu'] = 'hide';
        $data['engdata']=$this->MProject->getEngByPrjID($proid);
        if($prcessid!=0)        
        {
            $prcdatas=$this->MProject->getPrjPrcLst($prcessid);
            $data['prcdata']=$prcdatas[0];
        }

        $data['prcessid']=$prcessid;
        $data['masterprcid']=$masterprcid;
        $data['sheetstatus']=$this->MProject->getPrjSheetStatus($proid,$masterprcid);
        
        $data['custom_side_menu'] = 'projprsmenu';
        
        $data['prodata']=$this->Common_model->getProductById($proid);

        $data['engdata']=$this->MProject->getEngByPrjID($proid);

        $data['sidemenu_sub_active'] = 'timesheet';
        $data['sidemenu_sub_active1'] = $this->uri->segment(2);
        $data['tshdays']=$this->tshdays;
        $this->load->view('common/header',$data);
        $this->load->view('projects/timesheet/timeSheet',$data);
        $this->load->view('common/footer');
    }

    /* ========================================= Water Treatment ============================= */

    public function waterTreatment()
    {
        $this->exitpage('projects/projview');

        $proidnew = $this->uri->segment(3);
        $proid = intval($this->Common_model->decodeid($proidnew));        
        $data['proid'] = $proid;
        $prcessidnew = $this->uri->segment(4);
        $prcessid = intval($this->Common_model->decodeid($prcessidnew));        
        $data['prodata']=$this->Common_model->getProductById($proid);        
        $data['title'] = 'Water Treatment';
        $data['custom_side_menu'] = 'projprsmenu';
        $data['sidemenu_sub_active'] = 'watertreatment';
        $data['sidemenu_sub_active1'] = $this->uri->segment(2);
        //$data['sidemenu'] = 'hide';
        $this->load->view('common/header',$data);
        #echo '<pre>'; print_r($prodata); echo '</pre>';
        $this->load->view('projects/watertreatment/waterTreatment',$data);
        $this->load->view('common/footer');
    }
    public function waterTreatmentSysWitCer()
    {
        $this->exitpage('projects/projview');

        $proidnew = $this->uri->segment(3);
        $proid = intval($this->Common_model->decodeid($proidnew));        
        $data['proid'] = $proid;
        $prcessidnew = $this->uri->segment(4);
        $prcessid = intval($this->Common_model->decodeid($prcessidnew)); 

        if ($this->input->post('cancel'))
        {
            $path = base_url('projects/'.$this->uri->segment(2).'/'.$proidnew);
            redirect($path);
        }        
        $masterprcid = 20;                
        $data['title'] = 'System Witness Certificate';
        $data['masterprcid'] = $masterprcid;
        //$data['sidemenu'] = 'hide';

        if ($this->input->post('submit'))
        {

            $this->form_validation->set_rules('reportref', 'Ref', 'trim|required');
            $this->form_validation->set_rules('projsystem', 'System', 'trim|required');            
            $this->form_validation->set_rules('commaircomments', 'Comments', 'trim|required');

            if ($this->form_validation->run() == TRUE)
            {
                $created_date = date('Y-m-d H:i:s');

                if($prcessid==0)
                {
                    $ins_array1 = array(
                        'module_name' =>  'water',
                        'projectid' =>  $proid,
                        'processid' =>  $masterprcid,
                        'sheetnumber' => 0,                        
                        'system' => $this->input->post('projsystem'),                    
                        'referenceno' => $this->input->post('reportref'),
                        'comments'  =>  $this->input->post('commaircomments'),                        
                        'engineerid' => 0,
                        'reportdate' => $created_date,
                        'createdon' => $created_date,
                        'createdby' => $this->session->userdata('userid')
                    );

                    $prcessid=$this->Common_model->insertPrjPrcMaster($ins_array1);
                    $prcessidnew = ($this->Common_model->encodeid($prcessid));


                    $ins_array = array(
                        'projectprocesslistmasterid' => $prcessid,
                        'projectsystemid' => $this->input->post('projsystem'),
                        'witnessdate'=> date(SQL_FORMAT, strtotime($this->input->post('commairwitdate'))),
                        'servicecontractdate' => date(SQL_FORMAT, strtotime($this->input->post('commairtestcompdate'))),
                        'createdon' => $created_date,
                        'createdby' => $this->session->userdata('userid')
                    );
                    
                    $this->db->insert(WTSYSCERT, $ins_array);                
                    $insert_id=$this->db->insert_id();

                     $this->Common_model->updateSequenceval(PRJPRCLST,'sheetnumber','projectid='.$proid.' and processid='.$masterprcid,'id','ASC');

                    $this->session->set_flashdata('project_message', 'New '.$data['title'].' has been created successfully...');
                }
                else
                {
                    $update_array1 = array(
                        'system' => $this->input->post('projsystem'),                    
                        'referenceno' => $this->input->post('reportref'),
                        'comments'  =>  $this->input->post('commaircomments'),
                        'modifiedon' => $created_date,
                        'modifiedby' => $this->session->userdata('userid')
                    );

                    $this->Common_model->updatePrjPrcMaster($update_array1,$prcessid);
                    
                    $update_array=array(
                        'projectsystemid' => $this->input->post('projsystem'),
                        'witnessdate'=> date(SQL_FORMAT, strtotime($this->input->post('commairwitdate'))),
                        'servicecontractdate' => date(SQL_FORMAT, strtotime($this->input->post('commairtestcompdate'))),
                        'modifiedon' => $created_date,
                        'modifiedby' => $this->session->userdata('userid')
                    );

                    $this->db->where('projectprocesslistmasterid', $prcessid);
                    $this->db->update(WTSYSCERT, $update_array);

                    $this->session->set_flashdata('project_message', $data['title'].' has been updated successfully...');

                }

                $sheetstatus=$this->input->post('shtenadis');

                $this->MProject->insertPrjSheetStatus($proid,$masterprcid,$sheetstatus,false);

                $path = base_url('projects/'.$this->uri->segment(2).'/'.$proidnew.'/'.$prcessidnew);
                redirect($path);
            }
        }

        $data['engdata']=$this->MProject->getEngByPrjID($proid);
        if($prcessid!=0)        
        {
            $prcdatas=$this->MProject->getWTsyscertificate($prcessid);
            $data['prcdata']=$prcdatas[0];
        }

        $data['prcessid']=$prcessid;
        $data['sheetstatus']=$this->MProject->getPrjSheetStatus($proid,$masterprcid);
        $data['custom_side_menu'] = 'projprsmenu';
        $data['prodata']=$this->Common_model->getProductById($proid); 
        $data['sidemenu_sub_active'] = 'watertreatment';
        $data['sidemenu_sub_active1'] = $this->uri->segment(2);
        $this->load->view('common/header',$data);
        $this->load->view('projects/watertreatment/waterTreatmentSysWitCer',$data);
        $this->load->view('common/footer');
    }
    public function waterTreatmentChkList()
    {
        $this->exitpage('projects/projview');
        
        $proidnew = $this->uri->segment(3);
        $proid = intval($this->Common_model->decodeid($proidnew));        
        $data['proid'] = $proid;
        $prcessidnew = $this->uri->segment(4);
        $prcessid = intval($this->Common_model->decodeid($prcessidnew)); 

        if ($this->input->post('cancel'))
        {
            $path = base_url('projects/'.$this->uri->segment(2).'/'.$proidnew);
            redirect($path);
        }
        
        $masterprcid = 21;        
        $chklstid=0;        
        $data['title'] = 'Water Treatment Check List';
        $data['masterprcid'] = $masterprcid;
        //$data['sidemenu'] = 'hide';

        if ($this->input->post('submit'))
        {

            $this->form_validation->set_rules('reportref', 'Ref', 'trim|required');
            $this->form_validation->set_rules('projsystem', 'System', 'trim|required');            
            //$this->form_validation->set_rules('commaircomments', 'Comments', 'trim|required');
            $this->form_validation->set_rules('commairreptenggsign', 'Engineer', 'trim|required');

            if ($this->form_validation->run() == TRUE)
            {
                $created_date = date('Y-m-d H:i:s');

                if($prcessid==0)
                {
                    $ins_array1 = array(
                        'module_name' =>  'waterTreatment',
                        'projectid' =>  $proid,
                        'processid' => $masterprcid,
                        'sheetnumber' => 0,                        
                        'system' => $this->input->post('projsystem'),                    
                        'referenceno' => $this->input->post('reportref'),
                        'comments'  =>  '',                        
                        'engineerid' => $this->input->post('commairreptenggsign'),
                        'reportdate' => date('Y-m-d H:i:s',strtotime($this->input->post('commairreptenggdate'))),
                        'createdon' => $created_date,
                        'createdby' => $this->session->userdata('userid')
                    );

                    $prcessid=$this->Common_model->insertPrjPrcMaster($ins_array1);
                    $prcessidnew = ($this->Common_model->encodeid($prcessid));


                    $ins_array = array(
                        'projectprocesslistmasterid' => $prcessid,
                        'chemical' => $this->input->post('chemical'),
                        'inhibitor'=> $this->input->post('inhibitor'),
                        'biocide' => $this->input->post('biocide'),
                        'createdon' => $created_date,
                        'createdby' => $this->session->userdata('userid')
                    );
                    
                    $this->db->insert(WTCHKLST, $ins_array);                
                    $insert_id=$this->db->insert_id();
                    $chklstid=$insert_id;


                    $prosectid=$this->input->post('prosectid');
                    $insarray_batch=array();

                    if(!empty($prosectid))
                    {
                        foreach ($prosectid as $psc_key => $psc_value) 
                        { 
                            $secdata='';
                            if(isset($_POST['mawatqph_'.$psc_value]))
                            {
                                $secdata=$_POST['mawatqph_'.$psc_value];
                            }

                            $insarray_batch[] = array(
                              'projectprocesslistmasterid' => $prcessid ,
                              'chklstid'   =>  $insert_id,
                              'sectid' => $psc_value,
                              'secdata'=>$secdata
                            );
                        }
                    }
                    if(!empty($insarray_batch))
                    {
                        $this->db->insert_batch(WTCHKLSTDATA, $insarray_batch);
                    }

                     $this->Common_model->updateSequenceval(PRJPRCLST,'sheetnumber','projectid='.$proid.' and processid='.$masterprcid,'id','ASC');

                    $this->session->set_flashdata('project_message', 'New '.$data['title'].' has been created successfully...');
                }
                else
                {
                    $update_array1 = array(
                        'system' => $this->input->post('projsystem'),                    
                        'referenceno' => $this->input->post('reportref'),
                        'comments'  =>  $this->input->post('commaircomments'),
                        'engineerid' => $this->input->post('commairreptenggsign'),
                        'reportdate' => date('Y-m-d H:i:s',strtotime($this->input->post('commairreptenggdate'))),
                        'modifiedon' => $created_date,
                        'modifiedby' => $this->session->userdata('userid')
                    );

                    $this->Common_model->updatePrjPrcMaster($update_array1,$prcessid);
                    $chklstid=intval($this->input->post('chklstid'));

                    if($chklstid==0)
                    {
                        $ins_array = array(
                            'projectprocesslistmasterid' => $prcessid,
                            'chemical' => $this->input->post('chemical'),
                            'inhibitor'=> $this->input->post('inhibitor'),
                            'biocide' => $this->input->post('biocide'),
                            'createdon' => $created_date,
                            'createdby' => $this->session->userdata('userid')
                        );
                        
                        $this->db->insert(WTCHKLST, $ins_array);                
                        $insert_id=$this->db->insert_id();
                        $chklstid=$insert_id;

                    }
                    else
                    {                    
                        $update_array=array(
                            'chemical' => $this->input->post('chemical'),
                            'inhibitor'=> $this->input->post('inhibitor'),
                            'biocide' => $this->input->post('biocide'),
                            'modifiedon' => $created_date,
                            'modifiedby' => $this->session->userdata('userid')
                        );
                        $this->db->where('id', $chklstid);
                        $this->db->update(WTCHKLST, $update_array);
                    }

                    

                    $prosectid=$this->input->post('prosectid');
                    $insarray_batch=array();
                    $update_batch=array();

                    if(!empty($prosectid))
                    {
                        foreach ($prosectid as $psc_key => $psc_value) 
                        {                           
                            $curvalid=intval($_POST['curvalid_'.$psc_value]);
                            $secdata='';
                            if(isset($_POST['mawatqph_'.$psc_value]))
                            {
                                $secdata=$_POST['mawatqph_'.$psc_value];
                            }
                            if($curvalid==0)
                            {
                                $insarray_batch[] = array(
                                  'projectprocesslistmasterid' => $prcessid ,
                                  'chklstid'   =>  $chklstid,
                                  'sectid' => $psc_value,
                                  'secdata'=>$secdata
                                );
                            }
                            else
                            {
                                $update_batch[] = array(
                                  'id' => $_POST['curvalid_'.$psc_value],
                                  'secdata'=>$secdata
                                );
                            }
                            
                        }
                    }
                    if(!empty($insarray_batch))
                    {
                        $this->db->insert_batch(WTCHKLSTDATA, $insarray_batch);
                    }
                    if(!empty($update_batch))
                    {
                        $this->db->update_batch(WTCHKLSTDATA, $update_batch,'id');
                    }


                    $this->session->set_flashdata('project_message', $data['title'].' has been updated successfully...');

                }

                $sheetstatus=$this->input->post('shtenadis');

                $this->MProject->insertPrjSheetStatus($proid,$masterprcid,$sheetstatus,false);

                $path = base_url('projects/'.$this->uri->segment(2).'/'.$proidnew.'/'.$prcessidnew);
                redirect($path);
            }
        }

        $data['engdata']=$this->MProject->getEngByPrjID($proid);
        if($prcessid!=0)        
        {
            $prcdatas=$this->MProject->getPrjPrcLst($prcessid);
            $data['prcdata']=$prcdatas[0]; 

            $checkListdatas=$this->MProject->getWTcheckList($prcessid);
            $checkList=$checkListdatas->result_array();
            if($checkListdatas->num_rows()>0)
            {
                $data['checkList']=$checkList[0];
                $chklstid=$checkList[0]['id'];
            }
            else
            {
                $data['checkList']=array();
                $chklstid=0;
            }
        }

        $data['prcessid']=$prcessid;
        $data['chklstid']=$chklstid;
        $data['sheetstatus']=$this->MProject->getPrjSheetStatus($proid,$masterprcid);
        $data['custom_side_menu'] = 'projprsmenu';
        $data['prodata']=$this->Common_model->getProductById($proid); 
        $data['sidemenu_sub_active'] = 'watertreatment';
        $data['sidemenu_sub_active1'] = $this->uri->segment(2);

        $this->load->view('common/header',$data);
        #echo '<pre>'; print_r($prodata); echo '</pre>';
        $this->load->view('projects/watertreatment/waterTreatmentChkList',$data);
        $this->load->view('common/footer');
    }
    public function waterTreatmentFlushVelo()
    {
        $this->exitpage('projects/projview');
        $proidnew = $this->uri->segment(3);
        $proid = intval($this->Common_model->decodeid($proidnew));        
        $data['proid'] = $proid;
        $prcessidnew = $this->uri->segment(4);
        $prcessid = intval($this->Common_model->decodeid($prcessidnew));
        if ($this->input->post('cancel'))
        {
            $path = base_url('projects/'.$this->uri->segment(2).'/'.$proidnew);
            redirect($path);
        }
        $masterprcid=22;        
        $data['title'] = 'Water Flushing Velocities';
        $data['masterprcid'] = $masterprcid;

        /*== Start Insert/Update ==*/
        if ($this->input->post('submit'))
        {

            $this->form_validation->set_rules('reportref', 'Ref', 'trim|required');
            $this->form_validation->set_rules('projsystem', 'System', 'trim|required');            
            $this->form_validation->set_rules('commairreptenggsign', 'Engineer', 'trim|required');
            
            if ($this->form_validation->run() == TRUE)
            {
                $created_date = date('Y-m-d H:i:s');

                if($prcessid==0)
                {

                    $ins_array1 = array(
                        'projectid' =>  $proid,
                        'processid' =>  $masterprcid,
                        'sheetnumber' => 0,                        
                        'system' => $this->input->post('projsystem'),                    
                        'referenceno' => $this->input->post('reportref'),
                        'comments'  =>  $this->input->post('commaircomments'),                        
                        'engineerid' => $this->input->post('commairreptenggsign'),
                        'reportdate' => date('Y-m-d H:i:s',strtotime($this->input->post('commairreptenggdate'))),
                        'createdon' => $created_date,
                        'createdby' => $this->session->userdata('userid')
                    );

                    $prcessid=$this->Common_model->insertPrjPrcMaster($ins_array1);
                    $prcessidnew = ($this->Common_model->encodeid($prcessid));

                    $insarray_batch=array();

                    //$procesSection_pdata=$this->input->post('procesSection');
                    $procesSectionCat_pdata=$this->input->post('cwdesignmeasured');

                    #echo '<pre>'; print_r($_POST); echo '</pre>';
                    #exit;

                    if(!empty($procesSectionCat_pdata))
                    {
                        foreach ($procesSectionCat_pdata as $psc_key => $psc_value) 
                        {                            
                            $insarray_batch[] = array(
                              'projectprocesslistmasterid' => $prcessid ,
                              'deinforefnum'   =>  $_POST['deinforefnum'][$psc_key],
                              'deinfomanuf' => $_POST['deinfomanuf'][$psc_key],
                              'deinfotype'=>$_POST['deinfotype'][$psc_key],
                              'deinfosizemm'=>$_POST['deinfosizemm'][$psc_key],
                              'deinfokvs'=>$_POST['deinfokvs'][$psc_key],
                              'deinforflowis'=>$_POST['deinforflowis'][$psc_key],
                              'deinfopdkpa'=>$_POST['deinfopdkpa'][$psc_key],
                              'measurpdkpa'=>$_POST['measurpdkpa'][$psc_key],
                              'measurflowis'=>$_POST['measurflowis'][$psc_key],
                              'measurpercen'=>$_POST['measurpercen'][$psc_key],
                              'createdon' => $created_date,
                              'createdby' => $this->session->userdata('userid')
                            );
                        }
                    }
                    #if(!empty($insarray_batch))
                    {
                        $this->db->insert_batch(WTFLUSHVELO, $insarray_batch);
                    }

                    //$this->Common_model->updateSequenceval(CAPRECK,'sheetnumber','projectid='.$proid,'id','ASC');
                    $this->Common_model->updateSequenceval(PRJPRCLST,'sheetnumber','projectid='.$proid.' and processid='.$masterprcid,'id','ASC');

                    $this->session->set_flashdata('project_message', 'New '.$data['title'].' has been created successfully...');
                }
                else
                {
                   
                    $update_array1 = array(
                        'system' => $this->input->post('projsystem'),                    
                        'referenceno' => $this->input->post('reportref'),
                        'comments' => $this->input->post('commaircomments'),
                        'engineerid' => $this->input->post('commairreptenggsign'),
                        'reportdate' => date('Y-m-d H:i:s',strtotime($this->input->post('commairreptenggdate'))),
                        'modifiedon' => $created_date,
                        'modifiedby' => $this->session->userdata('userid')
                    );

                    $this->Common_model->updatePrjPrcMaster($update_array1,$prcessid);
                    
                    $upsarray_batch=array();

                    $procesSectionCat_pdata=$this->input->post('cwdesignmeasured');

                    if(!empty($procesSectionCat_pdata))
                    {
                        foreach ($procesSectionCat_pdata as $psc_key => $psc_value) 
                        {
                            if($psc_value==0)
                            {
                                $insarray_batch[] = array(
                                  'projectprocesslistmasterid' => $prcessid ,
                                  'deinforefnum'   =>  $_POST['deinforefnum'][$psc_key],
                                  'deinfomanuf' => $_POST['deinfomanuf'][$psc_key],
                                  'deinfotype'=>$_POST['deinfotype'][$psc_key],
                                  'deinfosizemm'=>$_POST['deinfosizemm'][$psc_key],
                                  'deinfokvs'=>$_POST['deinfokvs'][$psc_key],
                                  'deinforflowis'=>$_POST['deinforflowis'][$psc_key],
                                  'deinfopdkpa'=>$_POST['deinfopdkpa'][$psc_key],
                                  'measurpdkpa'=>$_POST['measurpdkpa'][$psc_key],
                                  'measurflowis'=>$_POST['measurflowis'][$psc_key],
                                  'measurpercen'=>$_POST['measurpercen'][$psc_key],
                                  'createdon' => $created_date,
                                  'createdby' => $this->session->userdata('userid')
                                );
                            }
                            else
                            {
                                $upsarray_batch[] = array(
                                    'id'=>$psc_value,
                                    'projectprocesslistmasterid' => $prcessid ,
                                    'deinforefnum'   =>  $_POST['deinforefnum'][$psc_key],
                                    'deinfomanuf' => $_POST['deinfomanuf'][$psc_key],
                                    'deinfotype'=>$_POST['deinfotype'][$psc_key],
                                    'deinfosizemm'=>$_POST['deinfosizemm'][$psc_key],
                                    'deinfokvs'=>$_POST['deinfokvs'][$psc_key],
                                    'deinforflowis'=>$_POST['deinforflowis'][$psc_key],
                                    'deinfopdkpa'=>$_POST['deinfopdkpa'][$psc_key],
                                    'measurpdkpa'=>$_POST['measurpdkpa'][$psc_key],
                                    'measurflowis'=>$_POST['measurflowis'][$psc_key],
                                    'measurpercen'=>$_POST['measurpercen'][$psc_key],
                                    'modifiedon' => $created_date,
                                    'modifiedby' => $this->session->userdata('userid')
                                );
                            }

                        }
                    }

                    /* =========== Delete Grille === */

                    $grilledel_pdata=$this->input->post('grilledel');

                    if(!empty($grilledel_pdata))
                    {
                        foreach ($grilledel_pdata as $grd_key => $grd_value) 
                        {
                            if(intval($grd_value)!=0)
                            {
                                $this->db->where('id', $grd_value);
                                $this->db->delete(WTFLUSHVELO);
                            }
                        }
                    }


                    if(!empty($upsarray_batch))
                    {
                        $this->db->update_batch(WTFLUSHVELO, $upsarray_batch,'id');
                    }
                    if(!empty($insarray_batch))
                    {
                        $this->db->insert_batch(WTFLUSHVELO, $insarray_batch);
                    }

                    $this->session->set_flashdata('project_message', $data['title'].' has been updated successfully...');

                }

                $sheetstatus=$this->input->post('shtenadis');
                $this->MProject->insertPrjSheetStatus($proid,$masterprcid,$sheetstatus,false);

                $path = base_url('projects/'.$this->uri->segment(2).'/'.$proidnew.'/'.$prcessidnew);
                redirect($path);
            }
        }

        //$data['sidemenu'] = 'hide';
        $data['engdata']=$this->MProject->getEngByPrjID($proid);
        $wtflushvelostrdata=$this->MProject->getWTflushvelosdata($prcessid);

        if($prcessid!=0)        
        {
            $prcdatas=$this->MProject->getPrjPrcLst($prcessid);
            $data['prcdata']=$prcdatas[0];  
        }

        if($wtflushvelostrdata->num_rows()>0)
        {
            $data['wtflushvelostrdata']=$wtflushvelostrdata->result_array();
        }
        else
        {
            $data['wtflushvelostrdata']=array(
                array(
                    'id'=>0,
                    'projectprocesslistmasterid' => $prcessid ,
                    'deinforefnum'   =>  '',
                    'deinfomanuf' => '',
                    'deinfotype'=>'',
                    'deinfosizemm'=>'',
                    'deinfokvs'=>'',
                    'deinforflowis'=>'',
                    'deinfopdkpa'=>'',
                    'measurpdkpa'=>'',
                    'measurflowis'=>'',
                    'measurpercen'=>''
                )
            );
        }

        if($this->input->post('deinforefnum'))
        {
            $data['wtflushvelostrdata']=array();
            $value1=$this->input->post('deinforefnum');            
            foreach ($value1 as $key => $value) {
                $data['wtflushvelostrdata'][]=array(
                    'id'=>$_POST['cwdesignmeasured'][$key],
                    'projectprocesslistmasterid' => $prcessid,
                    'deinforefnum'   =>  $_POST['deinforefnum'][$key],
                    'deinfomanuf' => $_POST['deinfomanuf'][$key],
                    'deinfotype'=>$_POST['deinfotype'][$key],
                    'deinfosizemm'=>$_POST['deinfosizemm'][$key],
                    'deinfokvs'=>$_POST['deinfokvs'][$key],
                    'deinforflowis'=>$_POST['deinforflowis'][$key],
                    'deinfopdkpa'=>$_POST['deinfopdkpa'][$key],
                    'measurpdkpa'=>$_POST['measurpdkpa'][$key],
                    'measurflowis'=>$_POST['measurflowis'][$key],
                    'measurpercen'=>$_POST['measurpercen'][$key]
                );
            }

        }

        /*== End Insert/Update ==*/

        //$data['sidemenu'] = 'hide';
        $data['engdata']=$this->MProject->getEngByPrjID($proid);
        if($prcessid!=0)        
        {
            $prcdatas=$this->MProject->getPrjPrcLst($prcessid);
            $data['prcdata']=$prcdatas[0];
        }

        $data['prcessid']=$prcessid;
        $data['sheetstatus']=$this->MProject->getPrjSheetStatus($proid,$masterprcid);
        $data['custom_side_menu'] = 'projprsmenu';
        $data['prodata']=$this->Common_model->getProductById($proid); 
        $data['sidemenu_sub_active'] = 'commWater';
        $data['sidemenu_sub_active1'] = $this->uri->segment(2);
        $this->load->view('common/header',$data);
        #echo '<pre>'; print_r($prodata); echo '</pre>';
        $this->load->view('projects/watertreatment/waterTreatmentFlushVelo',$data);
        $this->load->view('common/footer');
    }
    public function waterTreatmentRptSht()
    {
        $this->exitpage('projects/projview');

        $proidnew = $this->uri->segment(3);
        $proid = intval($this->Common_model->decodeid($proidnew));        
        $data['proid'] = $proid;
        $prcessidnew = $this->uri->segment(4);
        $prcessid = intval($this->Common_model->decodeid($prcessidnew));
        
        if ($this->input->post('cancel'))
        {
            $path = base_url('projects/'.$this->uri->segment(2).'/'.$proidnew);
            redirect($path);
        }
        
        $data['title'] = 'Report Sheet';
        $masterprcid = 23;
        

         if ($this->input->post('submit'))
        {

            $this->form_validation->set_rules('reportref', 'Ref', 'trim|required');
            $this->form_validation->set_rules('projsystem', 'System', 'trim|required');            
            $this->form_validation->set_rules('commairreptenggsign', 'Engineer', 'trim|required');
            $this->form_validation->set_rules('commairreptcomments', 'Comments', 'trim|required');


            if ($this->form_validation->run() == TRUE)
            {
                $created_date = date('Y-m-d H:i:s');
               

                if($prcessid==0)
                {
                    $ins_array1 = array(
                        'projectid' =>  $proid,
                        'processid' => $masterprcid,
                        'sheetnumber' => 0,                        
                        'system' => $this->input->post('projsystem'),                    
                        'referenceno' => $this->input->post('reportref'),
                        'comments'  =>  '',                        
                        'engineerid' => $this->input->post('commairreptenggsign'),
                        'reportdate' => date('Y-m-d H:i:s',strtotime($this->input->post('commairreptenggdate'))),
                        'createdon' => $created_date,
                        'createdby' => $this->session->userdata('userid')
                    );

                    $prcessid=$this->Common_model->insertPrjPrcMaster($ins_array1);
                    $prcessidnew = ($this->Common_model->encodeid($prcessid));


                    $ins_array = array(
                        'projectprocesslistmasterid' => $prcessid,
                        'reportdescription' => $this->input->post('commairreptcomments'),
                        'createdon' => $created_date,
                        'createdby' => $this->session->userdata('userid')
                    );
                    
                    $this->db->insert(WTREPORTSHEET, $ins_array);                
                    $insert_id=$this->db->insert_id();

                    $this->Common_model->updateSequenceval(PRJPRCLST,'sheetnumber','projectid='.$proid.' and processid='.$masterprcid,'id','ASC');

                    $this->session->set_flashdata('project_message', 'Report has been created successfully...');
                }
                else
                {
                    $update_array1 = array(
                        'system' => $this->input->post('projsystem'),                    
                        'referenceno' => $this->input->post('reportref'),
                        'engineerid' => $this->input->post('commairreptenggsign'),
                        'reportdate' => date('Y-m-d H:i:s',strtotime($this->input->post('commairreptenggdate'))),
                        'modifiedon' => $created_date,
                        'modifiedby' => $this->session->userdata('userid')
                    );

                    $this->Common_model->updatePrjPrcMaster($update_array1,$prcessid);

                 
                    $update_array = array(
                        'reportdescription' => $this->input->post('commairreptcomments'),
                    );
                        
                    $this->db->where('projectProcessListMasterid', $prcessid);
                    $this->db->update(WTREPORTSHEET, $update_array);

                
                    $this->session->set_flashdata('project_message', 'Report has been updated successfully...');

                }

                $sheetstatus=$this->input->post('shtenadis');

                $this->MProject->insertPrjSheetStatus($proid,$masterprcid,$sheetstatus,false);

                $path = base_url('projects/waterTreatmentRptSht/'.$proidnew.'/'.$prcessidnew);
                redirect($path);
            }
        }

      
        if($prcessid!=0)        
        {
           // echo $prcessid;
            $prcdatas=$this->MProject->getWTreportsheet($prcessid);
            $ac = $data['prcdata']=$prcdatas[0];
            //$data['prcdata']=$this->MProject->getPrjPrcLst($prcessid)[0];

           // echo "<pre>"; 
          // print_r($ac);
        }

        $data['prcessid']=$prcessid;
        $data['masterprcid']=$masterprcid;
        $data['sheetstatus']=$this->MProject->getPrjSheetStatus($proid,$masterprcid);
        
        $data['custom_side_menu'] = 'projprsmenu';
        
        $data['prodata']=$this->Common_model->getProductById($proid);

        $data['engdata']=$this->MProject->getEngByPrjID($proid);

        $data['sidemenu_sub_active'] = 'commAir';
        $data['sidemenu_sub_active1'] = $this->uri->segment(2);
        //$data['sidemenu'] = 'hide';
        $this->load->view('common/header',$data);
        #echo '<pre>'; print_r($prodata); echo '</pre>';
        $this->load->view('projects/watertreatment/waterTreatmentRptSht',$data);
        $this->load->view('common/footer');
    }
    public function waterTreatmentTempcer()
    {
        $this->exitpage('projects/projview');
        
        $proidnew = $this->uri->segment(3);
        $proid = intval($this->Common_model->decodeid($proidnew));        
        $data['proid'] = $proid;
        $prcessidnew = $this->uri->segment(4);
        $prcessid = intval($this->Common_model->decodeid($prcessidnew));

        if ($this->input->post('cancel'))
        {
            $path = base_url('projects/'.$this->uri->segment(2).'/'.$proidnew);
            redirect($path);
        }
        
        $data['title'] = 'Temporary Certificate of Disinfection/Chlorination';
        $masterprcid = 24;
        

        if($prcessid==0)
        {
            //getPrjPrcLst
            $getprolist=$this->MProject->getProcessMaster($proid,$masterprcid);
            //$getprolistdata=$getprolist->result_array();            
            if($getprolist->num_rows()>0)
            {
                $getprolistdata=$getprolist->result_array();
                $gettempvert=$this->MProject->getWTtempCettificate($getprolistdata[0]['id']);
                $gettempvertdata=$gettempvert;
                $prcessid=$gettempvertdata[0]['projectprocesslistmasterid'];
                $path = base_url('projects/waterTreatmentTempcer/'.$proid.'/'.$prcessid);
                redirect($path);

            }
        }



        if ($this->input->post('submit'))
        {

            $this->form_validation->set_rules('reportref', 'Ref', 'trim|required');            
            $this->form_validation->set_rules('commairreptenggsign', 'Engineer', 'trim|required');
            $this->form_validation->set_rules('contractname', 'Contract Name', 'trim|required');

            if($_POST['accord1']==""||$_POST['accord2']=="")
            {
                $this->form_validation->set_rules('accord', 'Accordance', 'required');                
            }
            
            if ($this->form_validation->run() == TRUE)
            {
                $created_date = date('Y-m-d H:i:s');
                if($prcessid==0)
                {

                    $ins_array1 = array(
                        'projectid' =>  $proid,
                        'processid' =>  $masterprcid,
                        'sheetnumber' => 0,                        
                        'system' => 0,                    
                        'referenceno' => $this->input->post('reportref'),
                        'comments'  =>  $this->input->post('commaircomments'),                        
                        'engineerid' => $this->input->post('commairreptenggsign'),
                        'reportdate' => date('Y-m-d H:i:s',strtotime($this->input->post('commairreptenggdate'))),
                        'createdon' => $created_date,
                        'createdby' => $this->session->userdata('userid')
                    );

                    $prcessid=$this->Common_model->insertPrjPrcMaster($ins_array1);
                    $prcessidnew = ($this->Common_model->encodeid($prcessid));

                    $ins_array2=array(
                        'projectprocesslistmasterid'=>$prcessid,
                        'contractname'=>$this->input->post('contractname'),
                        'accord1'=>$this->input->post('accord1'),
                        'accord2'=>$this->input->post('accord2'),
                        'createdon' => $created_date,
                        'createdby' => $this->session->userdata('userid')
                    );

                    $this->db->insert(WTTEMPCERT,$ins_array2);



                    //$this->Common_model->updateSequenceval(CAPRECK,'sheetnumber','projectid='.$proid,'id','ASC');
                    $this->Common_model->updateSequenceval(PRJPRCLST,'sheetnumber','projectid='.$proid.' and processid='.$masterprcid,'id','ASC');

                    $this->session->set_flashdata('project_message', 'New '.$data['title'].' has been created successfully...');
                }
                else
                {
                    $update_array1 = array(
                        'referenceno' => $this->input->post('reportref'),
                        'comments' => $this->input->post('commaircomments'),
                        'engineerid' => $this->input->post('commairreptenggsign'),
                        'reportdate' => date('Y-m-d H:i:s',strtotime($this->input->post('commairreptenggdate'))),
                        'modifiedon' => $created_date,
                        'modifiedby' => $this->session->userdata('userid')
                    );

                    $this->Common_model->updatePrjPrcMaster($update_array1,$prcessid);
                    
                    /* ================== Update Query ================== */

                    $ins_array2=array(
                        'contractname'=>$this->input->post('contractname'),
                        'accord1'=>$this->input->post('accord1'),
                        'accord2'=>$this->input->post('accord2'),
                        'modifiedon' => $created_date,
                        'modifiedby' => $this->session->userdata('userid')
                    );
                    $this->db->where('projectprocesslistmasterid',$prcessid);
                    $this->db->update(WTTEMPCERT,$ins_array2);

                    $this->session->set_flashdata('project_message', $data['title'].' has been updated successfully...');

                }

                $sheetstatus=$this->input->post('shtenadis');
                $this->MProject->insertPrjSheetStatus($proid,$masterprcid,$sheetstatus,false);

                $path = base_url('projects/waterTreatmentTempcer/'.$proidnew.'/'.$prcessidnew);
                redirect($path);
            }
        }

      
        if($prcessid!=0)        
        {
           // echo $prcessid;
            $prcdatas=$this->MProject->getWTtempCettificate($prcessid);
            $data['prcdata']=$prcdatas[0];
            //$data['prcdata']=$this->MProject->getPrjPrcLst($prcessid)[0];

           // echo "<pre>"; 
          // print_r($ac);
        }

        $data['prcessid']=$prcessid;
        $data['masterprcid']=$masterprcid;
        $data['sheetstatus']=$this->MProject->getPrjSheetStatus($proid,$masterprcid);
        
        $data['custom_side_menu'] = 'projprsmenu';
        
        $data['prodata']=$this->Common_model->getProductById($proid);



        $data['engdata']=$this->MProject->getEngByPrjID($proid);

        $data['sidemenu_sub_active'] = 'watertreatment';
        $data['sidemenu_sub_active1'] = $this->uri->segment(2);

        $this->load->view('common/header',$data);
        //echo '<pre>'; print_r($prodata); echo '</pre>';
        $this->load->view('projects/watertreatment/waterTreatmentTempcer',$data);
        $this->load->view('common/footer',$data);
    }
    public function waterTreatmentMaChlorin()
    {
        $this->exitpage('projects/projview');
        $proidnew = $this->uri->segment(3);
        $proid = intval($this->Common_model->decodeid($proidnew));        
        $data['proid'] = $proid;
        $prcessidnew = $this->uri->segment(4);
        $prcessid = intval($this->Common_model->decodeid($prcessidnew)); 
        if ($this->input->post('cancel'))
        {
            $path = base_url('projects/'.$this->uri->segment(2).'/'.$proidnew);
            redirect($path);
        }
        
        $data['title'] = 'Certificate of Mains Chlorination';
        $masterprcid = 25;
        


        if ($this->input->post('submit'))
        {

            $this->form_validation->set_rules('reportref', 'Ref', 'trim|required');            
            $this->form_validation->set_rules('projsystem', 'System', 'trim|required');            
            $this->form_validation->set_rules('commairreptenggsign', 'Engineer', 'trim|required');
            $this->form_validation->set_rules('contractname', 'Contract Name', 'trim|required');
            
            if ($this->form_validation->run() == TRUE)
            {

                $created_date = date('Y-m-d H:i:s');
                if($prcessid==0)
                {

                    $ins_array1 = array(
                        'projectid' =>  $proid,
                        'processid' =>  $masterprcid,
                        'sheetnumber' => 0,                        
                        'system' => $this->input->post('projsystem'),                    
                        'referenceno' => $this->input->post('reportref'),
                        'comments'  =>  '',                        
                        'engineerid' => $this->input->post('commairreptenggsign'),
                        'reportdate' => date('Y-m-d H:i:s',strtotime($this->input->post('commairreptenggdate'))),
                        'createdon' => $created_date,
                        'createdby' => $this->session->userdata('userid')
                    );

                    $prcessid=$this->Common_model->insertPrjPrcMaster($ins_array1);
                    $prcessidnew = ($this->Common_model->encodeid($prcessid));

                    $contactime1=$this->input->post('contactime');
                    $contactime2=$this->input->post('contactime1');
                    $contactime=intval($contactime1).':'.intval($contactime2);

                    $flushtimeclr1=$this->input->post('flushtimeclr');
                    $flushtimeclr2=$this->input->post('flushtimeclr1');
                    $flushtimeclr=intval($flushtimeclr1).':'.intval($flushtimeclr2);

                    $ins_array2=array(
                        'projectprocesslistmasterid'=>$prcessid,
                        'contractname'=>$this->input->post('contractname'),
                        'lebref'=>$this->input->post('lebref'),
                        'smppoint'=>$this->input->post('smppoint'),
                        'pilen1'=>$this->input->post('pilen1'),
                        'pilen2'=>$this->input->post('pilen2'),
                        'pidiameter1'=>$this->input->post('pidiameter1'),
                        'pidiameter2'=>$this->input->post('pidiameter2'),
                        'flushrate1'=>$this->input->post('flushrate1'),
                        'flushrate2'=>$this->input->post('flushrate2'),
                        'disinfection_used'=>$this->input->post('disinfection_used'),
                        'levelsourcewater1'=>$this->input->post('levelsourcewater1'),
                        'levelsourcewater2'=>$this->input->post('levelsourcewater2'),
                        'levelafterdosing1'=>$this->input->post('levelafterdosing1'),
                        'levelafterdosing2'=>$this->input->post('levelafterdosing2'),
                        'contactime'=>$contactime,
                        'levelaftercontact1'=>$this->input->post('levelaftercontact1'),
                        'levelaftercontact2'=>$this->input->post('levelaftercontact2'),
                        'resiafterflush1'=>$this->input->post('resiafterflush1'),
                        'resiafterflush2'=>$this->input->post('resiafterflush2'),
                        'flushtimeclr'=>$flushtimeclr,
                        'onsitetasterst'=>$this->input->post('onsitetasterst'),
                        'onsiteodourrst'=>$this->input->post('onsiteodourrst'),
                        'tvc3'=>$this->input->post('tvc3'),
                        'tvc2'=>$this->input->post('tvc2'),
                        'coliforms'=>$this->input->post('coliforms'),
                        'ecoil'=>$this->input->post('ecoil'),
                        'createdon' => $created_date,
                        'createdby' => $this->session->userdata('userid')
                    );

                    $this->db->insert(WTCHLORINCERT,$ins_array2);

                    //$this->Common_model->updateSequenceval(CAPRECK,'sheetnumber','projectid='.$proid,'id','ASC');
                    $this->Common_model->updateSequenceval(PRJPRCLST,'sheetnumber','projectid='.$proid.' and processid='.$masterprcid,'id','ASC');

                    $this->session->set_flashdata('project_message', 'New '.$data['title'].' has been created successfully...');
                }
                else
                {
                    $update_array1 = array(
                        'system' => $this->input->post('projsystem'),
                        'referenceno' => $this->input->post('reportref'),
                        'engineerid' => $this->input->post('commairreptenggsign'),
                        'reportdate' => date('Y-m-d H:i:s',strtotime($this->input->post('commairreptenggdate'))),
                        'modifiedon' => $created_date,
                        'modifiedby' => $this->session->userdata('userid')
                    );

                    $this->Common_model->updatePrjPrcMaster($update_array1,$prcessid);
                    
                    /* ================== Update Query ================== */

                    $contactime1=$this->input->post('contactime');
                    $contactime2=$this->input->post('contactime1');
                    $contactime=intval($contactime1).':'.intval($contactime2);

                    $flushtimeclr1=$this->input->post('flushtimeclr');
                    $flushtimeclr2=$this->input->post('flushtimeclr1');
                    $flushtimeclr=intval($flushtimeclr1).':'.intval($flushtimeclr2);

                    $ins_array2=array(
                        'contractname'=>$this->input->post('contractname'),
                        'lebref'=>$this->input->post('lebref'),
                        'smppoint'=>$this->input->post('smppoint'),
                        'pilen1'=>$this->input->post('pilen1'),
                        'pilen2'=>$this->input->post('pilen2'),
                        'pidiameter1'=>$this->input->post('pidiameter1'),
                        'pidiameter2'=>$this->input->post('pidiameter2'),
                        'flushrate1'=>$this->input->post('flushrate1'),
                        'flushrate2'=>$this->input->post('flushrate2'),
                        'disinfection_used'=>$this->input->post('disinfection_used'),
                        'levelsourcewater1'=>$this->input->post('levelsourcewater1'),
                        'levelsourcewater2'=>$this->input->post('levelsourcewater2'),
                        'levelafterdosing1'=>$this->input->post('levelafterdosing1'),
                        'levelafterdosing2'=>$this->input->post('levelafterdosing2'),
                        'contactime'=>$contactime,
                        'levelaftercontact1'=>$this->input->post('levelaftercontact1'),
                        'levelaftercontact2'=>$this->input->post('levelaftercontact2'),
                        'resiafterflush1'=>$this->input->post('resiafterflush1'),
                        'resiafterflush2'=>$this->input->post('resiafterflush2'),
                        'flushtimeclr'=>$flushtimeclr,
                        'onsitetasterst'=>$this->input->post('onsitetasterst'),
                        'onsiteodourrst'=>$this->input->post('onsiteodourrst'),
                        'tvc3'=>$this->input->post('tvc3'),
                        'tvc2'=>$this->input->post('tvc2'),
                        'coliforms'=>$this->input->post('coliforms'),
                        'ecoil'=>$this->input->post('ecoil'),
                        'modifiedon' => $created_date,
                        'modifiedby' => $this->session->userdata('userid')
                    );
                    $this->db->where('projectprocesslistmasterid',$prcessid);
                    $this->db->update(WTCHLORINCERT,$ins_array2);
                    $this->session->set_flashdata('project_message', $data['title'].' has been updated successfully...');

                }

                $sheetstatus=$this->input->post('shtenadis');
                $this->MProject->insertPrjSheetStatus($proid,$masterprcid,$sheetstatus,false);

                $path = base_url('projects/waterTreatmentMaChlorin/'.$proidnew.'/'.$prcessidnew);
                redirect($path);
            }
        }

      
        if($prcessid!=0)        
        {
           // echo $prcessid;
            $prcdatas=$this->MProject->getPrjPrcLst($prcessid);
            $data['prcdata']=$prcdatas[0];

            $mainChlorin=$this->MProject->getMainChlorin($prcessid);
            $data['mainChlorin']=$mainChlorin[0];


            //$data['prcdata']=$this->MProject->getPrjPrcLst($prcessid)[0];

           // echo "<pre>"; 
          // print_r($ac);
        }

        $data['prcessid']=$prcessid;
        $data['masterprcid']=$masterprcid;
        $data['sheetstatus']=$this->MProject->getPrjSheetStatus($proid,$masterprcid);
        
        $data['custom_side_menu'] = 'projprsmenu';
        
        $data['prodata']=$this->Common_model->getProductById($proid);



        $data['engdata']=$this->MProject->getEngByPrjID($proid);

        $data['sidemenu_sub_active'] = 'commAir';
        $data['sidemenu_sub_active1'] = $this->uri->segment(2);

        $this->load->view('common/header',$data);
        $this->load->view('projects/watertreatment/waterTreatmentMaChlorin',$data);
        $this->load->view('common/footer',$data);
    }

    /* ========================== Commissioning Water ============================== */

    public function commWater()
    {
        $this->exitpage('projects/projview');    
        
        $proidnew = $this->uri->segment(3);
        $proid = intval($this->Common_model->decodeid($proidnew));        
        $data['proid'] = $proid;
        $prcessidnew = $this->uri->segment(4);
        $prcessid = intval($this->Common_model->decodeid($prcessidnew));

        if ($this->input->post('cancel'))
        {
            $path = base_url('projects/'.$this->uri->segment(2).'/'.$proidnew);
            redirect($path);
        }
        
        $masterprcid = 12;                
        $data['title'] = 'System Witness Certificate';
        $data['masterprcid'] = $masterprcid;
        //$data['sidemenu'] = 'hide';

        if ($this->input->post('submit'))
        {

            $this->form_validation->set_rules('reportref', 'Ref', 'trim|required');
            $this->form_validation->set_rules('projsystem', 'System', 'trim|required');            
            $this->form_validation->set_rules('commaircomments', 'Comments', 'trim|required');

            if ($this->form_validation->run() == TRUE)
            {
                $created_date = date('Y-m-d H:i:s');

                if($prcessid==0)
                {
                    $ins_array1 = array(
                        'module_name' =>  'water',
                        'projectid' =>  $proid,
                        'processid' =>  $masterprcid,
                        'sheetnumber' => 0,                        
                        'system' => $this->input->post('projsystem'),                    
                        'referenceno' => $this->input->post('reportref'),
                        'comments'  =>  $this->input->post('commaircomments'),                        
                        'engineerid' => 0,
                        'reportdate' => $created_date,
                        'createdon' => $created_date,
                        'createdby' => $this->session->userdata('userid')
                    );

                    $prcessid=$this->Common_model->insertPrjPrcMaster($ins_array1);
                    $prcessidnew = ($this->Common_model->encodeid($prcessid));


                    $ins_array = array(
                        'projectprocesslistmasterid' => $prcessid,
                        'projectsystemid' => $this->input->post('projsystem'),
                        'witnessdate'=> date(SQL_FORMAT, strtotime($this->input->post('commairwitdate'))),
                        'servicecontractdate' => date(SQL_FORMAT, strtotime($this->input->post('commairtestcompdate'))),
                        'createdon' => $created_date,
                        'createdby' => $this->session->userdata('userid')
                    );
                    
                    $this->db->insert(CWSYSWTCRT, $ins_array);                
                    $insert_id=$this->db->insert_id();

                     $this->Common_model->updateSequenceval(PRJPRCLST,'sheetnumber','projectid='.$proid.' and processid='.$masterprcid,'id','ASC');

                    $this->session->set_flashdata('project_message', 'New '.$data['title'].' has been created successfully...');
                }
                else
                {
                    $update_array1 = array(
                        'system' => $this->input->post('projsystem'),                    
                        'referenceno' => $this->input->post('reportref'),
                        'comments'  =>  $this->input->post('commaircomments'),
                        'modifiedon' => $created_date,
                        'modifiedby' => $this->session->userdata('userid')
                    );

                    $this->Common_model->updatePrjPrcMaster($update_array1,$prcessid);
                    
                    $update_array=array(
                        'projectsystemid' => $this->input->post('projsystem'),
                        'witnessdate'=> date(SQL_FORMAT, strtotime($this->input->post('commairwitdate'))),
                        'servicecontractdate' => date(SQL_FORMAT, strtotime($this->input->post('commairtestcompdate'))),
                        'modifiedon' => $created_date,
                        'modifiedby' => $this->session->userdata('userid')
                    );

                    $this->db->where('projectprocesslistmasterid', $prcessid);
                    $this->db->update(CWSYSWTCRT, $update_array);

                    $this->session->set_flashdata('project_message', $data['title'].' has been updated successfully...');

                }

                $sheetstatus=$this->input->post('shtenadis');

                $this->MProject->insertPrjSheetStatus($proid,$masterprcid,$sheetstatus,false);

                $path = base_url('projects/commWater/'.$proidnew.'/'.$prcessidnew);
                redirect($path);
            }
        }

        $data['engdata']=$this->MProject->getEngByPrjID($proid);
        if($prcessid!=0)        
        {
            $prcdatas=$this->MProject->getCWsyscertificate($prcessid);
            $data['prcdata']=$prcdatas[0];
        }

        $data['prcessid']=$prcessid;
        $data['sheetstatus']=$this->MProject->getPrjSheetStatus($proid,$masterprcid);
        $data['custom_side_menu'] = 'projprsmenu';
        $data['prodata']=$this->Common_model->getProductById($proid); 
        $data['sidemenu_sub_active'] = 'commWater';
        $data['sidemenu_sub_active1'] = $this->uri->segment(2);
        $this->load->view('common/header',$data);
        $this->load->view('projects/commWater/commWater',$data);
        $this->load->view('common/footer');
    }
    
    public function commWaterRptSht()
    {
        $this->exitpage('projects/projview');

        $proidnew = $this->uri->segment(3);
        $proid = intval($this->Common_model->decodeid($proidnew));        
        $data['proid'] = $proid;
        $prcessidnew = $this->uri->segment(4);
        $prcessid = intval($this->Common_model->decodeid($prcessidnew));        

        $data['title'] = 'Report Sheet';
        $masterprcid = 13;
        

         if ($this->input->post('submit'))
        {

            $this->form_validation->set_rules('reportref', 'Ref', 'trim|required');
            $this->form_validation->set_rules('projsystem', 'System', 'trim|required');            
            $this->form_validation->set_rules('commairreptenggsign', 'Engineer', 'trim|required');
            $this->form_validation->set_rules('commairreptcomments', 'Comments', 'trim|required');


            if ($this->form_validation->run() == TRUE)
            {
                $created_date = date('Y-m-d H:i:s');
               

                if($prcessid==0)
                {
                    $ins_array1 = array(
                        'module_name' =>  'water',
                        'projectid' =>  $proid,
                        'processid' => $masterprcid,
                        'sheetnumber' => 0,                        
                        'system' => $this->input->post('projsystem'),                    
                        'referenceno' => $this->input->post('reportref'),
                        'comments'  =>  '',                        
                        'engineerid' => $this->input->post('commairreptenggsign'),
                        'reportdate' => date('Y-m-d H:i:s',strtotime($this->input->post('commairreptenggdate'))),
                        'createdon' => $created_date,
                        'createdby' => $this->session->userdata('userid')
                    );

                    $prcessid=$this->Common_model->insertPrjPrcMaster($ins_array1);
                    $prcessidnew = ($this->Common_model->encodeid($prcessid));


                    $ins_array = array(
                        'projectprocesslistmasterid' => $prcessid,
                        'reportdescription' => $this->input->post('commairreptcomments'),
                        'createdon' => $created_date,
                        'createdby' => $this->session->userdata('userid')
                    );
                    
                    $this->db->insert(CWREPORTSHEET, $ins_array);                
                    $insert_id=$this->db->insert_id();

                    $this->Common_model->updateSequenceval(PRJPRCLST,'sheetnumber','projectid='.$proid.' and processid='.$masterprcid,'id','ASC');

                    $this->session->set_flashdata('project_message', 'Report has been created successfully...');
                }
                else
                {
                    $update_array1 = array(
                        'system' => $this->input->post('projsystem'),                    
                        'referenceno' => $this->input->post('reportref'),
                        'engineerid' => $this->input->post('commairreptenggsign'),
                        'reportdate' => date('Y-m-d H:i:s',strtotime($this->input->post('commairreptenggdate'))),
                        'modifiedon' => $created_date,
                        'modifiedby' => $this->session->userdata('userid')
                    );

                    $this->Common_model->updatePrjPrcMaster($update_array1,$prcessid);

                 
                    $update_array = array(
                        'reportdescription' => $this->input->post('commairreptcomments'),
                    );
                        
                    $this->db->where('projectProcessListMasterid', $prcessid);
                    $this->db->update(CWREPORTSHEET, $update_array);

                
                    $this->session->set_flashdata('project_message', 'Report has been updated successfully...');

                }

                $sheetstatus=$this->input->post('shtenadis');

                $this->MProject->insertPrjSheetStatus($proid,$masterprcid,$sheetstatus,false);

                $path = base_url('projects/commWaterRptSht/'.$proidnew.'/'.$prcessidnew);
                redirect($path);
            }
        }

      
        if($prcessid!=0)        
        {
           // echo $prcessid;
            $prcdatas=$this->MProject->getcwreportsheet($prcessid);
            $ac = $data['prcdata']=$prcdatas[0];
            //$data['prcdata']=$this->MProject->getPrjPrcLst($prcessid)[0];

           // echo "<pre>"; 
          // print_r($ac);
        }

        $data['prcessid']=$prcessid;
        $data['masterprcid']=$masterprcid;
        $data['sheetstatus']=$this->MProject->getPrjSheetStatus($proid,$masterprcid);
        
        $data['custom_side_menu'] = 'projprsmenu';
        
        $data['prodata']=$this->Common_model->getProductById($proid);

        $data['engdata']=$this->MProject->getEngByPrjID($proid);

        $data['sidemenu_sub_active'] = 'commWater';
        $data['sidemenu_sub_active1'] = $this->uri->segment(2);
        $this->load->view('common/header',$data);
        $this->load->view('projects/commWater/commWaterRptSht',$data);
        $this->load->view('common/footer');


    }

    public function commWaterSysSchem()
    {
        $this->exitpage('projects/projview');
        
        $proidnew = $this->uri->segment(3);
        $proid = intval($this->Common_model->decodeid($proidnew));        
        $data['proid'] = $proid;
        $prcessidnew = $this->uri->segment(4);
        $prcessid = intval($this->Common_model->decodeid($prcessidnew));

        if ($this->input->post('cancel'))
        {
            $path = base_url('projects/'.$this->uri->segment(2).'/'.$proidnew);
            redirect($path);
        }
        $masterprcid = 14;                
        $data['title'] = 'System Schematic';
        $data['masterprcid'] = $masterprcid;
        $getsysFilesdata=array();

        $getsysFiles=$this->MProject->getsysFilesPrzid(intval($prcessid),CWSYSSCHE);  

        if($getsysFiles->num_rows()>0)
        {
            $getsysFilesdata=$getsysFiles->result_array();
        }

        if ($this->input->post('submit'))
        {

            $this->form_validation->set_rules('reportref', 'Ref', 'trim|required');
            $this->form_validation->set_rules('projsystem', 'System', 'trim|required');            
            $this->form_validation->set_rules('commairreptenggsign', 'Engineer', 'trim|required');

            if($prcessid==0)
            {
                $this->form_validation->set_rules('uploadfile', 'Upload File', 'callback_checksyschefile');
            }
            else
            {     

                $ckemtyval=$_FILES['uploadfile']['name'];                                              
                if(isset($_FILES['uploadfile']) && !empty($ckemtyval) && ($getsysFiles->num_rows()==0))
                {
                    //$this->form_validation->set_rules('uploadfile', '', 'callback_casyschefilecheck');
                    $this->form_validation->set_rules('uploadfile', 'Upload File', 'callback_checksyschefile');
                }
               

            }
            

            if ($this->form_validation->run() == TRUE)
            {
                $created_date = date('Y-m-d H:i:s');
                $mime = ($_FILES['uploadfile']['type']);

                if($this->input->post('delfiles'))
                {
                    $delfiles_query=array(
                        'isdeleted'=>'A',
                        'modifiedon' => $created_date,
                        'modifiedby' => $this->session->userdata('userid')
                    );
                    $delfiles=$this->input->post('delfiles');
                    if(!empty($delfiles))
                    {
                        foreach ($delfiles as $key => $value) {
                            $this->db->where('id', intval($value));
                            $this->db->update(CWSYSSCHE, $delfiles_query);
                        }
                        
                    }
                }

                if($prcessid==0)
                {
                    $ins_array1 = array(
                        'module_name' =>  'water',
                        'projectid' =>  $proid,
                        'processid' =>  $masterprcid,
                        'sheetnumber' => 0,                        
                        'system' => $this->input->post('projsystem'),                    
                        'referenceno' => $this->input->post('reportref'),
                        'comments'  =>  '',                        
                        'engineerid' => $this->input->post('commairreptenggsign'),
                        'reportdate' => date('Y-m-d H:i:s',strtotime($this->input->post('commairreptenggdate'))),
                        'createdon' => $created_date,
                        'createdby' => $this->session->userdata('userid')
                    );

                    $prcessid=$this->Common_model->insertPrjPrcMaster($ins_array1);
                    $prcessidnew = ($this->Common_model->encodeid($prcessid));

                    $ckemtyval=$_FILES['uploadfile']['name'];

                    if(isset($_FILES['uploadfile']) && !empty($ckemtyval))
                    {
                        $uploadData=array(
                            "orig_name"=>'',
                            "file_name"=>''
                        );

                        $filesCount = count($_FILES['uploadfile']['name']);                        
                        for($i = 0; $i < $filesCount; $i++){
                            $_FILES['userFile']['name'] = $_FILES['uploadfile']['name'][$i];
                            $_FILES['userFile']['type'] = $_FILES['uploadfile']['type'][$i];
                            $_FILES['userFile']['tmp_name'] = $_FILES['uploadfile']['tmp_name'][$i];
                            $_FILES['userFile']['error'] = $_FILES['uploadfile']['error'][$i];
                            $_FILES['userFile']['size'] = $_FILES['uploadfile']['size'][$i];

                            $mime = ($_FILES['uploadfile']['type'][$i]);
                            $filesize=$_FILES['uploadfile']['size'][$i];

                            $config['upload_path']   = DROOT.UPATH;
                            $config['allowed_types'] = 'gif|jpg|png|pdf';
                            $config['encrypt_name'] = TRUE;
                            //$config['allowed_types'] = 'gif|jpg|png';
                            
                            $this->load->library('upload', $config);
                            $this->upload->initialize($config);
                            if($this->upload->do_upload('userFile')){
                                
                                $uploadData = $this->upload->data();
                                $uploadedFile = $uploadData['file_name'];

                                chmod(DROOT.UPATH.$uploadData['file_name'],0777); // CHMOD file

                                $ins_array = array(
                                    'projectprocesslistmasterid' => $prcessid,
                                    'filename' => $uploadData['orig_name'],
                                    'filestorename'=>$uploadData['file_name'],
                                    'filetype' => $mime,
                                    'filesize'  => $filesize,
                                    'filestoredpath' => $config['upload_path'].$uploadData['file_name'],
                                    'createdon' => $created_date,
                                    'createdby' => $this->session->userdata('userid')
                                );
                                
                                $this->db->insert(CWSYSSCHE, $ins_array);                
                                $insert_id=$this->db->insert_id();

                            }
                        }
                    }
                    $this->Common_model->updateSequenceval(PRJPRCLST,'sheetnumber','projectid='.$proid.' and processid='.$masterprcid,'id','ASC');
                    $this->session->set_flashdata('project_message', 'New System Schematic has been created successfully...');
                }
                else
                {
                    $update_array1 = array(
                        'system' => $this->input->post('projsystem'),                    
                        'referenceno' => $this->input->post('reportref'),
                        'engineerid' => $this->input->post('commairreptenggsign'),
                        'reportdate' => date('Y-m-d H:i:s',strtotime($this->input->post('commairreptenggdate'))),
                        'modifiedon' => $created_date,
                        'modifiedby' => $this->session->userdata('userid')
                    );

                    $this->Common_model->updatePrjPrcMaster($update_array1,$prcessid);

                    if(isset($_FILES['uploadfile']) && !empty($ckemtyval))
                    {
                        $uploadData=array(
                            "orig_name"=>'',
                            "file_name"=>''
                        );

                        $filesCount = count($_FILES['uploadfile']['name']);                        
                        for($i = 0; $i < $filesCount; $i++){
                            $_FILES['userFile']['name'] = $_FILES['uploadfile']['name'][$i];
                            $_FILES['userFile']['type'] = $_FILES['uploadfile']['type'][$i];
                            $_FILES['userFile']['tmp_name'] = $_FILES['uploadfile']['tmp_name'][$i];
                            $_FILES['userFile']['error'] = $_FILES['uploadfile']['error'][$i];
                            $_FILES['userFile']['size'] = $_FILES['uploadfile']['size'][$i];

                            $mime = ($_FILES['uploadfile']['type'][$i]);
                            $filesize=$_FILES['uploadfile']['size'][$i];

                            $config['upload_path']   = DROOT.UPATH;
                            $config['allowed_types'] = 'gif|jpg|png|pdf';
                            $config['encrypt_name'] = TRUE;
                            //$config['allowed_types'] = 'gif|jpg|png';
                            
                            $this->load->library('upload', $config);
                            $this->upload->initialize($config);
                            if($this->upload->do_upload('userFile')){
                                
                                $uploadData = $this->upload->data();
                                $uploadedFile = $uploadData['file_name'];

                                chmod(DROOT.UPATH.$uploadData['file_name'],0777); // CHMOD file

                                $ins_array = array(
                                    'projectprocesslistmasterid' => $prcessid,
                                    'filename' => $uploadData['orig_name'],
                                    'filestorename'=>$uploadData['file_name'],
                                    'filetype' => $mime,
                                    'filesize'  => $filesize,
                                    'filestoredpath' => $config['upload_path'].$uploadData['file_name'],
                                    'createdon' => $created_date,
                                    'createdby' => $this->session->userdata('userid')
                                );
                                
                                $this->db->insert(CWSYSSCHE, $ins_array);                
                                $insert_id=$this->db->insert_id();

                            }
                        }
                    }

                    $this->session->set_flashdata('project_message', 'System Schematic has been updated successfully...');

                }

                $sheetstatus=$this->input->post('shtenadis');

                $this->MProject->insertPrjSheetStatus($proid,$masterprcid,$sheetstatus,false);

                $path = base_url('projects/commWaterSysSchem/'.$proidnew.'/'.$prcessidnew);
                redirect($path);
            }
        }

        //$data['sidemenu'] = 'hide';
        $data['engdata']=$this->MProject->getEngByPrjID($proid);
        if($prcessid!=0)        
        {
            $prcdatas=$this->MProject->getCWsysscheme($prcessid);
            $data['prcdata']=$prcdatas[0];
            //$data['prcdata']=$this->MProject->getPrjPrcLst($prcessid)[0];
        }

        $data['prcessid']=$prcessid;
        $data['getsysFilesdata']=$getsysFilesdata;
        $data['sheetstatus']=$this->MProject->getPrjSheetStatus($proid,$masterprcid);
        $data['custom_side_menu'] = 'projprsmenu';
        $data['prodata']=$this->Common_model->getProductById($proid); 
        $data['sidemenu_sub_active'] = 'commWater';
        $data['sidemenu_sub_active1'] = $this->uri->segment(2);
        $this->load->view('common/header',$data);
        $this->load->view('projects/commWater/commWaterSysSchem',$data);
        $this->load->view('common/footer');
    }

    public function commWaterPreComm()
    {
        $this->exitpage('projects/projview');
        $proidnew = $this->uri->segment(3);
        $proid = intval($this->Common_model->decodeid($proidnew));        
        $data['proid'] = $proid;
        $prcessidnew = $this->uri->segment(4);
        $prcessid = intval($this->Common_model->decodeid($prcessidnew));         
        if ($this->input->post('cancel'))
        {
            $path = base_url('projects/'.$this->uri->segment(2).'/'.$proidnew);
            redirect($path);
        }
        $masterprcid=15;        
        $data['title'] = 'Water System Pre-Commissioning Checks';
        $data['masterprcid'] = $masterprcid;
        if ($this->input->post('submit'))
        {

            $this->form_validation->set_rules('reportref', 'Ref', 'trim|required');
            $this->form_validation->set_rules('projsystem', 'System', 'trim|required');            
            $this->form_validation->set_rules('commairreptenggsign', 'Engineer', 'trim|required');
            
            if ($this->form_validation->run() == TRUE)
            {
                $created_date = date('Y-m-d H:i:s');

                if($prcessid==0)
                {

                    $ins_array1 = array(
                        'projectid' =>  $proid,
                        'processid' =>  $masterprcid,
                        'sheetnumber' => 0,                        
                        'system' => $this->input->post('projsystem'),                    
                        'referenceno' => $this->input->post('reportref'),
                        'comments'  =>  $this->input->post('commaircomments'),                        
                        'engineerid' => $this->input->post('commairreptenggsign'),
                        'reportdate' => date('Y-m-d H:i:s',strtotime($this->input->post('commairreptenggdate'))),
                        'createdon' => $created_date,
                        'createdby' => $this->session->userdata('userid')
                    );

                    $prcessid=$this->Common_model->insertPrjPrcMaster($ins_array1);
                    $prcessidnew = ($this->Common_model->encodeid($prcessid));

                    $insarray_batch=array();

                    $procesSection_pdata=$this->input->post('procesSection');

                    if(!empty($procesSection_pdata))
                    {
                        foreach ($procesSection_pdata as $ps_key => $ps_value) 
                        {
                            $insarray_batch[] = array(
                              'projectprocesslistmasterid' => $prcessid ,
                              'processsectioncategoryid' => $masterprcid,
                              'processsectionid' => $ps_value,
                              'checked'=>intval($this->input->post('commAirPreCommopt'.$ps_value)),
                              'comments'=>$this->input->post('commAirPreCommcmd'.$ps_value),
                              'createdon' => $created_date,
                              'createdby' => $this->session->userdata('userid')
                            );
                        }
                    }

                    if(!empty($insarray_batch))
                    {
                        $this->db->insert_batch(CWPRECKDETAILS, $insarray_batch);
                    }

                    //$this->Common_model->updateSequenceval(CAPRECK,'sheetnumber','projectid='.$proid,'id','ASC');
                    $this->Common_model->updateSequenceval(PRJPRCLST,'sheetnumber','projectid='.$proid.' and processid='.$masterprcid,'id','ASC');

                    $this->session->set_flashdata('project_message', 'New Water System Pre-Commissioning Checks has been created successfully...');
                }
                else
                {
                    $update_array1 = array(
                        'system' => $this->input->post('projsystem'),                    
                        'referenceno' => $this->input->post('reportref'),
                        'comments' => $this->input->post('commaircomments'),
                        'engineerid' => $this->input->post('commairreptenggsign'),
                        'reportdate' => date('Y-m-d H:i:s',strtotime($this->input->post('commairreptenggdate'))),
                        'modifiedon' => $created_date,
                        'modifiedby' => $this->session->userdata('userid')
                    );

                    $this->Common_model->updatePrjPrcMaster($update_array1,$prcessid);
                    
                    $upsarray_batch=array();

                    $procesSection_pdata=$this->input->post('procesSection');

                    if(!empty($procesSection_pdata))
                    {
                        foreach ($procesSection_pdata as $ps_key => $ps_value) 
                        {
                            $upsarray_batch[] = array(
                                'id'=>intval($this->input->post('procesSectionId'.$ps_value)),
                                'projectprocesslistmasterid' => $prcessid ,
                                'processsectioncategoryid' => $masterprcid,
                                'processsectionid' => $ps_value,
                                'checked'=>intval($this->input->post('commAirPreCommopt'.$ps_value)),
                                'comments'=>$this->input->post('commAirPreCommcmd'.$ps_value),
                                'modifiedon' => $created_date,
                                'modifiedby' => $this->session->userdata('userid')
                            );
                        }
                    }

                    if(!empty($upsarray_batch))
                    {
                        $this->db->update_batch(CWPRECKDETAILS, $upsarray_batch,'id');
                    }

                    $this->session->set_flashdata('project_message', 'Air System Pre-Commissioning Checks has been updated successfully...');

                }

                $sheetstatus=$this->input->post('shtenadis');
                $this->MProject->insertPrjSheetStatus($proid,$masterprcid,$sheetstatus,false);

                $path = base_url('projects/commWaterPreComm/'.$proidnew.'/'.$prcessidnew);
                redirect($path);
            }
        }
        //$data['sidemenu'] = 'hide';
        $data['engdata']=$this->MProject->getEngByPrjID($proid);
        if($prcessid!=0)        
        {
            $prcdatas=$this->MProject->getCWSyspreck($prcessid);
            $data['prcdata']=$prcdatas[0];
        }
        
        $data['prcessid']=$prcessid;
        $data['sheetstatus']=$this->MProject->getPrjSheetStatus($proid,15);
        $data['custom_side_menu'] = 'projprsmenu';
        $data['prodata']=$this->Common_model->getProductById($proid); 
        $data['sidemenu_sub_active'] = 'commAir';
        $data['sidemenu_sub_active1'] = $this->uri->segment(2);
        $this->load->view('common/header',$data);
        $this->load->view('projects/commWater/commWaterPreComm',$data);
        $this->load->view('common/footer');
    }
    public function commWaterPerfRcd()
    {
        $this->exitpage('projects/projview');        
        $proidnew = $this->uri->segment(3);
        $proid = intval($this->Common_model->decodeid($proidnew));        
        $data['proid'] = $proid;
        $prcessidnew = $this->uri->segment(4);
        $prcessid = intval($this->Common_model->decodeid($prcessidnew));         
        if ($this->input->post('cancel'))
        {
            $path = base_url('projects/'.$this->uri->segment(2).'/'.$proidnew);
            redirect($path);
        }
        $masterprcid=16;        
        $data['title'] = 'Pump Details & Performance Test Record';
        $data['masterprcid'] = $masterprcid;
        //$data['sidemenu'] = 'hide';


        if ($this->input->post('submit'))
        {

            $this->form_validation->set_rules('reportref', 'Ref', 'trim|required');
            $this->form_validation->set_rules('projsystem', 'System', 'trim|required');            
            $this->form_validation->set_rules('commairreptenggsign', 'Engineer', 'trim|required');
            
            if ($this->form_validation->run() == TRUE)
            {
                $created_date = date('Y-m-d H:i:s');

                if($prcessid==0)
                {

                    $ins_array1 = array(
                        'projectid' =>  $proid,
                        'processid' =>  $masterprcid,
                        'sheetnumber' => 0,                        
                        'system' => $this->input->post('projsystem'),                    
                        'referenceno' => $this->input->post('reportref'),
                        'comments'  =>  $this->input->post('commaircomments'),                        
                        'engineerid' => $this->input->post('commairreptenggsign'),
                        'reportdate' => date('Y-m-d H:i:s',strtotime($this->input->post('commairreptenggdate'))),
                        'createdon' => $created_date,
                        'createdby' => $this->session->userdata('userid')
                    );

                    $prcessid=$this->Common_model->insertPrjPrcMaster($ins_array1);
                    $prcessidnew = ($this->Common_model->encodeid($prcessid));

                    $insarray_batch=array();

                    //$procesSection_pdata=$this->input->post('procesSection');
                    $procesSectionCat_pdata=$this->input->post('processSecCatid');

                    if(!empty($procesSectionCat_pdata))
                    {
                        foreach ($procesSectionCat_pdata as $psc_key => $psc_value) 
                        {                            
                            $processSecCatid=$psc_value;
                            $procesSection_pdata=$this->input->post('procesSection'.$psc_value);
                            foreach ($procesSection_pdata as $ps_key => $ps_value) 
                            {
                                $staticcheck=(($this->input->post('commAirPreCommopt'.$processSecCatid.'_'.$ps_value))?$this->input->post('commAirPreCommopt'.$processSecCatid.'_'.$ps_value):'');
                                $comments=(($this->input->post('commAirPreCommcmd'.$processSecCatid.'_'.$ps_value))?$this->input->post('commAirPreCommcmd'.$processSecCatid.'_'.$ps_value):'');
                                $testdata=(($this->input->post('commAirPreCommtestdata'.$processSecCatid.'_'.$ps_value))?$this->input->post('commAirPreCommtestdata'.$processSecCatid.'_'.$ps_value):'');
                                $testdata1=(($this->input->post('commAirPreCommtestdata1'.$processSecCatid.'_'.$ps_value))?$this->input->post('commAirPreCommtestdata1'.$processSecCatid.'_'.$ps_value):'');

                                $testdata_ans=(($this->input->post('testdata_ans'.$processSecCatid.'_'.$ps_value))?$this->input->post('testdata_ans'.$processSecCatid.'_'.$ps_value):'');
                                $testdata1_ans=(($this->input->post('testdata1_ans'.$processSecCatid.'_'.$ps_value))?$this->input->post('testdata1_ans'.$processSecCatid.'_'.$ps_value):'');                       

                                $insarray_batch[] = array(
                                  'projectprocesslistmasterid' => $prcessid ,
                                  'processsectioncategoryid' => $processSecCatid,
                                  'processsectionid' => $ps_value,
                                  'staticcheck'=>$staticcheck,
                                  'comments'=>$comments,
                                  'testdata'=>$testdata,
                                  'testdata1'=>$testdata1,
                                  'testdata_ans'=>$testdata_ans,
                                  'testdata1_ans'=>$testdata1_ans,
                                  'createdon' => $created_date,
                                  'createdby' => $this->session->userdata('userid')
                                );
                            }
                        }
                    }

                    if(!empty($insarray_batch))
                    {
                        $this->db->insert_batch(CWPUMPTEST, $insarray_batch);
                    }

                    //$this->Common_model->updateSequenceval(CAPRECK,'sheetnumber','projectid='.$proid,'id','ASC');
                    $this->Common_model->updateSequenceval(PRJPRCLST,'sheetnumber','projectid='.$proid.' and processid='.$masterprcid,'id','ASC');

                    $this->session->set_flashdata('project_message', 'New '.$data['title'].' has been created successfully...');
                }
                else
                {
                   
                    $update_array1 = array(
                        'system' => $this->input->post('projsystem'),                    
                        'referenceno' => $this->input->post('reportref'),
                        'comments' => $this->input->post('commaircomments'),
                        'engineerid' => $this->input->post('commairreptenggsign'),
                        'reportdate' => date('Y-m-d H:i:s',strtotime($this->input->post('commairreptenggdate'))),
                        'modifiedon' => $created_date,
                        'modifiedby' => $this->session->userdata('userid')
                    );

                    $this->Common_model->updatePrjPrcMaster($update_array1,$prcessid);
                    
                    $upsarray_batch=array();

                    $procesSectionCat_pdata=$this->input->post('processSecCatid');

                    if(!empty($procesSectionCat_pdata))
                    {
                        foreach ($procesSectionCat_pdata as $psc_key => $psc_value) 
                        {                            
                            $processSecCatid=$psc_value;
                            $procesSection_pdata=$this->input->post('procesSection'.$psc_value);

                            if(!empty($procesSection_pdata))
                            {
                                foreach ($procesSection_pdata as $ps_key => $ps_value) 
                                {

                                    $staticcheck=(($this->input->post('commAirPreCommopt'.$processSecCatid.'_'.$ps_value))?$this->input->post('commAirPreCommopt'.$processSecCatid.'_'.$ps_value):'');
                                    $comments=(($this->input->post('commAirPreCommcmd'.$processSecCatid.'_'.$ps_value))?$this->input->post('commAirPreCommcmd'.$processSecCatid.'_'.$ps_value):'');
                                    $testdata=(($this->input->post('commAirPreCommtestdata'.$processSecCatid.'_'.$ps_value))?$this->input->post('commAirPreCommtestdata'.$processSecCatid.'_'.$ps_value):'');
                                    $testdata1=(($this->input->post('commAirPreCommtestdata1'.$processSecCatid.'_'.$ps_value))?$this->input->post('commAirPreCommtestdata1'.$processSecCatid.'_'.$ps_value):'');

                                    $testdata_ans=(($this->input->post('testdata_ans'.$processSecCatid.'_'.$ps_value))?$this->input->post('testdata_ans'.$processSecCatid.'_'.$ps_value):'');
                                    $testdata1_ans=(($this->input->post('testdata1_ans'.$processSecCatid.'_'.$ps_value))?$this->input->post('testdata1_ans'.$processSecCatid.'_'.$ps_value):'');

                                    $upsarray_batch[] = array(
                                        'id'=>intval($this->input->post('procesSectionId'.$ps_value)),
                                        'projectprocesslistmasterid' => $prcessid ,
                                        'processsectioncategoryid' => $masterprcid,
                                        'processsectionid' => $ps_value,
                                        'staticcheck'=>$staticcheck,
                                        'comments'=>$comments,
                                        'testdata'=>$testdata,
                                        'testdata1'=>$testdata1,
                                        'testdata_ans'=>$testdata_ans,
                                        'testdata1_ans'=>$testdata1_ans,
                                        'modifiedon' => $created_date,
                                        'modifiedby' => $this->session->userdata('userid')
                                    );
                                }
                            }
                        }
                    }

                    if(!empty($upsarray_batch))
                    {
                        $this->db->update_batch(CWPUMPTEST, $upsarray_batch,'id');
                    }

                    $this->session->set_flashdata('project_message', $data['title'].' has been updated successfully...');

                }

                $sheetstatus=$this->input->post('shtenadis');
                $this->MProject->insertPrjSheetStatus($proid,$masterprcid,$sheetstatus,false);

                $path = base_url('projects/'.$this->uri->segment(2).'/'.$proidnew.'/'.$prcessidnew);
                redirect($path);
            }
        }
        //$data['sidemenu'] = 'hide';
        $data['engdata']=$this->MProject->getEngByPrjID($proid);
        if($prcessid!=0)        
        {
            $prcdatas=$this->MProject->getPrjPrcLst($prcessid);
            $data['prcdata']=$prcdatas[0];
        }


        $data['prcessid']=$prcessid;
        $data['sheetstatus']=$this->MProject->getPrjSheetStatus($proid,$masterprcid);
        $data['custom_side_menu'] = 'projprsmenu';
        $data['prodata']=$this->Common_model->getProductById($proid); 
        $data['sidemenu_sub_active'] = 'commWater';
        $data['sidemenu_sub_active1'] = $this->uri->segment(2);

        $this->load->view('common/header',$data);
        $this->load->view('projects/commWater/commWaterPerfRcd',$data);
        $this->load->view('common/footer');
    }
    public function commWaterDistRcd()
    {
        $this->exitpage('projects/projview');
        
        $proidnew = $this->uri->segment(3);
        $proid = intval($this->Common_model->decodeid($proidnew));        
        $data['proid'] = $proid;
        $prcessidnew = $this->uri->segment(4);
        $prcessid = intval($this->Common_model->decodeid($prcessidnew)); 

        if ($this->input->post('cancel'))
        {
            $path = base_url('projects/'.$this->uri->segment(2).'/'.$proidnew);
            redirect($path);
        }
        $masterprcid=17;
        
        $data['title'] = 'Water Distribution Test Record';
        $data['masterprcid'] = $masterprcid;

        /*== Start Insert/Update ==*/
        if ($this->input->post('submit'))
        {

            $this->form_validation->set_rules('reportref', 'Ref', 'trim|required');
            $this->form_validation->set_rules('projsystem', 'System', 'trim|required');            
            $this->form_validation->set_rules('commairreptenggsign', 'Engineer', 'trim|required');
            
            if ($this->form_validation->run() == TRUE)
            {
                $created_date = date('Y-m-d H:i:s');

                if($prcessid==0)
                {

                    $ins_array1 = array(
                        'projectid' =>  $proid,
                        'processid' =>  $masterprcid,
                        'sheetnumber' => 0,                        
                        'system' => $this->input->post('projsystem'),                    
                        'referenceno' => $this->input->post('reportref'),
                        'comments'  =>  $this->input->post('commaircomments'),                        
                        'engineerid' => $this->input->post('commairreptenggsign'),
                        'reportdate' => date('Y-m-d H:i:s',strtotime($this->input->post('commairreptenggdate'))),
                        'createdon' => $created_date,
                        'createdby' => $this->session->userdata('userid')
                    );

                    $prcessid=$this->Common_model->insertPrjPrcMaster($ins_array1);
                    $prcessidnew = ($this->Common_model->encodeid($prcessid));

                    $insarray_batch=array();

                    //$procesSection_pdata=$this->input->post('procesSection');
                    $procesSectionCat_pdata=$this->input->post('cwdesignmeasured');

                    #echo '<pre>'; print_r($_POST); echo '</pre>';
                    #exit;

                    if(!empty($procesSectionCat_pdata))
                    {
                        foreach ($procesSectionCat_pdata as $psc_key => $psc_value) 
                        {                            
                            $insarray_batch[] = array(
                              'projectprocesslistmasterid' => $prcessid ,
                              'deinforefnum'   =>  $_POST['deinforefnum'][$psc_key],
                              'deinfomanuf' => $_POST['deinfomanuf'][$psc_key],
                              'deinfotype'=>$_POST['deinfotype'][$psc_key],
                              'deinfosizemm'=>$_POST['deinfosizemm'][$psc_key],
                              'deinfokvs'=>$_POST['deinfokvs'][$psc_key],
                              'deinforflowis'=>$_POST['deinforflowis'][$psc_key],
                              'deinfopdkpa'=>$_POST['deinfopdkpa'][$psc_key],
                              'measurpdkpa'=>$_POST['measurpdkpa'][$psc_key],
                              'measurflowis'=>$_POST['measurflowis'][$psc_key],
                              'measurpercen'=>$_POST['measurpercen'][$psc_key],
                              'measurregset'=>$_POST['measurregset'][$psc_key],
                              'measurbypasset'=>$_POST['measurbypasset'][$psc_key],
                              'createdon' => $created_date,
                              'createdby' => $this->session->userdata('userid')
                            );
                        }
                    }
                    #if(!empty($insarray_batch))
                    {
                        $this->db->insert_batch(CWWATERDISTST, $insarray_batch);
                    }

                    //$this->Common_model->updateSequenceval(CAPRECK,'sheetnumber','projectid='.$proid,'id','ASC');
                    $this->Common_model->updateSequenceval(PRJPRCLST,'sheetnumber','projectid='.$proid.' and processid='.$masterprcid,'id','ASC');

                    $this->session->set_flashdata('project_message', 'New '.$data['title'].' has been created successfully...');
                }
                else
                {
                   
                    $update_array1 = array(
                        'system' => $this->input->post('projsystem'),                    
                        'referenceno' => $this->input->post('reportref'),
                        'comments' => $this->input->post('commaircomments'),
                        'engineerid' => $this->input->post('commairreptenggsign'),
                        'reportdate' => date('Y-m-d H:i:s',strtotime($this->input->post('commairreptenggdate'))),
                        'modifiedon' => $created_date,
                        'modifiedby' => $this->session->userdata('userid')
                    );

                    $this->Common_model->updatePrjPrcMaster($update_array1,$prcessid);
                    
                    $upsarray_batch=array();

                    $procesSectionCat_pdata=$this->input->post('cwdesignmeasured');

                    if(!empty($procesSectionCat_pdata))
                    {
                        foreach ($procesSectionCat_pdata as $psc_key => $psc_value) 
                        {
                            if($psc_value==0)
                            {
                                $insarray_batch[] = array(
                                  'projectprocesslistmasterid' => $prcessid ,
                                  'deinforefnum'   =>  $_POST['deinforefnum'][$psc_key],
                                  'deinfomanuf' => $_POST['deinfomanuf'][$psc_key],
                                  'deinfotype'=>$_POST['deinfotype'][$psc_key],
                                  'deinfosizemm'=>$_POST['deinfosizemm'][$psc_key],
                                  'deinfokvs'=>$_POST['deinfokvs'][$psc_key],
                                  'deinforflowis'=>$_POST['deinforflowis'][$psc_key],
                                  'deinfopdkpa'=>$_POST['deinfopdkpa'][$psc_key],
                                  'measurpdkpa'=>$_POST['measurpdkpa'][$psc_key],
                                  'measurflowis'=>$_POST['measurflowis'][$psc_key],
                                  'measurpercen'=>$_POST['measurpercen'][$psc_key],
                                  'measurregset'=>$_POST['measurregset'][$psc_key],
                                  'measurbypasset'=>$_POST['measurbypasset'][$psc_key],
                                  'createdon' => $created_date,
                                  'createdby' => $this->session->userdata('userid')
                                );
                            }
                            else
                            {
                                $upsarray_batch[] = array(
                                    'id'=>$psc_value,
                                    'projectprocesslistmasterid' => $prcessid ,
                                    'deinforefnum'   =>  $_POST['deinforefnum'][$psc_key],
                                    'deinfomanuf' => $_POST['deinfomanuf'][$psc_key],
                                    'deinfotype'=>$_POST['deinfotype'][$psc_key],
                                    'deinfosizemm'=>$_POST['deinfosizemm'][$psc_key],
                                    'deinfokvs'=>$_POST['deinfokvs'][$psc_key],
                                    'deinforflowis'=>$_POST['deinforflowis'][$psc_key],
                                    'deinfopdkpa'=>$_POST['deinfopdkpa'][$psc_key],
                                    'measurpdkpa'=>$_POST['measurpdkpa'][$psc_key],
                                    'measurflowis'=>$_POST['measurflowis'][$psc_key],
                                    'measurpercen'=>$_POST['measurpercen'][$psc_key],
                                    'measurregset'=>$_POST['measurregset'][$psc_key],
                                    'measurbypasset'=>$_POST['measurbypasset'][$psc_key],
                                    'modifiedon' => $created_date,
                                    'modifiedby' => $this->session->userdata('userid')
                                );
                            }

                        }
                    }

                    /* =========== Delete Grille === */

                    $grilledel_pdata=$this->input->post('grilledel');

                    if(!empty($grilledel_pdata))
                    {
                        foreach ($grilledel_pdata as $grd_key => $grd_value) 
                        {
                            if(intval($grd_value)!=0)
                            {
                                $this->db->where('id', $grd_value);
                                $this->db->delete(CWWATERDISTST);
                            }
                        }
                    }


                    if(!empty($upsarray_batch))
                    {
                        $this->db->update_batch(CWWATERDISTST, $upsarray_batch,'id');
                    }
                    if(!empty($insarray_batch))
                    {
                        $this->db->insert_batch(CWWATERDISTST, $insarray_batch);
                    }

                    $this->session->set_flashdata('project_message', $data['title'].' has been updated successfully...');

                }

                $sheetstatus=$this->input->post('shtenadis');
                $this->MProject->insertPrjSheetStatus($proid,$masterprcid,$sheetstatus,false);

                $path = base_url('projects/'.$this->uri->segment(2).'/'.$proidnew.'/'.$prcessidnew);
                redirect($path);
            }
        }

        //$data['sidemenu'] = 'hide';
        $data['engdata']=$this->MProject->getEngByPrjID($proid);
        $cwwaterdiststrcd=$this->MProject->getcwWaterDistTstdata($prcessid);

        if($prcessid!=0)        
        {
            $prcdatas=$this->MProject->getPrjPrcLst($prcessid);
            $data['prcdata']=$prcdatas[0];  
        }

        if($cwwaterdiststrcd->num_rows()>0)
        {
            $data['cwwaterdiststrcd']=$cwwaterdiststrcd->result_array();
        }
        else
        {
            $data['cwwaterdiststrcd']=array(
                array(
                    'id'=>0,
                    'projectprocesslistmasterid' => $prcessid ,
                    'deinforefnum' => '',
                    'deinfomanuf' => '',
                    'deinfotype'=>'',
                    'deinfosizemm'=>'',
                    'deinfokvs'=>'',
                    'deinforflowis'=>'',
                    'deinfopdkpa'=>'',
                    'measurpdkpa'=>'',
                    'measurflowis'=>'',
                    'measurpercen'=>'',
                    'measurregset'=>'',
                    'measurbypasset'=>''
                )
            );
        }

        if($this->input->post('deinforefnum'))
        {
            $data['cwwaterdiststrcd']=array();
            $value1=$this->input->post('deinforefnum');            
            foreach ($value1 as $key => $value) {
                $data['cwwaterdiststrcd'][]=array(
                    'id'=>$_POST['cwdesignmeasured'][$key],
                    'projectprocesslistmasterid' => $prcessid,
                    'deinforefnum'   =>  $_POST['deinforefnum'][$key],
                    'deinfomanuf' => $_POST['deinfomanuf'][$key],
                    'deinfotype'=>$_POST['deinfotype'][$key],
                    'deinfosizemm'=>$_POST['deinfosizemm'][$key],
                    'deinfokvs'=>$_POST['deinfokvs'][$key],
                    'deinforflowis'=>$_POST['deinforflowis'][$key],
                    'deinfopdkpa'=>$_POST['deinfopdkpa'][$key],
                    'measurpdkpa'=>$_POST['measurpdkpa'][$key],
                    'measurflowis'=>$_POST['measurflowis'][$key],
                    'measurpercen'=>$_POST['measurpercen'][$key],
                    'measurregset'=>$_POST['measurregset'][$key],
                    'measurbypasset'=>$_POST['measurbypasset'][$key]
                );
            }

        }

        /*== End Insert/Update ==*/

        //$data['sidemenu'] = 'hide';
        $data['engdata']=$this->MProject->getEngByPrjID($proid);
        if($prcessid!=0)        
        {
            $prcdatas=$this->MProject->getPrjPrcLst($prcessid);
            $data['prcdata']=$prcdatas[0];
        }

        $data['prcessid']=$prcessid;
        $data['sheetstatus']=$this->MProject->getPrjSheetStatus($proid,$masterprcid);
        $data['custom_side_menu'] = 'projprsmenu';
        $data['prodata']=$this->Common_model->getProductById($proid); 
        $data['sidemenu_sub_active'] = 'commWater';
        $data['sidemenu_sub_active1'] = $this->uri->segment(2);
        $this->load->view('common/header',$data);
        $this->load->view('projects/commWater/commWaterDistRcd',$data);
        $this->load->view('common/footer');
    }
    public function commWaterDistPicv()
    {
        $this->exitpage('projects/projview');        
        $proidnew = $this->uri->segment(3);
        $proid = intval($this->Common_model->decodeid($proidnew));        
        $data['proid'] = $proid;
        $prcessidnew = $this->uri->segment(4);
        $prcessid = intval($this->Common_model->decodeid($prcessidnew));
        if ($this->input->post('cancel'))
        {
            $path = base_url('projects/'.$this->uri->segment(2).'/'.$proidnew);
            redirect($path);
        }
        $masterprcid=18;        
        $data['title'] = 'Water Distribution - PICV';
        $data['masterprcid'] = $masterprcid;

        /*== Start Insert/Update ==*/
        if ($this->input->post('submit'))
        {

            $this->form_validation->set_rules('reportref', 'Ref', 'trim|required');
            $this->form_validation->set_rules('projsystem', 'System', 'trim|required');            
            $this->form_validation->set_rules('commairreptenggsign', 'Engineer', 'trim|required');
            
            if ($this->form_validation->run() == TRUE)
            {
                $created_date = date('Y-m-d H:i:s');

                if($prcessid==0)
                {

                    $ins_array1 = array(
                        'projectid' =>  $proid,
                        'processid' =>  $masterprcid,
                        'sheetnumber' => 0,                        
                        'system' => $this->input->post('projsystem'),                    
                        'referenceno' => $this->input->post('reportref'),
                        'comments'  =>  $this->input->post('commaircomments'),                        
                        'engineerid' => $this->input->post('commairreptenggsign'),
                        'reportdate' => date('Y-m-d H:i:s',strtotime($this->input->post('commairreptenggdate'))),
                        'createdon' => $created_date,
                        'createdby' => $this->session->userdata('userid')
                    );

                    $prcessid=$this->Common_model->insertPrjPrcMaster($ins_array1);
                    $prcessidnew = ($this->Common_model->encodeid($prcessid));

                    $insarray_batch=array();

                    //$procesSection_pdata=$this->input->post('procesSection');
                    $procesSectionCat_pdata=$this->input->post('cwdesignmeasured');

                    #echo '<pre>'; print_r($_POST); echo '</pre>';
                    #exit;

                    if(!empty($procesSectionCat_pdata))
                    {
                        foreach ($procesSectionCat_pdata as $psc_key => $psc_value) 
                        {                            
                            $insarray_batch[] = array(
                              'projectprocesslistmasterid' => $prcessid ,
                              'deinforefnum'   =>  $_POST['deinforefnum'][$psc_key],
                              'deinfomanuf' => $_POST['deinfomanuf'][$psc_key],
                              'deinfotype'=>$_POST['deinfotype'][$psc_key],
                              'deinfopicvset'=>$_POST['deinfopicvset'][$psc_key],
                              'deinfosizemm'=>$_POST['deinfosizemm'][$psc_key],
                              'deinfokvs'=>$_POST['deinfokvs'][$psc_key],
                              'deinforflowis'=>$_POST['deinforflowis'][$psc_key],
                              'deinfopdkpa'=>$_POST['deinfopdkpa'][$psc_key],
                              'measurpdkpa'=>$_POST['measurpdkpa'][$psc_key],
                              'measurflowis'=>$_POST['measurflowis'][$psc_key],
                              'measurpercen'=>$_POST['measurpercen'][$psc_key],
                              'createdon' => $created_date,
                              'createdby' => $this->session->userdata('userid')
                            );
                        }
                    }
                    #if(!empty($insarray_batch))
                    {
                        $this->db->insert_batch(CWWATERDISTPICV, $insarray_batch);
                    }

                    //$this->Common_model->updateSequenceval(CAPRECK,'sheetnumber','projectid='.$proid,'id','ASC');
                    $this->Common_model->updateSequenceval(PRJPRCLST,'sheetnumber','projectid='.$proid.' and processid='.$masterprcid,'id','ASC');

                    $this->session->set_flashdata('project_message', 'New '.$data['title'].' has been created successfully...');
                }
                else
                {
                   
                    $update_array1 = array(
                        'system' => $this->input->post('projsystem'),                    
                        'referenceno' => $this->input->post('reportref'),
                        'comments' => $this->input->post('commaircomments'),
                        'engineerid' => $this->input->post('commairreptenggsign'),
                        'reportdate' => date('Y-m-d H:i:s',strtotime($this->input->post('commairreptenggdate'))),
                        'modifiedon' => $created_date,
                        'modifiedby' => $this->session->userdata('userid')
                    );

                    $this->Common_model->updatePrjPrcMaster($update_array1,$prcessid);
                    
                    $upsarray_batch=array();

                    $procesSectionCat_pdata=$this->input->post('cwdesignmeasured');

                    if(!empty($procesSectionCat_pdata))
                    {
                        foreach ($procesSectionCat_pdata as $psc_key => $psc_value) 
                        {
                            if($psc_value==0)
                            {
                                $insarray_batch[] = array(
                                  'projectprocesslistmasterid' => $prcessid ,
                                  'deinforefnum'   =>  $_POST['deinforefnum'][$psc_key],
                                  'deinfomanuf' => $_POST['deinfomanuf'][$psc_key],
                                  'deinfotype'=>$_POST['deinfotype'][$psc_key],
                                  'deinfopicvset'=>$_POST['deinfopicvset'][$psc_key],
                                  'deinfosizemm'=>$_POST['deinfosizemm'][$psc_key],
                                  'deinfokvs'=>$_POST['deinfokvs'][$psc_key],
                                  'deinforflowis'=>$_POST['deinforflowis'][$psc_key],
                                  'deinfopdkpa'=>$_POST['deinfopdkpa'][$psc_key],
                                  'measurpdkpa'=>$_POST['measurpdkpa'][$psc_key],
                                  'measurflowis'=>$_POST['measurflowis'][$psc_key],
                                  'measurpercen'=>$_POST['measurpercen'][$psc_key],
                                  'createdon' => $created_date,
                                  'createdby' => $this->session->userdata('userid')
                                );
                            }
                            else
                            {
                                $upsarray_batch[] = array(
                                    'id'=>$psc_value,
                                    'projectprocesslistmasterid' => $prcessid ,
                                    'deinforefnum'   =>  $_POST['deinforefnum'][$psc_key],
                                    'deinfomanuf' => $_POST['deinfomanuf'][$psc_key],
                                    'deinfotype'=>$_POST['deinfotype'][$psc_key],
                                    'deinfopicvset'=>$_POST['deinfopicvset'][$psc_key],
                                    'deinfosizemm'=>$_POST['deinfosizemm'][$psc_key],
                                    'deinfokvs'=>$_POST['deinfokvs'][$psc_key],
                                    'deinforflowis'=>$_POST['deinforflowis'][$psc_key],
                                    'deinfopdkpa'=>$_POST['deinfopdkpa'][$psc_key],
                                    'measurpdkpa'=>$_POST['measurpdkpa'][$psc_key],
                                    'measurflowis'=>$_POST['measurflowis'][$psc_key],
                                    'measurpercen'=>$_POST['measurpercen'][$psc_key],
                                    'modifiedon' => $created_date,
                                    'modifiedby' => $this->session->userdata('userid')
                                );
                            }

                        }
                    }

                    /* =========== Delete Grille === */

                    $grilledel_pdata=$this->input->post('grilledel');

                    if(!empty($grilledel_pdata))
                    {
                        foreach ($grilledel_pdata as $grd_key => $grd_value) 
                        {
                            if(intval($grd_value)!=0)
                            {
                                $this->db->where('id', $grd_value);
                                $this->db->delete(CWWATERDISTPICV);
                            }
                        }
                    }


                    if(!empty($upsarray_batch))
                    {
                        $this->db->update_batch(CWWATERDISTPICV, $upsarray_batch,'id');
                    }
                    if(!empty($insarray_batch))
                    {
                        $this->db->insert_batch(CWWATERDISTPICV, $insarray_batch);
                    }

                    $this->session->set_flashdata('project_message', $data['title'].' has been updated successfully...');

                }

                $sheetstatus=$this->input->post('shtenadis');
                $this->MProject->insertPrjSheetStatus($proid,$masterprcid,$sheetstatus,false);

                $path = base_url('projects/'.$this->uri->segment(2).'/'.$proidnew.'/'.$prcessidnew);
                redirect($path);
            }
        }

        //$data['sidemenu'] = 'hide';
        $data['engdata']=$this->MProject->getEngByPrjID($proid);
        $cwwaterdiststrcd=$this->MProject->getcwWaterDistPicvdata($prcessid);

        if($prcessid!=0)        
        {
            $prcdatas=$this->MProject->getPrjPrcLst($prcessid);
            $data['prcdata']=$prcdatas[0];  
        }

        if($cwwaterdiststrcd->num_rows()>0)
        {
            $data['cwwaterdiststrcd']=$cwwaterdiststrcd->result_array();
        }
        else
        {
            $data['cwwaterdiststrcd']=array(
                array(
                    'id'=>0,
                    'projectprocesslistmasterid' => $prcessid ,
                    'deinforefnum'   =>  '',
                    'deinfomanuf' => '',
                    'deinfotype'=>'',
                    'deinfopicvset'=>'',
                    'deinfosizemm'=>'',
                    'deinfokvs'=>'',
                    'deinforflowis'=>'',
                    'deinfopdkpa'=>'',
                    'measurpdkpa'=>'',
                    'measurflowis'=>'',
                    'measurpercen'=>''
                )
            );
        }

        if($this->input->post('deinforefnum'))
        {
            $data['cwwaterdiststrcd']=array();
            $value1=$this->input->post('deinforefnum');            
            foreach ($value1 as $key => $value) {
                $data['cwwaterdiststrcd'][]=array(
                    'id'=>$_POST['cwdesignmeasured'][$key],
                    'projectprocesslistmasterid' => $prcessid,
                    'deinforefnum'   =>  $_POST['deinforefnum'][$key],
                    'deinfomanuf' => $_POST['deinfomanuf'][$key],
                    'deinfotype'=>$_POST['deinfotype'][$key],
                    'deinfopicvset'=>$_POST['deinfopicvset'][$key],
                    'deinfosizemm'=>$_POST['deinfosizemm'][$key],
                    'deinfokvs'=>$_POST['deinfokvs'][$key],
                    'deinforflowis'=>$_POST['deinforflowis'][$key],
                    'deinfopdkpa'=>$_POST['deinfopdkpa'][$key],
                    'measurpdkpa'=>$_POST['measurpdkpa'][$key],
                    'measurflowis'=>$_POST['measurflowis'][$key],
                    'measurpercen'=>$_POST['measurpercen'][$key]
                );
            }

        }

        /*== End Insert/Update ==*/

        //$data['sidemenu'] = 'hide';
        $data['engdata']=$this->MProject->getEngByPrjID($proid);
        if($prcessid!=0)        
        {
            $prcdatas=$this->MProject->getPrjPrcLst($prcessid);
            $data['prcdata']=$prcdatas[0];
        }

        $data['prcessid']=$prcessid;
        $data['sheetstatus']=$this->MProject->getPrjSheetStatus($proid,$masterprcid);
        $data['custom_side_menu'] = 'projprsmenu';
        $data['prodata']=$this->Common_model->getProductById($proid); 
        $data['sidemenu_sub_active'] = 'commWater';
        $data['sidemenu_sub_active1'] = $this->uri->segment(2);
        $this->load->view('common/header',$data);
        $this->load->view('projects/commWater/commWaterDistPicv',$data);
        $this->load->view('common/footer');
    }
    public function commWaterHwsBlend()
    {
        $this->exitpage('projects/projview');
        $proidnew = $this->uri->segment(3);
        $proid = intval($this->Common_model->decodeid($proidnew));        
        $data['proid'] = $proid;
        $prcessidnew = $this->uri->segment(4);
        $prcessid = intval($this->Common_model->decodeid($prcessidnew)); 
        if ($this->input->post('cancel'))
        {
            $path = base_url('projects/'.$this->uri->segment(2).'/'.$proidnew);
            redirect($path);
        }
        $masterprcid=19;
        
        $data['title'] = 'HWS Blending Valves';
        $data['masterprcid'] = $masterprcid;

        /*== Start Insert/Update ==*/
        if ($this->input->post('submit'))
        {

            $this->form_validation->set_rules('reportref', 'Ref', 'trim|required');
            $this->form_validation->set_rules('projsystem', 'System', 'trim|required');            
            $this->form_validation->set_rules('commairreptenggsign', 'Engineer', 'trim|required');
            
            if ($this->form_validation->run() == TRUE)
            {
                $created_date = date('Y-m-d H:i:s');

                if($prcessid==0)
                {

                    $ins_array1 = array(
                        'projectid' =>  $proid,
                        'processid' =>  $masterprcid,
                        'sheetnumber' => 0,                        
                        'system' => $this->input->post('projsystem'),                    
                        'referenceno' => $this->input->post('reportref'),
                        'comments'  =>  $this->input->post('commaircomments'),                        
                        'engineerid' => $this->input->post('commairreptenggsign'),
                        'reportdate' => date('Y-m-d H:i:s',strtotime($this->input->post('commairreptenggdate'))),
                        'createdon' => $created_date,
                        'createdby' => $this->session->userdata('userid')
                    );

                    $prcessid=$this->Common_model->insertPrjPrcMaster($ins_array1);
                    $prcessidnew = ($this->Common_model->encodeid($prcessid));

                    $insarray_batch=array();

                    //$procesSection_pdata=$this->input->post('procesSection');
                    $procesSectionCat_pdata=$this->input->post('cwdesignmeasured');

                    #echo '<pre>'; print_r($_POST); echo '</pre>';
                    #exit;

                    if(!empty($procesSectionCat_pdata))
                    {
                        foreach ($procesSectionCat_pdata as $psc_key => $psc_value) 
                        {                            
                            $insarray_batch[] = array(
                              'projectprocesslistmasterid' => $prcessid ,
                              'valveref'   =>  $_POST['valveref'][$psc_key],
                              'valvetemp' => $_POST['valvetemp'][$psc_key],
                              'failsafeopt'=>$_POST['failsafeopt'][$psc_key],
                              'hwscmts'=>$_POST['hwscmts'][$psc_key],
                              'createdon' => $created_date,
                              'createdby' => $this->session->userdata('userid')
                            );
                        }
                    }
                    #if(!empty($insarray_batch))
                    {
                        $this->db->insert_batch(CWHWSBLENDVLS, $insarray_batch);
                    }

                    //$this->Common_model->updateSequenceval(CAPRECK,'sheetnumber','projectid='.$proid,'id','ASC');
                    $this->Common_model->updateSequenceval(PRJPRCLST,'sheetnumber','projectid='.$proid.' and processid='.$masterprcid,'id','ASC');

                    $this->session->set_flashdata('project_message', 'New '.$data['title'].' has been created successfully...');
                }
                else
                {
                   
                    $update_array1 = array(
                        'system' => $this->input->post('projsystem'),                    
                        'referenceno' => $this->input->post('reportref'),
                        'comments' => $this->input->post('commaircomments'),
                        'engineerid' => $this->input->post('commairreptenggsign'),
                        'reportdate' => date('Y-m-d H:i:s',strtotime($this->input->post('commairreptenggdate'))),
                        'modifiedon' => $created_date,
                        'modifiedby' => $this->session->userdata('userid')
                    );

                    $this->Common_model->updatePrjPrcMaster($update_array1,$prcessid);
                    
                    $upsarray_batch=array();

                    $procesSectionCat_pdata=$this->input->post('cwdesignmeasured');

                    if(!empty($procesSectionCat_pdata))
                    {
                        foreach ($procesSectionCat_pdata as $psc_key => $psc_value) 
                        {
                            if($psc_value==0)
                            {
                                $insarray_batch[] = array(
                                  'projectprocesslistmasterid' => $prcessid ,
                                  'valveref'   =>  $_POST['valveref'][$psc_key],
                                  'valvetemp' => $_POST['valvetemp'][$psc_key],
                                  'failsafeopt'=>$_POST['failsafeopt'][$psc_key],
                                  'hwscmts'=>$_POST['hwscmts'][$psc_key],
                                  'createdon' => $created_date,
                                  'createdby' => $this->session->userdata('userid')
                                );
                            }
                            else
                            {
                                $upsarray_batch[] = array(
                                    'id'=>$psc_value,
                                    'projectprocesslistmasterid' => $prcessid ,
                                    'valveref'   =>  $_POST['valveref'][$psc_key],
                                    'valvetemp' => $_POST['valvetemp'][$psc_key],
                                    'failsafeopt'=>$_POST['failsafeopt'][$psc_key],
                                    'hwscmts'=>$_POST['hwscmts'][$psc_key],
                                    'modifiedon' => $created_date,
                                    'modifiedby' => $this->session->userdata('userid')
                                );
                            }

                        }
                    }

                    /* =========== Delete Grille === */

                    $grilledel_pdata=$this->input->post('grilledel');

                    if(!empty($grilledel_pdata))
                    {
                        foreach ($grilledel_pdata as $grd_key => $grd_value) 
                        {
                            if(intval($grd_value)!=0)
                            {
                                $this->db->where('id', $grd_value);
                                $this->db->delete(CWHWSBLENDVLS);
                            }
                        }
                    }


                    if(!empty($upsarray_batch))
                    {
                        $this->db->update_batch(CWHWSBLENDVLS, $upsarray_batch,'id');
                    }
                    if(!empty($insarray_batch))
                    {
                        $this->db->insert_batch(CWHWSBLENDVLS, $insarray_batch);
                    }

                    $this->session->set_flashdata('project_message', $data['title'].' has been updated successfully...');

                }

                $sheetstatus=$this->input->post('shtenadis');
                $this->MProject->insertPrjSheetStatus($proid,$masterprcid,$sheetstatus,false);

                $path = base_url('projects/'.$this->uri->segment(2).'/'.$proidnew.'/'.$prcessidnew);
                redirect($path);
            }
        }

        //$data['sidemenu'] = 'hide';
        $data['engdata']=$this->MProject->getEngByPrjID($proid);
        $cwwaterdiststrcd=$this->MProject->getcwWaterHSWdata($prcessid);

        if($prcessid!=0)        
        {
            $prcdatas=$this->MProject->getPrjPrcLst($prcessid);
            $data['prcdata']=$prcdatas[0];  
        }

        if($cwwaterdiststrcd->num_rows()>0)
        {
            $data['cwwaterdiststrcd']=$cwwaterdiststrcd->result_array();
        }
        else
        {
            $data['cwwaterdiststrcd']=array(
                array(
                    'id'=>0,
                    'projectprocesslistmasterid' => $prcessid ,
                    'valveref'   =>  '',
                    'valvetemp' => '',
                    'failsafeopt'=>'',
                    'hwscmts'=>''
                )
            );
        }

        if($this->input->post('valveref'))
        {
            $data['cwwaterdiststrcd']=array();
            $value1=$this->input->post('valveref');            
            foreach ($value1 as $key => $value) {
                $data['cwwaterdiststrcd'][]=array(
                    'id'=>$_POST['cwdesignmeasured'][$key],
                    'projectprocesslistmasterid' => $prcessid,
                    'valveref'   =>  $_POST['valveref'][$key],
                    'valvetemp' => $_POST['valvetemp'][$key],
                    'failsafeopt'=>$_POST['failsafeopt'][$key],
                    'hwscmts'=>$_POST['hwscmts'][$key]
                );
            }

        }

        /*== End Insert/Update ==*/

        //$data['sidemenu'] = 'hide';
        $data['engdata']=$this->MProject->getEngByPrjID($proid);
        if($prcessid!=0)        
        {
            $prcdatas=$this->MProject->getPrjPrcLst($prcessid);
            $data['prcdata']=$prcdatas[0];
        }

        $data['prcessid']=$prcessid;
        $data['sheetstatus']=$this->MProject->getPrjSheetStatus($proid,$masterprcid);
        $data['custom_side_menu'] = 'projprsmenu';
        $data['prodata']=$this->Common_model->getProductById($proid); 
        $data['sidemenu_sub_active'] = 'commWater';
        $data['sidemenu_sub_active1'] = $this->uri->segment(2);
        $this->load->view('common/header',$data);
        $this->load->view('projects/commWater/commWaterHwsBlend',$data);
        $this->load->view('common/footer');
    }

    /* ============================== Commissioning Air ============================*/

    public function commAir()
    {
        $this->exitpage('projects/projview');
        
        $proidnew = $this->uri->segment(3);
        $proid = intval($this->Common_model->decodeid($proidnew));        
        $data['proid'] = $proid;
        $prcessidnew = $this->uri->segment(4);
        $prcessid = intval($this->Common_model->decodeid($prcessidnew));

        if ($this->input->post('cancel'))
        {
            $path = base_url('projects/'.$this->uri->segment(2).'/'.$proidnew);
            redirect($path);
        }
        
        $masterprcid = 1;                
        $data['title'] = 'System Witness Certificate';
        $data['masterprcid'] = $masterprcid;
        //$data['sidemenu'] = 'hide';

        if ($this->input->post('submit'))
        {

            $this->form_validation->set_rules('reportref', 'Ref', 'trim|required');
            $this->form_validation->set_rules('projsystem', 'System', 'trim|required');            
            $this->form_validation->set_rules('commaircomments', 'Comments', 'trim|required');

            if ($this->form_validation->run() == TRUE)
            {
                $created_date = date('Y-m-d H:i:s');

                if($prcessid==0)
                {
                    $ins_array1 = array(
                        'projectid' =>  $proid,
                        'processid' =>  $masterprcid,
                        'sheetnumber' => 0,                        
                        'system' => $this->input->post('projsystem'),                    
                        'referenceno' => $this->input->post('reportref'),
                        'comments'  =>  $this->input->post('commaircomments'),                        
                        'engineerid' => 0,
                        'reportdate' => $created_date,
                        'createdon' => $created_date,
                        'createdby' => $this->session->userdata('userid')
                    );

                    $prcessid=$this->Common_model->insertPrjPrcMaster($ins_array1);
                    $prcessidnew = ($this->Common_model->encodeid($prcessid));


                    $ins_array = array(
                        'projectprocesslistmasterid' => $prcessid,
                        'projectsystemid' => $this->input->post('projsystem'),
                        'witnessdate'=> date(SQL_FORMAT, strtotime($this->input->post('commairwitdate'))),
                        'servicecontractdate' => date(SQL_FORMAT, strtotime($this->input->post('commairtestcompdate'))),
                        'createdon' => $created_date,
                        'createdby' => $this->session->userdata('userid')
                    );
                    
                    $this->db->insert(CASYSCERT, $ins_array);                
                    $insert_id=$this->db->insert_id();

                    $this->Common_model->updateSequenceval(PRJPRCLST,'sheetnumber','projectid='.$proid.' and processid='.$masterprcid,'id','ASC');

                    $this->session->set_flashdata('project_message', 'New '.$data['title'].' has been created successfully...');
                }
                else
                {
                    $update_array1 = array(
                        'system' => $this->input->post('projsystem'),                    
                        'referenceno' => $this->input->post('reportref'),
                        'comments'  =>  $this->input->post('commaircomments'),
                        'modifiedon' => $created_date,
                        'modifiedby' => $this->session->userdata('userid')
                    );

                    $this->Common_model->updatePrjPrcMaster($update_array1,$prcessid);
                    
                    $update_array=array(
                        'projectsystemid' => $this->input->post('projsystem'),
                        'witnessdate'=> date(SQL_FORMAT, strtotime($this->input->post('commairwitdate'))),
                        'servicecontractdate' => date(SQL_FORMAT, strtotime($this->input->post('commairtestcompdate'))),
                        'modifiedon' => $created_date,
                        'modifiedby' => $this->session->userdata('userid')
                    );

                    $this->db->where('projectprocesslistmasterid', $prcessid);
                    $this->db->update(CASYSCERT, $update_array);

                    $this->session->set_flashdata('project_message', $data['title'].' has been updated successfully...');

                }

                $sheetstatus=$this->input->post('shtenadis');

                $this->MProject->insertPrjSheetStatus($proid,$masterprcid,$sheetstatus,false);

                $path = base_url('projects/commAir/'.$proidnew.'/'.$prcessidnew);
                redirect($path);
            }
        }

        $data['engdata']=$this->MProject->getEngByPrjID($proid);
        if($prcessid!=0)        
        {
            $prcdatas=$this->MProject->getCAsysWitness($prcessid);
            $data['prcdata']=$prcdatas[0];
        }

        $data['prcessid']=$prcessid;
        $data['sheetstatus']=$this->MProject->getPrjSheetStatus($proid,$masterprcid);
        $data['custom_side_menu'] = 'projprsmenu';
        $data['prodata']=$this->Common_model->getProductById($proid); 
        $data['sidemenu_sub_active'] = 'commAir';
        $data['sidemenu_sub_active1'] = $this->uri->segment(2);
        $this->load->view('common/header',$data);
        $this->load->view('projects/commAir/commAir',$data);
        $this->load->view('common/footer');
    }
    public function commAirRptSht()
    {
        $this->exitpage('projects/projview');

        $proidnew = $this->uri->segment(3);
        $proid = intval($this->Common_model->decodeid($proidnew));        
        $data['proid'] = $proid;
        $prcessidnew = $this->uri->segment(4);
        $prcessid = intval($this->Common_model->decodeid($prcessidnew));

        if ($this->input->post('cancel'))
        {
            $path = base_url('projects/'.$this->uri->segment(2).'/'.$proidnew);
            redirect($path);
        }        
        
        $data['title'] = 'Report Sheet';
        $masterprcid = 2;
        

         if ($this->input->post('submit'))
        {

            $this->form_validation->set_rules('reportref', 'Ref', 'trim|required');
            $this->form_validation->set_rules('projsystem', 'System', 'trim|required');            
            $this->form_validation->set_rules('commairreptenggsign', 'Engineer', 'trim|required');
            $this->form_validation->set_rules('commairreptcomments', 'Comments', 'trim|required');


            if ($this->form_validation->run() == TRUE)
            {
                $created_date = date('Y-m-d H:i:s');
               

                if($prcessid==0)
                {
                    $ins_array1 = array(
                        'projectid' =>  $proid,
                        'processid' => $masterprcid,
                        'sheetnumber' => 0,                        
                        'system' => $this->input->post('projsystem'),                    
                        'referenceno' => $this->input->post('reportref'),
                        'comments'  =>  '',                        
                        'engineerid' => $this->input->post('commairreptenggsign'),
                        'reportdate' => date('Y-m-d H:i:s',strtotime($this->input->post('commairreptenggdate'))),
                        'createdon' => $created_date,
                        'createdby' => $this->session->userdata('userid')
                    );

                    $prcessid=$this->Common_model->insertPrjPrcMaster($ins_array1);
                    $prcessidnew = ($this->Common_model->encodeid($prcessid));


                    $ins_array = array(
                        'projectprocesslistmasterid' => $prcessid,
                        'reportdescription' => $this->input->post('commairreptcomments'),
                        'createdon' => $created_date,
                        'createdby' => $this->session->userdata('userid')
                    );
                    
                    $this->db->insert(CAREPORTSHEET, $ins_array);                
                    $insert_id=$this->db->insert_id();

                    $this->Common_model->updateSequenceval(PRJPRCLST,'sheetnumber','projectid='.$proid.' and processid='.$masterprcid,'id','ASC');

                    $this->session->set_flashdata('project_message', 'Report has been created successfully...');
                }
                else
                {
                    $update_array1 = array(
                        'system' => $this->input->post('projsystem'),                    
                        'referenceno' => $this->input->post('reportref'),
                        'engineerid' => $this->input->post('commairreptenggsign'),
                        'reportdate' => date('Y-m-d H:i:s',strtotime($this->input->post('commairreptenggdate'))),
                        'modifiedon' => $created_date,
                        'modifiedby' => $this->session->userdata('userid')
                    );

                    $this->Common_model->updatePrjPrcMaster($update_array1,$prcessid);

                 
                    $update_array = array(
                        'reportdescription' => $this->input->post('commairreptcomments'),
                    );
                        
                    $this->db->where('projectProcessListMasterid', $prcessid);
                    $this->db->update(CAREPORTSHEET, $update_array);

                
                    $this->session->set_flashdata('project_message', 'Report has been updated successfully...');

                }

                $sheetstatus=$this->input->post('shtenadis');

                $this->MProject->insertPrjSheetStatus($proid,$masterprcid,$sheetstatus,false);

                $path = base_url('projects/commAirRptSht/'.$proidnew.'/'.$prcessidnew);
                redirect($path);
            }
        }

      
        if($prcessid!=0)        
        {
           // echo $prcessid;
            $prcdatas=$this->MProject->getcareportsheet($prcessid);
            $ac = $data['prcdata']=$prcdatas[0];
            //$data['prcdata']=$this->MProject->getPrjPrcLst($prcessid)[0];

           // echo "<pre>"; 
          // print_r($ac);
        }

        $data['prcessid']=$prcessid;
        $data['masterprcid']=$masterprcid;
        $data['sheetstatus']=$this->MProject->getPrjSheetStatus($proid,$masterprcid);
        
        $data['custom_side_menu'] = 'projprsmenu';
        
        $data['prodata']=$this->Common_model->getProductById($proid);

        $data['engdata']=$this->MProject->getEngByPrjID($proid);

        $data['sidemenu_sub_active'] = 'commAir';
        $data['sidemenu_sub_active1'] = $this->uri->segment(2);
        $this->load->view('common/header',$data);
        $this->load->view('projects/commAir/commAirRptSht',$data);
        $this->load->view('common/footer');
    }
    public function commAirSysSche()
    {
        $this->exitpage('projects/projview');
        
        $proidnew = $this->uri->segment(3);
        $proid = intval($this->Common_model->decodeid($proidnew));        
        $data['proid'] = $proid;
        $prcessidnew = $this->uri->segment(4);
        $prcessid = intval($this->Common_model->decodeid($prcessidnew));

        if ($this->input->post('cancel'))
        {
            $path = base_url('projects/'.$this->uri->segment(2).'/'.$proidnew);
            redirect($path);
        }
        $masterprcid = 3;        
        $data['title'] = 'System Schematic';
        $data['masterprcid'] = $masterprcid;
        $getsysFilesdata=array();
        $created_date = date('Y-m-d H:i:s');
        
        $getsysFiles=$this->MProject->getsysFilesPrzid(intval($prcessid),CASYSSCHE);  
        if($getsysFiles->num_rows()>0)
            {
                $getsysFilesdata=$getsysFiles->result_array();
            }

        if ($this->input->post('submit'))
        {
            
            #echo '<pre>'; print_r($_FILES['uploadfile']);echo '</pre>';
            #exit;

            $this->form_validation->set_rules('reportref', 'Ref', 'trim|required');
            $this->form_validation->set_rules('projsystem', 'System', 'trim|required');            
            $this->form_validation->set_rules('commairreptenggsign', 'Engineer', 'trim|required');
            $this->form_validation->set_rules('commairreptenggsign', 'Engineer', 'trim|required');

            if($prcessid==0)
            {
                $this->form_validation->set_rules('uploadfile', 'Upload File', 'callback_checksyschefile');
            }
            else
            {     

                $ckemtyval=$_FILES['uploadfile']['name'];                                              
                if(isset($_FILES['uploadfile']) && !empty($ckemtyval) && ($getsysFiles->num_rows()==0))
                {
                    //$this->form_validation->set_rules('uploadfile', '', 'callback_casyschefilecheck');
                    $this->form_validation->set_rules('uploadfile', 'Upload File', 'callback_checksyschefile');
                }
               

            }


            

            if ($this->form_validation->run() == TRUE)
            {
                $created_date = date('Y-m-d H:i:s');
                if($this->input->post('delfiles'))
                {
                    $delfiles_query=array(
                        'isdeleted'=>'A',
                        'modifiedon' => $created_date,
                        'modifiedby' => $this->session->userdata('userid')
                    );
                    $delfiles=$this->input->post('delfiles');
                    if(!empty($delfiles))
                    {
                        foreach ($delfiles as $key => $value) {
                            $this->db->where('id', intval($value));
                            $this->db->update(CASYSSCHE, $delfiles_query);
                        }
                        
                    }
                }

                if($prcessid==0)
                {
                    $ins_array1 = array(
                        'projectid' =>  $proid,
                        'processid' =>  $masterprcid,
                        'sheetnumber' => 0,                        
                        'system' => $this->input->post('projsystem'),                    
                        'referenceno' => $this->input->post('reportref'),
                        'comments'  =>  '',                        
                        'engineerid' => $this->input->post('commairreptenggsign'),
                        'reportdate' => date('Y-m-d H:i:s',strtotime($this->input->post('commairreptenggdate'))),
                        'createdon' => $created_date,
                        'createdby' => $this->session->userdata('userid')
                    );

                    $prcessid=$this->Common_model->insertPrjPrcMaster($ins_array1);
                    $prcessidnew = ($this->Common_model->encodeid($prcessid));

                    /*$uploadData=array(
                        "orig_name"=>'',
                        "file_name"=>''
                    );*/

                    $ckemtyval=$_FILES['uploadfile']['name'];

                    if(isset($_FILES['uploadfile']) && !empty($ckemtyval))
                    {
                        $uploadData=array(
                            "orig_name"=>'',
                            "file_name"=>''
                        );

                        $filesCount = count($_FILES['uploadfile']['name']);                        
                        for($i = 0; $i < $filesCount; $i++){
                            $_FILES['userFile']['name'] = $_FILES['uploadfile']['name'][$i];
                            $_FILES['userFile']['type'] = $_FILES['uploadfile']['type'][$i];
                            $_FILES['userFile']['tmp_name'] = $_FILES['uploadfile']['tmp_name'][$i];
                            $_FILES['userFile']['error'] = $_FILES['uploadfile']['error'][$i];
                            $_FILES['userFile']['size'] = $_FILES['uploadfile']['size'][$i];

                            $mime = ($_FILES['uploadfile']['type'][$i]);
                            $filesize=$_FILES['uploadfile']['size'][$i];

                            $config['upload_path']   = DROOT.UPATH;
                            $config['allowed_types'] = 'gif|jpg|png|pdf';
                            $config['encrypt_name'] = TRUE;
                            //$config['allowed_types'] = 'gif|jpg|png';
                            
                            $this->load->library('upload', $config);
                            $this->upload->initialize($config);
                            if($this->upload->do_upload('userFile')){
                                /*$fileData = $this->upload->data();
                                $uploadData[$i]['file_name'] = $fileData['file_name'];
                                $uploadData[$i]['created'] = date("Y-m-d H:i:s");
                                $uploadData[$i]['modified'] = date("Y-m-d H:i:s");*/
                                
                                $uploadData = $this->upload->data();
                                $uploadedFile = $uploadData['file_name'];

                                chmod(DROOT.UPATH.$uploadData['file_name'],0777); // CHMOD file

                                $ins_array = array(
                                    'projectprocesslistmasterid' => $prcessid,
                                    'filename' => $uploadData['orig_name'],
                                    'filestorename'=>$uploadData['file_name'],
                                    'filetype' => $mime,
                                    'filesize'  => $filesize,
                                    'filestoredpath' => $config['upload_path'].$uploadData['file_name'],
                                    'createdon' => $created_date,
                                    'createdby' => $this->session->userdata('userid')
                                );
                                
                                $this->db->insert(CASYSSCHE, $ins_array);                
                                $insert_id=$this->db->insert_id();

                            }
                        }

                    }

                    $this->Common_model->updateSequenceval(PRJPRCLST,'sheetnumber','projectid='.$proid.' and processid='.$masterprcid,'id','ASC');

                    $this->session->set_flashdata('project_message', 'New System Schematic has been created successfully...');
                }
                else
                {
                    $update_array1 = array(
                        'system' => $this->input->post('projsystem'),                    
                        'referenceno' => $this->input->post('reportref'),
                        'engineerid' => $this->input->post('commairreptenggsign'),
                        'reportdate' => date('Y-m-d H:i:s',strtotime($this->input->post('commairreptenggdate'))),
                        'modifiedon' => $created_date,
                        'modifiedby' => $this->session->userdata('userid')
                    );

                    $this->Common_model->updatePrjPrcMaster($update_array1,$prcessid);

                    $ckemtyval=$_FILES['uploadfile']['name'];

                    if(isset($_FILES['uploadfile']['name']) && !empty($ckemtyval))
                    {
                        $uploadData=array(
                            "orig_name"=>'',
                            "file_name"=>''
                        );

                        $filesCount = count($_FILES['uploadfile']['name']);                        
                        for($i = 0; $i < $filesCount; $i++){
                            $_FILES['userFile']['name'] = $_FILES['uploadfile']['name'][$i];
                            $_FILES['userFile']['type'] = $_FILES['uploadfile']['type'][$i];
                            $_FILES['userFile']['tmp_name'] = $_FILES['uploadfile']['tmp_name'][$i];
                            $_FILES['userFile']['error'] = $_FILES['uploadfile']['error'][$i];
                            $_FILES['userFile']['size'] = $_FILES['uploadfile']['size'][$i];

                            $mime = ($_FILES['uploadfile']['type'][$i]);
                            $filesize=$_FILES['uploadfile']['size'][$i];

                            $config['upload_path']   = DROOT.UPATH;
                            $config['allowed_types'] = 'gif|jpg|png|pdf';
                            $config['encrypt_name'] = TRUE;
                            //$config['allowed_types'] = 'gif|jpg|png';
                            
                            $this->load->library('upload', $config);
                            $this->upload->initialize($config);
                            if($this->upload->do_upload('userFile')){

                                $uploadData = $this->upload->data();
                                $uploadedFile = $uploadData['file_name'];

                                chmod(DROOT.UPATH.$uploadData['file_name'],0777); // CHMOD file

                                $ins_array = array(
                                    'projectprocesslistmasterid' => $prcessid,
                                    'filename' => $uploadData['orig_name'],
                                    'filestorename'=>$uploadData['file_name'],
                                    'filetype' => $mime,
                                    'filesize'  => $filesize,
                                    'filestoredpath' => $config['upload_path'].$uploadData['file_name'],
                                    'createdon' => $created_date,
                                    'createdby' => $this->session->userdata('userid')
                                );
                                
                                $this->db->insert(CASYSSCHE, $ins_array);                
                                $insert_id=$this->db->insert_id();

                            }
                        }
                    }

                    

                    $this->session->set_flashdata('project_message', 'System Schematic has been updated successfully...');

                }

                $sheetstatus=$this->input->post('shtenadis');

                $this->MProject->insertPrjSheetStatus($proid,$masterprcid,$sheetstatus,false);

                $path = base_url('projects/commAirSysSche/'.$proidnew.'/'.$prcessidnew);
                redirect($path);
            }
        }

        //$data['sidemenu'] = 'hide';
        $data['engdata']=$this->MProject->getEngByPrjID($proid);
        if($prcessid!=0)        
        {
            $prcdatas=$this->MProject->getCAsysschemenew($prcessid);
            $data['prcdata']=$prcdatas[0];
            //$data['prcdata']=$this->MProject->getPrjPrcLst($prcessid)[0];
        }

        
        $data['prcessid']=$prcessid;
        $data['getsysFilesdata']=$getsysFilesdata;
        $data['sheetstatus']=$this->MProject->getPrjSheetStatus($proid,$masterprcid);
        $data['custom_side_menu'] = 'projprsmenu';
        $data['prodata']=$this->Common_model->getProductById($proid); 
        $data['sidemenu_sub_active'] = 'commAir';
        $data['sidemenu_sub_active1'] = $this->uri->segment(2);
        $this->load->view('common/header',$data);
        $this->load->view('projects/commAir/commAirSysSche',$data);
        $this->load->view('common/footer');
    }
    public function commAirSyspreck()
    {
        $this->exitpage('projects/projview');
        
        $proidnew = $this->uri->segment(3);
        $proid = intval($this->Common_model->decodeid($proidnew));        
        $data['proid'] = $proid;
        $prcessidnew = $this->uri->segment(4);
        $prcessid = intval($this->Common_model->decodeid($prcessidnew));

        if ($this->input->post('cancel'))
        {
            $path = base_url('projects/'.$this->uri->segment(2).'/'.$proidnew);
            redirect($path);
        }
        $masterprcid=4;
        
        $data['title'] = 'Air System Pre-Commissioning Checks';
        $data['masterprcid'] = $masterprcid;
        if ($this->input->post('submit'))
        {

            $this->form_validation->set_rules('reportref', 'Ref', 'trim|required');
            $this->form_validation->set_rules('projsystem', 'System', 'trim|required');            
            $this->form_validation->set_rules('commairreptenggsign', 'Engineer', 'trim|required');
            
            if ($this->form_validation->run() == TRUE)
            {
                $created_date = date('Y-m-d H:i:s');

                if($prcessid==0)
                {

                    $ins_array1 = array(
                        'projectid' =>  $proid,
                        'processid' =>  $masterprcid,
                        'sheetnumber' => 0,                        
                        'system' => $this->input->post('projsystem'),                    
                        'referenceno' => $this->input->post('reportref'),
                        'comments'  =>  $this->input->post('commaircomments'),                        
                        'engineerid' => $this->input->post('commairreptenggsign'),
                        'reportdate' => date('Y-m-d H:i:s',strtotime($this->input->post('commairreptenggdate'))),
                        'createdon' => $created_date,
                        'createdby' => $this->session->userdata('userid')
                    );

                    $prcessid=$this->Common_model->insertPrjPrcMaster($ins_array1);
                    $prcessidnew = ($this->Common_model->encodeid($prcessid));

                    $insarray_batch=array();

                    $procesSection_pdata=$this->input->post('procesSection');

                    if(!empty($procesSection_pdata))
                    {
                        foreach ($procesSection_pdata as $ps_key => $ps_value) 
                        {
                            $insarray_batch[] = array(
                              'projectprocesslistmasterid' => $prcessid ,
                              'processsectioncategoryid' => $masterprcid,
                              'processsectionid' => $ps_value,
                              'checked'=>intval($this->input->post('commAirPreCommopt'.$ps_value)),
                              'comments'=>$this->input->post('commAirPreCommcmd'.$ps_value),
                              'createdon' => $created_date,
                              'createdby' => $this->session->userdata('userid')
                            );
                        }
                    }

                    if(!empty($insarray_batch))
                    {
                        $this->db->insert_batch(CAPRECKDETAILS, $insarray_batch);
                    }

                    //$this->Common_model->updateSequenceval(CAPRECK,'sheetnumber','projectid='.$proid,'id','ASC');
                    $this->Common_model->updateSequenceval(PRJPRCLST,'sheetnumber','projectid='.$proid.' and processid='.$masterprcid,'id','ASC');

                    $this->session->set_flashdata('project_message', 'New Air System Pre-Commissioning Checks has been created successfully...');
                }
                else
                {
                    $update_array1 = array(
                        'system' => $this->input->post('projsystem'),                    
                        'referenceno' => $this->input->post('reportref'),
                        'comments' => $this->input->post('commaircomments'),
                        'engineerid' => $this->input->post('commairreptenggsign'),
                        'reportdate' => date('Y-m-d H:i:s',strtotime($this->input->post('commairreptenggdate'))),
                        'modifiedon' => $created_date,
                        'modifiedby' => $this->session->userdata('userid')
                    );

                    $this->Common_model->updatePrjPrcMaster($update_array1,$prcessid);
                    
                    $upsarray_batch=array();

                    $procesSection_pdata=$this->input->post('procesSection');

                    if(!empty($procesSection_pdata))
                    {
                        foreach ($procesSection_pdata as $ps_key => $ps_value) 
                        {
                            $upsarray_batch[] = array(
                                'id'=>intval($this->input->post('procesSectionId'.$ps_value)),
                                'projectprocesslistmasterid' => $prcessid ,
                                'processsectioncategoryid' => $masterprcid,
                                'processsectionid' => $ps_value,
                                'checked'=>intval($this->input->post('commAirPreCommopt'.$ps_value)),
                                'comments'=>$this->input->post('commAirPreCommcmd'.$ps_value),
                                'modifiedon' => $created_date,
                                'modifiedby' => $this->session->userdata('userid')
                            );
                        }
                    }

                    if(!empty($upsarray_batch))
                    {
                        $this->db->update_batch(CAPRECKDETAILS, $upsarray_batch,'id');
                    }

                    $this->session->set_flashdata('project_message', 'Air System Pre-Commissioning Checks has been updated successfully...');

                }

                $sheetstatus=$this->input->post('shtenadis');
                $this->MProject->insertPrjSheetStatus($proid,$masterprcid,$sheetstatus,false);

                $path = base_url('projects/commAirSyspreck/'.$proidnew.'/'.$prcessidnew);
                redirect($path);
            }
        }
        //$data['sidemenu'] = 'hide';
        $data['engdata']=$this->MProject->getEngByPrjID($proid);
        if($prcessid!=0)        
        {
            $prcdatas=$this->MProject->getCASyspreck($prcessid);
            $data['prcdata']=$prcdatas[0];
        }
        
        $data['prcessid']=$prcessid;
        $data['sheetstatus']=$this->MProject->getPrjSheetStatus($proid,4);
        $data['custom_side_menu'] = 'projprsmenu';
        $data['prodata']=$this->Common_model->getProductById($proid); 
        $data['sidemenu_sub_active'] = 'commAir';
        $data['sidemenu_sub_active1'] = $this->uri->segment(2);
        $this->load->view('common/header',$data);
        $this->load->view('projects/commAir/commAirSyspreck',$data);
        $this->load->view('common/footer');
    }
    public function commAirFanPerRcd()
    {
        $this->exitpage('projects/projview');
        
        $proidnew = $this->uri->segment(3);
        $proid = intval($this->Common_model->decodeid($proidnew));        
        $data['proid'] = $proid;
        $prcessidnew = $this->uri->segment(4);
        $prcessid = intval($this->Common_model->decodeid($prcessidnew));

        if ($this->input->post('cancel'))
        {
            $path = base_url('projects/'.$this->uri->segment(2).'/'.$proidnew);
            redirect($path);
        }
        $masterprcid=5;
        
        $data['title'] = 'Fan Details & Performance Test Record';
        $data['masterprcid'] = $masterprcid;
        //$data['sidemenu'] = 'hide';


        if ($this->input->post('submit'))
        {

            $this->form_validation->set_rules('reportref', 'Ref', 'trim|required');
            $this->form_validation->set_rules('projsystem', 'System', 'trim|required');            
            $this->form_validation->set_rules('commairreptenggsign', 'Engineer', 'trim|required');
            
            if ($this->form_validation->run() == TRUE)
            {
                $created_date = date('Y-m-d H:i:s');

                if($prcessid==0)
                {

                    $ins_array1 = array(
                        'projectid' =>  $proid,
                        'processid' =>  $masterprcid,
                        'sheetnumber' => 0,                        
                        'system' => $this->input->post('projsystem'),                    
                        'referenceno' => $this->input->post('reportref'),
                        'comments'  =>  $this->input->post('commaircomments'),                        
                        'engineerid' => $this->input->post('commairreptenggsign'),
                        'reportdate' => date('Y-m-d H:i:s',strtotime($this->input->post('commairreptenggdate'))),
                        'createdon' => $created_date,
                        'createdby' => $this->session->userdata('userid')
                    );

                    $prcessid=$this->Common_model->insertPrjPrcMaster($ins_array1);
                    $prcessidnew = ($this->Common_model->encodeid($prcessid));

                    $insarray_batch=array();

                    //$procesSection_pdata=$this->input->post('procesSection');
                    $procesSectionCat_pdata=$this->input->post('processSecCatid');

                    if(!empty($procesSectionCat_pdata))
                    {
                        foreach ($procesSectionCat_pdata as $psc_key => $psc_value) 
                        {                            
                            $processSecCatid=$psc_value;
                            $procesSection_pdata=$this->input->post('procesSection'.$psc_value);
                            foreach ($procesSection_pdata as $ps_key => $ps_value) 
                            {
                                $staticcheck=(($this->input->post('commAirPreCommopt'.$processSecCatid.'_'.$ps_value))?$this->input->post('commAirPreCommopt'.$processSecCatid.'_'.$ps_value):'');
                                $comments=(($this->input->post('commAirPreCommcmd'.$processSecCatid.'_'.$ps_value))?$this->input->post('commAirPreCommcmd'.$processSecCatid.'_'.$ps_value):'');
                                $testdata=(($this->input->post('commAirPreCommtestdata'.$processSecCatid.'_'.$ps_value))?$this->input->post('commAirPreCommtestdata'.$processSecCatid.'_'.$ps_value):'');
                                $testdata1=(($this->input->post('commAirPreCommtestdata1'.$processSecCatid.'_'.$ps_value))?$this->input->post('commAirPreCommtestdata1'.$processSecCatid.'_'.$ps_value):'');

                                $testdata_ans=(($this->input->post('testdata_ans'.$processSecCatid.'_'.$ps_value))?$this->input->post('testdata_ans'.$processSecCatid.'_'.$ps_value):'');
                                $testdata1_ans=(($this->input->post('testdata1_ans'.$processSecCatid.'_'.$ps_value))?$this->input->post('testdata1_ans'.$processSecCatid.'_'.$ps_value):'');                       

                                $insarray_batch[] = array(
                                  'projectprocesslistmasterid' => $prcessid ,
                                  'processsectioncategoryid' => $processSecCatid,
                                  'processsectionid' => $ps_value,
                                  'staticcheck'=>$staticcheck,
                                  'comments'=>$comments,
                                  'testdata'=>$testdata,
                                  'testdata1'=>$testdata1,
                                  'testdata_ans'=>$testdata_ans,
                                  'testdata1_ans'=>$testdata1_ans,
                                  'createdon' => $created_date,
                                  'createdby' => $this->session->userdata('userid')
                                );
                            }
                        }
                    }

                    if(!empty($insarray_batch))
                    {
                        $this->db->insert_batch(CAFANPERFTEST, $insarray_batch);
                    }

                    //$this->Common_model->updateSequenceval(CAPRECK,'sheetnumber','projectid='.$proid,'id','ASC');
                    $this->Common_model->updateSequenceval(PRJPRCLST,'sheetnumber','projectid='.$proid.' and processid='.$masterprcid,'id','ASC');

                    $this->session->set_flashdata('project_message', 'New '.$data['title'].' has been created successfully...');
                }
                else
                {
                   
                    $update_array1 = array(
                        'system' => $this->input->post('projsystem'),                    
                        'referenceno' => $this->input->post('reportref'),
                        'comments' => $this->input->post('commaircomments'),
                        'engineerid' => $this->input->post('commairreptenggsign'),
                        'reportdate' => date('Y-m-d H:i:s',strtotime($this->input->post('commairreptenggdate'))),
                        'modifiedon' => $created_date,
                        'modifiedby' => $this->session->userdata('userid')
                    );

                    $this->Common_model->updatePrjPrcMaster($update_array1,$prcessid);
                    
                    $upsarray_batch=array();

                    $procesSectionCat_pdata=$this->input->post('processSecCatid');

                    if(!empty($procesSectionCat_pdata))
                    {
                        foreach ($procesSectionCat_pdata as $psc_key => $psc_value) 
                        {                            
                            $processSecCatid=$psc_value;
                            $procesSection_pdata=$this->input->post('procesSection'.$psc_value);

                            if(!empty($procesSection_pdata))
                            {
                                foreach ($procesSection_pdata as $ps_key => $ps_value) 
                                {

                                    $staticcheck=(($this->input->post('commAirPreCommopt'.$processSecCatid.'_'.$ps_value))?$this->input->post('commAirPreCommopt'.$processSecCatid.'_'.$ps_value):'');
                                    $comments=(($this->input->post('commAirPreCommcmd'.$processSecCatid.'_'.$ps_value))?$this->input->post('commAirPreCommcmd'.$processSecCatid.'_'.$ps_value):'');
                                    $testdata=(($this->input->post('commAirPreCommtestdata'.$processSecCatid.'_'.$ps_value))?$this->input->post('commAirPreCommtestdata'.$processSecCatid.'_'.$ps_value):'');
                                    $testdata1=(($this->input->post('commAirPreCommtestdata1'.$processSecCatid.'_'.$ps_value))?$this->input->post('commAirPreCommtestdata1'.$processSecCatid.'_'.$ps_value):'');

                                    $testdata_ans=(($this->input->post('testdata_ans'.$processSecCatid.'_'.$ps_value))?$this->input->post('testdata_ans'.$processSecCatid.'_'.$ps_value):'');
                                    $testdata1_ans=(($this->input->post('testdata1_ans'.$processSecCatid.'_'.$ps_value))?$this->input->post('testdata1_ans'.$processSecCatid.'_'.$ps_value):'');

                                    $upsarray_batch[] = array(
                                        'id'=>intval($this->input->post('procesSectionId'.$ps_value)),
                                        'projectprocesslistmasterid' => $prcessid ,
                                        'processsectioncategoryid' => $masterprcid,
                                        'processsectionid' => $ps_value,
                                        'staticcheck'=>$staticcheck,
                                        'comments'=>$comments,
                                        'testdata'=>$testdata,
                                        'testdata1'=>$testdata1,
                                        'testdata_ans'=>$testdata_ans,
                                        'testdata1_ans'=>$testdata1_ans,
                                        'modifiedon' => $created_date,
                                        'modifiedby' => $this->session->userdata('userid')
                                    );
                                }
                            }
                        }
                    }

                    if(!empty($upsarray_batch))
                    {
                        $this->db->update_batch(CAFANPERFTEST, $upsarray_batch,'id');
                    }

                    $this->session->set_flashdata('project_message', $data['title'].' has been updated successfully...');

                }

                $sheetstatus=$this->input->post('shtenadis');
                $this->MProject->insertPrjSheetStatus($proid,$masterprcid,$sheetstatus,false);

                $path = base_url('projects/commAirFanPerRcd/'.$proidnew.'/'.$prcessidnew);
                redirect($path);
            }
        }
        //$data['sidemenu'] = 'hide';
        $data['engdata']=$this->MProject->getEngByPrjID($proid);
        if($prcessid!=0)        
        {
            $prcdatas=$this->MProject->getPrjPrcLst($prcessid);
            $data['prcdata']=$prcdatas[0];
        }


        $data['prcessid']=$prcessid;
        $data['sheetstatus']=$this->MProject->getPrjSheetStatus($proid,$masterprcid);
        $data['custom_side_menu'] = 'projprsmenu';
        $data['prodata']=$this->Common_model->getProductById($proid); 
        $data['sidemenu_sub_active'] = 'commAir';
        $data['sidemenu_sub_active1'] = $this->uri->segment(2);

        $this->load->view('common/header',$data);
        $this->load->view('projects/commAir/commAirFanPerRcd',$data);
        $this->load->view('common/footer');
    }
    public function commAirPlotRcd()
    {
        $this->exitpage('projects/projview');
        
        $proidnew = $this->uri->segment(3);
        $proid = intval($this->Common_model->decodeid($proidnew));        
        $data['proid'] = $proid;
        $prcessidnew = $this->uri->segment(4);
        $prcessid = intval($this->Common_model->decodeid($prcessidnew)); 

        if ($this->input->post('cancel'))
        {
            $path = base_url('projects/'.$this->uri->segment(2).'/'.$proidnew);
            redirect($path);
        }
        $masterprcid=6;        
        $data['title'] = 'Piot Volume Test Record';
        $data['masterprcid'] = $masterprcid;
        //$data['sidemenu'] = 'hide';

        if ($this->input->post('submit'))
        {

            $this->form_validation->set_rules('reportref', 'Ref', 'trim|required');
            $this->form_validation->set_rules('projsystem', 'System', 'trim|required');            
            $this->form_validation->set_rules('commairreptenggsign', 'Engineer', 'trim|required');
            
            if ($this->form_validation->run() == TRUE)
            {
                $created_date = date('Y-m-d H:i:s');

                if($prcessid==0)
                {

                    $ins_array1 = array(
                        'projectid' =>  $proid,
                        'processid' =>  $masterprcid,
                        'sheetnumber' => 0,                        
                        'system' => $this->input->post('projsystem'),                    
                        'referenceno' => $this->input->post('reportref'),
                        'comments'  =>  $this->input->post('commaircomments'),                        
                        'engineerid' => $this->input->post('commairreptenggsign'),
                        'reportdate' => date('Y-m-d H:i:s',strtotime($this->input->post('commairreptenggdate'))),
                        'createdon' => $created_date,
                        'createdby' => $this->session->userdata('userid')
                    );

                    $prcessid=$this->Common_model->insertPrjPrcMaster($ins_array1);
                    $prcessidnew = ($this->Common_model->encodeid($prcessid));

                    $ins_array2 = array(
                        'projectprocesslistmasterid' =>  $prcessid,
                        'ref_no'            =>  $this->input->post('reportref'),
                        'traverseref'       =>  $this->input->post('traverseref'),                        
                        'traverselocation'  =>  $this->input->post('traverselocation'),                    
                        'duct_size_mm'      =>  $this->input->post('duct_size_mm'),
                        'duct_size_mm1'      =>  $this->input->post('duct_size_mm1'),
                        'duct_area_m2'      =>  $this->input->post('duct_area_m2'),                        
                        'flow_rate_m3_s'    =>  $this->input->post('flow_rate_m3_s'),
                        'total_velocity'    =>  $this->input->post('total_velocity'),
                        'average_velocity'  =>  $this->input->post('average_velocity'),
                        'actual_volume'     =>  $this->input->post('actual_volume'),
                        'design'            =>  $this->input->post('design'),
                        'no_test_points'    =>  $this->input->post('no_test_points'),
                        'static_presssure'  =>  $this->input->post('static_presssure'),
                        'createdon'         =>  $created_date,
                        'createdby'         =>  $this->session->userdata('userid')
                    );
                    $this->db->insert(CAPTVLMDGN, $ins_array2);


                    $insarray_batch=array();
                    $procesSectionCat_pdata=$this->input->post('plotrcdid');

                    if(!empty($procesSectionCat_pdata))
                    {
                        foreach ($procesSectionCat_pdata as $psc_key => $psc_value) 
                        {                            
                            $insarray_batch[] = array(
                              'projectprocesslistmasterid' => $prcessid,
                              'ref_no'    =>  $this->input->post('reportref'),
                              'volume1'   =>  $_POST['value1'][$psc_key],
                              'volume2'   =>  $_POST['value2'][$psc_key],
                              'volume3'   =>  $_POST['value3'][$psc_key],
                              'volume4'   =>  $_POST['value4'][$psc_key],
                              'volume5'   =>  $_POST['value5'][$psc_key],
                              'volume6'   =>  $_POST['value6'][$psc_key],
                              'volume7'   =>  $_POST['value7'][$psc_key],
                              'volume8'   =>  $_POST['value8'][$psc_key],
                              'createdon' => $created_date,
                              'createdby' => $this->session->userdata('userid')
                            );
                        }
                    }

                    if(!empty($insarray_batch))
                    {
                        $this->db->insert_batch(CAPTMSDGN, $insarray_batch);
                    }

                    //$this->Common_model->updateSequenceval(CAPRECK,'sheetnumber','projectid='.$proid,'id','ASC');
                    $this->Common_model->updateSequenceval(PRJPRCLST,'sheetnumber','projectid='.$proid.' and processid='.$masterprcid,'id','ASC');

                    $this->session->set_flashdata('project_message', 'New '.$data['title'].' has been created successfully...');
                }
                else
                {
                   
                    $update_array1 = array(
                        'system' => $this->input->post('projsystem'),                    
                        'referenceno' => $this->input->post('reportref'),
                        'comments' => $this->input->post('commaircomments'),
                        'engineerid' => $this->input->post('commairreptenggsign'),
                        'reportdate' => date('Y-m-d H:i:s',strtotime($this->input->post('commairreptenggdate'))),
                        'modifiedon' => $created_date,
                        'modifiedby' => $this->session->userdata('userid')
                    );

                    $this->Common_model->updatePrjPrcMaster($update_array1,$prcessid);

                    $designid=$this->input->post('designid');
                    $ins_array2 = array(
                        'projectprocesslistmasterid' =>  $prcessid,
                        'ref_no'            =>  $this->input->post('reportref'),
                        'traverseref'       =>  $this->input->post('traverseref'),                        
                        'traverselocation'  =>  $this->input->post('traverselocation'),                    
                        'duct_size_mm'      =>  $this->input->post('duct_size_mm'),
                        'duct_size_mm1'      =>  $this->input->post('duct_size_mm1'),
                        'duct_area_m2'      =>  $this->input->post('duct_area_m2'),                        
                        'flow_rate_m3_s'    =>  $this->input->post('flow_rate_m3_s'),
                        'total_velocity'    =>  $this->input->post('total_velocity'),
                        'average_velocity'  =>  $this->input->post('average_velocity'),
                        'actual_volume'     =>  $this->input->post('actual_volume'),
                        'design'            =>  $this->input->post('design'),
                        'no_test_points'    =>  $this->input->post('no_test_points'),
                        'static_presssure'  =>  $this->input->post('static_presssure'),
                        'createdon'         =>  $created_date,
                        'createdby'         =>  $this->session->userdata('userid')
                    );
                    $this->db->where('id',$designid);
                    $this->db->update(CAPTVLMDGN, $ins_array2);
                    
                    $upsarray_batch=array();

                    $procesSectionCat_pdata=$this->input->post('plotrcdid');

                    if(!empty($procesSectionCat_pdata))
                    {
                        foreach ($procesSectionCat_pdata as $psc_key => $psc_value) 
                        {
                            if($psc_value==0)
                            {
                                $insarray_batch[] = array(
                                  'projectprocesslistmasterid' => $prcessid,
                                  'ref_no'    =>  $this->input->post('reportref'),
                                  'volume1'   =>  $_POST['value1'][$psc_key],
                                  'volume2'   =>  $_POST['value2'][$psc_key],
                                  'volume3'   =>  $_POST['value3'][$psc_key],
                                  'volume4'   =>  $_POST['value4'][$psc_key],
                                  'volume5'   =>  $_POST['value5'][$psc_key],
                                  'volume6'   =>  $_POST['value6'][$psc_key],
                                  'volume7'   =>  $_POST['value7'][$psc_key],
                                  'volume8'   =>  $_POST['value8'][$psc_key],
                                  'createdon' => $created_date,
                                  'createdby' => $this->session->userdata('userid')
                                );
                            }
                            else
                            {
                                $upsarray_batch[] = array(
                                    'id'=>$psc_value,
                                    'projectprocesslistmasterid' => $prcessid ,
                                    'ref_no'    =>  $this->input->post('reportref'),
                                    'volume1'   =>  $_POST['value1'][$psc_key],
                                    'volume2'   =>  $_POST['value2'][$psc_key],
                                    'volume3'   =>  $_POST['value3'][$psc_key],
                                    'volume4'   =>  $_POST['value4'][$psc_key],
                                    'volume5'   =>  $_POST['value5'][$psc_key],
                                    'volume6'   =>  $_POST['value6'][$psc_key],
                                    'volume7'   =>  $_POST['value7'][$psc_key],
                                    'volume8'   =>  $_POST['value8'][$psc_key],
                                    'modifiedon' => $created_date,
                                    'modifiedby' => $this->session->userdata('userid')
                                );
                            }

                        }
                    }

                    /* =========== Delete Grille === */

                    $grilledel_pdata=$this->input->post('plotrcddel');

                    if(!empty($grilledel_pdata))
                    {
                        foreach ($grilledel_pdata as $grd_key => $grd_value) 
                        {
                            if(intval($grd_value)!=0)
                            {
                                $this->db->where('id', $grd_value);
                                $this->db->delete(CAPTMSDGN);
                            }
                        }
                    }


                    if(!empty($upsarray_batch))
                    {
                        $this->db->update_batch(CAPTMSDGN, $upsarray_batch,'id');
                    }
                    if(!empty($insarray_batch))
                    {
                        $this->db->insert_batch(CAPTMSDGN, $insarray_batch);
                    }

                    $this->session->set_flashdata('project_message', $data['title'].' has been updated successfully...');

                }

                $sheetstatus=$this->input->post('shtenadis');
                $this->MProject->insertPrjSheetStatus($proid,$masterprcid,$sheetstatus,false);

                $path = base_url('projects/commAirPlotRcd/'.$proidnew.'/'.$prcessidnew);
                redirect($path);
            }
        }

        //$data['sidemenu'] = 'hide';
        $data['engdata']=$this->MProject->getEngByPrjID($proid);
        $plotrcdMsddata=$this->MProject->getPlotRcdMsddata($prcessid);
        $prcdesign=$this->MProject->getPlotRcdDsndata($prcessid);


        if($prcessid!=0)        
        {
            $prcdatas=$this->MProject->getPrjPrcLst($prcessid);
            $data['prcdata']=$prcdatas[0];            
        }

        if($plotrcdMsddata->num_rows()>0)
        {
            $data['plotrcd']=$plotrcdMsddata->result_array();
        }
        else
        {
            $data['plotrcd']=array(
                array(
                    'id'=>0,
                    'projectprocesslistmasterid' => $prcessid,
                    'ref_no'    =>  '',
                    'volume1'   =>  '',
                    'volume2'   =>  '',
                    'volume3'   =>  '',
                    'volume4'   =>  '',
                    'volume5'   =>  '',
                    'volume6'   =>  '',
                    'volume7'   =>  '',
                    'volume8'   =>  ''
                )
            );
        }

        if($prcdesign->num_rows()>0)
        {
            $prcdatas=$prcdesign->result_array();
            $data['prcdesign']=$prcdatas[0];
        }
        else
        {
            $data['prcdesign']=array(array(
                'id'    =>  0,
                'projectprocesslistmasterid' =>  $prcessid,
                'ref_no'            =>  '',
                'traverseref'       =>  '',
                'traverselocation'  =>  '',
                'duct_size_mm'      =>  '',
                'duct_size_mm1'      =>  '',
                'duct_area_m2'      =>  '',
                'flow_rate_m3_s'    =>  '',
                'total_velocity'    =>  '',
                'average_velocity'  =>  '',
                'actual_volume'     =>  '',
                'design'            =>  '',
                'no_test_points'    =>  '',
                'static_presssure'  =>  ''
            ));
        }

        if($this->input->post('value1'))
        {
            $data['plotrcd']=array();
            $value1=$this->input->post('value1');            
            foreach ($value1 as $key => $value) {
                $data['plotrcd'][]=array(
                    'id'=>$_POST['plotrcdid'][$key],
                    'projectprocesslistmasterid' => $prcessid,
                    'volume1'   =>  $_POST['value1'][$key],
                    'volume2'   =>  $_POST['volume2'][$key],
                    'volume3'   =>  $_POST['volume3'][$key],
                    'volume4'   =>  $_POST['volume4'][$key],
                    'volume5'   =>  $_POST['volume5'][$key],
                    'volume6'   =>  $_POST['volume6'][$key],
                    'volume7'   =>  $_POST['volume7'][$key],
                    'volume8'   =>  $_POST['volume8'][$key]
                );
            }

        }
        
        $data['prcessid']=$prcessid;
        $data['sheetstatus']=$this->MProject->getPrjSheetStatus($proid,$masterprcid);
        $data['custom_side_menu'] = 'projprsmenu';
        $data['prodata']=$this->Common_model->getProductById($proid); 
        $data['sidemenu_sub_active'] = 'commAir';
        $data['sidemenu_sub_active1'] = $this->uri->segment(2);

        $this->load->view('common/header',$data);
        $this->load->view('projects/commAir/commAirPlotRcd',$data);
        $this->load->view('common/footer');
    }
    public function commAirGrillBalRcd()
    {
        $this->exitpage('projects/projview');
        
        $proidnew = $this->uri->segment(3);
        $proid = intval($this->Common_model->decodeid($proidnew));        
        $data['proid'] = $proid;
        $prcessidnew = $this->uri->segment(4);
        $prcessid = intval($this->Common_model->decodeid($prcessidnew));

        if ($this->input->post('cancel'))
        {
            $path = base_url('projects/'.$this->uri->segment(2).'/'.$proidnew);
            redirect($path);
        }
        $masterprcid=7;        
        $data['title'] = 'Grilling Balance Test Record';
        $data['masterprcid'] = $masterprcid;
        //$data['sidemenu'] = 'hide';

        if ($this->input->post('submit'))
        {

            $this->form_validation->set_rules('reportref', 'Ref', 'trim|required');
            $this->form_validation->set_rules('projsystem', 'System', 'trim|required');            
            $this->form_validation->set_rules('commairreptenggsign', 'Engineer', 'trim|required');
            
            if ($this->form_validation->run() == TRUE)
            {
                $created_date = date('Y-m-d H:i:s');

                if($prcessid==0)
                {

                    $ins_array1 = array(
                        'projectid' =>  $proid,
                        'processid' =>  $masterprcid,
                        'sheetnumber' => 0,                        
                        'system' => $this->input->post('projsystem'),                    
                        'referenceno' => $this->input->post('reportref'),
                        'comments'  =>  $this->input->post('commaircomments'),                        
                        'engineerid' => $this->input->post('commairreptenggsign'),
                        'reportdate' => date('Y-m-d H:i:s',strtotime($this->input->post('commairreptenggdate'))),
                        'createdon' => $created_date,
                        'createdby' => $this->session->userdata('userid')
                    );

                    $prcessid=$this->Common_model->insertPrjPrcMaster($ins_array1);
                    $prcessidnew = ($this->Common_model->encodeid($prcessid));


                    $ins_array2 = array(
                        'projectprocesslistmasterid' =>  $prcessid,
                        'grilleductotal'            =>  $this->input->post('grilleductotal'),
                        'grillehoodtotal'       =>  $this->input->post('grillehoodtotal'),                        
                        'grillecorrfactor'  =>  $this->input->post('grillecorrfactor'),
                        'createdon'         =>  $created_date,
                        'createdby'         =>  $this->session->userdata('userid')
                    );
                    $this->db->insert(CAGRILL, $ins_array2);

                    $insarray_batch=array();

                    //$procesSection_pdata=$this->input->post('procesSection');
                    $procesSectionCat_pdata=$this->input->post('gilleid');

                    if(!empty($procesSectionCat_pdata))
                    {
                        foreach ($procesSectionCat_pdata as $psc_key => $psc_value) 
                        {                            
                            $insarray_batch[] = array(
                              'projectprocesslistmasterid' => $prcessid ,
                              'grilleno' => $_POST['grilleno'][$psc_key],
                              'grille_hood_size' => $_POST['grille_hood_size'][$psc_key],
                              'area'=>$_POST['area'][$psc_key],
                              'design_volume'=>$_POST['design_volume'][$psc_key],
                              'design_velocity'=>$_POST['design_velocity'][$psc_key],
                              'final_velocity'=>$_POST['final_velocity'][$psc_key],
                              'measured_volume'=>$_POST['measured_volume'][$psc_key],
                              'correction_factor'=>$_POST['correction_factor'][$psc_key],
                              'actual_volume'=>$_POST['actual_volume'][$psc_key],
                              'design'=>$_POST['design'][$psc_key],
                              'createdon' => $created_date,
                              'createdby' => $this->session->userdata('userid')
                            );
                        }
                    }

                    if(!empty($insarray_batch))
                    {
                        $this->db->insert_batch(CAGRILLBAL, $insarray_batch);
                    }

                    //$this->Common_model->updateSequenceval(CAPRECK,'sheetnumber','projectid='.$proid,'id','ASC');
                    $this->Common_model->updateSequenceval(PRJPRCLST,'sheetnumber','projectid='.$proid.' and processid='.$masterprcid,'id','ASC');

                    $this->session->set_flashdata('project_message', 'New '.$data['title'].' has been created successfully...');
                }
                else
                {
                   
                    $update_array1 = array(
                        'system' => $this->input->post('projsystem'),                    
                        'referenceno' => $this->input->post('reportref'),
                        'comments' => $this->input->post('commaircomments'),
                        'engineerid' => $this->input->post('commairreptenggsign'),
                        'reportdate' => date('Y-m-d H:i:s',strtotime($this->input->post('commairreptenggdate'))),
                        'modifiedon' => $created_date,
                        'modifiedby' => $this->session->userdata('userid')
                    );

                    $this->Common_model->updatePrjPrcMaster($update_array1,$prcessid);

                    $grillmainid=$this->input->post('grillmainid');

                    $ins_array2 = array(
                        'projectprocesslistmasterid' =>  $prcessid,
                        'grilleductotal'            =>  $this->input->post('grilleductotal'),
                        'grillehoodtotal'       =>  $this->input->post('grillehoodtotal'),                        
                        'grillecorrfactor'  =>  $this->input->post('grillecorrfactor'),
                        'createdon'         =>  $created_date,
                        'createdby'         =>  $this->session->userdata('userid')
                    );      
                    if($grillmainid!=0)              
                    {
                        $this->db->where('id',$grillmainid);
                        $this->db->update(CAGRILL, $ins_array2);                        
                    }
                    else
                    {
                        $this->db->insert(CAGRILL, $ins_array2);
                        $grillmainid=$this->db->insert_id();
                    }
                    
                    $upsarray_batch=array();

                    $procesSectionCat_pdata=$this->input->post('gilleid');

                    if(!empty($procesSectionCat_pdata))
                    {
                        foreach ($procesSectionCat_pdata as $psc_key => $psc_value) 
                        {
                            if($psc_value==0)
                            {
                                $insarray_batch[] = array(
                                  'projectprocesslistmasterid' => $prcessid ,
                                  'grilleno' => $_POST['grilleno'][$psc_key],
                                  'grille_hood_size' => $_POST['grille_hood_size'][$psc_key],
                                  'area'=>$_POST['area'][$psc_key],
                                  'design_volume'=>$_POST['design_volume'][$psc_key],
                                  'design_velocity'=>$_POST['design_velocity'][$psc_key],
                                  'final_velocity'=>$_POST['final_velocity'][$psc_key],
                                  'measured_volume'=>$_POST['measured_volume'][$psc_key],
                                  'correction_factor'=>$_POST['correction_factor'][$psc_key],
                                  'actual_volume'=>$_POST['actual_volume'][$psc_key],
                                  'design'=>$_POST['design'][$psc_key],
                                  'createdon' => $created_date,
                                  'createdby' => $this->session->userdata('userid')
                                );
                            }
                            else
                            {
                                $upsarray_batch[] = array(
                                    'id'=>$psc_value,
                                    'projectprocesslistmasterid' => $prcessid ,
                                    'grilleno' => $_POST['grilleno'][$psc_key],
                                    'grille_hood_size' => $_POST['grille_hood_size'][$psc_key],
                                    'area'=>$_POST['area'][$psc_key],
                                    'design_volume'=>$_POST['design_volume'][$psc_key],
                                    'design_velocity'=>$_POST['design_velocity'][$psc_key],
                                    'final_velocity'=>$_POST['final_velocity'][$psc_key],
                                    'measured_volume'=>$_POST['measured_volume'][$psc_key],
                                    'correction_factor'=>$_POST['correction_factor'][$psc_key],
                                    'actual_volume'=>$_POST['actual_volume'][$psc_key],
                                    'design'=>$_POST['design'][$psc_key],
                                    'modifiedon' => $created_date,
                                    'modifiedby' => $this->session->userdata('userid')
                                );
                            }

                        }
                    }

                    /* =========== Delete Grille === */

                    $grilledel_pdata=$this->input->post('grilledel');

                    if(!empty($grilledel_pdata))
                    {
                        foreach ($grilledel_pdata as $grd_key => $grd_value) 
                        {
                            if(intval($grd_value)!=0)
                            {
                                $this->db->where('id', $grd_value);
                                $this->db->delete(CAGRILLBAL);
                            }
                        }
                    }


                    if(!empty($upsarray_batch))
                    {
                        $this->db->update_batch(CAGRILLBAL, $upsarray_batch,'id');
                    }
                    if(!empty($insarray_batch))
                    {
                        $this->db->insert_batch(CAGRILLBAL, $insarray_batch);
                    }

                    $this->session->set_flashdata('project_message', $data['title'].' has been updated successfully...');

                }

                $sheetstatus=$this->input->post('shtenadis');
                $this->MProject->insertPrjSheetStatus($proid,$masterprcid,$sheetstatus,false);

                $path = base_url('projects/commAirGrillBalRcd/'.$proidnew.'/'.$prcessidnew);
                redirect($path);
            }
        }

        //$data['sidemenu'] = 'hide';
        $data['engdata']=$this->MProject->getEngByPrjID($proid);
        $grillegriddata=$this->MProject->getGrilleBaldata($prcessid);

        if($prcessid!=0)        
        {
            $prcdatas=$this->MProject->getPrjPrcLst($prcessid);
            $data['prcdata']=$prcdatas[0];  

            $prcdatas=$this->MProject->getGrilleBalMain($prcessid);
            if(isset($prcdatas[0]))
            {
                $data['grillmain']=$prcdatas[0];
            }
            else
            {
                $data['grillmain']=array();
            }

        }

        if($grillegriddata->num_rows()>0)
        {
            $data['grillegrid']=$grillegriddata->result_array();
        }
        else
        {
            $data['grillegrid']=array(
                array(
                    'id'=>0,
                    'projectprocesslistmasterid' => $prcessid ,
                    'grilleno' => '',
                    'grille_hood_size' => '',
                    'area'=>'',
                    'design_volume'=>'',
                    'design_velocity'=>'',
                    'final_velocity'=>'',
                    'measured_volume'=>'',
                    'correction_factor'=>'',
                    'actual_volume'=>'',
                    'design'=>''
                )
            );
        }

        if($this->input->post('grilleno'))
        {
            $data['grillegrid']=array();
            $value1=$this->input->post('grilleno');            
            foreach ($value1 as $key => $value) {
                $data['grillegrid'][]=array(
                    'id'=>$_POST['gilleid'][$key],
                    'projectprocesslistmasterid' => $prcessid,
                    'grilleno'   =>  $_POST['grilleno'][$key],
                    'grille_hood_size' => $_POST['grille_hood_size'][$key],
                    'area'=>$_POST['area'][$key],
                    'design_volume'=>$_POST['design_volume'][$key],
                    'design_velocity'=>$_POST['design_velocity'][$key],
                    'final_velocity'=>$_POST['final_velocity'][$key],
                    'measured_volume'=>$_POST['measured_volume'][$key],
                    'correction_factor'=>$_POST['correction_factor'][$key],
                    'actual_volume'=>$_POST['actual_volume'][$key],
                    'design'=>$_POST['design'][$key]
                );
            }

        }

        if($this->input->post('grilleductotal'))
        {
            $data['grillmain']=array(
                array(
                    'id' =>  $this->input->post('grillmainid'),
                    'projectprocesslistmasterid'    =>  $prcessid,
                    'grilleductotal'                =>  $this->input->post('grilleductotal'),
                    'grillehoodtotal'               =>  $this->input->post('grillehoodtotal'),                        
                    'grillecorrfactor'              =>  $this->input->post('grillecorrfactor')
                )
            );
        }


        $data['prcessid']=$prcessid;
        $data['sheetstatus']=$this->MProject->getPrjSheetStatus($proid,$masterprcid);
        $data['custom_side_menu'] = 'projprsmenu';
        $data['prodata']=$this->Common_model->getProductById($proid); 
        $data['sidemenu_sub_active'] = 'commAir';
        $data['sidemenu_sub_active1'] = $this->uri->segment(2);
        
        $this->load->view('common/header',$data);
        $this->load->view('projects/commAir/commAirGrillBalRcd',$data);
        $this->load->view('common/footer');
    }
    public function commAirDirGrillRcd()
    {
        $this->exitpage('projects/projview');
        
        $proidnew = $this->uri->segment(3);
        $proid = intval($this->Common_model->decodeid($proidnew));        
        $data['proid'] = $proid;
        $prcessidnew = $this->uri->segment(4);
        $prcessid = intval($this->Common_model->decodeid($prcessidnew)); 

        if ($this->input->post('cancel'))
        {
            $path = base_url('projects/'.$this->uri->segment(2).'/'.$proidnew);
            redirect($path);
        }
        $masterprcid=8;        
        $data['title'] = 'Direct Volume Grilling Record Sheet';
        $data['masterprcid'] = $masterprcid;
        //$data['sidemenu'] = 'hide';

        if ($this->input->post('submit'))
        {

            $this->form_validation->set_rules('reportref', 'Ref', 'trim|required');
            $this->form_validation->set_rules('projsystem', 'System', 'trim|required');            
            $this->form_validation->set_rules('commairreptenggsign', 'Engineer', 'trim|required');
            
            if ($this->form_validation->run() == TRUE)
            {
                $created_date = date('Y-m-d H:i:s');

                if($prcessid==0)
                {

                    $ins_array1 = array(
                        'projectid' =>  $proid,
                        'processid' =>  $masterprcid,
                        'sheetnumber' => 0,                        
                        'system' => $this->input->post('projsystem'),                    
                        'referenceno' => $this->input->post('reportref'),
                        'comments'  =>  $this->input->post('commaircomments'),                        
                        'engineerid' => $this->input->post('commairreptenggsign'),
                        'reportdate' => date('Y-m-d H:i:s',strtotime($this->input->post('commairreptenggdate'))),
                        'createdon' => $created_date,
                        'createdby' => $this->session->userdata('userid')
                    );

                    $prcessid=$this->Common_model->insertPrjPrcMaster($ins_array1);
                    $prcessidnew = ($this->Common_model->encodeid($prcessid));

                    $ins_array2 = array(
                        'projectprocesslistmasterid' =>  $prcessid,
                        'grilleductotal'            =>  $this->input->post('grilleductotal'),
                        'grillehoodtotal'       =>  $this->input->post('grillehoodtotal'),                        
                        'grillecorrfactor'  =>  $this->input->post('grillecorrfactor'),
                        'createdon'         =>  $created_date,
                        'createdby'         =>  $this->session->userdata('userid')
                    );
                    $this->db->insert(CADIRGRILLVLM, $ins_array2);

                    $insarray_batch=array();

                    //$procesSection_pdata=$this->input->post('procesSection');
                    $procesSectionCat_pdata=$this->input->post('dirgilleid');

                    if(!empty($procesSectionCat_pdata))
                    {
                        foreach ($procesSectionCat_pdata as $psc_key => $psc_value) 
                        {                            
                            $insarray_batch[] = array(
                              'projectprocesslistmasterid' => $prcessid ,
                              'ref_no' => $_POST['ref_no'][$psc_key],
                              'grille_size' => $_POST['grille_size'][$psc_key],
                              'design_volume'=>$_POST['design_volume'][$psc_key],
                              'final_volume'=>$_POST['final_volume'][$psc_key],
                              'correction_factor'=>$_POST['correction_factor'][$psc_key],
                              'actual_volume'=>$_POST['actual_volume'][$psc_key],
                              'record_percent'=>$_POST['record_percent'][$psc_key],
                              'setting'=>$_POST['setting'][$psc_key],
                              'createdon' => $created_date,
                              'createdby' => $this->session->userdata('userid')
                            );
                        }
                    }

                    if(!empty($insarray_batch))
                    {
                        $this->db->insert_batch(CADIRGRILL, $insarray_batch);
                    }

                    //$this->Common_model->updateSequenceval(CAPRECK,'sheetnumber','projectid='.$proid,'id','ASC');
                    $this->Common_model->updateSequenceval(PRJPRCLST,'sheetnumber','projectid='.$proid.' and processid='.$masterprcid,'id','ASC');

                    $this->session->set_flashdata('project_message', 'New '.$data['title'].' has been created successfully...');
                }
                else
                {
                   
                    $update_array1 = array(
                        'system' => $this->input->post('projsystem'),                    
                        'referenceno' => $this->input->post('reportref'),
                        'comments' => $this->input->post('commaircomments'),
                        'engineerid' => $this->input->post('commairreptenggsign'),
                        'reportdate' => date('Y-m-d H:i:s',strtotime($this->input->post('commairreptenggdate'))),
                        'modifiedon' => $created_date,
                        'modifiedby' => $this->session->userdata('userid')
                    );

                    $this->Common_model->updatePrjPrcMaster($update_array1,$prcessid);

                    $grillmainid=$this->input->post('grillmainid');

                    $ins_array2 = array(
                        'projectprocesslistmasterid' =>  $prcessid,
                        'grilleductotal'            =>  $this->input->post('grilleductotal'),
                        'grillehoodtotal'       =>  $this->input->post('grillehoodtotal'),                        
                        'grillecorrfactor'  =>  $this->input->post('grillecorrfactor'),
                        'createdon'         =>  $created_date,
                        'createdby'         =>  $this->session->userdata('userid')
                    );                    
                    $this->db->where('id',$grillmainid);
                    $this->db->update(CAGRILL, $ins_array2);
                    
                    $upsarray_batch=array();

                    $procesSectionCat_pdata=$this->input->post('dirgilleid');

                    if(!empty($procesSectionCat_pdata))
                    {
                        foreach ($procesSectionCat_pdata as $psc_key => $psc_value) 
                        {
                            if($psc_value==0)
                            {
                                $insarray_batch[] = array(
                                  'projectprocesslistmasterid' => $prcessid ,
                                  'ref_no' => $_POST['ref_no'][$psc_key],
                                  'grille_size' => $_POST['grille_size'][$psc_key],
                                  'design_volume'=>$_POST['design_volume'][$psc_key],
                                  'final_volume'=>$_POST['final_volume'][$psc_key],
                                  'correction_factor'=>$_POST['correction_factor'][$psc_key],
                                  'actual_volume'=>$_POST['actual_volume'][$psc_key],
                                  'record_percent'=>$_POST['record_percent'][$psc_key],
                                  'setting'=>$_POST['setting'][$psc_key],                                  
                                  'createdon' => $created_date,
                                  'createdby' => $this->session->userdata('userid')
                                );
                            }
                            else
                            {
                                $upsarray_batch[] = array(
                                    'id'=>$psc_value,
                                    'projectprocesslistmasterid' => $prcessid ,
                                    'ref_no' => $_POST['ref_no'][$psc_key],
                                    'grille_size' => $_POST['grille_size'][$psc_key],
                                    'design_volume'=>$_POST['design_volume'][$psc_key],
                                    'final_volume'=>$_POST['final_volume'][$psc_key],
                                    'correction_factor'=>$_POST['correction_factor'][$psc_key],
                                    'actual_volume'=>$_POST['actual_volume'][$psc_key],
                                    'record_percent'=>$_POST['record_percent'][$psc_key],
                                    'setting'=>$_POST['setting'][$psc_key],
                                    'modifiedon' => $created_date,
                                    'modifiedby' => $this->session->userdata('userid')
                                );
                            }

                        }
                    }

                    /* =========== Delete Grille === */

                    $grilledel_pdata=$this->input->post('dirgrilledel');

                    if(!empty($grilledel_pdata))
                    {
                        foreach ($grilledel_pdata as $grd_key => $grd_value) 
                        {
                            if(intval($grd_value)!=0)
                            {
                                $this->db->where('id', $grd_value);
                                $this->db->delete(CADIRGRILL);
                            }
                        }
                    }


                    if(!empty($upsarray_batch))
                    {
                        $this->db->update_batch(CADIRGRILL, $upsarray_batch,'id');
                    }
                    if(!empty($insarray_batch))
                    {
                        $this->db->insert_batch(CADIRGRILL, $insarray_batch);
                    }

                    $this->session->set_flashdata('project_message', $data['title'].' has been updated successfully...');

                }

                $sheetstatus=$this->input->post('shtenadis');
                $this->MProject->insertPrjSheetStatus($proid,$masterprcid,$sheetstatus,false);

                $path = base_url('projects/commAirDirGrillRcd/'.$proidnew.'/'.$prcessidnew);
                redirect($path);
            }
        }

        //$data['sidemenu'] = 'hide';
        $data['engdata']=$this->MProject->getEngByPrjID($proid);
        $grillegriddata=$this->MProject->getDirGrilleBaldata($prcessid);

        if($prcessid!=0)        
        {
            $prcdatas=$this->MProject->getPrjPrcLst($prcessid); 
            $data['prcdata']=$prcdatas[0];

            $prcdatas=$this->MProject->getDirGrilleBalMain($prcessid);
            $data['grillmain']=$prcdatas[0];

        }

        if($grillegriddata->num_rows()>0)
        {
            $data['dirgrillegrid']=$grillegriddata->result_array();
        }
        else
        {
            $data['dirgrillegrid']=array(
                array(
                    'id'=>0,
                    'projectprocesslistmasterid' => $prcessid ,
                    'ref_no' => '',
                    'grille_size' => '',
                    'design_volume'=>'',
                    'final_volume'=>'',
                    'correction_factor'=>'',
                    'actual_volume'=>'',
                    'record_percent'=>'',
                    'setting'=>''
                )
            );
        }

        if($this->input->post('ref_no'))
        {
            $data['dirgrillegrid']=array();
            $value1=$this->input->post('ref_no');            
            foreach ($value1 as $key => $value) {
                $data['dirgrillegrid'][]=array(
                    'id'=>$_POST['dirgilleid'][$key],
                    'projectprocesslistmasterid' => $prcessid,                    
                    'ref_no' => $_POST['ref_no'][$key],
                    'grille_size' => $_POST['grille_size'][$key],
                    'design_volume'=>$_POST['design_volume'][$key],
                    'final_volume'=>$_POST['final_volume'][$key],
                    'correction_factor'=>$_POST['correction_factor'][$key],
                    'actual_volume'=>$_POST['actual_volume'][$key],
                    'record_percent'=>$_POST['record_percent'][$key],
                    'setting'=>$_POST['setting'][$key],
                );
            }

        }

        if($this->input->post('grilleductotal'))
        {
            $data['grillmain']=array(
                array(
                    'id' =>  $this->input->post('grillmainid'),
                    'projectprocesslistmasterid'    =>  $prcessid,
                    'grilleductotal'                =>  $this->input->post('grilleductotal'),
                    'grillehoodtotal'               =>  $this->input->post('grillehoodtotal'),                        
                    'grillecorrfactor'              =>  $this->input->post('grillecorrfactor')
                )
            );
        }

        //$data['sidemenu'] = 'hide';
        $data['prcessid']=$prcessid;
        $data['sheetstatus']=$this->MProject->getPrjSheetStatus($proid,$masterprcid);
        $data['custom_side_menu'] = 'projprsmenu';
        $data['prodata']=$this->Common_model->getProductById($proid); 
        $data['sidemenu_sub_active'] = 'commAir';
        $data['sidemenu_sub_active1'] = $this->uri->segment(2);

        $this->load->view('common/header',$data);
        $this->load->view('projects/commAir/commAirDirGrillRcd',$data);
        $this->load->view('common/footer');
    }
    public function commAirVlmControl()
    {
        $this->exitpage('projects/projview');
        
        $proidnew = $this->uri->segment(3);
        $proid = intval($this->Common_model->decodeid($proidnew));        
        $data['proid'] = $proid;
        $prcessidnew = $this->uri->segment(4);
        $prcessid = intval($this->Common_model->decodeid($prcessidnew));

        if ($this->input->post('cancel'))
        {
            $path = base_url('projects/'.$this->uri->segment(2).'/'.$proidnew);
            redirect($path);
        }
        
        $masterprcid=9;        
        $data['title'] = 'Variable Air Volume Control Box Test Record';
        $data['masterprcid'] = $masterprcid;
        //$data['sidemenu'] = 'hide';

        if ($this->input->post('submit'))
        {

            $this->form_validation->set_rules('reportref', 'Ref', 'trim|required');
            $this->form_validation->set_rules('projsystem', 'System', 'trim|required');            
            $this->form_validation->set_rules('commairreptenggsign', 'Engineer', 'trim|required');
            
            if ($this->form_validation->run() == TRUE)
            {
                $created_date = date('Y-m-d H:i:s');

                if($prcessid==0)
                {

                    $ins_array1 = array(
                        'projectid' =>  $proid,
                        'processid' =>  $masterprcid,
                        'sheetnumber' => 0,                        
                        'system' => $this->input->post('projsystem'),                    
                        'referenceno' => $this->input->post('reportref'),
                        'comments'  =>  $this->input->post('commaircomments'),                        
                        'engineerid' => $this->input->post('commairreptenggsign'),
                        'reportdate' => date('Y-m-d H:i:s',strtotime($this->input->post('commairreptenggdate'))),
                        'createdon' => $created_date,
                        'createdby' => $this->session->userdata('userid')
                    );

                    $prcessid=$this->Common_model->insertPrjPrcMaster($ins_array1);
                    $prcessidnew = ($this->Common_model->encodeid($prcessid));

                    $insarray_batch=array();

                    //$procesSection_pdata=$this->input->post('procesSection');
                    $procesSectionCat_pdata=$this->input->post('vlmctrlid');

                    if(!empty($procesSectionCat_pdata))
                    {
                        foreach ($procesSectionCat_pdata as $psc_key => $psc_value) 
                        {                            
                            $insarray_batch[] = array(
                                'projectprocesslistmasterid' => $prcessid ,
                                'ref_no' => $this->input->post('reportref'),
                                'vav_refno' => $_POST['vav_refno'][$psc_key],
                                'vav_addr_ref'=>$_POST['vav_addr_ref'][$psc_key],
                                'vav_nonimal_value'=>$_POST['vav_nonimal_value'][$psc_key],
                                'max_flow_m3_s'=>$_POST['max_flow_m3_s'][$psc_key],
                                'min_flow_m3_s'=>$_POST['min_flow_m3_s'][$psc_key],
                                'min_p_pa'=>$_POST['min_p_pa'][$psc_key],
                                'min_volts'=>$_POST['min_volts'][$psc_key],
                                'min_vol_m3s'=>$_POST['min_vol_m3s'][$psc_key],
                                'min_percentage'=>$_POST['min_percentage'][$psc_key],
                                'max_p_pa'=>$_POST['max_p_pa'][$psc_key],
                                'max_volts'=>$_POST['max_volts'][$psc_key],
                                'max_vol_m3s'=>$_POST['max_vol_m3s'][$psc_key],
                                'max_percentage'=>$_POST['max_percentage'][$psc_key],
                                'createdon' => $created_date,
                                'createdby' => $this->session->userdata('userid')
                            );
                        }
                    }

                    if(!empty($insarray_batch))
                    {
                        $this->db->insert_batch(CAAIRCTRL, $insarray_batch);
                    }

                    //$this->Common_model->updateSequenceval(CAPRECK,'sheetnumber','projectid='.$proid,'id','ASC');
                    $this->Common_model->updateSequenceval(PRJPRCLST,'sheetnumber','projectid='.$proid.' and processid='.$masterprcid,'id','ASC');

                    $this->session->set_flashdata('project_message', 'New '.$data['title'].' has been created successfully...');
                }
                else
                {
                   
                    $update_array1 = array(
                        'system' => $this->input->post('projsystem'),                    
                        'referenceno' => $this->input->post('reportref'),
                        'comments' => $this->input->post('commaircomments'),
                        'engineerid' => $this->input->post('commairreptenggsign'),
                        'reportdate' => date('Y-m-d H:i:s',strtotime($this->input->post('commairreptenggdate'))),
                        'modifiedon' => $created_date,
                        'modifiedby' => $this->session->userdata('userid')
                    );

                    $this->Common_model->updatePrjPrcMaster($update_array1,$prcessid);
                    
                    $upsarray_batch=array();

                    $procesSectionCat_pdata=$this->input->post('vlmctrlid');

                    if(!empty($procesSectionCat_pdata))
                    {
                        foreach ($procesSectionCat_pdata as $psc_key => $psc_value) 
                        {
                            if($psc_value==0)
                            {
                                $insarray_batch[] = array(
                                  'projectprocesslistmasterid' => $prcessid ,
                                  'ref_no' => $this->input->post('reportref'),
                                    'vav_refno' => $_POST['vav_refno'][$psc_key],
                                    'vav_addr_ref'=>$_POST['vav_addr_ref'][$psc_key],
                                    'vav_nonimal_value'=>$_POST['vav_nonimal_value'][$psc_key],
                                    'max_flow_m3_s'=>$_POST['max_flow_m3_s'][$psc_key],
                                    'min_flow_m3_s'=>$_POST['min_flow_m3_s'][$psc_key],
                                    'min_p_pa'=>$_POST['min_p_pa'][$psc_key],
                                    'min_volts'=>$_POST['min_volts'][$psc_key],
                                    'min_vol_m3s'=>$_POST['min_vol_m3s'][$psc_key],
                                    'min_percentage'=>$_POST['min_percentage'][$psc_key],
                                    'max_p_pa'=>$_POST['max_p_pa'][$psc_key],
                                    'max_volts'=>$_POST['max_volts'][$psc_key],
                                    'max_vol_m3s'=>$_POST['max_vol_m3s'][$psc_key],
                                    'max_percentage'=>$_POST['max_percentage'][$psc_key],
                                  'createdon' => $created_date,
                                  'createdby' => $this->session->userdata('userid')
                                );
                            }
                            else
                            {
                                $upsarray_batch[] = array(
                                    'id'=>$psc_value,
                                    'projectprocesslistmasterid' => $prcessid ,
                                    'ref_no' => $this->input->post('reportref'),
                                    'vav_refno' => $_POST['vav_refno'][$psc_key],
                                    'vav_addr_ref'=>$_POST['vav_addr_ref'][$psc_key],
                                    'vav_nonimal_value'=>$_POST['vav_nonimal_value'][$psc_key],
                                    'max_flow_m3_s'=>$_POST['max_flow_m3_s'][$psc_key],
                                    'min_flow_m3_s'=>$_POST['min_flow_m3_s'][$psc_key],
                                    'min_p_pa'=>$_POST['min_p_pa'][$psc_key],
                                    'min_volts'=>$_POST['min_volts'][$psc_key],
                                    'min_vol_m3s'=>$_POST['min_vol_m3s'][$psc_key],
                                    'min_percentage'=>$_POST['min_percentage'][$psc_key],
                                    'max_p_pa'=>$_POST['max_p_pa'][$psc_key],
                                    'max_volts'=>$_POST['max_volts'][$psc_key],
                                    'max_vol_m3s'=>$_POST['max_vol_m3s'][$psc_key],
                                    'max_percentage'=>$_POST['max_percentage'][$psc_key],
                                    'modifiedon' => $created_date,
                                    'modifiedby' => $this->session->userdata('userid')
                                );
                            }

                        }
                    }

                    /* =========== Delete Grille === */

                    $grilledel_pdata=$this->input->post('vlmctrldel');

                    if(!empty($grilledel_pdata))
                    {
                        foreach ($grilledel_pdata as $grd_key => $grd_value) 
                        {
                            if(intval($grd_value)!=0)
                            {
                                $this->db->where('id', $grd_value);
                                $this->db->delete(CAAIRCTRL);
                            }
                        }
                    }


                    if(!empty($upsarray_batch))
                    {
                        $this->db->update_batch(CAAIRCTRL, $upsarray_batch,'id');
                    }
                    if(!empty($insarray_batch))
                    {
                        $this->db->insert_batch(CAAIRCTRL, $insarray_batch);
                    }

                    $this->session->set_flashdata('project_message', $data['title'].' has been updated successfully...');

                }

                $sheetstatus=$this->input->post('shtenadis');
                $this->MProject->insertPrjSheetStatus($proid,$masterprcid,$sheetstatus,false);

                $path = base_url('projects/commAirVlmControl/'.$proidnew.'/'.$prcessidnew);
                redirect($path);
            }
        }

        //$data['sidemenu'] = 'hide';
        $data['engdata']=$this->MProject->getEngByPrjID($proid);
        $grillegriddata=$this->MProject->getVlmCtrldata($prcessid);

        if($prcessid!=0)        
        {
            $prcdatas=$this->MProject->getPrjPrcLst($prcessid);
            $data['prcdata']=$prcdatas[0];            
        }

        if($grillegriddata->num_rows()>0)
        {
            $data['vlmctrlgrid']=$grillegriddata->result_array();
        }
        else
        {
            $data['vlmctrlgrid']=array(
                array(
                    'id'=>0,
                    'projectprocesslistmasterid' => $prcessid ,
                    'ref_no' => '',
                    'vav_refno' => '',
                    'vav_addr_ref'=>'',
                    'vav_nonimal_value'=>'',
                    'max_flow_m3_s'=>'',
                    'min_flow_m3_s'=>'',
                    'min_p_pa'=>'',
                    'min_volts'=>'',
                    'min_vol_m3s'=>'',
                    'min_percentage'=>'',
                    'max_p_pa'=>'',
                    'max_volts'=>'',
                    'max_vol_m3s'=>'',
                    'max_percentage'=>''
                )
            );
        }


        if($this->input->post('vav_refno'))
        {
            $data['vlmctrlgrid']=array();
            $value1=$this->input->post('vav_refno');            
            foreach ($value1 as $key => $value) {
                $data['vlmctrlgrid'][]=array(
                    'id'=>$_POST['vlmctrlid'][$key],
                    'projectprocesslistmasterid' => $prcessid,                    
                    'vav_refno' => $_POST['vav_refno'][$key],
                    'vav_addr_ref'=>$_POST['vav_addr_ref'][$key],
                    'vav_nonimal_value'=>$_POST['vav_nonimal_value'][$key],
                    'max_flow_m3_s'=>$_POST['max_flow_m3_s'][$key],
                    'min_flow_m3_s'=>$_POST['min_flow_m3_s'][$key],
                    'min_p_pa'=>$_POST['min_p_pa'][$key],
                    'min_volts'=>$_POST['min_volts'][$key],
                    'min_vol_m3s'=>$_POST['min_vol_m3s'][$key],
                    'min_percentage'=>$_POST['min_percentage'][$key],
                    'max_p_pa'=>$_POST['max_p_pa'][$key],
                    'max_volts'=>$_POST['max_volts'][$key],
                    'max_vol_m3s'=>$_POST['max_vol_m3s'][$key],
                    'max_percentage'=>$_POST['max_percentage'][$key]
                );
            }

        }

        $data['prcessid']=$prcessid;
        $data['sheetstatus']=$this->MProject->getPrjSheetStatus($proid,$masterprcid);
        $data['custom_side_menu'] = 'projprsmenu';
        $data['prodata']=$this->Common_model->getProductById($proid); 
        $data['sidemenu_sub_active'] = 'commAir';
        $data['sidemenu_sub_active1'] = $this->uri->segment(2);
        
        $this->load->view('common/header',$data);
        $this->load->view('projects/commAir/commAirVlmControl',$data);        
        $this->load->view('common/footer');
    }
    public function commAirConstAirRcd()
    {
        $this->exitpage('projects/projview');

        $proidnew = $this->uri->segment(3);
        $proid = intval($this->Common_model->decodeid($proidnew));        
        $data['proid'] = $proid;
        $prcessidnew = $this->uri->segment(4);
        $prcessid = intval($this->Common_model->decodeid($prcessidnew)); 
        
        if ($this->input->post('cancel'))
        {
            $path = base_url('projects/'.$this->uri->segment(2).'/'.$proidnew);
            redirect($path);
        }
        
        $masterprcid=10;        
        $data['title'] = 'Constant Air Volume Control Box Test Record';
        $data['masterprcid'] = $masterprcid;
        //$data['sidemenu'] = 'hide';


        if ($this->input->post('submit'))
        {

            $this->form_validation->set_rules('reportref', 'Ref', 'trim|required');
            $this->form_validation->set_rules('projsystem', 'System', 'trim|required');            
            $this->form_validation->set_rules('commairreptenggsign', 'Engineer', 'trim|required');
            
            if ($this->form_validation->run() == TRUE)
            {
                $created_date = date('Y-m-d H:i:s');

                if($prcessid==0)
                {

                    $ins_array1 = array(
                        'projectid' =>  $proid,
                        'processid' =>  $masterprcid,
                        'sheetnumber' => 0,                        
                        'system' => $this->input->post('projsystem'),                    
                        'referenceno' => $this->input->post('reportref'),
                        'comments'  =>  $this->input->post('commaircomments'),                        
                        'engineerid' => $this->input->post('commairreptenggsign'),
                        'reportdate' => date('Y-m-d H:i:s',strtotime($this->input->post('commairreptenggdate'))),
                        'createdon' => $created_date,
                        'createdby' => $this->session->userdata('userid')
                    );

                    $prcessid=$this->Common_model->insertPrjPrcMaster($ins_array1);
                    $prcessidnew = ($this->Common_model->encodeid($prcessid));
                    $insarray_batch=array();

                    //$procesSection_pdata=$this->input->post('procesSection');
                    $procesSectionCat_pdata=$this->input->post('vlmctrlboxid');

                    if(!empty($procesSectionCat_pdata))
                    {
                        foreach ($procesSectionCat_pdata as $psc_key => $psc_value) 
                        {                            
                            $insarray_batch[] = array(
                                'projectprocesslistmasterid' => $prcessid ,
                                'ref_no' => $this->input->post('reportref'),
                                'cav_refno' =>$_POST['cav_refno'][$psc_key],
                                'cav_addr_ref'=>$_POST['cav_addr_ref'][$psc_key],
                                'cav_design_volume'=>$_POST['cav_design_volume'][$psc_key],
                                'max_flow_m3_s'=>$_POST['max_flow_m3_s'][$psc_key],
                                'max_p_pa_designed'=>$_POST['max_p_pa_designed'][$psc_key],
                                'max_p_pa_measured'=>$_POST['max_p_pa_measured'][$psc_key],
                                'max_volts'=>$_POST['max_volts'][$psc_key],
                                'max_vol_m3s'=>$_POST['max_vol_m3s'][$psc_key],
                                'max_percentage'=>$_POST['max_percentage'][$psc_key],
                                'createdon' => $created_date,
                                'createdby' => $this->session->userdata('userid')
                            );
                        }
                    }

                    if(!empty($insarray_batch))
                    {
                        $this->db->insert_batch(CACONSCTRL, $insarray_batch);
                    }

                    //$this->Common_model->updateSequenceval(CAPRECK,'sheetnumber','projectid='.$proid,'id','ASC');
                    $this->Common_model->updateSequenceval(PRJPRCLST,'sheetnumber','projectid='.$proid.' and processid='.$masterprcid,'id','ASC');

                    $this->session->set_flashdata('project_message', 'New '.$data['title'].' has been created successfully...');
                }
                else
                {
                   
                    $update_array1 = array(
                        'system' => $this->input->post('projsystem'),                    
                        'referenceno' => $this->input->post('reportref'),
                        'comments' => $this->input->post('commaircomments'),
                        'engineerid' => $this->input->post('commairreptenggsign'),
                        'reportdate' => date('Y-m-d H:i:s',strtotime($this->input->post('commairreptenggdate'))),
                        'modifiedon' => $created_date,
                        'modifiedby' => $this->session->userdata('userid')
                    );

                    $this->Common_model->updatePrjPrcMaster($update_array1,$prcessid);
                    
                    $upsarray_batch=array();

                    $procesSectionCat_pdata=$this->input->post('vlmctrlboxid');

                    if(!empty($procesSectionCat_pdata))
                    {
                        foreach ($procesSectionCat_pdata as $psc_key => $psc_value) 
                        {
                            if($psc_value==0)
                            {
                                $insarray_batch[] = array(
                                  'projectprocesslistmasterid' => $prcessid ,
                                  'ref_no' => $this->input->post('reportref'),
                                  'cav_refno' =>$_POST['cav_refno'][$psc_key],
                                  'cav_addr_ref'=>$_POST['cav_addr_ref'][$psc_key],
                                  'cav_design_volume'=>$_POST['cav_design_volume'][$psc_key],
                                  'max_flow_m3_s'=>$_POST['max_flow_m3_s'][$psc_key],
                                  'max_p_pa_designed'=>$_POST['max_p_pa_designed'][$psc_key],
                                  'max_p_pa_measured'=>$_POST['max_p_pa_measured'][$psc_key],
                                  'max_volts'=>$_POST['max_volts'][$psc_key],
                                  'max_vol_m3s'=>$_POST['max_vol_m3s'][$psc_key],
                                  'max_percentage'=>$_POST['max_percentage'][$psc_key],
                                  'createdon' => $created_date,
                                  'createdby' => $this->session->userdata('userid')
                                );
                            }
                            else
                            {
                                $upsarray_batch[] = array(
                                    'id'=>$psc_value,
                                    'projectprocesslistmasterid' => $prcessid ,
                                    'ref_no' => $this->input->post('reportref'),                                    
                                    'cav_refno' =>$_POST['cav_refno'][$psc_key],
                                    'cav_addr_ref'=>$_POST['cav_addr_ref'][$psc_key],
                                    'cav_design_volume'=>$_POST['cav_design_volume'][$psc_key],
                                    'max_flow_m3_s'=>$_POST['max_flow_m3_s'][$psc_key],
                                    'max_p_pa_designed'=>$_POST['max_p_pa_designed'][$psc_key],
                                    'max_p_pa_measured'=>$_POST['max_p_pa_measured'][$psc_key],
                                    'max_volts'=>$_POST['max_volts'][$psc_key],
                                    'max_vol_m3s'=>$_POST['max_vol_m3s'][$psc_key],
                                    'max_percentage'=>$_POST['max_percentage'][$psc_key],
                                    'modifiedon' => $created_date,
                                    'modifiedby' => $this->session->userdata('userid')
                                );
                            }

                        }
                    }

                    /* =========== Delete Grille === */

                    $grilledel_pdata=$this->input->post('vlmctrlboxdel');

                    if(!empty($grilledel_pdata))
                    {
                        foreach ($grilledel_pdata as $grd_key => $grd_value) 
                        {
                            if(intval($grd_value)!=0)
                            {
                                $this->db->where('id', $grd_value);
                                $this->db->delete(CACONSCTRL);
                            }
                        }
                    }


                    if(!empty($upsarray_batch))
                    {
                        $this->db->update_batch(CACONSCTRL, $upsarray_batch,'id');
                    }
                    if(!empty($insarray_batch))
                    {
                        $this->db->insert_batch(CACONSCTRL, $insarray_batch);
                    }

                    $this->session->set_flashdata('project_message', $data['title'].' has been updated successfully...');

                }

                $sheetstatus=$this->input->post('shtenadis');
                $this->MProject->insertPrjSheetStatus($proid,$masterprcid,$sheetstatus,false);

                $path = base_url('projects/commAirConstAirRcd/'.$proidnew.'/'.$prcessidnew);
                redirect($path);
            }
        }

        //$data['sidemenu'] = 'hide';
        $data['engdata']=$this->MProject->getEngByPrjID($proid);
        $grillegriddata=$this->MProject->getVlmCtrlBoxdata($prcessid);

        if($prcessid!=0)        
        {
            $prcdatas=$this->MProject->getPrjPrcLst($prcessid);
            $data['prcdata']=$prcdatas[0];            
        }

        if($grillegriddata->num_rows()>0)
        {
            $data['vlmctrlboxgrid']=$grillegriddata->result_array();
        }
        else
        {
            $data['vlmctrlboxgrid']=array(
                array(
                    'id'=>0,
                    'projectprocesslistmasterid' => $prcessid ,
                    'ref_no' => '',
                    'cav_refno' => '',
                    'cav_addr_ref'=>'',
                    'cav_design_volume'=>'',
                    'max_flow_m3_s'=>'',
                    'max_p_pa_designed'=>'',
                    'max_p_pa_measured'=>'',
                    'max_volts'=>'',
                    'max_vol_m3s'=>'',
                    'max_percentage'=>''
                )
            );
        }

        if($this->input->post('cav_refno'))
        {

            $data['vlmctrlboxgrid']=array();
            $value1=$this->input->post('cav_refno');            
            foreach ($value1 as $key => $value) {
                $data['vlmctrlboxgrid'][]=array(
                    'id'=>$POST['vlmctrlboxid'][$key],
                    'projectprocesslistmasterid' => $prcessid,                    
                    'cav_refno' =>$_POST['cav_refno'][$key],
                    'cav_addr_ref'=>$_POST['cav_addr_ref'][$key],
                    'cav_design_volume'=>$_POST['cav_design_volume'][$key],
                    'max_flow_m3_s'=>$_POST['max_flow_m3_s'][$key],
                    'max_p_pa_designed'=>$_POST['max_p_pa_designed'][$key],
                    'max_p_pa_measured'=>$_POST['max_p_pa_measured'][$key],
                    'max_volts'=>$_POST['max_volts'][$key],
                    'max_vol_m3s'=>$_POST['max_vol_m3s'][$key],
                    'max_percentage'=>$_POST['max_percentage'][$key],
                );
            }

        }

        $data['prcessid']=$prcessid;
        $data['sheetstatus']=$this->MProject->getPrjSheetStatus($proid,$masterprcid);        
        $data['custom_side_menu'] = 'projprsmenu';
        $data['prodata']=$this->Common_model->getProductById($proid); 
        $data['sidemenu_sub_active'] = 'commAir';
        $data['sidemenu_sub_active1'] = $this->uri->segment(2);
        
        $this->load->view('common/header',$data);
        $this->load->view('projects/commAir/commAirConstAirRcd',$data);        
        $this->load->view('common/footer');
    }
    public function commAirFcuCklst()
    {
        $this->exitpage('projects/projview');
        
        $proidnew = $this->uri->segment(3);
        $proid = intval($this->Common_model->decodeid($proidnew));        
        $data['proid'] = $proid;
        $prcessidnew = $this->uri->segment(4);
        $prcessid = intval($this->Common_model->decodeid($prcessidnew));

        if ($this->input->post('cancel'))
        {
            $path = base_url('projects/'.$this->uri->segment(2).'/'.$proidnew);
            redirect($path);
        }
        
        $masterprcid=11;        
        $data['title'] = 'FCU Validation Check List';
        $data['masterprcid'] = $masterprcid;
        //$data['sidemenu'] = 'hide';

        if ($this->input->post('submit'))
        {

            $this->form_validation->set_rules('reportref', 'Ref', 'trim|required');
            $this->form_validation->set_rules('projsystem', 'System', 'trim|required');            
            $this->form_validation->set_rules('commairreptenggsign', 'Engineer', 'trim|required');
            
            if ($this->form_validation->run() == TRUE)
            {
                $created_date = date('Y-m-d H:i:s');

                if($prcessid==0)
                {

                    $ins_array1 = array(
                        'projectid' =>  $proid,
                        'processid' =>  $masterprcid,
                        'sheetnumber' => 0,                        
                        'system' => $this->input->post('projsystem'),                    
                        'referenceno' => $this->input->post('reportref'),
                        'comments'  =>  $this->input->post('commaircomments'),                        
                        'engineerid' => $this->input->post('commairreptenggsign'),
                        'reportdate' => date('Y-m-d H:i:s',strtotime($this->input->post('commairreptenggdate'))),
                        'createdon' => $created_date,
                        'createdby' => $this->session->userdata('userid')
                    );

                    $prcessid=$this->Common_model->insertPrjPrcMaster($ins_array1);
                    $prcessidnew = ($this->Common_model->encodeid($prcessid));

                    $insarray_batch=array();

                    $procesSection_pdata=$this->input->post('procesSection');

                    if(!empty($procesSection_pdata))
                    {
                        foreach ($procesSection_pdata as $ps_key => $ps_value) 
                        {
                            $insarray_batch[] = array(
                              'projectprocesslistmasterid' => $prcessid ,
                              'ref_no' => $this->input->post('reportref'),
                              'processsectioncategoryid' => $masterprcid,
                              'processsectionid' => $ps_value,
                              'fcu_description'=>$this->input->post('sectionname_'.$ps_value),
                              'createdon' => $created_date,
                              'createdby' => $this->session->userdata('userid')
                            );
                        }
                    }

                    if(!empty($insarray_batch))
                    {
                        $this->db->insert_batch(CAFCUCKLST, $insarray_batch);
                    }

                    //$this->Common_model->updateSequenceval(CAPRECK,'sheetnumber','projectid='.$proid,'id','ASC');
                    $this->Common_model->updateSequenceval(PRJPRCLST,'sheetnumber','projectid='.$proid.' and processid='.$masterprcid,'id','ASC');

                    $this->session->set_flashdata('project_message', 'New '.$data['title'].' has been created successfully...');
                }
                else
                {
                    $update_array1 = array(
                        'system' => $this->input->post('projsystem'),                    
                        'referenceno' => $this->input->post('reportref'),
                        'comments' => $this->input->post('commaircomments'),
                        'engineerid' => $this->input->post('commairreptenggsign'),
                        'reportdate' => date('Y-m-d H:i:s',strtotime($this->input->post('commairreptenggdate'))),
                        'modifiedon' => $created_date,
                        'modifiedby' => $this->session->userdata('userid')
                    );

                    $this->Common_model->updatePrjPrcMaster($update_array1,$prcessid);
                    
                    $upsarray_batch=array();

                    $procesSection_pdata=$this->input->post('procesSection');

                    if(!empty($procesSection_pdata))
                    {
                        foreach ($procesSection_pdata as $ps_key => $ps_value) 
                        {
                            $upsarray_batch[] = array(
                                'id'=>intval($this->input->post('procesSectionId'.$ps_value)),
                                'projectprocesslistmasterid' => $prcessid ,
                                'ref_no' => $this->input->post('reportref'),
                                'processsectioncategoryid' => $masterprcid,
                                'processsectionid' => $ps_value,
                                'fcu_description'=>$this->input->post('sectionname_'.$ps_value),
                                'modifiedon' => $created_date,
                                'modifiedby' => $this->session->userdata('userid')
                            );
                        }
                    }

                    if(!empty($upsarray_batch))
                    {
                        $this->db->update_batch(CAFCUCKLST, $upsarray_batch,'id');
                    }

                    $this->session->set_flashdata('project_message', $data['title'].' has been updated successfully...');

                }

                $sheetstatus=$this->input->post('shtenadis');
                $this->MProject->insertPrjSheetStatus($proid,$masterprcid,$sheetstatus,false);

                $path = base_url('projects/commAirFcuCklst/'.$proidnew.'/'.$prcessidnew);
                redirect($path);
            }
        }
        //$data['sidemenu'] = 'hide';
        $data['engdata']=$this->MProject->getEngByPrjID($proid);
        if($prcessid!=0)        
        {
            $prcdatas=$this->MProject->getCASyspreck($prcessid);
            $data['prcdata']=$prcdatas[0];
        }
        
        $data['prcessid']=$prcessid;
        $data['sheetstatus']=$this->MProject->getPrjSheetStatus($proid,$masterprcid);        
        $data['custom_side_menu'] = 'projprsmenu';
        $data['prodata']=$this->Common_model->getProductById($proid); 
        $data['sidemenu_sub_active'] = 'commAir';
        $data['sidemenu_sub_active1'] = $this->uri->segment(2);

        $this->load->view('common/header',$data);
        $this->load->view('projects/commAir/commAirFcuCklst',$data);
        $this->load->view('common/footer');
    }
    public function updateProcessLstSrt()
    {
        /*echo '<pre>';print_r($_POST); echo '</pre>';
        exit;*/
        
        $ckemtyval=$_POST['item'];
        if(!empty($ckemtyval))
        {
            foreach ($ckemtyval as $key => $value) {
                //foreach ($value as $key1 => $value1) 
                {
                    //echo $key.'='.$value.'<br>';

                    $upd_array = array(
                        'orderofdisplay' => $key
                    );
                    $this->db->where('id', $value);
                    $this->db->update(PROCESSLST, $upd_array);

                }
            }
        }
    }

    public function casyschefilecheck($str){

        $allowed_mime_type_arr = array('image/gif','image/jpeg','image/pjpeg','image/png','image/x-png','application/pdf');
        $mime = get_mime_by_extension($_FILES['uploadfile']['name']);
        if(isset($_FILES['uploadfile']['name']) && $_FILES['uploadfile']['name']!=""){            
            
            if(in_array($mime, $allowed_mime_type_arr)){
                return true;
            }else{
                $this->form_validation->set_message('casyschefilecheck', 'Please select only gif/jpg/png/pdf/zip file.');
                return false;
            }

        }else{
            $this->form_validation->set_message('casyschefilecheck', 'Please choose a file to upload.');
            return FALSE;
        }
    }
    public function checksyschefile($str)
    {
        #echo '<pre>';print_r($_FILES['uploadfile']);echo '</pre>';
         if(!isset($_FILES['uploadfile']['name'][0]))
         {
            $this->form_validation->set_message('checksyschefile', 'Please choose a file to upload.');            
            return FALSE;
         }
         elseif(empty($_FILES['uploadfile']['name'][0]))
         {
            $this->form_validation->set_message('checksyschefile', 'Please choose a file to upload.');
            return FALSE;
         }
         else
         {
            return TRUE;
         }
    }
    function updatePrjSheetStatus()
    {
        $proid=$this->input->post('proid');
        $sheetid=$this->input->post('sheetid');
        $status=$this->input->post('status');
        $report=$this->MProject->updatePrjSheetStatus($proid,$sheetid,$this->input->post('status'),true);
        echo $report;
    }

    public function getSysDrpOpt()
    {
        
        $this->db->select('ss.*,u1.firstname as u1fname,u1.lastname as u1lname,u2.firstname as u2fname,u2.lastname as u2lname');
        $this->db->join(USER.' u1','ss.witnessedby=u1.userid','left');
        $this->db->join(USER.' u2','ss.testedby=u2.userid','left');
        $this->db->where('ss.id',intval($this->input->post('sysid')));
        $data=$this->db->get(PRJSYS.' ss');

        $datas=$data->result_array();

        if($data->num_rows()!=0)
        {
            $result=array(
                "datacnt"=>$data->num_rows(),
                "datas"=>array(
                    "witnessby"     =>  $datas[0]['u1fname'].' '.$datas[0]['u1lname'],
                    "witnessid"     =>  $datas[0]['witnessedby'],
                    "witnessdate"   =>  date(DT_FORMAT,strtotime($datas[0]['witnesseddate'])),
                    "company"       =>  $datas[0]['companyname'],
                    "testedby"      =>  $datas[0]['u2fname'].' '.$datas[0]['u2lname'],
                    "testedid"      =>  $datas[0]['testedby'],
                    "testedate"     =>  date(DT_FORMAT,strtotime($datas[0]['testedDate'])),
                    "contractor"    =>  $datas[0]['servicecontractorname']
                )
            );
        }
        else
        {
            $result=array(
                "datacnt"=>$data->num_rows(),
                "datas"=>array(
                    "witnessby"     =>  '',
                    "witnessid"     =>  0,
                    "witnessdate"   =>  date(DT_FORMAT),
                    "company"       =>  '',
                    "testedby"      =>  '',
                    "testedid"      =>  0,
                    "testedate"     =>  date(DT_FORMAT),
                    "contractor"    =>  ''
                )
            );            
        }

        echo json_encode($result);
    }
    public function checkSysAssign()
    {
        $sysid=intval($this->uri->segment(3));
        if($sysid!=0)
        {
            $sysidres=$this->MProject->getSystemPrjck($sysid);
            echo $sysidres->num_rows();
        }
        else
        {
            echo 0;
        }
    }

    public function getStaffSign()
    {
        $userid=intval($this->uri->segment(3));
        $testersigndata=$this->Common_model->getUserById($userid);
        $testersign=$testersigndata['signature'];
        echo $testersign;
    }
    public function removeFilebyUser($value='')
    {
        $data=array();
        echo json_encode($data);
    }

    public function getSites()
    {
        $custid=intval($this->input->post('custid'));
        $getSites=$this->MProject->getSites($siteid,$custid);
        $data=array();
        if($getSites->num_rows()>0)
        {
            $data=$getSites->result_array();
        }
        echo json_encode($data);

    }
    public function getContactSites()
    {
        $custid=intval($this->input->post('custid'));
        $siteid=intval($this->input->post('siteid'));
        $getContactSites=$this->MProject->getContactSites($siteid,$custid);
        $data=array();
        if($getContactSites->num_rows()>0)
        {
            $data=$getContactSites->result_array();
        }
        echo json_encode($data);
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */