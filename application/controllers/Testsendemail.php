<?php defined('BASEPATH') OR exit('No direct script access allowed');

//////////////////////////////////////////////////////////////////////////////
//
// As the name suggests, this is a simple controller to test
// to see if ssmtp and Codeigniter's email library is working
//
class TestSendEmail extends CI_Controller {
    public function index()
    {
        log_message('debug', 'TestSendMail.index()');

		$config['protocol'] = 'sendmail';
		$config['mailpath'] = '/usr/sbin/sendmail';
		$config['charset'] = 'iso-8859-1';
		$config['wordwrap'] = TRUE;

		$this->load->library('email');
		$this->email->initialize($config);
		$this->email->from('proxy@yourmail.net', 'Proxy Message');
		$this->email->to('proxy@yourmail.net');

		$this->email->subject('Email Test from CI');
		$this->email->message('Testing the email class.');

		$this->email->send();

		$this->load->view('testsendemailview');

    } // index()   
} // class