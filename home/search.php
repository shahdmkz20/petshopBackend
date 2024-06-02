<?php 

include '../connect.php';
$search = filterRequest('search');
getAllData("itemView" ,"item_name_eng LIKE '%$search%' OR item_name_ar LIKE '%$search%'");