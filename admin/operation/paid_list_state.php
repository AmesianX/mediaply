<?
$path = '../..';

require($path.'/_common.php');

if ($_POST['page']=='paid_apply_list') $state = 'W';
else if ($_POST['page']=='paid_waiting_list') $state = 'Y';

for ($i=0; $i<count($_POST['paid_id']); $i++) {
	mysql_query('UPDATE `ft_paid` SET `state`="'.$state.'" WHERE `id`='.$_POST['paid_id'][$i].';');
}

location_replace($ft['adm_path'].'/?page='.$_POST['page']);
?>
