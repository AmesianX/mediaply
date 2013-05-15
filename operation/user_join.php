<?
$path = '..';

require($path.'/_common.php');

if($_POST['username'] && $_POST['nickname'] && $_POST['password'] && $_POST['email']) {
	if (strlen($_POST['username']) > 0 && strlen($_POST['password']) > 0 && strlen($_POST['email'])) {
		$User = new User();

		$reg = $User -> User_Registration($_POST['username'], $_POST['password'], $_POST['email']);

		if($reg) {
			mysql_query('UPDATE `users` SET `nickname`="'.$_POST['nickname'].'", `reg_date`="'.$ft['date'].'", `reg_time`="'.$ft['time'].'" WHERE `uid`='.$reg.';');
			$_SESSION['uid'] = $reg;
			location_replace($ft['path']);
		} else {
			alert('회원가입 오류');
			history_back();
		}
	}
}
?>
