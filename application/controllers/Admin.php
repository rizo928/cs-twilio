<?php defined('BASEPATH') OR exit('No direct script access allowed');

//////////////////////////////////////////////////////////////////////
//
// Handles retrieval and setting of vital application parameters that
// are persisted by default in a JSON formatted file called
// filebox.json
//
// Views associated with this controller include:
//      - adminview     (form that collects parameters/fields)
//      - adminfailview (notifies user that the attempt to set
//        admin vars failed)
//      - adminsuccessview (notifies user of successful set of
//        admin vars)
//
class Admin extends CI_Controller {
    public function index() {   
        log_message('debug', 'Admin.index()...');

        $this->load->helper(array('form', 'url'));

        $this->load->library('form_validation');

/*
        ADDITIONAL FIELDS THAT THE APPLICATION USES THAT
        COULD BE ADDED TO THE ADMIN SCREEN

        $this->form_validation->set_rules('twilioSEID_field', 'twilioSEID', 'trim|required|min_length[34]',
                array('required' => 'You must provide a valid %s.')
        );
        $this->form_validation->set_rules('twilioToken_field', 'twilioToken', 'trim|required');
        $this->form_validation->set_rules('smsFrom_field', 'smsFrom', 'trim|required');
        $this->form_validation->set_rules('conferenceID_field', 'conferenceID', 'trim|required');
        $this->form_validation->set_rules('senderEmail_field', 'senderEmail', 'trim|required|valid_email');
*/
        $this->form_validation->set_rules('validPINS_field', 'validPINS', 'trim|required');
        $this->form_validation->set_rules('engineerPhone_field', 'engineerPhone', 'trim|required');
        $this->form_validation->set_rules('engineerEmail_field', 'engineerEmail', 'trim|required|valid_email');

        if ($this->form_validation->run() == FALSE) {
        	// initial and subsequent data entry and validation failures
            $this->load->view('adminview',$GLOBALS['hConfig']->getAll());
        }
        else {
        	// Data submission and validation successful if we reach this point.

            // Load in array of our persistant variables for modification below
    		$aConfig = $GLOBALS['hConfig']->getAll();

    		// $aConfig['twilioSEID'] = $this->input->post('twilioSEID_field');
    		// $aConfig['twilioToken'] = $this->input->post('twilioToken_field');
    		// $aConfig['smsFrom'] = $this->input->post('smsFrom_field');
    		// $aConfig['conferenceID'] = $this->input->post('conferenceID_field');
            // $aConfig['senderEmail'] = $this->input->post('senderEmail_field');

    		$aConfig['validPINS'] = json_decode($this->input->post('validPINS_field'));
    		$aConfig['engineerPhone'] = $this->input->post('engineerPhone_field');
    		$aConfig['engineerEmail'] = $this->input->post('engineerEmail_field');
    		if (is_null($GLOBALS['hConfig']->setAll($aConfig))){
    			// serious application error if we reach this point
    			// one possible cause is a permissions issue with the directory
    			// where FileBox is trying to write the file.
    			log_message('error','Admin.index(): Failed to write configuration.');
    			$this->load->view('adminfailview');
    		}
    		else {
            	$this->load->view('adminsuccessview');
    		}
        } // else
    } // index()   
} // class