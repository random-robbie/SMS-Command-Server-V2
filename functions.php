<?php
// SMS Server Commands V2
// By Robert Wiggins
// For use with SMSpi.co.uk API
// Donate something via paypal txt3rob@gmail.com

require __DIR__ . '/vendor/autoload.php';
use \Curl\Curl;
use phpseclib\Net\SSH2;

function sms ($sender,$message,$hash)
{
$curl = new Curl();
$curl->setUserAgent('SMS Command Server V2');
$curl->post('http://www.smspi.co.uk/api/send/', array(
    'hash' => $hash,
    'to' => $sender,
	'message' => $message,
));

if ($curl->error) {
    echo 'Error: ' . $curl->errorCode . ': ' . $curl->errorMessage;
}
else {
	$decode = json_decode($curl->rawResponse);
    if ($decode[0]->error == false)
{
	echo $decode[0]->info;
} else
{
	echo $decode[0]->message;
}
}
		

}

function execute_command ($serverip,$username,$password,$command)
{
$ssh = new SSH2($serverip);
if (!$ssh->login($username, $password)) {
	return false;
    exit();
}

$ssh->exec($command);

}


function debug ($message)
{
			$fp = fopen("error.txt","a");
			fwrite($fp,$message);
			fclose($fp);
			}
			
			
function listservers($dbh)
{
//List Servers
$serverlist = $dbh->prepare('SELECT * FROM `servers`');
$serverlist->execute();
return $serverlist;
}

function countservers ($dbh)
{
$countservers = $dbh->prepare('SELECT * FROM `servers`');
$countservers->execute();
$count = $countservers->rowCount();
return $count;
}

function countcommands ($dbh)
{
$countcommands = $dbh->prepare('SELECT * FROM `commands`');
$countcommands->execute();
$count = $countcommands->rowCount();
return $count;
}

function listcommands ($dbh)
{
//DB look up for command
$commandlist = $dbh->prepare('SELECT * FROM `commands`');
$commandlist->execute();
return $commandlist;
}

function check_auth ($authnumber,$from)
{
	if (in_array($from, $authnumber))
		$auth = true;
	return $auth;
}

function error_msg ($message)
{
	$error_msg = '
            <div class="row" ><div class="col-lg-4">
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            Error: '.$message.'
                        </div>
                       
                        
                    </div> <!-- /.col-lg-4 -->
                </div>';
	return $error_msg;
}

function execute_msg ($message)
{
	$execute_msg = '
            <div class="row">
                <div class="col-lg-4">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            '.$message.'
                        </div>
                        
                    </div>
                    <!-- /.col-lg-4 -->
                </div>';
	return $execute_msg;
}

function check_server_name ($server,$dbh)
{
//DB look up for server name
$check = $dbh->prepare('SELECT * FROM `servers` WHERE `server_name` = :server_name');
$check->bindParam(':server_name', $server);
$check->execute();
$count = $check->rowCount();
if ($count != "0")
{
	$result = $check->fetch(PDO::FETCH_ASSOC);
	return $result;
} 
}

function check_command_name ($command_name,$dbh)
{
//DB look up for command name
$check = $dbh->prepare('SELECT * FROM `commands` WHERE `command_name` = :command_name');
$check->bindParam(':command_name', $command_name);
$check->execute();
$count = $check->rowCount();
if ($count != "0")
{
	$result = $check->fetch(PDO::FETCH_ASSOC);
	return $result;
} 
}

	
			?>