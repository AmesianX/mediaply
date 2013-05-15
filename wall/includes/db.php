<?php
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'tmdcjs132$');
define('DB_DATABASE', 'mediaply_music');
$connection = mysql_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD) or die(mysql_error());
$database = mysql_select_db(DB_DATABASE) or die(mysql_error());
mysql_query ("set character_set_results='utf8'");   
$path = "uploads/";
$perpage=10; // Updates perpage
$base_url='http://music.mediaply.co.kr/wall/';
$gravatar=0; // 0 false 1 true gravatar image
$rowsPerPage=10; //friends list
?>
