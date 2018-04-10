<?php

class UserRoles_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    //Get all roles List
    public function getrolesdata()
    {
        $this->db->select('*');
        $this->db->from(USERROLE);
        $this->db->order_by("rolesname", "asc");
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }        
    
    //Get roles data
    public function getroles($id)
    {
        $this->db->select('*');
        $this->db->from(USERROLE);
        $this->db->where('roleid',$id); 
        $query = $this->db->get();
        $result = $query->row_array();
        return $result;
    }
    
    //check user role id used
    function checkrolesid($roleid)
    {
        $id = 0;
        $this->db->select('*');
        $this->db->where('roleid', $roleid);
        $this->db->from('users');

        $query = $this->db->get();
        if($query->num_rows() > 0){
            $id = 1;
        }
        return $id; 
    }
    
    //Get all privileges data
    function getpriviledgedata()
    {
        $this->db->select('*');
        $this->db->from('privileges');
        $this->db->where('isactive',1); 
        $this->db->order_by("privilegedescription", "asc");
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
   }
    
   //check user privilege exist or not
   function checkprivilegeexist($privilegeid,$roleid)
   {
        $id = 0;
        $this->db->select('*');
        $this->db->where('roleid', $roleid);
        $this->db->where('privilegeid', $privilegeid);
        $this->db->from('rolesprivileges');

        $query = $this->db->get();
        if($query->num_rows() > 0){
            $id = 1;
        }
        return $id; 
    }
   
   ///get all roles priviledge data
   function getrolespriviledgedata($rolesid)
   {
        $this->db->select('A.privilegedescription,B.*');
        $this->db->from('privileges as A');
        $this->db->join('rolesprivileges as B','A.privilegeid = B.privilegeid', 'left');
        $this->db->where('B.roleid', $rolesid);
        $query = $this->db->get();
        $result = $query->result_array();
        
        return $result;
   } 
   
   //check user status exist
   function checkstatusexist($existid)
   {
        $id = 0;
        $this->db->select('*');
        $this->db->where('roleid', $existid);
        $this->db->from('users');

        $query = $this->db->get();
        if($query->num_rows() > 0){
            $id = 1;
        }
        return $id; 
   }
   
   //check role name exist
   function checkrolesnameexist($existid,$role)
   {
        $id = 0;
        $this->db->select('*');
        $this->db->where('roleid !=', $existid);
        $this->db->where('rolesname', $role);
        $this->db->where('isdeleted', 'I');
        $this->db->from(USERROLE);

        $query = $this->db->get();
        if($query->num_rows() > 0){
            $id = 1;
        }
        return $id; 
   }

   function checkAddrolesnameexist($existid,$role)
   {
        $id = 0;
        $this->db->select('*');
        $this->db->where('rolesname', $role);
        $this->db->where('isdeleted', 'I');
        $this->db->from(USERROLE);

        $query = $this->db->get();
        if($query->num_rows() > 0){
            $id = 1;
        }
        return $id; 
   }
   function getRolePermission($roleid=0,$optpageid=0)
   {
        $this->db->select('*');
        $this->db->where('roleid',$roleid);
        $this->db->where('optpageid',$optpageid);
        $data=$this->db->get(PRVPERMION);
        return $data;
   }
    
}