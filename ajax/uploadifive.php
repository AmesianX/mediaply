<?php
/*
UploadiFive
Copyright (c) 2012 Reactive Apps, Ronnie Garcia
*/
$path = '..';
require($path.'/_common.php');

// Set the uplaod directory
//$uploadDir = '/upload/track_file/';
$uploadDir = $ft['upload'].$ft['year'].'/'.$ft['month'].'/';
// Set the allowed file extensions
$fileTypes = array('jpg', 'jpeg', 'gif', 'png', 'mp3'); // Allowed file extensions

$verifyToken = md5('unique_salt' . $_POST['timestamp']);

if (!empty($_FILES) && $_POST['token'] == $verifyToken) {

                if(!is_dir($file_dir_y))
                {
                  @mkdir($file_dir_y,0766);
                }
                if(!is_dir($file_dir_m))
                {
                  @mkdir($file_dir_m,0766);
                }
	$tempFile   = $_FILES['Filedata']['tmp_name'];
	//$uploadDir  = $_SERVER['DOCUMENT_ROOT'] . $uploadDir;
        $uploadDir = $uploadDir . $_GET['timestamp'] . '_';
	$targetFile = $uploadDir . $_FILES['Filedata']['name'];

	// Validate the filetype
	$fileParts = pathinfo($_FILES['Filedata']['name']);
	if (in_array(strtolower($fileParts['extension']), $fileTypes)) {

		// Save the file
		move_uploaded_file($tempFile, $targetFile);
		echo 1;

	} else {

		// The file type wasn't allowed
		echo 'Invalid file type.';

	}
}
?>
