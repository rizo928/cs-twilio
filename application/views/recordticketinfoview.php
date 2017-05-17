<?php defined('BASEPATH') OR exit('No direct script access allowed');
log_message('debug', 'recordticketinfoview...');

header("content-type: text/xml");
echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";

?>
<Response>
    <Say>
        Please state your company name and a brief summary of the issue at the beep. Press the pound key when finished. 
    </Say>
    <Record 
        action="<?php echo base_url('contactengineer');?>"
        recordingStatusCallback="<?php echo base_url('handlerecording');?>"
        maxLength="120"
        finishOnKey="#"
        />
    <Say>I did not receive a recording. Goodbye!</Say>
</Response>