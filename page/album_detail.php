<?
$path = '..';

require($path.'/_common.php');

$album = mysql_fetch_assoc(mysql_query('SELECT * FROM `ft_album` WHERE `aid`='.$_POST['aid'].';'));
$genre_data = mysql_fetch_assoc(mysql_query('SELECT * FROM `ft_genre` WHERE `gid`='.$album['gid_fk'].';'));
$user_data = mysql_fetch_assoc(mysql_query('SELECT * FROM `users` WHERE `uid`='.$album['uid_fk'].';'));

$album_recommend_data = mysql_fetch_assoc(mysql_query('SELECT * FROM `ft_album_recommend` WHERE `aid_fk`='.$album['aid'].' AND `uid_fk`='.$user['uid'].';'));
?>

<div class="content_row w604">

<img class="title_img" src="<?=$ft['img_path']?>/title_album_detail.jpg" alt="album detail title" />

<table border="0" cellpadding="0" cellspacing="0" summary="앨범 상세보기 테이블" class="album_info_table mb10">
	<caption>앨범 상세보기 테이블</caption>
	<colgroup>
		<col width="120" />
		<col width="80" />
		<col width="" />
	</colgroup>
	<tbody>
		<tr>
			<td rowspan="5" class="nobtm">
				<div class="album_pic mb10"><img src="<?=$ft['path']?>/upload/album_pic/<?=$album['album_pic']?>" alt="album image" /></div>
				<span class="clear" id="album_recommend_btn">
					<? if ($album_recommend_data['arid']) { ?>
					<span class="txt_btn" onclick="album_recommend(<?=$album['aid']?>, 'del');">추천 취소</span>
					<? } else { ?>
					<span class="txt_btn" onclick="album_recommend(<?=$album['aid']?>, 'ins');">추천</span>
					<? } ?>
				<span>
			</td>
			<th class="top">앨범명</th>
			<td class="top"><?=$album['albumname']?></td>
		</tr>
		<tr>
			<th>장르</th>
			<td><?=$genre_data['genre']?></td>
		</tr>
		<tr>
			<th>설명</th>
			<td><?=$album['explain']?></td>
		</tr>
                <tr>
                        <th>아티스트명</th>
                        <td><?=$album['artistname']?></td>
                </tr>

		<tr>
			<th>작성자</th>
			<td><?=$user_data['artistname']?></td>
		</tr>
	</tbody>
</table>

<? $list = mysql_query('SELECT * FROM `ft_track` WHERE `state`="Y" AND `aid_fk`='.$_POST['aid'].' ORDER BY `tid` ASC;'); ?>

<table border="0" cellpadding="0" cellspacing="0" summary="트랙 리스트 테이블" class="list_table mv10">
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

<div class="clear fright mt10">
	<span class="txt_btn" onclick="ajax_page_load('left_content', 'album', '&p_num=<?=$_POST['p_num']?>&order=<?=$order?>');">목록보기</span>
</div>

</div>
