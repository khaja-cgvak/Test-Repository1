<?php
class Home_model extends CI_Model
{
     public function __construct()
    {
        parent::__construct();
    }
    public function getProjectPrecentage($projectid=0)
    {

        /* === Total number of Project process === */                

        $processlist=$this->db->get(PROCESSLST);
        $processlistcnt=$processlist->num_rows();

        /* === Total number of Disabled Project process === */                

        $this->db->select('pl.id');
        $this->db->join(PRJSHTSTS.' ps','(ps.sheetid=pl.id and ps.projectid='.$projectid.')','left');
        $this->db->where('ps.status',0);
        //$this->db->where('ps.projectid',$projectid);
        $processdislist=$this->db->get(PROCESSLST.' pl');
        $processdislistcnt=$processdislist->num_rows();

        /* ============ Final attend sheet =========== */
        $processlisttotal=$processlistcnt-$processdislistcnt;

        /* === Total Numner of Completed Sheets === */

        $prolistmaster='';
        $this->db->select('pl.id');
        $this->db->join(PRJSHTSTS.' ps','(ps.sheetid=pl.processid and ps.projectid='.$projectid.')','left');
        $this->db->where('pl.projectid',$projectid);        
        $this->db->where('ps.status',1);
        $this->db->group_by('pl.processid');
        $prolistmaster=$this->db->get(PRJPRCLST.' pl');
        $prolistmastercnt=$prolistmaster->num_rows();

        return round((($prolistmastercnt/$processlisttotal)*100),2);

    }

}
?>