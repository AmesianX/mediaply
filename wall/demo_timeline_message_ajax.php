 <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
 <?php
 //Srinivas Tamada http://9lessons.info
//Load latest update 
error_reporting(0);
$path = '..';
include_once 'ft/_common.php';
include_once 'includes/tolink.php';
include_once 'includes/textlink.php';
include_once 'includes/htmlcode.php';
include_once 'includes/Expand_URL.php';
include_once 'includes/time_stamp.php';

if(isset($_POST['update']))
{
$update=mysql_real_escape_string($_POST['update']);


if(1)
{
$msg_id=time();
$orimessage=$update;
$message=tolink(htmlcode($update));
$time=time();
$uid=1;
$username="Srinivas";
 // User Avatar
 $face='http://www.gravatar.com/avatar.php?gravatar_id=7a9e87053519e0e7a21bb69d1deb6dfe';
  // End Avatar
?>
<div class="item " id='item<?php echo $msg_id;?>'>

<a href='#' class='deletebox' id="<?php echo $msg_id;?>" title="Delete Update">X</a>
<div class="stbody" id="stbody<?php echo $msg_id;?>">
<div class="stimg">
<img src="<?php echo $face;?>" class='time_face' alt='<?php echo $username; ?>' />
</div>
<div class="sttext">
<b><a href="<?php echo $base_url.$username; ?>"><?php echo $username;?></a></b> <?php echo clear($message);?>

<div class="sttime"><?php time_stamp($time);?> | <a href='#' class='commentopen' id='<?php echo $msg_id;?>' title='Comment'>Comment </a></div> 
<div id="stexpandbox">
<div id="stexpand">
	<?
	if(textlink($orimessage))
	{
	$link =textlink($orimessage);
	echo Expand_URL($link);
	}
	?>	
	
</div>
</div>
<div class="commentcontainer" id="commentload<?php echo $msg_id;?>">

</div>
<div class="commentupdate" style='display:none' id='commentbox<?php echo $msg_id;?>'>
<div class="stcommentimg">
<img src="<?php echo $face;?>" class='small_face'/>
</div> 
<div class="stcommenttext" >
<form method="post" action="">
<textarea name="comment" class="comment" maxlength="200"  id="ctextarea<?php echo $msg_id;?>"></textarea>
<br />
<input type="submit"  value=" Comment "  id="<?php echo $msg_id;?>" class="comment_button"/>
</form>
</div>
</div>
</div> 
</div>
</div>
<?php
}
}
?>
