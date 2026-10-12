<?php
//ob_start("ob_gzhandler");
error_reporting(0);
session_start();

/* DATABASE CONFIGURATION */
define('DB_SERVER', 'unibronertbackup.mysql.db');
define('DB_USERNAME', 'unibronertbackup');
define('DB_PASSWORD', 'Momo08545547');
define('DB_DATABASE', 'unibronertbackup');
define("BASE_URL", "http://delisso.createam.tn/mobile/api/");
define("SITE_KEY", 'yourSecretKey');

// define('DB_SERVER', 'melservioqhotel.mysql.db');
// define('DB_USERNAME', 'melservioqhotel');
// define('DB_PASSWORD', 'Momo08545547');
// define('DB_DATABASE', 'melservioqhotel');
// define("BASE_URL", "http://delisso.createam.tn/mobile/api/");
// define("SITE_KEY", 'yourSecretKey');




function getDB() 
{
	$dbhost=DB_SERVER;
	$dbuser=DB_USERNAME;
	$dbpass=DB_PASSWORD;
	$dbname=DB_DATABASE;
	$dbConnection = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);	
	$dbConnection->exec("set names utf8");
	$dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	return $dbConnection;
}
/* DATABASE CONFIGURATION END */

/* API key encryption */
function apiToken($session_uid)
{
$key=md5(SITE_KEY.$session_uid);
return hash('sha256', $key);
}



?>