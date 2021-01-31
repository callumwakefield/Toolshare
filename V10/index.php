<?php

//starts the session
session_start();
   
//makes sure that the user is logged in
if (!isset($_SESSION['username'])) { 
    $_SESSION['msg'] = "You have to log in first";
    //rerouts user to loggin if they arn't logged in 
    header('location: login.php'); 
} 
   
//destroys session on loggout and redirects to loggin
if (isset($_GET['logout'])) { 
    session_destroy(); 
    unset($_SESSION['username']); 
    header("location: login.php"); 
} 
?> 
<!DOCTYPE html> 
<html> 
<head> 
    <title>Homepage</title> 
    <link rel="stylesheet" type="text/css"
                    href="style.css"> 
</head> 
<body>
    <div class="header"> 
        <h2>Home Page</h2> 
    </div>
    <div id="nav_placeholder">
        <?php 
            include_once("nav.php")
        ?>
    </div> 
    <div class="content"> 
   
        <!-- Creating notification when the 
                user logs in -->
          
        <!-- Accessible only to the users that 
                have logged in already -->
        <?php if (isset($_SESSION['success'])) : ?> 
            <div class="error success" > 
                <h3> 
                    <?php
                        echo $_SESSION['success'];  
                        unset($_SESSION['success']); 
                    ?> 
                </h3> 
            </div> 
        <?php endif ?> 
   
        <!-- information of the user logged in -->
        <!-- welcome message for the logged in user -->
        <?php  if (isset($_SESSION['username'])) : ?> 
            <p> 
                Welcome  
                <strong> 
                    <?php echo $_SESSION['username']; ?> 
                </strong> 
            </p> 
            <p>  
                <a href="index.php?logout='1'" style="color: red;"> 
                    Click here to Logout 
                </a> 
            </p> 
        <?php endif ?> 
    </div> 
</body> 
</html>