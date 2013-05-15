<?
$menu_id = '01';

$config = mysql_fetch_assoc(mysql_query('SELECT * FROM `ft_config`'));
?>

<script type="text/javascript">
function form_submit(obj) {
	if (!/^[0-9]*$/i.test(obj.per_buy.value)) {
		alert('정수를 입력해주세요.');
		obj.per_buy.focus();
		return false;
	}

	if (!/^[0-9]*$/i.test(obj.per_download.value)) {
		alert('정수를 입력해주세요.');
		obj.per_download.focus();
		return false;
	}

	if (!/^[0-9]*$/i.test(obj.per_streaming.value)) {
		alert('정수를 입력해주세요.');
		obj.per_streaming.focus();
		return false;
	}

	if (!/^[0-9]*$/i.test(obj.per_playlist.value)) {
		alert('정수를 입력해주세요.');
		obj.per_playlist.focus();
		return false;
	}

	if (!/^[0-9]*$/i.test(obj.per_recommend.value)) {
		alert('정수를 입력해주세요.');
		obj.per_recommend.focus();
		return false;
	}

	obj.submit();
}
</script>

<div id="right_title">기본 설정</div>

<div id="content">

	<form name="config_form" method="post" action="<?=$ft['adm_op_path']?>/config.php">
	<input type="hidden" name="page" value="<?=$page?>" />
	<table border="0" cellpadding="0" cellspacing="0" summary="기본 설정 테이블" class="config_table">
		<caption>기본 설정 테이블</caption>
		<colgroup>
			<col width="140" />
			<col width="" />
		</colgroup>
		<tr>
			<th colspan="2">기본 설정</th>
		</tr>
		<tr>
			<td>사용불가 아이디<br /><span class="font_11 font_FF0000">※ 콤마(,)로 구분</span></td><td><textarea name="impossible_username"><?=$config['impossible_username']?></textarea></td>
		</tr>
		<tr>
			<td>사용불가 닉네임<br /><span class="font_11 font_FF0000">※ 콤마(,)로 구분</span></td><td><textarea name="impossible_nickname"><?=$config['impossible_nickname']?></textarea></td>
		</tr>
		<tr>
			<td>사용불가 아티스트명<br /><span class="font_11 font_FF0000">※ 콤마(,)로 구분</span></td><td><textarea name="impossible_artistname"><?=$config['impossible_artistname']?></textarea></td>
		</tr>
                <tr>
                        <td>음악소개</td><td><textarea name="music_indr"><?=$config['music_indr']?></textarea></td>
                </tr>
		<tr>
			<td>이용약관</td><td><textarea name="terms"><?=$config['terms']?></textarea></td>
		</tr>
		<tr>
			<td>개인정보취급방침</td><td><textarea name="privacy"><?=$config['privacy']?></textarea></td>
		</tr>
		<tr>
			<th colspan="2">통계 설정</th>
		</tr>
		<tr>
			<td>구매 횟수</td><td>X&nbsp;<input type="text" name="per_buy" maxlength="2" value="<?=$config['per_buy']?>" /></td>
		</tr>
		<tr>
			<td>다운로드 횟수</td><td>X&nbsp;<input type="text" name="per_download" maxlength="2" value="<?=$config['per_download']?>" /></td>
		</tr>
		<tr>
			<td>스트리밍 횟수</td><td>X&nbsp;<input type="text" name="per_streaming" maxlength="2" value="<?=$config['per_streaming']?>" /></td>
		</tr>
		<tr>
			<td>플레이리스트 추가 횟수</td><td>X&nbsp;<input type="text" name="per_playlist" maxlength="2" value="<?=$config['per_playlist']?>" /></td>
		</tr>
		<tr>
			<td>추천 횟수</td><td>X&nbsp;<input type="text" name="per_recommend" maxlength="2" value="<?=$config['per_recommend']?>" /></td>
		</tr>
	</table>
	</form>

	<div class="clear pv20 align_right">
		<span class="txt_btn" onclick="form_submit(document.config_form);">적용</span>
	</div>

</div>
