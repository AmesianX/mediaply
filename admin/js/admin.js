
var content_height = 0;
var left_height = 0;
var cal_height = 0;
var left_array = new Array();

$(document).ready(function(){
	content_height = parseInt($('#content').css('height')) + parseInt($('#right_title').css('height')) + 58;
	left_height = parseInt($('#left_container').css('height'));
	cal_height = parseInt($('#left_menu').css('height'));

	if (content_height > left_height) {
		$('#left_container').css('height', content_height);
		left_height = content_height;
	}

	for (i=0; i<$('.left_sub').length; i++) {
		$('.left_sub').eq(i).show();
		left_array[$('.left_sub').eq(i).attr('id')] = parseInt($('.left_sub').eq(i).css('height'));
		$('.left_sub').eq(i).hide();
	}
});

function sub(id) {
	if ($('#btn_'+id).attr('alt')=='submenu open') {
		$('#left_'+id).css('background', 'url('+path+'/admin/image/bg_left_active.png)');
		$('#btn_'+id).attr('src', path+'/admin/image/btn_left_minus.png');
		$('#btn_'+id).attr('alt', 'submenu close');
		$('#sub_'+id).slideDown();
		cal_height += left_array['sub_'+id] + 20;
	} else if ($('#btn_'+id).attr('alt')=='submenu close') {
		$('#left_'+id).css('background', 'url('+path+'/admin/image/bg_left.png)');
		$('#btn_'+id).attr('src', path+'/admin/image/btn_left_plus.png');
		$('#btn_'+id).attr('alt', 'submenu open');
		cal_height -= left_array['sub_'+id] + 20;
		$('#sub_'+id).slideUp();
	}

	if (cal_height >= left_height) $('#left_container').animate({height : cal_height});
	else if (cal_height < left_height) $('#left_container').animate({height : left_height});
}
