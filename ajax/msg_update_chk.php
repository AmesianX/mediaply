<?
$path = '..';

require($path.'/_common.php');

$result = mysql_fetch_assoc(mysql_query('SELECT count(*) AS `cnt` FROM `messages` WHERE `msg_id`>'.$_POST['msg_id'].';'));
$msg_id = mysql_fetch_assoc(mysql_query('SELECT * FROM `messages` WHERE `msg_id`>'.$_POST['msg_id'].' ORDER BY `msg_id` LIMIT 0, 1;'));

echo $result['cnt'].'|'.$msg_id['msg_id'];
?>
