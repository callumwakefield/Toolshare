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
$description = ""; 
$comments = "";
$availability = 0;
$region = "";




   
// DBMS connection code -> hostname, 
// username, password, database name 
$host = 'localhost:3307';
$user = 'user';
$pass = 'A.43b&12g/3';
$dbname = 'toolshare';

$db = mysqli_connect($host, $user, $pass, $dbname); 
   
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
    $region = mysqli_real_escape_string($db, $_POST['region']);
   
    //prevents the user from submiting nothing in the requiered 
    //fields and makes sure that it is long enough and valid
    if (empty($first_name)) {
         array_push($errors, "First name is required");
    }
    else {
        if (strlen($first_name) < 3) {
            array_push($errors, "the first name is too short");
        }
        elseif (strlen($first_name) > 30) {
            array_push($errors, 
                "the first name you entered is too long");
        }
    }


    if (empty($last_name)) { 
        array_push($errors, "Last name is required");
    }
    else {
        if (strlen($last_name) < 3) {
            array_push($errors, "the last name is too short");
        }
        elseif (strlen($last_name) > 30) {
            array_push($errors, 
                "the last name you entered is too long");
        }
    }
      
    
    if (empty($region)) { 
        array_push($errors, "region is required"); 
    }
    else {
        if (strlen($region) < 5) {
            array_push($errors, "the region name is too short");
        }
        elseif (strlen($region) > 30) {
            array_push($errors, "the region name is too long");
        }
    }


    if (empty($address)) { 
        array_push($errors, "Address is required"); 
    }
    else {
        if (strlen($address) <= 7) {
            array_push($errors, "the address is too short");
        }
        elseif (strlen($address) > 35) {
            array_push($errors, "the address is too long");
        }
    }
   

    if (empty($username)) { 
        array_push($errors, "Username is required"); 
    } 
    else {
        if (strlen($username) < 6) {
            array_push($errors, "the username is too short");
        }
        elseif (strlen($username) > 40) {
            array_push($errors, "the username is too long");
        }
    }


    if (empty($phone_num)) { 
        array_push($errors, "Phone number is required"); 
    }
    else {
        if (strlen($phone_num) < 7) {
            array_push($errors, "Phone number is too short");
        }
        elseif (strlen($phone_num) > 25) {
            array_push($errors, "phone number is too long");
        }
    }


    if (empty($email)) { 
        array_push($errors, "Email is required");
    } 
    else {
        if (strlen($email) < 13) {
            array_push($errors, "Email is too short");
        }
        elseif (strlen($email) > 50) {
            array_push($errors, "your email is too long");
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            array_push($errors, "Invalid email format");
        }
        
    }


    if (empty($password_1)) { 
        array_push($errors, "Confomation password is required"); 
    }
    else {
        if (strlen($password_1) < 7) {
            array_push($errors, "
                Confomation pasword is too short");
        }
    }
    if (empty($password_2)) { array_push($errors, 
                "Confomation password is required"); } 
    


    //makes sure that the passwords match
    if ($password_1 != $password_2) { 
        array_push($errors, "The two passwords do not match");  
    }

    //makes sure that the username is an origional
    $username_qry = "SELECT * FROM registration WHERE
         username='$username'";

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
             address, password, username, email, phone_number, region)  
                  VALUES('$first_name', '$last_name', '$address',
                        '$password', '$username', '$email',
                        '$phone_num', '$region')";  
          
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
        header('location: account.php');  
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
            header('location: account.php'); 
        } 
        else { 
              
            // If the username and password doesn't match 
            array_push($errors, "Username or password incorrect");  
        } 
    } 
}

//else {
  //  array_push($errors, "invalid image format")
//}

// tool regestration
if (isset($_POST['reg_tool'])) {

    // gets the data from the form
    $tool = mysqli_real_escape_string($db, $_POST['tool_name']);
    $additional_items = mysqli_real_escape_string($db, 
                                    $_POST['additional_items']);
    $description = mysqli_real_escape_string($db, $_POST['description']);
    $comments = mysqli_real_escape_string($db, $_POST['comments']);
    $user_id = $_SESSION["user_id"];


    // stuff for img
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
            

            

        }
        
    
    }
    else {
        $image = "";
    }

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



    if (count($errors) == 0) {

        //Inserting data into the table 
        $tool_query = "INSERT INTO tool_registry (
                owner_id, tool, additional_items, description,
                availability, comments, image) 
            VALUES('$user_id', '$tool', '$additional_items',
                '$description', '$availability', '$comments',
                '$image')";

        if (mysqli_query($db, $tool_query)) {
            header('location: users_tools.php');
        }
        else {
            array_push($errors, "Error submiting:");
            array_push($errors, mysqli_error($db));
        }
    }    
}

//registretion update
if (isset($_POST['reg_update_btn'])) {

    //gets the infomation from the form and strips special charecters 
    $first_name = mysqli_real_escape_string($db, $_POST['first_name']);
    $last_name = mysqli_real_escape_string($db, $_POST['last_name']);
    $address = mysqli_real_escape_string($db, $_POST['address']);
    $username = mysqli_real_escape_string($db, $_POST['username']); 
    $phone_num = mysqli_real_escape_string($db, $_POST['phone_num']);
    $email = mysqli_real_escape_string($db, $_POST['email']); 
    $region = mysqli_real_escape_string($db, $_POST['region']);
    $user_id = $_SESSION['user_id'];
   
    //prevents the user from submiting nothing in the requiered 
    //fields and makes sure that it is long enough and valid
    if (empty($first_name)) {
         array_push($errors, "First name is required");
    }
    else {
        if (strlen($first_name) < 3) {
            array_push($errors, "the first name is too short");
        }
        elseif (strlen($first_name) > 30) {
            array_push($errors, 
                "the first name you entered is too long");
        }
    }


    if (empty($last_name)) { 
        array_push($errors, "Last name is required");
    }
    else {
        if (strlen($last_name) < 3) {
            array_push($errors, "the last name is too short");
        }
        elseif (strlen($last_name) > 30) {
            array_push($errors, 
                "the last name you entered is too long");
        }
    }
      
    
    if (empty($region)) { 
        array_push($errors, "region is required"); 
    }
    else {
        if (strlen($region) < 5) {
            array_push($errors, "the region name is too short");
        }
        elseif (strlen($region) > 30) {
            array_push($errors, "the region name is too long");
        }
    }


    if (empty($address)) { 
        array_push($errors, "Address is required"); 
    }
    else {
        if (strlen($address) <= 7) {
            array_push($errors, "the address is too short");
        }
        elseif (strlen($address) > 35) {
            array_push($errors, "the address is too long");
        }
    }
   

    if (empty($username)) { 
        array_push($errors, "Username is required"); 
    } 
    else {
        if (strlen($username) < 6) {
            array_push($errors, "the username is too short");
        }
        elseif (strlen($username) > 40) {
            array_push($errors, "the username is too long");
        }
    }


    if (empty($phone_num)) { 
        array_push($errors, "Phone number is required"); 
    }
    else {
        if (strlen($phone_num) < 7) {
            array_push($errors, "Phone number is too short");
        }
        elseif (strlen($phone_num) > 25) {
            array_push($errors, "phone number is too long");
        }
    }


    if (empty($email)) { 
        array_push($errors, "Email is required");
    } 
    else {
        if (strlen($email) < 13) {
            array_push($errors, "Email is too short");
        }
        elseif (strlen($email) > 50) {
            array_push($errors, "your email is too long");
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            array_push($errors, "Invalid email format");
        }
        
    }

    //makes sure that the username is an origional
    $username_qry = "SELECT id FROM registration WHERE
         username='$username'";

    $results = mysqli_query($db, $username_qry);

    if (mysqli_num_rows($results) > 0) {
        $row = mysqli_fetch_assoc($results);

        if ($user_id != $row['id']) {
            array_push($errors, 
                "someone else has that username
                please try another one");
        }
    }

    //makes sure that their are no errors befor submiting
    if (count($errors) == 0) {  
          
        // Inserting data into table 
        $query = "UPDATE registration SET
            username = '$username', 
            first_name = '$first_name', 
            last_name = '$last_name', 
            region = '$region', 
            address = '$address', 
            email = '$email', 
            phone_number = '$phone_num' 
            WHERE id = '$user_id'"; 
        
        $update = mysqli_query($db, $query); 

        if ($update) {
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
        }
        else {
            echo mysqli_error($db);
        }          
    }   
} 

//delete users account
if (isset($_POST['delete_account_btn'])) {
    
    //variables
    $user_id = $_SESSION['user_id'];

    //delete query
    $delete_query = "DELETE FROM registration WHERE id='$user_id'";
    
    if (mysqli_query($db, $delete_query)) {
        header("location: index.php?logout='1'");
    }
    else {
        echo "Error deleting your account" . mysqli_error($db);
    }

}
?>