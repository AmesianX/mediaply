<?
$path = '..';

require($path.'/_common.php');
?>

<script type="text/javascript" src="https://api.paygate.net/ajax/common/OpenPayAPI.js"></script>

<script type="text/javascript">
var frm = document.PGIOForm;

function startPayment() {
	if (frm.qty.value<10) {
		alert('최소 결제 단위는 10개입니다.');
		return false;
	}

	$('.payment_table').hide();

	doTransaction(frm);
}

function getPGIOresult() {
	verifyReceived(getPGIOElement('tid'), 'callbacksuccess', 'callbackfail');
}

function callbacksuccess() {
	var replycode = getPGIOElement('replycode');
	var replymsg = getPGIOElement('replyMsg');
	replymsg = replymsg.replace(/<br>/gi, '\n');

	if (replycode == '0000') {
		$.ajax({
			type: "POST",
			url: "<?=$ft['ajax_path']?>/payment.php",
			data: $('#PGIOForm').serialize(),
			success: function(result) {
				$('#bean_cnt').val(frm.qty.value);
				alert('결제가 완료되었습니다.');
				window.open('https://service.paygate.net/front/support/slipView.jsp?trnsctnNo='+frm.tid.value+'&admMemNo=M000000001&langcode=KR', 'payment_result', '');
				ajax_page_load('left_content', 'payment');
			}
		});

		return false;
	} else {
		alert("결제가 실패했습니다.\n다시 이용해 주세요.\n\n코드 : " + replycode + "\n메시지 : \n" + replymsg);
		ajax_page_load('left_content', 'payment');
	}
}

function callbackfail() {
	alert("결제가 실패했습니다.\n다시 이용해 주세요.");
	ajax_page_load('left_content', 'payment');
}

$(document).ready(function(){
	$('.number_only').change(function(){
		if (!/^[0-9]*$/i.test($(this).val())) {
			alert('숫자만 입력해주세요.');
			$(this).css('background-color', '#EEC8C8');
			$(this).val(null);
			$(this).focus();
		}
	});

	$('#paymethod_btn').live('click', function(){
		$('#paymethod').val($(this).val());
	});
});
</script>

<div class="content_row w604">

<img class="title_img" src="<?=$ft['img_path']?>/title_payment.jpg" alt="payment title" />

<form name="PGIOForm" id="PGIOForm" method="post" action="">
<input type="hidden" name="mid" value="h0n9t3n" />
<input type="hidden" name="langcode" value="KR" />
<input type="hidden" name="paymethod" id="paymethod" value="801" />
<input type="hidden" name="unitprice" value="" />
<input type="hidden" name="goodcurrency" value="WON" />
<input type="hidden" name="goodname" value="콩나물" />
<input type="hidden" name="receipttoname" value="<?=$user['username']?>" />
<input type="hidden" name="receipttoemail" value="<?=$user['email']?>" />
<input type="hidden" name="tid" value="" />
<input type="hidden" name="replycode" value="" />
<input type="hidden" name="replyMsg" value="" />
<input type="hidden" name="ResultScreen" value="" />
<table border="0" cellpadding="0" cellspacing="0" summary="결제 테이블" class="payment_table">
	<caption>결제 테이블</caption>
	<colgroup>
		<col width="160" />
		<col width="" />
	</colgroup>
	<tr>
		<th>수량 선택</th>
		<td><span class="fleft mt5 mr5"><img src="<?=$ft['img_path']?>/icon_bean.jpg" alt="bean icon" />&nbsp;x</span><input type="text" name="qty" maxlength="4" class="number_only fleft" onkeyup="document.PGIOForm.unitprice.value=parseInt(this.value)*100;" /></td>
	</tr>
	<tr>
		<th>결제 수단 선택</th>
		<td>
			<label class="btn"><input type="radio" name="paymethod_btn" id="paymethod_btn" class="fleft" value="801" checked="checked" /><span class="fleft">휴대폰</span></label>
			<label class="btn"><input type="radio" name="paymethod_btn" id="paymethod_btn" class="fleft ml15" value="card" /><span class="fleft">신용카드</span></label>
			<label class="btn"><input type="radio" name="paymethod_btn" id="paymethod_btn" class="fleft ml15" value="4" /><span class="fleft">실시간 계좌이체</span></label>
		</td>
	</tr>
	<tr>
		<td colspan="2" class="align_center"><span class="font_11 font_FF0000">※ 콩나물 1개당 100원</span>&nbsp;&nbsp;<span class="txt_btn" onclick="startPayment();">결제</span></td>
	</tr>
</table>
</form>

<div id="PGIOscreen"></div>

<div id="PGIOheader"></div>
<div id="div_lgdacom"></div>
<div id="dop_parent"></div>

</div>
