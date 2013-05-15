<?
$path = '../..';

require($path.'/_common.php');

mysql_query('DELETE FROM `ft_notice` WHERE `id`='.$_GET['id'].';');

location_replace($ft['adm_path'].'/?page=notice_list');
?>
