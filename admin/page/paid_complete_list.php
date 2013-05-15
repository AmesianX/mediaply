<?
$menu_id = '04';

$where = 'WHERE 1 AND `state`="Y" AND `price`>0';

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

<div id="right_title">출금 완료 내역</div>

<div id="content">

	<input type="hidden" name="page" value="<?=$page?>" />
	<table border="0" cellpadding="0" cellspacing="0" summary="출금 완료 내역 리스트 테이블" class="list_table" id="paid_list_table">
		<caption>출금 완료 내역 리스트 테이블</caption>
		<colgroup>
			<col width="60" />
			<col width="120" />
			<col width="120" />
			<col width="" />
			<col width="170" />
		</colgroup>
		<thead>
		<tr>
			<th>번호</th>
			<th>회원아이디</th>
			<th>콩나물</th>
			<th>내역</th>
			<th>일시</th>
		</tr>
		</thead>
		<tbody>
		<? for ($i=0; $row=mysql_fetch_array($list); $i++) { ?>
		<? $artist_data = mysql_fetch_assoc(mysql_query('SELECT * FROM `users` WHERE `uid`='.$row['artist_uid_fk'].';')); ?>
		<tr>
			<td><?=$tmp_no--?></td>
			<td><?=$artist_data['username']?></td>
			<td><?=$row['price']?>개<!-- &nbsp;(<?=$row['price']*100?>원) --></td>
			<? if ($row['type']=='track') { ?>
			<? $track = mysql_fetch_assoc(mysql_query('SELECT * FROM `ft_track` WHERE `tid`='.$row['tid_fk'].';')); ?>
			<? $album = mysql_fetch_assoc(mysql_query('SELECT * FROM `ft_album` WHERE `aid`='.$track['aid_fk'].';')); ?>
			<td><span class="fleft w100per limit_text align_left">트랙 판매 : <?=$track['trackname']?></span></td>
			<? } else if ($row['type']=='present') { ?>
			<? $user_data = mysql_fetch_assoc(mysql_query('SELECT * FROM `users` WHERE `uid`='.$row['uid_fk'].';')); ?>
			<td><span class="fleft w100per limit_text align_left"><?=$user_data['username']?> 님으로부터 장미꽃 선물</span></td>
			<? } ?>
			<td><?=$row['paid_date']?>&nbsp;<?=$row['paid_time']?></td>
		</tr>
		<? } ?>
		</tbody>
	</table>

	<div class="clear mb10"><?=$paging?></div>

</div>
