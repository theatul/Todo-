<?php

/* Database config */

$db_host		= '127.0.0.1';
$db_user		= 'root';
$db_pass		= '';
$db_database	= 'appytodo1'; 

/* End config */


$link = @mysql_connect($db_host,$db_user,$db_pass) or die('Unable to establish a DB connection');

mysql_set_charset('utf8');
mysql_select_db($db_database,$link);

?>
