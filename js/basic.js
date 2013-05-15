
function view_terms() {
	$('#terms').css({'left' : ($(window).width()-808)/2, 'top' : ($(window).height()-600)/2});
	$('#div_bg').fadeTo(1000, 0.5);
	$('#terms').fadeTo(1000, 1);
}

function users_recommend(uid, act) {
	$.ajax({
		url: path+'/ajax/recommend_users.php',
		type: 'POST',
		dataType: 'html',
		data: 'uid='+uid+'&act='+act,
		success: function(result) {
			if (act=='ins' && result=='success') {
				$('#users_recommend_btn').html('<span class="txt_btn" onclick="users_recommend('+uid+', \'del\');">추천 취소</span>');
				alert('추천 완료.');
			} else if (act=='del' && result=='success') {
				$('#users_recommend_btn').html('<span class="txt_btn" onclick="users_recommend('+uid+', \'ins\');">추천</span>');
				alert('추천 취소 완료.');
			} else {
				alert('err');
			}
		}
	});
}

function album_recommend(aid, act) {
	$.ajax({
		url: path+'/ajax/recommend_album.php',
		type: 'POST',
		dataType: 'html',
		data: 'aid='+aid+'&act='+act,
		success: function(result) {
			if (act=='ins' && result=='success') {
				$('#album_recommend_btn').html('<span class="txt_btn" onclick="album_recommend('+aid+', \'del\');">추천 취소</span>');
				alert('추천 완료.');
			} else if (act=='del' && result=='success') {
				$('#album_recommend_btn').html('<span class="txt_btn" onclick="album_recommend('+aid+', \'ins\');">추천</span>');
				alert('추천 취소 완료.');
			} else {
				alert('err');
			}
		}
	});
}

function track_buy_view(tid) {
	$.ajax({
		url: path+'/ajax/track_info.php',
		type: 'POST',
		dataType: 'html',
		data: 'tid='+tid,
		beforeSend: function () {
			$('#loading').show();
		},
		success: function(data) {
			var info = data.split('|');

			$('#track_buy_tid').val(tid);
			$('#track_buy_album_pic').attr('src', path+'/upload/album_pic/'+info['0']);
			$('#track_buy_trackname').html('<img src="'+path+'/image/icon_album_title.jpg" alt="album title icon" />&nbsp;'+info['1']);
			$('#track_buy_artistname').html('<span class="btn ml2" onclick="window.open(\''+path+'/wall/'+info['2']+'\', \'wall\', \'\');"><img src="'+path+'/image/icon_artist.jpg" alt="artist icon" />&nbsp;<span class="ml2">'+info['3']+'</span></span>');
			$('#track_buy_price').html(info['4']);

			$('#track_buy').css({'left' : ($(window).width()-408)/2, 'top' : ($(window).height()-200)/2});

			$('#loading').fadeOut(1000);
			$('#div_bg').fadeTo(1000, 0.5);
			$('#track_buy').fadeTo(1000, 1);
		}
	});
}

function track_buy() {
	$.ajax({
		url: path+'/ajax/paid.php',
		type: 'POST',
		dataType: 'html',
		data: 'type=track&tid='+$('#track_buy_tid').val(),
		beforeSend: function () {
			$('#loading').show();
		},
		success: function(result) {
			result = result.split('|');
			if (result['0']=='overlap') alert('이미 구매한 트랙입니다.');
			else if (result['0']=='success') {
				$.ajax({
					url: path+'/ajax/chart_data.php',
					type: 'POST',
					dataType: 'html',
					data: 'tid='+$('#track_buy_tid').val()+'&target=buy_cnt'
				});
				$('#bean_cnt').html(result['1']);
				alert('구매 완료.');
			} else if (result['0']=='shortage') {
				if (confirm('콩나물이 부족합니다.\n충전하시겠습니까?')) {
					ajax_page_load('left_content', 'payment');
					return false;
				}
			}

			$('#loading').fadeOut(1000);
			$('#div_bg').fadeOut(1000);
			$('#track_buy').fadeOut(1000);
		}
	});
}

function track_recommend(tid, act) {
	if (act=='ins') {
		$.ajax({
			url: path+'/ajax/chart_data.php',
			type: 'POST',
			dataType: 'html',
			data: 'tid='+tid+'&target=recommend_cnt',
			success: function(result) {
				$('#recommend_'+tid).html('<span class="btn" onclick="track_recommend('+tid+', \'del\');"><img src="'+path+'/image/icon_recommend_on.jpg" alt="recommend track" /></span>');
				alert(result+' 트랙을 추천하셨습니다.');
			}
		});
	} else if (act=='del') {
		$.ajax({
			url: path+'/ajax/del_recommend.php',
			type: 'POST',
			dataType: 'html',
			data: 'tid='+tid,
			success: function(result) {
				$('#recommend_'+tid).html('<span class="btn" onclick="track_recommend('+tid+', \'ins\');"><img src="'+path+'/image/icon_recommend_off.jpg" alt="recommend track" /></span>');
				alert(result+' 트랙에 대한 추천을 취소하셨습니다.');
			}
		});
	}
}

function lyric_view(tid) {
	var lyric_view = window.open(path+'/lyric_view.php?tid='+tid, 'lyric_view', 'width=450, height=600, left='+(screen.availWidth/2-225)+', top='+(screen.availHeight/2-300));
	lyric_view.focus();
}

function track_download(tid) {
	$('#hidden_iframe').attr('src', path+'/download.php?tid='+tid);
	$.ajax({
		url: path+'/ajax/chart_data.php',
		type: 'POST',
		dataType: 'html',
		data: 'tid='+tid+'&target=download_cnt'
	});
}

//2012.10.29 h0n9t3n 임시추가
function add_radio_streaming(sid){
        $.ajax({
                url: path+'/ajax/add_radio_streaming.php',
                type: 'POST',
                dataType: 'html',
                data: 'sid='+sid,
                beforeSend: function () {
                        $('#loading').show();
                },
                success: function(data) {
                        var info = data.split('|');
			//var img = info['4'].replace('[','<');
                        $('#loading').fadeOut(1000);
                        player.add({
                                title: '<marquee width=140 scrollamount=3>'+info['5']+'</marquee>',
                                artist: info['3'] + '/' + info['2'],
                                poster: info['4'],
                                mp3: info['0'] + ';stream/1'
                        });
                        player.play(-1);
                        playlist_cnt++;

                        $("#jp_container_1").animate({left:0}, 'slow');
                        player_visible = 1;
                        $("#player_toggle").attr('src', path+'/image/btn_player_hide.png');

                        if (!playlist_visible) $("#playlist_toggle").click();
                }
        });
}

function add_streaming(aid, tid) {
	$.ajax({
		url: path+'/ajax/add_streaming.php',
		type: 'POST',
		dataType: 'html',
		data: 'aid='+aid+'&tid='+tid+'&target=streaming_cnt',
		beforeSend: function () {
			$('#loading').show();
		},
		success: function(data) {
			var info = data.split('|');
			$('#loading').fadeOut(1000);

			if (info['0'].length>10) var trackname = info['0'].substring(0, 10) + '..';
			else var trackname = info['0'];

			player.add({
				title: trackname+'<input type="hidden" name="now_playing_'+tid+'" value="'+tid+'" />',
				artist: '<input type="hidden" name="now_username_'+tid+'" value="'+info['1']+'" />'+info['2'],
				poster: '<span class="btn" onclick="ajax_page_load(\'left_content\', \'album_detail\', \'&aid='+aid+'\');"><img src="'+path+'/upload/album_pic/'+info['3']+'" alt="'+info['0']+'" /></span>',
			        //mp3: 'http://music.mediaply.co.kr/play_streaming.php?tid=' +tid,
				mp3: info['4']
			});
			if (info['5']) $('#ft_lyric').html('<img src="'+path+'/image/player/btn_lyric_on.png" alt="no lyric" onclick="lyric_view('+tid+');" />');
			else $('#ft_lyric').html('<img src="'+path+'/image/player/btn_lyric_off.png" alt="no lyric" />');
                        //player("stop");
			//player.play(-1);
			playlist_cnt++;

			$("#jp_container_1").animate({left:0}, 'slow');
			player_visible = 1;
			$("#player_toggle").attr('src', path+'/image/btn_player_hide.png');

			if (!playlist_visible) $("#playlist_toggle").click();
		}
	});
}

function add_parent_streaming(aid, tid) {
	$.ajax({
		url: path+'/ajax/add_streaming.php',
		type: 'POST',
		dataType: 'html',
		data: 'aid='+aid+'&tid='+tid+'&target=streaming_cnt',
		beforeSend: function () {
			$('#loading', opener.document).show();
		},
		success: function(data) {
			var info = data.split('|');
			$('#loading', opener.document).fadeOut(1000);

			if (info['0'].length>10) var trackname = info['0'].substring(0, 10) + '..';
			else var trackname = info['0'];

			opener.player.add({
				title: trackname+'<input type="hidden" name="now_playing_'+tid+'" value="'+tid+'" />',
				artist: '<input type="hidden" name="now_username_'+tid+'" value="'+info['1']+'" />'+info['2'],
				poster: '<span class="btn" onclick="ajax_page_load(\'left_content\', \'album_detail\', \'&aid='+aid+'\');"><img src="'+path+'/upload/album_pic/'+info['3']+'" alt="'+info['0']+'" /></span>',
                                //mp3: 'http://music.mediaply.co.kr/play_streaming.php?tid=' +tid
				mp3: info['4']
			});
			if (info['5']) $('#ft_lyric', opener.document).html('<img src="'+path+'/image/player/btn_lyric_on.png" alt="no lyric" onclick="lyric_view('+tid+');" />');
			else $('#ft_lyric', opener.document).html('<img src="'+path+'/image/player/btn_lyric_off.png" alt="no lyric" />');
			//opener.player.play(-1);
			opener.playlist_cnt++;

			$("#jp_container_1", opener.document).animate({left:0}, 'slow');
			opener.player_visible = 1;
			$("#player_toggle", opener.document).attr('src', path+'/image/btn_player_hide.png');

			if (!opener.playlist_visible) $("#playlist_toggle", opener.document).click();
		}
	});
}

function selected_add_streaming() {
	var cnt = 0;
	var aid = new Array();
	var tid = new Array();

	for (i=0; i<$('.tid').length; i++) {
		if ($('.tid').eq(i).attr('checked')) {
			aid[cnt] = $('.aid').eq(i).val();
			tid[cnt] = $('.tid').eq(i).val();
			cnt++;
		}
	}

	if (!cnt) {
		alert('선택된 트랙이 없습니다.');
		return false;
	}

	$.ajax({
		url: path+'/ajax/add_streaming_multi.php',
		type: 'POST',
		dataType: 'html',
		data: 'aid='+aid+'&tid='+tid+'&cnt='+cnt+'&target=streaming_cnt',
		beforeSend: function () {
			$('#loading').show();
		},
		success: function(data) {
			var tmp = data.split('#');
			$('#loading').fadeOut(1000);

			for (i=0; i<tmp.length; i++) {
				var info = tmp[i].split('|');

				if (info['0'].length>10) var trackname = info['0'].substring(0, 10) + '..';
				else var trackname = info['0'];

				player.add({
					title: trackname+'<input type="hidden" name="now_playing_'+tid[i]+'" value="'+tid[i]+'" />',
					artist: '<input type="hidden" name="now_username_'+tid[i]+'" value="'+info['1']+'" />'+info['2'],
					poster: '<span class="btn" onclick="ajax_page_load(\'left_content\', \'album_detail\', \'&aid='+aid+'\');"><img src="'+path+'/upload/album_pic/'+info['3']+'" alt="'+info['0']+'" /></span>',
					mp3: info['4']
                                         //mp3: 'http://music.mediaply.co.kr/play_streaming.php?tid=' +tid
				});
			}

			if (info['5']) $('#ft_lyric').html('<img src="'+path+'/image/player/btn_lyric_on.png" alt="no lyric" onclick="lyric_view('+tid[tmp.length-1]+');" />');
			else $('#ft_lyric').html('<img src="'+path+'/image/player/btn_lyric_off.png" alt="no lyric" />');
			//player.play(-1);
			playlist_cnt++;

			$("#jp_container_1").animate({left:0}, 'slow');
			player_visible = 1;
			$("#player_toggle").attr('src', path+'/image/btn_player_hide.png');

			if (!playlist_visible) $("#playlist_toggle").click();
		}
	});
}

function all_add_streaming() {
	var cnt = 0;
	var aid = new Array();
	var tid = new Array();

	for (i=0; i<$('.tid').length; i++) {
		aid[cnt] = $('.aid').eq(i).val();
		tid[cnt] = $('.tid').eq(i).val();
		cnt++;
	}

	if (!cnt) {
		alert('선택된 트랙이 없습니다.');
		return false;
	}

	$.ajax({
		url: path+'/ajax/add_streaming_multi.php',
		type: 'POST',
		dataType: 'html',
		data: 'aid='+aid+'&tid='+tid+'&cnt='+cnt+'&target=streaming_cnt',
		beforeSend: function () {
			$('#loading').show();
		},
		success: function(data) {
			var tmp = data.split('#');
			$('#loading').fadeOut(1000);

			for (i=0; i<tmp.length; i++) {
				var info = tmp[i].split('|');

				if (info['0'].length>10) var trackname = info['0'].substring(0, 10) + '..';
				else var trackname = info['0'];

				player.add({
					title: trackname+'<input type="hidden" name="now_playing_'+tid[i]+'" value="'+tid[i]+'" />',
					artist: '<input type="hidden" name="now_username_'+tid[i]+'" value="'+info['1']+'" />'+info['2'],
					poster: '<span class="btn" onclick="ajax_page_load(\'left_content\', \'album_detail\', \'&aid='+aid+'\');"><img src="'+path+'/upload/album_pic/'+info['3']+'" alt="'+info['0']+'" /></span>',
					mp3: info['4']
                                        //  mp3: 'http://music.mediaply.co.kr/play_streaming.php?tid=' +tid
				});
			}

			if (info['5']) $('#ft_lyric').html('<img src="'+path+'/image/player/btn_lyric_on.png" alt="no lyric" onclick="lyric_view('+tid[tmp.length-1]+');" />');
			else $('#ft_lyric').html('<img src="'+path+'/image/player/btn_lyric_off.png" alt="no lyric" />');
			//player.play(-1);
			playlist_cnt++;

			$("#jp_container_1").animate({left:0}, 'slow');
			player_visible = 1;
			$("#player_toggle").attr('src', path+'/image/btn_player_hide.png');

			if (!playlist_visible) $("#playlist_toggle").click();
		}
	});
}

function add_playlist(tid) {
	$.ajax({
		url: path+'/ajax/chart_data.php',
		type: 'POST',
		dataType: 'html',
		data: 'tid='+tid+'&target=playlist_cnt',
		success: function(result) {
			if (result=='success') {
				alert('플레이리스트 추가 완료.');
				$('#playlist_'+tid).html('<img src="'+path+'/image/icon_add_playlist_off.jpg" alt="add playlist" />');
			} else if (result=='overlap') alert('이미 플레이리스트에 추가된 곡입니다.');
			else alert('err');
		}
	});
}

function del_playlist(tid) {
	$.ajax({
		url: path+'/ajax/del_playlist.php',
		type: 'POST',
		dataType: 'html',
		data: 'tid='+tid,
		success: function(data) {
			if (data=='success') {
				alert('플레이리스트 제거 완료.');
				ajax_page_load('left_content', left_content);
			}
		}
	});
}

function ajax_paging(p_num, total_page, target_id, page, p_scale) {
	if (!p_scale) p_scale = 10;

	var str = '';

	if (p_num > 1) str += '&nbsp;<span class="btn" onclick="ajax_page_load(\''+target_id+'\', \''+page+'\', \'&p_num=1\');">처음</span>&nbsp;';

	var start_page = ((parseInt((p_num - 1) / p_scale)) * p_scale) + 1;
	var end_page = start_page + p_scale - 1;

	if (end_page >= total_page) end_page = total_page;

	if (start_page > 1) str += '&nbsp;<span class="btn" onclick="ajax_page_load(\''+target_id+'\', \''+page+'\', \'&p_num='+(start_page-1)+'\');">이전</span>&nbsp;';

	if (total_page > 1) {
		for (i=start_page; i<=end_page; i++) {
			if (p_num != i) str += '&nbsp;<span class="btn" onclick="ajax_page_load(\''+target_id+'\', \''+page+'\', \'&p_num='+i+'\');">'+i+'</span>&nbsp;';
			else str += '&nbsp;<b>'+i+'</b>&nbsp;';
		}
	}

	if (total_page > end_page) str += '&nbsp;<span class="btn" onclick="ajax_page_load(\''+target_id+'\', \''+page+'\', \'&p_num='+(end_page+1)+'\');">다음</span>&nbsp;';

	if (p_num < total_page) str += '&nbsp;<span class="btn" onclick="ajax_page_load(\''+target_id+'\', \''+page+'\', \'&p_num='+total_page+'\');">맨끝</span>&nbsp;';

	return str;
}

function ajax_page_load(target_id, page, val) {
	if (!val) val = '';

	$.ajax({
		url: path+'/page/'+page+'.php',
		type: 'POST',
		dataType: 'html',
		data: 'target_id='+target_id+'&page='+page+val,
		beforeSend: function () {
			$('#loading').show();
			$('#'+target_id).hide();
			$('#'+target_id).empty();
		},
		success: function(data) {
			eval(target_id+'="'+page+val+'";');

			$('#loading').fadeOut(1000);
			$('#'+target_id).html(data);
			$('#'+target_id).fadeIn(1000);
			if (page=='index') {
				$(function(){
					$('#jcarouselWidget1 .jcarouselList').jCarouselLite({
						visible: 1,
						//auto: 5000,
						speed: 1000,
						btnPrev: '#jcarouselWidget1 .btnPrev',
						btnNext: '#jcarouselWidget1 .btnNext',
						circular: false
					});

					$('#jcarouselWidget2 .jcarouselList').jCarouselLite({
						visible: 1,
						//auto: 5000,
						speed: 1000,
						btnPrev: '#jcarouselWidget2 .btnPrev',
						btnNext: '#jcarouselWidget2 .btnNext',
						circular: false
					});
				});
			}
		}
	});
}

function ajax_page_load_noloading(target_id, page, val) {
	if (!val) val = '';

	$.ajax({
		url: path+'/page/'+page+'.php',
		type: 'POST',
		dataType: 'html',
		data: 'target_id='+target_id+'&page='+page+val,
		success: function(data) {
			eval(target_id+'="'+page+val+'";');

			$('#'+target_id).html(data);
			if (page=='index') {
				$(function(){
					$('#jcarouselWidget1 .jcarouselList').jCarouselLite({
						visible: 1,
						auto: 5000,
						speed: 1000,
						btnPrev: '#jcarouselWidget1 .btnPrev',
						btnNext: '#jcarouselWidget1 .btnNext',
						circular: false
					});

					$('#jcarouselWidget2 .jcarouselList').jCarouselLite({
						visible: 1,
						auto: 5000,
						speed: 1000,
						btnPrev: '#jcarouselWidget2 .btnPrev',
						btnNext: '#jcarouselWidget2 .btnNext',
						circular: false
					});
				});
			}
		}
	});
}

function number_format(data){
	var prev_data = '';

	if (Number(data) < 0) {
		prev_data = '-';
		data = String(data).replace('-', '');
	}

	var num_str = String(data);
	var number = new Array;
	var number_format_str = '';
	var data_ary = new Array();

	data_ary = num_str.split('.');

	for (i=0; i<data_ary.length; i++) {
		if (!number[i]) number[i] = '';

		var str = String(data_ary[i]);
		var len = str.length;
		var mod = (len % 3);
		var tmp = 3 - mod;

		for (j=0; j<str.length; j++) {
			number[i] = number[i] + str.charAt(j);
			if (j < str.length - 1) {
				tmp++;
				if ((tmp % 3) == 0) {
					number[i] = number[i] + ',';
					tmp = 0;
				}
			}
		}

		if (i > 0) {
			number_format_str += '.' + number[i];
		} else {
			number_format_str += number[i];
		}
	}

	return prev_data+number_format_str;
}
