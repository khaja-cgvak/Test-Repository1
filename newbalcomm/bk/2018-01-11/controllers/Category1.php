<?php

class Category1 extends CI_Controller {

    public function __construct() {
    	parent::__construct();
    }

    public function hai()
	{
	    echo 'hai';
	}

	public function send_mail()
{
    $config = Array(
  'protocol' => 'smtp',
  'smtp_host' => 'mail.knowmytalent.com',
  'smtp_port' => 465,
  'smtp_user' => 'kellyohams@knowmytalent.com', // change it to yours
  'smtp_pass' => 'Rehoboth@1610', // change it to yours
  'mailtype' => 'html',
  'charset' => 'iso-8859-1',
  'wordwrap' => TRUE
);

        $message = '';
        $this->load->library('email', $config);
      $this->email->set_newline("\r\n");
      $this->email->from('kellyohams@knowmytalent.com'); // change it to yours
      $this->email->to('testing.useonly2@gmail.com');// change it to yours
      $this->email->subject('Resume from JobsBuddy for your Job posting');
      $this->email->message($message);
      if($this->email->send())
     {
      echo 'Email sent.';
     }
     else
    {
     show_error($this->email->print_debugger());
    }
}
}
?>