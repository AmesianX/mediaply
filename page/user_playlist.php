<?
$path = '..';

require($path.'/_common.php');

$list = mysql_query('SELECT `a`.* FROM `ft_playlist` `a`, `ft_track` `b` WHERE `a`.`uid_fk`='.$user['uid'].' AND `a`.`tid_fk`=`b`.`tid` AND `b`.`state`="Y" ORDER BY `a`.`pid` DESC;');
?>

<div id="div_bg"></div>
<div class="relative">
	<div id="track_buy">
		<input type="hidden" name="tid" id="tid" value="" />
		<table border="0" cellpadding="0" cellspacing="0" summary="트랙 구매 테이블" class="view_table">
			<caption>트랙 구매 테이블</caption>
			<colgroup>
				<col width="120" />
				<col width="" />
			</colgroup>
			<tbody>
				<tr>
					<th colspan="2">트랙 구매</th>
				</tr>
				<tr>
					<td rowspan="3"><div class="album_pic"><img id="album_pic" src="" alt="album_pic" /></div></td>
					<td><span id="trackname"></span></td>
				</tr>
				<tr>
					<td><span id="artistname"></span></td>
				</tr>
				<tr>
					<td>콩나물 <span id="price"></span>개</td>
				</tr>
				<tr>
					<th colspan="2"><div class="align_center"><span class="btn" onclick="track_buy();">구매</span>&nbsp;<span class="btn" onclick="$('#track_buy').fadeOut();$('#div_bg').fadeOut();">취소</span></div></th>
				</tr>
			</tbody>
		</table>
	</div>
</div>

<div class="content_row w604">

<img class="title_img" src="<?=$ft['img_path']?>/title_user_playlist.jpg" alt="user playlist title" />

<table border="0" cellpadding="0" cellspacing="0" summary="트랙 리스트 테이블" id="play_list_table" class="list_table">
	<caption>트랙 리스트 테이블</caption>
	<colgroup>
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
	</colgroup>
	<thead>
	<tr>
		<th><input type="checkbox" onclick="if ($(this).attr('checked')) { $('#play_list_table input[type=checkbox]').attr('checked', true); } else { $('#play_list_table input[type=checkbox]').attr('checked', false); }" /></th>
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
		<td><input type="checkbox" class="tid" value="<?=$row['tid']?>" /><input type="hidden" class="aid" value="<?=$row['aid_fk']?>" /></td>
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
	<? if (!$i) { ?><tr><td colspan="10"><div class="pv20">등록된 플레이리스트가 없습니다.</div></td></tr><? } ?>
	</tbody>
</table>

<div class="clear fleft w100per mt10">
	<div class="fleft">
		<span class="txt_btn" onclick="all_add_streaming();">전체듣기</span>
		<span class="txt_btn" onclick="selected_add_streaming();">선택듣기</span>
	</div>
	<div class="fright">
		<span class="txt_btn" onclick="$('#recommend_config').slideToggle();">추천설정</span>
	</div>
</div>

<div id="recommend_config" class="w100per clear fleft mt30 hide">
	<form name="recommend_config_form" id="recommend_config_form" method="post" action="" onsubmit="return recommend_submit();" enctype="multipart/form-data">
	<table border="0" cellpadding="0" cellspacing="0" class="write_table">
		<colgroup>
			<col width="100" />
			<col width="" />
		</colgroup>
		<tr>
			<th>추천 리스트</th>
			<td><label><input type="radio" name="is_secret" value="N" <?=$user['is_secret']=='N'?'checked="checked"':''?> />&nbsp;공개</label><label class="ml20"><input type="radio" name="is_secret" value="Y" <?=$user['is_secret']=='Y'?'checked="checked"':''?> />&nbsp;비공개</label></td>
		</tr>
		<tr>
			<th>제목</th>
			<td><input type="text" name="recommend_name" value="<?=$user['recommend_name']?>" /></td>
		</tr>
		<tr>
			<th>소개</th>
			<td><input type="text" name="recommend_introduce" value="<?=$user['recommend_introduce']?>"></td>
		</tr>
		<tr>
			<th>이미지</th>
			<td>
				<input type="file" name="recommend_pic" id="recommend_pic" class="fleft" />
				<? if ($user['recommend_pic'] && $user['recommend_pic']!='default.png') { ?>
					<img src="<?=$ft['path'].'/upload/recommend_pic/'.$user['recommend_pic']?>" alt="<?=$user['nickname']?>" class="recommend_pic ml10" />
					<div class="fleft mt5 ml10"><label><input type="checkbox" name="recommend_pic_del" id="recommend_pic_del" value="Y" />&nbsp;삭제</label></div>
				<? } ?>
				<span class="clear fleft">사용 가능한 이미지는 JPG, GIF 입니다.</span>
			</td>
		</tr>
		<tr>
			<td colspan="2"><input type="image" src="<?=$ft['img_path']?>/btn_ok.jpg" id="artist_submit" /></td>
		</tr>
	</table>
	</form>
</div>

</div>

<script type="text/javascript">
var recommend_pic_upload_result = 0;
var recommend_pic_del_result = 0;

function recommend_submit() {
	$.ajax({
		type: "POST",
		url: "<?=$ft['ajax_path']?>/user_recommend_config.php",
		data: $('#recommend_config_form').serialize(),
		success: function(result) {
			if (result) {
				alert('추천설정 변경완료.');
			}

			if ($('#recommend_pic').val()) recommend_pic_upload();
			if ($('#recommend_pic_del').attr('checked')) recommend_pic_del();

			setTimeout('page_refresh();', 3000);
		}
	});

	return false;
}

function page_refresh() {
	if (recommend_pic_upload_result!=1 && recommend_pic_del_result!=1) ajax_page_load('left_content', 'user_playlist');
}

function recommend_pic_upload() {
	recommend_pic_upload_result = 1;
	$.ajaxFileUpload({
		url:'<?=$ft['ajax_path']?>/user_recommend_pic_upload.php',
		secureuri:false,
		fileElementId:'recommend_pic',
		dataType: 'json',
		success: function(data, status) {
			if (typeof(data.error) != 'undefined') {
				if (data.error != '') {
					alert(data.error);
				} else {
					alert(data.msg);
					recommend_pic_upload_result = 0;
				}
			}
		},
		error: function(data, status, e) {
			alert(e);
		}
	});

	return false;
}

function recommend_pic_del() {
	recommend_pic_del_result = 1;
	$.ajax({
		type: "POST",
		url: "<?=$ft['ajax_path']?>/user_file_del.php",
		data: "field_name=recommend_pic&uid=<?=$user['uid']?>",
		success: function(msg) {
			if (msg) {
				alert(msg);
				recommend_pic_del_result = 0;
			}
		}
	});
}
</script>
