<?php


function sms ($sender,$message)
{

		

}

function debug ($message)
{
			$fp = fopen("error.txt","a");
			fwrite($fp,$message);
			fclose($fp);
			}
	
			?>