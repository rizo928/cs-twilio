<?php defined('BASEPATH') OR exit('No direct script access allowed');

//////////////////////////////////////////////////////////////////////////////
//
// Reaches here after the customer enters a call back number and we're now
// going to ask them to leave a recording that captures their request.
//
class RecordTicketInfo extends CI_Controller {
    public function index()
    {
        log_message('debug', 'RecordTicketInfo.index()...');
        
        $callbackNo = $this->input->post('Digits');
        log_message('debug', 'CallbackNo: '.$callbackNo);

        // Using a simple file to store the callback number previously entered.
        // This isn't thread (multi-call) safe but it's simple for prototype purposes.
        $GLOBALS['hConfig']->set('callbackNo',$callbackNo);
        
        $this->load->view('recordticketinfoview');
    } // index()
} // class