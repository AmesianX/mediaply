<?
$path = '..';

require($path.'/_common.php');
?>

<script type="text/javascript">
var username_chk = 0;
var nickname_chk = 0;
var password_chk = 0;
var password_re_chk = 0;
var email_chk = 0;

$(document).ready(function(){
	$("#username").change(function(){
		var username = $("#username").val();
		var msgbox = $("#ustatus");

		if(username.length >= 4) {
			msgbox.html('check');
			$('#join_submit').attr('disabled', true);

			$.ajax({
				type: "POST",
				url: "<?=$ft['ajax_path']?>/user_join.php",
				data: "type=username&value="+username,
				success: function(msg) {
					msgbox.ajaxComplete(function(event, request, settings){
						if(msg == 'ok') {
							if (/^[a-zA-Z0-9_-]{4,16}$/i.test(username)) {
								username_chk = 1;
								msgbox.html('사용가능');
							} else {
								username_chk = 0;
								msgbox.html('사용불가');
							}
						} else if (msg == 'impossible') {
							username_chk = 0;
							msgbox.html('사용불가');
						} else {
							username_chk = 0;
							msgbox.html('중복');
						}
					});
				}
			});

			$('#join_submit').attr('disabled', false);
		} else {
			username_chk = 0;
			msgbox.html('사용불가');
		}
	});

	$("#nickname").change(function(){
		var nickname = $("#nickname").val();
		var msgbox = $("#nstatus");

		if(nickname.length >= 2) {
			msgbox.html('check');
			$('#join_submit').attr('disabled', true);

			$.ajax({
				type: "POST",
				url: "<?=$ft['ajax_path']?>/user_join.php",
				data: "type=nickname&value="+nickname,
				success: function(msg) {
					msgbox.ajaxComplete(function(event, request, settings){
						if(msg == 'ok') {
							if (/^[가-힣a-zA-Z0-9_-]{2,16}$/i.test(nickname)) {
								nickname_chk = 1;
								msgbox.html('사용가능');
							} else {
								nickname_chk = 0;
								msgbox.html('사용불가');
							}
						} else if (msg == 'impossible') {
							nickname_chk = 0;
							msgbox.html('사용불가');
						} else {
							nickname_chk = 0;
							msgbox.html('중복');
						}
					});
				}
			});

			$('#join_submit').attr('disabled', false);
		} else {
			nickname_chk = 0;
			msgbox.html('사용불가');
		}
	});

	$("#password").change(function(){
		var password = $("#password").val();
		var msgbox = $("#pstatus");

		if(password.length >= 4) {
			password_chk = 1;
			msgbox.html('사용가능');
		} else {
			password_chk = 0;
			msgbox.html('사용불가');
			$("#prstatus").html('');
		}
	});

	$("#password_re").change(function(){
		var password = $("#password").val();
		var password_re = $("#password_re").val();
		var msgbox = $("#prstatus");

		if(password_re.length >= 4) {
			if (password != password_re) {
				password_re_chk = 0;
				msgbox.html('불일치');
			} else {
				password_re_chk = 1;
				msgbox.html('일치');
			}
		} else {
			password_re_chk = 0;
			msgbox.html('');
		}
	});

	$("#email").change(function(){
		var email = $("#email").val();
		var msgbox = $("#estatus");

		if(email.length >= 5) {
			msgbox.html('check');
			$('#join_submit').attr('disabled', true);

			$.ajax({
				type: "POST",
				url: "<?=$ft['ajax_path']?>/user_join.php",
				data: "type=email&value="+email,
				success: function(msg) {
					msgbox.ajaxComplete(function(event, request, settings){
						if(msg == 'ok') {
							if (/^[a-zA-Z0-9._-]+@[a-zA-Z0-9-]+\.[a-zA-Z.]{2,5}$/i.test(email)) {
								email_chk = 1;
								msgbox.html('사용가능');
							} else {
								email_chk = 0;
								msgbox.html('사용불가');
							}
						} else {
							email_chk = 0;
							msgbox.html('중복');
						}
					});
				}
			});

			$('#join_submit').attr('disabled', false);
		} else {
			email_chk = 0;
			msgbox.html('사용불가');
		}
	});
});

function user_join_form_chk(form) {
	if (username_chk == 0) {
		form.username.value = '';
		form.username.focus();
		alert('아이디를 다시 입력해주세요.');
		return false;
	}

	if (nickname_chk == 0) {
		form.nickname.value = '';
		form.nickname.focus();
		alert('닉네임을 다시 입력해주세요.');
		return false;
	}

	if (password_chk == 0) {
		form.password.value = '';
		form.password.focus();
		alert('패스워드를 다시 입력해주세요.');
		return false;
	}

	if (password_re_chk == 0) {
		form.password_re.value = '';
		form.password_re.focus();
		alert('패스워드 확인을 다시 입력해주세요.');
		return false;
	}

	if (email_chk == 0) {
		form.email.value = '';
		form.email.focus();
		alert('이메일을 다시 입력해주세요.');
		return false;
	}

	if (!form.agree.checked) {
		alert('이용약관에 동의하지 않으면 가입하실 수 없습니다.');
		return false;
	}

	return true;
}
</script>

<div class="content_row w604">

<img class="title_img" src="<?=$ft['img_path']?>/title_user_join.jpg" alt="join title" />

<form name="user_join_form" method="post" action="<?=$ft['op_path']?>/user_join.php" onsubmit="return user_join_form_chk(this);">
<table border="0" cellpadding="0" cellspacing="0" summary="회원 가입 테이블" class="write_table">
	<caption>회원 가입 테이블</caption>
	<colgroup>
		<col width="100" />
		<col width="" />
	</colgroup>
	<tr>
		<th>아이디</th>
		<td><input type="text" name="username" id="username" autocomplete="off" class="fleft" /><div class="relative"><div id="ustatus" class="absolute"></div></div></td>
	</tr>
	<tr>
		<th>닉네임</th>
		<td><input type="text" name="nickname" id="nickname" autocomplete="off" class="fleft" /><div class="relative"><div id="nstatus" class="absolute"></div></div></td>
	</tr>
	<tr>
		<th>패스워드</th>
		<td><input type="password" name="password" id="password" autocomplete="off" class="fleft" /><div class="relative"><div id="pstatus" class="absolute"></div></div></td>
	</tr>
	<tr>
		<th>패스워드 확인</th>
		<td><input type="password" name="password_re" id="password_re" autocomplete="off" class="fleft" /><div class="relative"><div id="prstatus" class="absolute"></div></div></td>
	</tr>
	<tr>
		<th>이메일</th>
		<td><input type="text" name="email" id="email" autocomplete="off" class="fleft" /><div class="relative"><div id="estatus" class="absolute"></div></div></td>
	</tr>
	<tr>
		<td colspan="2" class="left"><label><input type="checkbox" name="agree" class="mt2 mr2" />미디어플라이 <span class="font_58B9CB bold btn" onclick="view_terms();">이용약관</span>을 확인하였으며, 이에 동의합니다.</label></td>
	</tr>
	<tr>
		<td colspan="2" class="center"><input type="image" src="<?=$ft['img_path']?>/btn_ok.jpg" id="join_submit" /></td>
	</tr>
</table>
</form>

</div>
