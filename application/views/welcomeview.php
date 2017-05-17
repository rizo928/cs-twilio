<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Twilio Application Prototype</title>

	<style type="text/css">

	::selection { background-color: #E13300; color: white; }
	::-moz-selection { background-color: #E13300; color: white; }

	body {
		background-color: #fff;
		margin: 40px;
		font: 13px/20px normal Helvetica, Arial, sans-serif;
		color: #4F5155;
	}

	a {
		color: #003399;
		background-color: transparent;
		font-weight: normal;
	}

	h1 {
		color: #444;
		background-color: transparent;
		border-bottom: 1px solid #D0D0D0;
		font-size: 19px;
		font-weight: normal;
		margin: 0 0 14px 0;
		padding: 14px 15px 10px 15px;
	}

	code {
		font-family: Consolas, Monaco, Courier New, Courier, monospace;
		font-size: 12px;
		background-color: #f9f9f9;
		border: 1px solid #D0D0D0;
		color: #002166;
		display: block;
		margin: 14px 0 14px 0;
		padding: 12px 10px 12px 10px;
	}

	#body {
		margin: 0 15px 0 15px;
	}

	p.footer {
		text-align: right;
		font-size: 11px;
		border-top: 1px solid #D0D0D0;
		line-height: 32px;
		padding: 0 10px 0 10px;
		margin: 20px 0 0 0;
	}

	#container {
		margin: 10px;
		border: 1px solid #D0D0D0;
		box-shadow: 0 0 8px #D0D0D0;
	}
	</style>
</head>
<body>

<div id="container">
	<h1>Twilio application prototype successfully initialized.</h1>

	<div id="body">
		<p>To use this application, set the following web hooks for your Twilio number.</p>

		<p>Voice and Fax:</p>
		A call comes in Web Hook (POST): <b><i>http://yourURL/first</i></b>

		<p>Messaging:</p>
		A message comes in Web Hook (POST): <b><i>http://yourURL/receivesms</i></b>

		<p><b>CONFIGURATION...</b></p>
		You must configuration the application before using it.  To configure the application go to <b><i>http://yourURL/admin</i></b>

		Alternately, you can directly edit the JSON formatted configuration file located at <b><i>INSTALL_DIRECTORY/filebox.json</i></b>

		<p>You can also send a JSON formatted SMS to the Twilio phone number to change the following parameters: <b><i>validPINS engineerPhone engineerEmail</i></b></p>
		<p>Example 1:</p>
		<p>To change the valid PIN(s) send the following SMS to your Twilio number: 
		<b><i>{"validPINS":["123","456"]}</i></b></p>
		<p>Example 2:</p>
		<p>To change the engineers phone number, send the following SMS: 
		<b><i>{"engineerPhone":"5551238888"}</i></b></p>

		<p></p>
		<p><b>CAUTION:</b> Very little validation is done on the configuration values received via sms/text.</p>
	</div>

	<p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds. <?php echo  (ENVIRONMENT === 'development') ?  'CodeIgniter Version <strong>' . CI_VERSION . '</strong>' : '' ?></p>
</div>

</body>
</html>