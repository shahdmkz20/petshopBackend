<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include '../connect.php';
include '../sendOTP.php';



// Retrieve data from URL parameters (POST method)
$email = filterRequest("email") ?? '';
$password = filterRequest(("password"))?? '';
$password = sha1($password); // Hash password


getData('user' ,"LOWER(user_email) = LOWER(?) AND user_password=  ?" , array($email  , $password) , true);
