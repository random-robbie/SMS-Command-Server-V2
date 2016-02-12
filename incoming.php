<?php
// SMS Server Commands V2
// By Robert Wiggins
// For use with SMSpi.co.uk API
// Donate something via paypal txt3rob@gmail.com

// functions Include
include ('config.php');
include ('functions.php');

//number to check for authorisation
if (!isset($_REQUEST['from']))
{	
	$error_msg = "You best check yo self before you wreck your self fool";
	echo error_msg($error_msg);
	exit();
}


// is this a SMS if nothing passed for SMS it's via web
if (!isset($_REQUEST['sms']))
{
	$issms = "1";
	$message = str_replace($smskey,"",$_REQUEST['message']);
	$split =  explode(" ",$message);
	$server = $split[1];
	$command = $split[2];
	
	// Convert 44 from to 0
	$ptn = "/^44/";  
	$rpltxt = "0";
	$from = preg_replace($ptn, $rpltxt, $_REQUEST['from']);
} else {
	$issms = "0";
	$from = $_REQUEST['from'];
	$server_name = $_REQUEST['server'];
	$command_name = $_REQUEST['command'];
	
}

//Check Authorisation for execution
$check_auth = check_auth ($authnumber,$from);

if ($check_auth == false)
{
	if ($issms == "1")
	{
		sms ($from,$notauth,$hash);
		exit();
	} else {
		echo error_msg ($notauth);
		exit();
	}
}	

//Check server name exsists
//Grab Server name
if ($issms == "0") { $server = $_REQUEST['server'];}

$check_server = check_server_name ($server,$dbh);

if ($check_server == NULL)
{
	if ($issms == "1")
	{
		sms ($from,"Sorry Server Name Not Found",$hash);
		exit();
	} else {
		echo error_msg ("Sorry that server name has not been found");
		exit();
	}
}	

$server_name = $check_server['server_name'];
$username = $check_server['username'];
$password = $check_server['password'];
$serverip = $check_server['serverip'];

$check_command = check_command_name ($command_name,$dbh);
if ($check_command == NULL)
	{
	if ($issms == "1")
	{
		sms ($from,"Sorry Commnad Name Not Found",$hash);
		exit();
	} else {
		echo error_msg ("Sorry that command name has not been found");
		exit();
	}
}	

$final_command = $check_command['command'];

$executed = execute_command ($serverip,$username,$password,$final_command);


if ($executed == false)
	{
	if ($issms == "1")
	{
		sms ($from,"Sorry there was an error",$hash);
		exit();
	} else {
		echo error_msg ("Sorry there was an error");
		exit();
	}
} else {
	if ($issms == "1")
	{
		sms ($from,"Your Command has been executed",$hash);
		exit();
	} else {
		echo execute_msg ("Command Executed Successfully ");
		exit();
}
}
?>