<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Roles extends CI_Controller {

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     * 	- or -  
     * 		http://example.com/index.php/welcome/index
     * 	- or -
     * Since this controller is set as the default controller in 
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see http://codeigniter.com/user_guide/general/urls.html
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('roles/UserRoles_model','Mroles');

        if (!$this->Common_model->isLoggedIn())
            redirect(base_url('')); // login checking

    }
    public function exitpage()
    {
        $roleid=$this->session->userdata('userroleid');
        $segarr=array($this->uri->segment(1),$this->uri->segment(2));
        $segarrval=implode('/', $segarr);

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
    //Load Home page
    public function index()
    {
        
        $this->exitpage();
        //check_user_permission(array(1)); // check user permission
        $data = array();
        //$data['template'] = 'roles/list';
        $data['title'] = 'Roles List';
        $this->session->set_userdata('left_submenu', 'roles');
        $data['rolesdata'] = $this->Mroles->getrolesdata();
        
        
		$this->load->view('common/header');
        $this->load->view('roles/list',$data);
		$this->load->view('common/footer');
    }

    //Add New user
    public function addroles()
    {
        //check_user_permission(array(1)); // check user permission
        $this->exitpage();
        $data = array();
       // $data['template'] = 'roles/add';

        if ($this->input->post('cancel'))
        {
            $path = base_url('roles');
            redirect($path);
        }
        $this->session->set_userdata('left_submenu', 'roles');
       
        if ($this->input->post('submit'))
        {
            $this->form_validation->set_rules('role', 'role', 'trim|required|callback_checkAddrolesnameexist');
            $this->form_validation->set_rules('description', 'Description', 'trim|required');
            $this->form_validation->set_rules('status', 'Is acive', 'trim|required');
            
            if ($this->form_validation->run() == TRUE)
            {
                $created_date = date('Y-m-d H:i:s');

                $ins_array = array(
                    'rolesname' => $this->input->post('role'),
                    'rolesdescription' => $this->input->post('description'),
                    'isactive' => $this->input->post('status'),
                    'createdby' => $this->session->userdata('userid'),
                    'createdon' => $created_date,
                    'lastmodifiedby' => $this->session->userdata('userid'),
                    'lastmodifiedon' => $created_date,
                );
                $this->db->insert(USERROLE, $ins_array);
                $insert_id=$this->db->insert_id();

                $roleid=$this->session->userdata('userroleid');
                if($roleid==1)
                {
                    $prvPageid=$this->input->post('prvPageid');
                    foreach ($prvPageid as $key => $value) {
                        $optstatus=$this->input->post('prvOptPageid_'.$value);
                        $ins_array1 = array(
                            'optpageid' => $value,
                            'roleid'    => $insert_id,
                            'optstatus' => $optstatus,
                            'createdby' => $this->session->userdata('userid'),
                            'createdon' => $created_date
                        );
                        $this->db->insert(PRVPERMION, $ins_array1);
                    }
                }
                
                
                //$this->session->set_flashdata('success_message_new', 'New role has been created successfully...');
                //$path = base_url('roles/editroles/'.$insert_id);

                $this->session->set_flashdata('success_message', 'New role has been created successfully...');
                $path = base_url('roles');

                redirect($path);
            }
        }

        $data['title'] = 'Add New Role';

        //$this->load->vars($data);
		$this->load->view('common/header');
        $this->load->view('roles/add',$data);
		$this->load->view('common/footer');
    }
    //Add New user
    public function editroles()
    {
        $this->exitpage();
        $data = array();
       // $data['template'] = 'roles/add';
        $this->session->set_userdata('left_submenu', 'roles');
        
        if ($this->input->post('cancel'))
        {
            $path = base_url('roles') ;
            redirect($path);
        }

        $id = $this->uri->segment('3');
        $deroleid=$this->Common_model->decodeid($id);
        
        $data['roles'] = $this->Mroles->getroles($deroleid);
        if ($this->input->post('submit'))
        {
            $this->form_validation->set_rules('role', 'role', 'trim|required|callback_checkrolenameexist');
            $this->form_validation->set_rules('description', 'Description', 'trim|required');
            $this->form_validation->set_rules('status', 'Is acive', 'trim|required|callback_checkstatusexist');
            
            if ($this->form_validation->run() == TRUE)
            {
                if($this->input->post('role') != 'Super Admin'){
                    $existid = $this->Common_model->decodeid($this->input->post('existid')); 
                    $created_date = date('Y-m-d H:i:s');

                    $upd_array = array(
                        'rolesname' => $this->input->post('role'),
                        'rolesdescription' => $this->input->post('description'),
                        'isactive' => $this->input->post('status'),
                        'createdby' => $this->session->userdata('userid'),
                        'createdon' => $created_date,
                        'lastmodifiedby' => $this->session->userdata('userid'),
                        'lastmodifiedon' => $created_date,
                    );
                    
                    $this->db->where('roleid',$existid);
                    $this->db->update(USERROLE, $upd_array);


                    $roleid=$this->session->userdata('userroleid');
                    if($roleid==1)
                    {
                        $prvPageid=$this->input->post('prvPageid');
                        foreach ($prvPageid as $key => $value) {
                            $optstatus=$this->input->post('prvOptPageid_'.$value);
                            #echo '<pre>';print_r($optstatus); echo '</pre>';
                            $upd_array1 = array(
                                'optpageid' => $value,
                                'roleid'    => $existid,
                                'optstatus' => $optstatus,
                                'modifiedby' => $this->session->userdata('userid'),
                                'modifiedon' => $created_date
                            );
                            
                            $rolePermission=$this->Mroles->getRolePermission($existid,$value);
    						 
                            if($rolePermission->num_rows()>0)
                            {
                                $this->db->where('roleid',$existid);
                                $this->db->where('optpageid',$value);
                                $this->db->update(PRVPERMION, $upd_array1);
                            }
                            else
                            {
                                $upd_array1['createdby'] = $this->session->userdata('userid');
                                $upd_array1['createdon'] = $created_date;                        
                                $this->db->insert(PRVPERMION, $upd_array1);                        
                            }
                        }
                    }
                    
                    //$this->session->set_flashdata('success_message_new', 'The role has been updated successfully...');
                    //$path = base_url('roles/editroles/'.$existid);

                    $this->session->set_flashdata('success_message', 'The role has been updated successfully...');
                    $path = base_url('roles');


                    redirect($path);
            }
            else
            {
                $this->session->set_flashdata('success_message', 'The roles of super admin can not be changed');
                $path = base_url('roles');
                redirect($path);
            }
            }
        }

        $data['title'] = 'Edit Role';

        $this->load->vars($data);
		$this->load->view('common/header');
        $this->load->view('roles/add',$data);
		$this->load->view('common/footer');
    }
    
    
    //Check email Exist
    public function checkemailexist()
    {
        $existid = $this->Common_model->decodeid($this->input->post('existid'));
        $email = $this->input->post('email');
        $cnt = $this->Mroles->checkemailexist($email,$existid);
        if ($cnt == 1)
        {
            $this->form_validation->set_message('checkemailexist', 'This email id already exist');
            return FALSE;
        }
        else
        {
            return TRUE;
        }
    }
    
     //Check email Exist
    public function checkrolenameexist()
    {
        $existid = $this->Common_model->decodeid($this->input->post('existid'));
        $role = $this->input->post('role');
        $cnt = $this->Mroles->checkrolesnameexist($existid,$role);
        if ($cnt == 1)
        {
            $this->form_validation->set_message('checkrolenameexist', 'This Role Name already exist');
            return FALSE;
        }
        else
        {
            return TRUE;
        }
    }

    public function checkAddrolesnameexist()
    {
        $existid = $this->Common_model->decodeid($this->input->post('existid'));
        $role = $this->input->post('role');
        $cnt = $this->Mroles->checkAddrolesnameexist($existid,$role);
        if ($cnt == 1)
        {
            $this->form_validation->set_message('checkAddrolesnameexist', 'This Role Name already exist');
            return FALSE;
        }
        else
        {
            return TRUE;
        }
    }

    
     //Check email Exist
    public function checkstatusexist()
    {
        $existid = $this->Common_model->decodeid($this->input->post('existid'));
        $status = $this->input->post('status');
        $cnt = $this->Mroles->checkstatusexist($existid);
        if ($cnt == 1 && $status == 0)
        {
            $this->form_validation->set_message('checkstatusexist', 'This Roles has been refered to users');
            return FALSE;
        }
        else
        {
            return TRUE;
        }
    }

    //Delete User
    public function delete_role()
    {
        //check_user_permission(array(1)); // check user permission
        $this->exitpage();
        $roleid = $this->uri->segment(3);
        $created_date = date('Y-m-d H:i:s');

        // delete from users
        /*$this->db->where('roleid', $roleid);
        $this->db->delete(USERROLE);*/

        $upd_array = array(
            'isdeleted' => 'A',
            'lastmodifiedby' => $this->session->userdata('userid'),
            'lastmodifiedon' => $created_date
        );
        
        $this->db->where('roleid',$roleid);
        $this->db->update(USERROLE, $upd_array);

        $this->session->set_flashdata('success_message', 'The role has been deleted successfully...');
        $path = base_url('roles');
        redirect($path);
    }  
    public function deleterolecheck($return=false)
    {
        //check_user_permission(array(1)); // check user permission
        $roleid = $this->uri->segment(3);
        
        $data='';
        $return=0;
        $this->db->select('*');
        $this->db->where('roleid',$roleid);
        //$this->db->where('isactive',1);
        $this->db->where('isdeleted','I');
        $data=$this->db->get(USER);  
        if($return==false)      
        {
            echo $data->num_rows();
        }
        else
        {
            return $data;
        }
    }        
    
    //Check exist role id
    public function checkexistroleid()
    {
        $id = $_POST['id'];
        echo $cnt = $this->Mroles->checkrolesid($id);
    }   

	public function getallRoles()
	{
		$table = USERROLE;
		 
		// Table's primary key
		$primaryKey = 'roleid';
		 
		// Array of database columns which should be read and sent back to DataTables.
		// The `db` parameter represents the column name in the database, while the `dt`
		// parameter represents the DataTables column identifier. In this case simple
		// indexes
        $roleid=$this->session->userdata('userroleid');
        $segarrval='roles/editroles';
        $ckpermission=$this->Common_model->ckRolePermission($roleid,$segarrval);
        define('roledit',$ckpermission);
        $segarrval='roles/delete_role';
        $ckpermission=$this->Common_model->ckRolePermission($roleid,$segarrval);
        define('roledle',$ckpermission);



		$columns = array(
			array( 'db' => 'rolesname', 'dt' => 0,'field'=>'rolesname'),
			array( 'db' => 'rolesdescription',  'dt' => 1,'field'=>'rolesdescription'),
			array( 'db' => 'isactive',   'dt' => 2,'field'=>'isactive','formatter' => function( $d, $row ) {
					return (($d==1)?'Active':'Inactive');
				}),
			array( 'db' => 'roleid',   'dt' => 3,'field'=>'roleid','formatter' => function( $d, $row ) {
					$action='<div class="icon_list">';
                    $enid=$this->Common_model->encodeid($d);
                    if(roledit==true)
                    {
                        $action.='<a href="'.site_url('roles/editroles/'.$enid).'" data-toggle="tooltip"  title="Edit Role"><i class="fa fa-pencil" aria-hidden="true"></i></a>&nbsp;';
                    }
                    if(roledle==true)
                    {
                        $action.='<a href="javascript:void(0)" data-toggle="tooltip"  title="Delete Role" data-id="'.$d.'" class="user_roles_acc"><i class="fa fa-times" aria-hidden="true"></i></a>';
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
		
		 
		/*require( DROOT.'/assets/class/ssp.class.php' );
		 
		echo json_encode(
			SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns )
		);*/

        require( DROOT.'/assets/class/ssp.customized.class.php' );
        
        $joinQuery = "";
        $extraWhere = " isdeleted='I' ";

        if($_REQUEST['rrolestatus']!='all')
        {
            $extraWhere .= " AND isactive='".intval($_REQUEST['rrolestatus'])."' ";
        }

        $extraWhere_add=' AND ';

        #echo '<pre>'; print_r($_GET); echo '</pre>';

        echo json_encode(
            SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere,'',$extraWhere_add )
        );

         
        /*echo json_encode(
            SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere )
        );*/
		
	}
    
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */