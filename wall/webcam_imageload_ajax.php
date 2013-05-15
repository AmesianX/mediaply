 <?php
 //Srinivas Tamada http://9lessons.info
//Load latest update 
error_reporting(0);
$path = '..';
include_once 'ft/_common.php';
include_once 'includes/db.php';
include_once 'includes/Wall_Updates.php';
include_once 'includes/tolink.php';
include_once 'includes/time_stamp.php';
include_once 'session.php';
$Wall = new Wall_Updates();
if(isSet($_POST['webcam']))
{
$newdata=$Wall->Get_Upload_Image($uid,0);
echo "<img src='uploads/".$newdata['image_path']."'  class='webcam_preview' id='".$newdata['id']."'/>";
}
?>
