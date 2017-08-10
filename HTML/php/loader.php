<?php
ini_set('display_errors','0');
require_once("session.inc");
require_once("mysql.inc");
require_once("db.inc");
require_once("JSON.php");
require_once("userfunctions.inc");
require_once("paging.inc");
require_once("session.inc");
require_once("mailer.php");


define("_HOSTNAME", "localhost");
define("_USERNAME", "root");
define("_PASSWORD", "Acgchennai#1");
define("_DATABASE", "etww-v2");


$sesobj=new SESSION_MANAGEMENT();

/** Create database object */
$sqlobj=new dbconn(_HOSTNAME, _USERNAME, _PASSWORD, _DATABASE);

/** Create UserFunctions object */
$userobj=new UserFunctions();

/** Create Pageing Object */
$pageobj=new Pageing('5');

define("HTTPS_URL", "http://localhost/");
define("BASE_URL", "http://localhost/");

function dollarfy ($num,$dec) {
	$format="%.$dec" . "f";
	$number=sprintf($format,$num);
	$str=strtok($number,".");
	$dc=strtok(".");
	$str=commify($str);
	$return="$str";

	if ($dec!=0){
		$return = "<img src='".HTTP_URL."assets/img/inr.png' width='8' height='10'> $return" . ".$dc";
	}
	return($return);
}
## Commify Function
function commify ($str)  {
	$n = strlen($str);
	if ($n <= 3) {
			$return=$str;
	}
	else {
			$pre=substr($str,0,$n-3);
			$post=substr($str,$n-3,3);
			$pre=commify($pre);
			$return="$pre,$post";
	}
	return($return);
}


?>
