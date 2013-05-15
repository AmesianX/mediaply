 <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
 <?php
 //Srinivas Tamada http://9lessons.info
//Load latest update 
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
if(isSet($_POST['update']))
{
$update=mysql_real_escape_string($_POST['update']);
$uploads=$_POST['uploads'];
$data=$Wall->Insert_Update($uid,$update,$uploads);

if($data)
{
$msg_id=$data['msg_id'];
$orimessage=$data['message'];
$message=tolink(htmlcode($data['message']));
$time=$data['created'];
$mtime=date("c", $time);
$uid=$data['uid_fk'];
$username=$data['username'];
 // User Avatar
 if($gravatar)
 $face=$Wall->Gravatar($uid);
 else
 $face=$Wall->Profile_Pic($uid);
  // End Avatar
?>
<div class="stbody" id="stbody<?php echo $msg_id;?>">
<div class="stimg">
<img src="<?php echo $face;?>" class='big_face' alt='<?php echo $username; ?>'/>
</div> 
<div class="sttext">
<a class="stdelete" href="#" id="<?php echo $msg_id;?>" title='Delete Update'></a>
<b><a href="<?php echo $base_url.$username; ?>"><?php echo $username;?></a></b> <?php echo clear($message);?>
<?php
 if($uploads)
{
echo "<div style='margin-top:10px'>";
$uploads_array=explode(',',$uploads);
$uploads=implode(',',array_unique($uploads_array));
$s = explode(",", $uploads);
foreach($s as $a)
{
 $newdata=$Wall->Get_Upload_Image_Id($a);
 if($newdata)
echo "<img src='uploads/".$newdata['image_path']."' class='imgpreview'/>";
}
echo "</div>";
 }
  ?>
<div class="sttime"><a href='#' class='commentopen' id='<?php echo $msg_id;?>' title='Comment'>Comment </a> | <a href='<?php echo $base_url ?>status/<?php echo $msg_id; ?>' class="timeago" title='<?php echo $mtime; ?>'></a>
	</div> 
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
<?php// include('load_comments.php') ?>
</div>
<div class="commentupdate" style='display:none' id='commentbox<?php echo $msg_id;?>'>
<div class="stcommentimg">
<img src="<?php echo $face;?>" class='small_face'/>
</div> 
<div class="stcommenttext" >
<form method="post" action="">
<textarea name="comment" class="comment" maxlength="200"  id="ctextarea<?php echo $msg_id;?>"></textarea>
<br />
<input type="submit"  value=" Comment "  id="<?php echo $msg_id;?>" class="comment_button button"/>
</form>
</div>
</div>
</div> 
</div>
<?php
}
}
?>
