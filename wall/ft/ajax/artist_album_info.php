<?
$path = '../../..';

require($path.'/_common.php');

$album = mysql_fetch_assoc(mysql_query('SELECT * FROM `ft_album` WHERE `aid`='.$_POST['aid'].';'));
$genre_data = mysql_fetch_assoc(mysql_query('SELECT * FROM `ft_genre` WHERE `gid`='.$album['gid_fk'].';'));
$user_data = mysql_fetch_assoc(mysql_query('SELECT * FROM `users` WHERE `uid`='.$album['uid_fk'].';'));

$album_recommend_data = mysql_fetch_assoc(mysql_query('SELECT * FROM `ft_album_recommend` WHERE `aid_fk`='.$album['aid'].' AND `uid_fk`='.$user['uid'].';'));

if ($user['uid'] == $album['uid_fk']) $is_mypage = 1;
else $is_mypage = 0;
?>

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
				<span class="clear txt_btn" id="album_recommend_btn">
					<? if ($album_recommend_data['arid']) { ?>
					<span onclick="album_recommend(<?=$album['aid']?>, 'del');">추천 취소</span>
					<? } else { ?>
					<span onclick="album_recommend(<?=$album['aid']?>, 'ins');">추천</span>
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
		<? if ($is_mypage) { ?>
		<tr>
			<td colspan="3" class="nobtm">
				<span class="txt_btn fright ml2" onclick="album_del(<?=$album['aid']?>);">앨범삭제</span>
				<span class="txt_btn fright ml2" onclick="location.href='<?=$ft['wall_path']?>/ft.php?page=artist_album_reg&username=<?=$user['username']?>&aid=<?=$album['aid']?>';">앨범수정</span>
				<span class="txt_btn fright ml2" onclick="location.href='<?=$ft['wall_path']?>/ft.php?page=artist_track_reg&username=<?=$user['username']?>&aid=<?=$album['aid']?>';">트랙등록</span>
			</td>
		</tr>
		<? } ?>
	</tbody>
</table>
