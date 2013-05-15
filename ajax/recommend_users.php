<?
$path = '..';

require($path.'/_common.php');

if ($_POST['act']=='ins') {
	mysql_query('INSERT INTO `users_recommend` SET `target_uid_fk`='.$_POST['uid'].', `uid_fk`='.$user['uid'].', `reg_date`="'.$ft['date'].'", `reg_time`="'.$ft['time'].'";');
	mysql_query('UPDATE `users` SET `recommend_cnt`=`recommend_cnt`+1 WHERE `uid`='.$_POST['uid'].';');
} else if ($_POST['act']=='del') {
	mysql_query('DELETE FROM `users_recommend` WHERE `target_uid_fk`='.$_POST['uid'].' AND `uid_fk`='.$user['uid'].';');
	mysql_query('UPDATE `users` SET `recommend_cnt`=`recommend_cnt`-1 WHERE `uid`='.$_POST['uid'].';');
}

echo 'success';
?>
