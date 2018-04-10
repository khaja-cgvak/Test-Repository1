<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cusers extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct(); 
		
		$this->load->model('users/Users_model','MUser');

		if (!$this->Common_model->isLoggedIn())
		{
			redirect(base_url()); // login checking
		}
        
	}
	public function index()
	{
		
		
	}
	
	//Edit user
    public function edituser($userid)
    {
        //check_user_permission(array(1)); // check user permission
        
        $data = array();
       // $data['template'] = 'users/add';

        $userid_new=$this->Common_model->decodeid($userid);

        if ($this->input->post('cancel'))
        {
            $path = base_url();
            redirect($path);
        }
        $data['userdata'] = $this->MUser->getusersdata($userid_new);
        $this->session->set_userdata('left_submenu', 'users');
        $data['selected_role'] = $data['userdata']['roleid'];

        if ($this->input->post('submit'))
        {
            $this->form_validation->set_rules('firstname', 'first name', 'trim|required');
            $this->form_validation->set_rules('lastname', 'last name', 'trim|required');
            $this->form_validation->set_rules('designation', 'designation', 'trim');
            //$this->form_validation->set_rules('signature', 'Signature', 'trim|required');
            //$this->form_validation->set_rules('email', 'email', 'trim|valid_email|callback_checkemailexist');
            //$this->form_validation->set_rules('email', 'email', 'trim');
            $this->form_validation->set_rules('email', 'email', 'trim|valid_email|callback_checkemailexist');

            $data['selected_role'] = $this->input->post('userroles');
            if ($this->input->post('password') != '')
            {
                $this->form_validation->set_rules('password', 'Password must contain (Minimum 6 characters at least one Uppercase, one Special Character and one Digit:)', 'required|regex_match["^(?=.*\d)(?=.*[@#\-_$%^&+=§!\?])(?=.*[A-Z])[0-9A-Za-z@#\-_$%^&+=§!\?]{6,}$"]');
                
                $this->form_validation->set_rules('cpassword', 'confirm password', 'required|matches[password]',array('matches' => 'The confirm password field does not match the Password'));
            }
            if ($this->form_validation->run() == TRUE)
            {
                $created_date = date('Y-m-d H:i:s');
                $existid = $this->Common_model->decodeid($this->input->post('existid'));

                $upd_array = array(                    
                    'firstname' => $this->input->post('firstname'),
                    'lastname' => $this->input->post('lastname'),                    
                    'designation' => $this->input->post('designation'),
                    //'signature' => ($this->input->post('signature')),
                    'emailid' => $this->input->post('email'),                    
                    'lastmodifiedby' => $this->session->userdata('userid'),
                    'lastmodifiedon' => $created_date,
                );

                // if password is not empty
                if ($this->input->post('password') != '')
                    $upd_array['password'] = md5($this->input->post('password'));

                //echo $existid; exit;
                $this->db->where('userid', $existid);
                $this->db->update('users', $upd_array);

                $this->session->set_flashdata('success_message', 'Your Account has been updated successfully...');
                $path = base_url('cusers/edituser/'.$userid);
                redirect($path);
            }
        }

        $data['title'] = 'Edit Your Account';

        //$this->load->vars($data);
        $this->load->view('common/header');		
        $this->load->view('cusers/adduser',$data);
		$this->load->view('common/footer');
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
}
