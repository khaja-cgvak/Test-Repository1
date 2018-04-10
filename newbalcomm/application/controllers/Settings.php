<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Settings extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();  				
		$this->load->model('settings/Settings_model','MSetting');
		if (!$this->Common_model->isLoggedIn())
		{
			redirect(base_url()); // login checking
		}
	}
	public function index()
	{
		$data=array();
		$data['sidemenu_sub_active'] = 'settings';
        $data['sidemenu_sub_active1'] = 'settings';
        $data['title'] = 'Dynamic Form Option';

        //$data['sidemenu_sub_active1'] = $this->uri->segment(2);
		$this->load->view('common/header',$data);
		$this->load->view('settings/home',$data);
		$this->load->view('common/footer');
	}
	public function adddyform()
	{
		$data=array();
		$data['process_select']=$this->MSetting->getDrodownProcess();
		$data['sidemenu_sub_active'] = 'settings';
        $data['sidemenu_sub_active1'] = 'adddyform';
        $data['title'] = 'Add Dynamic Form Option';

        //$data['sidemenu_sub_active1'] = $this->uri->segment(2);
		$this->load->view('common/header',$data);
		$this->load->view('settings/adddyform',$data);
		$this->load->view('common/footer');
	}
	public function getSectionByPid()
	{
		$result=array();
		$pid=intval($this->uri->segment(3));
		$this->db->select('*');
		$this->db->where('procid',$pid);
		$this->db->where('parentid',0);
		$data=$this->db->get(DYFORM);		
		$result=array(
			"count"=>$data->num_rows(),
			"data"=>$data->result_array()
			);
		echo json_encode($result);
	}
}
