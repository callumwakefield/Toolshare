<?php

    //includes server.php
    include("server.php");

    //makes sure that the user is logged in
    if (!isset($_SESSION['username'])) { 
        $_SESSION['msg'] = "You have to log in first";
        //rerouts user to loggin if they arn't logged in 
        header('location: login.php'); 
    } 

    //gets users id
    $user_id = $_SESSION['user_id'];

?>
<html>
    <head>
        <title>Delete my account</title>
        <meta charset="utf8"> 
        <link rel="stylesheet" href="stylesheet.css">
        <link rel="icon" href="images/icon.png"> 
    </head>
    <body>
        <h1 class="delete_warning">
            Are you sure you want to delete your account 
        </h1>
        <form method="post" class="deleat_account_form">
            <label>Delete account:</label>
            <button type="submit" id="delete_account_btn" 
                name="delete_account_btn">
                DELETE ACCOUNT
            </button>
        </form>
    </body>

