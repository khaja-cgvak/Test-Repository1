<?php
class Login_model extends CI_Model
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
}
?>