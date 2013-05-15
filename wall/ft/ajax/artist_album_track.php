<?
$path = '../../..';

require($path.'/_common.php');

$album = mysql_fetch_assoc(mysql_query('SELECT * FROM `ft_album` WHERE `aid`='.$_POST['aid'].';'));

if ($user['uid'] == $album['uid_fk']) $is_mypage = 1;
else $is_mypage = 0;

$list = mysql_query('SELECT * FROM `ft_track` WHERE `aid_fk`='.$_POST['aid'].' ORDER BY `tid` ASC;');
?>
<div id="div_bg"></div>
<div class="relative">
        <div id="track_buy">
                <input type="hidden" name="tid" id="track_buy_tid" value="" />
                <table border="0" cellpadding="0" cellspacing="0" summary="트랙 구매 테이블" class="view_table">
                        <caption>트랙 구매 테이블</caption>
                        <colgroup>
                                <col width="" />
                                <col width="130" />
                                <col width="130" />
                        </colgroup>
                        <tbody>
                                <tr>
                                        <th colspan="3" class="title">트랙 구매<span class="btn fright" onclick="$('#track_buy').fadeOut();$('#div_bg').fadeOut();"><img src="<?=$ft['img_path']?>/btn_close.jpg" alt="close button" /></span></th>
                                </tr>
                                <tr>
                                        <td><div class="album_pic"><img id="track_buy_album_pic" src="" alt="album_pic" /></div></td>
                                        <td><span id="track_buy_trackname"></span><br /><span id="track_buy_artistname"></span></td>
                                        <td><img src="<?=$ft['img_path']?>/icon_bean.jpg" alt="bean icon" />&nbsp;x<span id="track_buy_price"></span></td>
                                </tr>
                                <tr>
                                        <th colspan="3"><div class="align_center mt10"><span class="txt_btn" onclick="track_buy();">구매</span></div></th>
                                </tr>
                        </tbody>
                </table>
        </div>
</div>
<table border="0" cellpadding="0" cellspacing="0" summary="트랙 리스트 테이블" class="list_table mt10">
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
		<? if ($is_mypage) { ?>
		<col width="40" />
		<col width="40" />
		<col width="40" />
		<? } ?>
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
		<? if ($is_mypage) { ?>
		<th>상태</th>
		<th>수정</th>
		<th>삭제</th>
		<? } ?>
	</tr>
	</thead>
	<tbody>
	<? for ($i=0; $row=mysql_fetch_array($list); $i++) { ?>
	<? $genre_data = mysql_fetch_assoc(mysql_query('SELECT * FROM `ft_genre` WHERE `gid`='.$row['gid_fk'].';')); ?>
	<? $recommend_data = @mysql_fetch_assoc(mysql_query('SELECT * FROM `ft_recommend` WHERE `tid_fk`='.$row['tid'].' AND `uid_fk`='.$user['uid'].';')); ?>
	<? $playlist_data = @mysql_fetch_assoc(mysql_query('SELECT * FROM `ft_playlist` WHERE `tid_fk`='.$row['tid'].' AND `uid_fk`='.$user['uid'].';')); ?>
	<tr>
		<td id="recommend_<?=$row['tid']?>">
			<? if ($is_user) { ?><?=$recommend_data['rid']?'<span class="btn" onclick="track_recommend('.$row['tid'].', \'del\');"><img src="'.$ft['img_path'].'/icon_recommend_on.jpg" alt="recommend track" /></span>':'<span class="btn" onclick="track_recommend('.$row['tid'].', \'ins\');"><img src="'.$ft['img_path'].'/icon_recommend_off.jpg" alt="recommend track" /></span>'?><? } else { ?><span class="btn" onclick="alert('로그인 해주세요.');"><img src="'.$ft['img_path'].'/icon_recommend_off.jpg" alt="recommend track" /></span><? } ?>
		</td>
		<td><span class="fleft w100per limit_text align_left"><?=$row['trackname']?></span></td>
		<td><?=$row['artistname']?></td>
		<td><?=$row['price']?>&nbsp;개</td>
		<td>
			<? if ($is_user) { if ($row['price'] > 0) {?><?='<span class="btn" onclick="track_buy_view('.$row['tid'].');"><img src="'.$ft['img_path'].'/icon_buy_on.jpg" alt="buy track" /></span>'?><? } else {?><?='<img src="'.$ft['img_path'].'/icon_buy_off.jpg" alt="buy track" /></span>'?><? } ?><? } else { ?><span class="btn" onclick="alert('로그인 해주세요.');"><img src="<?=$ft['img_path']?>/icon_buy_on.jpg" alt="buy track" /></span><? } ?>
		</td>
		<td>
			<?=$row['lyric']?'<span class="btn" onclick="lyric_view('.$row['tid'].');"><img src="'.$ft['img_path'].'/icon_lyric_on.jpg" alt="view lyric" /></span>':'<img src="'.$ft['img_path'].'/icon_lyric_off.jpg" alt="view lyric" />'?>
		</td>
		<td>
			<? if ($is_user && $paid_data['id']) { ?><span class="btn" onclick="track_download(<?=$row['tid']?>);"><img src="<?=$ft['img_path']?>/icon_download_on.jpg" alt="download track" /></span><? } else if ($is_user) {?><?=$row['free_download']=='Y'?'<span class="btn" onclick="track_download('.$row['tid'].');"><img src="'.$ft['img_path'].'/icon_download_on.jpg" alt="download track" /></span>':'<img src="'.$ft['img_path'].'/icon_download_off.jpg" alt="download track" />'?><? } else { ?><?=$row['free_download']=='Y'?'<span class="btn" onclick="alert(\'로그인 해주세요.\');"><img src="'.$ft['img_path'].'/icon_download_on.jpg" alt="download track" /></span>':'<img src="'.$ft['img_path'].'/icon_download_off.jpg" alt="download track" />'?><? } ?>
		</td>
		<td>
			<? if ($is_user && $paid_data['id']) { ?><span class="btn" onclick="add_parent_streaming(<?=$row['aid_fk']?>, <?=$row['tid']?>);"><img src="<?=$ft['img_path']?>/icon_streaming_on.jpg" alt="add streaming" /></span><? } else {?><?=$row['free_streaming']=='Y'?'<span class="btn" onclick="add_parent_streaming('.$row['aid_fk'].', '.$row['tid'].');"><img src="'.$ft['img_path'].'/icon_streaming_on.jpg" alt="add streaming" /></span>':'<img src="'.$ft['img_path'].'/icon_streaming_off.jpg" alt="add streaming" />'?><? } ?>
		</td>
		<td id="playlist_<?=$row['tid']?>">
			<? if ($is_user) { ?><?=$playlist_data['pid']?'<img src="'.$ft['img_path'].'/icon_add_playlist_off.jpg" alt="add playlist" />':'<span class="btn" onclick="add_playlist('.$row['tid'].');"><img src="'.$ft['img_path'].'/icon_add_playlist_on.jpg" alt="add playlist" /></span>'?><? } else { ?><span class="btn" onclick="alert('로그인 해주세요.');"><img src="<?=$ft['img_path']?>/icon_add_playlist_on.jpg" alt="add playlist" /></span><? } ?>
		</td>
		<? if ($is_mypage) { ?>
		<td><?=$row['state']?></td>
		<td><span class="btn" onclick="location.href='<?=$ft['wall_path']?>/ft.php?page=artist_track_reg&username=<?=$user['username']?>&aid=<?=$album['aid']?>&tid=<?=$row['tid']?>';">수정</span></td>
		<td><span class="btn" onclick="track_del(<?=$row['tid']?>);">삭제</span></td>
		<? } ?>
	</tr>
	<? } ?>
	</tbody>
</table>
