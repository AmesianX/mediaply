<?
$db_server = 'localhost';
$db_username = [your account];
$db_password = [your password];
$db_name = [your db];

$db_conn = mysql_connect($db_server, $db_username, $db_password) or die('error : mysql_connect');
mysql_select_db($db_name, $db_conn) or die('error : mysql_select_db');
?>
