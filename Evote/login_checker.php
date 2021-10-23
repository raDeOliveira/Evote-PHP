<?php
// login checker for 'Voter' access level
 
// if access level was not 'Admin', redirect him to login page
if(isset($_SESSION['access_level']) && $_SESSION['access_level']=="Admin"){
    header("Location: {$home_url}admin/read_events.php?action=logged_in_as_admin");
}
 
// if $require_login was set and value is 'true'
else if(isset($require_login) && $require_login==true){
    // if user not yet logged in, redirect to login page
    if(!isset($_SESSION['access_level'])){
        header("Location: {$home_url}login.php?action=please_login");
    }
}
 
// if it was the 'login' or 'register' or 'sign up' page but the Voter was already logged in
else if(isset($page_title) && ($page_title=="Login" || $page_title=="Sign Up")){
    // if user not yet logged in, redirect to login page
    // customer to VOTER
    if(isset($_SESSION['access_level']) && ($_SESSION['access_level']=="Voter")){
        header("Location: {$home_url}index.php?action=already_logged_in");
    }
}
 
else{
    // no problem, stay on current page
}
?>