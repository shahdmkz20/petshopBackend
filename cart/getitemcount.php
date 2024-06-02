<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include '../connect.php';
$userEmail = filterRequest('userEmail');
$itemId = filterRequest('itemId');


$stmt = $con->prepare("SELECT COUNT(cart.cart_id) FROM cart WHERE cart_userEmail = ? AND cart_itemId = ? AND cart_orderd =0");
$stmt->execute(array($userEmail , $itemId));

$count = $stmt->rowCount();
$data = $stmt->fetchColumn();


if($count >0){
    echo json_encode(array("status" => "success" , "data" => $data));
}else{
    echo json_encode(array("status" => "success" , "data" => "0"));
}