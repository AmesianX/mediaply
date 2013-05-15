<?
$path = '..';

require($path.'/_common.php');

if ($_POST['target']=='download_cnt') {
	$chk = mysql_fetch_assoc(mysql_query('SELECT * FROM `ft_download` WHERE `tid_fk`='.$_POST['tid'].' AND `uid_fk`='.$user['uid'].';'));

	if ($chk['did']) exit;
}

if ($_POST['target']=='recommend_cnt') {
	$chk = mysql_fetch_assoc(mysql_query('SELECT * FROM `ft_recommend` WHERE `tid_fk`='.$_POST['tid'].' AND `uid_fk`='.$user['uid'].';'));

	if ($chk['rid']) exit;
}

if ($_POST['target']=='playlist_cnt') {
	$chk = mysql_fetch_assoc(mysql_query('SELECT * FROM `ft_playlist` WHERE `tid_fk`='.$_POST['tid'].' AND `uid_fk`='.$user['uid'].';'));

	if ($chk['pid']) {
		echo 'overlap';
		exit;
	}
}

$chk = mysql_fetch_assoc(mysql_query('SELECT * FROM `ft_chart` WHERE `tid_fk`='.$_POST['tid'].' AND `year`='.date('Y', $ft['timestamp']).' AND `month`='.date('m', $ft['timestamp']).' AND `day`='.date('d', $ft['timestamp']).';'));

if ($chk['cid']) {
	mysql_query('UPDATE `ft_chart` SET `'.$_POST['target'].'`=`'.$_POST['target'].'`+1 WHERE `tid_fk`='.$_POST['tid'].' AND `year`='.date('Y', $ft['timestamp']).' AND `month`='.date('m', $ft['timestamp']).' AND `day`='.date('d', $ft['timestamp']).';');

	$cid_fk = $chk['cid'];
} else {
	mysql_query('INSERT INTO `ft_chart` SET `tid_fk`='.$_POST['tid'].', `year`='.date('Y', $ft['timestamp']).', `month`='.date('m', $ft['timestamp']).', `day`='.date('d', $ft['timestamp']).', `'.$_POST['target'].'`=1;');

	$cid_fk = mysql_insert_id();
}

if ($_POST['target']=='download_cnt') {
	mysql_query('INSERT INTO `ft_download` SET `tid_fk`='.$_POST['tid'].', `uid_fk`='.$user['uid'].', `reg_date`="'.$ft['date'].'", `reg_time`="'.$ft['time'].'";');
}

if ($_POST['target']=='recommend_cnt') {
	mysql_query('INSERT INTO `ft_recommend` SET `cid_fk`='.$cid_fk.', `tid_fk`='.$_POST['tid'].', `uid_fk`='.$user['uid'].', `reg_date`="'.$ft['date'].'", `reg_time`="'.$ft['time'].'";');
	$result = mysql_fetch_assoc(mysql_query('SELECT * FROM `ft_track` WHERE `tid`='.$_POST['tid'].';'));
	echo $result['trackname'];
}

if ($_POST['target']=='playlist_cnt') {
	mysql_query('INSERT INTO `ft_playlist` SET `cid_fk`='.$cid_fk.', `tid_fk`='.$_POST['tid'].', `uid_fk`='.$user['uid'].', `reg_date`="'.$ft['date'].'", `reg_time`="'.$ft['time'].'";');
	echo 'success';
}
?>
