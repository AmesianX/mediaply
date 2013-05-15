<?
$menu_id = '03';

$row = mysql_fetch_assoc(mysql_query('SELECT * FROM `ft_album` WHERE `aid`='.$_GET['aid'].';'));
$genre_data = mysql_fetch_assoc(mysql_query('SELECT * FROM `ft_genre` WHERE `gid`='.$row['gid_fk'].';'));
$user_data = mysql_fetch_assoc(mysql_query('SELECT * FROM `users` WHERE `uid`='.$row['uid_fk'].';'));
?>

<div id="right_title">승인 대기 앨범 상세보기</div>

<div id="content">

	<table border="0" cellpadding="0" cellspacing="0" summary="승인 대기 앨범 상세보기 테이블" class="view_table">
		<caption>승인 대기 앨범 상세보기 테이블</caption>
		<colgroup>
			<col width="120" />
			<col width="80" />
			<col width="" />
		</colgroup>
		<tbody>
			<tr>
				<td rowspan="5"><div class="album_pic"><img src="<?=$ft['path']?>/upload/album_pic/<?=$row['album_pic']?>" alt="album image" /></div></td>
				<th>앨범명</th>
				<td><?=$row['albumname']?></td>
			</tr>
			<tr>
				<th>장르</th>
				<td><?=$genre_data['genre']?></td>
			</tr>
			<tr>
				<th>설명</th>
				<td><?=$row['explain']?></td>
			</tr>
			<tr>
				<th>작성자</th>
				<td><?=$user_data['username']?></td>
			</tr>
			<tr>
				<th>작성일시</th>
				<td><?=$row['reg_date']?>&nbsp;<?=$row['reg_time']?></td>
			</tr>
		</tbody>
	</table>

	<? $list = mysql_query('SELECT * FROM `ft_track` WHERE `aid_fk`='.$_GET['aid'].' ORDER BY `tid` ASC;'); ?>

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
			<col width="170" />
			<col width="80" />
			<col width="80" />
		</colgroup>
		<thead>
		<tr>
			<th>번호</th>
			<th>트랙명</th>
			<th>장르</th>
			<th>콩나물</th>
			<th>가사</th>
			<th>다운</th>
			<th>듣기</th>
			<th>작성일시</th>
			<th>상태</th>
			<th>승인</th>
		</tr>
		</thead>
		<tbody>
		<? for ($i=0; $row=mysql_fetch_array($list); $i++) { ?>
		<? $genre_data = mysql_fetch_assoc(mysql_query('SELECT * FROM `ft_genre` WHERE `gid`='.$row['gid_fk'].';')); ?>
		<tr>
			<td><?=$i+1?></td>
			<td><span class="fleft"><?=$row['trackname']?></span></td>
			<td><?=$genre_data['genre']?></td>
			<td><?=$row['price']?>&nbsp;개</td>
			<td><span class="btn" onclick="lyric_view(<?=$row['tid']?>);"><img src="<?=$ft['img_path']?>/icon_lyric_on.jpg" alt="view lyric" /></span>
			<td><span class="btn" onclick="track_download(<?=$row['tid']?>);"><img src="<?=$ft['img_path']?>/icon_download_on.jpg" alt="download track" /></span></td>
			<td><span class="btn" onclick="add_parent_streaming(<?=$row['aid_fk']?>, <?=$row['tid']?>);"><img src="<?=$ft['img_path']?>/icon_streaming_on.jpg" alt="add streaming" /></span></td>
			<td><?=$row['reg_date']?>&nbsp;<?=$row['reg_time']?></td>
			<td id="state_<?=$row['tid']?>"><?=$row['state']?></td>
			<td id="state_btn_<?=$row['tid']?>"><?=$row['state']=='N'?'<span class="btn" onclick="track_state('.$row['tid'].');">[승인]</span>':'-'?></td>
		</tr>
		<? } ?>
		</tbody>
	</table>

	<div class="clear mb10"></div>

</div>

<script type="text/javascript">
function track_state(tid) {
	$.ajax({
		url: path+'/admin/ajax/track_state.php',
		type: 'POST',
		dataType: 'html',
		data: 'tid='+tid,
		success: function(result) {
			if (result=='success') {
				$('#state_'+tid).html('Y');
				$('#state_btn_'+tid).html('-');
				alert('승인되었습니다.');
			}
		}
	});
}
</script>
