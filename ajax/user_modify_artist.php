<?
$path = '..';

require($path.'/_common.php');

$result = '';

if ($_POST['artistname'] != $user['artistname']) {
	if ($_POST['artistname_chk'] == 0) {
		mysql_query('UPDATE `users` SET `artistname`="'.$_POST['artistname'].'" WHERE `uid`='.$user['uid'].';');
		$result .= '0';	//변경완료.
	} else if ($_POST['artistname_chk'] == 1) {
		$result .= '1';	//아티스트명 형식 오류.
	} else if ($_POST['artistname_chk'] == 2) {
		$result .= '2';	//아티스트명 중복.
	} else if ($_POST['artistname_chk'] == 3) {
		$result .= '3';	//아티스트명 2자 미만.
	}
}

$result .= '|';

if ($_POST['label'] != $user['label']) {
	mysql_query('UPDATE `users` SET `label`="'.$_POST['label'].'" WHERE `uid`='.$user['uid'].';');
	$result .= '0';	//변경완료.
}

$result .= '|';

if ($_POST['gid_fk1'] != $user['gid_fk1']) {
	mysql_query('UPDATE `users` SET `gid_fk1`="'.$_POST['gid_fk1'].'" WHERE `uid`='.$user['uid'].';');
	$result .= '0';	//변경완료.
}

$result .= '|';

if ($_POST['gid_fk2'] != $user['gid_fk2']) {
	mysql_query('UPDATE `users` SET `gid_fk2`="'.$_POST['gid_fk2'].'" WHERE `uid`='.$user['uid'].';');
	$result .= '0';	//변경완료.
}

$result .= '|';

if ($_POST['introduce'] != $user['introduce']) {
	mysql_query('UPDATE `users` SET `introduce`="'.$_POST['introduce'].'" WHERE `uid`='.$user['uid'].';');
	$result .= '0';	//변경완료.
}

$result .= '|';

if ($_POST['bank_name'] != $user['bank_name']) {
	mysql_query('UPDATE `users` SET `bank_name`="'.$_POST['bank_name'].'" WHERE `uid`='.$user['uid'].';');
	$result .= '0';	//변경완료.
}

$result .= '|';

if ($_POST['bank_account'] != $user['bank_account']) {
	mysql_query('UPDATE `users` SET `bank_account`="'.$_POST['bank_account'].'" WHERE `uid`='.$user['uid'].';');
	$result .= '0';	//변경완료.
}

$result .= '|';

if ($_POST['bank_holder'] != $user['bank_holder']) {
	mysql_query('UPDATE `users` SET `bank_holder`="'.$_POST['bank_holder'].'" WHERE `uid`='.$user['uid'].';');
	$result .= '0';	//변경완료.
}

echo $result;
?>
