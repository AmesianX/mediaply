<?php

$path = '.';

require($path.'/_common.php');

$track = mysql_fetch_assoc(mysql_query('SELECT * FROM `ft_track` WHERE `tid`='.$_GET['tid'].';'));
$paid_data = mysql_fetch_assoc(mysql_query('SELECT * FROM `ft_paid` WHERE `uid_fk`='.$user['uid'].' AND `tid_fk`='.$track['tid'].';'));


$uploadDir = '/upload/track_file/';

        $file_name = $track['trackname'].'.mp3';
        $file_ref = $uploadDir . $track['track_file'];

set_time_limit(0);
//digitally-imported.fm electro-house mp3 stream. Please bare with me.
//define('SRC_URL', 'http://scfire-ntc-aa03.stream.aol.com:80/stream/1025');
$strContext=stream_context_create(
    array(
      'http'=>array(
        'method'=>'GET',
        'header'=>"Accept-language: en\r\n"
      )
    )
  );
$fpOrigin=fopen($file_ref, 'rb', false, $strContext); //open a binary compatible stream
header('content-type: application/octet-stream');   //setup the current user session
while(!feof($fpOrigin)){
  $buffer=fread($fpOrigin, 4096); //we read chunks of 4096 bytes
  echo $buffer; //And we send them back to the current user
  flush();  //we try to flush the output buffer, in case there is a deflated or gzipped transfert betweenm the web server and the client
}
fclose($fpOrigin);
?>
