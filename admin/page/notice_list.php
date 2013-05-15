<?
$menu_id = '01';

$where = 'WHERE 1';

$total = mysql_fetch_assoc(mysql_query('SELECT COUNT(*) AS `cnt` FROM `ft_notice` '.$where.';'));

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

$list = mysql_query('SELECT * FROM `ft_notice` '.$where.' ORDER BY `id` DESC LIMIT '.$first_index.', '.$rows.';');

$paging = get_paging($p_num, $total_page, $PHP_SELF.'?page='.$page.'&p_num=', 10);
?>

<script type="text/javascript">
function post_delete(id) {
	if (confirm('삭제하시겠습니까?')) {
		location.href='<?=$ft['adm_path']?>/operation/notice_delete.php?p_num=<?=$p_num?>&id='+id;
	}
}
</script>

<div id="right_title">공지 설정</div>

<div id="content">

	<table border="0" cellpadding="0" cellspacing="0" summary="공지 리스트 테이블" class="list_table">
		<caption>공지 리스트 테이블</caption>
		<colgroup>
			<col width="60" />
			<col width="" />
			<col width="170" />
			<col width="60" />
			<col width="60" />
		</colgroup>
		<thead>
		<tr>
			<th>번호</th>
			<th>제목</th>
			<th>작성일시</th>
			<th>수정</th>
			<th>삭제</th>
		</tr>
		</thead>
		<tbody>
		<? for ($i=0; $row=mysql_fetch_array($list); $i++) { ?>
		<tr>
			<td><?=$tmp_no--?></td>
			<td><span class="fleft w100per limit_text align_left btn" onclick="location.href='<?=$ft['adm_path']?>/?page=notice_view&p_num=<?=$p_num?>&id=<?=$row['id']?>';"><?=$row['subject']?></span></td>
			<td><?=$row['reg_date']?>&nbsp;<?=$row['reg_time']?></td>
			<td><span class="btn" onclick="location.href='<?=$ft['adm_path']?>/?page=notice_write&p_num=<?=$p_num?>&id=<?=$row['id']?>';">수정</span></td>
			<td><span class="btn" onclick="post_delete(<?=$row['id']?>);">삭제</span></td>
		</tr>
		<? } ?>
		</tbody>
	</table>

	<div class="clear mb10"><?=$paging?></div>

	<div class="clear pv20 align_right">
		<span class="txt_btn" onclick="location.href='<?=$ft['adm_path']?>/?page=notice_write&p_num=<?=$p_num?>';">글쓰기</span>
	</div>

</div>
