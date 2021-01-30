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
$tool = "";
$additional_items = "";
$comments = "";
$availability = 0;



   
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
   
    //prevents the user from submiting nothing in the requiered 
    //fields and makes sure that it is long enough and valid
    if (empty($first_name)) {
         array_push($errors, "First name is required");
    }
    else {
        if (strlen($first_name) < 3) {
            array_push($errors, "the first name is too short");
        }
    }


    if (empty($last_name)) { 
        array_push($errors, "Last name is required");
    }
    else {
        if (strlen($last_name) < 3) {
            array_push($errors, "the last name is too short");
        }
    }
        
    if (empty($address)) { 
        array_push($errors, "Address is required"); 
    }
    else {
        if (strlen($address) <= 7) {
            array_push($errors, "the address is too short");
        }
    }
   

    if (empty($username)) { 
        array_push($errors, "Username is required"); 
    } 
    else {
        if (strlen($username) < 6) {
            array_push($errors, "the username is too short");
        }
    }


    if (empty($phone_num)) { 
        array_push($errors, "Phone number is required"); 
    }
    else {
        if (strlen($phone_num) < 7) {
            array_push($errors, "Phone number is too short");
        }
    }
    

    if (empty($email)) { 
        array_push($errors, "Email is required");
    } 
    else {
        if (strlen($email) < 13) {
            array_push($errors, "Email is too short");
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            array_push($errors, "Invalid email format");
        }
    }


    if (empty($password_1)) { 
        array_push($errors, "Password is required"); 
    }
    else {
        if (strlen($password_1) < 7) {
            array_push($errors, "pasword is too short");
        }
    }
    if (empty($password_2)) { array_push($errors, "Password is required"); } 
    


//makes sure that the passwords match
if ($password_1 != $password_2) { 
    array_push($errors, "The two passwords do not match");  
}

//makes sure that the username is an origional
$username_qry = "SELECT * FROM registration WHERE username='$username'";

$results = mysqli_query($db, $username_qry);

if (mysqli_num_rows($results) > 0) {
    array_push($errors, 
        "someone else has that username please try another one");
}

    //makes sure that their are no errors befor submiting
    if (count($errors) == 0) { 
          
        //encodes the password in sha256 
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
        
        
        //stors the users id in the session variable
        $id_qry = "SELECT * FROM registration
                WHERE username = '$username';";

            $id_result = mysqli_query($db, $id_qry);

            if (mysqli_num_rows($id_result) > 0) {

                $row = mysqli_fetch_assoc($id_result);
                $user_id =  $row['id'];

                $_SESSION["user_id"] = $user_id;
                
            }
          
        // Welcome message 
        $_SESSION['success'] = "You have logged in"; 
          
        // Page on which the user will be  
        // redirected after logging in 
        header('location: index.php');  
    } 
} 
   
// User login 
if (isset($_POST['login_user'])) { 
      
    // Gets the data the user submits and sanitizes it
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
            
            //stors the users id in the session variable
            $id_qry = "SELECT * FROM registration
                WHERE username = '$username';";

            $id_result = mysqli_query($db, $id_qry);

            if (mysqli_num_rows($id_result) > 0) {

                $row = mysqli_fetch_assoc($id_result);
                $user_id =  $row['id'];

                $_SESSION["user_id"] = $user_id;
                
            }

              
            // Page on which the user is sent 
            // to after logging in 
            header('location: home.php'); 
        } 
        else { 
              
            // If the username and password doesn't match 
            array_push($errors, "Username or password incorrect");  
        } 
    } 
}


// tool regestration
if (isset($_POST['reg_tool'])) {

    // gets the data from the form
    $tool = mysqli_real_escape_string($db, $_POST['tool_name']);
    $additional_items = mysqli_real_escape_string($db, 
                                    $_POST['additional_items']);
    $comments = mysqli_real_escape_string($db, $_POST['comments']);
    
    $user_id = $_SESSION["user_id"];

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


    if (empty($comments)) {
        array_push($errors, "description reqiered");
    }
    else {
        if (strlen($comments) > 300) {
            array_push($errors, 
            "description can not be over 300 characters");
        }
    }
    

    if (strlen($additional_items) > 100) {
            array_push($errors, 
            "additional items names must not be over 100 characters");
        }



    if (count($errors) == 0) {
        //Inserting data into the table 
        $tool_query = "INSERT INTO tool_registry (owner_id, tool, additional_items, comments, availability) 
            VALUES('$user_id', '$tool', '$additional_items', '$comments', '$availability')";

        if (mysqli_query($db, $tool_query)) {
            header('location: home.php');
        }
        else {
            array_push($errors, "Error submiting");
        }
    }    
}



?>