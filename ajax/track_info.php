<?
$path = '..';

require($path.'/_common.php');

$track = mysql_fetch_assoc(mysql_query('SELECT * FROM `ft_track` WHERE `tid`='.$_POST['tid'].';'));
$album = mysql_fetch_assoc(mysql_query('SELECT * FROM `ft_album` WHERE `aid`='.$track['aid_fk'].';'));
$artist = mysql_fetch_assoc(mysql_query('SELECT * FROM `users` WHERE `uid`='.$album['uid_fk'].';'));

echo $album['album_pic'].'|'.$track['trackname'].'|'.$artist['username'].'|'.$artist['artistname'].'|'.$track['price'];
?>
