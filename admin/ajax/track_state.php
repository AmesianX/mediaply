<?
$path = '../..';

require($path.'/_common.php');

$track = mysql_fetch_assoc(mysql_query('SELECT * FROM `ft_track` WHERE `tid`='.$_POST['tid'].';'));
$music_data = '['.$track['artistname'] . ' ' . $track['trackname']. ']';
$music = mysql_fetch_assoc(mysql_query('SELECT music_indr FROM `ft_config`;'));

mysql_query('UPDATE `ft_track` SET `state`="Y" WHERE `tid`='.$_POST['tid'].';');
mysql_query('UPDATE `ft_config` SET `music_indr` = "'. $music['music_indr'] . $music_data . '";');

echo 'success';
?>
