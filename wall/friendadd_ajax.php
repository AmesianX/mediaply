<?php
 //Srinivas Tamada http://9lessons.info
//Load latest comment 
error_reporting(0);
$path = '..';
include_once 'ft/_common.php';
include_once 'includes/db.php';
include_once 'includes/Wall_Updates.php';
include_once 'session.php';
$Wall = new Wall_Updates();

if(isSet($_POST['fid']))
{
$fid=$_POST['fid'];
$cdata=$Wall->Add_Friend($uid,$fid);
echo $cdata;
}
?>
