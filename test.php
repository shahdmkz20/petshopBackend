<?php
include 'connect.php';
include 'sendOTP.php';


try {
     

    getAllData('user',"1=0");
   

} catch (Exception $e) {
    
}

