<?php  
  
//begins the session
session_start(); 
   
//variables 
$username = ""; 
$first_name = "";
$last_name = "";
$address = "";
$email    = "";
$phone_num = ""; 
$errors = array();  
$_SESSION['success'] = ""; 
   
// DBMS connection code -> hostname, 
// username, password, database name 
$db = mysqli_connect('localhost', 'user', 'A.43b&12g/3', 'toolshare'); 
   
// Registration code 
if (isset($_POST['reg_user'])) { 
   
    //gets the infomation from the form and strips special charecters 
    $first_name = mysqli_real_escape_string($db, $_POST['first_name']);
    $last_name = mysqli_real_escape_string($db, $_POST['last_name']);
    $address = mysqli_real_escape_string($db, $_POST['address']);
    $username = mysqli_real_escape_string($db, $_POST['username']); 
    $phone_num = mysqli_real_escape_string($db, $_POST['phone_num']);
    $email = mysqli_real_escape_string($db, $_POST['email']); 
    $password_1 = mysqli_real_escape_string($db, $_POST['password_1']); 
    $password_2 = mysqli_real_escape_string($db, $_POST['password_2']); 
   
    //prevents the user from submiting nothing for the requiered fields
    if (empty($first_name)) { array_push($errors, "First name is required"); }
    if (empty($last_name)) { array_push($errors, "Last name is required"); }
    if (empty($address)) { array_push($errors, "Address is required"); }
    if (empty($username)) { array_push($errors, "Username is required"); } 
    if (empty($phone_num)) { array_push($errors, "Phone number is required"); }
    if (empty($email)) { array_push($errors, "Email is required"); } 
    if (empty($password_1)) { array_push($errors, "Password is required"); }
    if (empty($password_2)) { array_push($errors, "Password is required"); } 
   
    //checks that the variables are long enough
    if (strlen($address) <= 7) {
        array_push($errors, "the address is too short");
    }

    if (strlen($first_name) < 3) {
        array_push($errors, "the first name is too short");
    }

    if (strlen($last_name) < 3) {
        array_push($errors, "the last name is too short");
    }

    if (strlen($username) < 6) {
        array_push($errors, "the username is too short");
    }

    //makes sure that the passwords match
    if ($password_1 != $password_2) { 
        array_push($errors, "The two passwords do not match");  
    } 
   
    //makes sure that their are no errors befor submiting
    if (count($errors) == 0) { 
          
        //encodes the password in md5 
        $password = hash("sha256", $password_1); 
          
        // Inserting data into table 
        $query = "INSERT INTO registration (first_name, last_name,
             address, password, username, email, phone_number)  
                  VALUES('$first_name', '$last_name', '$address',
                        '$password', '$username', '$email',
                        '$phone_number')";  
          
        mysqli_query($db, $query); 
   
        // stors the users username in the session variable
        $_SESSION['username'] = $username;
        $_SESSION['email'] = $email; 
          
        // Welcome message 
        $_SESSION['success'] = "You have logged in"; 
          
        // Page on which the user will be  
        // redirected after logging in 
        header('location: index.php');  
    } 
} 
   
// User login 
if (isset($_POST['login_user'])) { 
      
    // Data sanitization to prevent SQL injection 
    $username = mysqli_real_escape_string($db, $_POST['username']); 
    $password = mysqli_real_escape_string($db, $_POST['password']); 
   
    // Error message if the input field is left blank 
    if (empty($username)) { 
        array_push($errors, "Username is required"); 
    } 
    if (empty($password)) { 
        array_push($errors, "Password is required"); 
    } 
   
    // Checking for the errors 
    if (count($errors) == 0) { 
          
        // Password matching 
        $password = hash("sha256", $password); 
          
        $query = "SELECT * FROM registration WHERE username= 
                '$username' AND password='$password'"; 
        $results = mysqli_query($db, $query); 
   
        // $results = 1 means that one user with the 
        // entered username exists 
        if (mysqli_num_rows($results) == 1) { 
              
            // Storing username in session variable 
            $_SESSION['username'] = $username; 
              
            // Welcome message 
            $_SESSION['success'] = "You have logged in!"; 
              
            // Page on which the user is sent 
            // to after logging in 
            header('location: index.php'); 
        } 
        else { 
              
            // If the username and password doesn't match 
            array_push($errors, "Username or password incorrect");  
        } 
    } 
} 
   
?>