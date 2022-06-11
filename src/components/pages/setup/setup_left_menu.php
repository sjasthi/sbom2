<div class="wrap">
	<div id="menu-left">
		<a href="setup_system_preference.php">
			<div <?php if(isset($left_selected) && $left_selected == "SYSPREFERENCES")
			{ echo 'class="menu-left-current-page"'; } ?>>
				<img src="../../../assets/images/image3.png">
				<br/>System Preferences<br/>
			</div>
		</a>

		<a href="setup_user_preference.php">
			<div <?php if(isset($left_selected) && $left_selected == "USERPREFERENCES")
			{ echo 'class="menu-left-current-page"'; } ?>>
				<img src="../../../assets/images/image25.png">
				<br/>User Preferences<br/>
			</div>
		</a>
	</div>
</div>
