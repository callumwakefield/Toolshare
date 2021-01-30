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
$record_id = 0;
$tool = "";
$additional_items = "";
$description = "";
$comments = "";
$availability = 0;
$user_id = $_SESSION["user_id"];

//gets tool id
$record_id = $_GET['id'];

//owner id query
$owner_qry = "SELECT owner_id, id FROM tool_registry 
                WHERE id='$record_id'";

$owner_result = mysqli_query($db, $owner_qry);

if (mysqli_num_rows($owner_result) > 0) {
    $row = mysqli_fetch_assoc($owner_result);

    //gets tools owners id
    $owner_id = $row['owner_id'];

    // only lets people through if they are the owner
    if ($owner_id == $user_id) {

        //query for tool record
        $tool_qry = "SELECT * FROM tool_registry WHERE 
            id='$record_id'";

        $result = mysqli_query($db, $tool_qry);

        $data = mysqli_fetch_array($result);

        //runs when update button is pressed
        if (isset($_POST['update'])) {
            
            //gets values
            $tool = mysqli_real_escape_string($db, 
                                        $_POST['tool_name']);
            $additional_items = mysqli_real_escape_string($db, 
                                        $_POST['additional_items']);
            $description = mysqli_real_escape_string($db, 
                                        $_POST['description']);
            $comments = mysqli_real_escape_string($db, 
                                        $_POST['comments']);

            if (isset($_POST['availability'])) {
                $availability = 1;
            }
            else {
                $availability = FALSE;
            }

            //data validation
            if (empty($tool)) {
                array_push($errors, "tool type is requiered");
            }
            else {
                if (strlen($tool) < 8 or strlen($tool) > 40) {
                    array_push($errors, 
                        "tool name must be between 8 and 40 characters");
                }
            }


            if (empty($description)) {
                array_push($errors, "description reqiered");
            }
            else {
                if (strlen($description) > 1000) {
                    array_push($errors, 
                    "description can not be over 300 characters");
                }
            }

            
            if (strlen($comments) > 500) {
                array_push($errors, 
                "comments can not be over 300 characters");
            }
            
            

            if (strlen($additional_items) > 100) {
                    array_push($errors, 
                    "additional items names must not be over 100 characters");
            }

            if (count($errors) == 0 ) {
                //query that will change the record
                $edit_qry = "UPDATE tool_registry SET tool='$tool',
                    additional_items='$additional_items', 
                        description='$description', 
                        availability='$availability', 
                        comments='$comments' 
                        WHERE id='$record_id'";

                $edit = mysqli_query($db, $edit_qry);

                if ($edit) {

                    //closes and redirects if succsesfull
                    mysqli_close($db);
                    header("location:users_tools.php");
                    exit;
                }
                else {
                    echo mysqli_error();
                }
            }
        }
        ?>

        <html>
        <head>
            <title>Update record</title>
            <meta charset="utf8"> 
            <link rel="stylesheet" href="stylesheet.css">
            <link rel="icon" href="images/icon.png">
        </head>
        <body>            
            <div class="banner">
                <div class="Toolshare">
                    Tool share    
                </div>
                <!--imports the navagation bar -->
                <?php include('nav.php')?>
            </div> 


            <!-- form to collect updated data -->
            <form method="POST" class="update_tool_record">

                <div class="header"> 
                    <h2>Edit record</h2> 
                </div> 
            
                <?php include('errors.php') ?>

                <div class="input-group">
                    <label>Enter tool type</label>
                    <input type="text" name="tool_name" 
                        value="<?php echo $data['tool']; ?>">
                </div>

                <div class="input-group">
                    <label>Describe tool</label>
                    <input type="text" name="description"
                        value="<?php echo $data['description']; ?>">
                </div>

                <div class="input-group">
                    <label>List additional items</label>
                    <input type="text" name="additional_items"
                        value="<?php echo $data['additional_items']; ?>">
                </div>

                <div class="input-group">
                    <label>Describe tool</label>
                    <input type="text" name="comments"
                        value="<?php echo $data['comments']; ?>">
                </div>

                <div class="image_display">

                    <?php
                        if ($data['image'] != "") {
                            ?>
                                <img src="<?php echo $data['image']?>">
                            <?php
                        }
                    ?>
                    <a href="change_image.php?id=<?php 
                        echo $record_id; ?>">Add/Change image</a>

                </div>

                <label class="avalability-label">Is it avaliable:</label>
                <?php
                    if ($data['availability'] == '1') {
                        echo '<input type="checkbox" 
                            class="avalability-checkbtn" 
                            name="availability" value="1"
                            checked>';
                    }
                    elseif ($data['availability'] == 0) {
                        echo '<input type="checkbox" 
                            class="avalability-checkbtn" 
                            name="availability" value="1">';
                    }
                ?>
                


                <div class="input-group">
                    <button type="submit" class="btn" name="update">
                        Update
                    </button>
                </div>


            </form>


        </body>
        </html>
        <?php
    }
}

?>