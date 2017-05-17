<?php defined('BASEPATH') OR exit('No direct script access allowed');

//////////////////////////////////////////////////////////////////////////////
//
// A simple controller to test to see if Twilio's REST API for sending an
// SMS (text) message is working.
class TestSendMessage extends CI_Controller {

    private function _sendSMS($to,$from,$body){
        $sid = $GLOBALS['hConfig']->get('twilioSEID');
        $token = $GLOBALS['hConfig']->get('twilioToken');
        $client = new Twilio\Rest\Client($sid, $token);

        // Use the client to do fun stuff like send text messages!
        $client->messages->create(
        // the number you'd like to send the message to
        $to,
        array(
            // A Twilio phone number you purchased at twilio.com/console
            'from' => $from,
            // the body of the text message you'd like to send
            'body' => $body
            )
        );
    } // _sendSMS()

    public function index($theMsg='**default**')
    {
        log_message('debug', 'TestSendMessage.index()...');
        $this->_sendSMS($GLOBALS['hConfig']->get('engineerPhone'),
                        $GLOBALS['hConfig']->get('smsFrom'),
                        'message from TestSendMessage() controller');
    }  // index()
   
} // class