<?php defined('BASEPATH') OR exit('No direct script access allowed');
	log_message('debug', 'errorview...');

	header("content-type: text/xml");
  echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
?>
<Response>
  <Say> Error in our application.  Goodbye. </Say>
  <Hangup/>
</Response>