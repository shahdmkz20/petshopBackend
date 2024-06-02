<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include '../connect.php';
include '../sendOTP.php';


$email = filterRequest('email');
$verificationCode = rand(10000 , 99999);

$data = array('user_verifyCode' => $verificationCode) ; 
updateData('user' , $data , "user_email = '$email'");
sendOTP($email, $verificationCode);