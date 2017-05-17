<?php defined('BASEPATH') OR exit('No direct script access allowed');

//////////////////////////////////////////////////////////////////////
//
// Start the outbound call to the on-call engineer
//
class ContactEngineer extends CI_Controller {

    /////////////////////////////////////////////////////////////////
    //
    // Use Twilio REST API to kick off an outbound call to the
    // on call engineer.
    //
    private function _startEngineerCall()
    {
        log_message('debug', 'Starting engineer call...');
        $sid = $GLOBALS['hConfig']->get('twilioSEID');
        $token = $GLOBALS['hConfig']->get('twilioToken');
        $client = new Twilio\Rest\Client($sid, $token);
        if (is_null($client)){
            log_message('error','ContactEngineer->_startEngineerCall() new Twilio\Rest\Client() returned NULL');
        }

        // This will throw an exception if the number being dialed
        // is international and the Twilio acount hasn't been enabled
        // for international calls.

    	$call = $client->calls->create(
            $GLOBALS['hConfig']->get('engineerPhone'), // To
            $GLOBALS['hConfig']->get('twilioPhone'), // From
            array("url" => base_url('greetengineer'))
		);
        if (is_null($call)){
            log_message('error','ContactEngineer->_startEngineerCall() $client->calls->create() returned NULL');
        }
        return TRUE;
    } // _startEngineerCall()


    /////////////////////////////////////////////////////////////////
    //
    public function index()
    {
        log_message('debug', 'ContactEngineer.index()...');

    	// start the outbound call to an engineer

    	if ($this->_startEngineerCall()){
            // place the caller on hold in a conference room
            $this->load->view('contactengineerview');          
        }
        else {
            // Likely cause is an attempt to dial a bad number
            // Regardless, we sent an email to the engineer with
            // callback and trouble info at this point, so let the
            // customer know to expect a call back.
            log_message('error', 'ContactEngineer->_startEngineerCall() failed'.
                        ' while attempting to call: '.$GLOBALS['hConfig']->get('engineerPhone'));
            $this->load->view('unsatisfiedcustomerview');
        }
    } // index()   
} // class