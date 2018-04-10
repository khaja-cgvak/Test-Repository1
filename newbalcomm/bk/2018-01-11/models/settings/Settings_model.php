<?php

class Settings_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getDrodownProcess()
    {
    	$sql="select t1.id,t2.id as subid,t1.ticketname as process,t2.ticketname as subprocess from `".PROCESS."` as t1 left outer join `".PROCESS."` as t2 on t2.parentid=t1.id where t1.parentid=0 order by t1.ticketname,t2.ticketname;";
    	$query=$this->db->query($sql);
    	return $query->result_array();
    }

    
}