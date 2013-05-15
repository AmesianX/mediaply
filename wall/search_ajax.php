 <?php
 //Srinivas Tamada http://9lessons.info
//Load latest update 
error_reporting(0);
$path = '..';
include_once 'ft/_common.php';
include_once 'includes/db.php';
include_once 'includes/Wall_Updates.php';
include_once 'session.php';
$sWall = new Wall_Updates();

if(isSet($_POST['searchword']))
{
$searchword=$_POST['searchword'];
$updatesarray=$sWall->User_Search($searchword);

if($updatesarray)
{
foreach($updatesarray as $data)
{
$suname=$data['username'];
$suid=$data['uid'];
// User Avatar
if($gravatar)
$face=$sWall->Gravatar($suid);
else
$face=$sWall->Profile_Pic($suid);
?>
<div class="display_box" align="left">
<a href='<?php echo $base_url.$suname ?>' style='display:block'>
<img src="<?php echo $face; ?>?d=mm&s=30" class='search_face'/>
<?php echo $suname; ?>&nbsp;<br/>
</a>
</div>
<?php
}
}

}
?>

