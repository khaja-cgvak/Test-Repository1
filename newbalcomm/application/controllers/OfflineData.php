<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 
*/
class OfflineData extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('projects/Projects_model','MProject');
        if (!$this->Common_model->isLoggedIn())
            redirect(base_url('')); // login checking
	}

	public function index()
	{ 
        //$this->exitpage();
		$this->load->model('common/Common_model');
        $data['projects_data']=$this->Common_model->getAllProjectsWithNameAndId();
        $data['systems_data']=$this->Common_model->getAllSystemsGroupByProject();
        $data['project_users'] = $this->Common_model->getAllUsersOfProject();
        $total_data = array();
        for($i=0; $i< count($data['project_users']); $i++){

        	if(($data['projects_data'][$i]['projectid'] == $data['systems_data'][$i]['projectid']) && $data['project_users'][$i]['projectid'] == $data['projects_data'][$i]['projectid'])
        	{
        		$total_data[$i] = array(
        			'projectid' => $data['projects_data'][$i]['projectid'],
        			'projectname' => $data['projects_data'][$i]['projectname'],
        			'systems' => $data['systems_data'][$i]['systems'],
        			'users' => $data['project_users'][$i]['name'],
        		);
        	}
        }

        $data['total_data'] = $total_data;
   		//echo '<pre>';print_r($total_data);die;
        $data['userRoledata']=$this->Common_model->getUserRolesByRoles();
        $data['userroles']=$this->Common_model->getUserRolesById();
        $data['customers']=$this->Common_model->getAllCustomers();
       
        
        $data['title'] = 'View Offline Data';
        $data['custom_side_menu'] = 'projprsmenu';
        $data['sidemenu_sub_active'] = '';
        $data['sidemenu_sub_active1'] = '';

        $this->load->view('common/header',$data);
        $this->load->view('offline/offline_data',$data);
        $this->load->view('common/footer');
	}

    public function upload()
    {
        if( $this->input->post('submit') )
        {
            $config['upload_path']     = './uploads/json_files';
            $config['allowed_types']   = 'txt';
            $config['max_size']        = 1000;

            $this->load->library('upload', $config);
            $filesCount = count($_FILES['offline_file']['name']);
            $files = $_FILES;
            for($i = 0; $i < $filesCount; $i++)
            {
                $_FILES['offline_file']['name']      = $files['offline_file']['name'][$i];
                $_FILES['offline_file']['type']      = $files['offline_file']['type'][$i];
                $_FILES['offline_file']['tmp_name']  = $files['offline_file']['tmp_name'][$i];
                $_FILES['offline_file']['error']     = $files['offline_file']['error'][$i];
                $_FILES['offline_file']['size']      = $files['offline_file']['size'][$i];
               
                $this->upload->do_upload('offline_file');
                $fileData = $this->upload->data();
                $insertArr = array(
                    'file_name'         => $fileData['file_name'],
                    'form_name'         =>'',
                    'form_id'           => '',
                    'uploaded_by'       => $this->session->userdata('userid'),
                    'uploaded_date'     => date('Y-m-d H:i:s'),
                    'is_imported'       => '0'
                );
                $this->Common_model->common_insert(OFFLINE,$insertArr);
            }
            $this->session->set_flashdata('success_message', 'Files Uploaded Successfully...');
            redirect('upload');             
        }
        else
        {
            $data = array();
            $data['title'] = 'Upload Files';
            $this->load->view('common/header',$data);
            $this->load->view('offline/upload_offline_files',$data);
            $this->load->view('common/footer');
        }    
    }

    public function import()
    {
        //$this->exitpage();
        $data = array();
        $data['title'] = 'Import Data to DB';
        $this->db->select('id, projectname');
        $this->db->where('isdeleted', 'N');
        $data['projects'] = $this->db->get(PROJECTS)->result_array();

        $data['userall']=$this->MProject->getUsers(0);
        //$data['engdata']=$this->MProject->getEngByPrjID($proid);
        $data['json_log'] = $this->Common_model->getJsonFilesLog();
        $this->load->view('common/header',$data);
        $this->load->view('offline/import_offline_form',$data);
        $this->load->view('common/footer');
    }

    public function delete_json_file()
    {
        //$this->exitpage();
        //isdeleted
        $json_file_id = $this->uri->segment(3);
        $created_date = date('Y-m-d H:i:s');

       /* $upd_array = array(
            'isdeleted' => 'Y',
            'lastmodifiedon' => $created_date,
            'lastmodifiedby' => $this->session->userdata('userid')
        );*/
        $this->db->select('file_name');
        $this->db->where('id', $json_file_id);
        $json_file_name = $this->db->get(OFFLINE)->row()->file_name;
        //echo $json_file_name;die;
        if(unlink('./uploads/json_files/'.$json_file_name)){
            $this->db->where('id', $json_file_id);
            $this->db->delete(OFFLINE);
            $this->session->set_flashdata('success_message', 'The Json Text File has been deleted successfully...');
        }
        else
        {
            $this->session->set_flashdata('failed_message', 'Failed to delete...please try again');
        }
        $path = base_url('import') ;
        redirect($path);

    }

    /**Check Project-name, system name and engineer 
     * names entered by user valida or not 
     * in offline form */
    public function checkValidNames()
    {
        $project_name = $this->input->post('project_name');
        $system_name = $this->input->post('system_name');
        $engineer_name = $this->input->post('engineer_name');
        $engineer_names_arr = explode(" ", $engineer_name);
        $process_slug = $this->input->post('process_slug');
        if($process_slug == 'rpz')
        {
            $testername = $this->input->post('testername');
            $watersupp = $this->input->post('watersupp');

            $testernameArr = explode(" ",$testername);
            $watersuppnameArr = explode(" ",$watersupp);

        }
        $reportref = $this->input->post('reportref');
        if( ! $this->Common_model->checkRefIsUniq($reportref) ) {
            echo json_encode(array('status'=>'failed1','data'=>'Reference Already Exists'));
            return;
        }
        $project_id_data = $this->Common_model->getProjectId($project_name);
        if(!empty($project_id_data)){
            $project_id = $project_id_data->id;
        }
        if( !empty($project_id )){

            if($process_slug == 'rpz')
            {
                $tester_id_data=$this->Common_model->getUserIdHavingNames($testernameArr);
                $watersupp_id_data=$this->Common_model->getUserIdHavingNames($watersuppnameArr);
               if(!empty($tester_id_data) && !empty($watersupp_id_data)){
                $tester_id = $tester_id_data->userid;
                $watersupp_id = $watersupp_id_data->userid;
               }

               if(!empty( $tester_id) &&  $watersupp_id){

                    $project_encoded_id = $this->Common_model->encodeid($project_id);
                    $response = array(
                        'project_id' => $project_id,
                        'tester_id' =>$tester_id,
                        'watersupp_id'=> $watersupp_id,
                        'post_url'=> base_url().'projects/'.$process_slug.'/'.$project_encoded_id
                    );
                    echo json_encode(array('status'=>'success', 'data'=>$response));
                    return;
               }
               else
                {
                    echo json_encode(array('status'=>'failed','data'=>'Wrong Details Supplied'));
                    return;
                }
            }
            

            if($process_slug == 'waterTreatmentTempcer'){//for Temporary Certificate of Disinfection/Chlorination no system id field
                if(!empty($engineer_names_arr) && count($engineer_names_arr)>1){
                    $engineer_id_result = $this->Common_model->getProjectEngineerId($engineer_names_arr, $project_id);
                }
               
                if(!empty($engineer_id_result)){
                    $engineer_id = $engineer_id_result->userid;
                }
                   
                if(!empty( $engineer_id)){
                $project_encoded_id = $this->Common_model->encodeid($project_id);
                $response = array(
                    'project_id' => $project_id,
                    'engineer_id' => $engineer_id,
                    'post_url'=> base_url().'projects/'.$process_slug.'/'.$project_encoded_id
                );
                echo json_encode(array('status'=>'success', 'data'=>$response));
                return;
                }
                else
                {
                    echo json_encode(array('status'=>'failed','data'=>'Wrong Details Supplied'));
                    return;
                }
            }
            
            $system_id_data = $this->Common_model->getSystemId($project_id, $system_name);
            if(!empty($system_id_data)){
                $system_id = $system_id_data->id;
            }

            if($process_slug == 'commAir' || $process_slug == 'commWater' || $process_slug == 'waterTreatmentSysWitCer'){//for System Witness Certificates no engid
                $system_id_data = $this->Common_model->getSystemId($project_id, $system_name);
                if(!empty($system_id_data)){
                    $system_id = $system_id_data->id;
                }
                if(!empty($system_id)) {
                $project_encoded_id = $this->Common_model->encodeid($project_id);
                $response = array(
                    'project_id' => $project_id,
                    'system_id' =>  $system_id,
                    'post_url'=> base_url().'projects/'.$process_slug.'/'.$project_encoded_id
                );
                echo json_encode(array('status'=>'success', 'data'=>$response));
                return;
                } 
                else
                {
                    echo json_encode(array('status'=>'failed','data'=>'Wrong Details Supplied'));
                }
            }
            if(!empty($engineer_names_arr) && count($engineer_names_arr)>1){
                $engineer_id_result = $this->Common_model->getProjectEngineerId($engineer_names_arr, $project_id);
            }
           
            if(!empty($engineer_id_result)){
                $engineer_id = $engineer_id_result->userid;
            }
           if(!empty($system_id) && !empty($engineer_id))
           {
               $project_encoded_id = $this->Common_model->encodeid($project_id);
                $response = array(
                    'project_id' => $project_id,
                    'system_id' =>  $system_id,
                    'engineer_id' => $engineer_id,
                    'post_url'=> base_url().'projects/'.$process_slug.'/'.$project_encoded_id
                );
                echo json_encode(array('status'=>'success', 'data'=>$response));
                return;
           }
           else
           {
                echo json_encode(array('status'=>'failed','data'=>'Wrong Details Supplied'));
           }
        }
        else
        {
            echo json_encode(array('status'=>'failed','data'=>'Wrong Details Supplied'));
            return;
        } 
    }

    public function download_offline_app()
    {
        $this->load->helper('download');         
        $file_data = file_get_contents(base_url().'offline_app/offline_app.zip');
        force_download('offline_app.zip', $file_data, TRUE);        
    }

    public function getSystemsnEngineersByProjName($proj_name){
        $data['engineer_list'] = $this->Common_model->get_engineers_by_projname(urldecode($proj_name));
        $data['systems_list'] =  $this->Common_model->get_systems_by_projname(urldecode($proj_name));
        $resArr = array(
            'engineers_list' => $data['engineer_list'],
            'systems_list'  => $data['systems_list']
        );
        echo json_encode($resArr);
        return;
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
}