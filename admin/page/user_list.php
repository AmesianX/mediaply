<?
$menu_id = '02';

$where = 'WHERE 1';

if ($_GET['search_txt']) $where .= ' AND `'.$_GET['search_field'].'` like "%'.$_GET['search_txt'].'%"';

$total = mysql_fetch_assoc(mysql_query('SELECT COUNT(*) AS `cnt` FROM `users` '.$where.';'));

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

$list = mysql_query('SELECT * FROM `users` '.$where.' ORDER BY `uid` DESC LIMIT '.$first_index.', '.$rows.';');

$paging = get_paging($p_num, $total_page, $PHP_SELF.'?page='.$page.'&p_num=', 10);
?>

<div id="right_title">회원 리스트</div>

<div id="content">

	<div class="clear fright mb10">
		<select name="search_field" id="search_field">
			<option value="username" <?=$_GET['search_field']=='username'?'selected="selected"':''?>>아이디</option>
			<option value="nickname" <?=$_GET['search_field']=='nickname'?'selected="selected"':''?>>닉네임</option>
			<option value="artistname" <?=$_GET['search_field']=='artistname'?'selected="selected"':''?>>아티스트네임</option>
			<option value="email" <?=$_GET['search_field']=='email'?'selected="selected"':''?>>이메일</option>
		</select>
		<input type="text" name="search_txt" id="search_txt" value="<?=$_GET['search_txt']?>" />
		<input type="button" value="&nbsp;검색&nbsp;" onclick="location.href='<?=$ft['adm_path']?>/?page=<?=$page?>&p_num=<?=$p_num?>&search_field='+$('#search_field').val()+'&search_txt='+$('#search_txt').val();" />
	</div>

	<form name="user_list_form" method="post" action="<?=$ft['adm_op_path']?>/user_list.php">
	<input type="hidden" name="page" value="<?=$page?>" />
	<input type="hidden" name="p_num" value="<?=$p_num?>" />
	<table border="0" cellpadding="0" cellspacing="0" summary="회원 리스트 테이블" class="list_table">
		<caption>회원 리스트 테이블</caption>
		<colgroup>
			<col width="60" />
			<col width="120" />
			<col width="120" />
			<col width="120" />
			<col width="120" />
			<col width="" />
			<col width="170" />
		</colgroup>
		<thead>
		<tr>
			<th>번호</th>
			<th>아이디</th>
			<th>닉네임</th>
			<th>아티스트네임</th>
			<th>구분</th>
			<th>이메일</th>
			<th>가입일시</th>
		</tr>
		</thead>
		<tbody>
		<? for ($i=0; $row=mysql_fetch_array($list); $i++) { ?>
		<tr>
			<td><?=$tmp_no--?><? if ($user['uid']!=$row['uid']) { ?><input type="hidden" name="uid[]" value="<?=$row['uid']?>" /><? } ?></td>
			<td><?=$row['username']?></td>
			<td><?=$row['nickname']?></td>
			<td><?=$row['artistname']?></td>
			<td>
				<? if ($user['uid']!=$row['uid']) { ?>
				<select name="type[]">
					<option value="listener" <?=$row['type']=='listener'?'selected="selected"':''?>>listener</option>
					<option value="artist" <?=$row['type']=='artist'?'selected="selected"':''?>>artist</option>
					<option value="admin" <?=$row['type']=='admin'?'selected="selected"':''?>>admin</option>
				</select>
				<? } else { ?>
				<?=$row['type']?>
				<? } ?>
			</td>
			<td><?=$row['email']?></td>
			<td><?=$row['reg_date']?>&nbsp;<?=$row['reg_time']?></td>
		</tr>
		<? } ?>
		</tbody>
	</table>
	</form>

	<div class="clear mb10"><?=$paging?></div>

	<div class="clear pv20 align_right">
		<span class="txt_btn" onclick="document.user_list_form.submit();">적용</span>
	</div>

</div>
