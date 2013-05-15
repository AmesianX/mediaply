<?
$path = '.';

require($path.'/_common.php');
$uploadDir = '/upload/track_file/';
$track = mysql_fetch_assoc(mysql_query('SELECT * FROM `ft_track` WHERE `tid`='.$_GET['tid'].';'));
$paid_data = mysql_fetch_assoc(mysql_query('SELECT * FROM `ft_paid` WHERE `uid_fk`='.$user['uid'].' AND `tid_fk`='.$track['tid'].';'));

if ($is_admin || $paid_data['id'] || $track['free_download']=='Y') {
	$file_name = $track['trackname'].'.mp3';
	//$file_ref = $ft['path'].'/'.$track['track_file'];
        $file_ref = $uploadDir.$track['track_file'];

	$ie = isset($_SERVER['HTTP_USER_AGENT']) && strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false; 

	if ($ie) $file_name = iconv('UTF-8', 'EUC-KR', $file_name);

	header('Content-Type: application/octet-stream');
	header('Content-Disposition: attachment; filename="'.$file_name.'";');
	header('Content-Transfer-Encoding: binary');
	header('Content-Length: '.(string)(filesize($file_ref)));
	header('Expires: 0');

	if ($ie) {
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Pragma: public');
	} else {
		header('Cache-Control: cache, must-revalidate');
		header('Pragma: no-cache');
	}

	$fp = fopen($file_ref, 'rb');
	fpassthru($fp);
	fclose($fp);
}
?>
