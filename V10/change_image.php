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
$user_id = $_SESSION['user_id'];

//gets tool id
$record_id = $_GET['id'];

$owner_qry = "SELECT owner_id, id FROM tool_registry 
                WHERE id='$record_id'";

$owner_result = mysqli_query($db, $owner_qry);


if (mysqli_num_rows($owner_result) > 0) {
    $row = mysqli_fetch_assoc($owner_result);

    //gets tools owners id
    $owner_id = $row['owner_id'];

    // only lets people through if they are the owner
    if ($owner_id == $user_id) {

        if (isset($_POST['change_image'])) {

            // stuff for image
            $filename = $_FILES['file']['name'];
            $target_dir = "upload/";
            
            if ($filename != '') {

                $target_file = $target_dir.basename($_FILES["file"]["name"]); 
            
                // Select file type
                $extension = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

                // accseptble extensions
                $extensions_arr = array("jpg","jpeg","png","gif");

                //checks the extension
                if (in_array($extension, $extensions_arr)) {

                    //converts file to base 64
                    $image_base64 = base64_encode(file_get_contents($_FILES['file']['tmp_name']));

                    $image = "data:image/".$extension.";base64,".$image_base64;

                    //send image to upload folder
                    move_uploaded_file($_FILES['file']['tmp_name'], $target_dir);
                    
                    //update query
                    $update_qry = "UPDATE tool_registry SET 
                        image='$image' WHERE id=$record_id";

                    $result = mysqli_query($db, $update_qry);

                    if ($result) {
        
                        //closes and redirects if succsesfull
                        mysqli_close($db);
                        header("location:users_tools.php");
                        exit;
                    }
                    else {
                        echo mysqli_error($db);
                    }
                    

                }
                
            
            }


            



        }

        //image query
        $img_qry = "SELECT image FROM tool_registry WHERE 
        id='$record_id'";

        $result = mysqli_query($db, $img_qry);

        $row = mysqli_fetch_array($result);

        ?>
        <html>
        <head>
            <title>Change image</title>
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

            <form method="post" enctype="multipart/form-data"
                class="update_img_form">
                <p>

                    <label class="search-title">
                        Add/change image
                    </label>

                    <div class="image-input">
                        <label>upload image:</label>                
                        <input type="file" name="file">
                    </div>
                    <div class="input-group">
                        <button type="submit" name="change_image"
                            class="btn"> Update </button>
                    </div>
                </p>
            </form>
        </body>
        </html>
        <?php
    }
}


?>