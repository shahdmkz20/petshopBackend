<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include '../connect.php';
include '../sendOTP.php';



// Retrieve data from URL parameters (POST method)
$email = filterRequest("email") ?? '';
$verifyCode = rand(10000 , 99999);


$stmt = $con->prepare("SELECT * FROM user WHERE LOWER(user_email) = LOWER(?) ");
$stmt->execute(array($email));
$count = $stmt->rowCount();
result($count);

if($count > 0 ){
    $data = array( "user_verifyCode" => $verifyCode);
    updateData("user" , $data , "user_email = '$email'" , false);
    sendOTP($email, $verifyCode);
}

