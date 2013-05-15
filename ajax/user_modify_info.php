<?
$path = '..';

require($path.'/_common.php');

$result = '';

if ($_POST['nickname'] != $user['nickname']) {
	if ($_POST['nickname_chk'] == 0) {
		mysql_query('UPDATE `users` SET `nickname`="'.$_POST['nickname'].'" WHERE `uid`='.$user['uid'].';');
		$result .= '0';	//변경완료.
	} else if ($_POST['nickname_chk'] == 1) {
		$result .= '1';	//닉네임 형식 오류.
	} else if ($_POST['nickname_chk'] == 2) {
		$result .= '2';	//닉네임 중복.
	} else if ($_POST['nickname_chk'] == 3) {
		$result .= '3';	//닉네임 2자 미만.
	}
}

$result .= '|';

if ($_POST['password'] && $_POST['password_re']) {
	if (strlen($_POST['password']) >= 4 && strlen($_POST['password_re']) >= 4) {
		if ($_POST['password'] == $_POST['password_re']) {
			mysql_query('UPDATE `users` SET `password`="'.md5($_POST['password']).'" WHERE `uid`='.$user['uid'].';');
			$result .= '0';	//변경완료.
		} else {
			$result .= '1';	//비밀번호 불일치.
		}
	} else {
		$result .= '2';	//비밀번호 4자 미만.
	}
}

$result .= '|';

if ($_POST['email'] != $user['email']) {
	if ($_POST['email_chk'] == 0) {
		mysql_query('UPDATE `users` SET `email`="'.$_POST['email'].'" WHERE `uid`='.$user['uid'].';');
		$result .= '0';	//변경완료.
	} else if ($_POST['email_chk'] == 1) {
		$result .= '1';	//이메일 형식 오류.
	} else if ($_POST['email_chk'] == 2) {
		$result .= '2';	//이메일 중복.
	} else if ($_POST['email_chk'] == 3) {
		$result .= '3';	//이메일 5자 미만.
	}
}

$result .= '|';

$bg_repeat = $_POST['bg_repeat'] == 'Y' ? 'Y' : 'N';
if ($bg_repeat != $user['bg_repeat']) {
	mysql_query('UPDATE `users` SET `bg_repeat`="'.$bg_repeat.'" WHERE `uid`='.$user['uid'].';');
	$result .= '0';	//변경완료.
}

$result .= '|';

if ($_POST['mypage_title'] != $user['mypage_title']) {
	mysql_query('UPDATE `users` SET `mypage_title`="'.$_POST['mypage_title'].'" WHERE `uid`='.$user['uid'].';');
	$result .= '0';	//변경완료.
}

echo $result;
?>
