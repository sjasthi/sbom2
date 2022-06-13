
<div class="wrap">
	<div id="menu-left">
		<a href="<?php echo checkSelectedLeftMenuLink( "SYSPREFERENCES", "setup_system_preference.php" ); ?>">
			<div <?php if(isset($left_selected) && $left_selected == "SYSPREFERENCES")
			{ echo 'class="menu-left-current-page"'; } ?>>
                <?php include $assetsPath."svg/systemGear.svg"; ?>
				<p> System </p>
				<p> Preferences </p>
			</div>
		</a>

		<a href="<?php echo checkSelectedLeftMenuLink( "USERPREFERENCES", "setup_user_preference.php" ); ?>">
			<div <?php if(isset($left_selected) && $left_selected == "USERPREFERENCES")
			{ echo 'class="menu-left-current-page"'; } ?>>
                <?php include $assetsPath."svg/user.svg"; ?>
				<p> User </p>
				<p> Preferences </p>
			</div>
		</a>
	</div>
</div>
