<?php defined('BASEPATH') OR exit('No direct script access allowed');
  log_message('debug', 'eleaveconferenceview...');

	header("content-type: text/xml");
  echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";

?>
<Response>
    <Say>
        Thanks for helping the customer. Goodbye.
    </Say>
    <Hangup/>
</Response>