<?
$path = '..';

require($path.'/_common.php');

$total = mysql_fetch_assoc(mysql_query('SELECT COUNT(*) AS `cnt` FROM `ft_album`;'));

$rows = 8;
$total_page = ceil($total['cnt'] / $rows);
if (!$_POST['p_num']) $p_num = 1;
else $p_num = $_POST['p_num'];
$first_index = ($p_num - 1) * $rows;

if ($_POST['p_num'] && ($p_num <= 0 || $p_num > $total_page)) {
	alert('존재하지 않는 페이지입니다.');
}

$tmp_no = $total['cnt'] - (($p_num - 1) * $rows);

if (!$_POST['order']) $order = 'aid';
else $order = $_POST['order'];

$list = mysql_query('SELECT * FROM `ft_album` ORDER BY `'.$order.'` DESC LIMIT '.$first_index.', '.$rows.';');
?>

<div class="content_row w604">

<img class="title_img" src="<?=$ft['img_path']?>/title_album.jpg" alt="album title" />

<div class="fright">
	<span class="btn <?=$order=='aid'?'bold':''?>" onclick="ajax_page_load('left_content', 'album', '&order=aid');">최신순</span> | <span class="btn <?=$order=='recommend_cnt'?'bold':''?>" onclick="ajax_page_load('left_content', 'album', '&order=recommend_cnt');">추천순</span>
</div>

<table border="0" cellpadding="0" cellspacing="0" class="album_container mb10">
	<tr>
	<? for ($i=0; $row=mysql_fetch_array($list); $i++) { ?>
		<?
		$user_data = mysql_fetch_assoc(mysql_query('SELECT * FROM `users` WHERE `uid`='.$row['uid_fk'].';'));

		if ($i && $i%4==0) echo '</tr><tr>';
		?>
		<td>
			<table border="0" cellpadding="0" cellspacing="0" class="album_table">
				<tr>
					<td>
						<div class="album_pic btn" onclick="ajax_page_load('left_content', 'album_detail', '&p_num=<?=$p_num?>&order=<?=$order?>&aid=<?=$row['aid']?>');"><img src="<?=$ft['path']?>/upload/album_pic/<?=$row['album_pic']?>" alt="album cover" /></div>
						<div class="album_info limit_text btn" onclick="ajax_page_load('left_content', 'album_detail', '&p_num=<?=$p_num?>&order=<?=$order?>&aid=<?=$row['aid']?>');">
							<img src="<?=$ft['img_path']?>/icon_album_title.jpg" alt="album title icon" />&nbsp;<?=$row['albumname']?>
						</div>
						<div class="album_info limit_text btn" onclick="window.open('<?=$ft['wall_path']?>/<?=$user_data['username']?>', 'wall', '');">
							<img src="<?=$ft['img_path']?>/icon_artist.jpg" alt="artist icon" class="mh2" />&nbsp;<?=$user_data['artistname']?>
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
	<? if (!$i) { ?><tr><td>등록된 앨범이 없습니다.</td></tr><? } ?>
	</tr>
</table>

<div id="paging" class="clear"></div>

</div>

<script type="text/javascript">$('#paging').html(ajax_paging(<?=$p_num?>, <?=$total_page?>, '<?=$_POST['target_id']?>', '<?=$_POST['page']?>', 10));</script>
