<?
$path = '..';

require($path.'/_common.php');

$error = "";
$msg = "";

if (!empty($_FILES['recommend_pic']['error'])) {
	switch($_FILES['recommend_pic']['error']) {
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
} else if (empty($_FILES['recommend_pic']['tmp_name']) || $_FILES['recommend_pic']['tmp_name'] == 'none') {
	$error = 'No file was uploaded..';
} else {
	$pic_info = getimagesize($_FILES['recommend_pic']['tmp_name']);

	switch ($pic_info['2']) {
		case 1:
			$extension = 'gif';
			break;
		case 2:
			$extension = 'jpg';
			break;
		default :
			$error = 'JPG, GIF 파일만 등록하실 수 있습니다.';
			$msg = 'JPG, GIF 파일만 등록하실 수 있습니다.';
			break;
	}

	if (!$error) {
		$pic_dir = $ft['path'].'/upload/recommend_pic';
		@mkdir($pic_dir, 0707);
		@chmod($pic_dir, 0707);

		if ($user['recommend_pic'] && $user['recommend_pic'] != 'default.jpg') {
			@unlink($pic_dir.'/'.$user['recommend_pic']);
			mysql_query('UPDATE `users` SET `recommend_pic`=null WHERE `uid`='.$user['uid'].';');
		}

		$pic_name = $ft['timestamp'].'_'.$user['uid'].'.'.$extension;
		$pic_file = $pic_dir.'/'.$pic_name;

		if (move_uploaded_file($_FILES['recommend_pic']['tmp_name'], $pic_file)) {
			chmod($pic_file, 0606);
			mysql_query('UPDATE `users` SET `recommend_pic`="'.$pic_name.'" WHERE `uid`='.$user['uid'].';');
			$msg .= "추천 사진 등록 완료.";
		}
	}

	@unlink($_FILES['recommend_pic']);
}

echo "{";
echo "error: '" . $error . "',\n";
echo "msg: '" . $msg . "'\n";
echo "}";
?>
