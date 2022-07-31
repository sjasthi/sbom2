<?php
$nav_selected = "REPORTS";
$left_selected = "AppComprehensiveReport";
$tabTitle = "SBOM - Reports (Comprehensive Report)";


include("../../../../index.php");
include("reports_left_menu.php");

?>

<?php if (isset($_GET['app_id']) == true) {

    include("./reports_use_app_id.php");
} elseif (isset($_GET['app_name']) == true && isset($_GET['app_version'])) {
    include("./reports_use_app_name_version.php");
} else {
    include("./reports_app_not_found.php");
}
?>