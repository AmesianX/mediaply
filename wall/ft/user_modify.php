<?
if (!$is_mypage) {
	alert('접근권한이 없습니다.');
	location_replace($ft['wall_path']);
}
?>

<script type="text/javascript">
var profile_pic_upload_result = 0;
var profile_pic_del_result = 0;
var profile_bg_upload_result = 0;
var profile_bg_del_result = 0;

var before_nickname = '<?=$user['nickname']?>';
var before_email = '<?=$user['email']?>';
<? if ($user['type']=='artist') { ?>var before_artistname = '<?=$user['artistname']?>';<? } ?>

$(document).ready(function(){
	$("#nickname").change(function(){
		var nickname = $("#nickname").val();
		var msgbox = $("#nstatus");

		if(nickname.length >= 2) {
			$('#info_submit').attr('disabled', true);

			$.ajax({
				type: "POST",
				url: "<?=$ft['ajax_path']?>/user_join.php",
				data: "type=nickname&value="+nickname,
				success: function(msg) {
					if(msg == 'ok') {
						if (/^[가-힣a-zA-Z0-9_-]{2,16}$/i.test(nickname)) {
							$("#nickname_chk").val('0');
							msgbox.html('사용가능');
						} else {
							$("#nickname_chk").val('1');
							msgbox.html('사용불가');
						}
					} else if (msg == 'impossible') {
						$("#nickname_chk").val('1');
						msgbox.html('사용불가');
					} else {
						$("#nickname_chk").val('1');
						msgbox.html('중복');
					}
				}
			});

			$('#info_submit').attr('disabled', false);
		} else {
			$("#nickname_chk").val('1');
			msgbox.html('사용불가');
		}
	});

	$("#email").change(function(){
		var email = $("#email").val();
		var msgbox = $("#estatus");

		if(email.length >= 5) {
			$('#info_submit').attr('disabled', true);

			$.ajax({
				type: "POST",
				url: "<?=$ft['ajax_path']?>/user_join.php",
				data: "type=email&value="+email,
				success: function(msg) {
					if(msg == 'ok') {
						if (/^[a-zA-Z0-9._-]+@[a-zA-Z0-9-]+\.[a-zA-Z.]{2,5}$/i.test(email)) {
							$("#email_chk").val('0');
							msgbox.html('사용가능');
						} else {
							$("#email_chk").val('1');
							msgbox.html('사용불가');
						}
					} else {
						$("#email_chk").val('2');
						msgbox.html('중복');
					}
				}
			});

			$('#info_submit').attr('disabled', false);
		} else {
			$("#email_chk").val('3');
			msgbox.html('사용불가');
		}
	});

	<? if ($user['type']=='artist') { ?>
	$("#artistname").change(function(){
		var artistname = $("#artistname").val();
		var msgbox = $("#astatus");

		if(artistname.length >= 2) {
			$('#artist_submit').attr('disabled', true);

			$.ajax({
				type: "POST",
				url: "<?=$ft['ajax_path']?>/user_join.php",
				data: "type=artistname&value="+artistname,
				success: function(msg) {
					if(msg == 'ok') {
						if (/^[가-힣a-zA-Z0-9_-]{2,16}$/i.test(artistname)) {
							$("#artistname_chk").val('0');
							msgbox.html('사용가능');
						} else {
							$("#artistname_chk").val('1');
							msgbox.html('사용불가');
						}
					} else if (msg == 'impossible') {
						$("#artistname_chk").val('1');
						msgbox.html('사용불가');
					} else {
						$("#artistname_chk").val('1');
						msgbox.html('중복');
					}
				}
			});

			$('#artist_submit').attr('disabled', false);
		} else {
			$("#artistname_chk").val('1');
			msgbox.html('사용불가');
		}
	});
	<? } ?>
});

function info_submit() {
	<? if ($user['type'] == 'artist') { ?>
	if (!$("#profile_pic").val() && '<?=$user['profile_pic']?>' == 'default.jpg') {
		alert('프로필 사진을 업데이트 해주세요.');
		return false;
	}

	if ($('#profile_pic_del').attr('checked')) {
		alert('아티스트 회원은 프로필 사진을 삭제할 수 없습니다.');
		return false;
	}
	<? } ?>

	$.ajax({
		type: "POST",
		url: "<?=$ft['ajax_path']?>/user_modify_info.php",
		data: $('#user_info_modify_form').serialize(),
		success: function(result) {
			if (result) {
				/*
				var tmp = result.split('|');
				var msg = '';

				switch (tmp[0]) {
					case '0' :
						msg += '닉네임 변경 완료.\n';
						break;
					case '1' :
						msg += '닉네임 형식 오류.\n';
						break;
					case '2' :
						msg += '닉네임 중복.\n';
						break;
					case '3' :
						msg += '닉네임 2자 미만.\n';
						break;
					default :
						break;
				}

				switch (tmp[1]) {
					case '0' :
						msg += '비밀번호 변경 완료.\n';
						break;
					case '1' :
						msg += '비밀번호 불일치.\n';
						break;
					case '2' :
						msg += '비밀번호 4자 미만.\n';
						break;
					default :
						break;
				}

				switch (tmp[2]) {
					case '0' :
						msg += '이메일 변경 완료.\n';
						break;
					case '1' :
						msg += '이메일 형식 오류.\n';
						break;
					case '2' :
						msg += '이메일 중복.\n';
						break;
					case '3' :
						msg += '이메일 5자 미만.\n';
						break;
					default :
						break;
				}

				switch (tmp[3]) {
					case '0' :
						msg += '배경 반복 여부 변경 완료.\n';
						break;
					default :
						break;
				}

				switch (tmp[4]) {
					case '0' :
						msg += '마이페이지 타이틀 변경 완료.\n';
						break;
					default :
						break;
				}

				if (msg) alert(msg);

				if (tmp[0] == '0') before_nickname = $('#nickname').val();
				else $('#nickname').val(before_nickname);

				if (tmp[1]) $('#user_info_modify_form input[type="password"]').attr('value', '');

				if (tmp[2] == '0') before_email = $('#email').val();
				else $('#email').val(before_email);
				*/

				alert('회원 정보 변경완료.');
			}

			if ($('#profile_pic').val()) profile_pic_upload();
			if ($('#profile_pic_del').attr('checked')) profile_pic_del();
			if ($('#profile_bg').val()) profile_bg_upload();
			if ($('#profile_bg_del').attr('checked')) profile_bg_del();

			setTimeout('page_refresh();', 3000);
		}
	});

	return false;
}

function page_refresh() {
	if (profile_pic_upload_result!=1 && profile_pic_del_result!=1 && profile_bg_upload_result!=1 && profile_bg_del_result!=1) location.reload();
}

function profile_pic_upload() {
	profile_pic_upload_result = 1;
	$.ajaxFileUpload({
		url:'<?=$ft['ajax_path']?>/user_profile_pic_upload.php',
		secureuri:false,
		fileElementId:'profile_pic',
		dataType: 'json',
		success: function(data, status) {
			if (typeof(data.error) != 'undefined') {
				if (data.error != '') {
					alert(data.error);
				} else {
					alert(data.msg);
					profile_pic_upload_result = 0;
				}
			}
		},
		error: function(data, status, e) {
			alert(e);
		}
	});

	return false;
}

function profile_pic_del() {
	profile_pic_del_result = 1;
	$.ajax({
		type: "POST",
		url: "<?=$ft['ajax_path']?>/user_file_del.php",
		data: "field_name=profile_pic&uid=<?=$user['uid']?>",
		success: function(msg) {
			if (msg) {
				alert(msg);
				profile_pic_del_result = 0;
			}
		}
	});
}

function profile_bg_upload() {
	profile_bg_upload_result = 1;
	$.ajaxFileUpload({
		url:'<?=$ft['ajax_path']?>/user_profile_bg_upload.php',
		secureuri:false,
		fileElementId:'profile_bg',
		dataType: 'json',
		success: function(data, status) {
			if (typeof(data.error) != 'undefined') {
				if (data.error != '') {
					alert(data.error);
				} else {
					alert(data.msg);
					profile_bg_upload_result = 0;
				}
			}
		},
		error: function(data, status, e) {
			alert(e);
		}
	});

	return false;
}

function profile_bg_del() {
	profile_bg_del_result = 1;
	$.ajax({
		type: "POST",
		url: "<?=$ft['ajax_path']?>/user_file_del.php",
		data: "field_name=profile_bg&uid=<?=$user['uid']?>",
		success: function(msg) {
			if (msg) {
				alert(msg);
				profile_bg_del_result = 0;
			}
		}
	});
}

<? if ($user['type']=='artist') { ?>
function artist_submit() {
	if ($("#artistname_chk").val() != 0) {
		$("#artistname_chk").val(null);
		$("#artistname").focus();
		alert('아티스트명을 다시 입력해주세요.');
		return false;
	}

	<? if ($user['type'] == 'artist' && $user['profile_pic'] == 'default.jpg') { ?>
	if (!$("#profile_pic").val()) {
		alert('프로필 사진을 업데이트 해주세요.');
		return false;
	}
	<? } ?>

	if (!$("#bank_name").val()) {
		$("#bank_name").val(null);
		$("#bank_name").focus();
		alert('은행명을 입력해주세요.');
		return false;
	}

	if (!$("#bank_account").val()) {
		$("#bank_account").val(null);
		$("#bank_account").focus();
		alert('계좌번호를 입력해주세요.');
		return false;
	}

	if (!$("#bank_holder").val()) {
		$("#bank_holder").val(null);
		$("#bank_holder").focus();
		alert('예금주를 입력해주세요.');
		return false;
	}

	$.ajax({
		type: "POST",
		url: "<?=$ft['ajax_path']?>/user_modify_artist.php",
		data: $('#user_artist_modify_form').serialize(),
		success: function(result) {
			if (result) {
				/*
				var tmp = result.split('|');
				var msg = '';

				switch (tmp[0]) {
					case '0' :
						msg += '아티스트명 변경 완료.\n';
						break;
					case '1' :
						msg += '아티스트명 형식 오류.\n';
						break;
					case '2' :
						msg += '아티스트명 중복.\n';
						break;
					case '3' :
						msg += '아티스트명 2자 미만.\n';
						break;
					default :
						break;
				}

				switch (tmp[1]) {
					case '0' :
						msg += '레이블 변경 완료.\n';
						break;
					default :
						break;
				}

				switch (tmp[2]) {
					case '0' :
						msg += '장르1 변경 완료.\n';
						break;
					default :
						break;
				}

				switch (tmp[3]) {
					case '0' :
						msg += '장르2 변경 완료.\n';
						break;
					default :
						break;
				}

				switch (tmp[4]) {
					case '0' :
						msg += '소개 변경 완료.\n';
						break;
					default :
						break;
				}

				switch (tmp[5]) {
					case '0' :
						msg += '은행명 변경 완료.\n';
						break;
					default :
						break;
				}

				switch (tmp[6]) {
					case '0' :
						msg += '계좌번호 변경 완료.\n';
						break;
					default :
						break;
				}

				switch (tmp[7]) {
					case '0' :
						msg += '예금주 변경 완료.\n';
						break;
					default :
						break;
				}

				if (msg) alert(msg);

				if (tmp[0] == '0') before_artistname = $('#artistname').val();
				else $('#artistname').val(before_artistname);
				*/

				alert('아티스트 정보 변경완료.');
				location.reload();
			}
		}
	});

	return false;
}
<? } ?>
</script>

<img class="title_img mb10 ml20" src="<?=$ft['img_path']?>/title_user_info_modify.jpg" alt="modify user info title" />

<span class="clear fleft mb10 ml20 font_666666">회원 정보의 수정이 가능합니다.</span>

<form name="user_info_modify_form" id="user_info_modify_form" method="post" action="" onsubmit="return info_submit();" enctype="multipart/form-data">
<input type="hidden" name="nickname_chk" id="nickname_chk" value="0" />
<input type="hidden" name="email_chk" id="email_chk" value="0" />
<table border="0" cellpadding="0" cellspacing="0" summary="회원 정보 수정 테이블" class="write_table mb10 ml20">
	<caption>회원 정보 수정 테이블</caption>
	<colgroup>
		<col width="100" />
		<col width="" />
	</colgroup>
	<tr>
		<th>닉네임</th>
		<td><input type="text" name="nickname" id="nickname" autocomplete="off" value="<?=$user['nickname']?>" class="fleft" /><div class="relative"><div id="nstatus" class="absolute"></div></div></td>
	</tr>
	<tr>
		<th>비밀번호</th>
		<td><input type="password" name="password" autocomplete="off" class="fleft" /><input type="password" name="password_re" autocomplete="off" class="fleft ml5" /></td>
	</tr>
	<tr>
		<th>이메일</th>
		<td><input type="text" name="email" id="email" autocomplete="off" value="<?=$user['email']?>" class="fleft" /><div class="relative"><div id="estatus" class="absolute"></div></div></td>
	</tr>
	<tr>
		<th>프로필 사진</th>
		<td>
			<input type="file" name="profile_pic" id="profile_pic" src="<?=$ft['img_path']?>/btn_file.jpg" class="fleft" />
			<? if ($user['profile_pic'] && $user['profile_pic']!='default.jpg') { ?>
				<img src="<?=$ft['path'].'/wall/profile_pic/'.$user['profile_pic']?>" alt="<?=$user['nickname']?>" class="profile_pic ml10" />
				<div class="fleft mt5 ml10"><label><input type="checkbox" name="profile_pic_del" id="profile_pic_del" value="Y" />&nbsp;삭제</label></div>
			<? } ?>
			<span class="clear fleft">사용 가능한 이미지는 JPG, GIF 입니다.</span>
		</td>
	</tr>
	<tr>
		<th>마이페이지<br />타이틀</th>
		<td><input type="text" name="mypage_title" id="mypage_title" autocomplete="off" value="<?=$user['mypage_title']?>" class="fleft" /></td>
	</tr>
	<tr>
		<th>마이페이지<br />배경</th>
		<td>
			<input type="file" name="profile_bg" id="profile_bg" src="<?=$ft['img_path']?>/btn_file.jpg" class="fleft" />
			<? if ($user['profile_bg']) { ?>
				<img src="<?=$ft['path'].'/upload/profile_bg/'.$user['profile_bg']?>" alt="<?=$user['nickname']?>" class="profile_bg ml10" />
				<div class="fleft mt5 ml10"><label><input type="checkbox" name="profile_bg_del" id="profile_bg_del" value="Y" />&nbsp;삭제</label></div>
			<? } ?>
			<span class="clear fleft">사용 가능한 이미지는 JPG, GIF 입니다.</span>
		</td>
	</tr>
	<tr>
		<th>배경 반복</th>
		<td>
			<label><input type="checkbox" name="bg_repeat" id="bg_repeat" value="Y" <?=$user['bg_repeat']=='Y'?'checked="checked"':''?> />&nbsp;반복</label>
		</td>
	</tr>
	<tr>
		<th>회원탈퇴</th>
		<td><span class="btn" onclick="alert('준비중입니다.');">탈퇴하기</span></td>
	</tr>
	<tr>
		<td colspan="2"><input type="image" src="<?=$ft['img_path']?>/btn_ok.jpg" id="info_submit" /></td>
	</tr>
</table>
</form>

<? if ($user['type']=='artist') { ?>
<img class="title_img mv10 ml20" src="<?=$ft['img_path']?>/title_user_artist_modify.jpg" alt="modify artist info title" />

<span class="clear fleft mb10 ml20 font_666666">아티스트 정보의 수정이 가능합니다.</span>

<form name="user_artist_modify_form" id="user_artist_modify_form" method="post" action="" onsubmit="return artist_submit();" enctype="multipart/form-data">
<input type="hidden" name="artistname_chk" id="artistname_chk" value="0" />
<table border="0" cellpadding="0" cellspacing="0" summary="아티스트 정보 수정 테이블" class="write_table mb10 ml20">
	<caption>아티스트 정보 수정 테이블</caption>
	<colgroup>
		<col width="100" />
		<col width="" />
	</colgroup>
	<tr>
		<th>아티스트명</th>
		<td><input type="text" name="artistname" id="artistname" autocomplete="off" value="<?=$user['artistname']?>" class="fleft" /><div class="relative"><div id="astatus" class="absolute"></div></div></td>
	</tr>
	<tr>
		<th>레이블</th>
		<td><input type="text" name="label" id="label" autocomplete="off" value="<?=$user['label']?>" class="fleft" /></td>
	</tr>
	<tr>
		<th>장르</th>
		<td>
			<select name="gid_fk1" class="fleft">
				<option value="">::선택::</option>
				<? $genre = mysql_query('SELECT * FROM `ft_genre` ORDER BY `genre` ASC'); ?>
				<? for ($i=0; $row=mysql_fetch_array($genre); $i++) { ?>
				<option value="<?=$row['gid']?>" <?=$row['gid']==$user['gid_fk1']?'selected="selected"':''?>><?=$row['genre']?></option>
				<? } ?>
			</select>
			<select name="gid_fk2" class="fleft">
				<option value="">::선택::</option>
				<? $genre = mysql_query('SELECT * FROM `ft_genre` ORDER BY `genre` ASC'); ?>
				<? for ($i=0; $row=mysql_fetch_array($genre); $i++) { ?>
				<option value="<?=$row['gid']?>" <?=$row['gid']==$user['gid_fk2']?'selected="selected"':''?>><?=$row['genre']?></option>
				<? } ?>
			</select>
		</td>
	</tr>
	<tr>
		<th>소개</th>
		<td><textarea name="introduce" class="fleft"><?=$user['introduce']?></textarea></td>
	</tr>
	<tr>
		<th>은행명</th>
		<td><input type="text" name="bank_name" id="bank_name" autocomplete="off" value="<?=$user['bank_name']?>" class="fleft" /></td>
	</tr>
	<tr>
		<th>계좌번호</th>
		<td><input type="text" name="bank_account" id="bank_account" autocomplete="off" value="<?=$user['bank_account']?>" class="fleft" /></td>
	</tr>
	<tr>
		<th>예금주</th>
		<td><input type="text" name="bank_holder" id="bank_holder" autocomplete="off" value="<?=$user['bank_holder']?>" class="fleft" /></td>
	</tr>
	<tr>
		<td colspan="2"><input type="image" src="<?=$ft['img_path']?>/btn_ok.jpg" id="artist_submit" /></td>
	</tr>
</table>
</form>
<? } ?>
