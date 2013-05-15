
 <?php
 //Srinivas Tamada http://9lessons.info
//Load latest comment 
error_reporting(0);
$path = '..';
include_once 'ft/_common.php';
include_once 'includes/db.php';
include_once 'includes/Wall_Updates.php';
include_once 'includes/tolink.php';
include_once 'includes/htmlcode.php';
include_once 'includes/textlink.php';
include_once 'includes/Expand_URL.php';
include_once 'includes/time_stamp.php';
include_once 'session.php';

$Wall = new Wall_Updates();
if(isSet($_POST['lastid']))
{
$lastid=mysql_real_escape_string($_POST['lastid']);
$profile_uid=mysql_real_escape_string($_POST['profile_uid']);
include('timeline_load_messages.php');
}
?>
