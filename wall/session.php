<?php
session_start();

if ($_SESSION['uid']) {
	$session_uid = $_SESSION['uid'];
} else if (get_cookie('auto_login')) {
	$session_uid = get_cookie('auto_login');
}

$is_user = 0;

if (!empty($session_uid)) {
	$is_user = 1;

	$uid = $session_uid;

	$Wall = new Wall_Updates();
	$UserDetails = $Wall -> User_Details($session_uid);
	$friend_count = $UserDetails['friend_count'];

	$user = mysql_fetch_assoc(mysql_query('SELECT * FROM `users` WHERE `username`="'.$UserDetails['username'].'";'));

	if (!$user['profile_pic']) $user['profile_pic'] = 'default.jpg';

	switch($user['type']) {
		case 'listener' :
			$user['type_kr'] = '리스너';
			break;
		case 'artist' :
			$user['type_kr'] = '아티스트';
			break;
		case 'admin' :
			$user['type_kr'] = '관리자';
			break;
		default :
			$user['type_kr'] = 'Error';
			break;
	}

	if ($user['type_kr']=='Error') {
		alert('Login Error');
		location_replace($ft['path']);
	}
} else {
	alert('로그인 해주세요.');
	location_replace($ft['path']);
}

if ($_GET['username']) {
	$profile = mysql_fetch_assoc(mysql_query('SELECT * FROM `users` WHERE `username`="'.$_GET['username'].'";'));
} else {
	$profile = mysql_fetch_assoc(mysql_query('SELECT * FROM `users` WHERE `username`="'.$user['username'].'";'));
}

if (!$profile['profile_pic']) $profile['profile_pic'] = 'default.jpg';

if ($user['username'] == $profile['username']) $is_mypage = 1;
else $is_mypage = 0;
?>
