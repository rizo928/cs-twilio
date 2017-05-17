<?php defined('BASEPATH') OR exit('No direct script access allowed');
log_message('debug', 'invalidpinview...');

header("content-type: text/xml");
echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";

?>
<Response>
    <Say>
    	<?php echo $enteredPIN; ?> is not valid.
        You must have a valid customer PIN to use our system. Goodbye!
    </Say>
    <Hangup/>
</Response>