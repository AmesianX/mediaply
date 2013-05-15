<?
$path = '../../..';

require($path.'/_common.php');

for ($i=0; $i<count($_POST['paid_id']); $i++) {
	mysql_query('UPDATE `ft_paid` SET `state`="A" WHERE `id`='.$_POST['paid_id'][$i].';');
}

location_replace($ft['wall_path'].'/ft.php?page='.$_POST['page'].'&p_num='.$_POST['p_num']);
?>
