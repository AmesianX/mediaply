<?
$path = '..';

require($path.'/_common.php');

$price = 10;

if ($user['bean_cnt'] < $price) {
	echo 'shortage';
	exit;
}

mysql_query('INSERT INTO `ft_present` SET `uid_fk`='.$user['uid'].', `artist_uid_fk`='.$_POST['artist_uid_fk'].', `price`='.$price.', `present_date`="'.$ft['date'].'", `present_time`="'.$ft['time'].'";');
echo 'success|'.($user['bean_cnt']-$price);
?>
