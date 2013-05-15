<?
$path = '..';

require($path.'/_common.php');

$recommend = mysql_fetch_assoc(mysql_query('SELECT * FROM `users` WHERE `uid`='.$_POST['uid'].';'));

$users_recommend_data = mysql_fetch_assoc(mysql_query('SELECT * FROM `users_recommend` WHERE `target_uid_fk`='.$recommend['uid'].' AND `uid_fk`='.$user['uid'].';'));
?>

<div class="content_row w604">

<img class="title_img" src="<?=$ft['img_path']?>/title_recommend_detail.jpg" alt="recommend detail title" />

<table border="0" cellpadding="0" cellspacing="0" summary="앨범 상세보기 테이블" class="album_info_table mb10">
	<caption>앨범 상세보기 테이블</caption>
	<colgroup>
		<col width="120" />
		<col width="80" />
		<col width="" />
	</colgroup>
	<tbody>
		<tr>
			<td rowspan="3" class="nobtm">
				<div class="album_pic"><img src="<?=$ft['path']?>/upload/recommend_pic/<?=$recommend['recommend_pic']?>" alt="recommend image" /></div>
			</td>
			<th class="top">앨범명</th>
			<td class="top"><?=$recommend['recommend_name']?></td>
		</tr>
		<tr>
			<th>소개</th>
			<td><?=$recommend['recommend_introduce']?></td>
		</tr>
		<tr>
			<th>작성자</th>
			<td><?=$recommend['nickname']?></td>
		</tr>
		<tr>
			<td class="nobtm">
				<span class="clear" id="users_recommend_btn">
					<? if ($users_recommend_data['urid']) { ?>
					<span class="txt_btn" onclick="users_recommend(<?=$recommend['uid']?>, 'del');">추천 취소</span>
					<? } else { ?>
					<span class="txt_btn" onclick="users_recommend(<?=$recommend['uid']?>, 'ins');">추천</span>
					<? } ?>
				<span>
			</td>
			<td colspan="2" class="nobtm"></td>
		</tr>
	</tbody>
</table>

<? $list = mysql_query('SELECT `a`.* FROM `ft_playlist` `a`, `ft_track` `b` WHERE `a`.`uid_fk`='.$_POST['uid'].' AND `a`.`tid_fk`=`b`.`tid` AND `b`.`state`="Y" ORDER BY `a`.`pid` DESC;'); ?>

<table border="0" cellpadding="0" cellspacing="0" summary="트랙 리스트 테이블" id="play_list_table" class="list_table">
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
		<th>장르</th>
		<th>콩나물</th>
		<th>구매</th>
		<th>가사</th>
		<th>다운</th>
		<th>듣기</th>
		<th>제거</th>
	</tr>
	</thead>
	<tbody>
	<? for ($i=0; $row=mysql_fetch_array($list); $i++) { ?>
	<? $row = mysql_fetch_assoc(mysql_query('SELECT * FROM `ft_track` WHERE `tid`='.$row['tid_fk'].';')); ?>
	<? $genre_data = mysql_fetch_assoc(mysql_query('SELECT * FROM `ft_genre` WHERE `gid`='.$row['gid_fk'].';')); ?>
	<? $recommend_data = @mysql_fetch_assoc(@mysql_query('SELECT * FROM `ft_recommend` WHERE `tid_fk`='.$row['tid'].' AND `uid_fk`='.$user['uid'].';')); ?>
	<? $paid_data = @mysql_fetch_assoc(mysql_query('SELECT * FROM `ft_paid` WHERE `uid_fk`='.$user['uid'].' AND `tid_fk`='.$row['tid'].';')); ?>
	<tr>
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
		<td>
			<span class="btn" onclick="del_playlist(<?=$row['tid']?>);"><img src="<?=$ft['img_path']?>/icon_del_playlist_on.jpg" alt="delete playlist" /></span>
		</td>
	</tr>
	<? } ?>
	</tbody>
</table>

<div class="clear fright mt10">
	<span class="txt_btn" onclick="ajax_page_load('left_content', 'recommend', '&p_num=<?=$_POST['p_num']?>&order=<?=$order?>');">목록보기</span>
</div>

</div>
