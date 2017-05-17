<?php defined('BASEPATH') OR exit('No direct script access allowed');

//////////////////////////////////////////////////////////////////////
//
// Handles the situation where the engineer left the conference
//
// The Twilio API handles conneting another party as two
// completely independent calls that are conferenced together.
// This is controller is part of the call flow for 
// the outbond call to the engineer 
// (not the customer's).
//
class ELeaveConference extends CI_Controller {
    public function index()
    {   
        log_message('debug', 'ELeaveConference.index()...');
        
        $this->load->view('eleaveconferenceview');
    } // index()   
} // class