
</div>

</div>

<div id="friend_div">
	<div class="fleft ml15 bold">내친구목록</div>
	<?
	$updatesarray = $Wall -> Friends_List_Limitless($user['uid']);

	if ($updatesarray) {
		foreach ($updatesarray as $data) {
			$friend_uid = $data['uid'];

			$friend_username = $data['username'];
			if ($gravatar)
				$face = $Wall -> Gravatar($friend_uid);
			else
				$face = $Wall -> Profile_Pic($friend_uid);
	?>
			<div class="clear pt5">
				<a href="<?=$face?>" rel="facebox"><img src="<?=$face?>" class="right_friends_pic fleft ml15" alt="<?=$friend_username?>" /></a><b><a href="<?=$base_url.$friend_username?>" class="fleft ml5 mt5"><?=ucfirst($friend_username)?></a></b>
			</div>
	<?
		}
	} else {
		echo '<div class="clear pt5"></div><h4>No friends added</h4>';
	}
	?>
</div>
