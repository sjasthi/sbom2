<div id="nav">
    <ul>
        <?php
            $imgPath = '';
            $pagePath = '';

            if( !isset( $nav_selected ) ) { // pages are separate from the index, so this is needed..
                $nav_selected = '';
                $imgPath = 'src/';
                $pagePath = 'src/components/pages/';

                // LOGO from SRC
                echo '
                    <a href="index.php">
                        <li class="horozontal-li-logo">
                            <img src="'.$imgPath.'assets/images/sbom_main.png">
                            <p> Software BOM </p>
                        </li>
                    </a>';
            } else {
                $imgPath = '../../../';
                $pagePath = '../';

                // LOGO from PAGES
                echo '
                    <a href="../../../../index.php">
                        <li class="horozontal-li-logo">
                            <img src="'.$imgPath.'assets/images/sbom_main.png">
                            <p> Software BOM </p>
                        </li>
                    </a>';
            }
        ?>

        <span class="links">
            <?php
                function checkSelectedTab( $tab, $nav_selected ) {
                    // if the tab you selected matches the page
                    if( isset( $nav_selected ) && $tab === $nav_selected ) {
                        return 'class="current-page"';
                    }

                    return '';
                }

                $class = checkSelectedTab( "RELEASES", $nav_selected );
                echo '
                    <a href="'.$pagePath.'releases/releases_releases_list.php">
                        <li '.$class.'>
                            <img src="'.$imgPath.'assets/images/list.png">
                            <p> Releases </p>
                        </li>
                    </a>';
                
                $class = checkSelectedTab( "APPLICATIONS", $nav_selected );
                echo '
                    <a href="'.$pagePath.'applications/applications_page.php">
                        <li '.$class.'>
                            <img src="'.$imgPath.'assets/images/apps.png">
                            <p> Applications </p>
                        </li>
                    </a>';

                $class = checkSelectedTab( "BOM", $nav_selected );
                echo '
                <a href="'.$pagePath.'bom/bom_sbom_list.php">
                    <li '.$class.'>
                        <img src="'.$imgPath.'assets/images/sbom_list.png">
                        <p> BOM List </p>
                    </li>
                </a>';

                $class = checkSelectedTab( "SETUP", $nav_selected );
                echo '
                <a href="'.$pagePath.'setup/setup_system_preference.php">
                    <li '.$class.'>
                        <img src="'.$imgPath.'assets/images/setup.png">
                        <p> Setup </p>
                    </li>
                </a>';

                $class = checkSelectedTab( "LOGIN", $nav_selected );
                if( isset( $_SESSION['login_user'] ) ) {
                    echo '
                        <a href="'.$pagePath.'login/logout.php">
                            <li>
                                <img src="'.$imgPath.'assets/images/login.png">
                                <p> logout </p>
                            </li>
                        </a>';
                } else {
                    echo '
                        <a href="'.$pagePath.'login/login.php">
                            <li '.$class.'> 
                                <img src="'.$imgPath.'assets/images/login.png">
                                <p> login </p>
                            </li>
                        </a>';
                }
            ?>

            <!--
                // OLD FILES THAT CAN BE USED LATER..
                
                <a href="bom_sbom_tree.php">
                    <li <?php if($nav_selected == "BOM"){ echo 'class="current-page"'; } ?>>
                        <img src="src/assets/images/bom_tree.png">
                        <br />BOM Tree
                    </li>
                </a>

                <a href="sla_payload.php">
                    <li <?php if($nav_selected == "BOM"){ echo 'class="current-page"'; } ?>>
                        <img src="src/assets/images/sla_payload.png">
                        <br />SLA Payload
                    </li>
                </a>

                <a href="reports.php">
                    <li <?php if($nav_selected == "BOM"){ echo 'class="current-page"'; } ?>>
                        <img src="src/assets/images/reports.png">
                        <br />Reports
                    </li>
                </a>

                <a href="ownership.php">
                    <li <?php if($nav_selected == "BOM"){ echo 'class="current-page"'; } ?>>
                        <img src="src/assets/images/ownership.png">
                        <br />Ownership
                    </li>
                </a>

                <a href="help.php">
                    <li <?php if($nav_selected == "HELP"){ echo 'class="current-page"'; } ?>>
                    <img src="./images/help.png">
                    <br/>help</li>
                </a>
            -->
        </span>
    </ul>
</div>
