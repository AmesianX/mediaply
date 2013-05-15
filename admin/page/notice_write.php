<?
$menu_id = '01';

if ($_GET['id']) $notice = mysql_fetch_assoc(mysql_query('SELECT * FROM `ft_notice` WHERE `id`='.$_GET['id'].';'));
?>

<div id="right_title">공지 설정</div>

<div id="content">

	<form name="notice_form" method="post" action="<?=$ft['adm_op_path']?>/notice_write.php">
	<input type="hidden" name="act" value="<?=$notice['id']?'mod':'ins'?>" />
	<input type="hidden" name="id" value="<?=$notice['id']?>" />
	<input type="hidden" name="page" value="<?=$page?>" />
	<input type="hidden" name="p_num" value="<?=$p_num?>" />
	<table border="0" cellpadding="0" cellspacing="0" summary="공지 쓰기 테이블" class="write_table">
		<caption>공지 쓰기 테이블</caption>
		<colgroup>
			<col width="140" />
			<col width="" />
		</colgroup>
		<tr>
			<th>제목</th><td><input type="text" name="subject" value="<?=$notice['subject']?>" /></td>
		</tr>
		<tr>
			<th>내용</th><td><textarea name="content"><?=$notice['content']?></textarea></td>
		</tr>
	</table>
	</form>

	<div class="clear pv20 align_right">
		<span class="txt_btn" onclick="location.href='<?=$ft['adm_path']?>/?page=notice_list&p_num=<?=$p_num?>';">목록보기</span>
		<span class="txt_btn" onclick="document.notice_form.submit();">작성완료</span>
	</div>

</div>
