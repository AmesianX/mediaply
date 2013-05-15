<?
$menu_id = '04';

$where = 'WHERE 1';

$total = mysql_fetch_assoc(mysql_query('SELECT COUNT(*) AS `cnt` FROM `ft_payment` '.$where.';'));

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

$list = mysql_query('SELECT * FROM `ft_payment` '.$where.' ORDER BY `pay_date` DESC, `pay_time` DESC LIMIT '.$first_index.', '.$rows.';');

$paging = get_paging($p_num, $total_page, $PHP_SELF.'?page='.$page.'&p_num=', 10);
?>

<div id="right_title">결제 내역</div>

<div id="content">

	<table border="0" cellpadding="0" cellspacing="0" summary="결제 내역 리스트 테이블" class="list_table">
		<caption>결제 내역 리스트 테이블</caption>
		<colgroup>
			<col width="60" />
			<col width="" />
			<col width="120" />
			<col width="120" />
			<col width="120" />
			<col width="170" />
		</colgroup>
		<thead>
		<tr>
			<th>번호</th>
			<th>결제아이디</th>
			<th>회원아이디</th>
			<th>금액</th>
			<th>결제구분</th>
			<th>결제일시</th>
		</tr>
		</thead>
		<tbody>
		<? for ($i=0; $row=mysql_fetch_array($list); $i++) { ?>
		<? $user_data = mysql_fetch_assoc(mysql_query('SELECT * FROM `users` WHERE `uid`='.$row['uid_fk'].';')); ?>
		<tr>
			<td><?=$tmp_no--?></td>
			<td><?=$row['tid']?></td>
			<td><?=$user_data['username']?></td>
			<td><?=$row['unitprice']?></td>
			<td><?=$row['paymethod']?></td>
			<td><?=$row['pay_date']?>&nbsp;<?=$row['pay_time']?></td>
		</tr>
		<? } ?>
		</tbody>
	</table>

	<div class="clear mb10"><?=$paging?></div>

</div>
