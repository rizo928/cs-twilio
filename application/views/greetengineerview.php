<?php defined('BASEPATH') OR exit('No direct script access allowed');
    log_message('debug', 'greetengineerview...');

    header("content-type: text/xml");
    echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
?>
<Response>
    <Gather action="<?php echo base_url('engineerresponse/index/TRUE');?>" method="POST" timeout="10" numDigits="1">
        <Say>
            Welcome Mr. Fix it.
            Press 1 if you would like to accept a service call.
            Otherwise press 2 or simply hang up.
        </Say>
    </Gather>
    <Say>We didn't receive any input. Goodbye!</Say>
    <Redirect method="POST">
        <?php echo base_url('engineerresponse/index/FALSE');?>
    </Redirect>
</Response>
