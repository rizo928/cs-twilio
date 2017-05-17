<?php defined('BASEPATH') OR exit('No direct script access allowed');
log_message('debug', 'firstview...');

header("content-type: text/xml");
echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";

?>
<Response>
    <Gather action="<?php echo base_url('validatepin');?>" method="POST">
        <Say>
            Welcome to the Twilio Demonstration.
            Please enter your PIN number,
            followed by the pound sign
        </Say>
    </Gather>
    <Say>We didn't receive any input. Goodbye!</Say>
</Response>