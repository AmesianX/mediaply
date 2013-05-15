<?
if (!$is_mypage) {
	alert('접근권한이 없습니다.');
	location_replace($ft['wall_path']);
}

$ft['timestamp'] = date('U');
$ft['year'] = date('Y' , $ft['timestamp']);
$ft['month'] = date('m' , $ft['timestamp']);

$uploadDir = $ft['year'].'/'.$ft['month'].'/' . $ft['timestamp'] . '_';

if ($_GET['tid'])
{ 
$track = mysql_fetch_assoc(mysql_query('SELECT * FROM `ft_track` WHERE `tid`='.$_GET['tid'].';'));
$artist = mysql_fetch_assoc(mysql_query('SELECT artistname FROM `ft_track` WHERE `tid`='.$_GET['tid'].';'));
}else{
$artist = mysql_fetch_assoc(mysql_query('SELECT artistname FROM `users` WHERE `username`="'.$_GET['username'].'";'));
}
?>

<script type="text/javascript">
var tid = null;

$(document).ready(function(){
  $('#price').keydown(function(e){
    fn_Number($(this),e);
  }).keyup(function(e){
    fn_Number($(this),e);
  }).css('imeMode','disabled');
});
$(document).ready(function(){
        $("#price").change(function(){
           var price = $("#price").val();
           if( price > 0)
           {
            $("#free_download").val("N"); 
            $("#free_download").attr("checked",false);
            $("#free_download").attr("disabled",true);
           }
           else
           {
            $("#free_download").val("Y");
            $("#free_download").attr("checked",true);
            $("#free_download").attr("disabled",false);
           }
        });
});
function fn_Number(obj, e){
if(e.which=='229' || e.which=='197' && $.browser.opera) {
  setInterval(function(){
                         obj.trigger('keyup');
                         }, 100);
}

if ( ! (e.which && (e.which > 47 && e.which < 58)|| e.which ==8 || e.which ==9|| e.which ==0 || (e.ctrlKey && e.which ==86) ) ) {
  e.preventDefault();
}
var value = obj.val().match(/[^0-9]/g);
  if(value!=null) {
                   obj.val(obj.val().replace(/[^0-9]/g,''));
                   }
}

function track_reg_submit() {
	if ($('#track_file').val()) {
		var chk = $('#track_file').val().toLowerCase().lastIndexOf('.mp3');
		var chk_result = $('#track_file').val().substr(chk, chk+4);

		if (chk_result != '.mp3') {
			alert('MP3 파일만 등록하실 수 있습니다.');
			return false;
		}
	}
        if (!$("#trackname").val()) {
                $("#trackname").val(null);
                $("#trackname").focus();
                alert('트랙명을 입력해주세요.');
                return false;
        }

        if (!$("#gid_fk").val()) {
                $("#gid_fk").val(null);
                $("#gid_fk").focus();
                alert('장르를 선택해주세요.');
                return false;
        }
	if (('<?=$_GET['tid']?>' == '' && $('span.filename').text()) && $('span.fileinfo').text() == ' - Completed' || '<?=$_GET['tid']?>' != '') {
		$.ajax({
			type: "POST",
			url: "<?=$ft['ajax_path']?>/artist_track_reg.php",
			data: $('#track_reg_form').serialize(),
			success: function(result) {
				if (result) {
					tid = result;
					//헷갈려함 트랙파일 업로드 전에 메시지가 나와서 그냥 페이지를 넘길 가능성 존재
					alert('트랙 등록 완료.');

					//if ($('#track_file').val()) track_file_upload();
					location.replace('<?=$PHP_SELF?>?page=artist_album_list&username=<?=$_GET['username']?>');
				}
			}
		});
	} else {
		alert('트랙파일을 첨부해주세요.');
	}


	return false;
}
/*
function track_file_upload() {
//davidjc.AjaxFileUpload
	$.ajaxFileUpload({
		type: "GET",
		url: '<?=$ft['ajax_path']?>/artist_track_file_upload.php?tid='+tid,
		secureuri: false,
		fileElementId: 'track_file',
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
*/
<?php $timestamp = time();?>
  $(function() {
                 $('#track_file').uploadifive({
				                 'auto'             : false ,
                                                 'multi'            : false ,
                                                 'buttonText'       : 'SELECT FILE' ,
                                                 'uploadLimit'      : 0 ,
                                                 'queueSizeLimit'   : 0 ,
                                                 'onSelect'         : function(queue) {
                                                                                         if(queue.count > 1)
                                                                                         {
                                                                                            $('#track_file').uploadifive('cancel', $('.uploadifive-queue-item').first().data('file'))
                                                                                         }
                                                                                       },
                                                 'itemTemplate'     : '<div class="uploadifive-queue-item"><span class="filename"></span> | <span class="fileinfo"></span><div class="close"></div></div>' ,
				                 'checkScript'      : <?if ($_GET['tid']){?>'<?=$ft['ajax_path']?>/check-exists.php?tid=<?=$_GET['tid']?>',<?} else {?>'<?=$ft['ajax_path']?>/check-exists.php',<?}?>
				                 'formData'         : {
							                'timestamp' : '<?php echo $timestamp;?>',
									'token'     : '<?php echo md5('unique_salt' . $timestamp);?>'
				                                       },
				                 'queueID'          : 'queue',
				                 'uploadScript'     : '<?=$ft['ajax_path']?>/uploadifive.php?timestamp=<?=$ft['timestamp']?>' ,
				                 'onUploadComplete' : function(file, data) {
                                                                                             $('#filename').val('<?=$uploadDir?>'+file.name);
                                                                                             alert( file.name + ' 업로드 완료 하였습니다.'); 
                                                                                            }
			                      });
		});
</script>
<form name="track_reg_form" id="track_reg_form" method="post" action="" onsubmit="return track_reg_submit();" enctype="multipart/form-data">
<? if ($_GET['tid']) { ?>
<input type="hidden" name="mod" value="1" />
<input type="hidden" name="tid" value="<?=$track['tid']?>" />
<input type="hidden" name="filename" id="filename" value="<?=$track['track_file']?>" />
<? } else { ?>
<input type="hidden" name="reg" value="1" />
<input type="hidden" name="filename" id="filename" value="" />
<? } ?>
<input type="hidden" name="aid_fk" value="<?=$_GET['aid']?>" />
<table border="0" cellpadding="0" cellspacing="0" summary="트랙 등록 테이블" class="write_table ml20">
	<caption>트랙 등록 테이블</caption>
	<colgroup>
		<col width="100" />
		<col width="" />
	</colgroup>
        <tr>
                <th>아티스트명</th>
                <td><input type="text" name="artistname" id="artistname" autocomplete="off" value="<?=$artist['artistname']?>" /></td>
        </tr>
	<tr>
		<th>트랙명</th>
		<td><input type="text" name="trackname" id="trackname" autocomplete="off" value="<?=$track['trackname']?>" /></td>
	</tr>
	<tr>
		<th>장르</th>
		<td>
			<select name="gid_fk" id="gid_fk">
				<option value="">::선택::</option>
				<? $genre = mysql_query('SELECT * FROM `ft_genre` ORDER BY `genre` ASC'); ?>
				<? for ($i=0; $row=mysql_fetch_array($genre); $i++) { ?>
				<option value="<?=$row['gid']?>" <?=$row['gid']==$track['gid_fk']?'selected="selected"':''?>><?=$row['genre']?></option>
				<? } ?>
			</select>
		</td>
	</tr>
	<tr>
		<th>트랙파일</th>
		<td>
                        <div id="queue"></div>
			<input type="file" name="track_file" id="track_file" src="<?=$ft['img_path']?>/btn_file.jpg" class="fleft" />
		        <a style="position: relative; top: 8px;" href="javascript:$('#track_file').uploadifive('upload')">Upload File</a>
			<span class="clear fleft">사용 가능한 파일형식은 MP3 입니다.</span>
		</td>
	</tr>
	<tr>
		<th>가사</th>
		<td><textarea name="lyric" /><?=$track['lyric']?></textarea></td>
	</tr>
	<tr>
		<th>가격</th>
		<td>
			<span class="fleft mt5 mr5">콩나물</span><input type="text" name="price" id="price" autocomplete="off" value="<?=$track['price']?>" class="fleft align_right" /><span class="fleft mt5 ml5">개</span>
			<span class="fleft mt5 ml5">(콩나물 1개 = 100원)</span>
		</td>
	</tr>
	<tr>
		<th>기타</th>
		<td>
			<label><span class="btn fleft">무료다운로드</span><input type="checkbox" name="free_download" id="free_download" value="Y" class="btn fleft mt2 ml2" <?=$track['free_download']=='Y'?'checked="checked"':''?> /></label>
			<label><span class="btn fleft ml10">무료스트리밍</span><input type="checkbox" name="free_streaming" value="Y" class="btn fleft mt2 ml2" <?=$track['free_streaming']=='Y'?'checked="checked"':''?> /></label>
		</td>
	</tr>
	<tr>
		<td colspan="2"><span class="font_11 font_FF0000">※ 등록, 수정 후 관리자의 승인을 거쳐 리스너 회원에게 노출됩니다.</span></td>
	</tr>
	<tr>
		<td colspan="2"><input type="image" src="<?=$ft['img_path']?>/btn_ok.jpg" /></td>
	</tr>
</table>
</form>
