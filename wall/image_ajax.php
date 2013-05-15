<?php

error_reporting(0);
$path = '..';
include_once 'ft/_common.php';
include_once 'includes/db.php';
include_once 'includes/Wall_Updates.php';
include_once 'session.php';
$Wall = new Wall_Updates();


function getExtension($str) 
{

         $i = strrpos($str,".");
         if (!$i) { return ""; } 

         $l = strlen($str) - $i;
         $ext = substr($str,$i+1,$l);
         return $ext;
 }

$valid_formats = array("jpg", "png", "gif", "bmp","jpeg","PNG","JPG","JPEG","GIF","BMP");
	if(isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST")
		{
			$name = $_FILES['photoimg']['name'];
			$size = $_FILES['photoimg']['size'];
			
			if(strlen($name))
				{
					 $ext = getExtension($name);
					if(in_array($ext,$valid_formats))
					{
					if($size<(1024*1024))
						{
							$actual_image_name = time().$uid.".".$ext;
							$tmp = $_FILES['photoimg']['tmp_name'];
							if(move_uploaded_file($tmp, $path.$actual_image_name))
								{
								    $data=$Wall->Image_Upload($uid,$actual_image_name);
									 $newdata=$Wall->Get_Upload_Image($uid,$actual_image_name);
									 if($newdata)
									{
								//echo '<img src="data:image/jpg;base64,'.$newdata['image_base'].'" class="preview" id="'.$newdata['id'].'"/>';
								echo "<img src='uploads/".$actual_image_name."'  class='preview' id='".$newdata['id']."'/>";
									}
								}
							else
								echo "failed";
						}
						else
						echo "Image file size max 1 MB";					
						}
						else
						echo "Invalid file format.";	
				}
				
			else
				echo "Please select image..!";
				
			exit;
		}
?>