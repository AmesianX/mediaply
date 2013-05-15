<?
$path = '..';

require($path.'/_common.php');

$total = mysql_fetch_assoc(mysql_query('SELECT COUNT(*) AS `cnt` FROM `ft_notice`'));

$rows = 10;
$total_page = ceil($total['cnt'] / $rows);
if (!$_POST['p_num']) $p_num = 1;
else $p_num = $_POST['p_num'];
$first_index = ($p_num - 1) * $rows;

if ($_POST['p_num'] && ($p_num <= 0 || $p_num > $total_page)) {
	alert('존재하지 않는 페이지입니다.');
}

$tmp_no = $total['cnt'] - (($p_num - 1) * $rows);

$list = mysql_query('SELECT * FROM `ft_notice` ORDER BY `id` DESC LIMIT '.$first_index.', '.$rows.';');
?>

<div class="content_row w604">

<img class="title_img" src="<?=$ft['img_path']?>/title_notice.jpg" alt="notice title" />

<table border="0" cellpadding="0" cellspacing="0" summary="공지 리스트 테이블" class="list_table mb10">
	<caption>공지 리스트 테이블</caption>
	<colgroup>
		<col width="60" />
		<col width="" />
		<col width="170" />
	</colgroup>
	<thead>
	<tr>
		<th>번호</th>
		<th>제목</th>
		<th>작성일시</th>
	</tr>
	</thead>
	<tbody>
	<? for ($i=0; $row=mysql_fetch_array($list); $i++) { ?>
	<tr>
		<td><?=$tmp_no--?></td>
		<td><span class="fleft w100per limit_text align_left btn" onclick="ajax_page_load('left_content', 'notice_view', '&p_num=<?=$p_num?>&id=<?=$row['id']?>');"><?=$row['subject']?></span></td>
		<td><?=$row['reg_date']?>&nbsp;<?=$row['reg_time']?></td>
	</tr>
	<? } ?>
	<? if (!$i) { ?><tr><td colspan="3"><div class="pv20">등록된 공지사항이 없습니다.</div></td></tr><? } ?>
	</tbody>
</table>

<div id="paging" class="clear"></div>

</div>

<script type="text/javascript">$('#paging').html(ajax_paging(<?=$p_num?>, <?=$total_page?>, '<?=$_POST['target_id']?>', '<?=$_POST['page']?>', 10));</script>
