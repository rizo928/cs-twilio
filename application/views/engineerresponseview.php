<?php defined('BASEPATH') OR exit('No direct script access allowed');
	log_message('debug', 'engineerresponseview...');

    header("content-type: text/xml");
    echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
?>
<Response>
    <Say>
        Thanks Mr. Engineer.  Goodbye.
    </Say>
    <Hangup/>
</Response>