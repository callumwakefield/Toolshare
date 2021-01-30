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

//includes server and db conection
include('server.php');

//defines variables
$record_id = 0;

//gets the tools id to be deleted through query string
$record_id = $_GET['id'];


//query for delete
$del_qry = "DELETE FROM tool_registry WHERE id='$record_id'";

$del = mysqli_query($db, $del_qry);

if ($del) {
    
    //close database conection
    mysqli_close($db);

    //redirect to record page
    header("location:users_tools.php");
    exit;
}
else {

    //displays error msg if it fails to delete record
    echo "Error deleting record";
}


?>
