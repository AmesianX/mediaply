<?
$path = '.';

require($path.'/_common.php');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>MEDIAPLY</title>
<link rel="stylesheet" type="text/css" href="<?=$ft['path']?>/css/common.css" />
<link rel="stylesheet" type="text/css" href="<?=$ft['path']?>/css/basic.css" />
<link rel="stylesheet" type="text/css" href="<?=$ft['path']?>/player/skin/blue.monday/jplayer.blue.monday.css" />
<!--<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>-->
<script type="text/javascript" src="<?=$ft['path']?>/js/jquery.min.js"></script>
<script type="text/javascript" src="<?=$ft['path']?>/js/ajaxfileupload.js"></script>
<script type="text/javascript" src="<?=$ft['path']?>/js/jcarousellite_1.0.1.min.js"></script>
<script type="text/javascript" src="<?=$ft['path']?>/js/basic.js"></script>
<script type="text/javascript" src="<?=$ft['path']?>/player/js/jquery.jplayer.min.js"></script>
<script type="text/javascript" src="<?=$ft['path']?>/player/js/jplayer.playlist.min.js"></script>

<script type="text/javascript">
var path = '<?=$ft['path']?>';
var username = '<?=$user['username']?>';

var left_content;
var right_content;
var right_artist;
var right_comment;

var player_visible = 0;
var playlist_visible = 0;
var playlist_cnt = 0;
var player;
var now_playing;
</script>

<script type="text/javascript">
$(document).ready(function(){
	$('#playlist').hide();
	$('#playlist_toggle').attr('src', '<?=$ft['img_path']?>/btn_playlist_show.png');

	player = new jPlayerPlaylist({
		jPlayer: '#jquery_jplayer_1',
		cssSelectorAncestor: '#jp_container_1'
	},[],{
		playlistOptions: {
			enableRemoveControls: true
		},
		swfPath: '<?=$ft['path']?>/player/js',
		solution: 'html, flash',
		supplied: 'mp3, oga',
		wmode: 'window'
	});

	$('.jp-playlist-item-remove').live('click', function(){
		if (playlist_visible && playlist_cnt <= 1) {
			$('#playlist_toggle').click();
		}

		$('#ft_title').html('TITLE');
		$('#ft_artist').html('ARTIST');
		$('#ft_poster').html('<img src="<?=$ft['img_path']?>/player/empty_track.png" alt="no image" />');
		$('#ft_lyric').html('<img src="<?=$ft['img_path']?>/player/btn_lyric_off.png" alt="no lyric" />');

		playlist_cnt--;
	});

	$('#jquery_jplayer_1').bind($.jPlayer.event.play, function(event) {
		$('#ft_title').html(event.jPlayer.status.media.title);
		$('#ft_artist').html(event.jPlayer.status.media.artist);
		$('#ft_artist').html('<span class="btn" onclick="window.open(\'<?=$ft['wall_path']?>/'+$('#ft_artist input').val()+'\', \'wall\', \'\');">'+event.jPlayer.status.media.artist+'</span>');
		$('#ft_poster').html(event.jPlayer.status.media.poster);
		now_playing = $('#ft_title input').val();
	});

	$('#jquery_jplayer_1').bind($.jPlayer.event.ended, function(event) {
		$.ajax({
			url: path+'/ajax/chart_data.php',
			type: 'POST',
			dataType: 'html',
			data: 'tid='+now_playing+'&target=streaming_cnt'
		});
	});

	$('#player_toggle').click(function(){
		if (player_visible) {
			$('#jp_container_1').animate({left:-300}, 'slow');
			player_visible = 0;
			$(this).attr('src', '<?=$ft['img_path']?>/btn_player_show.png');
		} else {
			$('#jp_container_1').animate({left:0}, 'slow');
			player_visible = 1;
			$(this).attr('src', '<?=$ft['img_path']?>/btn_player_hide.png');
		}
	});

	$('#playlist_toggle').click(function(){
		if (playlist_cnt > 0) {
			if (playlist_visible) {
				$('#playlist').slideUp('slow');
				playlist_visible = 0;
				$(this).attr('src', '<?=$ft['img_path']?>/btn_playlist_show.png');
			} else {
				$('#playlist').slideDown('slow');
				playlist_visible = 1;
				$(this).attr('src', '<?=$ft['img_path']?>/btn_playlist_hide.png');
			}
		} else {
			alert('리스트가 비어있습니다.');
		}
	});

	//add_radio_streaming(1);
});
</script>
</head>
<body onload="javascript:add_radio_streaming(1)">

<div id="loading"><img src="<?=$ft['path']?>/image/loading.gif" alt="loading" /></div>

<div id="jquery_jplayer_1" class="jp-jplayer"></div>
<div id="jp_container_1" class="jp-audio">
	<div class="player_view"><img id="player_toggle" class="btn" src="<?=$ft['img_path']?>/btn_player_show.png" alt="player toggle" /></div>
	<div class="jp-type-playlist">
		<div class="jp-gui jp-interface">
			<div class="ft_info">
				<div id="ft_lyric"><img src="<?=$ft['img_path']?>/player/btn_lyric_off.png" alt="no lyric" /></div>
				<div id="ft_poster"><img src="<?=$ft['img_path']?>/player/empty_track.png" alt="no image" /></div>
				<div class="ft_txt_info">
					<div id="ft_title">TITLE</div>
					<img class="ft_artist_icon" src="<?=$ft['img_path']?>/player/icon_artist.png" alt="artist icon" />
					<div id="ft_artist">ARTIST</div>
				</div>
			</div>
			<ul class="jp-toggles">
				<li><a href="javascript:;" class="jp-shuffle" tabindex="1" title="shuffle">shuffle</a></li>
				<li><a href="javascript:;" class="jp-shuffle-off" tabindex="1" title="shuffle off">shuffle off</a></li>
				<li><a href="javascript:;" class="jp-repeat" tabindex="1" title="repeat">repeat</a></li>
				<li><a href="javascript:;" class="jp-repeat-off" tabindex="1" title="repeat off">repeat off</a></li>
			</ul>
			<ul class="jp-controls">
				<li><a href="javascript:;" class="jp-previous" tabindex="1">previous</a></li>
				<li><a href="javascript:;" class="jp-play" tabindex="1">play</a></li>
				<li><a href="javascript:;" class="jp-pause" tabindex="1">pause</a></li>
				<li><a href="javascript:;" class="jp-next" tabindex="1">next</a></li>
			</ul>
			<div class="jp-volume-bar">
				<div class="jp-volume-bar-value"></div>
			</div>
			<div class="jp-progress">
				<div class="jp-seek-bar">
					<div class="jp-play-bar"></div>
				</div>
			</div>
			<div class="jp-current-time"></div>
			<div class="jp-duration"></div>
		</div>
		<div class="jp-no-solution">
			<span>Update Required</span>
			To play the media you will need to either update your browser to a recent version or update your <a href="http://get.adobe.com/flashplayer/" target="_blank">Flash plugin</a>.
		</div>
	</div>
	<div class="playlist" id="playlist">
	<div class="jp-playlist">
		<ul>
			<li></li>
		</ul>
	</div>
	</div>
	<div class="playlist_view"><img id="playlist_toggle" class="btn" src="<?=$ft['img_path']?>/btn_playlist_hide.png" alt="playlist toggle" /></div>
</div>

<div id="div_bg"></div>
<div class="relative">
	<div id="track_buy">
		<input type="hidden" name="tid" id="track_buy_tid" value="" />
		<table border="0" cellpadding="0" cellspacing="0" summary="트랙 구매 테이블" class="view_table">
			<caption>트랙 구매 테이블</caption>
			<colgroup>
				<col width="" />
				<col width="130" />
				<col width="130" />
			</colgroup>
			<tbody>
				<tr>
					<th colspan="3" class="title">트랙 구매<span class="btn fright" onclick="$('#track_buy').fadeOut();$('#div_bg').fadeOut();"><img src="<?=$ft['img_path']?>/btn_close.jpg" alt="close button" /></span></th>
				</tr>
				<tr>
					<td><div class="album_pic"><img id="track_buy_album_pic" src="" alt="album_pic" /></div></td>
					<td><span id="track_buy_trackname"></span><br /><span id="track_buy_artistname"></span></td>
					<td><img src="<?=$ft['img_path']?>/icon_bean.jpg" alt="bean icon" />&nbsp;x<span id="track_buy_price"></span></td>
				</tr>
				<tr>
					<th colspan="3"><div class="align_center mt10"><span class="txt_btn" onclick="track_buy();">구매</span></div></th>
				</tr>
			</tbody>
		</table>
	</div>
</div>
<div class="relative">
	<div id="terms">
		<div class="title">이용약관<span class="btn fright" onclick="$('#terms').fadeOut();$('#div_bg').fadeOut();"><img src="<?=$ft['img_path']?>/btn_close.jpg" alt="close button" /></span></div>
		<div class="content"><?=nl2br($config['terms'])?></div>
	</div>
</div>

<div class="relative">
        <div id="music_indr">
                <div class="title">음악소개<span class="btn fright" onclick="$('#music_indr').fadeOut();$('#div_bg').fadeOut();"><img src="<?=$ft['img_path']?>/btn_close.jpg" alt="close button" /></span></div>
                <div class="content"><?=nl2br($config['music_indr'])?></div>
        </div>
</div>

<? if ($is_user) { ?>
<div id="a_top_container">
	<div class="content">
		<div class="fleft"><span class="btn" onclick="ajax_page_load('left_content', 'index');ajax_page_load('right_content', 'right');"><img id="logo_small" src="<?=$ft['img_path']?>/logo_small.png" alt="logo" /></span></div>
		<div class="fright pt6">
			<? if ($user['type']=='admin') { ?><span class="font_FF0000 btn" onclick="window.open('<?=$ft['adm_path']?>/', 'admin', '');">관리자페이지</span><? } ?>
			<span class="font_58B9CB btn" onclick="window.open('<?=$ft['wall_path']?>/', 'wall', '');"><?=$user['nickname']?></span>&nbsp;<?=$user['type_kr']?>님 환영합니다!
			<span class="ml40">남은 콩나물 <span id="bean_cnt" class="font_FF0000"><?=$user['bean_cnt']?></span>개</span>
			(<span class="btn" onclick="ajax_page_load('left_content', 'payment');">구매</span>
			<span class="btn" onclick="ajax_page_load('left_content', 'payment_record');">구매내역</span>
			<span class="btn" onclick="ajax_page_load('left_content', 'paid');">사용내역</span>)
			<span class="ml20 btn" onclick="ajax_page_load('left_content', 'user_playlist');">플레이리스트</span>
			<span class="ml20 btn" onclick="ajax_page_load('left_content', 'user_modify');">계정설정</span>
			<span class="ml20 btn" onclick="document.logout_form.submit();">로그아웃</span>
			<? if ($user['type']=='listener') { ?><span class="ml20 btn font_9CF157" onclick="ajax_page_load('left_content', 'user_artist_reg');">아티스트등록신청</span><? } ?>
		</div>
	</div>
</div>
<form name="logout_form" method="post" action=""><input type="hidden" name="logout" value="1" /></form>
<? } else { ?>
<div id="b_top_container">
	<div class="content">
		<div class="fleft"><span class="btn" onclick="ajax_page_load('left_content', 'index');ajax_page_load('right_content', 'right');"><img id="logo" src="<?=$ft['img_path']?>/logo.png" alt="logo" /></span></div>
		<div class="fright">
			<form name="login_form" method="post" action="">
			<input type="hidden" name="login" value="1" />
			<table border="0" cellpadding="0" cellspacing="0" summary="로그인 테이블" id="login_table">
				<caption>로그인 테이블</caption>
				<thead>
				<tr>
					<th>아이디</th>
					<th>비밀번호</th>
					<th></th>
				</tr>
				</thead>
				<tbody>
				<tr>
					<td><input type="text" name="user" /></td>
					<td><input type="password" name="passcode" /></td>
					<td rowspan="2" class="valign_top">
						<input type="image" src="<?=$ft['img_path']?>/btn_login.png" alt="login button" />
						<span class="btn ml10" onclick="ajax_page_load('left_content', 'user_join');"><img src="<?=$ft['img_path']?>/btn_join.png" alt="join button" /></span>
					</td>
				</tr>
				<tr>
					<td><label><input type="checkbox" name="auto_login" />로그인상태유지</label></td>
					<td>로그인정보를잊으셨나요?</td>
				</tr>
				</tbody>
			</table>
			</form>
		</div>
	</div>
</div>
<? } ?>

<div id="menu_container">
	<div class="content">
		<div class="fleft">
			<div id="search" class="fleft">
				<input id="search_txt" name="search_txt" type="text" onkeyup="if (event.keyCode == 13) ajax_page_load('left_content', 'search', '&search_txt='+$('#search_txt').val());" />
				<span class="btn" onclick="ajax_page_load('left_content', 'search', '&search_txt='+$('#search_txt').val())"><img src="<?=$ft['img_path']?>/btn_search.png" alt="search button" /></span>
			</div>
		</div>
		<div class="fright">
			<div id="menu">
				<ul>
					<li><span class="btn" onclick="ajax_page_load('left_content', 'track');"><img class="title" src="<?=$ft['img_path']?>/btn_track.png" alt="track list" /></span></li>
					<li><img src="<?=$ft['img_path']?>/line_menu.png" alt="line" /></li>
					<li><span class="btn" onclick="ajax_page_load('left_content', 'album');"><img class="title" src="<?=$ft['img_path']?>/btn_album.png" alt="album list" /></span></li>
					<li><img src="<?=$ft['img_path']?>/line_menu.png" alt="line" /></li>
					<li><span class="btn" onclick="ajax_page_load('left_content', 'artist');"><img class="title" src="<?=$ft['img_path']?>/btn_artist.png" alt="artist list" /></span></li>
					<li><img src="<?=$ft['img_path']?>/line_menu.png" alt="line" /></li>
					<li><span class="btn" onclick="ajax_page_load('left_content', 'chart');"><img class="title" src="<?=$ft['img_path']?>/btn_chart.png" alt="chart" /></span></li>
					<li><img src="<?=$ft['img_path']?>/line_menu.png" alt="line" /></li>
					<li><span class="btn" onclick="ajax_page_load('left_content', 'recommend');"><img class="title" src="<?=$ft['img_path']?>/btn_recommend.png" alt="recommend list" /></span></li>
				</ul>
			</div>
		</div>
	</div>
</div>

<div id="content">
	<table border="0" cellpadding="0" cellspacing="0" summary="컨텐츠 테이블" id="contant_table">
		<caption>컨텐츠 테이블</caption>
		<tr>
			<td id="left_td"><div id="left_content">left</div></td>
			<td id="right_td"><div id="right_content">right</div></td>
		</tr>
	</table>
</div>

<div class="clear content">
	<div class="fleft"><span class="btn" onclick="ajax_page_load('left_content', 'index');"><img id="copy_logo" src="<?=$ft['img_path']?>/copy_logo.png" alt="logo" /></span></div>
	<div class="fright"><img src="<?=$ft['img_path']?>/copy.png" alt="copyright" usemap="#map" /></div>
</div>

<iframe id="hidden_iframe" src="" class="hide"></iframe>

<map name="map" id="map">
	<area shape="rect" coords="3,35,46,47" href="javascript:ajax_page_load('left_content', 'music_indr');" /><!-- 회사소개 -->
	<area shape="rect" coords="62,35,106,47" href="javascript:ajax_page_load('left_content', 'terms');" /><!-- 이용약관 -->
	<area shape="rect" coords="123,35,206,47" href="javascript:ajax_page_load('left_content', 'privacy');" /><!-- 개인정보취급방침 -->
	<area shape="rect" coords="223,35,311,47" href="#" /><!-- 제휴/프로모션문의 -->
</map>

<script type="text/javascript">
ajax_page_load('left_content', 'index');
ajax_page_load('right_content', 'right');
</script>

<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-36595923-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>

</body>
</html>
