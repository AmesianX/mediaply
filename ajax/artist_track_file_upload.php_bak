<?
$path = '..';

require($path.'/_common.php');

$error = "";
$msg = "";

if (!empty($_FILES['track_file']['error'])) {
	switch($_FILES['track_file']['error']) {
		case '1':
			$error = 'The uploaded file exceeds the upload_max_filesize directive in php.ini';
			break;
		case '2':
			$error = 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form';
			break;
		case '3':
			$error = 'The uploaded file was only partially uploaded';
			break;
		case '4':
			$error = 'No file was uploaded.';
			break;
		case '6':
			$error = 'Missing a temporary folder';
			break;
		case '7':
			$error = 'Failed to write file to disk';
			break;
		case '8':
			$error = 'File upload stopped by extension';
			break;
		case '999':
		default:
			$error = 'No error code avaiable';
	}
} else if (empty($_FILES['track_file']['tmp_name']) || $_FILES['track_file']['tmp_name'] == 'none') {
	$error = 'No file was uploaded..';
} else {
	$file_info = pathinfo($_FILES['track_file']['name']);

	switch ($file_info['extension']) {
		case 'mp3':
			$extension = 'mp3';
			break;
		default :
			$error = 'MP3 파일만 등록하실 수 있습니다.';
			$msg = 'MP3 파일만 등록하실 수 있습니다.';
			break;
	}

	if (!$error) {               
                if(!is_dir($file_dir_y))
                {
                  @mkdir($file_dir_y,0706);
                }
                if(!is_dir($file_dir_m))
                {
                  @mkdir($file_dir_m,0706);
                }
		//@mkdir($file_dir, 0706);
		//@chmod($file_dir, 0706);

		$track = mysql_fetch_assoc(mysql_query('SELECT * FROM `ft_track` WHERE `tid`='.$_GET['tid'].';'));

		if ($track['track_file']) {
			@unlink($file_dir_m.'/'.$track['track_file']);
			mysql_query('UPDATE `ft_track` SET `track_file`=null WHERE `tid`='.$track['tid'].';');
		}

		$file_name = $ft['timestamp'].'_'.$track['tid'].'.'.$extension;
		$file_file = $file_dir_m.'/'.$file_name;
                $file_path = $ft['upload'].$ft['year'].'/'.$ft['month'].'/'.$file_name;

		if (move_uploaded_file($_FILES['track_file']['tmp_name'], $file_file)) {
			chmod($file_file, 0606);
			mysql_query('UPDATE `ft_track` SET `track_file`="'.$file_path.'", `state`="N" WHERE `tid`='.$track['tid'].';');
			$msg .= "트랙파일 등록 완료.";
		}
	}

	@unlink($_FILES['track_file']);
}

echo "{";
echo "error: '" . $error . "',\n";
echo "msg: '" . $msg . "'\n";
echo "}";
?>
