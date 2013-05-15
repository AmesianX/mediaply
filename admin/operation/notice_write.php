<?
$path = '../..';

require($path.'/_common.php');

if ($_POST['act']=='ins') {
	mysql_query('INSERT INTO `ft_notice` SET `subject`="'.$_POST['subject'].'", `content`="'.$_POST['content'].'", `reg_date`="'.$ft['date'].'", `reg_time`="'.$ft['time'].'";');
	$id = mysql_insert_id();
} else if ($_POST['act']=='mod') {
	mysql_query('UPDATE `ft_notice` SET `subject`="'.$_POST['subject'].'", `content`="'.$_POST['content'].'" WHERE `id`='.$_POST['id'].';');
	$id = $_POST['id'];
}

location_replace($ft['adm_path'].'/?page=notice_view&p_num='.$_POST['p_num'].'&id='.$id);
?>
