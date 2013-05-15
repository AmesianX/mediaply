<?
$path = '..';

require($path.'/_common.php');

$notice = mysql_fetch_assoc(mysql_query('SELECT * FROM `ft_notice` WHERE `id`='.$_POST['id'].';'));
?>

<div class="content_row w604">

<img class="title_img" src="<?=$ft['img_path']?>/title_notice.jpg" alt="notice title" />

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

<div class="clear fright mt10">
	<span class="txt_btn" onclick="ajax_page_load('left_content', 'notice_list', '&p_num=<?=$_POST['p_num']?>');">목록보기</span>
</div>

</div>
