<?
$path = '..';

require($path.'/_common.php');

if ($user['type'] != 'admin') {
	alert('접근권한이 없습니다.');
	location_replace($ft['path']);
}

$page = $_GET['page'] ? $_GET['page'] : 'index';
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>MEDIAPLY 관리자모드 - <?=$page?></title>
<link rel="stylesheet" type="text/css" href="<?=$ft['path']?>/css/common.css" />
<link rel="stylesheet" type="text/css" href="<?=$ft['adm_path']?>/css/admin.css" />
<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
<script type="text/javascript" src="<?=$ft['path']?>/js/basic.js"></script>
<script type="text/javascript" src="<?=$ft['adm_path']?>/js/admin.js"></script>

<script type="text/javascript">
var path = '<?=$ft['path']?>';
</script>
</head>
<body>

<div id="top_container">
	<div class="fleft ml20"><span class="btn" onclick="location.href='<?=$ft['adm_path']?>';"><img id="logo_small" src="<?=$ft['adm_img_path']?>/logo_small.png" alt="logo" /></span></div>
	<div class="fright mr20">
		<span class="font_58B9CB"><?=$user['username']?></span> <?=$user['type_kr']?>님 환영합니다!
		<span class="btn ml20" onclick="location.href='<?=$ft['path']?>';"><img src="<?=$ft['adm_img_path']?>/btn_home.png" alt="home button" /></span>
		<span class="btn" onclick="document.logout_form.submit();"><img src="<?=$ft['adm_img_path']?>/btn_logout.png" alt="logout button" /></span>
	</div>
</div>
<form name="logout_form" method="post" action=""><input type="hidden" name="logout" value="1" /></form>

<div id="middle_container">
	<div id="left_container">
		<div id="left_menu">
			<ul>
				<li id="left_title"><span class="btn" onclick="location.href='<?=$ft['adm_path']?>';">관리자모드</span></li>
				<li id="left_01">
					기본설정<span class="fright btn mt5" onclick="sub('01');"><img id="btn_01" src="<?=$ft['adm_img_path']?>/btn_left_plus.png" alt="submenu open" /></span>
					<div id="sub_01" class="left_sub">
						<ul>
							<li><a href="<?=$ft['adm_path']?>/?page=config">기본 설정</a></li>
							<li><a href="<?=$ft['adm_path']?>/?page=notice_list">공지 설정</a></li>
						</ul>
					</div>
				</li>
				<li id="left_02">
					회원관리<span class="fright btn mt5" onclick="sub('02');"><img id="btn_02" src="<?=$ft['adm_img_path']?>/btn_left_plus.png" alt="submenu open" /></span>
					<div id="sub_02" class="left_sub">
						<ul>
							<li><a href="<?=$ft['adm_path']?>/?page=user_list">회원 리스트</a></li>
						</ul>
					</div>
				</li>
				<li id="left_03">
					음원관리<span class="fright btn mt5" onclick="sub('03');"><img id="btn_03" src="<?=$ft['adm_img_path']?>/btn_left_plus.png" alt="submenu open" /></span>
					<div id="sub_03" class="left_sub">
						<ul>
							<!-- <li><a href="<?=$ft['adm_path']?>/?page=genre_list">장르 리스트</a></li> -->
							<li><a href="<?=$ft['adm_path']?>/?page=album_list">승인 완료 앨범 리스트</a></li>
							<li><a href="<?=$ft['adm_path']?>/?page=album_list_stateN">승인 대기 앨범 리스트</a></li>
						</ul>
					</div>
				</li>
				<li id="left_04">
					결제관리<span class="fright btn mt5" onclick="sub('04');"><img id="btn_04" src="<?=$ft['adm_img_path']?>/btn_left_plus.png" alt="submenu open" /></span>
					<div id="sub_04" class="left_sub">
						<ul>
							<li><a href="<?=$ft['adm_path']?>/?page=payment_list">결제 내역</a></li>
							<li><a href="<?=$ft['adm_path']?>/?page=paid_track_list">트랙 구매 내역</a></li>
							<li><a href="<?=$ft['adm_path']?>/?page=paid_present_list">장미꽃 선물 내역</a></li>
							<li><a href="<?=$ft['adm_path']?>/?page=paid_apply_list">출금 신청 내역</a></li>
							<li><a href="<?=$ft['adm_path']?>/?page=paid_waiting_list">입금 대기 내역</a></li>
							<li><a href="<?=$ft['adm_path']?>/?page=paid_complete_list">출금 완료 내역</a></li>
						</ul>
					</div>
				</li>
			</ul>
		</div>
	</div>
	<div id="right_container">
		<div id="content_container"><? require($ft['adm_path'].'/page/'.$page.'.php'); ?></div>
	</div>
</div>

<div id="bottom_container">copyright ⓒ MEDIAPLY all rights reserved.</div>

<iframe id="hidden_iframe" src="" class="hide"></iframe>

<script type="text/javascript">
if ('<?=$menu_id?>') setTimeout("sub('<?=$menu_id?>');", 100);
</script>

</body>
</html>
