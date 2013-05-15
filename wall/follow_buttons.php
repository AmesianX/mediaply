<span class="follow">
<?php 
$friend_status=$Wall->Friends_Check($user['uid'],$profile_uid);
$friend_check=$Wall->Friends_Check_Count($user['uid'],$profile_uid);
if($friend_check=='0')
{
?>
<a href="#"  class='fplain-menu add-box addbutton' id='add<?php echo $profile_uid; ?>' p='1'>Follow</a>
<a href="#"  class='fplain-menu rm-box removebutton'  id='remove<?php echo $profile_uid; ?>' style="display:none" p='1'>Following</a>
<?php
}
else if($friend_status=='me')
{
echo '<b>You!</b>';
}
else if($friend_status=='fri')
{
?>
<a href="#"  class='fplain-menu rm-box removebutton'  id='remove<?php echo $profile_uid; ?>' p='1'>Following</a>
<a href="#"  class='fplain-menu add-box addbutton'  id='add<?php echo $profile_uid; ?>' style="display:none" p='1'>Follow</a>
<?php } ?>
</span>