<?
$path = '..';

require($path.'/_common.php');

if ($_POST['reg']) {
	mysql_query('INSERT INTO `ft_album` SET `uid_fk`='.$user['uid'].', `gid_fk`='.$_POST['gid_fk'].', `albumname`="'.$_POST['albumname'].'", `explain`="'.$_POST['explain'].'", `artistname`="'.$_POST['artistname'].'", `reg_date`="'.$ft['date'].'", `reg_time`="'.$ft['time'].'";');

	echo mysql_insert_id();
} else if ($_POST['mod']) {
	mysql_query('UPDATE `ft_album` SET `uid_fk`='.$user['uid'].', `gid_fk`='.$_POST['gid_fk'].', `albumname`="'.$_POST['albumname'].'", `explain`="'.$_POST['explain'].'", `artistname`="'.$_POST['artistname'].'", `reg_date`="'.$ft['date'].'", `reg_time`="'.$ft['time'].'" WHERE `aid`='.$_POST['aid'].';');

	echo $_POST['aid'];
}
?>
