<?
$path = '..';

require($path.'/_common.php');

if (isset($_POST['type']) && isset($_POST['value'])) {
	$type = $_POST['type'];
	$value = $_POST['value'];

	$case_chk = 0;

	if ($type=='username' || $type=='nickname' || $type=='artistname') {
		$list = explode(',', $config['impossible_'.$type]);
		for ($i=0; $i<count($list); $i++) {
			if ($list[$i]==$value) {
				$case_chk = 1;
				break;
			}
		}
	}

	if ($case_chk) {
		echo 'impossible';
	} else {
		$check = @mysql_fetch_assoc(mysql_query('SELECT * FROM `users` WHERE `'.$type.'`="'.$value.'"'.($user['uid']?' AND `uid`!='.$user['uid'].'':'').';'));

		if($check['uid']) {
			echo 'overlap';
		} else {
			echo 'ok';
		}
	}
}
?>
