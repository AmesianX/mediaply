 <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
 <?php
 //Srinivas Tamada http://9lessons.info
//Load latest comment 
error_reporting(0);
$path = '..';
include_once 'ft/_common.php';
include_once 'includes/tolink.php';
include_once 'includes/textlink.php';
include_once 'includes/htmlcode.php';
include_once 'includes/time_stamp.php';


if(isSet($_POST['comment']))
{
$comment=mysql_real_escape_string($_POST['comment']);

$msg_id=$_POST['msg_id'];

if(1)
{
$com_id=time();
 $comment=tolink(htmlentities($comment));
 $time=time();
 $username="Srinivas";
 $uid=1;
 $cface='http://www.gravatar.com/avatar.php?gravatar_id=7a9e87053519e0e7a21bb69d1deb6dfe';
 ?>
<div class="stcommentbody" id="stcommentbody<?php echo $com_id; ?>">
<div class="stcommentimg">
<img src="<?php echo $cface; ?>" class='small_face' alt='<?php echo $username; ?>'/>
</div> 
<div class="stcommenttext">
<a class="stcommentdelete" href="#" id='<?php echo $com_id; ?>'></a>
<b><a href="<?php echo $base_url.$username; ?>"><?php echo $username; ?></a></b> <?php echo clear($comment); ?>
<div class="stcommenttime"><?php time_stamp($time); ?></div> 
</div>
</div>
<?php
}
}
?>
