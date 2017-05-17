# cs-twilio

This is a sample customer service application written for
the twilio.com environment.  The basic call flow
of the application is as follows:

1. Customer dials into the application
2. Customer is greeted and asked to enter a PIN
3. The PIN is validate
4. The customer is asked to provide a call back number
   just in case they aren't connected to an engineer.
5. The customer is asked to record a message detailing
   there specific needs.
6. An email is sent to the engineer containing the
   callback number and a copy of the recorded message.
7. The customer is placed on hold.
8. The application calls an engineer
9. The engineer is given the choice to accept or
   reject the customer service request.
10. If they accept, they are conferenced in with the
    customer.
11. If they reject, the customer is informed that
    they will receive a callback and then hung up on.

The application is written in PHP using Twilio's PHP
language wrapper where possible.

The application is desiged and written for the
CodeIgniter 3.x framework, though it really isn't
used much and could just as easily be done away with.

This is a sample application only.  If used as a basis
for a production application, be aware that in it's
current state it isn't "multi-call/thread" safe. In
other words, multiple simultaneous calls into the app
could cause issues.  The code has comments in it as
to how this could be addressed.

The basic steps to setup the environment and install the
application are as follows:

1. Setup a webserver environment with PHP.  The Docker
   container utilized to run and test this app is:

   		rizo928/alpine-apache-php

   It is available as an automated build from Docker hub.
   The container is based on Alpine Linux, PHP 7 and
   Appache 2.  See the github repository (same name) for
   details around the build environment.

2. Configure a ssmtp server if you want to receive
   email from the application (included as part
   of the afore mentioned Docker container)

2. Download, install and test Codeigniter 3.x

3. Create a .htaccess file to eliminate the index.php
   requirement for Codeigniter (directions on their
   website or just Google it)

4. Update the Codeigniter config.php file to include:

	$config['base_url'] = 'https://yourserver.com/';
	$config['index_page'] = '';    <<--- must be blank

5. Edit Codeigniter autoload.php file to include:

	$autoload['libraries'] = array('FileBox');

	$autoload['helper'] = array('url');

	FileBox is a simple pure json file based database
	that is used for this prototype/demo for simplicity.
	A production application should update the code anywhere
	FileBox is used to access a real database.

6. Install the Twilio REST API w/PHP lanugage wrapper

7. Pull this repository into the directory where
   code igniter was installed

8. Edit the filebox.json file

	"twilioSEID":"your-twilio-account-id","twilioToken":"your-twilio-token"

	Replace the dummy values with your twilio
	account SID and token.  And remember this now exists in
	an unencrypted form on disk, so be careful.

9. Point you browser at https://yourserver.com/admin

	This should bring up an admin page where you can finish
	setting up the various configuration items needed by the
	application.  

	If the page doesn't come up, it's probably
	an issue with your server or the codeigniter setup.  A
	common problem would be that the .htaccess file is not
	setup correctly to eliminate the index.php file.  Try
	https://yourserver.com/index.php/admin and see if it works.
	If so, than that's your problem.


10. Point your provisioned Aculab phone number at:

	https://yourserver.com/first
	https://yourserver.com/final

11. Dial in and see if it works.

