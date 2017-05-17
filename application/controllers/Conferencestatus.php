<?php defined('BASEPATH') OR exit('No direct script access allowed');

//////////////////////////////////////////////////////////////////////
//
//  Called when the conference between the customer and the engineer
//  is started and stopped.
//
//  The real purpose of this controller is to set a flag 
//  (conferenceStarted) so that the code knows if the customer
//  actually was bridged with the engineer or not 
//  (in Hangleleaveconference).  If not bridged (conferenced 
//  with the engineer), then we notify them that the engineer
//  will contact them at a later time.
//
class ConferenceStatus extends CI_Controller {
    public function index()
    {   
        log_message('debug', 'ConferenceStatus.index()...');

        // OTHER VTWILIO VARIABLES AVAIALBLE
        //
        // $AcountSID 	= $this->input->post('AccountSid');
        // $CallSID 	= $this->input->post('CallSid');
        // $confSID 	= $this->input->post('ConferenceSid');

        // CONFERENCE VARIABLES WE'RE INTERESTED IN A THIS POINT
        $confName 	= $this->input->post('FriendlyName');
        $confEvent 	= $this->input->post('StatusCallbackEvent');

        switch ($confEvent) {
        	case 'conference-start':
        		log_message('debug','Conference: '.$confName.' started.');
        		$GLOBALS['hConfig']->set('conferenceStarted','TRUE');
        		break;
         	case 'conference-end':
        		log_message('debug','Conference: '.$confName.' ended.');
        		break; 	
        	default:
        		log_message('debug','Conference: '.$confName.' unhandled status: '.$confEvent);
        		break;
        }

    } // index()   
} // class