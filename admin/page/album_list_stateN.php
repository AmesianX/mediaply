<?
$menu_id = '03';

$where = 'WHERE 1';

$total = mysql_fetch_assoc(mysql_query('SELECT COUNT(DISTINCT `b`.`aid_fk`) AS `cnt` FROM `ft_album` `a`, `ft_track` `b` '.$where.' AND `a`.`aid`=`b`.`aid_fk` AND `b`.`state`="N";'));

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

$list = mysql_query('SELECT `a`.* FROM `ft_album` `a`, `ft_track` `b` '.$where.' AND `a`.`aid`=`b`.`aid_fk` AND `b`.`state`="N" GROUP BY `b`.`aid_fk` ORDER BY `a`.`aid` DESC LIMIT '.$first_index.', '.$rows.';');

$paging = get_paging($p_num, $total_page, $PHP_SELF.'?page='.$page.'&p_num=', 10);
?>

<div id="right_title">승인 대기 앨범 리스트</div>

<div id="content">

	<table border="0" cellpadding="0" cellspacing="0" summary="승인 대기 앨범 리스트 테이블" class="list_table">
		<caption>승인 대기 앨범 리스트 테이블</caption>
		<colgroup>
			<col width="60" />
			<col width="120" />
			<col width="120" />
			<col width="120" />
			<col width="" />
			<col width="120" />
			<col width="170" />
		</colgroup>
		<thead>
		<tr>
			<th>번호</th>
			<th>앨범이미지</th>
			<th>앨범명</th>
			<th>장르</th>
			<th>설명</th>
			<th>작성자</th>
			<th>작성일시</th>
		</tr>
		</thead>
		<tbody>
		<? for ($i=0; $row=mysql_fetch_array($list); $i++) { ?>
		<?
		$genre_data = mysql_fetch_assoc(mysql_query('SELECT * FROM `ft_genre` WHERE `gid`='.$row['gid_fk'].';'));
		$user_data = mysql_fetch_assoc(mysql_query('SELECT * FROM `users` WHERE `uid`='.$row['uid_fk'].';'));
		?>
		<tr class="btn" onclick="location.href='<?=$ft['adm_path']?>/?page=album_view_stateN&p_num=<?=$p_num?>&aid=<?=$row['aid']?>';">
			<td><?=$tmp_no--?></td>
			<td><div class="album_pic"><img src="<?=$ft['path']?>/upload/album_pic/<?=$row['album_pic']?>" alt="album image" /></div></td>
			<td><?=$row['albumname']?></td>
			<td><?=$genre_data['genre']?></td>
			<td><?=$row['explain']?></td>
			<td><?=$user_data['username']?></td>
			<td><?=$row['reg_date']?>&nbsp;<?=$row['reg_time']?></td>
		</tr>
		<? } ?>
		</tbody>
	</table>

	<div class="clear mb10"><?=$paging?></div>

</div>
