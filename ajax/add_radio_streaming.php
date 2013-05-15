<?
$path = '..';

require($path.'/_common.php');
require($path.'/lib/ShoutcastInfo.class.php');

header('Content-Type: text/html; charset=UTF-8');

//$album = mysql_fetch_assoc(mysql_query('SELECT * FROM `ft_album` WHERE `aid`='.$_POST['aid'].';'));
//$track = mysql_fetch_assoc(mysql_query('SELECT * FROM `ft_track` WHERE `tid`='.$_POST['tid'].';'));
//$artist = mysql_fetch_assoc(mysql_query('SELECT * FROM `users` WHERE `uid`='.$album['uid_fk'].';'));

//$schedule = mysql_fetch_assoc(mysql_query('SELECT * FROM `ft_schedule` WHERE `s_id`='.$_POST['sid'].';'));

$schedule['s_file'] = "http://r0.inlive.co.kr:11020/";

$arr_url = parse_url($schedule['s_file']);

$url = $arr_url['host'];
$port = $arr_url['port'];

$scs = &new ShoutcastInfo($url,$port);
if( !$scs->connect())
{
  die($scs->error(TRUE));
}

$scs->send();

$data = $scs->parse();

$data['track'] = iconv("EUC-KR","UTF-8",$data['track']);
$data['title'] = iconv("EUC-KR","UTF-8",$data['title']);

//$is_lyric = $track['lyric'] ? 1 : 0;
//echo $track['trackname'].'|'.$artist['username'].'|'.$artist['artistname'].'|'.$album['album_pic'].'|'.$track['track_file'].'|'.$is_lyric;
echo $schedule['s_file'].'|'.$data['status'].'|'.$data['listener_max'].'|'.$data['listener'].'|'.$data['title'].'|'.$data['track'];
?>
