<?
session_start();

require($ft['path'].'/wall/includes/User.php');
require($ft['path'].'/wall/includes/Wall_Updates.php');

if ($_SESSION['uid']) {
	$session_uid = $_SESSION['uid'];
} else if (get_cookie('auto_login')) {
	$session_uid = get_cookie('auto_login');
}

$is_user = 0;
$is_admin = 0;

if(!empty($session_uid)) {
	$is_user = 1;

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
			$is_admin = 1;
			$user['type_kr'] = '관리자';
			break;
		default :
			$user['type_kr'] = 'Error';
			break;
	}

	if ($user['type_kr']=='Error') {
		alert('Login Error');
		$_POST['logout'] = 1;
	}

	$bean = mysql_fetch_assoc(mysql_query('SELECT SUM(`unitprice`) AS `bean_cnt` FROM `ft_payment` WHERE `uid_fk`='.$user['uid'].';'));
	$track = mysql_fetch_assoc(mysql_query('SELECT SUM(`price`) AS `track` FROM `ft_paid` WHERE `type`="track" AND `uid_fk`='.$user['uid'].';'));
	$present = mysql_fetch_assoc(mysql_query('SELECT SUM(`price`) AS `present` FROM `ft_paid` WHERE `type`="present" AND `uid_fk`='.$user['uid'].';'));
	$user['bean_cnt'] = ($bean['bean_cnt'] / 100) - $track['track'] - $present['present'];
} else {
	if($_POST['user'] && $_POST['passcode']) {
		$user = new User();

		$username = $_POST['user'];
		$password = $_POST['passcode'];
		if (strlen($username) > 0 && strlen($password) > 0)	{
			$login = $user -> User_Login($username,$password);

			if($login) {
				$_SESSION['uid'] = $login;

				if ($_POST['auto_login']) {
					set_cookie('auto_login', $_SESSION['uid'], 86400*30);
				} else {
					set_cookie('auto_login', '', 0);
				}

				location_replace($ft['path']);
			} else {
				alert('Login Error');
				location_replace($ft['path']);
			}
		}
	} else if ($_POST['login']) {
		alert('Login Error');
		location_replace($ft['path']);
	}
}

if ($_POST['logout']) {
	$_SESSION['uid']=''; 
	session_unset();
	if(session_destroy()) {
		set_cookie('auto_login', '', 0);
		location_replace($ft['path']);
	} else {
		alert('Logout Error');
		location_replace($ft['path']);
	}
}
?>
