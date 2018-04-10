<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct(); 
		
		$this->load->model('users/Users_model','MUser');

		if (!$this->Common_model->isLoggedIn())
		{
			redirect(base_url()); // login checking
		}
        
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
	public function index()
	{
        $this->exitpage();		
		$this->load->view('common/header');
		$this->load->view('users/userlist');
		$this->load->view('common/footer');
	}
	public function getallUsers()
	{
		
		$table = USER;
        
		 
		// Table's primary key
		$primaryKey = 'userid';

        $roleid=$this->session->userdata('userroleid');
        $segarrval='users/edituser';
        $ckpermission=$this->Common_model->ckRolePermission($roleid,$segarrval);
        define('usredit',$ckpermission);
        $segarrval='users/delete_user';
        $ckpermission=$this->Common_model->ckRolePermission($roleid,$segarrval);
        define('usrdle',$ckpermission);


		$columns = array(
			array( 'db' => 'u.firstname', 'dt' => 0, 'field' => 'firstname' ),
			array( 'db' => 'u.lastname',  'dt' => 1, 'field' => 'lastname' ),
			array( 'db' => 'ud.rolesname',   'dt' => 2, 'field' => 'rolesname' ),
			array( 'db' => 'u.displayname',   'dt' => 3, 'field' => 'displayname' ),
			array( 'db' => 'u.designation',   'dt' => 4, 'field' => 'designation' ),
			array( 'db' => 'u.isactive',   'dt' => 5, 'field' => 'isactive','formatter' => function( $d, $row ) {
					return (($d==1)?'Active':'Inactive');
				}),
			array( 'db' => 'u.userid',   'dt' => 6, 'field' => 'userid','formatter' => function( $d, $row ) {
                    $action_row='<div class="icon_list">';
                    $enid=$this->Common_model->encodeid($d);
                    if(usredit==true)
                    $action_row.='<a href="'.site_url('users/edituser/'.$enid).'"  data-toggle="tooltip"  title="Edit User"><i class="fa fa-pencil" aria-hidden="true"></i></a>&nbsp;';
                    
                    $currentuserid=$this->session->userdata('userid');

                    if($d!=1 && $currentuserid!=$d && usrdle==true)
                    {
                        $action_row .='<a href="javascript:void(0)" data-id="'.$d.'" class="delete_user_acc" data-toggle="tooltip"  title="Delete User"><i class="fa fa-times" aria-hidden="true"></i></a>';
                    }

                    $action_row .='</div>';

                    return $action_row;
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
		
		$joinQuery = "FROM `".USER."` AS `u` JOIN `".USERROLE."` AS `ud` ON (`u`.`roleid` = `ud`.`roleid`)";
		$extraWhere = " u.isdeleted='I' ";
		 
		echo json_encode(
			SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere )
		);
	}
	
	function adduser()
	{
		$this->exitpage();
        
        $data = array();
       

        if ($this->input->post('cancel'))
        {
            $path = base_url() . 'users';
            redirect($path);
        }
        $data['selected_role'] = '';
        $data['roles_list'] = $this->MUser->getallusersroles();
        

        if ($this->input->post('submit'))
        {
            $this->form_validation->set_rules('firstname', 'first name', 'trim|required');
            $this->form_validation->set_rules('lastname', 'last name', 'trim|required');
            $this->form_validation->set_rules('username', 'user name', 'trim|required|min_length[1]|callback_checkAdduserexist');
            $this->form_validation->set_rules('designation', 'designation', 'trim');
            $this->form_validation->set_rules('userroles', 'user roles', 'trim|required');
            //$this->form_validation->set_rules('signature', 'Signature', 'trim|required');
            $this->form_validation->set_rules('email', 'email', 'trim|valid_email|callback_checkAddemailexist');
            
            //$this->form_validation->set_rules('password', 'Password must contain (Minimum 6 characters at least 1 Alphabet and 1 Number:)', 'required|regex_match["^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{6,}$"]');

            $this->form_validation->set_rules('password', 'Password must contain (Minimum 6 characters at least one Uppercase, one Special Character and one Digit:)', 'required|regex_match["^(?=.*\d)(?=.*[@#\-_$%^&+=§!\?])(?=.*[A-Z])[0-9A-Za-z@#\-_$%^&+=§!\?]{6,}$"]');

            $this->form_validation->set_rules('cpassword', 'confirm password', 'required|matches[password]',array('matches' => 'The confirm password field does not match the Password'));
            $this->form_validation->set_rules('status', 'Is acive', 'trim|required');
      
            $data['selected_role'] = $this->input->post('userroles');

            if ($this->form_validation->run() == TRUE)
            {
                $created_date = date('Y-m-d H:i:s');

                $ins_array = array(
                    'roleid' => $this->input->post('userroles'),
                    'firstname' => $this->input->post('firstname'),
                    'lastname' => $this->input->post('lastname'),
                    'displayname' => $this->input->post('username'),
                    'designation' => $this->input->post('designation'),
                    'lastname' => $this->input->post('lastname'),
                    'emailid' => $this->input->post('email'),
                    'password' => md5($this->input->post('password')),
                    //'signature' => ($this->input->post('signature')),
                    'isactive' => $this->input->post('status'),
                    'createdon' => $created_date,
                    'lastmodifiedby' => $this->session->userdata('userid'),
                    'lastmodifiedon' => $created_date,
                );
                
                $this->db->insert(USER, $ins_array);
                $this->session->set_flashdata('success_message', 'New user has been created successfully...');
                $path = base_url() . 'users';
                redirect($path);
            }
        }

        $data['title'] = 'Add New User';  
		$this->load->view('common/header');		
        $this->load->view('users/adduser',$data);
		$this->load->view('common/footer');
		
	}
	
	//Edit user
    public function edituser($userid)
    {
        $deuserid=$this->Common_model->decodeid($userid);
        $this->exitpage();
        
        $data = array();
       // $data['template'] = 'users/add';


        if ($this->input->post('cancel'))
        {
            $path = base_url() . 'users';
            redirect($path);
        }



        $data['userdata'] = $this->MUser->getusersdata($deuserid);
        $this->session->set_userdata('left_submenu', 'users');
        $data['selected_role'] = $data['userdata']['roleid'];
        $data['roles_list'] = $this->MUser->getallusersroles();

        if ($this->input->post('submit'))
        {
            $this->form_validation->set_rules('firstname', 'first name', 'trim|required');
            $this->form_validation->set_rules('lastname', 'last name', 'trim|required');
            $this->form_validation->set_rules('username', 'user name', 'trim|required|min_length[1]|callback_checkuserexist');
            $this->form_validation->set_rules('designation', 'designation', 'trim');
            //$this->form_validation->set_rules('signature', 'Signature', 'trim|required');
            $this->form_validation->set_rules('email', 'email', 'trim|valid_email|callback_checkemailexist');
            //$this->form_validation->set_rules('email', 'email', 'trim');
            $this->form_validation->set_rules('userroles', 'user roles', 'trim|required');

            $data['selected_role'] = $this->input->post('userroles');
           
            if ($this->form_validation->run() == TRUE)
            {
                $created_date = date('Y-m-d H:i:s');
                $existid = $this->Common_model->decodeid($this->input->post('existid'));

                $upd_array = array(
                    'roleid' => $this->input->post('userroles'),
                    'firstname' => $this->input->post('firstname'),
                    'lastname' => $this->input->post('lastname'),
                    'displayname' => $this->input->post('username'),
                    'designation' => $this->input->post('designation'),
                    'lastname' => $this->input->post('lastname'),
                    'emailid' => $this->input->post('email'),
                    //'signature' => ($this->input->post('signature')),
                    'isactive' => $this->input->post('status'),
                    'lastmodifiedby' => $this->session->userdata('userid'),
                    'lastmodifiedon' => $created_date,
                );
                $this->db->where('userid', $existid);
                $this->db->update(USER, $upd_array);

                $this->session->set_flashdata('success_message', 'The user has been updated successfully...');
                $path = base_url() . 'users';
                redirect($path);
            }
        }

        $data['title'] = 'Edit User';

        //$this->load->vars($data);
        $this->load->view('common/header');		
        $this->load->view('users/adduser',$data);
		$this->load->view('common/footer');
    }
	//Check email Exist
    public function checkuserexist()
    {
        $existid = $this->Common_model->decodeid($this->input->post('existid'));
        $username = $this->input->post('username');
        $cnt = $this->MUser->checkuserexist($username, $existid);
        if ($cnt == 1)
        {
            $this->form_validation->set_message('checkuserexist', 'This username id already exist');
            return FALSE;
        }
        else
        {
            return TRUE;
        }
    }

    public function checkemailexist()
    {
        $existid = $this->Common_model->decodeid($this->input->post('existid'));
        $email = $this->input->post('email');
        $cnt = $this->MUser->checkemailexist($email, $existid);
        if ($cnt == 1)
        {
            $this->form_validation->set_message('checkemailexist', 'This Email id already exist');
            return FALSE;
        }
        else
        {
            return TRUE;
        }
    }


    public function checkAdduserexist()
    {        
        $username = $this->input->post('username');
        $cnt = $this->MUser->checkuserexist($username,'');
        if ($cnt == 1)
        {
            $this->form_validation->set_message('checkAdduserexist', 'This username id already exist');
            return FALSE;
        }
        else
        {
            return TRUE;
        }
    }

    public function checkAddemailexist()
    {
        $email = $this->input->post('email');
        $cnt = $this->MUser->checkemailexist($email,'');
        if ($cnt == 1)
        {
            $this->form_validation->set_message('checkAddemailexist', 'This Email id already exist');
            return FALSE;
        }
        else
        {
            return TRUE;
        }
    }


    
    //Delete User
    public function delete_user()
    {
        $this->exitpage();
        
        $userid = $this->uri->segment(3);
        $created_date = date('Y-m-d H:i:s');

       

        if($userid==1)
        {
            $this->session->set_flashdata('success_message', "You don't have permission to delete the Super Admin.");
            $path = base_url() . 'users';
            redirect($path);
        }
        else
        {
            $upd_array = array(
                'isdeleted' => 'A',
                'lastmodifiedby' => $this->session->userdata('userid'),
                'lastmodifiedon' => $created_date
            );
            
            $this->db->where('userid',$userid);
            $this->db->update(USER, $upd_array);

            $this->session->set_flashdata('success_message', 'User has been deleted successfully...');
            $path = base_url() . 'users';
            redirect($path);
        }
    }
    public function deleteuserscheck($return=false)
    {
        //check_user_permission(array(1)); // check user permission
        //PROJURS
        //PRJSYS
        //PROJECTS
        $id = $this->uri->segment(3);
        
        $data='';
        $data1='';

        $returncnt=0;

        $this->db->select('*');
        $this->db->join(PROJECTS.' p','p.id=u.projid','inner');
        $this->db->where('u.userid',$id);        
        $this->db->where('p.isdeleted','N');
        $data=$this->db->get(PROJURS.' u');  
        $datacnt=$data->num_rows();
        $returncnt=$datacnt;

        $this->db->select('*');
        $this->db->join(PROJECTS.' p','p.id=u.projectid','inner');
        /*$this->db->where('u.userid',$id);        
        $this->db->where('p.isdeleted','N');*/
        $this->db->where("(u.testedby='".$id."' or u.witnessedby='".$id."') and p.isdeleted='N' ");
        $data1=$this->db->get(PRJSYS.' u');         
        $datacnt1=$data1->num_rows();
        $returncnt+=$datacnt1;

        echo $returncnt;
    } 
}
