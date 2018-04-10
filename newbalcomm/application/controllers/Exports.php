<?php
error_reporting(0);
defined('BASEPATH') OR exit('No direct script access allowed');
class Exports extends CI_Controller {

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
        $data['title'] = 'Project List';
        $this->load->view('common/header');
        $this->load->view('exports/project-list',$data);
        $this->load->view('common/footer');
    }
	public function getallProjects()
	{
        $table = PROJECTS;
         
        // Table's primary key
        $primaryKey = 'id';

        $roleid=$this->session->userdata('userroleid');
        $segarrval='exports/projview';
        $ckpermission=$this->Common_model->ckRolePermission($roleid,$segarrval);
        define('rptview',$ckpermission);

        $columns = array(
            array( 'db' => 'p.projectnumber', 'dt' => 0, 'field' => 'projectnumber','formatter'=>function($d,$row){
				$enid=$this->Common_model->encodeid($row['id']);
                return '<a href="'.site_url('exports/projview/'.$enid).'">'.$d.'</a>';
            }),          
            array( 'db' => 'p.projectstartdate',  'dt' => 1, 'field' => 'projectstartdate','formatter' => function( $d, $row ) { return date('d M Y',strtotime($d));}),
            /*array( 'db' => 'p.projectenddate',  'dt' => 2, 'field' => 'projectenddate','formatter' => function( $d, $row ) { return date('d M Y',strtotime($d));}),*/
            array( 'db' => 'p.projectdescription',  'dt' => 2, 'field' => 'projectdescription'),
            array( 'db' => 'u.custname',  'dt' => 3, 'field' => 'custname'),
            //array( 'db' => 'p.projectstatus',  'dt' => 5, 'field' => 'projectstatus'),            
            array( 'db' => 'p.id',   'dt' => 4, 'field' => 'id','formatter' => function( $d, $row ) {
                    $action='<div class="icon_list">';
                    $enid=$this->Common_model->encodeid($d);
                    if(rptview==true)
                    {
                        $action.='<a href="'.site_url('exports/projview/'.$enid).'"  data-toggle="tooltip"  title="Report List"><i class="fa fa-cog" aria-hidden="true"></i></a>';
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
        $extraWhere = " p.isdeleted='N' and p.isactive='1' ";        
        $searchval=$_REQUEST['search']['value'];       
        $extraWhere_add=' AND ';
        echo json_encode(
            SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere,'',$extraWhere_add )
        );
	}
    public function projview()
    {
        //$this->exitpage();
        $data = array();        
        $proid_new = $this->uri->segment(3);
        $proid=intval($this->Common_model->decodeid($proid_new));
        $projdata=$this->Common_model->getProductById($proid);
        $data['projdata']=$projdata;
        $data['title'] = $projdata['projectname'].' - Report List';
        $data['proid']=$proid_new;
        $this->load->view('common/header');
        $this->load->view('exports/repot-list',$data);
        $this->load->view('common/footer');
    }
    public function getallPrjReports()
    {
        $table = PROJECTS;
        $proid = intval($this->Common_model->decodeid($this->uri->segment(3)));
         
        // Table's primary key
        $primaryKey = 'id';

        $roleid=$this->session->userdata('userroleid');
        $segarrval='exports/reptdownload';
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
                        $action.='<a href="'.site_url('exports/reptdownload/'.$enid.'/'.$newproid).'"  data-toggle="tooltip"  title="Download Report"><i class="fa fa-download" aria-hidden="true"></i></a>';
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
        include_once(DROOT."/assets/mpdf/mpdf.php");
        
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
            $mpdf->debug=false;
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
                    $html_new=$this->load->view('exports/'.$filctrl[$plvalue['processcategoryid']].'/'.$plvalue['plslug'],$data,true);                
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

                    //echo DROOT.'/application/views/exports/'.$filctrl[$plvalue['processcategoryid']].'/'.$plvalue['plslug'].'.php<br>';

                    include(DROOT.'/application/views/exports/'.$filctrl[$plvalue['processcategoryid']].'/'.$plvalue['plslug'].'.php'); 
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
                        $mpdf->debug=false;
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
        $path = base_url('exports/projview/'.$proid_id);
        redirect($path);

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
