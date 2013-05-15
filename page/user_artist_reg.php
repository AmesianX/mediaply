<?
$path = '..';

require($path.'/_common.php');
?>

<script type="text/javascript">
$(document).ready(function(){
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
});

function artist_reg_submit() {
	if ($("#artistname_chk").val() != 0) {
		$("#artistname_chk").val(null);
		$("#artistname").focus();
		alert('아티스트명을 다시 입력해주세요.');
		return false;
	}

	<? if ($user['profile_pic'] == 'default.jpg') { ?>
	if (!$("#profile_pic").val()) {
		alert('프로필 사진을 업데이트 해주세요.');
		return false;
	}
	<? } ?>
//파일업로드시 확장자 체크는 자바스크립트단에서 하지말고 php단에서 해야되요
//자바스크립트에서 해봤자 우회가능합니다...일단 주석..2012.10.28.h0n9t3n
/*
	if ($('#profile_pic').val()) {
		var chk = $('#profile_pic').val().toLowerCase().lastIndexOf('.jpg');
		var is_jpg = $('#profile_pic').val().substr(chk, chk+4);

		chk = $('#profile_pic').val().toLowerCase().lastIndexOf('.gif');
		var is_gif = $('#profile_pic').val().substr(chk, chk+4);

		if (is_jpg != '.jpg' && is_gif != '.gif') {
			alert('JPG, GIF 파일만 등록하실 수 있습니다.');
			return false;
		}
	}
*/
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
		url: "<?=$ft['ajax_path']?>/user_artist_reg.php",
		data: $('#user_artist_reg_form').serialize(),
		success: function(result) {
			switch (result) {
				case '0' :
					alert('아티스트 등록 완료.');
					break;
				case '1' :
					alert('아티스트명 형식 오류.');
					break;
				case '2' :
					alert('아티스트명 중복.');
					break;
				case '3' :
					alert('아티스트명 2자 미만.');
					break;
				default :
					break;
			}

			if ($('#profile_pic').val()) profile_pic_upload();
			else if ($('#profile_pic_del').attr('checked')) profile_pic_del();
			else if (result == '0') location.reload();
		}
	});

	return false;
}

function profile_pic_upload() {
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
					location.reload();
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
	$.ajax({
		type: "POST",
		url: "<?=$ft['ajax_path']?>/user_file_del.php",
		data: "field_name=profile_pic&uid=<?=$user['uid']?>",
		success: function(msg) {
			if (msg) {
				alert(msg);
				location.reload();
			}
		}
	});
}
</script>

<div class="content_row w604">

<img class="title_img" src="<?=$ft['img_path']?>/title_user_artist_reg.jpg" alt="artist register title" />

<form name="user_artist_reg_form" id="user_artist_reg_form" method="post" action="" onsubmit="return artist_reg_submit();" enctype="multipart/form-data">
<input type="hidden" name="artistname_chk" id="artistname_chk" value="1" />
<table border="0" cellpadding="0" cellspacing="0" summary="아티스트 등록 테이블" class="write_table">
	<caption>아티스트 등록 테이블</caption>
	<colgroup>
		<col width="100" />
		<col width="" />
	</colgroup>
	<tr>
		<th>아티스트명</th>
		<td><input type="text" name="artistname" id="artistname" autocomplete="off" class="fleft" /><div class="relative"><div id="astatus" class="absolute"></div></div></td>
	</tr>
	<tr>
		<th>프로필 사진</th>
		<td>
			<input type="file" name="profile_pic" id="profile_pic" class="fleft" />
			<? if ($user['profile_pic'] && $user['profile_pic']!='default.jpg') { ?>
				<img src="<?=$ft['wall_path'].'/profile_pic/'.$user['profile_pic']?>" alt="<?=$user['nickname']?>" class="profile_pic ml10" />
				<div class="fleft mt5 ml10"><label><input type="checkbox" name="profile_pic_del" id="profile_pic_del" value="Y" />&nbsp;삭제</label></div>
			<? } ?>
			<span class="clear fleft">사용 가능한 이미지는 JPG, GIF 입니다.</span>
		</td>
	</tr>
	<tr>
		<th>레이블</th>
		<td><input type="text" name="label" id="label" autocomplete="off" /></td>
	</tr>
	<tr>
		<th>장르</th>
		<td>
			<select name="gid_fk1">
				<option value="">::선택::</option>
				<? $genre = mysql_query('SELECT * FROM `ft_genre` ORDER BY `genre` ASC'); ?>
				<? for ($i=0; $row=mysql_fetch_array($genre); $i++) { ?>
				<option value="<?=$row['gid']?>"><?=$row['genre']?></option>
				<? } ?>
			</select>
			<select name="gid_fk2">
				<option value="">::선택::</option>
				<? $genre = mysql_query('SELECT * FROM `ft_genre` ORDER BY `genre` ASC'); ?>
				<? for ($i=0; $row=mysql_fetch_array($genre); $i++) { ?>
				<option value="<?=$row['gid']?>"><?=$row['genre']?></option>
				<? } ?>
			</select>
		</td>
	</tr>
	<tr>
		<th>소개</th>
		<td><textarea name="introduce"></textarea></td>
	</tr>
	<tr>
		<th>은행명</th>
		<td><input type="text" name="bank_name" id="bank_name" autocomplete="off" value="" /></td>
	</tr>
	<tr>
		<th>계좌번호</th>
		<td><input type="text" name="bank_account" id="bank_account" autocomplete="off" value="" /></td>
	</tr>
	<tr>
		<th>예금주</th>
		<td><input type="text" name="bank_holder" id="bank_holder" autocomplete="off" value="" /></td>
	</tr>
	<tr>
		<td colspan="2" class="center"><input type="image" src="<?=$ft['img_path']?>/btn_ok.jpg" /></td>
	</tr>
</table>
</form>

</div>
