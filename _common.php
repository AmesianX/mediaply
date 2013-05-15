<?
if( !get_magic_quotes_gpc() )
{
	if( is_array($_GET) )
	{
		while( list($k, $v) = each($_GET) )
		{
			if( is_array($_GET[$k]) )
			{
				while( list($k2, $v2) = each($_GET[$k]) )
				{
					$_GET[$k][$k2] = addslashes($v2);
				}
				@reset($_GET[$k]);
			}
			else
			{
				$_GET[$k] = addslashes($v);
			}
		}
		@reset($_GET);
	}

	if( is_array($_POST) )
	{
		while( list($k, $v) = each($_POST) )
		{
			if( is_array($_POST[$k]) )
			{
				while( list($k2, $v2) = each($_POST[$k]) )
				{
					$_POST[$k][$k2] = addslashes($v2);
				}
				@reset($_POST[$k]);
			}
			else
			{
				$_POST[$k] = addslashes($v);
			}
		}
		@reset($_POST);
	}

	if( is_array($_COOKIE) )
	{
		while( list($k, $v) = each($_COOKIE) )
		{
			if( is_array($_COOKIE[$k]) )
			{
				while( list($k2, $v2) = each($_COOKIE[$k]) )
				{
					$_COOKIE[$k][$k2] = addslashes($v2);
				}
				@reset($_COOKIE[$k]);
			}
			else
			{
				$_COOKIE[$k] = addslashes($v);
			}
		}
		@reset($_COOKIE);
	}
}

function xss_filter($content){ //xss ..
	 $content = preg_replace('/(<)(|\/)(\!|\?|html|head|title|meta|body|script|style|base|noscript|
	  form|input|select|option|optgroup|textarea|button|label|fieldset|legend|iframe|embed|object|param|
	  frameset|frame|noframes|basefont|applet| isindex|xmp|plaintext|listing|bgsound|marquee|blink|
	  noembed|comment|xml)/i', '&lt;$3', $content);
	 
	 $content = preg_replace_callback("/([^a-z])(o)(n)/i", 
	  create_function('$matches', 'if($matches[2]=="o") $matches[2] = "&#111;";
	  else $matches[2] = "&#79;"; return $matches[1].$matches[2].$matches[3];'), $content);
 
	return $content;
}

$ft['timestamp'] = date('U');
$ft['datetime'] = date('Y-m-d H:i:s', $ft['timestamp']);
$ft['date'] = date('Y-m-d', $ft['timestamp']);
$ft['time'] = date('H:i:s', $ft['timestamp']);

$ft['year'] = date('Y' , $ft['timestamp']);
$ft['month'] = date('m' , $ft['timestamp']);

$ft['path'] = $path;
$ft['ajax_path'] = $ft['path'].'/ajax';
$ft['img_path'] = $ft['path'].'/image';
$ft['op_path'] = $ft['path'].'/operation';
$ft['wall_path'] = $ft['path'].'/wall';

$ft['adm_path'] = $ft['path'].'/admin';
$ft['adm_img_path'] = $ft['adm_path'].'/image';
$ft['adm_op_path'] = $ft['adm_path'].'/operation';

$file_dir_y = '/mediaply/music/upload/track_file/'.$ft['year'];
$file_dir_m = '/mediaply/music/upload/track_file/'.$ft['year'].'/'.$ft['month'];
$ft['upload'] = '/mediaply/music/upload/track_file/';

require($ft['path'].'/lib/basic.php');

require($ft['path'].'/_db_conn.php');

require($ft['path'].'/_default.php');

header('Content-Type: text/html; charset=utf-8'); 
$config = mysql_fetch_assoc(mysql_query('SELECT * FROM `ft_config`'));
?>
