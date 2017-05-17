<?php defined('BASEPATH') OR exit('No direct script access allowed');
  log_message('debug', 'erejectview...');

	header("content-type: text/xml");
  echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";

?>
<Response>
    <Say>
        Customer call rejected. Continue with your golf game. Goodbye.
    </Say>
    <Hangup/>
</Response>