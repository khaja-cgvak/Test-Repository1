<?php

class Reports_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }
    public function getSystemsbyid($projid=0,$id=0)
    {
        $this->db->select('*');
        $this->db->where('projectid',$projid);
        $this->db->where('id',$id);
        $data=$this->db->get(PRJSYS);
        return $data->result_array();
    }  
    public function displaySheetNumText($table='',$sheetnumber=1,$processid=0)
    {
        
        $seg1=$this->uri->segment(1); // page controller
        $seg2=$this->uri->segment(2); // controller action
        $seg3=intval($this->Common_model->decodeid($this->uri->segment(3))); // project id
        $seg4=intval($this->Common_model->decodeid($this->uri->segment(4))); // Current sheet page number

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

        $link1=($sheetnumber);
        $link2=($cntable1);
        
        return '<strong>Sheet:</strong>&nbsp;'.$link1.' of '.$link2;
    }  
    public function getProcessCatAll()
    {
        $this->db->select('*');
        $this->db->order_by('processcategory','ASC');
        $data=$this->db->get(PROCESS);
        return $data;
    }
    public function getUserByid($id=0)
    {
        $this->db->select('*');
        if($id!=0)
        {
            $this->db->where('userid',$id);
        }
        $this->db->where('isactive',1);
        $this->db->where('isdeleted','I');
        $this->db->order_by('firstname','ASC');
        $this->db->order_by('lastname','ASC');
        $data=$this->db->get(USER);
        return $data;        
    }
}
