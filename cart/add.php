<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include '../connect.php';
$userEmail = filterRequest('userEmail');
$itemId = filterRequest('itemId');

// Retrieve data from the "carst" table
getData("cart", " LOWER(cart_userEmail) = LOWER(?) AND cart_itemId = ? AND cart_orderd =0 ", array($userEmail, $itemId), false);

    $data = array(
        "cart_userEmail" => $userEmail,
        "cart_itemId" => $itemId,
    );
    $insertCount = insertData("cart", $data, false);

