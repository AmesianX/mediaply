<?
$path = '..';

require($path.'/_common.php');

$chk = mysql_fetch_assoc(mysql_query('SELECT * FROM `ft_playlist` WHERE `tid_fk`='.$_POST['tid'].' AND `uid_fk`='.$user['uid'].';'));

mysql_query('UPDATE `ft_chart` SET `playlist_cnt`=`playlist_cnt`-1 WHERE `cid`='.$chk['cid_fk'].';');

mysql_query('DELETE FROM `ft_playlist` WHERE `pid`='.$chk['pid'].';');

echo 'success';
?>
