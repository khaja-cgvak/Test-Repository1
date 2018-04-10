<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Prjbg extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();  
		$this->load->model('home/Home_model','CHome');
		
		if (!$this->Common_model->isLoggedIn())
		{
			redirect(base_url()); // login checking
		}

        if(!isset($_POST))
        {
            $data=array("action"=>"error",'actmsg'=>"Access denied.");
            echo json_encode($data);
            exit;
        }


	}
	public function index()
	{
		$data=array("action"=>"error",'actmsg'=>"Access denied.");
        echo json_encode($data);
        exit;
	}

    function addSitedata()
    {
        $created_date = date('Y-m-d H:i:s');
        $ins_sys_array= array(
            'custid'=>$this->input->post('cntid'),
            'sitename'=>$this->input->post('sitename'),
            'siteaddress'=>$this->input->post('siteaddress')
        );

        $ins_sys_array['createdon'] = $created_date;
        $ins_sys_array['createdby']= $this->session->userdata('userid');
        $this->db->insert(CUSSITES, $ins_sys_array);
        $sid=$this->db->insert_id();
        $data=array("action"=>"success",'actmsg'=>"Site details has been added successfully.",'sid'=>$sid);
        echo json_encode($data);

    }

    function addContactdata()
    {
        $created_date = date('Y-m-d H:i:s');
        
        $siteid=$this->input->post('siteid');       
        $custid=$this->input->post('custid');

        $ins_sys_array= array(
            'custid'=>$custid,
            'contactfirstname'=>$this->input->post('contactfirstname'),
            'contactlastname'=>$this->input->post('contactlastname'),
            'contactdesignation'=>$this->input->post('contactdesignation'),
            'contactphone'=>$this->input->post('contactphone'),
            'contactmobile'=>$this->input->post('contactmobile'),
            'contactemailid'=>$this->input->post('contactemailid')
        );
        $ins_sys_array['createdon'] = $created_date;
        $ins_sys_array['createdby']= $this->session->userdata('userid');
        $this->db->insert(CUSDETAILS, $ins_sys_array);              
        $contid=$this->db->insert_id();
        

        $si_ins_array=array(
            "custid"=>$custid,
            "siteid"=>$siteid,
            "contid"=>$contid
        );
        $this->db->insert(CUSCONSITE, $si_ins_array); 


        $data=array("action"=>"success",'actmsg'=>"Contact details has been added successfully.",'contid'=>$contid);
        echo json_encode($data);

    }

}
