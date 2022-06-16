
<?php
    // functions
    function checkSelectedTab( $tab ) {
        // if the tab you selected matches the page
        if( $tab === $GLOBALS['nav_selected'] ) {
            return 'current-page';
        }

        return '';
    }

    function checkSelectedLink( $tab, $path ) {
        if( $GLOBALS['nav_selected'] !== $tab ) {
            return $path;
        }

        return '#';
    }

    function checkSelectedLeftMenu( $tab ) {
        if( isset($GLOBALS['left_selected']) && $GLOBALS['left_selected'] === $tab ) {
            return 'class="menu-left-current-page"';
        }

        return '';
    }

    function checkSelectedLeftMenuLink( $tab, $path ) {
        if( $GLOBALS['left_selected'] !== $tab ) {
            return $path;
        } else {
            return "#";
        }
    }
?>
