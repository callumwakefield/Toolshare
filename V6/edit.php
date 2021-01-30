<?php

//using server connection
include("server.php");

//variables
$record_id = 0;
$tool = "";
$additional_items = "";
$comments = "";
$availability = 0;

//gets tool id
$record_id = $_GET['id'];

//query for tool record
$tool_qry = "SELECT * FROM tool_registry WHERE id='$record_id'";

$result = mysqli_query($db, $tool_qry);

$data = mysqli_fetch_array($result);

//runs when update button is pressed
if (isset($_POST['update'])) {
    
    //gets values
    $tool = mysqli_real_escape_string($db, $_POST['tool_name']);
    $additional_items = mysqli_real_escape_string($db, 
                                    $_POST['additional_items']);
    $comments = mysqli_real_escape_string($db, $_POST['comments']);

    if (isset($_POST['availability'])) {
        $availability = 1;
    }
    else {
         $availability = FALSE;
    }

    //query that will change the record
    $edit_qry = "UPDATE tool_registry SET tool='$tool',
         additional_items='$additional_items', comments='$comments',
         availability='$availability'";

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
?>

<html>
<head>
    <title>Update record</title>
    <meta charset="utf8"> 
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="icon" href="images/icon.png">
</head>
<body>
    
    <!--imports the navagation bar -->
    <?php include_once('nav.php') ?>

    <h1>Update record</h1>


    <!-- form to collect updated data -->
    <form method="POST">
    
        <?php include('errors.php') ?>

        <div class="input-group">
            <label>Enter tool type</label>
            <input type="text" name="tool_name" 
                value="<?php echo $data['tool_name']; ?>">
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
            <button type="submit" class="btn" name="update">
                Register tool
            </button>
        </div>


    </form>


</body>
</html>