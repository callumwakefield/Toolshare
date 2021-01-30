<?php 
    include("server.php");

    //variables
    $username = "";
    $first_name = "";
    $last_name = "";
    $region = "";
    $address = "";
    $email = "";
    $phone_num = "";
    


    //gets users info
    $user_id = $_SESSION['user_id'];

    $user_qry = "SELECT * FROM registration WHERE id='$user_id'";

    $result = mysqli_query($db, $user_qry);

    if (mysqli_num_rows($result) > 0) {    
        $row = mysqli_fetch_assoc($result);

        // gets values
        $username = $row['username'];
        $first_name = $row['first_name'];
        $last_name = $row['last_name'];
        $region = $row['region'];
        $address = $row['address'];
        $email = $row['email'];
        $phone_num = $row['phone_number'];
    }



?>
<html> 
<head> 
    <title>Dashboard</title> 
    <link rel="stylesheet" type="text/css" href="stylesheet.css">
    <meta charset="utf8">
    <link rel="icon" href="images/icon.png"> 
</head> 
<body>
    <div class="banner">
        <div class="Toolshare">
            Tool share    
        </div>
        <?php include('nav.php')?>
    </div> 
    <div class="parallex4">
        <div class="parrlx-title">
            Dashboard
        </div>
    </div>
    <div class="space">

    </div>
    <form method="post" class="dashboard">
        <?php
            include('errors.php');
        ?>
        
        <h1>My details</h1>
         
        <label>Enter Username</label> 
        <input type="text" name="username"
            value="<?php echo $username; ?>"> 



        <label>Enter First name</label> 
        <input type="text" name="first_name"
            value="<?php echo $first_name; ?>"> 
        
         
            
        <label>Enter lastname</label> 
        <input type="text" name="last_name"
            value="<?php echo $last_name; ?>"> 
            


        <label>Enter city/town or region</label>
        <input type="text" name="region"
            value="<?php echo $region; ?>">
            
            

        <label>Enter address</label> 
        <input type="text" name="address"
            value="<?php echo $address; ?>"> 
            

            
        <label>Email</label> 
        <input type="email" name="email"
            value="<?php echo $email; ?>"> 
             

                 
        <label>Enter phone number</label> 
        <input type="tel" name="phone_num"
            value="<?php echo $phone_num; ?>"> 
            
        <button type="submit"class="btn" 
            id="reg_update_btn" name="reg_update_btn">
            Update
        </button>

    </form>
    <?php 
        include('footer.php');
    ?>
</body>
</html>