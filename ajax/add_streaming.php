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

$album = mysql_fetch_assoc(mysql_query('SELECT * FROM `ft_album` WHERE `aid`='.$_POST['aid'].';'));
$track = mysql_fetch_assoc(mysql_query('SELECT * FROM `ft_track` WHERE `tid`='.$_POST['tid'].';'));
$artist = mysql_fetch_assoc(mysql_query('SELECT * FROM `users` WHERE `uid`='.$album['uid_fk'].';'));

$is_lyric = $track['lyric'] ? 1 : 0;

//$login = 'mediaply';
//$pass = 'vmffkdl8605';

//$PHP_AUTH_USER=$login;
//$PHP_AUTH_PW=$pass;

//$_SERVER['PHP_AUTH_USER'] =$login;
//$_SERVER['PHP_AUTH_PW']= $pass;
//$_SERVER['HTTP_AUTHORIZATION'] = 'Basic bWVkaWFwbHk6dm1mZmtkbDg2MDU=';
echo $track['trackname'].'|'.$artist['username'].'|'.$artist['artistname'].'|'.$album['album_pic'].'|'.'/upload/track_file/'.$track['track_file'].'|'.$is_lyric;
?>
