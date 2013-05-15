<?php
ob_start("ob_gzhandler");
error_reporting(0);

$path = '..';

include_once 'ft/_common.php';
include_once 'includes/db.php';
include_once 'includes/Wall_Updates.php';
include_once 'includes/tolink.php';
include_once 'includes/textlink.php';
include_once 'includes/htmlcode.php';
include_once 'includes/Expand_URL.php';
include_once 'session.php';

$Wall = new Wall_Updates();

if ($_GET['username']) {
	$profile = mysql_fetch_assoc(mysql_query('SELECT * FROM `users` WHERE `username`="'.$_GET['username'].'";'));
} else {
	$profile = mysql_fetch_assoc(mysql_query('SELECT * FROM `users` WHERE `username`="'.$user['username'].'";'));
}

if (!$profile['profile_pic']) $profile['profile_pic'] = 'default.jpg';

if ($user['username'] == $profile['username']) $is_mypage = 1;
else $is_mypage = 0;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>MEDIAPLY</title>
<link rel="stylesheet" type="text/css" href="<?=$ft['path']?>/css/common.css" />
<link rel="stylesheet" type="text/css" href="<?=$ft['path']?>/css/wall.css" />
<link href="css/facebox.css" rel="stylesheet" type="text/css">
<link href="css/tipsy.css" rel="stylesheet" type="text/css">
<link href="css/lightbox.css" rel="stylesheet" type="text/css">
<link href="css/wall.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/jquery.wallform.js"></script>
<!-- <script type="text/javascript" src="js/jquery.webcam.js"></script> -->
<script type="text/javascript" src="js/jquery.color.js"></script>
<script type="text/javascript" src="js/jquery.livequery.js"></script>
<script type="text/javascript" src="js/jquery.timeago.js"></script>
<script type="text/javascript" src="js/jquery.tipsy.js"></script>
<script type="text/javascript" src="js/facebox.js"></script>
<script type="text/javascript" src="js/wall.js"></script>
<script type="text/javascript" src="js/photoZoom.min.js"></script>

<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-36595923-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>

<script type="text/javascript">
    $(document).ready(function(){
       $("#imageContainer_profile").photoZoom();
    });
</script>

<script type="text/javascript">
    $(document).ready(function(){
       $("#imageContainer_message").photoZoom();
    });
</script>

</head>
<body <?=$profile['profile_bg']?'style="background:url(\''.$ft['path'].'/upload/profile_bg/'.$profile['profile_bg'].'\') '.($user['bg_repeat']=='Y'?'':'no-repeat').';"':''?>>
<?php include('topbar.php'); ?>

<div style="padding:0px 8px;">

<div id="wall_container">

<div id="updateboxarea">
<h4>What's up?</h4>
<textarea name="update" id="update" maxlength="200" ></textarea>
<div id="linkbox"></div>
<br />
<!--
<div id="webcam_container" class='border'>
<div id="webcam" >
</div>
<div id="webcam_preview">

</div>

<div id='webcam_status'></div>
<div id='webcam_takesnap'>

<input type="button" value=" Take Snap " onclick="return takeSnap();" class="camclick button"/>
<input type="hidden" id="webcam_count" />
</div>
</div>
-->
<div  id="imageupload" class="border">
<form id="imageform" method="post" enctype="multipart/form-data" action='image_ajax.php'> 
<div id='preview'>
</div>

<span id='addphoto'>Add Photo:</span> <input type="file" name="photoimg" id="photoimg" />
<input type='hidden' id='uploadvalues' />
</form>
</div>
<div style="width:100%;clear:both">
<input type="submit"  value=" Update "  id="update_button"  class="update_button"/> 
<span style="float:right">
<a href="javascript:void(0);" id="camera" title="Upload Image"><img src="icons/cameraa.png" border="0" /></a> 
<!-- <a href="javascript:void(0);" id="webcam_button" title="Webcam Snap"><img src="icons/web-cam.png"  border="0"  style='margin-top:5px'/></a> -->
</span>
</div>

</div>

<div id='flashmessage'>
<div id="flash" align="left"  ></div>
</div>
<div id="content">

<?php 
// Loading Messages
include('load_messages.php'); 
?>

</div>
</div>

</div>

<?php include('bottom.php'); ?>

</body>
</html>
