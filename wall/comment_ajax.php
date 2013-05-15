 <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
 <?php
 //Srinivas Tamada http://9lessons.info
//Load latest comment 
error_reporting(0);
$path = '..';
include_once 'ft/_common.php';
include_once 'includes/db.php';
include_once 'includes/Wall_Updates.php';
include_once 'includes/tolink.php';
include_once 'includes/textlink.php';
include_once 'includes/htmlcode.php';
include_once 'session.php';

$Wall = new Wall_Updates();
if(isSet($_POST['comment']))
{
$comment=mysql_real_escape_string($_POST['comment']);

$msg_id=$_POST['msg_id'];
$ip=$_SERVER['REMOTE_ADDR'];
$cdata=$Wall->Insert_Comment($uid,$msg_id,$comment,$ip);
if($cdata)
{
$com_id=$cdata['com_id'];
// modify by h0n9t3n 12.10.29 htmlentities는 한글 깨짐으로 htmlspecialchars을 사용
// $comment=tolink(htmlentities($cdata['comment'] ));
 $comment=tolink(htmlspecialchars($cdata['comment'] ));
 $time=$cdata['created'];
$mtime=date("c", $time);
 $username=$cdata['username'];
 $uid=$cdata['uid_fk'];
 // User Avatar
 if($gravatar)
 $cface=$Wall->Gravatar($uid);
 else
 $cface=$Wall->Profile_Pic($uid);
  // End Avatar
 ?>
<div class="stcommentbody" id="stcommentbody<?php echo $com_id; ?>">
<div class="stcommentimg">
<img src="<?php echo $cface; ?>" class='small_face' alt='<?php echo $username; ?>'/>
</div> 
<div class="stcommenttext">
<a class="stcommentdelete" href="#" id='<?php echo $com_id; ?>'></a>
<b><a href="<?php echo $base_url.$username; ?>"><?php echo $username; ?></a></b> <?php echo clear($comment); ?>
<div class="stcommenttime" title="<?php echo $mtime; ?>"></div> 
</div>
</div>
<?php
}
}
?>
