<?php include('server.php') ?> 
<!DOCTYPE html> 
<html> 
<head> 
    <title>Login</title>
    <meta charset="utf8"> 
    <link rel="stylesheet" href="stylesheet.css">
    <link rel="icon" href="images/icon.png"> 
</head> 
<body>
    <?php 
        include_once("nav.php");
    ?> 
    
       
    <!-- form to collect users login -->
    <form method="post" action="login.php" class="login-form"> 
        
        <!--form title -->
        <div class="header"> 
            <h2>Login Here!</h2> 
        </div>
        
        <!-- form -->
        <?php include('errors.php'); ?> 
   
        <div class="input-group"> 
            <label>Enter Username:</label> 
            <input type="text" name="username" 
            value="<?php echo $username; ?>"> 
        </div> 

        <div class="input-group"> 
            <label>Enter Password:</label> 
            <input type="password" name="password"> 
        </div> 

        <div class="input-group"> 
            <button type="submit" class="btn"
                        name="login_user"> 
                Login 
            </button> 
        </div> 
        <p> 
            New Here?  
            <a href="register.php"> 
                Click here to register! 
            </a> 
        </p> 
    </form> 
</body> 
  
</html>