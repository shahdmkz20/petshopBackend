<?php 

include "connect.php"; 

$allData = array(   );
$allData["status"] = "success";

//get categories
$categories = getAllData("categories" ,null ,null , false);
$allData['categories'] = $categories; 


//get items
$items = getAllData("itemView" ,null ,null , false);
$allData['items'] = $items; 


echo json_encode($allData);
