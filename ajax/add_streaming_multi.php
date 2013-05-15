<?
$path = '..';

require($path.'/_common.php');

$chk = mysql_fetch_assoc(mysql_query('SELECT * FROM `ft_chart` WHERE `tid_fk`='.$_POST['tid'].' AND `year`='.date('Y', $ft['timestamp']).' AND `month`='.date('m', $ft['timestamp']).' AND `day`='.date('d', $ft['timestamp']).';'));

if ($chk['cid']) {
        mysql_query('UPDATE `ft_chart` SET `'.$_POST['target'].'`=`'.$_POST['target'].'`+1 WHERE `tid_fk`='.$_POST['tid'].' AND `year`='.date('Y', $ft['timestamp']).' AND `month`='.date('m', $ft['timestamp']).' AND `day`='.date('d', $ft['timestamp']).';');

        $cid_fk = $chk['cid'];
} else {
        mysql_query('INSERT INTO `ft_chart` SET `tid_fk`='.$_POST['tid'].', `year`='.date('Y', $ft['timestamp']).', `month`='.date('m', $ft['timestamp']).', `day`='.date('d', $ft['timestamp']).', `'.$_POST['target'].'`=1;');

        $cid_fk = mysql_insert_id();
}

$aid = explode(',', $_POST['aid']);
$tid = explode(',', $_POST['tid']);

$cnt = 0;

for ($i=0; $i<$_POST['cnt']; $i++) {
	$album = mysql_fetch_assoc(mysql_query('SELECT * FROM `ft_album` WHERE `aid`='.$aid[$i].';'));
	$track = mysql_fetch_assoc(mysql_query('SELECT * FROM `ft_track` WHERE `tid`='.$tid[$i].';'));
	$artist = mysql_fetch_assoc(mysql_query('SELECT * FROM `users` WHERE `uid`='.$album['uid_fk'].';'));
	$paid_data = @mysql_fetch_assoc(mysql_query('SELECT * FROM `ft_paid` WHERE `uid_fk`='.$user['uid'].' AND `tid_fk`='.$track['tid'].';'));

	if ($track['free_streaming']=='Y' || $paid_data['id']) {
		$is_lyric = $track['lyric'] ? 1 : 0;

		if ($cnt > 0) echo '#';

		echo $track['trackname'].'|'.$artist['username'].'|'.$artist['artistname'].'|'.$album['album_pic'].'|'.$track['track_file'].'|'.$is_lyric;

		$cnt++;
	}
}
?>
