<?
$path = '..';

require($path.'/_common.php');

if ($_POST['reg']) {
	mysql_query('INSERT INTO `ft_track` SET `aid_fk`='.$_POST['aid_fk'].', `gid_fk`='.$_POST['gid_fk'].', `trackname`="'.$_POST['trackname'].'", `lyric`="'.$_POST['lyric'].'", `price`="'.$_POST['price'].'", `track_file`="'.$_POST['filename'].'", `artistname`="'.$_POST['artistname'].'", `free_download`="'.($_POST['free_download']=='Y'?'Y':'N').'", `free_streaming`="'.($_POST['free_streaming']=='Y'?'Y':'N').'", `state`="N", `reg_date`="'.$ft['date'].'", `reg_time`="'.$ft['time'].'";');

	echo mysql_insert_id();
} else if ($_POST['mod']) {
	mysql_query('UPDATE `ft_track` SET `aid_fk`='.$_POST['aid_fk'].', `gid_fk`='.$_POST['gid_fk'].', `trackname`="'.$_POST['trackname'].'", `lyric`="'.$_POST['lyric'].'", `price`="'.$_POST['price'].'", `track_file`="'.$_POST['filename'].'", `artistname`="'.$_POST['artistname'].'", `free_download`="'.($_POST['free_download']=='Y'?'Y':'N').'", `free_streaming`="'.($_POST['free_streaming']=='Y'?'Y':'N').'", `state`="N" WHERE `tid`='.$_POST['tid'].';');

	echo $_POST['tid'];
}
?>
