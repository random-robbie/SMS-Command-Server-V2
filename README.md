sms-command-server V2
==================

Send a SMS or use this webpage to send pre-set commands to your servers.

Logs in via SSH so nice and secure and this setup can be on a different server.


![Alt text](http://i1257.photobucket.com/albums/ii502/laird9961/screenshot.jpg_zpsyaqksoea.png "Screenshot")

Add servers to the database via phpmyadmin.

Register on http://www.smspi.co.uk/ and set the POST TO url to http://yourserver/incoming.php

Send a SMS with your key word i.e "HADS9 server1 reboot" and it will text back to say if the server has been rebooted.

That go to the webpage url and enter your authorised mobile number and it will let you execute the command with out displaying the server ip or details.

Installation
----

Edit config.php with your database details and SMSPI hash.
Put your mobile number or mobile numbers in to 

```
Single number

$authnumber = array ("0771245589");

Multiple Numbers

$authnumber = array ("0771245589,0745158745,0774547898");

```

Import commands.sql to your database 

Easiest to be done via phpmyadmin

TO DO
----

Work a way to make it allow spaces for command names.
Add History Page to see what commands have been sent or if they have been authorised or not.

