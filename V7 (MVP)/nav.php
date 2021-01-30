<?php

    //variables
    $user_logged = false;
    $loggout_link = "<a href='index.php?logout='1''>Loggout</a>";
    $login_link = "<a href='login.php'>loggin</a>";
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
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <div class="navbar">
            <ul>
                <li>
                    <a href="home.php">Home</a>
                </li>
                <li>
                    <a href="tutorial.php">How to</a>
                </li>
                <li>
                    <a href="about.php">About us</a>
                </li>
                <?php 
                    include_once("utility_links.php")
                ?>
                <li>
                    <?php 

                        //only displays lo links to 
                        //logged in users
                        if (isset($_SESSION['username'])) {
                            echo $account;
                        }
                    ?>
                </li>
                <li class="login_link">
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
                </li>

            </ul>
        </div>
    </body>
</html>