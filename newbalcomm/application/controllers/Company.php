<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Company extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct(); 

		if (!$this->Common_model->isLoggedIn())
		{
			redirect(base_url()); // login checking
		}
        
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
    
    public function checksyschefile($str)
    {
        #echo '<pre>';print_r($_FILES['uploadfile']);echo '</pre>';
         if(!isset($_FILES['uploadfile']['name']))
         {
            $this->form_validation->set_message('checksyschefile', 'Please choose a file to upload.');            
            return FALSE;
         }
         else
         {
            return TRUE;
         }
    }
	public function index()
	{
        $this->exitpage();
        $data=array();
        $created_date = date('Y-m-d H:i:s');
        if($this->input->post('submit'))            
        {
            $this->form_validation->set_rules('companyname', 'Company Name', 'trim|required');
            $this->form_validation->set_rules('phone', 'Phone Number', 'trim|required');
            //$this->form_validation->set_rules('mobile', 'Mobile Number', 'trim|required');
            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
            $this->form_validation->set_rules('address', 'Address', 'trim|required');
            $this->form_validation->set_rules('uploadfile', 'Upload File', 'callback_checksyschefile');

            
            if ($this->form_validation->run() == TRUE)
            {

                $config['upload_path']   = DROOT.UPATH;
                $config['allowed_types'] = 'gif|jpg|png';
                $config['encrypt_name'] = false;
                $cmplogo='';
                //$config['allowed_types'] = 'gif|jpg|png';
                
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                
                
                $upd_array = array(
                    'companyname' => $this->input->post('companyname'),
                    'phone' => $this->input->post('phone'),
                    'mobile' => $this->input->post('mobile'),
                    'email' => $this->input->post('email'),
                    'address' => $this->input->post('address'),
                    'modifiedon' => $created_date,
                    'modifiedby' => $this->session->userdata('userid')
                );

                $this->db->where('id', 1);
                $this->db->update(COMPANY, $upd_array);

                if($this->upload->do_upload('uploadfile')){                    
                    $uploadData = $this->upload->data();
                    $uploadedFile = $uploadData['file_name'];
                    chmod(DROOT.UPATH.$uploadData['file_name'],0777); // CHMOD file

                    $upd_array = array(
                        'logo'=> $uploadData['file_name']
                    );
                    
                    $this->db->where('id', 1);
                    $this->db->update(COMPANY, $upd_array);
                }

                $this->session->set_flashdata('success_message', 'The Company details has been updated successfully...');
            }
        }
        $company=$this->Common_model->getCompanyByid(1);        
        $companydetails=array();
        if($company->num_rows()>0)
        {
            $companydetails=$company->row_array();
        }
        $data['company']=$company;
        $data['companydetails'] = $companydetails;  
        $data['title'] = 'Company';  
        $this->load->view('common/header');     
        $this->load->view('company/index',$data);
        $this->load->view('common/footer');		
	}
}
