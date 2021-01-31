<?php

    //variables
    $user_logged = false;
    $loggout_link = "<a href='index.php?logout='1''>Logout</a>";
    $login_link = "<a href='login.php'>login</a>";
    $account = "<a href='account.php'>Dashboard</a>";

    //checks if the user is logged in
    if (!isset($_SESSION['username'])) { 
        $user_logged = false; 
    }
    else {
        $user_logged = true;
    }
?>

<!doctype html>
<html>
    <head>
        <link rel="stylesheet" href="stylesheet.css">
    </head>
    <body>
        <div class="navbar">
            <a href="home.php">Home</a>
            <a href="about.php">About us</a>
            <?php
                if (!isset($_SESSION['username'])) {
                    echo '<a href="FAQ.php">FAQ</a>';
                }                
            ?>
            <?php 
            include_once("utility_links.php");
            //only displays lo links to 
            //logged in users
            if (isset($_SESSION['username'])) {
                echo $account;
            }
            ?>
            <div class='loggin_link'>
                <?php 
                        
                    //only shows loggout to
                    //users who are logged in
                    if (isset($_SESSION['username'])) {
                        echo $loggout_link;
                    }
                    else {
                        //otherwise shows the loggin option
                        echo $login_link;
                    }
                ?>
            </div>
        </div>
    </body>
</html>