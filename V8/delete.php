<?php


//makes sure that the user is logged in
if (!isset($_SESSION['username'])) { 
    $_SESSION['msg'] = "You have to log in first";
    //rerouts user to loggin if they arn't logged in 
    header('location: login.php'); 
} 


//includes server and db conection
include('server.php');

//defines variables
$record_id = 0;
$owner_id = 0;
$user_id = $_SESSION["user_id"]; 

//gets the tools id to be deleted through query string
$record_id = $_GET['id'];

//owner id query
$owner_qry = "SELECT owner_id, id FROM tool_registry 
                WHERE id='$record_id'";

$owner_result = mysqli_query($db, $owner_qry);

if (mysqli_num_rows($owner_result) > 0) {
    $row = mysqli_fetch_assoc($owner_result);

    //gets tools owners id
    $owner_id = $row['owner_id'];

    // only deleats record if user is owner
    if ($owner_id == $user_id) {

        //query for delete
        $del_qry = "DELETE FROM tool_registry 
            WHERE id='$record_id'";

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
    }
}
?>
