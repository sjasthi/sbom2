<div id="menu-left">
    <a href="releases_releases_list.php">
        <div <?php if ($left_selected == "RELEASESLIST") {
            echo 'class="menu-left-current-page"';
        } ?>>
            <img src="./images/releases.png">
            <br/>Releases List<br/></div>
    </a>
    <a href="releases_releases_gantt.php">
        <div <?php if ($left_selected == "RELEASESGANTT") {
            echo 'class="menu-left-current-page"';
        } ?>>
            <img src="./images/gantt.png">
            <br/>Releases Gantt<br/></div>
    </a>
</div>
