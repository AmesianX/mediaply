<?
$path = '..';

require($path.'/_common.php');

$track = mysql_fetch_assoc(mysql_query('SELECT * FROM `ft_track` WHERE `tid`='.$_POST['tid'].';'));

@unlink('/upload/track_file/'.$track['track_file']);

mysql_query('DELETE FROM `ft_track` WHERE `tid`='.$_POST['tid'].';');
?>
