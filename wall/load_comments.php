<?php
//Srinivas Tamada http://9lessons.info
//Loading Comments link with load_updates.php 
 $commentsarray=$Wall->Comments($msg_id,0);
 
 if($x)
 {
 $comment_count=count($commentsarray);
$second_count=$comment_count-2;
if($comment_count>2)
{
?>
<div class="comment_ui" id="view<?php echo $msg_id; ?>">
<a href="#" class="view_comments" id="<?php echo $msg_id; ?>" vi='<?php echo $comment_count; ?>'>View all <?php echo $comment_count; ?> comments</a>
</div>
<?php
$commentsarray=$Wall->Comments($msg_id,$second_count);
}
}
if($commentsarray)
{
foreach($commentsarray as $cdata)
 {
 $com_id=$cdata['com_id'];
 $comment=tolink(htmlcode($cdata['comment'] ));
  $time=$cdata['created'];
$mtime=date("c", $time);
   $username=$cdata['username'];
  $com_uid=$cdata['uid_fk'];
 // User Avatar
 if($gravatar)
 $cface=$Wall->Gravatar($com_uid);
 else
 $cface=$Wall->Profile_Pic($com_uid);
  // End Avatar
 ?>
<div class="stcommentbody" id="stcommentbody<?php echo $com_id; ?>">
<div class="stcommentimg">
<img src="<?php echo $cface; ?>" class='small_face' alt='<?php echo $username; ?>'/>
</div> 
<div class="stcommenttext">
<?php if($uid==$com_uid || $uid==$msg_uid ){ ?>
<a class="stcommentdelete" href="#" id='<?php echo $com_id; ?>' title='Delete Comment'></a>
<?php } ?>
<b><a href="<?php echo $base_url.$username; ?>"><?php echo $username; ?></a></b> <?php echo clear($comment); ?>
<div class="stcommenttime" title="<?php echo $mtime; ?>"></div> 
</div>
</div>
<?php 
}
}
?>