<?
$path = '..';

require($path.'/_common.php');

if ($_POST['act']=='ins') {
	mysql_query('INSERT INTO `ft_album_recommend` SET `aid_fk`='.$_POST['aid'].', `uid_fk`='.$user['uid'].', `reg_date`="'.$ft['date'].'", `reg_time`="'.$ft['time'].'";');
	mysql_query('UPDATE `ft_album` SET `recommend_cnt`=`recommend_cnt`+1 WHERE `aid`='.$_POST['aid'].';');
} else if ($_POST['act']=='del') {
	mysql_query('DELETE FROM `ft_album_recommend` WHERE `aid_fk`='.$_POST['aid'].' AND `uid_fk`='.$user['uid'].';');
	mysql_query('UPDATE `ft_album` SET `recommend_cnt`=`recommend_cnt`-1 WHERE `aid`='.$_POST['aid'].';');
}

echo 'success';
?>
