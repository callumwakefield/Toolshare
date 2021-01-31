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
if (isset($_SESSION['username'])) {
    header('location:account.php');  
}

?> 
<html> 
<head> 
    <title>Homepage</title> 
    <link rel="stylesheet" href="stylesheet.css"> 
</head> 
<body>
    