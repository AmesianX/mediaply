<?
if ($profile['type']!='artist' &&  $profile['type'] != 'admin') {
	alert('아티스트 회원이 아닙니다.');
	location_replace($ft['wall_path']);
}

$list = mysql_query('SELECT * FROM `ft_album` WHERE `uid_fk`='.$profile['uid'].' ORDER BY `aid` DESC;');
?>

<script type="text/javascript">
$(document).ready(function(){
	$('#jcarouselWidget1 .jcarouselList').jCarouselLite({
		visible: 4,
		speed: 500,
		btnPrev: '#jcarouselWidget1 .btnPrev',
		btnNext: '#jcarouselWidget1 .btnNext',
		circular: false
	});
});

function album_click(aid) {
	$.ajax({
		type: "POST",
		url: "<?=$ft['wall_path']?>/ft/ajax/artist_album_info.php",
		data: 'aid='+aid,
		success: function(result) {
			$('#album_info').html(result);
			$.ajax({
				type: "POST",
				url: "<?=$ft['wall_path']?>/ft/ajax/artist_album_track.php",
				data: 'aid='+aid,
				success: function(result) {
					$('#track_list').html(result);
				}
			});
		}
	});
}

function album_del(aid) {
	if (confirm('앨범에 포함된 트랙이 함께 삭제됩니다.\n삭제하시겠습니까?')) {
		$.ajax({
			type: "POST",
			url: "<?=$ft['ajax_path']?>/artist_album_del.php",
			data: 'aid='+aid,
			success: function() {
				alert('앨범 삭제 완료.');
				location.reload();
			}
		});
	}
}

function track_del(tid) {
	if (confirm('삭제하시겠습니까?')) {
		$.ajax({
			type: "POST",
			url: "<?=$ft['ajax_path']?>/artist_track_del.php",
			data: 'tid='+tid,
			success: function() {
				alert('트랙 삭제 완료.');
				location.reload();
			}
		});
	}
}
</script>

<img class="title_img mb10 ml20" src="<?=$ft['img_path']?>/title_mypage_album.jpg" alt="album title" />
<div id="jcarouselWidget1" class="jcarouselWidget">
	<div class="btnPrev"><img src="<?=$ft['img_path']?>/btn_arrow_left.png" alt="" /></div>
	<div class="jcarouselList">
		<ul>
			<? for ($i=0; $row=mysql_fetch_array($list); $i++) { ?>
			<? if ($i==0 && $row['aid']) $first_aid = $row['aid']; ?>
			<li><div class="album_pic btn" onclick="album_click(<?=$row['aid']?>);"><img src="<?=$ft['path']?>/upload/album_pic/<?=$row['album_pic']?>" alt="album cover" /></div></li>
			<? } ?>
			<?
			if (!$i) {
				for ($i=0; $i<4; $i++) {
					echo '<li>&nbsp;<br />&nbsp;</li>';
				}
			}
			?>
		</ul>
	</div>
	<div class="btnNext"><img src="<?=$ft['img_path']?>/btn_arrow_right.png" alt="" /></div>
</div>

<img class="title_img mt30 mb10 ml20" src="<?=$ft['img_path']?>/title_mypage_album_info.jpg" alt="album info title" />

<div id="album_info" class="ph20"></div>

<img class="title_img mt30 mb10 ml20" src="<?=$ft['img_path']?>/title_mypage_album_track.jpg" alt="track list title" />

<div id="track_list" class="ph20"></div>

<? if ($is_mypage) { ?>
<div class="clear fright mt10 mr20">
	<span class="txt_btn" onclick="location.href='<?=$PHP_SELF?>?page=artist_album_reg&username=<?=$_GET['username']?>';">앨범등록</span>
</div>
<? } ?>

<script type="text/javascript">
<? if ($first_aid) { ?>album_click(<?=$first_aid?>);<? } ?>
</script>
