<?php
ob_start("ob_gzhandler");
error_reporting(0);
$path = '..';
include_once 'ft/_common.php';
include_once 'includes/db.php';
include_once 'includes/Wall_Updates.php';
include_once 'includes/tolink.php';
include_once 'includes/textlink.php';
include_once 'includes/htmlcode.php';
include_once 'includes/Expand_URL.php';
include_once 'includes/time_stamp.php';
include_once 'session.php';

$Wall = new Wall_Updates();

if($_GET['username'])
{
$username=$_GET['username'];
$profile_uid=$Wall->User_ID($username);


//User Avatar
 if($gravatar)
 $face=$Wall->Gravatar($profile_uid);
 else
 $face=$Wall->Profile_Pic($profile_uid);
// End Avatar

$UserDetails=$Wall->User_Details($profile_uid);
$friend_count=$UserDetails['friend_count'];
if(empty($profile_uid))
{
header('Location:404.php');
}
}
else
{
header('Location:404.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Facebook Timeline Design with jquery and CSS</title>
<head>
<link href="<?php echo $base_url; ?>css/timeline.css" rel="stylesheet" type="text/css">
</head>
<body>
 <div id="containertop" >
 <div id='profile' style='margin:10px;height:100px'>
 <img src='<?php echo $face; ?>&s=100' style='border:solid 2px #cc0000;float:left;' alt='<?php echo $username; ?>'/>
 <h1 style='margin-left:120px'><?php echo ucfirst($username); ?>'s Timeline</h1>
<h2 style='margin-left:120px'><?php echo $friend_count; ?> Friends </h2>
 <h4 style='margin-left:120px'></h4>

 </div>

</div>
<div id="container">
<div class="timeline_container">
<div class="timeline">
<div class="plus"></div>
</div>
</div>
<div>


<?php include("timeline_load_messages.php"); ?>

	  
<div id="popup" class='shade'>
<div class="Popup_rightCorner" >	</div>
<div id='box'>
<b>What's Up?</b><br/>
<textarea id='update'></textarea>
<input type='submit' value=' Update ' id='update_button'/>
</div>
</div>
</div>
	
</div>
<script type="text/javascript" src="<?php echo $base_url; ?>js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo $base_url; ?>js/jquery.masonry.min.js"></script>
<script type="text/javascript" src="<?php echo $base_url; ?>js/jquery.livequery.js"></script>
<script type="text/javascript" src="<?php echo $base_url; ?>js/jquery.timeago.js"></script>
<script type="text/javascript">
$(function(){
function Arrow_Points()
{ 
var s = $('#container').find('.item');
$.each(s,function(i,obj){
var posLeft = $(obj).css("left");
$(obj).addClass('borderclass');
if(posLeft == "0px")
{
html = "<span class='rightCorner'></span>";
$(obj).prepend(html);			
}
else
{
html = "<span class='leftCorner'></span>";
$(obj).prepend(html);
}
});
}



$('.timeline_container').mousemove(function(e)
{
var topdiv=$("#containertop").height();
var pag= e.pageY - topdiv-26;
$('.plus').css({"top":pag +"px", "background":"url('<?php echo $base_url; ?>images/plus.png')","margin-left":"1px"});}).
mouseout(function()
{
$('.plus').css({"background":"url('')"});
});
	
	
				
$("#update_button").live('click',function()
{


var updateval = $("#update").val();

var dataString = 'update='+ updateval;
if($.trim(updateval).length==0)
{
alert("Please Enter Some Text");
}
else
{
$.ajax({
type: "POST",
url: "<?php echo $base_url; ?>timeline_message_ajax.php",
data: dataString,
cache: false,
success: function(html)
{
$("#container").prepend(html);

//Reload masonry
$('#container').masonry( 'reload' );

$('.rightCorner').hide();
$('.leftCorner').hide();
Arrow_Points();

$("#update").val('');
$("#popup").hide();


}
});
$("#preview").html();
$('#imageupload').slideUp('fast');
}
return false;





});

// Divs
$('#container').masonry({
	
 	singleMode: false,
	        itemSelector: '.item',
	        animate: true
	    });
Arrow_Points();
  
//Mouseup textarea false
$("#popup").mouseup(function() 
{
return false
});
 
<?php if($uid==$profile_uid) { ?>  

$(".timeline_container").click(function(e)
{
var topdiv=$("#containertop").height();
$("#popup").css({'top':(e.pageY-topdiv-33)+'px'});
$("#popup").fadeIn();
$("#update").focus();

	
});  
<?php } ?>

$(".deletebox").live('click',function()
{

	var ID = $(this).attr("id");
	var dataString = 'msg_id='+ ID;

	if(confirm("Sure you want to delete this update? There is NO undo!"))
	{

	$.ajax({
	type: "POST",
	url: "<?php echo $base_url; ?>delete_message_ajax.php",
	data: dataString,
	cache: false,
	success: function(html){
	$("#item"+ID).fadeOut(300,function(){$(this).parent().remove();});  
	//Remove item
	$('#container').masonry( 'remove',$("#item"+ID) );
	
	
	 }
	 });
	}
	
return false;
});


$(".stcommentdelete").live('click',function()
{

	var ID = $(this).attr("id");
	var dataString = 'com_id='+ ID;

	if(confirm("Sure you want to delete this comment? There is NO undo!"))
	{

	$.ajax({
	type: "POST",
	url: "<?php echo $base_url; ?>delete_comment_ajax.php",
	data: dataString,
	cache: false,
	success: function(html){
	$("#stcommentbody"+ID).fadeOut(300,function(){$("#stcommentbody"+ID).remove();}); 
	
		 }
	 });
	}
	
return false;
});



//Textarea without editing.
$(document).mouseup(function()
{
$('#popup').hide();

});

// View all comments
$(".view_comments").live("click",function()  
{
var ID = $(this).attr("id");
var V = $(this).attr("vi");


$.ajax({
type: "POST",
url: "<?php echo $base_url; ?>view_ajax.php",
data: "msg_id="+ ID, 
cache: false,
success: function(html){
$("#commentload"+ID).html(html);
//----
var b=$("#item"+ID);
var a=b.height();
b.animate({height: a}, 
function(){
$('#container').masonry();
$('.rightCorner').hide();
$('.leftCorner').hide();
Arrow_Points();
});
//---

}
});
return false;
});

function more_results()
{

var ID = $('.more:last').attr("id");
var profile_uid = $('#hidden').val();

if(ID)
{
$.ajax({
type: "POST",
url: "<?php echo $base_url; ?>timeline_moreupdates_ajax.php",
data: "lastid="+ ID +"&profile_uid="+profile_uid, 
cache: false,
beforeSend: function(){ $("#more"+ID).html('<img src="<?php echo $base_url; ?>icons/ajaxloader.gif" />'); },
success: function(html){
var $boxes = $(html);
$('#container').append( $boxes ).masonry( 'appended', $boxes );
Arrow_Points();
$("#more"+ID).remove();
}
});
}
else
{
$("#more").html('The End');// no results
}

//return false;
};


$(window).scroll(function(){
if ($(window).scrollTop() == $(document).height() - $(window).height()){
more_results();
}
});


// commentopen 
$('.commentopen').live("click",function() 
{
var ID = $(this).attr("id");
$("#commentbox"+ID).slideToggle('fast');

var b=$("#item"+ID);
var a=b.height();
if($("#commentbox"+ID).height() > 1)
{
var Z=a-65;	
	
}
else
{
var Z=a+65;		
	
}



b.animate({height: Z }, 
function(){
$('#container').masonry();
$('.rightCorner').hide();
$('.leftCorner').hide();
Arrow_Points();
});

return false;
});


//Commment Submit

$('.comment_button').live("click",function() 
{

var ID = $(this).attr("id");

var comment= $("#ctextarea"+ID).val();
var dataString = 'comment='+ comment + '&msg_id=' + ID;

if($.trim(comment).length==0)
{
alert("Please Enter Comment Text");
}
else
{
$.ajax({
type: "POST",
url: "<?php echo $base_url; ?>comment_ajax.php",
data: dataString,
cache: false,
success: function(html)
{
//----
var b=$("#item"+ID);
var a=b.height();

b.animate({height: a+60}, function()
{
$('#container').masonry();
$('.rightCorner').hide();
$('.leftCorner').hide();
Arrow_Points();
});
//----

$("#commentload"+ID).append(html);
$("#ctextarea"+ID).val('');
$("#ctextarea"+ID).focus();


 }
 });
}
return false;
});

  
});
</script>
<input type='hidden' value='<?php echo $profile_uid; ?>' id='hidden'/>
</body>
</html>