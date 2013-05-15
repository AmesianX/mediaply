<form name="logout_form" method="post" action="<?=$ft['path']?>"><input type="hidden" name="logout" value="1" /></form>

<div id="bar">
	<div id="top_container">
		<span class="btn fleft" onclick="location.href='<?=$ft['wall_path']?>/';"><img id="logo_small" src="<?=$ft['img_path']?>/logo_small.png" alt="logo" /></span>
		<div id="searchbox">
			<input type="text" class="uiinput" id="searchinput" />
			<div id="display"></div>
		</div>
		<div class="fright">
			<? if ($is_user) { ?>
			<span class="fleft btn ml20 font_FFFFFF" onclick="location.href='<?=$ft['wall_path']?>/';">뉴스피드</span>
			<span class="fleft btn ml20 font_FFFFFF" onclick="location.href='<?=$ft['wall_path']?>/<?=$user['username']?>';">담벼락</span>
			<span class="fleft btn ml20 font_FFFFFF" onclick="location.href='<?=$ft['wall_path']?>/ft.php?page=timeline&username=<?=$user['username']?>';">타임라인</span>
			<span class="fleft btn ml20 font_FFFFFF" onclick="location.href='<?=$ft['wall_path']?>/ft.php?page=friends&username=<?=$user['username']?>';">친구목록</span>
			<span class="fleft btn ml20 font_FFFFFF" onclick="location.href='<?=$ft['wall_path']?>/ft.php?page=user_modify';">계정설정</span>
			<span class="fleft btn ml20 font_FFFFFF" onclick="document.logout_form.submit();">로그아웃</span>
			<? } ?>
		</div>
	</div>
</div>

<div id="div_bg"></div>
<div class="relative">
	<div id="present">
		<table border="0" cellpadding="0" cellspacing="0" class="write_table">
			<colgroup>
				<col width="50%" />
				<col width="50%" />
			</colgroup>
			<tr>
				<th colspan="2" class="title">장미꽃 선물하기<span class="btn fright" onclick="$('#div_bg').fadeOut(1000);$('#present').fadeOut(1000);"><img src="<?=$ft['img_path']?>/btn_close.jpg" alt="close button" /></span></th>
			</tr>
			<tr>
				<th>수량</th>
				<td><img src="<?=$ft['img_path']?>/icon_rose.jpg" alt="rose icon" />&nbsp;x&nbsp;<input type="text" name="cnt" id="cnt" /></td>
			</tr>
			<tr>
				<th colspan="2"><div class="align_center"><span class="btn" onclick="present(<?=$profile['uid']?>, $('#cnt').val());">확인</span></div></th>
			</tr>
		</table>
	</div>
</div>

<div class="w950">

<div id="left_div">
	<a href="<?=$ft['wall_path']?>/profile_pic/<?=$profile['profile_pic']?>" rel="facebox"><img src="<?=$ft['wall_path']?>/profile_pic/<?=$profile['profile_pic']?>" id="left_profile_pic" /></a>
	<span class="clear fleft w100per limit_text align_left mt15 font_13"><span class="profile_title"><?=$profile['nickname']?></span>(<?=$profile['username']?>)</span>
	<? if ($profile['type']=='artist') { ?>
	<? $genre1 = @mysql_fetch_assoc(mysql_query('SELECT * FROM `ft_genre` WHERE `gid`='.$profile['gid_fk1'].';')); ?>
	<? $genre2 = @mysql_fetch_assoc(mysql_query('SELECT * FROM `ft_genre` WHERE `gid`='.$profile['gid_fk2'].';')); ?>
	<span class="clear fleft w100per limit_text align_left mt15 border_bottom"><span class="profile_title">아티스트명</span>&nbsp;<?=$profile['artistname']?></span>
	<? if ($profile['label']) { ?><span class="clear fleft w100per limit_text align_left mt5 border_bottom"><span class="profile_title">레이블</span>&nbsp;<?=$profile['label']?></span><? } ?>
	<? if ($genre1['genre'] || $genre2['genre']) { ?><span class="clear fleft w100per limit_text align_left mt5 border_bottom"><span class="profile_title">장르</span>&nbsp;<?=$genre1['genre']?><?=($genre1['genre'] && $genre2['genre'])?',&nbsp;':''?><?=$genre2['genre']?></span><? } ?>
	<? if ($profile['introduce']) { ?><span class="clear fleft w100per limit_text align_left mt5"><span class="profile_title">소개</span></span>
	<span class="clear fleft w100per align_left mt5 border break_all"><?=nl2br($profile['introduce'])?></span><? } ?>
	<span class="clear fleft btn mt15" onclick="location.href='<?=$ft['wall_path']?>/ft.php?page=artist_album_list&username=<?=$profile['username']?>';"><span class="profile_title"><img src="<?=$ft['img_path']?>/icon_album.jpg" alt="album icon" />&nbsp;<?=$is_mypage?'앨범관리':'앨범목록'?></span></span>
	<? if ($is_mypage) { ?><span class="fleft btn mt15 profile_title" onclick="location.href='<?=$ft['wall_path']?>/ft.php?page=track';">(판매내역)</span><? } ?>
	<? if (!$is_mypage) { ?>
	<span class="clear fleft btn mt5" onclick="$('#div_bg').fadeTo(1000, 0.5);$('#present').fadeTo(1000, 1);"><span class="profile_title"><img src="<?=$ft['img_path']?>/icon_rose.jpg" alt="rose icon" />&nbsp;장미꽃 선물하기</span></span>
	<? } else { ?>
	<span class="clear fleft btn mt5" onclick="location.href='<?=$ft['wall_path']?>/ft.php?page=present';"><span class="profile_title"><img src="<?=$ft['img_path']?>/icon_rose.jpg" alt="rose icon" />&nbsp;장미꽃 선물함</span></span>
	<? } ?>
	<? } ?>
	<span class="clear fleft btn mt<?=$profile['type']=='artist'?'':'1'?>5" onclick="location.href='<?=$ft['wall_path']?>/<?=$profile['username']?>';"><span class="profile_title"><img src="<?=$ft['img_path']?>/icon_wall.jpg" alt="wall icon" />&nbsp;담벼락</span></span>
	<span class="clear fleft btn mt5" onclick="location.href='<?=$ft['wall_path']?>/ft.php?page=timeline&username=<?=$profile['username']?>';"><span class="profile_title"><img src="<?=$ft['img_path']?>/icon_timeline.jpg" alt="timeline icon" />&nbsp;타임라인</span></span>
</div>

<div id="right_div">
	<div class="fleft ml15 bold font_20"><?=$profile['mypage_title']?$profile['mypage_title']:$profile['nickname'].'님의 마이페이지'?></div>
	<div class="clear pb20"></div>

<script type="text/javascript">
function present(artist_uid_fk, cnt) {
	if (!/^[0-9]+$/.test(cnt) || cnt <= 0) {
		alert('수량을 다시 입력해주세요.');
		return false;
	}

	if (confirm('장미꽃 한송이에 콩나물 10개가 차감됩니다.\n선물하시겠습니까?')) {
		$.ajax({
			url: '<?=$ft['path']?>/ajax/paid.php',
			type: 'POST',
			dataType: 'html',
			data: 'type=present&artist_uid_fk='+artist_uid_fk+'&cnt='+cnt,
			success: function(result) {
				result = result.split('|');
				$('#div_bg').fadeOut(1000);
				$('#present').fadeOut(1000);
				if (result['0']=='success') {
					alert('선물 완료.');
					$('#bean_cnt', opener.document).html(result['1']);
				} else if (result['0']=='shortage') {
					alert('선물 실패.\n콩나물이 부족합니다.');
				}
			}
		});
	}
}

$(document).ready(function(){
	$('#present').css('left', ($(window).width()-208)/2);
	$('#present').css('top', ($(window).height()-100)/2);
});
</script>
