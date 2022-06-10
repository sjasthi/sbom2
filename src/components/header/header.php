<div id="nav">
    <ul>
        <?php
            if( !isset( $nav_selected ) ) { // pages are separate from the index, so this is needed..
                echo '
                    <a href="index.php">
                        <li class="horozontal-li-logo">
                            <img src="src/assets/images/sbom_main.png">
                            <p> Software BOM </p>
                        </li>
                    </a>';
            } else {
                echo '
                    <a href="../../../../index.php">
                        <li class="horozontal-li-logo">
                            <img src="../../../assets/images/sbom_main.png">
                            <p> Software BOM </p>
                        </li>
                    </a>';
            }
        ?>

        <span class="links">
            <?php
                function checkSelectedTab( $tab, $nav_selected ) {
                    if( isset( $nav_selected ) ){
                        if( $tab === $nav_selected ) {
                            return 'class="current-page"';
                        } else {
                            return '';
                        }
                    }
                }

                $class = '';
                if( !isset( $nav_selected ) ) { // If a page hasn't been selected use default paths..
                    echo '
                        <a href="src/components/pages/releases/releases_releases_list.php">
                            <li>
                                <img src="src/assets/images/list.png">
                                <p> Releases </p>
                            </li>
                        </a>';

                    echo '
                        <a href="src/components/pages/applications/applications_page.php">
                            <li>
                                <img src="src/assets/images/apps.png">
                                <p> Applications </p>
                            </li>
                        </a>';
                    
                    echo '
                        <a href="src/components/pages/bom/bom_sbom_list.php">
                            <li>
                                <img src="src/assets/images/sbom_list.png">
                                <p> BOM List </p>
                            </li>
                        </a>';

                    echo '
                        <a href="src/components/pages/setup/setup_system_preference.php">
                            <li>
                                <img src="src/assets/images/setup.png">
                                <p> Setup </p>
                            </li>
                        </a>';

                    if( isset( $_SESSION['login_user'] ) ) {
                        echo '
                            <a href="src/components/pages/login/logout.php">
                                <li>
                                    <img src="src/assets/images/login.png">
                                    <p> logout </p>
                                </li>
                            </a>';
                    } else {
                        if( isset( $nav_selected ) && $nav_selected == "LOGIN" ) {
                            echo '
                                <a href="src/components/pages/login/login.php">
                                    <li class="current-page"> 
                                        <img src="src/assets/images/login.png">
                                        <p> login </p>
                                    </li>
                                </a>';
                        } else {
                            echo '
                                <a href="src/components/pages/login/login.php">
                                    <li> 
                                        <img src="src/assets/images/login.png">
                                        <p> login </p>
                                    </li>
                                </a>';
                        }
                    }
    
                    if( isset( $_SESSION['admin'] ) ) {
                        echo '
                        <a href="src/components/pages/admin/admin_users.php">
                        <li>
                            <img src="src/assets/images/admin.png" />
                            <p> Admin </p>
                        </li>
                        </a>';
                    }
                } else { // if a page is selected, then the user needs different pathing back to index..
                    $class = checkSelectedTab( "RELEASES", $nav_selected );
                    echo '
                        <a href="../releases/releases_releases_list.php">
                            <li '.$class.'>
                                <img src="../../../assets/images/list.png">
                                <p> Releases </p>
                            </li>
                        </a>';
                    
                    $class = checkSelectedTab( "APPLICATIONS", $nav_selected );
                    echo '
                        <a href="../applications/applications_page.php">
                            <li '.$class.'>
                                <img src="../../../assets/images/apps.png">
                                <p> Applications </p>
                            </li>
                        </a>';

                    $class = checkSelectedTab( "BOM", $nav_selected );
                    echo '
                    <a href="../bom/bom_sbom_list.php">
                        <li '.$class.'>
                            <img src="../../../assets/images/sbom_list.png">
                            <p> BOM List </p>
                        </li>
                    </a>';

                    $class = checkSelectedTab( "SETUP", $nav_selected );
                    echo '
                    <a href="../setup/setup_system_preference.php">
                        <li '.$class.'>
                            <img src="../../../assets/images/setup.png">
                            <p> Setup </p>
                        </li>
                    </a>';

                    if( isset( $_SESSION['login_user'] ) ) {
                        echo '
                            <a href="../login/logout.php">
                                <li>
                                    <img src="../../../assets/images/login.png">
                                    <p> logout </p>
                                </li>
                            </a>';
                    } else {
                        if( isset( $nav_selected ) && $nav_selected == "LOGIN" ) {
                            echo '
                                <a href="../login/login.php">
                                    <li class="current-page"> 
                                        <img src="../../../assets/images/login.png">
                                        <p> login </p>
                                    </li>
                                </a>';
                        } else {
                            echo '
                                <a href="../login/login.php">
                                    <li> 
                                        <img src="../../../assets/images/login.png">
                                        <p> login </p>
                                    </li>
                                </a>';
                        }
                    }
                }
            ?>

            <!--
                <a href="bom_sbom_tree.php">
                    <li <?php if(isset($nav_selected) && $nav_selected == "BOM"){ echo 'class="current-page"'; } ?>>
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
