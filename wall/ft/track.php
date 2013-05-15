<?
$total = mysql_fetch_assoc(mysql_query('SELECT COUNT(*) AS `cnt` FROM `ft_paid` WHERE `type`="track" AND `price`>0 AND `artist_uid_fk`='.$user['uid'].';'));

$rows = 10;
$total_page = ceil($total['cnt'] / $rows);
if (!$_GET['p_num']) $p_num = 1;
else $p_num = $_GET['p_num'];
$first_index = ($p_num - 1) * $rows;

if ($_GET['p_num'] && ($p_num <= 0 || $p_num > $total_page)) {
	alert('존재하지 않는 페이지입니다.');
	location_replace($ft['adm_path']);
}

$tmp_no = $total['cnt'] - (($p_num - 1) * $rows);

$list = mysql_query('SELECT * FROM `ft_paid` WHERE `type`="track" AND `price`>0 AND `artist_uid_fk`='.$user['uid'].' ORDER BY `paid_date` DESC, `paid_time` DESC LIMIT '.$first_index.', '.$rows.';');

$paging = get_paging($p_num, $total_page, $PHP_SELF.'?page='.$page.'&p_num=', 10);
?>

<form name="withdraw" method="post" action="<?=$ft['wall_path']?>/ft/operation/withdraw.php">
<input type="hidden" name="page" value="<?=$page?>" />
<input type="hidden" name="p_num" value="<?=$p_num?>" />
<table border="0" cellpadding="0" cellspacing="0" summary="트랙 판매 내역 리스트 테이블" class="list_table ph20" id="paid_track_table">
	<caption>트랙 판매 내역 리스트 테이블</caption>
	<colgroup>
		<col width="40" />
		<col width="40" />
		<col width="" />
		<col width="120" />
		<col width="70" />
		<col width="170" />
		<col width="60" />
	</colgroup>
	<thead>
	<tr>
		<th><input type="checkbox" onclick="if ($(this).attr('checked')) { $('#paid_track_table input[type=checkbox]').attr('checked', true); } else { $('#paid_track_table input[type=checkbox]').attr('checked', false); }" /></th>
		<th>번호</th>
		<th>트랙명</th>
		<th>구매회원아이디</th>
		<th>콩나물</th>
		<th>구매일시</th>
		<th>출금</th>
	</tr>
	</thead>
	<tbody>
	<? for ($i=0; $row=mysql_fetch_array($list); $i++) { ?>
	<? $delay = ($ft['timestamp'] - strtotime($row['paid_date'].' '.$row['paid_time']) > 5184000) ? 0 : 1 ; ?>
	<? $track = mysql_fetch_assoc(mysql_query('SELECT * FROM `ft_track` WHERE `tid`='.$row['tid_fk'].';')); ?>
	<? $user_data = mysql_fetch_assoc(mysql_query('SELECT * FROM `users` WHERE `uid`='.$row['uid_fk'].';')); ?>
	<tr>
		<td><? if ($row['state']=='N' && !$delay) { ?><input type="checkbox" name="paid_id[]" value="<?=$row['id']?>" /><? } ?></td>
		<td><?=$tmp_no--?></td>
		<td><span class="fleft w100per limit_text align_left"><?=$track['trackname']?></span></td>
		<td><?=$user_data['username']?></td>
		<td><img src="<?=$ft['img_path']?>/icon_bean.jpg" alt="bean icon" />&nbsp;x<?=$row['price']?></td>
		<td><?=$row['paid_date']?>&nbsp;<?=$row['paid_time']?></td>
		<td>
			<?
			if ($delay) {
				echo '신청불가';
			} else {
				switch ($row['state']) {
					case 'N' :
						echo '신청가능';
						break;
					case 'A' :
						echo '신청중';
						break;
					case 'W' :
						echo '접수완료';
						break;
					case 'Y' :
						echo '출금완료';
						break;
					default :
						echo 'err';
						break;
				}
			}
			?>
		</td>
	</tr>
	<? } ?>
	</tbody>
</table>
</form>

<div class="clear fleft mv10 ph20"><?=$paging?></div>

<div class="clear fright mv10 ph20"><span class="font_11 font_FF0000">※ 2개월 이내 내역 출금 불가</span></div>

<div class="clear fright mv10 ph20"><span class="font_11 font_FF0000">※ 출금 신청 금액에서 수수료 33.5%(판매수수료 30%, 결제수수료 3.5%)가 차감된 금액이 지급됩니다.</span></div>

<div class="clear fright mv10 ph20"><span class="txt_btn ml20" onclick="document.withdraw.submit();">선택신청</span></div>
