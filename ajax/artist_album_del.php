<?
$path = '..';

require($path.'/_common.php');

$list = mysql_query('SELECT * FROM `ft_track` WHERE `aid_fk`='.$_POST['aid'].';');

for ($i=0; $row=mysql_fetch_array($list); $i++) {
	@unlink($ft['path'].'/upload/track_file/'.$row['track_file']);
}

mysql_query('DELETE FROM `ft_track` WHERE `aid_fk`='.$_POST['aid'].';');
mysql_query('DELETE FROM `ft_album` WHERE `aid`='.$_POST['aid'].';');
?>
