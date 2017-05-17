<?php defined('BASEPATH') OR exit('No direct script access allowed');
  log_message('debug', 'contactengineerview...');

	header("content-type: text/xml");
  echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";

?>
<Response>
    <Say>
        Please hold while we attempt to connect you with an engineer.
    </Say>
  <Dial action="<?php echo base_url('handleleaveconference');?>" method="POST">
    <Conference 
      startConferenceOnEnter="false" 
      endConferenceOnExit="true"
      statusCallback="<?php echo base_url('conferencestatus');?>"
      statusCallbackEvent="start end"
      waitUrl = 'http://twimlets.com/holdmusic?Bucket=com.twilio.music.ambient'>
      theConferenceID
    </Conference>
  </Dial>
</Response>
