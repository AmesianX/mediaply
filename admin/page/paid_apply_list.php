<?
$menu_id = '04';

$where = 'WHERE 1 AND `state`="A" AND `price`>0';

if ($_GET['artist_uid_fk']) $where .= ' AND `artist_uid_fk`='.$_GET['artist_uid_fk'];

if ($_GET['s_year'] && $_GET['s_month'] && $_GET['s_day'] && $_GET['e_year'] && $_GET['e_month'] && $_GET['e_day']) $where .= ' AND `paid_date` BETWEEN "'.$_GET['s_year'].'-'.$_GET['s_month'].'-'.$_GET['s_day'].'" AND "'.$_GET['e_year'].'-'.$_GET['e_month'].'-'.$_GET['e_day'].'"';

$list = mysql_query('SELECT * FROM `ft_paid` '.$where.' ORDER BY `paid_date` DESC, `paid_time` DESC;');

$tmp_no = mysql_num_rows($list);

$total_price = 0;
?>

<div id="right_title">출금 신청 내역</div>

<div id="content">

	<div class="clear fright mb10">
		<select name="s_year" id="s_year">
			<? for ($i=2012; $i<=date('Y'); $i++) { ?>
			<option value="<?=$i?>" <?=$i==$_GET['s_year']?'selected="selected"':''?>><?=$i?></option>
			<? } ?>
		</select>
		<select name="s_month" id="s_month">
			<? for ($i=1; $i<=12; $i++) { ?>
			<option value="<?=$i?>" <?=$i==$_GET['s_month']?'selected="selected"':''?>><?=$i?></option>
			<? } ?>
		</select>
		<select name="s_day" id="s_day">
			<? for ($i=1; $i<=31; $i++) { ?>
			<option value="<?=$i?>" <?=$i==$_GET['s_day']?'selected="selected"':''?>><?=$i?></option>
			<? } ?>
		</select>
		~
		<select name="e_year" id="e_year">
			<? for ($i=2012; $i<=date('Y'); $i++) { ?>
			<option value="<?=$i?>" <?=$i==$_GET['e_year']?'selected="selected"':''?>><?=$i?></option>
			<? } ?>
		</select>
		<select name="e_month" id="e_month">
			<? for ($i=1; $i<=12; $i++) { ?>
			<option value="<?=$i?>" <?=$i==$_GET['e_month']?'selected="selected"':''?>><?=$i?></option>
			<? } ?>
		</select>
		<select name="e_day" id="e_day">
			<? for ($i=1; $i<=31; $i++) { ?>
			<option value="<?=$i?>" <?=$i==$_GET['e_day']?'selected="selected"':''?>><?=$i?></option>
			<? } ?>
		</select>
		<input type="button" value="&nbsp;검색&nbsp;" onclick="location.href='<?=$ft['adm_path']?>/?page=<?=$page?>&artist_uid_fk=<?=$_GET['artist_uid_fk']?>&s_year='+$('#s_year').val()+'&s_month='+$('#s_month').val()+'&s_day='+$('#s_day').val()+'&e_year='+$('#e_year').val()+'&e_month='+$('#e_month').val()+'&e_day='+$('#e_day').val();" />
	</div>

	<form name="paid_list_form" method="post" action="<?=$ft['adm_op_path']?>/paid_list_state.php">
	<input type="hidden" name="page" value="<?=$page?>" />
	<table border="0" cellpadding="0" cellspacing="0" summary="출금 신청 내역 리스트 테이블" class="list_table" id="paid_list_table">
		<caption>출금 신청 내역 리스트 테이블</caption>
		<colgroup>
			<col width="60" />
			<col width="60" />
			<col width="120" />
			<col width="120" />
			<col width="" />
			<col width="170" />
		</colgroup>
		<thead>
		<tr>
			<th><input type="checkbox" onclick="if ($(this).attr('checked')) { $('#paid_list_table input[type=checkbox]').attr('checked', true); } else { $('#paid_list_table input[type=checkbox]').attr('checked', false); }" /></th>
			<th>번호</th>
			<th>회원아이디</th>
			<th>콩나물</th>
			<th>내역</th>
			<th>일시</th>
		</tr>
		</thead>
		<tbody>
		<? for ($i=0; $row=mysql_fetch_array($list); $i++) { ?>
		<? $artist_data = mysql_fetch_assoc(mysql_query('SELECT * FROM `users` WHERE `uid`='.$row['artist_uid_fk'].';')); ?>
		<? $total_price += $row['price']; ?>
		<tr>
			<td><input type="checkbox" name="paid_id[]" value="<?=$row['id']?>" /></td>
			<td><?=$tmp_no--?></td>
			<td><span class="btn" onclick="location.href='<?=$ft['adm_path']?>/?page=<?=$page?>&artist_uid_fk=<?=$row['artist_uid_fk']?>&s_year=<?=$_GET['s_year']?>&s_month=<?=$_GET['s_month']?>&s_day=<?=$_GET['s_day']?>&e_year=<?=$_GET['e_year']?>&e_month=<?=$_GET['e_month']?>&e_day=<?=$_GET['e_day']?>';"><?=$artist_data['username']?></span></td>
			<td><?=$row['price']?>개&nbsp;(<?=$row['price']*100?>원)</td>
			<? if ($row['type']=='track') { ?>
			<? $track = mysql_fetch_assoc(mysql_query('SELECT * FROM `ft_track` WHERE `tid`='.$row['tid_fk'].';')); ?>
			<? $album = mysql_fetch_assoc(mysql_query('SELECT * FROM `ft_album` WHERE `aid`='.$track['aid_fk'].';')); ?>
			<td><span class="fleft w100per limit_text align_left">트랙 판매 : <?=$track['trackname']?></span></td>
			<? } else if ($row['type']=='present') { ?>
			<? $user_data = mysql_fetch_assoc(mysql_query('SELECT * FROM `users` WHERE `uid`='.$row['uid_fk'].';')); ?>
			<td><span class="fleft w100per limit_text align_left"><?=$user_data['username']?> 님으로부터 장미꽃 선물</span></td>
			<? } ?>
			<td><?=$row['paid_date']?>&nbsp;<?=$row['paid_time']?></td>
		</tr>
		<? } ?>
		</tbody>
	</table>
	</form>

	<? if ($total_price) { ?><div class="clear pv20 align_right">콩나물 합계 : <?=$total_price?>개&nbsp;(<?=$total_price*100?>원), 실지급액 : <?=$total_price*100-$total_price*30-$total_price*3.5?>원</div><? } ?>

	<div class="clear pv20 align_right">
		<span class="txt_btn" onclick="document.paid_list_form.submit();">선택변경</span>
	</div>

</div>
