    <?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reports extends CI_Controller {

    protected $filctrl=array(
            1=>'commAir',
            2=>'commWater',
            3=>'rpz',
            4=>'timesheet',
            5=>'watertreatment'
        );	
	public function __construct()
	{        
		parent::__construct(); 
		
		$this->load->model('projects/Projects_model','MProject');
        $this->load->model('reports/Reports_model','MReports');

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
        $data = array();
        //$data['template'] = 'roles/list';
		
        $data['userRoledata']=$this->Common_model->getUserRolesByRoles();
        $data['userroles']=$this->Common_model->getUserRolesById();
        $data['customers']=$this->Common_model->getAllCustomers();
        $data['title'] = 'Project List';
		$this->session->set_userdata('left_submenu', 'projects');
		 if ($this->input->post('submit'))
        {           
            /*$this->form_validation->set_rules('projectname', 'Project Number', 'trim|required');
            $this->form_validation->set_rules('sitename', 'Site name', 'trim|required');
            $this->form_validation->set_rules('sitecontactname', 'Contact name', 'trim|required');
            $this->form_validation->set_rules('userincharge', 'Customer Name', 'trim|required');
            $this->form_validation->set_rules('assign_users[]', 'Assign Users', 'trim|required');
            $this->form_validation->set_rules('projectdescription', 'Project Description', 'trim|required');
            $this->form_validation->set_rules('status', 'Is acive', 'trim|required');*/
           

            $systemname_ck = $this->input->post('systemname');
            if(!empty($systemname_ck))
            {
                foreach($systemname_ck as $id => $data_ck)
                {
                    $this->form_validation->set_rules('systemname[' . $id . ']', 'System Name', 'required|trim');
                    $this->form_validation->set_rules('companyname[' . $id . ']', 'Company Name', 'required|trim');
                    $this->form_validation->set_rules('companyaddress[' . $id . ']', 'Company Address', 'required|trim');
                    $this->form_validation->set_rules('contractorname[' . $id . ']', 'Services Contractor Name', 'required|trim');
                    /*$this->form_validation->set_rules('contractoraddress[' . $id . ']', 'Services Contractor Address', 'required|trim');*/
                    $this->form_validation->set_rules('witnessedny[' . $id . ']', 'Witnessed By', 'required|trim');
                    $this->form_validation->set_rules('witnesseddate[' . $id . ']', 'Date', 'required|trim');
                    $this->form_validation->set_rules('testcmpby[' . $id . ']', 'Test Completed By', 'required|trim');
                    $this->form_validation->set_rules('testcmpdate[' . $id . ']', 'Date', 'required|trim');
                }
            }
             if ($this->form_validation->run() == TRUE)
             {
				  $ckemtyval=$this->input->post('systemname');
				
                
                if(!empty($ckemtyval))
                {
                    foreach ($this->input->post('systemname') as $sys_key => $sys_value) {
                       
                        $ins_sys_array= array(
                            'projectid'=>$_POST['projectid'],
                            'systemname'=>$_POST['systemname'][$sys_key],
                            'companyname'=>$_POST['companyname'][$sys_key],
                            'companyaddress'=>$_POST['companyaddress'][$sys_key],
                            'servicecontractorname'=>$_POST['contractorname'][$sys_key],
                            'testedby'=>$_POST['testcmpby'][$sys_key],
                            'witnessedby'=>$_POST['witnessedny'][$sys_key],
                            'witnesseddate'=>date('Y-m-d H:i:s',strtotime($_POST['witnesseddate'][$sys_key])),
                            'testedDate'=>date('Y-m-d H:i:s',strtotime($_POST['testcmpdate'][$sys_key])),
                        );
						//print_r($ins_sys_array); 
                        $this->db->insert(PRJSYS, $ins_sys_array);

                    }
                } 
				//die;
                $this->session->set_flashdata('success_message', 'New Systems has been created successfully...');
                $path = base_url('reports') ;
                redirect($path);				
			 }
        }

        $data['title'] = 'Project List'; 

        $data['system_details']=array(
            array(
                    'id'=>0,
                    'projectid'=>0,
                    'systemname'=>'',
                    'companyname'=>'',
                    'companyaddress'=>'',
                    'servicecontractorname'=>'',
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
                        'projectid'=>$_POST['projectid'],
                        'systemname'=>$_POST['systemname'][$sys_key],
                        'companyname'=>$_POST['companyname'][$sys_key],
                        'companyaddress'=>$_POST['companyaddress'][$sys_key],
                        'servicecontractorname'=>$_POST['contractorname'][$sys_key],
                        /*'servicecontractoraddress'=>$_POST['contractoraddress'][$sys_key],*/
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
        $this->load->view('common/header');
        $this->load->view('reports/project-list',$data);
        $this->load->view('common/footer');
    }
	public function getallProjects1()
	{
        $table = PROJECTS;
         
        // Table's primary key
        $primaryKey = 'id';

        $roleid=$this->session->userdata('userroleid');
        $segarrval='reports/projview';
        $ckpermission=$this->Common_model->ckRolePermission($roleid,$segarrval);
        define('rptview',$ckpermission);

        $columns = array(
            array( 'db' => 'p.projectname', 'dt' => 0, 'field' => 'projectname','formatter'=>function($d,$row){
               
				return '<a href="'.site_url('reports/projview/'.$row['id']).'">'.$d.'</a>';
				
            }),          
            array( 'db' => 'p.projectstartdate',  'dt' => 1, 'field' => 'projectstartdate','formatter' => function( $d, $row ) { return date('d M Y',strtotime($d));}),
            array( 'db' => 'p.projectenddate',  'dt' => 2, 'field' => 'projectenddate','formatter' => function( $d, $row ) { return date('d M Y',strtotime($d));}),
            array( 'db' => 'p.projectdescription',  'dt' => 3, 'field' => 'projectdescription'),
            array( 'db' => 'u.custname',  'dt' => 4, 'field' => 'custname'),
            array( 'db' => 'p.projectstatus',  'dt' => 5, 'field' => 'projectstatus'),            
            array( 'db' => 'p.id',   'dt' => 5, 'field' => 'id','formatter' => function( $d, $row ) {
                    $action='<div class="icon_list">';
					
                    $enid=$this->Common_model->encodeid($d);
                    if(rptview==true)
                    {
                        $action.='<a href="'.site_url('reports/projview/'.$enid).'"  data-toggle="tooltip"  title="Report List"><i class="fa fa-cog" aria-hidden="true"></i></a>';
                    }
                    $action.='</div>';
					
                    return $action;
                }), 
            array( 'db' => 'p.id', 'dt' => 6, 'field' => 'id','formatter'=>function($d,$row){
               
				
				return '<input type="submit" id="button123" class="button" value="Add Sytem Details" />';
				
				
            }),
        /*array( 'db' => 'p.id', 'dt' => 6, 'field' => 'id','formatter'=>function($d,$row){
               
				return '<input type="text" name="oid" id="pid" value='.$row['id']).'>';
				
				
            }), */   			
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
        $extraWhere = " p.isdeleted='N' and p.isactive='1' ";        
        $searchval=$_REQUEST['search']['value'];       
        $extraWhere_add=' AND ';
        echo json_encode(
            SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere,'',$extraWhere_add )
        );
	}
    public function projview()
    {
        $this->exitpage();
        $data = array();        
        $proid_new = $this->uri->segment(3);
        $proid=intval($this->Common_model->decodeid($proid_new));
        $projdata=$this->Common_model->getProductById($proid);
        $data['projdata']=$projdata;
        $data['title'] = $projdata['projectname'].' - Report List';
        $data['proid']=$proid_new;
        $this->load->view('common/header');
        $this->load->view('reports/repot-list',$data);
        $this->load->view('common/footer');
    }
    public function getallPrjReportsgetallPrjReports()
    {
        $table = PROJECTS;
        $proid = intval($this->Common_model->decodeid($this->uri->segment(3)));
         
        // Table's primary key
        $primaryKey = 'id';

        $roleid=$this->session->userdata('userroleid');
        $segarrval='reports/reptdownload';
        $ckpermission=$this->Common_model->ckRolePermission($roleid,$segarrval);
        define('rptedit',$ckpermission);


        $columns = array(                     
            array( 'db' => 'prj.createdon',  'dt' => 0, 'field' => 'createdon','formatter' => function( $d, $row ) { return date('d M Y',strtotime($d));}),
            array( 'db' => 'us.firstname',  'dt' => 1, 'field' => 'firstname'),     
            array( 'db' => 'us.lastname',  'dt' => 1, 'field' => 'lastname','formatter' => function( $d, $row ) {  return $row['firstname'].' '.$row['lastname']; }),            
            array( 'db' => 'u.custname',  'dt' => 2, 'field' => 'custname'),            
            array( 'db' => 'prj.id',   'dt' => 3, 'field' => 'id','formatter' => function( $d, $row ) {

                    $newproid = $this->uri->segment(3);

                    $enid=$this->Common_model->encodeid($d);
                    //$newproid = $this->Common_model->encodeid($newproid);

                    $action='<div class="icon_list">';
                    if(rptedit==true)
                    {
                        $action.='<a href="'.site_url('reports/reptdownload/'.$enid.'/'.$newproid).'"  data-toggle="tooltip"  title="Download Report"><i class="fa fa-download" aria-hidden="true"></i></a>';
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
        
        $joinQuery = "FROM `".PRJREPORT."`as prj 
            left join`".PROJECTS."` AS `p` on (`p`.`id`=`prj`.`proid`) 
            Left JOIN `".CUSTOMER."` AS `u` ON (`u`.`id` = `p`.`userincharge`)
            Left JOIN `".USER."` AS `us` ON (`us`.`userid` = `prj`.`createdby`)";
        $extraWhere = " (prj.isdeleted='I' and prj.proid='".$proid."') ";        
        $searchval=$_REQUEST['search']['value'];       
        $extraWhere_add=' AND ';

        if(!empty($searchval))
        {
            //$extraWhere = " addressLine2 like '%".$searchval."%' ";
            $extraWhere .= " OR us.lastname like '%".$searchval."%' ";
        }

        echo json_encode(
            SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere,'',$extraWhere_add )
        );
    }
    public function crereport()
    {
        $this->exitpage();
        include(DROOT."/assets/mpdf/mpdf.php");
        
        //$mpdf->setAutoTopMargin=true;
        //$mpdf->setAutoBottomMargin=true;
        $proid_id = $this->uri->segment(3);
        $proid=intval($this->Common_model->decodeid($proid_id));
        $masterprcid = 1;        
        
        $data['proid'] = $proid;
        
        $data['masterprcid'] = $masterprcid;
        $data['engdata']=$this->MProject->getEngByPrjID($proid);        
        $data['sheetstatus']=$this->MProject->getPrjSheetStatus($proid,$masterprcid);
        $data['custom_side_menu'] = 'projprsmenu';
        $data['prodata']=$this->Common_model->getProductById($proid); 
        $data['sidemenu_sub_active'] = 'commAir';
        $data['sidemenu_sub_active1'] = $this->uri->segment(2);        


        $this->db->select('plm.*,pl.processcategoryid,pl.processtitle,pl.slug as plslug');
        /* join Project Sheet */
        $this->db->join(PRJSHTSTS.' ps','(ps.projectid='.$proid.' AND ps.sheetid = plm.processid)','inner');
        $this->db->join(PROCESSLST.' pl','pl.id=plm.processid','inner');
        
        $this->db->where('plm.projectid',$proid);
        $this->db->where('ps.status',1);

        /* Order by */

        $this->db->order_by('pl.processcategoryid','ASC');
        $this->db->order_by('pl.orderofdisplay','ASC');
        $this->db->order_by('plm.sheetnumber','ASC');

        //$this->db->group_by('plm.processid');        
        $res1=$this->db->get(PRJPRCLST.' plm');
        $res1cnt=$res1->num_rows();

       # echo $this->db->last_query();

        #exit;

        $filctrl=$this->filctrl;

        #echo '<pre>';print_r($filctrlw);echo '</pre>';

        $result_syswit_header='<html><head>
            <style>
                body{
                    font-size: 10pt; 
                }                
                table {                                        
                    line-height: 1.3;
                    vertical-align: top; 
                    border-collapse: collapse;
                }
                thead { 
                    font-weight: bold; 
                    vertical-align: middle; 
                }
                th {    
                    font-weight: bold; 
                    text-align:center; 
                    padding-left: 2mm; 
                    padding-right: 2mm; 
                    padding-top: 0.5mm; 
                    padding-bottom: 0.5mm; 
                    vertical-align: middle; 
                 }
                td {    
                    padding-left: 2mm; 
                    text-align:left; 
                    padding-right: 2mm; 
                    padding-top: 0.5mm; 
                    padding-bottom: 0.5mm;
                 }
                th p { 
                    text-align: left; 
                    margin:0pt;
                }
                td p { 
                    text-align: left; 
                    margin:0pt;
                }
                .no_border
                {
                    border:0px;
                }
                .no_border_bottom
                {
                    border-bottom:0px;
                }
                .no_border_eleft
                {
                    border:0px 0px 0px 1px;
                }
                td.td-pad-0,th.td-pad-0
                {
                    padding:0px;
                }
                table.tblnormal
                {
                    border-collapse: inherit;
                }
            </style>
        </head><body>';
        $result_syswit_footer='</body></html>';

        $result_syswit=array(
        );

         

        $header = '<div align="left"><h4 style="margin:0px;">BALCOMM LIMITED</h4><hr style="margin:0px;width:33%;text-align:left">Commissioning, Ductwork Cleaning<br>& Water Treatment</div><hr>';
        $headerE = $header;

        $footer = '<hr><div align="center">1A Stoke Gardens, Slough, Berks, SL1 3QB - Tel: 01753 528173 - Fax: 01753 579743</div>';
        $footerE = $footer;

        if($res1cnt>0)
        {
            $created_date = date('Y-m-d H:i:s');
            $ins_array = array(
                'proid' => $proid,            
                'createdon' => $created_date,
                'createdby' => $this->session->userdata('userid')
            );
            $this->db->insert(PRJREPORT, $ins_array);
            $insert_id=$this->db->insert_id();

            $filesnames=array(
                1=>$proid.'_'.$insert_id.'__Commissioning-Air.pdf',
                2=>$proid.'_'.$insert_id.'__Commissioning-Water.pdf',
                3=>$proid.'_'.$insert_id.'__RPZ.pdf',
                4=>$proid.'_'.$insert_id.'__Time-Sheet.pdf',
                5=>$proid.'_'.$insert_id.'__Water-Treatment.pdf'
            );

            $res1data=$res1->result_array();            
            $processcategoryid=$res1data[0]['processcategoryid'];
            $processcatnewid=$res1data[0]['processcategoryid'];

            $mpdf=new mPDF('c','A4','','',25,25,35,15,10,10);
            $mpdf->SetHTMLHeader($header);
            $mpdf->SetHTMLHeader($headerE,'E');
            $mpdf->SetHTMLFooter($footer);
            $mpdf->SetHTMLFooter($footerE,'E');
            $mpdf->WriteHTML($result_syswit_header);


            foreach ($res1data as $rs_key => $plvalue) {

                $prcessid = $plvalue['id'];                                 
                $data['prcessid']=$prcessid;
                $data['title'] = $plvalue['processtitle'];
                $data['masterprcid'] = $plvalue['processid'];
                $data['processcatnewid'] = $processcatnewid;
                $data['mpdf']=$mpdf;
                $html_new='';
                if($plvalue['plslug']!='commAirSysSche')
                {
                    $html_new=$this->load->view('reports/'.$filctrl[$plvalue['processcategoryid']].'/'.$plvalue['plslug'],$data,true);                
                    $result_syswit[$plvalue['processcategoryid']].=$html_new;
                    //if($res1cnt!=($rs_key+1))                
                    if((isset($res1data[$rs_key+1]['processcategoryid'])))
                    {
                        if($processcategoryid==$res1data[$rs_key+1]['processcategoryid'])                    
                        {
                            $result_syswit[$plvalue['processcategoryid']].='<pagebreak />';                            
                            $html_new.='<pagebreak />';
                        }
                        $processcategoryid=$res1data[$rs_key+1]['processcategoryid'];
                    }

                    if($res1cnt!=($rs_key+1)) 
                    {
                        //$html_new.='<pagebreak />';
                    }

                    $mpdf->WriteHTML($html_new);

                }
                else
                {
                    
                    $title = $plvalue['processtitle'];
                    $masterprcid = $plvalue['processid'];

                    include(DROOT.'/application/views/reports/'.$filctrl[$plvalue['processcategoryid']].'/'.$plvalue['plslug'].'.php'); 
                    /*if($res1cnt!=($rs_key+1)) 
                    {
                        //$mpdf->WriteHTML('<pagebreak />');
                    } */

                    if((isset($res1data[$rs_key+1]['processcategoryid'])))
                    {
                        if($processcategoryid==$res1data[$rs_key+1]['processcategoryid'])                    
                        {
                            $mpdf->WriteHTML('<pagebreak />');
                        }
                        $processcategoryid=$res1data[$rs_key+1]['processcategoryid'];
                    }                  
                }

                if($res1cnt==($rs_key+1)) 
                {
                    $mpdf->Output(PDFPATH.'/'.$filesnames[$processcatnewid],'F');
                    $processcatnewid=$res1data[$rs_key+1]['processcategoryid'];                   
                }

                if((isset($res1data[$rs_key+1]['processcategoryid'])))
                {
                    if($processcatnewid!=$res1data[$rs_key+1]['processcategoryid'])                    
                    {
                        $mpdf->Output(PDFPATH.'/'.$filesnames[$processcatnewid],'F');
                        $processcatnewid=$res1data[$rs_key+1]['processcategoryid'];

                        $mpdf=new mPDF('c','A4','','',25,25,35,15,10,10);
                        $mpdf->SetHTMLHeader($header);
                        $mpdf->SetHTMLHeader($headerE,'E');
                        $mpdf->SetHTMLFooter($footer);
                        $mpdf->SetHTMLFooter($footerE,'E');
                        $mpdf->WriteHTML($result_syswit_header);
                    }
                }

            }
        }

        $this->session->set_flashdata('project_message', 'Report has been created successfully...');
        $path = base_url('reports/projview/'.$proid_id);
        redirect($path);

    }
	
	 public function editsystems()
    {   
     //echo '<pre>';print_r($_POST);die;
        //$this->exitpage();
        $data=array();
        $proid_new = $this->uri->segment(3);
        $proid = $this->Common_model->decodeid($this->uri->segment(3));
        $projid=$proid;

        if ($this->input->post('cancel'))
        {
            //$path = base_url('reports/'.$this->uri->segment(2).'/'.$proidnew);
			$path = base_url('reports');
            redirect($path);
        }
        if ($this->input->post('submit'))
        {
            /*$this->form_validation->set_rules('projectname', 'Project Number', 'trim|required');
            $this->form_validation->set_rules('sitename', 'Site name', 'trim|required');
            $this->form_validation->set_rules('sitecontactname', 'Contact name', 'trim|required');
            $this->form_validation->set_rules('userincharge', 'Customer Name', 'trim|required');
            $this->form_validation->set_rules('assign_users[]', 'Assign Users', 'trim|required');
            $this->form_validation->set_rules('projectdescription', 'Project Description', 'trim|required');
            $this->form_validation->set_rules('status', 'Is acive', 'trim|required');*/

            $systemname_ck = $this->input->post('systemname');
            if(!empty($systemname_ck))
            {
                foreach($systemname_ck as $id => $data_ck)
                {
                    $this->form_validation->set_rules('systemname[' . $id . ']', 'System Name', 'required|trim');
                    $this->form_validation->set_rules('companyname[' . $id . ']', 'Company Name', 'required|trim');
                   // $this->form_validation->set_rules('companyaddress[' . $id . ']', 'Company Address', 'required|trim');
                    $this->form_validation->set_rules('contractorname[' . $id . ']', 'Services Contractor Name', 'required|trim');
                    //$this->form_validation->set_rules('contractoraddress[' . $id . ']', 'Services Contractor Address', 'required|trim');
                    $this->form_validation->set_rules('witnessedny[' . $id . ']', 'Witnessed By', 'required|trim');
                    $this->form_validation->set_rules('witnesseddate[' . $id . ']', 'Date', 'required|trim');
                    $this->form_validation->set_rules('testcmpby[' . $id . ']', 'Test Completed By', 'required|trim');
                    $this->form_validation->set_rules('testcmpdate[' . $id . ']', 'Date', 'required|trim');
                }
            }

            
            if ($this->form_validation->run() == TRUE)
            {
                /*$created_date = date('Y-m-d H:i:s');

                $upd_array = array(
                    'projectname' => $this->input->post('projectname'),
                    'projectstartdate' => date('Y-m-d',strtotime($this->input->post('projectstartdate'))),
                    'siteid' => $this->input->post('sitename'),
                    'contactid' => $this->input->post('sitecontactname'),
                    'userincharge' => $this->input->post('userincharge'),
                    'projectdescription' => $this->input->post('projectdescription'),
                    'isactive' => $this->input->post('status'),
                    'lastmodifiedon' => $created_date,
                    'lastmodifiedby' => $this->session->userdata('userid')
                );
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
                }*/
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
                            /*'servicecontractoraddress'=>$_POST['contractoraddress'][$sys_key],*/
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
                            $new_system_id = $this->db->insert_id();
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


                $this->session->set_flashdata('success_message', 'The System has been updated successfully...');
                $url_choice = $this->input->post('url_choice');
                if($new_system_id ){
                    
                    if( $url_choice=='true' ){
                        $this->session->set_userdata('system_value', $new_system_id);
                        $projid = $this->Common_model->encodeid($projid);
                        $path = base_url('projects/projview/'.$projid.'/'.$new_system_id);
                    redirect($path);
                    }
                    else{
                         $path = base_url('reports') ;
                        redirect($path);
                    }                
                }
                else
                {
                    if( $url_choice=='true' ){
                        $this->session->set_userdata('system_value', $_POST['systemid'][0]);
                        $projid = $this->Common_model->encodeid($projid);
                        //$system_id = $this->Common_model->encodeid($_POST['systemid'][0]);
                        $system_id = $_POST['systemid'][0];
                        $path = base_url('projects/projview/'.$projid.'/'.$system_id);
                    redirect($path);
                    }
                    else{
                         $path = base_url('reports') ;
                        redirect($path);
                    }
                }
                $path = base_url('reports') ;
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
                        /*'servicecontractoraddress'=>'',*/
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
                        //'companyaddress'=>$_POST['companyaddress'][$sys_key],
                        'servicecontractorname'=>$_POST['contractorname'][$sys_key],
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
        $data['company_info'] = $this->MProject->getCompanyDetails();
        $data['title'] = 'Edit System';
		$data['customername'] =  urldecode($this->uri->segment(4));

        //$data['sidemenu'] = 'hide';
        $this->load->view('common/header',$data);
        $this->load->view('reports/add',$data);
        //echo '<pre>';print_r($data['projdata']);die;
        $this->load->view('common/footer');
    }
	
    public function reptdownload()
    {
        $this->exitpage();
        
        $repid=($this->uri->segment(3));
        $proid=($this->uri->segment(4));


        $proid=intval($this->Common_model->decodeid($proid));
        $repid=intval($this->Common_model->decodeid($repid));

        /*$processCatAll=$this->MReports->getProcessCatAll();
        $processCatAllcnt=$processCatAll->num_rows();
        if($processCatAllcnt>0)
        {
            $processCatAll_data=$processCatAll->result_array();            
            foreach ($processCatAll_data as $prz_key => $prz_value) {

            }
        }*/
        

        //$files = array(PDFPATH.$proid.'_'.$repid.'__Commissioning-Air.pdf');
        $files = array(
            $proid.'_'.$repid.'__Commissioning-Air.pdf',
            $proid.'_'.$repid.'__Commissioning-Water.pdf',
            $proid.'_'.$repid.'__RPZ.pdf',
            $proid.'_'.$repid.'__Time-Sheet.pdf',
            $proid.'_'.$repid.'__Water-Treatment.pdf'
        );
        
        $zip = new ZipArchive();

        # create a temp file & open it
        $tmp_file = tempnam('.','');
        $zip->open($tmp_file, ZipArchive::CREATE);

        # loop through each file
        foreach($files as $file){            
            if(file_exists(PDFPATH.$file)){
                //$download_file = file_get_contents($file);
                //$zip->addFromString(basename($file),$download_file);
                $zip->addFile(PDFPATH.$file,$file);
            }

        }
        # close zip
        $zip->close();
        # send the file to the browser as a download
        header('Content-disposition: attachment; filename='.time().'.zip');
        header('Content-type: application/zip');
        readfile($tmp_file);
        //sleep(30);
        unlink($tmp_file);
    }
}
