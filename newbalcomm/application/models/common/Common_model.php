<?php
class Common_model extends CI_Model
{
     public function __construct()
    {
        parent::__construct();
    }
	
	public function isLoggedIn()
	{
		// Get current CodeIgniter instance
		//$CI = & get_instance();

		// We need to use $CI->session instead of $this->session
		$user = $this->session->userdata('userid');

		if (isset($user) && $user != '')
		{
			return true;
		}
		return false;
	}
	
	public function generateRandomString($length = 8) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$sc = '@#$!';
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, strlen($characters) - 1)];
		}
		$sp = $sc[rand(0, strlen($sc) - 1)];
		 
		return str_shuffle($sp.$randomString);
	}

	public function getProductById($id=0)
	{
		$this->db->where('id',$id);
		$data=$this->db->get(PROJECTS);		
		$data_result=$data->result_array();
		return $data_result[0];
	}
	public function getUserById($id=0)
	{
		$this->db->where('userid',$id);
		$data=$this->db->get(USER);		
		$data_result=$data->result_array();
		return $data_result[0];
	}
	public function getAllCustomers()
	{
		$this->db->where('isactive',1);
		$this->db->order_by('custname','ASC');
		$data=$this->db->get(CUSTOMER);		
		$data_result=$data->result_array();
		return $data_result;
	}
	public function getCustomerById($id=0)
	{
		$this->db->where('id',$id);
		$data=$this->db->get(CUSTOMER);		
		$data_result=$data->result_array();
		return $data_result[0];
	}
	public function getUserRolesById($id=0)
	{
		if(intval($id)!=0)
		{
			$this->db->where('roleid',$id);
		}
		$this->db->where('isactive',1);
		$this->db->where('isdeleted','I');
		$data=$this->db->get(USERROLE);		
		$data_result=$data->result_array();
		return $data_result;
	}
	public function getUsersByURId($roleid=0)
	{
		if(intval($roleid)!=0)
		{
			$this->db->where('roleid',$roleid);
		}
		$this->db->where('isactive',1);
		$this->db->where('isdeleted','I');
		$this->db->order_by('firstname','ASC');
		$this->db->order_by('lastname','ASC');
		$data=$this->db->get(USER);		
		$data_result=$data->result_array();
		return $data_result;
	}
	public function getAssUrsIds($projid=0)
	{
		$data=array();
		$this->db->where('projid',intval($projid));
		$query=$this->db->get(PROJURS);		
		$result=$query->result_array();
		foreach ($result as $key => $value) {
			$data[]=$value['userid'];
		}
		return $data;
	}
	public function getUserRolesByRoles()
	{
		$this->db->select('*');
		$this->db->join(USERROLE,USERROLE.'.roleid='.USER.'.roleid','left');
		$this->db->where('`'.USER.'.`isactive',1);
		$this->db->where('`'.USERROLE.'.`isactive',1);

		$this->db->where('`'.USER.'.`isdeleted','I');
		$this->db->where('`'.USERROLE.'.`isdeleted','I');

		$data=$this->db->get(USER);

		return $data;
	}
	public function updateSequenceval($table='',$colomn='',$where='',$orderby='',$order='ASC')
	{
		$whe_cond='';
		if(!empty($where))
		{
			$whe_cond=' and ';
		}

		$sql="SET @i = 0;";
		$sql1="UPDATE ".$table." SET ".$colomn." = @i:=@i+1 where 1 ".$whe_cond.$where." ORDER BY ".$orderby." ASC";

		#echo $sql;
		$this->db->query($sql);
		$this->db->query($sql1);

	}
	public function displaySheetNum($table='',$sheetnumber=1,$processid=0)
	{
		
		$seg1=$this->uri->segment(1); // projects controller
		$seg2=$this->uri->segment(2); // controller action
		$seg3=intval($this->decodeid($this->uri->segment(3))); // project id
		$seg4=intval($this->decodeid($this->uri->segment(4))); // Current sheet page number

		$seg3new=($this->encodeid($seg3)); // project id
		$seg4new=($this->encodeid($seg4)); // Current sheet page number


		/* count the table */
		$cntable1=1;
		if($table!='')
		{
			$this->db->select('id');
			$this->db->where('processid',$processid);
			$this->db->where('projectid',intval($seg3));
			$data1=$this->db->get($table);
			$cntable1=$data1->num_rows();
		}

		$link1=$sheetnumber;

		if(!empty($sheetnumber)&&($sheetnumber!=1))
		{
			$this->db->select('id');			
			$this->db->where('sheetnumber',($sheetnumber-1));
			$this->db->where('projectid',intval($seg3));
			$this->db->where('processid',$processid);
			$this->db->limit(1);
			$datars1=$this->db->get($table);
			
			$data_result=$datars1->result_array();
			$data2=$data_result[0];

			$link1='<a href="'.base_url($seg1.'/'.$seg2.'/'.$seg3new.'/'.$this->encodeid($data2['id'])).'"><i class="fa fa-angle-left" aria-hidden="true"></i>&nbsp;'.($sheetnumber).'</a>';
		}
		else
		{
			$link1=$link1;
			
		}

		

		$link2=$cntable1;

		if(($cntable1>1)&&($cntable1!=($sheetnumber)))
		{
			$this->db->select('id');
			$this->db->where('sheetnumber',($sheetnumber+1));
			$this->db->where('processid',$processid);
			$this->db->where('projectid',intval($seg3));
			$this->db->limit(1);
			$datars2=$this->db->get($table);
			$data_result=$datars2->result_array();
			$data3=$data_result[0];

			//$data3=$this->db->get($table)->result_array()[0];

			$link2='<a href="'.base_url($seg1.'/'.$seg2.'/'.$seg3new.'/'.$this->encodeid($data3['id'])).'">'.($cntable1).'&nbsp;<i class="fa fa-angle-right" aria-hidden="true"></i></a>';
		}
		else
		{
			if( $link2 == 0){
				$link2=+1;
			}
			$link2;
		}

		if($seg4==0)
		{	$link_new=1;
			if(($cntable1>0))
			{

				$this->db->select('id');
				$this->db->where('sheetnumber',($sheetnumber));
				$this->db->where('processid',$processid);
				$this->db->where('projectid',intval($seg3));
				$this->db->limit(1);
				$datars2=$this->db->get($table);				
				$data_result=$datars2->result_array();
				$data3=$data_result[0];

				//$data3=$this->db->get($table)->result_array()[0];

				$link_new='<a href="'.base_url($seg1.'/'.$seg2.'/'.$seg3new.'/'.$this->encodeid($data3['id'])).'"><i class="fa fa-angle-left" aria-hidden="true">&nbsp;</i>'.($cntable1+1).'</a>';
				$link2 = $cntable1+1;
			}

			return '<strong>Sheet:</strong>&nbsp;'.($link_new).' of '.$link2;
		}
		else
		{
			return '<strong>Sheet:</strong>&nbsp;'.$link1.' of '.$link2;

		}
	}
	public function getProcessCat($id=0)
	{
		if($id!=0)
		{
			$this->db->where('id',$id);
		}
		$data=$this->db->get(PROCESS);
		return $data;
	}
	public function getProcessLstByPrcat($id=0)
	{
		if($id!=0)
		{
			$this->db->where('processcategoryid',$id);
		}
		$this->db->order_by("isenabled", 'DESC');
		$this->db->order_by('orderofdisplay','ASC');
		$data=$this->db->get(PROCESSLST);
		return $data;
	}
	public function getProcesSecCat($id=0)
	{
		if($id!=0)
		{
			$this->db->where('id',$id);
		}
		$this->db->order_by('orderofdisplay','ASC');
		$data=$this->db->get(PROCESSECCAT);
		return $data;
	}
	public function getProcesSecCatByPrcId($id=0)
	{
		if($id!=0)
		{
			$this->db->where('processlistid',$id);
		}
		$this->db->order_by('orderofdisplay','ASC');
		$data=$this->db->get(PROCESSECCAT);
		return $data;
	}

	public function getProcesSec($id=0)
	{
		if($id!=0)
		{
			$this->db->where('id',$id);
		}
		$this->db->order_by('orderofdisplay','ASC');
		$data=$this->db->get(PROCESSEC);
		return $data;
	}
	public function getProcesSecByCatid($id=0)
	{
		if($id!=0)
		{
			$this->db->where('processsectioncategoryid',$id);
		}
		$this->db->order_by('orderofdisplay','ASC');
		$data=$this->db->get(PROCESSEC);
		return $data;
	}
	public function insertPrjPrcMaster($ins_array1=array())
	{
		$insert_id=0;
		if(!empty($ins_array1))
		{
			$this->db->insert(PRJPRCLST, $ins_array1);
			$insert_id=$this->db->insert_id();
		}
		return $insert_id;

	}

	public function updatePrjPrcMaster($update_array=array(),$prcessid=0)
	{
		if($prcessid!=0)
		{
	        $this->db->where('id', $prcessid);
	        $this->db->update(PRJPRCLST, $update_array);
	    }
	}

	public function getAllProjects()
	{
		$this->db->where('isactive',1);
		$this->db->order_by('id','ASC');
		$data=$this->db->get(PROJECTS);		
		$data_result=$data->result_array();
		return $data_result;
	}
   
    public function getAllsystems($projectid=null)
	{
		$this->db->where('projectid',$projectid);
		$this->db->order_by('id','ASC');
		$data=$this->db->get(PRJSYS);		
		$data_result=$data->result_array();
		return $data_result;
	}

	public function getenginners($projectid=0)
	{
		
	    $this->db->from(USER.' u');
	    $this->db->where('u.roleid','25');
		$this->db->where('u.isactive',1);
		$this->db->where('u.isdeleted','I');
		$this->db->join('projects_users pc','pc.userid = u.userid','inner');
        $this->db->where('pc.projid',$projectid);

		$data=$this->db->get();		
		$data_result=$data->result_array();
		return $data_result;
	}

	 /*** new functions ***/

	public function sheetnumber($table='',$sheetnumber=1,$processid=0,$module=null)
	{
		
		$seg1=$this->uri->segment(1); // page controller
		$seg2=$this->uri->segment(2); // controller action
		$seg3=intval($this->uri->segment(3)); // project id
		$seg4=intval($this->uri->segment(4)); // Current sheet page number


		/* count the table */
		$cntable1=1;
		if($table!='')
		{
			$this->db->select('id');
			$this->db->where('processid',$processid);
			$this->db->where('module_name',$module);
			$this->db->where('processid',$processid);
			$this->db->where('projectid',intval($seg3));
			$data1=$this->db->get($table);
			$cntable1=$data1->num_rows();
		}

		$link1=$sheetnumber;

		if(!empty($sheetnumber)&&($sheetnumber!=1))
		{
			$this->db->select('id');			
			$this->db->where('sheetnumber',($sheetnumber-1));
			$this->db->where('projectid',intval($seg3));
			$this->db->where('module_name',$module);
			$this->db->where('processid',$processid);
			$this->db->limit(1);
			$datars1=$this->db->get($table);
			
			$data_result=$datars1->result_array();
			$data2=$data_result[0];

			$link1='<a href="'.base_url($seg1.'/'.$seg2.'/'.$seg3.'/'.$data2['id']).'"><i class="fa fa-angle-left" aria-hidden="true"></i>&nbsp;'.($sheetnumber+1).'</a>';
		}
		else
		{
			$link1='<a href="'.base_url($seg1.'/'.$seg2.'/'.$seg3).'"><i class="fa fa-angle-left" aria-hidden="true"></i>&nbsp;'.($link1+=1).'</a>';
			
		}

		

		$link2=$cntable1;

		if(($cntable1>1)&&($cntable1!=($sheetnumber)))
		{
			$this->db->select('id');
			$this->db->where('sheetnumber',($sheetnumber+1));
			$this->db->where('processid',$processid);
			$this->db->where('module_name',$module);
			$this->db->where('projectid',intval($seg3));
			$this->db->limit(1);
			$datars2=$this->db->get($table);
			$data_result=$datars2->result_array();
			$data3=$data_result[0];

			//$data3=$this->db->get($table)->result_array()[0];

			$link2='<a href="'.base_url($seg1.'/'.$seg2.'/'.$seg3.'/'.$data3['id']).'">'.($cntable1+1).'&nbsp;<i class="fa fa-angle-right" aria-hidden="true"></i></a>';
		}
		else
		{
			$link2+=1;
		}

		if($seg4==0)
		{
			if(($cntable1>0))
			{
				$this->db->select('id');
				$this->db->where('sheetnumber',($sheetnumber));
				$this->db->where('processid',$processid);
				$this->db->where('module_name',$module);
				$this->db->where('projectid',intval($seg3));
				$this->db->limit(1);
				$datars2=$this->db->get($table);				
				$data_result=$datars2->result_array();
				$data3=$data_result[0];

				//$data3=$this->db->get($table)->result_array()[0];

				$link2='<a href="'.base_url($seg1.'/'.$seg2.'/'.$seg3.'/'.$data3['id']).'">'.($cntable1+1).'&nbsp;<i class="fa fa-angle-right" aria-hidden="true"></i></a>';
			}

			return '<strong>Sheet:</strong>&nbsp;1 of '.$link2;
		}
		else
		{
			return '<strong>Sheet:</strong>&nbsp;'.$link1.' of '.$link2;

		}
	}
	public function getPrvPages($id=0)
	{
		$this->db->select('*');
		if(!empty($id))
		{
			$this->db->where('id',$id);
		}
		$this->db->where('pagestatus',1);
		$data=$this->db->get(PRVPAGES);
		return $data;
	}
	public function getPrvOptPages($id=0)
	{
		$this->db->select('*');
		if(!empty($id))
		{
			$this->db->where('id',$id);
		}
		$data=$this->db->get(PRVPAGEOPT);
		return $data;
	}
	public function getPrvOptPagesByPid($id=0)
	{
		$this->db->select('*');
		if(!empty($id))
		{
			$this->db->where('pageid',$id);
		}
		$data=$this->db->get(PRVPAGEOPT);
		return $data;
	}
	public function ckRolePermission($roleid=0,$segarrval='')
	{
		$this->db->select('*');
		$this->db->join(PRVPAGEOPT.' popt','prn.optpageid=popt.id','left');
		$this->db->where('popt.optslug',$segarrval);
		$this->db->where('prn.roleid',intval($roleid));
		$this->db->where('prn.optstatus',1);
		$data=$this->db->get(PRVPERMION.' prn');
		if($data->num_rows()>0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	public function encodeid($id=0)
	{
		$base_64 = base64_encode($id);
        $url_param = rtrim($base_64, '=');
        return $url_param;
	}
	public function decodeid($url_param='')
	{
        $base_64 = $url_param . str_repeat('=', strlen($url_param) % 4);
        $data_val = base64_decode($base_64);
        return $data_val;
	}
	public function getCompanyByid($id=0)
	{
		$this->db->select('*');
		$this->db->where('id',intval($id));
		$result=$this->db->get(COMPANY);
		return $result;
	}

	public function getAllProjectsWithNameAndId()
	{
		$this->db->select('id as projectid, projectname');
        $result =$this->db->get_where(PROJECTS, array('isdeleted'=>'N'))->result_array();
        return $result;
        
	}

	public function getAllSystemsGroupByProject()
	{
		$this->db->select('ps.projectid as projectid,group_concat(ps.systemname ," : " ,ps.id) as systems');
		$this->db->from(PRJSYS.' ps');
		$this->db->join(PROJECTS.' p', 'p.id = ps.projectid');
		$this->db->where('p.isdeleted', 'N');
		//$this->db->distinct();
        $this->db->group_by('projectid');

        $result =$this->db->get()->result_array();
        return $result;
	}

	public function getAllUsersOfProject()
	{
		$this->db->select('p.projid as projectid, group_concat(concat(u.firstname," ", u.lastname)," : ",p.userid) as name');
        $this->db->from(USER.' u');
        $this->db->join(PROJURS.' p', 'p.userid = u.userid');
        $this->db->join(PROJECTS.' proj', 'proj.id = p.projid');
        $this->db->where('proj.isdeleted', 'N');
        $this->db->group_by('p.projid');
        $result = $this->db->get()->result_array();
        return $result;
	}

	public function common_insert($table ='', $insArr=array()){
		return $this->db->insert($table, $insArr);
	}

	public function getJsonFilesLog()
	{
		$this->db->select('o.*,concat(u.firstname," ",u.lastname) as name ');
		$this->db->from('offline_form_uploads o');
		$this->db->join(USER.' u', 'o.uploaded_by = u.userid');
		$this->db->where('o.is_imported', 0);
		return $this->db->get()->result_array();
	}

	public function get_engineers_by_projname($proj_name='') {
		if( $proj_name != '' ){

			$this->db->select('u.userid,concat(u.firstname, " ",u.lastname) as name');
			$this->db->from(USER.' u');
			$this->db->join(PROJURS.' p', 'p.userid = u.userid');
			$this->db->join(PROJECTS.' proj', 'proj.id = p.projid');
			$this->db->where('proj.isdeleted', 'N');
			$this->db->where('proj.projectname', $proj_name);
			$result = $this->db->get()->result_array();
			return $result;
		}

	}

	public function get_systems_by_projname($proj_name) {
		$this->db->select('ps.id,ps.systemname');
		$this->db->from(PRJSYS.' ps');
		$this->db->join(PROJECTS.' p', 'p.id = ps.projectid');
		$this->db->where('p.isdeleted', 'N');
		$this->db->where('p.projectname', $proj_name);
        $result =$this->db->get()->result_array();
        return $result;

	}

	public function getProjectId($project_name){
		$this->db->select('id');
        $this->db->where('projectname', $project_name);
        $this->db->where('isdeleted', 'N');
        return $this->db->get(PROJECTS)->row();
	}

	public function getSystemId( $project_id, $system_name){
		$this->db->select('id');
		$this->db->where('projectid', $project_id);
		$this->db->where('systemname', $system_name);
		 return $this->db->get(PRJSYS)->row();
	}

	public function getUserIdHavingNames($names_arr){
		$this->db->select('userid');		
		$this->db->from(USER);
		$this->db->where('firstname', $names_arr[0]);
		$this->db->where('lastname', $names_arr[1]);
		$this->db->where('isactive',1);
        $this->db->where('isdeleted','I');
		return $this->db->get()->row();
	}

	public function getProjectEngineerId($engineer_names_arr, $project_id){
		$this->db->select('pu.userid');
		$this->db->from(PROJURS.' pu');
		$this->db->join(USER.' u', 'pu.userid = u.userid');
		$this->db->where('u.firstname', $engineer_names_arr[0]);
		$this->db->where('u.lastname', $engineer_names_arr[1]);
		$this->db->where('pu.projid', $project_id);
		return $this->db->get()->row();
	}

	public function checkRefIsUniq($ref){
		$rows_count = $this->db->get_where(PRJPRCLST, array('referenceno'=>$ref))->num_rows();
		if(!empty($rows_count) && count($rows_count)>=1){
			return FALSE;
		}
		else{
			return TRUE;
		}

	}


}
