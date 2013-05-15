<?
$path = '..';

require($path.'/_common.php');

if ($_POST['field_name']=='profile_pic') {
	$pic_dir = $ft['wall_path'].'/wall/'.$_POST['field_name'];
} else if ($_POST['field_name']=='artist_bg') {
	$pic_dir = $ft['path'].'/upload/'.$_POST['field_name'];
} else if ($_POST['field_name']=='recommend_pic') {
	$pic_dir = $ft['path'].'/upload/'.$_POST['field_name'];
}

@mkdir($pic_dir, 0707);
@chmod($pic_dir, 0707);

if ($user[$_POST['field_name']] && $user[$_POST['field_name']] != 'default.jpg') {
	@unlink($pic_dir.'/'.$user[$_POST['field_name']]);
	mysql_query('UPDATE `users` SET `'.$_POST['field_name'].'`=null WHERE `uid`='.$user['uid'].';');

	echo '삭제 완료.';
}
?>
