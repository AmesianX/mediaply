<?
$path = '..';

require($path.'/_common.php');

$total = mysql_fetch_assoc(mysql_query('SELECT COUNT(*) AS `cnt` FROM `ft_track` WHERE `state`="Y" AND `trackname` like "%'.$_POST['search_txt'].'%";'));

$rows = 10;
$total_page = ceil($total['cnt'] / $rows);
if (!$_POST['p_num']) $p_num = 1;
else $p_num = $_POST['p_num'];
$first_index = ($p_num - 1) * $rows;

if ($_POST['p_num'] && ($p_num <= 0 || $p_num > $total_page)) {
	alert('존재하지 않는 페이지입니다.');
}

$list = mysql_query('SELECT * FROM `ft_track` WHERE `state`="Y" AND `trackname` like "%'.$_POST['search_txt'].'%" OR `artistname` like "%'.$_POST['search_txt'].'%" ORDER BY `tid` DESC LIMIT '.$first_index.', '.$rows.';');
?>

<div class="content_row w604">

<img class="title_img" src="<?=$ft['img_path']?>/title_search.jpg" alt="search title" />

<table border="0" cellpadding="0" cellspacing="0" summary="트랙 리스트 테이블" class="list_table mb10">
	<caption>트랙 리스트 테이블</caption>
	<colgroup>
		<col width="40" />
		<col width="" />
		<col width="90" />
		<col width="50" />
		<col width="40" />
		<col width="40" />
		<col width="40" />
		<col width="40" />
		<col width="40" />
	</colgroup>
	<thead>
	<tr>
		<th>추천</th>
		<th>트랙명</th>
		<th>아티스트명</th>
		<th>콩나물</th>
		<th>구매</th>
		<th>가사</th>
		<th>다운</th>
		<th>듣기</th>
		<th>추가</th>
	</tr>
	</thead>
	<tbody>
	<? for ($i=0; $row=mysql_fetch_array($list); $i++) { ?>
	<? $genre_data = mysql_fetch_assoc(mysql_query('SELECT * FROM `ft_genre` WHERE `gid`='.$row['gid_fk'].';')); ?>
	<? $recommend_data = @mysql_fetch_assoc(mysql_query('SELECT * FROM `ft_recommend` WHERE `tid_fk`='.$row['tid'].' AND `uid_fk`='.$user['uid'].';')); ?>
	<? $playlist_data = @mysql_fetch_assoc(mysql_query('SELECT * FROM `ft_playlist` WHERE `tid_fk`='.$row['tid'].' AND `uid_fk`='.$user['uid'].';')); ?>
	<? $paid_data = @mysql_fetch_assoc(mysql_query('SELECT * FROM `ft_paid` WHERE `uid_fk`='.$user['uid'].' AND `tid_fk`='.$row['tid'].';')); ?>
	<tr>
		<td id="recommend_<?=$row['tid']?>">
			<? if ($is_user) { ?><?=$recommend_data['rid']?'<span class="btn" onclick="track_recommend('.$row['tid'].', \'del\');"><img src="'.$ft['img_path'].'/icon_recommend_on.jpg" alt="recommend track" /></span>':'<span class="btn" onclick="track_recommend('.$row['tid'].', \'ins\');"><img src="'.$ft['img_path'].'/icon_recommend_off.jpg" alt="recommend track" /></span>'?><? } else { ?><span class="btn" onclick="alert('로그인 해주세요.');"><img src="<?=$ft['img_path']?>/icon_recommend_off.jpg" alt="recommend track" /></span><? } ?>
		</td>
		<td><span class="fleft w100per limit_text align_left"><?=$row['trackname']?></span></td>
		<td><?=$row['artistname']?></td>
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
	</tr>
	<? } ?>
	</tbody>
</table>

<div id="paging" class="clear"></div>

</div>

<script type="text/javascript">$('#paging').html(ajax_paging(<?=$p_num?>, <?=$total_page?>, '<?=$_POST['target_id']?>', '<?=$_POST['page']?>&search_txt=<?=$_POST['search_txt']?>', 10));</script>
