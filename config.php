<?php
// SMS Server Commands V2
// By Robert Wiggins
// For use with SMSpi.co.uk API
// Donate something via paypal txt3rob@gmail.com

// configuration
$dbtype		= "mysql";
$dbhost 	= "localhost";
$dbname		= "commands";
$dbuser		= "dbuser";
$dbpass		= "dbpass";
$smskey = "";  // NOTE YOU MUST ADD A SPACE FOR THIS TO WORK
$authnumber = array ("");  // ENTER THE MOBILE NUMBERS THAT YOU WISH TO ALLOW TO CONTROL TO PUT A COMMOR BETWEEN THE NUMBERS
$hash = ""; //YOUR SMSPI.CO.UK HASH

// SMS Errors
$notauth = "Sorry you are not authorised to do anything on this server.";
$notfound = "Command not found sorry try again.";

// database connection
$dbh = new PDO("mysql:host=$dbhost;dbname=$dbname",$dbuser,$dbpass);
?>