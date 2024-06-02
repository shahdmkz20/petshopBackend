<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include '../connect.php';
$userEmail = filterRequest('userEmail');

$data = getAllData("cartview" , 'cart_userEmail =? ' , array($userEmail), false);

$stmt = $con->prepare("SELECT SUM(itemsprice) as totalPrice, SUM(itemCount) as totalCount FROM `cartview` 
WHERE cart_userEmail = ? AND cart_orderd = 0");

$stmt->execute(array($userEmail)); 
$dataCountPrice = $stmt->fetch(PDO::FETCH_ASSOC);

echo json_encode(array(
    "status" => "success",
    "data" => $data,
    "countprice" => $dataCountPrice,
));


/**<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include '../connect.php';
$userEmail = filterRequest('userEmail');

$data = getAllData("cartview" , 'cart_userEmail = ? ' , array($userEmail), false);

$stmt = $con->prepare("CREATE OR REPLACE VIEW cartview AS
SELECT SUM(items.item_price) as itemprice , COUNT(cart.cart_id) as itemCount , cart.* , items.* FROM cart 
INNER JOIN items ON items.item_id = cart.cart_itemId 
WHERE cart.cart_orderd = 0 
GROUP BY cart.cart_itemId , cart.cart_userEmail ");

$stmt->execute(); 

$dataCountPrice = $stmt->fetch(PDO::FETCH_ASSOC);

echo json_encode(array(
    "status" => "success",
    "data" => $data,
    "countprice" => $dataCountPrice,
));

 */