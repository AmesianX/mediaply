<?
$path = '.';

require($path.'/_common.php');

$obj = mysql_fetch_assoc(mysql_query('SELECT * FROM `ft_track` WHERE `tid`='.$_GET['tid'].';'));
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>MEDIAPLY</title>
<link rel="stylesheet" type="text/css" href="<?=$ft['path']?>/css/common.css" />
<link rel="stylesheet" type="text/css" href="<?=$ft['path']?>/css/lyric_view.css" />
<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
</head>
<body style="width:100%; height:100%; background-color:#F2F2F2; overflow:hidden;">

<div style="width:100%; background-color:#2A2A2A; padding:8px 0px;"><img src="<?=$ft['img_path']?>/logo_small.png" alt="logo" style="margin-left:8px;" /></div>

<div style="width:96%; height:519px; padding:8px; overflow-y:scroll; word-break:break-all;"><?=nl2br($obj['lyric'])?></div>

<div style="width:100%; background-color:#2A2A2A; padding:8px 0px; text-align:right;"><img src="<?=$ft['img_path']?>/btn_lyric_close.jpg" alt="close button" style="margin-right:8px; cursor:pointer;" onclick="self.close();" /></div>

</body>
</html>
