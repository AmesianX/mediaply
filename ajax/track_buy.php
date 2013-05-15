<?
$path = '..';

require($path.'/_common.php');

$track = mysql_fetch_assoc(mysql_query('SELECT * FROM `ft_track` WHERE `tid`='.$_POST['tid'].';'));
$album = mysql_fetch_assoc(mysql_query('SELECT * FROM `ft_album` WHERE `aid`='.$track['aid_fk'].';'));
$artist = mysql_fetch_assoc(mysql_query('SELECT * FROM `users` WHERE `uid`='.$album['uid_fk'].';'));

$chk = mysql_fetch_assoc(mysql_query('SELECT * FROM `ft_paid` WHERE `uid_fk`='.$user['uid'].' AND `tid_fk`='.$track['tid'].';'));

if ($chk['id']) {
	echo 'overlap';
} else {
	if ($user['bean_cnt'] < $track['price']) {
		echo 'shortage';
		exit;
	}

	mysql_query('INSERT INTO `ft_paid` SET `uid_fk`='.$user['uid'].', `artist_uid_fk`='.$artist['uid'].', `tid_fk`='.$track['tid'].', `price`='.$track['price'].', `paid_date`="'.$ft['date'].'", `paid_time`="'.$ft['time'].'";');
	echo 'success|'.($user['bean_cnt']-$track['price']);
}
?>
