<?php defined('BASEPATH') OR exit('No direct script access allowed');

//////////////////////////////////////////////////////////////////////////////
//
// Reaches here when the base URL is called, i.e. https://myserver.com
//
class Welcome extends CI_Controller {
    public function index()
    {   
        log_message('debug', 'Welcome.index()...');
        
        $this->load->view('welcomeview');
    } // index()   
} // class
