<?php defined('BASEPATH') OR exit('No direct script access allowed');

////////////////////////////////////////////////////////////////////
//
// Called when the on-call engineer makes a selection as to whether or
// not they will accept the call (i.e. help the customer).
//
class EngineerResponse extends CI_Controller {

    ////////////////////////////////////////////////////////////////
    //
    // With the Twilio API, in order to do anything with a
    // conference, we need it's ID (conference sid).  This method
    // loops through the list of in-progress Twilio conferences
    // to find one that matches the "friendly name" we gave
    // the conference used to bridge the customer and the engineer.
    //
    // Note that to make this approach "thread-safe" for a
    // multi-call environment, the "friendly name" would need to
    // be unique across/between calls - e.g. something like
    // 'theConference'.$conferenceSID
    //
    protected function _GetConfID(){
        $sid = $GLOBALS['hConfig']->get('twilioSEID');
        $token = $GLOBALS['hConfig']->get('twilioToken');
        try {
            $client = new Twilio\Rest\Client($sid, $token);
            $conferences = $client->conferences->read(
                array("status" => "in-progress", "friendlyName" => $GLOBALS['hConfig']->get('conferenceID'))
                );
            // Loop over the list of conferences and echo a property for each one
            foreach ($conferences as $conference) {
                log_message('debug','Conference Status: '.$conference->status);
                log_message('debug','Conference Sid: '.$conference->sid);
                return $conference->sid;
            }
        } // try
        catch(Exception $e){
            $this->load->view('errorview');
        } // catch
        return NULL;
    } // _GetConfID()

    ////////////////////////////////////////////////////////////////
    //
    // If the engineer rejects the call, we need to kill the
    // conference the customer is in and let them know that they
    // will receive a call back at a later time.  This method kills
    // the conference using Twilio's REST API based on a generated
    // URL that includes the unique conference ID (sid).
    //
    // Twilio doesn't have a PHP language wrapper for this,
    // so we use CURL directly.
    //
    protected function _killConferenceByURL($url){

        $sid = $GLOBALS['hConfig']->get('twilioSEID');
        $token = $GLOBALS['hConfig']->get('twilioToken');
        $auth = $sid .":". $token;
        $fields = array('Status' => 'completed');
        $post = http_build_query($fields);
        $curl = curl_init($url);
        // Set some options - we are passing in a useragent too here
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_USERAGENT , 'Mozilla 5.0');
        curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
        curl_setopt($curl, CURLOPT_USERPWD, $auth);
        curl_setopt($curl, CURLOPT_VERBOSE , true);

        $resp = curl_exec($curl);

        // log_message('debug',$resp);

        curl_close($curl);
    } // _killConferenceByURL()

    /////////////////////////////////////////////////////////////////
    //
    public function index($responded="TRUE")
    {
        log_message('debug', 'EngineerResponse.index('.$responded.')...');

        $eResp = $this->input->post('Digits');

        log_message('debug','Engineer response = '.$eResp);

        // This would be a "case statement" if we were doing a
        // call menu with more than one item to worry about.
        if ($eResp == '1'){
            log_message('debug','Connect to the conference.');
            // Check to see that the customer actually is in the
            // conference (and hasn't hung up) before connecting.
            if ($this->_GetConfID()){
                 $this->load->view('econnectview');               
            }
            else {
                // No conference in progress, so the caller
                // must have bailed.
                 $this->load->view('ecbailedview');                               
            }
        }
        else {
            log_message('debug','Call rejected by engineer.');

            $confID = $this->_GetConfID();
            if (!is_null($confID)){
                $sid = $GLOBALS['hConfig']->get('twilioSEID');
                $token = $GLOBALS['hConfig']->get('twilioToken');
                $confURL =  'https://api.twilio.com/2010-04-01/Accounts/'.
                            $sid.'/Conferences/'.$confID.'.json';

                // log_message('debug','Conference URL: '.$confURL);
                $this->_killConferenceByURL($confURL);
            }
            else {
                log_message('debug','No conference in progress.');
            }

            $this->load->view('erejectview');
        }
    }  // index()
   
} // class