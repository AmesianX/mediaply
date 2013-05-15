<?
$path = '../..';

require($path.'/_common.php');

mysql_query('UPDATE `ft_config` SET `upd_date`="'.$ft['date'].'", `upd_time`="'.$ft['time'].'", `impossible_username`="'.$_POST['impossible_username'].'", `impossible_nickname`="'.$_POST['impossible_nickname'].'", `impossible_artistname`="'.$_POST['impossible_artistname'].'", `music_indr`="'.$_POST['music_indr'].'", `terms`="'.$_POST['terms'].'", `privacy`="'.$_POST['privacy'].'", `per_buy`='.$_POST['per_buy'].', `per_download`='.$_POST['per_download'].', `per_streaming`='.$_POST['per_streaming'].', `per_playlist`='.$_POST['per_playlist'].', `per_recommend`='.$_POST['per_recommend'].';');

location_replace($ft['adm_path'].'/?page='.$_POST['page']);
?>
