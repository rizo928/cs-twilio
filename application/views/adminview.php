<html>
<head>
<title>TWILIO DEMO APPLICATION ADMIN</title>
</head>
<body>

<?php echo validation_errors(); ?>

<?php 
	// echo form_open('form');
	echo form_open('admin'); 
?>

<p><h2>Please update the application configuration below...</h2></p>

<h5>validPINS - caller pin(s).  To specify multiple, use JSON e.g. ["123","4034"]</h5>
<input type="text" name="validPINS_field" value="<?php echo set_value('validPINS_field',json_encode($validPINS)); ?>" size="50" />

<h5>engineerPhone - phone number to use when contacting an engineer (E.164 number format)<h5>
<input type="text" name="engineerPhone_field" value="<?php echo set_value('engineerPhone_field',$engineerPhone); ?>" size="50" />

<h5>engineerEmail - email address to use when sending the customer callback number and recording to the engineer</h5>
<input type="text" name="engineerEmail_field" value="<?php echo set_value('engineerEmail_field',$engineerEmail); ?>" size="50" />

<p>
<div><input type="submit" value="Submit" /></div>

</form>

</body>
</html>