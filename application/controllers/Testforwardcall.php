<?php defined('BASEPATH') OR exit('No direct script access allowed');

//////////////////////////////////////////////////////////////////////////////
//
class TestForwardCall extends CI_Controller {
    public function index()
    {   
        log_message('debug', 'TestForwardCall.index()...');
        $this->load->view('testforwardcallview');
    } // index()   
} // class