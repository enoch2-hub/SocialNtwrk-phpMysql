<!-- header.php -->
<?php
    session_start();


echo <<<_INIT
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Document</title>
            
            <link rel="stylesheet" href="style.css">

            <script src='javascript.js'></script>
            <script src="jquery-3.7.1.js"></script>

    _INIT;

    require_once 'functions.php';

    $userstr = 'Welcome Guest';
    $randstr = substr(md5(rand()), 0, 7);

    if(isset($_SESSION['user'])) {
        $user       = $_SESSION['user'];
        $loggedin   = TRUE;
        $userstr    = "Logged in as $user";
    } else {
        $loggedin = FALSE;
    }


echo <<<_MAIN
    <div class='main' data-role='page'>
        <div class='navhead' data-role='header'>
            <div id='logo'>
                <div class="username">$userstr</div>
                    <img id='robin' src='ball.png'>
            </div>
        </div>

        <div data-role='content'>
    
    _MAIN;

    if($loggedin) {

echo <<<_LOGGEDIN
    <div class='navbar'>

        <a data-role='button' data-inline='true' data-icon='home'
            data-transition="slide" href='members.php?view=$user&r=$randstr'>
        Home</a>

        <a data-role='button' data-inline='true' data-icon='user'
            data-transition="slide" href='members.php?r=$randstr'>
        Members</a>

        <a data-role='button' data-inline='true' data-icon='heart'
            data-transition="slide" href='friends.php?r=$randstr'>
        Friends</a>

        <a data-role='button' data-inline='true' data-icon='mail'
            data-transition="slide" href='messages.php?r=$randstr'>
        Messages</a>

        <a data-role='button' data-inline='true' data-icon='edit'
            data-transition="slide" href='profile.php?r=$randstr'>
        Edit Profile</a>
        
        <a data-role='button' data-inline='true' data-icon='action'
            data-transition="slide" href='logout.php?r=$randstr'>
        Logout</a>

    </div>


_LOGGEDIN;


    } else {

echo <<<_GUEST
        <div class='navbar'>
            <a data-role='button' data-inline='true' data-icon='home'
                data-transition='slide' href='index.php?r=$randstr'>
            Home</a>

            <a data-role='button' data-inline='true' data-icon='plus'
                data-transition='slide' href='signup.php?r=$randstr'>
            Sign Up</a>

            <a data-role='button' data-inline='true' data-icon='check'
                data-transition='slide' href='login.php?r=$randstr'>
            Login</a>
        </div>


    _GUEST;

    }

?>