<?
$path = '..';

require($path.'/_common.php');

$total = mysql_fetch_assoc(mysql_query('SELECT COUNT(*) AS `cnt` FROM `ft_paid` WHERE `uid_fk`='.$user['uid'].';'));

$rows = 10;
$total_page = ceil($total['cnt'] / $rows);
if (!$_POST['p_num']) $p_num = 1;
else $p_num = $_POST['p_num'];
$first_index = ($p_num - 1) * $rows;

if ($_POST['p_num'] && ($p_num <= 0 || $p_num > $total_page)) {
	alert('존재하지 않는 페이지입니다.');
}

$list = mysql_query('SELECT * FROM `ft_paid` WHERE `uid_fk`='.$user['uid'].' ORDER BY `paid_date` DESC, `paid_time` DESC LIMIT '.$first_index.', '.$rows.';');

$paging = get_paging($p_num, $total_page, $PHP_SELF.'?page='.$page.'&p_num=', 10);
?>

<div class="content_row w604">

<img class="title_img" src="<?=$ft['img_path']?>/title_paid.jpg" alt="paid title" />

<table border="0" cellpadding="0" cellspacing="0" summary="콩나물 사용 내역 리스트 테이블" class="list_table mb10">
	<caption>콩나물 사용 내역 리스트 테이블</caption>
	<colgroup>
		<col width="" />
		<col width="120" />
		<col width="170" />
	</colgroup>
	<thead>
	<tr>
		<th>사용처</th>
		<th>콩나물</th>
		<th>사용일시</th>
	</tr>
	</thead>
	<tbody>
	<? for ($i=0; $row=mysql_fetch_array($list); $i++) { ?>
		<? if ($row['type']=='track') { ?>
		<? $track = mysql_fetch_assoc(mysql_query('SELECT * FROM `ft_track` WHERE `tid`='.$row['tid_fk'].';')); ?>
		<? $album = mysql_fetch_assoc(mysql_query('SELECT * FROM `ft_album` WHERE `aid`='.$track['aid_fk'].';')); ?>
		<tr>
			<td><span class="fleft w100per limit_text align_left">트랙 구매 : <?=$track['trackname']?></span></td>
			<td><?=$row['price']?>개<!-- &nbsp;(<?=$row['price']*100?>원) --></td>
			<td><?=$row['paid_date']?>&nbsp;<?=$row['paid_time']?></td>
		</tr>
		<? } else if ($row['type']=='present') { ?>
		<? $artist_data = mysql_fetch_assoc(mysql_query('SELECT * FROM `users` WHERE `uid`='.$row['artist_uid_fk'].';')); ?>
		<tr>
			<td><span class="fleft w100per limit_text align_left"><?=$artist_data['artistname']?> 아티스트님에게 장미꽃 선물</span></td>
			<td><?=$row['price']?>개<!-- &nbsp;(<?=$row['price']*100?>원) --></td>
			<td><?=$row['paid_date']?>&nbsp;<?=$row['paid_time']?></td>
		</tr>
		<? } ?>
	<? } ?>
	<? if (!$i) { ?><tr><td colspan="3"><div class="pv20">사용 내역이 없습니다.</div></td></tr><? } ?>
	</tbody>
</table>

<div id="paging" class="clear"></div>

</div>

<script type="text/javascript">$('#paging').html(ajax_paging(<?=$p_num?>, <?=$total_page?>, '<?=$_POST['target_id']?>', '<?=$_POST['page']?>', 10));</script>
