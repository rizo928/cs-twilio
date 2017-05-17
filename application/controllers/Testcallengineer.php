<?php defined('BASEPATH') OR exit('No direct script access allowed');

//////////////////////////////////////////////////////////////////////////////
//
// Simple controller to test the Twilio REST API for kicking off an
// outbound call.
//
class TestCallEngineer extends CI_Controller {

    private _hBox;

    protected function _startEngineerCall(){
        log_message('debug', 'Starting engineer call...');
        $sid = $GLOBALS['hConfig']->get('twilioSEID');
        $token = $GLOBALS['hConfig']->get('twilioToken');
        try {
            $client = new Twilio\Rest\Client($sid, $token);
        	$call = $client->calls->create(
                $hConfig->get('engineerPhone'), // To
                $hConfig->get('twilioPhone'), // From
                array("url" => base_url('greetengineer'),
                      "FallbackUrl" => base_url('error'))
    		);
        } // try

        catch(Exception $e){
            $this->load->view('error_view');
        } // catch

    } // _startEngineerCall()

    public function index()
    {
        log_message('debug', 'TestCallEngineer.index()...');

    	// start the outbound call to an engineer
    	$this->_startEngineerCall();

    	// place the caller on hold in a conference room
        $this->load->view('testcallengineerview');
    } // index()   
} // class