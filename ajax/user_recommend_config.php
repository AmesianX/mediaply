<?
$path = '..';

require($path.'/_common.php');

$result = '';

if ($_POST['is_secret'] != $user['is_secret']) {
	mysql_query('UPDATE `users` SET `is_secret`="'.$_POST['is_secret'].'" WHERE `uid`='.$user['uid'].';');
	$result .= '0';	//변경완료.
}

$result .= '|';

if ($_POST['recommend_name'] != $user['recommend_name']) {
	mysql_query('UPDATE `users` SET `recommend_name`="'.$_POST['recommend_name'].'" WHERE `uid`='.$user['uid'].';');
	$result .= '0';	//변경완료.
}

$result .= '|';

if ($_POST['recommend_introduce'] != $user['recommend_introduce']) {
	mysql_query('UPDATE `users` SET `recommend_introduce`="'.$_POST['recommend_introduce'].'" WHERE `uid`='.$user['uid'].';');
	$result .= '0';	//변경완료.
}

echo $result;
?>
