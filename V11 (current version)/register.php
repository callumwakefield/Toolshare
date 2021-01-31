<?php 

//includes the db connection
include('server.php') 

?> 

<!DOCTYPE html> 
<html> 
<head> 
    <title>Registration</title> 
    <link rel="stylesheet" type="text/css" href="stylesheet.css">
    <meta charset="utf8">
    <link rel="icon" href="images/icon.png"> 
</head> 
  
<body>
    <?php
        include_once("nav.php");
    ?>
    

        <div>          
            <form method="post" action="register.php" class="register-form">
                <div class="header"> 
                    <h2>Register</h2> 
                </div> 
                
                <?php include('errors.php'); ?> 
                
                <br>
                <div class="input-group"> 
                    <label>Enter Username:</label> 
                    <input type="text" name="username"
                        value="<?php echo $username; ?>"> 
                </div> 

                <div class="input-group"> 
                    <label>Enter First name:</label> 
                    <input type="text" name="first_name"
                        value="<?php echo $first_name; ?>"> 
                </div>

                <div class="input-group"> 
                    <label>Enter Last name:</label> 
                    <input type="text" name="last_name"
                        value="<?php echo $last_name; ?>"> 
                </div>

                <div class="input-group">
                    <label>Enter city/town or region:</label>
                    <input type="text" name="region"
                    value="<?php echo $region; ?>">
                </div>

                
                <div class="input-group"> 
                    <label>Enter address:</label> 
                    <input type="text" name="address"
                    value="<?php echo $address; ?>"> 
                </div>

                <div class="input-group"> 
                    <label>Email:</label> 
                    <input type="email" name="email"
                        value="<?php echo $email; ?>"> 
                </div> 

                <div class="input-group"> 
                    <label>Enter phone number:</label> 
                    <input type="tel" name="phone_num"
                    value="<?php echo $phone_num; ?>"> 
                </div>

                <div class="input-group"> 
                    <label>Enter Password:</label> 
                    <input type="password" name="password_1"> 
                </div> 
                <div class="input-group"> 
                    <label>Confirm password:</label> 
                    <input type="password" name="password_2"> 
                </div> 
                <div class="terms">
                    <label>I have read and aggree to the <a href="terms_conditions.html"
                    target="_blank">terms and conditions</a>:</label>
                </div>
                <input type="checkbox" class="checkbtn" name="check_btn_1"
                    id="reg_checkbox">
                <div class="input-group"> 
                    <button type="submit" class="btn" id="reg_btn"
                                        name="reg_user" disabled> 
                        Register 
                    </button>
                    
                </div> 
                </br>   
                <p> 
                    Already having an account? 
                    <a href="login.php"> 
                        Login Here! 
                    </a>
                </p> 
            </form>
        </div>
    </div> 
</body> 
</html>

<script src="script.js"></script>
