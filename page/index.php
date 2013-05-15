<?
$path = '..';

require($path.'/_common.php');

$album_list = mysql_query('SELECT * FROM `ft_album` ORDER BY `aid` DESC LIMIT 0, 24;');
$artist_list = mysql_query('SELECT * FROM `users` WHERE `type`="artist" ORDER BY `uid` DESC LIMIT 0, 24;');
?>

<div class="content_row w604">

<span class="btn" onclick="ajax_page_load('left_content', 'album');"><img class="title_img" src="<?=$ft['img_path']?>/title_new_album.jpg" alt="new album title" /></span>

<div id="jcarouselWidget1" class="jcarouselWidget">
	<div class="btnPrev"><img src="<?=$ft['img_path']?>/btn_arrow_left.jpg" alt="" /></div>
	<div class="jcarouselList">
		<ul>
			<li>
				<table border="0" cellpadding="0" cellspacing="0" class="album_container">
					<tr>
						<? for ($i=0; $row=mysql_fetch_array($album_list); $i++) { ?>
						<?
						$user_data = mysql_fetch_assoc(mysql_query('SELECT * FROM `users` WHERE `uid`='.$row['uid_fk'].';'));
						if ($i>0 && $i%8==0) echo '</tr></table></li><li><table border="0" cellpadding="0" cellspacing="0" class="album_container"><tr>';
						else if ($i>0 && $i%4==0) echo '</tr><tr>';
						?>
						<td>
							<table border="0" cellpadding="0" cellspacing="0" class="album_table">
								<tr>
									<td>
										<div class="album_pic btn" onclick="ajax_page_load('left_content', 'album_detail', '&p_num=<?=$p_num?>&aid=<?=$row['aid']?>');"><img src="<?=$ft['path']?>/upload/album_pic/<?=$row['album_pic']?>" alt="album cover" /></div>
										<div class="album_info limit_text btn" onclick="ajax_page_load('left_content', 'album_detail', '&p_num=<?=$p_num?>&aid=<?=$row['aid']?>');">
											<img src="<?=$ft['img_path']?>/icon_album_title.jpg" alt="album title icon" /> <?=$row['albumname']?>
										</div>
										<div class="album_info limit_text btn" onclick="window.open('<?=$ft['wall_path']?>/<?=$user_data['username']?>', 'wall', '');">
											<img src="<?=$ft['img_path']?>/icon_artist.jpg" alt="artist icon" class="mh2" /> <?=$user_data['artistname']?>
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
					</tr>
				</table>
			</li>
		</ul>
	</div>
	<div class="btnNext"><img src="<?=$ft['img_path']?>/btn_arrow_right.jpg" alt="" /></div>
</div>

<span class="btn" onclick="ajax_page_load('left_content', 'artist');"><img class="title_img mt30" src="<?=$ft['img_path']?>/title_new_artist.jpg" alt="new artist title" /></span>

<div id="jcarouselWidget2" class="jcarouselWidget">
	<div class="btnPrev"><img src="<?=$ft['img_path']?>/btn_arrow_left.jpg" alt="" /></div>
	<div class="jcarouselList">
		<ul>
			<li>
				<table border="0" cellpadding="0" cellspacing="0" class="artist_container">
					<tr>
						<? for ($i=0; $row=mysql_fetch_array($artist_list); $i++) { ?>
						<?
						if ($i>0 && $i%8==0) echo '</tr></table></li><li><table border="0" cellpadding="0" cellspacing="0" class="artist_container"><tr>';
						else if ($i>0 && $i%4==0) echo '</tr><tr>';
						?>
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
					</tr>
				</table>
			</li>
		</ul>
	</div>
	<div class="btnNext"><img src="<?=$ft['img_path']?>/btn_arrow_right.jpg" alt="" /></div>
</div>

</div>
