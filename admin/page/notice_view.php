<?
$menu_id = '01';

$notice = mysql_fetch_assoc(mysql_query('SELECT * FROM `ft_notice` WHERE `id`='.$_GET['id'].';'));
?>

<div id="right_title">공지 설정</div>

<div id="content">

	<table border="0" cellpadding="0" cellspacing="0" summary="공지 읽기 테이블" class="notice_view_table">
		<caption>공지 읽기 테이블</caption>
		<colgroup>
			<col width="10%" />
			<col width="40%" />
			<col width="10%" />
			<col width="40%" />
		</colgroup>
		<thead>
			<tr>
				<th>제목</th>
				<td><?=$notice['subject']?></td>
				<th>등록일</th>
				<td><?=$notice['reg_date']?>&nbsp;<?=$notice['reg_time']?></td>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td colspan="4"><?=nl2br($notice['content'])?></td>
			</tr>
		</tbody>
	</table>

	<div class="clear mb10"></div>

	<div class="clear pv20 align_right">
		<span class="txt_btn" onclick="location.href='<?=$ft['adm_path']?>/?page=notice_list&p_num=<?=$p_num?>';">목록보기</span>
	</div>

</div>
