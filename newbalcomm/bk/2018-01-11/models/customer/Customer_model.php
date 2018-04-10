<?php
class Customer_model extends CI_Model
{
     public function __construct()
    {
        parent::__construct();
    }
	function getcustomerdata($id=0)
    {
        $this->db->select('*');
        $this->db->where('id', $id);
        $this->db->from(CUSTOMER);

        $query = $this->db->get();
        $result = $query->row_array();
        return $result;
    }
    function getContactDetailsAll($id=0)
	{
		$this->db->select('*');
        $this->db->where('custid', $id);
        $this->db->from(CUSDETAILS);
        $query = $this->db->get();
        return $query;
	}

}
?>