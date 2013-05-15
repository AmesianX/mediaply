<?
if (!$is_mypage || $profile['type'] != 'admin') {
	alert('접근권한이 없습니다.');
	location_replace($ft['wall_path']);
}

if ($_GET['aid'])
{ 
$album = mysql_fetch_assoc(mysql_query('SELECT * FROM `ft_album` WHERE `aid`='.$_GET['aid'].';'));
$artist = mysql_fetch_assoc(mysql_query('SELECT artistname FROM `ft_track` WHERE `aid`='.$_GET['aid'].';'));
}else{
$artist = mysql_fetch_assoc(mysql_query('SELECT artistname FROM `users` WHERE `username`="'.$_GET['username'].'";'));
}
?>

<script type="text/javascript">
var aid = null;

function album_reg_submit() {
        if (!$("#albumname").val()) {
                $("#albumname").val(null);
                $("#albumname").focus();
                alert('앨범명을 입력해주세요.');
                return false;           
        }  
        if (!$("#gid_fk").val()) {
                $("#gid_fk").val(null);
                $("#gid_fk").focus();
                alert('장르을 입력해주세요.');
                return false;           
        }  
	$.ajax({
		type: "POST",
		url: "<?=$ft['ajax_path']?>/artist_album_reg.php",
		data: $('#album_reg_form').serialize(),
		success: function(result) {
			if (result) {
				aid = result;
				//alert('앨범 등록 완료.');

				if ($('#album_pic').val()) album_pic_upload();
				else location.replace('<?=$PHP_SELF?>?page=artist_album_list&username=<?=$_GET['username']?>');
			}
		}
	});

	return false;
}

function album_pic_upload() {
	$.ajaxFileUpload({
		type: "GET",
		url: '<?=$ft['ajax_path']?>/artist_album_pic_upload.php?aid='+aid,
		secureuri: false,
		fileElementId: 'album_pic',
		dataType: 'json',
		success: function(data, status) {
			if (typeof(data.error) != 'undefined') {
				if (data.error != '') {
					alert(data.error);
					location.replace('<?=$PHP_SELF?>?page=artist_album_list&username=<?=$_GET['username']?>');
				} else {
					alert(data.msg);
					location.replace('<?=$PHP_SELF?>?page=artist_album_list&username=<?=$_GET['username']?>');
				}
			}
		},
		error: function(data, status, e) {
			alert(e);
			location.replace('<?=$PHP_SELF?>?page=artist_album_list&username=<?=$_GET['username']?>');
		}
	});

	return false;
}
</script>

<form name="album_reg_form" id="album_reg_form" method="post" action="" onsubmit="return album_reg_submit();" enctype="multipart/form-data">
<? if ($_GET['aid']) { ?>
<input type="hidden" name="mod" value="1" />
<input type="hidden" name="aid" value="<?=$album['aid']?>" />
<? } else { ?>
<input type="hidden" name="reg" value="1" />
<? } ?>
<table border="0" cellpadding="0" cellspacing="0" summary="앨범 등록 테이블" class="write_table ml20">
	<caption>앨범 등록 테이블</caption>
	<colgroup>
		<col width="100" />
		<col width="" />
	</colgroup>
	<tr>
		<th>아티스트명</th>
		<td><input type="text" name="artistname" id="artistname" autocomplete="off" value="<?=$artist['artistname']?>" /></td>
	</tr>
        <tr>
                <th>앨범명</th>
                <td><input type="text" name="albumname" id="albumname" autocomplete="off" value="<?=$album['albumname']?>" /></td>
        </tr>
	<tr>
		<th>장르</th>
		<td>
			<select name="gid_fk" id="gid_fk">
				<option value="">::선택::</option>
				<? $genre = mysql_query('SELECT * FROM `ft_genre` ORDER BY `genre` ASC'); ?>
				<? for ($i=0; $row=mysql_fetch_array($genre); $i++) { ?>
				<option value="<?=$row['gid']?>" <?=$row['gid']==$album['gid_fk']?'selected="selected"':''?>><?=$row['genre']?></option>
				<? } ?>
			</select>
		</td>
	</tr>
	<tr>
		<th>설명</th>
		<td><input type="text" name="explain" autocomplete="off" value="<?=$album['explain']?>" /></td>
	</tr>
	<tr>
		<th>앨범이미지</th>
		<td>
			<input type="file" name="album_pic" id="album_pic" class="fleft" src="<?=$ft['img_path']?>/btn_file.jpg" />
			<span class="clear fleft">사용 가능한 이미지는 JPG, PNG, GIF 입니다.</span>
		</td>
	</tr>
	<tr>
		<td colspan="2" class="center"><input type="image" src="<?=$ft['img_path']?>/btn_ok.jpg" /></td>
	</tr>
</table>
</form>
