<?php
// core configuration
include_once "config/core.php";

// set page title
$page_title = "Login";

// include login checker
$require_login=false;
include_once "login_checker.php";

// default to false
$access_denied=false;

if($_POST){

    include_once "config/Database.php";
    include_once "objects/User.php";

    // get database connection
    $database = new Database();
    $db = $database->getConnection();

    // initialize objects
    $user = new User($db);

    // check if email and password are in the database
    $user->email_user = $_POST['email_user'];

    // check if email exists, also get user details using this emailExists() method
    $email_exists = $user->emailExists();

    // validate login
    if ($email_exists && password_verify ($_POST['password'], $user->password)){

        // if it is, set the session value to true
        $_SESSION['logged_in'] = true;
        $_SESSION['user_id'] = $user->id_user;
        $_SESSION['access_level'] = $user->access_level;
        $_SESSION['name_user'] = htmlspecialchars($user->name_user, ENT_QUOTES, 'UTF-8') ;
        $_SESSION['email_user'] = htmlspecialchars($user->email_user, ENT_QUOTES, 'UTF-8') ;

        // if access level is 'Admin', redirect to admin section
        if($user->access_level=='Admin'){
            header("Location: {$home_url}admin/read_events.php?action=login_success");
        }

        // else, redirect only to 'Voter' section sim
        else if($user->access_level=='Voter'){
            header("Location: {$home_url}voter/index.php?action=login_success");

        }
    }

    // if username does not exist or password is wrong
    else {
        $access_denied = true;
    }
}

include_once "layout_head.php";

echo "<br><br><br><br><br>";
echo "<div style='margin: auto' class='col-sm-6 col-md-5 col-md-offset-4'>";

// get 'action' value in url parameter to display corresponding prompt messages
$action = isset($_GET['action']) ? $_GET['action'] : "";

// tell the user he is not yet logged in
if ($action == 'not_yet_logged_in'){
    echo "<div class='alert alert-danger margin-top-40' role='alert'>Please login.</div>";
}

// tell the user to login
else if ($action == 'please_login'){
    echo "<div class='alert alert-info'>
        <strong>Please login to access that page.</strong>
    </div>";
}

// tell the user email is verified
else if ($action == 'email_verified'){
    echo "<div class='alert alert-success'>
        <strong>Your email address have been validated.</strong>
    </div>";
}

// tell the user if access denied
if($access_denied){
    echo "<div class='alert alert-danger margin-top-40' role='alert'>
        Access Denied.<br /><br />
        Your username or password maybe incorrect
    </div>";
}

// actual HTML login form
echo "<div id='my-tab-content' class='tab-content'>";
echo "<div class='tab-pane active' id='login'>";
echo "<form id='form_index' class='form-signin' action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "' method='post'>";
echo "<input type='text' name='email_user' class='form-control' placeholder='Email' required autofocus />";
echo "<input type='password' name='password' class='form-control' placeholder='Password' required />";
echo "<input id='create-back-button' type='submit' class='btn btn-lg btn-primary btn-block' value='Log In' />";

echo "</form>";
echo "</div>";
echo "</div>";
echo "</div>";

echo "<br><br><br><br><br><br><br><br><br><br><br><br>";
?>
</div>
<?php

// footer HTML and JavaScript codes
include_once "layout_foot.php";
?>