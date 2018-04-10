<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct(); 		
		$this->load->model('customer/Customer_model','Cmodel');
		

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
		$this->load->view('common/header');
		$this->load->view('customer/list');
		$this->load->view('common/footer');
	}
	public function getallCustomers()
		{
		
		$table = CUSTOMER;
		 
		// Table's primary key
		$primaryKey = 'id';
		 
		// Array of database columns which should be read and sent back to DataTables.
		// The `db` parameter represents the column name in the database, while the `dt`
		// parameter represents the DataTables column identifier. In this case simple
		// indexes

		/*$extraWhere = " addressLine2 like '%".$searchval."%' ";
		$extraWhere .= " OR city like '%".$searchval."%' ";
		$extraWhere .= " OR state like '%".$searchval."%' ";
		$extraWhere .= " OR country like '%".$searchval."%' ";
		$extraWhere .= " OR zipcode like '%".$searchval."%' ";
		$extraWhere .= " OR phone like '%".$searchval."%' ";
		$extraWhere .= " OR fax like '%".$searchval."%' ";
		$extraWhere .= " OR mobile like '%".$searchval."%' ";
		$extraWhere .= " OR contactlastname like '%".$searchval."%' ";
		$extraWhere .= " OR contactdesignation like '%".$searchval."%' ";
		$extraWhere .= " OR contactphone like '%".$searchval."%' ";
		$extraWhere .= " OR contactmobile like '%".$searchval."%' ";
		$extraWhere .= " OR contactemailid like '%".$searchval."%' ";*/

		$roleid=$this->session->userdata('userroleid');
        $segarrval='customer/editcustomer';
        $ckpermission=$this->Common_model->ckRolePermission($roleid,$segarrval);
        define('cusedit',$ckpermission);
        $segarrval='customer/deletecustomer';
        $ckpermission=$this->Common_model->ckRolePermission($roleid,$segarrval);
        define('cusdle',$ckpermission);


		$columns = array(
			array( 'db' => 'custname', 'dt' => 0),			
			array( 'db' => 'addressLine1',  'dt' => 1),
			array( 'db' => 'addressLine2',  'dt' => 1),
			array( 'db' => 'city',  'dt' => 1),
			array( 'db' => 'state',  'dt' => 1),
			array( 'db' => 'country',  'dt' => 1),
			array( 'db' => 'zipcode',  'dt' => 1),
			array( 'db' => 'phone',  'dt' => 1),
			array( 'db' => 'fax',  'dt' => 1,'formatter' => function( $d, $row ) {
				$address_row="";
				$address_arr="";
                $address_arr=$row['addressLine1'];
				//print_r($address_arr);
				/*if(!empty($row['addressLine1']))
				{
					$address_arr[]=$row['addressLine1'];
					
				}
				if(!empty($row['addressLine2']))
				{
					$address_arr[]='<br>'.$row['addressLine2'];
				}
				if(!empty($row['city']))
				{
					$address_arr[]='<br>'.$row['city'];
				}
				if(!empty($row['state']))
				{
					$address_arr[]=$row['state'];
				}
				if(!empty($row['country']))
				{
					$address_arr[]='<br>'.$row['country'];
				}
				if(!empty($row['zipcode']))
				{
					$address_arr[]=$row['zipcode'];
				}				
				
				if(!empty($row['phone']))
				{
					$address_arr[]='<br><u>Phone:</u> '.$row['phone'];
				}
				if(!empty($row['fax']))
				{
					$address_arr[]='<br><u>Fax:</u> '.$row['fax'];
				}

				$address_row=implode(', ',$address_arr);
              			
				return $address_row;*/
			}),

			array( 'db' => 'emailid',   'dt' => 2 ),
			array( 'db' => 'website',   'dt' => 3 ),
			/*array( 'db' => 'contactfirstname',   'dt' => 4 ),
			array( 'db' => 'contactlastname',   'dt' => 4 ),
			array( 'db' => 'contactdesignation',   'dt' => 4 ),
			array( 'db' => 'contactphone',   'dt' => 4 ),
			array( 'db' => 'contactmobile',   'dt' => 4 ),
			array( 'db' => 'contactemailid',   'dt' => 4,'formatter' => function( $d, $row ) {
				$address_row="";
				$address_arr="";

				if(!empty($row['contactfirstname']))
				{
					$address_arr[]=$row['contactfirstname'].' '.$row['contactlastname'];
				}
				if(!empty($row['contactdesignation']))
				{
					$address_arr[]='<br><u>Designation:</u> '.$row['contactdesignation'];
				}
				if(!empty($row['contactphone']))
				{
					$address_arr[]='<br><u>Phone:</u> '.$row['contactphone'];
				}
				if(!empty($row['contactmobile']))
				{
					$address_arr[]='<br><u>Mobile:</u> '.$row['contactmobile'];
				}
				if(!empty($row['contactemailid']))
				{
					$address_arr[]='<br><u>Email:</u> '.$row['contactemailid'];
				}

				$address_row=implode(', ',$address_arr);
				
				return $address_row;
			}),*/

			array( 'db' => 'isactive',   'dt' => 4,'formatter' => function( $d, $row ) {
					return (($d==1)?'Active':'Inactive');
				}),
			array( 'db' => 'id',   'dt' => 5,'formatter' => function( $d, $row ) {
					$action='<div class="icon_list">';

					$enid=$this->Common_model->encodeid($d);

					$action.='<a href="'.site_url('customer/contactcustomer/'.$enid).'"  data-toggle="tooltip"  title="Customer Contact"><i class="fa fa-file-text-o" aria-hidden="true"></i></a>&nbsp;';

					$action.='<a href="'.site_url('customer/sitecustomer/'.$enid).'"  data-toggle="tooltip"  title="Customer Site"><i class="fa fa-sitemap" aria-hidden="true"></i></a>&nbsp;';

					if(cusedit==true)
					{
						$action.='<a href="'.site_url('customer/editcustomer/'.$enid).'"  data-toggle="tooltip"  title="Edit Customer"><i class="fa fa-pencil" aria-hidden="true"></i></a>&nbsp;';
					}
					if(cusdle==true)
					{
						$action.='<a href="javascript:void(0)" data-id="'.$d.'" class="delete_customer_acc" data-toggle="tooltip"  title="Delete Customer"><i class="fa fa-times" aria-hidden="true"></i></a>';
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
		
		
		 
		 
		/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
		 * If you just want to use the basic configuration for DataTables with PHP
		 * server-side, there is no need to edit below this line.
		 */
		 
		/*require( DROOT.'/assets/class/ssp.class.php' );
		 
		echo json_encode(
			SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns )
		);*/

		require( DROOT.'/assets/class/ssp.customized.class.php' );
		
		//$joinQuery = "FROM `".USER."` AS `u` JOIN `".USERROLE."` AS `ud` ON (`u`.`roleid` = `ud`.`roleid`)";
		//$extraWhere = "";

		$joinQuery = "";
		$searchval=$_REQUEST['search']['value'];
		$extraWhere = "";
		$extraWhere_add='OR';
		if(!empty($searchval))
		{
			$extraWhere = " addressLine2 like '%".$searchval."%' ";
			$extraWhere .= " OR city like '%".$searchval."%' ";
			$extraWhere .= " OR state like '%".$searchval."%' ";
			$extraWhere .= " OR country like '%".$searchval."%' ";
			$extraWhere .= " OR zipcode like '%".$searchval."%' ";
			$extraWhere .= " OR phone like '%".$searchval."%' ";
			$extraWhere .= " OR fax like '%".$searchval."%' ";
			$extraWhere .= " OR mobile like '%".$searchval."%' ";
			/*$extraWhere .= " OR contactlastname like '%".$searchval."%' ";
			$extraWhere .= " OR contactdesignation like '%".$searchval."%' ";
			$extraWhere .= " OR contactphone like '%".$searchval."%' ";
			$extraWhere .= " OR contactmobile like '%".$searchval."%' ";
			$extraWhere .= " OR contactemailid like '%".$searchval."%' ";*/			
		}

		#echo '<pre>'; print_r($_GET); echo '</pre>';
		 
		echo json_encode(
			SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere,'',$extraWhere_add )
		);
		
		
	}
	
	function addcustomer()
	{
		$this->exitpage();
        
        $data = array();
       

        if ($this->input->post('cancel'))
        {
            $path = base_url('customer');
            redirect($path);
        }
        if ($this->input->post('submit'))
        {
            
			// Customer Details

			$this->form_validation->set_rules('custname', 'Customer name', 'trim|required');
            $this->form_validation->set_rules('addressLine1', 'Address', 'trim|required');            
            $this->form_validation->set_rules('city', 'City', 'trim|required');
            $this->form_validation->set_rules('state', 'County', 'trim|required');
			$this->form_validation->set_rules('country', 'Country', 'trim|required');
            $this->form_validation->set_rules('zipcode', 'Postcode', 'trim|required');
			$this->form_validation->set_rules('phone', 'Phone', 'trim|required');
			$this->form_validation->set_rules('emailid', 'Email', 'trim|required|valid_email');
			//$this->form_validation->set_rules('website', 'Website', 'trim|required|callback_validurlformat');
			$this->form_validation->set_rules('status', 'Is acive', 'trim|required');
			//$this->form_validation->set_rules('csignature', 'Signature', 'trim|required');


            
            if ($this->form_validation->run() == TRUE)
            {
                $created_date = date('Y-m-d H:i:s');

                $ins_array = array(
                    'custname' => $this->input->post('custname'),
                    'addressLine1' => $this->input->post('addressLine1'),
                    'addressLine2' => $this->input->post('addressLine2'),
                    'city' => $this->input->post('city'),
                    'state' => $this->input->post('state'),
                    'country' => $this->input->post('country'),
                    'zipcode' => $this->input->post('zipcode'),
                    'phone' => ($this->input->post('phone')),
					'fax' => $this->input->post('fax'),
                    'mobile' => $this->input->post('mobile'),
                    'emailid' => $this->input->post('emailid'),
                    'website' => $this->input->post('website'),
                    'csignature' => ($this->input->post('csignature')),
                    'isactive' => $this->input->post('status'),
                    'createon' => $created_date,
                    'createdby' => $this->session->userdata('userid')
                );
                
                $custid=$this->db->insert(CUSTOMER, $ins_array);

                $custid=$this->db->insert_id();                
                

                $this->session->set_flashdata('success_message', 'New Customer has been created successfully...');
                $path = base_url('customer') ;
                redirect($path);
            }
        }


        $data['title'] = 'Add New Customer';  
		$this->load->view('common/header');		
        $this->load->view('customer/add',$data);
		$this->load->view('common/footer');
		
	}
	
	//Edit user
    public function editcustomer($userid)
    {
        $this->exitpage();
        $deuserid=$this->Common_model->decodeid($userid);
        
        $data = array();
       // $data['template'] = 'users/add';

        if ($this->input->post('cancel'))
        {
            $path = base_url('customer');
            redirect($path);
        }
        $data['userdata'] = $this->Cmodel->getcustomerdata($deuserid);

        if ($this->input->post('submit'))
        {
            
			// Customer Details

			$this->form_validation->set_rules('custname', 'Customer name', 'trim|required');
            $this->form_validation->set_rules('addressLine1', 'Address', 'trim|required');            
            $this->form_validation->set_rules('city', 'City', 'trim|required');
            $this->form_validation->set_rules('state', 'County', 'trim|required');
			$this->form_validation->set_rules('country', 'Country', 'trim|required');
            $this->form_validation->set_rules('zipcode', 'Postcode', 'trim|required');
			$this->form_validation->set_rules('phone', 'Phone', 'trim|required');
			$this->form_validation->set_rules('emailid', 'Email', 'trim|required|valid_email');
			//$this->form_validation->set_rules('website', 'Website', 'trim|required|callback_validurlformat');
			$this->form_validation->set_rules('status', 'Is acive', 'trim|required');
			//$this->form_validation->set_rules('csignature', 'Signature', 'trim|required');

			// Customer Contact


			

            if ($this->form_validation->run() == TRUE)
            {
            	$cuscontdel=$this->input->post('cuscontdel');
            	foreach ($cuscontdel as $del_key => $del_value) {
            		$this->db->where('id', intval($del_value));
            		$this->db->where('custid', $deuserid);            		
        			$this->db->delete(CUSDETAILS);
            	}
                $created_date = date('Y-m-d H:i:s');
                $existid = $this->Common_model->decodeid($this->input->post('existid'));

                $upd_array = array(
                    'custname' => $this->input->post('custname'),
                    'addressLine1' => $this->input->post('addressLine1'),
                    'addressLine2' => $this->input->post('addressLine2'),
                    'city' => $this->input->post('city'),
                    'state' => $this->input->post('state'),
                    'country' => $this->input->post('country'),
                    'zipcode' => $this->input->post('zipcode'),
                    'phone' => ($this->input->post('phone')),
					'fax' => $this->input->post('fax'),
                    'mobile' => $this->input->post('mobile'),
                    'emailid' => $this->input->post('emailid'),
                    'website' => $this->input->post('website'),
                    'csignature' => ($this->input->post('csignature')),
                    'isactive' => $this->input->post('status'),
                    'modifiedon' => $created_date,
                    'modifiedby' => $this->session->userdata('userid')
                );


                //echo $existid; exit;
                $this->db->where('id', $existid);
                $this->db->update(CUSTOMER, $upd_array);

                

                $this->session->set_flashdata('success_message', 'The Customer has been updated successfully...');
                $path = base_url('customer');
                redirect($path);
            }
        }


        $data['title'] = 'Edit Customer';

        //$this->load->vars($data);
        $this->load->view('common/header');		
        $this->load->view('customer/add',$data);
		$this->load->view('common/footer');
    }
    public function contactcustomer($userid)
    {
        //$this->exitpage();
        $deuserid=$this->Common_model->decodeid($userid);
        $data['title'] = 'Customer Contact';

        //$this->load->vars($data);
        $data['userid']=$userid;
        $this->load->view('common/header');		
        $this->load->view('customer/contactcustomer',$data);
		$this->load->view('common/footer');

    }
    
    //Delete User
    public function deletecustomer()
    {
        $this->exitpage();
        
        $userid = $this->uri->segment(3);

        // delete from users
        $this->db->where('id', $userid);
        $this->db->delete(CUSTOMER);

        $this->db->where('custid', $userid);
        $this->db->delete(CUSDETAILS);

        $this->session->set_flashdata('success_message', 'Customer has been deleted successfully...');
        $path = base_url('customer');
        redirect($path);
    }

    public function deletecutomercheck($return=false)
    {
        //check_user_permission(array(1)); // check user permission
        $userincharge = $this->uri->segment(3);
        
        $data='';
        $return=0;
        $this->db->select('*');
        $this->db->where('userincharge',$userincharge);
        //$this->db->where('isactive',1);
        $this->db->where('isdeleted','N');
        $data=$this->db->get(PROJECTS);  
        if($return==false)      
        {
            echo $data->num_rows();
        }
        else
        {
            return $data;
        }
    }   
    public function validurlformat(){
    	$str=$this->input->post('website');
        //$pattern = "|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i";
		$pattern = '/^(([\w]+:)?\/\/)?(([\d\w]|%[a-fA-f\d]{2,2})+(:([\d\w]|%[a-fA-f\d]{2,2})+)?@)?([\d\w]([-\d\w]{0,253}[\d\w])?\.)+[\w]{2,4}(:[\d]+)?(\/([-+_~.,\d\w]|%[a-fA-f\d]{2,2})*)*(\?(&?([-+_~.,\d\w]|%[a-fA-f\d]{2,2})=?)*)?(#([-+_~.,\/\d\w]|%[a-fA-f\d]{2,2})*)?$/';

        if (!preg_match($pattern, $str)){
            $this->form_validation->set_message('validurlformat', 'The URL you entered is not correctly formatted.');
            return FALSE;
        }
 
        return TRUE;
    } 

    public function getallCustomersContacts()
		{
		
		$table = CUSDETAILS;
		$userid=intval($this->Common_model->decodeid($this->uri->segment(3)));
		 
		// Table's primary key
		$primaryKey = 'id';


		$columns = array(
			array( 'db' => 'contactfirstname', 'dt' => 0),			
			array( 'db' => 'contactlastname',  'dt' => 1),
			array( 'db' => 'contactdesignation',   'dt' => 2 ),
			array( 'db' => 'contactphone',   'dt' => 3 ),
			array( 'db' => 'contactmobile',   'dt' => 4 ),
			array( 'db' => 'contactemailid',   'dt' => 5 ),
			array( 'db' => 'id',   'dt' => 6,'formatter' => function( $d, $row ) {
					$action='<div class="icon_list">';

					$enid=$this->Common_model->encodeid($d);

					//if(cusedit==true)
					{
						$action.='<a href="javascript:void(0);" data-id="'.$enid.'" class="editcuscontact"  data-toggle="tooltip"  title="Edit Customer"><i class="fa fa-pencil" aria-hidden="true"></i></a>&nbsp;';
					}
					//if(cusdle==true)
					{
						$action.='<a href="javascript:void(0);" data-id="'.$enid.'" class="delcuscontact" data-toggle="tooltip"  title="Delete Customer"><i class="fa fa-times" aria-hidden="true"></i></a>';
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
		
		//$joinQuery = "FROM `".USER."` AS `u` JOIN `".USERROLE."` AS `ud` ON (`u`.`roleid` = `ud`.`roleid`)";
		//$extraWhere = "";

		$joinQuery = "";
		$searchval=$_REQUEST['search']['value'];
		$extraWhere = " custid ='".$userid."'";
		$extraWhere_add=' and ';
		#echo '<pre>'; print_r($_GET); echo '</pre>';
		 
		echo json_encode(
			SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere,'',$extraWhere_add )
		);
		
		
	}

	function addeditcustomercont()
	{
		//$this->exitpage();	
		$data=array();	
		$custid=intval($this->Common_model->decodeid($this->uri->segment(3)));		
		if ($this->input->post())
        {
        	$this->form_validation->set_rules('contactfirstname', 'First name', 'trim|required');
            $this->form_validation->set_rules('contactlastname', 'Last name', 'trim|required');            
            $this->form_validation->set_rules('contactdesignation', 'Job Role', 'trim|required');
            $this->form_validation->set_rules('contactphone', 'Phone', 'trim|required');
			$this->form_validation->set_rules('contactemailid', 'Email', 'trim|required|valid_email');
		}

		if ($this->form_validation->run() == TRUE)
        {
        	$created_date = date('Y-m-d H:i:s');
        		$ins_sys_array= array(
                    'custid'=>$custid,
                    'contactfirstname'=>$this->input->post('contactfirstname'),
                    'contactlastname'=>$this->input->post('contactlastname'),
                    'contactdesignation'=>$this->input->post('contactdesignation'),
                    'contactphone'=>$this->input->post('contactphone'),
                    'contactmobile'=>$this->input->post('contactmobile'),
                    'contactemailid'=>$this->input->post('contactemailid')
                );

                $post_cusid=$this->input->post('custcontid');

        	if(empty($post_cusid))
        	{
        		$ins_sys_array['createdon'] = $created_date;
            	$ins_sys_array['createdby']= $this->session->userdata('userid');
                $this->db->insert(CUSDETAILS, $ins_sys_array);        		
        		$data=array('action'=>'success','actmsg'=>"Contact details has been added successfully.");
        	}
        	else
        	{
        		$ins_sys_array['modifiedon'] = $created_date;
            	$ins_sys_array['modifiedby']= $this->session->userdata('userid');
            	$contid=intval($this->Common_model->decodeid($this->input->post('custcontid')));	
                $this->db->where('id', $contid);
                $this->db->update(CUSDETAILS, $ins_sys_array);
        		$data=array('action'=>'success','actmsg'=>"Contact details has been updated successfully.");	
        	}
        }
        else
        {
        	$data=array('action'=>'error','actmsg'=>$this->form_validation->error_array());
        }
        echo json_encode($data);
	}
	function getcustomerContact()
	{
		$custid=intval($this->Common_model->decodeid($this->uri->segment(3)));
		$contid=intval($this->Common_model->decodeid($this->input->post('contid')));
		$data=array('action'=>'error','actmsg'=>'No contact found.');
		$result='';
		$this->db->select('*');		
		$this->db->where('custid',$custid);
		$this->db->where('id',$contid);
		$this->db->limit(1);
		$sql=$this->db->get(CUSDETAILS);
		#echo $this->db->last_query();
		if($sql->num_rows()!=0)
		{
			$result=$sql->row_array();			
			$data=array('action'=>'success','actmsg'=>$result);
		}
		echo json_encode($data);
	}
	function delcustomerContact()
	{
		$custid=intval($this->Common_model->decodeid($this->uri->segment(3)));
		$contid=intval($this->Common_model->decodeid($this->input->post('contid')));
		$data=array('action'=>'success','actmsg'=>'Customer contact has been deleted.');
		
		
		$this->db->where('custid',$custid);
		$this->db->where('id',$contid);
		$this->db->delete(CUSDETAILS);

		echo json_encode($data);
	}

	function sitecustomer($userid)
	{
		$deuserid=$this->Common_model->decodeid($userid);
        $data['title'] = 'Customer Contact';

        //$this->load->vars($data);
        $data['userid']=$userid;
        $data['contactall']=$this->Cmodel->getContactDetailsAll($deuserid);
        $this->load->view('common/header');		
        $this->load->view('customer/sitecustomer',$data);
		$this->load->view('common/footer');		
	}
	function getallCustomersSites()
	{
		$table = CUSSITES;
		$userid=intval($this->Common_model->decodeid($this->uri->segment(3)));
		 
		// Table's primary key
		$primaryKey = 'id';


		$columns = array(
			array( 'db' => 'sitename', 'dt' => 0),			
			array( 'db' => 'siteaddress', 'dt' => 1),			
			//array( 'db' => 'custid',  'dt' => 1),
			array( 'db' => 'id',   'dt' => 2,'formatter' => function( $d, $row ) {
					$action='<div class="icon_list">';

					$enid=$this->Common_model->encodeid($d);

					//if(cusedit==true)
					{
						$action.='<a href="javascript:void(0);" data-id="'.$enid.'" class="editcussite"  data-toggle="tooltip"  title="Edit Site"><i class="fa fa-pencil" aria-hidden="true"></i></a>&nbsp;';
					}
					//if(cusdle==true)
					{
						$action.='<a href="javascript:void(0);" data-id="'.$enid.'" class="delcussite" data-toggle="tooltip"  title="Delete Site"><i class="fa fa-times" aria-hidden="true"></i></a>';
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
		
		//$joinQuery = "FROM `".USER."` AS `u` JOIN `".USERROLE."` AS `ud` ON (`u`.`roleid` = `ud`.`roleid`)";
		//$extraWhere = "";

		$joinQuery = "";
		$searchval=$_REQUEST['search']['value'];
		$extraWhere = " custid ='".$userid."'";
		$extraWhere_add=' and ';
		#echo '<pre>'; print_r($_GET); echo '</pre>';
		 
		echo json_encode(
			SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere,'',$extraWhere_add )
		);
	}
	function sitecontactscheck()
	{
		$sitecontacts=$this->input->post('sitecontacts');
    	if(empty($sitecontacts))
    	{
    		$this->form_validation->set_message('sitecontactscheck', 'Please select any one Contacts');
    		return false;
    	}
    	else
    	{
    		return true;
    	}
	}
	public function addeditcustomersite()
	{
		//$this->exitpage();	
		$data=array();	
		$custid=intval($this->Common_model->decodeid($this->uri->segment(3)));		

		if ($this->input->post())
        {
        	$this->form_validation->set_rules('sitename', 'Site name', 'trim|required');
        	$this->form_validation->set_rules('siteaddress', 'Site Address', 'trim|required');
        	$this->form_validation->set_rules('sitecontacts', '...', 'callback_sitecontactscheck');
        	
		}

		if ($this->form_validation->run() == TRUE)
        {
        	$created_date = date('Y-m-d H:i:s');
        		$ins_sys_array= array(
                    'custid'=>$custid,
                    'sitename'=>$this->input->post('sitename'),
                    'siteaddress'=>$this->input->post('siteaddress')
                );
            $sitecontacts=$this->input->post('sitecontacts');

        	if(empty($this->input->post('custsiteid')))
        	{
        		$ins_sys_array['createdon'] = $created_date;
            	$ins_sys_array['createdby']= $this->session->userdata('userid');
                $this->db->insert(CUSSITES, $ins_sys_array);        		
                $siteid=$this->db->insert_id();

                if(count($sitecontacts)>0)
                {
                	foreach ($sitecontacts as $si_key => $si_value) {
                		$si_ins_array=array(
                			"custid"=>$custid,
                			"siteid"=>$siteid,
                			"contid"=>$si_value
                		);
                		$this->db->insert(CUSCONSITE, $si_ins_array);  
                	}
                }

        		$data=array('action'=>'success','actmsg'=>"Site details has been added successfully.");
        	}
        	else
        	{
        		$ins_sys_array['modifiedon'] = $created_date;
            	$ins_sys_array['modifiedby']= $this->session->userdata('userid');
            	$siteid=intval($this->Common_model->decodeid($this->input->post('custsiteid')));	
                $this->db->where('id', $siteid);
                $this->db->update(CUSSITES, $ins_sys_array);

                $this->db->where('siteid',$siteid);
				$this->db->where('custid',$custid);
				$this->db->delete(CUSCONSITE);

				if(count($sitecontacts)>0)
                {
                	foreach ($sitecontacts as $si_key => $si_value) {
                		$si_ins_array=array(
                			"custid"=>$custid,
                			"siteid"=>$siteid,
                			"contid"=>$si_value
                		);
                		$this->db->insert(CUSCONSITE, $si_ins_array);  
                	}
                }

        		$data=array('action'=>'success','actmsg'=>"Site details has been updated successfully.");	
        	}
        }
        else
        {
        	$data=array('action'=>'error','actmsg'=>$this->form_validation->error_array());
        }
        echo json_encode($data);		
	}
	public function getcustomerSite()
	{
		$custid=intval($this->Common_model->decodeid($this->uri->segment(3)));
		$siteid=intval($this->Common_model->decodeid($this->input->post('siteid')));
		$data=array('action'=>'error','actmsg'=>'No Site found.');
		$result='';
		$this->db->select('*');		
		$this->db->where('custid',$custid);
		$this->db->where('id',$siteid);
		$this->db->limit(1);
		$sql=$this->db->get(CUSSITES);
		#echo $this->db->last_query();
		if($sql->num_rows()!=0)
		{
			$result=$sql->row_array();	
			
			$this->db->select('contid');
			$this->db->where('siteid',$siteid);
			$this->db->where('custid',$custid);
			$cuscontsql=$this->db->get(CUSCONSITE);		
			$result['contacts']=array();
			if($cuscontsql->num_rows()>0)
			{
				$cuscontsqldata=$cuscontsql->result_array();
				foreach ($cuscontsqldata as $cs_key => $cs_value) {
						$result['contacts'][]=$cs_value['contid'];
				}
				
			}
			$data=array('action'=>'success','actmsg'=>$result);
		}
		echo json_encode($data);		
	}
	public function delcustomerSites()
	{
		$custid=intval($this->Common_model->decodeid($this->uri->segment(3)));
		$siteid=intval($this->Common_model->decodeid($this->input->post('siteid')));
		$data=array('action'=>'success','actmsg'=>'Site has been deleted.');
		
		
		$this->db->where('custid',$custid);
		$this->db->where('id',$siteid);
		$this->db->delete(CUSSITES);

        $this->db->where('siteid',$siteid);
		$this->db->where('custid',$custid);
		$this->db->delete(CUSCONSITE);

		echo json_encode($data);
	}
}
