<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include '../connect.php';



$userEmail = filterRequest('userEmail');
$itemId = filterRequest('itemId');
deleteData("cart"," cart_id = (SELECT cart_id FROM cart WHERE LOWER(cart_userEmail) = LOWER(?) AND cart_orderd =0  AND cart_itemId = ? LIMIT 1) " , array($userEmail ,$itemId));