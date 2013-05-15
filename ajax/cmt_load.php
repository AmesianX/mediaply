<?
$path = '..';

require($path.'/_common.php');

if ($_POST['act']=='next') {
	$next = mysql_fetch_assoc(mysql_query('SELECT * FROM `messages` WHERE `msg_id`>'.$_POST['next'].' ORDER BY `msg_id` ASC LIMIT 0, 1;'));
	$prev = mysql_fetch_assoc(mysql_query('SELECT * FROM `messages` WHERE `msg_id`>'.$_POST['prev'].' ORDER BY `msg_id` ASC LIMIT 0, 1;'));

	$result = $next;
} else if ($_POST['act']=='prev') {
	$next = mysql_fetch_assoc(mysql_query('SELECT * FROM `messages` WHERE `msg_id`<'.$_POST['next'].' ORDER BY `msg_id` DESC LIMIT 0, 1;'));
	$prev = mysql_fetch_assoc(mysql_query('SELECT * FROM `messages` WHERE `msg_id`<'.$_POST['prev'].' ORDER BY `msg_id` DESC LIMIT 0, 1;'));

	$result = $prev;
}

if ($result['msg_id']) {
	$user_data = mysql_fetch_assoc(mysql_query('SELECT * FROM `users` WHERE `uid`='.$result['uid_fk'].';'));
	if (!$user_data['profile_pic']) $user_data['profile_pic'] = 'default.jpg';
/*****************12.11.02 modified by h0n9t3n*********************************/

        $current = $ft['timestamp'];
        $timestamp = $result['created'];

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
	
        //$msg_ago = $ft['timestamp'] - $result['created'];

	//$msg_s = $msg_ago;
	//$msg_i = round($msg_ago / 60);
	//$msg_h = round($msg_ago / 60 / 60);
	//$msg_d = round($msg_ago / 60 / 60 / 24);
	//$msg_m = round($msg_ago / 60 / 60 / 24 / 30);
	//$msg_y = round($msg_ago / 60 / 60 / 24 / 30 / 12);

	//if ($msg_y >= 1) $ago = $msg_y.'년 전';
	//else if ($msg_m >= 1) $ago = $msg_m.'개월 전';
	//else if ($msg_d >= 1) $ago = $msg_d.'일 전';
	//else if ($msg_h >= 1) $ago = $msg_h.'시간 전';
	//else if ($msg_i >= 1) $ago = $msg_i.'분 전';
	//else $ago = $msg_s.'초 전';
?>
<input type="hidden" name="msg_next" id="msg_next" value="<?=$next['msg_id']?>" />
<input type="hidden" name="msg_prev" id="msg_prev" value="<?=$prev['msg_id']?>" />
<div class="hide right_msg_div">
	<table width="100%" border="0" cellpadding="0" cellspacing="0" style="table-layout:fixed;">
		<colgroup>
			<col width="40" />
			<col width="" />
		</colgroup>
		<tr>
			<td class="valign_top"><img src="<?=$ft['wall_path'].'/profile_pic/'.$user_data['profile_pic']?>" alt="<?=$user_data['nickname']?>" class="profile_pic" /></td>
			<td class="valign_top">
				<span class="fleft w100per limit_text align_left btn bold" onclick="window.open('<?=$ft['wall_path']?>/<?=$user_data['username']?>', 'wall', '');"><?=$user_data['nickname']?></span><div class="clear fleft break_all"><?=str_replace('\n', '<br />', $result['message'])?><div><img src="<?=$ft['img_path']?>/icon_clock.jpg" alt="clock icon" />&nbsp;<?=$ago?></div></div>
			</td>
		</tr>
	</table>
</div>
<?
}
?>
