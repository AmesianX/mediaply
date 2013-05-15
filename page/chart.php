<?
$path = '..';

require($path.'/_common.php');

if (!$_POST['year']) $year = date('Y', $ft['timestamp']);
else $year = $_POST['year'];
if (!$_POST['month']) $month = date('m', $ft['timestamp']);
else $month = $_POST['month'];

if ($month <= 1) {
	$last_year = $year - 1;
	$last_month = 12;
} else {
	$last_year = $year;
	$last_month = $month - 1;
}

$list = mysql_query('SELECT `a`.*, `a`.`buy_cnt`*'.$config['per_buy'].'+`a`.`download_cnt`*'.$config['per_download'].'+`a`.`streaming_cnt`*'.$config['per_streaming'].'+`a`.`playlist_cnt`*'.$config['per_playlist'].'+`a`.`recommend_cnt`*'.$config['per_recommend'].' AS `score`, `b`.`reg_date`, `b`.`reg_time` FROM `ft_chart` `a`, `ft_track` `b` WHERE `b`.`state`="Y" AND `b`.`tid`=`a`.`tid_fk` AND `a`.`year`='.$year.' AND `a`.`month`='.$month.' GROUP BY `a`.`tid_fk` ORDER BY `score` DESC, `b`.`reg_date` DESC, `b`.`reg_time` DESC LIMIT 0, 100;');

$last_list = mysql_query('SELECT `a`.*, `a`.`buy_cnt`*'.$config['per_buy'].'+`a`.`download_cnt`*'.$config['per_download'].'+`a`.`streaming_cnt`*'.$config['per_streaming'].'+`a`.`playlist_cnt`*'.$config['per_playlist'].'+`a`.`recommend_cnt`*'.$config['per_recommend'].' AS `score`, `b`.`reg_date`, `b`.`reg_time` FROM `ft_chart` `a`, `ft_track` `b` WHERE `b`.`state`="Y" AND `b`.`tid`=`a`.`tid_fk` AND `a`.`year`='.$last_year.' AND `a`.`month`='.$last_month.' GROUP BY `a`.`tid_fk` ORDER BY `score` DESC, `b`.`reg_date` DESC, `b`.`reg_time` DESC LIMIT 0, 100;');

for ($i=0; $row=mysql_fetch_array($last_list); $i++) {
	$last_data[$i]['tid_fk'] = $row['tid_fk'];
}
?>

<div class="content_row w604">

<img class="title_img" src="<?=$ft['img_path']?>/title_chart.jpg" alt="chart title" />

<div class="fright">
	<select name="year" onchange="ajax_page_load('left_content', 'chart', '&year='+this.value+'&month=<?=$month?>');">
		<? for ($i=2012; $i<=date('Y', $ft['timestamp']); $i++) { ?>
			<option value="<?=$i?>" <?=$i==$year?'selected="selected"':''?>><?=$i?></option>
		<? } ?>
	</select>&nbsp;년
	<select name="month" onchange="ajax_page_load('left_content', 'chart', '&year=<?=$year?>&month='+this.value);">
		<? for ($i=1; $i<=12; $i++) { ?>
			<option value="<?=$i?>" <?=$i==$month?'selected="selected"':''?>><?=$i?></option>
		<? } ?>
	</select>&nbsp;월
</div>

<table border="0" cellpadding="0" cellspacing="0" summary="트랙 리스트 테이블" class="list_table mb10">
	<caption>트랙 리스트 테이블</caption>
	<colgroup>
		<col width="40" />
		<col width="40" />
		<col width="40" />
		<col width="" />
		<col width="90" />
		<col width="50" />
		<col width="40" />
		<col width="40" />
		<col width="40" />
		<col width="40" />
		<col width="40" />
		<col width="40" />
	</colgroup>
	<thead>
	<tr>
		<th>순위</th>
		<th>점수</th>
		<th>추천</th>
		<th>트랙명</th>
		<th>장르</th>
		<th>콩나물</th>
		<th>구매</th>
		<th>가사</th>
		<th>다운</th>
		<th>듣기</th>
		<th>추가</th>
		<th>변동</th>
	</tr>
	</thead>
	<tbody>
	<? for ($i=0; $row=mysql_fetch_array($list); $i++) { ?>
	<? $score = $row['score'] ?>
	<? $row = mysql_fetch_assoc(mysql_query('SELECT * FROM `ft_track` WHERE `tid`='.$row['tid_fk'].';')); ?>
	<? $genre_data = mysql_fetch_assoc(mysql_query('SELECT * FROM `ft_genre` WHERE `gid`='.$row['gid_fk'].';')); ?>
	<? $recommend_data = @mysql_fetch_assoc(@mysql_query('SELECT * FROM `ft_recommend` WHERE `tid_fk`='.$row['tid'].' AND `uid_fk`='.$user['uid'].';')); ?>
	<? $playlist_data = @mysql_fetch_assoc(mysql_query('SELECT * FROM `ft_playlist` WHERE `tid_fk`='.$row['tid'].' AND `uid_fk`='.$user['uid'].';')); ?>
	<? $paid_data = @mysql_fetch_assoc(mysql_query('SELECT * FROM `ft_paid` WHERE `uid_fk`='.$user['uid'].' AND `tid_fk`='.$row['tid'].';')); ?>
	<?
		$tmp = 0;
		$state = '';
		for ($j=0; $j<count($last_data); $j++) {
			if ($last_data[$j]['tid_fk'] == $row['tid']) {
				if ($i > $j) {
					$state = 'down';
				} else if ($i < $j) {
					$state = 'up';
				} else if ($i == $j) {
					$state = 'hold';
				}
				$tmp = 1;
				break;
			}
		}
		if (!$tmp) $state = 'new';
	?>
	<tr>
		<td><?=$i+1?></td>
		<td><?=$score?></td>
		<td id="recommend_<?=$row['tid']?>">
			<? if ($is_user) { ?><?=$recommend_data['rid']?'<span class="btn" onclick="track_recommend('.$row['tid'].', \'del\');"><img src="'.$ft['img_path'].'/icon_recommend_on.jpg" alt="recommend track" /></span>':'<span class="btn" onclick="track_recommend('.$row['tid'].', \'ins\');"><img src="'.$ft['img_path'].'/icon_recommend_off.jpg" alt="recommend track" /></span>'?><? } else { ?><span class="btn" onclick="alert('로그인 해주세요.');"><img src="<?=$ft['img_path']?>/icon_recommend_off.jpg" alt="recommend track" /></span><? } ?>
		</td>
		<td><span class="fleft w100per limit_text align_left"><?=$row['trackname']?></span></td>
		<td><?=$genre_data['genre']?></td>
		<td><?=$row['price']?>&nbsp;개</td>
		<td>
			<? if ($is_user) { ?><?='<span class="btn" onclick="track_buy_view('.$row['tid'].');"><img src="'.$ft['img_path'].'/icon_buy_on.jpg" alt="buy track" /></span>'?><? } else { ?><span class="btn" onclick="alert('로그인 해주세요.');"><img src="<?=$ft['img_path']?>/icon_buy_on.jpg" alt="buy track" /></span><? } ?>
		</td>
		<td>
			<?=$row['lyric']?'<span class="btn" onclick="lyric_view('.$row['tid'].');"><img src="'.$ft['img_path'].'/icon_lyric_on.jpg" alt="view lyric" /></span>':'<img src="'.$ft['img_path'].'/icon_lyric_off.jpg" alt="view lyric" />'?>
		</td>
		<td>
			<? if ($is_user && $paid_data['id']) { ?><span class="btn" onclick="track_download(<?=$row['tid']?>);"><img src="<?=$ft['img_path']?>/icon_download_on.jpg" alt="download track" /></span><? } else if ($is_user) {?><?=$row['free_download']=='Y'?'<span class="btn" onclick="track_download('.$row['tid'].');"><img src="'.$ft['img_path'].'/icon_download_on.jpg" alt="download track" /></span>':'<img src="'.$ft['img_path'].'/icon_download_off.jpg" alt="download track" />'?><? } else { ?><?=$row['free_download']=='Y'?'<span class="btn" onclick="alert(\'로그인 해주세요.\');"><img src="'.$ft['img_path'].'/icon_download_on.jpg" alt="download track" /></span>':'<img src="'.$ft['img_path'].'/icon_download_off.jpg" alt="download track" />'?><? } ?>
		</td>
		<td>
			<? if ($is_user && $paid_data['id']) { ?><span class="btn" onclick="add_streaming(<?=$row['aid_fk']?>, <?=$row['tid']?>);"><img src="<?=$ft['img_path']?>/icon_streaming_on.jpg" alt="add streaming" /></span><? } else {?><?=$row['free_streaming']=='Y'?'<span class="btn" onclick="add_streaming('.$row['aid_fk'].', '.$row['tid'].');"><img src="'.$ft['img_path'].'/icon_streaming_on.jpg" alt="add streaming" /></span>':'<img src="'.$ft['img_path'].'/icon_streaming_off.jpg" alt="add streaming" />'?><? } ?>
		</td>
		<td id="playlist_<?=$row['tid']?>">
			<? if ($is_user) { ?><?=$playlist_data['pid']?'<img src="'.$ft['img_path'].'/icon_add_playlist_off.jpg" alt="add playlist" />':'<span class="btn" onclick="add_playlist('.$row['tid'].');"><img src="'.$ft['img_path'].'/icon_add_playlist_on.jpg" alt="add playlist" /></span>'?><? } else { ?><span class="btn" onclick="alert('로그인 해주세요.');"><img src="<?=$ft['img_path']?>/icon_add_playlist_on.jpg" alt="add playlist" /></span><? } ?>
		</td>
		<td><img src="<?=$ft['img_path']?>/icon_<?=$state?>.jpg" alt="<?=$state?> icon" /></td>
	</tr>
	<? } ?>
	<? if (!$i) { ?><tr><td colspan="12"><div class="pv20">집계된 자료가 없습니다.</div></td></tr><? } ?>
	</tbody>
</table>

</div>
