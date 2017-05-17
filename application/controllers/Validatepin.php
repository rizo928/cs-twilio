<?php defined('BASEPATH') OR exit('No direct script access allowed');

//////////////////////////////////////////////////////////////////////////////
//
// Reaches here after the customer enters a numeric PIN number.
//
// This bascically compares what the caller entered to an array of valid
// PIN numbers persistently stored (in plain text) in the default filebox.json
// file.  This array of valid pin numbers can be altered/aupdated from the
// admin page.
//
class ValidatePin extends CI_Controller {

    //////////////////////////////////////////////////////////////////////////
    //
    private function _isValidPIN($thePIN='')
    {
        // Read the persistent parameter 'validPINS' and check to
        // see if exists and is in fact properly formatted
        if (is_array($GLOBALS['hConfig']->get('validPINS'))){
            // Check if the caller entered PIN is in the array
            // (yes we could tighten up this code)
            if (in_array($thePIN, $GLOBALS['hConfig']->get('validPINS'))){
                return TRUE;
            } 
            else {
                log_message('debug','ValidatePin->_isValidPIN() PIN not in array');
                return FALSE;
            }
        }
        else {
            // Be generous and handle the case where validPINS is in fact
            // a single PIN vs. the specified array
            if ($thePIN == $GLOBALS['hConfig']->get('validPINS')){
                return TRUE;
            }
            else {
                log_message('debug','ValidatePin->_isValidPIN() check for single PIN failed');
            }
        }
        return FALSE;
    } // _isValidPIN()

    //////////////////////////////////////////////////////////////////////////
    //
    public function index()
    {
        log_message('debug', 'ValidatePin.index()...');
        
        // Twilio POSTs the digits entered previously in
        // a variable called 'Digits'
        $enteredPIN = $this->input->post('Digits');
        $data = array('enteredPIN' => $enteredPIN);
        
        if ($this->_isValidPIN($enteredPIN)){
            $this->load->view('validpinview');
        }
        else{
            $this->load->view('invalidpinview', $data);
        }
    }   // index()

} // class