<?php defined('BASEPATH') OR exit('No direct script access allowed');

//////////////////////////////////////////////////////////////////////
//
// Reaches hear when the on-call engineer answers his/her phone.
//
class GreetEngineer extends CI_Controller {
    public function index()
    {
        log_message('debug', 'GreetEngineer.index()...');
        
        $this->load->view('greetengineerview');
    } // index()   
} // class