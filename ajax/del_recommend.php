<?
$path = '..';

require($path.'/_common.php');

$chk = mysql_fetch_assoc(mysql_query('SELECT * FROM `ft_recommend` WHERE `tid_fk`='.$_POST['tid'].' AND `uid_fk`='.$user['uid'].';'));

mysql_query('UPDATE `ft_chart` SET `recommend_cnt`=`recommend_cnt`-1 WHERE `cid`='.$chk['cid_fk'].';');

mysql_query('DELETE FROM `ft_recommend` WHERE `rid`='.$chk['rid'].';');

$result = mysql_fetch_assoc(mysql_query('SELECT * FROM `ft_track` WHERE `tid`='.$_POST['tid'].';'));
echo $result['trackname'];
?>
