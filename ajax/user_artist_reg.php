<?
$path = '..';

require($path.'/_common.php');

$result = '';

if ($_POST['artistname_chk'] == 0) {
	mysql_query('UPDATE `users` SET `artistname`="'.$_POST['artistname'].'", `label`="'.$_POST['label'].'", `gid_fk1`="'.$_POST['gid_fk1'].'", `gid_fk2`="'.$_POST['gid_fk2'].'", `introduce`="'.$_POST['introduce'].'", `bank_name`="'.$_POST['bank_name'].'", `bank_account`="'.$_POST['bank_account'].'", `bank_holder`="'.$_POST['bank_holder'].'", `type`="artist" WHERE `uid`='.$user['uid'].';');
	$result .= '0';	//등록완료.
} else if ($_POST['artistname_chk'] == 1) {
	$result .= '1';	//아티스트명 형식 오류.
} else if ($_POST['artistname_chk'] == 2) {
	$result .= '2';	//아티스트명 중복.
} else if ($_POST['artistname_chk'] == 3) {
	$result .= '3';	//아티스트명 2자 미만.
}

echo $result;
?>
