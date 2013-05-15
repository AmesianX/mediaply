<?
$path = '..';

require($path.'/_common.php');

mysql_query('INSERT INTO `ft_payment` SET `tid`="'.$_POST['tid'].'", `uid_fk`='.$user['uid'].', `unitprice`='.$_POST['unitprice'].', `paymethod`="'.$_POST['paymethod'].'", `pay_date`="'.$ft['date'].'", `pay_time`="'.$ft['time'].'";');
?>
