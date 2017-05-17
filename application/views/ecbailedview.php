<?php defined('BASEPATH') OR exit('No direct script access allowed');
  log_message('debug', 'ecbailedview...');

	header("content-type: text/xml");
  echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";

?>
<Response>
    <Say>
        The customer bailed, so you're off the hook. Goodbye.
    </Say>
    <Hangup/>
</Response>