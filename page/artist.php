<?
$path = '..';

require($path.'/_common.php');

if (!$_POST['order']) $order = 'new';
else $order = $_POST['order'];

if ($order=='new') {
	$total = mysql_fetch_assoc(mysql_query('SELECT COUNT(*) AS `cnt` FROM `users` WHERE `type`="artist";'));

	$rows = 8;
	$total_page = ceil($total['cnt'] / $rows);
	if (!$_POST['p_num']) $p_num = 1;
	else $p_num = $_POST['p_num'];
	$first_index = ($p_num - 1) * $rows;

	if ($_POST['p_num'] && ($p_num <= 0 || $p_num > $total_page)) {
		alert('존재하지 않는 페이지입니다.');
	}

	$list = mysql_query('SELECT * FROM `users` WHERE `type`="artist" ORDER BY `uid` DESC LIMIT '.$first_index.', '.$rows.';');
} else if ($order=='hot') {
	$total = mysql_fetch_assoc(mysql_query('SELECT COUNT(DISTINCT `artist_uid_fk`) AS `cnt` FROM `ft_paid` WHERE `type`="present" AND `paid_date` LIKE "'.substr($ft['date'], 0, 7).'%";'));

	$rows = 8;
	$total_page = ceil($total['cnt'] / $rows);
	if (!$_POST['p_num']) $p_num = 1;
	else $p_num = $_POST['p_num'];
	$first_index = ($p_num - 1) * $rows;

	if ($_POST['p_num'] && ($p_num <= 0 || $p_num > $total_page)) {
		alert('존재하지 않는 페이지입니다.');
	}

	$list = mysql_query('SELECT *, SUM(`price`) AS `cnt` FROM `ft_paid` WHERE `type`="present" AND `paid_date` LIKE "'.substr($ft['date'], 0, 7).'%" GROUP BY `artist_uid_fk` ORDER BY `cnt` DESC, `paid_date` DESC, `paid_time` DESC LIMIT '.$first_index.', '.$rows.';');
}
?>

<div class="content_row w604">

<img class="title_img" src="<?=$ft['img_path']?>/title_artist.jpg" alt="artist title" />

<div class="fright">
	<span class="btn <?=$order=='new'?'bold':''?>" onclick="ajax_page_load('left_content', 'artist', '&order=new');">최신순</span> | <span class="btn <?=$order=='hot'?'bold':''?>" onclick="ajax_page_load('left_content', 'artist', '&order=hot');">인기순</span>
</div>

<table border="0" cellpadding="0" cellspacing="0" class="artist_container mb10">
	<tr>
	<? for ($i=0; $row=mysql_fetch_array($list); $i++) { ?>
	<?
		if ($order=='hot') {
			$row = mysql_fetch_assoc(mysql_query('SELECT * FROM `users` WHERE `uid`='.$row['artist_uid_fk'].';'));
			if (!$row['profile_pic']) $row['profile_pic'] = 'default.jpg';
		}
	?>
		<? if ($i && $i%4==0) echo '</tr><tr>'; ?>
		<td>
			<table border="0" cellpadding="0" cellspacing="0" class="artist_table">
				<tr>
					<td>
						<div class="artist_pic btn" onclick="window.open('<?=$ft['wall_path']?>/<?=$row['username']?>', 'wall', '');"><img src="<?=$ft['wall_path']?>/profile_pic/<?=$row['profile_pic']?$row['profile_pic']:'default.jpg'?>" alt="<?=$user['artistname']?>" /></div>
						<div class="artist_info limit_text btn" onclick="window.open('<?=$ft['wall_path']?>/<?=$row['username']?>', 'wall', '');">
							<img src="<?=$ft['img_path']?>/icon_artist.jpg" alt="artist icon" class="mh2" /> <?=$row['artistname']?>
						</div>
					</td>
				</tr>
			</table>
		</td>
	<? } ?>
	<?
	if ($i%8) {
		for ($j=$i%8; $j<8; $j++) {
			if ($j==4) echo '</tr><tr>';
			echo '<td>&nbsp;</td>';
		}
	} else if ($i%4) {
		for ($j=$i%4; $j<4; $j++) {
			echo '<td>&nbsp;</td>';
		}
	}
	?>
	<? if (!$i) { ?><tr><td>등록된 아티스트가 없습니다.</td></tr><? } ?>
	</tr>
</table>

<div id="paging" class="clear"></div>

</div>

<script type="text/javascript">$('#paging').html(ajax_paging(<?=$p_num?>, <?=$total_page?>, '<?=$_POST['target_id']?>', '<?=$_POST['page']?>', 10));</script>
