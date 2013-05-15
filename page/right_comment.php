<?
$path = '..';

require($path.'/_common.php');

$list = mysql_query('SELECT * FROM `messages` ORDER BY `msg_id` DESC LIMIT 0, 5;');
?>

<script type="text/javascript">
function msg_load(act) {
	$.ajax({
		url: path+'/ajax/cmt_load.php',
		type: 'POST',
		dataType: 'html',
		data: 'act='+act+'&next='+next+'&prev='+prev,
		success: function(result) {
			if (result) {
				if (act=='next') {
					for (i=4; i>0; i--) {
						$('#right_msg_table .right_msg_td').eq(i).html($('#right_msg_table .right_msg_td').eq(i-1).html());
					}
					$('#right_msg_table .right_msg_td').eq(0).html(result);
					$('#right_msg_table .right_msg_td .right_msg_div').eq(0).slideDown();
				} else if (act=='prev') {
					for (i=0; i<4; i++) {
						$('#right_msg_table .right_msg_td').eq(i).html($('#right_msg_table .right_msg_td').eq(i+1).html());
					}
					$('#right_msg_table .right_msg_td').eq(4).html(result);
					$('#right_msg_table .right_msg_td .right_msg_div').eq(4).slideDown();
				}

				next = $('#msg_next').val();
				prev = $('#msg_prev').val();

				$('#msg_next').remove();
				$('#msg_prev').remove();
			}
		}
	});
}

function right_msg_div() {
	for (i=0; i<$('.right_msg_div').length; i++) {
		setTimeout("$('.right_msg_div').eq("+i+").slideDown();", 300*i);
	}
}

function msg_update_chk() {
	$.ajax({
		url: path+'/ajax/msg_update_chk.php',
		type: 'POST',
		dataType: 'html',
		data: 'msg_id='+first,
		success: function(result) {
			var tmp = result.split('|');

			if (parseInt(tmp['0']) > 0) {
				for (i=0; i<tmp['0']; i++) {
					setTimeout("msg_load('next');", 1000);
				}
				first = parseInt(tmp['1']);
			}
		}
	});
}

$(document).ready(function(){
	setTimeout('right_msg_div();', 1000);
	setInterval('msg_update_chk();', 30000);
});
</script>

<img class="title_img" src="<?=$ft['img_path']?>/title_new_comment.jpg" alt="new comment title" />

<div class="fright mt_5">
	<img class="btn" onclick="msg_load('next');" src="<?=$ft['img_path']?>/btn_arrow_left_s.jpg" alt="left button" />
	<img class="btn" onclick="msg_load('prev');" src="<?=$ft['img_path']?>/btn_arrow_right_s.jpg" alt="right button" />
</div>

<table border="0" cellpadding="0" cellspacing="0" id="right_msg_table" style="width:100%; table-layout:fixed;">
<?
for ($i=0; $row=mysql_fetch_array($list); $i++) {
	$user_data = mysql_fetch_assoc(mysql_query('SELECT * FROM `users` WHERE `uid`='.$row['uid_fk'].';'));
	if (!$user_data['profile_pic']) $user_data['profile_pic'] = 'default.jpg';

/*****************12.11.02 modified by h0n9t3n*********************************/

        $current = $ft['timestamp'];
        $timestamp = $row['created'];

        if ($timestamp <= $current - 86400 * 365) { 
            $ago = (int)(($current - $timestamp) / (86400 * 365)) . "년전"; 
        } 
        else if ($timestamp <= $current - 86400 * 31) { 
            $ago = (int)(($current - $timestamp) / (86400 * 31)) . "개월전"; 
        } 
        else if ($timestamp <= $current - 86400 * 1) { 
            $ago = (int)(($current - $timestamp) / 86400) . "일전"; 
        } 
        else if ($timestamp <= $current - 3600 * 1) { 
            $ago = (int)(($current - $timestamp) / 3600) . "시간전"; 
        } 
        else if ($timestamp <= $current - 60 * 1) { 
            $ago = (int)(($current - $timestamp) / 60) . "분전"; 
        } 
        else { 
            $ago = (int)($current - $timestamp) . "초전"; 
        }
/*********************************************************************************/
	//$msg_ago = $ft['timestamp'] - $row['created'];
	//$msg_s = $msg_ago;
	//$msg_i = floor($msg_ago / 60);
	//$msg_h = floor($msg_ago / 60 / 60);
	//$msg_d = floor($msg_ago / 60 / 60 / 24);
	//$msg_m = floor($msg_ago / 60 / 60 / 24 / 30);
	//$msg_y = floor($msg_ago / 60 / 60 / 24 / 30 / 12);

	//if ($msg_y >= 1) $ago = $msg_y.'년 전';
	//else if ($msg_m >= 1) $ago = $msg_m.'개월 전';
	//else if ($msg_d >= 1) $ago = $msg_d.'일 전';
	//else if ($msg_h >= 1) $ago = $msg_h.'시간 전';
	//else if ($msg_i >= 1) $ago = $msg_i.'분 전';
	//else $ago = $msg_s.'초 전';

	if ($i==0) {
		echo '<script type="text/javascript">var first = '.$row['msg_id'].';</script>';
		echo '<script type="text/javascript">var next = '.$row['msg_id'].';</script>';
	}
	if ($i==4) echo '<script type="text/javascript">var prev = '.$row['msg_id'].';</script>';
?>
	<tr>
		<td class="right_msg_td pv10">
			<div class="hide right_msg_div">
				<table width="100%" border="0" cellpadding="0" cellspacing="0" style="table-layout:fixed;">
					<colgroup>
						<col width="40" />
						<col width="" />
					</colgroup>
					<tr>
						<td class="valign_top"><img src="<?=$ft['wall_path'].'/profile_pic/'.$user_data['profile_pic']?>" alt="<?=$user_data['nickname']?>" class="profile_pic" /></td>
						<td class="valign_top">
							<span class="fleft w100per limit_text align_left btn bold" onclick="window.open('<?=$ft['wall_path']?>/<?=$user_data['username']?>', 'wall', '');"><?=$user_data['nickname']?></span><div class="clear fleft break_all"><?=str_replace('\n', '<br />', $row['message'])?><div><img src="<?=$ft['img_path']?>/icon_clock.jpg" alt="clock icon" />&nbsp;<?=$ago?></div></div>
						</td>
					</tr>
				</table>
			</div>
		</td>
	</tr>
<?
}

if ($i<5) {
	for ($j=$i%5; $j<5; $j++) {
		echo '<tr><td></td></tr>';
	}
}
?>
</table>
