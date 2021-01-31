<?php 

// includes server.php
include('server.php');

//variables
$tool = "";
$additional_items = "";
$description = "";
$comments = "";
$availability = 0;
$owner_id = 0;
$tool_id = 0;

// gets the users id
$user_id = $_SESSION['user_id'];

//query to get users tools descriptions
$users_tool_qry = " SELECT * FROM tool_registry WHERE owner_id='$user_id'";
   
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
    <title>My tools</title>
    <meta charset="utf8"> 
    <link rel="stylesheet" href="stylesheet.css">
    <link rel="icon" href="images/icon.png"> 
</head> 
<body>
    <div class="banner">
        <div class="Toolshare">
            Tool share    
        </div>
        <?php include('nav.php')?>
    </div>    

    <div class="parallex5">
        <div class="parrlx-title">
            My tools
        </div>

    </div>

<div class="users-tbl">
    <?php 
    
        $result = mysqli_query($db, $users_tool_qry);

        if (mysqli_num_rows($result) > 0) {

            //sets up the table
            echo '<table class="search-table">
            <tr>
                <th>Tool Name:</th>
                <th>Additional items:</th>
                <th>Avalability:</th>
                <th>Edit:</th>
                <th>Delete:</th> 
            </tr>';

            //output data of each row
            while ($row = mysqli_fetch_assoc($result)) {
                $tool_id = $row["id"];
                $owner_id = $row["owner_id"];
                $tool = $row["tool"];
                $description = $row["description"];
                $comments = $row["comments"];
                $additional_items = $row["additional_items"];

                if (boolval($row["availability"]) == TRUE) {
                    $availability = "Avaliable";
                } 
                else {
                    $availability = "Not avaliable";
                }

                ?>
                <tr>
                    <td><?php echo $tool; ?></td>
                    <td><?php echo $additional_items; ?></td>
                    <td><?php echo $availability; ?></td>
                    <td><a href='edit.php?id=<?php 
                                echo $tool_id; ?>'>Edit/view</a></td>
                    <td><a href='delete.php?id=<?php 
                                echo $tool_id; ?>'>Delete</a></td>

                </tr>
                <?php
            }
        }
        else {
            echo "<h2>sorry but you have no tools uploaded</h2>";
        }
    
    ?>
</div>
</body>
</html>