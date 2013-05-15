<?php
/*
UploadiFive
Copyright (c) 2012 Reactive Apps, Ronnie Garcia
*/

$path = '..';
require($path.'/_common.php');
$track = mysql_fetch_assoc(mysql_query('SELECT track_file FROM `ft_track` WHERE `tid`='.$_GET['tid'].';'));

// Define a destination
$targetFolder = '/upload/track_file/'; // Relative to the root and should match the upload folder in the uploader script
$checkFile = $targetFolder . $track['track_file'];
//if (file_exists($_SERVER['DOCUMENT_ROOT'] . $targetFolder . '/' . $_POST['filename'])) {
if (file_exists($checkFile)) {
        @unlink($checkFile);
	//echo 1;
} else {
	echo 0;
}
?>
