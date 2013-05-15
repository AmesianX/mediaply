<?
$path = '..';

require($path.'/_common.php');

$notice = mysql_fetch_assoc(mysql_query('SELECT * FROM `ft_notice` ORDER BY `id` DESC LIMIT 0, 1;'));
?>

<script type="text/javascript">
$(document).ready(function(){
	ajax_page_load('right_artist', 'right_artist');
	ajax_page_load('right_comment', 'right_comment');
});
</script>

<div class="content_row w233">
	<span class="fleft w100per limit_text align_left btn" onclick="ajax_page_load('left_content', 'notice_view', '&id=<?=$notice['id']?>');"><?=$notice['subject']?></span>
</div>

<div class="h_line"></div>

<div class="content_row w233" id="right_artist_container">
	<div id="right_artist"></div>
</div>

<div class="h_line"></div>

<div class="content_row w233" id="right_comment_container">
	<div id="right_comment"></div>
</div>

<div class="h_line"></div>

<div class="content_row w233">
	<!--<div class="clear"><a href="http://bsent.co.kr/" target="_blank"><img src="<?=$ft['img_path']?>/ban_01.gif" alt="banner" /></a></div>-->
	<div class="clear mt10"><a href="http://www.386fm.net/" target="_blank"><img src="<?=$ft['img_path']?>/ban_02.gif" alt="banner" /></a></div>
</div>
