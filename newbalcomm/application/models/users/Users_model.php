<?php
class Users_model extends CI_Model
{
     public function __construct()
    {
        parent::__construct();
    }

    //Get Login Details
    public function login($username, $password)
    {
        $this->db->select('*');
        $this->db->where('displayname', $username);
        $this->db->where('password', md5($password));
        $this->db->where('isactive', 1);
        $this->db->from(USER);

        $query = $this->db->get();
        $result = $query->row_array();
        return $result;
    }
    
    //Get all users List
    public function getallusers()
    {
        $this->db->select('A.*,B.rolesname');
        $this->db->from('users as A');
        $this->db->join('roles as B','A.roleid = B.roleid');
        $this->db->order_by("A.firstname", "asc");
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }        
    
    //get user data
    function getusersdata($userid)
    {
        $this->db->select('*');
        $this->db->where('userid', $userid);
        $this->db->from(USER);

        $query = $this->db->get();
        $result = $query->row_array();
        return $result;
    }
    
    //Check Email Exist
    function checkemailexist($email,$existid)
    {
        $n = 0;
        $this->db->select('*');
        if($existid !=''){
             $this->db->where('userid !=', $existid);
        } 
        $this->db->where('emailid', $email);
        $this->db->where('isdeleted', 'I');
        $this->db->from(USER);
        $query = $this->db->get();
        if($query->num_rows() >0){
             $n = 1;
        }
        return $n;
    }
    
     //Check Email Exist
    function checkuserexist($username,$existid)
    {
        $n = 0;
        $this->db->select('*');
        if($existid !=''){
             $this->db->where('userid !=', $existid);
        } 
        $this->db->where('displayname', $username);
        $this->db->where('isdeleted', 'I');
        $this->db->from(USER);
        $query = $this->db->get();
        if($query->num_rows() >0){
             $n = 1;
        }
        return $n;
    }


    
    
    //Get All user roles
    function getallusersroles()
    {
        $this->db->select('*');
        $this->db->where('isactive', 1);
        $this->db->where('isdeleted', 'I');
        $this->db->from(USERROLE);

        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }
    
    //check machine refered
    function checkuserrefered($userid)
    {
        $id = 0;
        $query =  $this->db->query("select * from millingsheetheader where millingtoolcreatedby = '$userid'");
        if($query->num_rows() > 0){
            $id = 1;
        }
        return $id; 
    }
    
    
    //check valid useremail
    function checkvalidemail($useremailid)
    {
        $id = 0;
        $this->db->select('*');
        $this->db->from(USER);
        $this->db->where('isactive', 1);
        $this->db->where('emailid', $useremailid);
        $query = $this->db->get();
        
        if($query->num_rows() > 0){
            $id = 1;
        }
        return $id; 
    }
    
    //get user detail
    function getemaildetails($email)
    {
        $this->db->select('*');
        $this->db->from(USER);
        $this->db->where('emailid', $email);
        
        $query = $this->db->get();
        $result = $query->row_array();
        return $result;
    }
    //get company details
    function getcompanydetails()
    {
        $this->db->select('*');
        $this->db->from('settings');
        
        $query = $this->db->get();
        $result = $query->row_array();
        return $result;
    }
}
?>