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

$ft['timestamp'] = date('U');
$ft['datetime'] = date('Y-m-d H:i:s', $ft['timestamp']);
$ft['date'] = date('Y-m-d', $ft['timestamp']);
$ft['time'] = date('H:i:s', $ft['timestamp']);

$ft['path'] = $path;
$ft['ajax_path'] = $ft['path'].'/ajax';
$ft['img_path'] = $ft['path'].'/image';
$ft['op_path'] = $ft['path'].'/operation';
$ft['wall_path'] = $ft['path'].'/wall';

$ft['adm_path'] = $ft['path'].'/admin';
$ft['adm_img_path'] = $ft['img_path'].'/admin';

require($ft['path'].'/lib/basic.php');

header('Content-Type: text/html; charset=utf-8');
?>
