<?php 

include "../connect.php";


$categoryId = filterRequest('id');
$items = getAllData("itemView" ,"category_id = $categoryId");