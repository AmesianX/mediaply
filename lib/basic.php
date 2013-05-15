<?
function set_cookie($name, $value, $expire) {
	setcookie(md5($name), base64_encode($value), time()+$expire, '/');
}

function get_cookie($name) {
	return base64_decode($_COOKIE[md5($name)]);
}

function mysql_password($value) {
    $result = mysql_fetch_assoc(mysql_query('SELECT PASSWORD("'.$value.'") AS `pass`;'));
    return $result['pass'];
}

function self_close() {
	echo '<script type="text/javascript">self.close();</script>';
}

function alert($msg) {
	echo '<script type="text/javascript">alert("'.$msg.'");</script>';
}

function location_reload() {
	echo '<script type="text/javascript">location.reload();</script>';
}

function location_href($url) {
	echo '<script type="text/javascript">location.href("'.$url.'");</script>';
}

function location_replace($url) {
	echo '<script type="text/javascript">location.replace("'.$url.'");</script>';
}

function history_back($num=0) {
	echo '<script type="text/javascript">history.back('.$num.');</script>';
}

function get_paging($p_num, $total_page, $url, $p_scale=10) {
	$str = '';

	if ($p_num > 1) $str .= '&nbsp;<a href="'.$url.'1">처음</a>&nbsp;';

	$start_page = (((int)(($p_num - 1) / $p_scale)) * $p_scale) + 1;
	$end_page = $start_page + $p_scale - 1;

	if ($end_page >= $total_page) $end_page = $total_page;

	if ($start_page > 1) $str .= '&nbsp;<a href="'.$url.($start_page-1).'">이전</a>&nbsp;';

	if ($total_page > 1) {
		for ($k=$start_page; $k<=$end_page; $k++) {
			if ($p_num != $k) $str .= '&nbsp;<a href="'.$url.$k.'"><span>'.$k.'</span></a>&nbsp;';
			else $str .= '&nbsp;<b>'.$k.'</b>&nbsp;';
		}
	}

	if ($total_page > $end_page) $str .= '&nbsp;<a href="'.$url.($end_page+1).'">다음</a>&nbsp;';

	if ($p_num < $total_page) $str .= '&nbsp;<a href="'.$url.$total_page.'">맨끝</a>&nbsp;';

	return $str;
}
?>