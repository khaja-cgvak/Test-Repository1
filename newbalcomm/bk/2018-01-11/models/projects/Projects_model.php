<?php

class Projects_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getCAsysscheme($id=0)
    {
        $this->db->select('pl.*, csys.filename,csys.filestorename,csys.filetype,csys.filestoredpath');      
        $this->db->join(CASYSSCHE.' csys','csys.projectprocesslistmasterid=pl.id','','left');
        $this->db->where('pl.id',intval($id));
        $this->db->limit(1);
        $data=$this->db->get(PRJPRCLST.' pl');
        #echo $this->db->last_query();


        return $data->result_array();
    }
    public function getCAsysschemenew($id=0)
    {
        $this->db->select('pl.*');      
        //$this->db->join(CASYSSCHE.' csys','csys.projectprocesslistmasterid=pl.id','','left');
        $this->db->where('pl.id',intval($id));
        $this->db->limit(1);
        $data=$this->db->get(PRJPRCLST.' pl');
        #echo $this->db->last_query();


        return $data->result_array();
    }
    public function getCAsysWitness($id=0)
    {
        $this->db->select('pl.*, csys.projectsystemid,csys.witnessdate,csys.servicecontractdate'); 
        $this->db->select('ss.companyname,ss.servicecontractorname');
        $this->db->select('u1.firstname as u1fname,u1.lastname as u1lname,u2.firstname as u2fname,u2.lastname as u2lname');
        $this->db->join(CASYSCERT.' csys','csys.projectprocesslistmasterid=pl.id','','left');
        $this->db->join(PRJSYS.' ss','csys.projectsystemid=ss.id','','left');
        $this->db->join(USER.' u1','ss.witnessedby=u1.userid','left');
        $this->db->join(USER.' u2','ss.testedby=u2.userid','left');
        $this->db->where('pl.id',intval($id));
        $this->db->limit(1);
        $data=$this->db->get(PRJPRCLST.' pl');

       
        //$data=$this->db->get(PRJSYS.' ss');



    	return $data->result_array();
    }

    public function getCASyspreck($id=0)
    {

        //$this->db->select('pl.*, csys.projectprocesslistmasterid,csys.processsectioncategoryid,csys.processsectionid,csys.check,csys.comments as decomments');      
        $this->db->select('pl.*');      
        //$this->db->join(CAPRECKDETAILS.' csys','csys.projectprocesslistmasterid=pl.id','','left');
        $this->db->where('pl.id',intval($id));
        $this->db->limit(1);
        $data=$this->db->get(PRJPRCLST.' pl');
        #echo $this->db->last_query();
        return $data->result_array();
    	
    }
    public function getProcessMasterDetails($masterid=0,$sectionid=0,$limit=0)
    {
        $data=array();
        if(!empty($masterid)&&!empty($sectionid))
        {
            $this->db->select('*');
            $this->db->where('projectprocesslistmasterid',$masterid);
            $this->db->where('processsectionid',$sectionid);
            if($limit!=0)
            {
                $this->db->limit($limit);
            }
            $data=$this->db->get(CAPRECKDETAILS);
        }

        return $data;
    }
    public function getCAFcuCkDetails($masterid=0,$sectionid=0,$limit=0)
    {
        $data=array();
        if(!empty($masterid)&&!empty($sectionid))
        {
            $this->db->select('*');
            $this->db->where('projectprocesslistmasterid',$masterid);
            $this->db->where('processsectionid',$sectionid);
            if($limit!=0)
            {
                $this->db->limit($limit);
            }
            $data=$this->db->get(CAFCUCKLST);
        }

        return $data;
    }
    public function getFanPrefDetails($masterid=0,$sectionid=0,$limit=0)
    {
    	$data=array();
    	if(!empty($masterid)&&!empty($sectionid))
    	{
    		$this->db->select('*');
    		$this->db->where('projectprocesslistmasterid',$masterid);
    		$this->db->where('processsectionid',$sectionid);
    		if($limit!=0)
    		{
    			$this->db->limit($limit);
    		}
    		$data=$this->db->get(CAFANPERFTEST);
    	}

    	return $data;
    }



    public function insertPrjSheetStatus($proid=0,$sheetid=0,$status='',$report=false)
    {

    	$data='';
    	if($proid!=0 && $sheetid!=0)
    	{
    		//PRJSHTSTS
    		$this->db->where('projectid',$proid);
    		$this->db->where('sheetid',$sheetid);
    		$sql1=$this->db->get(PRJSHTSTS);
    		if($sql1->num_rows()==0)
    		{
    			$ins_array = array(
    				'projectid'=>$proid,
    				'sheetid'=>$sheetid,
                    'status' => $status
                );
    			$this->db->insert(PRJSHTSTS,$ins_array);
    			$data='success';
    		}
    		else
    		{
    			$upd_array = array(
                    'status' => $status
                );
    			$this->db->where('projectid',$proid);
    			$this->db->where('sheetid',$sheetid);
    			$this->db->update(PRJSHTSTS,$upd_array);
    			$data='success';
    		}
    	}
    	return $data;
    }

    public function updatePrjSheetStatus($status=0,$sheetid=0,$report=false)
    {
    	$data='';
    	if($status!=0 && $sheetid!=0)
    	{
    		//PRJSHTSTS
    		$upd_array = array(
                'status' => $status
            );			
			$this->db->where('id',$sheetid);
			$this->db->update(PRJSHTSTS,$upd_array);
			$data='success';
    	}
    	return $data;

    }

    public function getPrjSheetStatus($proid=0,$sheetid=0)
    {
    	
    	$this->db->where('projectid',$proid);			
		$this->db->where('sheetid',$sheetid);
		$this->db->limit(1);
		$data=$this->db->get(PRJSHTSTS);
    	return $data->result_array();

    }

    public function getSystemDetailsAll($projid=0)
    {
        $this->db->select('*');
        $this->db->where('projectid',$projid);
        $this->db->where('isdelete','I');
        $data=$this->db->get(PRJSYS);
        return $data;
    }

    public function getUsers($roleid=0)
    {
        $this->db->select('*');
        if($roleid!=0)
        {
            $this->db->where('roleid',$roleid);
        }
        $this->db->where('isactive',1);
        $this->db->where('isdeleted','I');
        $this->db->order_by('firstname','ASC');
        $this->db->order_by('lastname','ASC');
        $data=$this->db->get(USER);
        return $data;        
    }
    public function getSystems($projid=0)
    {
        $this->db->select('*');
        $this->db->where('projectid',$projid);
        $this->db->where('isdelete','I');
        $data=$this->db->get(PRJSYS);
        return $data;
    }
    public function getPrjPrcLst($projid=0)
    {
        $this->db->select('*');
        $this->db->where('id',$projid);
        $this->db->order_by('sheetnumber', asc);
        $data=$this->db->get(PRJPRCLST);
        return $data->result_array();
    }
    public function getGrilleBaldata($projid=0)
    {
        $this->db->select('*');
        $this->db->where('projectprocesslistmasterid',$projid);
        $data=$this->db->get(CAGRILLBAL);
        return $data;
    }

    public function getGrilleBalMain($projid=0)
    {
        $this->db->select('*');
        $this->db->where('projectprocesslistmasterid',$projid);
        $data=$this->db->get(CAGRILL);
        return $data->result_array();
    }

    public function getDirGrilleBalMain($projid=0)
    {
        $this->db->select('*');
        $this->db->where('projectprocesslistmasterid',$projid);
        $data=$this->db->get(CADIRGRILLVLM);
        return $data->result_array();
    }

    public function getEngByPrjID($proid=0)
    {
        $this->db->select('u.*');
        $this->db->join(PROJURS.' pu','pu.userid=u.userid','left');
        $this->db->where('pu.projid',$proid);
        $this->db->where('u.isactive',1);
        $this->db->where('u.isdeleted','I');
        $this->db->order_by('u.firstname','ASC');
        $this->db->order_by('u.lastname','ASC');
        $data=$this->db->get(USER.' u');
        $sql =$this->db->last_query();
        return $data->result_array();
    }



    public function getPlotRcdMsddata($projid=0)
    {
        $this->db->select('*');
        $this->db->where('projectprocesslistmasterid',$projid);
        $data=$this->db->get(CAPTMSDGN);
        return $data;
    }
    public function getPlotRcdDsndata($projid=0)
    {
        $this->db->select('*');
        $this->db->where('projectprocesslistmasterid',$projid);
        $data=$this->db->get(CAPTVLMDGN);
        return $data;
    }
    public function getDirGrilleBaldata($projid=0)
    {
        $this->db->select('*');
        $this->db->where('projectprocesslistmasterid',$projid);
        $data=$this->db->get(CADIRGRILL);
        return $data;
    }
    public function getVlmCtrldata($projid=0)
    {
        $this->db->select('*');
        $this->db->where('projectprocesslistmasterid',$projid);
        $data=$this->db->get(CAAIRCTRL);
        return $data;
    }
    public function getVlmCtrlBoxdata($projid=0)
    {
        $this->db->select('*');
        $this->db->where('projectprocesslistmasterid',$projid);
        $data=$this->db->get(CACONSCTRL);
        return $data;
    }

    public function getProcessTitle($projid=0)
    {
        $this->db->select('processtitle');
        $this->db->where('id',$projid);
        $data=$this->db->get(PROCESSLST)->result_array();
        return $data;
    }


    public function getSysDrpData($id=0)
    {
        $this->db->select('ss.*,u1.firstname as u1fname,u1.lastname as u1lname,u2.firstname as u2fname,u2.lastname as u2lname');
        $this->db->join(USER.' u1','ss.witnessedby=u1.userid','left');
        $this->db->join(USER.' u2','ss.testedby=u2.userid','left');
        $this->db->where('ss.id',intval($id));
        $data=$this->db->get(PRJSYS.' ss');

        $datas=$data->result_array();

        $result=array(
            "datacnt"=>$data->num_rows(),
            "datas"=>array(
                "witnessby"     =>  $datas[0]['u1fname'].' '.$datas[0]['u1lname'],
                "witnessid"     =>  $datas[0]['witnessedby'],
                "witnessdate"   =>  date(DT_FORMAT,strtotime($datas[0]['witnesseddate'])),
                "company"       =>  $datas[0]['companyname'],
                "testedby"      =>  $datas[0]['u2fname'].' '.$datas[0]['u2lname'],
                "testedid"      =>  $datas[0]['testedby'],
                "testedate"     =>  date(DT_FORMAT,strtotime($datas[0]['testedDate'])),
                "contractor"    =>  $datas[0]['servicecontractorname']
            )
        );

        echo json_encode($result);
    }

    public function getcareportsheet($id=null)
    {
        
        $this->db->select('pl.*,csys.reportdescription'); 
        $this->db->from('projectprocesslistmaster pl');   
        $this->db->join('ca_report_sheet csys','csys.projectprocesslistmasterid = pl.id','','left');
         
       $this->db->where('pl.id',$id);  
       // $this->db->limit(1);
        $data=$this->db->get(); 
        return $data->result_array();
    }

    public function getSystemPrjck($sysid=0)
    {
        $this->db->select('pl.*');        
        $this->db->join(PROJECTS.' p','p.id=pl.projectid','left');
        $this->db->where('p.isdeleted','N');
        $this->db->where('pl.system',intval($sysid));
        $data=$this->db->get(PRJPRCLST.' pl');
        return $data;
    }

    /*** cw functions ***/

    public function getcwreportsheet($id=null)
    {
        
        $this->db->select('pl.*,csys.reportdescription'); 
        $this->db->from('projectprocesslistmaster pl');   
        $this->db->join('cw_report_sheet csys','csys.projectprocesslistmasterid = pl.id','','left');
         
       $this->db->where('pl.id',$id);  
       // $this->db->limit(1);
        $data=$this->db->get(); 
        return $data->result_array();
    }

     public function getCWsysscheme($id=0)
    {
        $this->db->select('pl.*, csys.filename,csys.filestorename,csys.filetype,csys.filestoredpath');      
        $this->db->join(CWSYSSCHE.' csys','csys.projectprocesslistmasterid=pl.id','','left');
        $this->db->where('pl.id',intval($id));
        $this->db->limit(1);
        $data=$this->db->get(PRJPRCLST.' pl');
        #echo $this->db->last_query();


        return $data->result_array();
    }

    public function getCWsyscertificate($id=0)
    {
        
        $this->db->select('pl.*, csys.projectsystemid,csys.witnessdate,csys.servicecontractdate'); 
        $this->db->select('ss.companyname,ss.servicecontractorname');
        $this->db->select('u1.firstname as u1fname,u1.lastname as u1lname,u2.firstname as u2fname,u2.lastname as u2lname');
        $this->db->join(CWSYSWTCRT.' csys','csys.projectprocesslistmasterid=pl.id','','left');
        $this->db->join(PRJSYS.' ss','csys.projectsystemid=ss.id','','left');
        $this->db->join(USER.' u1','ss.witnessedby=u1.userid','left');
        $this->db->join(USER.' u2','ss.testedby=u2.userid','left');
        $this->db->where('pl.id',intval($id));
        $this->db->limit(1);
        $data=$this->db->get(PRJPRCLST.' pl');

        return $data->result_array();
    }

    public function getCWSyspreck($id=0)
    {

        //$this->db->select('pl.*, csys.projectprocesslistmasterid,csys.processsectioncategoryid,csys.processsectionid,csys.check,csys.comments as decomments');      
        $this->db->select('pl.*');      
        //$this->db->join(CAPRECKDETAILS.' csys','csys.projectprocesslistmasterid=pl.id','','left');
        $this->db->where('pl.id',intval($id));
        $this->db->limit(1);
        $data=$this->db->get(PRJPRCLST.' pl');
        #echo $this->db->last_query();
        return $data->result_array();
        
    }

    public function getcwProcessMasterDetails($masterid=0,$sectionid=0,$limit=0)
    {
        $data=array();
        if(!empty($masterid)&&!empty($sectionid))
        {
            $this->db->select('*');
            $this->db->where('projectprocesslistmasterid',$masterid);
            $this->db->where('processsectionid',$sectionid);
            if($limit!=0)
            {
                $this->db->limit($limit);
            }
            $data=$this->db->get(CWPRECKDETAILS);
        }

        return $data;
    }

    public function getPumpPrefDetails($masterid=0,$sectionid=0,$limit=0)
    {
        $data=array();
        if(!empty($masterid)&&!empty($sectionid))
        {
            $this->db->select('*');
            $this->db->where('projectprocesslistmasterid',$masterid);
            $this->db->where('processsectionid',$sectionid);
            if($limit!=0)
            {
                $this->db->limit($limit);
            }
            $data=$this->db->get(CWPUMPTEST);
        }

        return $data;
    }

    public function getcwWaterDistTstdata($projid=0)
    {
        $this->db->select('*');
        $this->db->where('projectprocesslistmasterid',$projid);
        $data=$this->db->get(CWWATERDISTST);
        return $data;
    }
    public function getcwWaterDistPicvdata($projid=0)
    {
        $this->db->select('*');
        $this->db->where('projectprocesslistmasterid',$projid);
        $data=$this->db->get(CWWATERDISTPICV);
        return $data;
    }
    public function getcwWaterHSWdata($projid=0)
    {
        $this->db->select('*');
        $this->db->where('projectprocesslistmasterid',$projid);
        $data=$this->db->get(CWHWSBLENDVLS);
        return $data;
    }
    public function getcwTimesheetMaster($projid=0)
    {
        $this->db->select('*');
        $this->db->where('projectprocesslistmasterid',$projid);
        $data=$this->db->get(CWTIMEMASTER);
        #echo $this->db->last_query();
        return $data;
    }
    public function getcwTimesheetData($projid=0)
    {
        $this->db->select('*');
        $this->db->where('projectprocesslistmasterid',$projid);
        $this->db->order_by('dayid','ASC');
        $this->db->group_by('dayid');
        $data=$this->db->get(CWTIMEDATA);
        return $data;
    }

    public function getWTsyscertificate($id=0)
    {
        
        $this->db->select('pl.*, csys.projectsystemid,csys.witnessdate,csys.servicecontractdate'); 
        $this->db->select('ss.companyname,ss.servicecontractorname');
        $this->db->select('u1.firstname as u1fname,u1.lastname as u1lname,u2.firstname as u2fname,u2.lastname as u2lname');
        $this->db->join(WTSYSCERT.' csys','csys.projectprocesslistmasterid=pl.id','','left');
        $this->db->join(PRJSYS.' ss','csys.projectsystemid=ss.id','','left');
        $this->db->join(USER.' u1','ss.witnessedby=u1.userid','left');
        $this->db->join(USER.' u2','ss.testedby=u2.userid','left');
        $this->db->where('pl.id',intval($id));
        $this->db->limit(1);
        $data=$this->db->get(PRJPRCLST.' pl');

        return $data->result_array();
    }
    public function getWTreportsheet($id=null)
    {
        
        $this->db->select('pl.*,csys.reportdescription'); 
        $this->db->from('projectprocesslistmaster pl');   
        $this->db->join(WTREPORTSHEET.' csys','csys.projectprocesslistmasterid = pl.id','','left');
         
       $this->db->where('pl.id',$id);  
       // $this->db->limit(1);
        $data=$this->db->get(''); 
        return $data->result_array();
    }
    public function getWTflushvelosdata($projid=0)
    {
        $this->db->select('*');
        $this->db->where('projectprocesslistmasterid',$projid);
        $data=$this->db->get(WTFLUSHVELO);       
        return $data;
    }
    public function getWTcheckList($projid=0)
    {
        $this->db->select('*');
        $this->db->where('projectprocesslistmasterid',$projid);
        $data=$this->db->get(WTCHKLST);       
        return $data;
    }
    public function getWTchkLstData($projid=0,$sectid=0)
    {
        $this->db->select('*');
        $this->db->where('projectprocesslistmasterid',$projid);
        $this->db->where('sectid',$sectid);
        $data=$this->db->get(WTCHKLSTDATA);       
        return $data;
    }

    /* ========================= RPZ ========================== */

    public function insertRPZsection($tablename='',$insertarray=array())
    {
        $insertid=0;
        if(!empty($tablename)&&!empty($insertarray))
        {
            $this->db->insert($tablename,$insertarray);            
            $insertid=$this->db->insert_id();
        }
        return $insertid;
    }
    public function updateRPZsection($tablename='',$updatearray=array(),$updatekey='projectprocesslistmasterid',$updatekeyval='')
    {
        $insertid=0;
        if(!empty($tablename)&&!empty($updatearray)&&!empty($updatekey)&&!empty($updatekeyval))
        {
            $this->db->where($updatekey,$updatekeyval);
            $this->db->update($tablename,$updatearray);
        }
        return $insertid;
    }

    public function getPRZsection($tablename='',$prcessid=0)
    {   
        $data=array(); 
        if(!empty($tablename)&&!empty($prcessid))
        {
            $this->db->select('*');
            $this->db->where('projectprocesslistmasterid',$prcessid);
            $ress=$this->db->get($tablename);
            if($ress->num_rows()>0)
            {
                $result=$ress->result_array();
                $data=$result[0];
            }
        }
        return $data;
    }
    public function getWTtempCettificate($id=0)
    {
        $this->db->select('*');         
        
        $this->db->join(WTTEMPCERT.' csys','csys.projectprocesslistmasterid=pl.id','','left');
        $this->db->where('pl.id',intval($id));
        $this->db->limit(1);
        $data=$this->db->get(PRJPRCLST.' pl');

        return $data->result_array();

        /*$this->db->select('*');
        $this->db->where('projectprocesslistmasterid',$prcessid);
        $ress=$this->db->get(WTTEMPCERT);        
        return $ress->result_array();*/
    }
    public function getProcessMaster($projectid=0,$processid=0)
    {
        $this->db->select('*');
        $this->db->where('projectid',$projectid);
        $this->db->where('processid',$processid);
        $ress=$this->db->get(PRJPRCLST);                
        return $ress;
    }
    public function getMainChlorin($prcessid=0)
    {
        $this->db->select('*');
        $this->db->where('projectprocesslistmasterid',$prcessid);
        $ress=$this->db->get(WTCHLORINCERT);                
        return $ress->result_array();
    }

    public function getsysFilesPrzid($prcessid=0,$tablename='')
    {
        $this->db->select('*');
        $this->db->where('projectprocesslistmasterid',$prcessid);
        $this->db->where('projectprocesslistmasterid <>',0);
        $this->db->where('isdeleted','I');
        $ress=$this->db->get($tablename);          
        return $ress;
    }
    public function getsysFilesid($id=0,$tablename='')
    {
        $this->db->select('*');
        $this->db->where('id',$id);
        $this->db->where('id <>',0);
        $this->db->where('isdeleted','I');
        $ress=$this->db->get($tablename);                
        return $ress;
    }

    public function getSites($siteid=0,$custid=0)
    {
        $this->db->select('*');
        if(!empty($siteid))
        {
            $this->db->where('id',$siteid);
        }
        $this->db->where('custid',$custid);
        $ress=$this->db->get(CUSSITES);                
        return $ress;
    }
    public function getContactSites($siteid=0,$custid=0)
    {
        $this->db->select('cd.*');
        $this->db->join(CUSDETAILS. ' cd','cd.id=ccs.contid','left');
        $this->db->where('ccs.siteid',$siteid);
        $this->db->where('ccs.custid',$custid);
        $ress=$this->db->get(CUSCONSITE. ' ccs');                
        return $ress;
    }

    public function getCompanyDetails() {
        $this->db->select('companyname, address');
        $this->db->from(COMPANY);
        $data = $this->db->get()->row_array();
        return $data;

    }

    public function getlatestsheetid($processid=0,$table)
    {
        $seg3=intval($this->Common_model->decodeid($this->uri->segment(3))); // project id

        $this->db->select('*');
        $this->db->where('processid',$processid);
        $this->db->where('projectid',intval($seg3));
        $this->db->limit(1);
        $this->db->order_by('sheetnumber','desc');
        $data1=$this->db->get(PRJPRCLST);        
        $cntable1=$data1->num_rows();
        if(!empty($cntable1))
        {
            $datass=$data1->result();            
            #echo '<pre>'; print_r($datass); echo '</pre>';
            #echo '<br>';                        
            return $this->Common_model->encodeid($datass[0]->id);            
        }
        return false;

    }


    
}
