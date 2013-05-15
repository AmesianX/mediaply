<?
$path = '../..';

require($path.'/_common.php');

for ($i=0; $i<count($_POST['uid']); $i++) {
	mysql_query('UPDATE `users` SET `type`="'.$_POST['type'][$i].'" WHERE `uid`='.$_POST['uid'][$i].';');
	$user_data = mysql_fetch_assoc(mysql_query('SELECT * FROM `users` WHERE `uid`='.$_POST['uid'][$i].';'));
	if ($user_data['type']=='artist' && !$user_data['artistname']) {
		mysql_query('UPDATE `users` SET `artistname`="noname" WHERE `uid`='.$_POST['uid'][$i].';');
	} else if ($user_data['type']!='artist' && $user_data['artistname']) {
		mysql_query('UPDATE `users` SET `artistname`=null WHERE `uid`='.$_POST['uid'][$i].';');
	}
}

location_replace($ft['adm_path'].'/?page='.$_POST['page'].'&p_num='.$_POST['p_num']);
?>
