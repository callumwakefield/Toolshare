<?php


//using server connection
include("server.php");

//makes sure that the user is logged in
if (!isset($_SESSION['username'])) { 
    $_SESSION['msg'] = "You have to log in first";
    //rerouts user to loggin if they arn't logged in 
    header('location: login.php'); 
}

//variables
$region = "";
$email = "";
$tool = "";
$description = "";
$additional_items = "";
$comments = "";





//gets tool id
$record_id = $_GET['id'];




// tool query
$tool_qry = "SELECT 
        r.region AS region,
        r.email AS email,
        tr.tool AS tool,
        tr.additional_items AS additional_items,
        tr.description AS description,
        tr.availability AS availability,
        tr.comments AS comments,
        tr.id AS tool_id,
        tr.image AS image
    FROM tool_registry AS tr INNER JOIN registration AS r
    ON tr.owner_id = r.id WHERE tr.id='$record_id';";

$result = mysqli_query($db, $tool_qry);

if (mysqli_num_rows($result) > 0) {

    $row = mysqli_fetch_assoc($result);

    $region = $row["region"];
    $email = $row["email"];
    $tool = $row["tool"];
    $additional_items = $row["additional_items"];
    $description = $row["description"];
    $comments = $row["comments"];
    $image = $row["image"];


    if (boolval($row["availability"]) == FALSE) {
        echo "<h3>sorry that tool is not avaliable</h3>";
    }
    else {
        echo $region;
        echo $email;
        echo $tool;
        echo $additional_items;
        echo $description;
        echo $comments;
        ?>

        <img src='<?php echo $image; ?>' width='300px' height='300px'>

        <?php
    }



}
else {
    echo "<h3>sorry but that record could not be found</h3>";
}