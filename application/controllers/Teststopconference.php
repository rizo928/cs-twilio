<?php defined('BASEPATH') OR exit('No direct script access allowed');

//////////////////////////////////////////////////////////////////////////////
//
// Bridging an inprogress call with another person contacted and screened
// via a separate outbound call/leg is a bit complex with the Twilio API.
// Basically we have to make use of the conference capability.
//
// This controller test the capability of killing an in-progress conference.
//
class TestStopConference extends CI_Controller {

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
            $this->load->view('error_view');
        } // catch
    } // _GetConfID()

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

        log_message('debug',$resp);

        curl_close($curl);
    } // _killConferenceByURL()

    public function index()
    {


        log_message('debug', 'TestStopConference.index()...');
        //
        // http://docs.guzzlephp.org/en/latest/quickstart.html
        //
        // If we want to kick the caller out of the conference we'd need to do
        // so by sending a POST via Guzzle.
        //
        $confID = $this->_GetConfID();

        $sid = $GLOBALS['hConfig']->get('twilioSEID');
        $token = $GLOBALS['hConfig']->get('twilioToken');

        $confURL =  'https://api.twilio.com/2010-04-01/Accounts/'.
                    $sid.'/Conferences/'.$confID.'.json';

        log_message('debug','Conference URL: '.$confURL);

        $this->_curlKill($confURL);

/*
        $hGuz = new GuzzleHttp\Client();
        $res = $hGuz->request('POST', $confURL, ['auth' => [$sid, $token],'body' => 'Status=completed'] );
*/
        log_message('debug','Killed conference.');
 
    } // index()   
} // class