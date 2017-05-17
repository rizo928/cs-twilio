<?php defined('BASEPATH') OR exit('No direct script access allowed');
  log_message('debug', 'unsatisfiedcustomerview...');

	header("content-type: text/xml");
  echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";

?>
<Response>
    <Say>
        Our engineers are busy and will contact you later. Good luck Mr. Customer and Goodbye.
    </Say>
    <Hangup/>
</Response>