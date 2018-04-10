<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
	
	public function __construct()
	{	
		parent::__construct();         
		$this->load->model('login/login_model','MUser');
	}
	public function index()
	{
		$this->load->view('common/header');
		
		$data=array();
		
		if ($this->input->post('submit')) {
			
            $this->form_validation->set_rules('username', 'user name', 'trim|required');
            $this->form_validation->set_rules('password', 'password', 'trim|required');

            if ($this->form_validation->run()) {
                //Remember me
                if ($this->input->post('remember') != '') {
                    $year = time() + 31536000;
                    setcookie('remember_username', $_POST['username'], $year);
                    setcookie('remember_userpsw', $_POST['password'], $year);
                } elseif ($this->input->post('remember') == '' || $this->input->post('remember') == NULL) {
                    if (isset($_COOKIE['remember_username'])) {
                     
                        $past = time() - 100;
                        setcookie('remember_username', 'gone', $past);
                        setcookie('remember_userpsw', 'gone', $past);
                    }
                }

                $username = $this->input->post('username');
                $password = $this->input->post('password');

                $user_detail = $this->MUser->login($username, $password);
				
             
                if (!empty($user_detail) && isset($user_detail)) {

                    //echo '<pre>'; print_r($user_detail); exit;
                    $this->session->set_userdata('userid', $user_detail['userid']);
                    $this->session->set_userdata('username', $user_detail['displayname']);
					$this->session->set_userdata('firstname', $user_detail['firstname']);
					$this->session->set_userdata('lastname', $user_detail['lastname']);
                    $this->session->set_userdata('useremailid', $user_detail['emailid']);
                    $this->session->set_userdata('userroleid', $user_detail['roleid']);
                    $this->session->set_userdata('createdon', strtotime($user_detail['createdon']));
                    $url = base_url('home');
					//echo $url; die;
                    redirect($url);
                } else {
                    $data['login_error'] = 'Invalid User Name / Password.';
                }
            } else {
                $data['login_error'] = 'Invalid User Name / Password.';
            }
        }
		
		if ($this->Common_model->isLoggedIn())
		{
			redirect(base_url('home')); // login checking
		}
		
		$this->load->view('login/login',$data);
		$this->load->view('common/footer');
	}
	//Log out function 
    public function logout() {
        $this->session->sess_destroy();
        $red_path = base_url();
        redirect($red_path);
    }
	
	//Forget Password
    public function forget_password() {
        $data['page_title'] = 'Forget Password';
        $data['email_error'] = '';
       
        if ($this->input->post('cancel')) {
            $red_path = base_url();
            redirect($red_path);
        }
        if ($this->input->post('submit')) {
            $this->form_validation->set_rules('useremail', 'email id', 'trim|required|valid_email');
            $useremailid = $this->input->post('useremail');
            if ($this->form_validation->run()) {
                $val = $this->MUser->checkvalidemail($useremailid);
                if ($val == 0) {
                    $data['email_error'] = 'Email Id does not exist';
                } else {

                    $randnum = $this->Common_model->generateRandomString();
                    $result = $this->MUser->getemaildetails($useremailid);

                    $email_subject = "Password Reset Successfully";
                    $content = "Dear " . $result['displayname'] . ",<br/><br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Your password has been changed in Balcomm Water Treatment,<br/><br/><br/>Emaild and password below,<br/><br/><br/><br/>Email Id:" . $result['emailid'] . "<br/><br/>Password:" . $randnum . "";
                    $to_email = trim($result['emailid']);
                    $from_email = 'admin@balcomm.co.uk';

                    /*$config = Array(
                        'protocol' => 'smtp',
                        'smtp_host' => 'ssl://smtp.gmail.com',
                        'smtp_port' => 465,
                        'smtp_user' => 'testemail5212@gmail.com',
                        'smtp_pass' => 'CGvak@123',
                        'mailtype'  => 'html', 
                        'charset'   => 'iso-8859-1'
                    );*/

                    $config['protocol'] = "smtp";
                    $config['smtp_host'] = "ssl://smtp.gmail.com";
                    $config['smtp_port'] = "465";
                    $config['smtp_user'] = "testemail5212@gmail.com"; 
                    $config['smtp_pass'] = "CGvak@123";
                    $config['charset'] = "utf-8";
                    $config['mailtype'] = "html";
                    $config['crlf'] = "\r\n";
                    $config['newline'] = "\r\n";                    
                    $config['smtp_timeout'] = '7';

                    $this->load->library('email');                    
                    $this->email->initialize($config);
                    //$this->email->set_newline("\r\n");
                    //$this->email->clear(TRUE);
                    $this->email->from($from_email,'Balcomm');
                    $this->email->to($to_email);
                    

                    $this->email->subject($email_subject);
                    $this->email->message('This is a test');
                    $emailres=$this->email->send();

                    $upd_array = array('password' => md5($randnum));
                    $this->db->where('userid', $result['userid']);
                    $this->db->update(USER, $upd_array);

                    #$to_email.'<br>'.$content.'<br>'.$this->db->last_query();

                    $this->session->set_flashdata('success_message', 'Your password has been changed successfully...Please check your mail');
                    $path = base_url() . 'login/forget_password';
                    redirect($path);

                }
            }
        }

        //$this->load->vars($data);
		$this->load->view('common/header');
        $this->load->view('login/forget_password',$data);
		$this->load->view('common/footer');
    }
	
}
