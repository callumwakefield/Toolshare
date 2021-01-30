<?php 

// includes server.php
include('server.php'); 
   
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
    <title>Register tool</title>
    <meta charset="utf8"> 
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="images/icon.png"> 
</head> 
<body>
    
    <?php include_once('nav.php') ?>

    <h1>Tool registration</h1>
    <div class="tool_regestration">
        <!--form to collect users tool infomation-->
        <form method="post" action="register_tool.php">

            <?php include('errors.php') ?>

            <div class="input-group">
                <label>Enter tool type</label>
                <input type="text" name="tool_name" 
                    value="<?php echo $tool; ?>">
            </div>

            <div class="input-group">
                <label>Describe tool</label>
                <input type="text" name="comments"
                    value="<?php echo $comments; ?>">
            </div>

            <div class="input-group">
                <label>List additional items</label>
                <input type="text" name="additional_items"
                    value="<?php echo $additional_items; ?>">
            </div>

            <div class="input-group">
                <label>Is it avaliable</label>
            </div>
            <input type="checkbox" class="avalability-checkbtn" 
                name="availability" value="1">
            

            <div class="input-group">
                <button type="submit" class="btn" name="reg_tool">
                    Register tool
                </button>
            </div>

        </form>
    </div>

</body>