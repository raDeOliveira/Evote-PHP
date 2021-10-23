<?php
// core configuration
include_once "config/core.php";

// set page title
$page_title = "index";

// include login checker
include_once "login_checker.php";

// include classes
include_once 'config/Database.php';
include_once 'objects/User.php';
include_once "utils/Utils.php";

// include page header HTML
include_once "layout_head.php";

?>

<br><br><br><br><br>
<img id="start_voting" src="images/evote-logo.png" alt="">

</div>

<?php
// include page footer HTML
include_once "layout_foot.php";
?>
