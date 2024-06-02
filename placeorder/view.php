<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include '../connect.php';



$email = filterRequest("email") ?? '';


getAllData('orders' , "orders_userEmail = '$email'");
 
