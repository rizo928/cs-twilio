<?php defined('BASEPATH') OR exit('No direct script access allowed');

//////////////////////////////////////////////////////////////////////////////
//
// This is reached when an SMS (text) message is sent to the application
// (phone number with SMS enabled that is pointing to http://myserver.com/receivesms)
//
// SMS messages are assumed to be in JSON format, specifying key value pairs for
// valid configuration items.
//
// CAUTION: virtually no error checking is done on the inbound SMS as this is only
// a demo of the receive/send SMS api.
//
class ReceiveSMS extends CI_Controller {

    //////////////////////////////////////////////////////////////////////////////
    //
    // Encapsulates the Twilio specifics of sending an SMS message
    //
    // Note that in order for this to work, the $from parameter must
    // be one of your valid Twilio phone numbers.
    //
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

    public function index()
    {
        log_message('debug', 'ReceiveSMS.index()...');

        $from = $this->input->post('From');
        $body = json_decode($this->input->post('Body'),true);

        $responseSMS = "We received your application configuration message.\n";

        // SET OF TEST "messages"
        //
        // ********** DELETE BEFORE PUBLIC RELEASE!!!!!!!!!!!
        //
        // $body = json_decode('{"validPINS":["123"]}',true);
        // $body = json_decode('{"engineerPhone":"5552091234"}',true);
        // $body = json_decode('{"smsFrom":"5556755678"}',true);
        // $body = json_decode('{"validPINS":["123"],"engineerPhone":"5551092345"}',true);
        // $body = json_decode('{"engineerEmail":"foo@foocom"}',true);
        // $body = json_decode('{"engineerEmail":"proxy@foo.net"}',true);
        // $body = json_decode('{"foo":"foobar"}',true); // INVALID KEY
        // $body = json_decode('{"Pin""123","Phone:"5555271111""hello@mymail.com"',true); // INVALID JSON
        if (is_null($body)){
        	log_message('debug',"Received Invalid JSON");
        	return;
        }
		log_message('debug', 'SMS Received From: '.$from);
		foreach ($body as $key => $value) {
    		// log_message('debug','Key: '.$key.' Value: '.$value);
    		switch ($key){
    			case 'validPINS':
                    if (!is_array($value)){
                        log_message('debug',"Adding a single PIN");
                    }
                    else {
                        log_message('debug','Setting the array of valid PINS');
                    }
                    $GLOBALS['hConfig']->set($key,$value);
                    $responseSMS = $responseSMS.$key." set to: ".json_encode($value)."\n";
                    break;
                case 'engineerPhone':
                case 'engineerEmail':
                case 'smsFrom':
                   	log_message('debug', 'Process '.$key.'...');
                    $GLOBALS['hConfig']->set($key,$value);
                    $responseSMS = $responseSMS.$key." set to: ".json_encode($value)."\n";
    				break;
    			default:
    				log_message('debug', 'Process default...');
                    $responseSMS = "Invalid configuration key: ".$key."\n";
    		} // switch
  		} // foreach

        $this->_sendSMS($from, // respond back to original sender
                $GLOBALS['hConfig']->get('smsFrom'),
                $responseSMS);

    } // index()   
} // class