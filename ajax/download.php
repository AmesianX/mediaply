<?
$path = '..';

require($path.'/_common.php');

$obj = mysql_fetch_assoc(mysql_query('SELECT * FROM `ft_track` WHERE `tid`='.$_GET['tid'].';'));

if ($is_admin || $obj['free_download']=='Y') {
	$file_name = $obj['trackname'].'.mp3';
	$file_ref = $ft['path'].'/upload/track_file/'.$obj['track_file'];

	header('Content-Type: application/octet-stream');
	header('Content-Disposition: attachment; filename='.iconv('UTF-8', 'EUC-KR', $file_name).';');
	header('Content-Transfer-Encoding: binary');
	header('Content-Length: '.(string)(filesize($file_ref)));
	header('Cache-Control: cache, must-revalidate');
	header('Pragma: no-cache');
	header('Expires: 0');

	$fp = fopen($file_ref, 'rb');
	while (!feof($fp)) {
		echo fread($fp, 100*1024);
	}
	fclose($fp);
	flush();
}
?>
