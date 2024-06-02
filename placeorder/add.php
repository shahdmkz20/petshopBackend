<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include '../connect.php';



$email = filterRequest("email") ?? '';
$address = filterRequest(("address"))?? '';
$price = filterRequest("price") ?? '';

$data = array(
    "orders_userEmail" => $email ,
    "orders_address" => $address ,
    "orders_price" => $price ,   
);

$count = insertData("orders" , $data , false);

if($count > 0 ){
    $stmt = $con->prepare("SELECT MAX(orders_id) from orders ");
    $stmt->execute();
    $maxID = $stmt->fetchColumn();
    $stmt = $con->prepare("UPDATE `cart` SET `cart_orderd`= ?  WHERE cart_userEmail = ? AND cart_orderd = 0") ;
    $stmt->execute(array($maxID , $email));
    
}

 
