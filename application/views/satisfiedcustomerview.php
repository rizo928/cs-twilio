<?php defined('BASEPATH') OR exit('No direct script access allowed');
  log_message('debug', 'satisfiedcallerview...');

	header("content-type: text/xml");
  echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";

?>
<Response>
    <Say>
        Thanks for letting us assist you. Goodbye.
    </Say>
    <Hangup/>
</Response>