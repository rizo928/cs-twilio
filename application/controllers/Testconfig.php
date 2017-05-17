<?php defined('BASEPATH') OR exit('No direct script access allowed');

//////////////////////////////////////////////////////////////////////////////
//
// Simple controller to test global persistent parameter read/write
//
class TestConfig extends CI_Controller {
    public function index()
    {
        log_message('debug', 'TestConfig.index()...');
        $hConfig = $GLOBALS['hConfig']->getAll();
        if (array_key_exists('twilioSEID', $configData)){
            log_message('debug',"SUCCESSFULLY LOADED CONFIGURATION");
        }
        else {
            log_message('debug',"ERROR LOADING CONFIGURATION");
        }
        $this->load->view('testconfigtestview', $hConfig);
    } // index()   
} // class