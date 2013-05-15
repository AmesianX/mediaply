<?
$path = '..';

require($path.'/_common.php');

$total = mysql_fetch_assoc(mysql_query('SELECT COUNT(*) AS `cnt` FROM `ft_payment` WHERE `uid_fk`='.$user['uid'].';'));

$rows = 10;
$total_page = ceil($total['cnt'] / $rows);
if (!$_POST['p_num']) $p_num = 1;
else $p_num = $_POST['p_num'];
$first_index = ($p_num - 1) * $rows;

if ($_POST['p_num'] && ($p_num <= 0 || $p_num > $total_page)) {
	alert('존재하지 않는 페이지입니다.');
}

$list = mysql_query('SELECT * FROM `ft_payment` WHERE `uid_fk`='.$user['uid'].' ORDER BY `pay_date` DESC, `pay_time` DESC LIMIT '.$first_index.', '.$rows.';');

$paging = get_paging($p_num, $total_page, $PHP_SELF.'?page='.$page.'&p_num=', 10);
?>

<div class="content_row w604">

<img class="title_img" src="<?=$ft['img_path']?>/title_payment_record.jpg" alt="payment record title" />

<table border="0" cellpadding="0" cellspacing="0" summary="콩나물 구매 내역 리스트 테이블" class="list_table mb10">
	<caption>콩나물 구매 내역 리스트 테이블</caption>
	<colgroup>
		<col width="" />
		<col width="120" />
		<col width="170" />
	</colgroup>
	<thead>
	<tr>
		<th>결제아이디</th>
		<th>콩나물</th>
		<th>구매일시</th>
	</tr>
	</thead>
	<tbody>
	<? for ($i=0; $row=mysql_fetch_array($list); $i++) { ?>
	<tr>
		<td><?=$row['tid']?></td>
		<td><?=$row['unitprice']/100?>개<!-- &nbsp;(<?=$row['unitprice']?>원) --></td>
		<td><?=$row['pay_date']?>&nbsp;<?=$row['pay_time']?></td>
	</tr>
	<? } ?>
	<? if (!$i) { ?><tr><td colspan="3"><div class="pv20">구매 내역이 없습니다.</div></td></tr><? } ?>
	</tbody>
</table>

<div id="paging" class="clear"></div>

</div>

<script type="text/javascript">$('#paging').html(ajax_paging(<?=$p_num?>, <?=$total_page?>, '<?=$_POST['target_id']?>', '<?=$_POST['page']?>', 10));</script>
