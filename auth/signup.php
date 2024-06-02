<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include '../connect.php';
include '../sendOTP.php';

// Function to generate a random verification code

// Retrieve data from URL parameters (GET method)
$username = filterRequest("username") ?? '';
$password = sha1(filterRequest("password")) ?? ''; // Hash password
$email = filterRequest("email") ?? '';
$verificationCode = rand(10000 , 99999);

// Ensure $con is defined and not null
if ($con !== null) {
    try {
        $stmt = $con->prepare("SELECT * FROM user WHERE LOWER(user_email) = LOWER(?)");
        $stmt->execute(array($email));
        $count = $stmt->rowCount();

        if ($count > 0) {
            // Handle case when email already exists
            echo json_encode(array("status" => "failure", "message" => "Email already exists"));
        } else {
            $data = array(
                'user_name' => $username,
                'user_password' => $password,
                'user_email' => $email,
                'user_verifyCode' => $verificationCode
            );

            // Call insertData function to insert data into the 'user' table
            insertData("user", $data , $json = true);
      
                sendOTP($email , $verificationCode);
            
        }
    } catch (PDOException $e) {
        // Handle database errors
        echo json_encode(array("status" => "error", "message" => $e->getMessage()));
    }
} else {
    // Handle case when database connection is not established
    echo json_encode(array("status" => "error", "message" => "Database connection error"));
}
?>
