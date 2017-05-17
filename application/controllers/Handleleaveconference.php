<?php defined('BASEPATH') OR exit('No direct script access allowed');

/////////////////////////////////////////////////////////////////////
//
// Reaches here when the conference the customer was placed in ends.
//
// This could occur because the on-call engineer rejected the call;
// or, if the engineer left the conference before the customer.
//
class HandleLeaveConference extends CI_Controller {
    public function index()
    {   
        log_message('debug', 'HandleLeaveConference.index()...');
        $wasInConference = $GLOBALS['hConfig']->get('conferenceStarted');
        log_message('debug',"conferenceStarted=".$wasInConference);
        // We check this persistent variable to see if the engineer
        // actually was in the conference with the caller or not to
        // decide what to tell the caller.
        // 
        // See comments in First.php for details about this approach.
        //
        if ($wasInConference == 'TRUE'){
        	log_message('debug','satisfied customer...');
        	$this->load->view('satisfiedcustomerview');
        } else {
        	log_message('debug','unsatisfied customer...');
        	$this->load->view('unsatisfiedcustomerview');
        }
    } // index()   
} // class