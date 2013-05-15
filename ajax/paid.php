<?
$path = '..';

require($path.'/_common.php');

if ($_POST['type']=='track') {
	$track = mysql_fetch_assoc(mysql_query('SELECT * FROM `ft_track` WHERE `tid`='.$_POST['tid'].';'));
	$album = mysql_fetch_assoc(mysql_query('SELECT * FROM `ft_album` WHERE `aid`='.$track['aid_fk'].';'));
	$artist = mysql_fetch_assoc(mysql_query('SELECT * FROM `users` WHERE `uid`='.$album['uid_fk'].';'));

	$chk = mysql_fetch_assoc(mysql_query('SELECT * FROM `ft_paid` WHERE `uid_fk`='.$user['uid'].' AND `tid_fk`='.$track['tid'].';'));

	if ($chk['id']) {
		echo 'overlap';
		exit;
	} else {
		$tid_fk = '`tid_fk`='.$track['tid'].',';
		$artist_uid_fk = $artist['uid'];
		$price = $track['price'];
	}
} else if ($_POST['type']=='present') {
	$artist_uid_fk = $_POST['artist_uid_fk'];
	$price = $_POST['cnt'] * 10;
}

if ($user['bean_cnt'] < $price) {
	echo 'shortage';
	exit;
}

mysql_query('INSERT INTO `ft_paid` SET `type`="'.$_POST['type'].'", `uid_fk`='.$user['uid'].', `artist_uid_fk`='.$artist_uid_fk.', '.$tid_fk.' `price`='.$price.', `paid_date`="'.$ft['date'].'", `paid_time`="'.$ft['time'].'";');
echo 'success|'.($user['bean_cnt']-$price);
?>
