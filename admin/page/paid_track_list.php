<?
$menu_id = '04';

$where = 'WHERE 1 AND `type`="track" AND `price`>0';

$total = mysql_fetch_assoc(mysql_query('SELECT COUNT(*) AS `cnt` FROM `ft_paid` '.$where.';'));

$rows = 10;
$total_page = ceil($total['cnt'] / $rows);
if (!$_GET['p_num']) $p_num = 1;
else $p_num = $_GET['p_num'];
$first_index = ($p_num - 1) * $rows;

if ($_GET['p_num'] && ($p_num <= 0 || $p_num > $total_page)) {
	alert('존재하지 않는 페이지입니다.');
	location_replace($ft['adm_path']);
}

$tmp_no = $total['cnt'] - (($p_num - 1) * $rows);

$list = mysql_query('SELECT * FROM `ft_paid` '.$where.' ORDER BY `paid_date` DESC, `paid_time` DESC LIMIT '.$first_index.', '.$rows.';');

$paging = get_paging($p_num, $total_page, $PHP_SELF.'?page='.$page.'&p_num=', 10);
?>

<div id="right_title">트랙 구매 내역</div>

<div id="content">

	<table border="0" cellpadding="0" cellspacing="0" summary="트랙 구매 내역 리스트 테이블" class="list_table">
		<caption>트랙 구매 내역 리스트 테이블</caption>
		<colgroup>
			<col width="60" />
			<col width="" />
			<col width="170" />
			<col width="170" />
			<col width="120" />
			<col width="170" />
			<col width="120" />
		</colgroup>
		<thead>
		<tr>
			<th>번호</th>
			<th>트랙명</th>
			<th>구매회원아이디</th>
			<th>아티스트회원아이디</th>
			<th>콩나물</th>
			<th>구매일시</th>
			<th>앨범정보</th>
		</tr>
		</thead>
		<tbody>
		<? for ($i=0; $row=mysql_fetch_array($list); $i++) { ?>
		<? $track = mysql_fetch_assoc(mysql_query('SELECT * FROM `ft_track` WHERE `tid`='.$row['tid_fk'].';')); ?>
		<? $album = mysql_fetch_assoc(mysql_query('SELECT * FROM `ft_album` WHERE `aid`='.$track['aid_fk'].';')); ?>
		<? $user_data = mysql_fetch_assoc(mysql_query('SELECT * FROM `users` WHERE `uid`='.$row['uid_fk'].';')); ?>
		<? $artist_data = mysql_fetch_assoc(mysql_query('SELECT * FROM `users` WHERE `uid`='.$row['artist_uid_fk'].';')); ?>
		<tr>
			<td><?=$tmp_no--?></td>
			<td><span class="fleft w100per limit_text align_left"><?=$track['trackname']?></span></td>
			<td><?=$user_data['username']?></td>
			<td><?=$artist_data['username']?></td>
			<td><?=$row['price']?>개</td>
			<td><?=$row['paid_date']?>&nbsp;<?=$row['paid_time']?></td>
			<td><span class="btn" onclick="location.href='<?=$ft['adm_path']?>/?page=album_view&aid=<?=$album['aid']?>';">상세보기</span></td>
		</tr>
		<? } ?>
		</tbody>
	</table>

	<div class="clear mb10"><?=$paging?></div>

</div>
