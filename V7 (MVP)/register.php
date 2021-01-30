<?php 

//includes the db connection
include('server.php') 

?> 

<!DOCTYPE html> 
<html> 
<head> 
    <title>Registration</title> 
    <link rel="stylesheet" type="text/css" href="style.css">
    <meta charset="utf8">
    <link rel="icon" href="images/icon.png"> 
</head> 
  
<body>
    <?php
        include_once("nav.php");
    ?>
    <div class="login">
        <div class="message">
            <div class="message">
                <h1>Tool share</h1>
                <h4>A crowd sharing platform for tools</h4>
            </div>
        </div>

        <div class="register_form">
            <div class="header"> 
                <h2>Register</h2> 
            </div> 
            
            <form method="post" action="register.php"> 
        
                <?php include('errors.php'); ?> 
        
                <div class="input_group"> 
                    <label>Enter Username</label> 
                    <input type="text" name="username"
                        value="<?php echo $username; ?>"> 
                </div> 

                <div class="input_group"> 
                    <label>Enter First name</label> 
                    <input type="text" name="first_name"
                        value="<?php echo $first_name; ?>"> 
                </div>

                <div class="input_group"> 
                    <label>Enter lastname</label> 
                    <input type="text" name="last_name"
                        value="<?php echo $last_name; ?>"> 
                </div>

                <div class="input_group"> 
                    <label>Enter address</label> 
                    <input type="text" name="address"
                    value="<?php echo $address; ?>"> 
                </div>

                <div class="input_group"> 
                    <label>Email</label> 
                    <input type="email" name="email"
                        value="<?php echo $email; ?>"> 
                </div> 

                <div class="input_group"> 
                    <label>Enter phone number</label> 
                    <input type="tel" name="phone_num"
                    value="<?php echo $phone_num; ?>"> 
                </div>

                <div class="input_group"> 
                    <label>Enter Password</label> 
                    <input type="password" name="password_1"> 
                </div> 
                <div class="input_group"> 
                    <label>Confirm password</label> 
                    <input type="password" name="password_2"> 
                </div> 
                <div class="input_group"> 
                    <button type="submit" class="register_btn" id="reg_btn"
                                        name="reg_user" disabled> 
                        Register 
                    </button>
                    <div class="terms">
                        <label>I have read and aggree to the <a href="terms_conditions.html"
                        target="_blank">terms and conditions</a>:</label>
                        <input type="checkbox" class="checkbtn" name="check_btn_1"
                            id="reg_checkbox">
                    </div> 
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
