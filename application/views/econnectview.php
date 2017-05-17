<?php defined('BASEPATH') OR exit('No direct script access allowed');
  log_message('debug', 'econnectview...');

	header("content-type: text/xml");
  echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";

?>
<Response>
    <Say>
        Please hold while we attempt to connect you to the customer.
    </Say>
  <Dial action="<?php echo base_url('eleaveconference');?>" method="POST">
    <Conference 
      startConferenceOnEnter="true" 
      endConferenceOnExit="true">
      theConferenceID
    </Conference>
  </Dial>
</Response>