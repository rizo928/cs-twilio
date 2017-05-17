<?php defined('BASEPATH') OR exit('No direct script access allowed');

/////////////////////////////////////////////////////////////////////
//
// Reaches here after the customer records a message detailing
// their needs.
//
class HandleRecording extends CI_Controller {

    function _allowUrlFopen(){
        if (ini_get('allow_url_fopen')) {
            return true;
        } 
        else {
            // not currently allowed, but try and fix that
            ini_set('allow_url_fopen', true);
            if (ini_get('allow_url_fopen')) {
                return true;
            } 
            else {
                return false;
            }
        }
    } // function allowUrlFopen()

    ////////////////////////////////////////////////////////////////
    //
    // Save the recording pointed to by URL to a temporary local file
    //
    function _storeUrlToFilesystem($url, $localFile) {
        try {
            $pRemote=fopen($url, 'r');
            if ($pRemote){
                $pLocal=fopen($localFile, 'w');
                if ($pLocal){
                    while(!feof($pRemote)){
                        fwrite($pLocal, fread($pRemote, 8192));
                    }
                    fclose($pLocal);
                    return true;
                }
                fclose($pRemote);
            }
        } catch (Exception $e) {
            // echo "<p>".'Caught exception: '.$e->getMessage()."</p>";
            log_message('error', 
            'Caught exception in HandleRecording->_storeUrlToFilesystem()');
            return false;
        } // catch()
        return false;
    } // storeUrlToFilesystem()

    ////////////////////////////////////////////////////////////////
    //
    public function index()
    {
        log_message('debug', 'HandleRecording.index()...');

        // These are the variables Twilio sends in the POST
        // after a <Record> event:
        //
        // $acid = $this->input->post('AccountSid');
        // $csid = $this->input->post('CallSid');
        // $rsid = $this->input->post('RecordingSid');
        $rurl = $this->input->post('RecordingUrl');
        // $rlen = $this->input->post('RecordingDuration');

        // Retrieving the customer callback number we stored earlier
        // in the call flow.
        //
        // Note again, that this isn't thread (multi-call) safe.
        // Rather to make it thread/multicall safe we'd need to
        // use a DB recorded keyed by callid e.g. 
        // 'callbackNo'.$csid
        $callbackNo = $GLOBALS['hConfig']->get('callbackNo');

        log_message('debug', 'CallbackNo: '.$callbackNo);
        log_message('debug', 'RecordingUrl: '.$rurl);

        // The file name used here isn't thread/multicall safe
        if ($this->_storeUrlToFilesystem($rurl,'test.mp3')){
            log_message('debug', '_storeUrlToFilesystem completed successfully');
        }
        else {
            log_message('debug', '_storeUrlToFilesystem failed');
        }

        // send email to the on-call engineer
        // (could probably create a function/method for this)
        //
        // This uses the Codeigniter email library (see
        // Codeigniter documentation for details.
        //
        // The library relies on sendmail to be setup correctly.
        // For simplicity purposes the environment utilized for
        // testing this demo used ssmtp which was simlinked
        // to sendmail.

        $config['protocol'] = 'sendmail';
        $config['mailpath'] = '/usr/sbin/sendmail';
        $config['charset'] = 'iso-8859-1';
        $config['wordwrap'] = TRUE;

        $this->load->library('email');
        $this->email->initialize($config);
        $this->email->from($GLOBALS['hConfig']->get('senderEmail'), 'Twilio Demo Application');
        $this->email->to($GLOBALS['hConfig']->get('engineerEmail'));
        $this->email->attach('test.mp3');
        $this->email->subject('Engineering Email');

        // Ugly format for email prototype.  In a production
        // application we'd of course do a nice HTML email body.
        $body = 'Callback Number: '.$callbackNo."\nRecording URL: ".$rurl."\n Recording is also attached.";
        log_message('debug', 'Email body: '.$body);
        $this->email->message($body);

        // Note that a success here simply means that the
        // Codeigniter library accepted the send request
        // If sendmail (or ssmtp configured as such) isn't
        // functioning properly you won't get an error
        // message.  Rather you simply won't see the email.
        if (!$this->email->send()){
            log_message('debug', 'email sent...');
        } else {
            log_message('debug', 'email sent...');
        }

    }  // index()
   
} // class