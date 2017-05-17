<?php defined('BASEPATH') OR exit('No direct script access allowed');
log_message('debug', 'validpinview...');

header("content-type: text/xml");
echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
?>
<Response>
    <Gather action="<?php echo base_url('recordticketinfo');?>" method="POST">
        <Say>
            Please enter a callback number, 
            followed by pressing the pound sign.
        </Say>
    </Gather>
    <Say>We didn't receive any input. Goodbye!</Say>
</Response>