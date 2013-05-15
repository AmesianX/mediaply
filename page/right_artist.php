<?
$path = '..';

require($path.'/_common.php');

$total = mysql_num_rows(mysql_query('SELECT SUM(`a`.`buy_cnt`*'.$config['per_buy'].'+`a`.`download_cnt`*'.$config['per_download'].'+`a`.`streaming_cnt`*'.$config['per_streaming'].'+`a`.`playlist_cnt`*'.$config['per_playlist'].'+`a`.`recommend_cnt`*'.$config['per_recommend'].'+(SELECT SUM(`e`.`price`) FROM `ft_paid` `e` WHERE `e`.`artist_uid_fk`=`d`.`uid` AND `e`.`paid_date`="'.$ft['date'].'")) AS `score`, `d`.* FROM `ft_chart` `a`, `users` `d` WHERE `a`.`tid_fk` IN (SELECT `b`.`tid` FROM `ft_track` `b` WHERE `b`.`aid_fk` IN (SELECT `c`.`aid` FROM `ft_album` `c` WHERE `c`.`uid_fk`=`d`.`uid`)) AND `d`.`type`="artist" AND `a`.`year`='.date('Y', $ft['timestamp']).' AND `a`.`month`='.date('n', $ft['timestamp']).' AND `a`.`day`='.date('j', $ft['timestamp']).' GROUP BY `d`.`uid`;'));

$rows = 5;
$total_page = ceil($total / $rows);
if (!$_POST['p_num']) $p_num = 1;
else $p_num = $_POST['p_num'];
$first_index = ($p_num - 1) * $rows;

if ($_POST['p_num'] && ($p_num <= 0 || $p_num > $total_page)) {
	alert('존재하지 않는 페이지입니다.');
}

$last_list = mysql_query('SELECT SUM(`a`.`buy_cnt`*'.$config['per_buy'].'+`a`.`download_cnt`*'.$config['per_download'].'+`a`.`streaming_cnt`*'.$config['per_streaming'].'+`a`.`playlist_cnt`*'.$config['per_playlist'].'+`a`.`recommend_cnt`*'.$config['per_recommend'].'+(SELECT SUM(`e`.`price`) FROM `ft_paid` `e` WHERE `e`.`artist_uid_fk`=`d`.`uid` AND `e`.`paid_date`="'.date('Y-m-d', strtotime($ft['date'].' -1 day')).'")) AS `score`, `d`.* FROM `ft_chart` `a`, `users` `d` WHERE `a`.`tid_fk` IN (SELECT `b`.`tid` FROM `ft_track` `b` WHERE `b`.`aid_fk` IN (SELECT `c`.`aid` FROM `ft_album` `c` WHERE `c`.`uid_fk`=`d`.`uid`)) AND `d`.`type`="artist" AND `a`.`year`='.date('Y', strtotime($ft['date'].' -1 day')).' AND `a`.`month`='.date('n', strtotime($ft['date'].' -1 day')).' AND `a`.`day`='.date('j', strtotime($ft['date'].' -1 day')).' GROUP BY `d`.`uid` ORDER BY `score` DESC LIMIT 0, '.$total.';');

$hot_artist_list = mysql_query('SELECT SUM(`a`.`buy_cnt`*'.$config['per_buy'].'+`a`.`download_cnt`*'.$config['per_download'].'+`a`.`streaming_cnt`*'.$config['per_streaming'].'+`a`.`playlist_cnt`*'.$config['per_playlist'].'+`a`.`recommend_cnt`*'.$config['per_recommend'].'+(SELECT SUM(`e`.`price`) FROM `ft_paid` `e` WHERE `e`.`artist_uid_fk`=`d`.`uid` AND `e`.`paid_date`="'.$ft['date'].'")) AS `score`, `d`.* FROM `ft_chart` `a`, `users` `d` WHERE `a`.`tid_fk` IN (SELECT `b`.`tid` FROM `ft_track` `b` WHERE `b`.`aid_fk` IN (SELECT `c`.`aid` FROM `ft_album` `c` WHERE `c`.`uid_fk`=`d`.`uid`)) AND `d`.`type`="artist" AND `a`.`year`='.date('Y', $ft['timestamp']).' AND `a`.`month`='.date('n', $ft['timestamp']).' AND `a`.`day`='.date('j', $ft['timestamp']).' GROUP BY `d`.`uid` ORDER BY `score` DESC LIMIT '.$first_index.', '.$rows.';');


for ($i=0; $row=mysql_fetch_array($last_list); $i++) {
	$last_data[$i]['uid'] = $row['uid'];
}

$before = $p_num - 1;
$after = $p_num + 1;

if ($before<=0) $before = $total_page;
if ($after>$total_page) $after = 1;

if (!$total_page) $after = 0;
?>

<img class="title_img" src="<?=$ft['img_path']?>/title_hot_artist.jpg" alt="hot artist title" />

<div class="fright mt_5">
	<img class="btn" onclick="ajax_page_load_noloading('right_artist', 'right_artist', '&p_num=<?=$before?>');" src="<?=$ft['img_path']?>/btn_arrow_left_s.jpg" alt="left button" />
	<img class="btn" onclick="ajax_page_load_noloading('right_artist', 'right_artist', '&p_num=<?=$after?>');" src="<?=$ft['img_path']?>/btn_arrow_right_s.jpg" alt="right button" />
</div>

<?
for ($i=0; $row=mysql_fetch_array($hot_artist_list); $i++) {
	$tmp = 0;
	$state = '';
	$step = 0;
	for ($j=0; $j<count($last_data); $j++) {
		if ($last_data[$j]['uid'] == $row['uid']) {
			if ($i > $j) {
				$state = 'down';
				$step = $i - $j;
			} else if ($i < $j) {
				$state = 'up';
				$step = $j - $i;
			} else if ($i == $j) {
				$state = 'hold';
			}
			$tmp = 1;
			break;
		}
	}
	if (!$tmp) $state = 'new';

	if (!$row['profile_pic']) $row['profile_pic'] = 'default.jpg';
?>
	<div class="clear pv10 hide right_artist_div">
		<table width="100%" border="0" cellpadding="0" cellspacing="0" style="table-layout:fixed;">
			<colgroup>
				<col width="20" />
				<col width="40" />
				<col width="" />
				<col width="30" />
			</colgroup>
			<tr>
				<td><?=$i+$first_index+1?>.</td>
				<td><img src="<?=$ft['wall_path'].'/profile_pic/'.$row['profile_pic']?>" alt="<?=$row['artistname']?>" class="profile_pic" /></td>
				<td><span class="fleft w100per limit_text align_left btn bold" onclick="window.open('<?=$ft['wall_path']?>/<?=$row['username']?>', 'wall', '');"><?=$row['artistname']?></span></td>
				<td class="align_center"><img src="<?=$ft['img_path']?>/icon_<?=$state?>.jpg" alt="<?=$state?> icon" /><?=$step?$step:''?></td>
			</tr>
		</table>
	</div>
<?
}
?>

<script type="text/javascript">
function right_artist_div() {
	for (i=0; i<$('.right_artist_div').length; i++) {
		setTimeout("$('.right_artist_div').eq("+i+").slideDown();", 300*i);
	}
}

$(document).ready(function(){
	setTimeout('right_artist_div();', 1000);
});
</script>
