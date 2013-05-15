<script type="text/javascript">
$('.addbutton').live('click', function(){
	var vid = $(this).attr("id");
	var sid = vid.split("add"); 
	var ID = sid[1];
	var dataString = 'fid='+ID ;

	$.ajax({
		type: "POST",
		url: "<?=$ft['wall_path']?>/friendadd_ajax.php",
		data: dataString,
		cache: false,
		success: function(html){
			location.reload();
		}
	});

	return false;
});

$('.removebutton').live('click', function(){
	var vid = $(this).attr("id");
	var sid = vid.split("remove"); 
	var ID = sid[1];
	var dataString = 'fid='+ID ;

	$.ajax({
		type: "POST",
		url: "<?=$ft['wall_path']?>/friendremove_ajax.php",
		data: dataString,
		cache: false,
		success: function(html) {	
			location.reload();
		}
	});

	return false;
});
</script>

<?
$updatesarray = $Wall -> Friends_List_Limitless($profile['uid']);

if ($updatesarray) {
	foreach ($updatesarray as $data) {
		$friend_uid = $data['uid'];

		$friend_username = $data['username'];
		if ($gravatar)
			$face = $Wall -> Gravatar($friend_uid);
		else
			$face = $Wall -> Profile_Pic($friend_uid);
?>
		<div class="clear" style="height:5px;"></div>
		<div class="clear pr15">
			<a href="<?=$face?>" rel="facebox"><img src="<?=$face?>" class='fleft ml15' alt='<?=$friend_username?>' style="width:50px; height:50px;" /></a><b><a href="<?=$base_url.$friend_username?>" class="fleft ml5 mt15"><?=ucfirst($friend_username)?></a></b>
			<?php 
			$profile_uid=$friend_uid;
			include($ft['wall_path'].'/follow_buttons.php');
			?>
		</div>
<?
	}
} else {
	echo '<div class="clear" style="height:5px;"></div><h4>No friends added</h4>';
}
?>
